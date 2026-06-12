<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Tabungan - {{ $nasabah->nama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h1, h2, h3, p { margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2e7d32; padding-bottom: 10px; }
        .header h1 { color: #2e7d32; font-size: 24px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px; }
        .mutasi-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .mutasi-table th, .mutasi-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .mutasi-table th { background-color: #e8f5e9; color: #2e7d32; font-weight: bold; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .text-red { color: #d32f2f; }
        .text-green { color: #2e7d32; }
    </style>
</head>
<body>

    <div class="header">
        <h1>BANK SAMPAH EMAK.ID</h1>
        <p>Buku Rekapitulasi Tabungan Nasabah</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="150"><strong>No. Rekening</strong></td>
            <td>: {{ $nasabah->no_rekening }}</td>
            <td width="150"><strong>Total Saldo Saat Ini</strong></td>
            <td>: <strong>Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td><strong>Nama Nasabah</strong></td>
            <td>: {{ $nasabah->nama }}</td>
            <td><strong>Dicetak Pada</strong></td>
            <td>: {{ date('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Kecamatan / Unit</strong></td>
            <td colspan="3">: {{ $nasabah->kecamatan }} / {{ $nasabah->unit ? $nasabah->unit->nama_unit : '-' }}</td>
        </tr>
    </table>

    <table class="mutasi-table">
        <thead>
            <tr>
                <th width="30" class="text-center">No</th>
                <th width="120">Tanggal</th>
                <th>Keterangan</th>
                <th width="100" class="text-right">Debit (Keluar)</th>
                <th width="100" class="text-right">Kredit (Masuk)</th>
                <th width="100" class="text-right">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($mutasiWithSaldo as $m)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ \Carbon\Carbon::parse($m['tanggal'])->format('d/m/Y H:i') }}</td>
                <td>{{ $m['keterangan'] }}</td>
                <td class="text-right text-red">{{ $m['debit'] > 0 ? number_format($m['debit'], 0, ',', '.') : '-' }}</td>
                <td class="text-right text-green">{{ $m['kredit'] > 0 ? number_format($m['kredit'], 0, ',', '.') : '-' }}</td>
                <td class="text-right font-bold">{{ number_format($m['saldo'], 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada riwayat transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
