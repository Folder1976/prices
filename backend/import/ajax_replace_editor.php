<?php
include('../../config.php');
include('../config.php');

    $key = 'exit';
    $table = '';
    $pp = DB_PREFIX;
    $id = '';
    $data = array();
    
foreach($_POST as $index => $value){
    
    //echo ' '.$index.'='.$value;
    
    if($index == 'key'){
        $key = $value;
    }elseif($index == 'table'){
        $table = $value;
    }elseif($index == 'id'){
        $id = $value;
    }else{
		$value = str_replace('@@@@', '&', $value);
		$value = str_replace('@##@', '\\', $value);
        $data[$index] = $value;
    }
}


if($key == 'edit'){
    
    $sql = 'UPDATE `'.$table.'` SET ';
        foreach($data as $fild => $value){
            $sql .= ' `'.$fild.'`=\''.str_replace("'",'&#39;', $value).'\',';
        }
	$sql = trim($sql,',');
	$sql .= ' WHERE id = \''.$id.'\'';
    
    //echo $sql;
    $mysqli->query($sql) or die('ajax_replace_editor.php '.$sql);
}

if($key == 'add'){
    
    $sql = 'INSERT INTO `'.$table.'` SET ';
        foreach($data as $fild => $value){
            $sql .= ' `'.$fild.'`=\''.str_replace("'",'&#39;', $value).'\',';
        }
    $sql = trim($sql,',');
    
    echo $sql;
    $mysqli->query($sql) or die('ajax_replace_editor.php '.$sql);
	
	echo $mysqli->insert_id;
}

if($key == 'dell'){
    
    $sql = 'DELETE FROM `'.$table.'` WHERE id = \''.$id.'\';';
        
    //echo $sql;
    $mysqli->query($sql) or die('ajax_replace_editor.php '.$sql);
}

if($key == 'get_shop'){
    
    $sql = 'SELECT * FROM `'.$pp.'shops` WHERE id = \''.$id.'\';';
	
    $r = $mysqli->query($sql) or die('ajax_replace_editor.php '.$sql);
	
	if($r->num_rows > 0){
		$return = array();
		$tmp = $r->fetch_assoc();
		$return['id'] = $tmp['id'];
		$return['name'] = $tmp['name'];
		$return['xml_name'] = $tmp['xml_name'];
		$return['enable'] = $tmp['enable'];
		$return['sort'] = $tmp['sort'];
		$return['modul'] = $tmp['modul'];
		$return['xml_url'] = $tmp['xml_url'];
	
		echo json_encode($return);
	}
	
}



?>