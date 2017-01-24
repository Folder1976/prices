<?php

include('../../config.php');
include('../config.php');
	
	$key = $_POST['key'];
    $id = $_POST['id'];
	$fild = $_POST['fild'];
	$value = $_POST['value'];
	$lang = $_POST['lang'];
	 
    

if($key == 'baner_description'){
    
	$sql = "SELECT * FROM " . DB_PREFIX . "baner_description WHERE language_id = '".$lang."' AND baner_id = '".$id."'";
	$r = $mysqli->query($sql) or die('sad54asdfyflsadfjsad bf;j '.$sql);
	
	if($r->num_rows){
		$sql = "UPDATE " . DB_PREFIX . "baner_description SET `$fild` = '$value' WHERE language_id = '".$lang."' AND baner_id = '".$id."'";
		$mysqli->query($sql) or die('sad54asdfyflsadfjsad bf;j '.$sql);
	}else{
		$sql = "INSERT INTO " . DB_PREFIX . "baner_description SET `$fild` = '$value', language_id = '".$lang."', baner_id = '".$id."'";
		$mysqli->query($sql) or die('sad54asdfyflsadfjsad bf;j '.$sql);
	}
}


?>