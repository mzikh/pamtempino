-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2024 at 01:37 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_air1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_beban`
--

CREATE TABLE `tb_beban` (
  `id_beban` int(11) NOT NULL,
  `beban` varchar(20) NOT NULL,
  `harga_beban` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_beban`
--

INSERT INTO `tb_beban` (`id_beban`, `beban`, `harga_beban`) VALUES
(1, 'Listrik', 11000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_bulan`
--

CREATE TABLE `tb_bulan` (
  `id_bulan` char(3) NOT NULL,
  `nama_bulan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_bulan`
--

INSERT INTO `tb_bulan` (`id_bulan`, `nama_bulan`) VALUES
('A', 'Januari'),
('B', 'Februari'),
('C', 'Maret'),
('D', 'April'),
('E', 'Mei'),
('F', 'Juni'),
('G', 'Juli'),
('H', 'Agustus'),
('I', 'September'),
('J', 'Oktober'),
('K', 'November'),
('L', 'Desember');

-- --------------------------------------------------------

--
-- Table structure for table `tb_info`
--

CREATE TABLE `tb_info` (
  `id_info` int(11) NOT NULL,
  `isi_info` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_info`
--

INSERT INTO `tb_info` (`id_info`, `isi_info`) VALUES
(1, 'Untuk para pelanggan segera membayar tagihan bulan ini. Terimakasih.');

-- --------------------------------------------------------

--
-- Table structure for table `tb_layanan`
--

CREATE TABLE `tb_layanan` (
  `id_layanan` int(11) NOT NULL,
  `layanan` varchar(20) NOT NULL,
  `tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_layanan`
--

INSERT INTO `tb_layanan` (`id_layanan`, `layanan`, `tarif`) VALUES
(1, 'Layanan Air 1', 5000),
(2, 'Layanan air 2', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pakai`
--

CREATE TABLE `tb_pakai` (
  `id_pakai` char(11) NOT NULL,
  `id_pelanggan` char(15) NOT NULL,
  `bulan` char(3) NOT NULL,
  `tahun` char(4) NOT NULL,
  `awal` int(11) NOT NULL,
  `akhir` int(11) NOT NULL,
  `pakai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pakai`
--

INSERT INTO `tb_pakai` (`id_pakai`, `id_pelanggan`, `bulan`, `tahun`, `awal`, `akhir`, `pakai`) VALUES
('K000000001', '10', 'A', '2024', 0, 0, 0),
('K000000002', '10', 'A', '2024', 0, 5, 5),
('K000000003', '10', 'B', '2024', 5, 10, 5),
('K000000004', '10', 'C', '2024', 10, 15, 5),
('K000000005', '11', 'C', '2024', 0, 0, 0),
('K000000006', '11', 'D', '2024', 0, 5, 5),
('K000000007', '11', 'B', '2024', 5, 10, 5),
('K000000008', '11', 'C', '2024', 10, 15, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` char(15) NOT NULL,
  `nama_pelanggan` varchar(20) NOT NULL,
  `alamat` varchar(40) NOT NULL,
  `no_hp` char(15) NOT NULL,
  `status` char(10) NOT NULL DEFAULT 'Aktif',
  `id_layanan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `no_hp`, `status`, `id_layanan`) VALUES
('10', 'M Zainul Ikhsan', 'Tempino', '0813228584838', 'Aktif', 1),
('11', 'Abdurrahman Fathan M', 'Jelutung', '083166482934', 'Aktif', 1),
('12', 'Ahmad Iqbal Siregar', 'Tungkal', '083149293732', 'Aktif', 1),
('13', 'Bastian Wahyudi', 'Riau', '0831632882392', 'Aktif', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_tagihan` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `uang_bayar` int(11) NOT NULL,
  `kembali` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id_tagihan`, `tgl_bayar`, `uang_bayar`, `kembali`) VALUES
(90, '2024-05-04', 40000, 4000),
(91, '2024-05-04', 40000, 4000),
(92, '2024-05-08', 40000, 4000),
(94, '2024-05-13', 50000, 14000),
(95, '2024-05-17', 40000, 4000),
(96, '2024-05-22', 40000, 4000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengaduan`
--

CREATE TABLE `tb_pengaduan` (
  `id_pengaduan` int(11) NOT NULL,
  `id_pelanggan` char(15) CHARACTER SET latin1 NOT NULL,
  `tgl_pengaduan` datetime NOT NULL,
  `subjek_pengaduan` varchar(200) NOT NULL,
  `deskripsi_pengaduan` text NOT NULL,
  `foto_pengaduan` varchar(255) NOT NULL,
  `status_pengaduan` enum('Pending','Proses','Selesai') NOT NULL,
  `bukti_pengaduan` varchar(255) NOT NULL,
  `tgl_diselesaikan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pengaduan`
--

INSERT INTO `tb_pengaduan` (`id_pengaduan`, `id_pelanggan`, `tgl_pengaduan`, `subjek_pengaduan`, `deskripsi_pengaduan`, `foto_pengaduan`, `status_pengaduan`, `bukti_pengaduan`, `tgl_diselesaikan`) VALUES
(8, '10', '2024-05-31 12:57:16', 'Pipa Patah', 'Di injak anak kecil', 'kurma 3.jpg', 'Pending', '', '0000-00-00 00:00:00'),
(9, '10', '2024-05-31 13:20:19', 'Kebocoran Pipa', 'Pipa ny patah', 'pumpkin.png', 'Pending', '', '0000-00-00 00:00:00');

--
-- Triggers `tb_pengaduan`
--
DELIMITER $$
CREATE TRIGGER `trg_update_tgl_diselesaikan` BEFORE UPDATE ON `tb_pengaduan` FOR EACH ROW BEGIN
    IF NEW.status_pengaduan = 'Selesai' THEN
        SET NEW.tgl_diselesaikan = NOW();
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tagihan`
--

CREATE TABLE `tb_tagihan` (
  `id_tagihan` int(11) NOT NULL,
  `id_pakai` char(11) NOT NULL,
  `tagihan` int(11) NOT NULL,
  `status` char(12) NOT NULL DEFAULT 'Belum Bayar'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_tagihan`
--

INSERT INTO `tb_tagihan` (`id_tagihan`, `id_pakai`, `tagihan`, `status`) VALUES
(74, 'K000000001', 0, 'Belum Bayar'),
(90, 'K000000002', 36000, 'Lunas'),
(91, 'K000000003', 36000, 'Lunas'),
(92, 'K000000004', 36000, 'Lunas'),
(93, 'K000000005', 0, 'Belum Bayar'),
(94, 'K000000006', 36000, 'Lunas'),
(95, 'K000000007', 36000, 'Lunas'),
(96, 'K000000008', 36000, 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(20) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `level` varchar(15) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `no_rek` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_user`, `username`, `password`, `level`, `no_hp`, `no_rek`) VALUES
(1, 'Amad Khoiri', 'admin', '1', 'Administrator', '085878526022', ''),
(2, 'Fachrul Sukmadinata', 'opt', '1', 'Operator', '087789987654', ''),
(21, 'M Zainul Ikhsan', 'Zainul', '1', 'Pelanggan', '0813228584838', '10'),
(22, 'Abdurrahman Fathan M', 'Fathan', '1', 'Pelanggan', '083166482934', '11'),
(23, 'Ahmad Iqbal Siregar', 'iqbal', '1', 'Pelanggan', '083149293732', '12'),
(24, 'Bastian Wahyudi', 'Bastian', '1', 'Pelanggan', '0831632882392', '13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_beban`
--
ALTER TABLE `tb_beban`
  ADD PRIMARY KEY (`id_beban`);

--
-- Indexes for table `tb_bulan`
--
ALTER TABLE `tb_bulan`
  ADD PRIMARY KEY (`id_bulan`);

--
-- Indexes for table `tb_info`
--
ALTER TABLE `tb_info`
  ADD PRIMARY KEY (`id_info`);

--
-- Indexes for table `tb_layanan`
--
ALTER TABLE `tb_layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `tb_pakai`
--
ALTER TABLE `tb_pakai`
  ADD PRIMARY KEY (`id_pakai`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `bulan` (`bulan`);

--
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD KEY `tb_pelanggan_ibfk_1` (`id_layanan`);

--
-- Indexes for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD KEY `tb_pembayaran_ibfk_1` (`id_tagihan`);

--
-- Indexes for table `tb_pengaduan`
--
ALTER TABLE `tb_pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_pelanggan_2` (`id_pelanggan`);

--
-- Indexes for table `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `id_pelanggan` (`id_pakai`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_beban`
--
ALTER TABLE `tb_beban`
  MODIFY `id_beban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_info`
--
ALTER TABLE `tb_info`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_layanan`
--
ALTER TABLE `tb_layanan`
  MODIFY `id_layanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_pengaduan`
--
ALTER TABLE `tb_pengaduan`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  MODIFY `id_tagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_pakai`
--
ALTER TABLE `tb_pakai`
  ADD CONSTRAINT `tb_pakai_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `tb_pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_pakai_ibfk_2` FOREIGN KEY (`bulan`) REFERENCES `tb_bulan` (`id_bulan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD CONSTRAINT `tb_pelanggan_ibfk_1` FOREIGN KEY (`id_layanan`) REFERENCES `tb_layanan` (`id_layanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD CONSTRAINT `tb_pembayaran_ibfk_1` FOREIGN KEY (`id_tagihan`) REFERENCES `tb_tagihan` (`id_tagihan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pengaduan`
--
ALTER TABLE `tb_pengaduan`
  ADD CONSTRAINT `tb_pengaduan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `tb_pelanggan` (`id_pelanggan`) ON DELETE CASCADE;

--
-- Constraints for table `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  ADD CONSTRAINT `tb_tagihan_ibfk_1` FOREIGN KEY (`id_pakai`) REFERENCES `tb_pakai` (`id_pakai`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
