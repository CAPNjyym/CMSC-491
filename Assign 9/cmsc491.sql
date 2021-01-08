-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 08, 2012 at 10:35 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cmsc491`
--

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE IF NOT EXISTS `owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last` text NOT NULL,
  `first` text NOT NULL,
  `middle` text NOT NULL,
  `gender` varchar(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`id`, `last`, `first`, `middle`, `gender`) VALUES
(1, 'Culpepper', 'Jyym', 'Michael', 'M'),
(2, 'Jyym', 'CAPN', '', 'M'),
(3, 'Mouse', 'Anon', 'E', 'M'),
(4, 'Citizen', 'Average', 'Ordinary', 'F'),
(5, 'Legs', 'Chairs', 'Have', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `owns`
--

CREATE TABLE IF NOT EXISTS `owns` (
  `vehicle_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  PRIMARY KEY (`vehicle_id`),
  UNIQUE KEY `vehicle_id` (`vehicle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owns`
--

INSERT INTO `owns` (`vehicle_id`, `owner_id`) VALUES
(1, 4),
(2, 4),
(3, 1),
(4, 2),
(5, 2),
(6, 3),
(7, 3),
(8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `make` text NOT NULL,
  `model` text NOT NULL,
  `color` text NOT NULL,
  `license` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `make`, `model`, `color`, `license`) VALUES
(1, 'Every', 'Car', 'EVER', 'IOWNTHEM'),
(2, 'Rust', 'Junk', 'Ugly', 'BROKEN'),
(3, 'Old', 'New', 'Pretty', '123-XYZ'),
(4, 'McLaren', 'F1', 'White', 'HELL-YES'),
(5, 'McLaren', 'MP4-12C', 'Silver', 'THE-NEW1'),
(6, 'Crazy', 'Out There', 'Nuts', 'BONKERS'),
(7, 'Blow', 'It', 'Up', 'NOW'),
(8, 'McLaren', 'MP4/4', 'White and Red (Dayglow Orange)', 'SENNA12');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
