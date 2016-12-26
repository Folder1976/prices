ALTER TABLE  `fash_product_attribute` ADD  `value` INT NOT NULL AFTER  `text` ,
ADD INDEX (  `value` ) ;

ALTER TABLE  `fash_product` ADD  `sale` FLOAT NOT NULL AFTER  `old_price` ,
ADD INDEX (  `sale` ) ;