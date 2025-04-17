-- MySQL dump 10.13  Distrib 5.7.39, for Win64 (x86_64)
--
-- Host: localhost    Database: blaze_taxi_clean_db
-- ------------------------------------------------------
-- Server version	5.7.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `additional_fees`
--

DROP TABLE IF EXISTS `additional_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `additional_fees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additional_fees`
--

LOCK TABLES `additional_fees` WRITE;
/*!40000 ALTER TABLE `additional_fees` DISABLE KEYS */;
/*!40000 ALTER TABLE `additional_fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_settings`
--

DROP TABLE IF EXISTS `app_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_description` longtext COLLATE utf8mb4_unicode_ci,
  `site_copyright` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_option` json DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `help_support_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_settings`
--

LOCK TABLES `app_settings` WRITE;
/*!40000 ALTER TABLE `app_settings` DISABLE KEYS */;
INSERT INTO `app_settings` VALUES (1,'BLAZE TAXI',NULL,'/tmp/phpblQIei','/tmp/phpfWWqnj','Panel Administrativo del aplicativo BLAZE TAXI','Todos los derechos reservados. BLAZE TAXI','https://www.facebook.com/blazeridesvzla/','https://www.instagram.com/blazerides.ve/',NULL,NULL,'[\"en\", \"es\"]','admin@blazetaxi.com','04121541166','Ayuda / AtenciÃ³n al Cliente',NULL,NULL,NULL);
/*!40000 ALTER TABLE `app_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'popup',
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bonus_user`
--

DROP TABLE IF EXISTS `bonus_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bonus_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `bonus_id` bigint(20) unsigned NOT NULL,
  `amount` int(11) DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bonus_user_bonus_id_foreign` (`bonus_id`),
  KEY `bonus_user_user_id_foreign` (`user_id`),
  CONSTRAINT `bonus_user_bonus_id_foreign` FOREIGN KEY (`bonus_id`) REFERENCES `bonuses` (`id`),
  CONSTRAINT `bonus_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bonus_user`
--

LOCK TABLES `bonus_user` WRITE;
/*!40000 ALTER TABLE `bonus_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `bonus_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bonuses`
--

DROP TABLE IF EXISTS `bonuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bonuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `rides_qty` int(11) NOT NULL,
  `start_date_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `starts_at` datetime DEFAULT NULL,
  `end_date_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `ends_at` datetime DEFAULT NULL,
  `days_to_expiration` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bonuses`
--

LOCK TABLES `bonuses` WRITE;
/*!40000 ALTER TABLE `bonuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `bonuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cancellation_reasons`
--

DROP TABLE IF EXISTS `cancellation_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cancellation_reasons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cancellation_reasons`
--

LOCK TABLES `cancellation_reasons` WRITE;
/*!40000 ALTER TABLE `cancellation_reasons` DISABLE KEYS */;
INSERT INTO `cancellation_reasons` VALUES (1,'Change of plans','The user no longer needs the service.',1,'2024-11-11 20:28:54','2024-11-11 20:28:54'),(2,'Long wait time','The wait time exceeded expectations.',1,'2024-11-11 20:28:54','2024-11-11 20:28:54'),(3,'Driver issues','There was a problem with the assigned driver.',1,'2024-11-11 20:28:54','2024-11-11 20:28:54'),(4,'Unexpected price','The final price was higher than expected.',1,'2024-11-11 20:28:54','2024-11-11 20:28:54'),(5,'Incorrect address','The pickup or drop-off location was incorrect.',1,'2024-11-11 20:28:54','2024-11-11 20:28:54'),(6,'Alternative transportation','The user chose another mode of transportation.',1,'2024-11-11 20:28:54','2024-11-11 20:28:54'),(7,'Other','User specified a different reason.',1,'2024-11-11 20:28:54','2024-11-11 20:28:54');
/*!40000 ALTER TABLE `cancellation_reasons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cancellations`
--

DROP TABLE IF EXISTS `cancellations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cancellations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ride_request_id` bigint(20) unsigned NOT NULL,
  `cancellation_reason_id` bigint(20) unsigned NOT NULL,
  `additional_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cancellations_ride_request_id_foreign` (`ride_request_id`),
  KEY `cancellations_cancellation_reason_id_foreign` (`cancellation_reason_id`),
  CONSTRAINT `cancellations_cancellation_reason_id_foreign` FOREIGN KEY (`cancellation_reason_id`) REFERENCES `cancellation_reasons` (`id`),
  CONSTRAINT `cancellations_ride_request_id_foreign` FOREIGN KEY (`ride_request_id`) REFERENCES `ride_requests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cancellations`
--

LOCK TABLES `cancellations` WRITE;
/*!40000 ALTER TABLE `cancellations` DISABLE KEYS */;
/*!40000 ALTER TABLE `cancellations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaint_comments`
--

DROP TABLE IF EXISTS `complaint_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaint_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `complaint_id` bigint(20) unsigned DEFAULT NULL,
  `added_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `complaint_comments_complaint_id_foreign` (`complaint_id`),
  CONSTRAINT `complaint_comments_complaint_id_foreign` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaint_comments`
--

LOCK TABLES `complaint_comments` WRITE;
/*!40000 ALTER TABLE `complaint_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `complaint_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaints` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `rider_id` bigint(20) unsigned DEFAULT NULL,
  `complaint_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'rider, driver',
  `subject` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ride_request_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'pending' COMMENT 'pending, investigation, resolved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `complaints_rider_id_foreign` (`rider_id`),
  KEY `complaints_ride_request_id_foreign` (`ride_request_id`),
  CONSTRAINT `complaints_ride_request_id_foreign` FOREIGN KEY (`ride_request_id`) REFERENCES `ride_requests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `complaints_rider_id_foreign` FOREIGN KEY (`rider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaints`
--

LOCK TABLES `complaints` WRITE;
/*!40000 ALTER TABLE `complaints` DISABLE KEYS */;
/*!40000 ALTER TABLE `complaints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'all,first_ride,region_wise,service_wise',
  `usage_limit_per_rider` bigint(20) unsigned DEFAULT NULL,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'fixed,percentage',
  `discount` double DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `minimum_amount` double DEFAULT NULL,
  `maximum_discount` double DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) DEFAULT NULL,
  `region_ids` text COLLATE utf8mb4_unicode_ci,
  `service_ids` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'driver' COMMENT 'driver',
  `is_required` tinyint(4) DEFAULT NULL,
  `has_expiry_date` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (2,'Licencia de conducir','driver',1,0,1,'2023-01-09 04:16:28','2023-03-19 00:58:26'),(3,'CÃ©dula de Identidad','driver',1,1,1,'2023-03-19 00:58:22','2023-03-19 00:58:22');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `driver_documents`
--

DROP TABLE IF EXISTS `driver_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `driver_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` bigint(20) unsigned DEFAULT NULL,
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `is_verified` tinyint(4) DEFAULT '0' COMMENT '0-pending,1-approved,2-rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `driver_documents_driver_id_foreign` (`driver_id`),
  KEY `driver_documents_document_id_foreign` (`document_id`),
  CONSTRAINT `driver_documents_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  CONSTRAINT `driver_documents_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `driver_documents`
--

LOCK TABLES `driver_documents` WRITE;
/*!40000 ALTER TABLE `driver_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `driver_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `driver_services`
--

DROP TABLE IF EXISTS `driver_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `driver_services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `service_id` bigint(20) unsigned DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `driver_services_driver_id_foreign` (`driver_id`),
  CONSTRAINT `driver_services_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `driver_services`
--

LOCK TABLES `driver_services` WRITE;
/*!40000 ALTER TABLE `driver_services` DISABLE KEYS */;
/*!40000 ALTER TABLE `driver_services` ENABLE KEYS */;
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
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2022_04_28_130817_create_user_details_table',1),(6,'2022_04_29_063151_create_regions_table',1),(7,'2022_04_29_063230_create_services_table',1),(8,'2022_04_29_064239_create_ride_requests_table',1),(9,'2022_04_29_064325_create_driver_services_table',1),(10,'2022_04_29_064758_create_complaints_table',1),(11,'2022_04_29_064809_create_reviews_table',1),(12,'2022_05_02_061025_create_ride_request_histories_table',1),(13,'2022_05_02_102753_create_payment_gateways_table',1),(14,'2022_05_02_102825_create_payments_table',1),(15,'2022_05_02_120722_create_permission_tables',1),(16,'2022_05_04_100102_create_media_table',1),(17,'2022_05_18_095512_create_coupons_table',1),(18,'2022_05_18_095624_create_wallets_table',1),(19,'2022_05_18_096432_create_wallet_histories_table',1),(20,'2022_05_23_084042_create_notifications_table',1),(21,'2022_05_23_094130_create_settings_table',1),(22,'2022_05_23_104508_create_app_settings_table',1),(23,'2022_06_09_074731_create_additional_fees_table',1),(24,'2022_06_13_125956_create_documents_table',1),(25,'2022_06_13_130010_create_driver_documents_table',1),(26,'2022_08_05_071122_create_sos_table',1),(27,'2022_08_05_113139_create_ride_request_ratings_table',1),(28,'2022_08_08_052703_create_withdraw_requests_table',1),(29,'2022_08_08_090613_create_user_bank_accounts_table',1),(30,'2022_12_10_091040_alter_services_table',2),(31,'2022_12_12_082101_alter_users_table',2),(32,'2022_12_20_100326_create_complaint_comments_table',3),(33,'2023_02_20_210057_add_proposed_fee_to_ride_requests_table',4),(34,'2023_02_20_214522_create_ride_request_offering_table',4),(35,'2023_04_27_140015_add_cash_in_hand_row_to_ride_requests_table',5),(36,'2023_04_27_154658_add_cash_collected_row_to_ride_requests_table',6),(38,'2023_04_27_210324_add_collected_cash_row_to_payments_table',7),(39,'2023_06_20_152052_add_ref_code_row_to_users_table',8),(40,'2023_06_21_110155_add_applied_ref_code_row_to_users_table',9),(41,'2023_08_16_141308_add_modality_row_to_ride_requests_table',10),(44,'2023_09_18_135935_create_bonus_table',11),(46,'2023_09_22_094723_create_bonus_user_table',12),(47,'2023_10_05_144551_create_banners_table',13),(48,'2023_01_13_071123_add_last_location_update_at_in_users_table',14),(49,'2024_08_23_110447_add_old_username_row_to_users_table',15),(50,'2024_11_05_152731_create_cancellation_reasons_table',16),(51,'2024_11_05_152856_create_cancellations_table',16);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(3,'App\\Models\\User',3),(2,'App\\Models\\User',4),(2,'App\\Models\\User',5),(3,'App\\Models\\User',6),(2,'App\\Models\\User',7),(3,'App\\Models\\User',9),(3,'App\\Models\\User',10),(2,'App\\Models\\User',11),(2,'App\\Models\\User',12),(3,'App\\Models\\User',13),(2,'App\\Models\\User',14),(3,'App\\Models\\User',15),(2,'App\\Models\\User',16),(3,'App\\Models\\User',17),(2,'App\\Models\\User',18),(3,'App\\Models\\User',19),(3,'App\\Models\\User',20),(3,'App\\Models\\User',21),(3,'App\\Models\\User',23),(3,'App\\Models\\User',24),(3,'App\\Models\\User',25),(2,'App\\Models\\User',26),(2,'App\\Models\\User',27),(3,'App\\Models\\User',28),(3,'App\\Models\\User',29);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
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
-- Table structure for table `payment_gateways`
--

