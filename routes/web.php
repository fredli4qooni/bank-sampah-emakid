<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ValidasiController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $url = match (Auth::user()->role) {
        'admin' => '/admin/dashboard',
        'penimbang' => '/penimbang/dashboard',
        'pengelola' => '/pengelola/dashboard',
        default => '/',
    };
    return redirect($url);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:admin,penimbang'])->group(function () {
    Route::resource('nasabah', NasabahController::class);
    
    Route::get('/transaksi/input', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/input', [TransaksiController::class, 'store'])->name('transaksi.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    Route::resource('jenis-sampah', JenisSampahController::class);

    Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
    Route::get('/validasi/{id}', [ValidasiController::class, 'show'])->name('validasi.show');
    Route::post('/validasi/{id}/process', [ValidasiController::class, 'process'])->name('validasi.process');

    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'role:penimbang'])->group(function () {
    Route::get('/penimbang/dashboard', [DashboardController::class, 'penimbang'])->name('penimbang.dashboard');
});


Route::middleware(['auth', 'role:pengelola'])->group(function () {
    Route::get('/pengelola/dashboard', [DashboardController::class, 'pengelola'])->name('pengelola.dashboard');
});

Route::middleware(['auth', 'role:admin,pengelola'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
});

require __DIR__.'/auth.php';