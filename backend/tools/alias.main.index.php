<!-- Sergey Kotlyarov 2016 folder.list@gmail.com -->
<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}



set_time_limit(0);
ini_set("max_execution_time","0");
ini_set("memory_limit","-1");
error_reporting(E_ALL ^ E_DEPRECATED);

	include_once('class/alias.class.php');
	$Alias = new Alias($mysqli, DB_PREFIX);
	
	//перегенерим алиасы категорий
	$sql = 'SELECT category_id FROM `'.DB_PREFIX.'category`;';
	$r = $mysqli->query($sql) or die($sql);
	
	while($row = $r->fetch_assoc()){
		
		$category_alias = $Alias->getCategoryAlias($row['category_id']);
		$Alias->setCategoryAlias($category_alias, $row['category_id']);
		//echo '<br>'.$category_alias;	
	}
	
	//die();
	
	//Перегенерим алиасы продуктов
	$sql = 'SELECT product_id FROM `'.DB_PREFIX.'product`;';
	$r = $mysqli->query($sql) or die($sql);
	
	while($row = $r->fetch_assoc()){
		
		$product_alias = $Alias->getProductAlias($row['product_id']);
		$Alias->setProductAlias($product_alias, $row['product_id']);
		//echo '<br>'.$product_alias;	
	}
	
	echo '<h3>Обновил алиасы</h3>';
	
	
echo '<br>Готово!';
		
?>