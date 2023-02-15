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

/*Table structure for table `blast_freezer_entries` */

DROP TABLE IF EXISTS `blast_freezer_entries`;

CREATE TABLE `blast_freezer_entries` (
  `remaining_quantity` double unsigned NOT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Auto generated code',
  `group_id` bigint(20) unsigned NOT NULL,
  `company_id` bigint(20) unsigned NOT NULL,
  `location_id` bigint(20) unsigned NOT NULL,
  `device_id` bigint(20) unsigned NOT NULL,
  `trolley_id` bigint(20) unsigned NOT NULL,
  `product_details_id` bigint(20) unsigned NOT NULL,
  `lead_time` datetime NOT NULL COMMENT 'Trolley out time',
  `trolley_outed` datetime DEFAULT NULL,
  `quantity` double unsigned NOT NULL COMMENT 'Quantity in Kg',
  `status` enum('In','Out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blast_freezer_entries_code_unique` (`code`),
  KEY `blast_freezer_entries_group_id_foreign` (`group_id`),
  KEY `blast_freezer_entries_company_id_foreign` (`company_id`),
  KEY `blast_freezer_entries_location_id_foreign` (`location_id`),
  KEY `blast_freezer_entries_device_id_foreign` (`device_id`),
  KEY `blast_freezer_entries_trolley_id_foreign` (`trolley_id`),
  KEY `blast_freezer_entries_product_details_id_foreign` (`product_details_id`),
  CONSTRAINT `blast_freezer_entries_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blast_freezer_entries_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blast_freezer_entries_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blast_freezer_entries_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blast_freezer_entries_product_details_id_foreign` FOREIGN KEY (`product_details_id`) REFERENCES `product_details` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blast_freezer_entries_trolley_id_foreign` FOREIGN KEY (`trolley_id`) REFERENCES `trolleys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `blast_freezer_entries` */

insert  into `blast_freezer_entries` values (0,3,'BF520781',1,3,6,2,2,4,'2023-02-14 17:10:00','2023-02-14 11:09:36',90,'Out','2023-02-14 11:03:50','2023-02-14 11:14:00'),(0,4,'BF664166',1,3,6,1,3,3,'2023-02-14 17:15:00','2023-02-14 11:15:46',200,'Out','2023-02-14 11:05:23','2023-02-14 11:17:17'),(0,5,'BF827925',1,3,6,2,4,4,'2023-02-14 17:18:00','2023-02-14 11:23:00',180,'Out','2023-02-14 11:06:07','2023-02-14 11:24:21'),(120,6,'BF570505',1,3,6,2,2,3,'2023-02-15 09:52:00','2023-02-15 03:50:47',200,'Out','2023-02-15 03:48:07','2023-02-15 03:55:23');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
