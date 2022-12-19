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

/*Table structure for table `user_locations` */

DROP TABLE IF EXISTS `user_locations`;

CREATE TABLE `user_locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `location_id` bigint(20) unsigned NOT NULL,
  `type` enum('Group','Company','Location') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_locations_user_id_foreign` (`user_id`),
  KEY `user_locations_location_id_foreign` (`location_id`),
  CONSTRAINT `user_locations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_locations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_locations` */

insert  into `user_locations` values (5,2,1,'Group','2022-09-24 06:01:29','2022-09-24 06:01:29'),(6,2,3,'Company','2022-09-24 06:01:29','2022-09-24 06:01:29'),(7,2,5,'Location','2022-09-24 06:01:29','2022-09-24 06:01:29'),(8,2,6,'Location','2022-09-24 06:01:29','2022-09-24 06:01:29'),(24,4,1,'Group','2022-09-24 06:23:38','2022-09-24 06:23:38'),(25,4,3,'Company','2022-09-24 06:23:38','2022-09-24 06:23:38'),(26,4,5,'Location','2022-09-24 06:23:38','2022-09-24 06:23:38'),(27,4,6,'Location','2022-09-24 06:23:38','2022-09-24 06:23:38'),(28,4,8,'Location','2022-09-24 06:23:38','2022-09-24 06:23:38'),(29,4,9,'Location','2022-09-24 06:23:38','2022-09-24 06:23:38'),(30,4,10,'Location','2022-09-24 06:23:38','2022-09-24 06:23:38'),(31,3,1,'Group','2022-09-24 06:23:51','2022-09-24 06:23:51'),(32,3,3,'Company','2022-09-24 06:23:51','2022-09-24 06:23:51'),(33,3,5,'Location','2022-09-24 06:23:51','2022-09-24 06:23:51'),(34,3,6,'Location','2022-09-24 06:23:51','2022-09-24 06:23:51'),(35,3,8,'Location','2022-09-24 06:23:51','2022-09-24 06:23:51'),(36,3,9,'Location','2022-09-24 06:23:51','2022-09-24 06:23:51'),(37,3,10,'Location','2022-09-24 06:23:51','2022-09-24 06:23:51'),(38,5,1,'Group','2022-10-03 14:50:48','2022-10-03 14:50:48'),(39,5,3,'Company','2022-10-03 14:50:48','2022-10-03 14:50:48'),(40,5,5,'Location','2022-10-03 14:50:48','2022-10-03 14:50:48'),(41,5,6,'Location','2022-10-03 14:50:48','2022-10-03 14:50:48'),(42,6,1,'Group','2022-10-03 14:50:59','2022-10-03 14:50:59'),(43,6,3,'Company','2022-10-03 14:50:59','2022-10-03 14:50:59'),(44,6,5,'Location','2022-10-03 14:50:59','2022-10-03 14:50:59'),(45,6,6,'Location','2022-10-03 14:50:59','2022-10-03 14:50:59'),(46,7,1,'Group','2022-10-03 14:51:08','2022-10-03 14:51:08'),(47,7,3,'Company','2022-10-03 14:51:08','2022-10-03 14:51:08'),(48,7,5,'Location','2022-10-03 14:51:08','2022-10-03 14:51:08'),(49,7,6,'Location','2022-10-03 14:51:08','2022-10-03 14:51:08'),(50,8,1,'Group','2022-10-03 14:51:12','2022-10-03 14:51:12'),(51,8,3,'Company','2022-10-03 14:51:12','2022-10-03 14:51:12'),(52,8,5,'Location','2022-10-03 14:51:12','2022-10-03 14:51:12'),(53,8,6,'Location','2022-10-03 14:51:12','2022-10-03 14:51:12'),(58,10,1,'Group','2022-10-03 14:51:25','2022-10-03 14:51:25'),(59,10,3,'Company','2022-10-03 14:51:25','2022-10-03 14:51:25'),(60,10,5,'Location','2022-10-03 14:51:25','2022-10-03 14:51:25'),(61,10,6,'Location','2022-10-03 14:51:25','2022-10-03 14:51:25'),(62,9,1,'Group','2022-10-04 11:18:22','2022-10-04 11:18:22'),(63,9,3,'Company','2022-10-04 11:18:22','2022-10-04 11:18:22'),(64,9,6,'Location','2022-10-04 11:18:22','2022-10-04 11:18:22'),(72,1,1,'Group','2022-12-17 16:56:55','2022-12-17 16:56:55'),(73,1,3,'Company','2022-12-17 16:56:55','2022-12-17 16:56:55'),(74,1,5,'Location','2022-12-17 16:56:55','2022-12-17 16:56:55'),(75,1,6,'Location','2022-12-17 16:56:55','2022-12-17 16:56:55'),(76,1,8,'Location','2022-12-17 16:56:55','2022-12-17 16:56:55'),(77,1,9,'Location','2022-12-17 16:56:55','2022-12-17 16:56:55'),(78,1,10,'Location','2022-12-17 16:56:55','2022-12-17 16:56:55');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
