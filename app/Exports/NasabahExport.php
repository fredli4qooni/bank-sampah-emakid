<?php

namespace App\Exports;

use App\Models\Nasabah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NasabahExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Nasabah::with('unit')->get();
    }

    public function headings(): array
    {
        return [
            'ID Nasabah', 'No Rekening', 'Nama Lengkap', 'No HP', 
            'Kecamatan', 'Unit / Kelompok', 'Total Saldo (Rp)', 'Tanggal Bergabung'
        ];
    }

    public function map($nasabah): array
    {
        return [
            $nasabah->id_nasabah,
            $nasabah->no_rekening,
            $nasabah->nama,
            $nasabah->no_hp,
            $nasabah->kecamatan,
            $nasabah->unit->nama_unit ?? '-',
            $nasabah->saldo,
            $nasabah->created_at->format('Y-m-d H:i:s'),
        ];
    }
}