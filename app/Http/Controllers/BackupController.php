<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BackupLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use ZipArchive;

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

            $date = now()->format('Y-m-d_HHmmss');
            $sqlFileName = "backup_{$dbName}_{$date}.sql";
            $zipFileName = "backup_emakid_{$date}.zip";

            $tempDir = storage_path('app/temp');
            if (!File::exists($tempDir)) {
                File::makeDirectory($tempDir, 0755, true);
            }

            $sqlPath = $tempDir . '/' . $sqlFileName;
            $zipPath = $tempDir . '/' . $zipFileName;

            $passwordParam = $dbPass ? "-p\"{$dbPass}\"" : "";
            $dumpPath = env('MYSQLDUMP_PATH', 'mysqldump'); 
            $command = "\"{$dumpPath}\" -h {$dbHost} -u {$dbUser} {$passwordParam} {$dbName} > \"{$sqlPath}\"";

            $output = [];
            $returnVar = 0;
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception("Gagal eksekusi mysqldump. Pastikan mysqldump tersedia di Environment Variables Windows/Server Anda.");
            }

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($sqlPath, $sqlFileName);
                $zip->close();
            } else {
                throw new \Exception("Gagal membuat file ZIP kompresi.");
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
                'keterangan' => 'Proses backup dan kompresi selesai dengan aman.'
            ]);

            File::delete($sqlPath);

            return response()->download($zipPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            BackupLog::create([
                'admin_id' => Auth::id(),
                'file_size' => null,
                'status' => 'Gagal',
                'keterangan' => substr($e->getMessage(), 0, 255)
            ]);

            return back()->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }
}