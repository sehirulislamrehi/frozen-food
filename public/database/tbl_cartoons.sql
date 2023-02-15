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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cartoons` */

insert  into `cartoons` values (1,'Humza paratha 1600gm','CN466467',9.6,90,56,1.6,20,2,'In',2761,'2023-02-14','2025-02-14',1,3,6,'2023-02-14 11:14:00','2023-02-14 11:14:00'),(2,'Humza paratha 1600gm','CN79575',120,200,20,3.5,8,2,'In',4,'2023-02-14','2024-02-14',1,3,6,'2023-02-14 11:17:17','2023-02-14 11:17:17'),(3,'Humza paratha 1600gm','CN682294',120,180,12,3.6,2,2,'In',2761,'2023-02-14','2025-02-14',1,3,6,'2023-02-14 11:24:21','2023-02-14 11:24:21'),(4,'Humza paratha 1600gm','CN911938',80,80,24,3.5,12,2,'In',4,'2023-02-15','2024-02-15',1,3,6,'2023-02-15 03:55:23','2023-02-15 03:55:23');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
