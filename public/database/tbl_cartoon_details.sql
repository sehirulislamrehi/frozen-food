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

insert  into `cartoon_details` values (1,1,12,2,30,'2022-12-15 09:54:03','2022-12-15 09:54:53'),(3,2,14,3,100,'2022-12-19 11:21:51','2022-12-19 11:21:51'),(4,1,11,2,50,'2022-12-20 09:59:00','2022-12-20 09:59:34');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
