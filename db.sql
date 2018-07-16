# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `course` varchar(200) NOT NULL DEFAULT '',
  `institution` varchar(200) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `email`, `password`)
VALUES
	/*Pass: admin*/
	(1, 'Admin', 'admin@admin.com', '$2y$10$BgCYh/ld5h7WIn3sl0yeu.MpfXcuKXrkghybbTGlNnfFhUVqTwXAK'),
	/*Pass: main*/
	(2, 'Main', 'main@main.com', '$2y$10$RUiLWUfasSoNQzSPPS3.Fe8Bl86UDnz59TscHcm.39ZurQ05oCQvm'); 