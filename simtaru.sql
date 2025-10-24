-- phpMyAdmin SQL Dump
-- version 5.2.2deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2025 at 02:52 AM
-- Server version: 8.4.6-0ubuntu0.25.04.3
-- PHP Version: 8.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simtaru`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('simtaru-cache-091981864ccf7a0d2bc897d2f3a768b1', 'i:1;', 1760786349),
('simtaru-cache-091981864ccf7a0d2bc897d2f3a768b1:timer', 'i:1760786349;', 1760786349),
('simtaru-cache-0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'i:1;', 1761005968),
('simtaru-cache-0ade7c2cf97f75d009975f4d720d1fa6c19f4897:timer', 'i:1761005968;', 1761005968),
('simtaru-cache-218d20bc4b8ebe246eca93c53939f01c', 'i:1;', 1761006160),
('simtaru-cache-218d20bc4b8ebe246eca93c53939f01c:timer', 'i:1761006160;', 1761006160),
('simtaru-cache-5a01240e7957633ca2e857fdb4fd13ed', 'i:1;', 1760786288),
('simtaru-cache-5a01240e7957633ca2e857fdb4fd13ed:timer', 'i:1760786288;', 1760786288),
('simtaru-cache-690d9541eb046759912eaf67ffb69cc5', 'i:1;', 1761005994),
('simtaru-cache-690d9541eb046759912eaf67ffb69cc5:timer', 'i:1761005994;', 1761005994),
('simtaru-cache-86d551112e04d09622dae161edc37792', 'i:1;', 1760576007),
('simtaru-cache-86d551112e04d09622dae161edc37792:timer', 'i:1760576007;', 1760576007),
('simtaru-cache-89624bcfe283a2ed2db87abb4af7db23', 'i:1;', 1760786183),
('simtaru-cache-89624bcfe283a2ed2db87abb4af7db23:timer', 'i:1760786183;', 1760786183),
('simtaru-cache-949aed209d6a5a212d4e67ad9f173114', 'i:1;', 1760785313),
('simtaru-cache-949aed209d6a5a212d4e67ad9f173114:timer', 'i:1760785313;', 1760785313),
('simtaru-cache-94cb7eb9da5aefeb24ccb5bd5a2fa527', 'i:1;', 1761005076),
('simtaru-cache-94cb7eb9da5aefeb24ccb5bd5a2fa527:timer', 'i:1761005076;', 1761005076),
('simtaru-cache-97f026d38e2064666814b78db2beec08', 'i:1;', 1760575729),
('simtaru-cache-97f026d38e2064666814b78db2beec08:timer', 'i:1760575728;', 1760575728),
('simtaru-cache-9e9ed453514598c46655b94f2f97dda1', 'i:1;', 1760924652),
('simtaru-cache-9e9ed453514598c46655b94f2f97dda1:timer', 'i:1760924652;', 1760924652),
('simtaru-cache-b1d5781111d84f7b3fe45a0852e59758cd7a87e5', 'i:1;', 1761006129),
('simtaru-cache-b1d5781111d84f7b3fe45a0852e59758cd7a87e5:timer', 'i:1761006129;', 1761006129),
('simtaru-cache-c6a4b53a261ec4b38b284bcec4c7d064', 'i:1;', 1761006283),
('simtaru-cache-c6a4b53a261ec4b38b284bcec4c7d064:timer', 'i:1761006283;', 1761006283),
('simtaru-cache-dinda@simtaru-harum.com|103.151.37.248', 'i:1;', 1760924103),
('simtaru-cache-dinda@simtaru-harum.com|103.151.37.248:timer', 'i:1760924103;', 1760924103),
('simtaru-cache-dinda@simtaru-harum.com|103.151.37.56', 'i:1;', 1760924652),
('simtaru-cache-dinda@simtaru-harum.com|103.151.37.56:timer', 'i:1760924652;', 1760924652),
('simtaru-cache-ed387288d1cf3a04e5afbcb04a42ea37', 'i:1;', 1761005869),
('simtaru-cache-ed387288d1cf3a04e5afbcb04a42ea37:timer', 'i:1761005869;', 1761005869),
('simtaru-cache-f256a581d376b95c3c209aa533dc2a09', 'i:1;', 1760924103),
('simtaru-cache-f256a581d376b95c3c209aa533dc2a09:timer', 'i:1760924103;', 1760924103),
('simtaru-cache-f6144a8cbe761ecf67093be6bd98c817', 'i:1;', 1760924630),
('simtaru-cache-f6144a8cbe761ecf67093be6bd98c817:timer', 'i:1760924630;', 1760924630),
('simtaru-cache-fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f', 'i:4;', 1761006332),
('simtaru-cache-fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1f:timer', 'i:1761006332;', 1761006332),
('simtaru-cache-fe7bc4be8c3f9f1d86d6a4fbf9452f41', 'i:1;', 1760924664),
('simtaru-cache-fe7bc4be8c3f9f1d86d6a4fbf9452f41:timer', 'i:1760924664;', 1760924664),
('simtaru-cache-rina@simtaru-harum.com|103.151.37.56', 'i:1;', 1760924630),
('simtaru-cache-rina@simtaru-harum.com|103.151.37.56:timer', 'i:1760924630;', 1760924630);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disposisis`
--

CREATE TABLE `disposisis` (
  `id` bigint UNSIGNED NOT NULL,
  `permohonan_id` bigint UNSIGNED NOT NULL,
  `tahapan_id` bigint UNSIGNED NOT NULL,
  `pemberi_id` bigint UNSIGNED NOT NULL,
  `penerima_id` bigint UNSIGNED NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `tanggal_disposisi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `layanan_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layanan_id` bigint UNSIGNED NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_selesai` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disposisis`
--

INSERT INTO `disposisis` (`id`, `permohonan_id`, `tahapan_id`, `pemberi_id`, `penerima_id`, `catatan`, `tanggal_disposisi`, `updated_by`, `created_at`, `updated_at`, `layanan_type`, `layanan_id`, `is_done`, `tgl_selesai`) VALUES
(4, 4, 1, 8, 9, 'ee', '2025-09-19 11:16:35', NULL, '2025-09-19 11:16:35', '2025-09-19 11:16:35', 'App\\Models\\Skrk', 4, 0, NULL),
(6, 4, 2, 9, 6, 'sudah selesai', '2025-09-19 13:17:07', NULL, '2025-09-19 13:17:07', '2025-09-19 13:17:07', 'App\\Models\\Skrk', 4, 0, NULL),
(8, 6, 1, 11, 9, 'Gaos kerjakan', '2025-09-21 10:45:17', NULL, '2025-09-21 10:45:17', '2025-09-21 10:45:17', 'App\\Models\\Skrk', 6, 0, NULL),
(9, 7, 1, 11, 9, 'kerjakan', '2025-09-22 01:45:42', NULL, '2025-09-22 01:45:42', '2025-09-22 01:45:42', 'App\\Models\\Skrk', 7, 0, NULL),
(10, 7, 2, 2, 6, NULL, '2025-09-22 07:32:52', NULL, '2025-09-22 07:32:52', '2025-09-22 07:32:52', 'App\\Models\\Skrk', 7, 0, NULL),
(11, 8, 1, 11, 9, 'Silahkan di kerjakan', '2025-09-24 11:42:24', 2, '2025-09-24 11:42:24', '2025-10-03 13:42:52', 'App\\Models\\Skrk', 8, 0, NULL),
(12, 9, 1, 8, 9, 'surveyy', '2025-09-26 01:21:05', 7, '2025-09-26 01:21:05', '2025-09-29 00:38:52', 'App\\Models\\Skrk', 9, 0, NULL),
(13, 9, 2, 9, 6, 'analisis ', '2025-09-26 01:49:47', NULL, '2025-09-26 01:49:47', '2025-09-26 01:49:47', 'App\\Models\\Skrk', 9, 0, NULL),
(14, 10, 1, 8, 9, 'Gaos survey', '2025-09-30 00:08:53', NULL, '2025-09-30 00:08:53', '2025-09-30 00:08:53', 'App\\Models\\Skrk', 10, 0, NULL),
(15, 10, 2, 9, 10, 'Oke', '2025-09-30 00:45:17', NULL, '2025-09-30 00:45:17', '2025-09-30 00:45:17', 'App\\Models\\Skrk', 10, 0, NULL),
(16, 10, 3, 9, 10, NULL, '2025-09-30 12:54:42', NULL, '2025-09-30 12:54:42', '2025-09-30 12:54:42', 'App\\Models\\Skrk', 10, 0, NULL),
(19, 11, 1, 8, 9, 'Belum lengkap berkasnya', '2025-10-03 02:49:36', 8, '2025-10-03 02:49:36', '2025-10-03 02:50:06', 'App\\Models\\Skrk', 11, 0, NULL),
(20, 12, 1, 8, 12, 'survey', '2025-10-07 01:41:14', NULL, '2025-10-07 01:41:14', '2025-10-07 01:41:14', 'App\\Models\\Skrk', 12, 0, NULL),
(21, 13, 1, 8, 9, 'Silahkan disruvey', '2025-10-09 06:51:24', 8, '2025-10-09 06:51:24', '2025-10-09 07:13:38', 'App\\Models\\Skrk', 13, 1, '2025-10-09'),
(22, 13, 2, 7, 10, 'hhh', '2025-10-09 07:34:55', NULL, '2025-10-09 06:55:51', '2025-10-09 07:34:55', 'App\\Models\\Skrk', 13, 1, '2025-10-09'),
(23, 13, 1, 7, 9, 'Perbaiki sedikit', '2025-10-09 07:06:52', NULL, '2025-10-09 07:06:52', '2025-10-09 07:13:38', 'App\\Models\\Skrk', 13, 1, '2025-10-09'),
(24, 13, 2, 7, 10, 'perbaiki', '2025-10-09 07:19:37', NULL, '2025-10-09 07:19:37', '2025-10-09 07:35:58', 'App\\Models\\Skrk', 13, 1, '2025-10-09'),
(25, 13, 2, 7, 10, 'perbaiki', '2025-10-09 07:21:08', NULL, '2025-10-09 07:21:08', '2025-10-09 07:35:58', 'App\\Models\\Skrk', 13, 1, '2025-10-09'),
(26, 13, 2, 7, 10, 'perbaiki', '2025-10-09 07:21:14', NULL, '2025-10-09 07:21:14', '2025-10-09 07:35:58', 'App\\Models\\Skrk', 13, 1, '2025-10-09'),
(27, 13, 2, 7, 10, 'fr', '2025-10-09 07:31:39', NULL, '2025-10-09 07:31:39', '2025-10-09 07:35:58', 'App\\Models\\Skrk', 13, 1, '2025-10-09'),
(28, 13, 2, 7, 10, 'fr', '2025-10-09 07:34:24', NULL, '2025-10-09 07:34:24', '2025-10-09 07:35:58', 'App\\Models\\Skrk', 13, 1, '2025-10-09'),
(29, 13, 3, 7, 8, 'Lanjutkan proses cetak Dokumen SKRK', '2025-10-09 07:37:16', NULL, '2025-10-09 07:37:16', '2025-10-09 07:47:00', 'App\\Models\\Skrk', 13, 1, '2025-10-09'),
(30, 14, 1, 8, 12, 'survey ', '2025-10-13 07:38:12', 8, '2025-10-13 07:38:12', '2025-10-13 08:50:44', 'App\\Models\\Skrk', 14, 1, '2025-10-13'),
(31, 14, 2, 12, 10, 'analisis', '2025-10-13 08:34:06', NULL, '2025-10-13 08:34:06', '2025-10-13 23:48:32', 'App\\Models\\Skrk', 14, 1, '2025-10-13'),
(32, 15, 1, 8, 12, 'Silahkan dikerjakan', '2025-10-13 12:57:04', NULL, '2025-10-13 12:57:04', '2025-10-13 13:06:52', 'App\\Models\\Skrk', 15, 1, '2025-10-13'),
(33, 15, 2, 12, 6, 'Oke', '2025-10-13 12:59:46', NULL, '2025-10-13 12:59:46', '2025-10-13 13:04:02', 'App\\Models\\Skrk', 15, 1, '2025-10-13'),
(34, 15, 1, 7, 12, 'Ada yang salah di survey', '2025-10-13 13:04:55', NULL, '2025-10-13 13:04:55', '2025-10-13 13:06:52', 'App\\Models\\Skrk', 15, 1, '2025-10-13'),
(35, 15, 2, 7, 6, 'Kurang di rapat', '2025-10-13 13:05:13', NULL, '2025-10-13 13:05:13', '2025-10-13 13:07:27', 'App\\Models\\Skrk', 15, 1, '2025-10-13'),
(36, 15, 3, 7, 8, 'Lanjutkan proses cetak Dokumen SKRK', '2025-10-13 13:11:07', NULL, '2025-10-13 13:11:07', '2025-10-13 13:12:09', 'App\\Models\\Skrk', 15, 1, '2025-10-13'),
(37, 16, 1, 11, 9, 'Silahkan di survey', '2025-10-13 21:29:34', NULL, '2025-10-13 21:29:34', '2025-10-13 21:40:13', 'App\\Models\\Skrk', 16, 1, '2025-10-13'),
(38, 16, 2, 9, 10, 'Kerjakan', '2025-10-13 21:31:38', NULL, '2025-10-13 21:31:38', '2025-10-13 21:36:17', 'App\\Models\\Skrk', 16, 1, '2025-10-13'),
(39, 16, 1, 7, 9, 'tidak beres', '2025-10-13 21:37:06', NULL, '2025-10-13 21:37:06', '2025-10-13 21:40:13', 'App\\Models\\Skrk', 16, 1, '2025-10-13'),
(40, 16, 2, 7, 10, 'kurang rapi', '2025-10-13 21:37:32', NULL, '2025-10-13 21:37:32', '2025-10-13 21:40:52', 'App\\Models\\Skrk', 16, 1, '2025-10-13'),
(41, 16, 3, 7, 11, 'Lanjutkan proses cetak Dokumen SKRK', '2025-10-13 21:41:47', NULL, '2025-10-13 21:41:47', '2025-10-13 21:43:52', 'App\\Models\\Skrk', 16, 1, '2025-10-13'),
(42, 14, 2, 7, 10, 'perbaiki pola ruang', '2025-10-13 23:52:44', NULL, '2025-10-13 23:52:44', '2025-10-14 01:13:07', 'App\\Models\\Skrk', 14, 1, '2025-10-14'),
(43, 17, 1, 8, 9, 'Survey', '2025-10-14 00:06:48', NULL, '2025-10-14 00:06:48', '2025-10-14 00:12:36', 'App\\Models\\Skrk', 17, 1, '2025-10-14'),
(44, 17, 2, 9, 10, 'sudah oke', '2025-10-14 00:11:49', NULL, '2025-10-14 00:11:49', '2025-10-14 00:19:23', 'App\\Models\\Skrk', 17, 1, '2025-10-14'),
(45, 17, 2, 7, 10, 'Belum rapi', '2025-10-14 00:23:07', NULL, '2025-10-14 00:23:07', '2025-10-14 00:24:33', 'App\\Models\\Skrk', 17, 1, '2025-10-14'),
(46, 17, 3, 7, 8, 'Lanjutkan proses cetak Dokumen SKRK', '2025-10-14 00:26:52', NULL, '2025-10-14 00:26:52', '2025-10-14 00:30:59', 'App\\Models\\Skrk', 17, 1, '2025-10-14'),
(47, 18, 1, 7, 9, 'Perbaiki BA Rapat SKRK ', '2025-10-15 10:48:28', NULL, '2025-10-15 10:28:55', '2025-10-15 10:48:28', 'App\\Models\\Skrk', 18, 1, '2025-10-15'),
(48, 18, 2, 9, 6, NULL, '2025-10-15 10:36:13', NULL, '2025-10-15 10:36:13', '2025-10-15 10:42:36', 'App\\Models\\Skrk', 18, 1, '2025-10-15'),
(49, 18, 1, 7, 9, 'Perbaiki', '2025-10-15 10:43:35', NULL, '2025-10-15 10:43:35', '2025-10-15 10:45:01', 'App\\Models\\Skrk', 18, 1, '2025-10-15'),
(50, 18, 2, 7, 6, NULL, '2025-10-15 10:43:54', NULL, '2025-10-15 10:43:54', '2025-10-15 10:46:59', 'App\\Models\\Skrk', 18, 1, '2025-10-15'),
(51, 18, 3, 7, 8, 'Lanjutkan proses cetak Dokumen SKRK', '2025-10-15 10:49:40', NULL, '2025-10-15 10:49:40', '2025-10-15 10:52:23', 'App\\Models\\Skrk', 18, 1, '2025-10-15'),
(52, 19, 1, 11, 9, 'Dilanjutkan survey', '2025-10-15 11:14:18', NULL, '2025-10-15 11:14:18', '2025-10-15 12:41:06', 'App\\Models\\Skrk', 19, 1, '2025-10-15'),
(53, 19, 2, 9, 10, 'Sudah oke', '2025-10-15 11:27:06', NULL, '2025-10-15 11:27:06', '2025-10-15 12:36:19', 'App\\Models\\Skrk', 19, 1, '2025-10-15'),
(54, 19, 1, 7, 9, 'Salah Hari', '2025-10-15 12:38:07', NULL, '2025-10-15 12:38:07', '2025-10-15 12:41:06', 'App\\Models\\Skrk', 19, 1, '2025-10-15'),
(55, 19, 2, 7, 10, 'Fotonya dihapus saja', '2025-10-15 12:38:51', NULL, '2025-10-15 12:38:51', '2025-10-15 12:43:52', 'App\\Models\\Skrk', 19, 1, '2025-10-15'),
(56, 19, 3, 7, 11, 'Lanjutkan proses cetak Dokumen SKRK', '2025-10-15 12:45:49', NULL, '2025-10-15 12:45:49', '2025-10-15 12:45:49', 'App\\Models\\Skrk', 19, 0, NULL),
(57, 20, 1, 8, 12, 'survey ya', '2025-10-15 23:47:57', NULL, '2025-10-15 23:47:57', '2025-10-15 23:55:44', 'App\\Models\\Skrk', 20, 1, '2025-10-15'),
(58, 20, 2, 12, 6, 'analisis ', '2025-10-15 23:54:57', NULL, '2025-10-15 23:54:57', '2025-10-16 00:16:44', 'App\\Models\\Skrk', 20, 1, '2025-10-16'),
(59, 20, 3, 7, 8, 'Lanjutkan proses cetak Dokumen SKRK', '2025-10-16 00:40:31', NULL, '2025-10-16 00:40:31', '2025-10-16 00:42:37', 'App\\Models\\Skrk', 20, 1, '2025-10-16'),
(60, 21, 1, 8, 9, NULL, '2025-10-18 10:54:08', NULL, '2025-10-18 10:54:08', '2025-10-18 11:16:56', 'App\\Models\\Skrk', 21, 1, '2025-10-18'),
(61, 21, 2, 9, 10, NULL, '2025-10-18 11:00:32', NULL, '2025-10-18 11:00:32', '2025-10-18 11:12:48', 'App\\Models\\Skrk', 21, 1, '2025-10-18'),
(62, 21, 1, 7, 9, 'salah hari', '2025-10-18 11:14:10', NULL, '2025-10-18 11:14:10', '2025-10-18 11:16:56', 'App\\Models\\Skrk', 21, 1, '2025-10-18'),
(63, 21, 3, 7, 8, 'Lanjutkan proses cetak Dokumen SKRK', '2025-10-18 11:18:01', NULL, '2025-10-18 11:18:01', '2025-10-18 11:19:00', 'App\\Models\\Skrk', 21, 1, '2025-10-18'),
(64, 22, 1, 8, 9, NULL, '2025-10-21 00:06:40', NULL, '2025-10-21 00:06:40', '2025-10-21 00:18:39', 'App\\Models\\Skrk', 22, 1, '2025-10-21'),
(65, 22, 2, 9, 10, 'silahkan kerjakan', '2025-10-21 00:11:34', NULL, '2025-10-21 00:11:34', '2025-10-21 00:14:42', 'App\\Models\\Skrk', 22, 1, '2025-10-21'),
(66, 22, 1, 7, 9, 'salah hari survey', '2025-10-21 00:15:52', NULL, '2025-10-21 00:15:52', '2025-10-21 00:18:39', 'App\\Models\\Skrk', 22, 1, '2025-10-21'),
(67, 22, 2, 7, 10, 'Salah nama', '2025-10-21 00:16:35', NULL, '2025-10-21 00:16:35', '2025-10-21 00:21:19', 'App\\Models\\Skrk', 22, 1, '2025-10-21'),
(68, 22, 3, 7, 8, 'Lanjutkan proses cetak Dokumen SKRK', '2025-10-21 00:23:28', NULL, '2025-10-21 00:23:28', '2025-10-21 00:24:45', 'App\\Models\\Skrk', 22, 1, '2025-10-21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itr`
--

CREATE TABLE `itr` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
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
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `nama`, `keterangan`, `created_at`, `updated_at`, `kode`) VALUES
(1, 'SKRK', 'Surat Keterangan Rencana Kota', '2025-09-15 13:44:17', '2025-09-15 13:44:17', 'SKRK'),
(2, 'KKPR Berusaha', 'Kesesuaian Kegiatan Pemanfaatan Ruang (Berusaha)', '2025-09-15 13:44:32', '2025-09-15 13:44:32', 'KKPR-B'),
(3, 'KKPR Non Berusaha', 'Kesesuaian Kegiatan Pemanfaatan Ruang (Non Berusaha)', '2025-09-15 13:44:47', '2025-09-15 13:44:47', 'KKPR-NB'),
(4, 'ITR', 'Informasi Tata Ruang', '2025-09-15 13:44:57', '2025-09-15 13:44:57', 'ITR');

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
(4, '2025_07_21_003654_add_two_factor_columns_to_users_table', 1),
(5, '2025_07_21_003736_create_personal_access_tokens_table', 1),
(6, '2025_07_22_045622_create_registrasis_table', 1),
(7, '2025_07_22_054809_create_layanans_table', 1),
(8, '2025_07_22_065331_create_permohonans_table', 1),
(9, '2025_07_23_033109_add_kode_registrasi', 1),
(10, '2025_08_12_020625_create_riwayat_permohonans_table', 1),
(11, '2025_08_14_005235_create_persyaratan_berkas_table', 1),
(12, '2025_08_14_005250_create_permohonan_berkas_table', 1),
(13, '2025_08_17_183822_create_tahapans_table', 1),
(14, '2025_08_17_184149_create_disposisis_table', 1),
(15, '2025_08_17_184429_update_persyaratan_berkas_table', 1),
(16, '2025_09_01_010106_add_upload_berkas_persyaratan', 1),
(17, '2025_09_01_073019_create_permohonan_skrk_table', 1),
(18, '2025_09_01_073457_update_permohonan_table', 1),
(19, '2025_09_02_004925_add_kode_layanan', 1),
(20, '2025_09_11_022509_add_kode_berkas_persyaratan', 1),
(21, '2025_09_12_015127_add_some_column_skrk', 1),
(22, '2025_09_16_001609_add_email_registrasi', 2),
(23, '2025_09_16_020113_change_koordinat_column_to_json_in_permohonans', 2),
(24, '2025_09_16_075641_add_berkas_permohonan_to_permohonans', 3),
(25, '2025_09_16_203847_add_is_survey_is_analis_on_permohonan', 3),
(26, '2025_09_17_032121_add_is_prioritas_to_permohonans', 3),
(27, '2025_09_18_011546_move_kbli_to_permohonans', 4),
(28, '2025_09_21_113240_add_berkas_kuasa_permohonan', 5),
(29, '2025_09_23_012958_add_verified_by_on_permohonan_berkas', 6),
(30, '2025_09_23_041352_add_batas_administratif_skrk', 6),
(31, '2025_09_24_023647_add_layanan_on_disposisi', 7),
(32, '2025_09_25_023033_move_permohonan_to_regist', 7),
(33, '2025_09_30_070109_add_no_surat_permohonan', 8),
(35, '2025_09_30_220448_add_status_disposisi', 9),
(36, '2025_10_06_042203_add_unique_to_kode_in_registrasi_table', 10),
(37, '2025_10_06_042648_add_upload_flags_to_skrk_table', 10),
(38, '2025_10_09_032529_create_itrs_table', 11),
(39, '2025_10_10_085449_add_versi_to_permohonan_berkas_table', 11);

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
-- Table structure for table `permohonan`
--

