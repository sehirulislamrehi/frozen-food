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

/*Table structure for table `cartoons` */

DROP TABLE IF EXISTS `cartoons`;

CREATE TABLE `cartoons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cartoon_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cartoon_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actual_cartoon_weight` double NOT NULL COMMENT 'weight in kg. Manual entry',
  `cartoon_weight` double NOT NULL COMMENT 'weight in kg. Auto calculated.',
  `packet_quantity` int(11) NOT NULL,
  `per_packet_weight` double NOT NULL COMMENT 'weight in kg',
  `per_packet_item` int(11) DEFAULT NULL,
  `sample_item` int(11) NOT NULL DEFAULT '0',
  `status` enum('In','Out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `manufacture_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `company_id` bigint(20) unsigned NOT NULL,
  `location_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cartoons_group_id_foreign` (`group_id`),
  KEY `cartoons_company_id_foreign` (`company_id`),
  KEY `cartoons_location_id_foreign` (`location_id`),
  KEY `cartoons_product_id_foreign` (`product_id`),
  CONSTRAINT `cartoons_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cartoons_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cartoons_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cartoons_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cartoons` */

insert  into `cartoons` values (1,'cartoon 1','CN221610',8,80,10,0.4,10,0,'In',3,'2022-12-15','2023-12-15',1,3,6,'2022-12-15 09:54:03','2022-12-17 10:22:56');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
