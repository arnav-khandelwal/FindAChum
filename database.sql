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
INSERT INTO `friends` VALUES (18,19,'accepted'),(18,20,'accepted'),(18,21,'accepted'),(18,22,'accepted'),(18,24,'accepted'),(18,25,'accepted'),(18,26,'accepted'),(19,18,'accepted'),(19,20,'accepted'),(19,21,'accepted'),(19,22,'accepted'),(19,23,'accepted'),(19,24,'accepted'),(20,21,'accepted'),(20,22,'accepted'),(20,23,'accepted'),(20,24,'accepted'),(21,18,'accepted'),(21,22,'accepted'),(21,23,'accepted'),(21,24,'accepted'),(21,25,'accepted'),(22,23,'accepted'),(22,24,'accepted'),(22,25,'accepted'),(23,24,'accepted');
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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (51,18,'Weightlifting Meetup','Join us for a weightlifting session at the gym. Spotters needed!','gym, weightlifting, fitness','2024-11-24 09:00:00',2,'2024-11-18 04:25:49'),(52,19,'Morning Yoga Session','Start your day with a rejuvenating yoga session at the park.','yoga, health, wellness','2024-11-21 06:00:00',3,'2024-11-18 04:26:13'),(53,20,'5K Fun Run','Let’s hit the trails for a 5K run. All levels welcome!','running, fitness, outdoors','2024-11-22 07:30:00',4,'2024-11-18 04:26:16'),(54,21,'Soccer Match','Looking for players for a soccer match this weekend!','soccer, sports, competition','2024-11-23 16:00:00',4,'2024-11-18 04:26:19'),(56,19,'Evening Badminton Game','Looking for a doubles partner for an indoor badminton game.','badminton, indoor, sports','2024-11-24 19:00:00',1,'2024-11-18 04:27:53'),(57,20,'Cycling Group Ride','Join our cycling group for a 20km ride around the city.','cycling, outdoors, fitness','2024-11-25 06:30:00',2,'2024-11-18 04:27:53'),(58,21,'Tennis Practice Match','Anyone up for a practice singles match this weekend?','tennis, competition, practice','2024-11-26 10:00:00',2,'2024-11-18 04:27:53'),(59,18,'Trail Hiking Adventure','Explore nature with us on a group hike this Saturday.','hiking, outdoors, adventure','2024-11-27 08:00:00',5,'2024-11-18 04:27:53'),(60,21,'Playing Basketball at Jaypee Basketball Court','Looking for teammates ','basketball','2024-10-01T09:52',1,'2024-11-18 04:28:50'),(62,18,'Football at ATS','Come play football near ats, we have 4 open spots, no serious games though only playing for fun','Football, 5v5, fun','2024-11-28T19:30',0,'2024-11-25 04:54:21'),(63,22,'Basketball Practice','A great session on the court today! Working on dribbling and shooting.','Basketball, Sports, Practice','2024-11-25 15:00',10,'2024-11-25 08:30:00'),(64,23,'Photography Session','Spent the day capturing some beautiful landscapes and portraits.','Photography, Outdoors','2024-11-24 10:00',12,'2024-11-24 03:30:00'),(65,24,'Football Match Highlights','Fantastic game last night! We won 3-1, and I scored a goal.','Football, Sports, Match','2024-11-23 18:00',20,'2024-11-23 12:00:00'),(66,25,'Yoga Routine for Flexibility','Tried a new yoga routine today. Feeling more flexible already!','Yoga, Health','2024-11-22 07:00',5,'2024-11-22 01:00:00'),(67,26,'Travel Vlog: San Francisco','Exploring the beauty of San Francisco, from Golden Gate to Chinatown.','Travel, San Francisco, Vlog','2024-11-21 14:00',8,'2024-11-21 08:15:00'),(68,27,'Gym Session: Chest Day','Did a solid chest workout today. Increasing weights every week.','Fitness, Gym, Chest Day','2024-11-20 16:00',15,'2024-11-20 10:00:00'),(69,28,'Cycling Tour Around Seattle','Amazing cycling trip around Seattle. The views were breathtaking!','Cycling, Outdoors','2024-11-19 10:00',18,'2024-11-19 04:00:00'),(70,29,'Cooking a New Dish: Pasta','Today, I tried cooking homemade pasta for the first time. It was delicious!','Cooking, Food','2024-11-18 18:00',10,'2024-11-18 12:15:00'),(71,30,'Watching a Movie Night','A great night of watching classics with friends. Highly recommend the movie \"Inception\".','Movies, Entertainment','2024-11-17 20:00',22,'2024-11-17 14:15:00'),(72,31,'Fitness Challenge: 30-Day Squat Program','Started a 30-day squat challenge today. Let’s see how far I can push myself.','Fitness, Health, Challenge','2024-11-16 08:00',25,'2024-11-16 02:00:00'),(73,22,'Basketball Game Review','Analyzed some recent games for strategy and tactics improvement. Great learning experience.','Basketball, Sports, Strategy','2024-11-15 14:00',8,'2024-11-15 08:00:00'),(74,23,'Vlog: Road Trip to Yosemite','Recorded my road trip experience to Yosemite National Park. Check it out!','Travel, Vlog, Road Trip','2024-11-14 12:00',6,'2024-11-14 06:00:00'),(75,24,'Football Match Review','Reviewed a football match I played in. Looking forward to the next one.','Football, Sports, Review','2024-11-13 18:00',30,'2024-11-13 12:15:00'),(76,25,'Cooking a Traditional Mexican Dish','Made tacos for dinner today. Traditional Mexican recipe, very tasty!','Cooking, Food, Mexican','2024-11-12 17:00',12,'2024-11-12 11:00:00'),(77,26,'Tech Innovations and Gadgets','Exploring new gadgets and how they’re changing the tech industry. Exciting stuff!','Tech, Gadgets, Innovation','2024-11-11 14:00',7,'2024-11-11 08:00:00'),(78,27,'Fashion Tips for Fall','Discussing some fall fashion trends for this season. Cozy but stylish!','Fashion, Style','2024-11-10 09:00',9,'2024-11-10 03:15:00'),(79,28,'Cycling Around the City','A peaceful ride around the city today. Felt great to be outside in the fresh air.','Cycling, Outdoors','2024-11-09 10:00',11,'2024-11-09 04:15:00'),(80,29,'Yoga and Meditation for Mental Clarity','A session combining yoga and meditation. Helps clear my mind and focus better.','Yoga, Meditation','2024-11-08 06:00',10,'2024-11-08 00:00:00'),(81,30,'Fitness Routine Update','Updating my fitness routine to include more cardio. Feeling stronger every day!','Fitness, Health','2024-11-07 16:00',13,'2024-11-07 10:00:00'),(82,31,'Movie Review: The Dark Knight','Reviewed \"The Dark Knight\". A true masterpiece of modern cinema.','Movies, Entertainment','2024-11-06 21:00',25,'2024-11-06 15:00:00'),(83,33,'new post','sdflkjvnsdfv','1234','2024-09-10T09:52',0,'2024-11-25 06:00:04');
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
  `image_address` varchar(300) DEFAULT 'images\\default_avatar.png',
  PRIMARY KEY (`user_name`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES ('admin','hmm','hmm','hmm',123,'_okayarnav_','pcmbgod',NULL,NULL,'images/newProfile.jpg'),('aryan','updated','Not Update','Not Update',NULL,NULL,NULL,NULL,NULL,'images\\default_avatar.png'),('danielbrown','Update to see','Gaming, Traveling','San Francisco',26,'daniel_brown_insta','daniel_brown_twitter','6677889900','4.6','images\\default_avatar.png'),('davidwilson','Update to see','Cycling, Photography','Seattle',32,'david_wilson_insta','david_wilson_twitter','9988776655','4.4','images\\default_avatar.png'),('emilydavis','Update to see','Yoga, Cooking','Miami',27,'emily_cooking_insta','emily_cooking_twitter','1122334455','4.9','images\\default_avatar.png'),('ethanclark','Update to see','Football, Movies','Boston',28,'ethan_clark_insta','ethan_clark_twitter','4455667788','4.7','images\\default_avatar.png'),('janesmith','Update to see','Photography, Traveling','Los Angeles',25,'jane_smith_insta','jane_smith_twitter','9876543210','4.7','images\\default_avatar.png'),('johndoe','Update to see','Basketball, Reading','New York',28,'john_doe_insta','john_doe_twitter','1234567890','4.5','images\\default_avatar.png'),('krishna123','hi i am krishna','\"Update to see\"','\"Update to see\"',NULL,NULL,NULL,NULL,NULL,'images\\default_avatar.png'),('mikejohnson','Update to see','Football, Technology','Chicago',30,'mike_tech_insta','mike_tech_twitter','5432167890','4.8','images\\default_avatar.png'),('oliviataylor','Update to see','Fashion, Cooking','San Diego',29,'olivia_taylor_insta','olivia_taylor_twitter','2233445566','4.6','images\\default_avatar.png'),('poorvi','Not Update','tennis, football, volleyball','noida',24,'__okipoorviie','poorvi',NULL,NULL,'images/myProfile.png'),('rudra','Not Update','Not Update','Not Update',NULL,'rudrapratap_sd',NULL,NULL,NULL,'images\\default_avatar.png'),('sarahlee','Update to see','Music, Fashion','Austin',24,'sarah_lee_insta','sarah_lee_twitter','3344556677','5.0','images\\default_avatar.png'),('sophialewis','Update to see','Fitness, Painting','Denver',26,'sophia_lewis_insta','sophia_lewis_twitter','5566778899','4.8','images\\default_avatar.png'),('yash','\"Update to see\"','\"Update to see\"','\"Update to see\"',NULL,NULL,NULL,NULL,NULL,'images\\default_avatar.png');
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (18,'arnav','arnav181104@gmail.com','$2y$10$CT/xZsb1viLxETaK8KGxWuCF6ihRTW/.W2PAgCv71KCFVxhX7XBRa','2024-11-05 04:09:43','admin'),(19,'poorvi','poorvi@mail.com','$2y$10$4EUVri7KxoVnRuXtFPpp/.z10pWmMZnnxOURdORSLRO9gYWVw7oGW','2024-11-14 09:26:30','poorvi'),(20,'arnav','rudra@gmail.com','$2y$10$nTbcuxO0n/d6r0aINk8ZCu5A6dqbPzakY2WgKat4UIhMldvtyZaG2','2024-11-17 17:50:22','rudra'),(21,'aryan','aryan@mail.com','$2y$10$C9XUHSSCIrSW0BMIAY5/bejbDDvgyS11smSEgj9slPF06q6XviT4e','2024-11-18 04:24:45','aryan'),(22,'John Doe','john.doe@example.com','password123','2024-11-25 05:36:24','johndoe'),(23,'Jane Smith','jane.smith@example.com','password456','2024-11-25 05:36:24','janesmith'),(24,'Mike Johnson','mike.johnson@example.com','password789','2024-11-25 05:36:24','mikejohnson'),(25,'Emily Davis','emily.davis@example.com','mypassword','2024-11-25 05:36:24','emilydavis'),(26,'Daniel Brown','daniel.brown@example.com','secretpass','2024-11-25 05:36:24','danielbrown'),(27,'Sarah Lee','sarah.lee@example.com','password112','2024-11-25 05:36:24','sarahlee'),(28,'David Wilson','david.wilson@example.com','securepass','2024-11-25 05:36:24','davidwilson'),(29,'Olivia Taylor','olivia.taylor@example.com','12345password','2024-11-25 05:36:24','oliviataylor'),(30,'Ethan Clark','ethan.clark@example.com','clarkpassword','2024-11-25 05:36:24','ethanclark'),(31,'Sophia Lewis','sophia.lewis@example.com','passw0rd123','2024-11-25 05:36:24','sophialewis'),(32,'Krishna Seth','krishna@gmail.com','$2y$10$VOWq8U/wmBrpEcHOnG.2leatGvBgo8BtPv47vxe0Y/CGwvjMw1AJW','2024-11-25 05:54:02','krishna123'),(33,'yash','yash@mail.com','$2y$10$psdTP.lVxIWEfW/uGWMCCun3fHv6l4HpMQPjmFIRmQqxGgPo06j0i','2024-11-25 05:58:54','yash');
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

-- Dump completed on 2024-11-25 12:04:44
