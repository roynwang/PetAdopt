-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 17, 2014 at 11:27 PM
-- Server version: 5.5.35
-- PHP Version: 5.5.9-1+sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `allpets`
--

-- --------------------------------------------------------

--
-- Table structure for table `pets_table`
--

CREATE TABLE IF NOT EXISTS `pets_table` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  `species` tinyint(4) NOT NULL,
  `sex` tinyint(4) NOT NULL,
  `description` text CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  `photo` mediumtext NOT NULL,
  `tag` mediumtext NOT NULL,
  `salvor` varchar(40) NOT NULL,
  UNIQUE KEY `Main` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='All pets information' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pets_table`
--

INSERT INTO `pets_table` (`uid`, `name`, `species`, `sex`, `description`, `photo`, `tag`, `salvor`) VALUES
(1, '三毛', 0, 0, 'Now I can edit the story.', '6798453217_72dea2d06e_m.jpg', 'tag1,tag2,tag3', 'roynwang@live.cn'),
(2, 'Echo', 1, 1, 'My name is Echo', '6791628438_affaa19e10_m.jpg', 'tag3,tag4', 'roynwang@live.cn'),
(3, 'Hello', 0, 0, '', '', '', 'roynwang@live.cn'),
(4, 'world', 0, 0, '', '', '', 'roynwang@live.cn'),
(5, 'you', 0, 0, '', '', '', 'roynwang@live.cn'),
(6, 'love', 0, 0, '', '', '', 'roynwang@live.cn'),
(7, 'another', 0, 0, 'just for test', '', '', 'roynwang@live.cn');

-- --------------------------------------------------------

--
-- Table structure for table `salvor_table`
--

CREATE TABLE IF NOT EXISTS `salvor_table` (
  `id` varchar(40) NOT NULL DEFAULT '',
  `pwd` char(32) DEFAULT NULL,
  `display_name` char(20) CHARACTER SET gb2312 COLLATE gb2312_bin DEFAULT NULL,
  `QQ` varchar(15) DEFAULT NULL,
  `phone_0` varchar(15) DEFAULT NULL,
  `phone_1` varchar(15) DEFAULT NULL,
  UNIQUE KEY `Main` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='test';

--
-- Dumping data for table `salvor_table`
--

INSERT INTO `salvor_table` (`id`, `pwd`, `display_name`, `QQ`, `phone_0`, `phone_1`) VALUES
('dong@live.cn', '3aabc66071d653be7c1f70d9f8223c05', '', '', '', ''),
('my@live.cn', '3aabc66071d653be7c1f70d9f8223c05', '学习', '123456', 'df', NULL),
('r@live.cn', '3aabc66071d653be7c1f70d9f8223c05', '', '', '', ''),
('royn.wang.renyuan@gmail.com', '3aabc66071d653be7c1f70d9f8223c05', '任远', '123', '1861226106f', ''),
('royn@live.cn', '3aabc66071d653be7c1f70d9f8223c05', NULL, NULL, NULL, NULL),
('roynwang@live.cn', '3aabc66071d653be7c1f70d9f8223c05', 'Dongbo', 'test', 'test1', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
