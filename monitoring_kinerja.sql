-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2023 at 11:07 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring_kinerja`
--

-- --------------------------------------------------------

--
-- Table structure for table `bidang`
--

CREATE TABLE `bidang` (
  `idBidang` int(11) NOT NULL,
  `nama_bidang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bidang`
--

INSERT INTO `bidang` (`idBidang`, `nama_bidang`) VALUES
(1, 'Bidang Fungsional'),
(2, 'Bidang Statistik dan Persandian'),
(3, 'Bidang Informatics'),
(4, 'Bidang Informasi dan Komunikasi Public');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `idJabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`idJabatan`, `nama_jabatan`) VALUES
(1, 'Sekretaris2'),
(2, 'Kabid'),
(4, 'Staff'),
(5, 'Kadis'),
(6, 'Kasi');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `idPegawai` int(11) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama_peg` varchar(255) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `detail_jabatan` text NOT NULL,
  `id_bidang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`idPegawai`, `nip`, `nama_peg`, `id_jabatan`, `detail_jabatan`, `id_bidang`) VALUES
(1, '2107411000', 'karyawan1', 2, 'kabid pemetaan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `idPekerjaan` int(11) NOT NULL,
  `uraian_pekerjaan` varchar(255) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  `status_pekerjaan` enum('Selesai','Pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` (`idPekerjaan`, `uraian_pekerjaan`, `id_pegawai`, `waktu_mulai`, `waktu_selesai`, `status_pekerjaan`) VALUES
(1, 'Membuat laporan harian', 1, '2022-12-29 10:32:24', '2022-12-30 10:32:24', 'Selesai'),
(2, 'Membuat desain', 1, '2022-12-30 10:32:24', '2022-12-31 10:32:24', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(70) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`) VALUES
(4, 'Michael Natanael', 'natanaelmichael', 'michael.natanael.tik21@mhsw.pnj.ac.id', '$2y$10$r/jCxr7EcU.P7.pVjh.FjurVOH/0qIkhy.RBdV8qnrosqwAessOd2'),
(5, 'Angel', 'angel', 'angel@gmail.com', '$2y$10$tvZlYMmywrUdqxEMtan7dezKTqv0pfTayBSGgjm.QBW8lUtX24qyG'),
(6, 'Lukas', 'lukas', 'lukas@gmail.com', '$2y$10$wsbvnOEMGbZ7QJx1rv9WleLwr2PdX1boJiJnhtWnecQTCQTj8e2r6'),
(7, 'Jack', 'jack', 'jack@gmail.com', '$2y$10$Xt7UyeuE1e4zUP9VhOfd6ewsyPL5sKbQMPjXtzh/KitVal8kzFNVa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`idBidang`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`idJabatan`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`idPegawai`),
  ADD KEY `jabatan_constraint` (`id_jabatan`),
  ADD KEY `bidang_constraint` (`id_bidang`);

--
-- Indexes for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`idPekerjaan`),
  ADD UNIQUE KEY `uraian_kegiatan` (`uraian_pekerjaan`),
  ADD KEY `kegiatan_ibfk_1` (`id_pegawai`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `idBidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `idJabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `idPegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `idPekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `bidang_constraint` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`idBidang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jabatan_constraint` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`idJabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD CONSTRAINT `pekerjaan_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`idPegawai`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
