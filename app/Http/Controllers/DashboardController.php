<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Build query berdasarkan hierarki admin
            $pendingQuery = Peminjaman::with(['user', 'ruangan.gedung'])
                ->where('status', 'pending');

            $allQuery = Peminjaman::query();

            // Filter berdasarkan hierarki
            if ($user->isAdminGedung() && $user->id_gedung) {
                $pendingQuery->whereHas('ruangan', function ($q) use ($user) {
                    $q->where('ruangan.id_gedung', $user->id_gedung);
                });
                $allQuery->whereHas('ruangan', function ($q) use ($user) {
                    $q->where('ruangan.id_gedung', $user->id_gedung);
                });
            } elseif ($user->isAdminFakultas() && $user->id_fakultas) {
                $pendingQuery->whereHas('ruangan', function ($q) use ($user) {
                    $q->whereHas('gedung', function ($g) use ($user) {
                        $g->where('id_fakultas', $user->id_fakultas);
                    });
                });
                $allQuery->whereHas('ruangan', function ($q) use ($user) {
                    $q->whereHas('gedung', function ($g) use ($user) {
                        $g->where('id_fakultas', $user->id_fakultas);
                    });
                });
            }

            $stats = [
                'total'    => (clone $allQuery)->count(),
                'pending'  => (clone $allQuery)->where('status', 'pending')->count(),
                'approved' => (clone $allQuery)->where('status', 'approved')->count(),
                'rejected' => (clone $allQuery)->where('status', 'rejected')->count(),
            ];

            $viewData = ['stats' => $stats];

            if ($user->role === 'admin') {
                $viewData['pending'] = $pendingQuery->latest('waktu_pengajuan')->get();
            }

            return view('dashboard', $viewData);
        }

        // User biasa: tampilkan peminjaman miliknya
        $myPeminjaman = Peminjaman::with(['ruangan'])
            ->where('id_user', $user->id)
            ->latest('waktu_pengajuan')
            ->get();

        $stats = [
            'total'    => $myPeminjaman->count(),
            'pending'  => $myPeminjaman->where('status', 'pending')->count(),
            'approved' => $myPeminjaman->where('status', 'approved')->count(),
            'rejected' => $myPeminjaman->where('status', 'rejected')->count(),
        ];

        return view('dashboard', compact('myPeminjaman', 'stats'));
    }
}
