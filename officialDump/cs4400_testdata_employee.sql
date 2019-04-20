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
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `employee` (
  `Username` varchar(255) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `Phone` bigint(20) NOT NULL,
  `employeeAddress` varchar(255) NOT NULL,
  `employeeCity` varchar(255) NOT NULL,
  `employeeState` varchar(255) NOT NULL,
  `employeeZipcode` int(11) NOT NULL,
  `employeeType` varchar(255) NOT NULL,
  PRIMARY KEY (`EmployeeID`,`Phone`,`Username`),
  UNIQUE KEY `EmployeeID` (`EmployeeID`),
  KEY `Username` (`Username`),
  CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES ('james.smith',1,4043721234,'123 East Main Street','Rochester','NY',14604,'Admin'),('michael.smith',2,4043726789,'350 Ferst Drive','Atlanta','GA',30332,'Staff'),('robert.smith',3,1234567890,'123 East Main Street','Columbus','OH',43215,'Staff'),('maria.garcia',4,7890123456,'123 East Main Street','Richland','PA',17987,'Manager'),('david.smith',5,5124776435,'350 Ferst Drive','Atlanta','GA',30332,'Manager'),('manager1',6,8045126767,'123 East Main Street','Rochester','NY',14604,'Manager'),('manager2',7,9876543210,'123 East Main Street','Rochester','NY',14604,'Manager'),('manager3',8,5432167890,'350 Ferst Drive','Atlanta','GA',30332,'Manager'),('manager4',9,8053467565,'123 East Main Street','Columbus','OH',43215,'Manager'),('manager5',10,8031446782,'801 Atlantic Drive','Atlanta','GA',30332,'Manager'),('staff1',11,8024456765,'266 Ferst Drive Northwest','Atlanta','GA',30332,'Staff'),('staff2',12,8888888888,'266 Ferst Drive Northwest','Atlanta','GA',30332,'Staff'),('staff3',13,3333333333,'801 Atlantic Drive','Atlanta','GA',30332,'Staff');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
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
