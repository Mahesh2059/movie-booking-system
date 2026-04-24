-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2026 at 04:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_ticket_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `seat_list` text DEFAULT NULL,
  `ticket_count` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_ref` varchar(50) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT 'Pending',
  `receipt_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_id`, `show_id`, `username`, `email`, `phone`, `seat_list`, `ticket_count`, `total_price`, `booking_date`, `booking_ref`, `payment_status`, `receipt_file`) VALUES
(14, 3, 1, 'sushil', 'maheshdevekota@gmail.com', '9887777778788778', 'A1,A2,A3', 3, 600.00, '2025-07-21', NULL, 'Pending', NULL),
(37, 10, 15, 'Prem', 'prem@gmail.com', '989898', 'A1,A2', 2, 400.00, '2025-07-26', 'BOOK17535112927671', 'Submitted', 'BOOK17535112927671.jpg'),
(38, 3, 1, 'sushil', 'sushil@gmail.com', '9887777778788778', 'A5,A6', 2, 400.00, '2025-07-27', 'BOOK17535922316650', 'Submitted', 'BOOK17535922316650.jpg'),
(39, 11, 1, 'haddi', 'haddi@gmail.com', '9866219972', 'I1,I2,I3,I4,I5,I6,I7,I8', 8, 1600.00, '2025-07-27', 'BOOK17536014947012', 'Submitted', 'BOOK17536014947012.jpg'),
(40, 3, 15, 'sushil', 'sushil@gmail.com', '9887777778788778', 'C7,C8,C9', 3, 600.00, '2025-08-30', 'BOOK17565244462878', 'Pending', NULL),
(41, 12, 1, 'neymar', 'neymar@gmail.com', '986621997222', 'A7,A8', 2, 400.00, '2025-09-17', 'BOOK17581040331037', 'Submitted', 'BOOK17581040331037.jpg'),
(42, 13, 1, 'ram', 'maheshdevekota@gmail.com', '9887777778788778', 'B8,B9', 2, 400.00, '2026-03-25', 'BOOK17744197602278', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cinema`
--

CREATE TABLE `cinema` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cinema`
--

INSERT INTO `cinema` (`id`, `name`, `location`, `city`) VALUES
(1, 'karnali cinema', 'birendanagar-6', 'Surkhet'),
(2, 'koshi cinema', 'damak_4', 'Damak'),
(3, 'bagmati cinema ', 'kalanki-8', 'kathmandu'),
(4, 'qfa', 'birtamod', 'morang'),
(5, 'dmax', 'damak', 'jhapa'),
(7, 'dmax', 'damak', 'jhapa');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `num` varchar(50) NOT NULL,
  `msg` varchar(100) NOT NULL,
  `msg_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `num`, `msg`, `msg_date`) VALUES
(4, 'mahesh', 'maheshdevekota@gmail.com', '777', 'helllo boss', '2025-06-30'),
(5, 'mahesh', 'sthasushil9814@gmail.com', '86996', 'hellloooooooooooooo', '2025-06-30'),
(6, 'mahesh', 'maheshdevekota@gmail.com', '999', 'jjj', '2025-06-30'),
(7, 'mahesh', 'maheshdevekota@gmail.com', '999', 'jjj', '2025-06-30'),
(8, 'prem ', 'sthasushil9814@gmail.com', '990880', 'mero naam prem ho', '2025-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cellno` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `genre_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `genre_name`) VALUES
(1, 'action'),
(2, 'comedy'),
(3, 'Romance'),
(5, 'sad');

-- --------------------------------------------------------

--
-- Table structure for table `industry`
--

CREATE TABLE `industry` (
  `id` int(11) NOT NULL,
  `industry_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `industry`
--

INSERT INTO `industry` (`id`, `industry_name`) VALUES
(1, 'bollywood'),
(2, 'hollywood'),
(3, 'nepali'),
(4, 'bollywood');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `lang_name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `lang_name`) VALUES
(1, 'hindi'),
(2, 'english'),
(4, 'nepali'),
(6, 'nepali');

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `movie_banner` varchar(100) NOT NULL,
  `rel_date` date NOT NULL,
  `industry_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `duration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `name`, `movie_banner`, `rel_date`, `industry_id`, `genre_id`, `lang_id`, `duration`) VALUES
(7, 'sitaram', 'images\\img1.jpg', '2025-07-23', 1, 1, 1, ''),
(9, '3idiots', 'images\\3idiots.jpg', '2025-07-09', 1, 2, 1, ''),
(11, 'aama', 'uploads/movie_banners/687dbabcbe783_images.jpg', '2025-07-03', 3, 5, 4, '120'),
(12, 'Baaghi 3', 'uploads/movie_banners/687dba97d64a4_download.jpg', '2025-07-31', 1, 1, 1, '120'),
(15, 'saiyaara', 'uploads/movie_banners/68847553dc939_download (1).jpg', '2025-07-26', 1, 3, 1, '120'),
(16, 'coolie', 'uploads/movie_banners/68ca8bfb073e2_hq720.jpg', '2025-09-19', 1, 1, 1, '150');

