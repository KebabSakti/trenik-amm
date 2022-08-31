-- Adminer 4.8.1 MySQL 5.5.5-10.6.4-MariaDB-1:10.6.4+maria~focal dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `approvals`;
CREATE TABLE `approvals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `status` enum('approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `approvals_submission_id_index` (`submission_id`),
  KEY `approvals_user_id_index` (`user_id`),
  KEY `approvals_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `approval_rules`;
CREATE TABLE `approval_rules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `approval_rules_department_id_index` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `approval_rules` (`id`, `company_id`, `department_id`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	1,	NULL,	'2022-08-26 15:45:17',	'2022-08-26 15:45:17',	NULL);

DROP TABLE IF EXISTS `approval_rule_details`;
CREATE TABLE `approval_rule_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `approval_rule_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `approval_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `approval_rule_details` (`id`, `approval_rule_id`, `department_id`, `approval_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	1,	1,	'2022-08-26 15:45:17',	'2022-08-26 15:45:17',	NULL),
(2,	1,	8,	2,	'2022-08-26 15:45:17',	'2022-08-26 15:45:17',	NULL),
(3,	1,	2,	3,	'2022-08-26 15:45:17',	'2022-08-26 15:45:17',	NULL);

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monthly_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `companies_company_name_index` (`company_name`),
  KEY `companies_monthly_balance_index` (`monthly_balance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `companies` (`id`, `company_name`, `company_description`, `monthly_balance`, `created_at`, `updated_at`) VALUES
(1,	'Koperasi AMM Handil',	NULL,	150000000.00,	'2022-08-16 05:17:47',	'2022-08-16 05:17:47'),
(3,	'Koperasi AMM Site Bontang',	NULL,	200000000.00,	'2022-08-16 09:00:38',	'2022-08-16 09:00:38');

DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `configs_company_id_index` (`company_id`),
  KEY `configs_key_index` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `credits`;
CREATE TABLE `credits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` bigint(20) NOT NULL,
  `month` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `credit_schemes`;
CREATE TABLE `credit_schemes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `count` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `credit` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `credit_schemes_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `credit_schemes` (`id`, `product_id`, `count`, `price`, `credit`, `created_at`, `updated_at`, `deleted_at`) VALUES
(16,	193,	1,	2000000.00,	2000000.00,	'2022-08-26 01:22:59',	'2022-08-27 15:41:17',	NULL),
(17,	193,	3,	2040000.00,	680000.00,	'2022-08-26 01:22:59',	'2022-08-27 15:41:17',	NULL),
(18,	193,	6,	2100000.00,	350000.00,	'2022-08-26 01:22:59',	'2022-08-27 15:41:17',	NULL),
(19,	193,	9,	2160000.00,	240000.00,	'2022-08-26 01:22:59',	'2022-08-27 15:41:17',	NULL),
(20,	193,	12,	2280000.00,	190000.00,	'2022-08-26 01:22:59',	'2022-08-27 15:41:17',	NULL),
(21,	161,	1,	2600000.00,	2600000.00,	'2022-08-28 14:07:25',	'2022-08-28 14:07:25',	NULL),
(22,	161,	3,	2640000.00,	880000.00,	'2022-08-28 14:07:25',	'2022-08-28 14:07:25',	NULL),
(23,	161,	6,	2700000.00,	450000.00,	'2022-08-28 14:07:25',	'2022-08-28 14:07:25',	NULL),
(24,	161,	9,	2790000.00,	310000.00,	'2022-08-28 14:07:25',	'2022-08-28 14:07:25',	NULL),
(25,	161,	12,	2880000.00,	240000.00,	'2022-08-28 14:07:25',	'2022-08-28 14:07:25',	NULL),
(26,	64,	1,	1.00,	1.00,	'2022-08-27 00:56:47',	'2022-08-27 00:56:47',	NULL),
(27,	64,	3,	1.00,	1.00,	'2022-08-27 00:56:47',	'2022-08-27 00:56:47',	NULL),
(28,	64,	6,	1.00,	1.00,	'2022-08-27 00:56:47',	'2022-08-27 00:56:47',	NULL),
(29,	64,	9,	1.00,	1.00,	'2022-08-27 00:56:47',	'2022-08-27 00:56:47',	NULL),
(30,	64,	12,	1.00,	1.00,	'2022-08-27 00:56:47',	'2022-08-27 00:56:47',	NULL),
(31,	202,	1,	1.00,	1.00,	'2022-08-27 00:57:20',	'2022-08-27 00:57:20',	NULL),
(32,	202,	3,	1.00,	1.00,	'2022-08-27 00:57:20',	'2022-08-27 00:57:20',	NULL),
(33,	202,	6,	1.00,	1.00,	'2022-08-27 00:57:20',	'2022-08-27 00:57:20',	NULL),
(34,	202,	9,	1.00,	1.00,	'2022-08-27 00:57:20',	'2022-08-27 00:57:20',	NULL),
(35,	202,	12,	1.00,	1.00,	'2022-08-27 00:57:20',	'2022-08-27 00:57:20',	NULL);

DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departments_company_id_index` (`company_id`),
  KEY `departments_department_name_index` (`department_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `departments` (`id`, `company_id`, `department_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'IT',	'2022-08-17 10:06:41',	'2022-08-27 15:49:37',	NULL),
(2,	1,	'Koperasi',	'2022-08-17 10:07:17',	'2022-08-27 15:52:53',	'2022-08-27 15:52:53'),
(8,	1,	'HCGA',	'2022-08-23 17:29:21',	'2022-08-23 17:29:21',	NULL);

DROP TABLE IF EXISTS `department_positions`;
CREATE TABLE `department_positions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) unsigned NOT NULL,
  `position_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_positions_position_name_index` (`position_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `department_positions` (`id`, `company_id`, `position_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'Bos Besar',	'2022-08-18 08:51:48',	'2022-08-27 15:30:29',	NULL);

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `position_id` bigint(20) NOT NULL,
  `grade_id` bigint(20) NOT NULL,
  `employee_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ktp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employees_user_id_index` (`user_id`),
  KEY `employees_department_id_index` (`department_id`),
  KEY `employees_grade_id_index` (`grade_id`),
  KEY `employees_employee_name_index` (`employee_name`),
  KEY `employees_nik_index` (`nik`),
  KEY `employees_phone_index` (`phone`),
  KEY `employees_ktp_index` (`ktp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `employees` (`id`, `user_id`, `department_id`, `position_id`, `grade_id`, `employee_name`, `nik`, `phone`, `ktp`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	5,	1,	1,	1,	'User 1',	'NIK111111',	'081254982661',	'KTP111111',	'2022-08-27 09:29:56',	'2022-08-27 16:44:38',	NULL),
(2,	6,	1,	1,	1,	'User 2',	'NIK222222',	'081254982662',	'KTP222222',	'2022-08-27 09:34:55',	'2022-08-27 09:34:55',	NULL);

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) NOT NULL,
  `grade_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_credit` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grades_company_id_index` (`company_id`),
  KEY `grades_grade_name_index` (`grade_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `grades` (`id`, `company_id`, `grade_name`, `max_credit`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'B2',	2700000.00,	'2022-08-18 09:56:41',	'2022-08-28 03:36:05',	NULL);

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2019_08_19_000000_create_failed_jobs_table',	1),
(4,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(5,	'2022_08_14_094809_create_departments_table',	1),
(6,	'2022_08_14_094817_create_grades_table',	1),
(8,	'2022_08_14_095342_create_credits_table',	1),
(9,	'2022_08_14_095818_create_companies_table',	1),
(10,	'2022_08_14_124203_create_configs_table',	1),
(11,	'2022_08_14_124822_create_submissions_table',	1),
(12,	'2022_08_14_124840_create_approvals_table',	1),
(14,	'2022_08_14_132429_create_pricings_table',	1),
(15,	'2022_08_15_090043_create_department_positions_table',	1),
(17,	'2016_06_01_000001_create_oauth_auth_codes_table',	2),
(18,	'2016_06_01_000002_create_oauth_access_tokens_table',	2),
(19,	'2016_06_01_000003_create_oauth_refresh_tokens_table',	2),
(20,	'2016_06_01_000004_create_oauth_clients_table',	2),
(21,	'2016_06_01_000005_create_oauth_personal_access_clients_table',	2),
(24,	'2022_08_20_132318_create_approval_rule_details_table',	4),
(25,	'2022_08_14_095244_create_products_table',	5),
(27,	'2022_08_20_153358_create_rule_schemes_table',	5),
(28,	'2022_08_20_152612_create_credit_schemes_table',	6),
(29,	'2022_08_15_104621_create_approval_rules_table',	7),
(30,	'2022_08_26_154241_create_submission_attachments_table',	8),
(31,	'2022_08_14_131328_create_employees_table',	9);

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0888cfb34442d8e957d87d65878b28e96edacebfa3d18d52b8bd8578d1718e60405b9282b04a8ea1',	1,	3,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 13:25:18',	'2022-08-17 13:25:18',	'2023-08-17 13:25:18'),
('46d96e675d40d962399e6913c020a60dd377ac17864841293b75a9c2cefdf4fd6582c8b7bd8c1fe4',	1,	1,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 11:08:16',	'2022-08-17 11:08:16',	'2023-08-17 11:08:16'),
('55f6f6d6615ca4164b883b96976032688758dbec442d454c76cefdf6299cbc3e2f8378934d70fd9e',	1,	3,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 13:26:55',	'2022-08-17 13:26:55',	'2023-08-17 13:26:55'),
('754dc469a39bd89f3686931e18c714767d15768f8950b33263bf2a3bc564980ace3293d06a03ebf1',	1,	3,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 13:27:27',	'2022-08-17 13:27:27',	'2023-08-17 13:27:27'),
('861125e00300f2665393dfb382f127919fb56097b8a84053bdd851b372ba6c382c72379b3ae4f722',	1,	3,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 11:29:45',	'2022-08-17 11:29:45',	'2023-08-17 11:29:45'),
('94445c75a2db4be76e9ea0f3acac7c6b61da8e492d6e7b79e87b8182ef251bc12560c1eb0b239659',	1,	3,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 13:24:54',	'2022-08-17 13:24:54',	'2023-08-17 13:24:54'),
('985aca487403370a48b8709d481915af46aaa67cb15ae0693705aa5af35ba0155484086555b81150',	1,	3,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 13:18:58',	'2022-08-17 13:18:58',	'2023-08-17 13:18:58'),
('99f1e5337def80650559fa86752b173dac9bad5c2f5958af5bae231637746fafaaf91870b4214ba2',	1,	3,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 11:31:07',	'2022-08-17 11:31:07',	'2023-08-17 11:31:07'),
('dbed4e931ccb31f11fa69e2cda3991ca0f407d0b61e49f988a86c07080d1226f4309399d200be7ab',	1,	3,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 13:14:01',	'2022-08-17 13:14:01',	'2023-08-17 13:14:01'),
('e637f06d19835ec6752f24fbddd6f1028408e3e691d8a7a3468ca795b461734103cb8e578ced72f2',	1,	3,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 13:26:36',	'2022-08-17 13:26:36',	'2023-08-17 13:26:36'),
('ecbe31a64d12b6b9b4e5aa0ec6642f70ccc62d47915cdbeaf71610a52e06af02856af90c50946f33',	1,	3,	'julian.aryo1989@gmail.com',	'[]',	0,	'2022-08-17 13:25:36',	'2022-08-17 13:25:36',	'2023-08-17 13:25:36');

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1,	NULL,	'Laravel Personal Access Client',	'F1zPGgtS258HLSdYRX1S2yo62Ag8xEA5z8msNAXk',	NULL,	'http://localhost',	1,	0,	0,	'2022-08-17 10:57:32',	'2022-08-17 10:57:32'),
(2,	NULL,	'Laravel Password Grant Client',	'qdC46Rz1UioLRrsGg7hMwNEvjeKtgoaGq5qJGUI3',	'users',	'http://localhost',	0,	1,	0,	'2022-08-17 10:57:32',	'2022-08-17 10:57:32'),
(3,	NULL,	'Laravel Personal Access Client',	'RDISZSIN94KN9RHBVb9I6BtqjAZVfVR0OEgwnaUD',	NULL,	'http://localhost',	1,	0,	0,	'2022-08-17 11:28:39',	'2022-08-17 11:28:39');

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1,	1,	'2022-08-17 10:57:32',	'2022-08-17 10:57:32'),
(2,	3,	'2022-08-17 11:28:39',	'2022-08-17 11:28:39');

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `pricings`;
CREATE TABLE `pricings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `sell_price` decimal(12,2) NOT NULL,
  `credit_count` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pricings_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_company_id_index` (`company_id`),
  KEY `products_product_name_index` (`product_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `products` (`id`, `company_id`, `product_name`, `product_brand`, `product_description`, `product_image`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'Mara Corwin',	'Destiney',	'Tenetur dolorum in sunt nulla illum labore. Ea nam quia eum commodi natus. Quis quis non quas praesentium iure.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(2,	1,	'Prof. Bernice Christiansen',	'Demetris',	'Veniam delectus earum amet quod. Dolore sapiente et quo esse. Occaecati ut amet perspiciatis harum voluptatum.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(3,	1,	'Sherwood Hayes',	'Kellen',	'Autem perferendis consequatur iusto unde suscipit. Perspiciatis vel ut ipsa explicabo et quia. Occaecati dolor et pariatur id dignissimos dolor molestiae.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(4,	1,	'Dr. Nathanial Murphy',	'Isobel',	'Ea repudiandae rerum consequatur nisi. Asperiores vero adipisci reprehenderit cum error vel suscipit.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(5,	1,	'Kirstin Flatley MD',	'Lacey',	'Omnis libero labore minus reprehenderit et. Inventore dolor aut sit id maxime nesciunt cumque. Libero molestiae id distinctio nemo. In blanditiis quo quidem atque rerum nesciunt.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(6,	1,	'Lexus Feeney',	'Lukas',	'Libero itaque nemo sapiente esse qui animi. Eos eos dolor iusto doloribus vero. Ipsam et laborum voluptas neque. In quis molestiae aut ut.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(7,	1,	'Dr. Isaias Stamm DVM',	'Emelie',	'Eligendi quod et dolores nulla officia quia sint qui. Ut fugit cupiditate voluptas exercitationem. Molestiae vero voluptatum vel quam nulla dolorum ducimus dignissimos.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(8,	1,	'Noel Gusikowski',	'Myriam',	'Dolor voluptatem voluptatum nesciunt qui quia ducimus. Ipsam consequatur veritatis non et. Velit a aut eaque sapiente vero laborum ut. Rerum ut velit pariatur et aliquid.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(9,	1,	'Camylle Ernser',	'Queen',	'At quia ab magni sint. Vel quo expedita iste id. Ut eaque ducimus dicta itaque adipisci.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(10,	1,	'Maia Wiegand',	'Madalyn',	'Nihil enim architecto ea et rerum amet. Natus quis rem quo enim. Quidem incidunt vitae cum maiores. Quia veritatis qui deserunt aut autem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(11,	1,	'Israel Beatty',	'Lesly',	'Eaque inventore voluptatem id accusantium at. Voluptas suscipit officia dicta nostrum non. Voluptas inventore et cupiditate error eum. Ex quis illum veniam consectetur sint.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(12,	1,	'Marlin Larkin',	'Wellington',	'Natus quidem non debitis voluptate quidem quia. Et autem ut officiis omnis suscipit facere.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(13,	1,	'Mr. Cleveland Schmeler',	'Pasquale',	'Ut et sed id et consequuntur officiis corrupti. Et modi est ut et eum atque. Magnam non magni ullam veritatis ipsum.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(14,	1,	'Kendrick Turner',	'Mckenzie',	'Blanditiis labore saepe deleniti. Ipsam et sapiente ratione ducimus nulla omnis quia. Magnam vero sequi consequatur nemo unde sed.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(15,	1,	'Birdie Koepp V',	'Jeanie',	'Omnis quia non unde et sint soluta sint. Aut sint cupiditate sed consectetur autem autem. Pariatur ut rerum hic numquam facilis voluptatem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(16,	1,	'Aida Rutherford',	'Adeline',	'Quasi explicabo mollitia assumenda eos incidunt. Quas fugiat eligendi et est. Eos optio occaecati pariatur eveniet sint. Delectus et ut necessitatibus reprehenderit.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(17,	1,	'Mrs. Margaretta Friesen',	'Tremayne',	'Asperiores ducimus ut consectetur eum eius quos et. Amet eos officia aut. Sit inventore atque sint est voluptatibus.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(18,	1,	'Magali McKenzie',	'Jordon',	'Labore velit autem quaerat velit sint. Odio eos ea adipisci similique sed dolor ut. Magni rem odit exercitationem et dolorum ipsam eos quia. Ipsum ducimus illo consectetur molestiae a.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(19,	1,	'Alfonzo Sawayn DDS',	'Zora',	'Sequi ut aliquam est reiciendis. Quia ipsam ab vel asperiores aut. Possimus maiores velit cumque repellendus aut voluptatum. Eos exercitationem at architecto expedita recusandae dicta ex.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(20,	1,	'Alvera Bartell DVM',	'Federico',	'Voluptate sapiente rerum quisquam et cum. Voluptate eaque nihil minima illo magnam numquam eius. Eius ab reiciendis quia.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(21,	1,	'Cassandra Ritchie',	'Reuben',	'Blanditiis rerum molestiae quia nostrum. Tempora alias est culpa. Et consequatur nam maxime. Consequatur pariatur et et maiores. Et est vel animi quis consequatur a ea.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(22,	1,	'Dana Rodriguez',	'Rebekah',	'Nihil aliquam aut saepe voluptas quam quisquam. Iusto modi velit nulla voluptates dolorem quod voluptas. Deleniti fugiat culpa expedita accusantium ullam ab.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(23,	1,	'Grant O\'Kon',	'Marietta',	'Porro soluta harum blanditiis at voluptatibus. Vero nulla reprehenderit ipsa reiciendis aut. Nostrum dolorum ullam libero sed enim. Pariatur doloremque voluptas error.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(24,	1,	'Winnifred Rice DDS',	'Jevon',	'Enim voluptate architecto doloribus magni vel pariatur. Eum veniam delectus repellat. Fugit odit earum iure a nam aut adipisci.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(25,	1,	'Felicia Wolff',	'Desiree',	'Aliquam id vero magni ut in doloremque. Odit fuga consequatur ipsam molestiae. Placeat ea vitae est. Quae non dolor quam autem cum eos. Nihil omnis voluptates qui totam et unde.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(26,	1,	'Kole Labadie',	'Lonzo',	'Quasi rem est ratione sed consectetur sint voluptatum et. Recusandae quia amet repellendus dolorem itaque a tempora. Ea nesciunt modi odit ea.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(27,	1,	'Cara Dare III',	'Ottis',	'Esse eos atque reprehenderit ex voluptatum tenetur eos. Id molestiae ad velit dolorem omnis. Animi doloremque magnam odio ratione vel.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(28,	1,	'Dr. Darrion Ondricka',	'Israel',	'Est iusto distinctio qui laboriosam modi. Beatae quis et molestiae eum dicta. Rerum necessitatibus deleniti sunt dolor necessitatibus hic et sit.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(29,	1,	'Prof. Rhiannon Fritsch IV',	'Precious',	'Neque magni nulla aut totam earum. Tenetur non et quia illum perspiciatis ratione perspiciatis. Eius unde ullam assumenda occaecati culpa aut at id. Nam maxime aut qui ex nemo.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(30,	1,	'Mrs. Mae Jast I',	'Norwood',	'Nobis a voluptates architecto at illo aliquam aut. Nulla officiis exercitationem velit est est nostrum. Et ut est dolores laudantium ut. Optio dolores accusamus beatae delectus tenetur.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(31,	1,	'Kamron Pollich',	'Jaylan',	'Amet enim illum et qui et et. Est assumenda aliquid ut molestias. Voluptatem corrupti quos molestiae doloribus.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(32,	1,	'Laverne Kuhn',	'Alene',	'Provident exercitationem facere velit quam animi sit. Et molestias libero in omnis iure. Qui quis aut quia velit assumenda eligendi qui.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(33,	1,	'Prof. Giles Kessler III',	'Baby',	'Quod et aut labore voluptas et. Impedit nostrum ad dolores voluptate non temporibus officiis. Aut iste non maiores nihil aliquid quos. Earum ipsam ea voluptatem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(34,	1,	'Camilla Stehr',	'Shanelle',	'Non nam magni ex facilis vero fugit et velit. Hic quia autem sit minus consequatur qui. Sit ex rem est blanditiis nisi quod suscipit.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(35,	1,	'Isabelle Macejkovic MD',	'Abby',	'Possimus officia cum aut voluptas non ipsam doloremque. Nisi doloremque eius sint officia quod sit nulla et. Ut nisi suscipit magnam dolor deserunt praesentium.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(36,	1,	'Ms. Elissa Pollich',	'Gladyce',	'Quia fugit consequatur ut esse minus autem quia alias. Magni accusantium aut impedit aut.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(37,	1,	'Waylon Mosciski',	'Sonny',	'Quia illum sunt voluptas dolores odit. Sed sint sit unde. Vitae est asperiores aspernatur corporis mollitia.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(38,	1,	'Maiya Johnson',	'Mozelle',	'Animi ad vitae praesentium sint. Possimus commodi impedit rerum non. Optio distinctio quisquam et repellendus.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(39,	1,	'Prof. Darian Predovic',	'Abbey',	'Voluptas ducimus dolorem dolorem voluptas quo. Et a esse suscipit. Porro nostrum quis quia quis consectetur voluptatem doloremque. Optio ipsum harum magnam voluptatem eligendi.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(40,	1,	'Dr. Al Hessel Sr.',	'Mariana',	'Excepturi magnam voluptatem eveniet quia fugiat dolores saepe aliquam. Nobis quos beatae aliquid atque. Ipsa veritatis deleniti fugit sit ut vel.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(41,	1,	'Duncan Mante',	'Wilburn',	'Et quia dolor voluptatem eius dolorem dolorem cumque. Enim ducimus voluptas sed odio vero voluptate iusto et. Ab molestiae et voluptas quo optio.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(42,	1,	'Felicity Fisher',	'Alverta',	'In officia dolorem culpa autem rerum. Totam unde error corrupti earum est voluptatibus delectus. Excepturi voluptates voluptas aperiam laborum. In fuga qui id aliquid nihil tempore perspiciatis.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(43,	1,	'Aiden Pfeffer III',	'Andy',	'Exercitationem perferendis voluptatum illo itaque. Perspiciatis impedit delectus fuga libero ut velit. Sed soluta quia quaerat in dignissimos iste neque. Sunt nihil deserunt esse corrupti.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(44,	1,	'Josie Schulist',	'Gabriella',	'Voluptatum ab similique occaecati qui autem. Officia illum voluptatem eos aut vero omnis est. Assumenda impedit est ut itaque. Sit similique aperiam qui voluptatem magnam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(45,	1,	'Elissa Klocko I',	'Patrick',	'Quidem praesentium in aut molestias explicabo doloribus. Ut quibusdam placeat consequuntur iure dolore consequatur. Est eveniet modi saepe sed distinctio rerum.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(46,	1,	'Mrs. Ayana Weber',	'Alfreda',	'Aspernatur porro eius atque quis quia illum voluptates. Aperiam nam accusantium voluptates et id id. Sit in debitis neque adipisci. Voluptatem dolore tempore qui.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(47,	1,	'Marcia Rodriguez',	'Jazmyn',	'Reiciendis facilis aut quaerat. Iste autem distinctio ex neque error vitae. Occaecati dolorum suscipit nostrum voluptas repellat.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(48,	1,	'Veda Bins Jr.',	'Davonte',	'Ullam maiores est dicta officiis qui. In quia error nostrum.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(49,	1,	'Guido Maggio',	'Abel',	'Quasi qui quae dolorem accusamus maxime animi. Quia quia architecto ad dolorem earum quia. Nostrum velit sit quod accusamus autem et.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(50,	1,	'Mr. Imani Halvorson DVM',	'Fern',	'Soluta perferendis quod debitis consectetur nesciunt. Tempora nemo sit aliquam unde corrupti. Sit ducimus ea dicta vitae. Enim illum ipsum voluptatibus eos.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(51,	1,	'Mr. Domenico Walker',	'Gudrun',	'Dolorem corrupti voluptatem qui quisquam quibusdam consequatur natus. Aut sapiente et quia. Neque est quidem non cumque beatae aut molestias. Voluptates ut et possimus rem vel natus autem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(52,	1,	'Mrs. Piper Schumm',	'Raul',	'Cupiditate temporibus velit tempora facilis ratione. Dolor adipisci nihil non deserunt fugit. Aliquam possimus est ut magni.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(53,	1,	'Ardella Pouros Jr.',	'Alex',	'Necessitatibus aut placeat aut maiores. Eum repudiandae sed voluptates vel est. Magnam corrupti iste omnis sequi reprehenderit saepe labore.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(54,	1,	'Prof. Mary Abernathy DDS',	'Reyna',	'Laudantium quia ut praesentium ut quis ex dolores. Eius enim aliquid dolor. Eum quis dolorum fuga ipsum.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(55,	1,	'Dorian Ortiz III',	'Xander',	'Eos doloremque id fuga eaque sequi voluptatibus itaque qui. Ea reiciendis quia qui voluptatem dolor accusantium. Amet accusamus ipsum architecto accusantium. Et vel tenetur est est non a porro.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(56,	1,	'Maryjane Quitzon',	'Harmony',	'Perspiciatis non enim ex velit quis quos. Veniam placeat repudiandae ea vel non tempore. Dicta voluptatem provident inventore rerum nihil placeat.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(57,	1,	'Miss Nikki Jacobson III',	'Dasia',	'Quae commodi fugiat dolorem asperiores. Ad sed quod dolorem. Voluptatem fugit amet officiis atque impedit occaecati. Corporis est et voluptatum voluptatem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(58,	1,	'Clifton Raynor PhD',	'Cassie',	'Sequi eius dolorem eum quisquam. Aut dolorem vero placeat doloribus id et mollitia mollitia. Doloribus sit aut quisquam odit perferendis labore.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(59,	1,	'Shirley Kreiger',	'Tia',	'Assumenda iste nostrum animi. Eos cum enim consectetur autem. Quia nobis quam a laudantium natus iusto. Laudantium fugiat cum sed et inventore sit ut tenetur.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(60,	1,	'Miss Tressie Gottlieb PhD',	'Martina',	'Praesentium aut occaecati et sint. Aut dolores et sapiente quae laudantium officia inventore qui.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(61,	1,	'Leanna Feeney',	'Nikko',	'Accusamus rerum eos exercitationem temporibus quasi. Sint perspiciatis necessitatibus placeat sequi.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(62,	1,	'Mr. Josh Hane I',	'Jaydon',	'Excepturi ex ipsam quia. Harum repellat blanditiis similique numquam omnis dolorum. Enim totam quibusdam aliquam. Blanditiis odit culpa esse quis ut.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(63,	1,	'Freda Kilback Jr.',	'Leta',	'Illum libero qui assumenda. Minima ad velit corrupti ipsa repellendus quidem vero.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(65,	1,	'Prof. Kobe Pacocha',	'Keara',	'Fugiat enim quisquam saepe tempora ut perspiciatis eos. Est ea eos expedita ut ipsa. Nisi iste ipsum neque commodi facilis rem atque.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(66,	1,	'Godfrey Thompson',	'Aurelie',	'Exercitationem corrupti quae dicta officiis est qui et. Laboriosam quam perspiciatis accusantium in. Est omnis adipisci est. Suscipit tenetur voluptatibus fugit rem ut laudantium.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(67,	1,	'Lysanne Wyman',	'Barney',	'Necessitatibus tempore aut aut occaecati animi ullam temporibus. Dolorem voluptas molestias et suscipit dolorem quia in dolorem. Reprehenderit cumque est sit.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(68,	1,	'Ocie Turcotte',	'Flavio',	'Quis sed sunt iusto id suscipit enim sed. Delectus quasi dolor ut magnam modi occaecati. Animi et laboriosam dolor cumque quisquam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(69,	1,	'Buddy Tremblay',	'Mariah',	'Exercitationem consequatur rem aut deleniti quo libero. Consequatur molestiae aliquam dicta illo asperiores sint. Ea in voluptatum qui labore. Cupiditate voluptate iste accusamus voluptatem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(70,	1,	'Milford Barrows',	'Freda',	'Sint non quas aut optio exercitationem molestias ducimus. Similique eaque numquam aliquid exercitationem id quo. Dolorem quam unde corrupti assumenda pariatur est eum.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(71,	1,	'Mrs. Theresia Kris',	'Bailee',	'Odio aut qui ab. Quo sit dicta ut tempora iste eos. Repellat dolor illo repellat numquam modi maiores nemo. Explicabo omnis reiciendis hic qui impedit quia.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(72,	1,	'Elyse Conroy III',	'Stephanie',	'Amet ratione officiis suscipit doloribus sed laborum. Dolor enim eum dolor. Sapiente dicta voluptatem aut est.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(73,	1,	'Miss Lenna Hayes DVM',	'Gustave',	'Aut omnis iste et temporibus quis deserunt. Natus delectus nesciunt aspernatur nemo aut atque. Ut ipsa est velit assumenda nihil aliquid consequatur. Quaerat perspiciatis dicta molestiae.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(74,	1,	'Mr. Dominic Thompson',	'Breana',	'Placeat non fuga est. Modi ducimus sit occaecati tempore. Qui quam facilis et pariatur laborum. Aliquam esse placeat nesciunt omnis facilis ea nobis debitis.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(75,	1,	'Prof. Cali Cruickshank III',	'Frederic',	'Qui quam accusamus voluptates dolorem similique debitis. Alias expedita temporibus corporis. Autem quibusdam qui soluta cupiditate architecto. Quos voluptate animi id odio.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(76,	1,	'Prof. Antone Luettgen I',	'Elliott',	'Voluptatem dolor dolor voluptate. Animi unde quis id eum error dolor qui. Tempora ea laborum voluptatem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(77,	1,	'Daniela Dietrich',	'Savannah',	'A voluptatem dolorem fugiat quibusdam voluptatum voluptatem omnis. Non nam ut voluptatum hic. Qui aliquam sed in et dolor. Quia illo repudiandae et libero.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(78,	1,	'Samantha Reilly',	'Rahsaan',	'Illum ut ab cumque eos. Dolor praesentium repellat illum sunt quia ut. Explicabo quo ab praesentium fugit hic est et. Sequi dolorem qui et adipisci.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(79,	1,	'Danielle Padberg',	'Fletcher',	'Ipsam doloremque corrupti dolorum fugiat. Necessitatibus sit voluptatem et consectetur tenetur nulla. Hic in est corporis facere numquam. Laudantium sit veniam quis placeat.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(80,	1,	'Kennedi Quigley',	'Erna',	'Temporibus facere officia repudiandae. Voluptatem maxime nobis voluptatem fuga est non adipisci. Quasi sunt nam inventore ipsa sunt aut.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(81,	1,	'Mr. Hiram Schinner DVM',	'Glennie',	'Id rem et enim sed quis dignissimos eum. Atque aut et tenetur voluptatem dignissimos optio delectus reprehenderit. Maxime vero doloremque commodi nulla.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(82,	1,	'Mrs. Veronica Olson I',	'Golden',	'Sint eum possimus odio eaque. Fugiat corrupti adipisci itaque. Ut illum ut animi recusandae necessitatibus vitae. Quas aut quo autem repellendus provident libero et.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(83,	1,	'Mr. Eric Mertz MD',	'Alexane',	'Quia corporis amet perferendis. Est est aut fuga voluptas aut ipsum enim. Incidunt qui quae quia harum soluta sed dolores. Sit quisquam architecto atque.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(84,	1,	'D\'angelo Bosco',	'Darien',	'Debitis tempora voluptas totam iste harum cum. Est fugit tempore harum eos deleniti et. Laborum ad assumenda a.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(85,	1,	'Dr. Mckayla Gerhold I',	'Reba',	'Ea ut deserunt harum velit. Corporis est consequuntur sequi rerum quia vitae esse.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(86,	1,	'Murphy Williamson',	'Tania',	'Deleniti autem amet blanditiis itaque enim ab. Voluptas ut qui eveniet veritatis numquam suscipit quo odit. Id optio quia molestiae laboriosam qui ut enim.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(87,	1,	'Gerry Jerde',	'Jefferey',	'Molestiae a distinctio est. Commodi provident commodi sapiente vel dolor non. Quidem corrupti quia quo libero laudantium.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(88,	1,	'Palma Bednar',	'Sabryna',	'Sunt aliquid praesentium voluptatem. Accusantium dicta autem temporibus natus laborum voluptatum pariatur. Assumenda nostrum tempora corporis optio.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(89,	1,	'Bridgette Wolf II',	'Anderson',	'Ullam commodi enim quaerat consequatur beatae nemo. Facilis voluptates optio eligendi cupiditate suscipit aliquam quo. Totam delectus porro ea. Doloremque maxime harum nulla enim velit sequi quia.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(90,	1,	'Yasmin King',	'Collin',	'Tenetur quod repudiandae consequatur adipisci id omnis. Recusandae at et est qui ad praesentium. Facilis sunt voluptatem corporis.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(91,	1,	'Jayne Dibbert DDS',	'Brice',	'Possimus accusamus ipsum earum beatae sed accusantium. Et sint voluptatem natus modi quis. Dolorem magnam voluptatum expedita enim quo.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(92,	1,	'Zane Daugherty',	'Carli',	'Et at sit corrupti qui. Asperiores ad sapiente architecto impedit rerum. Perspiciatis dolore impedit ut voluptatum quibusdam autem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(93,	1,	'Jarod Daniel',	'Naomi',	'Nostrum laboriosam quo et velit ducimus et. Magni et enim quis excepturi quidem ea. Architecto nostrum inventore consequatur.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(94,	1,	'Dulce Schoen',	'Zackary',	'Quae impedit vero occaecati id. Iste culpa fugit cumque. Commodi omnis autem iure excepturi quas maxime quia nulla.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(95,	1,	'Luella Pagac',	'Felton',	'Nostrum quia et perspiciatis fuga quia optio tenetur. Mollitia illo quis aut voluptatum qui aut nostrum. Aspernatur sapiente unde vero voluptatum vel nisi.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(96,	1,	'Genoveva Reilly',	'Kaycee',	'Et vero ratione enim soluta distinctio rerum. Cupiditate nostrum neque et. Sapiente voluptatum autem ut ut voluptatem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(97,	1,	'Axel Labadie',	'Mac',	'Provident tenetur dolores maiores eligendi laboriosam sapiente eaque. Repudiandae molestiae voluptas nam. Vel quia consequatur nam et qui autem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(98,	1,	'Moriah Bode',	'Chadd',	'Temporibus magni dicta repellat occaecati excepturi. Sequi officia velit dolorem. Nesciunt minus voluptatem vero unde natus. Veritatis consequatur odio et repellat harum recusandae.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(99,	1,	'Luigi Keebler',	'Amiya',	'Occaecati aspernatur aliquid dolores amet saepe quaerat. Dolore enim eum omnis dicta ut ea.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(100,	1,	'Joshua Ledner DDS',	'Winifred',	'Error magni recusandae dolore ut ut fugiat. Porro iusto ducimus et sed odit vel ducimus. Nulla necessitatibus nobis odit delectus iusto molestias. Autem tenetur quas hic explicabo.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(101,	1,	'Mohammed Ziemann',	'Lizeth',	'Iure hic voluptate praesentium repudiandae. Qui dignissimos repellendus est nulla et quos. Illum atque delectus enim neque sequi repellendus est eos.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(102,	1,	'Mr. Arely Swaniawski',	'Kiley',	'Similique culpa id accusamus temporibus possimus magni. Aut nihil asperiores rerum. Distinctio aut libero natus mollitia.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(103,	1,	'Myah Dach',	'Wellington',	'Aliquid est reprehenderit doloribus beatae. Dolorem et quo harum. Natus consequatur illo aut quidem nesciunt aliquid repellendus. Non maiores veniam esse enim magnam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(104,	1,	'Dr. Jakob Morissette',	'Else',	'Labore sapiente laudantium neque quo consequatur esse facilis. Autem sapiente voluptatem sint ut magni.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(105,	1,	'Ms. Velda Moore III',	'Samson',	'Aspernatur ut sed magni atque at quisquam illo. Et nisi repellendus omnis qui distinctio. Maxime dolor sit necessitatibus est excepturi deserunt.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(106,	1,	'Mrs. Ramona Lueilwitz I',	'Gerson',	'Sit molestiae quo mollitia iusto. Quia eos aut ut. Perspiciatis atque alias aliquam excepturi similique magni sed.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(107,	1,	'Madaline Block',	'Rosalyn',	'Doloremque quidem non tenetur temporibus et id. Autem nihil repudiandae odio dolor voluptatem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(108,	1,	'Prof. Cydney Gerhold DVM',	'Justina',	'Delectus rerum dolorem omnis officia sed molestias. Impedit eum omnis aut qui sed nostrum. Rerum ad quisquam vitae et. Explicabo amet et est sed.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(109,	1,	'Dr. Weldon Bednar',	'Neoma',	'Consequatur molestias commodi dolores sapiente aut. Animi rem quia quis dignissimos quaerat blanditiis. Quidem qui praesentium itaque nihil laborum possimus culpa.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:13',	'2022-08-24 17:05:13',	NULL),
(110,	1,	'Jacey Kihn',	'Riley',	'Rem assumenda modi corrupti sed. Blanditiis repudiandae tempore omnis ullam quae minima. Enim culpa voluptas nihil ut sed temporibus eos assumenda. Est quas aut incidunt recusandae saepe ut quia.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(111,	1,	'Queen Turner',	'Lincoln',	'Veniam dolorem modi quibusdam provident iusto. Incidunt incidunt nihil magni id. Asperiores dolorem accusamus doloremque possimus occaecati nesciunt. Sit sunt aperiam odit molestiae.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(112,	1,	'Evelyn Sawayn Sr.',	'Adonis',	'Qui qui reiciendis minima ut. Sed placeat dignissimos sint accusantium. Qui voluptas ab alias blanditiis. Amet commodi ab exercitationem qui reprehenderit quis.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(113,	1,	'Ettie Mitchell',	'Shea',	'Nostrum et illo odit illo aliquid in exercitationem. Illum vero exercitationem expedita ullam et. Voluptatem excepturi quas delectus sequi dolorem numquam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(114,	1,	'Franz O\'Connell V',	'Norma',	'Necessitatibus vel et et deserunt. Commodi inventore porro autem sint. Quos laboriosam consequatur laborum. Alias dolores explicabo aut.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(115,	1,	'Dr. Keshaun Kub V',	'Willow',	'Sed nostrum eum similique ipsam. Cum aperiam dolorem ut quam. Et amet minima iusto non soluta voluptatem amet.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(116,	1,	'Carol Oberbrunner',	'Arvel',	'Temporibus ab incidunt nihil inventore deleniti voluptatem ut. Dicta harum ad fugit qui tempora itaque. Corporis facilis animi dicta laborum eos ipsum accusantium aut.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(117,	1,	'Ronny Halvorson',	'Jameson',	'Esse qui voluptatibus suscipit necessitatibus omnis. Eligendi debitis error commodi qui atque maiores ex saepe. Libero quasi et eius beatae ut sequi doloremque libero.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(118,	1,	'Samsung A32',	'Samsung',	'Nisi mollitia amet harum occaecati consequatur facere. Vel numquam aut sint aut voluptatem. Animi cum quo incidunt sit accusamus in sequi.',	'images/EG3c0flGy9oC89VBfyvVXA4td0w72GUXvsL9PJAF.jpg',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:21:32',	NULL),
(119,	1,	'Betty Stokes',	'Martina',	'Voluptate ut aspernatur temporibus quam voluptatem tempora. Velit voluptas quos magni praesentium repellendus rerum. Sit ut autem nobis voluptatem. Omnis ab error rerum sapiente velit iusto.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(120,	1,	'Gene Wilkinson',	'Earline',	'Maiores tempora aliquam quo. Dolore quisquam eveniet similique nostrum asperiores. Quod cumque natus totam quas consequatur sunt. Numquam assumenda et velit omnis labore.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(121,	1,	'Freddie D\'Amore',	'Burnice',	'Porro quibusdam placeat ex suscipit magni. Unde perspiciatis et temporibus. Recusandae est et quis unde ratione. Cupiditate eligendi aspernatur voluptas sapiente perferendis ut.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(122,	1,	'Billy Marvin',	'Viola',	'Omnis vel aperiam aspernatur incidunt. Saepe eligendi quidem mollitia ratione aliquam nihil eligendi nihil. Quia at quisquam blanditiis quia placeat.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(123,	1,	'Prof. Mervin Padberg III',	'Dallas',	'Quos numquam at reiciendis eum provident incidunt. Sit perferendis blanditiis voluptas molestiae et.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(124,	1,	'Lorenza Huel',	'Darion',	'Possimus aut enim quisquam sunt aut. Aspernatur asperiores accusantium natus consequatur. Necessitatibus ut magnam enim culpa rerum ea.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(125,	1,	'Sven Kuhn',	'Vidal',	'Ipsum nobis nihil et cumque. Consequatur officiis laborum esse deserunt. Velit omnis ea est sed. Expedita temporibus excepturi earum laborum est. Et veniam earum perferendis ratione quis.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(126,	1,	'Arlo Maggio',	'Jalen',	'Sint quod ipsa nulla hic et quia. Odit magni assumenda ut quidem quos. Qui perferendis animi officiis dolore neque quibusdam qui. Sapiente qui harum repellat numquam vel soluta impedit.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(127,	1,	'Prof. Trey Bogan',	'Ayden',	'Nesciunt dolorum amet error sint. Est sit qui tempora ad qui. Qui esse dicta harum delectus magnam. Sapiente in sit illum in voluptatibus.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(128,	1,	'Neil Kiehn',	'Ashleigh',	'Et est voluptatem temporibus doloremque. Et ut nihil culpa dolorum. Est et dignissimos sed labore.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(129,	1,	'Dr. Mose Durgan',	'Esteban',	'In possimus eos rerum impedit reiciendis et. Minima consequuntur est natus enim id itaque. Et impedit ut et et.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(130,	1,	'Darrell Gerhold',	'Maverick',	'Nihil distinctio labore dolor nihil quis aut. Sit harum ab eos non ut incidunt. Aut voluptatem accusantium aperiam. Id accusamus quo cumque ex dolor magni.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(131,	1,	'Agustina Thiel',	'Antonietta',	'Praesentium dignissimos doloribus eum quae voluptate autem. Debitis nobis dolor iste. Et sunt deleniti id non qui.',	'images/O64KHrLxWEQ0uGsqmc9FC8JE4COh0hsgeHO5KnG9.jpg',	1,	'2022-08-24 17:05:14',	'2022-08-27 15:33:40',	NULL),
(132,	1,	'Delmer Hahn Jr.',	'Markus',	'Mollitia quos voluptate dolores temporibus at voluptatem. Eos voluptatum recusandae earum impedit perspiciatis. Soluta hic fugit rerum asperiores dolore. Qui sunt quae aliquid ut laudantium.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(133,	1,	'Norris Gislason',	'Kenneth',	'Ducimus id non autem. Eligendi et et omnis facere magnam eius.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(134,	1,	'Travon McKenzie',	'Nayeli',	'Tempora explicabo odit ex atque vero quis laudantium. Aut architecto est deleniti nulla nobis. Qui officia ut ducimus nihil et. Expedita tempore veniam et mollitia dolorem alias.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(135,	1,	'Tressa Keeling I',	'Jayme',	'Placeat error doloremque veritatis ut itaque qui et. Fugiat possimus voluptas quos aperiam dolorem. Officia et et accusantium eum dolore molestiae modi.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(136,	1,	'Janessa Glover',	'Reuben',	'Rerum sed ut et voluptas eos placeat. Rerum dolor in molestias ducimus velit. Aliquam sit libero corporis nostrum. Eaque quo veritatis et fugiat aut culpa.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(137,	1,	'Eino Schmitt V',	'Margarita',	'Sequi numquam quidem beatae voluptatem molestiae maxime dolorem. Omnis culpa error dolores enim ut sunt. Dolore ducimus nihil omnis omnis. Praesentium molestias deleniti laborum voluptas qui.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(138,	1,	'Jayne Kuhlman',	'Jeramie',	'Rem vel voluptas sit dolore. Vel eligendi dolores eligendi atque qui id porro. Est odit facilis aperiam neque amet. Odit ducimus tempore ut excepturi quasi numquam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(139,	1,	'Mr. Darron Paucek',	'Lucas',	'Fuga ut temporibus voluptatum et quasi. Alias illo non fugiat enim. In qui vero beatae harum dicta ducimus commodi necessitatibus. Sit voluptas dolor quis est.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(140,	1,	'Broderick Jakubowski',	'Marcia',	'Repellat commodi voluptas unde dolor. Dolorem itaque nisi hic animi. Officiis dicta neque vel enim commodi vel quia.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(141,	1,	'Mr. Darrion Dickens',	'Ole',	'Id non eaque at ut quam omnis. Vitae vitae non voluptates assumenda. Ut rem numquam nihil at natus id in. Accusamus consequatur placeat vitae tenetur.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(142,	1,	'Prof. Anais Mante',	'Daron',	'Velit dolore quia ratione. Cumque dolores voluptatum natus et et. Sed nulla qui ea vero possimus voluptas ullam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(143,	1,	'Mr. Alford Swift Sr.',	'Alvena',	'Dolor aspernatur aut ut ipsa qui. Ipsam quia fugit vitae libero. Et sunt provident voluptas corporis aut adipisci nostrum quibusdam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(144,	1,	'Pasquale Nitzsche',	'Carlie',	'Et saepe labore est molestiae magni. Autem quidem voluptatum sit. Rerum quisquam nesciunt similique placeat et optio laboriosam. Quia corporis impedit reprehenderit ut quia et laudantium veniam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(145,	1,	'Miss Roxane Hane I',	'Abigale',	'Omnis accusantium nobis mollitia quia eum. Voluptate dolor soluta et id. Perspiciatis dolorem cumque vero fuga est.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(146,	1,	'Myles Welch',	'Virgie',	'Nihil voluptas tempore commodi voluptas minus a. Similique et est veniam rerum. Magni reprehenderit quo et recusandae vero. Autem ex eveniet similique. Perferendis ullam error velit et.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(147,	1,	'Dayton Will',	'Francisca',	'Perferendis hic eum quae ex occaecati. Incidunt quo possimus iure amet. Quas esse sit non non. Sit soluta nihil dolorum excepturi omnis quae velit numquam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(148,	1,	'Derrick Goldner',	'Kelton',	'Et assumenda eum nam libero. Qui laborum ex corrupti rem autem. Vel sint quas aperiam ducimus tempora sit sit blanditiis.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(149,	1,	'Sallie Wiegand DDS',	'Leda',	'Id temporibus totam tempora repellat. Numquam et ab tempora ea illum sit. Qui deserunt iusto aut recusandae voluptates maiores qui iusto.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(150,	1,	'Jeremie Heidenreich',	'Brannon',	'Qui vero sed laborum voluptatem. Sint eligendi consequatur ad ad. Sit sunt sunt aliquam excepturi quia.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(151,	1,	'Claud Kohler',	'Paris',	'Ipsam omnis recusandae nihil sit. Harum rerum temporibus velit laudantium. Optio aliquam tenetur vero explicabo. Ut recusandae quia suscipit non beatae. Eos est neque autem delectus.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(152,	1,	'Angelo Beatty Sr.',	'Donna',	'Sed praesentium quia aut nobis ipsa saepe nesciunt. Consequatur vel quia ex. Deserunt omnis blanditiis aspernatur aliquam eaque voluptatem corporis laboriosam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(153,	1,	'Miss Melisa Rogahn IV',	'Zachery',	'Magni cumque blanditiis et. Illum sint deserunt quis placeat. Quis ipsam totam praesentium autem occaecati cum. Eos facilis quidem et voluptatem vitae ipsa.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(154,	1,	'Trent Keebler',	'Miracle',	'Vel quia est harum suscipit fuga modi autem. Sint harum porro voluptatem quia explicabo molestiae. Ad ad officiis voluptate accusantium et molestias.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(155,	1,	'Ima Rodriguez',	'Carley',	'Enim voluptas itaque eos nostrum omnis. Et sit et deserunt sit.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(156,	1,	'Dr. Cathy Sipes DDS',	'August',	'Et voluptatem officia saepe molestiae iusto delectus. Et consectetur sit quia adipisci qui. Praesentium veniam et sunt sint itaque error.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(157,	1,	'Garnett Berge',	'Demond',	'Aut quaerat sed quia iure quia. Sit in dolorem dicta dolor. Corporis distinctio id voluptatem impedit ut aliquid aut. Corporis sint illo ad ut.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(158,	1,	'Mrs. Angelina Davis',	'Adriana',	'Quaerat provident sint ea. Rerum eum sapiente rerum minima sint unde repudiandae eos. Nisi sit repellat ratione accusamus.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(159,	1,	'Lilliana Braun',	'Jacky',	'Qui repellendus unde ut laudantium velit dolor et. Adipisci dignissimos voluptatibus facilis perferendis inventore. Corporis iusto rem enim mollitia enim. Quis animi fugit saepe atque.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(160,	1,	'Zakary Pacocha',	'Murl',	'Voluptatem consequatur aut eligendi qui. Reiciendis necessitatibus repudiandae officiis ut provident. Voluptatibus vel recusandae nisi quidem minima similique quisquam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(161,	1,	'Oppo A16 4/64 GB',	'OPPO',	'Id sapiente error molestias velit ut. Animi blanditiis soluta consectetur amet atque tenetur voluptatibus.',	'images/ALIzTQhpxcKXyS5WNtXurbcMEclp6W6p8IjRU5LZ.jpg',	1,	'2022-08-24 17:05:14',	'2022-08-26 02:25:01',	NULL),
(162,	1,	'Van Dooley',	'Rodolfo',	'Provident ea ad eos excepturi eaque pariatur quis. Eum est recusandae soluta sint ut. Minus tenetur laborum ad numquam. Ut voluptatem nesciunt qui quaerat.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(163,	1,	'Collin Prohaska',	'Sigmund',	'Quis sit totam dolores architecto. Ea quae hic excepturi ratione. Vitae omnis ex aut dolorem. Mollitia sit similique quis rem impedit quisquam et.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(164,	1,	'Eusebio Davis',	'Robb',	'Atque corporis et id atque debitis. Ab aperiam iste rerum et. Eos quis dolore alias doloremque est. Deleniti iusto iusto nisi et. Tempore recusandae non eos asperiores est quo quidem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(165,	1,	'Tate Buckridge',	'Max',	'Id qui ut enim dicta alias provident. Dolorum consectetur maiores ut in. Deleniti ducimus reiciendis tenetur in itaque. Aperiam accusamus quam maxime pariatur est non sint.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(166,	1,	'Prof. Darryl Wuckert',	'Audie',	'Nam aut repudiandae eligendi minus quibusdam. Aut exercitationem dolores ipsa doloribus.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(167,	1,	'Kimberly Davis IV',	'Hans',	'Consequatur sint quis et. Rerum sunt non cumque voluptas. Dolorum consequatur quia et est. Ut dolor hic voluptate dolores vel.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(168,	1,	'Dr. Favian Heller MD',	'Connie',	'Enim excepturi culpa suscipit qui tenetur. Occaecati totam occaecati est culpa. Exercitationem possimus vel ullam ad odit. Nobis ex beatae voluptate sed nam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(169,	1,	'Dr. Maribel Sanford',	'Nathaniel',	'Sint suscipit voluptatem nemo quis est. Qui quo deserunt quia adipisci illo ea fugit. Magnam consequatur impedit dicta et. Et iste ullam dignissimos iste aperiam nihil totam labore.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(170,	1,	'Prof. Enrique Conn',	'Caleb',	'Occaecati et tenetur sint. Animi dolorem qui rem. Sunt repellendus alias eveniet eius.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(171,	1,	'Prof. Adeline Swaniawski',	'Percival',	'Alias enim dolores dolorem. Quam magni in autem voluptatem dicta aut. Sit error magnam vel et quasi. Modi non nostrum et ut accusantium at.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(172,	1,	'Kenneth Keeling',	'Shad',	'Quia eos illum amet. Veniam non ut laborum beatae iste nostrum iste. Sit deleniti aut qui nihil. Debitis maxime omnis quos repudiandae.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(173,	1,	'Emmanuel Dibbert II',	'Jayson',	'Aspernatur perferendis vel cumque explicabo vel. Nihil harum doloribus provident. Aut consequuntur ut voluptas nihil a error ut quos. Aut quas ut cupiditate.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(174,	1,	'Macy Doyle',	'Emerson',	'Autem accusantium illum quo quam officiis porro ut nisi. Alias aut commodi voluptatum rem iure minima. Neque sint quas sit modi eligendi quam consectetur recusandae. Quia dignissimos eius tempore.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(175,	1,	'Bella Medhurst III',	'Vada',	'Deserunt qui non vero quasi laborum nulla eos. Officiis ut pariatur quia odio aut. Quibusdam quisquam non recusandae vitae similique excepturi.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(176,	1,	'Jocelyn Deckow',	'Kenton',	'Aut cupiditate ea suscipit et. Minima omnis sapiente assumenda ab. Quia dolorum dolores corrupti fuga maiores ipsum sint et. Repudiandae laboriosam quia pariatur officia quae id est.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(177,	1,	'Kira Osinski',	'Nella',	'Et quia quia in. Voluptas ipsa perspiciatis vel aut laboriosam dolore. At omnis et sed non.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(178,	1,	'Jacey Wunsch DDS',	'Sigurd',	'Sit animi natus eum maxime. Ab iusto porro dolor sint sunt. Sunt voluptas veritatis ipsam repellat sed. Ipsum autem esse ullam molestiae. Veritatis aliquam pariatur in quia dolores quis.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(179,	1,	'Kennedi Lindgren',	'Brent',	'Non voluptatem nostrum earum eum omnis. Autem molestiae necessitatibus repudiandae tenetur temporibus eum. Recusandae distinctio doloribus est at. Odit expedita et sunt ut qui est ut.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(180,	1,	'Rene Renner',	'Jadyn',	'Voluptatem ex et quaerat est maiores eos. Magni ea omnis consectetur optio enim et ut. Modi et sapiente cumque quia quia hic facere.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(181,	1,	'Kelley Cole',	'Enrico',	'Corrupti maiores molestiae distinctio dolorem nisi sapiente rerum. Rerum facere deleniti eos deserunt. Quia sed at qui est doloremque vel. Voluptatibus quibusdam est omnis ratione.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(182,	1,	'Nathen Graham',	'Justyn',	'Ab excepturi a et doloremque nostrum officia. Et praesentium consequatur ab ea repudiandae. Quis nemo qui voluptatem voluptates blanditiis. Quia in laudantium delectus dolores repellat laboriosam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(183,	1,	'Prof. Zetta Hauck',	'Denis',	'Vero aliquam molestiae totam vel quis laboriosam et magnam. Aut dolores ad qui. Molestias ut quos explicabo dolores.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(184,	1,	'Leon Towne',	'Cory',	'Officiis minima doloribus sapiente saepe. Aut eveniet saepe eaque id non sed. Accusamus expedita beatae est sed.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(185,	1,	'Prof. Concepcion Mertz',	'Dannie',	'Mollitia modi reiciendis et quae ab. Excepturi sapiente aperiam voluptas odio et ab. Illo cupiditate minus adipisci maiores aut. Quis nihil minima perferendis asperiores ut non.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(186,	1,	'Jed Stokes MD',	'Mia',	'Veniam laboriosam unde nostrum ut recusandae necessitatibus rerum nulla. Officia labore qui natus voluptate nemo placeat id sint. Repellat repellat et optio velit quos.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(187,	1,	'Roberto Rowe',	'Asha',	'Quia quia explicabo tempora in deserunt cupiditate. Tenetur dolores voluptas inventore sit qui ut quis. Sequi consequuntur id autem.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(188,	1,	'Pearl Collier',	'Julien',	'Atque est nobis omnis possimus. Fugiat magni veritatis sunt molestiae. Et ducimus sequi eligendi velit harum tenetur sunt. Sint quibusdam suscipit eum.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(189,	1,	'Mrs. Elmira Kris',	'Trycia',	'Amet ea nisi animi in enim voluptatem a nam. Laudantium magni pariatur dolor est quae ea voluptas. Modi doloremque quo quis sit aut dolorum nostrum. Id iste et ut rerum.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(190,	1,	'Freeman Witting I',	'Sean',	'Ut soluta similique magnam vel sequi ut. Est pariatur rerum rem porro eum repellat veniam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(191,	1,	'Miss Madilyn Prosacco I',	'Lindsay',	'Et consectetur sunt culpa. Rem reiciendis consequatur expedita accusamus minus hic. Esse fuga omnis accusantium dolores quia ipsam. Dolor repellat incidunt sed est neque.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(192,	1,	'Prof. Luciano Streich V',	'Jackeline',	'Eum ducimus consequatur animi in doloremque velit. Eum iusto reiciendis vel voluptas. Quaerat voluptatem molestiae doloremque minima. Qui molestias earum inventore voluptatibus cumque.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(193,	1,	'Vivo V17 Plus',	'VIVO',	'Magnam eius distinctio harum cum. Omnis quo et hic aspernatur debitis voluptatibus. Tenetur id deserunt inventore eum maxime magni. Cum facilis enim occaecati facere ut pariatur quia.',	'images/Nak6V7mZ2dQsAugQZz1oAQYqONkau4AK5bQk4qpk.jpg',	1,	'2022-08-24 17:05:14',	'2022-08-27 16:34:52',	NULL),
(194,	1,	'Millie Mosciski DVM',	'Elyse',	'Optio blanditiis veniam quo quasi sequi voluptas consequatur. Et dolores ut et necessitatibus. Enim accusamus maxime sit ea quas inventore qui sed.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(195,	1,	'Mr. Marshall Torp V',	'Janis',	'Nisi delectus explicabo amet et. Eaque qui est minus laborum quisquam. Quisquam sint debitis eum deserunt.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(196,	1,	'Maxie Homenick MD',	'Concepcion',	'Est vel iusto vel omnis. Repellendus rerum occaecati molestias at repellat nostrum. Aut vel pariatur voluptate culpa ab maxime.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(197,	1,	'Miss Linda DuBuque',	'Vickie',	'Molestiae illo enim aut aut minima explicabo. Vitae laborum quia ducimus voluptatum accusamus. Itaque suscipit minus id earum. Aut earum officiis magni nihil ea autem et.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(198,	1,	'Ms. Jayne Gislason Sr.',	'Lamont',	'Cupiditate aut quis omnis dolorem cum perferendis. Voluptatibus ea neque nostrum molestias sed eaque. Sed commodi necessitatibus at cupiditate dolores.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(199,	1,	'Jerel Kuvalis',	'Brandon',	'Minima cum enim repudiandae nobis facere itaque. Id odio sed incidunt explicabo et iure. Alias magnam perferendis impedit magni eum.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(200,	1,	'Domenic Lindgren Sr.',	'Micaela',	'Quo ut repellendus dolorem. Aut sit minima non ipsum eaque. Autem consequatur eum sunt assumenda sed quisquam. Minus quia deleniti explicabo et magni.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(201,	1,	'Kara Cummings',	'Kory',	'Adipisci voluptatem debitis temporibus iusto qui. Est odio ut tempore ipsam.',	'https://via.placeholder.com/200',	1,	'2022-08-24 17:05:14',	'2022-08-24 17:05:14',	NULL),
(202,	1,	'Redmi Note 10 Pro',	'Xiaomi',	NULL,	'images/qKCB6THkm05caqw5u569c7agYFlIPR5ozZnrmYLk.jpg',	1,	'2022-08-27 00:56:15',	'2022-08-27 16:31:19',	'2022-08-27 16:31:19');

DROP TABLE IF EXISTS `rule_schemes`;
CREATE TABLE `rule_schemes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rule_schemes_rule_id_index` (`rule_id`),
  KEY `rule_schemes_department_id_index` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `submissions`;
CREATE TABLE `submissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `credit_scheme_id` bigint(20) NOT NULL,
  `submission_status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','progress','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `submissions_user_id_index` (`user_id`),
  KEY `submissions_product_id_index` (`product_id`),
  KEY `submissions_approved_index` (`submission_status`),
  KEY `submissions_paid_index` (`payment_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `submissions` (`id`, `user_id`, `product_id`, `credit_scheme_id`, `submission_status`, `payment_status`, `created_at`, `updated_at`) VALUES
(1,	5,	161,	23,	'pending',	'unpaid',	'2022-08-28 22:08:35',	'2022-08-28 22:08:35');

DROP TABLE IF EXISTS `submission_attachments`;
CREATE TABLE `submission_attachments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` bigint(20) NOT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `permit` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `submission_attachments` (`id`, `submission_id`, `foto`, `permit`, `created_at`, `updated_at`) VALUES
(1,	1,	'attachtment/wfEVqh5rhcRbUl7AuGdmR9cthzXVZWwMgS2ff9SY.jpg',	'attachtment/TTpYlSqJY5wroSTTRgLDfrsWteD9z6FOxZ2p7RnM.jpg',	'2022-08-28 22:08:35',	'2022-08-28 22:08:35');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint(20) NOT NULL,
  `role` enum('admin','pic','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_company_id_index` (`company_id`),
  KEY `users_role_index` (`role`),
  KEY `users_email_index` (`email`),
  KEY `users_api_index` (`api`(768))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `company_id`, `role`, `email`, `password`, `api`, `active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'admin',	'julian.aryo1989@gmail.com',	'$2y$10$eVioeAWPCvfdJJigb7gbKeJoCXngUC59aTG/couYOmIsWDqFJy0CC',	NULL,	0,	NULL,	'2022-08-16 05:17:47',	'2022-08-30 15:54:26',	NULL),
(3,	3,	'admin',	'my.meww@gmail.com',	'$2y$10$MUGl5PoyShCHNG57EQ/dMOBDHwam3X.tFgFghmA.c5.USooAjUjMS',	'',	0,	NULL,	'2022-08-16 09:00:38',	'2022-08-16 09:00:38',	NULL),
(5,	1,	'user',	'user1@test.com',	'$2y$10$Cdengt5vHOV6ZpAyxxxIWu9OcbWOBrpjVDiA4/phi4UmfZHki116W',	NULL,	1,	NULL,	'2022-08-27 09:29:56',	'2022-08-29 15:50:17',	NULL),
(6,	1,	'pic',	'user2@test.com',	'$2y$10$3pVxBBeLACzgfRK44.f3YOwfQsMvZzFEJXiT1oy8wXlMKw914jvF.',	'820c9f9d-8d28-4c5b-81d0-2b63e546bdb7',	1,	NULL,	'2022-08-27 09:34:55',	'2022-08-30 15:54:32',	NULL);

-- 2022-08-31 06:49:10
