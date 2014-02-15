CREATE TABLE `site_check` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `check_date` datetime DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `site_ok` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;