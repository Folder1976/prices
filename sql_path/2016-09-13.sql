ALTER TABLE  `fash_alias_description` ADD  `name_sush` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name` ;
ALTER TABLE  `fash_alias_description` ADD  `name_rod` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name_sush` ;
ALTER TABLE  `fash_alias_description` ADD  `name_several` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name_rod` ;

ALTER TABLE  `fash_category_description` ADD  `name_sush` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name` ;
ALTER TABLE  `fash_category_description` ADD  `name_rod` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name_sush` ;
ALTER TABLE  `fash_category_description` ADD  `name_several` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name_rod` ;

