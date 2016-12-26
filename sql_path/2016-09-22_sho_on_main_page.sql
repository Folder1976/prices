ALTER TABLE  `fash_shops` ADD  `on_main_page` INT( 1 ) NOT NULL AFTER  `enable` ,
ADD INDEX (  `on_main_page` ) ;