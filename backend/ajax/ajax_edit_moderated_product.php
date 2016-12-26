<?php

include('../../config.php');
include('../config.php');
$pp = DB_PREFIX;

    $key = 'exit';
	if(isset($_POST['key'])) $key = $_POST['key'];
	
    $id = 0;
	if(isset($_POST['id'])) $id = $_POST['id'];

    $product_id = 0;
	if(isset($_POST['product_id'])) $product_id = $_POST['product_id'];

    $product_name = 0;
	if(isset($_POST['product_name'])) $product_name = $_POST['product_name'];
  
	$text = 0;
	if(isset($_POST['text'])) $text = $_POST['text'];

    $product_full_name = 0;
	if(isset($_POST['product_full_name'])) $product_full_name = $_POST['product_full_name'];
  
	$category = '';
	if(isset($_POST['category'])) $category = $_POST['category'];

    $shop_id = 0;
	if(isset($_POST['shop_id'])) $shop_id = $_POST['shop_id'];

	$brand_id = 0;
	if(isset($_POST['brand_id'])) $brand_id = $_POST['brand_id'];

	$category_id = 0;
	if(isset($_POST['category_id'])) $category_id = $_POST['category_id'];

	$podcategory_id = 0;
	if(isset($_POST['podcategory_id'])) $podcategory_id = $_POST['podcategory_id'];

	$filter = '0_0';
	if(isset($_POST['filter_id'])) $filter = $_POST['filter_id'];

	$check = 0;
	if(isset($_POST['check'])) $check = $_POST['check'];

	$sizes_txt = 0;
	if(isset($_POST['sizes'])) $sizes_txt = $_POST['sizes'];

	$status_id = 0;
	if(isset($_POST['status_id'])) $status_id = $_POST['status_id'];

	if($key == 'save_names'){
		$sql = 'UPDATE `'.$pp.'product_description` SET
					name = \''.$product_name.'\',
					description = \''.htmlspecialchars(trim($text), ENT_QUOTES).'\'
					WHERE product_id = "'.$product_id.'";';
		//echo $sql;
		$mysqli->query($sql) or die('Не удалось изменить статус '.$sql);
	}
	
	if($key == 'save_status'){
		$sql = 'UPDATE `'.$pp.'product` SET moderation_id = "'.$status_id.'" WHERE product_id = "'.$product_id.'";';
		$mysqli->query($sql) or die('Не удалось изменить статус '.$sql);
echo $sql;			
	}
	
	if($key == 'save_filter'){

		$tmp = explode('_', $filter);
		$filter_name = $tmp[0];
		$filter_id = $tmp[1];
		
		if($check == 0){
				
			$sql = 'DELETE FROM `'.$pp.'product_attribute` WHERE attribute_id="'.$filter_id.'" AND product_id="'.$product_id.'"'; 
			
		}else{
	
			$sql = 'INSERT INTO `'.$pp.'product_attribute` SET attribute_id="'.$filter_id.'" , product_id="'.$product_id.'"';
	
		}
		
		$r = $mysqli->query($sql) or die('Не удалось изменить фильтр '.$sql);
echo $sql;		
	}

	if($key == 'save_size'){

		$sql = 'DELETE FROM `'.$pp.'product_to_size` WHERE product_id = "'.$product_id.'";';
		$r = $mysqli->query($sql) or die('Не удалось очистить размеры '.$sql);
		
		$sizes = explode(',', $sizes_txt);
		
		foreach($sizes as $size_id){
			$sql = 'INSERT INTO `'.$pp.'product_to_size` SET
								product_id = "'.$product_id.'",
								size_id = "'.$size_id.'";';
echo $sql;				
			$r = $mysqli->query($sql) or die('Не удалось добавить размер '.$sql);
		}

	}
	
	if($key == 'save_magazin'){

		$sql = 'DELETE FROM `'.$pp.'product_to_shop` WHERE product_id = "'.$product_id.'";';
		$r = $mysqli->query($sql) or die('Не удалось очистить магазин '.$sql);
		
		$sql = 'INSERT INTO `'.$pp.'product_to_shop` SET
				product_id = "'.$product_id.'",
				shop_id = "'.$shop_id.'";';
//echo $sql;				
		$r = $mysqli->query($sql) or die('Не удалось добавить магазин '.$sql);

	}
	
	if($key == 'save_brand'){

		$sql = 'UPDATE `'.$pp.'product` SET
					manufacturer_id = "'.$brand_id.'"
				WHERE product_id = "'.$product_id.'";';
		$mysqli->query($sql) or die('Не удалось добавить магазин '.$sql);

	}

	if($key == 'save_podcategory'){

		$sql = 'DELETE FROM `'.$pp.'product2category` WHERE product_id = "'.$product_id.'";';
		$r = $mysqli->query($sql) or die('Не удалось очистить подкатегорию '.$sql);
		
		$sql = 'INSERT INTO `'.$pp.'product2category` SET
				product_id = "'.$product_id.'",
				podcategory_id = "'.$podcategory_id.'";';
//echo $sql;				
		$r = $mysqli->query($sql) or die('Не удалось добавить подкатегорию '.$sql);

	}

	if($key == 'save_category'){

		$sql = 'DELETE FROM '.$pp.'product_to_category WHERE product_id = "'.$product_id.'";';
		$r = $mysqli->query($sql) or die('Не удалось добавить категорию '.$sql);
		
		$sql = 'INSERT INTO `'.$pp.'product_to_category` SET
					category_id = "'.$category_id.'",
					product_id = "'.$product_id.'";';
		$r = $mysqli->query($sql) or die('Не удалось добавить категорию '.$sql);

	}

