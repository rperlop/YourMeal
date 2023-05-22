-- MySQL dump 10.19  Distrib 10.3.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: your_meal
-- ------------------------------------------------------
-- Server version	10.3.34-MariaDB-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `property` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES ('compulsive_number',5),('strikes_number',3),('reports_min_number',5);
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `food_types`
--

DROP TABLE IF EXISTS `food_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `food_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food_types`
--

LOCK TABLES `food_types` WRITE;
/*!40000 ALTER TABLE `food_types` DISABLE KEYS */;
INSERT INTO `food_types` VALUES (1,'Pizza'),(2,'Chinese'),(3,'Mexican'),(4,'Spanish'),(5,'Burger'),(6,'Vegan'),(7,'Peruvian'),(8,'Japanese'),(9,'Italian'),(10,'Kebab'),(11,'Arabic'),(12,'Mediterranean'),(13,'Latin'),(14,'American'),(15,'Healthy');
/*!40000 ALTER TABLE `food_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `review_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `images_review_id_foreign` (`review_id`),
  CONSTRAINT `images_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (9,'1684755784-The-burguer-shop-847x435.jpg','public/img/1684755784-The-burguer-shop-847x435.jpg','2023-05-22 09:43:04','2023-05-22 09:43:04',53),(10,'1684755784-MG_0399.jpg','public/img/1684755784-MG_0399.jpg','2023-05-22 09:43:04','2023-05-22 09:43:04',53);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_04_04_130813_create_restaurants_table',2),(6,'2023_04_04_132253_create_schedules_table',3),(7,'2023_04_04_132308_create_food_types_table',3),(8,'2023_04_04_132316_create_price_ranges_table',3),(9,'2023_04_04_132335_create_user_food_prefences_table',3),(10,'2023_04_04_132356_create_rates_table',3),(11,'2023_04_04_132402_create_images_table',3),(12,'2023_04_04_132421_create_reports_table',3),(13,'2023_04_04_132425_create_reviews_table',3),(14,'2023_04_04_134734_update_users_table',4),(15,'2023_04_04_135738_rename_user_food_prefences_to_user_food_preferences',5),(16,'2023_04_04_141024_update_restaurants_table',6),(17,'2023_04_04_141438_update_images_table',7),(18,'2023_04_04_141853_update_reports_table',8),(19,'2023_04_04_142007_update_reviews_table',9),(20,'2014_10_12_100000_create_password_resets_table',10),(21,'2023_04_04_164845_add_default_value_to_role_column_in_users_table',11),(22,'2023_04_05_115006_create_user_food_preferences_has_price_ranges_table',12),(23,'2023_04_05_120304_create_user_food_preferences_has_food_types_table',13),(24,'2023_04_05_120402_create_restaurant_has_food_types_table',14),(25,'2023_04_05_120447_create_restaurant_schedules_table',15),(26,'2023_04_05_120608_create_user_food_preferences_has_schedules_table',16),(27,'2023_04_05_120851_rename_restaurant_schedules_to_restaurant_has_schedules_table',17),(28,'2023_04_05_133625_remove_name_from_users_table',18),(29,'2023_04_13_183115_add_range_to_table',19),(30,'2023_04_15_181803_add_updated_at_to_user_food_preferences_table',20),(32,'2023_04_19_121817_modify_user_food_preferences_table',21),(33,'2023_05_04_170252_remove_rate_id_from_reviews_table',22),(34,'2023_05_04_172402_add_rate_to_reviews_table',23),(35,'2023_05_07_210850_make_comment_nullable_in_reviews_table',24),(37,'2023_05_14_173957_add_longitude_and_latitude_to_restaurants_table',25),(38,'2023_05_17_113023_add_featured_to_restaurants_table',26),(39,'2023_05_17_152845_add_strikes_to_users_table',27),(40,'2023_05_18_170902_create_notifications_table',28),(41,'2023_05_18_172017_create_config_table',29),(42,'2023_05_18_172356_add_notify_to_users_table',30),(43,'2023_05_20_214838_add_banned_to_users',31),(44,'2023_05_22_211457_drop_rates_table',32),(45,'2023_05_22_211617_drop_rates_table',33);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('compulsive_user','reported_review') COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_review_id_foreign` (`review_id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (7,'reported_review',52,38,'2023-05-21 13:44:14','2023-05-21 13:44:14'),(8,'compulsive_user',52,31,'2023-05-21 13:45:18','2023-05-21 13:45:18');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `price_ranges`
