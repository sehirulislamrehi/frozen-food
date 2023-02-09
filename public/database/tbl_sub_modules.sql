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

/*Table structure for table `sub_modules` */

DROP TABLE IF EXISTS `sub_modules`;

CREATE TABLE `sub_modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sub_modules_name_unique` (`name`),
  UNIQUE KEY `sub_modules_key_unique` (`key`),
  KEY `sub_modules_module_id_foreign` (`module_id`),
  CONSTRAINT `sub_modules_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sub_modules` */

insert  into `sub_modules` values (1,'All User','all_user',1,'user.all',1,NULL,NULL),(2,'Roles','roles',2,'role.all',1,NULL,NULL),(3,'App Info','app_info',1,'app.info.all',50,NULL,NULL),(4,'Temperature log','temperature_log',1,'temperature.log',2,NULL,NULL),(5,'Company','company',1,'company.all',3,NULL,NULL),(6,'Location','location',2,'location.all',3,NULL,NULL),(7,'Device','device',1,'device.all',4,NULL,NULL),(8,'Freezer','freezer',1,'freezer.all',5,NULL,NULL),(9,'Trolley','trolley',2,'trolley.all',4,NULL,NULL),(10,'Products','products',3,'products.all',4,NULL,NULL),(11,'Blast Freezer Entry','blast_freezer_entry',2,'blast.freezer.entry.all',5,NULL,NULL),(12,'Email Lists','email_list',2,'email.list.all',50,NULL,NULL),(13,'Cartoon List','cartoon_list',3,'cartoon.list.all',5,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
