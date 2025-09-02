<?php 
	$v11sql =<<<XML

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3212
-- Generation Time: Nov 24, 2019 at 06:27 AM
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

--
-- Table structure for table `aktif`
--

DROP TABLE IF EXISTS `aktif`;
CREATE TABLE `aktif` (
  `id` int(11) NOT NULL,
  `mapel` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `token` varchar(6) COLLATE latin1_general_ci DEFAULT NULL,
  `tokentime` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `sesi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bobot`
--

DROP TABLE IF EXISTS `bobot`;
CREATE TABLE `bobot` (
  `id` int(11) NOT NULL,
  `kode` int(11) DEFAULT NULL,
  `no` int(11) DEFAULT NULL,
  `bobot` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grouping`
--

DROP TABLE IF EXISTS `grouping`;
CREATE TABLE `grouping` (
  `id` int(11) NOT NULL,
  `kode` int(11) DEFAULT NULL,
  `no` int(11) DEFAULT NULL,
  `grouping` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kd`
--

DROP TABLE IF EXISTS `kd`;
CREATE TABLE `kd` (
  `id` int(11) NOT NULL,
  `kode` int(11) DEFAULT NULL,
  `no` int(11) DEFAULT NULL,
  `kd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kdsoal`
--

DROP TABLE IF EXISTS `kdsoal`;
CREATE TABLE `kdsoal` (
  `id` int(11) NOT NULL,
  `kode` int(11) DEFAULT NULL,
  `kd` varchar(255) DEFAULT NULL,
  `alokasi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kunciessay`
--

DROP TABLE IF EXISTS `kunciessay`;
CREATE TABLE `kunciessay` (
  `id` int(11) NOT NULL,
  `kode` int(11) DEFAULT NULL,
  `no` int(11) DEFAULT NULL,
  `kunci` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kuncipg`
--

DROP TABLE IF EXISTS `kuncipg`;
CREATE TABLE `kuncipg` (
  `id` int(11) NOT NULL,
  `kode` int(11) DEFAULT NULL,
  `no` int(11) DEFAULT NULL,
  `kunci` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locking`
--

DROP TABLE IF EXISTS `locking`;
CREATE TABLE `locking` (
  `id` int(11) NOT NULL,
  `kode` int(11) DEFAULT NULL,
  `no` int(11) DEFAULT NULL,
  `locking` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `val` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

DROP TABLE IF EXISTS `nilai`;
CREATE TABLE `nilai` (
  `i` int(11) NOT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `mapel` varchar(255) DEFAULT NULL,
  `skor` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
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
-- Table structure for table `server`
--

DROP TABLE IF EXISTS `server`;
CREATE TABLE `server` (
  `id` int(11) NOT NULL,
  `nama_sekolah` varchar(100) DEFAULT NULL,
  `id_server` varchar(50) DEFAULT NULL,
  `pass_server` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa` (
  `i` int(11) NOT NULL,
  `id` varchar(30) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nik2` varchar(255) DEFAULT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `server` varchar(20) DEFAULT NULL,
  `sesi` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktif`
--
ALTER TABLE `aktif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bobot`
--
ALTER TABLE `bobot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `grouping`
--
ALTER TABLE `grouping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `kd`
--
ALTER TABLE `kd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `kdsoal`
--
ALTER TABLE `kdsoal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `kunciessay`
--
ALTER TABLE `kunciessay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `kuncipg`
--
ALTER TABLE `kuncipg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `locking`
--
ALTER TABLE `locking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`i`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`i`),
  ADD KEY `login` (`kode`,`pass`,`mapel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktif`
--
ALTER TABLE `aktif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bobot`
--
ALTER TABLE `bobot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grouping`
--
ALTER TABLE `grouping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kd`
--
ALTER TABLE `kd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kdsoal`
--
ALTER TABLE `kdsoal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kunciessay`
--
ALTER TABLE `kunciessay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kuncipg`
--
ALTER TABLE `kuncipg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locking`
--
ALTER TABLE `locking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `i` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `server`
--
ALTER TABLE `server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `i` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


XML;
