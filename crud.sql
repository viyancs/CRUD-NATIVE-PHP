-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2016 at 03:22 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Football', 1, '2016-07-13 00:00:00', '2016-07-13 00:00:00'),
(3, 'esport', 1, '2016-07-13 00:00:00', NULL),
(4, 'games', 1, '2016-07-13 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `author_id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'test', 'asdf', 1, '2016-07-13 00:00:00', NULL),
(2, 1, 'sfs', 'adfdfa', 1, '2016-07-13 00:00:00', NULL),
(3, 1, 'test', 'yes', 1, '2016-07-13 00:00:00', NULL),
(4, 1, 'test', 'yes', 1, '2016-07-13 00:00:00', NULL),
(5, 1, 'yahya', 'yahuan', 1, '2016-07-13 00:00:00', NULL),
(6, 1, 'portugal win euro 2016', 'portugal win&nbsp;', 1, '2016-07-13 00:00:00', '2016-07-13 00:00:00'),
(7, 1, 'messi loose final', 'messi loose final 3 times', 0, '2016-07-13 00:00:00', '2016-07-13 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `news_categories`
--

CREATE TABLE IF NOT EXISTS `news_categories` (
  `news_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_categories`
--

INSERT INTO `news_categories` (`news_id`, `cat_id`, `updated_at`) VALUES
(6, 3, '2016-07-13 00:00:00'),
(7, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reporter`
--

CREATE TABLE IF NOT EXISTS `reporter` (
  `id` int(11) NOT NULL,
  `nama` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `alamat` text,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reporter`
--

INSERT INTO `reporter` (`id`, `nama`, `email`, `alamat`, `status`, `created_at`, `updated_at`) VALUES
(1, 'robert', 'robert@dd.com', 'jihay', 1, '2016-07-13 00:00:00', '2016-07-13 00:00:00'),
(3, 'intan', 'intan@emais.com', 'blablala', 1, '2016-07-13 00:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`), ADD KEY `categories_name` (`name`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`), ADD KEY `news_author_id` (`author_id`), ADD KEY `news_title` (`title`);

--
-- Indexes for table `news_categories`
--
ALTER TABLE `news_categories`
  ADD KEY `news_categories_news_idx` (`news_id`), ADD KEY `news_categories_categories_idx` (`cat_id`);

--
-- Indexes for table `reporter`
--
ALTER TABLE `reporter`
  ADD PRIMARY KEY (`id`), ADD KEY `reporter_name` (`nama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `reporter`
--
ALTER TABLE `reporter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `news`
--
ALTER TABLE `news`
ADD CONSTRAINT `fk_news_author` FOREIGN KEY (`author_id`) REFERENCES `reporter` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `news_categories`
--
ALTER TABLE `news_categories`
ADD CONSTRAINT `news_categories_categories` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `news_categories_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
