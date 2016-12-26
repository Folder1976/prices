CREATE TABLE IF NOT EXISTS `fash_user_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_target` int(11) NOT NULL,
  `log_key` varchar(10) COLLATE utf8_bin NOT NULL,
  `log_date` datetime NOT NULL,
  `log_user` int(2) NOT NULL,
  `log_text` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_target` (`log_target`,`log_key`,`log_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;