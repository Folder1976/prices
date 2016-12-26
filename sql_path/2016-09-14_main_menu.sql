ALTER TABLE  `fash_user_moduls_spis` ADD  `modul_submenu` INT NOT NULL AFTER  `modul_group_id` ;
INSERT INTO  `fash_user_moduls_spis` (
`ua_modul_id` ,
`ua_modul_nazv` ,
`ua_modul_dir` ,
`ua_modul_sqlpref` ,
`ua_modul_mfile` ,
`ua_modul_icon` ,
`modul_group_id` ,
`modul_submenu` ,
`modul_city` ,
`modul_sort` ,
`is_show`
)
VALUES (
NULL ,  'Работа с СЕО',  'seo',  '',  '',  'index.seo.png',  '2',  '0',  '1',  '3',  '1'
);
UPDATE  `fash_user_moduls_spis` SET  `modul_submenu` =  '72' WHERE  `fash_user_moduls_spis`.`ua_modul_id` =9;
UPDATE  `fash_user_moduls_spis` SET  `modul_submenu` =  '72' WHERE  `fash_user_moduls_spis`.`ua_modul_id` =71;
INSERT INTO  `fash_user_moduls_spis` (
`ua_modul_id` ,
`ua_modul_nazv` ,
`ua_modul_dir` ,
`ua_modul_sqlpref` ,
`ua_modul_mfile` ,
`ua_modul_icon` ,
`modul_group_id` ,
`modul_submenu` ,
`modul_city` ,
`modul_sort` ,
`is_show`
)
VALUES (
NULL ,  'Импорт/экспорт тегов для заголовков',  'seo',  '',  '',  'seo_tags.index.php',  '2',  '72',  '1',  '3',  '1'
);