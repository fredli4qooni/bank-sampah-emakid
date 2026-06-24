<?php

namespace App\Imports;

use App\Models\Nasabah;
use App\Models\Unit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class NasabahImport implements ToCollection, WithStartRow
{
    public $importedCount = 0;
    public $skippedCount = 0;

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        $lastNasabah = Nasabah::orderBy('id_nasabah', 'desc')->first();
        $nextId = $lastNasabah ? $lastNasabah->id_nasabah + 1 : 1;
        $datePrefix = date('ym');

        foreach ($rows as $row) {
            // Jika kolom NAMA NASABAH kosong, abaikan
            if (!isset($row[0]) || trim($row[0]) === '') {
                continue;
            }

            $nama = trim($row[0]);
            $kelompok = trim($row[1] ?? '');
            $kelurahan = trim($row[2] ?? '');
            $kecamatan = trim($row[3] ?? '');
            $noHp = trim($row[4] ?? '');

            $idUnit = null;

            if ($kelompok !== '') {
                $unit = Unit::firstOrCreate(
                    ['nama_unit' => $kelompok],
                    [
                        'kecamatan' => $kecamatan !== '' ? $kecamatan : '-',
                        'tanggal_daftar' => now()->format('Y-m-d'),
                        'status' => 'aktif',
                        'nama_ketua' => '-',
                        'no_hp_ketua' => '-',
                    ]
                );
                $idUnit = $unit->id_unit;
            }

            $nasabah = Nasabah::where('nama', $nama)->first();

            if ($nasabah) {
                // Duplikat terdeteksi (nama sudah ada), lewati
                $this->skippedCount++;
                continue;
            }

            $noRekening = 'EMK-' . $datePrefix . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            Nasabah::create([
                'no_rekening' => $noRekening,
                'nama' => ucwords(strtolower($nama)),
                'alamat' => $kelurahan, // Kelurahan masuk ke alamat
                'kecamatan' => ucwords(strtolower($kecamatan)),
                'no_hp' => $noHp !== '' ? $noHp : null, // Sesuai dengan Excel kolom E
                'saldo' => 0.00,
                'id_unit' => $idUnit,
            ]);

            $this->importedCount++;
            $nextId++;
        }
    }
}
