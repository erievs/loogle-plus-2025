-- Adminer 4.8.1 MySQL 8.0.40 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE TABLE `accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_status` enum('user','admin','moderator') DEFAULT 'user',
  `ip_address` varchar(45) NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ban_status` enum('active','banned') DEFAULT 'active',
  `ban_reason` text,
  `ban_start_date` timestamp NULL DEFAULT NULL,
  `ban_end_date` timestamp NULL DEFAULT NULL,
  `banned_by` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `intro` text,
  `links` text,
  `bragging_rights` text,
  `gender` enum('male','female','other') DEFAULT NULL,
  `networking` text,
  `birthday` date DEFAULT NULL,
  `relationship` enum('single','in a relationship','married','other') DEFAULT NULL,
  `other_names` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `accounts` (`id`, `username`, `password`, `user_status`, `ip_address`, `date_created`, `ban_status`, `ban_reason`, `ban_start_date`, `ban_end_date`, `banned_by`, `banner_url`, `tagline`, `intro`, `links`, `bragging_rights`, `gender`, `networking`, `birthday`, `relationship`, `other_names`) VALUES
(1,	'd',	'$2y$12$nKGsYwDL8lDd3iRxRLp3g.mAXv0I2xsUmi7KjISTUx9bpGFMNPWp2',	'admin',	'::1',	'2024-12-29 07:49:31',	'active',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(2,	'g',	'$2y$12$ZXFbbbFLzRhm9oMf08jdUusTb.ToOfd9xCnBRrQJjhbIEML/TrnYS',	'user',	'::1',	'2024-12-30 06:54:52',	'active',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `plus_one_count` int NOT NULL DEFAULT '0',
  `plus_one_usernames` text NOT NULL,
  `site_embed_url` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `youtube_video_url` varchar(255) DEFAULT NULL,
  `community` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `registration_codes`;
CREATE TABLE `registration_codes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `is_used` tinyint(1) DEFAULT '0',
  `created_by` varchar(255) NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;;


-- 2025-02-09 07:37:59
