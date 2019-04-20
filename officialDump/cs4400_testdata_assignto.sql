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
-- Table structure for table `assignto`
--

DROP TABLE IF EXISTS `assignto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `assignto` (
  `staffUsername` varchar(255) NOT NULL,
  `eventName` varchar(255) NOT NULL,
  `startDate` date NOT NULL,
  `siteName` varchar(255) NOT NULL,
  PRIMARY KEY (`staffUsername`,`eventName`,`startDate`),
  KEY `eventName` (`eventName`,`startDate`),
  KEY `siteName` (`siteName`),
  CONSTRAINT `assignto_ibfk_1` FOREIGN KEY (`staffUsername`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `assignto_ibfk_2` FOREIGN KEY (`eventName`, `startDate`) REFERENCES `event` (`eventname`, `startdate`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `assignto_ibfk_3` FOREIGN KEY (`siteName`) REFERENCES `site` (`sitename`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignto`
--

LOCK TABLES `assignto` WRITE;
/*!40000 ALTER TABLE `assignto` DISABLE KEYS */;
INSERT INTO `assignto` VALUES ('staff1','Official Atlanta BeltLine Bike Tour','2019-02-09','Atlanta BeltLine Center'),('michael.smith','Eastside Trail','2019-02-13','Historic Fourth Ward Park'),('michael.smith','Bus Tour','2019-02-01','Inman Park'),('michael.smith','Bus Tour','2019-02-08','Inman Park'),('robert.smith','Bus Tour','2019-02-08','Inman Park'),('robert.smith','Eastside Trail','2019-02-04','Inman Park'),('robert.smith','Private Bus Tour','2019-02-01','Inman Park'),('staff1','Eastside Trail','2019-03-01','Inman Park'),('staff2','Bus Tour','2019-02-01','Inman Park'),('staff2','Eastside Trail','2019-02-04','Inman Park'),('staff3','Arboretum Walking Tour','2019-02-08','Inman Park'),('michael.smith','Eastside Trail','2019-02-04','Piedmont Park'),('staff1','Eastside Trail','2019-02-04','Piedmont Park'),('staff1','Westside Trail','2019-02-18','Westview Cemetery'),('staff3','Westside Trail','2019-02-18','Westview Cemetery');
/*!40000 ALTER TABLE `assignto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-20  1:31:24
