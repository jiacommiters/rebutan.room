<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * LIST PEMINJAMAN
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Super admin bisa melihat seluruh peminjaman.
            if ($user->isSuperAdmin()) {
                $data = Peminjaman::with(['user', 'ruangan'])->latest()->get();
            } else {
                // Admin hanya melihat peminjaman yang punya minimal 1 ruangan dalam scope-nya.
                $data = Peminjaman::with(['user', 'ruangan', 'ruangan.gedung'])
                    ->whereHas('ruangan', function ($q) use ($user) {
                        if ($user->isAdminGedung() && $user->id_gedung) {
                            $q->where('ruangan.id_gedung', $user->id_gedung);
                        } elseif ($user->isAdminFakultas() && $user->id_fakultas) {
                            $q->whereHas('gedung', function ($g) use ($user) {
                                $g->where('gedung.id_fakultas', $user->id_fakultas);
                            });
                        }
                    })
                    ->latest()
                    ->get();

                // Selain membatasi akses, filter juga ruangan yang ditampilkan sesuai scope.
                $data->each(function ($item) use ($user) {
                    $item->setRelation(
                        'ruangan',
                        $item->ruangan->filter(fn (Ruangan $r) => $user->canApproveRuangan($r))->values()
                    );
                });
            }
        } else {
            $data = Peminjaman::with(['user', 'ruangan'])
                ->where('id_user', $user->id)
                ->latest()
                ->get();
        }

        return view('peminjaman.index', compact('data'));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        if (Auth::user()->isAdmin()) {
            abort(403, 'Admin tidak dapat membuat pengajuan peminjaman.');
        }

        $ruangan = Ruangan::with('gedung')->get();

        return view('peminjaman.create', compact('ruangan'));
    }

    /**
     * STORE DATA
     */
    public function store(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            abort(403, 'Admin tidak dapat membuat pengajuan peminjaman.');
        }

        $request->validate([
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'tujuan' => 'required',
            'ruangan' => 'required|array',
            'surat' => 'required|file|mimes:pdf,doc,docx|max:2048'
        ]);

        // 🔥 CEK BENTROK — exclude rejected & cancelled
        foreach ($request->ruangan as $r) {
            $bentrok = Peminjaman::whereHas('ruangan', function ($q) use ($r) {
                $q->where('ruangan.id_ruangan', $r);
            })
            ->where(function ($q) use ($request) {
                $q->where('waktu_mulai', '<', $request->waktu_selesai)
                  ->where('waktu_selesai', '>', $request->waktu_mulai);
            })
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->exists();

            if ($bentrok) {
                return back()->withInput()->with('error', 'Jadwal bentrok di salah satu ruangan!');
            }
        }

        // UPLOAD SURAT
        $suratPath = null;
        if ($request->hasFile('surat')) {
            $suratPath = $request->file('surat')->store('surat-peminjaman', 'public');
        }

        // SIMPAN PEMINJAMAN
        $peminjaman = Peminjaman::create([
            'id_user' => Auth::id(),
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'tujuan' => $request->tujuan,
            'surat' => $suratPath,
            'waktu_pengajuan' => now(),
            'status' => 'pending'
        ]);

        // SIMPAN DETAIL (many-to-many)
        $peminjaman->ruangan()->attach($request->ruangan);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibuat!');
    }

    /**
     * DETAIL
     */
    public function show($id)
    {
        $data = Peminjaman::with(['user', 'ruangan.gedung', 'persetujuan.admin'])->findOrFail($id);

        if ($data && Auth::user()->isAdmin() && !Auth::user()->isSuperAdmin()) {
            // Admin hanya boleh melihat peminjaman yang punya ruangan dalam scope-nya.
            $hasScope = $data->ruangan->contains(function (Ruangan $ruangan) {
                return Auth::user()->canApproveRuangan($ruangan);
            });

            abort_unless($hasScope, 403, 'Akses ditolak.');

            // Filter ruangan yang ditampilkan sesuai scope.
            $data->setRelation(
                'ruangan',
                $data->ruangan->filter(fn (Ruangan $r) => Auth::user()->canApproveRuangan($r))->values()
            );
        }

        return view('peminjaman.show', compact('data'));
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        $data = Peminjaman::findOrFail($id);

        if ($data->id_user !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        if (Auth::user()->isAdmin() && !Auth::user()->isSuperAdmin()) {
            $data->load('ruangan.gedung');
            $hasScope = $data->ruangan->contains(function (Ruangan $ruangan) {
                return Auth::user()->canApproveRuangan($ruangan);
            });
            abort_unless($hasScope, 403, 'Akses ditolak.');
        }

        // Hapus relasi detail_peminjaman untuk menghindari orphaned data
        $data->ruangan()->detach();
        $data->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data berhasil dihapus!');
    }
}