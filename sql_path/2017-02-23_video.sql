ALTER TABLE  `fash_product_videos` ADD  `chanel` VARCHAR( 70 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `product_id` ;
ALTER TABLE  `fash_product_videos` ADD  `title` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `chanel` ;
ALTER TABLE  `fash_product_videos` ADD  `time` VARCHAR( 7 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER  `title` ;