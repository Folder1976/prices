ALTER TABLE  `fash_citys` ADD  `Region` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `CityLableChego` ;

ALTER TABLE  `fash_citys` ADD  `poRegionu` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `Region` ;

ALTER TABLE  `fash_citys` ADD  `ChegoRegiona` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `poRegionu` ;
ALTER TABLE  `fash_citys` ADD  `People` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `ChegoRegiona` ;
ALTER TABLE  `fash_citys` ADD  `LitlleCity` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `People` ;
ALTER TABLE  `fash_citys` ADD  `KodGoroda` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `LitlleCity` ;
ALTER TABLE  `fash_citys` ADD  `Population` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `KodGoroda` ;
