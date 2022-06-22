-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jun 2022 pada 06.39
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `backups`
--

CREATE TABLE `backups` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktur dari tabel `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `nominal` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `saldo` bigint(20) DEFAULT NULL,
  `id_login` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kas_saldos`
--

CREATE TABLE `kas_saldos` (
  `id_kas` bigint(10) NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `nominal` int(11) NOT NULL DEFAULT 0,
  `keterangan` varchar(255) DEFAULT NULL,
  `hpp` int(11) NOT NULL DEFAULT 0,
  `saldo` int(11) NOT NULL DEFAULT 0,
  `id_login` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `kas_saldos`
--

INSERT INTO `kas_saldos` (`id_kas`, `kode`, `jenis`, `nominal`, `keterangan`, `hpp`, `saldo`, `id_login`, `created_at`, `updated_at`) VALUES
(1, 'KS-000001', 'Pemasukan', 10500, 'Penjualan', 6000, 10500, 3, '2022-06-07 11:44:09', '2022-06-07 11:44:09'),
(3, 'KS-000003', 'Pemasukan', 3000, 'Penjualan', 1500, 19000, 3, '2022-06-07 12:05:10', '2022-06-07 12:05:10'),
(5, 'KS-000005', 'Pemasukan', 3000, 'Penjualan', 1500, 17000, 3, '2022-06-07 12:12:15', '2022-06-07 12:12:15'),
(6, 'KS-000006', 'Pemasukan', 3000, 'Penjualan', 1500, 20000, 3, '2022-06-07 16:51:20', '2022-06-07 16:51:20'),
(7, 'KS-000007', 'Pemasukan', 2500, 'Penjualan', 1500, 22500, 3, '2022-06-07 16:52:03', '2022-06-07 16:52:03'),
(8, 'KS-000008', 'Pemasukan', 3000, 'Penjualan', 1500, 25500, 3, '2022-06-07 16:52:21', '2022-06-07 16:52:21'),
(9, 'KS-000009', 'Pemasukan', 5500, 'Penjualan', 3000, 31000, 3, '2022-06-07 16:55:54', '2022-06-07 16:55:54'),
(10, 'KS-000010', 'Pemasukan', 12000, 'Penjualan', 6000, 43000, 3, '2022-06-10 20:19:05', '2022-06-10 20:19:05'),
(44, 'KS-000011', 'Pemasukan', 3000, 'Penjualan', 1500, 46000, 3, '2022-06-14 20:32:30', '2022-06-14 20:32:30'),
(45, 'KS-000045', 'Pengeluaran', 50000, 'beli gula, teh, es batu', 0, -4000, 3, '2022-06-14 20:33:43', '2022-06-14 20:33:43'),
(46, 'KS-000046', 'Pemasukan', 27500, 'Penjualan', 15000, 23500, 3, '2022-06-14 20:52:17', '2022-06-14 20:52:17'),
(47, 'KS-000047', 'Pengeluaran', 111111, 'beli es', 0, -87611, 3, '2022-06-14 21:13:07', '2022-06-14 21:13:07'),
(48, 'KS-000048', 'Pemasukan', 3000, 'Penjualan', 1500, -84611, 3, '2022-06-14 21:39:32', '2022-06-14 21:39:32'),
(49, 'KS-000049', 'Pemasukan', 27500, 'Penjualan', 15000, -57111, 3, '2022-06-15 18:12:05', '2022-06-15 18:12:05'),
(50, 'KS-000050', 'Pemasukan', 30000, 'Penjualan', 15000, -27111, 3, '2022-06-16 07:58:40', '2022-06-16 07:58:40'),
(51, 'KS-000051', 'Pemasukan', 17500, 'Penjualan', 11500, -9611, 3, '2022-06-16 11:01:14', '2022-06-16 11:01:14'),
(52, 'KS-000052', 'Pemasukan', 15000, 'Penjualan', 10000, 5389, 3, '2022-06-16 11:12:45', '2022-06-16 11:12:45'),
(53, 'KS-000053', 'Pemasukan', 3000, 'Penjualan', 2000, 8389, 3, '2022-06-16 11:49:49', '2022-06-16 11:49:49'),
(54, 'KS-000054', 'Pengeluaran', 10000, 'beli kopi', 0, -1611, 3, '2022-06-16 12:47:11', '2022-06-16 12:47:11'),
(55, 'KS-000055', 'Pemasukan', 8500, 'Penjualan', 5000, 6889, 3, '2022-06-16 12:48:06', '2022-06-16 12:48:06'),
(56, 'KS-000056', 'Pemasukan', 5500, 'Penjualan', 3500, 12389, 3, '2022-06-17 15:07:42', '2022-06-17 15:07:42'),
(57, 'KS-000057', 'Pengeluaran', 1000, 'beli garam', 0, 11389, 3, '2022-06-17 15:08:41', '2022-06-17 15:08:41'),
(58, 'KS-000058', 'Pemasukan', 3000, 'Penjualan', 1500, 14389, 3, '2022-06-17 15:18:14', '2022-06-17 15:18:14'),
(59, 'KS-000059', 'Pemasukan', 3000, 'Penjualan', 2000, 17389, 1, '2022-06-22 09:39:40', '2022-06-22 09:39:40'),
(60, 'KS-000060', 'Pemasukan', 3000, 'Penjualan', 1500, 20389, 1, '2022-06-22 09:41:36', '2022-06-22 09:41:36'),
(61, 'KS-000061', 'Pemasukan', 3000, 'Penjualan', 2000, 23389, 1, '2022-06-22 09:41:48', '2022-06-22 09:41:48'),
(62, 'KS-000062', 'Pemasukan', 3000, 'Penjualan', 2000, 26389, 1, '2022-06-22 09:43:57', '2022-06-22 09:43:57'),
(63, 'KS-000063', 'Pemasukan', 3000, 'Penjualan', 2000, 29389, 1, '2022-06-22 09:50:32', '2022-06-22 09:50:32'),
(64, 'KS-000064', 'Pemasukan', 18000, 'Penjualan', 10000, 47389, 1, '2022-06-22 11:00:48', '2022-06-22 11:00:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoris`
--

CREATE TABLE `kategoris` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `kategoris`
--

INSERT INTO `kategoris` (`id_kategori`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(2, 'es', '2022-06-07 11:39:09', '2022-06-07 11:39:09'),
(3, 'hot', '2022-06-07 11:39:25', '2022-06-07 11:39:25'),
(4, 'snack', '2022-06-07 11:39:38', '2022-06-07 11:39:38'),
(5, 'makanan berat', '2022-06-07 11:39:55', '2022-06-07 11:39:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjangs`
--

CREATE TABLE `keranjangs` (
  `id_keranjang` int(11) NOT NULL,
  `id_produk` varchar(255) NOT NULL,
  `id_member` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL DEFAULT 0,
  `harga_jual` int(11) NOT NULL DEFAULT 0,
  `stok` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `satuan` varchar(255) DEFAULT NULL,
  `hpp` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktur dari tabel `logins`
--

CREATE TABLE `logins` (
  `id_login` int(11) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `nama` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `id_member` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `logins`
--

INSERT INTO `logins` (`id_login`, `email`, `nama`, `username`, `password`, `id_member`, `token`, `role`, `active`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 'Administrator', 'admin', '$2y$10$INo6IRmOXz4YqFhdxnzRjuqgKGaOuOlhBpxClF5V8xd1KPnmhq.9G', 0, NULL, 1, 1, NULL, '2022-06-17 14:59:59'),
(2, 'kasir@gmail.com', 'Kasir', 'kasir', '$2y$10$iTLV.WtmYghGjOSnIHJr8eTF0xFzCJTHOemBLK0tCvlpkeBgOWHk2', 0, NULL, 1, 1, '2022-05-11 09:38:59', '2022-06-17 14:52:39'),
(3, 'elsaputri790@gmail.com', 'elsa putri aliyya', 'elsaapaa_', '$2y$10$nDAbdYJCCuli4RpyzEPHguQZ595NXiH/dwpw89lAn5VmasKueHQDC', 0, NULL, 1, 1, '2022-06-06 21:58:32', '2022-06-17 15:00:53'),
(9, 'owner@gmail.com', 'ratna oesmita', 'owner', '$2y$10$99bz6iFV4hG9H6jbZGenVuvkvgkSk3/RIx40KIJ3BOfHsaXNR8Br2', 0, NULL, 2, 1, '2022-06-17 15:46:08', '2022-06-17 16:01:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `medias`
--

CREATE TABLE `medias` (
  `id_media` int(11) UNSIGNED NOT NULL,
  `media_path` varchar(255) NOT NULL,
  `id_produk` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `medias`
--

INSERT INTO `medias` (`id_media`, `media_path`, `id_produk`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'images/1655864062_2589f5169542181776fa.jpg', '1q02fge', 1, '2022-06-22 09:14:22', '2022-06-22 09:14:22', NULL),
(4, 'images/1655864086_46dc292f5b66d869edc0.jpg', '6p41yub', 1, '2022-06-22 09:14:46', '2022-06-22 09:14:46', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `members`
--

CREATE TABLE `members` (
  `id_member` int(11) NOT NULL,
  `no_member` varchar(255) DEFAULT NULL,
  `nama_member` varchar(255) NOT NULL,
  `alamat_member` text NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gambar` text DEFAULT NULL,
  `NIK` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `members`
--

INSERT INTO `members` (`id_member`, `no_member`, `nama_member`, `alamat_member`, `telepon`, `email`, `gambar`, `NIK`, `created_at`, `updated_at`) VALUES
(1, 'M0001', 'Umum', 'Purwokerto', '08123456789', 'member@gmail.com', 'unnamed.jpg', '12314121', NULL, '2022-05-09 15:42:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notas`
--

CREATE TABLE `notas` (
  `id_nota` bigint(20) NOT NULL,
  `no_nota` varchar(255) DEFAULT NULL,
  `id_member` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 0,
  `hpp` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `bayar` int(11) NOT NULL DEFAULT 0,
  `kembali` int(11) NOT NULL DEFAULT 0,
  `periode` varchar(255) DEFAULT NULL,
  `id_login` int(11) NOT NULL DEFAULT 0,
  `id_toko` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `notas`
--

INSERT INTO `notas` (`id_nota`, `no_nota`, `id_member`, `jumlah`, `hpp`, `total`, `bayar`, `kembali`, `periode`, `id_login`, `id_toko`, `created_at`, `updated_at`) VALUES
(1, '20220607000001', 1, 2, 6000, 10500, 100000, 89500, '06-2022', 3, 1, '2022-06-07 11:44:09', '2022-06-07 11:44:09'),
(2, '20220607000002', 1, 2, 3000, 5500, 5500, 0, '06-2022', 3, 1, '2022-06-07 12:03:29', '2022-06-07 12:03:29'),
(3, '20220607000003', 1, 1, 1500, 3000, 3000, 0, '06-2022', 3, 1, '2022-06-07 12:05:10', '2022-06-07 12:05:10'),
(4, '20220607000004', 1, 1, 1500, 3000, 3000, 0, '06-2022', 3, 1, '2022-06-07 12:12:15', '2022-06-07 12:12:15'),
(5, '20220607000005', 1, 1, 1500, 3000, 5000, 2000, '06-2022', 3, 1, '2022-06-07 16:51:20', '2022-06-07 16:51:20'),
(6, '20220607000006', 1, 1, 1500, 2500, 20000, 17500, '06-2022', 3, 1, '2022-06-07 16:52:02', '2022-06-07 16:52:02'),
(7, '20220607000007', 1, 1, 1500, 3000, 20000, 17000, '06-2022', 3, 1, '2022-06-07 16:52:20', '2022-06-07 16:52:20'),
(8, '20220607000008', 1, 2, 3000, 5500, 6000, 500, '06-2022', 3, 1, '2022-06-07 16:55:54', '2022-06-07 16:55:54'),
(9, '20220610000009', 1, 1, 6000, 12000, 100000, 88000, '06-2022', 3, 1, '2022-06-10 20:19:05', '2022-06-10 20:19:05'),
(10, '20220613000010', 1, 1, 4500, 9000, 10000, 1000, '06-2022', 3, 1, '2022-06-13 14:09:54', '2022-06-13 14:09:54'),
(11, '20220613000011', 1, 1, 1500, 2500, 100000, 97500, '06-2022', 3, 1, '2022-06-13 14:10:10', '2022-06-13 14:10:10'),
(12, '20220614000012', 1, 1, 1500, 3000, 5000, 2000, '06-2022', 3, 1, '2022-06-14 20:32:30', '2022-06-14 20:32:30'),
(13, '20220614000013', 1, 2, 15000, 27500, 28000, 500, '06-2022', 3, 1, '2022-06-14 20:52:17', '2022-06-14 20:52:17'),
(14, '20220614000014', 1, 1, 1500, 3000, 5000, 2000, '06-2022', 3, 1, '2022-06-14 21:39:30', '2022-06-14 21:39:30'),
(16, '20220616000015', 1, 1, 15000, 30000, 30000, 0, '06-2022', 3, 1, '2022-06-16 07:58:39', '2022-06-16 07:58:39'),
(17, '20220616000017', 1, 2, 11500, 17500, 20000, 2500, '06-2022', 3, 1, '2022-06-16 11:01:14', '2022-06-16 11:01:14'),
(18, '20220616000018', 1, 1, 10000, 15000, 20000, 5000, '06-2022', 3, 1, '2022-06-16 11:12:44', '2022-06-16 11:12:44'),
(19, '20220616000019', 1, 1, 2000, 3000, 5000, 2000, '06-2022', 3, 1, '2022-06-16 11:49:49', '2022-06-16 11:49:49'),
(20, '20220616000020', 1, 3, 5000, 8500, 10000, 1500, '06-2022', 3, 1, '2022-06-16 12:48:05', '2022-06-16 12:48:05'),
(22, '20220617000021', 1, 1, 1500, 3000, 5000, 2000, '06-2022', 3, 1, '2022-06-17 15:18:14', '2022-06-17 15:18:14'),
(24, '20220622000001', 1, 1, 1500, 3000, 5000, 2000, '06-2022', 1, 1, '2022-06-22 09:25:01', '2022-06-22 09:25:01'),
(25, '20220622000025', 1, 1, 1500, 3000, 5000, 2000, '06-2022', 1, 1, '2022-06-22 09:25:42', '2022-06-22 09:25:42'),
(26, '20220622000026', 1, 1, 2000, 3000, 5000, 2000, '06-2022', 1, 1, '2022-06-22 09:26:00', '2022-06-22 09:26:00'),
(27, '20220622000027', 1, 1, 2000, 3000, 5000, 2000, '06-2022', 1, 1, '2022-06-22 09:28:43', '2022-06-22 09:28:43'),
(28, '20220622000028', 1, 2, 4000, 6000, 10000, 4000, '06-2022', 1, 1, '2022-06-22 09:34:39', '2022-06-22 09:34:39'),
(29, '20220622000029', 1, 2, 4000, 6000, 6000, 0, '06-2022', 1, 1, '2022-06-22 09:35:37', '2022-06-22 09:35:37'),
(30, '20220622000030', 1, 1, 2000, 3000, 5000, -1000, '06-2022', 1, 1, '2022-06-22 09:38:27', '2022-06-22 09:38:27'),
(31, '20220622000031', 1, 1, 2000, 3000, 5000, 2000, '06-2022', 1, 1, '2022-06-22 09:39:40', '2022-06-22 09:39:40'),
(32, '20220622000032', 1, 1, 1500, 3000, 5000, 2000, '06-2022', 1, 1, '2022-06-22 09:41:36', '2022-06-22 09:41:36'),
(33, '20220622000033', 1, 1, 2000, 3000, 5000, 2000, '06-2022', 1, 1, '2022-06-22 09:41:48', '2022-06-22 09:41:48'),
(34, '20220622000034', 1, 1, 2000, 3000, 5000, 2000, '06-2022', 1, 1, '2022-06-22 09:43:57', '2022-06-22 09:43:57'),
(35, '20220622000035', 1, 1, 2000, 3000, 5000, 2000, '06-2022', 1, 1, '2022-06-22 09:50:31', '2022-06-22 09:50:31'),
(36, '20220622000036', 1, 3, 10000, 18000, 50000, 32000, '06-2022', 1, 1, '2022-06-22 11:00:48', '2022-06-22 11:00:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nota_items`
--

CREATE TABLE `nota_items` (
  `id_itemnota` bigint(20) NOT NULL,
  `id_produk` char(15) DEFAULT NULL,
  `id_nota` int(11) DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `nota_items`
--

INSERT INTO `nota_items` (`id_itemnota`, `id_produk`, `id_nota`, `harga_beli`, `harga_jual`, `qty`, `satuan`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, '1q02fge', 1, 1500, 3000, 1, 'gelas', 3000, '2022-06-07 11:44:09', '2022-06-07 11:44:09'),
(2, '6p41yub', 1, 1500, 2500, 3, 'gelas', 7500, '2022-06-07 11:44:09', '2022-06-07 11:44:09'),
(3, '1q02fge', 2, 1500, 3000, 1, 'gelas', 3000, '2022-06-07 12:03:29', '2022-06-07 12:03:29'),
(4, '6p41yub', 2, 1500, 2500, 1, 'gelas', 2500, '2022-06-07 12:03:29', '2022-06-07 12:03:29'),
(5, '1q02fge', 3, 1500, 3000, 1, 'gelas', 3000, '2022-06-07 12:05:10', '2022-06-07 12:05:10'),
(6, '1q02fge', 4, 1500, 3000, 1, 'gelas', 3000, '2022-06-07 12:12:15', '2022-06-07 12:12:15'),
(7, '1q02fge', 5, 1500, 3000, 1, 'gelas', 3000, '2022-06-07 16:51:20', '2022-06-07 16:51:20'),
(8, '6p41yub', 6, 1500, 2500, 1, 'gelas', 2500, '2022-06-07 16:52:02', '2022-06-07 16:52:02'),
(9, '1q02fge', 7, 1500, 3000, 1, 'gelas', 3000, '2022-06-07 16:52:20', '2022-06-07 16:52:20'),
(10, '1q02fge', 8, 1500, 3000, 1, 'gelas', 3000, '2022-06-07 16:55:54', '2022-06-07 16:55:54'),
(11, '6p41yub', 8, 1500, 2500, 1, 'gelas', 2500, '2022-06-07 16:55:54', '2022-06-07 16:55:54'),
(12, '1q02fge', 9, 1500, 3000, 4, 'gelas', 12000, '2022-06-10 20:19:05', '2022-06-10 20:19:05'),
(13, '1q02fge', 10, 1500, 3000, 3, 'gelas', 9000, '2022-06-13 14:09:54', '2022-06-13 14:09:54'),
(14, '6p41yub', 11, 1500, 2500, 1, 'gelas', 2500, '2022-06-13 14:10:11', '2022-06-13 14:10:11'),
(15, '1q02fge', 12, 1500, 3000, 1, 'gelas', 3000, '2022-06-14 20:32:30', '2022-06-14 20:32:30'),
(16, '6p41yub', 13, 1500, 2500, 5, 'gelas', 12500, '2022-06-14 20:52:17', '2022-06-14 20:52:17'),
(17, '1q02fge', 13, 1500, 3000, 5, 'gelas', 15000, '2022-06-14 20:52:17', '2022-06-14 20:52:17'),
(18, '1q02fge', 14, 1500, 3000, 1, 'gelas', 3000, '2022-06-14 21:39:31', '2022-06-14 21:39:31'),
(19, '1q02fge', 15, 1500, 3000, 5, 'gelas', 15000, '2022-06-15 18:12:05', '2022-06-15 18:12:05'),
(20, '6p41yub', 15, 1500, 2500, 5, 'gelas', 12500, '2022-06-15 18:12:05', '2022-06-15 18:12:05'),
(21, '1q02fge', 16, 1500, 3000, 10, 'gelas', 30000, '2022-06-16 07:58:39', '2022-06-16 07:58:39'),
(22, '4t10pfa', 17, 10000, 15000, 1, 'piring', 15000, '2022-06-16 11:01:14', '2022-06-16 11:01:14'),
(23, '6p41yub', 17, 1500, 2500, 1, 'gelas', 2500, '2022-06-16 11:01:14', '2022-06-16 11:01:14'),
(24, '4t10pfa', 18, 10000, 15000, 1, 'piring', 15000, '2022-06-16 11:12:45', '2022-06-16 11:12:45'),
(25, '6x45rjs', 19, 2000, 3000, 1, 'butir', 3000, '2022-06-16 11:49:49', '2022-06-16 11:49:49'),
(26, '1q02fge', 20, 1500, 3000, 1, 'gelas', 3000, '2022-06-16 12:48:05', '2022-06-16 12:48:05'),
(27, '6p41yub', 20, 1500, 2500, 1, 'gelas', 2500, '2022-06-16 12:48:05', '2022-06-16 12:48:05'),
(28, '6x45rjs', 20, 2000, 3000, 1, 'butir', 3000, '2022-06-16 12:48:05', '2022-06-16 12:48:05'),
(29, '6x45rjs', 21, 2000, 3000, 1, 'butir', 3000, '2022-06-17 15:07:41', '2022-06-17 15:07:41'),
(30, '6p41yub', 21, 1500, 2500, 1, 'gelas', 2500, '2022-06-17 15:07:41', '2022-06-17 15:07:41'),
(31, '1q02fge', 22, 1500, 3000, 1, 'gelas', 3000, '2022-06-17 15:18:14', '2022-06-17 15:18:14'),
(33, '1q02fge', 24, 1500, 3000, 1, 'gelas', 3000, '2022-06-22 09:25:02', '2022-06-22 09:25:02'),
(34, '1q02fge', 25, 1500, 3000, 1, 'gelas', 3000, '2022-06-22 09:25:42', '2022-06-22 09:25:42'),
(35, '6x45rjs', 26, 2000, 3000, 1, 'butir', 3000, '2022-06-22 09:26:01', '2022-06-22 09:26:01'),
(36, '6x45rjs', 27, 2000, 3000, 1, 'butir', 3000, '2022-06-22 09:28:43', '2022-06-22 09:28:43'),
(37, '6x45rjs', 28, 2000, 3000, 1, 'butir', 3000, '2022-06-22 09:34:39', '2022-06-22 09:34:39'),
(38, '6x45rjs', 28, 2000, 3000, 1, 'butir', 3000, '2022-06-22 09:34:39', '2022-06-22 09:34:39'),
(39, '6x45rjs', 29, 2000, 3000, 1, 'butir', 3000, '2022-06-22 09:35:37', '2022-06-22 09:35:37'),
(40, '6x45rjs', 29, 2000, 3000, 1, 'butir', 3000, '2022-06-22 09:35:37', '2022-06-22 09:35:37'),
(41, '6x45rjs', 30, 2000, 3000, 1, 'butir', 3000, '2022-06-22 09:38:28', '2022-06-22 09:38:28'),
(42, '6x45rjs', 31, 2000, 3000, 1, 'butir', 3000, '2022-06-22 09:39:40', '2022-06-22 09:39:40'),
(43, '1q02fge', 32, 1500, 3000, 1, 'gelas', 3000, '2022-06-22 09:41:36', '2022-06-22 09:41:36'),
(44, '6x45rjs', 33, 2000, 3000, 1, 'butir', 3000, '2022-06-22 09:41:48', '2022-06-22 09:41:48'),
(45, '6x45rjs', 34, 2000, 3000, 1, 'butir', 3000, '2022-06-22 09:43:57', '2022-06-22 09:43:57'),
(46, '7g56ngh', 35, 2000, 3000, 1, 'bungkus', 3000, '2022-06-22 09:50:32', '2022-06-22 09:50:32'),
(47, '1a12ael', 36, 3000, 5000, 1, 'bungkus', 5000, '2022-06-22 11:00:48', '2022-06-22 11:00:48'),
(48, '1l76bmx', 36, 5000, 10000, 1, 'piring', 10000, '2022-06-22 11:00:48', '2022-06-22 11:00:48'),
(49, '1q02fge', 36, 2000, 3000, 1, 'gelas', 3000, '2022-06-22 11:00:48', '2022-06-22 11:00:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ppn_pajaks`
--

CREATE TABLE `ppn_pajaks` (
  `id_ppn` bigint(11) NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_login` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produks`
--

CREATE TABLE `produks` (
  `id_produk` char(15) NOT NULL DEFAULT '',
  `barcode` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL DEFAULT '',
  `merk` varchar(255) NOT NULL,
  `harga_beli` varchar(255) NOT NULL,
  `harga_jual` varchar(255) NOT NULL,
  `satuan_produk` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `active` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `produks`
--

INSERT INTO `produks` (`id_produk`, `barcode`, `id_kategori`, `nama_produk`, `merk`, `harga_beli`, `harga_jual`, `satuan_produk`, `deskripsi`, `stok`, `active`, `created_at`, `updated_at`) VALUES
('1a12ael', '00003', 5, 'Nasi Kucing', '-', '3000', '5000', 'bungkus', 'Nasi Bungkus dengan lauk bandeng dan sambel', 19, 1, '2022-06-22 10:57:40', '2022-06-22 11:00:48'),
('1l76bmx', '0001', 4, 'Kentang Goreng', '-', '5000', '10000', 'piring', 'Satu porsi kentang goreng yang dilengkapi dengan saos dan mayonaise', 49, 1, '2022-06-22 10:35:01', '2022-06-22 11:00:48'),
('1q02fge', '1111', 2, 'es nutrisari', 'Nutrisari', '2000', '3000', 'gelas', 'nutrisari jeruk nipis, jambu, dll', 9, 1, '2022-06-07 11:42:04', '2022-06-22 11:00:48'),
('1x76lmu', '0002', 4, 'Roti Bakar', '-', '5000', '7000', 'piring', 'roti bakar dengan beraneka macam selai\n(coklat, kacang, blueberry, strawberry, nanas, meses)', 12, 1, '2022-06-22 10:38:33', '2022-06-22 10:41:21'),
('2l31hak', '0003', 4, 'Sosis Bakar', '-', '8000', '12000', 'tusuk', 'Sosis bakar yang disajikan dengan saos dan mayonaise', 20, 1, '2022-06-22 10:39:33', '2022-06-22 10:41:45'),
('2p63osw', '1112', 2, 'Es chocolatos', 'Chocolatos', '2500', '6000', 'gelas', 'Sebungkus Chocolatos yang dipadukan dengan es batu', 24, 1, '2022-06-22 10:18:35', '2022-06-22 10:43:11'),
('2r19dlu', '00005', 5, 'Nasi goreng', '-', '3000', '5000', 'bungkus', 'Nasi goreng bungkus', 20, 1, '2022-06-22 10:59:32', '2022-06-22 10:59:32'),
('2z74lhb', '00001', 5, 'Indomie goreng/rebus', 'Indomie, Mie Sedap', '3000', '6000', 'piring', 'Indomie tanpa telur', 50, 1, '2022-06-22 10:30:57', '2022-06-22 10:51:01'),
('3p87hxl', '10101', 3, 'Wedang Jahe', '-', '2000', '5000', 'gelas', 'Jahe bakar gepuk yang diseduh dengan air panas', 24, 1, '2022-06-22 10:25:06', '2022-06-22 10:46:05'),
('3r61hxm', '10102', 3, 'Kopi Robusta', 'Kopi Racik', '3000', '6000', 'gelas', 'Kopi hitam Racikan yang diseduh dengan air panas', 100, 1, '2022-06-22 10:11:24', '2022-06-22 10:46:24'),
('4h53cwy', '1116', 2, 'Dalgona Cofee', '-', '4000', '10000', 'gelas', 'Kopi kocok yang dipadukan dengan susu cair dan es batu', 12, 1, '2022-06-22 10:09:44', '2022-06-22 10:47:27'),
('4q21rzn', '10103', 3, 'Wedang Uwuh', '-', '5000', '7000', 'gelas', 'Racikan rempah-rempah yang disajikan dalam segelas air panas', 12, 1, '2022-06-22 10:28:14', '2022-06-22 10:48:10'),
('5s41jya', '00004', 5, 'Nasi Oseng', '-', '3000', '5000', 'bungkus', 'Nasi bungkus dengan lauk oseng sayuran', 20, 1, '2022-06-22 10:58:33', '2022-06-22 10:58:33'),
('6d83nvr', '10104', 3, 'Teh Posi(4orang)', 'Teh racikan', '5000', '10000', 'gelas', 'Satu porsi teh panas yang disajikan dalam teko', 12, 1, '2022-06-22 10:27:05', '2022-06-22 10:48:35'),
('6l23qya', '10105', 3, 'Kopii Jahee', 'Kopi Racikan', '3000', '6000', 'gelas', 'Perpaduan antara kopi dan jahe yang dituangkan dalam cangkir', 100, 1, '2022-06-22 10:16:28', '2022-06-22 10:48:57'),
('6p41yub', '1113', 2, 'es teh manis', 'teh', '1500', '2500', 'gelas', 'es teh manis', 80, 1, '2022-06-07 11:40:57', '2022-06-22 10:43:36'),
('7o18jhj', '10106', 3, 'Good Day Freeze', 'Good day', '2500', '6000', 'gelas', 'Sebungkus Good day Freeze yang dipadukan dengan es batu', 24, 1, '2022-06-22 10:20:20', '2022-06-22 10:49:32'),
('7q90pac', '00002', 5, 'Intel(Indomie Telur) goreng/rebus', 'Indomie/Mie sedap', '5000', '8000', 'piring', 'Indomie goreng/rebus dengan menggunakan telur', 48, 1, '2022-06-22 10:33:02', '2022-06-22 10:51:24'),
('7v46typ', '10107', 3, 'Kopi Arabica', 'Kopi racikan', '3000', '6000', 'gelas', 'Kopi yang diracik dalam secangkir air panas', 100, 1, '2022-06-22 10:13:06', '2022-06-22 10:50:06'),
('7x09zwe', '1114', 2, 'Soda Gembira', '-', '6000', '10000', 'gelas', 'Es Soda yang dipadukan dengan Susu Kental Manis', 20, 1, '2022-06-22 10:07:33', '2022-06-22 10:44:04'),
('7y02gby', '1115', 2, 'ES Good Day', 'Good Day', '1000', '3000', 'gelas', 'Es Good Day dengan rasa yang lengkap\n(Good day coklat, cappucino, dll)', 24, 1, '2022-06-22 10:24:00', '2022-06-22 10:44:24'),
('9e15jix', '0004', 4, 'Otak-Otak Goreng', '-', '5000', '10000', 'tusuk', 'Otak-Otak goreng yang disajikan dengan saos dan mayonaise', 15, 1, '2022-06-22 10:36:19', '2022-06-22 10:42:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuans`
--

CREATE TABLE `satuans` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `group_setting` varchar(100) NOT NULL,
  `variable_setting` varchar(255) NOT NULL,
  `value_setting` text NOT NULL,
  `deskripsi_setting` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `group_setting`, `variable_setting`, `value_setting`, `deskripsi_setting`, `updated_at`) VALUES
(1, 'general', 'app_name', 'ANGKRINGAN 69 POGOG ROAD', 'App Name', '2022-06-17 15:12:00'),
(2, 'general', 'app_version', '1.1', 'App Version', '2022-06-17 15:12:07'),
(3, 'general', 'app_release', '2022/03/01 18:22:14', 'App Release', '2022-06-17 14:09:15'),
(4, 'general', 'app_developer', 'ELSA PUTRI ALIYYA', 'App Developer', '2022-06-17 14:09:28'),
(5, 'image', 'img_logo', 'assets/images/1655449802_fa1b43fc748694ad1285.jpg', 'Logo', '2022-06-17 14:10:02'),
(6, 'image', 'img_favicon', 'assets/images/1655449816_f10cd5d9c5909c7a67c4.jpg', 'Favicon', '2022-06-17 14:10:16'),
(7, 'image', 'img_background', 'assets/images/1655449829_8bc7837299bb16ffc984.jpg', 'Background', '2022-06-17 14:10:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id_supplier` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tokos`
--

CREATE TABLE `tokos` (
  `id_toko` int(11) NOT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `alamat_toko` text NOT NULL,
  `telp` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `tokos`
--

INSERT INTO `tokos` (`id_toko`, `nama_toko`, `alamat_toko`, `telp`, `email`, `nama_pemilik`, `updated_at`) VALUES
(1, 'Angkringan 69 Pogog Road', 'Pogog, Mantren, Kec.Punung, Kabupaten Pacitan, Jawa Timur 63553', '087722889257', 'angkringan69@gmail.com', 'Ratna Oesmita', '2022-06-16 08:38:16');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kas_saldos`
--
ALTER TABLE `kas_saldos`
  ADD PRIMARY KEY (`id_kas`);

--
-- Indeks untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `keranjangs`
--
ALTER TABLE `keranjangs`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indeks untuk tabel `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeks untuk tabel `medias`
--
ALTER TABLE `medias`
  ADD PRIMARY KEY (`id_media`);

--
-- Indeks untuk tabel `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id_member`);

--
-- Indeks untuk tabel `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indeks untuk tabel `nota_items`
--
ALTER TABLE `nota_items`
  ADD PRIMARY KEY (`id_itemnota`);

--
-- Indeks untuk tabel `ppn_pajaks`
--
ALTER TABLE `ppn_pajaks`
  ADD PRIMARY KEY (`id_ppn`);

--
-- Indeks untuk tabel `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `satuans`
--
ALTER TABLE `satuans`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tokos`
--
ALTER TABLE `tokos`
  ADD PRIMARY KEY (`id_toko`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `backups`
--
ALTER TABLE `backups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kas_saldos`
--
ALTER TABLE `kas_saldos`
  MODIFY `id_kas` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `keranjangs`
--
ALTER TABLE `keranjangs`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `logins`
--
ALTER TABLE `logins`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `medias`
--
ALTER TABLE `medias`
  MODIFY `id_media` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `members`
--
ALTER TABLE `members`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `notas`
--
ALTER TABLE `notas`
  MODIFY `id_nota` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `nota_items`
--
ALTER TABLE `nota_items`
  MODIFY `id_itemnota` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `tokos`
--
ALTER TABLE `tokos`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
