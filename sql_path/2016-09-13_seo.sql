INSERT INTO `fash_user_moduls_spis` (
`ua_modul_id` ,
`ua_modul_nazv` ,
`ua_modul_dir` ,
`ua_modul_sqlpref` ,
`ua_modul_mfile` ,
`ua_modul_icon` ,
`modul_group_id` ,
`modul_city` ,
`modul_sort` ,
`is_show`
)
VALUES (
NULL ,  'Шаблоны СЕО',  'seo',  '',  'seo_tpl.index.php',  'index.seo.png',  '2',  '1',  '3',  '1'
);

CREATE TABLE IF NOT EXISTS `fash_seo_tpl` (
  `seo_tpl_id` int(11) NOT NULL AUTO_INCREMENT,
  `target` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` varchar(512) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`seo_tpl_id`),
  KEY `target` (`target`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `fash_seo_tpl`
--

INSERT INTO `fash_seo_tpl` (`seo_tpl_id`, `target`, `value`) VALUES
(1, 'title', ''),
(2, 'title_h1', ''),
(3, 'meta_description', ''),
(4, 'meta_keywords', ''),
(5, 'domain_title', ''),
(6, 'domain_title_h1', ''),
(7, 'domain_meta_description', ''),
(8, 'domain_meta_keywords', '');

ALTER TABLE  `fash_seo_tpl` ADD  `memo` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `value` ;
UPDATE  `fash_seo_tpl` SET  `memo` =  'Тайтл' WHERE  `fash_seo_tpl`.`seo_tpl_id` =1;
UPDATE  `fash_seo_tpl` SET  `memo` =  'Тайтл Н1' WHERE  `fash_seo_tpl`.`seo_tpl_id` =2;
UPDATE  `fash_seo_tpl` SET  `memo` =  'Мета-тег Description' WHERE  `fash_seo_tpl`.`seo_tpl_id` =3;
UPDATE  `fash_seo_tpl` SET  `memo` =  'Мета-тег Keywords' WHERE  `fash_seo_tpl`.`seo_tpl_id` =4;
UPDATE  `fash_seo_tpl` SET  `memo` =  'Мета-тег Keywords (для поддоменов. Оставьте пустым если не хотите применять)' WHERE  `fash_seo_tpl`.`seo_tpl_id` =8;
UPDATE  `fash_seo_tpl` SET  `memo` =  'Мета-тег Description (для поддоменов. Оставьте пустым если не хотите применять)' WHERE  `fash_seo_tpl`.`seo_tpl_id` =7;
UPDATE  `fash_seo_tpl` SET  `memo` =  'Тайт Н1 (для поддоменов. Оставьте пустым если не хотите применять)' WHERE  `fash_seo_tpl`.`seo_tpl_id` =6;
UPDATE  `fash_seo_tpl` SET  `memo` =  'Тайт (для поддоменов. Оставьте пустым если не хотите применять)' WHERE  `fash_seo_tpl`.`seo_tpl_id` =5;


