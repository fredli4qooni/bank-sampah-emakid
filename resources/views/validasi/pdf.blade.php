<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Validasi Setoran</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #059669;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #059669;
            font-size: 22px;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #555;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            margin-top: 15px;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0fdf4;
            color: #065f46;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background-color: #f9fafb;
        }

        .total-amount {
            color: #059669;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>BANK SAMPAH EMAK.ID</h1>
        <p>Laporan Validasi & Koreksi Setoran (Grup Harian)</p>
        <p>
            Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong><br>
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Nama Penimbang</th>
                <th width="15%">Tanggal Validasi</th>
                <th width="12%" class="text-center">Total Lapangan</th>
                <th width="12%" class="text-center">Total Gudang</th>
                <th width="12%" class="text-center">Selisih</th>
                <th width="10%" class="text-center">Status</th>
                <th width="19%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            $totalLapanganAll = 0;
            $totalGudangAll = 0;
            @endphp
            @forelse($riwayatValidasi as $row)
            @php 
                $totalLapanganAll += $row['total_berat_lapangan'];
                $totalGudangAll += $row['total_berat_gudang'];
            @endphp
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td><strong>{{ $row['nama_penimbang'] }}</strong></td>
                <td>{{ $row['tanggal'] }}</td>
                <td class="text-center">{{ number_format($row['total_berat_lapangan'], 2, ',', '.') }} kg</td>
                <td class="text-center">{{ number_format($row['total_berat_gudang'], 2, ',', '.') }} kg</td>
                <td class="text-center">
                    {{ number_format($row['selisih'], 2, ',', '.') }} kg
                </td>
                <td class="text-center">
                    <strong>{{ strtoupper($row['status']) }}</strong>
                </td>
                <td>{{ $row['keterangan'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada riwayat validasi grup pada kriteria ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-center total-amount">{{ number_format($totalLapanganAll, 2, ',', '.') }} kg</td>
                <td class="text-center total-amount">{{ number_format($totalGudangAll, 2, ',', '.') }} kg</td>
                <td class="text-center total-amount">{{ number_format(abs($totalLapanganAll - $totalGudangAll), 2, ',', '.') }} kg</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
