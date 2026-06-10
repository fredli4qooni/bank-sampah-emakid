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
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'index'])->name('home');

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

    Route::resource('units', UnitController::class);

    Route::resource('jenis-sampah', JenisSampahController::class);

    Route::post('validasi/bulk', [App\Http\Controllers\ValidasiController::class, 'bulkProcess'])->name('validasi.bulk');
    Route::post('/validasi/{id}/process', [ValidasiController::class, 'process'])->name('validasi.process');
    Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
    Route::get('/validasi/{id}', [ValidasiController::class, 'show'])->name('validasi.show');

    Route::post('/chatbot/query', [ChatbotController::class, 'query'])
         ->middleware('throttle:60,1')
         ->name('chatbot.query');

    Route::get('/backup', [App\Http\Controllers\BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup/process', [App\Http\Controllers\BackupController::class, 'process'])->name('backup.process');

    Route::resource('faq', FaqController::class);
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
    Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
    Route::get('/validasi/{id}', [ValidasiController::class, 'show'])->name('validasi.show');
});

require __DIR__.'/auth.php';