-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 04:15 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `databases_2024_pengelolaan_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` varchar(15) NOT NULL,
  `id_transaksi` varchar(15) NOT NULL,
  `id_paket` varchar(10) NOT NULL,
  `qty` double NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `id_transaksi`, `id_paket`, `qty`, `keterangan`) VALUES
('DTL1053761016', 'TRX1188138529', 'PAK1278941', 6, ''),
('DTL1084183044', 'TRX1161395677', 'PAK1278941', 3, ''),
('DTL1105745016', 'TRX1198275034', 'PAK1278941', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `diskon`
--

CREATE TABLE `diskon` (
  `id_diskon` varchar(6) NOT NULL,
  `diskon` double NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `diskon`
--

INSERT INTO `diskon` (`id_diskon`, `diskon`, `total_harga`) VALUES
('DIS540', 3, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tlp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `nama`, `alamat`, `jenis_kelamin`, `tlp`) VALUES
('MEM1024878', 'Sapri', 'Desa Sumber Mulya', 'Laki-laki', '081294282541'),
('MEM1146991', 'Tomi', 'Desa Talang Bukit', 'Laki-laki', '082281095028'),
('MEM1176437', 'Silvi', 'Desa Suka Makmur, RT. 13', 'Perempuan', '082347564738'),
('MEM1276563', 'endrilia', 'ladang peris RT;20', 'Perempuan', '082103201212'),
('MEM1295335', 'Huna', 'Desa Talang Bukit', 'Perempuan', '082379981276');

-- --------------------------------------------------------

--
-- Table structure for table `outlet`
--

CREATE TABLE `outlet` (
  `id_outlet` varchar(13) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tlp` varchar(15) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `outlet`
--

INSERT INTO `outlet` (`id_outlet`, `nama`, `alamat`, `tlp`, `foto`) VALUES
('OUT1001676903', 'Outlet Sesena', 'Jambi', '081212345678', 'laundry.png'),
('OUT1078589195', 'Outlet Sukamaju', 'Desa SukaMaju dan Makmur\r\n', '081345566757', '65e41c036487b_7.png'),
('OUT1091316140', 'Outlet Liliani', 'Jl. Anggrek, Desa Kamboja, Jambi Barat, Rt. 16 Rw. 3', '082176377733', '65e4ff91b2083_1.png'),
('OUT1409226956', 'Outlet Eryunia', 'Desa Ladang Peris, Rt. 20', '082188776655', '65e500328dbc2_8.png');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id_paket` varchar(10) NOT NULL,
  `id_outlet` varchar(13) NOT NULL,
  `jenis` enum('kiloan','selimut','bed_cover','kaos','lain') NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `estimasi` varchar(50) NOT NULL,
  `foto_pkt` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id_paket`, `id_outlet`, `jenis`, `nama_paket`, `harga`, `estimasi`, `foto_pkt`) VALUES
('PAK1049406', 'OUT1078589195', 'selimut', 'paket hemat', 5000, '2', '65e0c5f1e6938_p4.png'),
('PAK1175599', 'OUT1409226956', 'kiloan', 'Paket Hemat', 5500, '3', '65e798eea4454_p4.png'),
('PAK1278941', 'OUT1001676903', 'kiloan', 'Paket Cuci Kering', 6000, '1', '65e0dbbbba2b4_8.png'),
('PAK1342150', 'OUT1091316140', 'kiloan', 'Paket Hemat', 5000, '3', '65e798c69e04c_p1.png');

-- --------------------------------------------------------

--
-- Table structure for table `sistem`
--

CREATE TABLE `sistem` (
  `apk_name` varchar(30) NOT NULL,
  `slogan` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tlp_` varchar(15) NOT NULL,
  `pajak` double NOT NULL,
  `diskon_mb` double NOT NULL,
  `antar` int(11) NOT NULL,
  `antar_jemput` int(11) NOT NULL,
  `jemput` int(11) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sistem`
--

INSERT INTO `sistem` (`apk_name`, `slogan`, `email`, `tlp_`, `pajak`, `diskon_mb`, `antar`, `antar_jemput`, `jemput`, `alamat`) VALUES
('Laundryuk', 'Bersih - Rapi - Wangi', 'ervinnamanik13@gmail.com', '081234567894', 1, 3, 15000, 23000, 0, 'Jl. Mekar Indah, Desa Ladang Peris, Kec. Batanghari, Kab. Bajubang, Jambi');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(15) NOT NULL,
  `id_outlet` varchar(13) NOT NULL,
  `kode_invoice` varchar(100) NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `tgl` datetime NOT NULL,
  `batas_waktu` datetime NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `biaya_tambahan` int(11) NOT NULL,
  `diskon` double NOT NULL,
  `pajak` int(11) NOT NULL,
  `status` enum('baru','proses','selesai','diambil') NOT NULL,
  `dibayar` enum('dibayar','belum_dibayar') NOT NULL,
  `id_user` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_outlet`, `kode_invoice`, `id_member`, `tgl`, `batas_waktu`, `tgl_bayar`, `biaya_tambahan`, `diskon`, `pajak`, `status`, `dibayar`, `id_user`) VALUES
('TRX1161395677', 'OUT1001676903', 'INV202403064482', 'MEM1146991', '2024-03-06 05:06:10', '2024-03-09 05:06:10', '2024-03-06 05:07:22', 0, 0, 1, 'baru', 'dibayar', 'adm123321'),
('TRX1188138529', 'OUT1001676903', 'INV202403067568', 'MEM1146991', '2024-03-06 06:17:02', '2024-03-12 06:17:02', '2024-03-06 08:03:09', 15000, 0, 1, 'baru', 'dibayar', 'adm123321'),
('TRX1198275034', 'OUT1001676903', 'INV202403061161', 'MEM1176437', '2024-03-06 05:20:52', '2024-03-09 05:20:52', '0000-00-00 00:00:00', 0, 0, 1, 'baru', 'belum_dibayar', 'adm123321');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `id_outlet` varchar(13) DEFAULT NULL,
  `role` enum('admin','kasir','owner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `id_outlet`, `role`) VALUES
('adm123321', 'admin', 'admin', 'admin', NULL, 'admin'),
('adm1513668', 'Malik', 'malik358236', 'admmal3797', NULL, 'admin'),
('kas1111', 'kasir', 'kasir', 'kasir', 'OUT1078589195', 'kasir'),
('kas9324092', 'Kinara Putri', 'kinara332980', 'kaskin9170', 'OUT1409226956', 'kasir'),
('own12321', 'owner', 'owner', 'owner', 'OUT1001676903', 'owner'),
('own9191710', 'Melati Putri', 'melati845713', 'ownmel6210', 'OUT1078589195', 'owner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `outlet`
--
ALTER TABLE `outlet`
  ADD PRIMARY KEY (`id_outlet`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id_paket`),
  ADD KEY `id_outlet` (`id_outlet`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_outlet` (`id_outlet`,`id_member`,`id_user`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_outlet` (`id_outlet`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_paket`) REFERENCES `paket` (`id_paket`),
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`);

--
-- Constraints for table `paket`
--
ALTER TABLE `paket`
  ADD CONSTRAINT `paket_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `outlet` (`id_outlet`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `outlet` (`id_outlet`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_outlet`) REFERENCES `outlet` (`id_outlet`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
