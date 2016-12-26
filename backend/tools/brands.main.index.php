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


	//Убираем бренды дубляжи
	$brand = '';

	$sql = 'select query, keyword FROM `'.DB_PREFIX.'url_alias` WHERE query LIKE "manufacturer_id=%"';
	$r = $mysqli->query($sql) or die($sql);
	$manufs_ids = array();
	while($row = $r->fetch_assoc()){
		$manufs_ids[str_replace('manufacturer_id=','',$row['query'])] = $row['keyword'];
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
		
		
		//echo $main_id. ' === '. implode(',', $values);
		
		$sql = 'UPDATE  `'.DB_PREFIX.'product` SET  manufacturer_id = "'.$main_id.'" WHERE manufacturer_id IN ('.implode(',', $values).');';
		//echo '<br>'.$sql;
		$mysqli->query($sql) or die($sql);
		$sql = 'DELETE FROM `'.DB_PREFIX.'manufacturer` WHERE manufacturer_id IN ('.implode(',', $values).');';
		//echo '<br>'.$sql;
		$mysqli->query($sql) or die($sql);
		$sql = 'DELETE FROM `'.DB_PREFIX.'manufacturer_description` WHERE manufacturer_id IN ('.implode(',', $values).');';
		//echo '<br>'.$sql;
		$mysqli->query($sql) or die($sql);
		$sql = 'DELETE FROM `'.DB_PREFIX.'manufacturer_to_store` WHERE manufacturer_id IN ('.implode(',', $values).');';
		//echo '<br>'.$sql;
		$mysqli->query($sql) or die($sql);
		
		
		echo '<br>'.$manufs_ids[$main_id]. ' => ' . count($values);
		//die();
		
	}
		
echo '<br>Готово!';
		
?>