-- --------------------------------------------------------

--
-- Table structure for table `seat_detail`
--

CREATE TABLE `seat_detail` (
  `id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `seat_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `show`
--

CREATE TABLE `show` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `show_date` date NOT NULL,
  `show_time_id` int(11) NOT NULL,
  `no_seat` int(11) NOT NULL,
  `cinema_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shows_time`
--

CREATE TABLE `shows_time` (
  `id` int(11) NOT NULL,
  `show_time` char(100) NOT NULL,
  `show_date` date DEFAULT NULL,
  `screen` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shows_time`
--

INSERT INTO `shows_time` (`id`, `show_time`, `show_date`, `screen`) VALUES
(1, '4:00 PM-6:00 PM', '2025-07-31', 'audi 1'),
(14, '12:00PM - 2:00PM', '2025-07-23', 'audi 3'),
(15, '7:00PM - 9:00PM', '2025-07-26', 'audi 3');

-- --------------------------------------------------------

--
-- Table structure for table `show_time`
--

CREATE TABLE `show_time` (
  `id` int(11) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `show_time`
--

INSERT INTO `show_time` (`id`, `time`) VALUES
(1, '1:00 PM-3:00 PM'),
(2, '3:30PM-5:30 PM'),
(5, '6:00 PM-8:00 PM'),
(6, '11:00PM-1:00AM');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `img_path` varchar(100) NOT NULL,
  `alt` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `img_path`, `alt`) VALUES
(1, 'uploads/sliders/e25941981869108a3c75dde7809e0a50.jpg', 'First slide'),
(2, 'images/banner2.jpg', 'Second slide'),
(3, 'images/banner3.jpg', 'Third slide'),
(4, 'uploads/sliders/69d69e9a83cf1.jpg', 'Dhurandhar');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `number` varchar(20) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `number`, `is_verified`) VALUES
(3, 'sushil', 'sushil@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '09828282', 1),
(4, 'admin', 'admin@gmail.com', '6590f73ecdf351c38de00befd2ecf17b', '7654', 1),
(5, 'admin', 'use@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', '34567', 1),
(9, 'admin', 'mmaah@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '9898', 1),
(10, 'Prem ', 'prem@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '989898', 1),
(11, 'haddi', 'haddi@gmail.com', '1c40bc48c8d2cee6eb4f8e7fb0e9d76b', '98989898', 1),
(12, 'neymar ', 'neymar@gmail.com', '70080aa08b4fe2b66aae3baea7e4a99f', '98662192222', 1),
(13, 'ram', 'ram@gmail.com', '698d51a19d8a121ce581499d7b701668', '7654', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `bookings_ibfk_1` (`show_id`);

--
-- Indexes for table `cinema`
--
ALTER TABLE `cinema`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cellno` (`cellno`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `industry`
--
ALTER TABLE `industry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `industry_id` (`industry_id`),
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `lang_id` (`lang_id`);

--
-- Indexes for table `seat_detail`
--
ALTER TABLE `seat_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `show_id` (`show_id`);

--
-- Indexes for table `show`
--
ALTER TABLE `show`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `cinema_id` (`cinema_id`),
  ADD KEY `show_time_id` (`show_time_id`);

--
-- Indexes for table `shows_time`
--
ALTER TABLE `shows_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `show_time`
--
ALTER TABLE `show_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `cinema`
--
ALTER TABLE `cinema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `industry`
--
ALTER TABLE `industry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `seat_detail`
--
ALTER TABLE `seat_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `show`
--
ALTER TABLE `show`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shows_time`
--
ALTER TABLE `shows_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `show_time`
--
ALTER TABLE `show_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`show_id`) REFERENCES `shows_time` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`industry_id`) REFERENCES `industry` (`id`),
  ADD CONSTRAINT `movie_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `movie_ibfk_3` FOREIGN KEY (`lang_id`) REFERENCES `language` (`id`);

--
-- Constraints for table `seat_detail`
--
ALTER TABLE `seat_detail`
  ADD CONSTRAINT `seat_detail_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `seat_detail_ibfk_2` FOREIGN KEY (`show_id`) REFERENCES `show` (`id`);

--
-- Constraints for table `show`
--
ALTER TABLE `show`
  ADD CONSTRAINT `show_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`),
  ADD CONSTRAINT `show_ibfk_3` FOREIGN KEY (`cinema_id`) REFERENCES `cinema` (`id`),
  ADD CONSTRAINT `show_ibfk_4` FOREIGN KEY (`show_time_id`) REFERENCES `show_time` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
