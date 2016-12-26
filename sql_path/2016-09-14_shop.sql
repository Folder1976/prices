ALTER TABLE  `fash_shops` ADD  `xml_url` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `xml_name` ;


ALTER TABLE  `fash_shops` ADD  `name_sush` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `image` ;
ALTER TABLE  `fash_shops` ADD  `name_rod` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name_sush` ;
ALTER TABLE  `fash_shops` ADD  `name_several` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name_rod` ;
ALTER TABLE  `fash_shops` ADD  `title_h1` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name_several` ;
ALTER TABLE  `fash_shops` ADD  `meta_title` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `title_h1` ;
ALTER TABLE  `fash_shops` ADD  `meta_description` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `meta_title` ;
ALTER TABLE  `fash_shops` ADD  `meta_keyword` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `meta_description` ;

