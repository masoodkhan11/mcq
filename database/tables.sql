CREATE TABLE `admins` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `password` varchar(255) NOT NULL,
 `created_at` timestamp NULL DEFAULT NULL,
 `updated_at` timestamp NULL DEFAULT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `users` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `password` varchar(255) NOT NULL,
 `created_at` timestamp NULL DEFAULT NULL,
 `updated_at` timestamp NULL DEFAULT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `quizzes` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `played_id` INT(11) UNSIGNED NOT NULL,
 `category` varchar(50) NOT NULL,
 `type` varchar(50) NOT NULL,
 `difficulty` varchar(50) NOT NULL,
 `question` text NOT NULL,
 `correct_answer` varchar(255) NOT NULL,
 `incorrect_answers` text NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `quiz_played` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `user_id` int(11) unsigned NOT NULL,
 `status` enum('complete','incomplete') NOT NULL DEFAULT 'incomplete',
 `total_points` smallint(6) NOT NULL,
 `scored_points` smallint(6) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `quiz_play_summary` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `played_id` int(11) unsigned NOT NULL,
 `quiz_id` int(11) unsigned NOT NULL,
 `answer` varchar(255) NOT NULL,
 `is_correct` tinyint(1) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `played_id` (`played_id`),
 KEY `quiz_id` (`quiz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
