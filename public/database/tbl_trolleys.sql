/*
SQLyog Job Agent Version 8.2 Copyright(c) Webyog Softworks Pvt. Ltd. All Rights Reserved.


MySQL - 5.5.68-MariaDB : Database - frozen_food
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`frozen_food` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `frozen_food`;

/*Table structure for table `trolleys` */

DROP TABLE IF EXISTS `trolleys`;

CREATE TABLE `trolleys` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `company_id` bigint(20) unsigned NOT NULL,
  `location_id` bigint(20) unsigned NOT NULL,
  `status` enum('Free','Used') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Free',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `trolleys_code_unique` (`code`),
  KEY `trolleys_group_id_foreign` (`group_id`),
  KEY `trolleys_company_id_foreign` (`company_id`),
  KEY `trolleys_location_id_foreign` (`location_id`),
  CONSTRAINT `trolleys_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trolleys_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trolleys_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `trolleys` */

insert  into `trolleys` values (2,'T760049','Trolley-01',1,3,6,'Free',1,'2022-10-04 11:20:52','2023-01-01 12:33:08'),(3,'T50778','Trolley-02',1,3,6,'Used',1,'2022-10-11 08:21:05','2022-12-17 10:06:54'),(4,'T24950','Trolley -03',1,3,6,'Free',1,'2022-10-11 14:18:10','2023-01-01 12:33:14'),(5,'T396413','Trolley -04',1,3,6,'Free',1,'2022-10-20 15:04:16','2022-10-25 14:50:28'),(6,'T353587','Trolley-05',1,3,6,'Used',1,'2022-10-20 15:07:16','2023-01-01 12:32:56'),(7,'T814729','Trolley-06',1,3,6,'Free',1,'2022-10-20 15:07:24','2022-10-20 15:07:24'),(8,'T676178','Trolley-07',1,3,6,'Free',1,'2022-10-20 15:07:31','2023-01-01 12:46:59'),(9,'T582254','Trolley-08',1,3,6,'Free',1,'2022-10-20 15:08:08','2023-01-15 09:23:34'),(10,'T915936','Trolley-09',1,3,6,'Free',1,'2022-10-20 15:08:13','2022-10-20 15:08:13'),(11,'T394499','Trolley-10',1,3,6,'Free',1,'2022-10-20 15:08:18','2022-10-20 15:08:18'),(12,'T583265','Trolley-11',1,3,6,'Free',1,'2023-01-18 16:13:28','2023-01-18 16:13:28'),(13,'T53495','Trolley-12',1,3,6,'Free',1,'2023-01-18 16:38:32','2023-01-18 16:38:32'),(14,'T621375','Trolley-13',1,3,6,'Free',1,'2023-01-18 16:40:35','2023-01-18 16:40:35'),(15,'T269971','Trolley-14',1,3,6,'Free',1,'2023-01-18 16:42:33','2023-01-18 16:42:33'),(16,'T820164','Trolley-15',1,3,6,'Free',1,'2023-01-18 16:49:49','2023-01-18 16:49:49'),(17,'T41045','Trolley-16',1,3,6,'Free',1,'2023-01-18 17:10:15','2023-01-18 17:10:15'),(18,'T315515','Trolley-17',1,3,6,'Free',1,'2023-01-18 17:46:22','2023-01-18 17:46:22'),(19,'T504126','Torlley-18',1,3,6,'Free',1,'2023-01-18 17:49:07','2023-01-18 17:49:07'),(20,'T290879','Trolley-19',1,3,6,'Free',1,'2023-01-18 17:53:58','2023-01-18 17:53:58'),(21,'T851789','Trolley-20',1,3,6,'Free',1,'2023-01-18 17:55:02','2023-01-18 17:55:02'),(22,'T5390','Trolley-21',1,3,6,'Free',1,'2023-01-19 08:38:57','2023-01-19 08:38:57'),(23,'T93484','Trolley-22',1,3,6,'Free',1,'2023-01-19 08:40:41','2023-01-19 08:40:41'),(24,'T615237','Trolley-23',1,3,6,'Free',1,'2023-01-19 08:41:49','2023-01-19 08:41:49'),(25,'T785783','Trolley-24',1,3,6,'Free',1,'2023-01-19 08:42:51','2023-01-19 08:42:51'),(26,'T302114','Trolley-25',1,3,6,'Free',1,'2023-01-19 08:43:57','2023-01-19 08:43:57'),(27,'T835360','Trolley-26',1,3,6,'Free',1,'2023-01-19 08:45:11','2023-01-19 08:45:11'),(28,'T411805','Trolley-27',1,3,6,'Free',1,'2023-01-19 08:47:47','2023-01-19 08:47:47'),(29,'T235830','Trolley-28',1,3,6,'Free',1,'2023-01-19 08:49:06','2023-01-19 08:49:06'),(30,'T24561','Trolley-29',1,3,6,'Free',1,'2023-01-19 08:50:06','2023-01-19 08:50:06'),(31,'T459691','Trolley-30',1,3,6,'Free',1,'2023-01-19 08:51:07','2023-01-19 08:51:07'),(32,'T664767','Trolley-31',1,3,6,'Free',1,'2023-01-19 08:52:08','2023-01-19 08:52:08'),(33,'T675524','Trolley-32',1,3,6,'Free',1,'2023-01-19 08:53:27','2023-01-19 08:53:27'),(34,'T730247','Trolley-33',1,3,6,'Free',1,'2023-01-19 08:54:36','2023-01-19 08:54:36'),(35,'T694159','Trolley-34',1,3,6,'Free',1,'2023-01-19 08:56:57','2023-01-19 08:56:57'),(36,'T783293','Trolley-34',1,3,6,'Free',1,'2023-01-19 08:58:22','2023-01-19 08:58:22'),(37,'T416667','Trolley-35',1,3,6,'Free',1,'2023-01-19 08:59:24','2023-01-19 08:59:24'),(38,'T32344','Trolley-36',1,3,6,'Free',1,'2023-01-19 09:00:28','2023-01-19 09:00:28'),(39,'T701806','Trolley-37',1,3,6,'Free',1,'2023-01-19 09:01:27','2023-01-19 09:01:42'),(40,'T761008','Trolley-38',1,3,6,'Free',1,'2023-01-19 09:02:53','2023-02-08 11:55:47');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