if($key == 'save_categories'){

		$sql = 'DELETE FROM '.$pp.'product_to_category WHERE product_id = "'.$product_id.'";';
		$r = $mysqli->query($sql) or die('Не удалось добавить категорию '.$sql);
		
		$category = trim($category, ',');
	
		$categs = explode(',', $category);
		
		if(count($categs) > 0){
			
			foreach($categs as $category_id){
				
				$sql = 'INSERT INTO `'.$pp.'product_to_category` SET
						category_id = "'.$category_id.'",
						product_id = "'.$product_id.'";';
				$r = $mysqli->query($sql) or die('Не удалось добавить категорию '.$sql);
			
			}
		
		}

	}


/*
	if($key == 'get_product'){
		$return = array();
		
		$sql = 'SELECT
						P.id,
						P.category_id,
						P.url,
						P.name,
						P.full_name,
						P.text,
						C.podcategory_id,
						S.shop_id,
						PM.front,
						PM.back,
						PM.middle,
						PM.other
						
					FROM `'.$pp.'product` P
					LEFT JOIN `'.$pp.'product2category` C ON C.product_id = P.id
					LEFT JOIN `'.$pp.'product2shop` S ON S.product_id = P.id
					LEFT JOIN `'.$pp.'product_media` PM ON PM.product_id = P.id
					WHERE P.id = "'.$id.'";';
		$r = $mysqli->query($sql) or die('Не удалось получить продукт '.$sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();

			$return['id'] = $tmp['id'];
			$return['url'] = $tmp['url'];
			$return['name'] = $tmp['name'];
			$return['full_name'] = $tmp['full_name'];
			$return['text'] = $tmp['text'];
			$return['image_front'] = $tmp['front'];
			$return['image_back'] = $tmp['back'];
			$return['image_middle'] = $tmp['middle'];
			$return['image_other'] = $tmp['other'];
			$return['shop_id'] = $tmp['shop_id'];
			$return['category_id'] = $tmp['category_id'];
			$return['podcategory_id'] = $tmp['podcategory_id'];
			$return['shop'] = array();
			$return['category'] = array();
			$return['podcategory'] = array();
			
			//Получим магазины
			$sql = 'SELECT `id`, `name` FROM `'.$pp.'shops` ORDER BY `name` ASC;';
			$r = $mysqli->query($sql) or die('Не удалось получить Магазины '.$sql);
			if($r->num_rows > 0){
				$return['shop']['0'] = 'Выбрать . . .';	
				while($tmp = $r->fetch_assoc()){
					$return['shop'][$tmp['id']] = $tmp['name'];		
				}
			}
		
			//Получим категорию
			$sql = 'SELECT `id`, `name` FROM `'.$pp.'category` ORDER BY `name` ASC;';
			$r = $mysqli->query($sql) or die('Не удалось получить Каталог '.$sql);
			if($r->num_rows > 0){
				while($tmp = $r->fetch_assoc()){
					$return['category'][$tmp['id']] = $tmp['name'];		
				}
			}
		
			//Получим подкатегорию
			$sql = 'SELECT `id`, `name` FROM `'.$pp.'podcategory` WHERE category_id = "'.$return['category_id'].'" AND parent_id = "0" ORDER BY `name` ASC;';
			$r = $mysqli->query($sql) or die('Не удалось получить Подкаталог '.$sql);
			if($r->num_rows > 0){
				while($tmp = $r->fetch_assoc()){
					$return['podcategory'][$tmp['id']]['name'] = $tmp['name'];
					$return['podcategory'][$tmp['id']]['options'] = array();
					
					$sql = 'SELECT `id`, `name` FROM `'.$pp.'podcategory` WHERE category_id = "'.$return['category_id'].'" AND parent_id = "'.$tmp['id'].'" ORDER BY `name` ASC;';
					$r2 = $mysqli->query($sql) or die('Не удалось получить Подкаталог '.$sql);
					if($r->num_rows > 0){
						while($tmp2 = $r2->fetch_assoc()){
							$return['podcategory'][$tmp['id']]['options'][$tmp2['id']] = $tmp2['name'];
						}
					}
					
				}
			}
		
			//Получим фильтры
				//Цвет
				$sql = 'SELECT C.`color_id` AS id, GC.`name`, P2C.product_id AS isset
						FROM `'.$pp.'podcat2color` C
						LEFT JOIN `'.$pp.'guidecolor` GC ON GC.id = C.color_id
						LEFT JOIN `'.$pp.'product2color` P2C ON P2C.color_id = C.color_id AND P2C.product_id = "'.$id.'"
						WHERE podcat_id = "'.$return['podcategory_id'].'" GROUP BY C.`color_id` ORDER BY `name` ASC;';
				
				$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
				if($r->num_rows > 0){
					while($tmp = $r->fetch_assoc()){
						$return['filters']['Цвет'][$tmp['id']]['name'] = $tmp['name'];
						$return['filters']['Цвет'][$tmp['id']]['filtername'] = 'color';
						if($tmp['isset']){
							$return['filters']['Цвет'][$tmp['id']]['isset'] = 1;
						}else{
							$return['filters']['Цвет'][$tmp['id']]['isset'] = 0;
						}
					}
				}
				
				//Длина
				$sql = 'SELECT C.`lenght_id` AS id, GC.`name`, P2C.product_id AS isset
						FROM `'.$pp.'podcat2lenght` C
						LEFT JOIN `'.$pp.'guidelenght` GC ON GC.id = C.lenght_id
						LEFT JOIN `'.$pp.'product2lenght` P2C ON P2C.lenght_id = C.lenght_id AND P2C.product_id = "'.$id.'"
						WHERE podcat_id = "'.$return['podcategory_id'].'" GROUP BY C.`lenght_id` ORDER BY `name` ASC;';
				$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
				if($r->num_rows > 0){
					while($tmp = $r->fetch_assoc()){
						$return['filters']['Длина'][$tmp['id']]['name'] = $tmp['name'];
						$return['filters']['Длина'][$tmp['id']]['filtername'] = 'lenght';
						if($tmp['isset']){
							$return['filters']['Длина'][$tmp['id']]['isset'] = 1;
						}else{
							$return['filters']['Длина'][$tmp['id']]['isset'] = 0;
						}
					}
				}
			
				//Материал
				$sql = 'SELECT C.`material_id` AS id, GC.`name`, P2C.product_id AS isset
						FROM `'.$pp.'podcat2material` C
						LEFT JOIN `'.$pp.'guidematerial` GC ON GC.id = C.material_id
						LEFT JOIN `'.$pp.'product2material` P2C ON P2C.material_id = C.material_id AND P2C.product_id = "'.$id.'"
						WHERE podcat_id = "'.$return['podcategory_id'].'" GROUP BY C.`material_id` ORDER BY `name` ASC;';
				$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
				if($r->num_rows > 0){
					while($tmp = $r->fetch_assoc()){
						$return['filters']['Материал'][$tmp['id']]['name'] = $tmp['name'];
						$return['filters']['Материал'][$tmp['id']]['filtername'] = 'material';
						if($tmp['isset']){
							$return['filters']['Материал'][$tmp['id']]['isset'] = 1;
						}else{
							$return['filters']['Материал'][$tmp['id']]['isset'] = 0;
						}
					}
				}
			
				//Повод
				$sql = 'SELECT C.`reason_id` AS id, GC.`name`, P2C.product_id AS isset
						FROM `'.$pp.'podcat2reason` C
						LEFT JOIN `'.$pp.'guidereason` GC ON GC.id = C.reason_id
						LEFT JOIN `'.$pp.'product2reason` P2C ON P2C.reason_id = C.reason_id AND P2C.product_id = "'.$id.'"
						WHERE podcat_id = "'.$return['podcategory_id'].'" GROUP BY C.`reason_id` ORDER BY `name` ASC;';
				$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
				if($r->num_rows > 0){
					while($tmp = $r->fetch_assoc()){
						$return['filters']['Повод'][$tmp['id']]['name'] = $tmp['name'];
						$return['filters']['Повод'][$tmp['id']]['filtername'] = 'reason';
						if($tmp['isset']){
							$return['filters']['Повод'][$tmp['id']]['isset'] = 1;
						}else{
							$return['filters']['Повод'][$tmp['id']]['isset'] = 0;
						}
					}
				}
			
				//Сезон
				$sql = 'SELECT C.`season_id` AS id, GC.`name`, P2C.product_id AS isset
						FROM `'.$pp.'podcat2season` C
						LEFT JOIN `'.$pp.'guideseason` GC ON GC.id = C.season_id
						LEFT JOIN `'.$pp.'product2season` P2C ON P2C.season_id = C.season_id AND P2C.product_id = "'.$id.'"
						WHERE podcat_id = "'.$return['podcategory_id'].'" GROUP BY C.`season_id` ORDER BY `name` ASC;';
				$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
				if($r->num_rows > 0){
					while($tmp = $r->fetch_assoc()){
						$return['filters']['Сезон'][$tmp['id']]['name'] = $tmp['name'];
						$return['filters']['Сезон'][$tmp['id']]['filtername'] = 'season';
						if($tmp['isset']){
							$return['filters']['Сезон'][$tmp['id']]['isset'] = 1;
						}else{
							$return['filters']['Сезон'][$tmp['id']]['isset'] = 0;
						}
					}
				}
			
			
				//Стиль
				$sql = 'SELECT C.`style_id` AS id, GC.`name`, P2C.product_id AS isset
						FROM `'.$pp.'podcat2style` C
						LEFT JOIN `'.$pp.'guidestyle` GC ON GC.id = C.style_id
						LEFT JOIN `'.$pp.'product2style` P2C ON P2C.style_id = C.style_id AND P2C.product_id = "'.$id.'"
						WHERE podcat_id = "'.$return['podcategory_id'].'" GROUP BY C.`style_id` ORDER BY `name` ASC;';
				$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
				if($r->num_rows > 0){
					while($tmp = $r->fetch_assoc()){
						$return['filters']['Стиль'][$tmp['id']]['name'] = $tmp['name'];
						$return['filters']['Стиль'][$tmp['id']]['filtername'] = 'style';
						if($tmp['isset']){
							$return['filters']['Стиль'][$tmp['id']]['isset'] = 1;
						}else{
							$return['filters']['Стиль'][$tmp['id']]['isset'] = 0;
						}
					}
				}
			
		
				//УНИВЕРСАЛЬНЫЙ
				$sql = 'SELECT
							GU.id AS group_id,
							GU.name AS group_name,
							GUF.id AS filter_id,
							GUF.name AS filter_name,
							P2F.product_id AS isset
						FROM `'.$pp.'podcat2filters` C
						LEFT JOIN `'.$pp.'guidesuniversal_filters` GUF1 ON GUF1.`id` = C.`filter_id`
						LEFT JOIN `'.$pp.'guidesuniversal` GU ON GU.id = GUF1.`group`
						LEFT JOIN `'.$pp.'guidesuniversal_filters` GUF ON GUF.`group` = GU.`id`
						LEFT JOIN `'.$pp.'product2filters` P2F ON GUF.`id` = P2F.`filter_id` AND P2F.product_id = "'.$id.'"
						WHERE podcat_id = "'.$return['podcategory_id'].'" AND GU.enable="1" ORDER BY GUF.`name` ASC;';
				
				//echo $sql; die();
				$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
				if($r->num_rows > 0){
					while($tmp = $r->fetch_assoc()){
						
						if($tmp['filter_id']){
							$return['filters'][$tmp['group_name']][$tmp['filter_id']]['name'] = $tmp['filter_name'];
							$return['filters'][$tmp['group_name']][$tmp['filter_id']]['filtername'] = 'filter_universal_'.$tmp['group_id'];
							if($tmp['isset']){
								$return['filters'][$tmp['group_name']][$tmp['filter_id']]['isset'] = 1;
							}else{
								$return['filters'][$tmp['group_name']][$tmp['filter_id']]['isset'] = 0;
							}
						}
					}
				}
			
			
		
			echo json_encode($return);
			return true;
		}
		
		return '';
		
	}

	if($key == 'get_podcategory'){
		$return = array();
		
		//Получим подкатегорию
		$sql = 'SELECT `id`, `name` FROM `'.$pp.'podcategory` WHERE category_id = "'.$id.'" AND parent_id = "0" ORDER BY `name` ASC;';
		$r = $mysqli->query($sql) or die('Не удалось получить Подкаталог '.$sql);
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
				$return['podcategory'][$tmp['id']]['name'] = $tmp['name'];
				$return['podcategory'][$tmp['id']]['options'] = array();
				
				$sql = 'SELECT `id`, `name` FROM `'.$pp.'podcategory` WHERE category_id = "'.$id.'" AND parent_id = "'.$tmp['id'].'" ORDER BY `name` ASC;';
				$r2 = $mysqli->query($sql) or die('Не удалось получить Подкаталог '.$sql);
				if($r->num_rows > 0){
					while($tmp2 = $r2->fetch_assoc()){
						$return['podcategory'][$tmp['id']]['options'][$tmp2['id']] = $tmp2['name'];
					}
				}
				
			}
		}
	
	
		echo json_encode($return);
		return true;
	
	}*/

?>