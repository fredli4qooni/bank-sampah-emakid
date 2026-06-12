<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Setoran Bank Sampah</title>
    <style>
        @page {
            margin: 5px;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 10px;
            margin: 0;
            padding: 0;
            text-align: left;
        }
        h2, h3, h4, p {
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h2 { font-size: 14px; margin-bottom: 2px; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .divider {
            border-bottom: 1px dashed #000;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            padding: 1px 0;
            vertical-align: top;
            word-wrap: break-word;
        }
        .footer {
            margin-top: 8px;
            font-size: 9px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>BANK SAMPAH EMAK.ID</h2>
    <p>Jl. Contoh Alamat No. 123</p>
    <div class="divider"></div>
    
    <table style="font-size: 10px;">
        <tr>
            <td class="text-left">No. Trx</td>
            <td class="text-right">#{{ $transaksi->id_transaksi }}</td>
        </tr>
        <tr>
            <td class="text-left">Tanggal</td>
            <td class="text-right">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="text-left">Nasabah</td>
            <td class="text-right">{{ $transaksi->nasabah->nama }}</td>
        </tr>
        <tr>
            <td class="text-left">Penimbang</td>
            <td class="text-right">{{ $transaksi->penimbang->name }}</td>
        </tr>
    </table>
    
    <div class="divider"></div>
    
    <table style="font-size: 11px;">
        @foreach($transaksi->detail as $item)
        <tr>
            <td colspan="3" class="text-left bold">{{ $item->jenisSampah->nama_sampah }}</td>
        </tr>
        <tr>
            <td class="text-left">{{ $item->berat }} kg x</td>
            <td class="text-center">{{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>
    
    <div class="divider"></div>
    
    <table style="font-size: 12px; font-weight: bold;">
        <tr>
            <td class="text-left">TOTAL</td>
            <td class="text-right">Rp {{ number_format($transaksi->total_nilai, 0, ',', '.') }}</td>
        </tr>
    </table>
    
    <div class="divider"></div>
    
    <div class="footer">
        <p>Status: {{ strtoupper($transaksi->status_validasi) }}</p>
        <p>Terima kasih telah menabung sampah!</p>
    </div>
</body>
</html>
