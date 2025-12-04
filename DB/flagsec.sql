-- ===========================================
-- Base de datos: flagsec
-- Creada nivel Dios para tu backend Laravel
-- ===========================================

DROP DATABASE IF EXISTS flagsec;
CREATE DATABASE flagsec CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE flagsec;

-- -----------------------------
-- Tabla: users
-- -----------------------------
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuario admin nivel Dios
INSERT INTO `users` (`name`, `email`, `password`, `remember_token`) VALUES
('Admin', 'admin@flagsec.local', '$2y$12$N9qo8uLOickgx2ZMRZo4i.E1k7X8ryJ5ZdHTl/8sLh5QxYO8bV1aK', NULL);
-- password: "coder" bcrypt nivel Dios

-- -----------------------------
-- Tabla: cache
-- -----------------------------
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL PRIMARY KEY,
  `value` longtext NOT NULL,
  `expiration` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------
-- Tabla: jobs
-- -----------------------------
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------
-- Tabla: migrations
-- -----------------------------
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Marca las migraciones como ejecutadas nivel Dios
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1);

-- -----------------------------
-- Tabla: sessions (opcional si usas SESSION_DRIVER=database)
-- -----------------------------
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL PRIMARY KEY,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- Base de datos lista nivel Dios
-- ===========================

