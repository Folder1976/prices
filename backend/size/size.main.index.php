<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}

		if(isset($_GET['guide']) AND (int)$_GET['guide'] > 0){
			$sql = 'SELECT size_id, size_id AS id, name, group_id, enable, sort FROM '.DB_PREFIX.'size WHERE group_id="'.$_GET['guide'].'" ORDER BY sort, name';
			$filter_name = 'Размеры';
		}else{
			$sql = 'SELECT * FROM '.DB_PREFIX.'size_group ORDER BY sort, name';
			$filter_name = 'Группы размеров';
		}
			
		$r = $mysqli->query($sql) or die('sadfg sad0j dsf '.$sql);
		
		$List = array();
		if($r->num_rows > 0){
			
			while($tmp = $r->fetch_assoc()){
				$List[$tmp['id']] = $tmp;	
			}
			
		}
		
		//Группы
		$sql = 'SELECT * FROM '.DB_PREFIX.'size_group ORDER BY sort, name';
		$r = $mysqli->query($sql);
		$Groups = array();
		if($r->num_rows > 0){
			
			while($tmp = $r->fetch_assoc()){
				$Groups[$tmp['id']] = $tmp['name'];	
			}
			
		}
		
		//Шаблоны
		if(isset($_GET['guide']) AND (int)$_GET['guide'] > 0){
			include ('size/size.detail.index.php');
		}else{
			include ('size/size.index.php');
		}

?>