-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: kizumba
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `artists`
--

DROP TABLE IF EXISTS `artists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('professeur','dj') COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `display_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artists`
--

LOCK TABLES `artists` WRITE;
/*!40000 ALTER TABLE `artists` DISABLE KEYS */;
INSERT INTO `artists` VALUES (1,'GAZL & COLIBRI','professeur','Kizomba','France','🇫🇷',NULL,NULL,'artists/f9wrRaCwhp2l9XtdoTWbgkrF1RqK7ju0v4vdAywb.png',1,2,'2026-04-09 19:40:46','2026-04-09 22:47:06'),(2,'SAID STREET','professeur','Urban Kiz','France','🇫🇷',NULL,NULL,'artists/VvnMebEkr8NYz1AqThDi14cGjNiXmsseWd2Y01yR.png',1,0,'2026-04-09 22:44:11','2026-04-09 22:53:37'),(3,'DJ FOFO JAH','dj','DJ Set / Tarraxo','France','🇫🇷',NULL,NULL,'artists/UxVw6iFOcYPIyAuFjJdFrMIzGOkiT9X6M8iOCbL7.png',1,1,'2026-04-09 22:45:17','2026-04-09 22:45:17'),(4,'DJ THEMOZ','dj','DJ Set','Bénin','🇧🇯',NULL,NULL,'artists/KIo8PnsS3A0B9E7XcW9gwQ7tosbn9hcOw219KuFD.png',1,2,'2026-04-09 22:46:08','2026-04-09 22:46:08'),(5,'SEAN','professeur','Semba','Côte d\'Ivoire','🇨🇮',NULL,NULL,'artists/IvMcXh0HAu2RGORGIxFnjzPSGDCOmMT4bM4RUAUl.png',1,3,'2026-04-09 22:47:59','2026-04-09 22:47:59'),(6,'OMOWISE & TENI','professeur','Kizomba','Ghana','🇬🇭',NULL,NULL,'artists/GuV7RsDZpy0tKbYB1DDBd98cA2hB2pHY7opajGxW.png',1,4,'2026-04-09 22:50:27','2026-04-09 22:50:27'),(7,'YASUKE & KALINKA','professeur','Kompa','Côte d\'Ivoire','🇨🇮',NULL,NULL,'artists/lwVRLA2iaPbEkBzc6DORrjqltaYCmPThmRaUm3t7.png',1,7,'2026-04-09 22:51:29','2026-04-09 22:56:36'),(8,'QUINN WANG','professeur','Urban Kiz','Chine','🇨🇳',NULL,NULL,'artists/upp6xh490y2KZ3Go07qrrxB0NnlprnS6wQ7iUHW8.png',1,5,'2026-04-09 22:53:25','2026-04-09 22:53:25'),(9,'AUREA & TRESOR','professeur','Kizomba','France & Hollande','🇫🇷 🇳🇱',NULL,NULL,'artists/7ORuflFzenOU3aMhRHIDIW9W1GQ3xr2R4kk6rEK4.png',1,6,'2026-04-09 22:56:04','2026-04-09 22:56:04'),(10,'LEDOUX KINGSMAN','professeur','Kizomba','France','🇫🇷',NULL,NULL,'artists/nNVV640XzeadhslaYUffnZ7h7PgVSUcGza06S6pg.png',1,8,'2026-04-09 22:59:44','2026-04-09 22:59:44'),(11,'DJ GOBEDSON','dj','DJ Set','France','🇫🇷',NULL,NULL,'artists/tswpXJWM09kttOZhs7anlulDi8MjRBm4XkpR3MIA.png',1,2,'2026-04-09 23:00:54','2026-04-09 23:00:54'),(12,'DJ MILKSHAKE','dj','DJ Set','France','🇫🇷',NULL,NULL,'artists/xG5pNp9cRu1KAZT6EVejHnYlJlFv9ZaYRclvye7Z.png',1,4,'2026-04-09 23:01:31','2026-04-09 23:01:31');
/*!40000 ALTER TABLE `artists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('united-kizdom-world-congress-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1775861525),('united-kizdom-world-congress-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1775861525;',1775861525);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `issued_tickets`
--

DROP TABLE IF EXISTS `issued_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `issued_tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` bigint unsigned NOT NULL,
  `ticket_id` bigint unsigned NOT NULL,
  `ticket_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_paid` bigint unsigned NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FCFA',
  `holder_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holder_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holder_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','used','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_sent` tinyint(1) NOT NULL DEFAULT '0',
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `issued_tickets_uid_unique` (`uid`),
  KEY `issued_tickets_payment_id_foreign` (`payment_id`),
  KEY `issued_tickets_ticket_id_foreign` (`ticket_id`),
  CONSTRAINT `issued_tickets_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `issued_tickets_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issued_tickets`
--

LOCK TABLES `issued_tickets` WRITE;
/*!40000 ALTER TABLE `issued_tickets` DISABLE KEYS */;
INSERT INTO `issued_tickets` VALUES (1,'PKC-WAA2M970',21,3,'Parties Only',50000,'FCFA','Acheteur','vosej74099@nyspring.com','+225015485','active',0,NULL,'2026-04-10 00:06:33','2026-04-10 00:06:33'),(2,'PKC-GLSUAOHQ',21,7,'Full Pass & Stay — Single Premium',390000,'XOF','Acheteur','vosej74099@nyspring.com','+225015485','active',0,NULL,'2026-04-10 00:06:33','2026-04-10 00:06:33'),(3,'PKC-LXPKL8GP',21,8,'Full Pass & Stay — Single Luxury',415000,'XOF','Acheteur','vosej74099@nyspring.com','+225015485','active',0,NULL,'2026-04-10 00:06:33','2026-04-10 00:06:33'),(4,'PKC-DAQML44E',22,5,'Classes Only',60000,'FCFA','José','vosej74099@nyspring.com','+225055855','active',0,NULL,'2026-04-10 00:11:39','2026-04-10 00:11:39'),(5,'PKC-SEYUMQKX',23,4,'Tourism Pack',70000,'FCFA','Tourism','vosej74099@nyspring.com','2555885','active',1,NULL,'2026-04-10 00:36:35','2026-04-10 01:13:58'),(6,'PKC-3USODYEP',24,2,'Parties & Classes',90000,'FCFA','fULL','vosej74099@nyspring.com','+5656465464','active',1,NULL,'2026-04-10 01:16:16','2026-04-10 01:16:26'),(7,'PKC-L59T9HVX',25,3,'Parties Only',50000,'FCFA','Jean Dupont','vosej74099@nyspring.com',NULL,'active',1,NULL,'2026-04-10 01:42:29','2026-04-10 01:42:52'),(8,'PKC-N2TGS1OE',27,5,'Classes Only',60000,'FCFA','Kevin ADJALIAN','Kevadjalian@gmail.com','+22901020304','active',1,NULL,'2026-04-10 10:16:59','2026-04-10 10:17:03'),(9,'PKC-TRLD5YMM',28,5,'Classes Only',54000,'FCFA','Ariel','vosej74099@nyspring.com','+225665526555','active',1,NULL,'2026-04-10 20:30:36','2026-04-10 20:30:40'),(10,'PKC-IKPGQAYF',28,4,'Tourism Pack',63000,'FCFA','Ariel','vosej74099@nyspring.com','+225665526555','active',1,NULL,'2026-04-10 20:30:36','2026-04-10 20:30:42');
/*!40000 ALTER TABLE `issued_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_04_08_180000_create_tickets_table',1),(5,'2026_04_08_190000_create_payments_table',1),(6,'2026_04_08_194657_create_issued_tickets_table',1),(7,'2026_04_08_194658_add_role_to_users_table',2),(8,'2026_04_08_195736_create_personal_access_tokens_table',2),(9,'2026_04_08_202033_add_columns_to_payments_table',2),(10,'2026_04_08_202033_add_columns_to_tickets_table',2),(11,'2026_04_09_000001_create_artists_table',3),(12,'2026_04_09_000002_add_image_to_tickets_table',3),(13,'2026_04_10_000001_add_early_bird_to_tickets_table',4),(14,'2026_04_10_000002_create_promo_codes_table',4),(15,'2026_04_10_000003_add_discount_to_payments_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tx_ref` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paydunya_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','completed','failed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `amount` bigint unsigned NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FCFA',
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart_items` json NOT NULL,
  `paydunya_response` json DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `promo_code_id` bigint unsigned DEFAULT NULL,
  `discount_amount` bigint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_tx_ref_unique` (`tx_ref`),
  KEY `payments_promo_code_id_foreign` (`promo_code_id`),
  CONSTRAINT `payments_promo_code_id_foreign` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,'PKC-HQB0OOFCYGAS',NULL,'failed',120000,'FCFA','Test','test@test.com',NULL,'[{\"name\": \"Full Pass\", \"slug\": \"full-pass\", \"quantity\": 1, \"unit_price\": 120000, \"description\": \"Accès complet à toutes les activités du festival\"}]',NULL,NULL,'2026-04-09 01:29:44','2026-04-09 01:29:45',NULL,0),(2,'PKC-JPYZECWIPTLC',NULL,'failed',355000,'FCFA','Test','test@test.com',NULL,'[{\"name\": \"Full Pass & Stay — Single Standard\", \"slug\": \"fps-single-standard\", \"quantity\": 1, \"unit_price\": 355000, \"description\": \"Full pass + hébergement single standard (2 pers. max)\"}]',NULL,NULL,'2026-04-09 01:36:12','2026-04-09 01:36:12',NULL,0),(3,'PKC-XUTGK2ROIWZW',NULL,'failed',120000,'FCFA','Test','ton@email.com',NULL,'[{\"name\": \"Full Pass\", \"slug\": \"full-pass\", \"quantity\": 1, \"unit_price\": 120000, \"description\": \"Accès complet à toutes les activités du festival\"}]',NULL,NULL,'2026-04-09 02:54:26','2026-04-09 02:54:26',NULL,0),(4,'PKC-L9HTP6WYK3QN',NULL,'failed',120000,'FCFA','Test','sodjinoukevin13@gmail.com',NULL,'[{\"name\": \"Full Pass\", \"slug\": \"full-pass\", \"quantity\": 1, \"unit_price\": 120000, \"description\": \"Accès complet à toutes les activités du festival\"}]',NULL,NULL,'2026-04-09 02:55:07','2026-04-09 02:55:07',NULL,0),(5,'PKC-WINSYIPLPTIW',NULL,'failed',120000,'FCFA','Test','sodjinoukevin13@gmail.com',NULL,'[{\"name\": \"Full Pass\", \"slug\": \"full-pass\", \"quantity\": 1, \"unit_price\": 120000, \"description\": \"Accès complet à toutes les activités du festival\"}]',NULL,NULL,'2026-04-09 03:00:49','2026-04-09 03:00:50',NULL,0),(6,'PKC-BSXOODNRZXV4','test_1pcwpgLsfA','pending',120000,'FCFA','Test','sodjinoukevin13@gmail.com',NULL,'[{\"name\": \"Full Pass\", \"slug\": \"full-pass\", \"quantity\": 1, \"unit_price\": 120000, \"description\": \"Accès complet à toutes les activités du festival\"}]',NULL,NULL,'2026-04-09 03:02:52','2026-04-09 03:02:52',NULL,0),(7,'PKC-IB4UJPTANBIX','test_QfXHKUVfxK','pending',120000,'FCFA','Test','test@test.com',NULL,'[{\"name\": \"Full Pass\", \"slug\": \"full-pass\", \"quantity\": 1, \"unit_price\": 120000, \"description\": \"Accès complet à toutes les activités du festival\"}]',NULL,NULL,'2026-04-09 03:09:33','2026-04-09 03:09:33',NULL,0),(8,'PKC-GVKNFOO7ICQY','test_g0yQ4VGOjE','pending',120000,'FCFA','Test','test@test.com',NULL,'[{\"name\": \"Full Pass\", \"slug\": \"full-pass\", \"quantity\": 1, \"unit_price\": 120000, \"description\": \"Accès complet à toutes les activités du festival\"}]',NULL,NULL,'2026-04-09 03:15:27','2026-04-09 03:15:27',NULL,0),(9,'PKC-13S1SIR3UCWP','test_ATlFqR0afr','pending',120000,'FCFA','Test','test@test.com',NULL,'[{\"name\": \"Full Pass\", \"slug\": \"full-pass\", \"quantity\": 1, \"unit_price\": 120000, \"description\": \"Accès complet à toutes les activités du festival\"}]',NULL,NULL,'2026-04-09 04:16:41','2026-04-09 04:16:42',NULL,0),(10,'PKC-2OBKQZ5SB9LW','test_zTn1R0Q3SI','pending',60000,'FCFA','greger','gyuyerhv@vjhve.eirjve','+225001545555','[{\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\"}]',NULL,NULL,'2026-04-09 10:59:03','2026-04-09 10:59:05',NULL,0),(11,'PKC-IXYUYVB3R04F','test_YXw2lW5pBr','pending',180000,'FCFA','Testeur','sodjinoukevin13@gmail.com','+22505557565','[{\"name\": \"Parties Only\", \"slug\": \"parties-only\", \"quantity\": 1, \"unit_price\": 50000, \"description\": \"Accès uniquement aux soirées\"}, {\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\"}, {\"name\": \"Tourism Pack\", \"slug\": \"tourism\", \"quantity\": 1, \"unit_price\": 70000, \"description\": \"Découverte touristique autour du festival\"}]',NULL,NULL,'2026-04-09 11:27:39','2026-04-09 11:27:40',NULL,0),(12,'PKC-UMPCB6YJPO90','test_dD2YNObB6v','pending',60000,'FCFA','vekhvni','nvjienv@chejrbv.com','+22565546525','[{\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\"}]',NULL,NULL,'2026-04-09 11:31:38','2026-04-09 11:31:39',NULL,0),(13,'PKC-CY4RLHYIYW8H','test_Y5VMOiKyyI','pending',50000,'FCFA','Ariel','sodjinoukevin13@gmail.com','+22564788595','[{\"name\": \"Parties Only\", \"slug\": \"parties-only\", \"quantity\": 1, \"unit_price\": 50000, \"description\": \"Accès uniquement aux soirées\"}]',NULL,NULL,'2026-04-09 11:36:47','2026-04-09 11:36:48',NULL,0),(14,'PKC-BT3CY5BVXBY2','test_UuDI9VXLfx','pending',50000,'FCFA','jean dupont','sodjinoukevin13@gmail.com','+225021555596','[{\"name\": \"Parties Only\", \"slug\": \"parties-only\", \"quantity\": 1, \"unit_price\": 50000, \"description\": \"Accès uniquement aux soirées\"}]',NULL,NULL,'2026-04-09 11:45:53','2026-04-09 11:45:53',NULL,0),(15,'PKC-M6DCEIACRDTS','test_1m6kV7vHuu','pending',30000,'FCFA','Test','test@test.com','+22515456565','[{\"name\": \"Shape Your Experience — Standard\", \"slug\": \"sye-standard\", \"quantity\": 1, \"unit_price\": 30000, \"description\": \"Hébergement standard (2 pers. max) — tarif par nuit\"}]',NULL,NULL,'2026-04-09 11:52:49','2026-04-09 11:52:49',NULL,0),(16,'PKC-MZNEN9HON3WL','test_6nEzeQRRJV','pending',50000,'FCFA','test','test@test.com','+22555665','[{\"name\": \"Parties Only\", \"slug\": \"parties-only\", \"quantity\": 1, \"unit_price\": 50000, \"description\": \"Accès uniquement aux soirées\"}]',NULL,NULL,'2026-04-09 11:53:55','2026-04-09 11:53:56',NULL,0),(17,'PKC-ZC5OKURZOCPG','test_QwFOTdbKmA','pending',60000,'FCFA','Test','test@gmail.com','+2250202024','[{\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\"}]',NULL,NULL,'2026-04-09 12:00:12','2026-04-09 12:00:12',NULL,0),(18,'PKC-PPBW77YF1J2N','test_BiKZXux0cO','pending',60000,'FCFA','sjtyksjrdj','test@gmail.com','+3301022655','[{\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\"}]',NULL,NULL,'2026-04-09 13:08:13','2026-04-09 13:08:14',NULL,0),(19,'PKC-KJ5F8S3N8RVV','test_lB8OIAZda3','pending',60000,'FCFA','Test','test@gmail.com','+225974165416','[{\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\"}]',NULL,NULL,'2026-04-09 23:17:57','2026-04-09 23:17:58',NULL,0),(20,'PKC-KHJJHP2IVOUH','test_F9X4g8Dybt','pending',60000,'FCFA','ACHAT','vosej74099@nyspring.com','+2250155888','[{\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\"}]',NULL,NULL,'2026-04-09 23:49:51','2026-04-09 23:49:52',NULL,0),(21,'PKC-VWN97NKEZ6PW','test_c3jZFfFcSw','completed',855000,'FCFA','Acheteur','vosej74099@nyspring.com','+225015485','[{\"name\": \"Parties Only\", \"slug\": \"parties-only\", \"quantity\": 1, \"unit_price\": 50000, \"description\": \"Accès uniquement aux soirées\"}, {\"name\": \"Full Pass & Stay — Single Premium\", \"slug\": \"fps-single-premium\", \"quantity\": 1, \"unit_price\": 390000, \"description\": \"Full pass + hébergement single premium (2 pers. max)\"}, {\"name\": \"Full Pass & Stay — Single Luxury\", \"slug\": \"fps-single-luxury\", \"quantity\": 1, \"unit_price\": 415000, \"description\": \"Full pass + hébergement single luxe (2 pers. max)\"}]','{\"hash\": \"db61f851d3f862a00effe31b5958f41ddad09758e1beccc516d7279de39a73ccf860fa39a4a6ed4b8da98ff5129dd4c1426884efbf491c8291cdcfe7a13664df\", \"mode\": \"test\", \"status\": \"completed\", \"actions\": {\"cancel_url\": \"http://localhost:3000/shop\", \"return_url\": \"http://localhost:3000/checkout?tx_ref=PKC-VWN97NKEZ6PW\", \"callback_url\": \"https://peacefully-intercrinal-brigitte.ngrok-free.dev/api/webhooks/paydunya\"}, \"invoice\": {\"items\": {\"item_0\": {\"name\": \"Parties Only\", \"quantity\": 1, \"unit_price\": 50000, \"description\": \"Accès uniquement aux soirées\", \"total_price\": 50000}, \"item_1\": {\"name\": \"Full Pass & Stay — Single Premium\", \"quantity\": 1, \"unit_price\": 390000, \"description\": \"Full pass + hébergement single premium (2 pers. max)\", \"total_price\": 390000}, \"item_2\": {\"name\": \"Full Pass & Stay — Single Luxury\", \"quantity\": 1, \"unit_price\": 415000, \"description\": \"Full pass + hébergement single luxe (2 pers. max)\", \"total_price\": 415000}}, \"taxes\": [], \"token\": \"test_c3jZFfFcSw\", \"description\": \"United Kizdom World Congress — Pass festival\", \"total_amount\": 855000}, \"customer\": {\"name\": \"Test\", \"email\": \"sodjinoukevin13@gmail.com\", \"phone\": \"0502407474\"}, \"custom_data\": {\"tx_ref\": \"PKC-VWN97NKEZ6PW\"}, \"receipt_url\": \"https://paydunya.com/sandbox-checkout/receipt/pdf/test_c3jZFfFcSw.pdf\", \"response_code\": \"00\", \"response_text\": \"Transaction Found\"}','2026-04-10 00:06:32','2026-04-09 23:52:02','2026-04-10 00:06:32',NULL,0),(22,'PKC-8B5AO7WWKUAV','test_9mt0jvv5jB','completed',60000,'FCFA','José','vosej74099@nyspring.com','+225055855','[{\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\"}]','{\"hash\": \"db61f851d3f862a00effe31b5958f41ddad09758e1beccc516d7279de39a73ccf860fa39a4a6ed4b8da98ff5129dd4c1426884efbf491c8291cdcfe7a13664df\", \"mode\": \"test\", \"status\": \"completed\", \"actions\": {\"cancel_url\": \"http://localhost:3000/shop\", \"return_url\": \"http://localhost:3000/checkout?tx_ref=PKC-8B5AO7WWKUAV\", \"callback_url\": \"https://peacefully-intercrinal-brigitte.ngrok-free.dev/api/webhooks/paydunya\"}, \"invoice\": {\"items\": {\"item_0\": {\"name\": \"Classes Only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\", \"total_price\": 60000}}, \"taxes\": [], \"token\": \"test_9mt0jvv5jB\", \"description\": \"United Kizdom World Congress — Pass festival\", \"total_amount\": 60000}, \"customer\": {\"name\": \"Test\", \"email\": \"sodjinoukevin13@gmail.com\", \"phone\": \"0502407474\"}, \"custom_data\": {\"tx_ref\": \"PKC-8B5AO7WWKUAV\"}, \"receipt_url\": \"https://paydunya.com/sandbox-checkout/receipt/pdf/test_9mt0jvv5jB.pdf\", \"response_code\": \"00\", \"response_text\": \"Transaction Found\"}','2026-04-10 00:11:39','2026-04-10 00:11:17','2026-04-10 00:11:39',NULL,0),(23,'PKC-R23YH74Y2VH9','test_haL3uL3PsI','completed',70000,'FCFA','Tourism','vosej74099@nyspring.com','2555885','[{\"name\": \"Tourism Pack\", \"slug\": \"tourism\", \"quantity\": 1, \"unit_price\": 70000, \"description\": \"Découverte touristique autour du festival\"}]','{\"hash\": \"db61f851d3f862a00effe31b5958f41ddad09758e1beccc516d7279de39a73ccf860fa39a4a6ed4b8da98ff5129dd4c1426884efbf491c8291cdcfe7a13664df\", \"mode\": \"test\", \"status\": \"completed\", \"actions\": {\"cancel_url\": \"http://localhost:3000/shop\", \"return_url\": \"http://localhost:3000/checkout?tx_ref=PKC-R23YH74Y2VH9\", \"callback_url\": \"https://peacefully-intercrinal-brigitte.ngrok-free.dev/api/webhooks/paydunya\"}, \"invoice\": {\"items\": {\"item_0\": {\"name\": \"Tourism Pack\", \"quantity\": 1, \"unit_price\": 70000, \"description\": \"Découverte touristique autour du festival\", \"total_price\": 70000}}, \"taxes\": [], \"token\": \"test_haL3uL3PsI\", \"description\": \"United Kizdom World Congress — Pass festival\", \"total_amount\": 70000}, \"customer\": {\"name\": \"Test\", \"email\": \"sodjinoukevin13@gmail.com\", \"phone\": \"0502407474\"}, \"custom_data\": {\"tx_ref\": \"PKC-R23YH74Y2VH9\"}, \"receipt_url\": \"https://paydunya.com/sandbox-checkout/receipt/pdf/test_haL3uL3PsI.pdf\", \"response_code\": \"00\", \"response_text\": \"Transaction Found\"}','2026-04-10 00:36:35','2026-04-10 00:36:25','2026-04-10 00:36:35',NULL,0),(24,'PKC-3URI07IQLKZP','test_LcHz2LHDg2','completed',90000,'FCFA','fULL','vosej74099@nyspring.com','+5656465464','[{\"name\": \"Parties & Classes\", \"slug\": \"parties-classes\", \"quantity\": 1, \"unit_price\": 90000, \"description\": \"Accès aux soirées et aux cours sélectionnés\"}]','{\"hash\": \"db61f851d3f862a00effe31b5958f41ddad09758e1beccc516d7279de39a73ccf860fa39a4a6ed4b8da98ff5129dd4c1426884efbf491c8291cdcfe7a13664df\", \"mode\": \"test\", \"status\": \"completed\", \"actions\": {\"cancel_url\": \"http://localhost:3000/shop\", \"return_url\": \"http://localhost:3000/checkout?tx_ref=PKC-3URI07IQLKZP\", \"callback_url\": \"https://peacefully-intercrinal-brigitte.ngrok-free.dev/api/webhooks/paydunya\"}, \"invoice\": {\"items\": {\"item_0\": {\"name\": \"Parties & Classes\", \"quantity\": 1, \"unit_price\": 90000, \"description\": \"Accès aux soirées et aux cours sélectionnés\", \"total_price\": 90000}}, \"taxes\": [], \"token\": \"test_LcHz2LHDg2\", \"description\": \"United Kizdom World Congress — Pass festival\", \"total_amount\": 90000}, \"customer\": {\"name\": \"Test\", \"email\": \"sodjinoukevin13@gmail.com\", \"phone\": \"0502407474\"}, \"custom_data\": {\"tx_ref\": \"PKC-3URI07IQLKZP\"}, \"receipt_url\": \"https://paydunya.com/sandbox-checkout/receipt/pdf/test_LcHz2LHDg2.pdf\", \"response_code\": \"00\", \"response_text\": \"Transaction Found\"}','2026-04-10 01:16:16','2026-04-10 01:16:07','2026-04-10 01:16:16',NULL,0),(25,'PKC-P0353IBJ95N2','test_TEK8dEykXs','completed',50000,'FCFA','Jean Dupont','vosej74099@nyspring.com',NULL,'[{\"name\": \"Parties Only\", \"slug\": \"parties-only\", \"quantity\": 1, \"unit_price\": 50000, \"description\": \"Accès uniquement aux soirées\"}]','{\"hash\": \"db61f851d3f862a00effe31b5958f41ddad09758e1beccc516d7279de39a73ccf860fa39a4a6ed4b8da98ff5129dd4c1426884efbf491c8291cdcfe7a13664df\", \"mode\": \"test\", \"status\": \"completed\", \"actions\": {\"cancel_url\": \"http://localhost:3000/shop\", \"return_url\": \"http://localhost:3000/checkout?tx_ref=PKC-P0353IBJ95N2\", \"callback_url\": \"https://peacefully-intercrinal-brigitte.ngrok-free.dev/api/webhooks/paydunya\"}, \"invoice\": {\"items\": {\"item_0\": {\"name\": \"Parties Only\", \"quantity\": 1, \"unit_price\": 50000, \"description\": \"Accès uniquement aux soirées\", \"total_price\": 50000}}, \"taxes\": [], \"token\": \"test_TEK8dEykXs\", \"description\": \"United Kizdom World Congress — Pass festival\", \"total_amount\": 50000}, \"customer\": {\"name\": \"Test\", \"email\": \"sodjinoukevin13@gmail.com\", \"phone\": \"0502407474\"}, \"custom_data\": {\"tx_ref\": \"PKC-P0353IBJ95N2\"}, \"receipt_url\": \"https://paydunya.com/sandbox-checkout/receipt/pdf/test_TEK8dEykXs.pdf\", \"response_code\": \"00\", \"response_text\": \"Transaction Found\"}','2026-04-10 01:42:29','2026-04-10 01:42:19','2026-04-10 01:42:29',NULL,0),(26,'PKC-H0VBSI4KZABN',NULL,'failed',60000,'FCFA','Kevin ADJALIAN','Kevadjalian@gmail.com',NULL,'[{\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\"}]',NULL,NULL,'2026-04-10 10:15:54','2026-04-10 10:16:04',NULL,0),(27,'PKC-XOHSONF6WL5A','test_glryFkhUqR','completed',60000,'FCFA','Kevin ADJALIAN','Kevadjalian@gmail.com','+22901020304','[{\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\"}]','{\"hash\": \"db61f851d3f862a00effe31b5958f41ddad09758e1beccc516d7279de39a73ccf860fa39a4a6ed4b8da98ff5129dd4c1426884efbf491c8291cdcfe7a13664df\", \"mode\": \"test\", \"status\": \"completed\", \"actions\": {\"cancel_url\": \"http://localhost:3000/shop\", \"return_url\": \"http://localhost:3000/checkout?tx_ref=PKC-XOHSONF6WL5A\", \"callback_url\": \"https://peacefully-intercrinal-brigitte.ngrok-free.dev/api/webhooks/paydunya\"}, \"invoice\": {\"items\": {\"item_0\": {\"name\": \"Classes Only\", \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\", \"total_price\": 60000}}, \"taxes\": [], \"token\": \"test_glryFkhUqR\", \"description\": \"United Kizdom World Congress — Pass festival\", \"total_amount\": 60000}, \"customer\": {\"name\": \"Test\", \"email\": \"sodjinoukevin13@gmail.com\", \"phone\": \"0502407474\"}, \"custom_data\": {\"tx_ref\": \"PKC-XOHSONF6WL5A\"}, \"receipt_url\": \"https://paydunya.com/sandbox-checkout/receipt/pdf/test_glryFkhUqR.pdf\", \"response_code\": \"00\", \"response_text\": \"Transaction Found\"}','2026-04-10 10:16:59','2026-04-10 10:16:47','2026-04-10 10:16:59',NULL,0),(28,'PKC-18QWLAC79UBI','test_snzyB0JAjr','completed',117000,'FCFA','Ariel','vosej74099@nyspring.com','+225665526555','[{\"name\": \"Classes Only\", \"slug\": \"classes-only\", \"discount\": 6000, \"quantity\": 1, \"unit_price\": 60000, \"description\": \"Accès uniquement aux cours\", \"final_price\": 54000, \"is_early_bird\": false}, {\"name\": \"Tourism Pack\", \"slug\": \"tourism\", \"discount\": 7000, \"quantity\": 1, \"unit_price\": 70000, \"description\": \"Découverte touristique autour du festival\", \"final_price\": 63000, \"is_early_bird\": false}]','{\"hash\": \"db61f851d3f862a00effe31b5958f41ddad09758e1beccc516d7279de39a73ccf860fa39a4a6ed4b8da98ff5129dd4c1426884efbf491c8291cdcfe7a13664df\", \"mode\": \"test\", \"status\": \"completed\", \"actions\": {\"cancel_url\": \"http://localhost:3000/shop\", \"return_url\": \"http://localhost:3000/checkout?tx_ref=PKC-18QWLAC79UBI\", \"callback_url\": \"https://peacefully-intercrinal-brigitte.ngrok-free.dev/api/webhooks/paydunya\"}, \"invoice\": {\"items\": {\"item_0\": {\"name\": \"Classes Only\", \"quantity\": 1, \"unit_price\": 54000, \"description\": \"Accès uniquement aux cours\", \"total_price\": 54000}, \"item_1\": {\"name\": \"Tourism Pack\", \"quantity\": 1, \"unit_price\": 63000, \"description\": \"Découverte touristique autour du festival\", \"total_price\": 63000}}, \"taxes\": [], \"token\": \"test_snzyB0JAjr\", \"description\": \"United Kizdom World Congress — Pass festival\", \"total_amount\": 117000}, \"customer\": {\"name\": \"Test\", \"email\": \"sodjinoukevin13@gmail.com\", \"phone\": \"0502407474\"}, \"custom_data\": {\"tx_ref\": \"PKC-18QWLAC79UBI\"}, \"receipt_url\": \"https://paydunya.com/sandbox-checkout/receipt/pdf/test_snzyB0JAjr.pdf\", \"response_code\": \"00\", \"response_text\": \"Transaction Found\"}','2026-04-10 20:30:36','2026-04-10 20:30:21','2026-04-10 20:30:36',1,13000);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'admin-token','9468c6abbf54aed947adecedbfc8b636950bf1bf81e25a7dbc68158192d83d22','[\"admin\"]',NULL,NULL,'2026-04-09 18:51:50','2026-04-09 18:51:50'),(2,'App\\Models\\User',1,'admin-token','69c5e773c549d59c7f88909ac56ec28b8adc94111e6ea32c2bf21d43bc7e6309','[\"admin\"]',NULL,NULL,'2026-04-09 18:58:22','2026-04-09 18:58:22'),(3,'App\\Models\\User',1,'admin-token','babcf7d9cb32d7ef0a0ba3a5a9277602361afa7c57683d494568dcb4a78fcd29','[\"admin\"]','2026-04-10 20:39:33',NULL,'2026-04-09 18:58:41','2026-04-10 20:39:33'),(4,'App\\Models\\User',1,'admin-token','71df9e900576803ef03d7309b0655b79952e37af7ac0c331b042d11787616d9a','[\"admin\"]',NULL,NULL,'2026-04-09 19:31:55','2026-04-09 19:31:55'),(5,'App\\Models\\User',1,'admin-token','4b42dad5285b9ed2e5ae3102310a2947ae626fdb9cc5eaf3ba25ecd2681ed2ef','[\"admin\"]','2026-04-09 19:37:25',NULL,'2026-04-09 19:37:25','2026-04-09 19:37:25'),(6,'App\\Models\\User',1,'admin-token','e91f7b31cb74d7432f1dcf76174cf6797eb46e25fe9f2318116237275ffd4abc','[\"admin\"]','2026-04-09 19:38:22',NULL,'2026-04-09 19:38:22','2026-04-09 19:38:22'),(7,'App\\Models\\User',1,'admin-token','ce06fed5a40066c16b6b116d3d107bd638393ad96fb2dd889e646c4376718001','[\"admin\"]','2026-04-09 19:40:46',NULL,'2026-04-09 19:40:46','2026-04-09 19:40:46'),(8,'App\\Models\\User',1,'admin-token','a4f4085e0c3b64c263731779141622a1c3d7ab5c9dd19964a26c59da3d324102','[\"admin\"]','2026-04-10 22:47:52',NULL,'2026-04-10 21:39:23','2026-04-10 22:47:52');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promo_codes`
--

DROP TABLE IF EXISTS `promo_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promo_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('percentage','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage',
  `value` int unsigned NOT NULL,
  `max_uses` int unsigned DEFAULT NULL,
  `uses_count` int unsigned NOT NULL DEFAULT '0',
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `applicable_slugs` json DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promo_codes_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promo_codes`
--

LOCK TABLES `promo_codes` WRITE;
/*!40000 ALTER TABLE `promo_codes` DISABLE KEYS */;
INSERT INTO `promo_codes` VALUES (1,'UKWC2026','percentage',10,NULL,0,NULL,NULL,1,NULL,'Code promo festival','2026-04-10 11:26:10','2026-04-10 11:57:09');
/*!40000 ALTER TABLE `promo_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('yFEWwKF2fCKe77ciT2lUzcYuWmMtZZyvQQ5RsNGP',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0','eyJfdG9rZW4iOiJXSk5Hc1NxaDVNaU9ZS2pJeG9CdTBhUGJiMzdiRXhMaWlvMTZIU1hBIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3BlYWNlZnVsbHktaW50ZXJjcmluYWwtYnJpZ2l0dGUubmdyb2stZnJlZS5kZXYiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1775703089);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint unsigned NOT NULL,
  `early_bird_price` bigint unsigned DEFAULT NULL,
  `early_bird_starts_at` timestamp NULL DEFAULT NULL,
  `early_bird_ends_at` timestamp NULL DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FCFA',
  `includes` json DEFAULT NULL,
  `stock` int unsigned NOT NULL DEFAULT '0',
  `sold` int unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tickets_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'full-pass','Full Pass','Accès Complet au Festival','Accès complet à toutes les activités du festival','Event Pass',120000,110000,'2026-04-10 10:00:00','2026-04-10 12:00:00','FCFA','[\"All Parties & Socials access\", \"All workshops & masterclasses access\", \"Tourism\"]',100,0,1,'tickets/gNXYD3flSZJdT38s6wECjwTlJRiks0hqFxiqS4iO.png','2026-04-08 20:22:33','2026-04-10 14:09:27'),(2,'parties-classes','Parties & Classes',NULL,'Accès aux soirées et aux cours sélectionnés','Event Pass',90000,NULL,NULL,NULL,'FCFA','[\"All Parties access\", \"Selected workshops access\"]',150,1,1,'tickets/XXMJNASSiqeqpwMoAQ95azmzA9u5pqnFCXoHZJja.png','2026-04-08 20:22:33','2026-04-10 13:23:25'),(3,'parties-only','Parties Only',NULL,'Accès uniquement aux soirées','Event Pass',50000,NULL,NULL,NULL,'FCFA','[\"All Parties access\", \"Social dancing\"]',200,2,1,'tickets/lBtVsiL9My7AuDgOAk1eDtboRHFCh6WvJgwYFddS.png','2026-04-08 20:22:33','2026-04-10 13:23:45'),(4,'tourism','Tourism Pack',NULL,'Découverte touristique autour du festival','Event Pass',70000,NULL,NULL,NULL,'FCFA','[\"City tours\", \"Cultural experiences\", \"Transport included\"]',80,2,1,'tickets/tyBPUweHI6zmXRfri4fZJFmQmwdCD3U9G5cDmPT9.png','2026-04-08 20:22:33','2026-04-10 20:30:36'),(5,'classes-only','Classes Only','Accès Complet au Festival','Accès uniquement aux cours','Event Pass',60000,50000,'2026-04-10 10:30:00','2026-04-10 12:00:00','FCFA','[\"Workshops access\", \"Masterclasses\"]',120,3,1,'tickets/dy5CtSWuHQ7Dwsih0uEaziPsJxKiLqvpODC1eDgY.png','2026-04-08 20:22:33','2026-04-10 20:30:36'),(6,'fps-single-standard','Full Pass & Stay — Single Standard',NULL,'Full pass + hébergement single standard (2 pers. max)','Full Pass & Stay',355000,NULL,NULL,NULL,'XOF','[\"1 Full pass\", \"1 appt chambre + salon standard\", \"1 petit dej / jour\"]',30,0,1,'tickets/Kz3fht9sPQKwPsb5b1cxyftknxezSZTHGCDdm6JD.png','2026-04-09 01:35:05','2026-04-09 22:26:28'),(7,'fps-single-premium','Full Pass & Stay — Single Premium',NULL,'Full pass + hébergement single premium (2 pers. max)','Full Pass & Stay',390000,NULL,NULL,NULL,'XOF','[\"1 Full pass\", \"1 appt chambre + salon premium\", \"1 petit dej / jour\", \"Pack d\'accueil\", \"1 t-shirt\"]',20,1,1,'tickets/1V6vl5rEwyVcBuue3SooRf6wN92zOxSdelzPIfnl.png','2026-04-09 01:35:05','2026-04-10 00:06:33'),(8,'fps-single-luxury','Full Pass & Stay — Single Luxury',NULL,'Full pass + hébergement single luxe (2 pers. max)','Full Pass & Stay',415000,NULL,NULL,NULL,'XOF','[\"1 Full pass\", \"1 appt chambre + salon luxe\", \"1 petit dej / jour\", \"Pack d\'accueil\", \"1 t-shirt\", \"Assistance\"]',10,1,1,'tickets/Y5U5e6PEotdeL2SJbWaEFuxap5oa9sziJOdoCrOb.png','2026-04-09 01:35:05','2026-04-10 00:06:33'),(9,'fps-double-standard','Full Pass & Stay — Couple Standard',NULL,'2 Full pass + hébergement double standard (2 pers. max)','Full Pass & Stay',515000,NULL,NULL,NULL,'XOF','[\"2 Full pass\", \"1 appt chambre + salon standard\", \"2 petit dej / jour\"]',30,0,1,'tickets/oc1arq6SPJaBFvdHUiOMG4gAd8FMs6POcWEWdMgo.png','2026-04-09 01:35:05','2026-04-09 22:24:12'),(10,'fps-double-premium','Full Pass & Stay — Couple Premium',NULL,'2 Full pass + hébergement double premium (4 pers. max)','Full Pass & Stay',610000,NULL,NULL,NULL,'XOF','[\"2 Full pass\", \"Appartement 2 chambres + salon premium\", \"2 petit dej / jour\", \"Pack d\'accueil\", \"2 t-shirts\"]',20,0,1,'tickets/0HOC2yU1cC0SRr83mxJfcmqohoVdZg5NXxj8Z4ue.png','2026-04-09 01:35:05','2026-04-09 22:25:28'),(11,'fps-double-luxury','Full Pass & Stay — Couple Luxury',NULL,'2 Full pass + hébergement double luxe (4 pers. max)','Full Pass & Stay',655000,NULL,NULL,NULL,'XOF','[\"2 Full pass\", \"Appartement 2 chambres + salon luxe\", \"2 petit dej / jour\", \"Pack d\'accueil\", \"2 t-shirts\", \"Assistance\"]',10,0,1,'tickets/aJUX96oH2mXix08GbN4CcYNEU801Xd79DH74v7Xu.png','2026-04-09 01:35:05','2026-04-09 22:25:50'),(12,'sye-standard','Shape Your Experience — Standard',NULL,'Hébergement standard (2 pers. max) — tarif par nuit','Shape Your Experience',30000,NULL,NULL,NULL,'XOF','[\"1 chambre d\'hôtel standard\", \"1 petit déjeuner / jour\", \"Assistance standard\"]',50,0,0,NULL,'2026-04-09 01:35:05','2026-04-10 11:56:56'),(13,'sye-premium','Shape Your Experience — Premium',NULL,'Hébergement premium (2 pers. max) — tarif par nuit','Shape Your Experience',35000,NULL,NULL,NULL,'XOF','[\"1 chambre d\'hôtel premium\", \"1 petit déjeuner / jour\", \"Assistance standard\"]',50,0,0,NULL,'2026-04-09 01:35:05','2026-04-10 11:57:00'),(14,'test-Siqew','test',NULL,NULL,'full',0,NULL,NULL,NULL,'FCFA',NULL,0,0,0,'tickets/09UVM55w1xvUGXvS2RqIH6WzISDtWRGBvoOzdKep.jpg','2026-04-09 22:30:24','2026-04-10 11:56:52');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin UKWC','admin@ukwc.com','admin',NULL,'$2y$12$ICOxN1Auofc.2lL49ots3ulTX7YMLD8XzV5swgOLVERM7KfxTxzLy',NULL,'2026-04-09 18:25:46','2026-04-09 18:38:18');
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

-- Dump completed on 2026-04-10 22:53:41
