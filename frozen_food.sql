-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2022 at 11:43 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frozen_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_infos`
--

CREATE TABLE `app_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fav` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_infos`
--

INSERT INTO `app_infos` (`id`, `logo`, `fav`, `mail_from_address`, `phone`, `created_at`, `updated_at`) VALUES
(1, '1663665616F3m6dTyMRKiL.jpg', '16636656162u4UKZPbk7DA.jpg', NULL, NULL, NULL, '2022-09-20 03:20:16');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_number` int(11) NOT NULL,
  `device_manual_id` int(11) NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `freezers`
--

CREATE TABLE `freezers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `freezer_details`
--

CREATE TABLE `freezer_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `freezer_id` bigint(20) UNSIGNED NOT NULL,
  `device_id` bigint(20) UNSIGNED NOT NULL,
  `device_manual_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Group','Company','Location') COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2021_04_24_161700_create_modules_table', 1),
(5, '2021_04_24_161711_create_permissions_table', 1),
(6, '2021_04_24_161732_create_locations_table', 1),
(7, '2021_04_24_161733_create_roles_table', 1),
(8, '2021_04_24_161734_create_permission_roles_table', 1),
(9, '2021_04_24_161742_create_sub_modules_table', 1),
(10, '2021_04_24_161757_create_super_admins_table', 1),
(11, '2021_08_19_102916_create_app_infos_table', 1),
(12, '2022_09_13_064302_create_temperature_table', 1),
(13, '2022_09_15_044004_create_devices_table', 1),
(14, '2022_09_15_044005_create_users_table', 1),
(15, '2022_09_17_091226_create_freezers_table', 1),
(16, '2022_09_17_091233_create_freezer_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `key`, `icon`, `position`, `route`, `created_at`, `updated_at`) VALUES
(1, 'User Module', 'user_module', 'fas fa-users', 1, NULL, NULL, NULL),
(2, 'Log Sheets', 'log_sheets', 'fas fa-file', 9, NULL, NULL, NULL),
(3, 'Location', 'location_module', 'fas fa-map', 2, NULL, NULL, NULL),
(4, 'System', 'system_module', 'fas fa-desktop', 3, NULL, NULL, NULL),
(5, 'Production', 'production_module', 'fab fa-product-hunt', 4, NULL, NULL, NULL),
(50, 'Settings', 'settings', 'fas fa-cog', 10, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `display_name`, `module_id`, `created_at`, `updated_at`) VALUES
(1, 'user_module', 'User Module', 1, NULL, NULL),
(2, 'all_user', 'All User', 1, NULL, NULL),
(3, 'add_user', '-- Add User', 1, NULL, NULL),
(4, 'edit_user', '-- Edit User', 1, NULL, NULL),
(5, 'reset_password', '-- Reset Password', 1, NULL, NULL),
(6, 'settings', 'Setting Module', 50, NULL, NULL),
(7, 'app_info', '-- Software Info', 50, NULL, NULL),
(8, 'log_sheets', 'Log sheets', 2, NULL, NULL),
(9, 'temperature_log', '-- Temperature log', 2, NULL, NULL),
(10, 'location_module', 'Location', 3, NULL, NULL),
(11, 'company', 'Company', 3, NULL, NULL),
(12, 'add_company', '-- Add Company', 3, NULL, NULL),
(13, 'edit_company', '-- Edit Company', 3, NULL, NULL),
(14, 'location', 'Location', 3, NULL, NULL),
(15, 'add_location', '-- Add Location', 3, NULL, NULL),
(16, 'edit_location', '-- Edit Location', 3, NULL, NULL),
(17, 'system_module', 'System', 4, NULL, NULL),
(18, 'device', 'Device', 4, NULL, NULL),
(19, 'add_device', '-- Add Device', 4, NULL, NULL),
(20, 'edit_device', '-- Edit Device', 4, NULL, NULL),
(21, 'delete_device', '-- Delete Device', 4, NULL, NULL),
(22, 'roles', 'Roles', 1, NULL, NULL),
(23, 'add_roles', '-- Add Roles', 1, NULL, NULL),
(24, 'edit_roles', '-- Edit Roles', 1, NULL, NULL),
(25, 'production_module', 'Production', 5, NULL, NULL),
(26, 'freezer', 'Freezer', 5, NULL, NULL),
(27, 'add_freezer', '-- Add Freezer', 5, NULL, NULL),
(28, 'edit_freezer', '-- Edit Freezer', 5, NULL, NULL),
(29, 'delete_freezer', '-- Delete Freezer', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(2, 1, 2, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(3, 1, 3, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(4, 1, 4, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(5, 1, 5, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(6, 1, 22, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(7, 1, 23, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(8, 1, 24, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(9, 1, 10, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(10, 1, 11, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(11, 1, 12, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(12, 1, 13, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(13, 1, 14, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(14, 1, 15, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(15, 1, 16, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(16, 1, 17, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(17, 1, 18, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(18, 1, 19, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(19, 1, 20, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(20, 1, 21, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(21, 1, 25, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(22, 1, 26, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(23, 1, 27, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(24, 1, 28, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(25, 1, 29, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(26, 1, 8, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(27, 1, 9, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(28, 1, 6, '2022-09-20 03:21:45', '2022-09-20 03:21:45'),
(29, 1, 7, '2022-09-20 03:21:45', '2022-09-20 03:21:45');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_modules`
--

CREATE TABLE `sub_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_modules`
--

INSERT INTO `sub_modules` (`id`, `name`, `key`, `position`, `route`, `module_id`, `created_at`, `updated_at`) VALUES
(1, 'All User', 'all_user', 1, 'user.all', 1, NULL, NULL),
(2, 'Roles', 'roles', 2, 'role.all', 1, NULL, NULL),
(3, 'App Info', 'app_info', 1, 'app.info.all', 50, NULL, NULL),
(4, 'Temperature log', 'temperature_log', 1, 'temperature.log', 2, NULL, NULL),
(5, 'Company', 'company', 1, 'company.all', 3, NULL, NULL),
(6, 'Location', 'location', 2, 'location.all', 3, NULL, NULL),
(7, 'Device', 'device', 1, 'device.all', 4, NULL, NULL),
(8, 'Freezer', 'freezer', 1, 'freezer.all', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `super_admins`
--

CREATE TABLE `super_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `super_admins`
--

INSERT INTO `super_admins` (`id`, `name`, `email`, `image`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@gmail.com', NULL, '1858361812', NULL, '$2y$10$CtuZmk8F3WC1SvgunaKWgehKCQdpRmx1j0w5DtvKfDvlVpE05Yan6', 'pkBysGl4xI6QvJsiTaFEH1mVIcbY5DzaucIa6PdYtMlNeb6NoiG8FJgP40O8', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `temperature`
--

CREATE TABLE `temperature` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `temperature` double NOT NULL,
  `date_time` datetime NOT NULL,
  `device_manual_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temperature_2022_09`
--

CREATE TABLE `temperature_2022_09` (
  `id` int(11) NOT NULL,
  `temperature` double NOT NULL,
  `date_time` datetime NOT NULL,
  `device_manual_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `temperature_2022_09`
--

INSERT INTO `temperature_2022_09` (`id`, `temperature`, `date_time`, `device_manual_id`) VALUES
(8, -36.20000076293945, '2022-09-20 11:43:54', 104651),
(9, -38.599998474121094, '2022-09-20 11:43:54', 104652),
(10, -21.899999618530273, '2022-09-20 11:43:54', 104653),
(11, 4.800000190734863, '2022-09-20 11:43:54', 104654),
(12, -36.29999923706055, '2022-09-20 11:43:59', 104651),
(13, -38.599998474121094, '2022-09-20 11:43:59', 104652),
(14, -21.799999237060547, '2022-09-20 11:43:59', 104653),
(15, 4.899999618530273, '2022-09-20 11:43:59', 104654),
(16, -36.400001525878906, '2022-09-20 11:44:04', 104651),
(17, -38.79999923706055, '2022-09-20 11:44:04', 104652),
(18, -21.899999618530273, '2022-09-20 11:44:04', 104653),
(19, 4.800000190734863, '2022-09-20 11:44:04', 104654),
(20, -36.5, '2022-09-20 11:44:09', 104651),
(21, -38.79999923706055, '2022-09-20 11:44:09', 104652),
(22, -21.899999618530273, '2022-09-20 11:44:09', 104653),
(23, 4.800000190734863, '2022-09-20 11:44:09', 104654),
(24, -36.29999923706055, '2022-09-20 11:44:14', 104651),
(25, -38.70000076293945, '2022-09-20 11:44:15', 104652),
(26, -21.799999237060547, '2022-09-20 11:44:15', 104653),
(27, 4.899999618530273, '2022-09-20 11:44:15', 104654),
(28, -36.20000076293945, '2022-09-20 11:44:20', 104651),
(29, -38.599998474121094, '2022-09-20 11:44:20', 104652),
(30, -21.799999237060547, '2022-09-20 11:44:20', 104653),
(31, 4.899999618530273, '2022-09-20 11:44:20', 104654),
(32, -36.29999923706055, '2022-09-20 11:44:25', 104651),
(33, -38.70000076293945, '2022-09-20 11:44:25', 104652),
(34, -21.899999618530273, '2022-09-20 11:44:25', 104653),
(35, 4.800000190734863, '2022-09-20 11:44:25', 104654),
(36, -36.20000076293945, '2022-09-20 11:44:30', 104651),
(37, -38.5, '2022-09-20 11:44:30', 104652),
(38, -21.799999237060547, '2022-09-20 11:44:30', 104653),
(39, 4.899999618530273, '2022-09-20 11:44:30', 104654),
(40, -36.20000076293945, '2022-09-20 11:44:35', 104651),
(41, -38.599998474121094, '2022-09-20 11:44:35', 104652),
(42, -21.899999618530273, '2022-09-20 11:44:35', 104653),
(43, 4.800000190734863, '2022-09-20 11:44:35', 104654),
(44, -36.20000076293945, '2022-09-20 11:44:40', 104651),
(45, -38.5, '2022-09-20 11:44:40', 104652),
(46, -21.799999237060547, '2022-09-20 11:44:40', 104653),
(47, 4.899999618530273, '2022-09-20 11:44:40', 104654);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_infos`
--
ALTER TABLE `app_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `devices_device_number_unique` (`device_number`),
  ADD UNIQUE KEY `devices_device_manual_id_unique` (`device_manual_id`),
  ADD KEY `devices_group_id_foreign` (`group_id`),
  ADD KEY `devices_company_id_foreign` (`company_id`),
  ADD KEY `devices_location_id_foreign` (`location_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `freezers`
--
ALTER TABLE `freezers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freezers_group_id_foreign` (`group_id`),
  ADD KEY `freezers_company_id_foreign` (`company_id`),
  ADD KEY `freezers_location_id_foreign` (`location_id`);

--
-- Indexes for table `freezer_details`
--
ALTER TABLE `freezer_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freezer_details_freezer_id_foreign` (`freezer_id`),
  ADD KEY `freezer_details_device_id_foreign` (`device_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locations_location_id_foreign` (`location_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modules_name_unique` (`name`),
  ADD UNIQUE KEY `modules_key_unique` (`key`),
  ADD UNIQUE KEY `modules_position_unique` (`position`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_key_unique` (`key`),
  ADD KEY `permissions_module_id_foreign` (`module_id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_group_id_foreign` (`group_id`),
  ADD KEY `roles_company_id_foreign` (`company_id`),
  ADD KEY `roles_location_id_foreign` (`location_id`);

--
-- Indexes for table `sub_modules`
--
ALTER TABLE `sub_modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_modules_name_unique` (`name`),
  ADD UNIQUE KEY `sub_modules_key_unique` (`key`),
  ADD KEY `sub_modules_module_id_foreign` (`module_id`);

--
-- Indexes for table `super_admins`
--
ALTER TABLE `super_admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `super_admins_email_unique` (`email`);

--
-- Indexes for table `temperature`
--
ALTER TABLE `temperature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temperature_2022_09`
--
ALTER TABLE `temperature_2022_09`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_group_id_foreign` (`group_id`),
  ADD KEY `users_company_id_foreign` (`company_id`),
  ADD KEY `users_location_id_foreign` (`location_id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_infos`
--
ALTER TABLE `app_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `freezers`
--
ALTER TABLE `freezers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `freezer_details`
--
ALTER TABLE `freezer_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_modules`
--
ALTER TABLE `sub_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `super_admins`
--
ALTER TABLE `super_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temperature`
--
ALTER TABLE `temperature`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temperature_2022_09`
--
ALTER TABLE `temperature_2022_09`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `devices_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `devices_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freezers`
--
ALTER TABLE `freezers`
  ADD CONSTRAINT `freezers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `freezers_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `freezers_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freezer_details`
--
ALTER TABLE `freezer_details`
  ADD CONSTRAINT `freezer_details_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `freezer_details_freezer_id_foreign` FOREIGN KEY (`freezer_id`) REFERENCES `freezers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_modules`
--
ALTER TABLE `sub_modules`
  ADD CONSTRAINT `sub_modules_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
