-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2026 at 04:28 AM
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
-- Database: `db_worksync`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Pengembangan Sistem'),
(2, 'Dokumentasi & Laporan');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_status`
--

CREATE TABLE `riwayat_status` (
  `id_riwayat` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `status_lama` varchar(20) DEFAULT NULL,
  `status_baru` varchar(20) NOT NULL,
  `tanggal_perubahan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_status`
--

INSERT INTO `riwayat_status` (`id_riwayat`, `id_tugas`, `id_user`, `status_lama`, `status_baru`, `tanggal_perubahan`) VALUES
(1, 1, 1, NULL, 'belum', '2026-11-25 08:16:47'),
(2, 1, 2, 'belum', 'proses', '2026-11-25 08:16:47'),
(3, 1, 1, NULL, 'belum', '2026-11-25 08:44:46'),
(4, 1, 2, 'belum', 'proses', '2026-11-25 08:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nama_role`, `deskripsi`) VALUES
(1, 'Admin', 'Mengelola seluruh data dan pengguna'),
(2, 'Anggota', 'Melaksanakan tugas yang diberikan');

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_pembuat` int(11) NOT NULL,
  `id_penanggung_jawab` int(11) DEFAULT NULL,
  `deadline` date NOT NULL,
  `prioritas` enum('rendah','sedang','tinggi') NOT NULL DEFAULT 'sedang',
  `status` enum('belum','proses','selesai') NOT NULL DEFAULT 'belum',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id_tugas`, `judul`, `deskripsi`, `id_kategori`, `id_pembuat`, `id_penanggung_jawab`, `deadline`, `prioritas`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Membuat Fitur Login & Role Filter', 'Implementasi autentikasi pengguna dan pembatasan akses Admin/Anggota.', 1, 1, 2, '2026-12-02', 'tinggi', 'proses', '2026-11-25 08:16:47', '2026-11-25 08:16:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `created_at`) VALUES
(1, 'Admin WorkSync', 'admin@worksync.test', '$2y$10$3yAyXvNxzgesNG3eQiMaXeWgpnU1b9CQLGS5atOXDrcvXkgWFqufu', '2026-11-25 08:02:14'),
(2, 'Dina Camelia', 'dina@worksync.test', '$2y$10$wI59GDVECrg8OCl7/q5QsutAIkO3uj.o60BkaHOFFow2AQNVQoWjG', '2026-11-25 08:02:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id_user`, `id_role`) VALUES
(1, 1),
(2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `riwayat_status`
--
ALTER TABLE `riwayat_status`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `id_tugas` (`id_tugas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `nama_role` (`nama_role`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_pembuat` (`id_pembuat`),
  ADD KEY `id_penanggung_jawab` (`id_penanggung_jawab`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id_user`,`id_role`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `riwayat_status`
--
ALTER TABLE `riwayat_status`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `riwayat_status`
--
ALTER TABLE `riwayat_status`
  ADD CONSTRAINT `riwayat_status_ibfk_1` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id_tugas`) ON DELETE CASCADE,
  ADD CONSTRAINT `riwayat_status_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL,
  ADD CONSTRAINT `tugas_ibfk_2` FOREIGN KEY (`id_pembuat`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `tugas_ibfk_3` FOREIGN KEY (`id_penanggung_jawab`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
