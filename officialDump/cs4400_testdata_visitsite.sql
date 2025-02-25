CREATE DATABASE  IF NOT EXISTS `cs4400_testdata` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */;
USE `cs4400_testdata`;
-- MySQL dump 10.13  Distrib 8.0.13, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: cs4400_testdata
-- ------------------------------------------------------
-- Server version	8.0.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `visitsite`
--

DROP TABLE IF EXISTS `visitsite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `visitsite` (
  `visitorUsername` varchar(255) NOT NULL,
  `siteName` varchar(255) NOT NULL,
  `visitSiteDate` date NOT NULL,
  PRIMARY KEY (`visitSiteDate`,`visitorUsername`,`siteName`),
  KEY `visitorUsername` (`visitorUsername`),
  KEY `siteName` (`siteName`),
  CONSTRAINT `visitsite_ibfk_1` FOREIGN KEY (`visitorUsername`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `visitsite_ibfk_2` FOREIGN KEY (`siteName`) REFERENCES `site` (`sitename`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitsite`
--

LOCK TABLES `visitsite` WRITE;
/*!40000 ALTER TABLE `visitsite` DISABLE KEYS */;
INSERT INTO `visitsite` VALUES ('mary.smith','Atlanta Beltline Center','2019-02-01'),('mary.smith','Inman Park','2019-02-01'),('mary.smith','Historic Fourth Ward Park','2019-02-02'),('mary.smith','Inman Park','2019-02-02'),('mary.smith','Piedmont Park','2019-02-02'),('mary.smith','Inman Park','2019-02-03'),('mary.smith','Atlanta Beltline Center','2019-02-10'),('visitor1','Inman Park','2019-02-01'),('visitor1','Piedmont Park','2019-02-01'),('visitor1','Westview Cemetery','2019-02-06'),('visitor1','Atlanta Beltline Center','2019-02-09'),('visitor1','Historic Fourth Ward Park','2019-02-11'),('visitor1','Piedmont Park','2019-02-11'),('visitor1','Atlanta Beltline Center','2019-02-13');
/*!40000 ALTER TABLE `visitsite` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-20  1:31:26
