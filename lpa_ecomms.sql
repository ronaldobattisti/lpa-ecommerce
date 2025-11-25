-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 01:12 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lpa_ecomms`
--

-- --------------------------------------------------------

--
-- Table structure for table `lpa_cart`
--

CREATE TABLE `lpa_cart` (
  `lpa_cart_user_id` int(20) NOT NULL,
  `lpa_cart_item_id` int(20) NOT NULL,
  `lpa_cart_item_qty` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lpa_cart`
--

INSERT INTO `lpa_cart` (`lpa_cart_user_id`, `lpa_cart_item_id`, `lpa_cart_item_qty`) VALUES
(17, 1, 7),
(16, 13, 1),
(16, 7, 1),
(16, 10, 1),
(17, 5, 1),
(17, 6, 2),
(16, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lpa_clients`
--

CREATE TABLE `lpa_clients` (
  `lpa_client_id` int(20) NOT NULL,
  `lpa_client_firstname` varchar(50) NOT NULL,
  `lpa_client_lastname` varchar(50) NOT NULL,
  `lpa_client_email` varchar(100) NOT NULL,
  `lpa_client_password` varchar(255) NOT NULL,
  `lpa_client_address` varchar(250) NOT NULL,
  `lpa_client_phone` varchar(30) NOT NULL,
  `lpa_client_payment_type` varchar(50) DEFAULT NULL,
  `lpa_client_card_last4` varchar(4) DEFAULT NULL,
  `lpa_client_registered` datetime NOT NULL DEFAULT current_timestamp(),
  `lpa_client_status` char(1) NOT NULL DEFAULT 'a',
  `lpa_client_group` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lpa_clients`
--

INSERT INTO `lpa_clients` (`lpa_client_id`, `lpa_client_firstname`, `lpa_client_lastname`, `lpa_client_email`, `lpa_client_password`, `lpa_client_address`, `lpa_client_phone`, `lpa_client_payment_type`, `lpa_client_card_last4`, `lpa_client_registered`, `lpa_client_status`, `lpa_client_group`) VALUES
(16, 'Ronaldo', 'Battisti', 'ronaldo.battisti@hotmail.com', '$2y$10$rHz7vxPRkmoz7Zg1ACnLue79kiMrIccudd610Lal/LFpR.uJDHEcu', 'Unity 6/237 Cavendish Rd, Coorparoo', '0413783515', NULL, NULL, '2025-10-18 09:56:06', 'a', 1),
(17, 'Cássio', 'Battisti', 'cassio_battisti@yahoo.com', '$2y$10$g1RGPATLwWrJb6vAWD7tL.qJqjVrD2kRJKJ.z.zmXbTy2clkO2Nta', 'Caxias do Sul, 25', '61752648953', NULL, NULL, '2025-10-25 09:25:22', 'a', 0),
(18, 'Luiz', 'Inácio', 'luiz.inacio@gmail.com', '$2a$10$VsrCU02D5f7BW/YfjO7wNu2fHGCf6UW5Drq4439/XFmARwaLiSUXy', 'Planalto Central', '123456789', NULL, NULL, '2025-11-17 17:25:38', 'a', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lpa_invoices`
--

CREATE TABLE `lpa_invoices` (
  `lpa_inv_no` int(20) NOT NULL,
  `lpa_inv_date` datetime NOT NULL DEFAULT current_timestamp(),
  `lpa_inv_client_id` int(20) NOT NULL,
  `lpa_inv_amount` decimal(8,2) NOT NULL,
  `lpa_inv_payment_type` varchar(50) NOT NULL,
  `lpa_inv_status` char(1) NOT NULL DEFAULT 'E'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lpa_invoices`
--

INSERT INTO `lpa_invoices` (`lpa_inv_no`, `lpa_inv_date`, `lpa_inv_client_id`, `lpa_inv_amount`, `lpa_inv_payment_type`, `lpa_inv_status`) VALUES
(4, '2025-10-22 11:35:49', 16, 27.00, 'paid', 's'),
(10, '2025-10-22 11:49:47', 16, 4412.00, 'pending', 'u'),
(11, '2025-10-22 11:54:09', 16, 64.00, 'pending', 'u'),
(12, '2025-10-22 11:57:16', 16, 46.00, 'pending', 'u'),
(13, '2025-10-25 09:26:30', 17, 26.00, 'pending', 'u'),
(14, '2025-10-27 15:49:44', 16, 19.00, 'Pending', 'U'),
(15, '2025-10-29 14:47:57', 16, 27.00, 'Pending', 'U'),
(16, '2025-10-29 14:49:09', 17, 72.00, 'Pending', 'U'),
(17, '2025-10-30 13:47:20', 16, 19.00, 'Pending', 'U'),
(18, '2025-10-30 13:47:42', 16, 1055.00, 'Pending', 'U'),
(19, '2025-11-04 11:21:51', 16, 19.00, 'Pending', 'U');

-- --------------------------------------------------------

--
-- Table structure for table `lpa_invoice_items`
--

CREATE TABLE `lpa_invoice_items` (
  `lpa_invitem_inv_no` int(20) NOT NULL,
  `lpa_invitem_stock_id` int(20) NOT NULL,
  `lpa_invitem_stock_name` varchar(250) NOT NULL,
  `lpa_invitem_qty` int(11) NOT NULL,
  `lpa_invitem_price` decimal(8,2) NOT NULL,
  `lpa_invitem_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lpa_invoice_items`
--

INSERT INTO `lpa_invoice_items` (`lpa_invitem_inv_no`, `lpa_invitem_stock_id`, `lpa_invitem_stock_name`, `lpa_invitem_qty`, `lpa_invitem_price`, `lpa_invitem_amount`) VALUES
(4, 4, 'Mechanical Keyboard Riso', 1, 27.00, 27.00),
(10, 7, 'Monitor LG', 2, 106.00, 212.00),
(10, 6, 'Desktop Dell all-in-one', 1, 1000.00, 1000.00),
(10, 5, 'Laptop Microsoft Surface', 1, 3200.00, 3200.00),
(11, 1, 'Mouse Logitech Lifte', 1, 19.00, 19.00),
(11, 2, 'RAM Samsumg 16GB', 1, 45.00, 45.00),
(12, 1, 'Mouse Logitech Lifte', 1, 19.00, 19.00),
(12, 4, 'Mechanical Keyboard Riso', 1, 27.00, 27.00),
(13, 11, 'Webcam Asus', 1, 26.00, 26.00),
(14, 1, 'Mouse Logitech Lifter', 1, 19.00, 19.00),
(15, 14, 'HDMI Cable Var', 1, 8.00, 8.00),
(15, 1, 'Mouse Logitech Lift', 1, 19.00, 19.00),
(16, 2, 'RAM Samsumg 16GB', 1, 45.00, 45.00),
(16, 4, 'Mechanical Keyboard Risoto', 1, 27.00, 27.00),
(17, 1, 'Mouse Logitech Lift', 1, 19.00, 19.00),
(18, 13, 'Headset hanger', 5, 11.00, 55.00),
(18, 6, 'Desktop Dell all-in-one', 1, 1000.00, 1000.00),
(19, 1, 'Mouse Logitech Lift', 1, 19.00, 19.00);

-- --------------------------------------------------------

--
-- Table structure for table `lpa_logs`
--

CREATE TABLE `lpa_logs` (
  `log_id` int(11) NOT NULL,
  `log_message` text NOT NULL,
  `log_time` datetime NOT NULL DEFAULT current_timestamp(),
  `log_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lpa_stock`
--

CREATE TABLE `lpa_stock` (
  `lpa_stock_id` int(20) NOT NULL,
  `lpa_stock_name` varchar(250) NOT NULL,
  `lpa_stock_desc` text DEFAULT NULL,
  `lpa_stock_onhand` varchar(5) NOT NULL,
  `lpa_stock_price` decimal(7,2) NOT NULL,
  `lpa_stock_cat` varchar(50) DEFAULT NULL,
  `lpa_stock_image` varchar(255) DEFAULT NULL,
  `lpa_stock_status` char(1) NOT NULL DEFAULT 'a'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lpa_stock`
--

INSERT INTO `lpa_stock` (`lpa_stock_id`, `lpa_stock_name`, `lpa_stock_desc`, `lpa_stock_onhand`, `lpa_stock_price`, `lpa_stock_cat`, `lpa_stock_image`, `lpa_stock_status`) VALUES
(1, 'Mouse Logitech Lift', 'Ergonomic mouse for work', '10', 19.00, 'peripheral', 'assets/images/MouseLogitechLiftVerticalErgonomicBlack.png', 'a'),
(2, 'RAM Samsumg 16GB', 'RAM memory Samsung for pc 16GB DDR4', '10', 45.00, 'component', 'assets/images/RAMSamsumg16GbDDR4.png', 'a'),
(4, 'Mechanical Keyboard Risoto', 'Mechanical Keyboard RisoPhy', '10', 27.00, 'peripheral', 'assets/images/RisoPhyMechanicalKeyboard.png', 'a'),
(5, 'Laptop Microsoft Surface', 'Laptop Microsoft Surface 13,8\"', '10', 3200.00, 'laptop', 'assets/images/LaptopMicrosoftSurface13.png', 'a'),
(6, 'Desktop Dell all-in-one', 'Desktop Dell all-in-one 24', '10', 1000.00, 'desktop', 'assets/images/DellProAllInOne24.png', 'a'),
(7, 'Monitor LG', 'Monitor LG Full Hd 21\"', '10', 106.00, 'display', 'assets/images/Monitor21FullHdLG.png', 'a'),
(8, 'Printer Brother', 'Printer Broder Ink Jet Fast', '10', 172.00, 'printer', 'assets/images/PrinterBrotherScannetInk.png', 'a'),
(9, 'Router TP-Link', 'Router TL-MR6400 TP-Link', '10', 60.00, 'network', 'assets/images/RouterTPLink.png', 'a'),
(10, 'Soudbar Samsung', 'Soundbar Samsung 150W', '10', 30.00, 'peripheral', 'assets/images/SoundbarSamsung.png', 'a'),
(11, 'Webcam Asus', 'Webcam Asus C3', '10', 26.00, 'peripheral', 'assets/images/WebCamAsusC3.png', 'a'),
(13, 'Headset hanger', 'Headset wall hanger', '50', 11.00, 'component', 'assets/images/headsetHanger.png', 'a'),
(14, 'HDMI Cable Var', 'HDMI cable 2 meters Var 4K', '30', 8.00, 'display', 'assets/images/hdmiCable.png', 'a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lpa_cart`
--
ALTER TABLE `lpa_cart`
  ADD KEY `lpa_cart_item_id` (`lpa_cart_item_id`),
  ADD KEY `lpa_cart_user_id` (`lpa_cart_user_id`);

--
-- Indexes for table `lpa_clients`
--
ALTER TABLE `lpa_clients`
  ADD PRIMARY KEY (`lpa_client_id`);

--
-- Indexes for table `lpa_invoices`
--
ALTER TABLE `lpa_invoices`
  ADD PRIMARY KEY (`lpa_inv_no`),
  ADD KEY `lpa_invoices_ibfk_1` (`lpa_inv_client_id`);

--
-- Indexes for table `lpa_invoice_items`
--
ALTER TABLE `lpa_invoice_items`
  ADD KEY `lpa_invitem_stock_id` (`lpa_invitem_stock_id`),
  ADD KEY `index` (`lpa_invitem_inv_no`) USING BTREE;

--
-- Indexes for table `lpa_logs`
--
ALTER TABLE `lpa_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `lpa_stock`
--
ALTER TABLE `lpa_stock`
  ADD PRIMARY KEY (`lpa_stock_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lpa_clients`
--
ALTER TABLE `lpa_clients`
  MODIFY `lpa_client_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `lpa_invoices`
--
ALTER TABLE `lpa_invoices`
  MODIFY `lpa_inv_no` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `lpa_logs`
--
ALTER TABLE `lpa_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lpa_stock`
--
ALTER TABLE `lpa_stock`
  MODIFY `lpa_stock_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lpa_cart`
--
ALTER TABLE `lpa_cart`
  ADD CONSTRAINT `lpa_cart_ibfk_1` FOREIGN KEY (`lpa_cart_item_id`) REFERENCES `lpa_stock` (`lpa_stock_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lpa_cart_ibfk_2` FOREIGN KEY (`lpa_cart_user_id`) REFERENCES `lpa_clients` (`lpa_client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lpa_invoices`
--
ALTER TABLE `lpa_invoices`
  ADD CONSTRAINT `lpa_invoices_ibfk_1` FOREIGN KEY (`lpa_inv_client_id`) REFERENCES `lpa_clients` (`lpa_client_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lpa_invoice_items`
--
ALTER TABLE `lpa_invoice_items`
  ADD CONSTRAINT `lpa_invoice_items_ibfk_1` FOREIGN KEY (`lpa_invitem_inv_no`) REFERENCES `lpa_invoices` (`lpa_inv_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lpa_invoice_items_ibfk_2` FOREIGN KEY (`lpa_invitem_stock_id`) REFERENCES `lpa_stock` (`lpa_stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
