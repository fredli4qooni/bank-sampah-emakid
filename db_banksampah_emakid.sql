-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2026 at 02:56 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_banksampah_emakid`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup_logs`
--

CREATE TABLE `backup_logs` (
  `id_log` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `file_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Berhasil','Gagal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `backup_logs`
--

INSERT INTO `backup_logs` (`id_log`, `admin_id`, `file_size`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(5, 1, '5.06 KB', 'Berhasil', 'Proses backup dan kompresi selesai dengan aman.', '2026-06-10 06:28:03', '2026-06-10 06:28:03'),
(6, 1, '16.50 KB', 'Berhasil', 'Paket backup lengkap (.sql dan .xlsx) berhasil diunduh.', '2026-06-10 20:00:45', '2026-06-10 20:00:45'),
(7, 1, '16.56 KB', 'Berhasil', 'Paket backup lengkap (.sql dan .xlsx) berhasil diunduh.', '2026-06-10 20:01:49', '2026-06-10 20:01:49'),
(8, 1, '17.09 KB', 'Berhasil', 'Paket backup lengkap (.sql dan .xlsx) berhasil diunduh.', '2026-06-10 22:56:11', '2026-06-10 22:56:11'),
(9, 1, '17.67 KB', 'Berhasil', 'Paket backup lengkap (.sql dan .xlsx) berhasil diunduh.', '2026-06-11 00:38:48', '2026-06-11 00:38:48'),
(10, 1, '18.79 KB', 'Berhasil', 'Paket backup lengkap (.sql dan .xlsx) berhasil diunduh.', '2026-06-19 04:19:31', '2026-06-19 04:19:31'),
(11, 1, '19.07 KB', 'Berhasil', 'Paket backup lengkap (.sql dan .xlsx) berhasil diunduh.', '2026-06-22 14:27:26', '2026-06-22 14:27:26'),
(12, 1, '25.99 KB', 'Berhasil', 'Paket backup lengkap (.sql dan .xlsx) berhasil diunduh.', '2026-06-26 16:19:59', '2026-06-26 16:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1782524195),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1782524195;', 1782524195),
('laravel-cache-admin1@emak.id|127.0.0.1', 'i:1;', 1781450919),
('laravel-cache-admin1@emak.id|127.0.0.1:timer', 'i:1781450919;', 1781450919),
('laravel-cache-sayalah@ya.id|127.0.0.1', 'i:1;', 1782524408),
('laravel-cache-sayalah@ya.id|127.0.0.1:timer', 'i:1782524408;', 1782524408);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calon_units`
--

CREATE TABLE `calon_units` (
  `id_calon` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_wa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jadwal_edukasi` date NOT NULL,
  `status` enum('pending','dihubungi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `calon_units`
--

INSERT INTO `calon_units` (`id_calon`, `nama_lengkap`, `no_wa`, `alamat_lengkap`, `jadwal_edukasi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test', '08123456789', 'jl. test', '2026-06-27', 'pending', '2026-06-26 04:24:24', '2026-06-26 04:24:24'),
(2, 'DINDA WULANDARI', '08123456789', 'sukarame', '2027-07-16', 'pending', '2026-06-26 16:07:47', '2026-06-26 16:07:47');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_rules`
--

CREATE TABLE `chatbot_rules` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_aturan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_aksi` enum('sistem','teks') COLLATE utf8mb4_unicode_ci NOT NULL,
  `handler_sistem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balasan_teks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot_rules`
--

INSERT INTO `chatbot_rules` (`id`, `nama_aturan`, `keywords`, `jenis_aksi`, `handler_sistem`, `balasan_teks`, `created_at`, `updated_at`) VALUES
(2, 'Bantuan', 'bantuan, help, perintah, apa saja, bisa apa, daftar perintah', 'teks', NULL, 'Saya bisa membantu Anda dengan: 1) Cek saldo nasabah (contoh: \"saldo Siti\") 2) Transaksi hari ini 3) Transaksi pending 4) Total nasabah 5) Volume hari ini/minggu ini 6) Harga sampah (contoh: \"harga plastik\") 7) Cek nasabah per kecamatan. Ketik perintah Anda!', '2026-06-27 01:33:28', '2026-06-27 01:33:28'),
(3, 'Sapaan', 'halo, hai, selamat pagi, selamat siang, selamat sore, selamat malam, hy, helo', 'teks', NULL, 'Halo, Admin! Ada yang bisa saya bantu hari ini? Silakan ketik perintah Anda atau ketik \"bantuan\" untuk melihat daftar perintah yang tersedia.', '2026-06-27 01:35:24', '2026-06-27 01:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_settings`
--

CREATE TABLE `chatbot_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `system_prompt` text COLLATE utf8mb4_unicode_ci,
  `welcome_message` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot_settings`
--

INSERT INTO `chatbot_settings` (`id`, `system_prompt`, `welcome_message`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '', 'Halo, Admin! Chatbot Assistant siap membantu.', 1, '2026-06-14 15:20:52', '2026-06-14 15:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` bigint UNSIGNED NOT NULL,
  `id_transaksi` bigint UNSIGNED NOT NULL,
  `id_jenis` bigint UNSIGNED NOT NULL,
  `berat` decimal(10,2) NOT NULL,
  `harga_saat_transaksi` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_jenis`, `berat`, `harga_saat_transaksi`, `subtotal`, `created_at`, `updated_at`) VALUES
(53, 29, 5, 9.20, 3000.00, 27600.00, '2026-06-25 03:58:12', '2026-06-25 03:58:12'),
(54, 29, 2, 4.00, 3000.00, 12000.00, '2026-06-25 03:58:12', '2026-06-25 03:58:12'),
(55, 29, 3, 2.00, 19000.00, 38000.00, '2026-06-25 03:58:12', '2026-06-25 03:58:12'),
(56, 30, 1, 16.00, 700.00, 11200.00, '2026-06-25 03:58:35', '2026-06-25 03:58:35'),
(57, 30, 5, 4.00, 3000.00, 12000.00, '2026-06-25 03:58:35', '2026-06-25 03:58:35'),
(58, 31, 2, 5.00, 3000.00, 15000.00, '2026-06-25 03:58:57', '2026-06-27 02:03:32'),
(59, 31, 3, 3.00, 19000.00, 57000.00, '2026-06-25 03:58:57', '2026-06-27 02:03:32'),
(60, 32, 3, 3.00, 19000.00, 57000.00, '2026-06-25 03:59:22', '2026-06-26 16:15:52'),
(61, 32, 2, 2.00, 3000.00, 6000.00, '2026-06-25 03:59:22', '2026-06-26 16:15:52'),
(62, 33, 2, 7.00, 3000.00, 21000.00, '2026-06-25 03:59:38', '2026-06-27 02:05:06'),
(63, 34, 1, 25.00, 700.00, 17500.00, '2026-06-25 03:59:52', '2026-06-26 04:58:15'),
(64, 35, 5, 10.00, 3000.00, 30000.00, '2026-06-25 04:35:10', '2026-06-27 02:17:45'),
(65, 36, 4, 17.00, 3750.00, 63750.00, '2026-06-27 01:37:47', '2026-06-27 01:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `dokumentasis`
--

CREATE TABLE `dokumentasis` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumentasis`
--

INSERT INTO `dokumentasis` (`id`, `judul`, `deskripsi`, `foto`, `created_at`, `updated_at`) VALUES
(2, 'Sosialisasi Pengelolaan Sampah Terpadu dengan Konsep Bank Sampah (induk & unit) di Kab. Tulang Bawang', 'Bank Sampah Emak.id - Pemerintah Kabupaten Tulang Bawang berkomitmen menciptakan lingkungan yang lebih bersih dan berkelanjutan. Hari ini, 22 Juni 2026, telah dilaksanakan kegiatan Sosialisasi Pengelolaan Sampah Terpadu dengan Konsep Bank Sampah (Induk & Unit).\r\nKegiatan ini bertujuan untuk memberikan pemahaman\r\nkepada masyarakat dan pengelola mengenai tata kelola sampah dari hulu ke hilir, serta optimalisasi peran Bank Sampah Induk sebagai pusat komando dan Bank Sampah Unit sebagai garda terdepan di tingkat warga.\r\nMari bersama kita ubah \"sampah\" menjadi \"berkah\" melalui sistem pengelolaan yang terintegrasi. Sampah selesai di sumber, ekonomi warga berputar!', 'dokumentasi/6a3f24ad6a27f-1782523053.webp', '2026-06-27 01:17:33', '2026-06-27 01:17:33'),
(3, 'Seminar Bank Sampah dalam Pertemuan Konsultasi IAD Wilayah Lampung', 'Bank Sampah Emak.id - Pemerintah Kabupaten Tulang Bawang berkomitmen menciptakan lingkungan yang lebih bersih dan berkelanjutan. Hari ini, 22 Juni 2026, telah dilaksanakan kegiatan Sosialisasi Pengelolaan Sampah Terpadu dengan Konsep Bank Sampah (Induk & Unit).\r\nKegiatan ini bertujuan untuk memberikan pemahaman\r\nkepada masyarakat dan pengelola mengenai tata kelola sampah dari hulu ke hilir, serta optimalisasi peran Bank Sampah Induk sebagai pusat komando dan Bank Sampah Unit sebagai garda terdepan di tingkat warga.\r\nMari bersama kita ubah \"sampah\" menjadi \"berkah\" melalui sistem pengelolaan yang terintegrasi. Sampah selesai di sumber, ekonomi warga berputar!', 'dokumentasi/6a3f258c9be62-1782523276.webp', '2026-06-27 01:21:21', '2026-06-27 01:21:21'),
(4, 'Bank Sampah Emak.id Menerima Penghargaan Implementasi K3 Terbaik Tahun 2025', 'Bank Sampah Emak.ID - Bank Sampah Emak.ID menerima Penghargaan Implementasi K3 Terbaik Tahun 2025 -\r\nKategori Lingkungan dalam rangka kegiatan yang diselenggarakan oleh PT PLN (Persero) Unit Induk Distribusi Lampung pada acara Executive Safety Forum Bulan K3\r\nNasional Tahun 2026.\r\nFounder Emak.ID Ahmad Khairudin Syam mengatakan bahwa pencapaian ini bukan tanpa sebab, ini adalah jerih payah dan konsistensi tim selama 5 tahun mengedukasi dan membantu emak-emak untuk berdaya dan memberdayakan.\r\nPenghargaan ini menjadi bentuk apresiasi atas komitmen kami dalam mendukung penerapan prinsip keselamatan, kesehatan kerja, serta pengelolaan lingkungan yang berkelanjutan.\r\nTerima kasih kepada seluruh mitra, tim, dan kolaborator yang terus membersamai langkah kami. Semoga penghargaan ini menjadi motivasi untuk terus menghadirkan program pengelolaan sampah yang aman, bertanggung jawab, dan berdampak nyata bagi lingkungan.', 'dokumentasi/6a3f26229d6b0-1782523426.webp', '2026-06-27 01:23:49', '2026-06-27 01:24:41'),
(5, 'Penandatanganan Kerja Sama Bersama PLN ULP Unit Sebalang, Lampung Selatan', 'Bank Sampah Emak.ID - Jumat (09/01), Bank Sampah Emak.ID melaksanakan penandatanganan kerja sama bersama PLN ULP Unit Sebalang, Lampung Selatan.\r\nKegiatan ini menjadi langkah awal kolaborasi dalam\r\nmendukung pengelolaan', 'dokumentasi/6a3f26d48aa57-1782523604.webp', '2026-06-27 01:26:48', '2026-06-27 01:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id_faq` bigint UNSIGNED NOT NULL,
  `pertanyaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jawaban` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int NOT NULL DEFAULT '1',
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id_faq`, `pertanyaan`, `jawaban`, `urutan`, `kategori`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bank Sampah Emak.id itu apa?', 'Bank Sampah Emak.id adalah platform digital dan lembaga pengelola sampah kering yang berpusat di Bandar Lampung. Platform ini memungkinkan masyarakat, terutama ibu rumah tangga, untuk mengumpulkan, memilah, dan menukarkan sampah non-organik menjadi tabungan bernilai ekonomis.', 1, NULL, 'nonaktif', '2026-06-09 19:33:39', '2026-06-27 00:56:46'),
(2, 'Bagaimana cara mendaftar menjadi nasabah Bank Sampah Emak.id?', 'Pendaftaran member atau nasabah Bank Sampah Emak.ID dapat dilakukan secara  berkelompok. Anda hanya perlu memilah sampah di rumah dan menghubungi admin untuk proses penimbangan serta pembuatan buku tabungan.\r\n\r\n1. Pendaftaran dapat dilakukan dengan langkah mudah berikut:\r\nPilahlah Sampah: Kumpulkan dan pisahkan sampah kering Anda (seperti plastik, kertas, logam, dan kaca) berdasarkan jenisnya.\r\n2. Hubungi Admin: Kirim pesan WhatsApp ke nomor resmi Bank Sampah Emak.ID di 0812-7152-3334.\r\n3. Penimbangan & Pembuatan Buku: Ikuti jadwal penimbangan. Pada setoran pertama, data Anda akan didaftarkan untuk mendapatkan buku tabungan nasabah.', 2, 'Pendaftaran', 'aktif', '2026-06-09 19:36:47', '2026-06-22 14:32:49'),
(3, 'Apakah ada biaya pendaftaran untuk menjadi nasabah?', 'Tidak ada biaya pendaftaran. Pendaftaran nasabah Bank Sampah Emak.id gratis.', 3, 'Pendaftaran', 'nonaktif', '2026-06-10 21:44:52', '2026-06-27 00:57:51'),
(4, 'Berapa minimal usia untuk menjadi nasabah?', 'Tidak ada batasan usia minimal. Setiap anggota masyarakat yang ingin menabung sampah dapat mendaftar sebagai nasabah.', 4, 'Pendaftaran', 'nonaktif', '2026-06-22 14:34:30', '2026-06-27 00:57:57'),
(5, 'Jenis sampah apa saja yang diterima oleh Bank Sampah Emak.id?', 'Bank Sampah Emak.id menerima sampah anorganik bernilai ekonomis, seperti plastik, kardus, kertas, logam, kaleng, besi, dan minyak jelantah.', 5, 'Jenis dan Harga Sampah', 'aktif', '2026-06-22 14:35:35', '2026-06-22 14:35:35'),
(6, 'Berapa harga per kilogram untuk setiap jenis sampah?', 'Harga setiap jenis sampah berbeda-beda dan dapat berubah sewaktu-waktu sesuai dengan harga pasar pengepul. Untuk informasi harga terbaru, nasabah dapat menghubungi admin atau melihat pengumuman di kantor.', 6, 'Jenis dan Harga Sampah', 'nonaktif', '2026-06-22 14:36:08', '2026-06-27 00:57:02'),
(7, 'Apakah harga sampah bisa berubah setiap saat?', 'Ya, harga sampah dapat berubah sesuai dengan fluktuasi harga pasar pengepul. Perubahan harga akan diinformasikan melalui pengumuman di kantor dan media sosial Bank Sampah Emak.id.', 7, 'Jenis dan Harga Sampah', 'aktif', '2026-06-22 14:36:35', '2026-06-22 14:36:35'),
(8, 'Sampah apa saja yang tidak diterima?', 'Sampah yang tidak diterima antara lain sampah basah/organik, sampah B3 (bahan berbahaya dan beracun), serta sampah yang sudah tercampur dan tidak dipilah.', 8, 'Jenis dan Harga Sampah', 'aktif', '2026-06-22 14:36:57', '2026-06-22 14:36:57'),
(9, 'Bagaimana cara menyetorkan sampah ke Bank Sampah Emak.id?', 'Nasabah memilah sampah sesuai jenisnya, kemudian membawanya ke lokasi penimbangan atau menghubungi petugas penimbang untuk penjemputan. Petugas akan menimbang sampah dan mencatat transaksi secara digital.', 9, 'Prosedur Setoran', 'aktif', '2026-06-22 14:38:11', '2026-06-22 14:38:11'),
(10, 'Apakah sampah harus dipilah sebelum disetorkan?', 'Ya, sampah harus dipilah sesuai jenisnya (plastik, kardus, kertas, logam, dll.) sebelum disetorkan. Sampah yang sudah dipilah akan memudahkan proses penimbangan dan meningkatkan nilai jualnya.', 10, 'Prosedur Setoran', 'aktif', '2026-06-22 14:38:44', '2026-06-22 14:38:44'),
(11, 'Apakah petugas penimbang datang ke rumah nasabah?', 'Ya, petugas penimbang dapat mendatangi rumah nasabah sesuai dengan jadwal yang telah disepakati. Nasabah dapat menghubungi admin untuk mengatur jadwal penjemputan.', 11, 'Prosedur Setoran', 'aktif', '2026-06-22 14:39:07', '2026-06-22 14:39:07'),
(12, 'Berapa minimal berat sampah yang dapat disetorkan?', 'Tidak ada batasan minimal berat sampah. Nasabah dapat menyetorkan sampah dalam jumlah berapa pun.', 12, 'Prosedur Setoran', 'nonaktif', '2026-06-22 14:39:31', '2026-06-27 00:57:30'),
(13, 'Bagaimana cara mengecek saldo tabungan sampah saya?', 'Nasabah dapat mengecek saldo dengan menghubungi admin melalui nomor kontak yang tersedia. Saldo juga dapat dilihat melalui buku tabungan yang dicatat oleh petugas saat transaksi.', 13, 'Saldo dan Tabungan', 'aktif', '2026-06-22 14:40:10', '2026-06-22 14:40:10'),
(14, 'Apakah saldo tabungan sampah bisa diuangkan?', 'Ya, saldo tabungan sampah dapat diuangkan melalui proses penarikan yang dilakukan di kantor Bank Sampah Emak.id.', 14, 'Saldo dan Tabungan', 'nonaktif', '2026-06-22 14:40:40', '2026-06-27 00:57:42');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_sampah`
--

CREATE TABLE `jenis_sampah` (
  `id_jenis` bigint UNSIGNED NOT NULL,
  `nama_sampah` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_per_kg` decimal(12,2) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_sampah`
--

INSERT INTO `jenis_sampah` (`id_jenis`, `nama_sampah`, `harga_per_kg`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Plastik', 700.00, 1, '2026-06-10 05:11:25', '2026-06-10 08:12:20'),
(2, 'Kertas HVS', 3000.00, 1, '2026-06-10 05:11:25', '2026-06-27 01:10:59'),
(3, 'Minyak Jelantah', 19000.00, 1, '2026-06-11 00:33:04', '2026-06-22 14:13:21'),
(4, 'Alat Elektronik', 3750.00, 1, '2026-06-14 15:32:55', '2026-06-27 01:04:18'),
(5, 'Kaleng', 3000.00, 1, '2026-06-14 15:32:55', '2026-06-27 01:04:58'),
(6, 'Besi', 3000.00, 1, '2026-06-27 01:05:21', '2026-06-27 01:05:21'),
(7, 'Kardus', 200.00, 1, '2026-06-27 01:11:10', '2026-06-27 01:11:10'),
(8, 'Koran', 300.00, 1, '2026-06-27 01:11:20', '2026-06-27 01:11:20'),
(9, 'Duplek', 400.00, 1, '2026-06-27 01:11:30', '2026-06-27 01:11:30'),
(10, 'Kertas Campur', 150.00, 1, '2026-06-27 01:11:50', '2026-06-27 01:11:50'),
(11, 'galon (bukan jenis PET)', 7000.00, 1, '2026-06-27 01:12:26', '2026-06-27 01:12:26'),
(12, 'Majalah', 300.00, 1, '2026-06-27 01:12:50', '2026-06-27 01:12:50'),
(13, 'Emberan', 500.00, 1, '2026-06-27 01:13:17', '2026-06-27 01:13:17'),
(14, 'Plastik Campur', 250.00, 1, '2026-06-27 01:13:30', '2026-06-27 01:13:30');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_koreksi`
--

CREATE TABLE `log_koreksi` (
  `id_log` bigint UNSIGNED NOT NULL,
  `id_transaksi` bigint UNSIGNED NOT NULL,
  `id_admin` bigint UNSIGNED NOT NULL,
  `catatan_alasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_sebelum` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_sesudah` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log_koreksi`
--

INSERT INTO `log_koreksi` (`id_log`, `id_transaksi`, `id_admin`, `catatan_alasan`, `field_sebelum`, `field_sesudah`, `created_at`, `updated_at`) VALUES
(3, 34, 1, 'Dikoreksi melalui form edit transaksi', '{\"total_nilai\":\"17458.00\"}', '{\"total_nilai\":17500}', '2026-06-26 04:58:15', '2026-06-26 04:58:15'),
(5, 33, 1, 'Dikoreksi melalui form edit transaksi', '{\"total_nilai\":\"18000.00\"}', '{\"total_nilai\":15000}', '2026-06-26 16:13:26', '2026-06-26 16:13:26'),
(6, 32, 1, 'Dikoreksi melalui form edit transaksi', '{\"total_nilai\":\"101000.00\"}', '{\"total_nilai\":63000}', '2026-06-26 16:15:52', '2026-06-26 16:15:52'),
(7, 35, 2, 'Dikoreksi melalui form edit transaksi', '{\"total_nilai\":\"20970.00\"}', '{\"total_nilai\":19500}', '2026-06-27 01:37:06', '2026-06-27 01:37:06'),
(8, 35, 2, 'Dikoreksi melalui form edit transaksi', '{\"total_nilai\":\"19500.00\"}', '{\"total_nilai\":21000}', '2026-06-27 02:01:32', '2026-06-27 02:01:32'),
(9, 31, 1, 'Dikoreksi melalui form edit transaksi', '{\"total_nilai\":\"78000.00\"}', '{\"total_nilai\":72000}', '2026-06-27 02:03:32', '2026-06-27 02:03:32'),
(10, 33, 1, 'Dikoreksi melalui form edit transaksi', '{\"total_nilai\":\"15000.00\"}', '{\"total_nilai\":21000}', '2026-06-27 02:05:06', '2026-06-27 02:05:06'),
(11, 35, 1, 'Dikoreksi melalui form edit transaksi', '{\"total_nilai\":\"21000.00\"}', '{\"total_nilai\":15000}', '2026-06-27 02:11:18', '2026-06-27 02:11:18'),
(12, 35, 1, 'Dikoreksi melalui form edit transaksi, grup divalidasi ulang', '{\"total_nilai\":\"15000.00\"}', '{\"total_nilai\":30000}', '2026-06-27 02:17:45', '2026-06-27 02:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_04_075400_create_nasabah_table', 1),
(5, '2026_06_04_075408_create_jenis_sampah_table', 1),
(6, '2026_06_04_112035_create_transaksi_table', 1),
(7, '2026_06_04_112042_create_detail_transaksi_table', 1),
(8, '2026_06_04_113019_create_log_koreksi_table', 1),
(9, '2026_06_05_004208_create_units_table', 1),
(10, '2026_06_05_004213_update_nasabahs_table_add_unit', 1),
(11, '2026_06_05_004222_update_jenis_sampahs_table_remove_satuan', 1),
(12, '2026_06_05_013311_create_faqs_table', 1),
(13, '2026_06_05_035755_create_backup_logs_table', 1),
(14, '2026_06_10_160925_create_penarikan_saldos_table', 2),
(15, '2026_06_10_165139_add_catatan_validasi_to_transaksi_table', 2),
(16, '2026_06_12_025915_create_chatbot_settings_table', 3),
(17, '2026_06_12_031320_create_chatbot_rules_table', 3),
(18, '2026_06_12_071929_update_penarikan_saldos_table_add_token_bukti', 3),
(19, '2026_06_22_012357_add_biaya_admin_to_penarikan_saldo_table', 4),
(20, '2026_06_23_095306_create_dokumentasis_table', 5),
(21, '2026_06_25_161545_create_calon_units_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `id_nasabah` bigint UNSIGNED NOT NULL,
  `id_unit` bigint UNSIGNED DEFAULT NULL,
  `no_rekening` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `kecamatan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldo` decimal(12,2) NOT NULL DEFAULT '0.00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`id_nasabah`, `id_unit`, `no_rekening`, `nama`, `alamat`, `kecamatan`, `no_hp`, `saldo`, `deleted_at`, `created_at`, `updated_at`) VALUES
(15, 5, 'EMK-2606-0015', 'Astuti', 'KEMILING PERMAI', 'Kemiling', '628950433218', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(16, 5, 'EMK-2606-0016', 'Lusi', 'KEMILING PERMAI', 'Kemiling', '6281300133890', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(17, 5, 'EMK-2606-0017', 'Delima Manik', 'KEMILING PERMAI', 'Kemiling', '628588637940', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(18, 5, 'EMK-2606-0018', 'Elis Susanti', 'KEMILING PERMAI', 'Kemiling', '628996542351', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(19, 5, 'EMK-2606-0019', 'Ety Purwati', 'KEMILING PERMAI', 'Kemiling', '6281315594078', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(20, 5, 'EMK-2606-0020', 'Handayani', 'KEMILING PERMAI', 'Kemiling', '6281418495931', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(21, 5, 'EMK-2606-0021', 'Ike Puspita Sari', 'KEMILING PERMAI', 'Kemiling', '628124131647', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(22, 5, 'EMK-2606-0022', 'Maryati', 'KEMILING PERMAI', 'Kemiling', '6289525534192', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(23, 5, 'EMK-2606-0023', 'Pak Sujatmiko', 'KEMILING PERMAI', 'Kemiling', '628582764835', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(24, 5, 'EMK-2606-0024', 'Perniati', 'KEMILING PERMAI', 'Kemiling', '628993056413', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(25, 5, 'EMK-2606-0025', 'Ponijem', 'KEMILING PERMAI', 'Kemiling', '6287737672423', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(26, 5, 'EMK-2606-0026', 'Sri Lestari', 'KEMILING PERMAI', 'Kemiling', '6289896965328', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(27, 5, 'EMK-2606-0027', 'Sumiyati', 'KEMILING PERMAI', 'Kemiling', '628560122691', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(28, 5, 'EMK-2606-0028', 'Sutriyani', 'KEMILING PERMAI', 'Kemiling', '6285297848018', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(29, 5, 'EMK-2606-0029', 'Umi Yati', 'KEMILING PERMAI', 'Kemiling', '6289951462704', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(30, 6, 'EMK-2606-0030', 'Ana Mariana', 'KEMILING RAYA', 'Kemiling', '628578148932', 63000.00, NULL, '2026-06-24 06:52:25', '2026-06-27 02:23:49'),
(31, 6, 'EMK-2606-0031', 'Aslihah', 'KEMILING RAYA', 'Kemiling', '628238809570', 21000.00, NULL, '2026-06-24 06:52:25', '2026-06-27 02:23:49'),
(32, 6, 'EMK-2606-0032', 'Desti Yati', 'KEMILING RAYA', 'Kemiling', '6281443039117', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(33, 6, 'EMK-2606-0033', 'Dewi', 'KEMILING RAYA', 'Kemiling', '628132782489', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(34, 6, 'EMK-2606-0034', 'Eni Kristiani', 'KEMILING RAYA', 'Kemiling', '628538346578', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(35, 6, 'EMK-2606-0035', 'Entin', 'KEMILING RAYA', 'Kemiling', '628553315098', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(36, 6, 'EMK-2606-0036', 'Erin Maharani', 'KEMILING RAYA', 'Kemiling', '628180103105', 17500.00, NULL, '2026-06-24 06:52:25', '2026-06-27 02:23:49'),
(37, 6, 'EMK-2606-0037', 'Iyem (walkiyem)', 'KEMILING RAYA', 'Kemiling', '628134738299', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(38, 6, 'EMK-2606-0038', 'Jainab', 'KEMILING RAYA', 'Kemiling', '628567631165', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(39, 6, 'EMK-2606-0039', 'Jumaini (bu Jum)', 'KEMILING RAYA', 'Kemiling', '6285370106513', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(40, 6, 'EMK-2606-0040', 'Kanti Sri Rahayu', 'KEMILING RAYA', 'Kemiling', '628178726247', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(41, 6, 'EMK-2606-0041', 'Kartinawati', 'KEMILING RAYA', 'Kemiling', '628187810801', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(42, 6, 'EMK-2606-0042', 'Menik', 'KEMILING RAYA', 'Kemiling', '628992677360', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(43, 6, 'EMK-2606-0043', 'Miat (kucir)', 'KEMILING RAYA', 'Kemiling', '6281606474687', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(44, 6, 'EMK-2606-0044', 'Nur Lela (leni)', 'KEMILING RAYA', 'Kemiling', '628154309805', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(45, 6, 'EMK-2606-0045', 'Partini', 'KEMILING RAYA', 'Kemiling', '628129788208', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(46, 6, 'EMK-2606-0046', 'Rianti', 'KEMILING RAYA', 'Kemiling', '628131913619', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(47, 6, 'EMK-2606-0047', 'Rodiah / Diah Rahmawati', 'KEMILING RAYA', 'Kemiling', '628189169985', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(48, 6, 'EMK-2606-0048', 'Saminah', 'KEMILING RAYA', 'Kemiling', '628195346247', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(49, 6, 'EMK-2606-0049', 'Samini', 'KEMILING RAYA', 'Kemiling', '628220799118', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(50, 6, 'EMK-2606-0050', 'Sri Rezeki', 'KEMILING RAYA', 'Kemiling', '6285898084124', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(51, 6, 'EMK-2606-0051', 'Suhartatik', 'KEMILING RAYA', 'Kemiling', '628148244935', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(52, 6, 'EMK-2606-0052', 'Suiwati ( Afah)', 'KEMILING RAYA', 'Kemiling', '6281787401640', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(53, 6, 'EMK-2606-0053', 'Sumiah', 'KEMILING RAYA', 'Kemiling', '6281124278680', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(54, 6, 'EMK-2606-0054', 'Yuyuk Susanti', 'KEMILING RAYA', 'Kemiling', '628142805982', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(55, 6, 'EMK-2606-0055', 'Sutriana', 'KEMILING RAYA', 'Kemiling', '628530450533', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(56, 6, 'EMK-2606-0056', 'Murtasiyah', 'KEMILING RAYA', 'Kemiling', '628965869232', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(57, 6, 'EMK-2606-0057', 'Wiwin', 'KEMILING RAYA', 'Kemiling', '6281602563421', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(58, 7, 'EMK-2606-0058', 'Adibah / Juariah / Juju', 'KEMILING PERMAI', 'Kemiling', '628527337543', 77600.00, NULL, '2026-06-24 06:52:25', '2026-06-27 02:23:49'),
(59, 7, 'EMK-2606-0059', 'Aida Wati As', 'KEMILING PERMAI', 'Kemiling', '628183654145', 63750.00, NULL, '2026-06-24 06:52:25', '2026-06-27 02:24:06'),
(60, 7, 'EMK-2606-0060', 'Bainah Sari Dewi', 'KEMILING PERMAI', 'Kemiling', '6289585014294', 72000.00, NULL, '2026-06-24 06:52:25', '2026-06-27 02:23:49'),
(61, 7, 'EMK-2606-0061', 'Bude Suusan', 'KEMILING PERMAI', 'Kemiling', '628129655698', 2400.00, NULL, '2026-06-24 06:52:25', '2026-06-27 02:23:49'),
(62, 7, 'EMK-2606-0062', 'Dewi Kospitia', 'KEMILING PERMAI', 'Kemiling', '6281493406088', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(63, 7, 'EMK-2606-0063', 'Diana Fitri!!!!', 'KEMILING PERMAI', 'Kemiling', '628965615951', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(64, 7, 'EMK-2606-0064', 'Diana Ningsih', 'KEMILING PERMAI', 'Kemiling', '6289884656482', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(65, 7, 'EMK-2606-0065', 'Ertina', 'KEMILING PERMAI', 'Kemiling', '6281762994680', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(66, 7, 'EMK-2606-0066', 'Euis Nerlela', 'KEMILING PERMAI', 'Kemiling', '6282136995777', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(67, 7, 'EMK-2606-0067', 'Evi Yuliani', 'KEMILING PERMAI', 'Kemiling', '628968721489', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(68, 7, 'EMK-2606-0068', 'Farida Rohana', 'KEMILING PERMAI', 'Kemiling', '628223433200', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(69, 7, 'EMK-2606-0069', 'Halimah', 'KEMILING PERMAI', 'Kemiling', '6281891769367', 10500.00, NULL, '2026-06-24 06:52:25', '2026-06-27 02:23:49'),
(70, 7, 'EMK-2606-0070', 'Halivah (evo) / Ifah / Kholifah', 'KEMILING PERMAI', 'Kemiling', '628522016328', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(71, 7, 'EMK-2606-0071', 'Helda Lina', 'KEMILING PERMAI', 'Kemiling', '628558317278', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(72, 7, 'EMK-2606-0072', 'Henal Masuri', 'KEMILING PERMAI', 'Kemiling', '6285879868727', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(73, 7, 'EMK-2606-0073', 'Huzaifah', 'KEMILING PERMAI', 'Kemiling', '6285534873471', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(74, 7, 'EMK-2606-0074', 'Ida Yuliati', 'KEMILING PERMAI', 'Kemiling', '6289734558122', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(75, 7, 'EMK-2606-0075', 'Ike Rosanti', 'KEMILING PERMAI', 'Kemiling', '6281823166587', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(76, 7, 'EMK-2606-0076', 'Kana', 'KEMILING PERMAI', 'Kemiling', '628533669096', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(77, 7, 'EMK-2606-0077', 'Lisda Anjani', 'KEMILING PERMAI', 'Kemiling', '628565466889', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(78, 7, 'EMK-2606-0078', 'Mahani / Yani', 'KEMILING PERMAI', 'Kemiling', '6281834670656', 0.00, NULL, '2026-06-24 06:52:25', '2026-06-24 06:52:25'),
(79, 5, 'EMK-2606-0079', 'Dinda Wulandari', 'Bandar Lampung', 'Kemiling', '6281271694520', 0.00, NULL, '2026-06-27 01:42:05', '2026-06-27 01:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penarikan_saldos`
--

CREATE TABLE `penarikan_saldos` (
  `id_penarikan` bigint UNSIGNED NOT NULL,
  `id_nasabah` bigint UNSIGNED NOT NULL,
  `id_admin` bigint UNSIGNED NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `biaya_admin` decimal(15,2) NOT NULL DEFAULT '0.00',
  `metode` enum('Tunai','Transfer Bank','E-Wallet (Dana/OVO/GoPay)','Token Listrik','Lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `nomor_token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_transfer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penarikan_saldos`
--

INSERT INTO `penarikan_saldos` (`id_penarikan`, `id_nasabah`, `id_admin`, `nominal`, `biaya_admin`, `metode`, `keterangan`, `nomor_token`, `bukti_transfer`, `status`, `created_at`, `updated_at`) VALUES
(12, 61, 1, 20000.00, 800.00, 'Transfer Bank', '0812345678', NULL, NULL, 'Approved', '2026-06-27 01:27:50', '2026-06-27 01:27:50');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('TJw7BGMWBqvhgxXCUcCGhFTESbawztV5vnsgtvGG', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJzVGRrbVFFcGhFTnJNUUhqRjNMQmdMdmcxOU9xNE12SHJvM2ZneUlqIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImFkbWluLmRhc2hib2FyZCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1782527734),
('xsWyFaR3N5i2ombdoDu1UDC1BJg30Vy2dVRsXK0F', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJUUTdRQmQwVzVMZ2FZTktoTjlkcE9LNjVhYVFORUNqNUJZdERZd2xPIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1782521555);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` bigint UNSIGNED NOT NULL,
  `id_nasabah` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `status_validasi` enum('pending','valid','terkoreksi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `catatan_validasi` text COLLATE utf8mb4_unicode_ci,
  `total_nilai` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_nasabah`, `id_user`, `status_validasi`, `catatan_validasi`, `total_nilai`, `created_at`, `updated_at`) VALUES
(29, 58, 2, 'terkoreksi', 'Terkoreksi Wajar: Selisih 0.2kg (Lap: 90.2kg, Gud: 90kg).', 77600.00, '2026-06-25 03:58:12', '2026-06-27 02:23:49'),
(30, 61, 2, 'terkoreksi', 'Terkoreksi Wajar: Selisih 0.2kg (Lap: 90.2kg, Gud: 90kg).', 23200.00, '2026-06-25 03:58:35', '2026-06-27 02:23:49'),
(31, 60, 2, 'terkoreksi', 'Terkoreksi Wajar: Selisih 0.2kg (Lap: 90.2kg, Gud: 90kg).', 72000.00, '2026-06-25 03:58:57', '2026-06-27 02:23:49'),
(32, 30, 2, 'terkoreksi', 'Terkoreksi Wajar: Selisih 0.2kg (Lap: 90.2kg, Gud: 90kg).', 63000.00, '2026-06-25 03:59:22', '2026-06-27 02:23:49'),
(33, 31, 2, 'terkoreksi', 'Terkoreksi Wajar: Selisih 0.2kg (Lap: 90.2kg, Gud: 90kg).', 21000.00, '2026-06-25 03:59:38', '2026-06-27 02:23:49'),
(34, 36, 2, 'terkoreksi', 'Terkoreksi Wajar: Selisih 0.2kg (Lap: 90.2kg, Gud: 90kg).', 17500.00, '2026-06-25 03:59:52', '2026-06-27 02:23:49'),
(35, 69, 2, 'terkoreksi', 'Terkoreksi Wajar: Selisih 0.2kg (Lap: 90.2kg, Gud: 90kg).', 30000.00, '2026-06-25 04:35:10', '2026-06-27 02:23:49'),
(36, 59, 2, 'terkoreksi', 'Selisih berat >10kg (Lap: 17kg, Gud: 6kg). Perlu di evaluasi pengelola.', 63750.00, '2026-06-27 01:37:47', '2026-06-27 02:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id_unit` bigint UNSIGNED NOT NULL,
  `nama_unit` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ketua` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp_ketua` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_daftar` date NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id_unit`, `nama_unit`, `kecamatan`, `nama_ketua`, `no_hp_ketua`, `tanggal_daftar`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Gg. WALUH', 'KEMILING', 'Umi Yati', '6289951462704', '2026-06-24', 'aktif', '2026-06-24 06:52:24', '2026-06-27 01:01:30'),
(6, 'KEMILING RAYA', 'KEMILING', 'Wiwin', '6281602563421', '2026-06-24', 'aktif', '2026-06-24 06:52:25', '2026-06-27 01:00:22'),
(7, 'BKP BLOK S', 'KEMILING', 'Lisda Anjani', '628565466889', '2026-06-24', 'aktif', '2026-06-24 06:52:25', '2026-06-27 01:00:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('penimbang','admin','pengelola') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'penimbang',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@emak.id', NULL, '$2y$12$jiLVTfhGf6zIFHysj4hJTej5NYV2C8PN4HI7iAvjpqdbDEEK9LFvK', 'admin', 'grg1M9rnzIk8eFAm2MmdbB0yON6IISvkWKfm1I7nFjVHakkL59thj7QF01lh', '2026-06-09 19:12:20', '2026-06-09 19:12:20'),
(2, 'Topan Penimbang', 'penimbang@emak.id', NULL, '$2y$12$DF7FCijWf8bhvbxSlvtrB.Vy0wFlVZUpM8OpS/vj.dXzPnK/7FNTW', 'penimbang', NULL, '2026-06-09 19:12:20', '2026-06-27 02:35:12'),
(3, 'Syam Pengelola', 'pengelola@emak.id', NULL, '$2y$12$/r65p3S3D6/D5XVeATaSeuRhBeTcCF7d0qmyc7Cd/uNFl9CNXl.qe', 'pengelola', NULL, '2026-06-09 19:12:21', '2026-06-27 02:33:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup_logs`
--
ALTER TABLE `backup_logs`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `backup_logs_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `calon_units`
--
ALTER TABLE `calon_units`
  ADD PRIMARY KEY (`id_calon`);

--
-- Indexes for table `chatbot_rules`
--
ALTER TABLE `chatbot_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatbot_settings`
--
ALTER TABLE `chatbot_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `detail_transaksi_id_transaksi_foreign` (`id_transaksi`),
  ADD KEY `detail_transaksi_id_jenis_foreign` (`id_jenis`);

--
-- Indexes for table `dokumentasis`
--
ALTER TABLE `dokumentasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id_faq`);

--
-- Indexes for table `jenis_sampah`
--
ALTER TABLE `jenis_sampah`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_koreksi`
--
ALTER TABLE `log_koreksi`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `log_koreksi_id_transaksi_foreign` (`id_transaksi`),
  ADD KEY `log_koreksi_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id_nasabah`),
  ADD UNIQUE KEY `nasabah_no_rekening_unique` (`no_rekening`),
  ADD KEY `nasabah_id_unit_foreign` (`id_unit`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penarikan_saldos`
--
ALTER TABLE `penarikan_saldos`
  ADD PRIMARY KEY (`id_penarikan`),
  ADD KEY `penarikan_saldos_id_nasabah_foreign` (`id_nasabah`),
  ADD KEY `penarikan_saldos_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `transaksi_id_nasabah_foreign` (`id_nasabah`),
  ADD KEY `transaksi_id_user_foreign` (`id_user`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup_logs`
--
ALTER TABLE `backup_logs`
  MODIFY `id_log` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `calon_units`
--
ALTER TABLE `calon_units`
  MODIFY `id_calon` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chatbot_rules`
--
ALTER TABLE `chatbot_rules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chatbot_settings`
--
ALTER TABLE `chatbot_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `dokumentasis`
--
ALTER TABLE `dokumentasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id_faq` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jenis_sampah`
--
ALTER TABLE `jenis_sampah`
  MODIFY `id_jenis` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_koreksi`
--
ALTER TABLE `log_koreksi`
  MODIFY `id_log` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id_nasabah` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `penarikan_saldos`
--
ALTER TABLE `penarikan_saldos`
  MODIFY `id_penarikan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id_unit` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `backup_logs`
--
ALTER TABLE `backup_logs`
  ADD CONSTRAINT `backup_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_id_jenis_foreign` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_sampah` (`id_jenis`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksi_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE;

--
-- Constraints for table `log_koreksi`
--
ALTER TABLE `log_koreksi`
  ADD CONSTRAINT `log_koreksi_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `log_koreksi_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE;

--
-- Constraints for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD CONSTRAINT `nasabah_id_unit_foreign` FOREIGN KEY (`id_unit`) REFERENCES `units` (`id_unit`) ON DELETE RESTRICT;

--
-- Constraints for table `penarikan_saldos`
--
ALTER TABLE `penarikan_saldos`
  ADD CONSTRAINT `penarikan_saldos_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `penarikan_saldos_id_nasabah_foreign` FOREIGN KEY (`id_nasabah`) REFERENCES `nasabah` (`id_nasabah`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_id_nasabah_foreign` FOREIGN KEY (`id_nasabah`) REFERENCES `nasabah` (`id_nasabah`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
