-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2019 at 05:08 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tspdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `id_jenis_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `id_jenis_barang`, `nama_barang`, `deskripsi`) VALUES
(1, 1, 'ROG', '<p>adalah laptop asus rog</p>'),
(2, 1, 'Alienware', '<p>dari dell</p>'),
(3, 2, 'Epson', '<p>dari epson</p>'),
(4, 2, 'Canon', '<p>dari canon</p>'),
(5, 3, 'ROG Phone', '<p>dari Asus</p>'),
(6, 3, 'Pixel 4', '<p>by Google</p>'),
(7, 3, 'Iphone 11', '<p>adalah iphone 11</p>');

-- --------------------------------------------------------

--
-- Table structure for table `detail_barang`
--

CREATE TABLE `detail_barang` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `registered_number` varchar(100) NOT NULL,
  `owner` int(11) NOT NULL,
  `kondisi` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_barang`
--

INSERT INTO `detail_barang` (`id`, `id_barang`, `registered_number`, `owner`, `kondisi`, `catatan`, `last_update`) VALUES
(1, 1, 'ROG112310', 4, 1, '<p>Oke</p>', '2019-11-19 10:36:42'),
(2, 1, 'ROG112311', 4, 1, '<p>Oke</p>', '2019-11-19 08:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `kondisi`
--

CREATE TABLE `kondisi` (
  `id` int(11) NOT NULL,
  `kondisi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kondisi`
--

INSERT INTO `kondisi` (`id`, `kondisi`) VALUES
(1, 'Baik dan Digunakan'),
(2, 'Baik dan Tidak Digunakan'),
(3, 'Rusak dan Digunakan'),
(4, 'Rusak dan Tidak Digunakan');

-- --------------------------------------------------------

--
-- Table structure for table `log_detail_barang`
--

CREATE TABLE `log_detail_barang` (
  `id` int(11) NOT NULL,
  `id_detail_barang` int(11) NOT NULL,
  `kondisi` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `url_gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_detail_barang`
--

INSERT INTO `log_detail_barang` (`id`, `id_detail_barang`, `kondisi`, `owner`, `catatan`, `tanggal`, `id_user`, `url_gambar`) VALUES
(1, 2, 1, 0, '<p>Baru Pertama</p>', '2019-11-15 09:18:36', 1, ''),
(2, 2, 1, 10, 'Diberikan ke user', '2019-11-16 09:27:32', 1, ''),
(3, 2, 1, 4, '<p>doni</p>', '2019-11-19 06:35:41', 0, 'http://localhost/tsp/uploads/inventory/2019/11/201911190635412_inventory.jpg'),
(4, 2, 3, 4, '<p>Rodo Rusak sitik</p>', '2019-11-19 06:36:36', 0, 'http://localhost/tsp/uploads/inventory/2019/11/201911190636362_inventory.jpg'),
(5, 2, 3, 4, '<p>Rodo Rusak sitik</p>', '2019-11-19 06:37:01', 0, 'http://localhost/tsp/uploads/inventory/2019/11/201911190637012_inventory.jpg'),
(6, 2, 3, 4, '<p>Rodo Rusak sitik</p>', '2019-11-19 06:37:14', 0, 'http://localhost/tsp/uploads/inventory/2019/11/201911190637142_inventory.jpg'),
(7, 2, 1, 4, '<p>Baik</p>', '2019-11-19 06:37:43', 0, ''),
(8, 2, 1, 4, '<p>Oke</p>', '2019-11-19 08:20:25', 1, 'http://localhost/tsp/uploads/inventory/2019/11/201911190820252_inventory.jpg'),
(9, 1, 1, 4, '<p>Oke</p>', '2019-11-19 10:36:42', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `master_cabang`
--

CREATE TABLE `master_cabang` (
  `id` int(11) NOT NULL,
  `nama_cabang` text NOT NULL,
  `alamat_cabang` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_cabang`
--

INSERT INTO `master_cabang` (`id`, `nama_cabang`, `alamat_cabang`) VALUES
(1, 'Kantor Pusat', 'Semarang Raya'),
(2, 'Cabang Solo', 'Solo Raya'),
(3, 'Cabang Pati', 'Pati Raya');

-- --------------------------------------------------------

--
-- Table structure for table `master_jenis_barang`
--

CREATE TABLE `master_jenis_barang` (
  `id` int(11) NOT NULL,
  `jenis_barang` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_jenis_barang`
--

INSERT INTO `master_jenis_barang` (`id`, `jenis_barang`) VALUES
(1, 'Laptop Mahal'),
(2, 'Printer'),
(3, 'Smartphone');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `ref` int(11) NOT NULL,
  `userlevel` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `cabang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `ref`, `userlevel`, `status`, `cabang`) VALUES
(1, 'superadmin', 'b32204fd7ccd7383613e2a1b298fc8814c8c3420', 0, 1, 1, 1),
(2, 'manajerpusat', 'b32204fd7ccd7383613e2a1b298fc8814c8c3420', 0, 2, 1, 1),
(3, 'adminpusat', 'b32204fd7ccd7383613e2a1b298fc8814c8c3420', 0, 3, 1, 1),
(4, 'userpusat', 'b32204fd7ccd7383613e2a1b298fc8814c8c3420', 0, 4, 1, 1),
(5, 'manajersolo', 'b32204fd7ccd7383613e2a1b298fc8814c8c3420', 0, 2, 1, 2),
(6, 'adminsolo', 'b32204fd7ccd7383613e2a1b298fc8814c8c3420', 0, 3, 1, 2),
(7, 'usersolo', 'b32204fd7ccd7383613e2a1b298fc8814c8c3420', 0, 4, 1, 2),
(8, 'manajerpati', 'b32204fd7ccd7383613e2a1b298fc8814c8c3420', 0, 2, 1, 3),
(9, 'adminpati', 'b32204fd7ccd7383613e2a1b298fc8814c8c3420', 0, 3, 1, 3),
(10, 'userpati', 'b32204fd7ccd7383613e2a1b298fc8814c8c3420', 0, 4, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `userlevel`
--

CREATE TABLE `userlevel` (
  `id` int(11) NOT NULL,
  `userlevel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlevel`
--

INSERT INTO `userlevel` (`id`, `userlevel`) VALUES
(1, 'Superadmin'),
(2, 'Manajer'),
(3, 'Admin'),
(4, 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_barang`
--
ALTER TABLE `detail_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kondisi`
--
ALTER TABLE `kondisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_detail_barang`
--
ALTER TABLE `log_detail_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_cabang`
--
ALTER TABLE `master_cabang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_jenis_barang`
--
ALTER TABLE `master_jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlevel`
--
ALTER TABLE `userlevel`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detail_barang`
--
ALTER TABLE `detail_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kondisi`
--
ALTER TABLE `kondisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log_detail_barang`
--
ALTER TABLE `log_detail_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `master_cabang`
--
ALTER TABLE `master_cabang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_jenis_barang`
--
ALTER TABLE `master_jenis_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `userlevel`
--
ALTER TABLE `userlevel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
