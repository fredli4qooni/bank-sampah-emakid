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
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\ChatbotSettingController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/tentang-kami', [PublicController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/program', [PublicController::class, 'program'])->name('program');

Route::get('/galeri', [PublicController::class, 'dokumentasi'])->name('dokumentasi.public');
Route::post('/pendaftaran-unit', [PublicController::class, 'storeCalonUnit'])->name('pendaftaran.unit');

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
    Route::post('/nasabah/import', [NasabahController::class, 'import'])->name('nasabah.import');
    Route::resource('nasabah', NasabahController::class);
    Route::get('/nasabah/{nasabah}/cetak', [NasabahController::class, 'cetakBuku'])->name('nasabah.cetak');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/input', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/input', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}/cetak', [TransaksiController::class, 'cetakStruk'])->name('transaksi.cetak');
    Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    Route::resource('units', UnitController::class);
    Route::get('/calon-unit', [\App\Http\Controllers\CalonUnitController::class, 'index'])->name('calon-unit.index');
    Route::put('/calon-unit/{id}/status', [\App\Http\Controllers\CalonUnitController::class, 'updateStatus'])->name('calon-unit.update-status');
    Route::delete('/calon-unit/{id}', [\App\Http\Controllers\CalonUnitController::class, 'destroy'])->name('calon-unit.destroy');

    Route::resource('jenis-sampah', JenisSampahController::class);
    Route::resource('dokumentasi', \App\Http\Controllers\DokumentasiController::class);

    Route::post('validasi/bulk', [App\Http\Controllers\ValidasiController::class, 'bulkProcess'])->name('validasi.bulk');
    Route::post('/validasi/{id}/process', [ValidasiController::class, 'process'])->name('validasi.process');
    Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
    Route::get('/validasi/{id}', [ValidasiController::class, 'show'])->name('validasi.show');
    Route::get('/validasi/{id}/koreksi', [\App\Http\Controllers\ValidasiController::class, 'koreksi'])->name('validasi.koreksi');
    Route::put('/validasi/{id}/koreksi', [\App\Http\Controllers\ValidasiController::class, 'updateKoreksi'])->name('validasi.update_koreksi');
    Route::delete('/validasi/{id}', [\App\Http\Controllers\ValidasiController::class, 'destroy'])->name('validasi.destroy');

    Route::post('/chatbot/query', [ChatbotController::class, 'query'])
        ->middleware('throttle:60,1')
        ->name('chatbot.query');

    Route::get('/pengaturan-chatbot', [ChatbotSettingController::class, 'index'])->name('chatbot.setting');
    Route::post('/pengaturan-chatbot', [ChatbotSettingController::class, 'update'])->name('chatbot.setting.update');
    Route::post('/pengaturan-chatbot/rule', [ChatbotSettingController::class, 'storeRule'])->name('chatbot.rule.store');
    Route::put('/pengaturan-chatbot/rule/{id}', [ChatbotSettingController::class, 'updateRule'])->name('chatbot.rule.update');
    Route::delete('/pengaturan-chatbot/rule/{id}', [ChatbotSettingController::class, 'destroyRule'])->name('chatbot.rule.destroy');

    Route::get('/backup', [App\Http\Controllers\BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup/process', [App\Http\Controllers\BackupController::class, 'process'])->name('backup.process');

    Route::get('/penarikan', [App\Http\Controllers\PenarikanController::class, 'index'])->name('penarikan.index');
    Route::get('/penarikan/create', [App\Http\Controllers\PenarikanController::class, 'create'])->name('penarikan.create');
    Route::post('/penarikan', [App\Http\Controllers\PenarikanController::class, 'store'])->name('penarikan.store');

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
    Route::get('/laporan-validasi', [\App\Http\Controllers\LaporanValidasiController::class, 'index'])->name('laporan.validasi');
    Route::get('/validasi', [ValidasiController::class, 'index'])->name('validasi.index');
    Route::get('/validasi/{id}', [ValidasiController::class, 'show'])->name('validasi.show');
});

require __DIR__ . '/auth.php';
