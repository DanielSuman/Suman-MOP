-- Adminer 4.8.1 MySQL 8.4.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1,	'Weapons 3',	'Mods that add or modify weapons in Left 4 Dead.',	'2024-06-19 09:22:57'),
(2,	'Maps',	'Custom maps created for Left 4 Dead.',	'2024-06-19 09:22:57'),
(3,	'Characters',	'Mods that introduce new characters or modify existing ones.',	'2024-06-19 09:22:57'),
(4,	'Gameplay Enhancements',	'Mods that enhance or change gameplay mechanics.',	'2024-06-19 09:22:57'),
(5,	'UI Modifications',	'Mods that alter the user interface of Left 4 Dead.',	'2024-06-19 09:22:57'),
(6,	'Sound and Music',	'Mods that change or add sound effects and music.',	'2024-06-19 09:22:57'),
(7,	'Visual Effects',	'Mods that enhance or modify visual effects in the game.',	'2024-06-19 09:22:57'),
(8,	'Performance Optimization',	'Mods designed to improve game performance.',	'2024-06-19 09:22:57'),
(9,	'Custom Campaigns',	'Mods that add new custom campaigns to play.',	'2024-06-19 09:22:57'),
(10,	'Bug Fixes',	'Mods that fix bugs or issues in Left 4 Dead.',	'2024-06-19 09:22:57');

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
  `user_id` int DEFAULT NULL,
  `mod_category` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mods_users` (`user_id`),
  KEY `fk_mods_categories` (`mod_category`),
  CONSTRAINT `fk_mods_categories` FOREIGN KEY (`mod_category`) REFERENCES `categories` (`id`),
  CONSTRAINT `mods_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `mods` (`id`, `name`, `description`, `image`, `vidprev`, `created_at`, `user_id`, `mod_category`) VALUES
(3,	'Pistol Pack 2',	'Introduces new pistols with unique abilities and designs.',	'upload/mods/3/thumbnail.png',	'',	'2024-06-19 09:39:57',	1,	1),
(4,	'Melee Mayhem',	'Expands melee weapon options with new weapons and combos.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	1),
(5,	'Assault Rifle Mods',	'Customizes assault rifles with various attachments and skins.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	1),
(6,	'Abandoned Hospital',	'Explore a hauntingly atmospheric hospital overrun by infected.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	2),
(7,	'Suburban Nightmare',	'Navigate through suburban streets teeming with infected hordes.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	2),
(9,	'Underground Catacombs',	'Explore dark tunnels filled with both infected and hidden treasures.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	2),
(10,	'Haunted Forest',	'Survive in a dense forest haunted by eerie apparitions and infected.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	2),
(11,	'Zombie Slayer',	'Adds a new tough survivor character with unique skills and backstory.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	3),
(12,	'Military Medic',	'Transforms an existing character into a skilled medic with military gear.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	3),
(13,	'Ninja Assassin',	'Introduces a nimble ninja character capable of stealth takedowns.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	3),
(14,	'Cyberpunk Survivor',	'Brings a futuristic survivor with cybernetic enhancements into the game.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	3),
(15,	'Zombie Outlaw',	'Become a renegade outlaw surviving in the post-apocalyptic world.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	3),
(16,	'Enhanced Infected AI',	'Improves infected behavior for more challenging gameplay.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	4),
(17,	'Special Infected Overhaul',	'Revamps special infected abilities and appearances.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	4),
(18,	'Infinite Ammo Mode',	'Introduces a mode where ammo is unlimited for all weapons.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	4),
(19,	'Survival Mode Tweaks',	'Adjusts survival mode mechanics for better balance and pacing.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	4),
(20,	'New Game Plus',	'Enables a new game plus mode with increased difficulty and rewards.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	4),
(21,	'Minimalistic HUD',	'Simplifies the HUD elements for a cleaner interface during gameplay.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	5),
(22,	'Customizable Menu Skins',	'Allows players to customize menu themes and background images.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	5),
(23,	'Improved Inventory Layout',	'Enhances the inventory screen layout for easier item management.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	5),
(24,	'Colorblind Mode',	'Adds a colorblind-friendly mode with distinct color schemes.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	5),
(25,	'Custom Crosshairs',	'Allows players to choose from a variety of custom crosshair designs.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	5),
(26,	'Epic Music Pack',	'Replaces the game soundtrack with epic orchestral music.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	6),
(27,	'Horror Sound Effects',	'Adds terrifying sound effects to enhance the horror atmosphere.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	6),
(28,	'Radio Voice Overhaul',	'Refreshes radio voice lines with new dialogue and voice actors.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	6),
(29,	'Dynamic Ambient Sounds',	'Introduces dynamic ambient sounds that react to player actions.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	6),
(30,	'Music Player Integration',	'Allows players to integrate their own music playlists into the game.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	6),
(31,	'HD Blood Splatter',	'Enhances blood effects with high-definition textures and physics.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	7),
(32,	'Realistic Fire Effects',	'Adds realistic fire and explosion effects for immersive visuals.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	7),
(33,	'Enhanced Lighting Mod',	'Improves overall game lighting for more realistic and dramatic scenes.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	7),
(34,	'HD Character Models',	'Upgrades character models with higher resolution textures and details.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	7),
(35,	'Environmental Detail Overhaul',	'Enhances environmental details like foliage and debris.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	7),
(36,	'FPS Boost',	'Optimizes game performance for smoother gameplay on lower-end systems.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	8),
(37,	'Loading Screen Reducer',	'Reduces loading screen times with optimized loading techniques.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	8),
(38,	'Memory Leak Fix',	'Fixes memory leaks that can cause performance issues during extended play.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	8),
(39,	'Stuttering Fix',	'Addresses stuttering and frame drops to ensure smoother gameplay.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	8),
(40,	'Multi-core Processor Support',	'Optimizes game engine to utilize multi-core processors more efficiently.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	8),
(41,	'The Last Stand',	'Adds a challenging campaign with a gripping storyline.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	9),
(42,	'City of the Dead',	'Explore a devastated cityscape overrun by the undead horde.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	9),
(43,	'Survivors in Space',	'Embark on an interstellar adventure to escape the zombie apocalypse.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	9),
(44,	'Haunted Mansion',	'Investigate a haunted mansion filled with puzzles and perilous traps.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	9),
(45,	'Tropical Island Escape',	'Survive on a tropical island infested with mutated zombie creatures.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	9),
(46,	'Critical Bug Fix Patch',	'Addresses critical bugs that can cause game crashes and glitches.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	10),
(47,	'Performance Optimization Update',	'Improves overall game performance across different hardware configurations.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	10),
(48,	'Compatibility Patch',	'Ensures compatibility with the latest game updates and operating systems.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	10),
(49,	'Balance Adjustment Patch',	'Adjusts gameplay balance to address community feedback and improve fairness.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	10),
(50,	'Texture Quality Fix',	'Fixes texture quality issues that affect visual fidelity and immersion.',	NULL,	NULL,	'2024-06-19 09:39:57',	1,	10),
(51,	'Admin',	'TEST',	'upload/mods//thumbnail.png',	'',	'2024-06-19 11:19:29',	NULL,	NULL);

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


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
(1,	'Administrator',	'Admin',	'Admin',	'Admin',	'admin',	'1234567',	'daniel.suman@student.ossp.cz',	'4644684',	'Admin',	NULL,	'Admin',	'Admin',	'Admin',	'admin');

-- 2024-06-20 09:55:25