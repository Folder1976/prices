<?php

class Product
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
	
	/*
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
	$data['sizes'][$size]['price'];
	$data['sizes'][$size]['instock'];
	$data['sizes'][$size]['prices'];
	*/
	
    public function getProductIdOnOriginUrl($url){
		$pp = $this->pp;
		
		$sql = 'SELECT product_id FROM `'.$pp.'product` WHERE
				upper(`original_url`) = "'.mb_strtoupper(addslashes($url),'UTF-8').'";';
		//echo $sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp['product_id'];
		}
		
		return 0;
		
	}

	public function addProduct($data){

		$sql = "INSERT INTO " . $this->pp . "product SET
									sale = '0',
									model = '" . $data['model'] . "',
									moderation_id = '" . $data['moderation_id'] . "',
									original_url = '" . $data['original_url'] . "',
									original_code = '" . $data['original_code'] . "',
									sku = '" . $data['sku'] . "',
									upc = '" . $data['upc'] . "',
									ean = '" . $data['ean'] . "',
									jan = '" . $data['jan'] . "',
									isbn = '" . $data['isbn'] . "',
									mpn = '" . $data['mpn'] . "',
									location = '" . $data['location'] . "',
									quantity = '" . (int)$data['quantity'] . "',
									minimum = '" . (int)$data['minimum'] . "',
									subtract = '" . (int)$data['subtract'] . "',
									stock_status_id = '" . (int)$data['stock_status_id'] . "',
									date_available = '" . $data['date_available'] . "',
									manufacturer_id = '" . (int)$data['manufacturer_id'] . "',
									shipping = '" . (int)$data['shipping'] . "',
									price = '" . (float)$data['price'] . "',
									points = '" . (int)$data['points'] . "',
									weight = '" . (float)$data['weight'] . "',
									weight_class_id = '" . (int)$data['weight_class_id'] . "',
									length = '" . (float)$data['length'] . "',
									width = '" . (float)$data['width'] . "',
									height = '" . (float)$data['height'] . "',
									length_class_id = '" . (int)$data['length_class_id'] . "',
									status = '" . (int)$data['status'] . "',
									tax_class_id = '" . (int)$data['tax_class_id'] . "',
									sort_order = '" . (int)$data['sort_order'] . "',
									date_added = NOW()";
		$this->db->query('SET NAMES utf8');
		$this->db->query($sql);
//echo '<br><br>'.$sql;
		$product_id = $this->db->insert_id;


		//Если индексированое добавление
		if(isset($data['product_id']) AND is_numeric($data['product_id'])){
			$sql = 'UPDATE ' . $this->pp . 'product SET product_id = "'.(int)$data['product_id'].'" WHERE product_id = "'.$product_id.'";';
			$this->db->query($sql) or die($sql);
			$product_id = (int)$data['product_id'];
		}

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . $this->pp . "product SET image = '" . $data['image'] . "' WHERE product_id = '" . (int)$product_id . "'") or die($sql);
		}

		foreach ($data['product_description'] as $language_id => $value) {
			$sql = "INSERT INTO " . $this->pp . "product_description SET product_id = '" . (int)$product_id . "',
										language_id = '" . (int)$language_id . "',
										name = '" . htmlentities($value['name'],ENT_QUOTES, 'UTF-8') . "',
										description = '" . htmlentities($value['description'],ENT_QUOTES, 'UTF-8') . "',
										tag = '" . htmlentities($value['tag'],ENT_QUOTES, 'UTF-8') . "',
										meta_title = '" . htmlentities($value['meta_title'],ENT_QUOTES, 'UTF-8') . "',
										meta_description = '" . htmlentities($value['meta_description'],ENT_QUOTES, 'UTF-8') . "',
										meta_keyword = '" . htmlentities($value['meta_keyword'],ENT_QUOTES, 'UTF-8') . "'";
			$this->db->query($sql) or die('dflijgodifjhgioufdhg ' . $sql);
		}

		
		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_to_store SET
										product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'") or die('dsgsdfgfdg');
			}
		}

		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
						$this->db->query("INSERT INTO " . $this->pp . "product_attribute SET
											product_id = '" . (int)$product_id . "',
											attribute_id = '" . (int)$product_attribute['attribute_id'] . "',
											language_id = '" . (int)$language_id . "',
											text = '" .  $product_attribute_description['text'] . "'") or die('dfsgsdfgsdfg');
					}
				}
			}
		}

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					if (isset($product_option['product_option_value'])) {
						$this->db->query("INSERT INTO " . $this->pp . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'") or die('fgjjj');

						$product_option_id = $this->db->insert_id;

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$this->db->query("INSERT INTO " . $this->pp . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->escape($product_option_value['weight_prefix']) . "'") or die('uywtrgsdf');
						}
					}
				} else {
					$this->db->query("INSERT INTO " . $this->pp . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $product_option['value'] . "', required = '" . (int)$product_option['required'] . "'") or die('dhgjoiyherpt');
				}
			}
		}

		//Если есть разница по ценам
		$sale = 0;
		if (isset($data['oldprice'])) {
			if($data['oldprice'] > 0 AND $data['oldprice'] > $data['price']) {
				$data['product_attribute'][580]['attribute_id'] = 580;
				$data['product_attribute'][580]['name'] = '1';
				$data['product_attribute'][580]['product_attribute_description'][1]['text'] = '1';
				$sale = $data['product_attribute'][580]['value'] = (100 - ((int)$data['price'] / ((int)$data['oldprice'] / 100)));
			}
		}else{
			$sale = 0;
			$data['oldprice'] = 0;
		}
		$this->db->query("UPDATE " . $this->pp . "product SET sale = '".$sale."',
						 old_price = '" . (int)$data['oldprice'] . "'
						 WHERE product_id = '" . (int)$product_id . "'");

		if (!isset($data['product_attribute']) AND !empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					
					if(!isset($product_attribute['value'])) $product_attribute['value'] = 0;
					
					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
						
						$sql = "INSERT INTO " . $this->pp . "product_attribute SET product_id = '" . (int)$product_id . "',
										 attribute_id = '" . (int)$product_attribute['attribute_id'] . "',
										 language_id = '" . (int)$language_id . "',
										 value = '" . $product_attribute['value'] . "',
										 text = '" .  $this->escape($product_attribute_description['text']) . "'";
						$this->db->query($sql);
					}
				}
			}
		}

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . $this->pp . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->escape($product_discount['date_start']) . "', date_end = '" . $this->escape($product_discount['date_end']) . "'") or die('sdfgsdy7u');
			}
		}

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . $this->pp . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->escape($product_special['date_start']) . "', date_end = '" . $this->escape($product_special['date_end']) . "'") or die('oiutgwqefibfv');
			}
		}

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . $this->pp . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->escape($product_image['image']) . "', sort_order = '" . (int)$product_image['sort_order'] . "'") or die('iugvogbq');
			}
		}

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'") or die('iughasvougadfovhoadf0ihn');
			}
		}

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_to_category
								 SET product_id = '" . (int)$product_id . "',
								 category_id = '" . (int)$category_id . "'
								 ON DUPLICATE KEY UPDATE category_id = '" . (int)$category_id . "'
								 ") or die('uivag uaerg');
			}
		}

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'") or die('vubaven');
			}
		}

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . $this->pp . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'") or die('ufg40734');
				$this->db->query("INSERT INTO " . $this->pp . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'") or die('98fq3tgvub');
				$this->db->query("DELETE FROM " . $this->pp . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'") or die('yfvgcp3qb');
				$this->db->query("INSERT INTO " . $this->pp . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'") or die('bv2ergw	gvawr');
			}
		}

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
				if ((int)$product_reward['points'] > 0) {
					$this->db->query("INSERT INTO " . $this->pp . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$product_reward['points'] . "'");
				}
			}
		}

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['product_shop'])) {
			foreach ($data['product_shop'] as $index => $shop_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_to_shop SET product_id = '" . (int)$product_id . "', shop_id = '" . (int)$shop_id . "'");
			}
		}

		if (isset($data['product_size'])) {
			foreach ($data['product_size'] as $size_id => $group_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_to_size SET product_id = '" . (int)$product_id . "', size_id = '" . (int)$size_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			if($data['keyword_add_id'] AND $data['keyword_add_id'] == 1){
				$data['keyword'] .= '-' . $product_id;
			}
			
			$this->db->query("INSERT INTO " . $this->pp . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->escape($data['keyword']) . "'");
		}

		if (isset($data['product_recurrings'])) {
			foreach ($data['product_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . $this->pp . "product_recurring` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		return $product_id;
}

	public function editProduct($product_id, $data) {
	
		$sql = "UPDATE " . $this->pp . "product SET
								model = '" . $this->escape($data['model']) . "',
								sale = '0',
								original_url = '" . $this->escape($data['original_url']) . "',
								original_code = '" . $this->escape($data['original_code']) . "',
								sku = '" . $this->escape($data['sku']) . "',
								upc = '" . $this->escape($data['upc']) . "',
								ean = '" . $this->escape($data['ean']) . "',
								jan = '" . $this->escape($data['jan']) . "',
								isbn = '" . $this->escape($data['isbn']) . "',
								mpn = '" . $this->escape($data['mpn']) . "',
								location = '" . $this->escape($data['location']) . "',
								quantity = '" . (int)$data['quantity'] . "',
								minimum = '" . (int)$data['minimum'] . "',
								subtract = '" . (int)$data['subtract'] . "',
								stock_status_id = '" . (int)$data['stock_status_id'] . "',
								date_available = '" . $this->escape($data['date_available']) . "',
								manufacturer_id = '" . (int)$data['manufacturer_id'] . "',
								shipping = '" . (int)$data['shipping'] . "',
								price = '" . (float)$data['price'] . "',
								points = '" . (int)$data['points'] . "',
								weight = '" . (float)$data['weight'] . "',
								weight_class_id = '" . (int)$data['weight_class_id'] . "',
								length = '" . (float)$data['length'] . "',
								width = '" . (float)$data['width'] . "',
								height = '" . (float)$data['height'] . "',
								length_class_id = '" . (int)$data['length_class_id'] . "',
								status = '" . (int)$data['status'] . "',
								tax_class_id = '" . (int)$data['tax_class_id'] . "',
								sort_order = '" . (int)$data['sort_order'] . "',
								date_modified = NOW()
								WHERE product_id = '" . (int)$product_id . "'";
		$this->db->query($sql);

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . $this->pp . "product SET image = '" . $this->escape($data['image']) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
	
		if (isset($data['moderation_id'])) {
			$this->db->query("UPDATE " . $this->pp . "product SET moderation_id = '" . (int)$data['moderation_id'] . "' WHERE product_id = '" . (int)$product_id . "'");
		}

		$this->db->query("DELETE FROM " . $this->pp . "product_description WHERE product_id = '" . (int)$product_id . "'");

		foreach ($data['product_description'] as $language_id => $value) {
			$sql = "INSERT INTO " . $this->pp . "product_description SET
										product_id = '" . (int)$product_id . "',
										language_id = '" . (int)$language_id . "',
										name = '" . htmlentities($this->escape($value['name']),ENT_QUOTES, 'UTF-8') . "',
										description = '" . $value['description'] . "',
										tag = '" . htmlentities($this->escape($value['tag']),ENT_QUOTES, 'UTF-8') . "',
										meta_title = '" . htmlentities($this->escape($value['meta_title']),ENT_QUOTES, 'UTF-8') . "',
										meta_description = '" . htmlentities($this->escape($value['meta_description']),ENT_QUOTES, 'UTF-8') . "',
										meta_keyword = '" . htmlentities($this->escape($value['meta_keyword']),ENT_QUOTES, 'UTF-8') . "'";
			$this->db->query($sql);
		}
		
//echo '<br><br>'.$sql;

		$this->db->query("DELETE FROM " . $this->pp . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		//Если есть разница по ценам
		$this->db->query("DELETE FROM " . $this->pp . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id='580'");
		if (isset($data['oldprice'])) {
			if($data['oldprice'] > 0 AND $data['oldprice'] > $data['price']) {
				$data['product_attribute'][580]['attribute_id'] = 580;
				$data['product_attribute'][580]['name'] = '1';
				$data['product_attribute'][580]['product_attribute_description'][1]['text'] = '1';
				$data['product_attribute'][580]['value'] = (100 - ((int)$data['price'] / ((int)$data['oldprice'] / 100)));
				
				$sql = "INSERT INTO " . $this->pp . "product_attribute SET product_id = '" . (int)$product_id . "',
											 attribute_id = '580',
											 language_id = '" . (int)$language_id . "',
											 value = '" . $data['product_attribute'][580]['value'] . "',
											 text = '1'";
				$this->db->query($sql);
				
				$sql = "UPDATE " . $this->pp . "product SET sale = '".$data['product_attribute'][580]['value']."' WHERE product_id = '" . (int)$product_id . "';";
				$this->db->query($sql);
			}
		}else{
			$data['oldprice'] = 0;
		}
		$this->db->query("UPDATE " . $this->pp . "product SET old_price = '" . (int)$data['oldprice'] . "' WHERE product_id = '" . (int)$product_id . "'");

		if(!isset($data['ignore_attribute'])){
			$this->db->query("DELETE FROM " . $this->pp . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
	
			if (!empty($data['product_attribute'])) {
				foreach ($data['product_attribute'] as $product_attribute) {
					if ($product_attribute['attribute_id']) {
						foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
							
							if(!isset($product_attribute['value'])) $product_attribute['value'] = 0;
							
							$sql = "INSERT INTO " . $this->pp . "product_attribute SET product_id = '" . (int)$product_id . "',
											 attribute_id = '" . (int)$product_attribute['attribute_id'] . "',
											 language_id = '" . (int)$language_id . "',
											 value = '" . $product_attribute['value'] . "',
											 text = '" .  $this->escape($product_attribute_description['text']) . "'";
							$this->db->query($sql);
						}
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . $this->pp . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . $this->pp . "product_option_value WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					if (isset($product_option['product_option_value'])) {
						$this->db->query("INSERT INTO " . $this->pp . "product_option SET
										 product_option_id = '" . (int)$product_option['product_option_id'] . "',
										 product_id = '" . (int)$product_id . "',
										 option_id = '" . (int)$product_option['option_id'] . "',
										 required = '" . (int)$product_option['required'] . "'");

						$product_option_id = $this->db->insert_id;

						foreach ($product_option['product_option_value'] as $product_option_value) {
							
							$sql = "INSERT INTO " . $this->pp . "product_option_value SET
											 product_option_id = '" . (int)$product_option_id . "',
											 product_id = '" . (int)$product_id . "',
											 option_id = '" . (int)$product_option['option_id'] . "',
											 option_value_id = '" . (int)$product_option_value['option_value_id'] . "',
											 quantity = '" . (int)$product_option_value['quantity'] . "',
											 subtract = '" . (int)$product_option_value['subtract'] . "',
											 price = '" . (float)$product_option_value['price'] . "',
											 alternative_size = '" . $product_option_value['alternative_size'] . "',
											 price_prefix = '" . $this->escape($product_option_value['price_prefix']) . "',
											 points = '" . (int)$product_option_value['points'] . "',
											 points_prefix = '" . $this->escape($product_option_value['points_prefix']) . "',
											 weight = '" . (float)$product_option_value['weight'] . "',
											 weight_prefix = '" . $this->escape($product_option_value['weight_prefix']) . "'";
							if(isset($product_option_value['product_option_value_id'])){
								$sql .= ', product_option_value_id = ' .$product_option_value['product_option_value_id'].'';
							}
							
							$this->db->query($sql);
							
						}
					}
				} else {
					$this->db->query("INSERT INTO " . $this->pp . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . $this->pp . "product_discount WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . $this->pp . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->escape($product_discount['date_start']) . "', date_end = '" . $this->escape($product_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . $this->pp . "product_special WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . $this->pp . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->escape($product_special['date_start']) . "', date_end = '" . $this->escape($product_special['date_end']) . "'");
			}
		}
	
		if(isset($data['no_size_reset'])){}else{
			$this->db->query("DELETE FROM " . $this->pp . "product_to_size WHERE product_id = '" . (int)$product_id . "'");
		}
		if (isset($data['product_size'])) {
			foreach ($data['product_size'] as $size_id => $group_id) {
				$sql = "INSERT INTO " . $this->pp . "product_to_size SET
						product_id = '" . (int)$product_id . "',
						size_id = '" . (int)$size_id . "'
						ON DUPLICATE KEY UPDATE size_id = '" . (int)$size_id . "';";
				//echo '<br><br>'.$sql;
				$this->db->query($sql) or die($sql);
			}
		}
	
		
		if (isset($data['product_shop'])) {
			foreach ($data['product_shop'] as $index => $shop_id) {
				$this->db->query("DELETE FROM " . $this->pp . "product_to_shop WHERE product_id = '" . (int)$product_id . "' AND shop_id = '" . (int)$shop_id . "'");
				$this->db->query("INSERT INTO " . $this->pp . "product_to_shop SET product_id = '" . (int)$product_id . "', shop_id = '" . (int)$shop_id . "'");
			}
		}

		
		$this->db->query("DELETE FROM " . $this->pp . "product_image WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . $this->pp . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->escape($product_image['image']) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . $this->pp . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		
		if(isset($data['product_category'])){
			$this->db->query("DELETE FROM " . $this->pp . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
	
			if (isset($data['product_category'])) {
				foreach ($data['product_category'] as $category_id) {
					$this->db->query("INSERT INTO " . $this->pp . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . $this->pp . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . $this->pp . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . $this->pp . "product_related WHERE related_id = '" . (int)$product_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . $this->pp . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . $this->pp . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . $this->pp . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . $this->pp . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . $this->pp . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $value) {
				if ((int)$value['points'] > 0) {
					$this->db->query("INSERT INTO " . $this->pp . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . $this->pp . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . $this->pp . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if($data['keyword_add_id'] AND $data['keyword_add_id'] == 1){
			$data['keyword'] .= '-' . $product_id;
		}
		
		$this->db->query("DELETE FROM " . $this->pp . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . $this->pp . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM `" . $this->pp . "product_recurring` WHERE product_id = " . (int)$product_id);

		if (isset($data['product_recurring'])) {
			foreach ($data['product_recurring'] as $product_recurring) {
				$this->db->query("INSERT INTO `" . $this->pp . "product_recurring` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$product_recurring['customer_group_id'] . ", `recurring_id` = " . (int)$product_recurring['recurring_id']);
			}
		}

	}

	public function dellProduct($product_id){
		
		$pp = $this->pp;

			$this->db->query("DELETE FROM " . $pp . "product_to_size WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_description WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_discount WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_filter WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_image WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_option WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_related WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_related WHERE related_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_reward WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_special WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "product_recurring WHERE product_id = " . (int)$product_id);
			$this->db->query("DELETE FROM " . $pp . "review WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . $pp . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");

	}
	
	public function dellImages(){
		
		set_time_limit(0);
		ini_set("max_execution_time","0");
		ini_set("memory_limit","256G");
		error_reporting(E_ALL ^ E_DEPRECATED);
		
		$pp = $this->pp;
		
		//Получим общие картинки
		$sql = 'SELECT distinct image FROM `'.$pp.'product_image`;';
		$r = $this->db->query($sql) or die($sql);
		
		$images = array();
		while($row = $r->fetch_assoc()){
			$images[$row['image']] = $row['image'];
		}
			
		//Поулчим товарные картинки	
		$sql = 'SELECT distinct image FROM `'.$pp.'product`;';
		$r = $this->db->query($sql) or die($sql);
		
		while($row = $r->fetch_assoc()){
			$images[$row['image']] = $row['image'];
		}
		
		$dir = $uploaddir = '../image/product/';
		
		$dh  = opendir($dir);
		while (false !== ($filename = readdir($dh))) {
			if ($filename != "." && $filename != "..") { 
				
				if(!isset($images['product/'.$filename])){
					echo '<br>DEL '.'product/'.$filename;
					unlink('../image/product/'.$filename);
				}else{
					//echo '<br>+++ '.'product/'.$filename;
				}
			}
		}	

	}
	

	
	public function escape($str){
		return $str;
	}
	
	public function translitArtkl($str) {
		$rus = array(',',':',';','#','#039;','(',')',"\\",'/','№','»','«',"'",'"','и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
	    $lat = array('','','','','','','','','','','','','','','u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
		
		return  strtolower(trim(str_replace($rus, $lat, $str)));
	}
	
	public function getProducts($data = array()) {
		$sql = "SELECT * FROM " . $this->pp . "product p
				LEFT JOIN " . $this->pp . "product_description pd ON (p.product_id = pd.product_id)
				LEFT JOIN " . $this->pp . "product_to_shop p2s ON (p.product_id = p2s.product_id)
				LEFT JOIN " . $this->pp . "product_to_category p2c ON (p.product_id = p2c.product_id)
				LEFT JOIN " . $this->pp . "category_path cp ON (p2c.category_id = cp.category_id)
				WHERE pd.language_id = '1'
				";

		if (!empty($data['filter_name'])) {
			$sql .= " AND (pd.name LIKE '%" . $this->escape(trim($data['filter_name'])) . "%'";
			$sql .= " OR p.model LIKE '%" . $this->escape(trim($data['filter_model'])) . "%')";
		}

		if (!empty($data['filter_model'])) {
			//$sql .= " AND p.model LIKE '%" . $this->escape(trim($data['filter_model'])) . "%'";
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['filter_moderation']) && !is_null($data['filter_moderation'])) {
			$sql .= " AND p.moderation_id = '" . (int)$data['filter_moderation'] . "'";
		}
		
		if (isset($data['filter_manufacturer']) && !is_null($data['filter_manufacturer'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer'] . "'";
		}

		if (isset($data['filter_shop']) && !is_null($data['filter_shop'])) {
			$sql .= " AND p2s.shop_id = '" . (int)$data['filter_shop'] . "'";
		}

		if (isset($data['filter_category']) && !is_null($data['filter_category'])) {
			$sql .= " AND cp.path_id = '" . (int)$data['filter_category'] . "'";
		}

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		//echo $sql; 
		$query = $this->db->query($sql);

		$return = array();
		while($tmp = $query->fetch_assoc()){
			$return[$tmp['product_id']] = $tmp;
		}
		
		return $return;
	}
	public function getProduct($product_id) {
		$sql = "SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer,
					(SELECT price FROM " . $this->pp . "product_discount pd2
							WHERE pd2.product_id = p.product_id AND pd2.quantity = '1' AND
									((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND
									(pd2.date_end = '0000-00-00' OR pd2.date_end > NOW()))
							ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount,
					(SELECT price FROM " . $this->pp . "product_special ps
							WHERE ps.product_id = p.product_id AND
									((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND
									(ps.date_end = '0000-00-00' OR ps.date_end > NOW()))
							ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special,
					(SELECT AVG(rating) AS total FROM " . $this->pp . "review r1
							WHERE r1.product_id = p.product_id AND r1.status = '1'
							GROUP BY r1.product_id) AS rating,
					(SELECT ss.name FROM " . $this->pp . "stock_status ss
							WHERE ss.stock_status_id = p.stock_status_id AND
									ss.language_id = '1') AS stock_status,
					(SELECT p2c.category_id FROM " . $this->pp . "product_to_category p2c
							WHERE p2c.product_id = p.product_id LIMIT 0,1) AS category_id,
					(SELECT sh.shop_id FROM " . $this->pp . "product_to_shop sh
							WHERE sh.product_id = p.product_id LIMIT 0,1) AS shop_id,
					p.sort_order
				FROM " . $this->pp . "product p
				LEFT JOIN " . $this->pp . "product_description pd ON (p.product_id = pd.product_id)
				LEFT JOIN " . $this->pp . "product_to_store p2s ON (p.product_id = p2s.product_id)
				LEFT JOIN " . $this->pp . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
				WHERE p.product_id = '" . (int)$product_id . "' AND
						p.status = '1' AND
						pd.language_id = 1 AND
						p.date_available <= NOW()
						;";
	
		$query = $this->db->query($sql) or die('lfl ase9 0 '. $sql);

		if ($query->num_rows) {
			$row = $query->fetch_assoc();
			
			$return = array(
				'product_id'       => $row['product_id'],
				'shop_id'       	=> $row['shop_id'],
				'category_id'       => $row['category_id'],
				'name'             => $row['name'],
				'description'      => $row['description'],
				'moderation_id'      => $row['moderation_id'],
				'original_url'      => $row['original_url'],
				'original_code'      => $row['original_code'],
				'meta_title'       => $row['meta_title'],
				'meta_description' => $row['meta_description'],
				'meta_keyword'     => $row['meta_keyword'],
				'tag'              => $row['tag'],
				'model'            => $row['model'],
				'sku'              => $row['sku'],
				'upc'              => $row['upc'],
				'ean'              => $row['ean'],
				'jan'              => $row['jan'],
				'isbn'             => $row['isbn'],
				'mpn'              => $row['mpn'],
				'location'         => $row['location'],
				'quantity'         => $row['quantity'],
				'stock_status'     => $row['stock_status'],
				'image'            => $row['image'],
				'manufacturer_id'  => $row['manufacturer_id'],
				'manufacturer'     => $row['manufacturer'],
				'price'            => ($row['discount'] ? $row['discount'] : $row['price']),
				'old_price'         => $row['old_price'],
				'click_price'         => $row['click_price'],
				'sale'            => $row['sale'],
				'special'          => $row['special'],
				'reward'           => 0 /*$query->row['reward']*/,
				'points'           => $row['points'],
				'tax_class_id'     => $row['tax_class_id'],
				'date_available'   => $row['date_available'],
				'weight'           => $row['weight'],
				'weight_class_id'  => $row['weight_class_id'],
				'length'           => $row['length'],
				'width'            => $row['width'],
				'height'           => $row['height'],
				'length_class_id'  => $row['length_class_id'],
				'subtract'         => $row['subtract'],
				'rating'           => round($row['rating']),
				'reviews'          => 0 /*$query->row['reviews'] ? $query->row['reviews'] : 0*/,
				'minimum'          => $row['minimum'],
				'sort_order'       => $row['sort_order'],
				'status'           => $row['status'],
				'date_added'       => $row['date_added'],
				'images'       		=> array(),
				'date_modified'    => $row['date_modified'],
				'viewed'           => $row['viewed']
			);
			$sql = 'SELECT image FROM '.$this->pp.'product_image WHERE product_id = "'.$product_id.'"';
			$query = $this->db->query($sql);
			if ($query->num_rows) {
				$images = array();
				while($row = $query->fetch_assoc()){
					$images[] = $row['image'];
				}
				$return['images'] = $images;
			}
			
			return $return;
			
			
		} else {
			return false;
		}
	}

	public function getProductsID($data = array()) {
		$sql = "SELECT p.product_id FROM " . $this->pp . "product p
				LEFT JOIN " . $this->pp . "product_description pd ON (p.product_id = pd.product_id)
				LEFT JOIN " . $this->pp . "product_to_shop p2s ON (p.product_id = p2s.product_id)
				LEFT JOIN " . $this->pp . "product_to_category p2c ON (p.product_id = p2c.product_id)
				LEFT JOIN " . $this->pp . "category_path cp ON (p2c.category_id = cp.category_id)
				WHERE pd.language_id = '1'
				";

		if (!empty($data['filter_name'])) {
			$sql .= " AND (pd.name LIKE '%" . $this->escape(trim($data['filter_name'])) . "%'";
			$sql .= " OR p.model LIKE '%" . $this->escape(trim($data['filter_model'])) . "%')";
		}

		if (!empty($data['filter_model'])) {
			//$sql .= " AND p.model LIKE '%" . $this->escape(trim($data['filter_model'])) . "%'";
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['filter_moderation']) && !is_null($data['filter_moderation'])) {
			$sql .= " AND p.moderation_id = '" . (int)$data['filter_moderation'] . "'";
		}
		
		if (isset($data['filter_manufacturer']) && !is_null($data['filter_manufacturer'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer'] . "'";
		}

		if (isset($data['filter_shop']) && !is_null($data['filter_shop'])) {
			$sql .= " AND p2s.shop_id = '" . (int)$data['filter_shop'] . "'";
		}

		if (isset($data['filter_category']) && !is_null($data['filter_category'])) {
			$sql .= " AND cp.path_id = '" . (int)$data['filter_category'] . "'";
		}

		$sql .= " GROUP BY p.product_id";

		$sql .= " ORDER BY pd.name";
	
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
	
	//echo $sql;
	
		$query = $this->db->query($sql);

		$return = array();
		while($tmp = $query->fetch_assoc()){
			$return[$tmp['product_id']] = $tmp['product_id'];
		}
		
		return $return;
	}


}

?>
