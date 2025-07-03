/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: laravel_app
-- ------------------------------------------------------
-- Server version	10.6.22-MariaDB-0ubuntu0.22.04.1

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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `answers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `answer_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `answers_user_id_answer_id_unique` (`user_id`,`answer_id`),
  KEY `answers_answer_id_foreign` (`answer_id`),
  CONSTRAINT `answers_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `possible_answers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (1,1,19,'2025-07-03 14:50:33','2025-07-03 14:50:33'),(2,1,3,'2025-07-03 14:50:33','2025-07-03 14:50:33'),(3,1,9,'2025-07-03 14:50:33','2025-07-03 14:50:33'),(4,1,20,'2025-07-03 14:50:33','2025-07-03 14:50:33'),(5,1,22,'2025-07-03 14:50:33','2025-07-03 14:50:33'),(6,2,18,'2025-07-03 14:53:32','2025-07-03 14:53:32'),(7,2,9,'2025-07-03 14:53:32','2025-07-03 14:53:32'),(8,2,5,'2025-07-03 14:53:32','2025-07-03 14:53:32'),(9,2,20,'2025-07-03 14:53:32','2025-07-03 14:53:32'),(10,2,23,'2025-07-03 14:53:32','2025-07-03 14:53:32'),(11,3,18,'2025-07-03 14:55:03','2025-07-03 14:55:03'),(12,3,9,'2025-07-03 14:55:03','2025-07-03 14:55:03'),(13,3,5,'2025-07-03 14:55:03','2025-07-03 14:55:03'),(14,3,20,'2025-07-03 14:55:03','2025-07-03 14:55:03'),(15,3,23,'2025-07-03 14:55:03','2025-07-03 14:55:03'),(16,4,18,'2025-07-03 14:56:34','2025-07-03 14:56:34'),(17,4,10,'2025-07-03 14:56:34','2025-07-03 14:56:34'),(18,4,5,'2025-07-03 14:56:34','2025-07-03 14:56:34'),(19,4,20,'2025-07-03 14:56:34','2025-07-03 14:56:34'),(20,4,22,'2025-07-03 14:56:34','2025-07-03 14:56:34'),(21,5,18,'2025-07-03 14:57:46','2025-07-03 14:57:46'),(26,5,3,'2025-07-03 17:33:27','2025-07-03 17:33:27'),(27,5,9,'2025-07-03 17:33:27','2025-07-03 17:33:27'),(28,5,21,'2025-07-03 17:33:27','2025-07-03 17:33:27'),(29,5,22,'2025-07-03 17:33:27','2025-07-03 17:33:27'),(30,5,13,'2025-07-03 17:33:27','2025-07-03 17:33:27'),(31,5,10,'2025-07-03 17:33:27','2025-07-03 17:33:27'),(32,5,20,'2025-07-03 17:33:27','2025-07-03 17:33:27'),(33,6,18,'2025-07-03 18:17:47','2025-07-03 18:17:47'),(34,6,2,'2025-07-03 18:17:47','2025-07-03 18:17:47'),(35,6,9,'2025-07-03 18:17:47','2025-07-03 18:17:47'),(36,6,8,'2025-07-03 18:17:47','2025-07-03 18:17:47'),(37,6,20,'2025-07-03 18:17:47','2025-07-03 18:17:47'),(38,6,22,'2025-07-03 18:17:47','2025-07-03 18:17:47'),(39,8,19,'2025-07-03 18:31:12','2025-07-03 18:31:12'),(40,8,2,'2025-07-03 18:31:12','2025-07-03 18:31:12'),(41,8,8,'2025-07-03 18:31:12','2025-07-03 18:31:12'),(42,8,9,'2025-07-03 18:31:12','2025-07-03 18:31:12'),(43,8,20,'2025-07-03 18:31:12','2025-07-03 18:31:12'),(44,8,22,'2025-07-03 18:31:12','2025-07-03 18:31:12');
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  KEY `categories_user_id_foreign` (`user_id`),
  CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,5,'Informatica clasa a 10-a','2025-07-03 17:13:52','2025-07-03 17:13:52'),(3,6,'Info clasa a 10-a','2025-07-03 18:40:02','2025-07-03 18:40:02'),(4,6,'Informatica','2025-07-03 18:41:08','2025-07-03 18:41:08');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_user`
--

DROP TABLE IF EXISTS `category_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_user_category_id_foreign` (`category_id`),
  KEY `category_user_user_id_foreign` (`user_id`),
  CONSTRAINT `category_user_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_user`
--

LOCK TABLES `category_user` WRITE;
/*!40000 ALTER TABLE `category_user` DISABLE KEYS */;
INSERT INTO `category_user` VALUES (1,1,3,NULL,NULL);
/*!40000 ALTER TABLE `category_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `content` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('video','document') NOT NULL,
  `uri` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `source` enum('youtube','cloud','local') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_user_id_foreign` (`user_id`),
  CONSTRAINT `content_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content`
--

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_category`
--

