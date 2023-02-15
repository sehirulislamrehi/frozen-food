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

/*Table structure for table `cartoon_details` */

DROP TABLE IF EXISTS `cartoon_details`;

CREATE TABLE `cartoon_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cartoon_id` bigint(20) unsigned NOT NULL,
  `blast_freezer_entries_id` bigint(20) unsigned NOT NULL,
  `product_details_id` bigint(20) unsigned NOT NULL,
  `quantity` double NOT NULL COMMENT 'quantity in kg.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cartoon_details_cartoon_id_foreign` (`cartoon_id`),
  KEY `cartoon_details_blast_freezer_entries_id_foreign` (`blast_freezer_entries_id`),
  KEY `cartoon_details_product_details_id_foreign` (`product_details_id`),
  CONSTRAINT `cartoon_details_blast_freezer_entries_id_foreign` FOREIGN KEY (`blast_freezer_entries_id`) REFERENCES `blast_freezer_entries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cartoon_details_cartoon_id_foreign` FOREIGN KEY (`cartoon_id`) REFERENCES `cartoons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cartoon_details_product_details_id_foreign` FOREIGN KEY (`product_details_id`) REFERENCES `product_details` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cartoon_details` */

insert  into `cartoon_details` values (1,1,3,4,90,'2023-02-14 11:14:00','2023-02-14 11:14:00'),(2,2,4,3,200,'2023-02-14 11:17:17','2023-02-14 11:17:17'),(3,3,5,4,180,'2023-02-14 11:24:21','2023-02-14 11:24:21'),(4,4,6,3,80,'2023-02-15 03:55:23','2023-02-15 03:55:23');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
