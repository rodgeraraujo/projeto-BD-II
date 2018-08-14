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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
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


INSERT INTO `events_location` (`id`, `lat`, `lng`, `title`, `theme`, `date_begin`, `date_end`, `location_status`, `user_id`) VALUES
(1, -6.886578, -38.566971, 'Titulo', 'Tema', '2018-08-07', '2018-08-14', 1, 2),
(2, -6.890533, -38.574574, 'teste 1', 'tema1', '2018-08-06', '2018-08-15', 1, 2),
(3, -6.888520, -38.563305, 'tema2', ' tema2', '2018-07-30', '2018-08-28', 1, 2),
(4, -6.888520, -38.563305, 'tema2', ' tema2', '2018-07-30', '2018-08-28', 1, 2),
(5, -6.876915, -38.557457, 'tema3', 'tema3', '2018-08-08', '2018-08-22', 1, 2),
(6, -6.890591, -38.574169, 'educaÃ§a', 'educacao', '2018-12-31', '2018-12-31', 1, 2),
(7, -6.890702, -38.544933, 'Amostra', 'EducaÃ§Ã£o', '2018-09-04', '2018-09-07', 1, 1),
(8, -6.888962, -38.545132, 'Amostra de Pesquisas', 'Tecnologia', '2018-08-15', '2018-08-17', 1, 7),
(9, -6.886298, -38.550816, 'Amostra', 'Tecnologia', '2018-08-15', '2018-08-21', 1, 7),
(10, -6.890181, -38.573875, 'Amostra e extensÃ£o..', 'Matematica', '2018-08-14', '2018-08-15', 0, 1);


ALTER TABLE `events_location`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;
