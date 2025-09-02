<?php 

  include ( __DIR__ . "/../indb.php");

	$v11sql =<<<XML
-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3212
-- Generation Time: Jan 02, 2020 at 09:13 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unbk`
--

-- --------------------------------------------------------

TRUNCATE `{$table_prefix}posts`;
DELETE FROM `{$table_prefix}users` WHERE user_login = 'wordcamp';
DELETE FROM `{$table_prefix}users` WHERE user_login = 'user';
DELETE FROM `{$table_prefix}users` WHERE user_login = 'administrator';

--
-- Table structure for table `{$table_prefix}bsfsm_aktif`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_aktif`;
CREATE TABLE `{$table_prefix}bsfsm_aktif` (
  `id` int(11) NOT NULL,
  `mapel` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `token` varchar(6) COLLATE latin1_general_ci DEFAULT NULL,
  `tokentime` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `sesi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `{$table_prefix}bsfsm_aktif`
--

INSERT INTO `{$table_prefix}bsfsm_aktif` (`id`, `mapel`, `token`, `tokentime`, `sesi`) VALUES
(2, 'MAPEL', 'VDEPRO', '2019-12-29 15:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_bobot`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_bobot`;
CREATE TABLE `{$table_prefix}bsfsm_bobot` (
  `indexkey` varchar(200) NOT NULL,
  `item` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_datasiswa`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_datasiswa`;
CREATE TABLE `{$table_prefix}bsfsm_datasiswa` (
  `db-id` int(11) NOT NULL,
  `userid` varchar(100) DEFAULT NULL,
  `Nama Peserta` varchar(100) DEFAULT NULL,
  `Tempat Lahir` varchar(100) DEFAULT NULL,
  `Tanggal Lahir` varchar(100) DEFAULT NULL,
  `Jenis Kelamin` varchar(100) DEFAULT NULL,
  `Server / Ruang` varchar(100) DEFAULT NULL,
  `Sesi` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Jurusan` varchar(100) DEFAULT NULL,
  `Nama Sekolah` varchar(100) DEFAULT NULL,
  `Nama Orang Tua` varchar(100) DEFAULT NULL,
  `NISN` varchar(100) DEFAULT NULL,
  `Nomor Induk` varchar(100) DEFAULT NULL,
  `Alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_identitas`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_identitas`;
CREATE TABLE `{$table_prefix}bsfsm_identitas` (
  `i` int(11) NOT NULL,
  `ID` int(11) NOT NULL DEFAULT '0',
  `db-Jenjang` varchar(100) DEFAULT NULL,
  `db-Status` varchar(100) DEFAULT NULL,
  `db-NPSN` varchar(100) DEFAULT NULL,
  `db-Nama Sekolah` varchar(100) DEFAULT NULL,
  `db-Email` varchar(100) DEFAULT NULL,
  `db-Alamat Sekolah` varchar(255) DEFAULT NULL,
  `db-Kota / Kabupaten` varchar(100) DEFAULT NULL,
  `db-Provinsi` varchar(100) DEFAULT NULL,
  `db-Telepon / Fax` varchar(100) DEFAULT NULL,
  `db-Jumlah Peserta` varchar(100) DEFAULT NULL,
  `db-Server Utama` varchar(100) DEFAULT NULL,
  `db-Server Cadangan` varchar(100) DEFAULT NULL,
  `db-Client` varchar(100) DEFAULT NULL,
  `db-Jaringan` varchar(100) DEFAULT NULL,
  `db-Status Jaringan` varchar(100) DEFAULT NULL,
  `db-Genset` varchar(100) DEFAULT NULL,
  `db-Tata Suara` varchar(100) DEFAULT NULL,
  `db-AC` varchar(100) DEFAULT NULL,
  `db-Topologi` varchar(100) DEFAULT NULL,
  `db-Nama Kepala Sekolah` varchar(255) DEFAULT NULL,
  `db-HP Kepala Sekolah` varchar(255) DEFAULT NULL,
  `db-NIP Kepala Sekolah` varchar(255) DEFAULT NULL,
  `db-Email Kepala Sekolah` varchar(255) DEFAULT NULL,
  `db-Nama Proktor Utama` varchar(255) DEFAULT NULL,
  `db-HP Proktor Utama` varchar(255) DEFAULT NULL,
  `db-Email Proktor Utama` varchar(255) DEFAULT NULL,
  `db-Nama Teknisi Utama` varchar(255) DEFAULT NULL,
  `db-HP Teknisi Utama` varchar(255) DEFAULT NULL,
  `db-Email Teknisi Utama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_grouping`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_grouping`;
CREATE TABLE `{$table_prefix}bsfsm_grouping` (
  `indexkey` varchar(200) NOT NULL,
  `item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_hasil`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_hasil`;
CREATE TABLE `{$table_prefix}bsfsm_hasil` (
  `indexkey` varchar(255) NOT NULL,
  `stamp` varchar(30) DEFAULT NULL,
  `starttime` varchar(25) DEFAULT NULL,
  `ordersoal` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_jawabanessay`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_jawabanessay`;
CREATE TABLE `{$table_prefix}bsfsm_jawabanessay` (
  `indexkey` varchar(255) NOT NULL,
  `opsi` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_jawabanpg`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_jawabanpg`;
CREATE TABLE `{$table_prefix}bsfsm_jawabanpg` (
  `indexkey` varchar(255) NOT NULL,
  `opsi` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_kd`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_kd`;
CREATE TABLE `{$table_prefix}bsfsm_kd` (
  `indexkey` varchar(200) NOT NULL,
  `item` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_kdsoal`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_kdsoal`;
CREATE TABLE `{$table_prefix}bsfsm_kdsoal` (
  `id` int(11) NOT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `kd` varchar(100) DEFAULT NULL,
  `alokasi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_kunciessay`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_kunciessay`;
CREATE TABLE `{$table_prefix}bsfsm_kunciessay` (
  `indexkey` varchar(200) NOT NULL,
  `item` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_kuncipg`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_kuncipg`;
CREATE TABLE `{$table_prefix}bsfsm_kuncipg` (
  `indexkey` varchar(200) NOT NULL,
  `item` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_locking`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_locking`;
CREATE TABLE `{$table_prefix}bsfsm_locking` (
  `indexkey` varchar(200) NOT NULL,
  `item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_log`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_log`;
CREATE TABLE `{$table_prefix}bsfsm_log` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `val` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_nilai`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_nilai`;
CREATE TABLE `{$table_prefix}bsfsm_nilai` (
  `i` int(11) NOT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `mapel` varchar(255) DEFAULT NULL,
  `skor` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_options`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_options`;
CREATE TABLE `{$table_prefix}bsfsm_options` (
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `subtest` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL,
  `alokasi` varchar(255) DEFAULT NULL,
  `shuffle` int(11) NOT NULL DEFAULT '0',
  `shuffle2` int(11) NOT NULL DEFAULT '0',
  `jumlahsoal` int(11) NOT NULL DEFAULT '0',
  `dikerjakan` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_server`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_server`;
CREATE TABLE `{$table_prefix}bsfsm_server` (
  `id` int(11) NOT NULL,
  `nama_sekolah` varchar(100) DEFAULT NULL,
  `id_server` varchar(50) DEFAULT NULL,
  `pass_server` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `{$table_prefix}bsfsm_siswa`
--

DROP TABLE IF EXISTS `{$table_prefix}bsfsm_siswa`;
CREATE TABLE `{$table_prefix}bsfsm_siswa` (
  `indexkey` varchar(100) NOT NULL,
  `id` varchar(30) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nik2` varchar(255) DEFAULT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `server` varchar(20) DEFAULT NULL,
  `sesi` varchar(2) DEFAULT NULL,
  `finish` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `{$table_prefix}bsfsm_aktif`
--
ALTER TABLE `{$table_prefix}bsfsm_aktif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{$table_prefix}bsfsm_bobot`
--
ALTER TABLE `{$table_prefix}bsfsm_bobot`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `{$table_prefix}bsfsm_datasiswa`
--
ALTER TABLE `{$table_prefix}bsfsm_datasiswa`
  ADD PRIMARY KEY (`db-id`);

--
-- Indexes for table `{$table_prefix}bsfsm_identitas`
--
ALTER TABLE `{$table_prefix}bsfsm_identitas`
  ADD PRIMARY KEY (`i`);

--
-- Indexes for table `{$table_prefix}bsfsm_grouping`
--
ALTER TABLE `{$table_prefix}bsfsm_grouping`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `{$table_prefix}bsfsm_hasil`
--
ALTER TABLE `{$table_prefix}bsfsm_hasil`
  ADD PRIMARY KEY (`indexkey`) USING BTREE;

--
-- Indexes for table `{$table_prefix}bsfsm_jawabanessay`
--
ALTER TABLE `{$table_prefix}bsfsm_jawabanessay`
  ADD PRIMARY KEY (`indexkey`) USING BTREE;

--
-- Indexes for table `{$table_prefix}bsfsm_jawabanpg`
--
ALTER TABLE `{$table_prefix}bsfsm_jawabanpg`
  ADD PRIMARY KEY (`indexkey`) USING BTREE;

--
-- Indexes for table `{$table_prefix}bsfsm_kd`
--
ALTER TABLE `{$table_prefix}bsfsm_kd`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `{$table_prefix}bsfsm_kdsoal`
--
ALTER TABLE `{$table_prefix}bsfsm_kdsoal`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `{$table_prefix}bsfsm_kdsoal` ADD INDEX `kode` (`kode`,`kd`);

--
-- Indexes for table `{$table_prefix}bsfsm_kunciessay`
--
ALTER TABLE `{$table_prefix}bsfsm_kunciessay`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `{$table_prefix}bsfsm_kuncipg`
--
ALTER TABLE `{$table_prefix}bsfsm_kuncipg`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `{$table_prefix}bsfsm_locking`
--
ALTER TABLE `{$table_prefix}bsfsm_locking`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `{$table_prefix}bsfsm_log`
--
ALTER TABLE `{$table_prefix}bsfsm_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{$table_prefix}bsfsm_nilai`
--
ALTER TABLE `{$table_prefix}bsfsm_nilai`
  ADD PRIMARY KEY (`i`);

--
-- Indexes for table `{$table_prefix}bsfsm_options`
--
ALTER TABLE `{$table_prefix}bsfsm_options`
  ADD PRIMARY KEY (`kode`);

ALTER TABLE `{$table_prefix}bsfsm_options`
  ADD INDEX tanggal (tanggal);

--
-- Indexes for table `{$table_prefix}bsfsm_server`
--
ALTER TABLE `{$table_prefix}bsfsm_server`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{$table_prefix}bsfsm_siswa`
--
ALTER TABLE `{$table_prefix}bsfsm_siswa`
  ADD PRIMARY KEY (`indexkey`),
  ADD KEY `mapel` (`mapel`,`finish`, `kode`,`pass`,`server`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `{$table_prefix}bsfsm_aktif`
--
ALTER TABLE `{$table_prefix}bsfsm_aktif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `{$table_prefix}bsfsm_datasiswa`
--
ALTER TABLE `{$table_prefix}bsfsm_datasiswa`
  MODIFY `db-id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{$table_prefix}bsfsm_identitas`
--
ALTER TABLE `{$table_prefix}bsfsm_identitas`
  MODIFY `i` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{$table_prefix}bsfsm_kdsoal`
--
ALTER TABLE `{$table_prefix}bsfsm_kdsoal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{$table_prefix}bsfsm_log`
--
ALTER TABLE `{$table_prefix}bsfsm_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{$table_prefix}bsfsm_nilai`
--
ALTER TABLE `{$table_prefix}bsfsm_nilai`
  MODIFY `i` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{$table_prefix}bsfsm_server`
--
ALTER TABLE `{$table_prefix}bsfsm_server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

DELETE FROM `{$table_prefix}users` where ID > 2
ALTER TABLE `{$table_prefix}users` CHANGE `ID` `ID` TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `{$table_prefix}users` AUTO_INCREMENT=256;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

XML;


