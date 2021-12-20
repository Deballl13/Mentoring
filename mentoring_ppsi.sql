-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2021 at 12:35 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mentoring_ppsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_ujian`
--

CREATE TABLE `jawaban_ujian` (
  `id` bigint(20) NOT NULL,
  `nim_peserta` int(11) NOT NULL,
  `id_soal` bigint(20) NOT NULL,
  `jawaban` text NOT NULL,
  `nilai` int(2) NOT NULL COMMENT 'bobot penilaian per soal'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pertemuan`
--

CREATE TABLE `pertemuan` (
  `id` bigint(20) NOT NULL,
  `kelompok` tinyint(2) NOT NULL,
  `tanggal` date NOT NULL,
  `pertemuan_ke` tinyint(3) NOT NULL,
  `waktu` time NOT NULL,
  `materi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pertemuan`
--

INSERT INTO `pertemuan` (`id`, `kelompok`, `tanggal`, `pertemuan_ke`, `waktu`, `materi`) VALUES
(3, 2, '2021-12-13', 1, '19:30:00', 'Ini materi 1'),
(4, 2, '2021-12-18', 2, '19:30:00', 'Ini materi pertemuan 2'),
(5, 2, '2021-12-25', 3, '08:00:00', 'materi pertemuan 3'),
(7, 2, '2021-12-27', 4, '19:00:00', 'materi pertemuan 4');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` bigint(20) NOT NULL,
  `nim_peserta` int(11) NOT NULL,
  `id_pertemuan` bigint(20) NOT NULL,
  `status_kehadiran` char(1) NOT NULL COMMENT 'H = Hadir\r\nA = Absen\r\nI = Izin\r\nS = Sakit',
  `waktu` datetime NOT NULL,
  `sholat_fardhu_berjamaah` tinyint(2) NOT NULL COMMENT 'jumlahnya berapa kali?',
  `qiyamul_lail` tinyint(2) NOT NULL COMMENT 'jumlahnya berapa kali?',
  `sholat_dhuha` tinyint(2) NOT NULL COMMENT 'jumlahnya berapa kali?',
  `sholat_rawatib` tinyint(2) NOT NULL COMMENT 'jumlahnya berapa kali?',
  `tilawah_quran` tinyint(2) NOT NULL COMMENT 'jumlahnya berapa kali?',
  `infaq` tinyint(2) NOT NULL COMMENT 'ada atau tidak',
  `olahraga` tinyint(2) NOT NULL,
  `baca_buku` tinyint(4) NOT NULL COMMENT 'jumlah halaman',
  `kegiatan_ukhuwah` tinyint(2) NOT NULL COMMENT 'jumlahnya berapa kali?'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `soal_ujian`
--

CREATE TABLE `soal_ujian` (
  `id` bigint(20) NOT NULL,
  `id_ujian` bigint(20) NOT NULL,
  `soal` text NOT NULL,
  `jawaban` text NOT NULL,
  `bobot_nilai` tinyint(2) NOT NULL COMMENT 'bobot nilai per soal'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `id` bigint(20) NOT NULL,
  `tanggal` datetime NOT NULL,
  `durasi` int(11) NOT NULL COMMENT 'dalam hitungan menit'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ujian`
--

INSERT INTO `ujian` (`id`, `tanggal`, `durasi`) VALUES
(1, '2022-01-08 10:00:00', 90);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `nim` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `jurusan` varchar(18) NOT NULL,
  `role` varchar(7) NOT NULL,
  `kelompok` tinyint(2) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`nim`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `email`, `no_hp`, `jurusan`, `role`, `kelompok`, `password`) VALUES
(1911511001, 'Luqmanul Hakim', 'L', 'Padang', '2000-12-31', 'hakim@gmail.com', '081232132131', 'Teknik Komputer', 'bpmai', NULL, '$2y$10$nbUyP3yVl3dXJqZWhXmPHOb3ItEU1bzRsO5zodl3Huy5t957uyHfu'),
(1911521001, 'Nadya Gusdita', 'P', 'Jambi', '2001-08-20', 'nadya@gmail.com', '081298347601', 'Sistem Informasi', 'mentor', 1, '$2y$10$zqBoksg/RO5RXfdFg7H6jO6.FPEE66v.eCgRJ/OLDaka0vMN1Vom6'),
(1911521003, 'Vira Yulia', 'P', 'Dumai', '2001-07-13', 'vira@gmail.com', '081234567890', 'Sistem Informasi', 'mentee', 1, '$2y$10$zmNHm8.jeiIAFEiISX.kgevtwiI/u0T9Ozg9hHeLlDPCYzmZSAQf.'),
(1911521025, 'Ade Iqbal', 'L', 'Padang', '2001-01-10', 'iqbal@gmail.com', '081232132131', 'Sistem Informasi', 'mentor', 2, '$2y$10$nbUyP3yVl3dXJqZWhXmPHOb3ItEU1bzRsO5zodl3Huy5t957uyHfu'),
(1911522019, 'Arif Roska Perdana', 'L', 'Padang', '2000-10-12', 'arif@gmail.com', '082131231231', 'Sistem Informasi', 'mentee', 2, '$2y$10$ZOcNYNFhxShy1kU4.DzoN.Sc7WOF7KWRh9Al2i1ZG2Gcr8GReLyli'),
(2011522003, 'Bambang Santoso', 'L', 'Medan', '2002-10-02', 'bambang@gmail.com', '084398127634', 'Sistem Informasi', 'mentee', 2, '$2y$10$tkQis6y564iujUOwb6TeXe97nErUXsQlCSiaaZOp6paQxoSDe6PzK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jawaban_ujian`
--
ALTER TABLE `jawaban_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soal ujian` (`id_soal`),
  ADD KEY `ujian_peserta` (`nim_peserta`);

--
-- Indexes for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presensi_peserta` (`nim_peserta`),
  ADD KEY `pertemuan` (`id_pertemuan`);

--
-- Indexes for table `soal_ujian`
--
ALTER TABLE `soal_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ujain` (`id_ujian`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jawaban_ujian`
--
ALTER TABLE `jawaban_ujian`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `soal_ujian`
--
ALTER TABLE `soal_ujian`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jawaban_ujian`
--
ALTER TABLE `jawaban_ujian`
  ADD CONSTRAINT `soal ujian` FOREIGN KEY (`id_soal`) REFERENCES `soal_ujian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ujian_peserta` FOREIGN KEY (`nim_peserta`) REFERENCES `users` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presensi_peserta` FOREIGN KEY (`nim_peserta`) REFERENCES `users` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `soal_ujian`
--
ALTER TABLE `soal_ujian`
  ADD CONSTRAINT `ujain` FOREIGN KEY (`id_ujian`) REFERENCES `ujian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
