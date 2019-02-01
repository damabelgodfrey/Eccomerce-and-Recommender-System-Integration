-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql100.byetcluster.com
-- Generation Time: Jan 27, 2019 at 05:35 PM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `epiz_23341668_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=53 ;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(41, 'PERKINS'),
(44, 'NIVEA'),
(45, 'JOY'),
(46, 'Ameritinz Special'),
(49, 'Damabel'),
(51, 'Dove'),
(52, 'Adidas');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` tinyint(4) NOT NULL DEFAULT '0',
  `exp_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=411 ;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `username`, `items`, `expire_date`, `paid`, `shipped`, `exp_time`) VALUES
(157, 'ledi', '[{"id":"14","price":"4000","size":"medium","quantity":"1","request":"beter"},{"id":"20","price":"2000","size":"small","quantity":2,"request":""},{"id":"14","price":"2900","size":"small","quantity":"1","request":""}]', '2018-12-20 01:47:19', 1, 1, 0),
(195, 'ledi', '[{"id":"16","price":"3000","size":"Family","quantity":2,"request":""},{"id":"20","price":"2000","size":"small","quantity":1,"request":""}]', '2018-12-20 23:46:49', 1, 1, 0),
(202, 'BB', '[{"id":"14","price":"2900","size":"small","quantity":4,"request":""}]', '2018-12-21 02:24:05', 1, 0, 0),
(203, 'ledi', '[{"id":"14","price":"4000","size":"medium","quantity":2,"request":""}]', '2018-12-21 14:03:34', 1, 1, 0),
(217, 'ledi', '[{"id":"24","price":"4900","size":"Baby","quantity":"1","request":""},{"id":"17","price":"950","size":"Family","quantity":"1","request":""},{"id":"15","price":"2900","size":"80mg","quantity":"1","request":""}]', '2018-12-26 10:06:08', 1, 0, 0),
(218, 'ledi', '[{"id":"21","price":"3900","size":"Adult","quantity":"1","request":""}]', '2018-12-26 10:08:34', 1, 1, 0),
(219, 'ledi', '[{"id":"14","price":"2900","size":"small","quantity":"5","request":""}]', '2018-12-30 10:50:31', 1, 1, 0),
(223, 'ledi', '[{"id":"20","price":"2000","size":"small","quantity":1,"request":""}]', '2019-01-02 01:27:55', 1, 1, 0),
(230, 'ledi', '[{"id":"25","price":"2500","size":"medium","quantity":"2","request":"Mild fragrance "},{"id":"25","price":"2000","size":"small","quantity":"1","request":"Mild Fragrance. "}]', '2019-01-10 20:03:46', 1, 1, 0),
(251, 'ledi', '[{"id":"14","price":"2900","size":"small","quantity":"1","request":""},{"id":"29","price":"5000","size":"Family","quantity":"1","request":""}]', '2019-01-31 19:43:58', 1, 1, 1546368238),
(253, 'ledi', '[{"id":"15","price":"2900","size":"80mg","quantity":"1","request":""}]', '2019-02-03 10:26:30', 1, 0, 1546593990),
(254, 'ledi', '[{"id":"18","price":"1900","size":"20Pieces","quantity":"1","request":""}]', '2019-02-03 10:40:06', 1, 1, 1546594806),
(388, 'ledi', '[{"id":"14","price":"2900","size":"small","quantity":"1","request":""}]', '2019-02-23 10:03:41', 1, 1, 1548342221),
(399, 'ledi', '[{"id":"29","price":"4500","size":"Adults","quantity":1,"request":""}]', '2019-02-24 12:40:06', 1, 0, 1548438006),
(407, 'Universe', '[{"id":"18","price":"1900","size":"Family","quantity":4,"request":""},{"id":"44","price":"6900","size":"UK 9","quantity":2,"request":""}]', '2019-02-25 13:01:35', 1, 1, 1548525695),
(406, 'ledi', '[{"id":"47","price":"14900","size":"Special","quantity":"1","request":""}]', '2019-02-25 19:28:00', 1, 0, 1548548880),
(404, 'Universe', '[{"id":"38","price":"3900","size":"medium","quantity":"1","request":""}]', '2019-02-24 19:52:04', 1, 1, 1548463924),
(408, 'CEO', '[{"id":"14","price":"2900","size":"small","quantity":1,"request":""}]', '2019-02-25 13:06:21', 0, 0, 1548525981),
(410, 'ledi', '[{"id":"32","price":"20","size":"Adult","quantity":"1","request":""}]', '2019-02-25 19:42:19', 0, 0, 1548549739);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=107 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(102, 'NEWLINE', 0),
(2, 'WOMEN', 0),
(106, 'Variety', 102),
(75, 'Gist Set', 2),
(76, 'Body Wash', 2),
(77, 'MEN', 0),
(78, 'Spray', 77),
(82, 'Cream', 2),
(83, 'Beauty Bar', 2),
(84, 'Deodorant', 2),
(85, 'Deodorant', 77),
(86, 'Beauty Bar', 77),
(87, 'Cream', 77),
(88, 'Body Wash', 77),
(95, 'BABIES', 0),
(100, 'Toiletries', 2),
(101, 'Unisex', 95);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

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

CREATE TABLE IF NOT EXISTS `customer_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `permissions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `customer_user`
--

INSERT INTO `customer_user` (`id`, `username`, `full_name`, `email`, `password`, `phone`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `join_date`, `last_login`, `permissions`) VALUES
(5, 'peter', 'Peter customer', 'peter@gmail.com', '$2y$10$XWs5fJNiU8IbpIOp30WgK.Y3Bv8j5UvWU52Rc1EIouakwwmAy5qp.', '08030342243', 'AIT Road', 'Chioba', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '2018-11-02 10:32:32', '2019-01-25 13:10:26', 'customer'),
(6, 'ledi', 'Ledi Damabel', 'ledi@ameritinz.com', '$2y$10$zuq8gWILCsvh2blsjlRRxOyyDBaJPg.NZ1uibbKEjW1ep6Qxgjx8a', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '2018-11-02 10:41:49', '2019-01-27 15:58:01', 'admin,editor,staff'),
(7, '', 'James customer', 'james@gmail.com', '$2y$10$16G27br6fcZQi30DzXaPyuRDUkDfCn2hScDuZ1f9e3dUa7OF9RbLy', '0', '', '', '', '', '', '', '2018-11-02 13:42:51', '2019-01-24 11:33:13', 'customer'),
(8, '', 'dumbor andrew', 'dumbor@gmail.com', '$2y$10$kJh6i2fGTpMRLZ7WmJl6Zusbvv94yDwR0fys3hRT8j0R1naE.7p5G', '0', '', '', '', '', '', '', '2018-11-03 20:19:16', '2019-01-24 11:33:13', 'customer'),
(13, 'CEO', 'CEO BB', 'bb@ameritinz.com', '$2y$10$.XmZhnDJN7RulIM1HioeEOpkkInsIl4e9kXsb8cl5BXEBcbPtIcp.', '08030342243', '55 milton avenue', '', 'London', 'LONDON ', 'Nw10 8pl', 'LONDON', '2019-01-24 12:18:01', '2019-01-26 15:11:15', 'pro,admin,editor,staff'),
(10, 'Customer', 'Customer View', 'view@customer.com', '$2y$10$ljIC7/KfVgteMJ7S5kwnV.mQq457S9B.y1T0ZIP4LKacpdqGN8nPK', '08030342243', 'GRA', 'Estate', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '2018-11-04 14:03:49', '2019-01-24 11:33:13', 'customer'),
(11, 'damabel', 'Damabel James', 'damabel@ameritinz.com', '$2y$10$8Opb7nj4hUMYtIfG8Oza1OpeQn.63Ssm.EF1IihsNe04L9D2mVQZ.', '08030932109', '', '', '', '', '', '', '2018-11-18 21:07:43', '2018-12-25 01:09:38', 'admin,editor,staff'),
(12, 'Universe', 'Test Universe', 'universe@test.com', '$2y$10$1dz6OfaYCHRMh.3NGUL0F.wdXZ7/c2p/wu6lYEsWsGuf5jZbENbju', '08030932488', 'Verily Avenue Phase 1', 'Nigeria ', 'Lagos', 'Lagos', '234', 'Nigeria', '2018-12-10 22:26:04', '2019-01-26 12:52:39', 'editor,staff');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission`) VALUES
(1, 'staff'),
(2, 'editor,staff'),
(3, 'admin,editor,staff'),
(4, 'pro,admin,editor,staff'),
(5, 'customer'),
(6, 'Supreme,pro,admin,editor');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=50 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `p_keyword`, `featured`, `sizes`, `sold`, `archive`, `sales`, `defective_product`) VALUES
(13, 'Cetaphil', '2900.00', '3001.00', 46, '87', '/ecommerce/images/products/Cetaphil0.jpg', 'special beauty cream for all.. blemish removal..', 'cetaphil', 0, 'medium:2900:3:5,large:3200:5:5', '0:0', 0, 0, 0),
(14, ' Garnier Blend', '1000.00', '2200.00', 49, '75', '/ecommerce/images/products/Johnson Bar10.jpg,/ecommerce/images/products/Johnson Bar11.jpg', 'Garnier whole blend', 'Garnier whole blend', 1, 'small:2900:9:10,medium:4000:3:10', '23:74800', 0, 1, 0),
(15, 'Suave kid', '2900.00', '3000.00', 46, '101', '/ecommerce/images/products/Suave kid0.jpg', '&lt;p&gt;Gentle on skin.. baby &lt;strong&gt;product&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', 'jj', 0, '80mg:2900:13:9', '113:8700', 0, 0, 0),
(16, 'Eucerin lotion', '3000.00', '3500.00', 46, '87', '/ecommerce/images/products/Eucerin lotion0.jpg', 'care lotion for best skin', 'Intensive care lotion for best skin', 0, 'Family:3000:5:10', '2:6000', 0, 0, 0),
(17, 'Crest Toothpaste', '950.00', '1000.00', 46, '101', '/ecommerce/images/products/Crete Toothpaste0.jpg', 'Oral B and Crete toothpaste. Brighter teeth and clean breath', 'toothpaste month wash', 0, 'Family:950:2:10', '1:950', 0, 0, 0),
(18, 'Maxi Pad', '1900.00', '2000.00', 46, '106', '/ecommerce/images/products/Alway Maxi Pad0.jpg', 'Stay save and free with Always Maxi sanitary pad.', 'pad protection sanitary', 0, 'Family:1900:4:10', '5:9500', 0, 1, 0),
(19, 'Olay Special', '4900.00', '5000.00', 44, '106', '/ecommerce/images/products/Olay Special0.jpg,/ecommerce/images/products/Olay Special1.jpg,/ecommerce/images/products/Olay Special2.jpg', 'Olay original with extra-ordinary sheer butter. Brighter and healthy skin for everyday glow', 'Olay', 0, 'Adult:4900:3:20', '0:0', 0, 0, 0),
(20, 'ST Ives', '3900.00', '4000.00', 44, '82', '/ecommerce/images/products/ST Ives1.jpg', 'St Ives original lotion for clear skin and remove blemish replacing with radiant skin..', 'st ive smooth', 0, 'small:2000:5:10,medium:2000:14:10', '5:11900', 0, 0, 0),
(21, 'Tresemme', '3900.00', '4000.00', 46, '87', '/ecommerce/images/products/Tresemme0.jpg,/ecommerce/images/products/Tresemme1.jpg', 'Tresemme superior product. Hurry for a try today...', '', 1, 'Adult:3900:38:10', '1:3900', 0, 0, 0),
(22, 'ST Ives Hyd..', '3900.00', '4000.00', 46, '82', '/ecommerce/images/products/ST Ives Hyd..0.jpg', 'ST Ives hydrating product for better result on skin.', 'hydrated', 0, 'Adult:3900:10:20', '0:0', 0, 1, 0),
(23, 'Huggies Pampers', '2900.00', '3000.00', 49, '106', '/ecommerce/images/products/Huggies Pampers0.jpg', 'Original US brand pampers by Huggies..Comfort guarantee for your baby.', 'pampers', 0, 'Saver:2900:15:10,Family:4000:12:10', '0:0', 0, 0, 0),
(24, 'Huggies Snugglers', '4900.00', '5000.00', 46, '101', '/ecommerce/images/products/Huggies Snugglers0.jpg', 'Huggies original Snugglers for your baby.', 'Huggies', 0, 'Baby:4900:12:20', '1:4900', 0, 0, 0),
(25, 'Garnier blend', '2900.00', '3000.00', 46, '87', '/ecommerce/images/products/Garnier blend0.jpg', 'original US Garnier whole blend..', 'blend', 0, 'small:2000:4:10,medium:2500:21:10', '3:7000', 0, 1, 0),
(26, 'Paris Rose', '3000.00', '4000.00', 46, '76', '/ecommerce/images/products/Paris Rose0.jpg', 'Paris Rose clear gel secret..', 'paris', 0, '100mg:4900:3:10,20mg:3000:2:10', '7:32400', 0, 0, 0),
(27, 'Mitchum Dry', '3900.00', '4000.00', 46, '85', '/ecommerce/images/products/Mitchum Dry0.jpg', 'Stay fresh and sexy with original Mitchum US product.', 'Mitchum', 0, 'Adult:3900:2:9,Family:3200:4:10', '0:0', 0, 1, 0),
(28, 'Dove Lotion', '3900.00', '4000.00', 51, '87', '/ecommerce/images/products/Dove Lotion0.jpg,/ecommerce/images/products/Dove Lotion1.jpg,/ecommerce/images/products/Dove Lotion2.jpg', 'Original dove cream for clear and radiant skin..Original dove cream for clear and radiant skin..\r\nOriginal dove cream for clear and radiant skin..\r\nOriginal dove cream for clear and radiant skin..', 'dove lotion ', 0, 'Baby:3900:49:10,Adult:4500:40:10', '0:0', 0, 1, 0),
(29, 'Oxi Detergent', '4500.00', '5000.00', 46, '86', '/ecommerce/images/products/Oxi Detergent0.jpg', 'Oxi clean laundry detergent for fast and safe wash.', 'hghhg', 1, 'Adults:4500:3:10,Family:5000:1:10', '6:27500', 0, 0, 0),
(31, 'Skot Roll', '2990.00', '3100.00', 46, '86', '/ecommerce/images/products/Skot Roll0.jpg', 'Skot Toilet original roll..', '', 1, 'Adult:10:8:10', '0:0', 0, 0, 0),
(32, 'Nivea Lotion', '3990.00', '4000.00', 44, '87', '/ecommerce/images/products/Nivia Lotion0.jpg', 'Nivea original...', 'Nivea', 1, 'Adult:20:3:12', '0:0', 0, 0, 0),
(33, 'Test', '2000.00', '2500.00', 46, '106', '/ecommerce/images/products/Test48b75.jpg,/ecommerce/images/products/Testee22a.jpg,/ecommerce/images/products/Test9762c.jpg,/ecommerce/images/products/Testc3dfd.jpg,/ecommerce/images/products/Test45b28.jpg/ecommerce/images/products/Testae47a.jpg,/ecommerce/images/products/Test1ecba.jpg,/ecommerce/images/products/Teste8d5f.jpg,/ecommerce/images/products/Test21d1f.jpg,/ecommerce/images/products/Test7fe33.jpg,/ecommerce/images/products/Test78574.jpg', 'Testing product for multiple size, image and product availability and price for each size.', 'Testing feature', 0, 'small:2000:25:10,medium:3000:6:10,Large:4200:0:12', '0:0', 0, 1, 0),
(35, 'Tone', '1000.00', '1200.00', 51, '101', '/ecommerce/images/products/aatester0.jpg,/ecommerce/images/products/aatester1.jpg', 'best product giudy', 'johnson soup better', 0, 'small:1000:9:10,large:1500:12:10', '0:0', 0, 0, 0),
(36, 'atest', '1.00', '2.00', 49, '101', '/ecommerce/images/products/atest0.jpg,/ecommerce/images/products/atest1.jpg,/ecommerce/images/products/atest2.png', 'best', 'test', 0, 'q:1:12:11', '0:0', 0, 0, 0),
(37, 'Mega Cremer', '1000.00', '2000.00', 46, '87', '/ecommerce/images/products/test100.png', 'johnson soup better test', 'johnson soup better', 0, 'm:1000:0:4', '0:0', 0, 1, 0),
(38, 'baby T', '3900.00', '4000.00', 46, '101', '/ecommerce/images/products/baby T0.jpg', 'Baby cover dool', 'Baby cover', 0, 'medium:3900:15:10', '1:3900', 0, 0, 0),
(39, 'Maxi Dress', '3800.00', '4000.00', 46, '106', '/ecommerce/images/products/Maxi Dress0.jpg,/ecommerce/images/products/Maxi Dress1.jpg', 'DESIGN Curve shirred bustier maxi dress with puff sleeve in animal print', 'Leopard print Maxi dress', 0, 'UK 9:3900:25:10,UK 12:3900:25:10', '0:0', 0, 0, 0),
(40, 'Midi Dress', '6900.00', '7000.00', 49, '106', '/ecommerce/images/products/Midi Dress0.jpg,/ecommerce/images/products/Midi Dress1.jpg', 'DESIGN Curve kimono midi pencil dress in satin floral embroidery', 'Pale green midi dress', 0, 'UK 12:4900:40:10,UK 14:4900:5:10', '0:0', 0, 0, 0),
(41, 'Badot mini', '6000.00', '6500.00', 46, '106', '/ecommerce/images/products/Badot mini0.jpg,/ecommerce/images/products/Badot mini1.jpg', 'Navy/Red Wild Honey bardot mini dress in check.', 'Navy/red check mini dress', 0, 'UK 6:6000:5:10,UK 8:6000:25:10,UK 10:6000:0:10', '0:0', 0, 0, 0),
(42, 'Trainers', '11900.00', '12000.00', 52, '106', '/ecommerce/images/products/Trainers0.jpg,/ecommerce/images/products/Trainers1.jpg', 'Adidas Originals grey and white Gazelle trainers...Adidas Originals grey and white Gazelle trainers.', 'Grey Adidas trainers ', 0, 'UK 9:11900:24:12,UK 12:12900:5:12', '0:0', 0, 0, 0),
(43, 'POD Trainer', '15900.00', '16000.00', 52, '106', '/ecommerce/images/products/POD Trainer0.jpg,/ecommerce/images/products/POD Trainer1.jpg', 'Adidas Originals black and white POD trainers', 'POD Trainers adidas', 0, 'UK 8:15900:23:12,UK 10:15900:23:12', '0:0', 0, 0, 0),
(44, 'T-shirt', '6900.00', '7000.00', 49, '106', '/ecommerce/images/products/T-shirt0.jpg,/ecommerce/images/products/T-shirt1.jpg', 'New Look oversized long sleeve cuff t-shirt in grey stripe', 'New look long sleeve', 0, 'UK 9:6900:39:10', '2:13800', 0, 0, 0),
(45, 'Trefoil shirt', '7900.00', '8000.00', 52, '106', '/ecommerce/images/products/Trefoil shirt0.jpg,/ecommerce/images/products/Trefoil shirt1.jpg', 'adidas Originals Long Sleeve T-Shirt With Trefoil Arm Print Black DV3152', 'Trefoil Arm Print Black shirt', 0, 'M:7900:12:10,L:7900:5:10', '0:0', 0, 0, 0),
(46, 'Emmi Bag', '14900.00', '15000.00', 49, '106', '/ecommerce/images/products/Emmi Bag0.jpg,/ecommerce/images/products/Emmi Bag1.jpg', 'Carry all your new-season essentials with this super smart shopper bag. 80% Polyurethane, 20% Polyester.', 'Emmi Smart Shopper Bag', 0, 'Special:14900:23:10', '0:0', 0, 0, 0),
(47, 'Hobo Bag', '14900.00', '15000.00', 46, '106', '/ecommerce/images/products/DHobo Bag0.jpg,/ecommerce/images/products/DHobo Bag1.jpg,/ecommerce/images/products/DHobo Bag2.jpg', 'Carry all your essentials in style with this hobo bag in tan. 90% Polyurethane, 10% Polyester.\r\nColour: TAN', 'Spark Hobo Bag', 1, 'Special:14900:41:10', '1:14900', 0, 1, 0),
(48, 'St Ives C', '3900.00', '4000.00', 46, '106', '/ecommerce/images/products/St Ives Ccdd30.jpg,/ecommerce/images/products/St Ives C63a7f.jpg', 'St Ives original cream for beautiful and radiant skin. Nourish and blemish control.', 'Nourish and blemish control cream', 0, 'Medium:3900:50:10,Large:4500:5:10', '0:0', 0, 0, 0),
(49, 'Stan shoe ', '5000.00', '6000.00', 52, '106', '/ecommerce/images/products/Stan shoe b15eb.jpeg,/ecommerce/images/products/Stan shoe 94070.jpeg', 'White multipurpose trainer', 'Trainers ', 1, '8:5000:5:2', '0:0', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

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
-- Table structure for table `secure_customer`
--

CREATE TABLE IF NOT EXISTS `secure_customer` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `secure_customer`
--

INSERT INTO `secure_customer` (`user_id`, `user_username`, `user_password`, `user_status`) VALUES
(1, 'test', 'password', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_userid` int(10) NOT NULL,
  `session_token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `session_serial` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `session_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=61 ;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `session_userid`, `session_token`, `session_serial`, `session_date`) VALUES
(60, 1, '0gwh4FfjjhGEsKJgKFDgKnn2juGHd3', 'wKW34sSdhjJKjujJdgjKjj2EngGnGg', '');

-- --------------------------------------------------------

--
-- Table structure for table `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `caption` text COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT '0',
  `timer` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `staffs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `rank` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `username`, `full_name`, `email`, `phone`, `password`, `join_date`, `last_login`, `rank`, `permissions`) VALUES
(7, 'BB', 'BB', 'bb@ameritinz.com', '08030932109', '$2y$10$qg6MRKS2WsI9cl7phUKTLeAPWw58pcIgRwaV7ou/d4.3plciejbUy', '2018-09-13 00:00:55', '2019-01-26 13:11:48', 'CEO', 'pro,admin,editor,staff'),
(14, 'damabel', 'Godfrey D. Damabel ', 'godfrey@ameritinz.com', '08030342243', '$2y$10$8uhmFGaHCEfF286ajMluUu2.w55ZipCE/.HqWRsOqnLEKaNtQgRC6', '2018-09-20 21:17:40', '2018-11-21 23:50:19', '', 'pro,admin,editor,staff'),
(16, 'ledi', 'Ledi Damabel', 'ledi@ameritinz.com', '08030342243', '$2y$10$egh1g4Lk8p3jGp3xzvotjOHgBC02wxJ.B6ySwVIf3IkQiWDOqyGE2', '2018-10-26 13:50:29', '2019-01-26 19:25:02', 'General Manager', 'admin,editor,staff'),
(17, '', 'Hope Kwasi', 'hope@ameritinz.com', '08030342243', '$2y$10$Lt9ixLcoEk2M5K2Ib4sspO5MgWw7Wzn.BSooniPvEocA9LfMbfuLC', '2018-10-26 13:56:53', '2018-11-21 01:46:09', 'Editor', 'staff'),
(18, '', 'Blessing Ogbegene', 'blessing@ameritinz.com', '08030342243', '$2y$10$qg6MRKS2WsI9cl7phUKTLeAPWw58pcIgRwaV7ou/d4.3plciejbUy', '2018-10-26 14:36:58', '2018-11-21 01:46:09', '', 'staff'),
(19, 'test', 'test tester', 'test@ameritinz.com', '08030932109', '$2y$10$FgbnqsRb6Ykt7DLrV3OcZOLMH/ATYHfDRA5fbpoFYKbwrMaNAyIki', '2018-12-02 02:39:50', '0000-00-00 00:00:00', 'General Manager', 'admin,editor,staff'),
(20, 'Universe', 'Universe Test', 'universe@test.com', '08030932487', '$2y$10$EsH9uaciQ4gKfu1WHvjfDuXjs9VW0qMSTjI1DDR9dFEu/zjte78Ky', '2018-12-23 22:01:05', '2019-01-26 13:40:40', 'Staff', 'admin,editor,staff'),
(21, 'dd', 'dd', 'ledi2@ameritinz.com', '08030932482', '$2y$10$s4HIAtyH9H/H.2t1p4xR3.p0jmPl2wAnDjCxiPnwHlwDebO4Zkx7C', '2018-12-23 22:05:05', '0000-00-00 00:00:00', '', 'editor,staff');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `grand_total` decimal(10,0) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `txn_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Not Complete',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=97 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `charge_id`, `cart_id`, `full_name`, `email`, `phone`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `items`, `sub_total`, `tax`, `grand_total`, `description`, `txn_type`, `txn_date`, `status`) VALUES
(75, 'cashdxpZp96mZTcf3k6', '157', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"14","price":"4000","size":"medium","quantity":"1","request":"beter"},{"id":"20","price":"2000","size":"small","quantity":2,"request":""},{"id":"14","price":"2900","size":"small","quantity":"1","request":""}]', '10900', '0', '10900', '4 items from Ameritinz Supermart', 'cash', '2018-11-20 00:47:33', 'Complete'),
(76, 'cashhWcHpx3ljSXrUS9', '195', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"16","price":"3000","size":"Family","quantity":2,"request":""},{"id":"20","price":"2000","size":"small","quantity":1,"request":""}]', '8000', '0', '8000', '3 items from Ameritinz Supermart', 'cash', '2018-11-20 22:47:10', 'Complete'),
(78, 'posk4232pbR21BWQC5', '203', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"14","price":"4000","size":"medium","quantity":2,"request":""}]', '8000', '0', '8000', '2 items from Ameritinz Supermart', 'pos', '2018-11-21 14:06:31', 'Complete'),
(79, 'cashCg9NTZ25MVNhfVz', '217', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"24","price":"4900","size":"Baby","quantity":"1","request":""},{"id":"17","price":"950","size":"Family","quantity":"1","request":""},{"id":"15","price":"2900","size":"80mg","quantity":"1","request":""}]', '8750', '0', '8750', '3 items from Ameritinz Supermart', 'cash', '2018-11-26 10:06:19', 'Not Complete'),
(80, 'cashTjPbsDzRgpw8vF4', '218', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"21","price":"3900","size":"Adult","quantity":"1","request":""}]', '3900', '0', '3900', '1 item from Ameritinz Supermart', 'cash', '2018-11-26 10:09:41', 'Complete'),
(81, 'cashyzR6v4KP51l4279', '219', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 2', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"14","price":"2900","size":"small","quantity":"5","request":""}]', '14500', '0', '14500', '5 items from Ameritinz Supermart', 'cash', '2018-11-30 10:56:19', 'Complete'),
(82, 'poschg0zSn4DGBPLM6', '223', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"20","price":"2000","size":"small","quantity":1,"request":""}]', '2000', '0', '2000', '1 item from Ameritinz Supermart', 'pos', '2018-12-03 01:34:32', 'Complete'),
(83, 'posDPKvpyhcLv0rFwc', '230', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"25","price":"2500","size":"medium","quantity":"2","request":"Mild fragrance "},{"id":"25","price":"2000","size":"small","quantity":"1","request":"Mild Fragrance. "}]', '7000', '0', '7000', '3 items from Ameritinz Supermart', 'pos', '2018-12-11 20:04:24', 'Complete'),
(84, 'pos2TvnJM5xbmRjTWC', '251', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"14","price":"2900","size":"small","quantity":"1","request":""},{"id":"29","price":"5000","size":"Family","quantity":"1","request":""}]', '7900', '0', '7900', '2 items from Ameritinz Supermart', 'pos', '2019-01-01 19:49:14', 'Complete'),
(85, 'posWtm4mhfWl7Mr4tv', '253', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"15","price":"2900","size":"80mg","quantity":"1","request":""}]', '2900', '0', '2900', '1 item from Ameritinz Supermart', 'pos', '2019-01-04 10:34:14', 'Not Complete'),
(86, 'cash2LFczjGjP5S95WC', '254', 'Ledi Damabel', 'ledi@ameritinz.com', '', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"18","price":"1900","size":"20Pieces","quantity":"1","request":""}]', '1900', '0', '1900', '1 item from Ameritinz Supermart', 'cash', '2019-01-04 10:50:44', 'Complete'),
(87, 'posz5Mq9kyPxCR4Cky', '255', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"15","price":"2900","size":"80mg","quantity":"1","request":""}]', '2900', '0', '2900', '1 item from Ameritinz Supermart', 'pos', '2019-01-04 11:18:43', 'Complete'),
(88, 'pos2WWqplWyDPfRULf', '298', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '', '4500', '0', '4500', '1 item from Ameritinz Supermart', 'pos', '2019-01-11 15:31:08', 'Complete'),
(89, 'posCdpwHMtD1VdB9L3', '381', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"26","price":"4900","size":"100mg","quantity":2,"request":""}]', '9800', '0', '9800', '2 items from Ameritinz Supermart', 'pos', '2019-01-18 18:51:21', 'Complete'),
(90, 'posV0j5W3t62Gvx0t6', '388', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"14","price":"2900","size":"small","quantity":"1","request":""}]', '2900', '0', '2900', '1 item from Ameritinz Supermart', 'pos', '2019-01-24 10:04:51', 'Complete'),
(91, 'posTj3W7WUW1lnym92', '', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"29","price":"4500","size":"Adults","quantity":2,"request":""}]', '9000', '0', '9000', '2 items from Ameritinz Supermart', 'pos', '2019-01-25 12:33:31', 'Complete'),
(92, 'posL4VFQCNLkLCCKyG', '', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"29","price":"4500","size":"Adults","quantity":2,"request":""}]', '9000', '0', '9000', '2 items from Ameritinz Supermart', 'pos', '2019-01-25 12:34:43', 'Complete'),
(93, 'posQcWW2KxwjmcwTMl', '', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"29","price":"4500","size":"Adults","quantity":1,"request":""}]', '4500', '0', '4500', '1 item from Ameritinz Supermart', 'pos', '2019-01-25 12:41:00', 'Complete'),
(94, 'cashtkpkj6NTL21yHvV', '404', 'Test Universe', 'universe@test.com', '803093248', 'Verily Avenue Phase 1', 'babyiloveu', 'Lagos', 'Lagos', '', 'Nigeria', '[{"id":"38","price":"3900","size":"medium","quantity":"1","request":""}]', '3900', '0', '3900', '1 item from Ameritinz Supermart', 'cash', '2019-01-25 19:58:19', 'Complete'),
(95, 'posSChwsyqzQ6vq64s', '407', 'Test Universe', 'universe@test.com', '08030932488', 'Verily Avenue Phase 1', 'Nigeria ', 'Lagos', 'Lagos', '234', 'Nigeria', '[{"id":"18","price":"1900","size":"Family","quantity":4,"request":""},{"id":"44","price":"6900","size":"UK 9","quantity":2,"request":""}]', '21400', '0', '21400', '6 items from Ameritinz Supermart', 'pos', '2019-01-26 13:10:45', 'Complete'),
(96, 'ch_1Dx1WGH16GOmvPiGUuH5g9Lm', '406', 'Ledi Damabel', 'ledi@ameritinz.com', '08030932109', 'Ameritinz Store 1', 'Rumuola', 'Port Harcourt', 'Rivers State', '1111', 'Nigeria', '[{"id":"47","price":"14900","size":"Special","quantity":"1","request":""}]', '14900', '0', '14900', '1 item from Ameritinz Supermart', 'charge', '2019-01-26 19:29:37', 'Not Complete');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=406 ;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `username`, `items`, `expire_date`) VALUES
(400, 'Father', '[{"id":"20","price":"2000","size":"medium","quantity":2,"request":""}]', '2019-02-24 20:21:30'),
(4, 'Universe', '[{"id":"49","price":"5000","size":"8","quantity":"4","request":""},{"id":"15","price":"2900","size":"80mg","quantity":"1","request":""}]', '2019-02-25 13:56:24'),
(401, 'peter', '[{"id":"36","price":"1","size":"q","quantity":"1","request":""}]', '2019-02-24 20:21:30'),
(405, 'ledi', '[{"id":"38","price":"3900","size":"medium","quantity":"1","request":""}]', '2019-02-25 11:44:07');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
