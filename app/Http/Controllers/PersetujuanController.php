<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Persetujuan;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;

class PersetujuanController extends Controller
{
    /**
     * LIST DATA YANG PERLU DI-APPROVE
     * Filtered berdasarkan hierarki admin
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403);
        }

        $query = Peminjaman::with(['user', 'ruangan.gedung.fakultas', 'persetujuan'])
            ->where('status', 'pending');

        // Filter berdasarkan hierarki admin
        if ($user->isAdminGedung() && $user->id_gedung) {
            // Admin gedung: hanya peminjaman yang punya ruangan di gedung dia
            $query->whereHas('ruangan', function ($q) use ($user) {
                $q->where('ruangan.id_gedung', $user->id_gedung);
            });
        } elseif ($user->isAdminFakultas() && $user->id_fakultas) {
            // Admin fakultas: hanya peminjaman yang punya ruangan di gedung fakultasnya
            $query->whereHas('ruangan', function ($q) use ($user) {
                $q->whereHas('gedung', function ($g) use ($user) {
                    $g->where('id_fakultas', $user->id_fakultas);
                });
            });
        }
        // Super admin: lihat semua (no filter)

        $data = $query->latest('waktu_pengajuan')->get();

        return view('approval.index', compact('data'));
    }

    /**
     * APPROVE / REJECT PER RUANGAN
     */
    public function approvePerRuangan(Request $request, $id_peminjaman, $id_ruangan)
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $peminjaman = Peminjaman::findOrFail($id_peminjaman);
        $ruangan = Ruangan::with('gedung')->findOrFail($id_ruangan);

        // Cek wewenang admin atas ruangan ini
        if (!$user->canApproveRuangan($ruangan)) {
            abort(403, 'Anda tidak memiliki wewenang atas ruangan ini.');
        }

        // Cek apakah sudah pernah di-approve untuk ruangan ini
        $existing = Persetujuan::where('id_peminjaman', $id_peminjaman)
            ->where('id_ruangan', $id_ruangan)
            ->first();

        if ($existing) {
            // Update yang sudah ada
            $existing->update([
                'id_admin' => $user->id,
                'level_admin' => $user->getAdminLevelLabel(),
                'status' => $request->status,
                'waktu_persetujuan' => now(),
                'komentar' => $request->komentar ?? null
            ]);
        } else {
            // Buat baru
            Persetujuan::create([
                'id_peminjaman' => $id_peminjaman,
                'id_ruangan' => $id_ruangan,
                'id_admin' => $user->id,
                'level_admin' => $user->getAdminLevelLabel(),
                'status' => $request->status,
                'waktu_persetujuan' => now(),
                'komentar' => $request->komentar ?? null
            ]);
        }

        // Auto-update status peminjaman berdasarkan seluruh persetujuan ruangan
        $this->updatePeminjamanStatus($peminjaman);

        return redirect()->route('approval.index')
            ->with('success', "Ruangan {$ruangan->nama_ruangan} berhasil di-" . ($request->status === 'approved' ? 'setujui' : 'tolak') . "!");
    }

    /**
     * APPROVE / REJECT SEMUA RUANGAN SEKALIGUS (backward compatible)
     */
    public function approve(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $peminjaman = Peminjaman::with('ruangan.gedung')->findOrFail($id);

        foreach ($peminjaman->ruangan as $r) {
            // Cek wewenang per-ruangan
            if (!$user->canApproveRuangan($r)) {
                continue; // skip ruangan yang bukan wewenangnya
            }

            $existing = Persetujuan::where('id_peminjaman', $peminjaman->id_peminjaman)
                ->where('id_ruangan', $r->id_ruangan)
                ->first();

            if ($existing) {
                $existing->update([
                    'id_admin' => $user->id,
                    'level_admin' => $user->getAdminLevelLabel(),
                    'status' => $request->status,
                    'waktu_persetujuan' => now(),
                    'komentar' => $request->komentar ?? null
                ]);
            } else {
                Persetujuan::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_ruangan' => $r->id_ruangan,
                    'id_admin' => $user->id,
                    'level_admin' => $user->getAdminLevelLabel(),
                    'status' => $request->status,
                    'waktu_persetujuan' => now(),
                    'komentar' => $request->komentar ?? null
                ]);
            }
        }

        // Auto-update status peminjaman
        $this->updatePeminjamanStatus($peminjaman);

        return redirect()->route('approval.index')
            ->with('success', 'Status berhasil diperbarui!');
    }

    /**
     * Auto-update status peminjaman berdasarkan persetujuan per-ruangan:
     * - Jika SEMUA ruangan approved → peminjaman approved
     * - Jika ADA ruangan rejected → peminjaman rejected
     * - Lainnya → tetap pending
     */
    private function updatePeminjamanStatus(Peminjaman $peminjaman)
    {
        $peminjaman->load('ruangan', 'persetujuan');

        $totalRuangan = $peminjaman->ruangan->count();
        $persetujuanList = $peminjaman->persetujuan;

        if ($persetujuanList->isEmpty()) {
            return; // belum ada persetujuan sama sekali
        }

        // Business rule: status "approved" harus didukung persetujuan oleh admin (gedung/fakultas),
        // super admin tidak menjadi prasyarat (opsional).
        $approvedCount = $persetujuanList
            ->where('status', 'approved')
            ->where('level_admin', '!=', 'super')
            ->count();
        $rejectedCount = $persetujuanList
            ->where('status', 'rejected')
            ->where('level_admin', '!=', 'super')
            ->count();

        if ($rejectedCount > 0) {
            $peminjaman->update(['status' => 'rejected']);
        } elseif ($approvedCount >= $totalRuangan) {
            $peminjaman->update(['status' => 'approved']);
        }
        // else: tetap pending (belum semua ruangan di-review)
    }
}