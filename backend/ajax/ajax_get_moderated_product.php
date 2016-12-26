<?php

include('../../config.php');
include('../config.php');



$pp = DB_PREFIX;

include_once('../class/product.class.php');
$Product = new Product($mysqli, DB_PREFIX);
	
include_once('../class/alias.class.php');
$Alias = new Alias($mysqli, DB_PREFIX);
	
    $key = 'exit';
	if(isset($_POST['key'])) $key = $_POST['key'];
	
    $id = 0;
	if(isset($_POST['id'])) $id = $_POST['id'];

//==================================================
//$id=5068;
//$key='get_product';
//==================================================
	

	if($key == 'get_product' OR $key == 'get_product_all'){
		$return = array();
		
		$product = $Product->getProduct($id);
		$alias = $Alias->getProductAlias($id);
		
		
		//header("Content-Type: text/html; charset=UTF-8");
		//echo "<pre>";  print_r(var_dump( $alias )); echo "</pre>";
		
		
		if($product){
		
			$return['id'] = $product['product_id'];
			$return['url'] = $alias;
			$return['origin_url'] = $product['original_url'];
			$return['name'] = $product['name'];
			$return['cost'] = number_format($product['price'], '2', '.', ' ');
			$return['real_cost'] = number_format($product['sale'], '2', '.', ' ').' %';
			$return['old_cost'] = number_format($product['old_price'], '2', '.', ' ');
			$return['is_hidden'] = $product['moderation_id'];
			$return['full_name'] = $product['name'];
			$return['text'] = htmlspecialchars_decode($product['description']);
			$return['images'][0] = $product['image'];
			foreach($product['images'] as $image){
				$return['images'][] = $image;
			}
			$return['shop_id'] = $product['shop_id'];
			$return['brand_id'] = $product['manufacturer_id'];
			$return['category_id'] = $product['category_id'];
			$return['shop'] = array();
			$return['category'] = array();
			$return['podcategory'] = array();
			
			//Получим магазины
			$sql = 'SELECT `id`, `name` FROM `'.$pp.'shops` WHERE `enable`="1" ORDER BY `name` ASC;';
			$r = $mysqli->query($sql) or die('Не удалось получить Магазины '.$sql);
			if($r->num_rows > 0){
				$return['shop']['0'] = 'Выбрать . . .';	
				while($tmp = $r->fetch_assoc()){
					$return['shop'][$tmp['id']] = $tmp['name'];		
				}
			}
		
			//Получим бренды
			$sql = 'SELECT `manufacturer_id`, `name` FROM `'.$pp.'manufacturer` ORDER BY `name` ASC;';
			$r = $mysqli->query($sql) or die('Не удалось получить Бренды '.$sql);
			if($r->num_rows > 0){
				$return['brand']['0'] = 'Выбрать . . .';	
				while($tmp = $r->fetch_assoc()){
					$return['brand'][$tmp['manufacturer_id']] = $tmp['name'];		
				}
			}
		
			//Получим категорию
			$sql = 'SELECT `category_id`, `name` FROM `'.$pp.'category_description` ORDER BY `name` ASC;';
			$r = $mysqli->query($sql) or die('Не удалось получить Каталог '.$sql);
			if($r->num_rows > 0){
				while($tmp = $r->fetch_assoc()){
					$return['category'][$tmp['category_id']] = $tmp['name'];		
				}
			}
		
			//Получим размер
			$sql = 'SELECT GS.`name`, SG.id AS group_id
					FROM `'.$pp.'product_to_size` P2S
					LEFT JOIN `'.$pp.'size` GS ON P2S.size_id = GS.size_id
					LEFT JOIN `'.$pp.'size_group` SG ON SG.id = GS.group_id
					WHERE P2S.product_id = "'.$id.'"
					ORDER BY GS.`sort`, GS.`name` ASC;';
			$r = $mysqli->query($sql) or die('Не удалось получить Размеры '.$sql);
			$return['size'] = array();
			if($r->num_rows > 0){
				while($tmp = $r->fetch_assoc()){
					if($tmp['name']){
						$return['size'][] = $tmp['name'];
						$return['size_group_id'] = $tmp['group_id'];
					}
				}
			}
			
			//Создадим массив альтернативных рамеров
			$sql = 'SELECT id, name	FROM `'.$pp.'size_group` WHERE `enable` = "1" ORDER BY `sort`, `name`';
			$r = $mysqli->query($sql) or die('Не удалось получить Группы Размеры '.$sql);
			if($r->num_rows > 0){
				$return['alternative_size'] = array();
				while($tmp = $r->fetch_assoc()){
					
					if(isset($return['size'])){
						$sql = 'SELECT size_id, name FROM `'.$pp.'size` WHERE group_id = "'.$tmp['id'].'" AND name IN ("'.implode('","', $return['size']).'") AND `enable` = "1" ORDER BY `sort`, `name`';
						$r1 = $mysqli->query($sql) or die('Не удалось получить Альтернативные Размеры '.$sql);
						if($r1->num_rows > 0){
							
							while($tmp2 = $r1->fetch_assoc()){
							
								$return['alternative_size'][$tmp['id']]['id'] = $tmp['id'];
								$return['alternative_size'][$tmp['id']]['name'] = $tmp['name'];
								
								if(!isset($return['alternative_size'][$tmp['id']]['sizes_id'])){
								
									$return['alternative_size'][$tmp['id']]['sizes_id'] = $tmp2['size_id'].',';
									$return['alternative_size'][$tmp['id']]['sizes_name'] = $tmp2['name'].',';
								
								}else{
								
									$return['alternative_size'][$tmp['id']]['sizes_id'] .= $tmp2['size_id'].',';
									$return['alternative_size'][$tmp['id']]['sizes_name'] .= $tmp2['name'].',';	
								
								}
								
							
							}
	
						}
					}
					
				}
				
				foreach($return['alternative_size'] as $index => $value){
					$return['alternative_size'][$index]['sizes_id'] = trim($return['alternative_size'][$index]['sizes_id'], ',');
					$return['alternative_size'][$index]['sizes_name'] = trim($return['alternative_size'][$index]['sizes_name'], ',');
					
					if($index == $return['size_group_id']){
						$return['size_list_id'] = $return['alternative_size'][$index]['sizes_id'];
					}
				}
				
			}
			
				//Получим все категории продукта
				$sql = "SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id='".(int)$product['product_id']."';";
				$r = $mysqli->query($sql);
				$caters = array();
				$categ_html = '';
				if($r->num_rows > 0){
					while($tmp = $r->fetch_assoc()){
						$caters[$tmp['category_id']] = $tmp['category_id'];
						
						$sql = "SELECT DISTINCT *,
							(SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;')
									FROM " . DB_PREFIX . "category_path cp
									LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id)
									WHERE cp.category_id = c.category_id GROUP BY cp.category_id) AS path,
							(SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias
									WHERE query = 'category_id=" . (int)$tmp['category_id'] . "') AS keyword
							FROM " . DB_PREFIX . "category c
									LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id)
									WHERE c.category_id = '" . (int)$tmp['category_id'] . "'";
									
						$r1 = $mysqli->query($sql);
						$row = $r1->fetch_assoc();
						$categ_html .= $row['path'].'<br>';
					}
				}
				
				$return['categ_html'] =  '<span style="font-size:12px;"><a href="javascript:;" class="select_category">'.trim($categ_html, '<br>').'</a></span>';
			
				//Получим список всех атрибутов для этих категорий
				if(count($caters)){
					//УНИВЕРСАЛЬНЫЙ 
					$sql = 'SELECT attribute_id FROM `'.$pp.'category_to_attribute` WHERE category_id IN ('.implode(',', $caters).');';
					$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
					if($r->num_rows > 0){
						while($tmp = $r->fetch_assoc()){
							$filter_ids[] = $tmp['attribute_id'];
						}
					}
					//Добавим все фильтры из Системы
					$sql = 'SELECT attribute_id FROM `'.$pp.'attribute` WHERE attribute_group_id = 0;';
					$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
					if($r->num_rows > 0){
						while($tmp = $r->fetch_assoc()){
							$filter_ids[] = $tmp['attribute_id'];
						}
					}
					
				}
			
				//Получим детальную инфу по этим Атрибутам
				if(isset($filter_ids) AND count($filter_ids) > 0){
					$sql = 'SELECT
								AGD.attribute_group_id AS group_id,
								AGD.name AS group_name,
								A.attribute_id AS filter_id,
								AD.name AS filter_name,
								P2A.product_id AS isset
							FROM `'.$pp.'attribute` A 
							LEFT JOIN `'.$pp.'attribute_description` AD ON A.attribute_id = AD.attribute_id
							LEFT JOIN `'.$pp.'attribute_group_description` AGD ON A.attribute_group_id = AGD.attribute_group_id
							LEFT JOIN `'.$pp.'product_attribute` P2A ON A.attribute_id = P2A.attribute_id AND P2A.product_id = "'.$id.'"
							
							WHERE A.attribute_id IN ('.implode(',',$filter_ids).') AND A.enable="1"
								GROUP BY A.filter_name
								ORDER BY filter_name ASC;';
					//}
					//echo $sql;
					//$return['filters']['111'] = $sql;
				
					$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
					if($r->num_rows > 0){
						while($tmp = $r->fetch_assoc()){
							
							if($tmp['filter_id']){
								$return['filters'][$tmp['group_name']][$tmp['filter_id']]['name'] = $tmp['filter_name'];
								//$return['filters'][$tmp['group_name']][$tmp['filter_id']]['filtername'] = 'filter-universal_'.$tmp['group_id'];
								$return['filters'][$tmp['group_name']][$tmp['filter_id']]['filtername'] = 'filter-universal';
								if($tmp['isset']){
									$return['filters'][$tmp['group_name']][$tmp['filter_id']]['isset'] = 1;
								}else{
									$return['filters'][$tmp['group_name']][$tmp['filter_id']]['isset'] = 0;
								}
							}
						}
						
						//header("Content-Type: text/html; charset=UTF-8");
						//echo "<pre>";  print_r(var_dump( $return['filters'] )); echo "</pre>";
						//die();
					}
					
					
				
				}
				
				//Получим лог по этому продукту
				$sql = 'SELECT
							log_id,
							log_date,
							firstname,
							lastname,
							log_text
						FROM `'.$pp.'user_log` UL
						LEFT JOIN `'.$pp.'user` U ON U.user_id = UL.log_user
						WHERE log_key = "moderation" AND log_target="'.(int)$product['product_id'].'"
						ORDER BY log_id ASC;';
				
				$r = $mysqli->query($sql) or die('Не удалось получить log '.$sql);
				$return['log'] = array();
				if($r->num_rows > 0){
					while($row = $r->fetch_assoc()){
						
						$return['log'][$row['log_id']]['log_id'] = $row['log_id'];
						$return['log'][$row['log_id']]['log_date'] = $row['log_date'];
						$return['log'][$row['log_id']]['user'] = $row['firstname'] . ' ' . $row['lastname'];
						$return['log'][$row['log_id']]['log_text'] = $row['log_text'];
						
					}
				}
				
		//header("Content-Type: text/html; charset=UTF-8");
		//echo "<pre>";  print_r(var_dump( $return )); echo "</pre>";
		
		
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
	
	}

?>