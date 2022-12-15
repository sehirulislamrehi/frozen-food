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

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations` values (1,'2014_10_12_100000_create_password_resets_table',1),(2,'2019_08_19_000000_create_failed_jobs_table',1),(3,'2019_12_14_000001_create_personal_access_tokens_table',1),(4,'2021_04_24_161700_create_modules_table',1),(5,'2021_04_24_161711_create_permissions_table',1),(6,'2021_04_24_161732_create_locations_table',1),(7,'2021_04_24_161733_create_roles_table',1),(8,'2021_04_24_161734_create_permission_roles_table',1),(9,'2021_04_24_161742_create_sub_modules_table',1),(10,'2021_04_24_161757_create_super_admins_table',1),(11,'2021_08_19_102916_create_app_infos_table',1),(12,'2022_09_13_064302_create_temperature_table',1),(13,'2022_09_15_044004_create_devices_table',1),(14,'2022_09_15_044005_create_users_table',1),(15,'2022_09_17_091226_create_freezers_table',1),(16,'2022_09_17_091233_create_freezer_details_table',1),(17,'2022_09_22_092331_create_role_locations_table',1),(18,'2022_09_22_100816_create_user_locations_table',1),(19,'2022_09_27_094759_create_trolleys_table',2),(20,'2022_09_28_095406_create_units_table',2),(21,'2022_09_29_111949_create_products_table',2),(22,'2022_09_29_111954_create_product_details_table',2),(23,'2022_10_01_121806_create_product_stocks_table',2),(24,'2022_10_06_112313_create_blast_freezer_entries_table',3),(25,'2022_12_10_094750_create_email_lists_table',4),(26,'2022_12_11_091101_create_cartoons_table',4),(27,'2022_12_11_091910_create_cartoon_details_table',4);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
