-- HRMS MySQL Export for Niagahoster
-- Generated for CPanel Import

SET FOREIGN_KEY_CHECKS=0;

-- Table structure for users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Note: In shared hosting, it is highly recommended to run 'php artisan migrate --seed' 
-- via terminal (SSH) for the most accurate results. 
-- If SSH is not available, use the SQL file below.

-- [!] DATA BELOW IS PLACEHOLDER - PLEASE RUN SEEDER ON SERVER [!]
