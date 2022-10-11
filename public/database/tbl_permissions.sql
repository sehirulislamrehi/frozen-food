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

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_key_unique` (`key`),
  KEY `permissions_module_id_foreign` (`module_id`),
  CONSTRAINT `permissions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions` values (1,'user_module','User Module',1,NULL,NULL),(2,'all_user','All User',1,NULL,NULL),(3,'add_user','-- Add User',1,NULL,NULL),(4,'edit_user','-- Edit User',1,NULL,NULL),(6,'settings','Setting Module',50,NULL,NULL),(7,'app_info','-- Software Info',50,NULL,NULL),(8,'log_sheets','Log sheets',2,NULL,NULL),(9,'temperature_log','-- Temperature log',2,NULL,NULL),(17,'system_module','System',4,NULL,NULL),(18,'device','Device',4,NULL,NULL),(19,'add_device','-- Add Device',4,NULL,NULL),(20,'edit_device','-- Edit Device',4,NULL,NULL),(21,'delete_device','-- Delete Device',4,NULL,NULL),(22,'roles','Roles',1,NULL,NULL),(23,'add_roles','-- Add Roles',1,NULL,NULL),(24,'edit_roles','-- Edit Roles',1,NULL,NULL),(25,'production_module','Production',5,NULL,NULL),(26,'freezer','Freezer',5,NULL,NULL),(27,'add_freezer','-- Add Freezer',5,NULL,NULL),(28,'edit_freezer','-- Edit Freezer',5,NULL,NULL),(29,'delete_freezer','-- Delete Freezer',5,NULL,NULL),(30,'database_download','Download Database',6,NULL,NULL),(31,'trolley','Trolley',4,NULL,NULL),(32,'add_trolley','-- Add Trolley',4,NULL,NULL),(33,'edit_trolley','-- Edit Trolley',4,NULL,NULL),(34,'products','Products',4,NULL,NULL),(35,'add_products','-- Add Products',4,NULL,NULL),(36,'edit_products','-- Edit Products',4,NULL,NULL),(37,'stock_entry','-- Stock Entry',4,NULL,NULL),(38,'stock_summary','-- Stock Summary',4,NULL,NULL),(39,'blast_freezer_entry','Blast Freezer Entry',5,NULL,NULL),(40,'add_blast_freezer_entry','-- Add Blast Freezer Entry',5,NULL,NULL),(41,'edit_blast_freezer_entry','-- Edit Blast Freezer Entry',5,NULL,NULL),(42,'delete_blast_freezer_entry','-- Delete Blast Freezer Entry',5,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
