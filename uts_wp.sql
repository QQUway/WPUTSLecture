-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2024 at 06:29 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uts_wp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `user_id`, `name`) VALUES
(1, 1, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `nasabah_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Nama` varchar(255) DEFAULT NULL,
  `Alamat` varchar(255) DEFAULT NULL,
  `Jenis_Kelamin` varchar(20) DEFAULT NULL,
  `Tanggal_Lahir` date DEFAULT NULL,
  `Upload_File_Bukti_Pembayaran_Bayaran_Simpanan_Pokok` varchar(255) DEFAULT NULL,
  `saldo` decimal(30,2) DEFAULT 0.00,
  `wajib` decimal(30,2) NOT NULL DEFAULT 0.00,
  `sukarela` decimal(30,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`nasabah_id`, `user_id`, `Email`, `Nama`, `Alamat`, `Jenis_Kelamin`, `Tanggal_Lahir`, `Upload_File_Bukti_Pembayaran_Bayaran_Simpanan_Pokok`, `saldo`, `wajib`, `sukarela`) VALUES
(5, 1, 'Admin@localhost.kdhh', 'Admin', 'lelekuda', 'Laki-laki', '2004-03-10', 'Melancholic Ensemble Album Cover.png', 0.00, 0.00, 0.00),
(8, 2, 'rifqihabib04@gmail.com', 'rifqi', 'rifqi02', 'Laki-laki', '2004-10-03', 'Screenshot 2022-03-17 203934.png', 0.00, 0.00, 0.00),
(9, 3, 'haya@amel.nt', 'haya', 'haya', 'Laki-laki', '3912-10-09', 'mio.png', 0.00, 0.00, 0.00),
(10, 4, 'bian@bian.bian', 'bian', 'bian', 'Laki-laki', '1000-10-10', 'mio.png', 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_data`
--

CREATE TABLE `transaction_data` (
  `transaction_id` int(11) NOT NULL,
  `status` enum('pending','verified') NOT NULL,
  `nasabah_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `kategori` enum('Wajib','Sukarela') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `file_upload_transaction_image_proof` varchar(255) DEFAULT NULL,
  `tanggal_transfer` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_data`
--

INSERT INTO `transaction_data` (`transaction_id`, `status`, `nasabah_id`, `admin_id`, `kategori`, `amount`, `file_upload_transaction_image_proof`, `tanggal_transfer`) VALUES
(7, 'verified', 8, NULL, 'Wajib', 200000.00, 'mio.png', '0000-00-00'),
(8, 'verified', 8, NULL, 'Wajib', 200000.00, 'mio.png', '0000-00-00'),
(9, 'verified', 8, NULL, 'Wajib', 200000.00, 'mio.png', '0000-00-00'),
(10, 'verified', 8, NULL, 'Wajib', 20000.00, 'mio.png', '0000-00-00'),
(11, 'pending', 8, NULL, 'Wajib', 200000.00, 'mio.png', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(4) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'Admin', '$2y$10$t/3HY2nBVKdtPcCtAMJyr.18Ysc7ZB8JFOvSpFJnx8cgQmKg.onp2'),
(2, 'Rifqi', '$2y$10$AHfDJdwo6QUzjKSZHIHPquL4lUa3t6Y6XnSzxl1QVQm3tMAIPKwXu'),
(3, 'haya', '$2y$10$waFkvkgpzVR46VGdfsTvXu9KlaIeXtthr7pqi/oUydrw744GFIwqS'),
(4, 'bian', '$2y$10$PEN0sM8BfYYDFJQDv540WuI83vgiGEt4vR13zTlnXGZOd6vND9Lh6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`nasabah_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaction_data`
--
ALTER TABLE `transaction_data`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `nasabah_id` (`nasabah_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `nasabah_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaction_data`
--
ALTER TABLE `transaction_data`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD CONSTRAINT `nasabah_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `transaction_data`
--
ALTER TABLE `transaction_data`
  ADD CONSTRAINT `transaction_data_ibfk_1` FOREIGN KEY (`nasabah_id`) REFERENCES `nasabah` (`nasabah_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_data_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
