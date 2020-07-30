-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2020 at 11:02 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `announcement` text COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `bcolor` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'lightgrey',
  `tcolor` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'white'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `username`, `announcement`, `url`, `status`, `bcolor`, `tcolor`) VALUES
(4, 'Ledi', 'Zinblet: We build enterprise solutions and applications that beats the test of speed, security and trust.       ', 'http://istore.epizy.com/ecommerce/contact', 0, '#FFF0F5', '#D2691E'),
(6, 'Ledi', '         Sales on till 14th of december........      Sales on till 14th of december........\r\nSales on till 14th of december........\r\nSales on till 14th of december........\r\nSales on till 14th of december........  \r\nSales on till 14th of december........\r\nSales on till 14th of december........\r\nSales on till 14th of december........       ', 'http://localhost:81/ecommerce/category?cat=87', 0, '#FFF0F5', '#D2691E'),
(7, 'Ledi', '      Recommender Systems      ', 'search', 1, '#FFF0F5', '#D2691E'),
(8, 'Ledi', 'sales', 'u', 0, '#FFF0F5', '#D2691E');

-- --------------------------------------------------------

--
-- Table structure for table `appearance`
--

CREATE TABLE `appearance` (
  `background_color` text COLLATE utf8_unicode_ci NOT NULL,
  `footer_color` text COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL,
  `background_image` text COLLATE utf8_unicode_ci NOT NULL,
  `category_image` text COLLATE utf8_unicode_ci NOT NULL,
  `navB_color` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'grey',
  `navT_color` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'black',
  `navdropB_color` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'grey',
  `navdropT_color` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'black',
  `navdropheader_color` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'black'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `appearance`
--

INSERT INTO `appearance` (`background_color`, `footer_color`, `id`, `background_image`, `category_image`, `navB_color`, `navT_color`, `navdropB_color`, `navdropT_color`, `navdropheader_color`) VALUES
('#E6E6FA', '#DCDCDC', 1, '/images/headerlogo/background.jpg', '/images/headerlogo/categorybrowse.jpg', '#696969', '#F8F8FF', '#C0C0C0', '#F0F8FF', '#D2691E');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(41, 'PERKINS'),
(44, 'NIVEA'),
(45, 'JOY'),
(46, 'Ameritinz Special'),
(49, 'Damabel'),
(51, 'Dove');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` tinyint(4) NOT NULL DEFAULT '0',
  `exp_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `username`, `items`, `expire_date`, `paid`, `shipped`, `exp_time`) VALUES
