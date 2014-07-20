DROP DATABASE IF EXISTS `phalcon_sample`;
CREATE DATABASE `phalcon_sample`;

use `phalcon_sample`;

SET NAMES 'utf8';

CREATE TABLE `session` (
    `session_id` varchar(35) NOT NULL,
    `data` text NOT NULL,
    `created_at` int(15) unsigned NOT NULL,
    `modified_at` int(15) unsigned DEFAULT NULL,
    PRIMARY KEY (`session_id`)
);

CREATE TABLE `group` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `enabled` BOOLEAN NOT NULL,
    `name` VARCHAR(64) NOT NULL,
    `info` VARCHAR(255) NULL,
    `roles` TEXT,
    `created_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `enabled` BOOLEAN NOT NULL,
    `suspended` BOOLEAN NOT NULL,
    `gender` ENUM('male', 'female', 'unknown', 'both') NOT NULL,
    `first_name` VARCHAR(64) NOT NULL,
    `last_name` VARCHAR(64) NOT NULL,
    `info` TEXT NULL,
    `email` VARCHAR(128) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    `roles` TEXT,
    `created_at` DATETIME DEFAULT NULL,
    `expires_at` DATE DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1024 COLLATE=utf8_unicode_ci;

CREATE TABLE `user_group` (
    `user_id` INT UNSIGNED NOT NULL,
    `group_id` INT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NOT NULL,
    FOREIGN KEY fk_user_group_user_id (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
    FOREIGN KEY fk_user_group_group_id (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE,
    PRIMARY KEY (`user_id`, `group_id`)
) ENGINE=InnoDB;

INSERT INTO `user` (`enabled`, `roles`, `gender`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(1, '["ROLE_USER"]', 'male', 'Jacek', 'Siciarek', 'siciarek@gmail.com', md5('HelloWorld2014'), NOW()),
(1, '["ROLE_USER"]', 'male', 'Julian', 'Olak', 'jolak@gmail.com', md5('HelloWorld2014'), NOW()),
(1, '["ROLE_USER"]', 'female', 'Karolina', 'Olak', 'kolak@gmail.com', md5('HelloWorld2014'), NOW()),
(1, '["ROLE_USER"]', 'female', 'Marianna', 'Olak', 'molak@gmail.com', md5('HelloWorld2014'), NOW()),
(1, '["ROLE_USER"]', 'male', 'Czesław', 'Olak', 'colak@gmail.com', md5('HelloWorld2014'), NOW())
;

INSERT INTO `group` (`enabled`, `name`, `info`, `roles`, `created_at`) VALUES
(1, 'Users', 'Registered users.', '["ROLE_USER"]', NOW()),
(1, 'Editors', 'Articles editors.', '["ROLE_EDITOR"]', NOW()),
(1, 'Reviewers', 'Articles reviewers.', '["ROLE_REVIEWER"]', NOW()),
(1, 'Admins', 'System administrators.', '["ROLE_ADMIN"]', NOW()),
(1, 'Superadmins', 'System superadministrators.', '["ROLE_SUPERADMIN"]', NOW())
;

INSERT INTO `user_group` (`user_id`, `group_id`) VALUES
(1024, 1),
(1024, 2),
(1024, 4),
(1025, 1),
(1025, 2)
;
