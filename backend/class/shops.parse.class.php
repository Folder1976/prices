<?php

class ShopImportParse 
{
	
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
	
	public function url_clear($url){
		$original = $url;
		
		$url = str_replace('https://', '', $url);
		$url = str_replace('https://', '', $url);
		$url = str_replace('http://', '', $url);
		$url = str_replace('http://', '', $url);
		$url = str_replace('//', '/', $url);
		
		if(strpos($original, 'https://') !== false){
			return 'https://'.$url;
		}else{
			return 'http://'.$url;
		}
		
	}
	
	
    public function getArray($simple, $shop_id, $postav_id = 0){
		if($shop_id == 1){
			return $this->getArrayTMModus($simple, $shop_id);
		}
		if($shop_id == 2){
			return $this->getArrayGLEM($simple, $shop_id);
		}
		if($shop_id == 4){
			return $this->getArrayStilnaia($postav_id); //Передаем поставщика
		}else{
			return $this->getArrayUniversal($simple, $shop_id); //Передаем поставщика
		}
	}
	
	public function strip_cdata($string){
		preg_match_all('/<!\[cdata\[(.*?)\]\]>/is', $string, $matches);
		return str_replace($matches[0], $matches[1], $string);
	}

	public function setcode($str){
		//echo '<br>'.mb_detect_encoding($str);
		return $str;
		if(mb_detect_encoding($str) == 'windows-1251'){
			return $str;
		}else{
			return mb_convert_encoding($str, "UTF-8", "windows-1251");
		}
	}
	public function getArrayCategory($simple, $shop_id){
			$categories = array();
			$html_utf8 = mb_convert_encoding($simple, "utf-8", "windows-1251");
		
			$pat = 'categories';
			$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
			
			$tmps = explode('<category id="', $regs[1]);
			
			foreach($tmps as $tmp){
				$tmp2 = explode('>', $tmp);
			
				if(isset($tmp2[1])){
		
					$tt = explode('"', $tmp2[0]);
					$id = trim($tt[0]);
					$id = trim($id,'"');
					$name = trim($tmp2[1]);
					$name = trim($name,'</category');
					
					$categories[(int)$id] = trim($this->setcode($name));
				}
			}
			return $categories;
	}
	
	
	public function getArrayCategoryStilnaia($ids){
			$categories = array();
			
			if(count($ids) == 0){
				return $categories;
			}
			$pp_S = 'shop_';
			$pp = $this->pp;
			$mysqli_stilnaya = mysqli_connect(ST__DB_SERVER_NAME,ST__DB_USER,ST__DB_PASS,ST__DB_NAME) or die("Error " . mysqli_error($mysqli_stilnaya)); 
			mysqli_set_charset($mysqli_stilnaya,"utf8");

			
			$sql = 'SELECT
							P.id,
							P.name
							FROM `'.$pp_S.'product2category` PC
							LEFT JOIN `'.$pp_S.'podcategory` P ON P.id = PC.podcategory_id
							WHERE PC.product_id IN ('.implode(',', $ids).')
							';
			
			$r = $mysqli_stilnaya->query($sql) or die('sadflijg asdljkfg;osd '.$sql);
		
			if($r->num_rows > 0){
				while($tmp = $r->fetch_assoc()){
					$categories[(int)$tmp['id']] = trim($tmp['name']);
				}
			}

			return $categories;
	}
	
	
	
	
	public function getArrayStilnaia($postav_id){
			
			$limit = 500000;
			
			$shop_id = 4;
			$pp = $this->pp;
			$pp_S = 'shop_';
			$mysqli_stilnaya = mysqli_connect(ST__DB_SERVER_NAME,ST__DB_USER,ST__DB_PASS,ST__DB_NAME) or die("Error " . mysqli_error($mysqli_stilnaya)); 
			mysqli_set_charset($mysqli_stilnaya,"utf8");

			//У данного поставщика нет названий категорий. Возмем в шапке
			
			$data_S = array();
			
			$data['id'] = 0;
			$data['index'] = '';
			$data['manufacture_id'] = 0;
			$data['manufacture_name'] = '';
			$data['shop_id'] = $shop_id;
			$data['sku'] = 0;
			$data['url'] = 0;
			$data['images'] = 0;
			$data['params'] = array();;
			$data['categoryid'] = 0;
			$data['categoryname'] = 0;
			$data['name'] = 0;
			$data['price'] = 0;
			$data['oldprice'] = 0;
			$data['currencyid'] = 'UAH';
			$data['instock'] = 0;
			$data['prices']['price'] = 0;
			$data['prices']['items'] = 0;
			$data['description'] = 0;
	
			$postav_sql = '';
			if($postav_id > 0){
				$postav_sql = ' AND user_id = "'.$postav_id.'" ';
			}
		
			$sql = 'SELECT
						P.id,
						P.url,
						P.name,
						P.full_name,
						P.real_cost,
						P.old_cost,
						P.text,
						P.category_id AS categoryid,
						PC.name AS categoryname,
						UD.full_name AS manufacture_name,
						UD.id AS manufacture_id
			
						FROM `'.$pp_S.'product` P
						LEFT JOIN `'.$pp_S.'product2category` P2C ON P.id = P2C.product_id
						LEFT JOIN `'.$pp_S.'podcategory` PC ON P2C.podcategory_id = PC.id
						LEFT JOIN `'.$pp_S.'users` UD ON P.user_id = UD.id
						
						WHERE P.is_sold = 0 AND P.is_hidden = 0 '.$postav_sql.'
						LIMIT 0, '.$limit;
		
			$r = $mysqli_stilnaya->query($sql) or die('ijafo isd '.$sql);
	
		while($row = $r->fetch_assoc()){
		
			$data['id'] = $row['id'];
			$data['index'] = 'http://stilnaya.com.ua/product/view/'.$row['url'];
			$data['url'] = 'http://stilnaya.com.ua/product/view/'.$row['url'];
			$data['name'] = trim($row['name']);
			$data['categoryid'] = $row['categoryid'];
			$data['categoryname'] = trim($row['categoryname']);
			$data['price'] = $row['real_cost'];
			$data['oldprice'] = $row['old_cost'];
			$data['instock'] = 1;
			$data['description'] = $row['text'];
			$data['prices']['price'] = $row['real_cost'];
			$data['prices']['items'] = 1;
			$data['manufacture_id'] = $row['manufacture_id'];
			$data['manufacture_name'] = $row['manufacture_name'];
		
		
			if($data['manufacture_name'] == '' OR $data['manufacture_name'] == NULL){
				$tmp = explode(' от ', $row['full_name']);
				if(isset($tmp[1])){
					$data['manufacture_id'] = 0;
					$data['manufacture_name'] = trim($tmp[1]);
				}
			}
			
			$data['images'] = array();
			$sql = 'SELECT * FROM `'.$pp_S.'product_media` WHERE product_id = "'.$data['id'].'" LIMIT 0, 1';
			$r_i = $mysqli_stilnaya->query($sql) or die(' 9834y uis '.$sql);
			
			if($r_i->num_rows > 0){
				$tmp = $r_i->fetch_assoc();
				if($tmp['front'] != ''){
					$data['images'][1] = 'http://stilnaya.com.ua/upload/product/large_front_'.$tmp['front'];
				}
				if($tmp['back'] != ''){
					$data['images'][2] = 'http://stilnaya.com.ua/upload/product/large_back_'.$tmp['back'];
				}
				if($tmp['middle'] != ''){
					$data['images'][3] = 'http://stilnaya.com.ua/upload/product/large_middle_'.$tmp['middle'];
				}
				if($tmp['other'] != ''){
					$data['images'][4] = 'http://stilnaya.com.ua/upload/product/large_other_'.$tmp['other'];
				}
			}
			
			//Другие параметры - из таблиц параметров
			$data['realparametrs']['material']	= array();
			$sql = 'SELECT	M.id,
							M.name
							FROM `'.$pp_S.'product2material` P2M
							LEFT JOIN `'.$pp_S.'guidematerial` M ON P2M.material_id = M.id
							WHERE P2M.product_id = "'.$data['id'].'"
							';
			$r_s = $mysqli_stilnaya->query($sql) or die(' 9kjgl834y uis '.$sql);
			if($r_s->num_rows > 0){
				while($tmp = $r_s->fetch_assoc()){
					
					$data['realparametrs']['material'][] = $tmp['name'];
					
				}
			}
				
				
		
			$data_S[$data['index']] = $data;	
			$size = array();
		
			//Размеры
			$sql = 'SELECT P2S.product_id,
							P2S.size_id,
							GS.inter,
							GS.sng,
							GS.usa
							FROM `'.$pp_S.'product2size` P2S
							LEFT JOIN `'.$pp_S.'guidesize` GS ON P2S.size_id = GS.id
							WHERE P2S.product_id = "'.$data['id'].'"';
			$r_s = $mysqli_stilnaya->query($sql) or die(' 9kjgl834y uis '.$sql);
			if($r_s->num_rows > 0){
				//Проверим столбец
				$size = array();
				$inter = 1;
				$sng = 1;
				$usa = 1;
				while($tmp = $r_s->fetch_assoc()){
					
					$size[$tmp['size_id']]['inter'] = $tmp['inter'];
					if($tmp['inter'] == '') $inter = 0;
					
					$size[$tmp['size_id']]['sng'] = $tmp['sng'];
					if($tmp['sng'] == '') $sng = 0;
					
					$size[$tmp['size_id']]['usa'] = $tmp['usa'];
					if($tmp['usa'] == '') $usa = 0;
					
				}
				
				if($inter == 1){
					$col = 'inter';
				}elseif($sng == 1){
					$col = 'sng';
				}elseif($usa == 1){
					$col = 'usa';
				}else{
					$col = 'inter';
				}
				
				
				foreach($size as $index => $value){
					$data_S[$data['index']]['sizes'][$value[$col]]['price'] = $data['price'];
					$data_S[$data['index']]['sizes'][$value[$col]]['instock'] = $data['instock'];
					$data_S[$data['index']]['sizes'][$value[$col]]['prices'] = $data['prices'];
				}
				
				
			}
			
			//Принудительный вылет
			if(count($data_S) > 1){
				//return $data_S;
			}
			
		}
	
		return $data_S;
	}
	public function getArrayTMModus($simple, $shop_id){
			
			//У данного поставщика нет названий категорий. Возмем в шапке
			$categories = array();
			$html_utf8 = mb_convert_encoding($simple, "utf-8", "windows-1251");
		
			$pat = 'categories';
			$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
			
			$tmps = explode('<category id="', $regs[1]);
			
			foreach($tmps as $tmp){
				$tmp2 = explode('>', $tmp);
			
				if(isset($tmp2[1])){
		
					$tt = explode('"', $tmp2[0]);
					$id = trim($tt[0]);
					$id = trim($id,'"');
					$name = trim($tmp2[1]);
					$name = trim($name,'</category');
					
					$categories[(int)$id] = trim($name);
				}
			}
			
			
			//=================================
			
			$data_S = array();
			
			$data['id'] = 0;
			$data['index'] = '';
			$data['manufacture_id'] = 0;
			$data['manufacture_name'] = '';
			$data['shop_id'] = $shop_id;
			$data['sku'] = 0;
			$data['url'] = 0;
			$data['images'] = 0;
			$data['params'] = array();;
			$data['categoryid'] = 0;
			$data['categoryname'] = '';
			$data['name'] = 0;
			$data['price'] = 0;
			$data['oldprice'] = 0;
			$data['currencyid'] = 'UAH';
			$data['instock'] = 0;
			$data['prices']['price'] = 0;
			$data['prices']['items'] = 0;
			$data['description'] = 0;
	
		
		$rows = explode('<offer id', $simple);
	
		foreach($rows as $row){
		
			$html_utf8 = mb_convert_encoding($row, "utf-8", "windows-1251");
			
			if(strpos($html_utf8, '<price>') !== false){
			
				//Прайсы и скидки
				$data['prices']['price'] = 0;
				$data['prices']['items'] = 0;
				
				//Основная цена
				$pat = 'price';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['price'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
				//Основная цена
				$pat = 'oldprice';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['oldprice'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				if($data['price'] == $data['oldprice']){
					//$data['oldprice'] = 0;
				}
				
				
				//Код Бренда
				$pat = 'vendorCode';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['manufacture_id'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
				//Название Бренда
				$pat = 'vendor';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['manufacture_name'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
				//Количество
				/*
				$pat = 'instock';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['instock'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				*/
				//Валюта
				$pat = 'currencyId';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['currencyid'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
				//Категория
				$pat = 'categoryId';
				$s = eregi("<$pat>(.*)</$pat >",$html_utf8,$regs);
				$data['categoryid'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
				//Категория	
				$data['categoryname'] = $categories[(int)$data['categoryid']];
				
				//Название
				$pat = 'model';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['name'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//URL
				$pat = 'url';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['index'] = $data['url'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//Описание
				$pat = 'description';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['description'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//Картинки
				$pat = 'picture';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
	
				$tmp = $regs[1];
				$data['images'] = explode('<'.$pat.'>', $tmp);
					
				foreach($data['images'] as $index => $value){
					$data['images'][$index] = trim(trim($value),'</picture>');
				}
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//Параметры
				$pat = 'param';
				$s = eregi("<$pat(.*)</$pat>",$html_utf8,$regs);
				$tmp = $regs[1];
				
				$data1['params'] = explode('<'.$pat.'', $tmp);
				
				$size = '';
					
				foreach($data1['params'] as $index => $value){
					$t = trim($value);
					$t = str_replace('name=', '',$t);
					$t = explode('>', $t);
				
					$t[0] = trim($t[0]);
					$t[0] = trim($t[0],'"');
					$t[0] = trim($t[0],'"');
					
					$t[1] = trim($t[1]);
					$t[1] = trim($t[1],'</param');
					$t[1] = trim($t[1],'"');
					$t[1] = trim($t[1],'"');
					
					if($t[0] != 'Размер'){
						$data['params'][$t[0]] = $t[1];
					}
					
				}
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//Ид товара
				$tmp = explode('"', $html_utf8);
				$data['id'] = (int)trim($tmp[1]);

				//Размеры
				if($data['id'] > 0){
					$data_S[$data['index']] = $data;
					
					//Выпарсиваем размеры
					
					//размеры и наличие
					$pat = 'avail';
					$s = eregi("<$pat(.*)</$pat>",$html_utf8,$regs);
					$tmp = $regs[1];
					
					$tmp1 = explode('<size quantity="', $tmp);
					
					foreach($tmp1 as $index => $tmp){
						
						if($index == 0){
							$tmp = trim($tmp);
							$tmp = str_replace('quantity="','', $tmp);
							$tmp = str_replace('">','', $tmp);
							$tmp = trim($tmp);
							$data['instock'] = (int)$tmp;
							continue;
						}
						
						$tmp = trim($tmp);
						$tmp = str_replace('>','', $tmp);
						$tmp = str_replace('</size','', $tmp);
						$tmp_a = explode('"', $tmp);
				
					
						if(isset($tmp_a[1])){
							$items = $tmp_a[0];
							$size = $tmp_a[1];
						}else{
							$items = $data['instock'];
							$size = '';
						}
					
						$data_S[$data['index']]['sizes'][$size]['price'] = $data['price'];
						$data_S[$data['index']]['sizes'][$size]['instock'] = $data['instock'];
						$data_S[$data['index']]['sizes'][$size]['prices'] = $data['prices'];
						
					}
					
					
				}
			
			/*
				if($data['id'] == 592){
					echo "<pre>";  print_r(var_dump( $data_S )); echo "</pre>";
					die();
				}
			*/
			
			}
			
		}
	
		return $data_S;
	}
	
	public function getArrayGLEM($simple, $shop_id){
		$data_S = array();
			
			$data['id'] = 0;
			$data['index'] = '';
			$data['manufacture_id'] = 0;
			$data['manufacture_name'] = '';
			$data['shop_id'] = $shop_id;
			$data['sku'] = 0;
			$data['url'] = 0;
			$data['images'] = 0;
			$data['params'] = array();;
			$data['categoryid'] = 0;
			$data['categoryname'] = 0;
			$data['name'] = 0;
			$data['price'] = 0;
			$data['oldprice'] = 0;
			$data['currencyid'] = 'UAH';
			$data['instock'] = 0;
			$data['prices']['price'] = 0;
			$data['prices']['items'] = 0;
			$data['description'] = 0;
	
		
		$rows = explode('<offer id', $simple);
	
		foreach($rows as $row){
		
			$html_utf8 = mb_convert_encoding($row, "utf-8", "windows-1251");
			
			if(strpos($html_utf8, '<price>') !== false){
			
				//Прайсы и скидки
				$s = eregi("<prices>(.*)</prices>",$html_utf8,$regs);
				
				$tmp = $regs[1];
				
				if($tmp){
					$s = eregi("<value>(.*)</value>",$tmp,$regs);
					$data['prices']['price'] = $regs[1];
					
					$s = eregi("<quantity>(.*)</quantity>",$tmp,$regs);
					$data['prices']['items'] = $regs[1];
				}
				
				$html_utf8 = str_replace("<prices>$tmp</prices>", '', $html_utf8);
					
				//Основная цена
				$pat = 'price';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['price'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
				//Количество
				$pat = 'instock';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['instock'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
				//Валюта
				$pat = 'currencyId';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['currencyid'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
			
				//Категория
				$pat = 'categoryId';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['categoryid'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				$pat = 'categoryName';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['categoryname'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
				//Название
				$pat = 'name';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['name'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//URL
				$pat = 'url';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['index'] = $data['url'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//Описание
					$pat = 'description';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['description'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//Картинки
				$pat = 'picture';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
	
				$tmp = $regs[1];
				$data['images'] = explode('<'.$pat.'>', $tmp);
					
				foreach($data['images'] as $index => $value){
					$data['images'][$index] = trim(trim($value),'</picture>');
				}
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//Параметры
				$pat = 'param';
				$s = eregi("<$pat(.*)</$pat>",$html_utf8,$regs);
				$tmp = $regs[1];
				
				$data1['params'] = explode('<'.$pat.'', $tmp);
				
				$size = '';
					
				foreach($data1['params'] as $index => $value){
					$t = trim($value);
					$t = str_replace('name=', '',$t);
					$t = explode('>', $t);
				
					$t[0] = trim($t[0]);
					$t[0] = trim($t[0],'"');
					$t[0] = trim($t[0],'"');
					
					$t[1] = trim($t[1]);
					$t[1] = trim($t[1],'</param');
					$t[1] = trim($t[1],'"');
					$t[1] = trim($t[1],'"');
					
					$data['params'][$t[0]] = $t[1];
					
					if($t[0] == 'Размер'){
						$size = $t[1];
					}
					
				}
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//Ид товара
				$tmp = explode('"', $html_utf8);
				$data['id'] = (int)trim($tmp[1]);
				
			}
			
			if($data['id'] > 0){
				$data_S[$data['index']] = $data;
				$data_S[$data['index']]['sizes'][$size]['price'] = $data['price'];
				$data_S[$data['index']]['sizes'][$size]['instock'] = $data['instock'];
				$data_S[$data['index']]['sizes'][$size]['prices'] = $data['prices'];
			}
		}
	
		return $data_S;
	}

	
	
	public function getArrayUniversal($simple, $shop_id){
		$data_S = array();
	
		if(mb_detect_encoding($simple, 'UTF-8', true)){
			
		}else{
			$simple = mb_convert_encoding($simple, "utf-8", "windows-1251");
		}
		
		if(strpos($simple, '<item>') !== false){
			echo '<br>Определил разделитель продуктов item';
			$rows = explode('<item>', $simple);	
		}elseif(strpos($simple, '<offer ') !== false){
			echo '<br>Определил разделитель продуктов offer';
			$rows = explode('<offer ', $simple);
		}elseif(strpos($simple, '<offer>') !== false){
			echo '<br>Определил разделитель продуктов offer';
			$rows = explode('<offer>', $simple);	
		}else{
			Echo 'Не удалось определить разделитель товаров';
			return false;
		}
		
		foreach($rows as $row){
		
			$data['id'] = 0;
			$data['index'] = '';
			$data['manufacture_id'] = 0;
			$data['manufacture_name'] = '';
			$data['shop_id'] = $shop_id;
			$data['sku'] = 0;
			$data['url'] = 0;
			$data['images'] = array();
			$data['params'] = array();;
			$data['categoryid'] = 0;
			$data['categoryname'] = 0;
			$data['name'] = 0;
			$data['price'] = 0;
			$data['oldprice'] = 0;
			$data['currencyid'] = 'UAH';
			$data['instock'] = 0;
			$data['prices']['price'] = 0;
			$data['prices']['items'] = 0;
			$data['description'] = '';
			$data['size_standart'] = 0;
			$data['size_array'] = array();
		
			if(strpos($row, '<id>') === false AND  strpos($row, '<price') === false) continue;
			//$html_utf8 = mb_convert_encoding($row, "utf-8", "windows-1251");
			$html_utf8 = $row;
			//if(strpos($html_utf8, '<price>') !== false){
					
				//ИД товара
				if(strpos($row, '<id>') !== false){
					$pat = 'id';
					$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
					$data['id'] = $tmp = $regs[1];
					$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				}elseif(strpos($row, 'id=') !== false){
			
					$tmp_arr = explode('id=', $html_utf8);
					$tmp_str = $tmp_arr[1];
					$tmp_arr = explode('"', $tmp_str);
					
					/*
					$tmp_arr = explode('>', $html_utf8);
					$tmp_str = $tmp_arr[0];
					$tmp_str = str_replace('"', '', $tmp_str);
					$tmp_arr = explode(' ', $tmp_str);
					
					$tmp_str = $tmp_arr[0];
					$tmp_arr = explode('=', $tmp_str);
					*/
					if(isset($tmp_arr[1])){
						$data['id'] = trim($tmp_arr[1]);
					}else{
						$data['id'] = 0;
					}
				}
				
	
				//Валюта
				$pat = 'currencyId';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				if(isset($regs[1]) AND $regs[1] != ''){
					$data['currencyid'] = $tmp = $regs[1];
					$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				}
					
				//Основная цена
				$regs = array();
				$pat = 'priceRUAH';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				if(isset($regs[1]) AND $regs[1] != ''){
					$data['price'] = $tmp = $regs[1];
					$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				}else{
					$pat = 'price';
					$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
					if(isset($regs[1])){
						$data['price'] = $tmp = $regs[1];
					}else{
						$data['price'] = $tmp = 0;
					}
					$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				}
				
				//Старая  цена
				$regs = array();
				$pat = 'oldprice';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				if(isset($regs[1])){
					$data['oldprice'] = $tmp = $regs[1];
					$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				}
				
				//Количество
				//$pat = 'instock';
				//$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				//$data['instock'] = $tmp = $regs[1];
				//$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				$data['instock'] = 1;

				//Валюта
				//$pat = 'currencyId';
				//$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				//$data['currencyid'] = $tmp = $regs[1];
				//$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
				//Категория
				$regs = array();
				$pat = 'categoryId';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				if(isset($regs[1])){
					$data['categoryid'] = $tmp = $regs[1];
					$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				}else{
					$data['categoryid'] = 1;
				}
				
				$regs = array();
				$pat = 'categoryName';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				if(isset($regs[1])){
					$data['categoryname'] = $tmp = $regs[1];
					$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				}else{
					$data['categoryname'] = '';
				}
				
				//Название
				$regs = array();
				$pat = 'name';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				if(isset($regs[1])){
					$data['name'] = $tmp = $regs[1];
				}else{
					$pat = 'model';
					$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
					if(isset($regs[1])){
						$data['name'] = $tmp = $regs[1];
					}else{
						continue;
					}
				}
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
	
				//URL
				$regs = array();
				$pat = 'url';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				$data['index'] = $data['url'] = $tmp = $regs[1];
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
		
				$data['index'] = $data['url'] =$this->url_clear($tmp);
		
				//Описание
				$regs = array();
				$pat = 'description';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				if(isset($regs[1])){
					$data['description'] = $tmp = $regs[1];
					$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
					//Убираем тег DATA
					$data['description'] = $this->strip_cdata($data['description']);
				}
				
				//Название Бренда
				$regs = array();
				$pat = 'vendor';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				if(isset($regs[1])){
					$data['manufacture_name'] = $tmp = $regs[1];
				}
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				
				//Картинки
				$regs = array();
				$pat = 'image';
				$s = eregi("<$pat>(.*)</$pat>",$html_utf8,$regs);
				
				if(isset($regs[1]) AND $regs[1] != ''){
					
				}else{
					$pat = 'picture';
					$s = eregi("<$pat(.*)>(.*)</$pat>",$html_utf8,$regs);
		
					if(!isset($regs[1]) AND isset($regs[2])){
						$regs[1] = $regs[2];
					}
				}
			
				if(isset($regs[1])){
					$tmp = $regs[1];
				}
				
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
				$images = explode(">", $tmp);
		
				//Вычистим разложеный массив
				foreach($images as $index => $value){
					if(strpos($value, '.jpeg') === false AND
					   strpos($value, '.jpg') === false AND
					   strpos($value, '.png') === false AND
					   strpos($value, '.gif') === false
					   ){
						unset($images[$index]);
					}else{
						$images[$index] = trim($this->url_clear($value));
					}
				}
		
				foreach($images as $index => $value){
					if($value == '') continue;
					$value = strip_tags(trim($value));
					$data['images'][] = trim($this->url_clear($value));
				}
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);

				//Параметры
				$regs = array();
				$pat = 'param';
				$s = eregi("<$pat(.*)</$pat>",$html_utf8,$regs);
		
				if(isset($regs[1]) AND $regs[1] != ''){
					$tmp = $regs[1];
					
					$data1['params'] = explode('<'.$pat.'', $tmp);
					$size = '';
						
					foreach($data1['params'] as $index => $value){
						$t = trim($value);
						$t = str_replace('name=', '',$t);
						$t = explode('>', $t);
					
						$t[0] = trim($t[0]);
						$t[0] = trim($t[0],'"');
						$t[0] = trim($t[0],'"');
						
						$t[1] = trim($t[1]);
						$t[1] = trim($t[1],'</param');
						$t[1] = trim($t[1],'"');
						$t[1] = trim($t[1],'"');
						
						$data['params'][$t[0]] = $t[1];
						
						if($t[0] == 'Размер'){
							$size = $t[1];
						}
						
					}
				}
				$html_utf8 = str_replace("<$pat>$tmp</$pat>", '', $html_utf8);
		
	
	
				//Ид товара
				//$tmp = explode('"', $html_utf8);
				//$data['id'] = (int)trim($tmp[1]);
				
				//размеры
				unset($data['size_standart']);
				$data['size_array'] = array();
				
				if(isset($data_S[$data['index']]) AND isset($data_S[$data['index']]['size_array'])) $data['size_array'] = $data_S[$data['index']]['size_array'];
				
				foreach($data['params'] as $index => $param){
					
					if(strpos($index, 'Размер') !== false OR strpos(strtolower($index), 'unit=') !== false){
						if(strpos(strtolower($index), '"brand"') !== false){
							$data['size_standart'] = 3;
						}elseif(strpos(strtolower($index), 'unit="inter') !== false){
							$data['size_standart'] = 3;
						}elseif(strpos(strtolower($index), 'unit="eur') !== false){
							$data['size_standart'] = 2;
						}else{
							$data['size_standart'] = 1;
						}
					
						if(strpos($param, ',') !== false){
							$tmp = explode(',', $param);
							foreach($tmp as $i => $v){
								$data['size_array'][trim($v)] = trim($v);
							}
							
						}elseif(strpos($param, '|') !== false){
							$tmp = explode('|', $param);
							foreach($tmp as $i => $v){
								$data['size_array'][trim($v)] = trim($v);
							}
							
						}else{
							$data['size_array'][trim($param)] = trim($param);
						}
						
					}
				}
				
			if($data['id'] == ''){
			}else{
				$data_S[$data['index']] = $data;
				//$data_S[$data['index']]['sizes'][$size]['price'] = $data['price'];
				//$data_S[$data['index']]['sizes'][$size]['instock'] = $data['instock'];
				//$data_S[$data['index']]['sizes'][$size]['prices'] = $data['prices'];
			}
		
		}
		return $data_S;
	}

	
	
	public function getAutoReplaces(){
		$pp = $this->pp;
		$sql = 'SELECT * FROM `'.$pp.'import_replace` ORDER BY id DESC;';
	
		$r = $this->db->query($sql);
		
		$return = array();
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
				$return[$tmp['id']] = $tmp;
			}
		}
		
		return $return;
	}
	
	public function getAutoReplacesIndex($str, $key){
		$pp = $this->pp;
		$sql = 'SELECT `find`, `rep` FROM `'.$pp.'import_replace` WHERE `params` LIKE \'%'.$key.'%\' ORDER BY id DESC;';
		
		$r = $this->db->query($sql) or die($sql);
		
		$return = array();
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
				$str = str_replace($tmp['find'], $tmp['rep'], $str);
			}
		}
		
		return $str;
	}

	
	public function replace($str, $key){
		$pp = $this->pp;
		$sql = 'SELECT `find`, `rep` FROM ';
		
		
	}
	
	
}

?>