(157, 'ledi', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '2018-12-20 01:47:19', 1, 1, 0),
(195, 'ledi', '[{\"id\":\"16\",\"price\":\"3000\",\"size\":\"Family\",\"quantity\":2,\"request\":\"\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":1,\"request\":\"\"}]', '2018-12-20 23:46:49', 1, 1, 0),
(202, 'BB', '[{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":4,\"request\":\"\"}]', '2018-12-21 02:24:05', 1, 0, 0),
(203, 'ledi', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":2,\"request\":\"\"}]', '2018-12-21 14:03:34', 1, 1, 0),
(217, 'ledi', '[{\"id\":\"24\",\"price\":\"4900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '2018-12-26 10:06:08', 1, 1, 0),
(218, 'ledi', '[{\"id\":\"21\",\"price\":\"3900\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\"}]', '2018-12-26 10:08:34', 1, 1, 0),
(219, 'ledi', '[{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"5\",\"request\":\"\"}]', '2018-12-30 10:50:31', 1, 1, 0),
(223, 'ledi', '[{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":1,\"request\":\"\"}]', '2019-01-02 01:27:55', 1, 1, 0),
(230, 'ledi', '[{\"id\":\"25\",\"price\":\"2500\",\"size\":\"medium\",\"quantity\":\"2\",\"request\":\"Mild fragrance \"},{\"id\":\"25\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"Mild Fragrance. \"}]', '2019-01-10 20:03:46', 1, 1, 0),
(251, 'ledi', '[{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"29\",\"price\":\"5000\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"}]', '2019-01-31 19:43:58', 1, 1, 1546368238),
(253, 'ledi', '[{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '2019-02-03 10:26:30', 1, 1, 1546593990),
(254, 'ledi', '[{\"id\":\"18\",\"price\":\"1900\",\"size\":\"20Pieces\",\"quantity\":\"1\",\"request\":\"\"}]', '2019-02-03 10:40:06', 1, 1, 1546594806),
(381, 'ledi', '[{\"id\":\"26\",\"price\":\"4900\",\"size\":\"100mg\",\"quantity\":2,\"request\":\"\"}]', '2019-02-16 13:40:56', 1, 1, 1547728856),
(389, 'ledi', '[{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '2019-02-26 00:33:05', 1, 1, 1548545585),
(390, 'ledi', '[{\"id\":\"18\",\"price\":\"1900\",\"size\":\"Family\",\"quantity\":\"2\",\"request\":\"\"}]', '2019-03-01 16:09:18', 1, 1, 1548860958),
(391, 'ledi', '[{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '2019-03-01 16:30:13', 1, 1, 1548862213),
(393, 'ledi', '[{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"2\",\"request\":\"\"}]', '2019-03-17 04:50:29', 1, 1, 1550202629),
(396, 'ledi', '[{\"id\":\"23\",\"price\":\"2900\",\"size\":\"Saver\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":1,\"request\":\"\"}]', '2019-03-22 14:59:53', 1, 1, 1550671193),
(401, 'ledi', '[{\"id\":\"36\",\"price\":\"1\",\"size\":\"q\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"23\",\"price\":\"2900\",\"size\":\"Saver\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":1,\"request\":\"\"}]', '2019-05-13 17:40:18', 1, 1, 1555173618),
(402, 'jay', '[{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":\"1\",\"request\":\"\"}]', '2019-03-27 14:14:29', 1, 1, 1551100469),
(408, 'ledi', '[{\"id\":\"22\",\"price\":\"3900\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"26\",\"price\":\"4900\",\"size\":\"100mg\",\"quantity\":1,\"request\":\"\"}]', '2019-08-04 19:38:24', 1, 0, 1562351904),
(410, 'ledi', '[{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"2\",\"request\":\"\"},{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":\"1\",\"request\":\"\"}]', '2019-08-22 00:47:25', 1, 0, 1563839245),
(411, 'ledi', '[{\"id\":\"22\",\"price\":\"3900\",\"size\":\"Adult\",\"quantity\":\"2\",\"request\":\"\"},{\"id\":\"25\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":\"3\",\"request\":\"\"},{\"id\":\"28\",\"price\":\"3900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"}]', '2019-08-22 02:24:58', 1, 0, 1563845098),
(413, 'ledi', '[{\"id\":\"28\",\"price\":\"4500\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"10\"}]', '2019-09-02 01:04:02', 1, 0, 1564790642),
(414, 'ledi', '[{\"id\":\"26\",\"price\":\"4900\",\"size\":\"100mg\",\"quantity\":1,\"request\":\"\",\"discount\":\"0\"},{\"id\":\"28\",\"price\":\"3900\",\"size\":\"Baby\",\"quantity\":1,\"request\":\"\",\"discount\":\"0\"}]', '2019-09-05 00:24:49', 1, 0, 1565047489),
(416, 'ledi', '[{\"id\":\"22\",\"price\":\"3900\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2019-09-05 00:34:28', 1, 0, 1565048068),
(417, 'ledi', '[{\"id\":\"22\",\"price\":\"3900\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2019-09-05 00:41:02', 1, 0, 1565048462),
(418, 'ledi', '[{\"id\":\"16\",\"price\":\"3000\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2019-09-05 00:45:00', 1, 0, 1565048700),
(419, 'ledi', '[{\"id\":\"28\",\"price\":\"3900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"},{\"id\":\"16\",\"price\":\"3000\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2019-09-05 00:59:08', 1, 0, 1565049548),
(420, 'ledi', '[{\"id\":\"32\",\"price\":\"20\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"},{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2019-09-05 01:01:32', 1, 0, 1565049692),
(421, 'ledi', '[{\"id\":\"28\",\"price\":\"3900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"10\"},{\"id\":\"16\",\"price\":\"3000\",\"size\":\"Family\",\"quantity\":2,\"request\":\"\",\"discount\":\"0\"}]', '2019-09-05 01:48:46', 1, 0, 1565052526),
(423, 'ledi', '[{\"id\":\"32\",\"price\":\"20\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2019-09-05 02:33:17', 1, 0, 1565055197),
(433, 'ledi', '[{\"id\":\"37\",\"price\":\"1000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"},{\"id\":\"28\",\"price\":\"4500\",\"size\":\"Adult\",\"quantity\":1,\"request\":\"\",\"discount\":\"0\"},{\"id\":\"25\",\"price\":\"2500\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"},{\"id\":\"32\",\"price\":\"20\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2020-08-24 01:03:50', 0, 0, 1595635430),
(435, 'godfrey', '[{\"id\":\"27\",\"price\":\"3200\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2020-08-21 20:44:29', 0, 0, 1595447069),
(436, 'Giudy', '[{\"id\":\"31\",\"price\":\"10\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"},{\"id\":\"28\",\"price\":\"4500\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2020-08-21 20:48:41', 0, 0, 1595447321),
(437, 'peter', '[{\"id\":\"25\",\"price\":\"2500\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"},{\"id\":\"31\",\"price\":\"10\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"},{\"id\":\"28\",\"price\":\"4500\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2020-08-21 20:54:56', 0, 0, 1595447696),
(438, 'damabel', '[{\"id\":\"25\",\"price\":\"2500\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"},{\"id\":\"32\",\"price\":\"20\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '2020-08-22 04:57:37', 0, 0, 1595476657);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`, `active`) VALUES
(1, 'MEN', 0, 0),
(2, 'WOMEN', 0, 1),
(72, 'Gist Set', 1, 0),
(75, 'Gist Set', 2, 0),
(76, 'Body Wash', 2, 1),
(77, 'UNISEX', 0, 1),
(78, 'Spray', 77, 1),
(80, 'Beauty Bar', 1, 0),
(81, 'Deudorant', 1, 0),
(82, 'Cream', 2, 1),
(83, 'Beauty Bar', 2, 1),
(84, 'Deodurant', 2, 1),
(85, 'DEODURANT', 77, 1),
(86, 'Beauty Bar', 77, 1),
(87, 'Cream', 77, 1),
(88, 'Body Wash', 77, 1),
(95, 'BABIES', 0, 1),
(99, 'Soap', 1, 0),
(100, 'Toiletries', 2, 0),
(101, 'Unisex', 95, 1),
(106, 'Gist Set', 0, 1),
(117, 'Body Wash', 106, 1),
(118, 'Body Wash', 95, 1),
(119, 'Gist Set', 95, 1),
(120, 'Cream', 95, 1),
(121, 'clothing', 0, 1),
(122, 'skirt', 121, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `msg_date` datetime NOT NULL,
  `status` varchar(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phone`, `url`, `subject`, `message`, `msg_date`, `status`) VALUES
(3, 'Ledi Damabel', 'ledi@ameritinz.com', 'ledi@ameritinz.', 'http://localhost:81/ecommerce/category?cat=87', 'general', 'ddss', '0000-00-00 00:00:00', 'unread'),
(19, 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'http://localhost:81/ecommerce/category?cat=87', 'quote', 'No internet\r\nChecking the network cables, modem, and router\r\nReconnecting to Wi-Fi\r\nRunning Windows Network Diagnostics\r\nERR_INTERNET_DISCONNECTED', '2019-04-27 21:32:09', 'read'),
(22, 'damaebel', 'ledi@ameritinz.com', '0803093210', 'http://localhost:81/ecommerce/contact', 'Customer Service and Complaint', 'i want to know why your service i want to know why your service i want to know why your service i want to know why your service', '2019-04-29 18:15:36', 'read'),
(23, 'damaebel', 'ledi@ameritinz.com', '0803093210', 'http://localhost:81/ecommerce/contact', 'Customer Service and Complaint', 'i want to know why your service i want to know why your service i want to know why your service i want to know why your service', '2019-04-29 18:58:38', 'read'),
(24, 'damaebel', 'ledi@ameritinz.com', '0803093210', 'http://localhost:81/ecommerce/contact', 'Customer Service and Complaint', 'i want to know why your service i want to know why your service i want to know why your service i want to know why your service', '2019-04-29 18:58:44', 'unread'),
(25, 'damaebel', 'ledi@ameritinz.com', '0803093210', 'http://localhost:81/ecommerce/contact', 'Customer Service and Complaint', 'i want to know why your service i want to know why your service i want to know why your service i want to know why your service', '2019-04-29 18:58:48', 'unread'),
(26, 'damaebel', 'ledi@ameritinz.com', '0803093210', 'http://localhost:81/ecommerce/contact', 'Customer Service and Complaint', 'i want to know why your service i want to know why your service i want to know why your service i want to know why your service', '2019-04-29 18:58:52', 'read'),
(27, 'damaebel', 'ledi@ameritinz.com', '0803093210', 'http://localhost:81/ecommerce/contact', 'Customer Service and Complaint', 'i want to know why your service i want to know why your service i want to know why your service i want to know why your service', '2019-04-29 19:33:18', 'read'),
(28, 'damaebel', 'ledi@ameritinz.com', '0803093210', 'http://localhost:81/ecommerce/contact', 'Customer Service and Complaint', 'i want to know why your service i want to know why your service i want to know why your service i want to know why your service', '2019-04-29 19:33:23', 'read'),
(29, 'damaebel', 'ledi@ameritinz.com', '0803093210', 'http://localhost:81/ecommerce/contact', 'Customer Service and Complaint', 'i want to know why your service i want to know why your service i want to know why your service i want to know why your service', '2019-04-29 20:33:27', 'read'),
(30, 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'http://localhost:81/ecommerce/category?cat=87', 'Delivery Information', 'better have it better have itbetter have itbetter have itbetter have itbetter have itbetter have itbetter have it', '2019-05-14 12:40:01', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `email`, `password`, `active`) VALUES
(1, 'damabelg@gmail.pro', 'damabelg@gmail.pro', 'Password0247', 0),
(3, 'james', 'damabelg@gmail.bari', 'Password0247', 0),
(7, 'godfrey', 'damabel@gmail.gov', 'Password', 0),
(10, 'godfrey11', 'damabel@gmail.pass', '5f4dcc3b5aa765d61d8327deb882cf99', 0),
(11, 'test', 'damabel@gmail.pass2', 'dc647eb65e6711e155375218212b3964', 0),
(14, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_user`
--

CREATE TABLE `customer_user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` text COLLATE utf8_unicode_ci NOT NULL,
  `state` text COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` text COLLATE utf8_unicode_ci NOT NULL,
  `country` text COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer_user`
--

INSERT INTO `customer_user` (`id`, `username`, `full_name`, `email`, `password`, `phone`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `join_date`, `last_login`, `permissions`) VALUES
(5, 'peter', 'Peter customer', 'peter@mail.com', '$2y$10$jPS1FcbjseZFxBacy2MsX.PW6C5DOOVliYtk0qm9nzyBvuVlXDrhC', '08030342222', 'AIT Road', 'Chioba', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '2018-11-02 10:32:32', '2020-07-22 20:53:23', 'customer'),
(6, 'ledi', 'Ledi Damabel', 'ledi@mail.com', '$2y$10$jPS1FcbjseZFxBacy2MsX.PW6C5DOOVliYtk0qm9nzyBvuVlXDrhC', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '2018-11-02 10:41:49', '2020-07-26 22:01:03', 'admin,editor,staff'),
(10, 'godfrey', 'godfrey, Gret', 'godfrey@mail.com', '$2y$10$ljIC7/KfVgteMJ7S5kwnV.mQq457S9B.y1T0ZIP4LKacpdqGN8nPK', '08030342243', 'GRA', 'Estate', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '2018-11-04 14:03:49', '2020-07-25 19:38:39', 'admin,editor,staff'),
(11, 'damabel', 'Damabel James', 'damabel@mail.com', '$2y$10$8Opb7nj4hUMYtIfG8Oza1OpeQn.63Ssm.EF1IihsNe04L9D2mVQZ.', '08030932109', '', '', '', '', '', '', '2018-11-18 21:07:43', '2020-07-26 18:42:18', 'admin,editor,staff'),
(12, 'Giudy', 'Giudy Taiwah', 'giudy@mail.com', '$2y$10$1dz6OfaYCHRMh.3NGUL0F.wdXZ7/c2p/wu6lYEsWsGuf5jZbENbju', '080648756211', '', '', '', '', '', '', '2018-12-10 22:26:04', '2020-07-22 20:47:57', 'editor,staff');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `disc_code` varchar(17) COLLATE utf8_unicode_ci NOT NULL,
  `disc_percent` int(3) NOT NULL,
  `expiry` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `no_use` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `state` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `disc_code`, `disc_percent`, `expiry`, `created_date`, `no_use`, `status`, `state`) VALUES
(2, 'kipoLOjvH4MI8TM1', 20, '2019-08-22 18:06:53', '2019-08-03 22:20:59', '3', 1, 0),
(3, 'AMERITINZ-NEW', 8, '2019-08-28 23:24:40', '2019-08-03 22:42:43', '4', 0, 0),
(10, 'r7AxCI6wr1SckEHC', 2, '2022-11-20 0:03:00', '2019-08-03 23:29:41', '1', 1, 0),
(11, 'DOpK71wIDoLbCNse', 50, '2019-08-08 15:53:21', '2019-08-04 02:53:58', '7', 0, 1),
(12, '2d6qOhCzrwlfpjvM', 12, '2019-08-05 1:15:14', '2019-08-04 22:19:19', '4', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission`) VALUES
(1, 'staff'),
(2, 'editor,staff'),
(3, 'admin,editor,staff'),
(4, 'pro,admin,editor,staff'),
(5, 'customer'),
(6, 'Supreme');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `p_keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `sizes` text COLLATE utf8_unicode_ci NOT NULL,
  `sold` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0:0',
  `archive` tinyint(4) NOT NULL DEFAULT '0',
  `sales` tinyint(4) NOT NULL DEFAULT '0',
  `defective_product` tinyint(4) NOT NULL DEFAULT '0',
  `category_activate_flag` tinyint(4) NOT NULL DEFAULT '0',
  `recommend_flag` tinyint(4) NOT NULL DEFAULT '0',
  `product_average_rating` double NOT NULL,
  `product_rating_counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `p_keyword`, `featured`, `sizes`, `sold`, `archive`, `sales`, `defective_product`, `category_activate_flag`, `recommend_flag`, `product_average_rating`, `product_rating_counter`) VALUES
(13, 'Cetaphil', '2900.00', '3001.00', 46, '87', '/ecommerce/images/products/Cetaphil0.jpg', 'special beauty cream for all.. blemish removal..', 'cetaphil', 1, 'medium:2900:3:5,large:3200:5:5', '0:0', 1, 0, 0, 1, 0, 0, 0),
(14, 'Johnson Giudy', '1000.00', '2200.00', 49, '75', '/ecommerce/images/products/Johnson Giudy54ec2.jpg,/ecommerce/images/products/Johnson Giudy6363b.jpg,/ecommerce/images/products/Johnson Giudyee277.jpg,/ecommerce/images/products/Johnson Giudyb4d31.jpg', 'Johnson&#039;s baby special smooth skin bathing soap. ', 'johnson soup better  dumbor', 0, 'small:2900:8:10,medium:4000:3:10', '24:77700', 1, 0, 0, 0, 0, 0, 0),
(15, 'Suave kid', '2900.00', '3000.00', 46, '101', '/ecommerce/images/products/Suave kid0.jpg', '&lt;p&gt;Gentle on skin.. baby &lt;strong&gt;product&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', 'jj', 0, '80mg:2900:10:9', '116:17400', 1, 0, 0, 1, 0, 0, 0),
(16, 'Shoe1', '3000.00', '3500.00', 46, '75', '/ecommerce/images/products/Shoe1bb42a.jpg', 'care lotion for best skin', 'Intensive care lotion for best skin', 1, 'Family:3000:1:10', '6:18000', 0, 1, 0, 1, 0, 0, 0),
(17, 'Crest Toothpaste', '950.00', '1000.00', 46, '101', '/ecommerce/images/products/Crest Toothpaste77739.jpg', 'Oral B and Crete toothpaste. Brighter teeth and clean breath', 'toothpaste month wash', 1, 'Family:950:0:10', '3:2850', 0, 1, 0, 1, 0, 0, 0),
(18, 'Alway Maxi Pad1', '1900.00', '2000.00', 46, '86', '/ecommerce/images/products/Alway Maxi Pad8abb3.png,/ecommerce/images/products/Alway Maxi Pad40ded.png', 'Stay save and free with Always Maxi sanitary pad.', 'pad protection sanitary', 1, 'Family:1900:3:10', '3:5700', 0, 1, 0, 0, 0, 0, 0),
(19, 'Olay Special', '4900.00', '5000.00', 44, '82', '/ecommerce/images/products/Olay Special987c8.jpg,/ecommerce/images/products/Olay Special9da24.jpg', 'Olay original with extra-ordinary sheer butter. Brighter and healthy skin for everyday glow', 'Olay', 0, 'Adult:4900:3:20', '0:0', 0, 0, 0, 1, 0, 0, 0),
(20, 'ST Ives', '3900.00', '4000.00', 44, '82', '/ecommerce/images/products/ST Ives1.jpg', 'St Ives original lotion for clear skin and remove blemish replacing with radiant skin..', 'st ive smooth', 0, 'small:2000:5:10,medium:2000:14:10', '5:11900', 0, 0, 0, 1, 0, 0, 0),
(21, 'Tresemme', '3900.00', '4000.00', 46, '87', '/ecommerce/images/products/Tresemme0.jpg,/ecommerce/images/products/Tresemme1.jpg', 'Tresemme superior product. Hurry for a try today...', '', 0, 'Adult:3900:38:10', '1:3900', 0, 0, 0, 1, 0, 0, 0),
(22, 'ST Ives Hyd..', '3900.00', '4000.00', 46, '82', '/ecommerce/images/products/ST Ives Hyd..0.jpg', 'ST Ives hydrating product for better result on skin.', 'hydrated', 1, 'Adult:3900:18:20', '5:19500', 0, 1, 0, 1, 0, 0, 0),
(23, 'Huggies Pampers', '2900.00', '3000.00', 49, '101', '/ecommerce/images/products/Huggies Pampers0.jpg', 'Original US brand pampers by Huggies..Comfort guarantee for your baby.', 'pampers', 1, 'Saver:2900:10:10,Family:4000:12:10', '2:5800', 0, 0, 0, 1, 0, 4, 1),
(24, 'Huggies Snugglers', '4900.00', '5000.00', 46, '101', '/ecommerce/images/products/Huggies Snugglers0.jpg', 'Huggies original Snugglers for your baby.', 'Huggies', 0, 'Baby:4900:12:20', '1:4900', 0, 0, 0, 1, 0, 0, 0),
(25, 'Garnier blend', '2900.00', '3000.00', 46, '87', '/ecommerce/images/products/Garnier blend0.jpg', 'original US Garnier whole blend..', 'blend', 0, 'small:2000:17:10,medium:2500:18:10', '6:13000', 0, 1, 0, 1, 0, 4, 3),
(26, 'Paris Rose', '3000.00', '4000.00', 46, '76', '/ecommerce/images/products/Paris Rose0.jpg', 'Paris Rose clear gel secret..', 'paris', 0, '100mg:4900:1:10,20mg:3000:0:10', '9:42200', 0, 0, 0, 1, 0, 0, 0),
(27, 'Mitchum Dry', '3900.00', '4000.00', 46, '85', '/ecommerce/images/products/Mitchum Dry0.jpg', 'Stay fresh and sexy with original Mitchum US product.', 'Mitchum', 1, 'Adult:3900:40:9,Family:3200:2:10', '0:0', 0, 1, 0, 1, 0, 5, 2),
(28, 'Dove Lotion', '3900.00', '4000.00', 51, '87', '/ecommerce/images/products/Dove Lotion0.jpg,/ecommerce/images/products/Dove Lotion1.jpg,/ecommerce/images/products/Dove Lotion2.jpg', 'Original dove cream for clear and radiant skin..Original dove cream for clear and radiant skin..\r\nOriginal dove cream for clear and radiant skin..\r\nOriginal dove cream for clear and radiant skin..', 'dove lotion ', 0, 'Baby:3900:8:10,Adult:4500:7:10', '5:20100', 0, 1, 0, 1, 0, 4.2, 5),
(29, 'Oxi Detergent', '4500.00', '5000.00', 46, '86', '/ecommerce/images/products/Oxi Detergent0.jpg', 'Oxi clean laundry detergent for fast and safe wash.', 'hghhg', 1, 'Adults:4500:0:10,Family:5000:0:10', '5:23000', 0, 0, 0, 1, 0, 0, 0),
(31, 'Skot Roll', '2990.00', '3100.00', 46, '86', '/ecommerce/images/products/Skot Roll0.jpg', 'Skot Toilet original roll..', '', 1, 'Adult:10:6:10', '0:0', 0, 0, 0, 1, 0, 4.7, 3),
(32, 'Nivea Lotion', '3990.00', '4000.00', 44, '87', '/ecommerce/images/products/Nivia Lotion0.jpg', 'Nivea original...', 'Nivea', 1, 'Adult:20:49:12', '2:40', 0, 0, 0, 1, 0, 4, 2),
(33, 'Test', '11.00', '22.00', 46, '81', '/ecommerce/images/products/Test0.jpg,/ecommerce/images/products/Test1.jpg,/ecommerce/images/products/Test2.jpg', 'dffff', '332', 0, 'small:2000:4:10,medium:2000:6:10', '0:0', 0, 1, 0, 0, 0, 0, 0),
(35, 'aatester', '1000.00', '1200.00', 51, '101', '/ecommerce/images/products/aatester0.jpg,/ecommerce/images/products/aatester1.jpg', 'best product giudy', 'johnson soup better', 0, 'small:1000:9:10,large:1500:12:10', '0:0', 0, 0, 0, 1, 0, 0, 0),
(36, 'atest', '1.00', '2.00', 49, '101', '/ecommerce/images/products/atest0.jpg,/ecommerce/images/products/atest1.jpg,/ecommerce/images/products/atest2.png', 'best', 'test', 0, 'q:1:11:11', '1:1', 0, 0, 0, 1, 0, 0, 0),
(37, 'Mega Cremer', '1000.00', '2000.00', 46, '87', '/ecommerce/images/products/test100.png', 'johnson soup better test', 'johnson soup better', 0, 'medium:1000:18:4', '0:0', 0, 1, 0, 1, 0, 4.5, 2),
(38, 'baby T', '3900.00', '4000.00', 46, '101', '/ecommerce/images/products/baby T0.jpg', 'Baby cover dool', 'Baby cover', 0, 'medium:3900:15:10', '0:0', 0, 0, 0, 1, 0, 0, 0),
(39, 'wdd', '11.00', '23.00', 49, '101', '/ecommerce/images/products/wdd4ba66.png', 'hhh', 'hhnn', 0, '1:2:2:2', '0:0', 0, 0, 0, 0, 0, 0, 0),
(40, 'Joy cream', '121.00', '144.00', 49, '120', '/ecommerce/images/products/Joy cream26d8e.jpg,/ecommerce/images/products/Joy cream5ddf2.jpg', 'better lotion and better skin', 'joy', 0, 'small:144:12:10', '0:0', 0, 0, 0, 0, 0, 0, 0),
(47, 'Johnson B', '12.00', '14.00', 46, '120', '/ecommerce/images/products/Johnson B391bf.jpg', 'ghh', 'k', 0, 'g:2:4:4', '0:0', 0, 0, 0, 0, 0, 0, 0),
(48, 'Johnson B', '12.00', '14.00', 46, '120', '/ecommerce/images/products/Johnson B391bf.jpg', 'ghh', 'k', 0, 'g:2:4:4', '0:0', 0, 0, 0, 0, 0, 0, 0),
(49, 'Johnson Bt', '12.00', '14.00', 46, '120', '/ecommerce/images/products/Johnson Bt70c99.jpg', 'ghh', 'k', 0, 'g:2:4:4', '0:0', 0, 0, 0, 0, 0, 0, 0),
(50, 'Johnson Bt', '12.00', '14.00', 46, '120', '/ecommerce/images/products/Johnson Bt70c99.jpg', 'ghh', 'k', 0, 'g:2:4:4', '0:0', 0, 0, 0, 0, 0, 0, 0),
(51, 'Johnson', '12.00', '14.00', 46, '120', '/ecommerce/images/products/Johnson6ccd9.jpg', 'ghh', 'k', 0, 'g:2:4:4', '0:0', 0, 0, 0, 0, 0, 0, 0),
(52, 'Johnson', '12.00', '14.00', 46, '120', '/ecommerce/images/products/Johnson6ccd9.jpg', 'ghh', 'k', 0, 'g:2:4:4', '0:0', 0, 0, 0, 0, 0, 0, 0),
(53, 'Johnson grey', '12.00', '14.00', 46, '120', '/ecommerce/images/products/Johnson grey433d5.jpg', 'ghh', 'k', 0, 'g:2:4:4', '0:0', 0, 0, 0, 0, 0, 0, 0),
(54, 'Johnson grey', '12.00', '111.00', 46, '120', '/ecommerce/images/products/Johnson grey433d5.jpg', 'ghh', 'k', 0, 'g:2:4:4', '0:0', 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE `ranks` (
  `id` int(11) NOT NULL,
  `rank` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`id`, `rank`) VALUES
(1, 'Branch Manager'),
(2, 'CEO'),
(3, 'General Manager'),
(4, 'Editor'),
(6, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `last_updated` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_rating` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `username`, `last_updated`, `product_rating`) VALUES
(20, 'ledi', '2020-07-25 01:03:50', '[{\"product_id\":\"37\",\"rating\":5},{\"product_id\":\"25\",\"rating\":4},{\"product_id\":\"32\",\"rating\":4},{\"product_id\":\"27\",\"rating\":5},{\"product_id\":\"28\",\"rating\":4},{\"product_id\":\"23\",\"rating\":4}]'),
(22, 'godfrey', '2020-07-22 08:44:29', '[{\"product_id\":\"27\",\"rating\":5},{\"product_id\":\"37\",\"rating\":4},{\"product_id\":\"28\",\"rating\":3}]'),
(23, 'Giudy', '2020-07-22 08:48:41', '[{\"product_id\":\"31\",\"rating\":5},{\"product_id\":\"28\",\"rating\":5}]'),
(24, 'peter', '2020-07-22 08:54:56', '[{\"product_id\":\"25\",\"rating\":3},{\"product_id\":\"31\",\"rating\":4},{\"product_id\":\"28\",\"rating\":4}]'),
(25, 'damabel', '2020-07-23 04:57:37', '[{\"product_id\":\"25\",\"rating\":5},{\"product_id\":\"32\",\"rating\":4},{\"product_id\":\"28\",\"rating\":5},{\"product_id\":\"31\",\"rating\":5}]');

-- --------------------------------------------------------

--
-- Table structure for table `secure_customer`
--

CREATE TABLE `secure_customer` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `secure_customer`
--

INSERT INTO `secure_customer` (`user_id`, `user_username`, `user_password`, `user_status`) VALUES
(1, 'test', 'password', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `session_userid` int(10) NOT NULL,
  `session_token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `session_serial` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `session_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `session_userid`, `session_token`, `session_serial`, `session_date`) VALUES
(60, 1, '0gwh4FfjjhGEsKJgKFDgKnn2juGHd3', 'wKW34sSdhjJKjujJdgjKjj2EngGnGg', '');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Company Name',
  `logo` text COLLATE utf8_unicode_ci NOT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `product` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Tel no',
  `slogan` text COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` text COLLATE utf8_unicode_ci NOT NULL,
  `instagram_id` text COLLATE utf8_unicode_ci NOT NULL,
  `twitter_id` text COLLATE utf8_unicode_ci NOT NULL,
  `linkedin_id` text COLLATE utf8_unicode_ci NOT NULL,
  `youtube_id` text COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'dollars',
  `maintenance_status` tinyint(4) NOT NULL DEFAULT '1',
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `logo`, `about`, `product`, `email`, `tel`, `slogan`, `facebook_id`, `instagram_id`, `twitter_id`, `linkedin_id`, `youtube_id`, `currency`, `maintenance_status`, `address`, `city`, `country`) VALUES
(1, 'Xinblet', '/images/headerlogo/logo.jpg', 'gggggg ', 'Xinblet', 'ledi@ameritinz.com', '08064854885', 'Security, Speed and Trust', 'facebook.com', 'instagram.com/damabelg', 'twitter.com', 'linkedin', 'youtube.com', 'dollars', 1, 'Ameritinz Store 1, Rumuola\r\nRumuola', 'Port Harcourt', 'Anguilla');

-- --------------------------------------------------------

--
-- Table structure for table `slide`
--

CREATE TABLE `slide` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `caption` text COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT '0',
  `timer` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slide`
--

INSERT INTO `slide` (`id`, `title`, `caption`, `image`, `url`, `flag`, `timer`, `status`) VALUES
(1, 'black sale', 'sales', '/ecommerce/images/slides/black sale.jpg', 'sales', 0, 0, 0),
(2, 'Oxi Clean', 'OXI CLEAN Now STORE..', '/ecommerce/images/slides/ .jpg', 'oxi', 1, 0, 1),
(3, 'Nivea Deal', ' ', '/ecommerce/images/slides/Nivea Deal.png', 'nivea', 1, 0, 1),
(4, 'Promotion', ' ', '/ecommerce/images/slides/Promotion.jpg', 'sales', 0, 0, 1),
(5, 'new arival', ' ', '/ecommerce/images/slides/new arival.jpg', 'sales', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `photo` text COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `rank` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `username`, `full_name`, `email`, `phone`, `photo`, `password`, `join_date`, `last_login`, `rank`, `permissions`) VALUES
(7, 'BB', 'BB', 'BB@ameritinz.com', '08030987852', '/ecommerce/images/staffs/BB.jpg', '$2y$10$qg6MRKS2WsI9cl7phUKTLeAPWw58pcIgRwaV7ou/d4.3plciejbUy', '2018-09-13 00:00:55', '2018-12-12 22:50:33', 'IT Manager', 'pro,admin,editor,staff'),
(14, 'damabel', 'Godfrey D. Damabel ', 'godfrey@ameritinz.com', '08030342243', '/ecommerce/images/staffs/damabel.jpg', '$2y$10$8uhmFGaHCEfF286ajMluUu2.w55ZipCE/.HqWRsOqnLEKaNtQgRC6', '2018-09-20 21:17:40', '2018-11-21 23:50:19', 'Auditor', 'staff'),
(16, 'ledi', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342243', '/ecommerce/images/staffs/949bf5da38.jpg', '$2y$10$egh1g4Lk8p3jGp3xzvotjOHgBC02wxJ.B6ySwVIf3IkQiWDOqyGE2', '2018-10-26 13:50:29', '2018-12-21 11:51:30', 'General Manager', 'admin,editor,staff'),
(19, 'test', 'test tester', 'test@ameritinz.com', '08030932109', '/ecommerce/images/staffs/test.jpg', '$2y$10$FgbnqsRb6Ykt7DLrV3OcZOLMH/ATYHfDRA5fbpoFYKbwrMaNAyIki', '2018-12-02 02:39:50', '0000-00-00 00:00:00', 'General Manager', 'editor,staff'),
(21, 'ecommerce1.jpg', 'ecommerce1.jpg', 'new@test.com', '08030932109', '/ecommerce/images/staffs/ecommerce1.jpg.jpg', '$2y$10$OHYrM4KbuuSxJYRb0XPLUe.xn5/2ADbT4bFZqDRM/MyFeo9E2HB9u', '2019-07-23 03:48:32', '0000-00-00 00:00:00', 'Marketing Manager', 'admin,editor,staff'),
(22, 'ledi@ameritinz.com', 'Aminus', 'ledin@ameritinz.com', '08030932109', '/ecommerce/images/staffs/ledi@ameritinz.com.jpg', '$2y$10$cbMFMis4SvmWZMN741YVl.CYyfSqM2I8lJaH4K18nHROSLdK73J9a', '2019-07-23 03:58:16', '0000-00-00 00:00:00', 'Sale Rep', 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `charge_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cart_id` varchar(21) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `tax` decimal(10,0) NOT NULL,
  `discount` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `grand_total` decimal(10,0) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `txn_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txn_date` datetime NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Not Complete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `charge_id`, `cart_id`, `full_name`, `email`, `phone`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `items`, `sub_total`, `tax`, `discount`, `grand_total`, `description`, `txn_type`, `txn_date`, `status`) VALUES
(75, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '10900', '0', '', '10900', '4 items from Ameritinz Supermart', 'cash', '2018-11-20 00:47:33', 'Complete'),
(76, 'cashhWcHpx3ljSXrUS9', '195', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"16\",\"price\":\"3000\",\"size\":\"Family\",\"quantity\":2,\"request\":\"\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":1,\"request\":\"\"}]', '8000', '0', '', '8000', '3 items from Ameritinz Supermart', 'cash', '2018-11-20 22:47:10', 'Complete'),
(78, 'posk4232pbR21BWQC5', '203', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":2,\"request\":\"\"}]', '8000', '0', '', '8000', '2 items from Ameritinz Supermart', 'pos', '2018-11-21 14:06:31', 'Complete'),
(79, 'cashCg9NTZ25MVNhfVz', '217', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"24\",\"price\":\"4900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '8750', '0', '', '8750', '3 items from Ameritinz Supermart', 'cash', '2018-11-26 10:06:19', 'Complete'),
(80, 'cashTjPbsDzRgpw8vF4', '218', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"21\",\"price\":\"3900\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\"}]', '3900', '0', '', '3900', '1 item from Ameritinz Supermart', 'cash', '2018-11-26 10:09:41', 'Complete'),
(81, 'cashyzR6v4KP51l4279', '219', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"5\",\"request\":\"\"}]', '14500', '0', '', '14500', '5 items from Ameritinz Supermart', 'cash', '2018-11-30 10:56:19', 'Complete'),
(82, 'poschg0zSn4DGBPLM6', '223', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":1,\"request\":\"\"}]', '2000', '0', '', '2000', '1 item from Ameritinz Supermart', 'pos', '2018-12-03 01:34:32', 'Complete'),
(83, 'posDPKvpyhcLv0rFwc', '230', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"25\",\"price\":\"2500\",\"size\":\"medium\",\"quantity\":\"2\",\"request\":\"Mild fragrance \"},{\"id\":\"25\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"Mild Fragrance. \"}]', '7000', '0', '', '7000', '3 items from Ameritinz Supermart', 'pos', '2018-12-11 20:04:24', 'Complete'),
(84, 'pos2TvnJM5xbmRjTWC', '251', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"29\",\"price\":\"5000\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"}]', '7900', '0', '', '7900', '2 items from Ameritinz Supermart', 'pos', '2019-01-01 19:49:14', 'Complete'),
(85, 'posWtm4mhfWl7Mr4tv', '253', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '2900', '0', '', '2900', '1 item from Ameritinz Supermart', 'pos', '2019-01-04 10:34:14', 'Complete'),
(86, 'cash2LFczjGjP5S95WC', '254', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"18\",\"price\":\"1900\",\"size\":\"20Pieces\",\"quantity\":\"1\",\"request\":\"\"}]', '1900', '0', '', '1900', '1 item from Ameritinz Supermart', 'cash', '2019-01-04 10:50:44', 'Complete'),
(87, 'posz5Mq9kyPxCR4Cky', '255', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '2900', '0', '', '2900', '1 item from Ameritinz Supermart', 'pos', '2019-01-04 11:18:43', 'Complete'),
(88, 'pos2WWqplWyDPfRULf', '298', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '', '4500', '0', '', '4500', '1 item from Ameritinz Supermart', 'pos', '2019-01-11 15:31:08', 'Complete'),
(89, 'posCdpwHMtD1VdB9L3', '381', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"26\",\"price\":\"4900\",\"size\":\"100mg\",\"quantity\":2,\"request\":\"\"}]', '9800', '0', '', '9800', '2 items from Ameritinz Supermart', 'pos', '2019-01-18 18:51:21', 'Complete'),
(90, 'ch_1Dx1KNH16GOmvPiGAQQzrdqo', '389', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '2900', '0', '', '2900', '1 item from Ameritinz Supermart', 'charge', '2019-01-27 01:16:47', 'Complete'),
(91, 'cashCMWLkwLN6t', '390', 'Ledi Damabel', 'ledi@ameritinz.com', '0803093210', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"18\",\"price\":\"1900\",\"size\":\"Family\",\"quantity\":\"2\",\"request\":\"\"}]', '3800', '0', '', '3800', '2 items from Ameritinz Supermart', 'cash', '2019-01-30 16:29:13', 'Complete'),
(92, 'ch_1DykKsH16GOmvPiGWREAynnI', '391', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '2900', '0', '', '2900', '1 item from Ameritinz Supermart', 'charge', '2019-01-31 19:32:26', 'Complete'),
(93, 'poskDHXVfHqmQ', '393', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"2\",\"request\":\"\"}]', '5800', '0', '', '5800', '2 items from Ameritinz Supermart', 'pos', '2019-02-15 04:50:38', 'Complete'),
(94, 'poscnbUbHVJG0', '396', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"23\",\"price\":\"2900\",\"size\":\"Saver\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":1,\"request\":\"\"}]', '7400', '0', '', '7400', '2 items from Ameritinz Supermart', 'pos', '2019-02-20 16:09:36', 'Complete'),
(95, 'ch_1E7mnOH16GOmvPiGKaIGkPHx', '402', ' Damabel', 'ledi2@ameritinz.com', '08030932109', 'Ameritinz Store 1, Rumuola', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":\"1\",\"request\":\"\"}]', '4500', '0', '', '4500', '1 item from Ameritinz Supermart', 'charge', '2019-02-25 17:59:11', 'Complete'),
(96, 'posHX1jFprDVy', '401', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"36\",\"price\":\"1\",\"size\":\"q\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"23\",\"price\":\"2900\",\"size\":\"Saver\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":1,\"request\":\"\"}]', '5801', '0', '', '5801', '3 items from Ameritinz Supermart', 'pos', '2019-04-13 18:22:18', 'Complete'),
(97, 'cash9bxq6vUWpw', '408', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"22\",\"price\":\"3900\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"26\",\"price\":\"4900\",\"size\":\"100mg\",\"quantity\":1,\"request\":\"\"}]', '8800', '0', '', '8800', '2 items from Ameritinz Supermart', 'cash', '2018-04-05 19:38:40', 'Not Complete'),
(98, 'cashp0zR3WwpLb', '410', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"2\",\"request\":\"\"},{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":\"1\",\"request\":\"\"}]', '6400', '0', '', '6400', '3 items from Ameritinz Supermart', 'cash', '2019-07-23 00:47:39', 'Not Complete'),
(99, 'posfdbw4Qjj1Z', '411', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"22\",\"price\":\"3900\",\"size\":\"Adult\",\"quantity\":\"2\",\"request\":\"\"},{\"id\":\"25\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":\"3\",\"request\":\"\"},{\"id\":\"28\",\"price\":\"3900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"}]', '17700', '0', '', '17700', '6 items from Ameritinz Supermart', 'pos', '2019-07-23 02:25:16', 'Complete'),
(100, 'ch_1E7mnOH16GOmvPiGKaIGkPHx', '402', ' Damabel', 'ledi2@ameritinz.com', '08030932109', 'Ameritinz Store 1, Rumuola', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":\"1\",\"request\":\"\"}]', '4500', '0', '', '4500', '1 item from Ameritinz Supermart', 'charge', '2018-02-25 17:59:11', 'Complete'),
(101, 'poschg0zSn4DGBPLM6', '223', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":1,\"request\":\"\"}]', '3500', '0', '', '3500', '1 item from Ameritinz Supermart', 'pos', '2019-05-03 01:34:32', 'Complete'),
(102, 'posHX1jFprDVy', '401', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"36\",\"price\":\"1\",\"size\":\"q\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"23\",\"price\":\"2900\",\"size\":\"Saver\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":1,\"request\":\"\"}]', '4801', '0', '', '4801', '3 items from Ameritinz Supermart', 'pos', '2019-05-13 18:22:18', 'Complete'),
(103, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '8900', '0', '', '8900', '4 items from Ameritinz Supermart', 'cash', '2019-05-20 00:47:33', 'Complete'),
(104, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '8900', '0', '', '8900', '4 items from Ameritinz Supermart', 'cash', '2018-03-20 00:47:33', 'Complete'),
(105, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '6500', '0', '', '6500', '4 items from Ameritinz Supermart', 'cash', '2018-04-20 00:47:33', 'Complete'),
(106, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '3500', '0', '', '3500', '4 items from Ameritinz Supermart', 'cash', '2018-05-20 00:47:33', 'Complete'),
(107, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '4100', '0', '', '4100', '4 items from Ameritinz Supermart', 'cash', '2018-06-20 00:47:33', 'Complete'),
(108, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '7200', '0', '', '7200', '4 items from Ameritinz Supermart', 'cash', '2018-07-20 00:47:33', 'Complete'),
(109, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '8200', '0', '', '8200', '4 items from Ameritinz Supermart', 'cash', '2018-08-20 00:47:33', 'Complete'),
(110, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '5200', '0', '', '5200', '4 items from Ameritinz Supermart', 'cash', '2018-09-20 00:47:33', 'Complete'),
(111, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '6900', '0', '', '6900', '4 items from Ameritinz Supermart', 'cash', '2018-10-20 00:47:33', 'Complete'),
(112, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '8700', '0', '', '8700', '4 items from Ameritinz Supermart', 'cash', '2018-01-20 00:47:33', 'Complete'),
(113, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '8700', '0', '', '8700', '4 items from Ameritinz Supermart', 'cash', '2019-03-20 00:47:33', 'Complete'),
(114, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '4800', '0', '', '4800', '4 items from Ameritinz Supermart', 'cash', '2019-06-20 00:47:33', 'Complete'),
(115, 'poschg0zSn4DGBPLM6', '223', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":1,\"request\":\"\"}]', '2000', '0', '', '2000', '1 item from Ameritinz Supermart', 'charge', '2019-05-03 01:34:32', 'Complete'),
(116, 'cashCg9NTZ25MVNhfVz', '217', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"24\",\"price\":\"4900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '8750', '0', '', '8750', '3 items from Ameritinz Supermart', 'pos', '2018-07-26 10:06:19', 'Complete'),
(117, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '10900', '0', '', '10900', '4 items from Ameritinz Supermart', 'charge', '2019-06-20 00:47:33', 'Complete'),
(118, 'cashCg9NTZ25MVNhfVz', '217', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"24\",\"price\":\"4900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '4750', '0', '', '4750', '3 items from Ameritinz Supermart', 'charge', '2019-07-26 10:06:19', 'Complete'),
(119, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '10900', '0', '', '10900', '4 items from Ameritinz Supermart', 'cash', '2019-02-20 00:47:33', 'Complete'),
(120, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '10900', '0', '', '10900', '4 items from Ameritinz Supermart', 'charge', '2019-03-20 00:47:33', 'Complete'),
(121, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '10900', '0', '', '7900', '4 items from Ameritinz Supermart', 'pos', '2019-03-20 00:47:33', 'Complete'),
(122, 'cashTjPbsDzRgpw8vF4', '218', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"21\",\"price\":\"3900\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\"}]', '3900', '0', '', '3900', '1 item from Ameritinz Supermart', 'pos', '2019-07-26 10:09:41', 'Complete'),
(123, 'posCdpwHMtD1VdB9L3', '381', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"26\",\"price\":\"4900\",\"size\":\"100mg\",\"quantity\":2,\"request\":\"\"}]', '9800', '0', '', '9800', '2 items from Ameritinz Supermart', 'charge', '2019-07-18 18:51:21', 'Complete'),
(124, 'cashCg9NTZ25MVNhfVz', '217', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"24\",\"price\":\"4900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '8750', '0', '', '8750', '3 items from Ameritinz Supermart', 'pos', '2018-07-26 10:06:19', 'Complete'),
(125, 'cashCg9NTZ25MVNhfVz', '217', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"24\",\"price\":\"4900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '8750', '0', '', '8750', '3 items from Ameritinz Supermart', 'pos', '2019-07-26 10:06:19', 'Complete'),
(126, 'cashCg9NTZ25MVNhfVz', '217', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"24\",\"price\":\"4900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '8750', '0', '', '8750', '3 items from Ameritinz Supermart', 'pos', '2019-06-26 10:06:19', 'Complete'),
(127, 'poschg0zSn4DGBPLM6', '223', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":1,\"request\":\"\"}]', '2000', '0', '', '2000', '1 item from Ameritinz Supermart', 'cash', '2019-03-03 01:34:32', 'Complete'),
(128, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":\"1\",\"request\":\"beter\"},{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":2,\"request\":\"\"},{\"id\":\"14\",\"price\":\"2900\",\"size\":\"small\",\"quantity\":\"1\",\"request\":\"\"}]', '10900', '0', '', '10900', '4 items from Ameritinz Supermart', 'cash', '2019-03-20 00:47:33', 'Complete'),
(129, 'cashCg9NTZ25MVNhfVz', '217', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"24\",\"price\":\"4900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '12550', '1000', '', '11550', '3 items from Ameritinz Supermart', 'online', '2019-03-26 10:06:19', 'Complete'),
(130, 'cashCg9NTZ25MVNhfVz', '217', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"24\",\"price\":\"4900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\"},{\"id\":\"15\",\"price\":\"2900\",\"size\":\"80mg\",\"quantity\":\"1\",\"request\":\"\"}]', '12550', '1000', '', '11550', '3 items from Ameritinz Supermart', 'online', '2019-04-26 10:06:19', 'Complete'),
(131, 'cashp0zR3WwpLb', '410', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"17\",\"price\":\"950\",\"size\":\"Family\",\"quantity\":\"2\",\"request\":\"\"},{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":\"1\",\"request\":\"\"}]', '6400', '0', '', '6400', '3 items from Ameritinz Supermart', 'cash', '2019-04-23 00:47:39', 'Not Complete'),
(132, 'posk4232pbR21BWQC5', '203', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":2,\"request\":\"\"}]', '8000', '0', '', '8000', '2 items from Ameritinz Supermart', 'online', '2019-04-21 14:06:31', 'Complete'),
(133, 'posk4232pbR21BWQC5', '203', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"14\",\"price\":\"4000\",\"size\":\"medium\",\"quantity\":2,\"request\":\"\"}]', '8000', '0', '', '8000', '2 items from Ameritinz Supermart', 'charge', '2019-04-21 14:06:31', 'Complete'),
(134, 'poschg0zSn4DGBPLM6', '223', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":1,\"request\":\"\"}]', '2000', '0', '', '2000', '1 item from Ameritinz Supermart', 'cash', '2019-03-03 01:34:32', 'Complete'),
(135, 'poschg0zSn4DGBPLM6', '223', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"20\",\"price\":\"2000\",\"size\":\"small\",\"quantity\":1,\"request\":\"\"}]', '2000', '0', '', '2000', '1 item from Ameritinz Supermart', 'cash', '2019-05-03 01:34:32', 'Complete'),
(136, 'pos2QrUdDPl3h', '413', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"28\",\"price\":\"4500\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"10\"}]', '4050', '0', '', '4050', '1 item from Ameritinz Supermart', 'pos', '2019-08-03 01:04:34', 'Not Complete'),
(137, 'poscFLvKfUqQn', '417', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"22\",\"price\":\"3900\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '3900', '0', '', '1950', '1 item from Ameritinz Supermart', 'pos', '2019-08-06 00:42:26', 'Not Complete'),
(138, 'cashMpnU8kpKM0', '420', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"32\",\"price\":\"20\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"},{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '4520', '0', '2260', '2260', '2 items from Ameritinz Supermart', 'cash', '2019-08-06 01:02:09', 'Not Complete'),
(139, 'posXH6RMDrBZ7', '421', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"28\",\"price\":\"3900\",\"size\":\"Baby\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"10\"},{\"id\":\"16\",\"price\":\"3000\",\"size\":\"Family\",\"quantity\":2,\"request\":\"\",\"discount\":\"0\"}]', '9510', '0', '190.2', '9320', '3 itemsfromXinblet', 'pos', '2019-08-06 01:50:48', 'Not Complete'),
(140, 'posSGqVvQBZN6', '423', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342222', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{\"id\":\"32\",\"price\":\"20\",\"size\":\"Adult\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"0\"}]', '20', '0', '2.4', '18', '1 itemfromXinblet', 'pos', '2019-08-06 02:33:46', 'Not Complete');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `username`, `items`, `expire_date`) VALUES
(3, 'ledi', '[{\"id\":\"16\",\"price\":\"3000\",\"size\":\"Family\",\"quantity\":\"1\",\"request\":\"\",\"discount\":\"\"},{\"id\":\"29\",\"price\":\"4500\",\"size\":\"Adults\",\"quantity\":\"1\",\"request\":\"\"}]', '2019-09-27 23:21:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appearance`
--
ALTER TABLE `appearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `customer_user`
--
ALTER TABLE `customer_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secure_customer`
--
ALTER TABLE `secure_customer`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
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
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `appearance`
--
ALTER TABLE `appearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=439;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customer_user`
--
ALTER TABLE `customer_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `ranks`
--
ALTER TABLE `ranks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `secure_customer`
--
ALTER TABLE `secure_customer`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
