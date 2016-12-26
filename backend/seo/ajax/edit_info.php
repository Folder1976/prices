<?php

include('../../../config.php');
include('../../config.php');

$pp = DB_PREFIX;

include_once('../../class/product.class.php');
$Product = new Product($mysqli, DB_PREFIX);
	
    $key = 'exit';
	if(isset($_POST['key'])) $key = $_POST['key'];
	
    $id = 0;
	if(isset($_POST['id'])) $id = $_POST['id'];


	if($key == 'dell'){
		$return = array();
		
		//Получим подкатегорию
		$sql = 'DELETE FROM `'.$pp.'alias_description` WHERE id = "'.$id.'";';
		$r = $mysqli->query($sql) or die('Не удалось удалить сео '.$sql);

		//$sql = 'DELETE FROM `'.$pp.'alias_description` WHERE id = "'.$id.'";';
		//$r = $mysqli->query($sql) or die('Не удалось удалить сео '.$sql);
//echo $sql;
		
		return true;
	
	}

?>