ALTER TABLE  `fash_manufacturer_description` ADD  `title_h1` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `manufacturer_id` ;

ALTER TABLE  `fash_manufacturer` ADD  `name_sush` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name` ;
ALTER TABLE  `fash_manufacturer` ADD  `name_rod` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name_sush` ;
ALTER TABLE  `fash_manufacturer` ADD  `name_several` VARCHAR( 120 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `name_rod` ;
