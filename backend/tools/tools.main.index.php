<!-- Sergey Kotlyarov 2016 folder.list@gmail.com -->
<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}



set_time_limit(0);
ini_set("max_execution_time","0");
ini_set("memory_limit","256G");
error_reporting(E_ALL ^ E_DEPRECATED);

die('Только для разработчика!');
//Чистка описаний по алиасам от дубляжей
	$sql = 'select id, url FROM `'.DB_PREFIX.'alias_description`';
	$r = $mysqli->query($sql) or die($sql);
	$manufs_ids = array();
	while($row = $r->fetch_assoc()){
		
		$sql = 'select id FROM `'.DB_PREFIX.'alias_description_domain` WHERE id = "'.$row['id'].'"';
		$r1 = $mysqli->query($sql) or die($sql);
		
		if($r1->num_rows == 0){
			
			$sql = 'select id FROM `'.DB_PREFIX.'alias_description` WHERE url = "'.$row['url'].'"';
			$r2 = $mysqli->query($sql) or die($sql);
			
			if($r2->num_rows > 1){
				
				$sql = 'DELETE FROM `'.DB_PREFIX.'alias_description` WHERE id = "'.$row['id'].'"';
				echo '<br>'.$r2->num_rows.' '.$row['url'].'  '.$sql;
				$mysqli->query($sql) or die($sql);
				
			}
			
		}else{
			
			$sql = 'select id FROM `'.DB_PREFIX.'alias_description` WHERE url = "'.$row['url'].'"';
			$r2 = $mysqli->query($sql) or die($sql);
			
			if($r2->num_rows > 1){
				
				$sql = 'DELETE FROM `'.DB_PREFIX.'alias_description` WHERE id = "'.$row['id'].'"';
				//echo '<br>'.$r2->num_rows.' '.$row['url'].'  '.$sql;
				$mysqli->query($sql) or die($sql);
				$sql = 'DELETE FROM `'.DB_PREFIX.'alias_description_domain` WHERE id = "'.$row['id'].'"';
				//echo '<br>'.$r2->num_rows.' '.$row['url'].'  '.$sql;
				$mysqli->query($sql) or die($sql);
				
			}
			
		}
	}	



die('Только для разработчика!');
	//Убираем бренды дубляжи
	$brand = '';

	$sql = 'select query FROM `'.DB_PREFIX.'url_alias` WHERE query LIKE "manufacturer_id=%"';
	$r = $mysqli->query($sql) or die($sql);
	$manufs_ids = array();
	while($row = $r->fetch_assoc()){
		$manufs_ids[str_replace('manufacturer_id=','',$row['query'])] = str_replace('manufacturer_id=','',$row['query']);
	}	

	$sql = 'SELECT manufacturer_id, name FROM `'.DB_PREFIX.'manufacturer`;';
	$r = $mysqli->query($sql) or die($sql);
	$manufs = array();
	while($row = $r->fetch_assoc()){
		$manufs[$row['name']][] = $row['manufacturer_id'];
	}	

	//Почистим от нормальных
	foreach($manufs as $index => $value){
		if(count($value) > 1){
		
		}else{
			unset($manufs[$index]);
		}
	}
	
	//Переносим товары и удаляем пустышшки брендов
	foreach($manufs as $index => $values){
		
		$main_id = 0;
		foreach($values as $i=>$value){
			if(isset($manufs_ids[$value])){
				$main_id = $value;
				unset($values[$i]);
				break;
			}
		}
		
		
		echo $main_id. ' === '. implode(',', $values);
		
		$sql = 'UPDATE  `'.DB_PREFIX.'product` SET  manufacturer_id = "'.$main_id.'" WHERE manufacturer_id IN ('.implode(',', $values).');';
		echo '<br>'.$sql;
		//$mysqli->query($sql) or die($sql);
		$sql = 'DELETE FROM `'.DB_PREFIX.'manufacturer` WHERE manufacturer_id IN ('.implode(',', $values).');';
		echo '<br>'.$sql;
		//$mysqli->query($sql) or die($sql);
		$sql = 'DELETE FROM `'.DB_PREFIX.'manufacturer_description` WHERE manufacturer_id IN ('.implode(',', $values).');';
		echo '<br>'.$sql;
		//$mysqli->query($sql) or die($sql);
		$sql = 'DELETE FROM `'.DB_PREFIX.'manufacturer_to_store` WHERE manufacturer_id IN ('.implode(',', $values).');';
		echo '<br>'.$sql;
		//$mysqli->query($sql) or die($sql);
		
		
		
		die();
		
	}
		

