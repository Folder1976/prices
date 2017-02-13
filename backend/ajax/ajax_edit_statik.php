<?php

include('../../config.php');
include('../config.php');
	
	$key = $_POST['key'];
    $id = $_POST['id'];
	if(isset($_POST['id_name'])) $id_name = $_POST['id_name'];
	$fild = $_POST['fild'];
	$value = $_POST['value'];
	$lang = $_POST['lang'];
	 
    

if($key == 'baner_description'){
    
	$sql = "SELECT * FROM " . DB_PREFIX . $key." WHERE language_id = '".$lang."' AND baner_id = '".$id."'";
	$r = $mysqli->query($sql) or die('sad54asdfyflsadfjsad bf;j '.$sql);
	
	if($r->num_rows){
		$sql = "UPDATE " . DB_PREFIX . $key . " SET `$fild` = '$value' WHERE language_id = '".$lang."' AND baner_id = '".$id."'";
		$mysqli->query($sql) or die('sad54asdfyflsadfjsad bf;j '.$sql);
	}else{
		$sql = "INSERT INTO " . DB_PREFIX . $key . " SET `$fild` = '$value', language_id = '".$lang."', baner_id = '".$id."'";
		$mysqli->query($sql) or die('sad54asdfyflsadfjsad bf;j '.$sql);
	}
}else{
	
	
	$sql = "SELECT * FROM " . DB_PREFIX . $key." WHERE language_id = '".$lang."' AND `$id_name` = '".$id."'";
	$r = $mysqli->query($sql) or die('sad54asdfyflsadfjsad bf;j '.$sql);
	
	if($r->num_rows){
		$sql = "UPDATE " . DB_PREFIX . $key . " SET `$fild` = '$value' WHERE language_id = '".$lang."' AND `$id_name` = '".$id."'";
		$mysqli->query($sql) or die('sad54asdfyflsadfjsad bf;j '.$sql);
	}else{
		$sql = "INSERT INTO " . DB_PREFIX . $key . " SET `$fild` = '$value', language_id = '".$lang."', `$id_name` = '".$id."'";
		$mysqli->query($sql) or die('sad54asdfyflsadfjsad bf;j '.$sql);
	}

	echo $sql;
	
}


?>