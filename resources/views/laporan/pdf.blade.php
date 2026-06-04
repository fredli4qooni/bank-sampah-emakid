<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Bank Sampah</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
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
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }

        table { border-collapse: collapse; margin-top: 15px; width: 100%; }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f0fdf4;
            color: #065f46;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
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
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>BANK SAMPAH EMAK.ID</h1>
        <p>Laporan Operasional Transaksi Nasabah</p>
        <p>Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Waktu Transaksi</th>
                <th width="25%">Nama Nasabah</th>
                <th width="20%">Petugas Penimbang</th>
                <th width="15%" class="text-center">Status</th>
                <th width="20%" class="text-right">Total Nilai (Rp)</th>
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
                <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $trx->nasabah->nama }} <br><small>({{ $trx->nasabah->no_rekening }})</small></td>
                <td>{{ $trx->penimbang->name }}</td>
                <td class="text-center">{{ strtoupper($trx->status_validasi) }}</td>
                <td class="text-right">{{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse

            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL NILAI KESELURUHAN:</td>
                <td class="text-right total-amount">{{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right; font-size: 12px;">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        <p>Oleh: {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</p>
    </div>

</body>

</html>