--

DROP TABLE IF EXISTS `price_ranges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price_ranges` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `range` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `price_ranges`
--

LOCK TABLES `price_ranges` WRITE;
/*!40000 ALTER TABLE `price_ranges` DISABLE KEYS */;
INSERT INTO `price_ranges` VALUES (1,NULL,NULL,'€'),(2,NULL,NULL,'€€'),(3,NULL,NULL,'€€€'),(4,NULL,NULL,'€€€€');
/*!40000 ALTER TABLE `price_ranges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `review_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_review_id_foreign` (`review_id`),
  KEY `reports_user_id_foreign` (`user_id`),
  CONSTRAINT `reports_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`),
  CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (12,'fakes','2023-05-20 14:48:13','2023-05-20 14:48:13',27,31),(19,'Spam','2023-05-21 13:43:49','2023-05-21 13:43:49',52,31),(20,'Spam','2023-05-21 13:43:55','2023-05-21 13:43:55',52,31),(21,'Spam','2023-05-21 13:44:01','2023-05-21 13:44:01',52,31),(22,'Spam','2023-05-21 13:44:08','2023-05-21 13:44:08',52,31),(23,'Spam','2023-05-21 13:44:14','2023-05-21 13:44:14',52,31),(24,'Spam','2023-05-21 13:45:18','2023-05-21 13:45:18',52,31);
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurant_has_food_types`
--

DROP TABLE IF EXISTS `restaurant_has_food_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurant_has_food_types` (
  `food_type_id` bigint(20) unsigned NOT NULL,
  `restaurant_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`food_type_id`,`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurant_has_food_types`
--

LOCK TABLES `restaurant_has_food_types` WRITE;
/*!40000 ALTER TABLE `restaurant_has_food_types` DISABLE KEYS */;
INSERT INTO `restaurant_has_food_types` VALUES (1,1),(1,3),(1,21),(2,1),(2,22),(2,23),(3,11),(3,12),(4,4),(4,8),(4,9),(4,10),(4,13),(4,15),(4,19),(4,24),(4,25),(5,17),(5,20),(5,27),(5,28),(6,19),(7,7),(7,14),(8,5),(8,6),(8,14),(9,3),(9,26),(10,21),(11,18),(12,8),(12,9),(12,10),(12,18),(12,19),(12,24),(12,25),(13,12),(14,16),(14,17),(14,20),(15,8),(15,11),(15,19);
/*!40000 ALTER TABLE `restaurant_has_food_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurant_has_schedules`
--

DROP TABLE IF EXISTS `restaurant_has_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurant_has_schedules` (
  `schedule_id` bigint(20) unsigned NOT NULL,
  `restaurant_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`schedule_id`,`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurant_has_schedules`
--

LOCK TABLES `restaurant_has_schedules` WRITE;
/*!40000 ALTER TABLE `restaurant_has_schedules` DISABLE KEYS */;
INSERT INTO `restaurant_has_schedules` VALUES (1,13),(1,24),(2,1),(2,3),(2,4),(2,5),(2,6),(2,7),(2,8),(2,9),(2,10),(2,11),(2,12),(2,13),(2,14),(2,15),(2,16),(2,17),(2,18),(2,19),(2,20),(2,21),(2,22),(2,23),(2,24),(2,25),(2,26),(2,27),(2,28),(3,1),(3,3),(3,4),(3,5),(3,6),(3,7),(3,8),(3,9),(3,10),(3,11),(3,12),(3,14),(3,15),(3,16),(3,17),(3,18),(3,19),(3,20),(3,21),(3,22),(3,23),(3,24),(3,25),(3,26),(3,27),(3,28);
/*!40000 ALTER TABLE `restaurant_has_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `web` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `terrace` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price_range_id` bigint(20) unsigned NOT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `featured_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `restaurants_email_unique` (`email`),
  KEY `restaurants_price_range_id_foreign` (`price_range_id`),
  CONSTRAINT `restaurants_price_range_id_foreign` FOREIGN KEY (`price_range_id`) REFERENCES `price_ranges` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restaurants`
--

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (3,'Bella Napoli','Av. del Jardinillo, 25, 41927 Mairena del Aljarafe, Sevilla','img/restaurants/WOpDJfMyytXqSa1HN7SeoXcFqJ1ZgneOixL3rYoG.jpg','+34 622 29 86 14','info@bellanapoli.com','http://www.facebook.com/labellanapolisevilla/about','Aquí, la cocina italiana le gusta a todos los comensales. Te servirán unas perfectamente elaboradas pizzas en horno de leña, unos sabrosos entrantes y un sorprendente pescado. Los camareros y camareras son aquí geniales, y eso es lo que hace que este restaurante sea tan bueno.',1,'2023-05-14 19:37:37','2023-05-15 10:02:53',2,-6.060569,37.341665,NULL),(4,'El Sella Triana','C. Pureza, 4, 41010 Sevilla','img/restaurants/AZvNIDgEamD66XHeGMSR1Htd4WcTgQQ78Bu3fZXh.jpg','+34 636 47 45 61','reservas@elsellatriana.com','http://www.facebook.com/elsellatriana/','Ubicado justo al lado del puente de Triana de Sevilla, en la popular calle Pureza junto a la plaza del Altozano y cerca de la Capilla de los Marineros, de la iglesia de Santa Ana y de la zona de copas y actuaciones en directo típicas del barrio trianero está el Restaurante & Tapas El Sella.',1,'2023-05-15 09:45:51','2023-05-15 10:02:42',2,-6.003300,37.385099,NULL),(5,'Sibuya Urban Sushi Bar Sevilla','Calle Albareda, 10:12, 41001 Seville, Spain','img/restaurants/bnb38WzCuCZbPQPbiGT9guz6Yl46s1fXKmMQuCzl.jpg','+34 954 03 50 30','sevilla@sibuya.es','http://www.sibuyaurbansushibar.com/','En la calle Albareda, 10, en pleno corazón de Sevilla, Sibuya Urban Sushi Bar quiere convertirse en uno de los referentes del nuevo concepto de comida nipona con una oferta gastronómica aún no vista en la capital andaluza.',1,'2023-05-15 09:50:17','2023-05-17 10:01:50',3,-5.995931,37.389528,5),(6,'Tropiqual','Plaza de Encarnación 34, 41003 Sevilla España','img/restaurants/ARfJNeHR51tsaLUEeNBbOleUl1g2anoyciFy0fCq.jpg','+34 854 70 32 50','contacto@tropiqual.es','http://www.tropiqualcompany.com/','Tropiqual es un restaurante de cocina Nikkei Nipo-Brasileña, variedad de sushi, grill de carnes y pescados, amplia coctelería y bar de copas.',1,'2023-05-15 10:05:47','2023-05-15 10:06:35',3,-5.991479,37.392707,NULL),(7,'La Salá','Calle José Velázquez Sánchez, Local 9, 41011 Sevilla','img/restaurants/nb0cbF6T4QSlZ0YDPMK3yCEJYTi8SFPAYPyLU8Ol.jpg','+34 955 44 00 30','mascriollomasperuano@gmail.com','http://www.facebook.com/Mascriollomasperuano/','Su nombre «Salá» viene de la palabra andaluza salero. La antigua dueña de este local era una mujer cubana y decían que tenía mucho salero, que era muy “salá”.',1,'2023-05-15 10:10:06','2023-05-15 10:10:41',2,-6.003305,37.375471,NULL),(8,'La Sede','Calle Regina 1 Local 7, 41003 Sevilla España','img/restaurants/wzbbj4moHkJBtPEeFJQ97nyg2Eb2rJq5E4cqvWT3.png','+34 655 44 43 33','lasede@lasede.es','http://www.facebook.com/people/La-Sede/100063700112220','La Sede es un pequeño bar de tapas situado en pleno centro de Sevilla, concretamente en la Plaza de la Encarnación, conocida como “las setas”.',1,'2023-05-15 10:20:02','2023-05-15 10:45:42',2,-5.991422,37.394839,NULL),(9,'Seis Tapas Bar','Plaza Nueva 7, 41001 Sevilla España','img/restaurants/3aK9nhKdenC2eYXdCV9fHJJIMnsiz1ZVVBKA9tZG.jpg','+34 955 44 00 30','info@tuhogarfueradecasa.com','https://www.tuhogarfueradecasa.com/en/seis/','SEIS es el proyecto más reciente del grupo Tu Hogar Fuera De Casa, 2017. Un todo en uno: Lobby Bar, restaurante, tapas, cócteles, música en vivo, espacios...',2,'2023-05-15 10:40:32','2023-05-15 10:41:42',3,-5.996538,37.388307,NULL),(10,'MareaViva','Calle de Luis Arenas Ladislao 151 Nervion Plaza, 41005 Sevilla','img/restaurants/xF8V2kw9oTWJyoF0ZbLYGoypVaAPOdeJUZgcJa9E.jpg','+34 954 57 41 76','info@grupoescaleno.es','http://mareavivasevilla.com/','Restaurante sencillo, especializado en platos de pescado, marisco, croquetas y minihamburguesas.',1,'2023-05-15 11:08:01','2023-05-15 11:08:01',3,-5.971024,37.385199,NULL),(11,'La Tizná','Calle Camilo José Cela, 1, 41018 Sevilla','img/restaurants/wDYdBenc8j1pezHs8xrAYyO3WtNx8Bh10Yr0lPQ1.jpg','+34 696 73 70 15','info@latizna.es','http://www.latizna.es/','La Tizná es un espacio versátil donde comprar, comer y beber productos frescos, locales, orgánicos, sostenibles y estacionales.',1,'2023-05-15 13:21:30','2023-05-15 13:21:30',3,-5.979487,37.380334,NULL),(12,'La Cantina Mexicana','Calle Francos 14 Pasaje, Centro, 41004 Sevilla','img/restaurants/p83Fp7PgcNHmJvwDLoqETCcqEAEi3KHDsuJPEjHj.jpg','+34 954 21 89 75','info@lacantinamexicana.es','http://lacantinamexicana.es/','Restaurante de cocina mexicana con decoración tradicional, donde se sirven platos pequeños, cerveza y margaritas.',1,'2023-05-15 13:24:02','2023-05-15 13:24:02',2,-5.992780,37.388372,NULL),(13,'Bar El Comercio','Calle Lineros 9, 41004 Sevilla España','img/restaurants/V4yMBkcgmNiRKKFoLT39QiePujOq8pjPm7SYIjuU.jpg','+34 670 82 90 53','barelcomercio@gmail.com','http://www.barelcomercio.com/','Mesas de forja, mármol y azulejos en un café de 1904 donde tomar chocolate con churros y aperitivos variados.',2,'2023-05-15 13:26:38','2023-05-15 13:26:38',1,-5.992280,37.390764,NULL),(14,'Chifa Tapas','Calle Barco 2 Esquina calle Joaquín Costa, 41002 Sevilla','img/restaurants/aMlN86jSnquAzFl9VvpoK87FNe8VzphaxUUQden3.jpg','+34 636 23 11 41','info@chifatapas.es','http://www.facebook.com/Chifatapas','Restaurante de comida fusión peruana-oriental, con un local que debes conocer.',2,'2023-05-15 13:29:36','2023-05-15 13:29:36',2,-5.993675,37.397285,NULL),(15,'Abantal','Calle Alcalde Jose de La Bandera 7, 41003 Sevilla','img/restaurants/YLCLpmrNUT0gmSlpoqTcDqXwi4C0mEyp8OK3sK6r.jpg','+34 954 54 00 00','info@abantalrestaurante.es','http://www.abantalrestaurante.es/','Menús degustación vanguardistas con variaciones modernas de la cocina andaluza y mesa del chef.',2,'2023-05-15 13:34:05','2023-05-15 13:34:05',4,-5.983714,37.387929,NULL),(16,'Hard Rock Cafe Sevilla','Calle San Fernando, 3 Junto Hotel Alfonso XIII, 41004 Sevilla','img/restaurants/WLNBlow5NDZHYN42tvVEA1nSSaZlcmeyeuEywhGy.jpg','+34 954 22 01 26','seville_social@hardrock.com','https://www.hardrockcafe.com/','Cadena de restaurantes de ambiente roquero con hamburguesas y clásicos de la cocina estadounidense.',2,'2023-05-15 13:36:46','2023-05-15 13:36:46',2,-5.992666,37.382396,NULL),(17,'Nickel burger','Calle de Lopez de Arenas 4 41001 Sevilla','img/restaurants/pgl3PZjF7QKYkmZYezuy2pV652sI7qvNqPmtac3T.jpg','+34 652 16 50 14','hola@nickelburger.com','http://www.nickelburger.com/','Nickel Burger es una hamburguesería en Sevilla que aporta un punto diferente y canalla a las hamburguesas clásicas.',1,'2023-05-15 13:39:14','2023-05-15 13:39:14',2,-5.998063,37.386936,NULL),(18,'Al Medina','Calle San Roque, 13 Plaza Del Museo, 41001 Sevilla','img/restaurants/kjAIeKY89juN27uoSvqGXsEKquIBnXxZaaBvLiQb.jpg','+34 954 21 54 51','reservas@restaurantealmedina.com','http://www.restaurantealmedina.com/contacto/','Restaurante ornamentado e inspirado en Marruecos, con mezze, tayines y baklava servidos con té.',2,'2023-05-15 13:43:47','2023-05-15 13:43:47',2,-5.998824,37.391460,NULL),(19,'El Enano Verde','Calle Feria, 61, 41002 Sevilla','img/restaurants/5IF0UmJopwkcXZftqvQES0X5LYcVHCxRLFF4m3sy.jpg','+34 646 45 97 17','elenanoverde-sevilla@hotmail.com','http://www.facebook.com/El-enano-verde-1333880363344598/','La cultura healthy que ha llegado de la mano de los millennial no es una moda.',1,'2023-05-15 13:47:40','2023-05-15 13:47:40',1,-5.991666,37.398366,NULL),(20,'Atticus Finch Burger','Mercado De La Calle Feria 98 Puesto 46, Sevilla','img/restaurants/johocbSUz5oE9ce3zRxMxScxsoleeBn2vEL42EQi.jpg','+34 610 16 56 63','atticusfinchburger@gmail.com','https://www.facebook.com/atticusfinchburger/','En Atticus Finch Burger, podrás disfrutar de unas deliciosas hamburguesas al más puro estilo americano, con ese pan brioche, una carne jugosa y picada a mano.',1,'2023-05-15 13:51:01','2023-05-15 13:51:01',1,-5.991694,37.399124,NULL),(21,'Döner Kebab El Zapatazo','Calle Peris Mencheta 23, 41002 Sevilla','img/restaurants/q9peDq0rS3NgfEiRnA54ehuNMFpQqaKRYcahg5Lx.jpg','+34 954 38 36 38','luna.joma1@gmail.com','http://www.alcazarandalusitapas.com/','El Zapatazo es un restaurante de kebab, que abrió sus puertas el año pasado cerca de la Alameda, concretamente en la calle Peris Mencheta.',1,'2023-05-15 13:54:51','2023-05-15 13:54:51',1,-5.992436,37.399392,NULL),(22,'Restaurante Gran Muralla','Plaza de Colón, 14001 Córdoba','img/restaurants/LIce2HXjILA9LzhP1w8gX9tugExB4xoxVNacUg2L.jpg','+34 957 49 12 36','contacto@granmurallacordoba.es','http://www.granmurallacordoba.es/','Cocina china y asiática en un espacio con paneles de madera lacada, murales orientales y servicio a domicilio.',1,'2023-05-15 14:37:33','2023-05-15 14:37:33',2,-4.777609,37.890254,NULL),(24,'Café bar Er Tito','Calle Jose Gestoso 11, 41003 Sevilla','img/restaurants/1684170482-er-tito.jpg','+34 618 09 60 33','robertocacciari@hotmail.com','https://www.facebook.com/errobertito','El Café Bar Er Tito, fundado en el año 2008, es una referencia de los desayunos del centro de Sevilla.',1,'2023-05-15 15:08:02','2023-05-15 15:08:02',1,-5.992941,37.393586,NULL),(25,'Ispal Restaurante','Plaza de San Sebastian 1, 41004 Sevilla','img/restaurants/1684170912-Ispal-1-1920x1080-1024x576.jpg','+34 955 54 71 27','reservas@restauranteispal.com','http://www.restauranteispal.com/','Menús degustación selectos inspirados en la cocina regional y maridajes con vino en un restaurante chic con terraza.',1,'2023-05-15 15:15:12','2023-05-15 15:15:12',4,-5.986527,37.381640,NULL),(26,'La Locanda di Andrea','Calle Feria 52, 41003 Sevilla','img/restaurants/1684171136-locanda.jpg','+34 955 18 35 60','locandadiandrea@gmail.com','http://www.facebook.com/La-Locanda-di-Andrea-1043913398983763/','Tapas caseras inspiradas en la cocina italiana servidas en un bar sencillo con terraza.',1,'2023-05-15 15:18:56','2023-05-15 15:18:56',1,-5.991251,37.395866,NULL),(27,'Burger foodporn','Avenida Finlandia, 41012 Sevilla','img/restaurants/1684271564-MG_0399.jpg','+34 653 16 32 50','burgerfoodporn@gmail.com','https://www.burgerfoodporn.com/','Restaurante informal y moderno, inspirado en las gastronetas y el arte callejero, con hamburguesas y cervezas exclusivas.',1,'2023-05-16 19:12:44','2023-05-16 19:12:44',2,-5.979618,37.343604,NULL),(28,'The Burger Shop','Avenida de la Ronda de Triana 11 15 Local, 41010 Sevilla','img/restaurants/1684271704-The-burguer-shop-847x435.jpg','+34 685 17 49 68','theburgershop2019@gmail.com','https://www.theburgershopsevilla.com/','The Burger Shop te ofrece la más exquisita variedad de Hamburguesas que puedes encontrar en Sevilla.',1,'2023-05-16 19:15:04','2023-05-16 19:15:04',2,-6.009512,37.381356,NULL);
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `restaurant_id` bigint(20) unsigned NOT NULL,
  `rate` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_restaurant_id_foreign` (`restaurant_id`),
  CONSTRAINT `reviews_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`),
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (23,'2023-05-15 15:56:16','2023-05-15 15:56:16',NULL,31,4,5),(24,'2023-05-15 15:57:03','2023-05-15 16:01:34',NULL,31,5,5),(27,'2023-05-15 16:07:28','2023-05-15 16:07:28',NULL,37,5,1),(28,'2023-05-15 16:07:59','2023-05-15 16:07:59',NULL,39,5,2),(29,'2023-05-16 18:24:25','2023-05-16 18:24:25',NULL,31,7,2),(30,'2023-05-16 18:24:41','2023-05-16 18:24:41',NULL,31,8,4),(31,'2023-05-16 18:24:50','2023-05-16 18:24:50',NULL,31,9,5),(32,'2023-05-16 18:25:02','2023-05-16 18:25:02',NULL,31,10,1),(33,'2023-05-16 18:25:14','2023-05-16 18:25:14',NULL,31,11,1),(34,'2023-05-16 18:25:23','2023-05-16 18:25:23',NULL,31,12,5),(35,'2023-05-16 18:25:31','2023-05-16 18:25:31',NULL,31,13,5),(36,'2023-05-16 18:25:39','2023-05-16 18:25:39',NULL,31,14,3),(37,'2023-05-16 18:25:47','2023-05-16 18:25:47',NULL,31,15,5),(38,'2023-05-16 18:25:57','2023-05-16 18:25:57',NULL,31,16,2),(39,'2023-05-16 18:59:35','2023-05-16 18:59:35',NULL,31,17,4),(40,'2023-05-16 18:59:43','2023-05-16 18:59:43',NULL,31,18,2),(41,'2023-05-16 18:59:50','2023-05-16 18:59:50',NULL,31,19,4),(42,'2023-05-16 18:59:56','2023-05-16 18:59:56',NULL,31,20,5),(43,'2023-05-16 19:00:04','2023-05-16 19:00:04',NULL,31,21,1),(44,'2023-05-16 19:00:11','2023-05-16 19:00:11',NULL,31,22,1),(45,'2023-05-16 19:01:31','2023-05-16 19:01:31',NULL,31,24,4),(46,'2023-05-16 19:01:40','2023-05-16 19:01:40',NULL,31,25,3),(47,'2023-05-16 19:01:48','2023-05-16 19:01:48',NULL,31,26,4),(48,'2023-05-16 19:15:35','2023-05-16 19:15:35',NULL,31,27,3),(49,'2023-05-16 19:15:42','2023-05-16 19:15:42',NULL,31,28,3),(50,'2023-05-17 18:05:55','2023-05-17 18:05:55',NULL,40,4,4),(52,'2023-05-21 13:40:59','2023-05-21 13:42:31','Visita <a src=\"https://www.chollometro.com\">Chollo</a>',38,4,4),(53,'2023-05-22 09:43:04','2023-05-22 09:43:39','The b',28,5,4);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (1,'Breakfast'),(2,'Lunch'),(3,'Dinner');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_food_preferences`
--

DROP TABLE IF EXISTS `user_food_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_food_preferences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `latitude` decimal(9,6) NOT NULL,
  `longitude` decimal(9,6) NOT NULL,
  `terrace` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_food_preferences`
--

LOCK TABLES `user_food_preferences` WRITE;
/*!40000 ALTER TABLE `user_food_preferences` DISABLE KEYS */;
INSERT INTO `user_food_preferences` VALUES (28,37.372794,-6.195615,1,'2023-04-24 10:04:41','2023-05-22 18:23:23'),(31,37.393119,-5.991853,1,'2023-05-07 12:51:28','2023-05-22 11:07:29'),(34,37.388630,-5.995340,1,'2023-05-14 13:17:23','2023-05-14 13:17:23'),(36,37.257587,-6.948495,1,'2023-05-14 13:20:05','2023-05-14 13:20:05'),(37,37.341652,-6.060788,2,'2023-05-15 06:28:01','2023-05-15 06:28:01'),(38,37.347095,-6.038155,2,'2023-05-15 08:02:14','2023-05-15 08:02:14'),(39,37.347095,-6.038155,1,'2023-05-15 16:04:45','2023-05-15 16:29:30'),(40,37.394845,-5.991464,1,'2023-05-17 16:01:08','2023-05-17 18:35:42'),(42,37.399124,-5.991694,1,'2023-05-22 04:36:37','2023-05-22 04:36:37');
/*!40000 ALTER TABLE `user_food_preferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_food_preferences_has_food_types`
--

DROP TABLE IF EXISTS `user_food_preferences_has_food_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_food_preferences_has_food_types` (
  `food_type_id` bigint(20) unsigned NOT NULL,
  `user_food_preference_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`food_type_id`,`user_food_preference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_food_preferences_has_food_types`
--

LOCK TABLES `user_food_preferences_has_food_types` WRITE;
/*!40000 ALTER TABLE `user_food_preferences_has_food_types` DISABLE KEYS */;
INSERT INTO `user_food_preferences_has_food_types` VALUES (1,31),(1,40),(2,38),(4,28),(4,31),(4,40),(4,42),(6,36),(6,37),(8,28),(8,31),(8,42),(9,28),(9,31),(9,34),(9,40),(10,28),(10,37),(11,28),(12,28),(13,28),(14,28),(15,28),(15,39);
/*!40000 ALTER TABLE `user_food_preferences_has_food_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_food_preferences_has_price_ranges`
--

DROP TABLE IF EXISTS `user_food_preferences_has_price_ranges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_food_preferences_has_price_ranges` (
  `price_range_id` bigint(20) unsigned NOT NULL,
  `user_food_preference_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`price_range_id`,`user_food_preference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_food_preferences_has_price_ranges`
--

LOCK TABLES `user_food_preferences_has_price_ranges` WRITE;
/*!40000 ALTER TABLE `user_food_preferences_has_price_ranges` DISABLE KEYS */;
INSERT INTO `user_food_preferences_has_price_ranges` VALUES (1,28),(1,31),(1,39),(1,40),(2,28),(2,31),(2,36),(2,38),(2,40),(3,28),(3,34),(3,38),(3,42),(4,28),(4,37);
/*!40000 ALTER TABLE `user_food_preferences_has_price_ranges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_food_preferences_has_schedules`
--

DROP TABLE IF EXISTS `user_food_preferences_has_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_food_preferences_has_schedules` (
  `schedule_id` bigint(20) unsigned NOT NULL,
  `user_food_preference_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`schedule_id`,`user_food_preference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_food_preferences_has_schedules`
--

LOCK TABLES `user_food_preferences_has_schedules` WRITE;
/*!40000 ALTER TABLE `user_food_preferences_has_schedules` DISABLE KEYS */;
INSERT INTO `user_food_preferences_has_schedules` VALUES (1,28),(1,31),(1,39),(2,28),(2,31),(2,36),(2,38),(2,40),(3,28),(3,31),(3,34),(3,37),(3,40),(3,42);
/*!40000 ALTER TABLE `user_food_preferences_has_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `user_food_preferences_id` bigint(20) unsigned NOT NULL,
  `strikes` int(11) DEFAULT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT 0,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_user_food_preferences_id_foreign` (`user_food_preferences_id`),
  CONSTRAINT `users_user_food_preferences_id_foreign` FOREIGN KEY (`user_food_preferences_id`) REFERENCES `user_food_preferences` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (28,'admin@admin.com',NULL,'$2y$10$oCVRgxyJyH2MxaNOG1D.1Oh2u1ayLQ2XivL4emIvTM2NQXl4GIsTq','X92yzaWMbAf1yXShN4QuhHaxlwc9NqeiX8RkVfo6uTd6xER3n7ueaGOUbizD','2023-04-24 10:04:42','2023-05-22 15:21:38','admin','admins','admin',28,NULL,0,0),(31,'monty@gmail.com',NULL,'$2y$10$rAkrEY0KUIh3pKSVitVRhubSr96kTxpXnJYJ95nwXvpxw/HuUrx.m',NULL,'2023-05-07 12:51:28','2023-05-15 15:54:59','José Carlos','Montañés','user',31,NULL,0,0),(34,'fran@gmail.com',NULL,'$2y$10$H26ZyiTl2O0amwR.nxUIteRvUjPvb/VakP3pIMPdP.AIYq9LgbFbi',NULL,'2023-05-14 13:17:23','2023-05-15 16:03:51','Fran','Espinosa','user',34,NULL,0,0),(36,'ruben@ruben.com',NULL,'$2y$10$EDiocgXPgF0i6F5MMSgXFee0e8hs4oKKWbsNu8Y.RDUITuJqLlfwW',NULL,'2023-05-14 13:20:05','2023-05-21 13:39:40','Ruben','Perez','admin',36,2,0,0),(37,'francisco@gmail.com',NULL,'$2y$10$yZweOLyZE28qSCXMWR7/UuWEBcjVBBXWTuJU7sO2NnGz84vaJ2/2G',NULL,'2023-05-15 06:28:01','2023-05-15 16:04:07','Francisco','López','user',37,NULL,0,0),(38,'angel@gmail.com',NULL,'$2y$10$geo7c2tJoSutkYpKV.N5B.QWVllZOuM0ZvZ2NjhnDD0kzFOCTV5Z6',NULL,'2023-05-15 08:02:14','2023-05-22 09:45:43','Angel','Perez','user',38,1,0,0),(39,'jesus@gmail.com',NULL,'$2y$10$/iTvHT6NdrR/G221Tv5e2.n85/j5o/G.65N./kiQA2hh7f08zd852',NULL,'2023-05-15 16:04:45','2023-05-20 19:57:12','Jesús','Fernández','user',39,NULL,0,0),(40,'teresa@gmail.com',NULL,'$2y$10$6TM0xlz5wEG4DhPSjzhU2OO9PAcLb9rMTeOxEzb/dyiL7C5oQ4tZ2','FfIhB1h0bQ7sTSijWgIg3yrug7xTXbhyEoMJA8sfdU76BejDhvMPjy7EWWx8','2023-05-17 16:01:08','2023-05-17 16:01:08','Teresa','López','user',40,NULL,0,0),(42,'maria@gmail.com',NULL,'$2y$10$MCRiUvp825RsjPMUhNGcrue.p1YT/lUuWnj9Ig1tmdNuFXPPv6zbW',NULL,'2023-05-22 04:36:38','2023-05-22 04:36:38','María','Gómez','user',42,NULL,0,0);
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

-- Dump completed on 2023-05-22 23:50:21
