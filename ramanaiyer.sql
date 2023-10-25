-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2023 at 06:37 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ramanaiyer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `creationDate`, `updationDate`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '2017-01-24 16:21:18', '12-09-2023 12:31:43 PM');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `pId` int(11) DEFAULT NULL,
  `pQty` int(3) DEFAULT NULL,
  `pPrice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(255) DEFAULT NULL,
  `categoryDescription` longtext DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `categoryName`, `categoryDescription`, `creationDate`, `updationDate`) VALUES
(3, 'Books', 'Test anuj', '2017-01-24 19:17:37', '30-01-2017 12:22:24 AM'),
(4, 'Electronics', 'Electronic Products', '2017-01-24 19:19:32', ''),
(5, 'Furniture', 'test', '2017-01-24 19:19:54', ''),
(6, 'Fashion', 'Fashion', '2017-02-20 19:18:52', '13-09-2023 06:18:47 PM');

-- --------------------------------------------------------

--
-- Table structure for table `combo`
--

CREATE TABLE `combo` (
  `id` int(11) NOT NULL,
  `comboName` varchar(255) DEFAULT NULL,
  `comboPrice` int(11) DEFAULT NULL,
  `comboPriceBeforeDiscount` int(11) DEFAULT NULL,
  `comboDescription` longtext DEFAULT NULL,
  `comboImage1` varchar(255) DEFAULT NULL,
  `comboImage2` varchar(255) DEFAULT NULL,
  `comboImage3` varchar(255) DEFAULT NULL,
  `shippingCharge` int(11) DEFAULT NULL,
  `comboAvailability` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL,
  `comboRating` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `combo`
--

INSERT INTO `combo` (`id`, `comboName`, `comboPrice`, `comboPriceBeforeDiscount`, `comboDescription`, `comboImage1`, `comboImage2`, `comboImage3`, `shippingCharge`, `comboAvailability`, `postingDate`, `updationDate`, `comboRating`) VALUES
(1, 'hfj', 926, 314, '                                                                fhgj                                                                ', 'test.jpg', '', '', 12, 'In Stock', '2023-10-20 11:20:13', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `combo_product`
--

CREATE TABLE `combo_product` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `productQuantity` int(11) DEFAULT NULL,
  `comboId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `combo_product`
--

