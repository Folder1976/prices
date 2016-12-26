<?php

include('../../config.php');
include('../config.php');
	
	$key = 'exit';
    $table = '';
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
        $data[$index] = $value;
    }
}

$attribute_id = $attribute_group_id = $id;
//echo $key;
if($key == 'edit_attr_grp'){
    
	$mysqli->query("UPDATE " . DB_PREFIX . "attribute_group
						SET
						sort_order = '" . (int)$data['sort'] . "',
						enable = '" . (int)$data['enable'] . "'
						WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");

	$mysqli->query("DELETE FROM " . DB_PREFIX . "attribute_group_description WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");

	$mysqli->query("INSERT INTO " . DB_PREFIX . "attribute_group_description
				   SET attribute_group_id = '" . (int)$attribute_group_id . "',
				   description = '" . $data['description'] . "',
				   language_id = '1', name = '" . htmlspecialchars($data['name'],ENT_QUOTES) . "'");
	
	
}

if($key == 'add_attr_grp'){
    
   	$mysqli->query("INSERT INTO " . DB_PREFIX . "attribute_group SET
						enable = '" . (int)$data['enable'] . "',
						sort_order = '" . (int)$data['sort'] . "'");

	$attribute_group_id = $mysqli->insert_id;

	$mysqli->query("INSERT INTO " . DB_PREFIX . "attribute_group_description
						SET attribute_group_id = '" . (int)$attribute_group_id . "',
						description = '" . $data['description'] . "',
						language_id = '1', name = '" . htmlspecialchars($data['name'],ENT_QUOTES) . "'");
	
}

if($key == 'dell_attr_grp'){
   	
	$mysqli->query("DELETE FROM " . DB_PREFIX . "attribute_group WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
	$mysqli->query("DELETE FROM " . DB_PREFIX . "attribute_group_description WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");

}

if($key == 'add_attr'){
    
	$mysqli->query("INSERT INTO " . DB_PREFIX . "attribute SET
					attribute_group_id = '" . (int)$data['group'] . "',
					filter_name = '" . $data['filter_name'] . "',
					enable = '" . (int)$data['enable'] . "',
					sort_order = '" . (int)$data['sort'] . "'");

	$attribute_id = $mysqli->insert_id;

	$mysqli->query("INSERT INTO " . DB_PREFIX . "attribute_description SET
						attribute_id = '" . (int)$attribute_id . "',
						language_id = '1',
						name = '" . htmlspecialchars($data['name'],ENT_QUOTES) . "'");
	
}

if($key == 'edit_attr'){
    
	$sql = "UPDATE " . DB_PREFIX . "attribute SET
						attribute_group_id = '" . (int)$data['group'] . "',
						filter_name = '" . $data['filter_name'] . "',
						`enable` = '" . (int)$data['enable'] . "',
						sort_order = '" . (int)$data['sort'] . "' WHERE attribute_id = '" . (int)$attribute_id . "'";
	//echo $sql;
	$mysqli->query($sql);

	$mysqli->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

	$mysqli->query("INSERT INTO " . DB_PREFIX . "attribute_description SET
						attribute_id = '" . (int)$attribute_id . "',
						language_id = '1',
						name = '" . htmlspecialchars($data['name'], ENT_QUOTES) . "'");
		
}

if($key == 'dell_attr'){
	
	$mysqli->query("DELETE FROM " . DB_PREFIX . "attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
	$mysqli->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

}

?>