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

TRUNCATE `portalubk_posts`;
DELETE FROM `portalubk_users` WHERE user_login = 'wordcamp';
DELETE FROM `portalubk_users` WHERE user_login = 'user';
DELETE FROM `portalubk_users` WHERE user_login = 'administrator';

--
-- Table structure for table `portalubk_bsfsm_aktif`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_aktif`;
CREATE TABLE `portalubk_bsfsm_aktif` (
  `id` int(11) NOT NULL,
  `mapel` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `token` varchar(6) COLLATE latin1_general_ci DEFAULT NULL,
  `tokentime` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `sesi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `portalubk_bsfsm_aktif`
--

INSERT INTO `portalubk_bsfsm_aktif` (`id`, `mapel`, `token`, `tokentime`, `sesi`) VALUES
(2, 'MAPEL', 'VDEPRO', '2019-12-29 15:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_bobot`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_bobot`;
CREATE TABLE `portalubk_bsfsm_bobot` (
  `indexkey` varchar(200) NOT NULL,
  `item` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_datasiswa`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_datasiswa`;
CREATE TABLE `portalubk_bsfsm_datasiswa` (
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
-- Table structure for table `portalubk_bsfsm_identitas`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_identitas`;
CREATE TABLE `portalubk_bsfsm_identitas` (
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
-- Table structure for table `portalubk_bsfsm_grouping`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_grouping`;
CREATE TABLE `portalubk_bsfsm_grouping` (
  `indexkey` varchar(200) NOT NULL,
  `item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_hasil`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_hasil`;
CREATE TABLE `portalubk_bsfsm_hasil` (
  `indexkey` varchar(255) NOT NULL,
  `stamp` varchar(30) DEFAULT NULL,
  `starttime` varchar(25) DEFAULT NULL,
  `ordersoal` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_jawabanessay`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_jawabanessay`;
CREATE TABLE `portalubk_bsfsm_jawabanessay` (
  `indexkey` varchar(255) NOT NULL,
  `opsi` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_jawabanpg`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_jawabanpg`;
CREATE TABLE `portalubk_bsfsm_jawabanpg` (
  `indexkey` varchar(255) NOT NULL,
  `opsi` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_kd`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_kd`;
CREATE TABLE `portalubk_bsfsm_kd` (
  `indexkey` varchar(200) NOT NULL,
  `item` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_kdsoal`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_kdsoal`;
CREATE TABLE `portalubk_bsfsm_kdsoal` (
  `id` int(11) NOT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `kd` varchar(100) DEFAULT NULL,
  `alokasi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_kunciessay`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_kunciessay`;
CREATE TABLE `portalubk_bsfsm_kunciessay` (
  `indexkey` varchar(200) NOT NULL,
  `item` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_kuncipg`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_kuncipg`;
CREATE TABLE `portalubk_bsfsm_kuncipg` (
  `indexkey` varchar(200) NOT NULL,
  `item` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_locking`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_locking`;
CREATE TABLE `portalubk_bsfsm_locking` (
  `indexkey` varchar(200) NOT NULL,
  `item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_log`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_log`;
CREATE TABLE `portalubk_bsfsm_log` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `val` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_nilai`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_nilai`;
CREATE TABLE `portalubk_bsfsm_nilai` (
  `i` int(11) NOT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `mapel` varchar(255) DEFAULT NULL,
  `skor` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_options`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_options`;
CREATE TABLE `portalubk_bsfsm_options` (
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
-- Table structure for table `portalubk_bsfsm_server`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_server`;
CREATE TABLE `portalubk_bsfsm_server` (
  `id` int(11) NOT NULL,
  `nama_sekolah` varchar(100) DEFAULT NULL,
  `id_server` varchar(50) DEFAULT NULL,
  `pass_server` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portalubk_bsfsm_siswa`
--

DROP TABLE IF EXISTS `portalubk_bsfsm_siswa`;
CREATE TABLE `portalubk_bsfsm_siswa` (
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
-- Indexes for table `portalubk_bsfsm_aktif`
--
ALTER TABLE `portalubk_bsfsm_aktif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portalubk_bsfsm_bobot`
--
ALTER TABLE `portalubk_bsfsm_bobot`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `portalubk_bsfsm_datasiswa`
--
ALTER TABLE `portalubk_bsfsm_datasiswa`
  ADD PRIMARY KEY (`db-id`);

--
-- Indexes for table `portalubk_bsfsm_identitas`
--
ALTER TABLE `portalubk_bsfsm_identitas`
  ADD PRIMARY KEY (`i`);

--
-- Indexes for table `portalubk_bsfsm_grouping`
--
ALTER TABLE `portalubk_bsfsm_grouping`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `portalubk_bsfsm_hasil`
--
ALTER TABLE `portalubk_bsfsm_hasil`
  ADD PRIMARY KEY (`indexkey`) USING BTREE;

--
-- Indexes for table `portalubk_bsfsm_jawabanessay`
--
ALTER TABLE `portalubk_bsfsm_jawabanessay`
  ADD PRIMARY KEY (`indexkey`) USING BTREE;

--
-- Indexes for table `portalubk_bsfsm_jawabanpg`
--
ALTER TABLE `portalubk_bsfsm_jawabanpg`
  ADD PRIMARY KEY (`indexkey`) USING BTREE;

--
-- Indexes for table `portalubk_bsfsm_kd`
--
ALTER TABLE `portalubk_bsfsm_kd`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `portalubk_bsfsm_kdsoal`
--
ALTER TABLE `portalubk_bsfsm_kdsoal`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `portalubk_bsfsm_kdsoal` ADD INDEX `kode` (`kode`,`kd`);

--
-- Indexes for table `portalubk_bsfsm_kunciessay`
--
ALTER TABLE `portalubk_bsfsm_kunciessay`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `portalubk_bsfsm_kuncipg`
--
ALTER TABLE `portalubk_bsfsm_kuncipg`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `portalubk_bsfsm_locking`
--
ALTER TABLE `portalubk_bsfsm_locking`
  ADD PRIMARY KEY (`indexkey`);

--
-- Indexes for table `portalubk_bsfsm_log`
--
ALTER TABLE `portalubk_bsfsm_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portalubk_bsfsm_nilai`
--
ALTER TABLE `portalubk_bsfsm_nilai`
  ADD PRIMARY KEY (`i`);

--
-- Indexes for table `portalubk_bsfsm_options`
--
ALTER TABLE `portalubk_bsfsm_options`
  ADD PRIMARY KEY (`kode`);

ALTER TABLE `portalubk_bsfsm_options`
  ADD INDEX tanggal (tanggal);

--
-- Indexes for table `portalubk_bsfsm_server`
--
ALTER TABLE `portalubk_bsfsm_server`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portalubk_bsfsm_siswa`
--
ALTER TABLE `portalubk_bsfsm_siswa`
  ADD PRIMARY KEY (`indexkey`),
  ADD KEY `mapel` (`mapel`,`finish`, `kode`,`pass`,`server`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `portalubk_bsfsm_aktif`
--
ALTER TABLE `portalubk_bsfsm_aktif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `portalubk_bsfsm_datasiswa`
--
ALTER TABLE `portalubk_bsfsm_datasiswa`
  MODIFY `db-id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portalubk_bsfsm_identitas`
--
ALTER TABLE `portalubk_bsfsm_identitas`
  MODIFY `i` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portalubk_bsfsm_kdsoal`
--
ALTER TABLE `portalubk_bsfsm_kdsoal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portalubk_bsfsm_log`
--
ALTER TABLE `portalubk_bsfsm_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portalubk_bsfsm_nilai`
--
ALTER TABLE `portalubk_bsfsm_nilai`
  MODIFY `i` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portalubk_bsfsm_server`
--
ALTER TABLE `portalubk_bsfsm_server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
