-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2023 at 09:09 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pelayananresto`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id` int(11) UNSIGNED NOT NULL,
  `kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id`, `kategori`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Snack');

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `id` int(11) UNSIGNED NOT NULL,
  `nomor_meja` int(50) NOT NULL,
  `status_meja` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`id`, `nomor_meja`, `status_meja`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(10, 7, 0),
(18, 8, 0),
(19, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2022-12-26-172206', 'App\\Database\\Migrations\\Users', 'default', 'App', 1672075454, 1),
(2, '2023-01-12-075539', 'App\\Database\\Migrations\\KategoriProduk', 'default', 'App', 1673510315, 2),
(3, '2023-01-12-075928', 'App\\Database\\Migrations\\Produk', 'default', 'App', 1673510627, 3),
(4, '2023-01-12-182817', 'App\\Database\\Migrations\\UserRole', 'default', 'App', 1673548178, 4),
(5, '2023-01-14-143258', 'App\\Database\\Migrations\\Meja', 'default', 'App', 1673706857, 5),
(6, '2023-01-14-150927', 'App\\Database\\Migrations\\Penjualan', 'default', 'App', 1673763586, 6),
(7, '2023-01-15-061405', 'App\\Database\\Migrations\\PenjualanDetail', 'default', 'App', 1673763586, 6),
(8, '2023-01-15-061923', 'App\\Database\\Migrations\\TempPenjualan', 'default', 'App', 1673763586, 6);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_meja` int(50) NOT NULL,
  `invoice` varchar(128) NOT NULL,
  `tanggal` date NOT NULL,
  `pelanggan` varchar(128) NOT NULL,
  `total` int(128) NOT NULL,
  `status_pesanan` int(50) NOT NULL,
  `status_pembayaran` int(50) NOT NULL,
  `tipe_pesanan` int(11) NOT NULL,
  `waiters` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `id_meja`, `invoice`, `tanggal`, `pelanggan`, `total`, `status_pesanan`, `status_pembayaran`, `tipe_pesanan`, `waiters`) VALUES
(10, 1, 'TRX17012300001', '2023-01-17', 'Mustaqim', 24000, 1, 1, 1, 'Aqil Mustaqim'),
(11, 5, 'TRX17012300002', '2023-01-17', 'Aqil', 23000, 1, 1, 1, 'Aqil Mustaqim'),
(12, 19, 'TRX17012300003', '2023-01-17', 'Nafi', 55000, 1, 1, 2, 'Aqil Mustaqim'),
(13, 19, 'TRX17012300004', '2023-01-17', 'Umum', 35000, 1, 0, 2, 'Aqil Mustaqim'),
(14, 19, 'TRX18012300001', '2023-01-18', 'Pak Agus', 11000, 0, 0, 2, 'Aqil Mustaqim'),
(15, 19, 'TRX18012300002', '2023-01-18', 'Acil', 33000, 0, 0, 2, 'Aqil Mustaqim'),
(16, 19, 'TRX18012300003', '2023-01-18', 'Umum', 24000, 0, 0, 2, 'Aqil Mustaqim'),
(17, 2, 'TRX18012300004', '2023-01-18', 'Didit', 23000, 0, 0, 1, 'Aqil Mustaqim'),
(18, 3, 'TRX01022300001', '2023-02-01', 'Fajar', 11000, 1, 1, 1, 'Aqil Mustaqim'),
(19, 4, 'TRX01022300002', '2023-02-01', 'Manda', 45000, 1, 1, 1, 'Aqil Mustaqim'),
(20, 6, 'TRX07022300001', '2023-02-07', 'Umum', 12000, 0, 0, 1, 'Muhammad Nafi Udin');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id` int(11) UNSIGNED NOT NULL,
  `invoice` varchar(128) NOT NULL,
  `id_produk` int(50) NOT NULL,
  `harga_beli` int(50) NOT NULL,
  `harga_jual` int(50) NOT NULL,
  `jumlah` int(50) NOT NULL,
  `subtotal` int(128) NOT NULL,
  `status_menu` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id`, `invoice`, `id_produk`, `harga_beli`, `harga_jual`, `jumlah`, `subtotal`, `status_menu`) VALUES
(13, 'TRX17012300001', 3, 5000, 12000, 2, 24000, 1),
(14, 'TRX17012300002', 4, 5000, 11000, 1, 11000, 1),
(15, 'TRX17012300002', 3, 5000, 12000, 1, 12000, 1),
(16, 'TRX17012300003', 4, 5000, 11000, 5, 55000, 1),
(17, 'TRX17012300004', 3, 5000, 12000, 2, 24000, 1),
(18, 'TRX17012300004', 4, 5000, 11000, 1, 11000, 1),
(19, 'TRX18012300001', 4, 5000, 11000, 1, 11000, 0),
(20, 'TRX18012300002', 4, 5000, 11000, 3, 33000, 0),
(21, 'TRX18012300003', 3, 5000, 12000, 2, 24000, 1),
(22, 'TRX18012300004', 4, 5000, 11000, 1, 11000, 0),
(23, 'TRX18012300004', 3, 5000, 12000, 1, 12000, 0),
(24, 'TRX01022300001', 4, 5000, 11000, 1, 11000, 1),
(25, 'TRX01022300002', 3, 5000, 12000, 1, 12000, 1),
(26, 'TRX01022300002', 4, 5000, 11000, 3, 33000, 1),
(27, 'TRX07022300001', 3, 5000, 12000, 1, 12000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_produk` varchar(50) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `kategori_produk_id` int(11) NOT NULL,
  `stok_produk` int(11) NOT NULL,
  `modal_produk` int(11) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `foto_produk` varchar(50) NOT NULL,
  `keterangan_produk` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kode_produk`, `nama_produk`, `kategori_produk_id`, `stok_produk`, `modal_produk`, `harga_produk`, `foto_produk`, `keterangan_produk`) VALUES
(2, 'PRDK002', 'Mie Aceh Goreng', 1, 0, 6000, 13000, '1673631246_b76bfe5f6eb814f3374d.jpeg', 'Mie Aceh Goreng Merupakan Mie Dengan Hasil Gorengan'),
(3, 'PRDK003', 'Mie Aceh Kepiting', 1, 1, 5000, 12000, '1673631449_29087d3d918f9ed3a65c.jpg', 'Mie Aceh Kepiting Dengan Varian Kuah Enak'),
(4, 'PRDK004', 'Mie Aceh Kuah Biasa', 1, 1, 5000, 11000, '1673631708_5c19fd3ae4be6f33182d.jpg', 'Mie Aceh Kuah Enak'),
(5, 'PRDK005', 'Teh Manis Dingin', 2, 0, 1000, 5000, '1675004463_e94184a3176dd8b87550.png', 'Teh Manis Enak');

-- --------------------------------------------------------

--
-- Table structure for table `temp_penjualan`
--

CREATE TABLE `temp_penjualan` (
  `id` int(11) UNSIGNED NOT NULL,
  `invoice` varchar(128) NOT NULL,
  `id_produk` int(50) NOT NULL,
  `harga_beli` int(50) NOT NULL,
  `harga_jual` int(50) NOT NULL,
  `jumlah` int(50) NOT NULL,
  `subtotal` int(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `temp_penjualan`
--

INSERT INTO `temp_penjualan` (`id`, `invoice`, `id_produk`, `harga_beli`, `harga_jual`, `jumlah`, `subtotal`) VALUES
(43, 'TRX09022300001', 3, 5000, 12000, 2, 24000),
(44, 'TRX09022300001', 3, 5000, 12000, 1, 12000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role_id` int(11) NOT NULL,
  `foto` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role_id`, `foto`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Aqil Mustaqim', 'aqilmustaqim28@gmail.com', '$2y$10$rWK9lONpGQkanhLhWC2FRernYkJ1h0bmtHSnZdPcsL/opdb4F.Vxm', 1, 'default.png', 1, '2023-01-13 01:52:10', '2023-02-15 11:57:47'),
(3, 'Muhammad Nafi Udin', 'sayanafi@gmail.com', '$2y$10$R4HLevPmz54kC.EPBHcdae5GPSoxXWwANg/Ed9qmyw/rfU7QYyT.i', 2, 'default.png', 1, '2023-01-13 08:40:01', '2023-01-13 09:19:15'),
(8, 'Yudha Anoraga', 'yudhaanoraga@gmail.com', '$2y$10$FfxvNNeO6LGkzk8RExv8VOByHZ8wliZLdmtw.cGB9TZLQwBlPdVGm', 3, 'default.png', 1, '2023-01-13 12:30:01', '2023-01-13 12:30:01'),
(9, 'Diana Puspita', 'diana@gmail.com', '$2y$10$gLOr7jqacu/Ouw4Gjk9Kp.NGSVifFcr/CjO7POXS78KgmqK7RoFFC', 4, 'default.png', 1, '2023-01-13 12:38:37', '2023-01-13 12:38:37'),
(10, 'Fahmi Pradana', 'fahmi@gmail.com', '$2y$10$nTCzar12o5qlT7u4S9WbmOIlaeJLv1TpfHF.QzX5vbjfQrImHzYMa', 5, 'default.png', 1, '2023-01-13 12:39:13', '2023-01-13 12:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) UNSIGNED NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Pelayan'),
(3, 'Koki Dine In'),
(4, 'Kasir'),
(5, 'Koki Take Away');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_meja` (`nomor_meja`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_penjualan`
--
ALTER TABLE `temp_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `meja`
--
ALTER TABLE `meja`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `temp_penjualan`
--
ALTER TABLE `temp_penjualan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