DROP TABLE IF EXISTS `payment_gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_gateways` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '0- InActive, 1- Active',
  `is_test` tinyint(4) DEFAULT '1' COMMENT '0-  No, 1- Yes',
  `test_value` json DEFAULT NULL,
  `live_value` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_gateways`
--

LOCK TABLES `payment_gateways` WRITE;
/*!40000 ALTER TABLE `payment_gateways` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_gateways` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rider_id` bigint(20) unsigned NOT NULL,
  `ride_request_id` bigint(20) unsigned NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `total_amount` double DEFAULT '0',
  `admin_commission` double DEFAULT '0',
  `received_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_fee` double DEFAULT '0',
  `driver_tips` double DEFAULT '0',
  `driver_commission` double DEFAULT '0',
  `fleet_commission` double DEFAULT '0',
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'cash',
  `txn_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'pending, paid, failed',
  `transaction_detail` json DEFAULT NULL,
  `collected_cash` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_rider_id_foreign` (`rider_id`),
  KEY `payments_ride_request_id_foreign` (`ride_request_id`),
  CONSTRAINT `payments_ride_request_id_foreign` FOREIGN KEY (`ride_request_id`) REFERENCES `ride_requests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_rider_id_foreign` FOREIGN KEY (`rider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'role','web',NULL,'2022-12-22 18:59:25',NULL),(2,'role add','web',1,'2022-12-22 18:59:25',NULL),(3,'role list','web',1,'2022-12-22 18:59:25',NULL),(4,'permission','web',NULL,'2022-12-22 18:59:25',NULL),(5,'permission add','web',4,'2022-12-22 18:59:25',NULL),(6,'permission list','web',4,'2022-12-22 18:59:25',NULL),(7,'region','web',NULL,'2022-12-22 18:59:25',NULL),(8,'region list','web',7,'2022-12-22 18:59:25',NULL),(9,'region add','web',7,'2022-12-22 18:59:25',NULL),(10,'region edit','web',7,'2022-12-22 18:59:25',NULL),(11,'region delete','web',7,'2022-12-22 18:59:25',NULL),(12,'service','web',NULL,'2022-12-22 18:59:25',NULL),(13,'service list','web',12,'2022-12-22 18:59:25',NULL),(14,'service add','web',12,'2022-12-22 18:59:25',NULL),(15,'service edit','web',12,'2022-12-22 18:59:25',NULL),(16,'service delete','web',12,'2022-12-22 18:59:25',NULL),(17,'driver','web',NULL,'2022-12-22 18:59:25',NULL),(18,'driver list','web',17,'2022-12-22 18:59:25',NULL),(19,'driver add','web',17,'2022-12-22 18:59:25',NULL),(20,'driver edit','web',17,'2022-12-22 18:59:25',NULL),(21,'driver delete','web',17,'2022-12-22 18:59:25',NULL),(22,'rider','web',NULL,'2022-12-22 18:59:25',NULL),(23,'rider list','web',22,'2022-12-22 18:59:25',NULL),(24,'rider add','web',22,'2022-12-22 18:59:25',NULL),(25,'rider edit','web',22,'2022-12-22 18:59:25',NULL),(26,'rider delete','web',22,'2022-12-22 18:59:25',NULL),(27,'riderequest','web',NULL,'2022-12-22 18:59:25',NULL),(28,'riderequest list','web',27,'2022-12-22 18:59:25',NULL),(29,'riderequest show','web',27,'2022-12-22 18:59:25',NULL),(30,'riderequest delete','web',27,'2022-12-22 18:59:25',NULL),(31,'pending driver','web',17,'2022-12-22 18:59:25',NULL),(32,'document','web',NULL,'2022-12-22 18:59:25',NULL),(33,'document list','web',32,'2022-12-22 18:59:25',NULL),(34,'document add','web',32,'2022-12-22 18:59:25',NULL),(35,'document edit','web',32,'2022-12-22 18:59:25',NULL),(36,'document delete','web',32,'2022-12-22 18:59:25',NULL),(37,'driverdocument','web',NULL,'2022-12-22 18:59:25',NULL),(38,'driverdocument list','web',37,'2022-12-22 18:59:25',NULL),(39,'driverdocument add','web',37,'2022-12-22 18:59:25',NULL),(40,'driverdocument edit','web',37,'2022-12-22 18:59:25',NULL),(41,'driverdocument delete','web',37,'2022-12-22 18:59:25',NULL),(42,'coupon','web',NULL,'2022-12-22 18:59:25',NULL),(43,'coupon list','web',42,'2022-12-22 18:59:25',NULL),(44,'coupon add','web',42,'2022-12-22 18:59:25',NULL),(45,'coupon edit','web',42,'2022-12-22 18:59:25',NULL),(46,'coupon delete','web',42,'2022-12-22 18:59:25',NULL),(47,'additionalfees','web',NULL,'2022-12-22 18:59:25',NULL),(48,'additionalfees list','web',47,'2022-12-22 18:59:25',NULL),(49,'additionalfees add','web',47,'2022-12-22 18:59:25',NULL),(50,'additionalfees edit','web',47,'2022-12-22 18:59:25',NULL),(51,'additionalfees delete','web',47,'2022-12-22 18:59:25',NULL),(52,'sos','web',NULL,'2022-12-22 18:59:25',NULL),(53,'sos list','web',52,'2022-12-22 18:59:25',NULL),(54,'sos add','web',52,'2022-12-22 18:59:25',NULL),(55,'sos edit','web',52,'2022-12-22 18:59:25',NULL),(56,'sos delete','web',52,'2022-12-22 18:59:25',NULL),(57,'complaint','web',NULL,'2022-12-22 18:59:25',NULL),(58,'complaint list','web',57,'2022-12-22 18:59:25',NULL),(59,'complaint add','web',57,'2022-12-22 18:59:25',NULL),(60,'complaint edit','web',57,'2022-12-22 18:59:25',NULL),(61,'complaint delete','web',57,'2022-12-22 18:59:25',NULL),(62,'pages','web',NULL,'2022-12-22 18:59:25',NULL),(63,'terms condition','web',62,'2022-12-22 18:59:25',NULL),(64,'privacy policy','web',62,'2022-12-22 18:59:25',NULL),(65,'Bonus','web',NULL,'2023-09-19 21:59:47','2023-09-19 21:59:47'),(66,'bonus add','web',65,'2023-09-19 22:00:24','2023-09-19 22:00:24'),(67,'bonus edit','web',65,'2023-09-20 15:00:26','2023-09-20 15:00:26'),(68,'bonus delete','web',65,'2023-09-20 15:00:39','2023-09-20 15:00:39'),(69,'banner','web',NULL,'2023-10-06 18:57:02','2023-10-06 18:57:02'),(70,'banner add','web',69,'2023-10-06 18:57:22','2023-10-06 18:57:22'),(71,'banner edit','web',69,'2023-10-06 18:57:38','2023-10-06 18:57:38'),(72,'banner delete','web',69,'2023-10-06 18:57:52','2023-10-06 18:57:52');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
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
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'km' COMMENT 'km,mile',
  `coordinates` polygon DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'UTC',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regions`
--

LOCK TABLES `regions` WRITE;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
INSERT INTO `regions` VALUES (2,'Barquisimeto','km',_binary '\0\0\0\0\0\0\0\0\0\0\0\0\0P\ÒºnQÀ\ãºÁ\â¯#@÷OÒ†·iQÀq¥œU¡#@\0P\Ò?bQÀ °®Lª\Ä#@\îO\Òd[QÀÞ®q¦ó#@\îO\ÒôRQÀ€\Çv|\Ãü#@\0P\Ò\'MQÀ¼‡Lð#@\îO\Ò„JQÀ\àµ$­¯ú#@	PÒ†LQÀ´…s< $@	PÒ†jMQÀ@ù\ÂQ¯K$@\îO\Ò$PQÀÜ–Ž¼ún$@÷OÒ†7SQÀŒ|´ªx$@P\ÒVQÀ\'q×žJe$@\åOÒ†œWQÀW3	yMA$@P\Òr\\QÀ\à= &4$@\îO\Ò<eQÀ\Ê\Î\Ëh\Ä$@#P\Ò	kQÀ\'HÄ»°\'$@\åOÒ†\ìpQÀ\ÖJžF‰,$@÷OÒ†pQÀb²¥¤™\Ý#@P\ÒºnQÀ\ãºÁ\â¯#@',1,'America/Caracas','2022-12-22 19:23:43','2022-12-22 19:23:43');
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `rider_id` bigint(20) unsigned DEFAULT NULL,
  `ride_request_id` bigint(20) unsigned DEFAULT NULL,
  `driver_rating` double DEFAULT '0',
  `rider_rating` double DEFAULT '0',
  `driver_review` text COLLATE utf8mb4_unicode_ci,
  `rider_review` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_rider_id_foreign` (`rider_id`),
  KEY `reviews_ride_request_id_foreign` (`ride_request_id`),
  CONSTRAINT `reviews_ride_request_id_foreign` FOREIGN KEY (`ride_request_id`) REFERENCES `ride_requests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_rider_id_foreign` FOREIGN KEY (`rider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride_request_histories`
--

DROP TABLE IF EXISTS `ride_request_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ride_request_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ride_request_id` bigint(20) unsigned NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `history_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `history_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `history_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ride_request_histories_ride_request_id_foreign` (`ride_request_id`),
  CONSTRAINT `ride_request_histories_ride_request_id_foreign` FOREIGN KEY (`ride_request_id`) REFERENCES `ride_requests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3190 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride_request_histories`
--

LOCK TABLES `ride_request_histories` WRITE;
/*!40000 ALTER TABLE `ride_request_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride_request_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride_request_offering`
--

DROP TABLE IF EXISTS `ride_request_offering`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ride_request_offering` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ride_request_id` bigint(20) unsigned NOT NULL,
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `fee_offered` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ride_request_offering_ride_request_id_foreign` (`ride_request_id`),
  CONSTRAINT `ride_request_offering_ride_request_id_foreign` FOREIGN KEY (`ride_request_id`) REFERENCES `ride_requests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=416 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride_request_offering`
--

LOCK TABLES `ride_request_offering` WRITE;
/*!40000 ALTER TABLE `ride_request_offering` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride_request_offering` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride_request_ratings`
--

DROP TABLE IF EXISTS `ride_request_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ride_request_ratings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ride_request_id` bigint(20) unsigned NOT NULL,
  `rider_id` bigint(20) unsigned DEFAULT NULL,
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `rating` double NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `rating_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ride_request_ratings_ride_request_id_foreign` (`ride_request_id`),
  CONSTRAINT `ride_request_ratings_ride_request_id_foreign` FOREIGN KEY (`ride_request_id`) REFERENCES `ride_requests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride_request_ratings`
--

LOCK TABLES `ride_request_ratings` WRITE;
/*!40000 ALTER TABLE `ride_request_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride_request_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride_requests`
--

DROP TABLE IF EXISTS `ride_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ride_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rider_id` bigint(20) unsigned DEFAULT NULL,
  `service_id` bigint(20) unsigned DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `is_schedule` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-regular, 1-schedule',
  `ride_attempt` int(11) DEFAULT '0',
  `distance_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` double DEFAULT '0',
  `subtotal` double DEFAULT '0',
  `extra_charges_amount` double DEFAULT '0',
  `driver_id` bigint(20) unsigned DEFAULT NULL,
  `riderequest_in_driver_id` bigint(20) unsigned DEFAULT NULL,
  `riderequest_in_datetime` datetime DEFAULT NULL,
  `start_latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_address` text COLLATE utf8mb4_unicode_ci,
  `end_latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_address` text COLLATE utf8mb4_unicode_ci,
  `distance` double DEFAULT NULL,
  `base_distance` double DEFAULT NULL,
  `duration` double DEFAULT NULL,
  `seat_count` double DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `base_fare` double DEFAULT NULL,
  `minimum_fare` double DEFAULT NULL,
  `per_distance` double DEFAULT NULL,
  `per_distance_charge` double DEFAULT NULL,
  `per_minute_drive` double DEFAULT NULL,
  `per_minute_drive_charge` double DEFAULT NULL,
  `extra_charges` json DEFAULT NULL,
  `coupon_discount` double DEFAULT NULL,
  `coupon_code` bigint(20) unsigned DEFAULT NULL,
  `coupon_data` json DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_by` enum('rider','driver','auto') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelation_charges` double DEFAULT NULL,
  `waiting_time` double DEFAULT NULL,
  `waiting_time_limit` double DEFAULT NULL,
  `tips` double DEFAULT NULL,
  `per_minute_waiting` double DEFAULT NULL,
  `per_minute_waiting_charge` double DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_driver_rated` tinyint(1) NOT NULL DEFAULT '0',
  `is_rider_rated` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled_driver_ids` text COLLATE utf8mb4_unicode_ci,
  `service_data` json DEFAULT NULL,
  `max_time_for_find_driver_for_ride_request` double DEFAULT NULL,
  `proposed_fee` double(8,2) NOT NULL DEFAULT '0.00',
  `cash_in_hand` double NOT NULL DEFAULT '0',
  `cash_collected` double NOT NULL DEFAULT '0',
  `modality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'auction',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ride_requests_rider_id_foreign` (`rider_id`),
  CONSTRAINT `ride_requests_rider_id_foreign` FOREIGN KEY (`rider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=865 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride_requests`
--

LOCK TABLES `ride_requests` WRITE;
/*!40000 ALTER TABLE `ride_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web',1,'2022-12-22 18:59:25',NULL),(2,'rider','web',1,'2022-12-22 18:59:25',NULL),(3,'driver','web',1,'2022-12-22 18:59:25',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region_id` bigint(20) unsigned DEFAULT NULL,
  `capacity` bigint(20) unsigned DEFAULT '1',
  `base_fare` double DEFAULT NULL,
  `minimum_fare` double DEFAULT NULL,
  `minimum_distance` double DEFAULT NULL,
  `per_distance` double DEFAULT NULL,
  `per_minute_drive` double DEFAULT NULL,
  `per_minute_wait` double DEFAULT NULL,
  `waiting_time_limit` double DEFAULT NULL,
  `cancellation_fee` double DEFAULT NULL,
  `payment_method` enum('cash_wallet','cash','wallet') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `commission_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'fixed, percentage',
  `admin_commission` double DEFAULT '0',
  `fleet_commission` double DEFAULT '0',
  `status` tinyint(4) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_region_id_foreign` (`region_id`),
  CONSTRAINT `services_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (4,'Normal Bqto',2,3,1.35,1.1,1,1.75,5,5,9,0,'cash_wallet','fixed',NULL,0,1,NULL,'2022-12-22 22:41:41','2023-01-09 03:36:14'),(8,'Moto Taxi Bqto',2,1,1.25,1.5,1,1.8,5,5,10,1,'cash_wallet','fixed',NULL,0,1,NULL,'2023-01-09 03:55:02','2023-01-09 04:06:16');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'terms_condition','terms_condition','<p><strong>POL&Iacute;TICA DE PRIVACIDAD</strong></p>\r\n<p>El presente Pol&iacute;tica de Privacidad establece los t&eacute;rminos en que Blaze, C.A. usa y protege la informaci&oacute;n que es proporcionada por sus usuarios al momento de utilizar su sitio web. Esta compa&ntilde;&iacute;a est&aacute; comprometida con la seguridad de los datos de sus usuarios. Cuando le pedimos llenar los campos de informaci&oacute;n personal con la cual usted pueda ser identificado, lo hacemos asegurando que s&oacute;lo se emplear&aacute; de acuerdo con los t&eacute;rminos de este documento. Sin embargo esta Pol&iacute;tica de Privacidad puede cambiar con el tiempo o ser actualizada por lo que le recomendamos y enfatizamos revisar continuamente esta p&aacute;gina para asegurarse que est&aacute; de acuerdo con dichos cambios.</p>\r\n<p><strong>Informaci&oacute;n que es recogida</strong></p>\r\n<p>Nuestro sitio web podr&aacute; recoger informaci&oacute;n personal por ejemplo: Nombre,&nbsp; informaci&oacute;n de contacto como&nbsp; su direcci&oacute;n de correo electr&oacute;nica e informaci&oacute;n demogr&aacute;fica. As&iacute; mismo cuando sea necesario podr&aacute; ser requerida informaci&oacute;n espec&iacute;fica para procesar alg&uacute;n pedido o realizar una entrega o facturaci&oacute;n.</p>\r\n<p><strong>Uso de la informaci&oacute;n recogida</strong></p>\r\n<p>Nuestro sitio web emplea la informaci&oacute;n con el fin de proporcionar el mejor servicio posible, particularmente para mantener un registro de usuarios, de pedidos en caso que aplique, y mejorar nuestros productos y servicios. &nbsp;Es posible que sean enviados correos electr&oacute;nicos peri&oacute;dicamente a trav&eacute;s de nuestro sitio con ofertas especiales, nuevos productos y otra informaci&oacute;n publicitaria que consideremos relevante para usted o que pueda brindarle alg&uacute;n beneficio, estos correos electr&oacute;nicos ser&aacute;n enviados a la direcci&oacute;n que usted proporcione y podr&aacute;n ser cancelados en cualquier momento.</p>\r\n<p>Blaze, C.A. est&aacute; altamente comprometido para cumplir con el compromiso de mantener su informaci&oacute;n segura. Usamos los sistemas m&aacute;s avanzados y los actualizamos constantemente para asegurarnos que no exista ning&uacute;n acceso no autorizado.</p>\r\n<p><strong>Cookies</strong></p>\r\n<p>Una cookie se refiere a un fichero que es enviado con la finalidad de solicitar permiso para almacenarse en su ordenador, al aceptar dicho fichero se crea y la cookie sirve entonces para tener informaci&oacute;n respecto al tr&aacute;fico web, y tambi&eacute;n facilita las futuras visitas a una web recurrente. Otra funci&oacute;n que tienen las cookies es que con ellas las web pueden reconocerte individualmente y por tanto brindarte el mejor servicio personalizado de su web.</p>\r\n<p>Nuestro sitio web emplea las cookies para poder identificar las p&aacute;ginas que son visitadas y su frecuencia. Esta informaci&oacute;n es empleada &uacute;nicamente para an&aacute;lisis estad&iacute;stico y despu&eacute;s la informaci&oacute;n se elimina de forma permanente. Usted puede eliminar las cookies en cualquier momento desde su ordenador. Sin embargo las cookies ayudan a proporcionar un mejor servicio de los sitios web, est&aacute;s no dan acceso a informaci&oacute;n de su ordenador ni de usted, a menos de que usted as&iacute; lo quiera y la proporcione directamente&nbsp;<a href=\"https://noticias-fcbarcelona.es/\" target=\"_blank\" rel=\"noopener\">noticias</a>. Usted puede aceptar o negar el uso de cookies, sin embargo la mayor&iacute;a de navegadores aceptan cookies autom&aacute;ticamente pues sirve para tener un mejor servicio web. Tambi&eacute;n usted puede cambiar la configuraci&oacute;n de su ordenador para declinar las cookies. Si se declinan es posible que no pueda utilizar algunos de nuestros servicios.</p>\r\n<p><strong>Enlaces a Terceros</strong></p>\r\n<p>Este sitio web pudiera contener en laces a otros sitios que pudieran ser de su inter&eacute;s. Una vez que usted de clic en estos enlaces y abandone nuestra p&aacute;gina, ya no tenemos control sobre al sitio al que es redirigido y por lo tanto no somos responsables de los&nbsp;<a href=\"https://plantillaterminosycondicionestiendaonline.com/\" target=\"_blank\" rel=\"noopener\">t&eacute;rminos o privacidad</a>&nbsp;ni de la protecci&oacute;n de sus datos en esos otros sitios terceros. Dichos sitios est&aacute;n sujetos a sus propias pol&iacute;ticas de privacidad por lo cual es recomendable que los consulte para confirmar que usted est&aacute; de acuerdo con estas.</p>\r\n<p><strong>Control de su informaci&oacute;n personal</strong></p>\r\n<p>En cualquier momento usted puede restringir la recopilaci&oacute;n o el uso de la informaci&oacute;n personal que es proporcionada a nuestro sitio web.&nbsp; Cada vez que se le solicite rellenar un formulario, como el de alta de usuario, puede marcar o desmarcar la opci&oacute;n de recibir informaci&oacute;n por correo electr&oacute;nico. &nbsp;En caso de que haya marcado la opci&oacute;n de recibir nuestro bolet&iacute;n o publicidad usted puede cancelarla en cualquier momento.</p>\r\n<p>Esta compa&ntilde;&iacute;a no vender&aacute;, ceder&aacute; ni distribuir&aacute; la informaci&oacute;n personal que es recopilada sin su consentimiento, salvo que sea requerido por un juez con un orden judicial.</p>\r\n<p>Blaze, C.A. Se reserva el derecho de cambiar los t&eacute;rminos de la presente Pol&iacute;tica de Privacidad en cualquier momento.</p>'),(2,'max_time_for_find_drivers_for_regular_ride_in_minute','ride','20'),(3,'ride_accept_decline_duration_for_driver_in_second','ride','100'),(4,'preset_tip_amount','ride','2|5|10|20|50'),(5,'apply_additional_fee','ride','1'),(6,'min_amount_to_add','wallet','5'),(7,'max_amount_to_add','wallet','2'),(8,'min_amount_to_get_ride','wallet','0'),(9,'preset_topup_amount','wallet','2|5|10|20|50|100|300|500'),(10,'CURRENCY_CODE','CURRENCY','USD'),(11,'CURRENCY_POSITION','CURRENCY','left'),(12,'ONESIGNAL_APP_ID','ONESIGNAL',''),(13,'ONESIGNAL_REST_API_KEY','ONESIGNAL',''),(14,'DISTANCE_RADIUS','DISTANCE','1000'),(15,'privacy_policy','privacy_policy','<p>POL&Iacute;TICA DE PRIVACIDAD</p>\r\n<p>El presente Pol&iacute;tica de Privacidad establece los t&eacute;rminos en que Blaze, C.A. usa y protege la informaci&oacute;n que es proporcionada por sus usuarios al momento de utilizar su sitio web. Esta compa&ntilde;&iacute;a est&aacute; comprometida con la seguridad de los datos de sus usuarios. Cuando le pedimos llenar los campos de informaci&oacute;n personal con la cual usted pueda ser identificado, lo hacemos asegurando que s&oacute;lo se emplear&aacute; de acuerdo con los t&eacute;rminos de este documento. Sin embargo esta Pol&iacute;tica de Privacidad puede cambiar con el tiempo o ser actualizada por lo que le recomendamos y enfatizamos revisar continuamente esta p&aacute;gina para asegurarse que est&aacute; de acuerdo con dichos cambios.</p>\r\n<p>Informaci&oacute;n que es recogida</p>\r\n<p>Nuestro sitio web podr&aacute; recoger informaci&oacute;n personal por ejemplo: Nombre, &nbsp;informaci&oacute;n de contacto como &nbsp;su direcci&oacute;n de correo electr&oacute;nica e informaci&oacute;n demogr&aacute;fica. As&iacute; mismo cuando sea necesario podr&aacute; ser requerida informaci&oacute;n espec&iacute;fica para procesar alg&uacute;n pedido o realizar una entrega o facturaci&oacute;n.</p>\r\n<p>Uso de la informaci&oacute;n recogida</p>\r\n<p>Nuestro sitio web emplea la informaci&oacute;n con el fin de proporcionar el mejor servicio posible, particularmente para mantener un registro de usuarios, de pedidos en caso que aplique, y mejorar nuestros productos y servicios. &nbsp;Es posible que sean enviados correos electr&oacute;nicos peri&oacute;dicamente a trav&eacute;s de nuestro sitio con ofertas especiales, nuevos productos y otra informaci&oacute;n publicitaria que consideremos relevante para usted o que pueda brindarle alg&uacute;n beneficio, estos correos electr&oacute;nicos ser&aacute;n enviados a la direcci&oacute;n que usted proporcione y podr&aacute;n ser cancelados en cualquier momento.</p>\r\n<p>Blaze, C.A. est&aacute; altamente comprometido para cumplir con el compromiso de mantener su informaci&oacute;n segura. Usamos los sistemas m&aacute;s avanzados y los actualizamos constantemente para asegurarnos que no exista ning&uacute;n acceso no autorizado.</p>\r\n<p>Cookies</p>\r\n<p>Una cookie se refiere a un fichero que es enviado con la finalidad de solicitar permiso para almacenarse en su ordenador, al aceptar dicho fichero se crea y la cookie sirve entonces para tener informaci&oacute;n respecto al tr&aacute;fico web, y tambi&eacute;n facilita las futuras visitas a una web recurrente. Otra funci&oacute;n que tienen las cookies es que con ellas las web pueden reconocerte individualmente y por tanto brindarte el mejor servicio personalizado de su web.</p>\r\n<p>Nuestro sitio web emplea las cookies para poder identificar las p&aacute;ginas que son visitadas y su frecuencia. Esta informaci&oacute;n es empleada &uacute;nicamente para an&aacute;lisis estad&iacute;stico y despu&eacute;s la informaci&oacute;n se elimina de forma permanente. Usted puede eliminar las cookies en cualquier momento desde su ordenador. Sin embargo las cookies ayudan a proporcionar un mejor servicio de los sitios web, est&aacute;s no dan acceso a informaci&oacute;n de su ordenador ni de usted, a menos de que usted as&iacute; lo quiera y la proporcione directamente noticias. Usted puede aceptar o negar el uso de cookies, sin embargo la mayor&iacute;a de navegadores aceptan cookies autom&aacute;ticamente pues sirve para tener un mejor servicio web. Tambi&eacute;n usted puede cambiar la configuraci&oacute;n de su ordenador para declinar las cookies. Si se declinan es posible que no pueda utilizar algunos de nuestros servicios.</p>\r\n<p>Enlaces a Terceros</p>\r\n<p>Este sitio web pudiera contener en laces a otros sitios que pudieran ser de su inter&eacute;s. Una vez que usted de clic en estos enlaces y abandone nuestra p&aacute;gina, ya no tenemos control sobre al sitio al que es redirigido y por lo tanto no somos responsables de los t&eacute;rminos o privacidad ni de la protecci&oacute;n de sus datos en esos otros sitios terceros. Dichos sitios est&aacute;n sujetos a sus propias pol&iacute;ticas de privacidad por lo cual es recomendable que los consulte para confirmar que usted est&aacute; de acuerdo con estas.</p>\r\n<p>Control de su informaci&oacute;n personal</p>\r\n<p>En cualquier momento usted puede restringir la recopilaci&oacute;n o el uso de la informaci&oacute;n personal que es proporcionada a nuestro sitio web. &nbsp;Cada vez que se le solicite rellenar un formulario, como el de alta de usuario, puede marcar o desmarcar la opci&oacute;n de recibir informaci&oacute;n por correo electr&oacute;nico. &nbsp;En caso de que haya marcado la opci&oacute;n de recibir nuestro bolet&iacute;n o publicidad usted puede cancelarla en cualquier momento.</p>\r\n<p>Esta compa&ntilde;&iacute;a no vender&aacute;, ceder&aacute; ni distribuir&aacute; la informaci&oacute;n personal que es recopilada sin su consentimiento, salvo que sea requerido por un juez con un orden judicial.</p>\r\n<p>Blaze, C.A. Se reserva el derecho de cambiar los t&eacute;rminos de la presente Pol&iacute;tica de Privacidad en cualquier momento.</p>'),(16,'ONESIGNAL_DRIVER_APP_ID','ONESIGNAL',NULL),(17,'ONESIGNAL_DRIVER_REST_API_KEY','ONESIGNAL',NULL),(18,'FIREBASE_SERVER_KEY','FIREBASE',NULL),(19,'REFERRALS_ENABLED','referrals','1'),(20,'REFERRAL_AMOUNT','referrals','2'),(21,'REFERRALS_TITLE','referrals','Gana con Referidos!!!'),(22,'REFERRALS_SUBTITLE','referrals','Al completar la primera carrera'),(23,'RIDE_MODALITY_AUCTION','ride','1'),(24,'RIDE_MODALITY_EXPRESS','ride','1');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sos`
--

DROP TABLE IF EXISTS `sos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `region_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `added_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sos_region_id_foreign` (`region_id`),
  CONSTRAINT `sos_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sos`
--

LOCK TABLES `sos` WRITE;
/*!40000 ALTER TABLE `sos` DISABLE KEYS */;
INSERT INTO `sos` VALUES (2,2,'ProtecciÃ³n Civil administraciÃ³n Lara','+58 2512544889',1,1,'2022-12-22 20:01:47','2023-01-11 16:05:43');
/*!40000 ALTER TABLE `sos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_bank_accounts`
--

DROP TABLE IF EXISTS `user_bank_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_bank_accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_bank_accounts_user_id_foreign` (`user_id`),
  CONSTRAINT `user_bank_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_bank_accounts`
--

LOCK TABLES `user_bank_accounts` WRITE;
/*!40000 ALTER TABLE `user_bank_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_bank_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_plate_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_production_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_address` text COLLATE utf8mb4_unicode_ci,
  `home_address` text COLLATE utf8mb4_unicode_ci,
  `work_latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `player_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_id` bigint(20) unsigned DEFAULT NULL,
  `fleet_id` bigint(20) unsigned DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_notification_seen` timestamp NULL DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_online` tinyint(4) DEFAULT '0',
  `is_available` tinyint(4) DEFAULT '1',
  `is_verified_driver` tinyint(4) DEFAULT '0',
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcm_token` text COLLATE utf8mb4_unicode_ci,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'UTC',
  `last_location_update_at` datetime DEFAULT NULL,
  `ref_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `applied_ref_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_old_username_unique` (`old_username`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','Admin','admin@admin.com','admin',NULL,'$2a$12$llcJYZS2/6WLy.o4UurBPuANOPIuia8n5nRyDZiXOK7vv9YUeEEne','+593992587744',NULL,NULL,'Quito Ecuador','admin',NULL,NULL,NULL,NULL,NULL,NULL,'2023-09-18 21:49:18','active',0,1,0,NULL,NULL,'Admin',NULL,'America/Caracas',NULL,NULL,NULL,'2022-12-22 18:59:25','2023-09-18 21:49:18');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_histories`
--

DROP TABLE IF EXISTS `wallet_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wallet_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'credit,debit',
  `transaction_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'credit- ,debit',
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double DEFAULT '0',
  `balance` double DEFAULT '0',
  `datetime` datetime DEFAULT NULL,
  `ride_request_id` bigint(20) unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet_histories_user_id_foreign` (`user_id`),
  KEY `wallet_histories_ride_request_id_foreign` (`ride_request_id`),
  CONSTRAINT `wallet_histories_ride_request_id_foreign` FOREIGN KEY (`ride_request_id`) REFERENCES `ride_requests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wallet_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=373 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_histories`
--

LOCK TABLES `wallet_histories` WRITE;
/*!40000 ALTER TABLE `wallet_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallet_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wallets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `online_received` double DEFAULT NULL,
  `collected_cash` double DEFAULT NULL,
  `manual_received` double DEFAULT NULL,
  `total_withdrawn` double DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallets_user_id_foreign` (`user_id`),
  CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallets`
--

LOCK TABLES `wallets` WRITE;
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdraw_requests`
--

DROP TABLE IF EXISTS `withdraw_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withdraw_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `amount` double DEFAULT '0',
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT '0-requested,1-approved,2-decline',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `withdraw_requests_user_id_foreign` (`user_id`),
  CONSTRAINT `withdraw_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw_requests`
--

LOCK TABLES `withdraw_requests` WRITE;
/*!40000 ALTER TABLE `withdraw_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdraw_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'blaze_taxi_clean_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-20 12:02:37
