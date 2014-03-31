-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: allpets
-- ------------------------------------------------------
-- Server version	5.5.35-0ubuntu0.12.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `pets_table`
--

DROP TABLE IF EXISTS `pets_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pets_table` (
  `uid` int(11) NOT NULL,
  `name` tinytext CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  `species` tinyint(4) NOT NULL,
  `sex` tinyint(4) NOT NULL,
  `description` text CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  `photo` mediumtext NOT NULL,
  `tag` mediumtext NOT NULL,
  `salvor` varchar(40) NOT NULL,
  UNIQUE KEY `Main` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All pets information';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pets_table`
--

LOCK TABLES `pets_table` WRITE;
/*!40000 ALTER TABLE `pets_table` DISABLE KEYS */;
INSERT INTO `pets_table` VALUES (1,'三毛',0,0,'Now I can edit the story.','6798453217_72dea2d06e_m.jpg','tag1,tag2,tag3','roynwang@live.cn'),(2,'Echo',1,1,'My name is Echo','6791628438_affaa19e10_m.jpg','tag3,tag4','roynwang@live.cn');
/*!40000 ALTER TABLE `pets_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salvor_table`
--

DROP TABLE IF EXISTS `salvor_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salvor_table` (
  `id` varchar(40) NOT NULL DEFAULT '',
  `pwd` char(32) DEFAULT NULL,
  `display_name` char(20) CHARACTER SET gb2312 COLLATE gb2312_bin DEFAULT NULL,
  `QQ` varchar(15) DEFAULT NULL,
  `phone_0` varchar(15) DEFAULT NULL,
  `phone_1` varchar(15) DEFAULT NULL,
  UNIQUE KEY `Main` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='test';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salvor_table`
--

LOCK TABLES `salvor_table` WRITE;
/*!40000 ALTER TABLE `salvor_table` DISABLE KEYS */;
INSERT INTO `salvor_table` VALUES ('dong@live.cn','3aabc66071d653be7c1f70d9f8223c05','','','',''),('my@live.cn','3aabc66071d653be7c1f70d9f8223c05','学习','123456','df',NULL),('r@live.cn','3aabc66071d653be7c1f70d9f8223c05','','','',''),('royn.wang.renyuan@gmail.com','3aabc66071d653be7c1f70d9f8223c05','任远','123','1861226106f',''),('royn@live.cn','3aabc66071d653be7c1f70d9f8223c05',NULL,NULL,NULL,NULL),('roynwang@live.cn','3aabc66071d653be7c1f70d9f8223c05','测试','test','test1',NULL);
/*!40000 ALTER TABLE `salvor_table` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-31 23:41:02
