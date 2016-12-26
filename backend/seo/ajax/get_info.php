<?php

include('../../../config.php');
include('../../config.php');

$pp = DB_PREFIX;


include_once('../../class/alias.class.php');
$Alias = new Alias($mysqli, DB_PREFIX);
	
    $key = 'exit';
	if(isset($_POST['key'])) $key = $_POST['key'];
	
    $id = 0;
	if(isset($_POST['id'])) $id = $_POST['id'];

	$category_id = 0;
	if(isset($_POST['category_id'])) $category_id = $_POST['category_id'];

	$url = 0;
	if(isset($_POST['url'])) $url = $_POST['url'];


	if($key == 'get_category_list'){
		$return = array();
		
		//Получим подкатегорию
		$sql = 'SELECT id, name, title, url FROM `'.$pp.'alias_description` WHERE category_id = "'.$id.'" ORDER BY `name` ASC;';
		$r = $mysqli->query($sql) or die('Не удалось получить Подкаталог '.$sql);
		
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
			
				$alias = $Alias->getArrayFromAlias($tmp['url']);
	
				$group_id = 0;
				$group_name = 'none';
				if(isset($alias['attributes_array']) AND isset($alias['attributes_array']['group_id'])){
					$group_id = $alias['attributes_array']['group_id'];
					$group_name = $alias['attributes_array']['group_name'];
				}
				
				$return[$group_id]['group_name'] = $group_name;
				
				$return[$group_id]['list'][$tmp['id']]['name'] = $tmp['name'];
				$return[$group_id]['list'][$tmp['id']]['title'] = $tmp['title'];
				$return[$group_id]['list'][$tmp['id']]['url'] = $tmp['url'];
				$return[$group_id]['list'][$tmp['id']]['alias'] = $alias;
			
			}
		}
	
	
		echo json_encode($return);
		return true;
	
	}
	
	if($key == 'get_all_category_list'){
		$return = array();
		
		//Получим подкатегорию
		$sql = 'SELECT id, name, title, url FROM `'.$pp.'alias_description` ORDER BY `title` ASC;';
		$r = $mysqli->query($sql) or die('Не удалось получить Подкаталог '.$sql);
	
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
			
				$alias = $Alias->getArrayFromAlias($tmp['url']);
	
				$group_id = 0;
				$group_name = 'none';
				if(isset($alias['attributes_array']) AND isset($alias['attributes_array']['group_id'])){
					$group_id = $alias['attributes_array']['group_id'];
					$group_name = $alias['attributes_array']['group_name'];
				}
				
				$return[$group_id]['group_name'] = $group_name;
				
				$return[$group_id]['list'][$tmp['id']]['name'] = $tmp['name'];
				$return[$group_id]['list'][$tmp['id']]['title'] = $tmp['title'];
				$return[$group_id]['list'][$tmp['id']]['url'] = $tmp['url'];
				$return[$group_id]['list'][$tmp['id']]['alias'] = $alias;
			
			}
		}
	
	
		echo json_encode($return);
		return true;
	
	}
	
	
	if($key == 'get_category_filters'){
		$return = array();
		$sql = 'SELECT attribute_id FROM `'.$pp.'category_to_attribute` WHERE category_id = "'.$category_id.'";';
				$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
				if($r->num_rows > 0){
					while($tmp = $r->fetch_assoc()){
						$filter_ids[] = $tmp['attribute_id'];
					}
				}
				
				if(count($filter_ids) > 0){
					$sql = 'SELECT
								AGD.attribute_group_id AS group_id,
								AGD.name AS group_name,
								A.attribute_id AS filter_id,
								A.filter_name AS filter_alias,
								AD.name AS filter_name,
								P2A.product_id AS isset
							FROM `'.$pp.'attribute` A 
							LEFT JOIN `'.$pp.'attribute_description` AD ON A.attribute_id = AD.attribute_id
							LEFT JOIN `'.$pp.'attribute_group_description` AGD ON A.attribute_group_id = AGD.attribute_group_id
							LEFT JOIN `'.$pp.'product_attribute` P2A ON A.attribute_id = P2A.attribute_id AND P2A.product_id = "'.$id.'"
							
							WHERE A.attribute_id IN ('.implode(',',$filter_ids).') AND A.enable="1"
								GROUP BY AD.name
								ORDER BY AD.`name` ASC;';
					//}
					$return['sql'] = $sql;
				
					$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);
					if($r->num_rows > 0){
						while($tmp = $r->fetch_assoc()){
							
							if($tmp['filter_id']){
								$return['filters'][$tmp['group_name']][$tmp['filter_id']]['name'] = $tmp['filter_name'];
								$return['filters'][$tmp['group_name']][$tmp['filter_id']]['filter_alias'] = $tmp['filter_alias'];
								//$return['filters'][$tmp['group_name']][$tmp['filter_id']]['filtername'] = 'filter-universal_'.$tmp['group_id'];
								$return['filters'][$tmp['group_name']][$tmp['filter_id']]['filtername'] = $tmp['filter_alias'];
								if(strpos($url, $tmp['filter_alias']) !== false){
									$return['filters'][$tmp['group_name']][$tmp['filter_id']]['isset'] = 1;
								}else{
									$return['filters'][$tmp['group_name']][$tmp['filter_id']]['isset'] = 0;
								}
							}
						}
					}
				
				}
		
			echo json_encode($return);
			return true;
		}
		
		if($key == 'get_category_info'){
			$data = array();
			$r_c = $mysqli->query("SELECT DISTINCT *,
								(SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '  >  ')
										FROM " . DB_PREFIX . "category_path cp
										LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND cd1.language_id = 1)
										WHERE cp.category_id = c.category_id GROUP BY cp.category_id) AS path,
								(SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias
										WHERE query = 'category_id=" . (int)$category_id . "') AS keyword
								FROM " . DB_PREFIX . "category c
										LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id AND cd2.language_id = 1)
										WHERE c.category_id = '" . (int)$category_id. "'");
			if($r_c->num_rows){
				$row = $r_c->fetch_assoc();
				$data['category_name'] = $row['path'];
				$data['category_id'] = $row['category_id'];
				$data['category_url'] = $row['keyword'];
			}
			echo json_encode($data);
			return true;
		}

?>