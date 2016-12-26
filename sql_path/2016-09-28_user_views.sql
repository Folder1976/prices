ALTER TABLE  `fash_product_views_users` ADD  `customer_id` INT NOT NULL AFTER  `id` ,
ADD INDEX (  `customer_id` ) ;

ALTER TABLE  `fash_product_views` ADD  `customer_id` INT NOT NULL AFTER  `id` ,
ADD INDEX (  `customer_id` ) ;

ALTER TABLE  `fash_product_loved` ADD  `customer_id` INT NOT NULL AFTER  `id` ,
ADD INDEX (  `customer_id` ) ;