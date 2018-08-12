/*CRIAR TABELA users*/
DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `course` varchar(200) NOT NULL DEFAULT '',
  `institution` varchar(200) NOT NULL DEFAULT '',
  `picture_img` VARCHAR(100) DEFAULT 'user/pic/avatar.png',
  `password` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `email`, `password`)
VALUES
/*Pass: admin*/ (1, 'Admin', 'admin@admin.com', '$2y$10$BgCYh/ld5h7WIn3sl0yeu.MpfXcuKXrkghybbTGlNnfFhUVqTwXAK'), 
	(2, 'Roger', 'roger@admin.com', '$2y$10$9DbQFiJxY66JKfktOZutC.OPfljFcNNxWakmyo1KjP48N7hEME72e'); 



/*CRIAR TABELA event_locations*/
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `events_location`;

CREATE TABLE IF NOT EXISTS `events_location` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `lat` FLOAT(10,6) NOT NULL,
  `lng` FLOAT(10,6) NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `theme` VARCHAR(200) NOT NULL,
  /*`address` VARCHAR(200) NOT NULL,*/
  `date_begin` DATE NOT NULL,
  `date_end` DATE NOT NULL,
  `location_status` tinyint(1) DEFAULT '0',
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


ALTER TABLE `events_location`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;
