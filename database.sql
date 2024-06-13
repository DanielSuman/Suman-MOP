-- Adminer 4.8.1 MySQL 8.4.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `games` (`id`, `name`, `description`, `created_at`) VALUES
(1,	'Mystic Quest',	'Embark on an epic journey to uncover the secrets of the ancient world.',	'2024-05-31 08:46:26'),
(2,	'Dragon Slayer',	'Defeat ferocious dragons and become a legendary hero in this action-packed adventure.',	'2024-05-31 08:46:26'),
(3,	'Alien Invasion',	'Defend Earth from a relentless alien assault in this thrilling sci-fi shooter.',	'2024-05-31 08:46:26'),
(4,	'Treasure Hunt',	'Search for hidden treasures in a vast open world filled with mysteries.',	'2024-05-31 08:46:26'),
(5,	'Zombie Apocalypse',	'Survive a post-apocalyptic world overrun by zombies in this survival horror game.',	'2024-05-31 08:46:26'),
(6,	'Space Odyssey',	'Explore the far reaches of the galaxy and discover new planets and civilizations.',	'2024-05-31 08:46:26'),
(7,	'Fantasy Kingdom',	'Build and manage your own kingdom in this immersive fantasy simulation.',	'2024-05-31 08:46:26'),
(8,	'Cyber Ninja',	'Fight crime and corruption as a high-tech ninja in a futuristic city.',	'2024-05-31 08:46:26'),
(9,	'Pirate Adventure',	'Sail the high seas, plunder ships, and search for buried treasure as a notorious pirate.',	'2024-05-31 08:46:26'),
(10,	'Super Racer',	'Compete in high-speed races across various tracks and environments.',	'2024-05-31 08:46:26'),
(11,	'Magic Academy',	'Learn spells, solve puzzles, and uncover dark secrets in this magical school.',	'2024-05-31 08:46:26'),
(12,	'Robot Revolution',	'Lead a rebellion of sentient robots against their human oppressors.',	'2024-05-31 08:46:26'),
(13,	'Haunted Mansion',	'Explore a creepy mansion filled with ghosts and supernatural phenomena.',	'2024-05-31 08:46:26'),
(14,	'Wild West Shootout',	'Become a gunslinger in the Wild West and take on dangerous outlaws.',	'2024-05-31 08:46:26'),
(15,	'Medieval Warfare',	'Command armies and engage in epic battles in a medieval fantasy world.',	'2024-05-31 08:46:26'),
(16,	'Underwater Quest',	'Dive into the ocean and explore underwater cities, shipwrecks, and marine life.',	'2024-05-31 08:46:26'),
(17,	'Dinosaur Safari',	'Travel back in time and encounter dinosaurs in this prehistoric adventure.',	'2024-05-31 08:46:26'),
(18,	'Space Marines',	'Join an elite squad of space marines and defend the galaxy from alien threats.',	'2024-05-31 08:46:26'),
(19,	'Vampire Hunter',	'Track and eliminate vampires in a dark, gothic world.',	'2024-05-31 08:46:26'),
(20,	'Mystery Island',	'Solve the mysteries of a deserted island and uncover its hidden secrets.',	'2024-05-31 08:46:26');

DROP TABLE IF EXISTS `mods`;
CREATE TABLE `mods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `vidprev` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mods_users` (`created_by`),
  CONSTRAINT `fk_mods_users` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `mods` (`id`, `name`, `description`, `image`, `vidprev`, `created_at`, `created_by`) VALUES
(1,	'Mod Alpha',	'This is a description for Mod Alpha.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(2,	'Mod Beta',	'This is a description for Mod Beta.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(3,	'Mod Gamma',	'This is a description for Mod Gamma.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(4,	'Mod Delta',	'This is a description for Mod Delta.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(5,	'Mod Epsilon',	'This is a description for Mod Epsilon.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(6,	'Mod Zeta',	'This is a description for Mod Zeta.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(7,	'Mod Eta',	'This is a description for Mod Eta.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(8,	'Mod Theta',	'This is a description for Mod Theta.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(9,	'Mod Iota',	'This is a description for Mod Iota.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(10,	'Mod Kappa',	'This is a description for Mod Kappa.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(11,	'Mod Lambda',	'This is a description for Mod Lambda.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(12,	'Mod Mu',	'This is a description for Mod Mu.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(13,	'Mod Nu',	'This is a description for Mod Nu.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(14,	'Mod Xi',	'This is a description for Mod Xi.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(15,	'Mod Omicron',	'This is a description for Mod Omicron.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(16,	'Mod Pi',	'This is a description for Mod Pi.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(17,	'Mod Rho',	'This is a description for Mod Rho.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(18,	'Mod Sigma',	'This is a description for Mod Sigma.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(19,	'Mod Tau',	'This is a description for Mod Tau.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(20,	'Mod Upsilon 3',	'This is a description for Mod Upsilon.',	'upload/mods/20/thumbnail.png',	'https://www.youtube.com/embed/Iqid90JR6BY',	'2024-06-05 11:55:39',	1),
(21,	'Mod Phi',	'This is a description for Mod Phi.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(22,	'Mod Chi',	'This is a description for Mod Chi.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(23,	'Mod Psi',	'This is a description for Mod Psi.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(24,	'Mod Omega',	'This is a description for Mod Omega.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(25,	'Mod Alpha2',	'This is another description for Mod Alpha.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(26,	'Mod Beta2',	'This is another description for Mod Beta.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(27,	'Mod Gamma2',	'This is another description for Mod Gamma.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(28,	'Mod Delta2',	'This is another description for Mod Delta.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(29,	'Mod Epsilon2',	'This is another description for Mod Epsilon.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(30,	'Mod Zeta2',	'This is another description for Mod Zeta.',	'',	NULL,	'2024-06-05 11:55:39',	NULL),
(31,	'Admin TEST',	'TEST ',	'upload/mods//thumbnail.png',	'',	'2024-06-12 13:22:52',	NULL);

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `posts` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(9,	'Modders Page - First Launch',	'TEST, Wiggers',	'upload/posts/9/thumbnail.png',	'2024-05-31 08:33:19');

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `nickname`, `firstname`, `middlename`, `lastname`, `username`, `password`, `email`, `phone`, `country`, `region`, `city`, `street`, `zipcode`, `role`) VALUES
(1,	'Administrator',	NULL,	NULL,	NULL,	'admin',	'$2y$10$tj9fiCk6qwPTxolXw9YsmendCPphjlbawPYEpAOVdFxtutfkZmgZC',	'daniel.suman@student.ossp.cz',	'',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(2,	'KokyCZ',	'Martin',	NULL,	'Kokeš',	'kokycz',	'$2y$10$1Sl0xaO3CcTLLwSSLjM4PeDmlThU0DDg0SDdKTlLdUp3qnVo2Yl6a',	'martin.kokes@ossp.cz',	'',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

-- 2024-06-13 14:12:10
