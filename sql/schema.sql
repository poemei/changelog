/* [AI:GPT-5.6 | 2026-09-01 05:00:00 UTC] */
CREATE TABLE IF NOT EXISTS `changelog` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `version` VARCHAR(20) NOT NULL,
    `category` ENUM('feature', 'fix', 'security', 'maintenance', 'release', 'development') NOT NULL DEFAULT 'feature',
    `description` TEXT NOT NULL,
    `date_released` DATE NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/* [End AI:GPT-5.6] */
