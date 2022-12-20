/*
SQLyog Job Agent Version 8.2 Copyright(c) Webyog Softworks Pvt. Ltd. All Rights Reserved.


MySQL - 5.7.35 : Database - frozen_food
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`frozen_food` /*!40100 DEFAULT CHARACTER SET latin1 */;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `trolleys` */

insert  into `trolleys` values (2,'T760049','Trolley-01',1,3,6,'Free',1,'2022-10-04 11:20:52','2022-12-15 09:47:25'),(3,'T50778','Trolley-02',1,3,6,'Used',1,'2022-10-11 08:21:05','2022-12-17 10:06:54'),(4,'T24950','Trolley -03',1,3,6,'Free',1,'2022-10-11 14:18:10','2022-12-19 11:18:32'),(5,'T396413','Trolley -04',1,3,6,'Free',1,'2022-10-20 15:04:16','2022-10-25 14:50:28'),(6,'T353587','Trolley-05',1,3,6,'Free',1,'2022-10-20 15:07:16','2022-10-20 15:07:16'),(7,'T814729','Trolley-06',1,3,6,'Free',1,'2022-10-20 15:07:24','2022-10-20 15:07:24'),(8,'T676178','Trolley-07',1,3,6,'Free',1,'2022-10-20 15:07:31','2022-10-20 15:07:31'),(9,'T582254','Trolley-08',1,3,6,'Free',1,'2022-10-20 15:08:08','2022-10-20 15:08:08'),(10,'T915936','Trolley-09',1,3,6,'Free',1,'2022-10-20 15:08:13','2022-10-20 15:08:13'),(11,'T394499','Trolley-10',1,3,6,'Free',1,'2022-10-20 15:08:18','2022-10-20 15:08:18');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
