ALTER TABLE  `fash_product_views` ADD  `source` INT NOT NULL AFTER  `product_id` ;

ALTER TABLE  `fash_product_views` ADD INDEX (  `user` ) ;
ALTER TABLE  `fash_product_views_users` ADD INDEX (  `hasp` ) ;