<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PersetujuanController;
use App\Http\Controllers\SuperAdmin\RuanganManagementController;
use App\Http\Controllers\SuperAdmin\UserManagementController;
use App\Http\Controllers\SuperAdmin\LaporanController;
use App\Http\Controllers\SuperAdmin\KampusManagementController;
use App\Http\Controllers\SuperAdmin\CabangManagementController;
use App\Http\Controllers\SuperAdmin\FakultasManagementController;
use App\Http\Controllers\SuperAdmin\GedungManagementController;



Route::get('/', function () {
    $ruangan = \App\Models\Ruangan::with(['gedung.fakultas', 'gedung.cabang'])
        ->orderBy('id_ruangan')
        ->limit(12)
        ->get();

    return view('welcome', compact('ruangan'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('/approval', [PersetujuanController::class, 'index'])->name('approval.index');
    Route::post('/approval/{id}', [PersetujuanController::class, 'approve'])->name('approval.approve');
    Route::post('/approval/{id_peminjaman}/{id_ruangan}', [PersetujuanController::class, 'approvePerRuangan'])->name('approval.approve.ruangan');

    Route::prefix('super-admin')->name('super-admin.')->group(function () {
        Route::resource('users', UserManagementController::class)->except(['show']);
        Route::resource('ruangan', RuanganManagementController::class)->except(['show']);
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::resource('kampus', KampusManagementController::class)->except(['show']);
        Route::resource('cabang', CabangManagementController::class)->except(['show']);
        Route::resource('fakultas', FakultasManagementController::class)->except(['show']);
        Route::resource('gedung', GedungManagementController::class)->except(['show']);
    });
});

use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/create-super-admin', function () {
    // Cek apakah super admin sudah ada (berdasarkan email)
    $exists = User::where('email', 'admin@example.com')->exists();

    if ($exists) {
        return 'Super admin sudah ada!';
    }

    User::create([
        'name'       => 'Super Admin',
        'email'      => 'admin@admin.telkomuniversity.ac.id',
        'password'   => Hash::make('password123'), // ganti dengan password kuat
        'role'       => 'super_admin',
        'nim_nip'    => '9999999999', // isi sesuai kebutuhan
        'id_cabang'  => null,       // atau isi jika foreign key wajib
        'id_fakultas'=> null,
    ]);
    return 'Super admin pertama baru aja gw buat';
});


require __DIR__.'/auth.php';
