-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 28, 2024 at 05:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockbuku`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` bigint(20) NOT NULL,
  `idbuku` bigint(40) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `harga` decimal(30,2) NOT NULL,
  `penerima` varchar(25) NOT NULL,
  `qty` bigint(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `username`, `last_name`, `email`, `password`) VALUES
(1, 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$L2JA2/0vF9HECvCeG4yRu.04nfC4s9D8/KBnTD.78yrNpR96J.xeK');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` bigint(40) NOT NULL,
  `idbuku` bigint(40) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `distributor` varchar(50) NOT NULL,
  `qty` bigint(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbuku`, `tanggal`, `distributor`, `qty`) VALUES
(1, 1, '2024-06-04 15:41:26', 'US', 100),
(2, 2, '2024-06-14 15:41:26', 'US', 150),
(3, 3, '2024-06-02 15:41:26', 'US', 80),
(4, 4, '2024-06-04 15:41:26', 'US', 120),
(5, 5, '2024-06-23 15:41:26', 'US', 90),
(6, 6, '2024-06-07 15:41:26', 'UK', 110),
(7, 7, '2024-06-06 15:41:26', 'US', 70),
(8, 8, '2024-06-12 15:41:26', 'UK', 130),
(9, 9, '2024-06-23 15:41:26', 'US', 60),
(10, 10, '2024-06-21 15:41:26', 'UK', 140),
(11, 11, '2024-06-01 15:41:26', 'US', 110),
(12, 12, '2024-06-09 15:41:26', 'US', 90),
(13, 13, '2024-06-08 15:41:26', 'US', 50),
(14, 14, '2024-06-26 15:41:26', 'US', 70),
(15, 15, '2024-06-25 15:41:26', 'US', 120),
(16, 16, '2024-06-27 15:41:26', 'US', 100),
(17, 17, '2024-06-07 15:41:26', 'US', 80),
(18, 18, '2024-06-06 15:41:26', 'UK', 110),
(19, 19, '2024-06-09 15:41:26', 'US', 90),
(20, 20, '2024-06-24 15:41:26', 'US', 100),
(21, 21, '2024-06-08 15:41:26', 'US', 70),
(22, 22, '2024-06-19 15:41:26', 'US', 120),
(23, 23, '2024-06-07 15:41:26', 'UK', 80),
(24, 24, '2024-06-13 15:41:26', 'UK', 110),
(25, 25, '2024-06-19 15:41:26', 'UK', 100),
(26, 26, '2024-06-02 15:41:26', 'UK', 130),
(27, 27, '2024-06-07 15:41:26', 'US', 90),
(28, 28, '2024-06-21 15:41:26', 'UK', 100),
(29, 29, '2024-06-22 15:41:26', 'UK', 80),
(30, 30, '2024-06-16 15:41:26', 'US', 110),
(31, 31, '2024-06-07 15:41:26', 'UK', 70),
(32, 32, '2024-06-06 15:41:26', 'UK', 120),
(33, 33, '2024-06-25 15:41:26', 'US', 90),
(34, 34, '2024-06-27 15:41:26', 'UK', 100);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idpeminjaman` bigint(40) NOT NULL,
  `idbuku` bigint(40) NOT NULL,
  `qty` bigint(40) NOT NULL,
  `peminjam` varchar(30) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Dipinjam',
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `denda` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `idregister` bigint(40) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`idregister`, `first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$L2JA2/0vF9HECvCeG4yRu.04nfC4s9D8/KBnTD.78yrNpR96J.xeK', '2024-06-28 01:03:22', '2024-06-28 01:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `last_access` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `data`, `last_access`) VALUES
('0rk4pl9ncmmhc3f3cuvbgmdl00', 'aXpyUk1IVmk1YXMrQUIzL3ZVT1FFNDRWdWZqU1pEdXJSbUZITk1oUm5rUlhJZmZjWWtjeVZ4TEI1ajFhazVOSjZPQWw4UTN4aktFcGRUTFB1RzFwWXFVZlZyZStyUzI4cGlxK09ZMThuNlV6dS9ZV1E4RURndjgyR3l1Y3c3dTJFN0ZkSHhwWUJnSCtwL2FEcU1MU1NVYzJuQWR4MS9lbXFnanVIcVJGR1djUW8vMFgrR2NtNjVrK05BYUpmcmY2OjqN6eUQFfN1QNGPImQpLukb', '2024-06-28 01:53:16');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idbuku` bigint(20) NOT NULL,
  `judulbuku` varchar(255) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` varchar(50) NOT NULL,
  `genre_buku` varchar(255) NOT NULL,
  `penulis` varchar(50) NOT NULL,
  `harga` decimal(30,2) NOT NULL,
  `stock` bigint(40) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`idbuku`, `judulbuku`, `penerbit`, `tahun_terbit`, `genre_buku`, `penulis`, `harga`, `stock`, `image`) VALUES
(1, 'This Year It Will Be Different', 'Doubleday', '2023', 'Fiksi Kontemporer, Fiksi Keluarga, Drama', 'Maeve Binchy', 58000.00, 245, 'e914e8880663a8fc0aa5f750458c747f.jpg'),
(2, 'David Copperfield', 'Penguin Classics (edisi terbaru)', '2003', 'Fiksi klasik, novel bildungsroman', 'Charles Dickens', 85000.00, 373, '03eb5584bb4610ec557fa9995be5fd9c.jpg'),
(3, 'About a Boy', 'Vintage Books', '1998', 'Fiksi dewasa, komedi romantis', 'Nick Hornby', 58000.00, 222, '17b416769ba59710613f9fd4b722caef.jpg'),
(4, 'They Do It with Mirrors', 'Dodd, Mead and Company', '1952', 'Novel kejahatan', 'Agatha Christie', 45000.00, 474, '1d69631885bd832334e46432c709f34d.jpg'),
(5, 'Diary of a Wimpy Kid: The Third Wheel', 'Andrews McMeel Publishing', '2013', 'Children\'s fiction, humor, diary', 'Jeff Kinney', 90000.00, 299, '936a203c54e39dea74eea3cd4b939174.jpg'),
(6, 'Diary of a Wimpy Kid: Cabin Fever', 'Andrews McMeel Publishing', '2011', 'Buku anak-anak, fiksi, humor', 'Jeff Kinney', 90000.00, 128, '0418f9c644c6132c3884a7aad12659bb.jpg'),
(7, 'Decisions at 13/14+: The Starting Point for GCSE Options', 'Hobson\'s Publishing PLC', '2008', 'Buku panduan pendidikan, karir, dan pengembangan diri', 'Michael Smith dan Veronica Matthew', 58000.00, 347, '38c0b816163913c4f27a022f71ef2d5f.jpg'),
(8, 'Round and Round the Garden', 'Kingfisher Books (Originally Parragon Books)', '2000', 'Buku anak-anak, puisi', 'Jane Taylor', 130000.00, 300, '507adf97cef737231974bf0df35ecdec.jpg'),
(9, 'The Luckiest Kids in the World: The Pony Party!', 'Scholastic Inc.', '2002', 'Children\'s book, fiction', 'Loney M. Setnick', 75000.00, 65, '7de11afd03efec599f9cf99f413e3068.jpg'),
(10, 'Gold Stars Picture Atlas', 'Parragon Book Service Limited', '2007', 'Buku atlas anak-anak, non-fiksi', 'Pam Beasant', 75000.00, 166, '8e95650f9e93c4904920adb5570858b0.jpg'),
(11, 'The Firm', 'Doubleday', '1991', 'Misteri Hukum, Fiksi Thriller', 'John Grisham', 75000.00, 237, 'b3a482381100c74d602850d6f48c513a.jpg'),
(12, 'Hello Oscar!', 'Walker Books', '2009', 'Children\'s Picture Book, Fiction', 'Chloe Inkpen and Mick Inkpen', 58000.00, 211, '70ed6c83ce716eb3d082c71a503a6a7c.jpg'),
(13, 'The Innocent Man', 'Doubleday', '2006', 'Non-fiksi, Kejahatan, Hukum', 'John Grisham', 75000.00, 28, '809fed916e541432df4697d58387269a.jpg'),
(14, 'The Graft', 'Distinctive Publishing', 'August 29, 2022', 'Crime thriller', 'Martina Cole', 75000.00, 44, 'e576a8b7e71ad92930a0f2dc06666786.jpg'),
(15, 'Red Rabbit', 'Putnam', '2022', 'Political Thriller, Spy Novel', 'Tom Clancy', 75000.00, 300, '4658190f9105eac1de9e4cb1700aff3c.jpg'),
(16, 'Bloodstream', 'HarperCollins', '2004', 'Medical Thriller', 'Tess Gerritsen', 75000.00, 491, '3a353c59d3e2f21352d92affbf1d02f2.jpg'),
(17, 'The King of Torts', 'Doubleday', '1999', 'Legal Thriller', 'John Grisham', 58000.00, 129, 'e8a5034322c0f75cfe1547fe947d5a22.jpg'),
(18, 'The Ship of Brides', 'Penguin Random House', '2005', 'Historical Fiction, Romance', 'Jojo Moyes', 85000.00, 429, '5f4cb5b70143cd1b55c3217d395f0e21.jpg'),
(19, 'Life of Pi', 'Harcourt Brace & Company', '2001', 'Fiksi, petualangan, spiritual', 'Yann Martel', 75000.00, 434, '9d36846664088d7fa30beaf0540bb696.jpg'),
(20, 'A Place Called Here', 'Henry Holt and Company', '2004', 'Fiksi dewasa muda, romansa', 'Cecelia Ahern', 75000.00, 200, 'ff526e7a17dc97e3d088daa2f44297d1.jpg'),
(21, 'The Marble Collector', 'Henry Holt and Company', '2012', 'fiksi dewasa muda, romansa', 'Cecelia Ahern', 85000.00, 82, 'c7554403a46d2694c8dd6a34e2c8f7a9.jpg'),
(22, 'The Hunger Games', 'Scholastic Press', '2008', 'Young adult dystopian fiction, science fiction, thriller', 'Suzanne Collins', 75000.00, 471, '320e466654446f16658cc64ac34d349e.jpg'),
(23, 'The Kite Runner', 'Riverhead Books', '2003', 'Fiksi dewasa muda, fiksi sejarah', 'Khaled Hosseini', 85000.00, 245, 'b0e45c664ff00f8cbed5764a5cd017f6.jpg'),
(24, 'Planet Earth', 'Usborne Publishing Ltd', '2007', 'Non-fiction, Children\'s Science', 'Leonie Pratt', 58000.00, 172, '40b918626e517f0f9d12c982f80b91b8.jpg'),
(25, 'Kernowland: The Crystal Pool', 'Severn House', '2023', 'Fiksi Dewasa, Fiksi Fantasi, Fiksi Misteri', 'Jack Trelawny', 75000.00, 409, '6832a03d995175938ccf6558d2c49a22.jpg'),
(26, 'Free Stuff for Doll Lovers on the Internet', 'Krause Publications', '2000', 'Hobi dan Koleksi', 'Judy Heim dan Gloria Hansen', 45000.00, 293, 'a306f7a939f0d7479311c1ab7bfa7492.jpg'),
(27, 'A Question of Principle', 'St. Martin\'s Press', '1987', 'Novel misteri', 'Jeffrey Ashford', 45000.00, 376, '6eda4d9a624f073a994be8f099d767e2.jpg'),
(28, 'The Tower', 'William Morrow', '2015', 'Thriller, Suspense', 'Simon Toyne', 85000.00, 269, 'd321150877e62ad2e09f3e29bf0d700d.jpg'),
(29, 'Breaking Dawn', 'Little, Brown and Company', '2008', 'Fiksi fantasi romantis', 'Stephenie Meyer', 85000.00, 308, '53284bbd8df076c77098786936f0511e.jpg'),
(30, 'The Hunger Games: Catching Fire', 'Scholastic Press', '2009', 'Fiksi dewasa muda, fiksi ilmiah, thriller', 'Suzanne Collins', 75000.00, 71, 'e0c16106a1206dabfd7dbbb8386db658.jpg'),
(31, 'Black Sunday', 'Doubleday', '1975', 'Mystery, thriller, suspense', 'Thomas Harris', 45000.00, 411, '351deeb7b6bb9d948bf8cd0013eecf22.jpg'),
(32, 'Angela\'s Ashes', 'Harvill Press (UK)', '1996', 'Fiksi memoar, otobiografi', 'Frank McCourt', 75000.00, 50, '1b3990e56fc65e6a1e6927d3c69a5f3e.jpg'),
(33, 'When Friday Isn\'t Payday', 'Warner Books', '1989', 'Bisnis, Kewirausahaan, Manajemen', 'Randy W. Kirk', 45000.00, 212, 'cfb27028919561aa99078647df5cb409.jpg'),
(34, 'Finishing Touches', 'Troll Communications Llc', '1991', 'Etiquette', 'Rabbi Jo David, Donald Richey', 60000.00, 250, '7c30aacd1052fbfa19fea61d8c2303b6.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`),
  ADD KEY `idbarang` (`idbuku`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`),
  ADD KEY `idbarang` (`idbuku`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`idpeminjaman`),
  ADD KEY `fk_peminjaman_stock` (`idbuku`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`idregister`),
  ADD UNIQUE KEY `username` (`first_name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbuku`),
  ADD UNIQUE KEY `idbuku` (`idbuku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` bigint(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idpeminjaman` bigint(40) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `idregister` bigint(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbuku` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keluar`
--
ALTER TABLE `keluar`
  ADD CONSTRAINT `fk_keluar_stock_idbuku` FOREIGN KEY (`idbuku`) REFERENCES `stock` (`idbuku`);

--
-- Constraints for table `masuk`
--
ALTER TABLE `masuk`
  ADD CONSTRAINT `fk_masuk_stock_idbuku` FOREIGN KEY (`idbuku`) REFERENCES `stock` (`idbuku`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_peminjaman_stock` FOREIGN KEY (`idbuku`) REFERENCES `stock` (`idbuku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
