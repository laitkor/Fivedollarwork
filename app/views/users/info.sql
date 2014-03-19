-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2011 at 06:16 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `info_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood`
--

CREATE TABLE IF NOT EXISTS `blood` (
  `dateofbirth` varchar(255) NOT NULL,
  ` age` int(11) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  ` occupation` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  ` addressforcommunication` varchar(255) NOT NULL,
  ` ifyes_howmanyoccasions` varchar(255) NOT NULL,
  ` whenlast` varchar(255) NOT NULL,
  ` yourbloodgroup` int(11) NOT NULL,
  `timeoflastmeal` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  ` donarsignature` varchar(255) NOT NULL,
  `signature_of_medical_officerv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blood`
--


-- --------------------------------------------------------

--
-- Table structure for table `child`
--

CREATE TABLE IF NOT EXISTS `child` (
  `retype_email` varchar(255) NOT NULL,
  `maritalstatus` varchar(255) NOT NULL,
  `residence` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `child`
--


-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE IF NOT EXISTS `education` (
  `nameofinstitutionforsignboard` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `officialregistrationno` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `education`
--


-- --------------------------------------------------------

--
-- Table structure for table `finance`
--

CREATE TABLE IF NOT EXISTS `finance` (
  `institution` varchar(255) NOT NULL,
  `contactaddress` varchar(255) NOT NULL,
  `telephone` int(11) NOT NULL,
  `faxno` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `areaofresearch` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance`
--


-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE IF NOT EXISTS `food` (
  `cardnumber` varchar(255) NOT NULL,
  `donation` varchar(255) NOT NULL,
  `ccv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food`
--


-- --------------------------------------------------------

--
-- Table structure for table `home`
--

CREATE TABLE IF NOT EXISTS `home` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `home`
--

INSERT INTO `home` (`username`, `password`) VALUES
('gtr6', 'r5er5');

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE IF NOT EXISTS `information` (
  `title` varchar(255) NOT NULL,
  ` firstname` varchar(255) NOT NULL,
  `surname` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `streetname` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `post_code` int(11) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `information`
--


-- --------------------------------------------------------

--
-- Table structure for table `secure`
--

CREATE TABLE IF NOT EXISTS `secure` (
  `company` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `primaryphone` varchar(255) NOT NULL,
  `alternatephone` varchar(255) NOT NULL,
  `cellphone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secure`
--


