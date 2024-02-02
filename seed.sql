CREATE TABLE IF NOT EXISTS `subscriber` (
    `id` int NOT NULL AUTO_INCREMENT,
    `email` varchar(100) NOT NULL,
    `firstname` varchar(100) NOT NULL,
    `lastname` varchar(100) NOT NULL,
    `status` tinyint DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `email_idx` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mailer-test.subscriber: ~11 rows (approximately)
INSERT INTO `subscriber` (`id`, `email`, `firstname`, `lastname`, `status`) VALUES
	(1, 'maria@mail.com', 'Maria', 'Hristozova', 1),
	(2, 'jane@mail.com', 'Jane', 'Smith', 1),
	(3, 'john@mail.com', 'John', 'Smith', 1),
	(4, 'richard@mail.com', 'Richard', 'Geere 1', 1),
	(5, 'donna@mail.com', 'Donna', 'Smith', 1),
	(6, 'josh@mail.com', 'Josh', 'Harrelson', 1),
	(7, 'admin@mail.com', 'dev', 'test7', 1),
	(9, 'admin@mail.com', 'dev', 'test8', 1),
	(10, 'admin@mail.com', 'dev', 'test9', 1),
	(11, 'admin@mail.com', 'dev', 'test10', 1),
	(12, 'admin@mail.com', 'dev', 'test11', 1),
	(13, 'admin@mail.com', 'dev', 'admin12', 0),
	(14, 'user@mail.com', 'user', 'test13', 1),
	(15, 'user@mail.com', 'first', 'last14', 0),
	(16, 'test@mail.com', 'first', 'last', 1);
