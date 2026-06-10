<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BackupLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NasabahExport;
use App\Exports\TransaksiExport;

class BackupController extends Controller
{
    public function index()
    {
        $logs = BackupLog::with('admin')->orderBy('created_at', 'desc')->take(20)->get();
        return view('backup.index', compact('logs'));
    }

    public function process()
    {
        set_time_limit(120);

        try {
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $dbName = env('DB_DATABASE');
            $dbHost = env('DB_HOST', '127.0.0.1');

            $date = now()->format('Y-m-d_His');
            $sqlFileName = "backup_{$dbName}_{$date}.sql";
            $nasabahExcelName = "rekap_nasabah_{$date}.xlsx";
            $transaksiExcelName = "rekap_transaksi_{$date}.xlsx";
            $zipFileName = "backup_emakid_full_{$date}.zip";

            if (!Storage::disk('local')->exists('temp')) {
                Storage::disk('local')->makeDirectory('temp');
            }

            $sqlPath = Storage::disk('local')->path('temp/' . $sqlFileName);
            $nasabahExcelPath = Storage::disk('local')->path('temp/' . $nasabahExcelName);
            $transaksiExcelPath = Storage::disk('local')->path('temp/' . $transaksiExcelName);
            $zipPath = Storage::disk('local')->path('temp/' . $zipFileName);

            $passwordParam = $dbPass ? "-p\"{$dbPass}\"" : "";
            $dumpPath = env('MYSQLDUMP_PATH', 'mysqldump'); 
            $command = "\"{$dumpPath}\" -h {$dbHost} -u {$dbUser} {$passwordParam} {$dbName} > \"{$sqlPath}\"";

            $output = [];
            $returnVar = 0;
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception("Gagal eksekusi mysqldump. Periksa kembali pengaturan path di file .env Anda.");
            }

            Excel::store(new NasabahExport, 'temp/' . $nasabahExcelName, 'local');
            Excel::store(new TransaksiExport, 'temp/' . $transaksiExcelName, 'local');

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                if (!file_exists($sqlPath) || !file_exists($nasabahExcelPath) || !file_exists($transaksiExcelPath)) {
                    throw new \Exception("Gagal mendeteksi file mentah (.sql / .xlsx) di folder lokal.");
                }

                $zip->addFile($sqlPath, $sqlFileName);
                $zip->addFile($nasabahExcelPath, $nasabahExcelName);
                $zip->addFile($transaksiExcelPath, $transaksiExcelName);
                $zip->close();
            } else {
                throw new \Exception("Sistem gagal membuat file kompresi ZIP.");
            }

            $bytes = filesize($zipPath);
            if ($bytes >= 1048576) {
                $fileSize = number_format($bytes / 1048576, 2) . ' MB';
            } elseif ($bytes >= 1024) {
                $fileSize = number_format($bytes / 1024, 2) . ' KB';
            } else {
                $fileSize = $bytes . ' B';
            }

            BackupLog::create([
                'admin_id' => Auth::id(),
                'file_size' => $fileSize,
                'status' => 'Berhasil',
                'keterangan' => 'Paket backup lengkap (.sql dan .xlsx) berhasil diunduh.'
            ]);

            Storage::disk('local')->delete('temp/' . $sqlFileName);
            Storage::disk('local')->delete('temp/' . $nasabahExcelName);
            Storage::disk('local')->delete('temp/' . $transaksiExcelName);

            return response()->download($zipPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            BackupLog::create([
                'admin_id' => Auth::id(),
                'file_size' => null,
                'status' => 'Gagal',
                'keterangan' => substr($e->getMessage(), 0, 255)
            ]);

            return back()->with('error', 'Gagal memproses pengamanan data: ' . $e->getMessage());
        }
    }
}