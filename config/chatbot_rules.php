<?php

return [
    'intents' => [
        'nasabah_hari_ini' => [
            'keywords' => ['siapa & transaksi & hari', 'nasabah & transaksi & hari'],
            'handler'  => 'handleNasabahHariIni',
        ],
        'transaksi_hari_ini' => [
            'keywords' => ['transaksi & hari', 'setoran & hari'],
            'handler'  => 'handleTransaksiHariIni',
        ],
        'transaksi_minggu_ini' => [
            'keywords' => ['transaksi & minggu', 'setoran & minggu'],
            'handler'  => 'handleTransaksiMingguIni',
        ],
        'transaksi_bulan_ini' => [
            'keywords' => ['transaksi & bulan', 'setoran & bulan'],
            'handler'  => 'handleTransaksiBulanIni',
        ],
        'volume_hari_ini' => [
            'keywords' => ['volume & hari', 'kg & hari', 'berat & hari'],
            'handler'  => 'handleVolumeHariIni',
        ],
        'volume_minggu_ini' => [
            'keywords' => ['volume & minggu', 'kg & minggu', 'berat & minggu'],
            'handler'  => 'handleVolumeMingguIni',
        ],
        'volume_bulan_ini' => [
            'keywords' => ['volume & bulan', 'kg & bulan', 'berat & bulan'],
            'handler'  => 'handleVolumeBulanIni',
        ],
        'nilai_minggu_ini' => [
            'keywords' => ['pendapatan & minggu', 'nilai & minggu', 'saldo & minggu'],
            'handler'  => 'handleNilaiMingguIni',
        ],
        'nilai_bulan_ini' => [
            'keywords' => ['pendapatan & bulan', 'nilai & bulan', 'saldo & bulan'],
            'handler'  => 'handleNilaiBulanIni',
        ],
        'komposisi_sampah' => [
            'keywords' => ['komposisi & terbanyak', 'jenis & terbanyak', 'sampah & terbanyak', 'komposisi & apa'],
            'handler'  => 'handleKomposisiSampah',
        ],
        'nasabah_terbaik' => [
            'keywords' => ['nasabah & paling banyak', 'nasabah & aktif', 'nasabah & terbaik', 'sering & transaksi', 'transaksi & terbanyak'],
            'handler'  => 'handleNasabahTerbaik',
        ],
        'transaksi_terbesar' => [
            'keywords' => ['transaksi & tinggi', 'transaksi & terbesar', 'nilai & tertinggi', 'transaksi & paling besar'],
            'handler'  => 'handleTransaksiTerbesar',
        ],
        'daftar_jenis_sampah' => [
            'keywords' => ['apa saja & jenis', 'daftar & jenis', 'nama & jenis', 'jenis sampahnya', 'jenis sampah nya'],
            'handler'  => 'handleDaftarJenisSampah',
        ],
        'total_jenis_sampah' => [
            'keywords' => ['berapa & jenis', 'jumlah & jenis', 'total & jenis'],
            'handler'  => 'handleTotalJenisSampah',
        ],
        'total_volume_keseluruhan' => [
            'keywords' => ['volume & saat ini', 'total volume', 'volume semua'],
            'handler'  => 'handleTotalVolumeKeseluruhan',
        ],
        'total_saldo_keseluruhan' => [
            'keywords' => ['total saldo', 'saldo semua', 'saldo keseluruhan'],
            'handler'  => 'handleTotalSaldoKeseluruhan',
        ],
        'cek_pending' => [
            'keywords' => ['pending', 'belum divalidasi', 'antrean'],
            'handler'  => 'handleCekPending',
        ],
        'daftar_nasabah' => [
            'keywords' => ['nama namanya', 'daftar nasabah', 'siapa saja nasabah', 'nama nama', 'siapa saja nama'],
            'handler'  => 'handleDaftarNasabah',
        ],
        'total_nasabah' => [
            'keywords' => ['berapa nasabah', 'jumlah nasabah', 'total nasabah', 'ada berapa nasabah'],
            'handler'  => 'handleTotalNasabah',
        ],
        'total_semua_transaksi' => [
            'keywords' => ['berapa & transaksi', 'jumlah & transaksi', 'total & transaksi'],
            'handler'  => 'handleTotalSemuaTransaksi',
        ],
        'cek_saldo' => [
            'keywords' => ['saldo '],
            'handler'  => 'handleCekSaldo',
        ],
        'riwayat_transaksi' => [
            'keywords' => ['riwayat ', 'setoran '], 
            'handler'  => 'handleRiwayatTransaksi',
        ],
        'harga_sampah' => [
            'keywords' => ['harga '], 
            'handler'  => 'handleHargaSampah',
        ],
        'nasabah_kecamatan' => [
            'keywords' => ['nasabah di ', 'warga di '],
            'handler'  => 'handleNasabahKecamatan',
        ],
        'bantuan' => [
            'keywords' => ['bantuan', 'help', 'panduan', 'cara pakai', 'apa saja'],
            'handler'  => 'handleBantuan',
        ],
        'sapaan' => [
            'keywords' => ['halo', 'hai', 'hello', 'selamat pagi', 'selamat siang', 'selamat malam', 'bot'], 
            'handler'  => 'handleSapaan',
        ],
    ]
];