die('Только для разработчика!');
//Делим большйо фаил
$dir = 'tmp/';
$f = '/var/www/fashion/backend/import/111/wildberries-ru_products_20161007_132243.xml';            // yназания файла базы 
$lines = file($f); 

$fc = 1; 

$lc = 200; // по сколько строк в файле 

$data = array();

$items = 0;

$fp = fopen($dir."file_".$fc.".txt", "a"); 
//for ($i=0; $i<count($lines); $i++){ 
for ($i=0; $i<100; $i++){
	
	if(strpos($lines[$i], '<?xml') !== false) $data[0] = $lines[$i];
	if(strpos($lines[$i], '<yml_catalog') !== false) $data[1] = $lines[$i];
	if(strpos($lines[$i], '<company') !== false) $data[2] = $lines[$i];
	
	fwrite($fp, $lines[$i]); 
	
	if(strpos($lines[$i], '</offer>') !== false) $items++;
	
	if (($i/$lc==floor($i/$lc) and $i!=0) OR $items > 10){
		fwrite($fp, '</offers>'); 
		fclose($fp);
		
		$items = 0;
		$fc += 1; 
		die('1111');
		$fp = fopen($dir."file_".$fc.".txt", "a");
		fwrite($fp, $data[0]);
		fwrite($fp, $data[1]);
		fwrite($fp, $data[2]); 
		
	}
	
} 
fclose($fp); 

	die('Только для разработчика!');
//Востановление Индекса скидок
	$sql = 'SELECT * FROM fash_category_description
					LEFT JOIN fash_url_alias ON query = CONCAT("category_id=", category_id)';
	$r = $mysqli->query($sql) or die($sql);

	while($row = $r->fetch_assoc()){

		$sql = 'INSERT INTO fash_alias_description SET 
					`name` = "'.$row['name'].'",
					`name_sush` = "'.$row['name_sush'].'",
					`name_rod` = "'.$row['name_rod'].'",
					`name_several` = "'.$row['name_several'].'",
					`date_edited` = "'.date('Y-m-d').'",
					`title` = "'.$row['meta_title'].'",
					`title_h1` = "'.$row['title_h1'].'",
					`url` = "'.$row['keyword'].'",
					`category_id` = "'.$row['category_id'].'",
					`section_id` = "0",
					`is_best` = "0",
					`text1` = \''.$row['meta_description'].'\',
					`text2` = \''.$row['description'].'\'
					ON DUPLICATE KEY UPDATE `text1` = \''.$row['meta_description'].'\'
					;';
		
		//echo '<br>'.$sql;
		$mysqli->query($sql) or die($sql);
		
		$sql = 'INSERT INTO fash_alias_description_domain SET 
					`title` = "'.$row['meta_title'].'",
					`title_h1` = "'.$row['title_h1'].'",
					`is_best` = "0",
					`text1` = \''.$row['meta_description'].'\',
					`text2` = \''.$row['description'].'\'
					ON DUPLICATE KEY UPDATE `text1` = \''.$row['meta_description'].'\'
					;';
		
		//echo '<br>'.$sql;
		$mysqli->query($sql) or die($sql);
		
	}	

		$sql = 'UPDATE fash_category_description_domain SET 
					`name_sush` = "",
					`name_rod` = "",
					`name_several` = "",
					`title_h1` = "",
					`description` = "",
					`meta_title` = "",
					`meta_description` = "",
					`meta_keyword` = ""
					;';
		
		//echo '<br>'.$sql;
		$mysqli->query($sql) or die($sql);
		
		$sql = 'UPDATE fash_category_description SET 
					`title_h1` = "",
					`description` = "",
					`meta_title` = "",
					`meta_description` = "",
					`meta_keyword` = ""
					;';
		
		//echo '<br>'.$sql;
		$mysqli->query($sql) or die($sql);
		

	
	die('22222');


