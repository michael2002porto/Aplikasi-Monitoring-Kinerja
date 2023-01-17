-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2023 at 05:28 AM
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
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `absen_masuk` datetime NOT NULL,
  `absen_pulang` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(3, 'Bidang Informatics');

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
  `id_jabatan` int(11) DEFAULT NULL,
  `alamat` varchar(255) NOT NULL,
  `id_bidang` int(11) DEFAULT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`idPegawai`, `nip`, `nama_peg`, `id_jabatan`, `alamat`, `id_bidang`, `photo`) VALUES
(21, '  2107411089', '  frenkie de jagung', NULL, '  jakarta  ', NULL, '63c60bfe648d7.jpg'),
(24, '  2107411003  ', '  Lewandowski ', 4, '  malang  ', 3, '63c5df43024d3.jpg'),
(25, ' 2107411045 ', ' araujo messi', 5, ' jakarta ', 3, '63c60a61a764d.jpg'),
(26, '2107411098', 'ter stegen', 5, 'jogja', NULL, '63c5df7f3862a.jpg');

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
(7, 'Jack', 'jack', 'jack@gmail.com', '$2y$10$Xt7UyeuE1e4zUP9VhOfd6ewsyPL5sKbQMPjXtzh/KitVal8kzFNVa'),
(8, 'michael natanael', 'michael', 'michael@gmail.com', '$2y$10$UcTsc1VaJ7mSSPU/c9DLAew3MQrAaALdIEBXt6/5rCbn8hal1GuNa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_karyawan` (`id_karyawan`);

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
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `idBidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `idJabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `idPegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `idPekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `pegawai` (`idPegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_FK` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`idBidang`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pegawai_FK_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`idJabatan`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD CONSTRAINT `pekerjaan_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`idPegawai`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
