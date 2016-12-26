<?php

include('../../config.php');
include('../config.php');
	
	$key = 'exit';
    $table = '';
    $id = '';
	$mainkey = 'id';
	$radio_name = '';
    $data = array();
	$find = array('*1*', '@*@');
	$replace = array('=', '&');
    
foreach($_POST as $index => $value){
    
    //echo '++++    '.$index.'='.$value;
 
	
    if($index == 'key'){
        $key = $value;
    }elseif($index == 'table'){
        $table = $value;
    }elseif($index == 'id'){
        $id = str_replace($find,$replace,$value);
    }elseif($index == 'mainkey'){
        $mainkey = $value;
    }elseif($index == 'radio_name'){
        $radio_name = $value;
    }else{
        $data[$index] = str_replace($find,$replace,$value);
    }
}

if($key == 'add'){
    
	$sql = "INSERT INTO " . DB_PREFIX . $table . " SET ";
			foreach($data as $index => $value){
				 $sql .= " `$index` = '$value',";		
			}
			$sql = trim($sql, ',');
	echo $sql;
	$mysqli->query($sql) or die('sad54yfljsad bf;j '.$sql);
	
}

if($key == 'set_radio'){
    
	$sql = "UPDATE " . DB_PREFIX . $table . " SET `$radio_name` = '0'";
	$mysqli->query($sql) or die('sadlkjgfljsad bf;j '.$sql);
	
//echo $sql;
	$sql = "UPDATE " . DB_PREFIX . $table . " SET `$radio_name` = '1' WHERE `$mainkey` = '" . $id . "'";
	$mysqli->query($sql) or die('sadlkjgfljsad bf;j '.$sql);
	
//echo $sql;
	
		
}

if($key == 'edit'){
    
	$sql = "UPDATE " . DB_PREFIX . $table . " SET ";
	foreach($data as $index => $value){
		 $sql .= " `$index` = '$value',";		
	}
	$sql = trim($sql, ',');
	$sql .=	" WHERE `$mainkey` = '" . $id . "'";
echo $sql;
	$mysqli->query($sql) or die('sadlkjgfljsad bf;j '.$sql);
		
}

if($key == 'dell'){
	
	$sql = "DELETE FROM " . DB_PREFIX . $table ." WHERE `$mainkey` = '" . $id . "'";
	echo $sql;
	$mysqli->query($sql) or die('sadlkjgfljsad bf;j '.$sql);
	
}

?>