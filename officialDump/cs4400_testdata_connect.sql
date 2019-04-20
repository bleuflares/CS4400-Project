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
-- Table structure for table `connect`
--

DROP TABLE IF EXISTS `connect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `connect` (
  `siteName` varchar(255) NOT NULL,
  `transitType` varchar(255) NOT NULL,
  `transitRoute` varchar(255) NOT NULL,
  PRIMARY KEY (`siteName`,`transitRoute`,`transitType`),
  KEY `transitRoute` (`transitRoute`,`transitType`),
  CONSTRAINT `connect_ibfk_1` FOREIGN KEY (`siteName`) REFERENCES `site` (`sitename`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `connect_ibfk_2` FOREIGN KEY (`transitRoute`, `transitType`) REFERENCES `transit` (`transitroute`, `transittype`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `connect`
--

LOCK TABLES `connect` WRITE;
/*!40000 ALTER TABLE `connect` DISABLE KEYS */;
INSERT INTO `connect` VALUES ('Historic Fourth Ward Park','Bus','152'),('Inman Park','Bus','152'),('Piedmont Park','Bus','152'),('Historic Fourth Ward Park','MARTA','Blue'),('Inman Park','MARTA','Blue'),('Piedmont Park','MARTA','Blue'),('Westview Cemetery','MARTA','Blue'),('Historic Fourth Ward Park','Bike','Relay'),('Piedmont Park','Bike','Relay');
/*!40000 ALTER TABLE `connect` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-20  1:31:25
