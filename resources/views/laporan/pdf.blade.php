<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Bank Sampah</title>
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

        .badge {
            display: inline-block;
            background: #e5e7eb;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            margin-top: 3px;
        }

        .catatan-merah {
            color: #dc2626;
            font-size: 8px;
            font-style: italic;
        }

        .catatan-abu {
            color: #6b7280;
            font-size: 8px;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>BANK SAMPAH EMAK.ID</h1>
        <p>Laporan Operasional Transaksi Nasabah</p>
        <p>
            Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong><br>
            Filter Unit: <strong>{{ $namaUnitFilter }}</strong>
        </p>
    </div>

    <table>
        <thead>
                <th width="5%" class="text-center">No</th>
                <th width="12%">Waktu & TRX</th>
                <th width="27%">Nama Nasabah & Rekening</th>
                <th width="23%">Unit / Kelompok</th>
                <th width="15%">Petugas</th>
                <th width="8%" class="text-center">Status</th>
                <th width="10%" class="text-right">Nilai Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            $grandTotal = 0;
            @endphp
            @forelse($transaksi as $trx)
            @php $grandTotal += $trx->total_nilai; @endphp
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>
                    {{ $trx->created_at->format('d/m/Y H:i') }}<br>
                    <span class="catatan-abu">#{{ $trx->id_transaksi }}</span>
                </td>
                <td>
                    <strong>{{ $trx->nasabah->nama }}</strong><br>
                    <span class="badge">{{ $trx->nasabah->no_rekening }}</span>
                </td>
                <td>{{ $trx->nasabah->unit->nama_unit ?? '-' }}</td>
                <td>{{ $trx->penimbang->name }}</td>
                <td class="text-center">
                    <strong>{{ strtoupper($trx->status_validasi) }}</strong>
                </td>
                <td class="text-right">
                    Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}<br>
                    <span class="catatan-abu">Berat: {{ $trx->detail->sum('berat') }} kg</span>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada transaksi pada kriteria ini.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="5" class="text-right">TOTAL KESELURUHAN:</td>
                    <td class="text-right total-amount">{{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
    </table>

    <div style="margin-top: 30px; text-align: right; font-size: 11px;">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p>Oleh: {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</p>
    </div>

</body>

</html>