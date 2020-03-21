-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 21, 2020 at 08:31 AM
-- Server version: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lib`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_conselor`
--

CREATE TABLE IF NOT EXISTS `academic_conselor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `con_name` varchar(180) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `email` varchar(120) NOT NULL,
  `phone` varchar(120) NOT NULL,
  `home_address` varchar(360) NOT NULL,
  `office_address` varchar(360) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=134 ;

-- --------------------------------------------------------

--
-- Table structure for table `academic_conselor_photo`
--

CREATE TABLE IF NOT EXISTS `academic_conselor_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conselor_id` int(11) NOT NULL,
  `file` longblob NOT NULL,
  `file_name` varchar(360) NOT NULL,
  `file_type` varchar(360) NOT NULL,
  `file_size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=105 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(120) NOT NULL,
  `position` varchar(360) NOT NULL,
  `name` varchar(360) NOT NULL,
  `email` varchar(360) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_photo`
--

CREATE TABLE IF NOT EXISTS `admin_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(360) NOT NULL,
  `file` longblob NOT NULL,
  `file_name` varchar(360) NOT NULL,
  `file_type` varchar(360) NOT NULL,
  `file_size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL,
  `file` longblob NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `file_type` varchar(200) NOT NULL,
  `file_size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `user` varchar(12) NOT NULL,
  `date` date NOT NULL,
  `login` varchar(16) NOT NULL,
  `logout` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE IF NOT EXISTS `program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `class_year` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(120) NOT NULL,
  `class` varchar(120) NOT NULL,
  `nim` varchar(160) NOT NULL,
  `name` varchar(360) NOT NULL,
  `email` varchar(360) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2923 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_photo`
--

CREATE TABLE IF NOT EXISTS `student_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(120) NOT NULL,
  `file` longblob NOT NULL,
  `file_name` varchar(360) NOT NULL,
  `file_type` varchar(360) NOT NULL,
  `file_size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=646 ;

-- --------------------------------------------------------

--
-- Table structure for table `thesis`
--

CREATE TABLE IF NOT EXISTS `thesis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `author` varchar(180) NOT NULL,
  `date` date NOT NULL,
  `year` varchar(20) NOT NULL,
  `barcode` varchar(180) NOT NULL,
  `call_no` varchar(180) NOT NULL,
  `conselor` varchar(20) NOT NULL,
  `program` varchar(20) NOT NULL,
  `hard` enum('y','n') NOT NULL,
  `soft` enum('y','n') NOT NULL,
  `status` enum('available','unavailable','unpublished','published') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2354 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(60) NOT NULL,
  `pass` varchar(60) NOT NULL,
  `status` enum('user','admin') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5042 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_activity_log`
--

CREATE TABLE IF NOT EXISTS `user_activity_log` (
  `idlog` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` varchar(30) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip_address` varchar(60) NOT NULL,
  `org` varchar(180) NOT NULL,
  `city` varchar(90) NOT NULL,
  `browser` varchar(180) NOT NULL,
  `location` varchar(180) NOT NULL,
  `geolocation` varchar(90) NOT NULL,
  `activity` varchar(180) NOT NULL,
  PRIMARY KEY (`idlog`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54342 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
