-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2023 at 12:03 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_aplikasi`
--

CREATE TABLE `tb_aplikasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `telp` varchar(16) NOT NULL,
  `email` varchar(256) NOT NULL,
  `alamat` text NOT NULL,
  `logo` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_aplikasi`
--

INSERT INTO `tb_aplikasi` (`id`, `nama`, `telp`, `email`, `alamat`, `logo`) VALUES
(1, 'Booking Ruangan | Ighra Afani', '089618367556', 'nurmuhaidi@gmail.com', 'Ngasem Candi Rt. 03 Rw. 01 Kec. Batealit Kab. Jepara', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_backupdb`
--

CREATE TABLE `tb_backupdb` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `database` varchar(256) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` int(11) NOT NULL,
  `kode` varchar(256) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `stock` int(11) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id`, `kode`, `nama`, `stock`, `terdaftar`) VALUES
(1, 'C01', 'Barang 1', 9, '2023-11-29 11:09:07'),
(2, 'C02', 'Barang 2', 8, '2023-11-29 11:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `tb_booking`
--

CREATE TABLE `tb_booking` (
  `id` int(11) NOT NULL,
  `idRuangan` int(11) NOT NULL,
  `peminjam` varchar(256) NOT NULL,
  `idInstansi` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `dariJam` time NOT NULL,
  `sampaiJam` time NOT NULL,
  `agenda` varchar(256) NOT NULL,
  `idBarang` varchar(500) NULL,
  `jumlah` int(11) NULL,
  `surat` varchar(256) NULL,
  `file` varchar(256) NULL,
  `status` varchar(32) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_booking`
--

INSERT INTO `tb_booking` (`id`, `idRuangan`, `peminjam`, `idInstansi`, `idUser`, `tanggal`, `dariJam`, `sampaiJam`, `agenda`, `idBarang`, `surat`, `file`, `status`, `terdaftar`) VALUES
(1, 1, 'test', 1, 2, '2024-10-21', '10:00:00', '21:00:00', 'test', '2', 'Ada', 'telegram.png', 'Diterima', '2023-11-29 11:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `tb_booking_barang`
--

CREATE TABLE `tb_booking_barang` (
  `id` int(11) NOT NULL,
  `idBarang` int(11) NOT NULL,
  `jumlah` varchar(500) NOT NULL,
  `idBarang2` int(11) NULL,
  `jumlah2` int(11) NULL,
  `stock` int(11) NOT NULL,
  `peminjam` varchar(256) NOT NULL,
  `idInstansi` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `dariJam` time NOT NULL,
  `sampaiJam` time NOT NULL,
  `agenda` varchar(256) NOT NULL,
  `surat` varchar(256) NULL,
  `file` varchar(256) NULL,
  `status` varchar(32) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_booking_barang`
--

INSERT INTO `tb_booking_barang` (`id`, `idBarang`, `idBarang2`, `stock`, `peminjam`, `idInstansi`, `idUser`, `tanggal`, `dariJam`, `sampaiJam`, `agenda`, `jumlah`, `jumlah2`, `surat`, `file`, `status`, `terdaftar`) VALUES
(1, 2, 1, 0, 'Test', 1, 1, '2024-11-10', '12:00:00', '23:00:00', 'test', '1', 1, 'Ada', 'twitter.png', 'Kembali', '2023-11-29 11:17:56'),
(4, 1, 2, 0, 'test', 1, 1, '2111-11-02', '21:00:00', '21:00:00', 'test', '2', 2, 'Ada', 'facebook1.png', 'Kembali', '2023-11-29 12:14:39'),
(5, 2, 1, 0, 'Test', 1, 1, '2024-11-21', '02:20:00', '21:00:00', 'Test', '2', 1, 'Ada', 'instagram1.png', 'Kembali', '2023-11-29 17:31:06'),
(6, 2, 1, 0, 'Test', 1, 1, '2024-10-21', '02:23:00', '21:00:00', 'test', '1', 2, 'Ada', 'Ujian_Online.png', 'Menunggu', '2023-11-29 18:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `tb_booking_instansi`
--

CREATE TABLE `tb_booking_instansi` (
  `id` int(11) NOT NULL,
  `idInstansi` int(11) NOT NULL,
  `peminjam` varchar(256) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `dariJam` time NOT NULL,
  `sampaiJam` time NOT NULL,
  `agenda` varchar(256) NOT NULL,
  `jumlah` varchar(500) NOT NULL,
  `surat` varchar(256) NOT NULL,
  `status` varchar(32) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_booking_kegiatan`
--

CREATE TABLE `tb_booking_kegiatan` (
  `id` int(11) NOT NULL,
  `idKegiatan` int(11) NOT NULL,
  `peminjam` varchar(256) NOT NULL,
  `idInstansi` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `dariJam` time NOT NULL,
  `sampaiJam` time NOT NULL,
  `agenda` varchar(256) NOT NULL,
  `idBarang` varchar(500) NOT NULL,
  `surat` varchar(256) NOT NULL,
  `file` varchar(256) NOT NULL,
  `status` varchar(32) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_instansi`
--

CREATE TABLE `tb_instansi` (
  `id` int(11) NOT NULL,
  `kode` varchar(256) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_instansi`
--

INSERT INTO `tb_instansi` (`id`, `kode`, `nama`, `terdaftar`) VALUES
(1, 'I01', 'Test1', '2023-11-29 11:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kegiatan`
--

CREATE TABLE `tb_kegiatan` (
  `id` int(11) NOT NULL,
  `kode` varchar(256) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` varchar(256) NOT NULL,
  `tempat` varchar(256) NOT NULL,
  `pegawai` varchar(256) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_log`
--

CREATE TABLE `tb_log` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `ipAddress` varchar(32) NOT NULL,
  `device` text NOT NULL,
  `status` varchar(16) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_log`
--

INSERT INTO `tb_log` (`id`, `idUser`, `ipAddress`, `device`, `status`, `terdaftar`) VALUES
(1, 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:120.0) Gecko/20100101 Firefox/120.0', 'Login', '2023-11-29 11:08:25'),
(2, 2, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:120.0) Gecko/20100101 Firefox/120.0', 'Login', '2023-11-29 11:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ruangan`
--

CREATE TABLE `tb_ruangan` (
  `id` int(11) NOT NULL,
  `kode` varchar(256) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_ruangan`
--

INSERT INTO `tb_ruangan` (`id`, `kode`, `nama`, `terdaftar`) VALUES
(1, 'R01', 'Ruangan 1', '2023-11-29 11:10:16');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `jenisKelamin` varchar(32) NOT NULL,
  `telp` varchar(16) NOT NULL,
  `email` varchar(256) NOT NULL,
  `alamat` text NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `foto` varchar(128) NOT NULL,
  `skin` varchar(8) NOT NULL,
  `level` varchar(16) NOT NULL,
  `login` varchar(8) NOT NULL,
  `terdaftar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `nama`, `jenisKelamin`, `telp`, `email`, `alamat`, `username`, `password`, `foto`, `skin`, `level`, `login`, `terdaftar`) VALUES
(1, 'Fariq Aditya Rahman', 'Laki-Laki', '082260636478', 'fariq012@gmail.com', 'Gunung Putri Circuit Sentul International', 'admin', '$2y$10$XRR25wG30kTxfbPOx1TR.ehlPYuAx2L96WILtiQOmCuH61VG.6j8y', 'no-image.png', 'blue', 'Administrator', 'Ya', '2023-02-16 10:03:46'),
(2, 'user', 'Laki-Laki', '2445425', 'mail@mail.com', 'Test', 'user', '$2y$10$2mGTZHvhVKpwyk4U2QyPQ.uVyuSTRa0zVN6tU8T7ww6O5wPSMTIAK', 'no-image.png', 'blue', 'User', 'Ya', '2023-11-29 11:37:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_aplikasi`
--
ALTER TABLE `tb_aplikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_backupdb`
--
ALTER TABLE `tb_backupdb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_booking`
--
ALTER TABLE `tb_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_booking_barang`
--
ALTER TABLE `tb_booking_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_booking_instansi`
--
ALTER TABLE `tb_booking_instansi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_booking_kegiatan`
--
ALTER TABLE `tb_booking_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_instansi`
--
ALTER TABLE `tb_instansi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_aplikasi`
--
ALTER TABLE `tb_aplikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_backupdb`
--
ALTER TABLE `tb_backupdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_booking`
--
ALTER TABLE `tb_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_booking_barang`
--
ALTER TABLE `tb_booking_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_booking_instansi`
--
ALTER TABLE `tb_booking_instansi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_booking_kegiatan`
--
ALTER TABLE `tb_booking_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_instansi`
--
ALTER TABLE `tb_instansi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_kegiatan`
--
ALTER TABLE `tb_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
