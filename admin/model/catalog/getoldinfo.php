<?php
class ModelCatalogGetOldInfo extends Model {
	
	private $from;
	private $db;
	private $pp = 'shop_';
	
	public function __construct(){
		$this->from = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,'loderi_fashion') or die("Error " . mysqli_error($this->from)); 
        mysqli_set_charset($this->from,"utf8");
		
		$this->db = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE) or die("Error " . mysqli_error($this->db)); 
        mysqli_set_charset($this->db,"utf8");
	}
	
	public function tmp() {
		
			$sql = 'DELETE FROM fash_category_to_attribute WHERE category_id IN(24,82, 85,272,304,305,306,307,308,309,310,311,312,313,314,315)';
			$r = $this->db->query($sql);

		
			$sql = 'SELECT * FROM shop_podcat2filters WHERE podcat_id IN(24,82, 85,272,304,305,306,307,308,309,310,311,312,313,314,315)';
			$r = $this->from->query($sql) or die($sql);
			
			while($row = $r->fetch_assoc()){
				
				$sql = 'INSERT INTO fash_category_to_attribute SET category_id = "'.$row['podcat_id'].'", attribute_id = "'.$row['filter_id'].'"';
				echo '<br>'.$sql;
				$this->db->query($sql);
				
			}
			
	}

	
	public function getCategories() {
		
		$sql = 'SELECT * FROM '.$this->pp.'category';
		$r = $this->from->query($sql) or die($sql);
		
		$data = array();
			
		while($tmp = $r->fetch_assoc()){
			
			$data[$tmp['id']]['category_description'][1]['name'] = $tmp['name'];
			$data[$tmp['id']]['category_description'][1]['description'] = $tmp['name'];
			$data[$tmp['id']]['category_description'][1]['meta_title'] = $tmp['name'];
			$data[$tmp['id']]['category_description'][1]['meta_description'] = $tmp['name'];
			$data[$tmp['id']]['category_description'][1]['meta_keyword'] = $tmp['name'];
			
			$data[$tmp['id']]['category_id'] = $tmp['id'];
			$data[$tmp['id']]['path'] = '';
			$data[$tmp['id']]['parent_id'] = 0;
			$data[$tmp['id']]['top'] = 1;
			$data[$tmp['id']]['filter'] = '';
			$data[$tmp['id']]['category_store'] = array('0' => '0');
			$data[$tmp['id']]['keyword'] = $tmp['url'];
			$data[$tmp['id']]['image'] = '';
			$data[$tmp['id']]['column'] = '0';
			$data[$tmp['id']]['sort_order'] = '0';
			$data[$tmp['id']]['status'] = '1';
			$data[$tmp['id']]['category_layout'] = array('0' => '0');
			
		}
		
		$sql = 'SELECT * FROM '.$this->pp.'podcategory';
		$r = $this->from->query($sql) or die($sql);
		
		
		while($tmp = $r->fetch_assoc()){
			
			$data[$tmp['id']]['category_description'][1]['name'] = $tmp['name'];
			$data[$tmp['id']]['category_description'][1]['description'] = $tmp['text2'];
			$data[$tmp['id']]['category_description'][1]['meta_title'] = $tmp['title'];
			$data[$tmp['id']]['category_description'][1]['meta_description'] = $tmp['description'];
			$data[$tmp['id']]['category_description'][1]['meta_keyword'] = $tmp['title_h1'];
			
			$data[$tmp['id']]['path'] = '';
			if($tmp['parent_id'] == 0){
				$tmp['parent_id'] = $tmp['category_id'];
				$data[$tmp['id']]['top'] = 1;
			}
			$data[$tmp['id']]['parent_id'] = $tmp['parent_id'];
			
			$data[$tmp['id']]['category_id'] = $tmp['id'];
			$data[$tmp['id']]['filter'] = '';
			$data[$tmp['id']]['category_store'] = array('0' => '0');
			$data[$tmp['id']]['keyword'] = $tmp['url'];
			$data[$tmp['id']]['image'] = '';
			$data[$tmp['id']]['column'] = '0';
			$data[$tmp['id']]['sort_order'] = '0';
			$data[$tmp['id']]['status'] = '1';
			$data[$tmp['id']]['category_layout'] = array('0' => '0');
			
		}
		return $data;
	}

	public function copyManufacturers(){
		
		$sql = 'DELETE FROM ' . DB_PREFIX . 'manufacturer';
		$this->db->query($sql) or die($sql);
		$sql = 'DELETE FROM ' . DB_PREFIX . 'manufacturer_to_store';
		$this->db->query($sql) or die($sql);
		
		$sql = 'DELETE FROM ' . DB_PREFIX . 'url_alias WHERE `query` LIKE "manufacturer_id=%"';
		$this->db->query($sql) or die($sql);
			
		
		$sql = 'SELECT * FROM '.$this->pp.'guidedesigner';
		$r = $this->from->query($sql) or die($sql);
		
		while($tmp = $r->fetch_assoc()){
			$manufacturer_id = $tmp['id'];
			$sql = 'INSERT INTO  ' . DB_PREFIX . 'manufacturer SET
									`name` = \''.$tmp['name'].'\',
									`enable` = \''.$tmp['enable'].'\',
									`manufacturer_id` = \''.$manufacturer_id.'\';';
			$this->db->query($sql) or die($sql);

			$sql = 'INSERT INTO  ' . DB_PREFIX . 'manufacturer_to_store SET
									`store_id` = \'0\',
									`manufacturer_id` = \''.$manufacturer_id.'\';';
			$this->db->query($sql) or die($sql);
			
			$sql = "INSERT INTO " . DB_PREFIX . "url_alias
								SET query = 'manufacturer_id=" . (int)$manufacturer_id . "',
								keyword = '" . $this->translitArtkl($tmp['name']) . "'";
			$this->db->query($sql) or die($sql);
		}

	}
	
	
	public function copyManufacturersSeo(){
		$sql = 'SELECT U.url, U.full_name as name,
						UI.seo_title as title,
						UI.seo_title_h1 as title_h1,
						UI.seo_text2 as text2,
						UI.seo_text as text1,
						UI.seo_desc,
						U.id 
						
						FROM '.$this->pp.'users U
						
						LEFT JOIN '.$this->pp.'userinfo UI ON UI.user_id = U.id
						WHERE url <> ""		
					';
		$r = $this->from->query($sql) or die($sql);
		
		while($tmp = $r->fetch_assoc()){
			$id = $tmp['id'];
			$sql = 'INSERT INTO  ' . DB_PREFIX . 'alias_description SET
							`id` = \''.$tmp['id'].'\',
							`name` = \''.$tmp['name'].'\',
							`title` = \''.$tmp['title'].'\',
							`title_h1` = \''.$tmp['title_h1'].'\',
							`url` = \''.$tmp['url'].'\',
							`category_id` = \'0\',
							`section_id` = \'0\',
							`text1` = \''.htmlspecialchars($tmp['text1'], ENT_QUOTES).'\',
							`text2` = \''.htmlspecialchars($tmp['text2'], ENT_QUOTES).'\',
							`is_best` = \'0\'
							on duplicate key update
							`name` = \''.$tmp['name'].'\'
							;';
			echo '<br>'.$sql;
			$this->db->query($sql) or die($sql);
		}
	}
	
	public function copyAliasDescription(){
		
		//$sql = 'DELETE FROM ' . DB_PREFIX . 'alias_description';
		//$this->db->query($sql) or die($sql);
		
		$sql = 'SELECT * FROM '.$this->pp.'categorize';
		$r = $this->from->query($sql) or die($sql);
		header("Content-Type: text/html; charset=UTF-8");
		while($tmp = $r->fetch_assoc()){
			$id = $tmp['id'];
			$sql = 'INSERT INTO  ' . DB_PREFIX . 'alias_description SET
									`id` = \''.$tmp['id'].'\',
									`name` = \''.$tmp['name'].'\',
									`title` = \''.$tmp['title'].'\',
									`title_h1` = \''.$tmp['title_h1'].'\',
									`url` = \''.$tmp['url'].'\',
									`category_id` = \''.$tmp['category_id'].'\',
									`section_id` = \''.$tmp['section_id'].'\',
									`text1` = \''.htmlspecialchars($tmp['text1'], ENT_QUOTES).'\',
									`text2` = \''.htmlspecialchars($tmp['text2'], ENT_QUOTES).'\',
									`is_best` = \''.$tmp['is_best'].'\'
									on duplicate key update
									`name` = \''.$tmp['name'].'\'
									;';
			echo '<br>'.$sql;
			$this->db->query($sql) or die($sql);
		}

	}
	
	public function copyAttributes(){
		
		$sql = 'DELETE FROM ' . DB_PREFIX . 'attribute';
		$this->db->query($sql) or die($sql);
		$sql = 'DELETE FROM ' . DB_PREFIX . 'attribute_description';
		$this->db->query($sql) or die($sql);
		$sql = 'DELETE FROM ' . DB_PREFIX . 'attribute_group';
		$this->db->query($sql) or die($sql);
		$sql = 'DELETE FROM ' . DB_PREFIX . 'attribute_group_description';
		$this->db->query($sql) or die($sql);
		$sql = 'DELETE FROM ' . DB_PREFIX . 'product_attribute';
		$this->db->query($sql) or die($sql);
		
		
		$sql = 'SELECT * FROM '.$this->pp.'guidesuniversal';
		$r = $this->from->query($sql) or die($sql);
		
		while($tmp = $r->fetch_assoc()){
			$sql = 'INSERT INTO  ' . DB_PREFIX . 'attribute_group SET
									`attribute_group_id` = \''.$tmp['id'].'\',
									`enable` = \''.$tmp['enable'].'\',
									`sort_order` = \''.$tmp['sort'].'\';';
			$this->db->query($sql) or die($sql);

			$sql = 'INSERT INTO  ' . DB_PREFIX . 'attribute_group_description SET
									`attribute_group_id` = \''.$tmp['id'].'\',
									`language_id` = \'1\',
									`name` = \''.$tmp['name'].'\';';
			$this->db->query($sql) or die($sql);
		}

		$sql = 'SELECT * FROM '.$this->pp.'guidesuniversal_filters';
		$r = $this->from->query($sql) or die($sql);
		
		while($tmp = $r->fetch_assoc()){
			$sql = 'INSERT INTO  ' . DB_PREFIX . 'attribute SET
									`attribute_id` = \''.$tmp['id'].'\',
									`attribute_group_id` = \''.$tmp['group'].'\',
									`filter_name` = \''.$tmp['filter_name'].'\',
									`sort_order` = \''.$tmp['sort'].'\',
									`enable` = \''.$tmp['enable'].'\';';
			$this->db->query($sql) or die($sql);

			$sql = 'INSERT INTO  ' . DB_PREFIX . 'attribute_description SET
									`attribute_id` = \''.$tmp['id'].'\',
									`language_id` = \'1\',
									`name` = \''.$tmp['name'].'\';';
			$this->db->query($sql) or die($sql);
		}

	}
	
	public function copySize(){
		
		$sql = 'DELETE FROM ' . DB_PREFIX . 'size_group';
		$this->db->query($sql) or die($sql);
		$sql = 'DELETE FROM ' . DB_PREFIX . 'size';
		$this->db->query($sql) or die($sql);
		
		$sql = 'SELECT * FROM '.$this->pp.'guidesize_group';
		$r = $this->from->query($sql) or die($sql);
		while($tmp = $r->fetch_assoc()){
			$sql = 'INSERT INTO  ' . DB_PREFIX . 'size_group SET
									`id` = \''.$tmp['id'].'\',
									`name` = \''.$tmp['name'].'\',
									`enable` = \''.$tmp['enable'].'\',
									`sort` = \''.$tmp['sort'].'\';';
			$this->db->query($sql) or die($sql);
		}

		$sql = 'SELECT * FROM '.$this->pp.'guidesize_new';
		$r = $this->from->query($sql) or die($sql);
		while($tmp = $r->fetch_assoc()){
			$sql = 'INSERT INTO  ' . DB_PREFIX . 'size SET
									`size_id` = \''.$tmp['id'].'\',
									`name` = \''.$tmp['name'].'\',
									`group_id` = \''.$tmp['group'].'\',
									`enable` = \''.$tmp['enable'].'\',
									`sort` = \''.$tmp['sort'].'\';';
			$this->db->query($sql) or die($sql);
		}

	}
	
	public function translitArtkl($str) {
		$rus = array('и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
		$lat = array('u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
		$str = str_replace($rus, $lat, $str);
	   
		$str = strtolower($str);
	   
		return $str;
	}
 
	public function getProducts(){
		
		return array();
		$data = array();
		
		$sql = 'SELECT * FROM '.DB_PREFIX.'manufacturer';
		$r = $this->db->query($sql) or die($sql);
		$manuf = array();
		while($tmp = $r->fetch_assoc()){
			$manuf[$tmp['manufacturer_id']] = $tmp['name'];
		}
		
		$sql = 'SELECT * FROM '.$this->pp.'product';
		$r = $this->from->query($sql) or die($sql);
		
		while($tmp = $r->fetch_assoc()){
			$product_id = $tmp['id'];
			$data[$tmp['id']]['product_id'] = $tmp['id'];
			$data[$tmp['id']]['moderation_id'] = $tmp['is_hidden'];
				$data[$tmp['id']]['upc'] = '';
				$data[$tmp['id']]['ean'] = '';
				$data[$tmp['id']]['jan'] = '';
				$data[$tmp['id']]['isbn'] = '';
				$data[$tmp['id']]['mpn'] = '';
				$data[$tmp['id']]['location'] = '';
				$data[$tmp['id']]['subtract'] = '';
				$data[$tmp['id']]['points'] = '';
				$data[$tmp['id']]['weight'] = '';
				$data[$tmp['id']]['weight_class_id'] = '';
				$data[$tmp['id']]['length'] = '';
				$data[$tmp['id']]['width'] = '';
				$data[$tmp['id']]['height'] = '';
				$data[$tmp['id']]['stock_status_id'] = '';
				$data[$tmp['id']]['date_available'] = date('Y-m-d', strtotime('-1 day'));
				$data[$tmp['id']]['length_class_id'] = '';
				$data[$tmp['id']]['tax_class_id'] = '';
				$data[$tmp['id']]['sort_order'] = 0;
			$data[$tmp['id']]['product_description'][1]['name'] = $tmp['name'];
			$data[$tmp['id']]['product_description'][1]['description'] = $tmp['text'];
			$data[$tmp['id']]['product_description'][1]['meta_title'] = $tmp['name'];
			$data[$tmp['id']]['product_description'][1]['meta_description'] = $tmp['text'];
			$data[$tmp['id']]['product_description'][1]['meta_keyword'] = $tmp['name'];
			$data[$tmp['id']]['product_description'][1]['tag'] = $tmp['name'];
		
			$data[$tmp['id']]['original_url'] = $tmp['origin_url'];
			$data[$tmp['id']]['original_code'] = $tmp['code'];
			
				$sql = 'SELECT * FROM '.$this->pp.'product_media WHERE product_id = "'.$product_id.'"';
				$r1 = $this->from->query($sql) or die($sql);
				
				$tmp1 = $r1->fetch_assoc();
				
				$pic[1] = '';
				if($tmp1['front'] != ''){
					$pic[1] = 'catalog/images/large_front_'.$tmp1['front'];
				}
				$pic[2] = '';
				if($tmp1['back'] != ''){
					$pic[2] = 'catalog/images/large_back_'.$tmp1['back'];
				}
				$pic[3] = '';
				if($tmp1['middle'] != ''){
					$pic[3] = 'catalog/images/large_middle_'.$tmp1['middle'];
				}
				$pic[4] = '';
				if($tmp1['other'] != ''){
					$pic[4] = 'catalog/images/large_other_'.$tmp1['other'];
				}
				
			$data[$product_id]['image'] = $pic[1];
			$count = 0;
		
			for($i = 1; $i <= 4; $i++){
				if($pic[$i] != ''){
					$data[$product_id]['product_image'][$count]['image'] = $pic[$i];
					$data[$product_id]['product_image'][$count]['sort_order'] = 0;
					$count++;
				}
			}
			
			$data[$product_id]['model'] = $tmp['code'];
			$data[$product_id]['sku'] = $tmp['code'];
			$data[$product_id]['price'] = $tmp['real_cost'];
			if($tmp['is_sold'] == 0){
				$data[$product_id]['quantity'] = 1;
			}else{
				$data[$product_id]['quantity'] = 0;
			}
			$data[$product_id]['minimum'] = 1;
			$data[$product_id]['shipping'] = 1;
			$data[$product_id]['keyword'] = $tmp['url']; //'product/view/'.
			$data[$product_id]['status'] = 1;
			$data[$product_id]['stock_status_id'] = 1;
			if(isset($manuf[$tmp['designer_id']])){
				$data[$product_id]['manufacturer'] = $manuf[$tmp['designer_id']];
				$data[$product_id]['manufacturer_id'] = $tmp['designer_id'];
			}else{
				$data[$product_id]['manufacturer'] = '';
				$data[$product_id]['manufacturer_id'] = 0;
			}
			
			$data[$product_id]['price'] = $tmp['real_cost'];
			$data[$product_id]['price'] = $tmp['real_cost'];
			$data[$product_id]['price'] = $tmp['real_cost'];
			
			$data[$product_id]['product_store'] = array(0 => 0);
			
			$sql = 'SELECT * FROM '.$this->pp.'product2filters WHERE product_id = "'.$product_id.'";';
			$r2 = $this->from->query($sql) or die($sql);
			if($r2->num_rows > 0){
				$attr = array();
				$count_att = 0;
				while($tmp_a = $r2->fetch_assoc()){
					$array[$count_att]['name'] = '';
					$array[$count_att]['attribute_id'] = $tmp_a['filter_id'];
					$array[$count_att]['product_attribute_description'] = array('1' => array('text' => '1'));
				}
			}
			
			$sql = 'SELECT * FROM '.$this->pp.'product2size WHERE product_id = "'.$product_id.'";';
			$r2 = $this->from->query($sql) or die($sql);
			while($tmp2 = $r2->fetch_assoc()){
				$sql = 'INSERT INTO '.DB_PREFIX.'product_to_size SET
								product_id = \''.$product_id.'\',
								size_id = \''.$tmp2['size_id'].'\'
								ON DUPLICATE KEY UPDATE size_id = \''.$tmp2['size_id'].'\';';
				$this->db->query($sql) or die($sql);
			}
			
			$sql = 'SELECT * FROM '.$this->pp.'product2category WHERE product_id = "'.$product_id.'";';
			$r2 = $this->from->query($sql) or die($sql);
			$categ = array();
			while($tmp2 = $r2->fetch_assoc()){
				$categ[] = $tmp2['podcategory_id'];
			}
			if(count($categ) > 0){
				$data[$product_id]['product_category'] = $categ;
			}
			
		//return $data;
		}
		
		return $data;
	}

	
	
	
}
