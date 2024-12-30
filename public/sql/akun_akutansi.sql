-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 22 Feb 2024 pada 09.10
-- Versi server: 8.0.36-cll-lve
-- Versi PHP: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mypbfnet_member_apps`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun_akutansi`
--

CREATE TABLE `akun_akutansi` (
  `id` bigint UNSIGNED NOT NULL,
  `id_perusahaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_akun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_akun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kas_bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_delete` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `akun_akutansi`
--

INSERT INTO `akun_akutansi` (`id`, `id_perusahaan`, `kode`, `nama_akun`, `jenis_akun`, `kas_bank`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, '1', '1-1001', 'Piutang Dagang dan Konsinyasi', 'Aktiva', '0', '0', '2023-11-10 02:40:44', '2023-11-10 02:40:44'),
(3, '1', '1-2001', 'Persediaan Dagang dan Konsinyasi', 'Aktiva', '0', '0', '2023-11-10 02:40:44', '2023-11-10 02:40:44'),
(5, '1', '1-3001', 'PPN Masukan', 'Aktiva', '0', '0', '2023-11-10 02:40:44', '2023-11-10 02:40:44'),
(6, '1', '2-1001', 'Hutang Dagang dan Konsinyasi', 'Kewajiban', '0', '0', '2023-11-10 02:40:44', '2023-11-10 02:40:44'),
(8, '1', '3-1001', 'Modal Pemilik', 'Modal', '0', '0', '2023-11-10 02:40:44', '2023-11-10 02:40:44'),
(9, '1', '1-0001', 'Kas Pusat', 'Aktiva', '1', '0', '2023-11-12 19:25:04', '2023-11-12 19:25:04'),
(10, '1', '1-0002', 'Kas Operasional', 'Aktiva', '1', '0', '2023-11-12 19:25:30', '2023-11-12 19:25:30'),
(11, '1', '1-0010', 'Bank BCA', 'Aktiva', '1', '0', '2023-11-12 19:26:11', '2023-11-12 19:26:11'),
(12, '1', '1-0011', 'Bank Mandiri', 'Aktiva', '1', '0', '2023-11-12 19:27:02', '2023-11-12 19:27:12'),
(13, '1', '1-0012', 'Bank BNI', 'Aktiva', '1', '0', '2023-11-12 19:27:51', '2023-11-12 19:27:51'),
(14, '1', '1-3010', 'Pajak Dibayar dimuka', 'Aktiva', '0', '0', '2023-11-12 19:30:11', '2023-11-12 19:30:11'),
(15, '1', '1-4001', 'Aset Tanah', 'Aktiva', '0', '0', '2023-11-12 19:32:17', '2023-11-12 19:32:17'),
(16, '1', '1-4010', 'Aset Bangunan', 'Aktiva', '0', '0', '2023-11-12 19:32:44', '2023-11-12 19:32:44'),
(17, '1', '1-4020', 'Aset Kendaraan', 'Aktiva', '0', '0', '2023-11-12 19:34:04', '2023-11-12 19:34:04'),
(18, '1', '1-4040', 'Aset Peralatan', 'Aktiva', '0', '0', '2023-11-12 19:34:25', '2023-11-12 19:34:25'),
(19, '1', '1-5010', 'Akumulasi Penyusutan Gedung', 'Aktiva', '0', '0', '2023-11-12 19:36:47', '2023-11-12 19:37:02'),
(20, '1', '1-5001', 'Akumulasi Penyusutan Tanah', 'Aktiva', '0', '0', '2023-11-12 19:37:37', '2023-11-12 19:37:37'),
(21, '1', '1-5030', 'Akumulasi Penyusutan Kendaraan', 'Aktiva', '0', '0', '2023-11-12 19:39:07', '2023-11-12 19:39:07'),
(22, '1', '1-5040', 'Akumulasi Penyusutan Peralatan', 'Aktiva', '0', '0', '2023-11-12 19:41:16', '2023-11-12 19:41:16'),
(23, '1', '2-2010', 'Hutang Non Operasional', 'Kewajiban', '0', '0', '2023-11-12 19:47:06', '2023-11-12 19:51:43'),
(24, '1', '2-3001', 'PPN Keluaran', 'Kewajiban', '0', '0', '2023-11-12 19:48:23', '2023-11-12 19:48:23'),
(25, '1', '2-3010', 'PPN Lebih Bayar', 'Kewajiban', '0', '0', '2023-11-12 19:49:34', '2023-11-12 19:49:34'),
(26, '1', '2-3020', 'PPN Kurang Bayar', 'Kewajiban', '0', '0', '2023-11-12 19:50:12', '2023-11-12 19:50:12'),
(27, '1', '2-2001', 'Hutang Gaji Karyawan', 'Kewajiban', '0', '0', '2023-11-12 19:52:53', '2023-11-12 19:52:53'),
(28, '1', '2-2020', 'Hutang PPN', 'Kewajiban', '0', '0', '2023-11-12 19:55:34', '2023-11-12 19:55:34'),
(29, '1', '3-1010', 'Laba Ditahan', 'Modal', '0', '0', '2023-11-12 19:57:04', '2023-11-12 19:57:04'),
(30, '1', '3-1020', 'Laba/Rugi', 'Modal', '0', '0', '2023-11-12 19:57:41', '2023-11-12 19:57:41'),
(31, '1', '3-1030', 'Prive', 'Modal', '0', '0', '2023-11-12 19:58:19', '2023-11-12 19:58:19'),
(32, '1', '4-1001', 'Pendapatan Dagang & Konsinyasi', 'Pendapatan', '0', '0', '2023-11-12 19:59:56', '2023-12-26 01:19:01'),
(34, '1', '5-1001', 'HPP Dagang dan Konsinyasi', 'HPP', '0', '0', '2023-11-12 20:08:42', '2023-11-12 20:08:42'),
(35, '1', '5-2001', 'HPP Stok Opname', 'HPP', '0', '0', '2023-11-12 20:09:38', '2023-11-12 20:09:38'),
(39, '1', '6-2001', 'Biaya Listrik/Air/Telp', 'Biaya', '0', '0', '2023-11-12 20:41:36', '2023-11-12 20:41:36'),
(40, '1', '6-2002', 'Biaya Sewa Gedung', 'Biaya', '0', '0', '2023-11-12 20:45:17', '2023-11-12 20:45:17'),
(41, '1', '6-2003', 'Biaya ATK', 'Biaya', '0', '0', '2023-11-12 21:00:41', '2023-11-12 21:00:41'),
(42, '1', '6-2004', 'Biaya Administrasi Bank', 'Biaya', '0', '0', '2023-11-12 21:01:00', '2023-11-12 21:01:00'),
(43, '1', '6-2005', 'Biaya Internet', 'Biaya', '0', '0', '2023-11-12 21:02:04', '2023-11-12 21:02:04'),
(44, '1', '6-2006', 'Biaya Promosi', 'Biaya', '0', '0', '2023-11-12 21:03:14', '2023-11-12 21:03:14'),
(45, '1', '6-3001', 'Biaya Gaji Karyawan', 'Biaya', '0', '0', '2023-11-12 21:03:49', '2023-11-12 21:03:49'),
(46, '1', '6-3002', 'Biaya Lembur Pegawai', 'Biaya', '0', '0', '2023-11-12 21:04:26', '2023-11-12 21:04:26'),
(47, '1', '6-3003', 'Biaya Komisi Sales', 'Biaya', '0', '0', '2023-11-12 21:05:36', '2023-11-12 21:05:36'),
(48, '1', '6-3004', 'Biaya Insentif Pegawai', 'Biaya', '0', '0', '2023-11-12 21:06:09', '2023-11-12 21:06:09'),
(49, '1', '6-4001', 'Biaya Penyusutan Aset Tanah', 'Biaya', '0', '0', '2023-11-12 21:07:04', '2023-11-12 21:07:04'),
(50, '1', '6-4002', 'Biaya Penyusutan Gedung', 'Biaya', '0', '0', '2023-11-12 21:20:38', '2023-11-12 21:20:38'),
(51, '1', '6-4003', 'Biaya Penyusutan Kendaraan', 'Biaya', '0', '0', '2023-11-12 21:21:34', '2023-11-12 21:21:34'),
(52, '1', '6-4004', 'Biaya Penyusutan Peralatan', 'Biaya', '0', '0', '2023-11-12 21:22:07', '2023-11-12 21:22:07'),
(54, '1', '7-1010', 'Pendapatan Stok Opname', 'Pendapatan Lain', '0', '0', '2023-11-12 22:42:47', '2023-12-26 02:51:29'),
(57, '1', '8-1010', 'Kerugian Stok Opname', 'Biaya Lain', '0', '0', '2023-11-12 22:57:29', '2023-12-26 01:17:41'),
(59, '1', '1-1003', 'Kas Kecil', 'Aktiva', '1', '0', '2023-11-13 23:24:39', '2023-11-13 23:24:39'),
(60, '1', '4-1002', 'Retur Penjualan', 'Pendapatan', '0', '0', '2024-02-21 18:39:27', '2024-02-21 18:39:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun_akutansi`
--
ALTER TABLE `akun_akutansi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun_akutansi`
--
ALTER TABLE `akun_akutansi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
