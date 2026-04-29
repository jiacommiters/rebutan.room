<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    private function authorizeSuperAdmin(): void
    {
        abort_unless(Auth::user()?->isSuperAdmin(), 403, 'Akses hanya untuk super admin.');
    }

    public function index(Request $request)
    {
        $this->authorizeSuperAdmin();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Default periode: bulan berjalan
        if (!$startDate || !$endDate) {
            $now = now();
            $startDate = $now->copy()->startOfMonth()->toDateString();
            $endDate = $now->copy()->endOfMonth()->toDateString();
        }

        // Rekap jumlah peminjaman (distinct peminjaman) per fakultas/unit pada periode
        $facultyStats = Peminjaman::query()
            ->select([
                'fakultas.id_fakultas',
                'fakultas.nama_fakultas',
                DB::raw('COUNT(DISTINCT peminjaman.id_peminjaman) as jumlah_peminjaman'),
            ])
            ->join('detail_peminjaman', 'peminjaman.id_peminjaman', '=', 'detail_peminjaman.id_peminjaman')
            ->join('ruangan', 'detail_peminjaman.id_ruangan', '=', 'ruangan.id_ruangan')
            ->join('gedung', 'ruangan.id_gedung', '=', 'gedung.id_gedung')
            ->leftJoin('fakultas', 'gedung.id_fakultas', '=', 'fakultas.id_fakultas')
            ->where('peminjaman.status', 'approved')
            ->whereBetween('peminjaman.waktu_mulai', [
                $startDate.' 00:00:00',
                $endDate.' 23:59:59',
            ])
            ->groupBy('fakultas.id_fakultas', 'fakultas.nama_fakultas')
            ->orderByDesc('jumlah_peminjaman')
            ->get();

        // Rekap penggunaan per tipe ruangan pada periode
        $roomTypeStats = Peminjaman::query()
            ->select([
                'ruangan.tipe_ruangan',
                DB::raw('COUNT(detail_peminjaman.id_ruangan) as jumlah_penggunaan_ruangan'),
            ])
            ->join('detail_peminjaman', 'peminjaman.id_peminjaman', '=', 'detail_peminjaman.id_peminjaman')
            ->join('ruangan', 'detail_peminjaman.id_ruangan', '=', 'ruangan.id_ruangan')
            ->where('peminjaman.status', 'approved')
            ->whereBetween('peminjaman.waktu_mulai', [
                $startDate.' 00:00:00',
                $endDate.' 23:59:59',
            ])
            ->groupBy('ruangan.tipe_ruangan')
            ->orderByDesc('jumlah_penggunaan_ruangan')
            ->get();

        // Riwayat peminjaman dalam periode (approved)
        $history = Peminjaman::with(['user', 'ruangan.gedung.fakultas'])
            ->where('status', 'approved')
            ->whereBetween('waktu_mulai', [
                $startDate.' 00:00:00',
                $endDate.' 23:59:59',
            ])
            ->orderByDesc('waktu_mulai')
            ->take(50)
            ->get();

        return view('super-admin.laporan.index', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'facultyStats' => $facultyStats,
            'roomTypeStats' => $roomTypeStats,
            'history' => $history,
        ]);
    }
}

