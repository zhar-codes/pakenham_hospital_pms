-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: pakenham_hospital_pms
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` VALUES (1,1,1,'2025-09-23 10:00:00','Scheduled','New patient intake','Main Clinic','2025-09-22 10:14:42','2025-09-22 10:14:42');
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `clinicians`
--

LOCK TABLES `clinicians` WRITE;
/*!40000 ALTER TABLE `clinicians` DISABLE KEYS */;
INSERT INTO `clinicians` VALUES (1,2,'Casey','Nguyen','General Practice','0400 000 111','clin1@example.local','Active','2025-09-22 10:14:42','2025-09-22 10:14:42');
/*!40000 ALTER TABLE `clinicians` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,4,'Ava','Santos','2002-05-12','0400 000 222','patient1@example.local',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Active','2025-09-22 10:14:42','2025-09-22 10:14:42');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin1','$2y$10$2E0X6p1s8V2tZqgYt2bJ8e4r2hKpQp8wG1G9y0Y2c6q5wQqgV7rK6','admin','admin1@example.local','Active','2025-09-22 10:14:42','2025-09-22 10:14:42'),(2,'clin1','$2y$10$V8w2T4yQyQn7kKx3Q3LZ0u2iZC8pXnCY1YwI3kX3o7qv2g1vT7m9a','clinician','clin1@example.local','Active','2025-09-22 10:14:42','2025-09-22 10:14:42'),(3,'recept1','$2y$10$e9ZpE8wK3fYQ2nB5rUqCqOqv1ZK0mD9eQ6sZQyTg7LhV1kCwEoXn2','reception','recept1@example.local','Active','2025-09-22 10:14:42','2025-09-22 10:14:42'),(4,'patient1','$2y$10$h3LqT9vE1xM2cY7pZ8aC2Oq4nVbD5kH6jLrT8yQ2wE1mN7pQ9sTFe','patient','patient1@example.local','Active','2025-09-22 10:14:42','2025-09-22 10:14:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-22 10:33:36
