<?php
header("Content-Type: text/html; charset=UTF-8");
include('../../../a2_config.php');
ini_set("display_errors",1); 
//include('../config.php');

$id = 0;
if(isset($_GET['id'])) $id = $_GET['id'];

$data = array();
$filds = '';
foreach($_GET as $index => $value){
	if($index != 'id' AND $index != 'key' AND $index != 'table') {
		$data[$index] = $value;
		$filds .= "`$index` = '$value',";
	}
	
}
$filds = trim($filds, ',');

$key = 0;
if(isset($_GET['key'])) $key = $_GET['key'];
			
$table = 0;
if(isset($_GET['table'])) $table = $_GET['table'];
			
switch($key){
    case 'edit' :
        $sql = 'UPDATE '.$table.' SET '.$filds. ' WHERE id = "'.$id.'"';
        //echo $sql;           
        $mysqli->query($sql) or die('не удалось сохранить параметры '.$sql);
        
        echo 'Обновил';
    break; 
    
    case 'add' :
        $sql = 'INSERT INTO '.$table.' SET '.$filds;
           
        $mysqli->query($sql) or die('не удалось сохранить параметры '.$sql);
        
        echo 'Добавил';
    break; 
    
    case 'dell' :
        $sql = "DELETE FROM '.$table.' 
                WHERE id = '$id';
                ";
           
        $mysqli->query($sql) or die('не удалось удалить параметры '.$sql);
        
        echo 'Удалил';
    break; 
     
}



?>