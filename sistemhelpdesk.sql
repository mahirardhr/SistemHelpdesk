-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 10:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemhelpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Software', NULL, NULL),
(2, 'Hardware', NULL, NULL),
(3, 'Jaringan', NULL, NULL),
(4, 'Akun/Login', NULL, NULL),
(5, 'Lainnya', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `attachment` varchar(255) DEFAULT NULL,
  `kategori_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pelapor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pic_id` bigint(20) UNSIGNED DEFAULT NULL,
  `prioritas` enum('rendah','sedang','tinggi') DEFAULT NULL,
  `sla_close` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `catatan_selesai` text DEFAULT NULL,
  `tampilkan_di_kb` tinyint(1) NOT NULL DEFAULT 0,
  `user_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `tanggal_selesai` datetime DEFAULT NULL,
  `tanggal_mulai` timestamp NULL DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporans`
--

INSERT INTO `laporans` (`id`, `ticket_number`, `description`, `status`, `attachment`, `kategori_id`, `pelapor_id`, `pic_id`, `prioritas`, `sla_close`, `created_at`, `updated_at`, `catatan_selesai`, `tampilkan_di_kb`, `user_confirmed`, `tanggal_selesai`, `tanggal_mulai`, `rating`) VALUES
(10, 'TKT-AZNTRN', 'laptop mati', 'closed', NULL, 1, 2, 1, 'rendah', '2025-06-11', '2025-06-07 08:53:55', '2025-06-25 10:34:17', 'gsufgsuigfao', 0, 1, '2025-06-25 17:34:17', '2025-06-25 10:33:58', NULL),
(11, 'TKT-WTCSV3', 'jaringan jeleek', 'closed', NULL, 3, 1, 3, 'rendah', '2025-06-12', '2025-06-07 08:55:00', '2025-06-25 10:13:10', 'ashuahsoah', 0, 0, '2025-06-25 17:13:10', '2025-06-11 03:07:31', NULL),
(12, 'TKT-KG6UL3', 'ga bisa login', 'closed', NULL, 4, 3, 3, 'sedang', '2025-06-17', '2025-06-07 08:56:24', '2025-06-17 12:35:37', NULL, 0, 0, NULL, NULL, NULL),
(13, 'TKT-E8IXR5', 'keyboard rusak', 'closed', NULL, 1, 2, 3, 'rendah', '2025-06-09', '2025-06-08 04:40:40', '2025-06-08 05:04:20', 'jangan kuat kuat', 0, 1, '2025-06-08 12:03:56', NULL, NULL),
(14, 'TKT-TBAPJU', 'keyboard rusakkkk', 'closed', NULL, 2, 2, 1, 'rendah', '2025-06-10', '2025-06-08 05:41:32', '2025-06-11 10:26:16', 'waduh', 0, 1, '2025-06-10 15:02:20', '2025-06-10 08:00:21', NULL),
(15, 'TKT-DFQ1KI', 'sistem bug', 'closed', NULL, 1, 2, 1, 'rendah', '2025-06-10', '2025-06-10 07:59:24', '2025-06-11 10:24:39', 'mantap', 0, 1, '2025-06-11 10:07:50', '2025-06-10 08:00:39', 3),
(16, 'TKT-AFP39E', 'sistem bug', 'closed', NULL, 1, 2, 1, 'rendah', '2025-06-12', '2025-06-11 03:11:22', '2025-06-11 03:13:35', 'wasfuds', 0, 1, '2025-06-11 10:13:08', '2025-06-11 03:12:26', 4),
(17, 'TKT-RIJ0UA', 'Masalah Biasa', 'closed', NULL, 2, 5, 1, 'rendah', '2025-06-14', '2025-06-13 03:48:36', '2025-06-13 03:55:48', 'asdfgh', 0, 1, '2025-06-13 10:55:16', '2025-06-13 03:52:02', 5),
(18, 'TKT-YDSBDU', 'Jaringan Lelet', 'closed', NULL, 3, 5, 1, 'sedang', '2025-06-26', '2025-06-13 04:03:54', '2025-06-25 09:57:39', 'keren', 0, 0, '2025-06-25 16:57:39', '2025-06-25 09:57:23', NULL),
(19, 'TKT-HZ9AMS', 'pc rusak', 'closed', NULL, 2, 3, 1, 'sedang', '2025-06-26', '2025-06-13 06:56:04', '2025-06-25 09:56:25', 'bagus', 0, 0, '2025-06-25 16:56:25', '2025-06-25 09:56:12', NULL),
(20, 'TKT-UTUDQ3', 'tidak bisa login', 'closed', NULL, 1, 3, 1, 'sedang', '2025-06-19', '2025-06-13 06:56:16', '2025-06-17 12:31:23', 'mantap', 0, 0, '2025-06-17 19:31:23', '2025-06-17 12:24:07', NULL),
(21, 'TKT-QSB6JM', 'sistem bug', 'closed', NULL, 1, 3, 1, 'sedang', '2025-06-14', '2025-06-13 07:12:59', '2025-06-13 07:13:35', 'login', 0, 0, '2025-06-13 14:13:35', '2025-06-13 07:13:17', NULL),
(22, 'TKT-DBRUTY', 'ga bisa login', 'closed', NULL, 1, 2, 1, 'rendah', '2025-06-15', '2025-06-13 07:37:48', '2025-06-13 07:40:25', 'perbaiki email', 0, 1, '2025-06-13 14:39:24', '2025-06-13 07:38:21', 2),
(23, 'TKT-L4YVEO', 'dgrdrhytt', 'closed', NULL, 2, 2, 3, 'tinggi', '2025-06-14', '2025-06-13 07:44:55', '2025-06-13 08:17:13', 'wokwokwowk', 0, 1, '2025-06-13 14:55:58', '2025-06-13 07:45:38', 4),
(24, 'TKT-IXRVYP', 'pc rusak', 'closed', NULL, 2, 3, 1, 'rendah', '2025-06-14', '2025-06-13 08:09:46', '2025-06-16 08:46:09', 'selesai', 0, 0, '2025-06-16 15:46:09', '2025-06-13 08:13:13', NULL),
(25, 'TKT-DN6GZE', 'ga bisa login', 'closed', 'attachments/tJ8gKT71oOyYUVwWRhJWSjtK6KxlM50w3FIhgVvF.pdf', 1, 2, 1, 'rendah', '2025-06-26', '2025-06-16 08:19:10', '2025-06-25 10:07:06', 'hahkdgagadi', 0, 1, '2025-06-25 17:07:06', '2025-06-25 10:06:50', 4),
(26, 'TKT-OX50OB', 'Aplikasi Word tidak dapat dijalankan. Muncul pesan error \"The application was unable to start correctly (0xc0000142)\".', 'open', 'attachments/kq2bGlLC91AzWlH9fyxTc7OoiEw6N656MIXNXVOD.png', 1, 2, NULL, NULL, NULL, '2025-06-30 13:40:39', '2025-06-30 13:40:39', NULL, 0, 0, NULL, NULL, NULL),
(27, 'TKT-MJK2CY', 'Printer tidak terdeteksi, Printer Canon G2010 tidak muncul di daftar perangkat. Sudah coba ganti kabel USB dan install ulang driver.', 'open', NULL, 2, 2, NULL, NULL, NULL, '2025-06-30 13:41:20', '2025-06-30 13:41:20', NULL, 0, 0, NULL, NULL, NULL),
(28, 'TKT-UZFTL3', 'Lambat saat akses server, oneksi ke shared drive sangat lambat, butuh waktu 3 menit hanya untuk membuka folder.', 'open', NULL, 1, 2, NULL, NULL, NULL, '2025-06-30 13:41:54', '2025-06-30 13:41:54', NULL, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_27_154108_add_no_sap_to_users_table', 1),
(5, '2025_04_30_162632_add_no_hp_and_departemen_to_users_table', 1),
(6, '2025_05_18_124931_create_laporans_table', 1),
(7, '2025_05_24_031524_create_kategoris_table', 1),
(8, '2025_05_28_022116_remove_reporter_name_from_laporans', 2),
(9, '2025_05_31_074155_add_catatan_selesai_to_laporans_table', 3),
(10, '2025_06_04_053648_create_timelines_table', 4),
(11, '2025_06_04_055932_add_status_times_to_laporan_table', 5),
(12, '2025_06_07_160132_add_timestamps_to_laporans_table', 6),
(13, '2025_06_07_163438_add_user_confirmed_to_laporans_table', 7),
(14, '2025_06_08_115156_add_tanggal_selesai_to_laporans_table', 8),
(15, '2025_06_08_122539_add_tanggal_mulai_to_laporans_table', 9),
(16, '2025_06_10_231932_create_ratings_table', 10),
(17, '2025_06_11_095200_add_rating_to_laporans_table', 11),
(18, '2025_06_25_163456_add_tampilkan_di_kb_to_laporans_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('vK2PMuBLsk3hqRZBP3Abmb7WNIuofzqp3AHBwUD3', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicGtFMENmMjFhdm5UUWt6S2JUSFpJTEd6dTFWb0xKWm1XZ0k4VDdWcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWxlIjt9czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Byb2ZpbGUiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1751292225);

-- --------------------------------------------------------

--
-- Table structure for table `timelines`
--

CREATE TABLE `timelines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laporan_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_sap` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `departemen` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'pelapor',
  `status` varchar(255) NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `no_sap`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `no_hp`, `departemen`, `role`, `status`) VALUES
(1, '123456', 'hira', 'hira@gmail.com', NULL, '$2y$12$9Z1xR/OBCgtOY5Qve9y.kOBK2zmyfK6gmVB0a/dyEn0faXzi8hN9O', NULL, '2025-05-26 20:36:06', '2025-05-26 20:36:06', '082391992783', 'TI', 'krani', 'open'),
(2, '222222', 'Abdul Arif', 'arifAbdul123@gmail.com', NULL, '$2y$12$55xfAffa5hepj7A.H3jRfuM7qJ6UFVE9VXld3NuvVuPnmGaRJcWnK', NULL, '2025-05-27 19:30:59', '2025-05-27 19:30:59', '0213456789', 'Keuangan', 'pelapor', 'open'),
(3, '1234789', 'mahi', 'zhramanda300@gmail.com', NULL, '$2y$12$hsDxNuSpywYmHz918OH/C.EwtZoBfzTXD78TOaMDRxYMIPVPCMLFy', NULL, '2025-05-27 19:31:25', '2025-05-27 19:31:25', '082391992783', 'Keuangan', 'asisten', 'open'),
(5, '102030', 'Rian Ardi', 'rian@gmail.com', NULL, '$2y$12$mVyo3/bMYwfhofVUY60pwebci0dvXsbSvO0fVfsow4mltgmOT/F16', NULL, '2025-06-13 03:47:16', '2025-06-13 03:47:16', '081234567890', 'IT', 'pelapor', 'open'),
(6, '112030', 'rian rian', 'riann@gmail.com', NULL, '$2y$12$ZK3plIpxSgBtJ4XPjilEcemNRCYJUwIO6xeV3UbhqFStA0yTM3GKq', NULL, '2025-06-13 04:24:53', '2025-06-13 04:24:53', '012322452367', 'Keuangan', 'pelapor', 'open'),
(7, '101010', 'hh', 'dd@gmail.com', NULL, '$2y$12$1zq/55j.MZJbzWabglI.AOFmucDbUW/K3xzUEhyKO7qIX3mT1VzBO', NULL, '2025-06-17 11:26:09', '2025-06-17 11:26:09', '0213456987', 'Keuangan', 'pelapor', 'open'),
(9, '10203010', 'ranti', 'rantika21ti@mahasiswa.pcr.ac.id', NULL, '$2y$12$MGrzNJQon3k/9F5SKx8kru93taQS4cCd45mC2XZ/NpzFj2a1nBaqi', NULL, '2025-06-20 07:49:59', '2025-06-20 07:49:59', '0231456987', 'HRD', 'pelapor', 'open');

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `laporans_ticket_number_unique` (`ticket_number`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `timelines`
--
ALTER TABLE `timelines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timelines_laporan_id_foreign` (`laporan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_no_sap_unique` (`no_sap`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `timelines`
--
ALTER TABLE `timelines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `timelines`
--
ALTER TABLE `timelines`
  ADD CONSTRAINT `timelines_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
