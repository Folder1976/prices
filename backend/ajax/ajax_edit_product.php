<?php

include('../../config.php');
include('../config.php');
include '../class/product.class.php';
$Product = new Product($mysqli, DB_PREFIX);
	
	$key = 'exit';
    $table = '';
    $id = '';
	$mainkey = 'id';
    $data = array();

foreach($_POST as $index => $value){
    
    //echo '++++    '.$index.'='.$value;
    if($index == 'key'){
        $key = $value;
    }elseif($index == 'table'){
        $table = $value;
    }elseif($index == 'id' OR $index == 'product_id'){
        $id = $value;
    }elseif($index == 'mainkey'){
        $mainkey = $value;
    }else{
        $data[$index] = $value;
    }
	 
}

if($key == 'add'){
    /*
	$sql = "INSERT INTO " . DB_PREFIX . $table . " SET ";
			foreach($data as $index => $value){
				 $sql .= " `$index` = '$value',";		
			}
			$sql = trim($sql, ',');
	$mysqli->query($sql) or die('sad54yfljsad bf;j '.$sql);
	*/
}

if($key == 'edit'){
    /*
	$sql = "UPDATE " . DB_PREFIX . $table . " SET ";
	foreach($data as $index => $value){
		 $sql .= " `$index` = '$value',";		
	}
	$sql = trim($sql, ',');
	$sql .=	" WHERE `$mainkey` = '" . (int)$id . "'";
//echo $sql;
	$mysqli->query($sql) or die('sadlkjgfljsad bf;j '.$sql);
		*/
}

if($key == 'dell' AND isset($id) AND is_numeric($id)){
	
	$Product->dellProduct((int)$id);
		//$Product->dellImages();
	
}
if($key == 'dell_filters' AND isset($id) AND is_numeric($id)){

	$sql = "DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '".(int)$id."' ";
	
	$mysqli->query($sql) or die('sad54yfljsosdfhg;adbf;j '.$sql);
}

?>