//Востановление Индекса скидок
	$sql = 'SELECT product_id, price, old_price FROM fash_product';
	$r = $mysqli->query($sql) or die($sql);

	while($row = $r->fetch_assoc()){

		if($row['old_price'] > 0 AND $row['old_price'] > $row['price']) {
			$sale = (100 - ((int)$row['price'] / ((int)$row['old_price'] / 100)));
			
			$sql = 'UPDATE fash_product SET sale = "'.$sale.'" WHERE product_id="'.(int)$row['product_id'].'"';
			//echo '<br>'.$sql;
			$mysqli->query($sql) or die($sql);
			
		}

	}	

	die('22222');

//Востановление описания из резерва
	$sql = 'SELECT id, text2 FROM fash_alias_description_2016_09_14';
	$r = $mysqli->query($sql) or die($sql);

	while($row = $r->fetch_assoc()){

		$sql = 'UPDATE fash_alias_description SET text2 = "'.$row['text2'].'" WHERE id="'.(int)$row['id'].'"';
		$mysqli->query($sql) or die($sql);

		$sql = 'UPDATE fash_alias_description_domain SET text2 = "'.$row['text2'].'" WHERE id="'.(int)$row['id'].'"';
		$mysqli->query($sql) or die($sql);

	}	

	die('1111');

/*
	$sql = 'SELECT product_id FROM fash_product WHERE manufacturer_id IN (184, 166, 178)';
	$r = $mysqli->query($sql) or die($sql);
	
	$product_ids = array();
	while($row = $r->fetch_assoc()){
		
		$product_ids[] = $row['product_id'];
	}	
	
	$sql = 'UPDATE fash_product_to_size SET size_id = 2 WHERE size_id=35 AND product_id IN ('.implode(',', $product_ids).')';
	$mysqli->query($sql) or die($sql);
	
	$sql = 'UPDATE fash_product_to_size SET size_id = 3 WHERE size_id=32 AND product_id IN ('.implode(',', $product_ids).')';
	$mysqli->query($sql) or die($sql);
	
	$sql = 'UPDATE fash_product_to_size SET size_id = 4 WHERE size_id=33 AND product_id IN ('.implode(',', $product_ids).')';
	$mysqli->query($sql) or die($sql);
	
	$sql = 'UPDATE fash_product_to_size SET size_id = 5 WHERE size_id=34 AND product_id IN ('.implode(',', $product_ids).')';
	$mysqli->query($sql) or die($sql);
	
	$sql = 'UPDATE fash_product_to_size SET size_id = 6 WHERE size_id=17 AND product_id IN ('.implode(',', $product_ids).')';
	$mysqli->query($sql) or die($sql);
	
	$sql = 'UPDATE fash_product_to_size SET size_id = 7 WHERE size_id=18 AND product_id IN ('.implode(',', $product_ids).')';
	$mysqli->query($sql) or die($sql);
	
	$sql = 'UPDATE fash_product_to_size SET size_id = 28 WHERE size_id=19 AND product_id IN ('.implode(',', $product_ids).')';
	$mysqli->query($sql) or die($sql);
		
	echo 'OK';
*/

$c = 28;
	
	$sql = 'SELECT P.category_id, PD.name FROM fash_product_to_category P LEFT JOIN fash_category_description PD ON PD.category_id = P.category_id';
	$r = $mysqli->query($sql) or die($sql);

	$categs = array();
	while($row = $r->fetch_assoc()){
		$categs[$row['category_id']] = $row['name'];
	}
	
	
	$sql = 'SELECT P.product_id, P.category_id, PD.name FROM fash_product_to_category P LEFT JOIN fash_product_description PD ON PD.product_id = P.product_id WHERE category_id IN ('.$c.')';
	$r = $mysqli->query($sql) or die($sql);

	$product_ids = array();
	while($row = $r->fetch_assoc()){
		
		$sql = 'SELECT category_id FROM fash_product_to_category_tmp WHERE product_id = "'.$row['product_id'].'"';
		
		$r1 = $mysqli->query($sql) or die($sql);
		$row1 = $r1->fetch_assoc();
		$categ_id = $row1['category_id'];
		
		if($row1['category_id'] != $row['category_id'] AND isset($categs[$categ_id])){
			echo '<br>'.$row['name'].'->'.$categs[$categ_id];
			
			if(isset($categs[$categ_id])){
				$sql = 'UPDATE fash_product_to_category SET category_id="'.$categ_id.'" WHERE product_id="'.$row['product_id'].'" AND category_id="'.$c.'";';
				//echo '<br>'.$sql;
				//$mysqli->query($sql) or die($sql);
			}
			
		}
		
	}
	
	
?>