CREATE DATABASE  IF NOT EXISTS `findchums` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `findchums`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: findchums
-- ------------------------------------------------------
-- Server version	8.0.36

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
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `friends` (
  `user_id` int NOT NULL,
  `friend_id` int NOT NULL,
  `status` enum('pending','accepted','removed') DEFAULT 'pending',
  PRIMARY KEY (`user_id`,`friend_id`),
  KEY `friend_id` (`friend_id`),
  CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` VALUES (18,19,'accepted'),(18,20,'accepted'),(18,21,'accepted'),(19,18,'accepted'),(19,20,'accepted'),(21,18,'accepted');
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_likes`
--

DROP TABLE IF EXISTS `post_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_likes`
--

LOCK TABLES `post_likes` WRITE;
/*!40000 ALTER TABLE `post_likes` DISABLE KEYS */;
INSERT INTO `post_likes` VALUES (8,59,21),(9,51,18),(10,51,19),(11,51,20),(12,52,19),(13,52,21),(14,53,20),(15,53,21),(16,54,18),(17,54,19),(18,56,20),(19,56,21),(20,57,18),(21,57,20),(22,58,19),(23,58,21),(24,59,18),(25,59,19);
/*!40000 ALTER TABLE `post_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `play_time` varchar(50) DEFAULT NULL,
  `likes` int DEFAULT '0',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (51,18,'Weightlifting Meetup','Join us for a weightlifting session at the gym. Spotters needed!','gym, weightlifting, fitness','2024-11-24 09:00:00',2,'2024-11-18 04:25:49'),(52,19,'Morning Yoga Session','Start your day with a rejuvenating yoga session at the park.','yoga, health, wellness','2024-11-21 06:00:00',3,'2024-11-18 04:26:13'),(53,20,'5K Fun Run','Let’s hit the trails for a 5K run. All levels welcome!','running, fitness, outdoors','2024-11-22 07:30:00',4,'2024-11-18 04:26:16'),(54,21,'Soccer Match','Looking for players for a soccer match this weekend!','soccer, sports, competition','2024-11-23 16:00:00',4,'2024-11-18 04:26:19'),(56,19,'Evening Badminton Game','Looking for a doubles partner for an indoor badminton game.','badminton, indoor, sports','2024-11-24 19:00:00',1,'2024-11-18 04:27:53'),(57,20,'Cycling Group Ride','Join our cycling group for a 20km ride around the city.','cycling, outdoors, fitness','2024-11-25 06:30:00',2,'2024-11-18 04:27:53'),(58,21,'Tennis Practice Match','Anyone up for a practice singles match this weekend?','tennis, competition, practice','2024-11-26 10:00:00',2,'2024-11-18 04:27:53'),(59,18,'Trail Hiking Adventure','Explore nature with us on a group hike this Saturday.','hiking, outdoors, adventure','2024-11-27 08:00:00',5,'2024-11-18 04:27:53'),(60,21,'Playing Basketball at Jaypee Basketball Court','Looking for teammates ','basketball','2024-10-01T09:52',1,'2024-11-18 04:28:50'),(61,18,'1234','sdflkjvnsdfv','1234','2024-10-04T09:52',0,'2024-11-24 19:39:33'),(62,18,'Football at ATS','Come play football near ats, we have 4 open spots, no serious games though only playing for fun','Football, 5v5, fun','2024-11-28T19:30',0,'2024-11-25 04:54:21');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_info` (
  `user_name` varchar(50) NOT NULL,
  `bio` varchar(45) NOT NULL DEFAULT '"Update to see"',
  `interests` varchar(45) NOT NULL DEFAULT '"Update to see"',
  `location` varchar(45) NOT NULL DEFAULT '"Update to see"',
  `age` int DEFAULT NULL,
  `instagram` varchar(45) DEFAULT NULL,
  `twitter` varchar(45) DEFAULT NULL,
  `phone_number` varchar(45) DEFAULT NULL,
  `rating` varchar(45) DEFAULT NULL,
  `image_address` varchar(300) DEFAULT 'C:\\xampp\\htdocs\\NeedAName\\images\\default_avatar.jpg',
  PRIMARY KEY (`user_name`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES ('admin','hmm','hmm','hmm',123,'hhmmm','hmmm',NULL,NULL,'images/newProfile.jpg'),('aryan','Not Update','Not Update','Not Update',NULL,NULL,NULL,NULL,NULL,'images\\default_avatar.png'),('poorvi','Not Update','tennis, football, volleyball','noida',24,'poorvi','poorvi',NULL,NULL,'images/myProfile.png'),('rudra','Not Update','Not Update','Not Update',NULL,NULL,NULL,NULL,NULL,'images\\default_avatar.png');
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (18,'arnav','arnav181104@gmail.com','$2y$10$CT/xZsb1viLxETaK8KGxWuCF6ihRTW/.W2PAgCv71KCFVxhX7XBRa','2024-11-05 04:09:43','admin'),(19,'poorvi','poorvi@mail.com','$2y$10$4EUVri7KxoVnRuXtFPpp/.z10pWmMZnnxOURdORSLRO9gYWVw7oGW','2024-11-14 09:26:30','poorvi'),(20,'arnav','rudra@gmail.com','$2y$10$nTbcuxO0n/d6r0aINk8ZCu5A6dqbPzakY2WgKat4UIhMldvtyZaG2','2024-11-17 17:50:22','rudra'),(21,'aryan','aryan@mail.com','$2y$10$C9XUHSSCIrSW0BMIAY5/bejbDDvgyS11smSEgj9slPF06q6XviT4e','2024-11-18 04:24:45','aryan');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-25 10:53:57