INSERT INTO `combo_product` (`id`, `productId`, `productQuantity`, `comboId`) VALUES
(9, 1, 5, 1),
(10, 4, 2, 1),
(11, 2, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `paymentMethod` varchar(50) DEFAULT NULL,
  `orderStatus` varchar(55) DEFAULT NULL,
  `receiptNo` varchar(50) DEFAULT NULL,
  `paymentId` varchar(50) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `dtSupply` datetime DEFAULT NULL,
  `remarks` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userId`, `productId`, `quantity`, `orderDate`, `paymentMethod`, `orderStatus`, `receiptNo`, `paymentId`, `price`, `dtSupply`, `remarks`) VALUES
(1, 7, '15', 1, '2023-09-26 12:16:23', 'COD', 'Delivered', NULL, 'COD', NULL, NULL, NULL),
(2, 7, '15', 1, '2023-09-26 12:16:48', 'Internet Banking', 'Shipped', '7_20230926174648', 'pay_Mgxdg1PVecpEbI', NULL, NULL, NULL),
(3, 7, '16', 1, '2023-09-26 12:16:48', 'Internet Banking', NULL, '7_20230926174648', 'pay_Mgxdg1PVecpEbI', NULL, NULL, NULL),
(4, 7, '9', 1, '2023-09-26 12:18:55', 'Internet Banking', NULL, '7_20230926174855', 'pay_MgxfzdGJKjmids', NULL, NULL, NULL),
(5, 7, '16', 1, '2023-09-26 12:21:57', 'Internet Banking', 'In Process', '7_20230926175157', 'pay_Mgxj4vj8EySLC0', NULL, NULL, NULL),
(6, 7, '15', 1, '2023-09-26 12:22:51', 'Debit / Credit card', NULL, '7_20230926175251', 'pay_MgxkZJoxFfRNvY', NULL, NULL, NULL),
(7, 6, '19', 1, '2023-09-26 12:25:12', 'Internet Banking', NULL, '6_20230926175512', 'pay_MgxmegKdZ0jVsp', NULL, NULL, NULL),
(10, 6, '20', 1, '2023-09-26 12:41:12', 'Debit / Credit card', NULL, '6_20230926181112', 'pay_Mgy3tQprOKC5JC', NULL, NULL, NULL),
(13, 6, '9', 1, '2023-09-26 12:45:07', 'Debit / Credit card', NULL, '6_20230926181507', 'pay_Mgy7b1wWAF5pDH', NULL, NULL, NULL),
(14, 6, '15', 2, '2023-09-27 06:33:50', 'Internet Banking', NULL, '6_20230927120350', 'pay_MhGKYTJgFmMKGR', NULL, NULL, NULL),
(15, 6, '16', 1, '2023-09-27 06:33:50', 'Internet Banking', NULL, '6_20230927120350', 'pay_MhGKYTJgFmMKGR', NULL, NULL, NULL),
(19, 6, '9', 1, '2023-09-27 07:01:20', 'Debit / Credit card', NULL, '6_20230927123120', 'pay_MhGnWhhrxd5eBW', NULL, NULL, NULL),
(20, 6, '15', 2, '2023-09-27 07:01:20', 'Debit / Credit card', NULL, '6_20230927123120', 'pay_MhGnWhhrxd5eBW', NULL, NULL, NULL),
(21, 6, '16', 1, '2023-09-27 07:01:20', 'Debit / Credit card', NULL, '6_20230927123120', 'pay_MhGnWhhrxd5eBW', NULL, NULL, NULL),
(22, 6, '15', 1, '2023-09-27 07:06:13', 'Internet Banking', NULL, '6_20230927123613', 'pay_MhGzAsjklQjv9z', NULL, NULL, NULL),
(25, 6, '15', 1, '2023-09-27 11:54:55', 'Debit / Credit card', NULL, '6_20230927172455', 'pay_MhLnpg5eXe9DCr', NULL, NULL, NULL),
(26, 7, '15', 1, '2023-09-28 06:48:48', 'COD', 'In Process', NULL, 'COD', NULL, NULL, NULL),
(27, 7, '16', 1, '2023-09-28 06:49:38', 'Internet Banking', NULL, '7_20230928121938', 'pay_Mhf8HgDn5iGSYl', NULL, NULL, NULL),
(28, 7, '15', 1, '2023-09-29 06:20:20', 'Internet Banking', NULL, '7_20230929115020', 'pay_Mi3AWKZOAPn2Go', NULL, NULL, NULL),
(32, 7, '16', 2, '2023-09-29 07:28:29', 'Debit / Credit card', NULL, '7_20230929125829', 'pay_Mi4KQaj5CCukHa', NULL, NULL, NULL),
(33, 7, '15', 1, '2023-09-29 07:34:08', 'Internet Banking', NULL, '7_20230929130408', 'pay_Mi4QqdUA0WrCyX', NULL, NULL, NULL),
(38, 7, '16', 1, '2023-09-29 08:43:33', 'Internet Banking', NULL, '7_20230929141333', 'pay_Mi5cN6mU44kjTu', NULL, NULL, NULL),
(39, 7, '9', 1, '2023-09-29 08:45:35', 'Debit / Credit card', NULL, '7_20230929141535', 'pay_Mi5elYB3TwsIY1', NULL, NULL, NULL),
(44, 6, '15', 1, '2023-10-05 04:10:59', 'Internet Banking', NULL, '6_20231005094059', 'pay_MkOBrqSFvtTqji', NULL, NULL, NULL),
(47, 6, '16', 1, '2023-10-05 05:35:03', 'PREPAID', NULL, '6_20231005110503', 'pay_MkPbLrilZGyLPf', NULL, NULL, NULL),
(51, 7, '9', 1, '2023-10-05 11:14:25', 'PREPAID', NULL, '7_20231005164425', 'pay_MkVPbXFZzOgREI', NULL, NULL, NULL),
(52, 7, '19', 1, '2023-10-05 11:24:36', 'PREPAID', NULL, '7_20231005165436', 'pay_MkVYdnT1qvf1lZ', NULL, '2023-10-31 17:12:00', NULL),
(54, 7, '15', 1, '2023-10-05 11:30:06', 'PREPAID', NULL, '7_20231005170006', 'pay_MkVex1iLJscbyx', NULL, '2023-10-31 17:12:00', NULL),
(55, 7, '16', 1, '2023-10-05 11:36:48', 'PREPAID', NULL, '7_20231005170648', 'pay_MkVlwQ8zVUeeTt', NULL, NULL, NULL),
(56, 7, '15', 1, '2023-10-06 04:31:58', 'COD', NULL, NULL, 'COD', NULL, '2023-10-24 17:12:00', NULL),
(57, 7, '9', 2, '2023-10-06 04:32:23', 'PREPAID', NULL, '7_20231006100223', 'pay_Mkn57mEndTxOwF', NULL, NULL, NULL),
(58, 7, '16', 1, '2023-10-06 04:32:23', 'PREPAID', NULL, '7_20231006100223', 'pay_Mkn57mEndTxOwF', NULL, NULL, NULL),
(63, 7, '15', 1, '2023-10-11 03:45:18', 'PREPAID', NULL, '7_20231011091518', NULL, NULL, NULL, NULL),
(71, 1, '15', 1, '2023-10-24 11:36:04', 'ADMIN', NULL, NULL, NULL, '205', '2023-10-24 17:05:00', 'test'),
(72, 1, '16', 2, '2023-10-24 11:36:04', 'ADMIN', NULL, NULL, NULL, '480', '2023-10-25 17:05:00', 'test'),
(73, 1, '19', 1, '2023-10-24 11:43:01', 'ADMIN', NULL, NULL, NULL, '379', '2023-10-31 17:12:00', ''),
(74, 10, '20', 1, '2023-10-24 12:23:10', 'ADMIN', NULL, NULL, NULL, '4129', '2023-10-24 17:52:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ordertrackhistory`
--

CREATE TABLE `ordertrackhistory` (
  `id` int(11) NOT NULL,
  `orderId` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remark` mediumtext DEFAULT NULL,
  `postingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordertrackhistory`
--

INSERT INTO `ordertrackhistory` (`id`, `orderId`, `status`, `remark`, `postingDate`) VALUES
(1, 1, 'Delivered', 'Test', '2023-09-12 07:27:36'),
(2, 8, 'Delivered', 'test', '2023-09-13 07:43:35'),
(3, 28, 'Delivered', 'test', '2023-09-22 11:13:15'),
(4, 1, 'Delivered', 'test', '2023-09-27 04:30:47'),
(5, 2, 'In Process', 'test', '2023-09-28 05:24:19'),
(6, 5, 'In Process', 'test', '2023-09-28 07:28:28'),
(7, 26, 'In Process', 'test', '2023-09-28 09:49:11'),
(8, 2, 'Shipped', 'test', '2023-09-28 09:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `receipt_no` varchar(50) DEFAULT NULL,
  `total_amt` int(11) DEFAULT NULL,
  `pg_buyer` varchar(100) DEFAULT NULL,
  `pg_buyer_name` varchar(100) DEFAULT NULL,
  `pg_buyer_phone` varchar(100) DEFAULT NULL,
  `pg_currency` varchar(100) DEFAULT NULL,
  `pg_fees` varchar(100) DEFAULT NULL,
  `pg_longurl` mediumtext DEFAULT NULL,
  `pg_mac` varchar(100) DEFAULT NULL,
  `pg_payment_id` varchar(100) DEFAULT NULL,
  `pg_request_id` varchar(100) DEFAULT NULL,
  `pg_purpose` varchar(100) DEFAULT NULL,
  `pg_shorturl` varchar(100) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `productreviews`
--

CREATE TABLE `productreviews` (
  `id` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `quality` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `review` longtext DEFAULT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productreviews`
--

INSERT INTO `productreviews` (`id`, `productId`, `quality`, `price`, `value`, `name`, `summary`, `review`, `reviewDate`) VALUES
(2, 3, 4, 5, 5, 'Anuj Kumar', 'BEST PRODUCT FOR ME :)', 'BEST PRODUCT FOR ME :)', '2017-02-26 20:43:57'),
(3, 3, 3, 4, 3, 'Sarita pandey', 'Nice Product', 'Value for money', '2017-02-26 20:52:46'),
(4, 3, 3, 4, 3, 'Sarita pandey', 'Nice Product', 'Value for money', '2017-02-26 20:59:19'),
(5, 15, 3, 3, 3, 'Yazar', 'hgkl', 'dsgbd', '2023-09-06 11:35:32'),
(6, 15, 2, 3, 4, 'Vallatharau', 'safgsag', 'sdfgsdfg', '2023-09-06 11:36:06'),
(18, 16, 3, 3, 3, 'Yazar', 'safgsag', 'sfgfsg', '2023-09-07 08:38:50'),
(19, 12, 1, 1, 1, 'Yazar', 'hgkl', 'sgfsg', '2023-09-07 08:41:09'),
(20, 11, 4, 4, 4, 'Yazar', 'hgkl', 'fdjhf', '2023-09-08 05:17:50'),
(21, 15, 3, 4, 2, 'Indhuja Pandrutti', 'test', 'test', '2023-09-27 10:45:10'),
(22, 15, 3, 4, 2, 'Indhuja Pandrutti', 'test', 'test', '2023-09-27 10:48:52'),
(23, 15, 5, 3, 1, 'test', 'test', 'test', '2023-09-27 10:53:07');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `subCategory` int(11) DEFAULT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productCompany` varchar(255) DEFAULT NULL,
  `productPrice` int(11) DEFAULT NULL,
  `productPriceBeforeDiscount` int(11) DEFAULT NULL,
  `productDescription` longtext DEFAULT NULL,
  `productImage1` varchar(255) DEFAULT NULL,
  `productImage2` varchar(255) DEFAULT NULL,
  `productImage3` varchar(255) DEFAULT NULL,
  `shippingCharge` int(11) DEFAULT NULL,
  `productAvailability` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL,
  `productRating` int(1) DEFAULT 1,
  `prod_avail` varchar(25) DEFAULT NULL,
  `allow_ao` smallint(6) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category`, `subCategory`, `productName`, `productCompany`, `productPrice`, `productPriceBeforeDiscount`, `productDescription`, `productImage1`, `productImage2`, `productImage3`, `shippingCharge`, `productAvailability`, `postingDate`, `updationDate`, `productRating`, `prod_avail`, `allow_ao`) VALUES
(1, 4, 3, 'Micromax 81cm (32) HD Ready LED TV  (32T6175MHD, 2 x HDMI, 2 x USB)', 'Micromax test', 139900, 0, '				<div class=\"HoUsOy\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; font-size: 18px; white-space: nowrap; line-height: 1.4; color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif;\">General</div><ul style=\"box-sizing: border-box; margin-bottom: 0px; margin-left: 0px; color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 14px;\"><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Sales Package</div><ul class=\"_3dG3ix col col-9-12\" style=\"box-sizing: border-box; margin-left: 0px; width: 548.25px; display: inline-block; vertical-align: top; line-height: 1.4;\"><li class=\"sNqDog\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\">1 TV Unit, Remote Controller, Battery (For Remote Controller),</li><li class=\"sNqDog\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\">Quick Installation Guide and User Manual: All in One, Wall</li><li class=\"sNqDog\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\">Mount Support</li></ul></li><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Model Name</div><ul class=\"_3dG3ix col col-9-12\" style=\"box-sizing: border-box; margin-left: 0px; width: 548.25px; display: inline-block; vertical-align: top; line-height: 1.4;\"><li class=\"sNqDog\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\">32T6175MHD</li></ul></li><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Display Size</div><ul class=\"_3dG3ix col col-9-12\" style=\"box-sizing: border-box; margin-left: 0px; width: 548.25px; display: inline-block; vertical-align: top; line-height: 1.4;\"><li class=\"sNqDog\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\">81 cm (32)</li></ul></li><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">Screen Type</div><ul class=\"_3dG3ix col col-9-12\" style=\"box-sizing: border-box; margin-left: 0px; width: 548.25px; display: inline-block; vertical-align: top; line-height: 1.4;\"><li class=\"sNqDog\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\">LED</li></ul></li><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\">HD Technology &amp; Resolutiontest</div><ul class=\"_3dG3ix col col-9-12\" style=\"box-sizing: border-box; margin-left: 0px; width: 548.25px; display: inline-block; vertical-align: top; line-height: 1.4;\"><li class=\"sNqDog\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\">HD Ready, 1366 x 768</li></ul></li></ul>				', 'micromax1.jpeg', 'micromax main image.jpg', 'micromax main image.jpg', 1200, 'Out of Stock', '2017-01-30 16:54:35', '', 3, NULL, 0),
(2, 4, 4, 'Apple iPhone 6 (Silver, 16 GB)', 'Apple INC', 36990, 0, '		<div class=\"_2PF8IO\" style=\"box-sizing: border-box; margin: 0px 0px 0px 110px; padding: 0px; flex: 1 1 0%; color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 14px;\"><ul style=\"box-sizing: border-box; margin-bottom: 0px; margin-left: 0px;\"><li class=\"_1tMfkh\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">1 GB RAM | 16 GB ROM |</li><li class=\"_1tMfkh\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">4.7 inch Retina HD Display</li><li class=\"_1tMfkh\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">8MP Primary Camera | 1.2MP Front</li><li class=\"_1tMfkh\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Li-Ion Battery</li><li class=\"_1tMfkh\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">A8 Chip with 64-bit Architecture and M8 Motion Co-processor Processor</li></ul></div>		', 'apple-iphone-6-1.jpeg', 'apple-iphone-6-2.jpeg', 'apple-iphone-6-3.jpeg', 0, 'Against Order', '2017-01-30 16:59:00', '', 1, NULL, 0),
(3, 4, 4, 'Redmi Note 4 (Gold, 32 GB)  (With 3 GB RAM)', 'Redmi', 10999, 0, '<br><div><ol><li>3 GB RAM | 32 GB ROM | Expandable Upto 128 GB<br></li><li>5.5 inch Full HD Display<br></li><li>13MP Primary Camera | 5MP Front<br></li><li>4100 mAh Li-Polymer Battery<br></li><li>Qualcomm Snapdragon 625 64-bit Processor<br></li></ol></div>', 'mi-redmi-note-4-1.jpeg', 'mi-redmi-note-4-2.jpeg', 'mi-redmi-note-4-3.jpeg', 0, 'In Stock', '2017-02-04 04:03:15', '', 1, NULL, 0),
(4, 4, 4, 'Lenovo K6 Power (Silver, 32 GB) ', 'Lenovo', 9999, 0, '<ul><li>3 GB RAM | 32 GB ROM | Expandable Upto 128 GB<br></li><li>5 inch Full HD Display<br></li><li>13MP Primary Camera | 8MP Front<br></li><li>4000 mAh Li-Polymer Battery<br></li><li>Qualcomm Snapdragon 430 Processor<br></li></ul>', 'lenovo-k6-power-k33a42-1.jpeg', 'lenovo-k6-power-k33a42-2.jpeg', 'lenovo-k6-power-k33a42-3.jpeg', 45, 'In Stock', '2017-02-04 04:04:43', '', 1, NULL, 0),
(5, 4, 4, 'Lenovo Vibe K5 Note (Gold, 32 GB)  ', 'Lenovo', 11999, 0, '<ul><li>3 GB RAM | 32 GB ROM | Expandable Upto 128 GB<br></li><li>5.5 inch Full HD Display<br></li><li>13MP Primary Camera | 8MP Front<br></li><li>3500 mAh Li-Ion Polymer Battery<br></li><li>Helio P10 64-bit Processor<br></li></ul>', 'lenovo-k5-note-pa330010in-1.jpeg', 'lenovo-k5-note-pa330116in-2.jpeg', 'lenovo-k5-note-pa330116in-3.jpeg', 0, 'In Stock', '2017-02-04 04:06:17', '', 1, NULL, 0),
(6, 4, 4, 'Micromax Canvas Mega 4G', 'Micromax', 6999, 0, '<ul><li>3 GB RAM | 16 GB ROM |<br></li><li>5.5 inch HD Display<br></li><li>13MP Primary Camera | 5MP Front<br></li><li>2500 mAh Battery<br></li><li>MT6735 Processor<br></li></ul>', 'micromax-canvas-mega-4g-1.jpeg', 'micromax-canvas-mega-4g-2.jpeg', 'micromax-canvas-mega-4g-3.jpeg', 35, 'In Stock', '2017-02-04 04:08:07', '', 1, NULL, 0),
(7, 4, 4, 'SAMSUNG Galaxy On5', 'SAMSUNG', 7490, 0, '<ul><li>1.5 GB RAM | 8 GB ROM | Expandable Upto 128 GB<br></li><li>5 inch HD Display<br></li><li>8MP Primary Camera | 5MP Front<br></li><li>2600 mAh Li-Ion Battery<br></li><li>Exynos 3475 Processor<br></li></ul>', 'samsung-galaxy-on7-sm-1.jpeg', 'samsung-galaxy-on5-sm-2.jpeg', 'samsung-galaxy-on5-sm-3.jpeg', 20, 'In Stock', '2017-02-04 04:10:17', '', 1, NULL, 0),
(8, 4, 4, 'OPPO A57', 'OPPO', 14990, 0, '<ul><li>3 GB RAM | 32 GB ROM | Expandable Upto 256 GB<br></li><li>5.2 inch HD Display<br></li><li>13MP Primary Camera | 16MP Front<br></li><li>2900 mAh Battery<br></li><li>Qualcomm MSM8940 64-bit Processor<br></li></ul>', 'oppo-a57-na-original-1.jpeg', 'oppo-a57-na-original-2.jpeg', 'oppo-a57-na-original-3.jpeg', 0, 'In Stock', '2017-02-04 04:11:54', '', 1, NULL, 0),
(9, 4, 5, 'Affix Back Cover for Mi Redmi Note 4', 'Techguru', 259, 0, '<ul><li>Suitable For: Mobile<br></li><li>Material: Polyurethane<br></li><li>Theme: No Theme<br></li><li>Type: Back Cover<br></li><li>Waterproof<br></li></ul>', 'amzer-amz98947-original-1.jpeg', 'amzer-amz98947-original-2.jpeg', 'amzer-amz98947-original-3.jpeg', 10, 'In Stock', '2017-02-04 04:17:03', '', 1, NULL, 0),
(11, 4, 6, 'Acer ES 15 Pentium Quad Core', 'Acer', 19990, 0, '<ul><li>Intel Pentium Quad Core Processor ( )<br></li><li>4 GB DDR3 RAM<br></li><li>Linux/Ubuntu Operating System<br></li><li>1 TB HDD<br></li><li>15.6 inch Display<br></li></ul>', 'acer-aspire-notebook-original-1.jpeg', 'acer-aspire-notebook-original-2.jpeg', 'acer-aspire-notebook-original-3.jpeg', 0, 'In Stock', '2017-02-04 04:26:17', '', 1, NULL, 0),
(12, 4, 6, 'Micromax Canvas Laptab II (WIFI) Atom 4th Gen', 'Micromax', 10999, 0, '<ul><li>Intel Atom Processor ( 4th Gen )<br></li><li>2 GB DDR3 RAM<br></li><li>32 bit Windows 10 Operating System<br></li><li>11.6 inch Touchscreen Display<br></li></ul>', 'micromax-lt777w-2-in-1-laptop-original-1.jpeg', 'micromax-lt777w-2-in-1-laptop-original-2.jpeg', 'micromax-lt777w-2-in-1-laptop-original-3.jpeg', 0, 'In Stock', '2017-02-04 04:28:17', '', 1, NULL, 0),
(13, 4, 6, 'HP Core i5 5th Gen', 'HP', 41990, 0, '<span style=\"color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 18px;\">HP Core i5 5th Gen - (4 GB/1 TB HDD/Windows 10 Home/2 GB Graphics) N8M28PA 15-ac123tx Notebook</span><span style=\"color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 18px;\">&nbsp;&nbsp;(15.6 inch, Turbo SIlver, 2.19 kg)</span><br><div><ul><li>Intel Core i5 Processor ( 5th Gen )<br></li><li>4 GB DDR3 RAM<br></li><li>64 bit Windows 10 Operating System<br></li><li>1 TB HDD<br></li><li>15.6 inch Display<br></li></ul></div>', 'hp-notebook-original-1.jpeg', 'hp-notebook-original-2.jpeg', 'hp-notebook-original-3.jpeg', 0, 'In Stock', '2017-02-04 04:30:24', '', 1, NULL, 0),
(14, 4, 6, 'Lenovo Ideapad 110 APU Quad Core A6 6th Gen', 'Lenovo', 22990, 0, '<span style=\"color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 18px;\">Lenovo Ideapad 110 APU Quad Core A6 6th Gen - (4 GB/500 GB HDD/Windows 10 Home) 80TJ00D2IH IP110 15ACL Notebook</span><span style=\"color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 18px;\">&nbsp;&nbsp;(15.6 inch, Black, 2.2 kg)</span><br><div><ul><li>AMD APU Quad Core A6 Processor ( 6th Gen )<br></li><li>4 GB DDR3 RAM<br></li><li>64 bit Windows 10 Operating System<br></li><li>500 GB HDD<br></li><li>15.6 inch Display<br></li></ul></div>', 'lenovo-ideapad-notebook-original-1.jpeg', 'lenovo-ideapad-notebook-original-2.jpeg', 'lenovo-ideapad-notebook-3.jpeg', 0, 'In Stock', '2017-02-04 04:32:15', '', 1, NULL, 0),
(15, 3, 8, 'The Wimpy Kid Do -It- Yourself Book', 'ABC', 205, 250, '						<span style=\"color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 18px;\">The Wimpy Kid Do -It- Yourself Book</span><span style=\"color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 18px;\">&nbsp;&nbsp;(English, Paperback, Jeff Kinney)</span><br><div><ul><li>Language: English<br></li><li>Binding: Paperback<br></li><li>Publisher: Penguin Books Ltd<br></li><li>ISBN: 9780141339665, 0141339667<br></li><li>Edition: 1<br></li></ul></div>						', 'diary-of-a-wimpy-kid-do-it-yourself-book-original-1.jpeg', 'diary-of-a-wimpy-kid-do-it-yourself-book-original-1.jpeg', '', 50, 'In Stock', '2017-02-04 04:35:13', '', 2, '11', 1),
(16, 3, 8, 'Thea Stilton and the Tropical Treasure ', 'XYZ', 240, 0, '<ul><li>Language: English<br></li><li>Binding: Paperback<br></li><li>Publisher: Scholastic<br></li><li>ISBN: 9789351032083, 9351032086<br></li><li>Edition: 2015<br></li><li>Pages: 176<br></li></ul>', '22-thea-stilton-and-the-tropical-treasure-original-1.jpeg', '22-thea-stilton-and-the-tropical-treasure-original-1.jpeg', '22-thea-stilton-and-the-tropical-treasure-original-1.jpeg', 30, 'In Stock', '2017-02-04 04:36:23', '', 3, '12', 0),
(17, 5, 9, 'Induscraft Solid Wood King Bed With Storage', 'Induscraft', 32566, 0, '<span style=\"color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 18px;\">Induscraft Solid Wood King Bed With Storage</span><span style=\"color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 18px;\">&nbsp;&nbsp;(Finish Color - Honey Brown)</span><br><div><ul><li>Material Subtype: Rosewood (Sheesham)<br></li><li>W x H x D: 1850 mm x 875 mm x 2057.5 mm<br></li><li>Floor Clearance: 8 mm<br></li><li>Delivery Condition: Knock Down<br></li></ul></div>', 'inaf245-queen-rosewood-sheesham-induscraft-na-honey-brown-original-1.jpeg', 'inaf245-queen-rosewood-sheesham-induscraft-na-honey-brown-original-2.jpeg', 'inaf245-queen-rosewood-sheesham-induscraft-na-honey-brown-original-3.jpeg', 0, 'In Stock', '2017-02-04 04:40:37', '', 1, NULL, 0),
(18, 5, 10, 'Nilkamal Ursa Metal Queen Bed', 'Nilkamal', 6523, 0, '<span style=\"color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 18px;\">@home by Nilkamal Ursa Metal Queen Bed</span><span style=\"color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 18px;\">&nbsp;&nbsp;(Finish Color - NA)</span><br><div><ul><li>Material Subtype: Carbon Steel<br></li><li>W x H x D: 1590 mm x 910 mm x 2070 mm<br></li><li>Floor Clearance: 341 mm<br></li><li>Delivery Condition: Knock Down<br></li></ul></div>', 'flbdorsabrqbblk-queen-carbon-steel-home-by-nilkamal-na-na-original-1.jpeg', 'flbdorsabrqbblk-queen-carbon-steel-home-by-nilkamal-na-na-original-2.jpeg', 'flbdorsabrqbblk-queen-carbon-steel-home-by-nilkamal-na-na-original-3.jpeg', 0, 'In Stock', '2017-02-04 04:42:27', '', 1, NULL, 0),
(19, 6, 12, 'Asian Casuals  (White, White)', 'Asian', 379, 0, '<ul style=\"box-sizing: border-box; margin-bottom: 0px; margin-left: 0px; color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 14px;\"><li class=\"_2-riNZ\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Colour: White, White</li><li class=\"_2-riNZ\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 0px 16px; list-style: none; position: relative;\">Outer Material: Denim</li><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\"><br></div></li></ul>', '1.jpeg', '2.jpeg', '3.jpeg', 45, 'In Stock', '2017-03-10 20:16:03', '', 1, NULL, 0),
(20, 6, 12, 'Adidas MESSI 16.3 TF Football turf Shoes  (Blue)', 'Adidas', 4129, 5000, '<ul style=\"box-sizing: border-box; margin-bottom: 0px; margin-left: 0px; color: rgb(33, 33, 33); font-family: Roboto, Arial, sans-serif; font-size: 14px;\"><li class=\"_2-riNZ\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Colour: Blue</li><li class=\"_2-riNZ\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 0px 16px; list-style: none; position: relative;\">Closure: Laced</li><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"text-align: left; box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\"><b>Weight</b></div><ul class=\"_3dG3ix col col-9-12\" style=\"box-sizing: border-box; margin-left: 0px; width: 548.25px; display: inline-block; vertical-align: top; line-height: 1.4;\"><li class=\"sNqDog\" style=\"text-align: left; box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\"><b>200 g (per single Shoe) - Weight of the product may vary depending on size.</b></li></ul></li><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"text-align: left; box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\"><b>Style</b></div><ul class=\"_3dG3ix col col-9-12\" style=\"box-sizing: border-box; margin-left: 0px; width: 548.25px; display: inline-block; vertical-align: top; line-height: 1.4;\"><li class=\"sNqDog\" style=\"text-align: left; box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\"><b>Panel and Stitch Detail, Textured Detail</b></li></ul></li><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"text-align: left; box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\"><b>Tip Shape</b></div><ul class=\"_3dG3ix col col-9-12\" style=\"box-sizing: border-box; margin-left: 0px; width: 548.25px; display: inline-block; vertical-align: top; line-height: 1.4;\"><li class=\"sNqDog\" style=\"text-align: left; box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\"><b>Round</b></li></ul></li><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px 0px 16px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"text-align: left; box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\"><b>Season</b></div><ul class=\"_3dG3ix col col-9-12\" style=\"box-sizing: border-box; margin-left: 0px; width: 548.25px; display: inline-block; vertical-align: top; line-height: 1.4;\"><li class=\"sNqDog\" style=\"text-align: left; box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\"><b>AW16</b></li></ul></li><li class=\"_1KuY3T row\" style=\"box-sizing: border-box; margin: 0px; padding: 0px; list-style: none; display: flex; flex-flow: row wrap; width: 731px;\"><div class=\"vmXPri col col-3-12\" style=\"text-align: left; box-sizing: border-box; margin: 0px; padding: 0px 8px 0px 0px; width: 182.75px; display: inline-block; vertical-align: top; color: rgb(135, 135, 135);\"><b>Closure</b></div><ul class=\"_3dG3ix col col-9-12\" style=\"box-sizing: border-box; margin-left: 0px; width: 548.25px; display: inline-block; vertical-align: top; line-height: 1.4;\"><li class=\"sNqDog\" style=\"text-align: left; box-sizing: border-box; margin: 0px; padding: 0px; list-style: none;\"><b>Laced</b></li></ul></li></ul>', '1.jpeg', '2.jpeg', '3.jpeg', 0, 'In Stock', '2017-03-10 20:19:22', '', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(11) NOT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `subcategory` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `categoryid`, `subcategory`, `creationDate`, `updationDate`) VALUES
(2, 4, 'Led Television', '2017-01-26 16:24:52', '26-01-2017 11:03:40 PM'),
(3, 4, 'Television', '2017-01-26 16:29:09', ''),
(4, 4, 'Mobiles', '2017-01-30 16:55:48', ''),
(5, 4, 'Mobile Accessories', '2017-02-04 04:12:40', ''),
(6, 4, 'Laptops', '2017-02-04 04:13:00', ''),
(7, 4, 'Computers', '2017-02-04 04:13:27', ''),
(8, 3, 'Comics', '2017-02-04 04:13:54', ''),
(9, 5, 'Beds', '2017-02-04 04:36:45', ''),
(10, 5, 'Sofas', '2017-02-04 04:37:02', ''),
(11, 5, 'Dining Tables', '2017-02-04 04:37:51', '13-09-2023 06:18:33 PM'),
(12, 6, 'Men Footwears', '2017-03-10 20:12:59', ''),
(14, 8, 'fsgdfgdfg', '2023-09-13 12:09:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `userEmail` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `userEmail`, `userip`, `loginTime`, `logout`, `status`) VALUES
(1, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-26 11:18:50', '', 1),
(2, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-26 11:29:33', '', 1),
(3, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-26 11:30:11', '', 1),
(4, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-26 15:00:23', '26-02-2017 11:12:06 PM', 1),
(5, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-26 18:08:58', '', 0),
(6, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-26 18:09:41', '', 0),
(7, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-26 18:10:04', '', 0),
(8, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-26 18:10:31', '', 0),
(9, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-26 18:13:43', '', 1),
(10, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-27 18:52:58', '', 0),
(11, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-02-27 18:53:07', '', 1),
(12, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-03 18:00:09', '', 0),
(13, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-03 18:00:15', '', 1),
(14, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-06 18:10:26', '', 1),
(15, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-07 12:28:16', '', 1),
(16, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-07 18:43:27', '', 1),
(17, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-07 18:55:33', '', 1),
(18, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-07 19:44:29', '', 1),
(19, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-08 19:21:15', '', 1),
(20, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-15 17:19:38', '', 1),
(21, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-15 17:20:36', '15-03-2017 10:50:39 PM', 1),
(22, 'anuj.lpu1@gmail.com', 0x3a3a3100000000000000000000000000, '2017-03-16 01:13:57', '', 1),
(23, 'hgfhgf@gmass.com', 0x3a3a3100000000000000000000000000, '2018-04-29 09:30:40', '', 1),
(24, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 04:50:53', '01-09-2023 10:23:54 AM', 1),
(25, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 04:54:04', NULL, 1),
(26, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 04:57:33', '01-09-2023 10:55:16 AM', 1),
(27, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:25:29', '01-09-2023 10:55:40 AM', 1),
(28, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:34:25', '01-09-2023 11:04:30 AM', 1),
(29, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:34:45', '01-09-2023 11:06:16 AM', 1),
(30, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:36:33', '01-09-2023 11:06:38 AM', 1),
(31, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:36:49', '01-09-2023 11:06:54 AM', 1),
(32, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:37:03', NULL, 0),
(33, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:37:41', NULL, 0),
(34, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:37:46', '01-09-2023 11:10:51 AM', 1),
(35, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:41:01', NULL, 0),
(36, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:41:07', '01-09-2023 11:17:16 AM', 1),
(37, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:47:42', '01-09-2023 11:21:28 AM', 1),
(38, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:51:35', NULL, 0),
(39, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:51:58', NULL, 1),
(40, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:52:03', NULL, 1),
(41, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:53:55', NULL, 1),
(42, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 05:53:59', '01-09-2023 11:36:31 AM', 1),
(43, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 06:06:41', NULL, 1),
(44, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 06:06:49', NULL, 1),
(45, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 06:06:53', NULL, 1),
(46, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 06:07:09', '01-09-2023 11:47:49 AM', 1),
(47, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 06:17:55', '01-09-2023 12:08:43 PM', 1),
(48, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 06:39:17', '01-09-2023 12:11:25 PM', 1),
(49, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 06:42:14', '01-09-2023 12:29:28 PM', 1),
(50, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 06:59:37', '01-09-2023 12:34:17 PM', 1),
(51, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 07:04:27', '01-09-2023 12:34:38 PM', 1),
(52, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-01 07:04:49', NULL, 1),
(53, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 04:17:00', '02-09-2023 10:10:12 AM', 1),
(54, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 04:41:19', '02-09-2023 10:13:07 AM', 1),
(55, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 04:44:02', '02-09-2023 10:14:23 AM', 1),
(56, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 04:44:59', '02-09-2023 10:17:21 AM', 1),
(57, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 04:47:44', '02-09-2023 10:18:02 AM', 1),
(58, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 04:54:12', '02-09-2023 10:24:32 AM', 1),
(59, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 04:54:57', '02-09-2023 10:25:15 AM', 1),
(60, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 04:55:44', '02-09-2023 10:27:13 AM', 1),
(61, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 06:23:30', '02-09-2023 11:55:09 AM', 1),
(62, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 06:29:14', '02-09-2023 11:59:28 AM', 1),
(63, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 06:29:38', '02-09-2023 11:59:48 AM', 1),
(64, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 06:29:58', '02-09-2023 12:02:55 PM', 1),
(65, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 06:34:46', '02-09-2023 12:05:06 PM', 1),
(66, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 06:35:28', '02-09-2023 12:05:55 PM', 1),
(67, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 06:36:11', '02-09-2023 12:06:20 PM', 1),
(68, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 06:36:28', NULL, 1),
(69, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 12:30:12', NULL, 0),
(70, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 12:30:17', '02-09-2023 06:03:00 PM', 1),
(71, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 12:33:06', NULL, 0),
(72, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 12:33:11', '02-09-2023 06:03:31 PM', 1),
(73, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-02 12:33:42', NULL, 1),
(74, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 04:11:18', NULL, 0),
(75, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 04:11:23', '04-09-2023 09:49:27 AM', 1),
(76, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 04:19:35', '04-09-2023 09:49:41 AM', 1),
(77, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 04:19:47', NULL, 0),
(78, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 04:19:51', '04-09-2023 09:51:35 AM', 1),
(79, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 04:21:43', '04-09-2023 10:32:57 AM', 1),
(80, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 05:03:05', '04-09-2023 10:33:09 AM', 1),
(81, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 06:23:20', NULL, 0),
(82, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 06:23:25', '04-09-2023 02:45:25 PM', 1),
(83, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 09:15:32', NULL, 0),
(84, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 09:15:37', '04-09-2023 04:45:39 PM', 1),
(85, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 11:15:47', NULL, 0),
(86, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 11:15:52', '04-09-2023 04:47:15 PM', 1),
(87, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 11:17:23', '04-09-2023 04:47:26 PM', 1),
(88, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 11:18:06', '04-09-2023 04:48:09 PM', 1),
(89, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 11:18:50', '04-09-2023 04:48:53 PM', 1),
(90, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 11:20:09', '04-09-2023 04:50:13 PM', 1),
(91, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 11:20:35', '04-09-2023 04:50:38 PM', 1),
(92, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 11:20:44', '04-09-2023 04:50:46 PM', 1),
(93, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 11:20:53', '04-09-2023 04:50:58 PM', 1),
(94, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 11:35:56', '04-09-2023 05:06:24 PM', 1),
(95, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 12:00:28', NULL, 0),
(96, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-04 12:00:33', NULL, 1),
(97, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-05 10:42:14', NULL, 0),
(98, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-05 10:42:18', NULL, 1),
(99, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-06 11:08:01', NULL, 1),
(100, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 05:55:16', '07-09-2023 11:50:57 AM', 1),
(101, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 06:30:11', '07-09-2023 12:00:29 PM', 1),
(102, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 06:35:25', '07-09-2023 12:05:37 PM', 1),
(103, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 06:35:54', '07-09-2023 12:09:30 PM', 1),
(104, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 06:39:44', '07-09-2023 12:10:05 PM', 1),
(105, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 06:40:16', '07-09-2023 12:10:24 PM', 1),
(106, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 06:40:53', '07-09-2023 12:12:50 PM', 1),
(107, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 06:43:11', '07-09-2023 12:14:48 PM', 1),
(108, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 07:05:59', '07-09-2023 12:36:10 PM', 1),
(109, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 07:06:24', '07-09-2023 05:01:30 PM', 1),
(110, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 11:43:42', '07-09-2023 05:19:47 PM', 1),
(111, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 11:50:59', '07-09-2023 06:11:32 PM', 1),
(112, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-07 12:41:38', NULL, 1),
(113, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-08 03:38:44', '08-09-2023 10:46:40 AM', 1),
(114, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-08 05:17:21', NULL, 1),
(115, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-11 05:42:22', '11-09-2023 11:27:22 AM', 1),
(116, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-11 05:57:29', '11-09-2023 12:15:11 PM', 1),
(117, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-11 06:45:16', '11-09-2023 05:22:40 PM', 1),
(118, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-11 11:52:50', '11-09-2023 06:20:29 PM', 1),
(119, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 06:32:36', '12-09-2023 12:02:48 PM', 1),
(120, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 06:32:57', '12-09-2023 12:07:20 PM', 1),
(121, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 06:37:49', '12-09-2023 12:16:28 PM', 1),
(122, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 06:46:35', '12-09-2023 12:17:09 PM', 1),
(123, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 06:47:16', '12-09-2023 12:17:42 PM', 1),
(124, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 06:48:48', NULL, 1),
(125, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 07:00:28', '12-09-2023 12:32:20 PM', 1),
(126, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 07:04:50', NULL, 1),
(127, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 07:08:45', NULL, 1),
(128, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 07:09:45', NULL, 1),
(129, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 07:14:24', NULL, 1),
(130, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 07:23:34', NULL, 1),
(131, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-12 11:47:16', NULL, 1),
(132, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 03:46:03', NULL, 1),
(133, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 05:22:52', NULL, 1),
(134, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 05:23:17', NULL, 0),
(135, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 05:23:24', NULL, 1),
(136, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 05:35:05', NULL, 1),
(137, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 05:40:07', NULL, 1),
(138, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 07:09:38', NULL, 1),
(139, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 07:13:09', NULL, 1),
(140, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 07:13:45', NULL, 1),
(141, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 07:15:02', NULL, 1),
(142, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 07:15:13', NULL, 1),
(143, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 07:27:21', NULL, 1),
(144, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 08:34:28', NULL, 1),
(145, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 09:27:25', NULL, 1),
(146, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 09:31:36', NULL, 1),
(147, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 09:36:01', NULL, 1),
(148, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 09:36:29', NULL, 1),
(149, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 09:40:28', NULL, 1),
(150, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 09:43:32', NULL, 1),
(151, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 09:46:08', NULL, 1),
(152, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 09:48:34', '13-09-2023 03:18:40 PM', 1),
(153, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 09:49:01', '13-09-2023 04:22:46 PM', 1),
(154, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-13 10:53:37', NULL, 1),
(155, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-14 03:37:24', NULL, 1),
(156, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-15 10:47:09', '15-09-2023 04:57:43 PM', 1),
(157, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-15 11:27:48', NULL, 0),
(158, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-15 11:27:55', NULL, 1),
(159, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-18 04:04:42', '18-09-2023 12:58:10 PM', 1),
(160, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-22 08:50:09', NULL, 1),
(161, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-22 10:50:07', NULL, 0),
(162, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-22 10:50:12', NULL, 1),
(163, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-25 11:02:57', NULL, 0),
(164, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-25 11:03:04', '25-09-2023 05:21:41 PM', 1),
(165, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-25 11:52:17', NULL, 1),
(166, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-26 04:30:23', '26-09-2023 01:02:19 PM', 1),
(167, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-26 07:32:30', '26-09-2023 03:06:23 PM', 1),
(168, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-26 09:36:33', '26-09-2023 05:54:43 PM', 1),
(169, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-26 12:24:51', NULL, 1),
(170, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-27 04:04:36', '27-09-2023 11:14:36 AM', 1),
(171, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-27 05:44:52', '27-09-2023 04:47:25 PM', 1),
(172, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-27 11:44:32', NULL, 1),
(173, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-28 04:12:05', NULL, 0),
(174, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-28 04:12:11', NULL, 1),
(175, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-09-29 06:20:13', NULL, 1),
(176, 'dhana@gmail.com', 0x3a3a3100000000000000000000000000, '2023-10-05 03:51:39', NULL, 1),
(177, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-10-05 10:07:52', NULL, 1),
(178, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-10-06 04:20:47', NULL, 1),
(179, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-10-10 05:16:56', NULL, 0),
(180, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-10-10 05:17:01', NULL, 1),
(181, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-10-11 03:37:07', NULL, 1),
(182, 'Yazar@gmail.com', 0x3a3a3100000000000000000000000000, '2023-10-21 03:45:16', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` bigint(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `shippingAddress` longtext DEFAULT NULL,
  `shippingState` varchar(255) DEFAULT NULL,
  `shippingCity` varchar(255) DEFAULT NULL,
  `shippingPincode` int(11) DEFAULT NULL,
  `billingAddress` longtext DEFAULT NULL,
  `billingState` varchar(255) DEFAULT NULL,
  `billingCity` varchar(255) DEFAULT NULL,
  `billingPincode` int(11) DEFAULT NULL,
  `regDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL,
  `address_line1` varchar(255) DEFAULT NULL,
  `address_line2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contactno`, `password`, `shippingAddress`, `shippingState`, `shippingCity`, `shippingPincode`, `billingAddress`, `billingState`, `billingCity`, `billingPincode`, `regDate`, `updationDate`, `address_line1`, `address_line2`) VALUES
(1, 'Anuj Kumar', 'anuj.lpu1@gmail.com', 9009857868, 'f925916e2754e5e03f75dd58a5733251', 'CS New Delhi, New Delhi, Delhi, 110001', 'New Delhi', 'Delhi', 110001, 'New Delhi', 'New Delhi', 'Delhi', 110092, '2017-02-04 19:30:50', '', 'CS New Delhi, New Delhi, Delhi, 110001', 'New Delhi, Delhi, 110001'),
(2, 'Amit ', 'amit@gmail.com', 8285703355, '5c428d8875d2948607f3e3fe134d71b4', '', '', '', 0, '', '', '', 0, '2017-03-15 17:21:22', '', NULL, NULL),
(3, 'hg', 'hgfhgf@gmass.com', 1121312312, '827ccb0eea8a706c4c34a16891f84e7b', '', '', '', 0, '', '', '', 0, '2018-04-29 09:30:32', '', NULL, NULL),
(6, 'dhana', 'dhana@gmail.com', 7373170110, '81dc9bdb52d04dc20036dbd8313ed055', 'sdfgsdsdg3', 'Tamil Nadu', 'Tiruchirappalli', 620001, 'dfgssdgd2', 'Tamil Nadu', 'Tiruchirappalli', 620011, '2023-09-01 05:51:46', '02-09-2023 05:22:18 PM', NULL, NULL),
(7, 'Yazar', 'Yazar@gmail.com', 9874563210, '6562c5c1f33db6e05a082a88cddab5ea', 'dfghgfdh', 'Tamil Nadu', 'Chennai', 600011, 'sdfgdg', 'Tamil Nadu', 'Tiruchirappalli', 620011, '2023-09-01 06:41:52', '02-09-2023 06:05:59 PM', NULL, NULL),
(8, 'Test', 'Test1@gmail.com', 9123456789, '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-04 05:33:22', NULL, NULL, NULL),
(9, 'sample', NULL, 9012345678, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-21 06:32:28', NULL, NULL, NULL),
(10, 'test', 'abc@def.com', 7373170111, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-24 12:10:14', NULL, 'test1', 'test2'),
(11, NULL, NULL, 9874563211, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-10-24 12:24:45', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `postingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `userId`, `productId`, `postingDate`) VALUES
(60, 1, 1, '2023-09-08 10:30:57'),
(75, 7, 16, '2023-09-13 05:36:55'),
(85, 7, 15, '2023-09-28 06:34:23'),
(88, 6, 15, '2023-10-05 05:11:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combo`
--
ALTER TABLE `combo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combo_product`
--
ALTER TABLE `combo_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordertrackhistory`
--
ALTER TABLE `ordertrackhistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productreviews`
--
ALTER TABLE `productreviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `combo`
--
ALTER TABLE `combo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `combo_product`
--
ALTER TABLE `combo_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `ordertrackhistory`
--
ALTER TABLE `ordertrackhistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productreviews`
--
ALTER TABLE `productreviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
