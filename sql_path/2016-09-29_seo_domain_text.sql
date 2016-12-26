INSERT INTO  `fash_seo_tpl` (
`seo_tpl_id` ,
`target` ,
`value` ,
`memo`
)
VALUES (
NULL ,  'domain_text1',  '',  'Сео текст для поддоменов'
);

ALTER TABLE  `fash_seo_tpl` CHANGE  `value`  `value` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ;