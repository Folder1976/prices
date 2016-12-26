<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}

		if(isset($_GET['guide']) AND (int)$_GET['guide'] > 0){
			$sql = 'SELECT name FROM `'.DB_PREFIX.'attribute_group_description` WHERE `attribute_group_id`="'.(int)$_GET['guide'].'" LIMIT 0,1;';
			$r = $mysqli->query($sql);
			
			$filter_name = '. . .';
			if($r->num_rows > 0){
				$tmp = $r->fetch_assoc();
				$filter_name = $tmp['name'];	
			}
				
			$sql = 'SELECT A.attribute_id AS id, A.attribute_group_id AS `group`, AD.name, A.filter_name, A.sort_order AS sort, A.enable
						FROM '.DB_PREFIX.'attribute A
						LEFT JOIN '.DB_PREFIX.'attribute_description AD ON AD.attribute_id = A.attribute_id
						WHERE A.attribute_group_id="'.(int)$_GET['guide'].'" ORDER BY sort, name';
		}else{
			$sql = 'SELECT A.attribute_group_id AS id, A.attribute_group_id AS `group`, AD.name, A.sort_order AS sort, A.enable, AD.description
							FROM '.DB_PREFIX.'attribute_group A
							LEFT JOIN '.DB_PREFIX.'attribute_group_description AD ON AD.attribute_group_id = A.attribute_group_id
							ORDER BY sort_order, name';
			$filter_name = 'Фильтры';
		}
			
		$r = $mysqli->query($sql) or die('sadfg sad0j dsf '.$sql);
		
		$List = array();
		if($r->num_rows > 0){
			
			while($tmp = $r->fetch_assoc()){
				$List[$tmp['id']] = $tmp;	
			}
			
		}
		
		//Группы
		$sql = 'SELECT A.attribute_group_id AS id, AD.name, A.sort_order AS sort, A.enable
						FROM '.DB_PREFIX.'attribute_group A
						LEFT JOIN '.DB_PREFIX.'attribute_group_description AD ON AD.attribute_group_id = A.attribute_group_id
						ORDER BY sort_order, name';
		$r = $mysqli->query($sql);
		$Groups = array();
		if($r->num_rows > 0){
			
			while($tmp = $r->fetch_assoc()){
				$Groups[$tmp['id']] = $tmp['name'];	
			}
			
		}
		
		//Шаблоны
		if(isset($_GET['guide']) AND (int)$_GET['guide'] > 0){
			include ('attribute/attribute.detail.index.php');
		}else{
			include ('attribute/attribute.index.php');
		}

?>