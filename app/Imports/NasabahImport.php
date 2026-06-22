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
        return 3;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!isset($row[0]) || trim($row[0]) === '') {
                continue;
            }

            $noRek = trim($row[0]);
            $nama = trim($row[1] ?? '');
            $kelompok = trim($row[2] ?? '');

            $idUnit = null;

            if ($kelompok !== '') {
                $unit = Unit::firstOrCreate(
                    ['nama_unit' => $kelompok],
                    [
                        'kecamatan' => '-',
                        'tanggal_daftar' => now()->format('Y-m-d'),
                        'status' => 'aktif',
                        'nama_ketua' => '-',
                        'no_hp_ketua' => '-',
                    ]
                );
                $idUnit = $unit->id_unit;
            }

            $nasabah = Nasabah::where('no_rekening', $noRek)
                ->orWhere('nama', $nama)
                ->first();

            if ($nasabah) {
                // Duplikat terdeteksi (nama atau no rek sudah ada), lewati
                $this->skippedCount++;
                continue;
            }

            Nasabah::create([
                'no_rekening' => $noRek,
                'nama' => $nama,
                'id_unit' => $idUnit,
                'saldo' => 0,
            ]);
            $this->importedCount++;
        }
    }
}