CREATE TABLE `permohonan` (
  `id` bigint UNSIGNED NOT NULL,
  `registrasi_id` bigint UNSIGNED NOT NULL,
  `layanan_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `berkas_ktp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luas_tanah` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `no_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_pengerjaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berkas_nib` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berkas_penguasaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berkas_permohonan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_prioritas` tinyint(1) NOT NULL DEFAULT '0',
  `status_modal` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kbli` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul_kbli` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berkas_kuasa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan`
--

INSERT INTO `permohonan` (`id`, `registrasi_id`, `layanan_id`, `status`, `keterangan`, `created_by`, `updated_by`, `created_at`, `updated_at`, `berkas_ktp`, `alamat_pemohon`, `npwp`, `luas_tanah`, `tgl_selesai`, `no_dokumen`, `waktu_pengerjaan`, `berkas_nib`, `berkas_penguasaan`, `berkas_permohonan`, `is_prioritas`, `status_modal`, `kbli`, `judul_kbli`, `berkas_kuasa`, `is_done`) VALUES
(4, 4, 1, 'process', NULL, 2, 2, '2025-09-19 11:16:35', '2025-09-19 22:34:01', 'berkas_ktp/REG-0004.pdf', 'Jalan Madiun I/C Taman Baru Mataram', '12321321', '23232', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'PMDN', '123', 'bangunan', NULL, 0),
(6, 6, 1, 'Proses Survey', 'Berkas sudah oke', 11, 11, '2025-09-21 10:45:17', '2025-09-21 10:45:17', NULL, 'Jalan Bangil VI/I Mataram', '12.3432.312.121', '1230', NULL, NULL, NULL, 'berkas_nib/REG-0003.pdf', 'berkas_penguasaan/REG-0003.pdf', 'berkas_permohonan/REG-0003.pdf', 0, 'PMDN', '5671611', 'Kaveling', 'berkas_kuasa/REG-0003.pdf', 0),
(7, 7, 1, 'Proses Analisa', 'sudah lengkap ', 11, 11, '2025-09-22 01:45:42', '2025-09-22 07:32:52', 'berkas_ktp/REG-0004.pdf', 'Jalan Bangil VI/I Mataram', '12321321', '213123', NULL, NULL, NULL, 'berkas_nib/REG-0004.pdf', 'berkas_penguasaan/REG-0004.pdf', 'berkas_permohonan/REG-0004.pdf', 0, 'PMDN', '2312', 'bangunan', 'berkas_kuasa/REG-0004.pdf', 0),
(8, 9, 1, 'Proses Survey', 'Berkas sudah lengkap', 11, 2, '2025-09-24 11:42:24', '2025-10-03 13:42:52', 'berkas_ktp/REG-0006.pdf', 'Jalan Angsoka Nomor 13 Mataram', '123.567.345', '200', NULL, NULL, NULL, 'berkas_nib/REG-0006.pdf', 'berkas_penguasaan/REG-0006.pdf', 'berkas_permohonan/REG-0006.pdf', 0, 'PMDN', '5466', 'Akomodasi Lainnya', 'berkas_kuasa/REG-0006.pdf', 0),
(9, 10, 1, 'Proses Verifikasi', 'sudah lengkap', 8, 7, '2025-09-26 01:21:05', '2025-09-29 00:38:52', 'berkas_ktp/REG-0007.png', 'Jl. Cilinaya no. 61 A Grisak', '-', '372', NULL, NULL, NULL, 'berkas_nib/REG-0007.pdf', 'berkas_penguasaan/REG-0007.pdf', 'berkas_permohonan/REG-0007.pdf', 0, 'PMDN', '55900', 'Penyediaan Akomodasi Lainnya', 'berkas_kuasa/REG-0007.pdf', 0),
(10, 13, 1, 'Cetak Dokumen', 'Kurang KTP', 8, 8, '2025-09-30 00:08:53', '2025-10-01 06:27:08', NULL, 'hjkjkhjffui', '-', '100', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'PMDN', '44343', 'desf', NULL, 0),
(11, 14, 1, 'Proses Survey', 'Sudah lengkap', 8, 8, '2025-10-03 02:49:36', '2025-10-03 02:50:06', 'berkas_ktp/REG-0011.pdf', 'Jalan Madiun I/C Taman Baru Mataram', '-', '1000', NULL, NULL, NULL, 'berkas_nib/REG-0011.pdf', 'berkas_penguasaan/REG-0011.pdf', 'berkas_permohonan/REG-0011.pdf', 0, 'PMDN', '530001', 'Perdagangan dan Jasa Eceran', NULL, 0),
(12, 15, 1, 'Proses Survey', 'sudah bisa disurvey', 8, 8, '2025-10-07 01:41:14', '2025-10-07 01:41:14', 'berkas_ktp/REG-0012.pdf', 'Perumahan Crystal Regency, Jl. Bung Karno, Mataram', '21212121', '372', NULL, NULL, NULL, 'berkas_nib/REG-0012.pdf', NULL, 'berkas_permohonan/REG-0012.pdf', 0, 'PMDN', '55900', 'Penyediaan Akomodasi Lainnya', 'berkas_kuasa/REG-0012.pdf', 0),
(13, 16, 1, 'completed', 'Sudah Oke', 8, 8, '2025-10-09 06:51:24', '2025-10-11 08:18:38', 'berkas_ktp/REG-2025-0013.pdf', 'Jalan Sriwijaya Nomor 13', '-', '1200', '2025-10-09', '324242', '1', 'berkas_nib/REG-2025-0013.pdf', 'berkas_penguasaan/REG-2025-0013.pdf', 'berkas_permohonan/REG-2025-0013.pdf', 0, 'PMDN', '530001', 'Akomodasi Lainnya', 'berkas_kuasa/REG-2025-0013.pdf', 1),
(14, 17, 1, 'Proses Verifikasi', 'disurvey', 8, 8, '2025-10-13 07:38:12', '2025-10-13 23:48:32', 'berkas_ktp/REG-0014-SKRK-10-2025.pdf', 'Jl. Hanoman No. 05 Kr. Tulamben Cakranegara', '21212121', '372', NULL, NULL, NULL, 'berkas_nib/REG-0014-SKRK-10-2025.pdf', 'berkas_penguasaan/REG-0014-SKRK-10-2025.pdf', 'berkas_permohonan/REG-0014-SKRK-10-2025.pdf', 0, 'PMDN', '55900', 'Penyediaan Akomodasi Lainnya', NULL, 0),
(15, 11, 1, 'completed', 'Sudah oke', 8, 8, '2025-10-13 12:57:04', '2025-10-13 13:12:09', 'berkas_ktp/REG-0008.pdf', 'Jalan Madiun I/C Taman Baru Mataram', '-', '23232', '2025-10-14', '324242', '34', 'berkas_nib/REG-0008.pdf', 'berkas_penguasaan/REG-0008.pdf', 'berkas_permohonan/REG-0008.pdf', 0, 'PMDN', '3423423', 'Akomodasi Lainnya', 'berkas_kuasa/REG-0008.pdf', 1),
(16, 18, 1, 'completed', 'Sudah oke', 11, 11, '2025-10-13 21:29:34', '2025-10-13 21:43:52', 'berkas_ktp/REG-2026-SKRK-10-2025.pdf', 'Jalan Madiun I/C Taman Baru Mataram', '-', '321', '2025-10-16', '324242', '3', 'berkas_nib/REG-2026-SKRK-10-2025.pdf', 'berkas_penguasaan/REG-2026-SKRK-10-2025.pdf', 'berkas_permohonan/REG-2026-SKRK-10-2025.pdf', 0, 'PMDN', '530001', 'Akomodasi lainnya', 'berkas_kuasa/REG-2026-SKRK-10-2025.pdf', 1),
(17, 12, 1, 'completed', 'Lanjutkan', 8, 8, '2025-10-14 00:06:48', '2025-10-14 00:30:59', 'berkas_ktp/REG-0009.pdf', 'Jalan Madiun I/C Taman Baru Mataram', '-', '1230', '2025-10-14', '324242', '15', 'berkas_nib/REG-0009.pdf', 'berkas_penguasaan/REG-0009.pdf', 'berkas_permohonan/REG-0009.pdf', 0, 'PMDN', '5671611', 'Akomodasi Lainnya', 'berkas_kuasa/REG-0009.pdf', 1),
(18, 30, 1, 'completed', NULL, 8, 8, '2025-10-15 10:28:55', '2025-10-15 10:52:23', 'berkas_ktp/REG-2028-SKRK-10-2025.pdf', 'Jalan Madiun I/C Taman Baru Mataram', '12321321', '23232', '2025-10-23', '324242', '9', 'berkas_nib/REG-2028-SKRK-10-2025.pdf', 'berkas_penguasaan/REG-2028-SKRK-10-2025.pdf', 'berkas_permohonan/REG-2028-SKRK-10-2025.pdf', 0, 'PMDN', '5466', 'bangunan', 'berkas_kuasa/REG-2028-SKRK-10-2025.pdf', 1),
(19, 31, 1, 'completed', 'Sudah Lengkap', 11, 11, '2025-10-15 11:14:18', '2025-10-15 12:46:30', 'berkas_ktp/REG-2029-SKRK-10-2025.pdf', 'Jalan Semanggi Nomor 19 Mataram', '198672631281', '1000', '2025-10-16', '324242', '2', 'berkas_nib/REG-2029-SKRK-10-2025.pdf', 'berkas_penguasaan/REG-2029-SKRK-10-2025.pdf', 'berkas_permohonan/REG-2029-SKRK-10-2025.pdf', 0, 'PMDN', '5671611', 'Akomodasi Lainnya', 'berkas_kuasa/REG-2029-SKRK-10-2025.pdf', 1),
(20, 33, 1, 'completed', 'survey', 8, 8, '2025-10-15 23:47:57', '2025-10-16 00:42:37', 'berkas_ktp/REG-2031-SKRK-10-2025.pdf', 'jl airlangga no 70', '242342', '678', '2025-10-23', 'rrrrrrrrrrrrrrr', '10', 'berkas_nib/REG-2031-SKRK-10-2025.pdf', 'berkas_penguasaan/REG-2031-SKRK-10-2025.pdf', 'berkas_permohonan/REG-2031-SKRK-10-2025.pdf', 0, 'PMDN', '55900', 'Penyediaan Akomodasi Lainnya', 'berkas_kuasa/REG-2031-SKRK-10-2025.pdf', 1),
(21, 32, 1, 'completed', NULL, 8, 8, '2025-10-18 10:54:08', '2025-10-18 11:19:00', 'berkas_ktp/REG-2030-SKRK-10-2025.pdf', 'Jalan Madiun I/C Taman Baru Mataram', '343412141', '1232141', '2025-10-20', '324242', '7', 'berkas_nib/REG-2030-SKRK-10-2025.pdf', 'berkas_penguasaan/REG-2030-SKRK-10-2025.pdf', 'berkas_permohonan/REG-2030-SKRK-10-2025.pdf', 0, 'PMDN', '530001', 'bangunan', 'berkas_kuasa/REG-2030-SKRK-10-2025.pdf', 1),
(22, 34, 1, 'completed', NULL, 8, 8, '2025-10-21 00:06:40', '2025-10-21 00:24:45', 'berkas_ktp/REG-2032-SKRK-10-2025.pdf', 'Jalan Madiun I/C Taman Baru Mataram', '-', '2345342', '2025-10-23', '324242', '4', 'berkas_nib/REG-2032-SKRK-10-2025.pdf', 'berkas_penguasaan/REG-2032-SKRK-10-2025.pdf', 'berkas_permohonan/REG-2032-SKRK-10-2025.pdf', 0, 'PMDN', '5671611', 'Kaveling', 'berkas_kuasa/REG-2032-SKRK-10-2025.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_berkas`
--

CREATE TABLE `permohonan_berkas` (
  `id` bigint UNSIGNED NOT NULL,
  `permohonan_id` bigint UNSIGNED NOT NULL,
  `persyaratan_berkas_id` bigint UNSIGNED NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_by` bigint UNSIGNED DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT NULL,
  `status` enum('menunggu','diterima','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `catatan_verifikator` text COLLATE utf8mb4_unicode_ci,
  `versi` enum('draft','final') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_berkas`
--

INSERT INTO `permohonan_berkas` (`id`, `permohonan_id`, `persyaratan_berkas_id`, `file_path`, `uploaded_by`, `uploaded_at`, `status`, `catatan_verifikator`, `versi`, `created_at`, `updated_at`, `verified_by`, `verified_at`) VALUES
(1, 4, 1, 'skrk_form_survey/REG-0004/REG-0004_1a_survey_skrk.pdf', 9, '2025-09-19 22:18:54', 'diterima', NULL, 'draft', '2025-09-19 13:17:07', '2025-09-29 06:28:57', '7', '2025-09-29 06:28:57'),
(2, 4, 2, 'skrk_form_survey/REG-0004/REG-0004_1b_ba_survey_skrk.docx', 9, '2025-09-19 22:18:54', 'diterima', NULL, 'draft', '2025-09-19 13:17:07', '2025-09-29 06:29:05', '7', '2025-09-29 06:29:05'),
(3, 4, 5, 'skrk_form_survey/REG-0004/REG-0004_3_kajian_skrk.docx', 6, '2025-09-19 22:22:45', 'diterima', NULL, 'draft', '2025-09-19 22:22:45', '2025-09-29 06:29:13', '7', '2025-09-29 06:29:13'),
(4, 7, 1, 'skrk_form_survey/REG-0004/REG-0004_1a_survey_skrk.pdf', 2, '2025-09-22 07:32:52', 'diterima', NULL, 'draft', '2025-09-22 07:32:52', '2025-09-22 07:35:09', NULL, NULL),
(5, 7, 2, 'skrk_form_survey/REG-0004/REG-0004_1b_ba_survey_skrk.pdf', 2, '2025-09-22 07:32:52', 'diterima', NULL, 'draft', '2025-09-22 07:32:52', '2025-09-22 07:35:10', NULL, NULL),
(6, 7, 3, 'skrk_form_survey/REG-0004/REG-0004_2a_ba_rapat_skrk.docx', 2, '2025-09-22 07:35:03', 'diterima', NULL, 'draft', '2025-09-22 07:35:03', '2025-09-22 07:35:13', NULL, NULL),
(7, 7, 4, 'skrk_form_survey/REG-0004/REG-0004_2b_notulen_rapat_skrk.docx', 2, '2025-09-22 07:35:03', 'diterima', NULL, 'draft', '2025-09-22 07:35:03', '2025-09-22 07:35:16', NULL, NULL),
(8, 7, 5, 'skrk_form_survey/REG-0004/REG-0004_3_kajian_skrk.pdf', 6, '2025-09-22 08:33:26', 'diterima', NULL, 'draft', '2025-09-22 08:33:26', '2025-09-23 23:25:27', '2', '2025-09-23 23:25:27'),
(9, 7, 6, 'skrk_form_survey/REG-0004/REG-0004_4_dokumen_skrk.pdf', 6, '2025-09-22 08:33:26', 'diterima', NULL, 'draft', '2025-09-22 08:33:26', '2025-09-23 23:25:34', '2', '2025-09-23 23:25:34'),
(10, 9, 6, 'skrk_form_survey/REG-0007/REG-0007_4_dokumen_skrk.jpeg', 6, '2025-09-26 02:51:20', 'diterima', NULL, 'draft', '2025-09-26 02:51:20', '2025-09-26 03:03:04', '1', '2025-09-26 03:03:04'),
(11, 10, 1, 'skrk_form_survey/REG-0010/REG-0010_1a_survey_skrk.docx', 9, '2025-09-30 12:54:24', 'diterima', NULL, 'draft', '2025-09-30 12:54:24', '2025-09-30 13:51:23', '7', '2025-09-30 13:51:23'),
(12, 10, 2, 'skrk_form_survey/REG-0010/REG-0010_1b_ba_survey_skrk.docx', 9, '2025-09-30 12:54:24', 'diterima', NULL, 'draft', '2025-09-30 12:54:24', '2025-09-30 13:51:30', '7', '2025-09-30 13:51:30'),
(13, 10, 3, 'skrk/REG-0010/REG-0010_2a_ba_rapat_skrk.pdf', 10, '2025-09-30 13:50:35', 'diterima', NULL, 'draft', '2025-09-30 13:50:35', '2025-09-30 13:51:57', '7', '2025-09-30 13:51:57'),
(14, 10, 4, 'skrk/REG-0010/REG-0010_2b_notulen_rapat_skrk.pdf', 10, '2025-10-01 06:24:36', 'diterima', NULL, 'draft', '2025-09-30 13:50:35', '2025-10-01 06:26:35', '7', '2025-10-01 06:26:35'),
(15, 10, 5, 'skrk/REG-0010/REG-0010_3_kajian_skrk.pdf', 10, '2025-10-01 06:24:36', 'diterima', NULL, 'draft', '2025-09-30 13:50:35', '2025-10-01 06:26:42', '7', '2025-10-01 06:26:42'),
(16, 10, 6, 'skrk/REG-0010/REG-0010_4_dokumen_skrk.pdf', 10, '2025-10-01 06:24:36', 'diterima', NULL, 'draft', '2025-10-01 06:24:36', '2025-10-01 06:26:57', '7', '2025-10-01 06:26:57'),
(17, 13, 1, 'skrk/REG-2025-0013/REG-2025-0013_1a_survey_skrk.pdf', 9, '2025-10-09 06:55:19', 'diterima', NULL, 'draft', '2025-10-09 06:55:19', '2025-10-09 07:06:24', '7', '2025-10-09 07:06:24'),
(18, 13, 2, 'skrk/REG-2025-0013/REG-2025-0013_1b_ba_survey_skrk.pdf', 9, '2025-10-09 06:55:19', 'diterima', 'Perbaiki sedikit', 'draft', '2025-10-09 06:55:19', '2025-10-09 07:14:14', '7', '2025-10-09 07:14:14'),
(19, 13, 5, 'skrk/REG-2025-0013/REG-2025-0013_3_kajian_skrk.pdf', 10, '2025-10-09 07:03:10', 'diterima', 'hhh', 'draft', '2025-10-09 07:03:10', '2025-10-09 07:36:54', '7', '2025-10-09 07:36:54'),
(20, 13, 6, 'skrk/REG-2025-0013/REG-2025-0013_4_dokumen_skrk.pdf', 10, '2025-10-09 07:03:10', 'diterima', 'fr', 'draft', '2025-10-09 07:03:10', '2025-10-09 07:37:05', '7', '2025-10-09 07:37:05'),
(21, 13, 1, 'skrk/REG-2025-0013/REG-2025-0013_1a_survey_skrk.pdf', 1, '2025-10-11 08:18:38', 'diterima', NULL, 'final', '2025-10-11 08:18:38', '2025-10-11 08:18:38', NULL, NULL),
(22, 14, 1, 'skrk/REG-0014-SKRK-10-2025/REG-0014-SKRK-10-2025_1a_survey_skrk.docx', 1, '2025-10-13 08:49:20', 'diterima', NULL, 'draft', '2025-10-13 08:49:20', '2025-10-13 23:50:16', '7', '2025-10-13 23:50:16'),
(23, 14, 2, 'skrk/REG-0014-SKRK-10-2025/REG-0014-SKRK-10-2025_1b_ba_survey_skrk.docx', 12, '2025-10-13 08:50:18', 'diterima', NULL, 'draft', '2025-10-13 08:50:18', '2025-10-13 23:50:29', '7', '2025-10-13 23:50:29'),
(24, 15, 1, 'skrk/REG-0008/REG-0008_1a_survey_skrk.docx', 12, '2025-10-13 12:59:34', 'diterima', NULL, 'draft', '2025-10-13 12:59:34', '2025-10-13 13:04:37', '7', '2025-10-13 13:04:37'),
(25, 15, 2, 'skrk/REG-0008/REG-0008_1b_ba_survey_skrk.docx', 12, '2025-10-13 12:59:34', 'diterima', 'Ada yang salah di survey', 'draft', '2025-10-13 12:59:34', '2025-10-13 13:07:57', '7', '2025-10-13 13:07:57'),
(26, 15, 3, 'skrk/REG-0008/REG-0008_2a_ba_rapat_skrk.docx', 6, '2025-10-13 13:03:11', 'diterima', 'Kurang di rapat', 'draft', '2025-10-13 13:03:11', '2025-10-13 13:08:06', '7', '2025-10-13 13:08:06'),
(27, 15, 4, 'skrk/REG-0008/REG-0008_2b_notulen_rapat_skrk.docx', 6, '2025-10-13 13:03:11', 'diterima', NULL, 'draft', '2025-10-13 13:03:11', '2025-10-13 13:05:21', '7', '2025-10-13 13:05:21'),
(28, 15, 5, 'skrk/REG-0008/REG-0008_3_kajian_skrk.docx', 6, '2025-10-13 13:03:11', 'diterima', NULL, 'draft', '2025-10-13 13:03:11', '2025-10-13 13:05:29', '7', '2025-10-13 13:05:29'),
(29, 15, 6, 'skrk/REG-0008/REG-0008_4_dokumen_skrk.docx', 6, '2025-10-13 13:03:11', 'diterima', NULL, 'draft', '2025-10-13 13:03:11', '2025-10-13 13:05:36', '7', '2025-10-13 13:05:36'),
(30, 15, 1, 'skrk/REG-0008/REG-0008_1a_survey_skrk.pdf', 8, '2025-10-13 13:12:09', 'diterima', NULL, 'final', '2025-10-13 13:12:09', '2025-10-13 13:12:09', NULL, NULL),
(31, 15, 2, 'skrk/REG-0008/REG-0008_1b_ba_survey_skrk.pdf', 8, '2025-10-13 13:12:09', 'diterima', NULL, 'final', '2025-10-13 13:12:09', '2025-10-13 13:12:09', NULL, NULL),
(32, 15, 3, 'skrk/REG-0008/REG-0008_2a_ba_rapat_skrk.pdf', 8, '2025-10-13 13:12:09', 'diterima', NULL, 'final', '2025-10-13 13:12:09', '2025-10-13 13:12:09', NULL, NULL),
(33, 15, 4, 'skrk/REG-0008/REG-0008_2b_notulen_rapat_skrk.pdf', 8, '2025-10-13 13:12:09', 'diterima', NULL, 'final', '2025-10-13 13:12:09', '2025-10-13 13:12:09', NULL, NULL),
(34, 15, 5, 'skrk/REG-0008/REG-0008_3_kajian_skrk.pdf', 8, '2025-10-13 13:12:09', 'diterima', NULL, 'final', '2025-10-13 13:12:09', '2025-10-13 13:12:09', NULL, NULL),
(35, 15, 6, 'skrk/REG-0008/REG-0008_4_dokumen_skrk.pdf', 8, '2025-10-13 13:12:09', 'diterima', NULL, 'final', '2025-10-13 13:12:09', '2025-10-13 13:12:09', NULL, NULL),
(36, 15, 7, 'skrk/REG-0008/REG-0008_5_dokumen_skrk_fix.pdf', 8, '2025-10-13 13:12:09', 'diterima', NULL, 'final', '2025-10-13 13:12:09', '2025-10-13 13:12:09', NULL, NULL),
(37, 16, 1, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_1a_survey_skrk.docx', 9, '2025-10-13 21:38:34', 'diterima', 'tidak beres', 'draft', '2025-10-13 21:31:16', '2025-10-13 21:41:30', '7', '2025-10-13 21:41:30'),
(38, 16, 2, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_1b_ba_survey_skrk.docx', 9, '2025-10-13 21:31:16', 'diterima', NULL, 'draft', '2025-10-13 21:31:16', '2025-10-13 21:37:15', '7', '2025-10-13 21:37:15'),
(39, 16, 3, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_2a_ba_rapat_skrk.docx', 10, '2025-10-13 21:36:10', 'diterima', 'kurang rapi', 'draft', '2025-10-13 21:36:10', '2025-10-13 21:41:39', '7', '2025-10-13 21:41:39'),
(40, 16, 4, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_2b_notulen_rapat_skrk.docx', 10, '2025-10-13 21:36:10', 'diterima', NULL, 'draft', '2025-10-13 21:36:10', '2025-10-13 21:37:39', '7', '2025-10-13 21:37:39'),
(41, 16, 5, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_3_kajian_skrk.docx', 10, '2025-10-13 21:36:11', 'diterima', NULL, 'draft', '2025-10-13 21:36:11', '2025-10-13 21:37:47', '7', '2025-10-13 21:37:47'),
(42, 16, 6, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_4_dokumen_skrk.docx', 10, '2025-10-13 21:36:11', 'diterima', NULL, 'draft', '2025-10-13 21:36:11', '2025-10-13 21:37:54', '7', '2025-10-13 21:37:54'),
(43, 16, 1, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_1a_survey_skrk.pdf', 11, '2025-10-13 21:43:52', 'diterima', NULL, 'final', '2025-10-13 21:43:52', '2025-10-13 21:43:52', NULL, NULL),
(44, 16, 2, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_1b_ba_survey_skrk.pdf', 11, '2025-10-13 21:43:52', 'diterima', NULL, 'final', '2025-10-13 21:43:52', '2025-10-13 21:43:52', NULL, NULL),
(45, 16, 3, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_2a_ba_rapat_skrk.pdf', 11, '2025-10-13 21:43:52', 'diterima', NULL, 'final', '2025-10-13 21:43:52', '2025-10-13 21:43:52', NULL, NULL),
(46, 16, 4, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_2b_notulen_rapat_skrk.pdf', 11, '2025-10-13 21:43:52', 'diterima', NULL, 'final', '2025-10-13 21:43:52', '2025-10-13 21:43:52', NULL, NULL),
(47, 16, 5, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_3_kajian_skrk.pdf', 11, '2025-10-13 21:43:52', 'diterima', NULL, 'final', '2025-10-13 21:43:52', '2025-10-13 21:43:52', NULL, NULL),
(48, 16, 6, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_4_dokumen_skrk.pdf', 11, '2025-10-13 21:43:52', 'diterima', NULL, 'final', '2025-10-13 21:43:52', '2025-10-13 21:43:52', NULL, NULL),
(49, 16, 7, 'skrk/REG-2026-SKRK-10-2025/REG-2026-SKRK-10-2025_5_dokumen_skrk_fix.pdf', 11, '2025-10-13 21:43:52', 'diterima', NULL, 'final', '2025-10-13 21:43:52', '2025-10-13 21:43:52', NULL, NULL),
(50, 14, 3, 'skrk/REG-0014-SKRK-10-2025/REG-0014-SKRK-10-2025_2a_ba_rapat_skrk.docx', 10, '2025-10-13 23:48:12', 'diterima', NULL, 'draft', '2025-10-13 23:48:12', '2025-10-13 23:50:41', '7', '2025-10-13 23:50:41'),
(51, 14, 4, 'skrk/REG-0014-SKRK-10-2025/REG-0014-SKRK-10-2025_2b_notulen_rapat_skrk.docx', 10, '2025-10-13 23:48:12', 'diterima', NULL, 'draft', '2025-10-13 23:48:12', '2025-10-13 23:50:53', '7', '2025-10-13 23:50:53'),
(52, 14, 5, 'skrk/REG-0014-SKRK-10-2025/REG-0014-SKRK-10-2025_3_kajian_skrk.docx', 10, '2025-10-13 23:48:12', 'diterima', NULL, 'draft', '2025-10-13 23:48:12', '2025-10-13 23:52:28', '7', '2025-10-13 23:52:28'),
(53, 14, 6, 'skrk/REG-0014-SKRK-10-2025/REG-0014-SKRK-10-2025_4_dokumen_skrk.docx', 10, '2025-10-13 23:48:12', 'ditolak', 'perbaiki pola ruang', 'draft', '2025-10-13 23:48:12', '2025-10-13 23:52:44', NULL, NULL),
(54, 17, 1, 'skrk/REG-0009/REG-0009_1a_survey_skrk.docx', 9, '2025-10-14 00:11:29', 'diterima', NULL, 'draft', '2025-10-14 00:11:29', '2025-10-14 00:22:34', '7', '2025-10-14 00:22:34'),
(55, 17, 2, 'skrk/REG-0009/REG-0009_1b_ba_survey_skrk.docx', 9, '2025-10-14 00:11:29', 'diterima', NULL, 'draft', '2025-10-14 00:11:29', '2025-10-14 00:22:53', '7', '2025-10-14 00:22:53'),
(56, 17, 3, 'skrk/REG-0009/REG-0009_2a_ba_rapat_skrk.docx', 10, '2025-10-14 00:19:14', 'diterima', 'Belum rapi', 'draft', '2025-10-14 00:19:14', '2025-10-14 00:26:44', '7', '2025-10-14 00:26:44'),
(57, 17, 4, 'skrk/REG-0009/REG-0009_2b_notulen_rapat_skrk.docx', 10, '2025-10-14 00:19:14', 'diterima', NULL, 'draft', '2025-10-14 00:19:14', '2025-10-14 00:23:16', '7', '2025-10-14 00:23:16'),
(58, 17, 5, 'skrk/REG-0009/REG-0009_3_kajian_skrk.docx', 10, '2025-10-14 00:19:14', 'diterima', NULL, 'draft', '2025-10-14 00:19:14', '2025-10-14 00:23:24', '7', '2025-10-14 00:23:24'),
(59, 17, 6, 'skrk/REG-0009/REG-0009_4_dokumen_skrk.docx', 10, '2025-10-14 00:19:14', 'diterima', NULL, 'draft', '2025-10-14 00:19:14', '2025-10-14 00:23:32', '7', '2025-10-14 00:23:32'),
(60, 17, 1, 'skrk/REG-0009/REG-0009_1a_survey_skrk.pdf', 8, '2025-10-14 00:30:59', 'diterima', NULL, 'final', '2025-10-14 00:30:59', '2025-10-14 00:30:59', NULL, NULL),
(61, 17, 2, 'skrk/REG-0009/REG-0009_1b_ba_survey_skrk.pdf', 8, '2025-10-14 00:30:59', 'diterima', NULL, 'final', '2025-10-14 00:30:59', '2025-10-14 00:30:59', NULL, NULL),
(62, 17, 3, 'skrk/REG-0009/REG-0009_2a_ba_rapat_skrk.pdf', 8, '2025-10-14 00:30:59', 'diterima', NULL, 'final', '2025-10-14 00:30:59', '2025-10-14 00:30:59', NULL, NULL),
(63, 17, 4, 'skrk/REG-0009/REG-0009_2b_notulen_rapat_skrk.pdf', 8, '2025-10-14 00:30:59', 'diterima', NULL, 'final', '2025-10-14 00:30:59', '2025-10-14 00:30:59', NULL, NULL),
(64, 17, 5, 'skrk/REG-0009/REG-0009_3_kajian_skrk.pdf', 8, '2025-10-14 00:30:59', 'diterima', NULL, 'final', '2025-10-14 00:30:59', '2025-10-14 00:30:59', NULL, NULL),
(65, 17, 6, 'skrk/REG-0009/REG-0009_4_dokumen_skrk.pdf', 8, '2025-10-14 00:30:59', 'diterima', NULL, 'final', '2025-10-14 00:30:59', '2025-10-14 00:30:59', NULL, NULL),
(66, 17, 7, 'skrk/REG-0009/REG-0009_5_dokumen_skrk_fix.pdf', 8, '2025-10-14 00:30:59', 'diterima', NULL, 'final', '2025-10-14 00:30:59', '2025-10-14 00:30:59', NULL, NULL),
(67, 18, 1, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_1a_survey_skrk.docx', 9, '2025-10-15 10:36:04', 'diterima', 'Perbaiki BA Rapat SKRK ', 'draft', '2025-10-15 10:36:04', '2025-10-15 10:49:25', '7', '2025-10-15 10:49:25'),
(68, 18, 2, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_1b_ba_survey_skrk.docx', 9, '2025-10-15 10:36:04', 'diterima', NULL, 'draft', '2025-10-15 10:36:04', '2025-10-15 10:43:43', '7', '2025-10-15 10:43:43'),
(69, 18, 3, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_2a_ba_rapat_skrk.docx', 6, '2025-10-15 10:42:29', 'diterima', NULL, 'draft', '2025-10-15 10:42:29', '2025-10-15 10:49:34', '7', '2025-10-15 10:49:34'),
(70, 18, 4, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_2b_notulen_rapat_skrk.docx', 6, '2025-10-15 10:42:29', 'diterima', NULL, 'draft', '2025-10-15 10:42:29', '2025-10-15 10:44:02', '7', '2025-10-15 10:44:02'),
(71, 18, 5, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_3_kajian_skrk.docx', 6, '2025-10-15 10:42:29', 'diterima', NULL, 'draft', '2025-10-15 10:42:29', '2025-10-15 10:44:10', '7', '2025-10-15 10:44:10'),
(72, 18, 6, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_4_dokumen_skrk.docx', 6, '2025-10-15 10:42:29', 'diterima', NULL, 'draft', '2025-10-15 10:42:29', '2025-10-15 10:44:17', '7', '2025-10-15 10:44:17'),
(73, 18, 1, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_1a_survey_skrk.pdf', 8, '2025-10-15 10:52:23', 'diterima', NULL, 'final', '2025-10-15 10:52:23', '2025-10-15 10:52:23', NULL, NULL),
(74, 18, 2, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_1b_ba_survey_skrk.pdf', 8, '2025-10-15 10:52:23', 'diterima', NULL, 'final', '2025-10-15 10:52:23', '2025-10-15 10:52:23', NULL, NULL),
(75, 18, 3, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_2a_ba_rapat_skrk.pdf', 8, '2025-10-15 10:52:23', 'diterima', NULL, 'final', '2025-10-15 10:52:23', '2025-10-15 10:52:23', NULL, NULL),
(76, 18, 4, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_2b_notulen_rapat_skrk.pdf', 8, '2025-10-15 10:52:23', 'diterima', NULL, 'final', '2025-10-15 10:52:23', '2025-10-15 10:52:23', NULL, NULL),
(77, 18, 5, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_3_kajian_skrk.pdf', 8, '2025-10-15 10:52:23', 'diterima', NULL, 'final', '2025-10-15 10:52:23', '2025-10-15 10:52:23', NULL, NULL),
(78, 18, 6, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_4_dokumen_skrk.pdf', 8, '2025-10-15 10:52:23', 'diterima', NULL, 'final', '2025-10-15 10:52:23', '2025-10-15 10:52:23', NULL, NULL),
(79, 18, 7, 'skrk/REG-2028-SKRK-10-2025/REG-2028-SKRK-10-2025_5_dokumen_skrk_fix.pdf', 8, '2025-10-15 10:52:23', 'diterima', NULL, 'final', '2025-10-15 10:52:23', '2025-10-15 10:52:23', NULL, NULL),
(80, 19, 1, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_1a_survey_skrk.docx', 9, '2025-10-15 12:40:59', 'diterima', 'Salah Hari', 'draft', '2025-10-15 11:26:50', '2025-10-15 12:45:33', '7', '2025-10-15 12:45:33'),
(81, 19, 2, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_1b_ba_survey_skrk.docx', 9, '2025-10-15 11:26:50', 'diterima', NULL, 'draft', '2025-10-15 11:26:50', '2025-10-15 12:38:19', '7', '2025-10-15 12:38:19'),
(82, 19, 5, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_3_kajian_skrk.docx', 10, '2025-10-15 12:43:47', 'diterima', 'Fotonya dihapus saja', 'draft', '2025-10-15 12:36:14', '2025-10-15 12:45:42', '7', '2025-10-15 12:45:42'),
(83, 19, 6, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_4_dokumen_skrk.docx', 10, '2025-10-15 12:36:14', 'diterima', NULL, 'draft', '2025-10-15 12:36:14', '2025-10-15 12:39:00', '7', '2025-10-15 12:39:00'),
(84, 19, 1, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_1a_survey_skrk.pdf', 7, '2025-10-15 12:46:30', 'diterima', NULL, 'final', '2025-10-15 12:46:30', '2025-10-15 12:46:30', NULL, NULL),
(85, 19, 2, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_1b_ba_survey_skrk.pdf', 7, '2025-10-15 12:46:30', 'diterima', NULL, 'final', '2025-10-15 12:46:30', '2025-10-15 12:46:30', NULL, NULL),
(86, 19, 3, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_2a_ba_rapat_skrk.pdf', 7, '2025-10-15 12:46:30', 'diterima', NULL, 'final', '2025-10-15 12:46:30', '2025-10-15 12:46:30', NULL, NULL),
(87, 19, 4, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_2b_notulen_rapat_skrk.pdf', 7, '2025-10-15 12:46:30', 'diterima', NULL, 'final', '2025-10-15 12:46:30', '2025-10-15 12:46:30', NULL, NULL),
(88, 19, 5, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_3_kajian_skrk.pdf', 7, '2025-10-15 12:46:30', 'diterima', NULL, 'final', '2025-10-15 12:46:30', '2025-10-15 12:46:30', NULL, NULL),
(89, 19, 6, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_4_dokumen_skrk.pdf', 7, '2025-10-15 12:46:30', 'diterima', NULL, 'final', '2025-10-15 12:46:30', '2025-10-15 12:46:30', NULL, NULL),
(90, 19, 7, 'skrk/REG-2029-SKRK-10-2025/REG-2029-SKRK-10-2025_5_dokumen_skrk_fix.pdf', 7, '2025-10-15 12:46:30', 'diterima', NULL, 'final', '2025-10-15 12:46:30', '2025-10-15 12:46:30', NULL, NULL),
(91, 20, 1, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_1a_survey_skrk.docx', 12, '2025-10-15 23:54:02', 'diterima', NULL, 'draft', '2025-10-15 23:54:02', '2025-10-16 00:39:23', '7', '2025-10-16 00:39:23'),
(92, 20, 2, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_1b_ba_survey_skrk.docx', 12, '2025-10-15 23:54:02', 'diterima', NULL, 'draft', '2025-10-15 23:54:02', '2025-10-16 00:39:33', '7', '2025-10-16 00:39:33'),
(93, 20, 3, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_2a_ba_rapat_skrk.docx', 6, '2025-10-16 00:16:13', 'diterima', NULL, 'draft', '2025-10-16 00:16:13', '2025-10-16 00:39:44', '7', '2025-10-16 00:39:44'),
(94, 20, 4, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_2b_notulen_rapat_skrk.docx', 6, '2025-10-16 00:16:13', 'diterima', NULL, 'draft', '2025-10-16 00:16:13', '2025-10-16 00:39:55', '7', '2025-10-16 00:39:55'),
(95, 20, 5, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_3_kajian_skrk.docx', 6, '2025-10-16 00:16:13', 'diterima', NULL, 'draft', '2025-10-16 00:16:13', '2025-10-16 00:40:06', '7', '2025-10-16 00:40:06'),
(96, 20, 6, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_4_dokumen_skrk.docx', 6, '2025-10-16 00:16:13', 'diterima', NULL, 'draft', '2025-10-16 00:16:13', '2025-10-16 00:40:15', '7', '2025-10-16 00:40:15'),
(97, 20, 1, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_1a_survey_skrk.pdf', 8, '2025-10-16 00:42:37', 'diterima', NULL, 'final', '2025-10-16 00:42:37', '2025-10-16 00:42:37', NULL, NULL),
(98, 20, 2, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_1b_ba_survey_skrk.pdf', 8, '2025-10-16 00:42:37', 'diterima', NULL, 'final', '2025-10-16 00:42:37', '2025-10-16 00:42:37', NULL, NULL),
(99, 20, 3, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_2a_ba_rapat_skrk.pdf', 8, '2025-10-16 00:42:37', 'diterima', NULL, 'final', '2025-10-16 00:42:37', '2025-10-16 00:42:37', NULL, NULL),
(100, 20, 4, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_2b_notulen_rapat_skrk.pdf', 8, '2025-10-16 00:42:37', 'diterima', NULL, 'final', '2025-10-16 00:42:37', '2025-10-16 00:42:37', NULL, NULL),
(101, 20, 5, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_3_kajian_skrk.pdf', 8, '2025-10-16 00:42:37', 'diterima', NULL, 'final', '2025-10-16 00:42:37', '2025-10-16 00:42:37', NULL, NULL),
(102, 20, 6, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_4_dokumen_skrk.pdf', 8, '2025-10-16 00:42:37', 'diterima', NULL, 'final', '2025-10-16 00:42:37', '2025-10-16 00:42:37', NULL, NULL),
(103, 20, 7, 'skrk/REG-2031-SKRK-10-2025/REG-2031-SKRK-10-2025_5_dokumen_skrk_fix.pdf', 8, '2025-10-16 00:42:37', 'diterima', NULL, 'final', '2025-10-16 00:42:37', '2025-10-16 00:42:37', NULL, NULL),
(104, 21, 1, 'skrk/REG-2030-SKRK-10-2025/REG-2030-SKRK-10-2025_1a_survey_skrk.docx', 9, '2025-10-18 11:00:22', 'diterima', NULL, 'draft', '2025-10-18 11:00:22', '2025-10-18 11:13:56', '7', '2025-10-18 11:13:56'),
(105, 21, 2, 'skrk/REG-2030-SKRK-10-2025/REG-2030-SKRK-10-2025_1b_ba_survey_skrk.docx', 9, '2025-10-18 11:16:51', 'diterima', 'salah hari', 'draft', '2025-10-18 11:00:22', '2025-10-18 11:17:52', '7', '2025-10-18 11:17:52'),
(106, 21, 5, 'skrk/REG-2030-SKRK-10-2025/REG-2030-SKRK-10-2025_3_kajian_skrk.docx', 10, '2025-10-18 11:12:42', 'diterima', NULL, 'draft', '2025-10-18 11:12:42', '2025-10-18 11:14:34', '7', '2025-10-18 11:14:34'),
(107, 21, 6, 'skrk/REG-2030-SKRK-10-2025/REG-2030-SKRK-10-2025_4_dokumen_skrk.docx', 10, '2025-10-18 11:12:42', 'diterima', NULL, 'draft', '2025-10-18 11:12:42', '2025-10-18 11:14:42', '7', '2025-10-18 11:14:42'),
(108, 21, 1, 'skrk/REG-2030-SKRK-10-2025/REG-2030-SKRK-10-2025_1a_survey_skrk.pdf', 8, '2025-10-18 11:19:00', 'diterima', NULL, 'final', '2025-10-18 11:19:00', '2025-10-18 11:19:00', NULL, NULL),
(109, 21, 2, 'skrk/REG-2030-SKRK-10-2025/REG-2030-SKRK-10-2025_1b_ba_survey_skrk.pdf', 8, '2025-10-18 11:19:00', 'diterima', NULL, 'final', '2025-10-18 11:19:00', '2025-10-18 11:19:00', NULL, NULL),
(110, 21, 5, 'skrk/REG-2030-SKRK-10-2025/REG-2030-SKRK-10-2025_3_kajian_skrk.pdf', 8, '2025-10-18 11:19:00', 'diterima', NULL, 'final', '2025-10-18 11:19:00', '2025-10-18 11:19:00', NULL, NULL),
(111, 21, 6, 'skrk/REG-2030-SKRK-10-2025/REG-2030-SKRK-10-2025_4_dokumen_skrk.pdf', 8, '2025-10-18 11:19:00', 'diterima', NULL, 'final', '2025-10-18 11:19:00', '2025-10-18 11:19:00', NULL, NULL),
(112, 21, 7, 'skrk/REG-2030-SKRK-10-2025/REG-2030-SKRK-10-2025_5_dokumen_skrk_fix.pdf', 8, '2025-10-18 11:19:00', 'diterima', NULL, 'final', '2025-10-18 11:19:00', '2025-10-18 11:19:00', NULL, NULL),
(113, 22, 1, 'skrk/REG-2032-SKRK-10-2025/REG-2032-SKRK-10-2025_1a_survey_skrk.docx', 9, '2025-10-21 00:10:11', 'diterima', NULL, 'draft', '2025-10-21 00:10:11', '2025-10-21 00:15:32', '7', '2025-10-21 00:15:32'),
(114, 22, 2, 'skrk/REG-2032-SKRK-10-2025/REG-2032-SKRK-10-2025_1b_ba_survey_skrk.docx', 9, '2025-10-21 00:18:30', 'diterima', 'salah hari survey', 'draft', '2025-10-21 00:10:11', '2025-10-21 00:23:08', '7', '2025-10-21 00:23:08'),
(115, 22, 5, 'skrk/REG-2032-SKRK-10-2025/REG-2032-SKRK-10-2025_3_kajian_skrk.docx', 10, '2025-10-21 00:14:36', 'diterima', NULL, 'draft', '2025-10-21 00:14:36', '2025-10-21 00:16:02', '7', '2025-10-21 00:16:02'),
(116, 22, 6, 'skrk/REG-2032-SKRK-10-2025/REG-2032-SKRK-10-2025_4_dokumen_skrk.docx', 10, '2025-10-21 00:21:11', 'diterima', 'Salah nama', 'draft', '2025-10-21 00:14:36', '2025-10-21 00:23:19', '7', '2025-10-21 00:23:19'),
(117, 22, 4, 'skrk/REG-2032-SKRK-10-2025/REG-2032-SKRK-10-2025_2b_notulen_rapat_skrk.pdf', 8, '2025-10-21 00:24:45', 'diterima', NULL, 'final', '2025-10-21 00:24:45', '2025-10-21 00:24:45', NULL, NULL),
(118, 22, 5, 'skrk/REG-2032-SKRK-10-2025/REG-2032-SKRK-10-2025_3_kajian_skrk.pdf', 8, '2025-10-21 00:24:45', 'diterima', NULL, 'final', '2025-10-21 00:24:45', '2025-10-21 00:24:45', NULL, NULL),
(119, 22, 6, 'skrk/REG-2032-SKRK-10-2025/REG-2032-SKRK-10-2025_4_dokumen_skrk.pdf', 8, '2025-10-21 00:24:45', 'diterima', NULL, 'final', '2025-10-21 00:24:45', '2025-10-21 00:24:45', NULL, NULL),
(120, 22, 7, 'skrk/REG-2032-SKRK-10-2025/REG-2032-SKRK-10-2025_5_dokumen_skrk_fix.pdf', 8, '2025-10-21 00:24:45', 'diterima', NULL, 'final', '2025-10-21 00:24:45', '2025-10-21 00:24:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persyaratan_berkas`
--

CREATE TABLE `persyaratan_berkas` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_berkas` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `urutan` int NOT NULL DEFAULT '1',
  `wajib` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tahapan_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `persyaratan_berkas`
--

INSERT INTO `persyaratan_berkas` (`id`, `nama_berkas`, `kode`, `deskripsi`, `urutan`, `wajib`, `created_at`, `updated_at`, `tahapan_id`) VALUES
(1, '1A Survey Lapangan', '1a_survey_skrk', '1A Form Survey Lapangan', 1, 1, '2025-09-15 13:45:47', '2025-09-15 13:45:47', 1),
(2, '1B BA Survey Lapangan', '1b_ba_survey_skrk', '1B Berita Acara Survey Lapangan', 2, 1, '2025-09-15 13:46:10', '2025-09-15 13:46:10', 1),
(3, '2A BA Rapat FPR (Bila Ada)', '2a_ba_rapat_skrk', '2A BA Rapat FPR (Bila Ada)', 1, 0, '2025-09-15 13:46:37', '2025-09-15 13:46:37', 2),
(4, '2B Notulensi Rapat FPR (Bila Ada)', '2b_notulen_rapat_skrk', '2B Notulensi Rapat FPR (Bila Ada)', 2, 0, '2025-09-15 13:46:54', '2025-09-15 13:46:54', 2),
(5, '3 KAJIAN SKRK', '3_kajian_skrk', 'Kajian SKRK', 3, 1, '2025-09-15 13:47:15', '2025-09-15 13:47:15', 2),
(6, '4 DOKUMEN SKRK', '4_dokumen_skrk', 'Dokumen SKRK', 4, 1, '2025-09-15 13:47:33', '2025-09-15 13:47:33', 2),
(7, '5. Dokumen SKRK Fix', '5_dokumen_skrk_fix', 'Dokumen SKRK Fix', 1, 1, '2025-09-29 03:25:54', '2025-09-29 03:25:54', 3);

-- --------------------------------------------------------

--
-- Table structure for table `registrasi`
--

CREATE TABLE `registrasi` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `layanan_id` int NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fungsi_bangunan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_tanah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kel_tanah` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kec_tanah` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrasi`
--

INSERT INTO `registrasi` (`id`, `nama`, `nik`, `no_hp`, `tanggal`, `layanan_id`, `created_by`, `created_at`, `updated_at`, `kode`, `email`, `fungsi_bangunan`, `alamat_tanah`, `kel_tanah`, `kec_tanah`) VALUES
(4, 'BUDI MULYONO', '23242342342', '03843243', '2025-09-23', 1, 4, '2025-09-17 01:10:46', '2025-09-17 01:10:46', 'REG-0002', 'budi@simtaru-harum.com', NULL, NULL, NULL, NULL),
(6, 'INDIRA GANDHI', '1233326215171', '08175733356', '2025-09-21', 1, 4, '2025-09-21 10:41:34', '2025-09-21 10:41:34', 'REG-0003', 'gandhi_er@yahoo.com', NULL, NULL, NULL, NULL),
(7, 'Mala Astiana', '1324341343', '08176352622', '2025-09-22', 1, 4, '2025-09-22 01:43:45', '2025-09-22 01:43:45', 'REG-0004', 'budi_astaga@yahoo.com', NULL, NULL, NULL, NULL),
(8, 'BUDI MULYONO', '23242342342', '03843243', '2025-09-24', 1, 4, '2025-09-24 00:34:58', '2025-09-24 00:34:58', 'REG-0005', 'budi_digoal@yahoo.com', NULL, NULL, NULL, NULL),
(9, 'Astrid Gumilar', '12345678910', '08176733356', '2025-09-24', 1, 4, '2025-09-24 11:37:18', '2025-09-26 00:41:57', 'REG-0006', 'astrid@yahoo.com', 'Rumah', '-', '-', 'Ampenan'),
(10, 'Boby Rahman', '5271042401930001', '085258192959', '2025-09-11', 1, 4, '2025-09-26 01:06:43', '2025-09-26 01:06:43', 'REG-0007', 'aaaa@hhh', 'Rumah Kost', 'Jl. Cilinaya no. 61 A Grisak ', 'Kekalik Jaya', 'Sekarbela'),
(11, 'Boby Rahman', '5271042401930001', '085258192959', '2025-09-11', 1, 4, '2025-09-29 07:50:51', '2025-09-29 07:50:51', 'REG-0008', 'aaaa@hhh', 'Rumah Kost', 'sssss', 'Kekalik Jaya', 'Sekarbela'),
(12, 'Rina widyawati', '263727282', '0817673354', '2025-09-30', 1, 4, '2025-09-30 00:02:47', '2025-09-30 00:02:47', 'REG-0009', 'endang@simtaru-harum.com', 'Rumah tinggal', 'Jalan abdi praja 38', 'Ampenan', 'Ampenan'),
(13, 'mala', '12345255', '1256+5+++', '2025-09-30', 1, 8, '2025-09-30 00:04:48', '2025-09-30 00:04:48', 'REG-0010', 'fg@hgjj.com', 'ruko', 'uhuitioi', 'ggg', 'Selaparang'),
(14, 'Kiandra Senofatih Dyon', '1425367182191', '08175733386', '2025-10-03', 1, 4, '2025-10-03 02:40:35', '2025-10-03 02:40:35', 'REG-0011', 'budi@sijukir.com', 'Ruko', 'Jalan Jenderal Ahmad Yani Nomor 9', 'Sayang-Sayang', 'Cakranegara'),
(15, 'Jimmy Wijaya', '5271061406870001', '08175727599', '2025-10-01', 1, 4, '2025-10-07 01:13:48', '2025-10-07 01:13:48', 'REG-0012', 'jimmy.wijaya87@gmail.com', 'Rumah Tinggal', 'Perumahan Crystal Regency, Jl. Bung Karno, Mataram', 'Karang Bedil', 'Mataram'),
(16, 'INDIRA GANDHI Spd.', '23242342342', '08175766651', '2025-10-09', 1, 4, '2025-10-09 06:42:10', '2025-10-09 06:47:07', 'REG-2025-0013', 'rina@simtaru-harum.com', 'Ruko', 'Jalan Madiun I/C Taman Baru Mataram', 'Pagesangan Timur', 'Mataram'),
(17, 'Ahmad Sofiandi', '5271056904000001', '082340818445', '2025-10-02', 1, 4, '2025-10-13 07:35:32', '2025-10-13 07:35:32', 'REG-0014-SKRK-10-2025', 'hhhhh@gmail.com', 'Rumah Tinggal', 'Jl. Hanoman No. 05 Kr. Tulamben Cakranegara', 'Karang Bedil', 'Mataram'),
(18, 'Amran M. Amin', '5271022637212', '08175645381', '2025-10-14', 1, 4, '2025-10-13 21:27:16', '2025-10-13 21:27:16', 'REG-2026-SKRK-10-2025', 'Amran@yahoo.com', 'Ruko', 'Jalan Pejanggik Nomor 16 Mataram', 'Tanjung Karang', 'Ampenan'),
(29, 'Dinda Hidayanti', '5271056904000001', '082340818445', '2025-10-10', 1, 4, '2025-10-15 08:48:41', '2025-10-15 08:48:41', 'REG-2027-SKRK-10-2025', 'hhhhh@gmail.com', 'Rumah Tinggal', 'Jl. Cilinaya no. 61 A Grisak', 'cilinaya', 'Cakranegara'),
(30, 'Sutarto', '21312312', '08176733356', '2025-10-15', 1, 4, '2025-10-15 10:27:46', '2025-10-15 10:27:46', 'REG-2028-SKRK-10-2025', 'gaos@simtaru-harum.com', 'Ruko', 'Jalan Madiun I/C Taman Baru Mataram', 'cakranegara utara', 'Cakranegara'),
(31, 'Betty Lafea', '8734190122311', '08176733356', '2025-10-15', 1, 4, '2025-10-15 11:08:27', '2025-10-15 11:08:27', 'REG-2029-SKRK-10-2025', 'nanik@simtaru-harum.com', 'Akomodasi Lainnya (Rumah Kos)', 'Jalan Beo Nomor 9 Cakranegara', 'cakranegara utara', 'Cakranegara'),
(32, 'steve alexander', '5271005206000001', '087795985214', '2025-10-14', 1, 4, '2025-10-15 23:39:32', '2025-10-15 23:39:32', 'REG-2030-SKRK-10-2025', 'steve123@gmail.com', 'Rumah Kost', 'jl airlangga n0 70', 'Punia', 'Mataram'),
(33, 'steve alexander', '5271005206000001', '087795985214', '2025-10-14', 1, 8, '2025-10-15 23:40:35', '2025-10-15 23:44:39', 'REG-2031-SKRK-10-2025', 'steve123@gmail.com', 'Rumah Kost', 'jl hanoman', 'Punia', 'Mataram'),
(34, 'Rumansyah', '234332373452', '08175753211', '2025-10-20', 1, 4, '2025-10-21 00:04:50', '2025-10-21 00:04:50', 'REG-2032-SKRK-10-2025', 'budi@sijukir.com', 'Ruko', 'jalan ahmad yani nomor 19', 'Sayang-Sayang', 'Cakranegara');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_permohonans`
--

CREATE TABLE `riwayat_permohonans` (
  `id` bigint UNSIGNED NOT NULL,
  `registrasi_id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riwayat_permohonans`
--

INSERT INTO `riwayat_permohonans` (`id`, `registrasi_id`, `user_id`, `keterangan`, `created_at`, `updated_at`) VALUES
(6, 4, 4, 'Entry Registrasi', '2025-09-17 01:10:46', '2025-09-17 01:10:46'),
(13, 4, 8, 'Entry Permohonan', '2025-09-19 11:16:35', '2025-09-19 11:16:35'),
(14, 4, 8, 'Disposisi kepada Gaos pada tahapan Survey Berkas', '2025-09-19 11:16:35', '2025-09-19 11:16:35'),
(17, 4, 9, 'Entry Data Survey', '2025-09-19 13:17:07', '2025-09-19 13:17:07'),
(18, 4, 9, 'Disposisi kepada Trisna Hartanti Utama, ST. pada tahapan Analis Berkas', '2025-09-19 13:17:07', '2025-09-19 13:17:07'),
(19, 4, 9, 'Entry Data Survey', '2025-09-19 13:17:07', '2025-09-19 13:17:07'),
(20, 4, 6, 'Entry Data Kajian Analisa', '2025-09-19 22:21:10', '2025-09-19 22:21:10'),
(21, 4, 6, 'Entry Data Dokumen SKRK', '2025-09-19 22:22:09', '2025-09-19 22:22:09'),
(22, 4, 6, 'Upload Berkas Analisa', '2025-09-19 22:22:45', '2025-09-19 22:22:45'),
(23, 4, 6, 'Upload Berkas Analisa', '2025-09-19 22:23:14', '2025-09-19 22:23:14'),
(24, 6, 4, 'Entry Registrasi', '2025-09-21 10:41:34', '2025-09-21 10:41:34'),
(25, 6, 11, 'Entry Permohonan', '2025-09-21 10:45:17', '2025-09-21 10:45:17'),
(26, 6, 11, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-09-21 10:45:17', '2025-09-21 10:45:17'),
(27, 7, 4, 'Entry Registrasi', '2025-09-22 01:43:45', '2025-09-22 01:43:45'),
(28, 7, 11, 'Entry Permohonan', '2025-09-22 01:45:42', '2025-09-22 01:45:42'),
(29, 7, 11, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-09-22 01:45:42', '2025-09-22 01:45:42'),
(30, 7, 2, 'Entry Data Survey', '2025-09-22 07:32:52', '2025-09-22 07:32:52'),
(31, 7, 2, 'Disposisi kepada Trisna Hartanti Utama, ST. pada tahapan Analis Berkas', '2025-09-22 07:32:52', '2025-09-22 07:32:52'),
(32, 7, 2, 'Entry Data Kajian Analisa', '2025-09-22 07:33:50', '2025-09-22 07:33:50'),
(33, 7, 2, 'Entry Data Dokumen SKRK', '2025-09-22 07:34:16', '2025-09-22 07:34:16'),
(34, 7, 2, 'Upload Berkas Analisa', '2025-09-22 07:35:03', '2025-09-22 07:35:03'),
(35, 7, 6, 'Upload Berkas Analisa', '2025-09-22 08:33:26', '2025-09-22 08:33:26'),
(36, 8, 4, 'Entry Registrasi', '2025-09-24 00:34:58', '2025-09-24 00:34:58'),
(37, 9, 4, 'Entry Registrasi', '2025-09-24 11:37:18', '2025-09-24 11:37:18'),
(38, 9, 11, 'Entry Permohonan', '2025-09-24 11:42:24', '2025-09-24 11:42:24'),
(39, 9, 11, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-09-24 11:42:24', '2025-09-24 11:42:24'),
(40, 10, 4, 'Entry Registrasi', '2025-09-26 01:06:43', '2025-09-26 01:06:43'),
(41, 10, 8, 'Entry Permohonan', '2025-09-26 01:21:05', '2025-09-26 01:21:05'),
(42, 10, 8, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-09-26 01:21:05', '2025-09-26 01:21:05'),
(43, 10, 9, 'Entry Data Survey', '2025-09-26 01:40:12', '2025-09-26 01:40:12'),
(44, 10, 9, 'Disposisi kepada Trisna Hartanti Utama, ST. pada tahapan Analisis', '2025-09-26 01:49:47', '2025-09-26 01:49:47'),
(45, 10, 9, 'Upload Berkas Survey', '2025-09-26 02:26:54', '2025-09-26 02:26:54'),
(46, 10, 6, 'Entry Data Kajian Analisa', '2025-09-26 02:44:35', '2025-09-26 02:44:35'),
(47, 10, 6, 'Entry Data Dokumen SKRK', '2025-09-26 02:50:11', '2025-09-26 02:50:11'),
(48, 10, 6, 'Upload Berkas Analisa', '2025-09-26 02:51:20', '2025-09-26 02:51:20'),
(49, 10, 6, 'Selesai Analisa Data SKRK', '2025-09-26 02:51:32', '2025-09-26 02:51:32'),
(50, 10, 6, 'Proses Verifikasi Data SKRK', '2025-09-26 02:51:32', '2025-09-26 02:51:32'),
(51, 10, 6, 'Upload Berkas Analisa', '2025-09-29 00:06:51', '2025-09-29 00:06:51'),
(52, 11, 4, 'Entry Registrasi', '2025-09-29 07:50:51', '2025-09-29 07:50:51'),
(53, 12, 4, 'Entry Registrasi', '2025-09-30 00:02:47', '2025-09-30 00:02:47'),
(54, 13, 8, 'Entry Registrasi', '2025-09-30 00:04:48', '2025-09-30 00:04:48'),
(55, 13, 8, 'Entry Permohonan', '2025-09-30 00:08:53', '2025-09-30 00:08:53'),
(56, 13, 8, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-09-30 00:08:53', '2025-09-30 00:08:53'),
(57, 13, 9, 'Entry Data Survey', '2025-09-30 00:44:58', '2025-09-30 00:44:58'),
(58, 13, 9, 'Disposisi kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-09-30 00:45:17', '2025-09-30 00:45:17'),
(59, 13, 9, 'Upload Berkas Survey', '2025-09-30 12:54:24', '2025-09-30 12:54:24'),
(60, 13, 9, 'Disposisi kepada Nanik Adrianti, ST. pada tahapan Cetak', '2025-09-30 12:54:42', '2025-09-30 12:54:42'),
(61, 13, 10, 'Entry Data Kajian Analisa', '2025-09-30 13:49:41', '2025-09-30 13:49:41'),
(62, 13, 10, 'Entry Data Dokumen SKRK', '2025-09-30 13:50:02', '2025-09-30 13:50:02'),
(63, 13, 10, 'Upload Berkas Analisa', '2025-09-30 13:50:35', '2025-09-30 13:50:35'),
(64, 13, 10, 'Selesai Analisa Data SKRK', '2025-09-30 13:50:47', '2025-09-30 13:50:47'),
(65, 13, 10, 'Proses Verifikasi Data SKRK', '2025-09-30 13:50:47', '2025-09-30 13:50:47'),
(66, 13, 10, 'Upload Berkas Analisa', '2025-10-01 06:24:02', '2025-10-01 06:24:02'),
(67, 13, 10, 'Upload Berkas Analisa', '2025-10-01 06:24:36', '2025-10-01 06:24:36'),
(68, 13, 10, 'Upload Berkas Analisa', '2025-10-01 06:25:50', '2025-10-01 06:25:50'),
(69, 14, 4, 'Entry Registrasi', '2025-10-03 02:40:35', '2025-10-03 02:40:35'),
(70, 14, 8, 'Entry Permohonan', '2025-10-03 02:49:36', '2025-10-03 02:49:36'),
(71, 14, 8, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-10-03 02:49:36', '2025-10-03 02:49:36'),
(72, 15, 4, 'Entry Registrasi', '2025-10-07 01:13:48', '2025-10-07 01:13:48'),
(73, 15, 8, 'Entry Permohonan', '2025-10-07 01:41:14', '2025-10-07 01:41:14'),
(74, 15, 8, 'Disposisi kepada Bayu Muliawan, SH. pada tahapan Survey Berkas', '2025-10-07 01:41:14', '2025-10-07 01:41:14'),
(75, 14, 9, 'Entry Data Survey', '2025-10-08 21:54:01', '2025-10-08 21:54:01'),
(76, 16, 4, 'Entry Registrasi', '2025-10-09 06:42:10', '2025-10-09 06:42:10'),
(77, 16, 8, 'Entry Permohonan', '2025-10-09 06:51:24', '2025-10-09 06:51:24'),
(78, 16, 8, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-10-09 06:51:24', '2025-10-09 06:51:24'),
(79, 16, 9, 'Entry Data Survey', '2025-10-09 06:54:38', '2025-10-09 06:54:38'),
(80, 16, 9, 'Upload Berkas Survey', '2025-10-09 06:55:19', '2025-10-09 06:55:19'),
(81, 16, 9, 'Upload Berkas Survey', '2025-10-09 06:55:19', '2025-10-09 06:55:19'),
(82, 16, 9, 'Disposisi kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-09 06:55:51', '2025-10-09 06:55:51'),
(83, 16, 9, 'Selesai Survey Data SKRK', '2025-10-09 06:57:58', '2025-10-09 06:57:58'),
(84, 16, 9, 'Proses Analisa SKRK', '2025-10-09 06:57:58', '2025-10-09 06:57:58'),
(85, 16, 10, 'Entry Data Kajian Analisa', '2025-10-09 06:59:41', '2025-10-09 06:59:41'),
(86, 16, 10, 'Entry Data Dokumen SKRK', '2025-10-09 07:02:36', '2025-10-09 07:02:36'),
(87, 16, 10, 'Upload Berkas Analisa', '2025-10-09 07:03:10', '2025-10-09 07:03:10'),
(88, 16, 10, 'Upload Berkas Analisa', '2025-10-09 07:03:10', '2025-10-09 07:03:10'),
(89, 16, 10, 'Selesai Analisa Data SKRK', '2025-10-09 07:04:13', '2025-10-09 07:04:13'),
(90, 16, 10, 'Proses Verifikasi Data SKRK', '2025-10-09 07:04:13', '2025-10-09 07:04:13'),
(91, 16, 9, 'Selesai Survey Data SKRK', '2025-10-09 07:13:38', '2025-10-09 07:13:38'),
(92, 16, 9, 'Proses Analisa SKRK', '2025-10-09 07:13:38', '2025-10-09 07:13:38'),
(93, 16, 10, 'Selesai Analisa Data SKRK', '2025-10-09 07:35:58', '2025-10-09 07:35:58'),
(94, 16, 10, 'Proses Verifikasi Data SKRK', '2025-10-09 07:35:58', '2025-10-09 07:35:58'),
(95, 16, 7, 'Selesai Verifikasi Berkas SKRK', '2025-10-09 07:37:16', '2025-10-09 07:37:16'),
(96, 16, 7, 'Sedang Proses Cetak Dokumen SKRK', '2025-10-09 07:37:16', '2025-10-09 07:37:16'),
(97, 16, 8, 'Dokumen SKRK selesai!', '2025-10-09 07:47:00', '2025-10-09 07:47:00'),
(98, 16, 1, 'Edit Dokumen SKRK selesai!', '2025-10-11 08:18:18', '2025-10-11 08:18:18'),
(99, 16, 1, 'Edit Dokumen SKRK selesai!', '2025-10-11 08:18:38', '2025-10-11 08:18:38'),
(100, 17, 4, 'Entry Registrasi', '2025-10-13 07:35:32', '2025-10-13 07:35:32'),
(101, 17, 8, 'Entry Permohonan', '2025-10-13 07:38:12', '2025-10-13 07:38:12'),
(102, 17, 8, 'Disposisi kepada Bayu Muliawan, SH. pada tahapan Survey Berkas', '2025-10-13 07:38:12', '2025-10-13 07:38:12'),
(103, 17, 12, 'Entry Data Survey', '2025-10-13 08:33:28', '2025-10-13 08:33:28'),
(104, 17, 12, 'Disposisi kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-13 08:34:06', '2025-10-13 08:34:06'),
(105, 17, 1, 'Upload Berkas Survey', '2025-10-13 08:49:20', '2025-10-13 08:49:20'),
(106, 17, 12, 'Upload Berkas Survey', '2025-10-13 08:50:18', '2025-10-13 08:50:18'),
(107, 17, 12, 'Selesai Survey Data SKRK', '2025-10-13 08:50:44', '2025-10-13 08:50:44'),
(108, 17, 12, 'Proses Analisa SKRK', '2025-10-13 08:50:44', '2025-10-13 08:50:44'),
(109, 11, 8, 'Entry Permohonan', '2025-10-13 12:57:04', '2025-10-13 12:57:04'),
(110, 11, 8, 'Disposisi kepada Bayu Muliawan, SH. pada tahapan Survey Berkas', '2025-10-13 12:57:04', '2025-10-13 12:57:04'),
(111, 11, 12, 'Entry Data Survey', '2025-10-13 12:58:32', '2025-10-13 12:58:32'),
(112, 11, 12, 'Upload Berkas Survey', '2025-10-13 12:59:34', '2025-10-13 12:59:34'),
(113, 11, 12, 'Upload Berkas Survey', '2025-10-13 12:59:34', '2025-10-13 12:59:34'),
(114, 11, 12, 'Disposisi kepada Trisna Hartanti Utama, ST. pada tahapan Analisis', '2025-10-13 12:59:46', '2025-10-13 12:59:46'),
(115, 11, 12, 'Selesai Survey Data SKRK', '2025-10-13 13:00:17', '2025-10-13 13:00:17'),
(116, 11, 12, 'Proses Analisa SKRK', '2025-10-13 13:00:17', '2025-10-13 13:00:17'),
(117, 11, 6, 'Entry Data Kajian Analisa', '2025-10-13 13:01:23', '2025-10-13 13:01:23'),
(118, 11, 6, 'Entry Data Dokumen SKRK', '2025-10-13 13:02:07', '2025-10-13 13:02:07'),
(119, 11, 6, 'Upload Berkas Analisa', '2025-10-13 13:03:11', '2025-10-13 13:03:11'),
(120, 11, 6, 'Upload Berkas Analisa', '2025-10-13 13:03:11', '2025-10-13 13:03:11'),
(121, 11, 6, 'Upload Berkas Analisa', '2025-10-13 13:03:11', '2025-10-13 13:03:11'),
(122, 11, 6, 'Upload Berkas Analisa', '2025-10-13 13:03:11', '2025-10-13 13:03:11'),
(123, 11, 6, 'Selesai Analisa Data SKRK', '2025-10-13 13:04:02', '2025-10-13 13:04:02'),
(124, 11, 6, 'Proses Verifikasi Data SKRK', '2025-10-13 13:04:02', '2025-10-13 13:04:02'),
(125, 11, 7, 'Disposisi kembali kepada Bayu Muliawan, SH. pada tahapan Survey', '2025-10-13 13:04:55', '2025-10-13 13:04:55'),
(126, 11, 7, 'Disposisi kembali kepada Trisna Hartanti Utama, ST. pada tahapan Analisis', '2025-10-13 13:05:13', '2025-10-13 13:05:13'),
(127, 11, 12, 'Selesai Survey Data SKRK', '2025-10-13 13:06:52', '2025-10-13 13:06:52'),
(128, 11, 12, 'Proses Analisa SKRK', '2025-10-13 13:06:52', '2025-10-13 13:06:52'),
(129, 11, 6, 'Selesai Analisa Data SKRK', '2025-10-13 13:07:27', '2025-10-13 13:07:27'),
(130, 11, 6, 'Proses Verifikasi Data SKRK', '2025-10-13 13:07:27', '2025-10-13 13:07:27'),
(131, 11, 7, 'Selesai Verifikasi Berkas SKRK', '2025-10-13 13:11:07', '2025-10-13 13:11:07'),
(132, 11, 7, 'Sedang Proses Cetak Dokumen SKRK', '2025-10-13 13:11:07', '2025-10-13 13:11:07'),
(133, 11, 8, 'Dokumen SKRK selesai!', '2025-10-13 13:12:09', '2025-10-13 13:12:09'),
(134, 18, 4, 'Entry Registrasi', '2025-10-13 21:27:16', '2025-10-13 21:27:16'),
(135, 18, 11, 'Entry Permohonan', '2025-10-13 21:29:34', '2025-10-13 21:29:34'),
(136, 18, 11, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-10-13 21:29:34', '2025-10-13 21:29:34'),
(137, 18, 9, 'Entry Data Survey', '2025-10-13 21:30:43', '2025-10-13 21:30:43'),
(138, 18, 9, 'Upload Berkas Survey', '2025-10-13 21:31:16', '2025-10-13 21:31:16'),
(139, 18, 9, 'Upload Berkas Survey', '2025-10-13 21:31:16', '2025-10-13 21:31:16'),
(140, 18, 9, 'Disposisi kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-13 21:31:38', '2025-10-13 21:31:38'),
(141, 18, 9, 'Selesai Survey Data SKRK', '2025-10-13 21:33:02', '2025-10-13 21:33:02'),
(142, 18, 9, 'Proses Analisa SKRK', '2025-10-13 21:33:02', '2025-10-13 21:33:02'),
(143, 18, 10, 'Entry Data Kajian Analisa', '2025-10-13 21:34:02', '2025-10-13 21:34:02'),
(144, 18, 10, 'Entry Data Dokumen SKRK', '2025-10-13 21:34:36', '2025-10-13 21:34:36'),
(145, 18, 10, 'Upload Berkas Analisa', '2025-10-13 21:36:10', '2025-10-13 21:36:10'),
(146, 18, 10, 'Upload Berkas Analisa', '2025-10-13 21:36:11', '2025-10-13 21:36:11'),
(147, 18, 10, 'Upload Berkas Analisa', '2025-10-13 21:36:11', '2025-10-13 21:36:11'),
(148, 18, 10, 'Upload Berkas Analisa', '2025-10-13 21:36:11', '2025-10-13 21:36:11'),
(149, 18, 10, 'Selesai Analisa Data SKRK', '2025-10-13 21:36:17', '2025-10-13 21:36:17'),
(150, 18, 10, 'Proses Verifikasi Data SKRK', '2025-10-13 21:36:17', '2025-10-13 21:36:17'),
(151, 18, 7, 'Disposisi kembali kepada Gaosul Muhyi, ST. pada tahapan Survey', '2025-10-13 21:37:06', '2025-10-13 21:37:06'),
(152, 18, 7, 'Disposisi kembali kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-13 21:37:32', '2025-10-13 21:37:32'),
(153, 18, 9, 'Selesai Survey Data SKRK', '2025-10-13 21:40:13', '2025-10-13 21:40:13'),
(154, 18, 9, 'Proses Analisa SKRK', '2025-10-13 21:40:13', '2025-10-13 21:40:13'),
(155, 18, 10, 'Selesai Analisa Data SKRK', '2025-10-13 21:40:52', '2025-10-13 21:40:52'),
(156, 18, 10, 'Proses Verifikasi Data SKRK', '2025-10-13 21:40:52', '2025-10-13 21:40:52'),
(157, 18, 7, 'Selesai Verifikasi Berkas SKRK', '2025-10-13 21:41:47', '2025-10-13 21:41:47'),
(158, 18, 7, 'Sedang Proses Cetak Dokumen SKRK', '2025-10-13 21:41:47', '2025-10-13 21:41:47'),
(159, 18, 11, 'Dokumen SKRK selesai!', '2025-10-13 21:43:52', '2025-10-13 21:43:52'),
(160, 17, 10, 'Entry Data Kajian Analisa', '2025-10-13 23:46:48', '2025-10-13 23:46:48'),
(161, 17, 10, 'Entry Data Dokumen SKRK', '2025-10-13 23:47:28', '2025-10-13 23:47:28'),
(162, 17, 10, 'Upload Berkas Analisa', '2025-10-13 23:48:12', '2025-10-13 23:48:12'),
(163, 17, 10, 'Upload Berkas Analisa', '2025-10-13 23:48:12', '2025-10-13 23:48:12'),
(164, 17, 10, 'Upload Berkas Analisa', '2025-10-13 23:48:12', '2025-10-13 23:48:12'),
(165, 17, 10, 'Upload Berkas Analisa', '2025-10-13 23:48:12', '2025-10-13 23:48:12'),
(166, 17, 10, 'Selesai Analisa Data SKRK', '2025-10-13 23:48:32', '2025-10-13 23:48:32'),
(167, 17, 10, 'Proses Verifikasi Data SKRK', '2025-10-13 23:48:32', '2025-10-13 23:48:32'),
(168, 17, 7, 'Disposisi kembali kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-13 23:52:44', '2025-10-13 23:52:44'),
(169, 12, 8, 'Entry Permohonan', '2025-10-14 00:06:48', '2025-10-14 00:06:48'),
(170, 12, 8, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-10-14 00:06:48', '2025-10-14 00:06:48'),
(171, 12, 9, 'Entry Data Survey', '2025-10-14 00:10:20', '2025-10-14 00:10:20'),
(172, 12, 9, 'Upload Berkas Survey', '2025-10-14 00:11:29', '2025-10-14 00:11:29'),
(173, 12, 9, 'Upload Berkas Survey', '2025-10-14 00:11:29', '2025-10-14 00:11:29'),
(174, 12, 9, 'Disposisi kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-14 00:11:49', '2025-10-14 00:11:49'),
(175, 12, 9, 'Selesai Survey Data SKRK', '2025-10-14 00:12:36', '2025-10-14 00:12:36'),
(176, 12, 9, 'Proses Analisa SKRK', '2025-10-14 00:12:36', '2025-10-14 00:12:36'),
(177, 12, 10, 'Entry Data Kajian Analisa', '2025-10-14 00:13:48', '2025-10-14 00:13:48'),
(178, 12, 10, 'Entry Data Dokumen SKRK', '2025-10-14 00:17:05', '2025-10-14 00:17:05'),
(179, 12, 10, 'Upload Berkas Analisa', '2025-10-14 00:19:14', '2025-10-14 00:19:14'),
(180, 12, 10, 'Upload Berkas Analisa', '2025-10-14 00:19:14', '2025-10-14 00:19:14'),
(181, 12, 10, 'Upload Berkas Analisa', '2025-10-14 00:19:14', '2025-10-14 00:19:14'),
(182, 12, 10, 'Upload Berkas Analisa', '2025-10-14 00:19:14', '2025-10-14 00:19:14'),
(183, 12, 10, 'Selesai Analisa Data SKRK', '2025-10-14 00:19:23', '2025-10-14 00:19:23'),
(184, 12, 10, 'Proses Verifikasi Data SKRK', '2025-10-14 00:19:23', '2025-10-14 00:19:23'),
(185, 12, 7, 'Disposisi kembali kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-14 00:23:07', '2025-10-14 00:23:07'),
(186, 12, 10, 'Selesai Analisa Data SKRK', '2025-10-14 00:24:33', '2025-10-14 00:24:33'),
(187, 12, 10, 'Proses Verifikasi Data SKRK', '2025-10-14 00:24:33', '2025-10-14 00:24:33'),
(188, 12, 7, 'Selesai Verifikasi Berkas SKRK', '2025-10-14 00:26:52', '2025-10-14 00:26:52'),
(189, 12, 7, 'Sedang Proses Cetak Dokumen SKRK', '2025-10-14 00:26:52', '2025-10-14 00:26:52'),
(190, 12, 8, 'Dokumen SKRK selesai!', '2025-10-14 00:30:59', '2025-10-14 00:30:59'),
(191, 17, 7, 'Selesai Analisa Data SKRK', '2025-10-14 01:13:07', '2025-10-14 01:13:07'),
(192, 17, 7, 'Proses Verifikasi Data SKRK', '2025-10-14 01:13:07', '2025-10-14 01:13:07'),
(193, 29, 4, 'Entry Registrasi', '2025-10-15 08:48:41', '2025-10-15 08:48:41'),
(194, 30, 4, 'Entry Registrasi', '2025-10-15 10:27:46', '2025-10-15 10:27:46'),
(195, 30, 8, 'Entry Permohonan', '2025-10-15 10:28:55', '2025-10-15 10:28:55'),
(196, 30, 8, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-10-15 10:28:55', '2025-10-15 10:28:55'),
(197, 30, 9, 'Entry Data Survey', '2025-10-15 10:30:02', '2025-10-15 10:30:02'),
(198, 30, 9, 'Upload Berkas Survey', '2025-10-15 10:36:04', '2025-10-15 10:36:04'),
(199, 30, 9, 'Upload Berkas Survey', '2025-10-15 10:36:04', '2025-10-15 10:36:04'),
(200, 30, 9, 'Disposisi kepada Trisna Hartanti Utama, ST. pada tahapan Analisis', '2025-10-15 10:36:13', '2025-10-15 10:36:13'),
(201, 30, 9, 'Selesai Survey Data SKRK', '2025-10-15 10:37:04', '2025-10-15 10:37:04'),
(202, 30, 9, 'Proses Analisa SKRK', '2025-10-15 10:37:04', '2025-10-15 10:37:04'),
(203, 30, 6, 'Entry Data Kajian Analisa', '2025-10-15 10:38:22', '2025-10-15 10:38:22'),
(204, 30, 6, 'Entry Data Dokumen SKRK', '2025-10-15 10:41:14', '2025-10-15 10:41:14'),
(205, 30, 6, 'Upload Berkas Analisa', '2025-10-15 10:42:29', '2025-10-15 10:42:29'),
(206, 30, 6, 'Upload Berkas Analisa', '2025-10-15 10:42:29', '2025-10-15 10:42:29'),
(207, 30, 6, 'Upload Berkas Analisa', '2025-10-15 10:42:29', '2025-10-15 10:42:29'),
(208, 30, 6, 'Upload Berkas Analisa', '2025-10-15 10:42:29', '2025-10-15 10:42:29'),
(209, 30, 6, 'Selesai Analisa Data SKRK', '2025-10-15 10:42:36', '2025-10-15 10:42:36'),
(210, 30, 6, 'Proses Verifikasi Data SKRK', '2025-10-15 10:42:36', '2025-10-15 10:42:36'),
(211, 30, 7, 'Disposisi kembali kepada Gaosul Muhyi, ST. pada tahapan Survey', '2025-10-15 10:43:35', '2025-10-15 10:43:35'),
(212, 30, 7, 'Disposisi kembali kepada Trisna Hartanti Utama, ST. pada tahapan Analisis', '2025-10-15 10:43:54', '2025-10-15 10:43:54'),
(213, 30, 9, 'Selesai Survey Data SKRK', '2025-10-15 10:45:01', '2025-10-15 10:45:01'),
(214, 30, 9, 'Proses Analisa SKRK', '2025-10-15 10:45:01', '2025-10-15 10:45:01'),
(215, 30, 6, 'Selesai Analisa Data SKRK', '2025-10-15 10:46:59', '2025-10-15 10:46:59'),
(216, 30, 6, 'Proses Verifikasi Data SKRK', '2025-10-15 10:46:59', '2025-10-15 10:46:59'),
(217, 30, 7, 'Selesai Verifikasi Berkas SKRK', '2025-10-15 10:49:40', '2025-10-15 10:49:40'),
(218, 30, 7, 'Sedang Proses Cetak Dokumen SKRK', '2025-10-15 10:49:40', '2025-10-15 10:49:40'),
(219, 30, 8, 'Dokumen SKRK selesai!', '2025-10-15 10:52:23', '2025-10-15 10:52:23'),
(220, 31, 4, 'Entry Registrasi', '2025-10-15 11:08:27', '2025-10-15 11:08:27'),
(221, 31, 11, 'Entry Permohonan', '2025-10-15 11:14:18', '2025-10-15 11:14:18'),
(222, 31, 11, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-10-15 11:14:18', '2025-10-15 11:14:18'),
(223, 31, 9, 'Entry Data Survey', '2025-10-15 11:16:00', '2025-10-15 11:16:00'),
(224, 31, 9, 'Upload Berkas Survey', '2025-10-15 11:26:50', '2025-10-15 11:26:50'),
(225, 31, 9, 'Upload Berkas Survey', '2025-10-15 11:26:50', '2025-10-15 11:26:50'),
(226, 31, 9, 'Disposisi kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-15 11:27:06', '2025-10-15 11:27:06'),
(227, 31, 9, 'Selesai Survey Data SKRK', '2025-10-15 11:28:07', '2025-10-15 11:28:07'),
(228, 31, 9, 'Proses Analisa SKRK', '2025-10-15 11:28:07', '2025-10-15 11:28:07'),
(229, 31, 10, 'Entry Data Kajian Analisa', '2025-10-15 12:30:07', '2025-10-15 12:30:07'),
(230, 31, 10, 'Entry Data Dokumen SKRK', '2025-10-15 12:35:08', '2025-10-15 12:35:08'),
(231, 31, 10, 'Upload Berkas Analisa', '2025-10-15 12:36:14', '2025-10-15 12:36:14'),
(232, 31, 10, 'Upload Berkas Analisa', '2025-10-15 12:36:14', '2025-10-15 12:36:14'),
(233, 31, 10, 'Selesai Analisa Data SKRK', '2025-10-15 12:36:19', '2025-10-15 12:36:19'),
(234, 31, 10, 'Proses Verifikasi Data SKRK', '2025-10-15 12:36:19', '2025-10-15 12:36:19'),
(235, 31, 7, 'Disposisi kembali kepada Gaosul Muhyi, ST. pada tahapan Survey', '2025-10-15 12:38:07', '2025-10-15 12:38:07'),
(236, 31, 7, 'Disposisi kembali kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-15 12:38:51', '2025-10-15 12:38:51'),
(237, 31, 9, 'Selesai Survey Data SKRK', '2025-10-15 12:41:06', '2025-10-15 12:41:06'),
(238, 31, 9, 'Proses Analisa SKRK', '2025-10-15 12:41:06', '2025-10-15 12:41:06'),
(239, 31, 10, 'Selesai Analisa Data SKRK', '2025-10-15 12:43:52', '2025-10-15 12:43:52'),
(240, 31, 10, 'Proses Verifikasi Data SKRK', '2025-10-15 12:43:52', '2025-10-15 12:43:52'),
(241, 31, 7, 'Selesai Verifikasi Berkas SKRK', '2025-10-15 12:45:49', '2025-10-15 12:45:49'),
(242, 31, 7, 'Sedang Proses Cetak Dokumen SKRK', '2025-10-15 12:45:49', '2025-10-15 12:45:49'),
(243, 31, 7, 'Dokumen SKRK selesai!', '2025-10-15 12:46:30', '2025-10-15 12:46:30'),
(244, 32, 4, 'Entry Registrasi', '2025-10-15 23:39:32', '2025-10-15 23:39:32'),
(245, 33, 8, 'Entry Registrasi', '2025-10-15 23:40:35', '2025-10-15 23:40:35'),
(246, 33, 8, 'Entry Permohonan', '2025-10-15 23:47:57', '2025-10-15 23:47:57'),
(247, 33, 8, 'Disposisi kepada Bayu Muliawan, SH. pada tahapan Survey Berkas', '2025-10-15 23:47:57', '2025-10-15 23:47:57'),
(248, 33, 12, 'Entry Data Survey', '2025-10-15 23:50:54', '2025-10-15 23:50:54'),
(249, 33, 12, 'Upload Berkas Survey', '2025-10-15 23:54:02', '2025-10-15 23:54:02'),
(250, 33, 12, 'Upload Berkas Survey', '2025-10-15 23:54:02', '2025-10-15 23:54:02'),
(251, 33, 12, 'Disposisi kepada Trisna Hartanti Utama, ST. pada tahapan Analisis', '2025-10-15 23:54:57', '2025-10-15 23:54:57'),
(252, 33, 12, 'Selesai Survey Data SKRK', '2025-10-15 23:55:44', '2025-10-15 23:55:44'),
(253, 33, 12, 'Proses Analisa SKRK', '2025-10-15 23:55:44', '2025-10-15 23:55:44'),
(254, 33, 6, 'Entry Data Kajian Analisa', '2025-10-16 00:08:35', '2025-10-16 00:08:35'),
(255, 33, 6, 'Entry Data Dokumen SKRK', '2025-10-16 00:09:49', '2025-10-16 00:09:49'),
(256, 33, 6, 'Upload Berkas Analisa', '2025-10-16 00:16:13', '2025-10-16 00:16:13'),
(257, 33, 6, 'Upload Berkas Analisa', '2025-10-16 00:16:13', '2025-10-16 00:16:13'),
(258, 33, 6, 'Upload Berkas Analisa', '2025-10-16 00:16:13', '2025-10-16 00:16:13'),
(259, 33, 6, 'Upload Berkas Analisa', '2025-10-16 00:16:13', '2025-10-16 00:16:13'),
(260, 33, 6, 'Selesai Analisa Data SKRK', '2025-10-16 00:16:44', '2025-10-16 00:16:44'),
(261, 33, 6, 'Proses Verifikasi Data SKRK', '2025-10-16 00:16:44', '2025-10-16 00:16:44'),
(262, 33, 7, 'Selesai Verifikasi Berkas SKRK', '2025-10-16 00:40:31', '2025-10-16 00:40:31'),
(263, 33, 7, 'Sedang Proses Cetak Dokumen SKRK', '2025-10-16 00:40:31', '2025-10-16 00:40:31'),
(264, 33, 8, 'Dokumen SKRK selesai!', '2025-10-16 00:42:37', '2025-10-16 00:42:37'),
(265, 32, 8, 'Entry Permohonan', '2025-10-18 10:54:08', '2025-10-18 10:54:08'),
(266, 32, 8, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-10-18 10:54:08', '2025-10-18 10:54:08'),
(267, 32, 9, 'Entry Data Survey', '2025-10-18 10:55:04', '2025-10-18 10:55:04'),
(268, 32, 9, 'Upload Berkas Survey', '2025-10-18 11:00:22', '2025-10-18 11:00:22'),
(269, 32, 9, 'Upload Berkas Survey', '2025-10-18 11:00:22', '2025-10-18 11:00:22'),
(270, 32, 9, 'Disposisi kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-18 11:00:32', '2025-10-18 11:00:32'),
(271, 32, 9, 'Selesai Survey Data SKRK', '2025-10-18 11:00:37', '2025-10-18 11:00:37'),
(272, 32, 9, 'Proses Analisa SKRK', '2025-10-18 11:00:37', '2025-10-18 11:00:37'),
(273, 32, 10, 'Entry Data Kajian Analisa', '2025-10-18 11:03:23', '2025-10-18 11:03:23'),
(274, 32, 10, 'Entry Data Dokumen SKRK', '2025-10-18 11:11:59', '2025-10-18 11:11:59'),
(275, 32, 10, 'Upload Berkas Analisa', '2025-10-18 11:12:42', '2025-10-18 11:12:42'),
(276, 32, 10, 'Upload Berkas Analisa', '2025-10-18 11:12:42', '2025-10-18 11:12:42'),
(277, 32, 10, 'Selesai Analisa Data SKRK', '2025-10-18 11:12:48', '2025-10-18 11:12:48'),
(278, 32, 10, 'Proses Verifikasi Data SKRK', '2025-10-18 11:12:48', '2025-10-18 11:12:48'),
(279, 32, 7, 'Disposisi kembali kepada Gaosul Muhyi, ST. pada tahapan Survey', '2025-10-18 11:14:10', '2025-10-18 11:14:10'),
(280, 32, 9, 'Selesai Survey Data SKRK', '2025-10-18 11:16:56', '2025-10-18 11:16:56'),
(281, 32, 9, 'Proses Analisa SKRK', '2025-10-18 11:16:56', '2025-10-18 11:16:56'),
(282, 32, 7, 'Selesai Verifikasi Berkas SKRK', '2025-10-18 11:18:01', '2025-10-18 11:18:01'),
(283, 32, 7, 'Sedang Proses Cetak Dokumen SKRK', '2025-10-18 11:18:01', '2025-10-18 11:18:01'),
(284, 32, 8, 'Dokumen SKRK selesai!', '2025-10-18 11:19:00', '2025-10-18 11:19:00'),
(285, 34, 4, 'Entry Registrasi', '2025-10-21 00:04:50', '2025-10-21 00:04:50'),
(286, 34, 8, 'Entry Permohonan', '2025-10-21 00:06:40', '2025-10-21 00:06:40'),
(287, 34, 8, 'Disposisi kepada Gaosul Muhyi, ST. pada tahapan Survey Berkas', '2025-10-21 00:06:40', '2025-10-21 00:06:40'),
(288, 34, 9, 'Entry Data Survey', '2025-10-21 00:08:06', '2025-10-21 00:08:06'),
(289, 34, 9, 'Upload Berkas Survey', '2025-10-21 00:10:11', '2025-10-21 00:10:11'),
(290, 34, 9, 'Upload Berkas Survey', '2025-10-21 00:10:11', '2025-10-21 00:10:11'),
(291, 34, 9, 'Disposisi kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-21 00:11:34', '2025-10-21 00:11:34'),
(292, 34, 9, 'Selesai Survey Data SKRK', '2025-10-21 00:11:51', '2025-10-21 00:11:51'),
(293, 34, 9, 'Proses Analisa SKRK', '2025-10-21 00:11:51', '2025-10-21 00:11:51'),
(294, 34, 10, 'Entry Data Kajian Analisa', '2025-10-21 00:12:40', '2025-10-21 00:12:40'),
(295, 34, 10, 'Entry Data Dokumen SKRK', '2025-10-21 00:13:48', '2025-10-21 00:13:48'),
(296, 34, 10, 'Upload Berkas Analisa', '2025-10-21 00:14:36', '2025-10-21 00:14:36'),
(297, 34, 10, 'Upload Berkas Analisa', '2025-10-21 00:14:36', '2025-10-21 00:14:36'),
(298, 34, 10, 'Selesai Analisa Data SKRK', '2025-10-21 00:14:42', '2025-10-21 00:14:42'),
(299, 34, 10, 'Proses Verifikasi Data SKRK', '2025-10-21 00:14:42', '2025-10-21 00:14:42'),
(300, 34, 7, 'Disposisi kembali kepada Gaosul Muhyi, ST. pada tahapan Survey', '2025-10-21 00:15:52', '2025-10-21 00:15:52'),
(301, 34, 7, 'Disposisi kembali kepada Nanik Adrianti, ST. pada tahapan Analisis', '2025-10-21 00:16:35', '2025-10-21 00:16:35'),
(302, 34, 9, 'Selesai Survey Data SKRK', '2025-10-21 00:18:39', '2025-10-21 00:18:39'),
(303, 34, 9, 'Proses Analisa SKRK', '2025-10-21 00:18:39', '2025-10-21 00:18:39'),
(304, 34, 10, 'Selesai Analisa Data SKRK', '2025-10-21 00:21:19', '2025-10-21 00:21:19'),
(305, 34, 10, 'Proses Verifikasi Data SKRK', '2025-10-21 00:21:19', '2025-10-21 00:21:19'),
(306, 34, 7, 'Selesai Verifikasi Berkas SKRK', '2025-10-21 00:23:28', '2025-10-21 00:23:28'),
(307, 34, 7, 'Sedang Proses Cetak Dokumen SKRK', '2025-10-21 00:23:28', '2025-10-21 00:23:28'),
(308, 34, 8, 'Dokumen SKRK selesai!', '2025-10-21 00:24:45', '2025-10-21 00:24:45');

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
('05QtFSD5XnyERYLlwgZ510K7qCEGxEQbZCfU9Irc', NULL, '45.148.10.243', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWXFuTUhxOEowYUdDbFMzd0JGVHJta0FleGJoQnBQcUFqcTFkOFFsWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8zNC40NS4xMjkuNjcvP3BwPWVudiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761241497),
('0dgOBqF3fK1T6zcUNc4ooUveHAqx7zWXzQY0I4Q9', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoib25RSG9mQ2FYZ0hGSnYwbGVlbDUxTEd3YklqSG80N1lydXZoMTdOeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761251751),
('35GXrpCuqy2pXtfENEe9elgMEe09AUDLjG04Oiss', NULL, '149.50.97.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5030.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmN3Zk93TzFtTnA4V3d3QU0ySUtzd1ZvNjYycGxlMTU5WFlvclJoTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761241122),
('3Sf3QGb9IgtO6iX9G0pWPTJIIxc2XGswXYVgJphg', NULL, '34.77.159.182', 'python-requests/2.32.5', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUtwM2hBSDNjc3BtbmxaZkxFZVUxanQ3M2VYZ3RkSWJlcVh3eEJLaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761273809),
('4Hma5LPjyUcC0eyDLfY257eOKE1GF205nbDzuujz', NULL, '216.180.246.150', '\'Mozilla/5.0 (compatible; GenomeCrawlerd/1.0; +https://www.nokia.com/genomecrawler)\'', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNFpMQjFwbzI4enZNMGdMaUY2d0hQNUk3U1ZsWVptYmhVYzNGMDZhMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761265342),
('4JaPCgYg2lwOL9PJLd20Qij91EoZyui69Jrek8oU', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZlFYU0taaVZFVGk2V1ZzMmN5RnFQeFVnVUM4VklqY1kyQ0xocUpscCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761240607),
('4nHDLUbl4L5yoD6VXfQcmzFImPoHsOIfBTMDz4Kc', NULL, '66.228.53.136', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 13_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUQ4Y09PUmxxcmpYSk83Znh6dWV2SzE1bm5uUnE1cktzdTVuRWM1ZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761214702),
('4osdyMaiu6ea4W7sHnc9REaOMy5HaFxcYOjjzsjP', NULL, '202.239.228.59', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVVZpOExYUVZzbzBOV043VFdDUEl3bW1wZHN3dUxEdmVUcE5EcEl5TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8zNS4xOTIuMTIwLjEzMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761268115),
('4QmNiGjwliFyEVEpH2nV4ZMpPHy1nI44F0YLSrlN', NULL, '47.242.24.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZWpSOWlLUGVPRW44SjIxUDRYczVnQXF1N05rYlFDVllVM0hHc2s4bSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761223902),
('52wWmEvXqssarL51yZnVgcrHJaTFIATfHRnr10nE', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzdQeFdsQWp2d3JwdGFvN2k1akJUOUFjSEI4MjVMZHFoOVNJc3ZvMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761272585),
('6a3ZiL0tDzWxmtNPuyYYOQA2HWsa7qlMIMgJGko4', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlJMZVg2RnJ5aGFscmlUbEZzbWpjeFpQNGc2Y1NRSzVoYTlURjNaaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761234648),
('6zFadVK8UGSs7OmACibULFNF6oswmjRyU2GbphXK', NULL, '93.174.93.12', 'Mozilla/5.0 (Linux; U; Android 7.0; en-US; PRA-LX1 Build/HUAWEIPRA-LX1) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.108 UCBrowser/12.13.0.1207 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQnZFZlFTTnVCQXhyekF3aGhXTTdDb0pzdHZRUUhkcTJ3Q2VnWTBEOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8zNS4xOTIuMTIwLjEzMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761224665),
('7DL4D3Cb7nSSzCNrPXiF1l020wfeXUVANlecxOBe', NULL, '108.129.230.19', 'ip9max/1.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiY2sycVFIMEZXdGVFaHBwbndPZVlkYUZiVU9NcUlXWWx5azZ5Y1dKaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761248731),
('8WSjdo6SNBWauXfVwIciR0vI9niqhnCG73XF8tCf', NULL, '193.142.147.209', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicXdqU0I1d1Z3SVVMQ3hPQVJSOVVzSU9EdFdWRkZDbml4WjlEVlEzWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761253951),
('93JW38XYi2Ao9EOSvBTMtPTYfVWI9W3tuIFimgZL', NULL, '159.192.72.194', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0NqRURQWW1wbnk2cnNKMkFjQ1JMUk9EZ0JreU1vdlRMTFRhbGJrViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761262031),
('A5jG60LiGl8B2ZxhriAz6Qg6tkb6clS4jQAiFwy7', NULL, '45.148.10.243', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidVdHcmhNb2gydTVpazJjbzRUdlo0YmpwdkN0aEllQmtXYTNTN1Z1TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8zNC40NS4xMjkuNjcvP3BwPWVudiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761241497),
('aFkP6xGAxDCizNQT9GxQVk6vuEySJ4WqHQBGoFJa', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiREIzcmNjUmd5OHllYVExMzVFMjEyNERHSlNibDdJQ0N1NlJwdEhXZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761269394),
('AVCZd6JhZlRA1XRf8JPSmqh4uKFr9swjEYLuu1AX', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWUZJWkhFYUhHQXJSZ3BzMUlhb0VoN3RZRmZuMkpVa2hIVHp1RUFFcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761258926),
('B3goSspGuiptytWGFfpuS3K5vMabcUCbQPBqDdzQ', NULL, '34.79.180.31', 'python-requests/2.32.5', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS1lLWmVKWjdOeEtHU25NUkZmUE1QelpYaWhJbVpzMElyZTc2SWszSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761216152),
('BeSLuPtRrimFFzYRbCQVXIDt6tS2WgDNAjeRvod4', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRlJsYWQ3RHFSaG1FZWx6OWptOGp4b2Q5WlpJRjJMSUUxQlZlS1VmeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761268003),
('BTl9IBagDnEoMVPtR950iJLDIBvkOVdCEjWcl0Wm', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoidWd4cmtlWlVCM0x6ekFvbjJIVkJQYmxEbzdwUlhXR09pTnZsMWJIUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761229767),
('BXBGrd81gFhrE75dBGLBJr31nQjWr5tMYT8CnQVb', NULL, '103.252.89.75', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaUFYaXBFM1VpUkxwcU1kVGprS0RqRll4YUhwbXlUY3c5Q0Z6Wm1XTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761267048),
('BY0zGEAEgv6vKJauHNLPEjftAJnYsTlsHozxoO2G', NULL, '206.168.34.214', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWdWTmw2NVZoWU1EcGVBNHl0dk5sSVNiVWJMTjRGVUIzQ1A4ZnBDWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761217104),
('c0iatnFJfwXxtgnccJOoHFZdRb9Oxrjj8LMbWXl7', NULL, '157.55.39.9', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib0VSZmhLNlJxQTV0RzZ4YWZSbmt0WVE4STRzRllvam95Uk8yTUxWSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761260381),
('ckuLy3HOo1wSegDILugyzhiDHTiAtgv81LJOGQ7L', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1N4bjZOVGY5cXV5SXUzRFJ1bHR3T1I1ZFlTN3F5N1I4SjQwZ3NJSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761249161),
('doHLw6cB00usYNB3RDzJTExI8Sil9JG3J5J9VUGp', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic2haaW5PSFdmczZUWnVhSFQxQkloTGxNcDRROG9weDhHeGZjS1JHZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761213618),
('ETWgvrOfhp7Y5ViQGzy1sOGtormhB8Rfk1cs9Zql', NULL, '193.142.147.209', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZWY0Mm5aNDJGYm5HcXNlRWk5bURaWExxVVdKYzlZaENqU2lNS0VJQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761227931),
('EXfcEAd8QwmG9Su2LjnhUQUgjKoV570uN4T8DOAA', NULL, '46.226.162.162', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMVBkSXVKVXdMM0VvRUpvcjlHRmhEbE8wV3J6dGJoWjlpbTIwVWJHYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761251627),
('GK683jTTRBZME0oGWVueE8hOt6mUT4at9QLU8QvY', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYkRWa1k1UlhJR216Y3U1WmlpN3VLYUF3QkNzQUN4Yms2TnpNeVpHMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761236867),
('HbLAyvYpCK1XCVpqWRDSnoDxJE3mrIEvIGMVeXM8', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjJjdERpTUlJaGtKUXdLUmxzZmNZY3JyejBVT2QxM3FubzFUT0VKRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761260701),
('hzWMbgrSbdTwQXRGtsDfLWLv2J2G6ece1zQAG4Jr', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRlpLVXliblRoNWJoQlY0dVBtS3dHMEtnZzRiSVZTVHd6VkJPT1VJUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761236156),
('im5Bh14XKQ1O0r974I0GUbMitDFMMr7lPvkjguA1', NULL, '93.174.93.12', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiakVTSFZYeWtQb2dmbGdlcnlMYXZsOTRIdVkzSUVvQWFlMExmZ09PZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8zNS4xOTIuMTIwLjEzMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761243489),
('jEdzCEA2JABH8rPxKnA0Ou8rR9KT2tGh69KXwy3C', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZnhUMTlrZzJVWHVvczFqZFRpSmFSNHVFYzgwQzBYSG5RMmxlYW9VOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761266893),
('JiqUYLkVonimdlFPgWQKzgdhPyXc29G7GppxH2Mf', NULL, '45.33.12.122', 'Mozilla/5.0 zgrab/0.x', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib0dpa1NSdUpobUJqbkZVYktmbXozOThJV3lvaGdFdU5va1F3WlVKdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761215667),
('jq1dlQmETUWddxJSl7jOjRVwcBsuso4u794IT8Fu', NULL, '205.210.31.5', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNmlkZ1hGMzlQSDZ2SGloWTlCYzlzVVBrYXBPU3pRQTNISWlEUFNQNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761244523),
('JSRxDRKU9VsF9JtFYLyquJq1cXTSuX1XODaQuMfi', NULL, '172.236.119.165', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 13_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0pPcUhyMWVpZTcyMFBpNW81dlZOZFN2S2dSOFVCZENrczhEU2tOQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761215677),
('Jt0eU0awaYfp0TIJ8Y7HblZH2f7cMrX6EdhmnHvl', 1, '125.164.40.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiak1SU1M3UHJUNFZsZHN1S2MyWk1NQTc4c0hlU2tSV2Zid29oMlBKeSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxOToiaHR0cDovLzM0LjQ1LjEyOS42NyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761274338),
('jZ3yFQODh7ZKXJueio6Iw3pKUVIclT3egUvGwPpQ', NULL, '204.76.203.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiamI3S013R3FkQ0ZKWlFoZ25iRkJaVkZLRnkwdUx2WTljbFp3YlBQQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761241424),
('k7WeELafA3RvOGbiUnI9QxHmrX2tpXVGaxMc0bJc', NULL, '204.76.203.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTmVKeVJLVm9qQldVelRDdTFRcG9Md2FIUnBub0Q3WGNaYkczTXM0NyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761218453),
('L7CY9zAKqwaPrtBqnxeecg0OgCMqdkjJ63xyTtLB', NULL, '185.247.137.242', 'Mozilla/5.0 (compatible; InternetMeasurement/1.0; +https://internet-measurement.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjQwdDRwRE5iYWtmRFp3WjRzMGhTM01heHg0Q1RTMVZVM1B1T0YyUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761221622),
('LnDsnbaALJuXpzruld4hRl7lFKpPtUdaOhOLl8t7', NULL, '204.76.203.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYklxNzBwbXlvaU81WXpaZ1pLSDB3SURqRHJ6QWpBdEd1UmhXQUdJSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761230697),
('lPc3lxIm8sHL0TTC8hlLKWfUr7I3mEWTTgnNCgTm', NULL, '185.238.231.148', 'python-requests/2.32.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVXNyTXpGb3VlUndEVGN3dmw4RlBGVjNRdnNuMmRJT21nZXdtRFZkUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8zNC40NS4xMjkuNjcvPyUzQ3BsYXklM0V3aXRobWUlM0MlMkYlM0U9Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761239661),
('Mb4BIiF5C2JkpkS3KDxa6mU6kIL1IlR411VwKwYy', NULL, '185.242.226.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnVxQkFKa0ViNDIwWTJRNkdDemg2Z252WUQ4S3UyWHBGSlFkWnpzQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761229786),
('mgPHpjTx2swSGN24MZV0yi55h41mWhXR4PMb8oh3', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZGJlY0FLZ2lHRm9SZnpwZ3VWZjNkT2h6OFNEdHFEZmtCRjBNclNwZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761238396),
('NgEJHhDPLj4wR942ZV0oNLjyd1VlCcax62VRuhX5', NULL, '54.160.134.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0RrRmxsalFOY1N3OUNERGxVOXhaUHJXRGMxMmFyNlFHRHZnSlYwdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761232132),
('nkTPfUrd6vciMMj4O07shcIhxxBsc9vYCImPIaw7', NULL, '204.76.203.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiQjBtY25XZEFVTEk4aXg1RDltN2N1YldydVpTNUttS05rQ3JVQlB6VSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761253100),
('PASTHn36jG5RvypPd3CsJtYOosgN9snzU4L2cXW5', NULL, '135.237.125.156', 'Mozilla/5.0 zgrab/0.x', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibEFkYUR6N0xLU2czMVFpM1RzU21SVmJkb2dDeHdrZ1VucTI1UHlsVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761255137),
('PhEt02fAlC49Wdr1rbvg6UFkJfhv3oiAoOuZTEwm', NULL, '103.203.57.3', 'Mozilla/5.0 zgrab/0.x', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieXQ0dEphb092S0JScWZEZEtYZW1zWmIxRk5LMEo5QmQydGt4c1ZyMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761227723),
('PiZfJNV4RYJZdBtaItYY8jmmYUurpeupan0rr4mT', NULL, '45.148.10.243', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib3N6RGgycjA2c2xRNlNPclZUSEx3Wm1YT01ERk1NWkU2aVM1TmRCUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8zNC40NS4xMjkuNjcvP3BocGluZm89MSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761241491),
('Q4jfFg6q7SZNI6kANos3TuFuwjrRO9SSQ58LioaF', NULL, '45.148.10.243', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWU9XblA0d2VSM2praExnUlYyTXE2TTRnUUZxTTB4U21BMjlRaFpvWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8zNC40NS4xMjkuNjcvbG9naW4/cHA9ZW52Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761241498),
('Q93Jg7K7BF7c9FaJCKLLtnfoiDGNp51waQhszIYb', NULL, '195.160.220.89', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2lFdnFBTWtHQVhtcm1xSEYxcERCejVZQWljMkJ1MVN1eE5wamFuVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8zNC40NS4xMjkuNjcvaW5kZXgucGhwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761232751),
('qCla8HzJcqgZgniKSHLYlxoxwJ5jtaNb8CTIznmM', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0FtdDdtTGJXT29WS2EzRW5BenY3UUgxZ0M1SkdDdU1VV3RFUUZKdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761226012),
('qfS1OhverqwT9jxC29Zz01iQN8l7g54Q7VCT8JZy', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZVMyenJCZXBucnFYSDRHWUlPY1NKMDhtZ01TVWluOUJYZUVjV2xPNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761244037),
('QtGxXsnZWqmW7l0FIduvXxktBwmQRC6em6yBYw9S', NULL, '193.142.147.209', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiajBJNzZFZkd6cW1EOUQwTFNIbGNDT0JhU01Xb1k3VVhPQk92VzN5aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761220028),
('QUtMgWiU9k9V6IzHo6kHbpcXNT7mMRnrRqa5UFf9', NULL, '138.197.3.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVXlpdnlqNERGaXc1REZjRExWc0J6YU95Z0lFcnRvS3VuSUVvZnpLRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761236933),
('rRpXWJktlorVsB1AFyG6LIuEXBcxbWtmHtfzEqlk', NULL, '79.124.40.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlh4SkNYZ1o5VTkxekVvbWpqV1RDbUZrNGcyRlpTVmlodFhxeWpOUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8zNC40NS4xMjkuNjcvP1hERUJVR19TRVNTSU9OX1NUQVJUPXBocHN0b3JtIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761229835),
('RYECNVFG0RcZJrqiB1daAui9J0QJRxBQUCipYNXO', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiR1NxcjdxWVBDcGt1SXJJN3FRZWV2blR1WG9xMHM2MEdmVTlkMVNhdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761274098),
('sqPS7OxyGl88VlaaBLnDTAq6prjiaesg8xJxz3YN', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnZIRDNxdWp4NDExWmpTaDUwcldjaG10NzVtb2JZc3g5dTBFenFIaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761243353),
('tAA86vowqUFbkmMva02SM8DsCaiRPcHTAVDcbP12', NULL, '45.148.10.243', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRW5sbGJ4UkJxdzl1c3RrTTVLUGdYM3JubEMzYlR2cXlFbE9zOENwYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761241497),
('teQHUyX8JAE7tsSlxBqfe1hxDbxGkCCR0jzg393u', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmpaalREVDdzZkRMRGhtRmtTejZ0emZBTVc5enRjczh6UVBVcUowZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761263459),
('tjrZXWxGWx8Nw5rbKV1UcUG4JqdX9z38kum6bzjK', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR0VNM0Jxdkl4S1RpSmlGclhTMUZsZGpSbUN5NWZobDNzMWV2NnhzQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761257662),
('txVlD8SQrR4rRrBPnjJijH4T2qkNHl6L0USucjAf', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZ0cyZzI5dkJiNUtJRHh1b0tySjJKSFlFZjUwVUxISHo0MEZ4UnQ3WiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761207990),
('UnPKZiVtK2NRTk4TzQnZ7bDIyjTZUcZWGrEfhYkY', NULL, '216.180.246.150', '\'Mozilla/5.0 (compatible; GenomeCrawlerd/1.0; +https://www.nokia.com/genomecrawler)\'', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMTQ4cmNjT2g4bzJrR1Z1MnppUnF2WTFPdEpoNTA3R3Zoc0JpTmZKaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8zNS4xOTIuMTIwLjEzMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761265299),
('vnTQz05vEvhlBo4s0auSK0AGaTl4SbmA2tJdvnM6', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRDJYNjVUYXBabUpmUjZGVGJnZjY0YVpVN1drWW5FTm05YjBZV0ZOMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761245882),
('VYA1v3BHUGybMJRUlvAsBW0jZsUam8qrvAd7ahWw', NULL, '78.153.140.178', 'Mozilla/5.0 (iPhone; CPU OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.1 Mobile/14E304 Safari/602.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOHY4U3ZLT2VoV093S2d4N1VJZVFOTnF2U3p4N3NTdEZjb2FoaVFoQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8zNC40NS4xMjkuNjcvP3BocGluZm89LTEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761238507),
('W9ebQRO7YhtppKNhxTwerJLpT1oPDZSU0NrUeLho', NULL, '87.120.191.93', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMzlDYXk0ckpHa2FDWlU4cHRpVGFBR1Bzc1NCc0tIUTltZ2NkNnFJWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761218056),
('WIHdhtOVMYU2637qeqd7owzdCiuleIc57zAgLYYh', NULL, '204.76.203.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYk1EU05RSHk0bDhGcXZqVVIyeGNQYldSRTdITFFLZmRZVmxxTnVXcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761264111),
('y120O6bkHxoF7PGHfFcoIhh59y7BaLcR7uMT2gFE', NULL, '64.62.197.167', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/92.0.4515.159 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQVVLQzhDWlZ1QXZPWDR5aXhadGR6Q0x2eE5iNndVc0o3RmtnV0NWSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761220581),
('YnLlJrW9kYq7MLddmXzsE7U1gPYfLlQGoLHKsBGG', NULL, '45.153.34.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYnp3dzl3VnJaajg0Ym1WYlhUcUFQSGUwU1J5d3JyazRaVlVaN08wYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761232432),
('Z4qnIh7ib170RqdqpT4lhomoNBow0v0q85RNj2re', NULL, '45.148.10.243', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRExqUzM0SVFETWhFbENOQldmSUFPQmprdkFXRzJoSmhEOGhHWTBFdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly8zNC40NS4xMjkuNjciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761241488),
('zgR8P9QKbc9om8kcrRrz4u3Y876kDYQOkOf1zLzM', NULL, '204.76.203.212', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVWFaNk9QUDBQTkJqUktmVWdDRnFybjRsSE5BVk1NTjd2aElMMDNsbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761207788),
('ZWYPGTXMTC61lqBWOkvzV4MJ3WroA912aSCP0gcp', NULL, '204.76.203.219', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.85 Safari/537.36 Edg/90.0.818.46', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoieEwwYTVscmc5UEFZMDE5bWhpWGRUTG84ZmREWDhJU1hHN0I5ZllVYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761222266);

-- --------------------------------------------------------

--
-- Table structure for table `skrk`
--

CREATE TABLE `skrk` (
  `id` bigint UNSIGNED NOT NULL,
  `permohonan_id` bigint UNSIGNED NOT NULL,
  `layanan_id` bigint UNSIGNED NOT NULL,
  `tgl_survey` date DEFAULT NULL,
  `penguasaan_tanah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ada_bangunan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skala_usaha` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `koordinat` json DEFAULT NULL,
  `luas_disetujui` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pemanfaatan_ruang` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peraturan_zonasi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kbli_diizinkan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kdb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `klb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gsb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jba` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jbb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kdh` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ktb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luas_kavling` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jaringan_utilitas` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `persyaratan_pelaksanaan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gambar_peta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_survey` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jml_bangunan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jml_lantai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luas_lantai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kedalaman_min` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kedalaman_max` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_survey` tinyint(1) NOT NULL DEFAULT '0',
  `is_berkas_survey_uploaded` tinyint(1) NOT NULL DEFAULT '0',
  `is_kajian` tinyint(1) NOT NULL DEFAULT '0',
  `is_analis` tinyint(1) NOT NULL DEFAULT '0',
  `is_dokumen` tinyint(1) NOT NULL DEFAULT '0',
  `is_berkas_analis_uploaded` tinyint(1) NOT NULL DEFAULT '0',
  `is_validate` tinyint(1) NOT NULL DEFAULT '0',
  `batas_administratif` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skrk`
--

INSERT INTO `skrk` (`id`, `permohonan_id`, `layanan_id`, `tgl_survey`, `penguasaan_tanah`, `ada_bangunan`, `skala_usaha`, `koordinat`, `luas_disetujui`, `pemanfaatan_ruang`, `peraturan_zonasi`, `kbli_diizinkan`, `kdb`, `klb`, `gsb`, `jba`, `jbb`, `kdh`, `ktb`, `luas_kavling`, `jaringan_utilitas`, `persyaratan_pelaksanaan`, `gambar_peta`, `foto_survey`, `created_at`, `updated_at`, `jml_bangunan`, `jml_lantai`, `luas_lantai`, `kedalaman_min`, `kedalaman_max`, `is_survey`, `is_berkas_survey_uploaded`, `is_kajian`, `is_analis`, `is_dokumen`, `is_berkas_analis_uploaded`, `is_validate`, `batas_administratif`) VALUES
(4, 4, 1, '2025-09-19', 'sudah', 'Ada', NULL, '[{\"x\": \"3434\", \"y\": \"342342\"}, {\"x\": \"24332\", \"y\": \"2423\"}, {\"x\": \"2423\", \"y\": \"2432\"}, {\"x\": \"2342\", \"y\": \"2432\"}]', '34324', 'Perjas', 'erfgfdg', '24342', 'dsfsdf', 'dsfsd', '12', '12', '12', '20', '22', '23', 'dfs', 'efdsfs', NULL, '[\"skrk_foto_survey\\/REG-0004_fqPS4.jpg\"]', '2025-09-19 11:16:35', '2025-09-19 22:22:09', '1', '3', '1233', '40', '0', 0, 0, 1, 1, 1, 0, 0, NULL),
(6, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-21 10:45:17', '2025-09-21 10:45:17', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL),
(7, 7, 1, '2025-09-22', 'sudah', 'Tidak Ada', NULL, '[{\"x\": \"1213\", \"y\": \"113123\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}]', '3423', 'Perjas', 'erfgfdg', '24342', 'dsfsdf', 'dsfsd', '12', '12', '12', '20', '22', '23', 'dfs', 'efdsfs', NULL, NULL, '2025-09-22 01:45:42', '2025-09-22 07:34:16', '2', '2', '3', '3', '3', 1, 0, 1, 1, 1, 0, 0, NULL),
(8, 8, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-24 11:42:24', '2025-09-24 11:42:24', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL),
(9, 9, 1, '2025-09-26', 'SHM NIBEL 23.07.000010494.0 Seluas 118 m2, SHM NO. 01491 seluas , SHM NO. ', 'Ada', NULL, '[{\"x\": \"116°4\'45,011\\\"E\", \"y\": \" 8°35\'42,049\\\"S\"}, {\"x\": \"116°4\'45,015\\\"E\", \"y\": \"8°35\'42,631\\\"S\"}, {\"x\": \"116°4\'44,317\\\"E\", \"y\": \"8°35\'42,544\\\"S\"}, {\"x\": \"116°4\'44,313\\\"E\", \"y\": \"8°35\'42,084\\\"S\"}]', '361', 'rumah kost', 'perumahan kepadatan tinggi', '55900', '211', '55900', '12,50', '3', '1,5', '7.21', '55900', '-', '-', 'kkkkkk', NULL, '[\"skrk_foto_survey\\/REG-0007_tssy2.jpeg\"]', '2025-09-26 01:21:05', '2025-09-29 00:25:32', '1 unit', '2 lantai ', '-', '-', '-', 1, 0, 1, 1, 1, 0, 0, '{\"barat\": \"bangunan rumah tinggal\", \"timur\": \"bangunan rumah kost\", \"utara\": \"jl. cilinaya baru\", \"selatan\": \"saluran\"}'),
(10, 10, 1, '2025-09-30', 'sudah', 'Ada', NULL, '[{\"x\": \".6666\", \"y\": \"7777\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}]', '21312', '1231', '1231', '1231', '1231', '1231', '123', '1231', '1231', '1231', '1231', '1231', '1231', '1321', NULL, NULL, '2025-09-30 00:08:53', '2025-10-01 06:27:14', '2131', '213', '1233', '1231', '1231', 1, 0, 1, 1, 1, 0, 1, '{\"barat\": \"Hhh\", \"timur\": \"Yy\", \"utara\": \"Ggg\", \"selatan\": \"Hhh\"}'),
(11, 11, 1, '2025-10-09', NULL, NULL, NULL, '[{\"x\": \"112\", \"y\": \"13131\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"skrk\\/gambar_peta\\/REG-0011_oYwMW.jpeg\"]', '[\"skrk\\/foto_survey\\/REG-0011_jJXXc.jpeg\"]', '2025-10-03 02:49:36', '2025-10-08 21:54:35', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, '{\"barat\": \"sungai\", \"timur\": \"ruko\", \"utara\": \"tanah kosong\", \"selatan\": \"rumah tinggal\"}'),
(12, 12, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-07 01:41:14', '2025-10-07 01:41:14', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL),
(13, 13, 1, '2025-10-09', 'sudah', 'Ada', 'kecil', '[{\"x\": \"231\", \"y\": \"2131\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}]', '3423', 'Perjas', 'erfgfdg', '24342', '40', '34', '34', '3', '3', '34', '30', '-', '231', 'wefdsfdsfsdfsfsfsf', '[\"skrk\\/gambar_peta\\/REG-2025-0013_t3Vpe.jpg\",\"skrk\\/gambar_peta\\/REG-2025-0013_0rcbt.jpeg\"]', '[\"skrk\\/foto_survey\\/REG-2025-0013_I1Owv.jpg\",\"skrk\\/foto_survey\\/REG-2025-0013_4Rc6c.jpg\"]', '2025-10-09 06:51:24', '2025-10-09 07:37:16', '1', '3', '3', '40', '3', 1, 1, 1, 1, 1, 1, 1, '{\"barat\": \"sungai\", \"timur\": \"ruko\", \"utara\": \"tanah kosong\", \"selatan\": \"rumah tinggal\"}'),
(14, 14, 1, '2025-10-02', 'SHM NIBEL 23.07.000010494.0 Seluas 118 m2, SHM NO. 01491 seluas , SHM NO. ', 'Ada', 'menengah ', '[{\"x\": \"7547\", \"y\": \"457444444\"}, {\"x\": \"4444457\", \"y\": \"4555555574\"}, {\"x\": \"45757\", \"y\": \"457454\"}, {\"x\": \"74574\", \"y\": \"474745\"}]', '361', 'rumah kost', 'perumahan kepadatan tinggi', '55900', '211', '55900', '12,50', '3', '1,5', '7.21', '55900', '-', '-', 'kkkkkk', NULL, '[\"skrk\\/foto_survey\\/REG-0014-SKRK-10-2025_lPq3F.jpeg\"]', '2025-10-13 07:38:12', '2025-10-14 01:13:07', '1 unit', '2 lantai ', '-', '-', '-', 1, 1, 1, 1, 1, 1, 0, '{\"barat\": \"bangunan rumah tinggal\", \"timur\": \"bangunan rumah kost\", \"utara\": \"jl. cilinaya baru\", \"selatan\": \"saluran\"}'),
(15, 15, 1, '2025-10-13', 'sudah', 'Ada', 'kecil', '[{\"x\": \"1231\", \"y\": \"1231312\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}]', '3423', 'Perjas', 'erfgfdg', '24342', 'dsfsdf', 'dsfsd', '12', '12', '12', '20', '22', '23', 'dfs', 'efdsfs', '[\"skrk\\/gambar_peta\\/REG-0008_C9tKZ.jpeg\"]', NULL, '2025-10-13 12:57:04', '2025-10-13 13:11:07', '1', '3', '1233', '40', '3', 1, 1, 1, 1, 1, 1, 1, '{\"barat\": \"sungai\", \"timur\": \"ruko\", \"utara\": \"tanah kosong\", \"selatan\": \"rumah tinggal\"}'),
(16, 16, 1, '2025-10-15', 'Nomor 124512', 'Ada', 'kecil', '[{\"x\": \"28317\", \"y\": \"341712\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}]', '3423', 'Perjas', 'erfgfdg', '1231', 'dsfsdf', 'dsfsd', '12', '12', '12', '20', '22', '23', 'dfs', 'efdsfs', '[\"skrk\\/gambar_peta\\/REG-2026-SKRK-10-2025_xklxW.jpeg\"]', '[\"skrk\\/foto_survey\\/REG-2026-SKRK-10-2025_2vcWE.png\"]', '2025-10-13 21:29:34', '2025-10-13 21:41:47', '2', '2', '1233', '40', '3', 1, 1, 1, 1, 1, 1, 1, '{\"barat\": \"sungai\", \"timur\": \"ruko\", \"utara\": \"tanah kosong\", \"selatan\": \"rumah tinggal\"}'),
(17, 17, 1, '2025-10-14', 'sudah', 'Ada', 'kecil', '[{\"x\": \"1231231\", \"y\": \"21414431\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}]', '3423', 'Perjas', '1231', '1231', '40', '1231', '12', '12', '3', '20', '30', '23', 'dfs', 'Agar memperhatikan B3', '[\"skrk\\/gambar_peta\\/REG-0009_S6SKk.jpeg\"]', '[\"skrk\\/foto_survey\\/REG-0009_FZFTH.jpeg\"]', '2025-10-14 00:06:48', '2025-10-14 00:26:52', '2', '3', '1233', '40', '1231', 1, 1, 1, 1, 1, 1, 1, '{\"barat\": \"sungai\", \"timur\": \"ruko\", \"utara\": \"tanah kosong\", \"selatan\": \"rumah tinggal\"}'),
(18, 18, 1, '2025-10-15', 'Sesuai dengan nomor Sertifikat Hak Milik Nomor SHM 23421', 'Tidak Ada', 'kecil', '[{\"x\": \"12313\", \"y\": \"1231231\"}, {\"x\": \"123123\", \"y\": \"123123\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}]', '3423', 'Perjas', 'Jangan membangun lebih dari 10 Lantai', '21431', '40%', '2,5', '13', '2', '2', '2', '3', '23', '-', 'harus ada pengolahan limbah B3', '[\"skrk\\/gambar_peta\\/REG-2028-SKRK-10-2025_qirJ6.jpeg\"]', '[\"skrk\\/foto_survey\\/REG-2028-SKRK-10-2025_Zau9k.png\"]', '2025-10-15 10:28:55', '2025-10-15 10:49:40', '-', '2', '3', '3', '3', 0, 1, 1, 1, 1, 1, 1, '{\"barat\": \"sungai\", \"timur\": \"ruko\", \"utara\": \"tanah kosong\", \"selatan\": \"rumah tinggal\"}'),
(19, 19, 1, '2025-10-16', 'Sesuai dengan nomor Sertifikat Hak Milik Nomor SHM 23421', 'Ada', 'kecil', '[{\"x\": \"76211\", \"y\": \"8331\"}, {\"x\": \"21234\", \"y\": \"112345\"}, {\"x\": \"234938\", \"y\": \"34321\"}, {\"x\": \"34324139\", \"y\": \"34424\"}]', '3423', 'Perjas', 'erfgfdg', '1231', 'dsfsdf', '1231', '123', '1231', '3', '20', '22', '23', '1231', 'harus ada pengolahan limbah B3', '[\"skrk\\/gambar_peta\\/REG-2029-SKRK-10-2025_R8PTI.jpeg\"]', '[\"skrk\\/foto_survey\\/REG-2029-SKRK-10-2025_OnubO.jpeg\"]', '2025-10-15 11:14:18', '2025-10-15 12:45:49', '1', '3', '1233', '40', '3', 1, 1, 1, 1, 1, 1, 1, '{\"barat\": \"sungai\", \"timur\": \"ruko\", \"utara\": \"tanah kosong\", \"selatan\": \"rumah tinggal\"}'),
(20, 20, 1, '2025-10-17', 'SHM NIBEL 23.07.000010494.0 Seluas 118 m2, SHM NO. 01491 seluas , SHM NO. ', NULL, 'menengah ', '[{\"x\": \"454545\", \"y\": \"54543333\"}, {\"x\": \"54535\", \"y\": \"34534\"}, {\"x\": \"35434\", \"y\": \"345345\"}, {\"x\": \"35434\", \"y\": \"3544545\"}]', '361', 'rumah kost', 'perumahan kepadatan tinggi', '55900', '211', '55900', '12,50', '3', '1,5', '7.21', '55900', '-', '-', 'kkkkkk', '[\"skrk\\/gambar_peta\\/REG-2031-SKRK-10-2025_qv79h.jpg\",\"skrk\\/gambar_peta\\/REG-2031-SKRK-10-2025_WMoBJ.jpg\"]', '[\"skrk\\/foto_survey\\/REG-2031-SKRK-10-2025_1dwqd.jpeg\",\"skrk\\/foto_survey\\/REG-2031-SKRK-10-2025_JBAXx.jpeg\"]', '2025-10-15 23:47:57', '2025-10-16 00:40:31', '1 unit', '1 lantai ', '-', '-', '-', 1, 1, 1, 1, 1, 1, 1, '{\"barat\": \"ruko\", \"timur\": \"rumah tinggal\", \"utara\": \"rumah tinggal\", \"selatan\": \"ruko\"}'),
(21, 21, 1, '2025-10-18', 'Sesuai dengan nomor Sertifikat Hak Milik Nomor SHM 23421', 'Ada', 'kecil', '[{\"x\": \"21231241\", \"y\": \"12313\"}, {\"x\": \"13123123\", \"y\": \"12312312\"}, {\"x\": \"12312\", \"y\": \"1312\"}, {\"x\": \"\", \"y\": \"\"}]', '3423', 'Perjas', 'erfgfdg', '1231', 'dsfsdf', 'dsfsd', '12', '12', '12', '20', '22', '23', 'dfs', 'efdsfs', '[\"skrk\\/gambar_peta\\/REG-2030-SKRK-10-2025_XGWRI.jpeg\"]', '[\"skrk\\/foto_survey\\/REG-2030-SKRK-10-2025_tsfoK.jpeg\"]', '2025-10-18 10:54:08', '2025-10-18 11:18:01', '2', '3', '1233', '40', '3', 1, 1, 1, 1, 1, 1, 1, '{\"barat\": \"sungai\", \"timur\": \"ruko\", \"utara\": \"tanah kosong\", \"selatan\": \"rumah tinggal\"}'),
(22, 22, 1, '2025-10-21', 'Sesuai dengan nomor Sertifikat Hak Milik Nomor SHM 23421', 'Ada', 'kecil', '[{\"x\": \"1234214\", \"y\": \"234123\"}, {\"x\": \"23414\", \"y\": \"34124124\"}, {\"x\": \"\", \"y\": \"\"}, {\"x\": \"\", \"y\": \"\"}]', '3423', 'Perjas', 'Jangan membangun lebih dari 10 Lantai', '1231', '40', '2,5', '12', '3', '12', '20', '30', '23', '231', 'Agar memperhatikan B3', '[\"skrk\\/gambar_peta\\/REG-2032-SKRK-10-2025_An254.jpg\"]', '[\"skrk\\/foto_survey\\/REG-2032-SKRK-10-2025_WukOp.jpg\",\"skrk\\/foto_survey\\/REG-2032-SKRK-10-2025_xWwGA.jpg\"]', '2025-10-21 00:06:40', '2025-10-21 00:23:28', '2', '3', '3', '40', '3', 1, 1, 1, 1, 1, 1, 1, '{\"barat\": \"sungai\", \"timur\": \"ruko\", \"utara\": \"tanah kosong\", \"selatan\": \"rumah tinggal\"}');

-- --------------------------------------------------------

--
-- Table structure for table `tahapans`
--

CREATE TABLE `tahapans` (
  `id` bigint UNSIGNED NOT NULL,
  `layanan_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tahapans`
--

INSERT INTO `tahapans` (`id`, `layanan_id`, `nama`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Survey', 1, '2025-09-15 13:45:09', '2025-09-15 13:45:09'),
(2, 1, 'Analisis', 2, '2025-09-15 13:45:17', '2025-09-15 13:45:17'),
(3, 1, 'Cetak', 3, '2025-09-29 03:25:34', '2025-09-29 03:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Imam Ahmad', 'imam@simtaru-harum.com', NULL, '$2y$12$uJgINXHvd3Bz3KHrlla3W.e0sV72uci0pbOmcLdK.OoGw5x0m3t5q', NULL, NULL, NULL, 'eZFqpnYQASRo1OpN9mZ5sDTLwM7FiT9ovkRejrgdoWWrfMZPgm0tMSUVgsYf', NULL, NULL, 'superadmin', '2025-09-15 13:43:04', '2025-09-16 03:25:44'),
(2, 'Budi Mulyono', 'budi@simtaru-harum.com', NULL, '$2y$12$rc3kfmv9tYVqSJDth6kNN.J/SZbR5u9RXphPvcbCoxmidGINYKu72', NULL, NULL, NULL, 'N9huNSvWGII2cEohltyoEHgv1IyUb8Lt0eIgIkN78CZXa8DhmqpJP1R0gy0Z', NULL, NULL, 'superadmin', '2025-09-16 03:24:41', '2025-09-16 03:24:41'),
(4, 'Hj. Endang Umbarwati S.Pd.', 'endang@simtaru-harum.com', NULL, '$2y$12$4/pFa.MGcVyuOPg3O5aFXejhNta4zi49.echEe7uWFRipTsu.7y5a', NULL, NULL, NULL, NULL, NULL, NULL, 'cs', '2025-09-16 05:39:50', '2025-09-21 10:40:43'),
(6, 'Trisna Hartanti Utama, ST.', 'tanti@simtaru-harum.com', NULL, '$2y$12$6pF.XQVdkRMGRZkUpllGaOPWyunZWBMgApezjYGJAEFqceCuaqveq', NULL, NULL, NULL, NULL, NULL, NULL, 'analis', '2025-09-16 07:05:10', '2025-09-19 12:18:24'),
(7, 'Baiq Eka Agusrina, ST.', 'rina@simtaru-harum.com', NULL, '$2y$12$shFXYWCAXkbm0QKOHE4RXOrF0KjqNMYVgwOhpXuV2VpS8iIYqr8kS', NULL, NULL, NULL, NULL, NULL, NULL, 'supervisor', '2025-09-17 00:35:14', '2025-09-19 12:17:44'),
(8, 'Ummu Aima', 'ema@simtaru-harum.com', NULL, '$2y$12$HNrkFBg5A69T8zupuSlKWOF4aWM8MShmz8pbYbeOPny9OAqwFCSDi', NULL, NULL, NULL, NULL, NULL, NULL, 'data-entry', '2025-09-18 05:13:40', '2025-09-19 12:18:50'),
(9, 'Gaosul Muhyi, ST.', 'gaos@simtaru-harum.com', NULL, '$2y$12$OSp4RqmhBgYGce.wZQtNf.kKfSlAjYbQ4zGineIJMcCUjhfQP1y4G', NULL, NULL, NULL, NULL, NULL, NULL, 'surveyor', '2025-09-18 06:12:47', '2025-09-19 12:19:28'),
(10, 'Nanik Adrianti, ST.', 'nanik@simtaru-harum.com', NULL, '$2y$12$Ub0os87NX1YataiIAWI10.9KYYSqcoyIduUVMCDc4.MAGtlojpKPa', NULL, NULL, NULL, 'zGIW500hBjEryTnCRtzIMel2p2fAMrU3gvisO86tS897WbPHZfj6R4QyEKCM', NULL, NULL, 'analis', '2025-09-19 12:20:04', '2025-09-19 12:20:04'),
(11, 'Dewi Ambarwati', 'dewi@simtaru-harum.com', NULL, '$2y$12$b5.e.etrvkNYw90tDFI27Oj.HfnWCz.LybD2n71WF1d8wUuSPpsaq', NULL, NULL, NULL, NULL, NULL, NULL, 'data-entry', '2025-09-19 12:20:53', '2025-09-19 12:20:53'),
(12, 'Bayu Muliawan, SH.', 'bayu@simtaru-harum.com', NULL, '$2y$12$P4kc1TtR.19fx1Xl6yw1uucRewSAwmGlp9YzVeXFTMCQsoPRAbhwG', NULL, NULL, NULL, NULL, NULL, NULL, 'surveyor', '2025-09-19 12:21:44', '2025-09-19 12:21:44'),
(13, 'Dinda Hidayanti, S.PWK.', 'dinda@simtaru-harum.com', NULL, '$2y$12$mmfLKntY4ie6S8fyXvJDKOtia4zSvOTuTC8NK9FwwR/HeumAPGleO', NULL, NULL, NULL, NULL, NULL, NULL, 'superadmin', '2025-09-19 12:23:08', '2025-09-19 12:23:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `disposisis`
--
ALTER TABLE `disposisis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disposisis_tahapan_id_foreign` (`tahapan_id`),
  ADD KEY `disposisis_pemberi_id_foreign` (`pemberi_id`),
  ADD KEY `disposisis_penerima_id_foreign` (`penerima_id`),
  ADD KEY `disposisis_layanan_type_layanan_id_index` (`layanan_type`,`layanan_id`),
  ADD KEY `disposisis_permohonan_id_foreign` (`permohonan_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `itr`
--
ALTER TABLE `itr`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permohonan`
--
ALTER TABLE `permohonan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permohonan_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `permohonan_layanan_id_foreign` (`layanan_id`);

--
-- Indexes for table `permohonan_berkas`
--
ALTER TABLE `permohonan_berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permohonan_berkas_permohonan_id_foreign` (`permohonan_id`),
  ADD KEY `permohonan_berkas_persyaratan_berkas_id_foreign` (`persyaratan_berkas_id`),
  ADD KEY `permohonan_berkas_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `persyaratan_berkas`
--
ALTER TABLE `persyaratan_berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persyaratan_berkas_tahapan_id_foreign` (`tahapan_id`);

--
-- Indexes for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registrasi_kode_unique` (`kode`);

--
-- Indexes for table `riwayat_permohonans`
--
ALTER TABLE `riwayat_permohonans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_permohonans_registrasi_id_foreign` (`registrasi_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `skrk`
--
ALTER TABLE `skrk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skrk_permohonan_id_foreign` (`permohonan_id`),
  ADD KEY `skrk_layanan_id_foreign` (`layanan_id`);

--
-- Indexes for table `tahapans`
--
ALTER TABLE `tahapans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahapans_layanan_id_foreign` (`layanan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disposisis`
--
ALTER TABLE `disposisis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itr`
--
ALTER TABLE `itr`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `permohonan`
--
ALTER TABLE `permohonan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `permohonan_berkas`
--
ALTER TABLE `permohonan_berkas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `persyaratan_berkas`
--
ALTER TABLE `persyaratan_berkas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `registrasi`
--
ALTER TABLE `registrasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `riwayat_permohonans`
--
ALTER TABLE `riwayat_permohonans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;

--
-- AUTO_INCREMENT for table `skrk`
--
ALTER TABLE `skrk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tahapans`
--
ALTER TABLE `tahapans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disposisis`
--
ALTER TABLE `disposisis`
  ADD CONSTRAINT `disposisis_pemberi_id_foreign` FOREIGN KEY (`pemberi_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disposisis_penerima_id_foreign` FOREIGN KEY (`penerima_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disposisis_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan` (`id`),
  ADD CONSTRAINT `disposisis_tahapan_id_foreign` FOREIGN KEY (`tahapan_id`) REFERENCES `tahapans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permohonan`
--
ALTER TABLE `permohonan`
  ADD CONSTRAINT `permohonan_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permohonan_registrasi_id_foreign` FOREIGN KEY (`registrasi_id`) REFERENCES `registrasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permohonan_berkas`
--
ALTER TABLE `permohonan_berkas`
  ADD CONSTRAINT `permohonan_berkas_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permohonan_berkas_persyaratan_berkas_id_foreign` FOREIGN KEY (`persyaratan_berkas_id`) REFERENCES `persyaratan_berkas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permohonan_berkas_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `persyaratan_berkas`
--
ALTER TABLE `persyaratan_berkas`
  ADD CONSTRAINT `persyaratan_berkas_tahapan_id_foreign` FOREIGN KEY (`tahapan_id`) REFERENCES `tahapans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `riwayat_permohonans`
--
ALTER TABLE `riwayat_permohonans`
  ADD CONSTRAINT `riwayat_permohonans_registrasi_id_foreign` FOREIGN KEY (`registrasi_id`) REFERENCES `registrasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skrk`
--
ALTER TABLE `skrk`
  ADD CONSTRAINT `skrk_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `skrk_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tahapans`
--
ALTER TABLE `tahapans`
  ADD CONSTRAINT `tahapans_layanan_id_foreign` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
