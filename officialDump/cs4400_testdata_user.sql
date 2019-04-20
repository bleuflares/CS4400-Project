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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `user` (
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Lastname` varchar(255) NOT NULL,
  `userType` varchar(255) NOT NULL,
  PRIMARY KEY (`Username`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('david.smith','dsmith456','Approved','David','Smith','Employee'),('james.smith','jsmith123','Approved','James','Smith','Employee'),('manager1','manager1','Pending','Manager','One','Employee'),('manager2','manager2','Approved','Manager','Two','Employee, Visitor'),('manager3','manager3','Approved','Manager','Three','Employee'),('manager4','manager4','Approved','Manager','Four','Employee, Visitor'),('manager5','manager5','Approved','Manager','Five','Employee, Visitor'),('maria.garcia','mgarcia123','Approved','Maria','Garcia','Employee, Visitor'),('maria.hernandez','mhernandez','Approved','Maria','Hernandez','User'),('maria.rodriguez','mrodriguez','Declined','Maria','Rodriguez','Visitor'),('mary.smith','msmith789','Approved','Mary','Smith','Visitor'),('michael.smith','msmith456','Approved','Michael','Smith','Employee, Visitor'),('robert.smith','rsmith789','Approved','Robert ','Smith','Employee'),('staff1','staff1234','Approved','Staff','One','Employee'),('staff2','staff4567','Approved','Staff','Two','Employee, Visitor'),('staff3','staff7890','Approved','Staff','Three','Employee, Visitor'),('user1','user123456','Pending','User','One','User'),('visitor1','visitor123','Approved','Visitor','One','Visitor');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-20  1:31:27
