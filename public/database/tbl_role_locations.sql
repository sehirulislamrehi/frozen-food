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

/*Table structure for table `role_locations` */

DROP TABLE IF EXISTS `role_locations`;

CREATE TABLE `role_locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `location_id` bigint(20) unsigned NOT NULL,
  `type` enum('Group','Company','Location') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_locations_role_id_foreign` (`role_id`),
  KEY `role_locations_location_id_foreign` (`location_id`),
  CONSTRAINT `role_locations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_locations_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_locations` */

insert  into `role_locations` values (1,1,1,'Group','2022-09-24 05:58:36','2022-09-24 05:58:36'),(2,1,3,'Company','2022-09-24 05:58:36','2022-09-24 05:58:36'),(3,1,5,'Location','2022-09-24 05:58:36','2022-09-24 05:58:36'),(4,1,6,'Location','2022-09-24 05:58:36','2022-09-24 05:58:36'),(5,2,1,'Group','2022-09-24 06:00:54','2022-09-24 06:00:54'),(6,2,3,'Company','2022-09-24 06:00:54','2022-09-24 06:00:54'),(7,2,5,'Location','2022-09-24 06:00:54','2022-09-24 06:00:54'),(8,2,6,'Location','2022-09-24 06:00:54','2022-09-24 06:00:54');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