DROP TABLE IF EXISTS `content_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `content_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_category_content_id_foreign` (`content_id`),
  KEY `content_category_category_id_foreign` (`category_id`),
  CONSTRAINT `content_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `content_category_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_category`
--

LOCK TABLES `content_category` WRITE;
/*!40000 ALTER TABLE `content_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `conversations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `is_group` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conversations`
--

LOCK TABLES `conversations` WRITE;
/*!40000 ALTER TABLE `conversations` DISABLE KEYS */;
INSERT INTO `conversations` VALUES (2,'2025-07-03 17:28:21','2025-07-03 17:28:21',NULL,0,5);
/*!40000 ALTER TABLE `conversations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_verification_tokens`
--

DROP TABLE IF EXISTS `email_verification_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_verification_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_verification_tokens`
--

LOCK TABLES `email_verification_tokens` WRITE;
/*!40000 ALTER TABLE `email_verification_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_verification_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
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
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `conversation_id` bigint(20) unsigned NOT NULL,
  `body` text NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_user_id_foreign` (`user_id`),
  KEY `messages_conversation_id_foreign` (`conversation_id`),
  CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (6,3,2,'Salut',1,'2025-07-03 17:28:58','2025-07-03 17:29:08'),(7,5,2,'Salut, cand esti disponibil',1,'2025-07-03 17:29:24','2025-07-03 17:29:27');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_05_03_000001_create_customer_columns',1),(4,'2019_05_03_000002_create_subscriptions_table',1),(5,'2019_05_03_000003_create_subscription_items_table',1),(6,'2019_08_19_000000_create_failed_jobs_table',1),(7,'2019_12_14_000001_create_personal_access_tokens_table',1),(8,'2024_03_19_000000_create_tutor_schedules_table',1),(9,'2024_03_20_000001_add_payment_fields_to_session_participants',1),(10,'2024_03_20_000002_create_payments_table',1),(11,'2024_03_21_000000_create_email_verification_tokens_table',1),(12,'2024_05_08_154219_create_answers_table',1),(13,'2024_05_12_160806_create_possible_answers_table',1),(14,'2024_06_02_000000_create_user_stripe_accounts_table',1),(15,'2024_08_28_171240_user_profile',1),(16,'2025_02_21_202602_add_unique_constraint_to_answers_table',1),(17,'2025_04_20_153417_create_notifications_table',1),(18,'2025_04_28_154425_create_tutors_students_table',1),(19,'2025_05_02_190454_create_jobs_table',1),(20,'2025_05_05_164851_create_conversations_table',1),(21,'2025_05_05_165624_create_messages_table',1),(22,'2025_05_11_140237_create_categories_table',1),(23,'2025_05_17_141220_create_category_user_table',1),(24,'2025_05_18_162802_create_content_table',1),(25,'2025_05_18_171055_create_content_category',1),(26,'2025_05_19_182707_modify_source_and_description_columns_in_content_table',1),(27,'2025_05_31_210639_create_tutor_ratings',1),(28,'2025_06_02_174704_add_foreign_key_to_answer_id_in_answers_table',1),(29,'2025_06_25_512514_modify_conversations_for_group_chat',1),(30,'2025_07_01_145124_add_location_to_user_profiles',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
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
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
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
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `tutor_id` bigint(20) unsigned NOT NULL,
  `stripe_payment_intent_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `platform_fee` decimal(10,2) NOT NULL,
  `tutor_amount` decimal(10,2) NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'usd',
  `status` varchar(255) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_method_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_method_details`)),
  `refund_status` varchar(255) DEFAULT NULL,
  `stripe_refund_id` varchar(255) DEFAULT NULL,
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_stripe_payment_intent_id_unique` (`stripe_payment_intent_id`),
  KEY `payments_student_id_foreign` (`student_id`),
  KEY `payments_session_id_student_id_index` (`session_id`,`student_id`),
  KEY `payments_tutor_id_status_index` (`tutor_id`,`status`),
  KEY `payments_status_index` (`status`),
  KEY `payments_refund_status_index` (`refund_status`),
  CONSTRAINT `payments_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `tutor_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
-- Table structure for table `possible_answers`
--

DROP TABLE IF EXISTS `possible_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `possible_answers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `answer` varchar(255) NOT NULL,
  `question_number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `possible_answers`
--

LOCK TABLES `possible_answers` WRITE;
/*!40000 ALTER TABLE `possible_answers` DISABLE KEYS */;
INSERT INTO `possible_answers` VALUES (1,'2025-07-03 14:48:16','2025-07-03 14:48:16','Mathematics',2),(2,'2025-07-03 14:48:16','2025-07-03 14:48:16','Romanian',2),(3,'2025-07-03 14:48:16','2025-07-03 14:48:16','English',2),(4,'2025-07-03 14:48:16','2025-07-03 14:48:16','French',2),(5,'2025-07-03 14:48:16','2025-07-03 14:48:16','German',2),(6,'2025-07-03 14:48:16','2025-07-03 14:48:16','History',2),(7,'2025-07-03 14:48:16','2025-07-03 14:48:16','Geography',2),(8,'2025-07-03 14:48:16','2025-07-03 14:48:16','Biology',2),(9,'2025-07-03 14:48:16','2025-07-03 14:48:16','Physics',2),(10,'2025-07-03 14:48:16','2025-07-03 14:48:16','Chemistry',2),(11,'2025-07-03 14:48:16','2025-07-03 14:48:16','Computer Science',2),(12,'2025-07-03 14:48:16','2025-07-03 14:48:16','Economics',2),(13,'2025-07-03 14:48:16','2025-07-03 14:48:16','Logic',2),(14,'2025-07-03 14:48:16','2025-07-03 14:48:16','Psychology',2),(15,'2025-07-03 14:48:16','2025-07-03 14:48:16','Philosophy',2),(16,'2025-07-03 14:48:16','2025-07-03 14:48:16','Music',2),(17,'2025-07-03 14:48:16','2025-07-03 14:48:16','Art',2),(18,'2025-07-03 14:48:16','2025-07-03 14:48:16','Tutor',1),(19,'2025-07-03 14:48:16','2025-07-03 14:48:16','Student',1),(20,'2025-07-03 14:48:16','2025-07-03 14:48:16','Online',3),(21,'2025-07-03 14:48:16','2025-07-03 14:48:16','In-person',3),(22,'2025-07-03 14:48:16','2025-07-03 14:48:16','Baccalaureate',4),(23,'2025-07-03 14:48:16','2025-07-03 14:48:16','National Evaluation',4);
/*!40000 ALTER TABLE `possible_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_participants`
--

DROP TABLE IF EXISTS `session_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `session_participants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'registered',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `stripe_payment_intent_id` varchar(255) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `refund_status` varchar(255) DEFAULT NULL,
  `stripe_refund_id` varchar(255) DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_participants_session_id_student_id_unique` (`session_id`,`student_id`),
  KEY `session_participants_session_id_status_index` (`session_id`,`status`),
  KEY `session_participants_student_id_status_index` (`student_id`,`status`),
  KEY `session_participants_payment_status_index` (`payment_status`),
  KEY `session_participants_stripe_payment_intent_id_index` (`stripe_payment_intent_id`),
  KEY `session_participants_refund_status_index` (`refund_status`),
  CONSTRAINT `session_participants_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `tutor_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `session_participants_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_participants`
--

LOCK TABLES `session_participants` WRITE;
/*!40000 ALTER TABLE `session_participants` DISABLE KEYS */;
INSERT INTO `session_participants` VALUES (1,1,3,'registered','paid','pi_3RgtGvQavUYBtXHs0KbzYTnQ',20.00,'2025-07-03 16:58:36',NULL,NULL,NULL,NULL,'2025-07-03 16:58:36','2025-07-03 16:58:36'),(2,2,3,'registered','paid','pi_3RgtmNQavUYBtXHs51kM5Th1',30.00,'2025-07-03 17:30:54',NULL,NULL,NULL,NULL,'2025-07-03 17:30:54','2025-07-03 17:30:54'),(3,3,8,'cancelled','pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-07-03 18:31:24','2025-07-03 18:34:53');
/*!40000 ALTER TABLE `session_participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription_items`
--

DROP TABLE IF EXISTS `subscription_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscription_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(20) unsigned NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_product` varchar(255) NOT NULL,
  `stripe_price` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscription_items_subscription_id_stripe_price_unique` (`subscription_id`,`stripe_price`),
  UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_items`
--

LOCK TABLES `subscription_items` WRITE;
/*!40000 ALTER TABLE `subscription_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscription_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_status` varchar(255) NOT NULL,
  `stripe_price` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tutor_ratings`
--

DROP TABLE IF EXISTS `tutor_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tutor_ratings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tutor_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_tutor_student_rating` (`tutor_id`,`student_id`),
  KEY `tutor_ratings_student_id_foreign` (`student_id`),
  KEY `idx_tutor_student_rating` (`tutor_id`,`student_id`),
  CONSTRAINT `tutor_ratings_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tutor_ratings_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tutor_ratings`
--

LOCK TABLES `tutor_ratings` WRITE;
/*!40000 ALTER TABLE `tutor_ratings` DISABLE KEYS */;
INSERT INTO `tutor_ratings` VALUES (1,5,3,5,'Imi place vocea lui','2025-07-03 16:59:21','2025-07-03 17:31:20');
/*!40000 ALTER TABLE `tutor_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tutor_sessions`
--

DROP TABLE IF EXISTS `tutor_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tutor_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tutor_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'one_on_one',
  `max_students` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'scheduled',
  `is_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `recurrence_pattern` varchar(255) DEFAULT NULL,
  `recurrence_end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tutor_sessions_tutor_id_start_time_index` (`tutor_id`,`start_time`),
  KEY `tutor_sessions_type_index` (`type`),
  KEY `tutor_sessions_status_index` (`status`),
  CONSTRAINT `tutor_sessions_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tutor_sessions`
--

LOCK TABLES `tutor_sessions` WRITE;
/*!40000 ALTER TABLE `tutor_sessions` DISABLE KEYS */;
INSERT INTO `tutor_sessions` VALUES (1,5,'Calculus','Today we will learn the basics of calculus, first lesson','2025-07-05 12:00:00','2025-07-05 13:00:00','group',5,20.00,'scheduled',0,NULL,NULL,'2025-07-03 16:57:34','2025-07-03 16:57:34'),(2,5,'Test','Test','2025-07-11 12:00:00','2025-07-11 13:00:00','group',7,30.00,'scheduled',0,NULL,NULL,'2025-07-03 17:30:17','2025-07-03 17:30:17'),(3,6,'Test','Test','2025-07-05 12:00:00','2025-07-05 13:00:00','one_on_one',NULL,NULL,'scheduled',0,NULL,NULL,'2025-07-03 18:29:52','2025-07-03 18:29:52');
/*!40000 ALTER TABLE `tutor_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tutors_students`
--

DROP TABLE IF EXISTS `tutors_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tutors_students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tutor_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tutors_students_tutor_id_foreign` (`tutor_id`),
  KEY `tutors_students_student_id_foreign` (`student_id`),
  CONSTRAINT `tutors_students_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tutors_students_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tutors_students`
--

LOCK TABLES `tutors_students` WRITE;
/*!40000 ALTER TABLE `tutors_students` DISABLE KEYS */;
INSERT INTO `tutors_students` VALUES (2,5,3,NULL,NULL);
/*!40000 ALTER TABLE `tutors_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_photo` varchar(255) DEFAULT NULL,
  `about_me` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` VALUES (1,1,NULL,NULL,NULL,NULL,'2025-07-03 14:48:16','2025-07-03 14:48:16'),(2,2,NULL,NULL,NULL,NULL,'2025-07-03 14:52:56','2025-07-03 14:52:56'),(3,3,'0741370795',NULL,'🙂Text','Buchar=','2025-07-03 14:54:06','2025-07-03 17:13:21'),(4,4,NULL,NULL,NULL,NULL,'2025-07-03 14:55:37','2025-07-03 14:55:37'),(5,5,'0741370795',NULL,'Text\n😈','Bucharest','2025-07-03 14:57:30','2025-07-03 17:51:04'),(6,6,NULL,NULL,NULL,NULL,'2025-07-03 18:17:22','2025-07-03 18:17:22'),(8,8,NULL,NULL,NULL,NULL,'2025-07-03 18:30:28','2025-07-03 18:30:28');
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_stripe_accounts`
--

DROP TABLE IF EXISTS `user_stripe_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_stripe_accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `stripe_customer_id` varchar(255) DEFAULT NULL,
  `stripe_account_id` varchar(255) DEFAULT NULL,
  `stripe_onboarding_completed` tinyint(1) NOT NULL DEFAULT 0,
  `stripe_account_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_stripe_accounts_user_id_unique` (`user_id`),
  KEY `user_stripe_accounts_stripe_customer_id_index` (`stripe_customer_id`),
  KEY `user_stripe_accounts_stripe_account_id_index` (`stripe_account_id`),
  CONSTRAINT `user_stripe_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_stripe_accounts`
--

LOCK TABLES `user_stripe_accounts` WRITE;
/*!40000 ALTER TABLE `user_stripe_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_stripe_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','tutor','student') NOT NULL DEFAULT 'student',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `stripe_id` varchar(255) DEFAULT NULL,
  `pm_type` varchar(255) DEFAULT NULL,
  `pm_last_four` varchar(4) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_stripe_id_index` (`stripe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@admin.com','2025-07-03 14:48:16','$2y$12$YPDAvKDRvYA/zQQik0yVVeXm/Bz2cu.EF.vB7O6qPALLQIzOwgAWu','5zOzor6mfr0y0z1Ky9XdOHoc5QSD3O7R722Itklw8cS2KkZlWYdThhS5yoAd','2025-07-03 14:48:16','2025-07-03 14:50:33','admin',1,NULL,NULL,NULL,NULL),(2,'Sebastian','sosig132@gmail.com','2025-07-03 14:53:05','$2y$12$tXAXT0MpGBWkTc47/wsYe.K5AhfSGMeghl0Xuiaurfs2Xb9qEx/fS',NULL,'2025-07-03 14:52:56','2025-07-03 14:53:05','student',1,NULL,NULL,NULL,NULL),(3,'Andre','andremunteanu2@gmail.com','2025-07-03 14:54:21','$2y$12$JWA4OG1be8TYkcKSQt6U0eyJTg0X2is9udsww1ORBB/YyKZ3jSxMi',NULL,'2025-07-03 14:54:06','2025-07-03 14:54:21','student',1,NULL,NULL,NULL,NULL),(4,'Adrian','meditator@gmail.com','2025-07-03 14:55:52','$2y$12$FFnckdKrnUrmgboaYN9fseeTNHuVmGRaX95b23LjYWbjYgK5vdPp.',NULL,'2025-07-03 14:55:37','2025-07-03 14:55:52','student',1,NULL,NULL,NULL,NULL),(5,'Emanuel','meditator2@gmail.com','2025-07-03 14:57:35','$2y$12$AUpx7FCIT3e42/wFK/i0Ae9lMboIEctKXCm.h47pZySGqHJVm0ekC',NULL,'2025-07-03 14:57:30','2025-07-03 14:57:46','tutor',1,NULL,NULL,NULL,NULL),(6,'Teacher','teacher@teacher.com','2025-07-03 18:17:27','$2y$12$JpA9Oxmnnol0SE/Vj8it4O2ia.q2Get5X0Umja.H6deP8itaER5AW',NULL,'2025-07-03 18:17:22','2025-07-03 18:17:47','tutor',1,NULL,NULL,NULL,NULL),(8,'Student','student@student.com','2025-07-03 18:30:42','$2y$12$GXVTXrTcRgQBXqo2B79vV.tLQZf1596EMo0DFRXGTGkChk.5VAHdK',NULL,'2025-07-03 18:30:28','2025-07-03 18:30:42','student',1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_conversations`
--

DROP TABLE IF EXISTS `users_conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_conversations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `conversation_id` bigint(20) unsigned NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `joined_at` timestamp NULL DEFAULT NULL,
  `left_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_conversations_user_id_conversation_id_unique` (`user_id`,`conversation_id`),
  KEY `users_conversations_conversation_id_foreign` (`conversation_id`),
  CONSTRAINT `users_conversations_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_conversations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_conversations`
--

LOCK TABLES `users_conversations` WRITE;
/*!40000 ALTER TABLE `users_conversations` DISABLE KEYS */;
INSERT INTO `users_conversations` VALUES (3,5,2,0,'2025-07-03 17:28:21',NULL,NULL,NULL),(4,3,2,0,'2025-07-03 17:28:21',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users_conversations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-04  0:46:58
