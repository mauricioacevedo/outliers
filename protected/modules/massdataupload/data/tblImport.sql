
CREATE TABLE `tbl_import_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bd` varchar(255) DEFAULT NULL,
  `tabla` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `eliminable` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8_spanish_ci;

CREATE TABLE `mvc_import_data_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) DEFAULT NULL,
  `cod_response` int(11) DEFAULT NULL,
  `process` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `import_date` datetime DEFAULT NULL,
  `user` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `content` longtext COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id`),
  KEY `fk_import_log` (`module_id`) USING BTREE  
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


