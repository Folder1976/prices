<?php
class ModelCatalogProduct extends Model {
	public function addProduct($data) {
		
		$this->event->trigger('pre.admin.product.add', $data);

		if(!isset($data['moderation_id'])) $data['moderation_id'] = 0;
		
		$data['code'] = $data['keyword'];
		
		$product_id = '';
		if(isset($data['product_id'])) $product_id = $data['product_id'];
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET
									product_id = '" . $product_id . "',
									model = '" . $this->db->escape($data['model']) . "',
									code = '" . $this->db->escape($data['code']) . "',
									moderation_id = '" . $this->db->escape($data['moderation_id']) . "',
									original_url = '" . $this->db->escape($data['original_url']) . "',
									original_code = '" . $this->db->escape($data['original_code']) . "',
									sku = '" . $this->db->escape($data['sku']) . "',
									upc = '" . $this->db->escape($data['upc']) . "',
									ean = '" . $this->db->escape($data['ean']) . "',
									jan = '" . $this->db->escape($data['jan']) . "',
									isbn = '" . $this->db->escape($data['isbn']) . "',
									mpn = '" . $this->db->escape($data['mpn']) . "',
									location = '" . $this->db->escape($data['location']) . "',
									quantity = '" . (int)$data['quantity'] . "',
									garant = '" . (int)$data['garant'] . "',
									minimum = '" . (int)$data['minimum'] . "',
									subtract = '" . (int)$data['subtract'] . "',
									stock_status_id = '" . (int)$data['stock_status_id'] . "',
									date_available = '" . $this->db->escape($data['date_available']) . "',
									manufacturer_id = '" . (int)$data['manufacturer_id'] . "',
									shipping = '" . (int)$data['shipping'] . "',
									zakup = '" . (float)$data['zakup'] . "',
									price = '" . (float)$data['price'] . "',
									points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$product_id = $this->db->getLastId();
		
		//Если индексированое добавление
		if(isset($data['product_id']) AND is_numeric($data['product_id'])){
			$sql = 'UPDATE ' . DB_PREFIX . 'product SET product_id = "'.(int)$data['product_id'].'" WHERE product_id = "'.$product_id.'";';
			$this->db->query($sql) or die($sql);
			$product_id = (int)$data['product_id'];
		}

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$product_id . "'");
		}

		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET
							 product_id = '" . (int)$product_id . "',
							 language_id = '" . (int)$language_id . "',
							 name = '" . $this->db->escape($value['name']) . "',
							 description = '" . $this->db->escape($value['description']) . "',
							 description_detail = '" . $this->db->escape($value['description_detail']) . "',
							 tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					if (isset($product_option['product_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");

						$product_option_id = $this->db->getLastId();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET
												product_option_id = '" . (int)$product_option_id . "',
												alternative_size = '" . (int)$product_option_value['alternative_size'] . "',
												product_id = '" . (int)$product_id . "',
												option_id = '" . (int)$product_option['option_id'] . "',
												option_value_id = '" . (int)$product_option_value['option_value_id'] . "',
												quantity = '" . (int)$product_option_value['quantity'] . "',
												subtract = '" . (int)$product_option_value['subtract'] . "',
												price = '" . (float)$product_option_value['price'] . "',
												price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "',
												points = '" . (int)$product_option_value['points'] . "',
												points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "',
												weight = '" . (float)$product_option_value['weight'] . "',
												weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
							$product_option_value_id = $this->db->getLastId();
							
							//Заэкранировано
							if(!isset($product_option_value['price_prefix'])) $product_option_value['price_prefix'] = 0;
							if(!isset($product_option_value['points'])) $product_option_value['points'] = 0;
							if(!isset($product_option_value['points_prefix'])) $product_option_value['points_prefix'] = 0;
							if(!isset($product_option_value['weight'])) $product_option_value['weight'] = 0;
							if(!isset($product_option_value['weight_prefix'])) $product_option_value['weight_prefix'] = 0;
							if(!isset($product_option_value['price'])) $product_option_value['price'] = 0;
							
							
							
							if(isset($product_option_value['params'])){
								foreach ($product_option_value['params'] as $index => $value) {
									if($value > 0){
										$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_params SET
													 product_option_value_id = '" . (int)$product_option_value_id . "',
													 param_key = '" . $this->db->escape($index). "',
													 param_value = '" . $this->db->escape($value) . "'");
									}
								}
							}
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
		}

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "',
								 price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($product_image['image']) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		//$this->_checkClausesAndMakeDecisionToUpdateRelationships($data, $product_id);
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				if(isset($data['main_relationships']) AND (int)$data['main_relationships'] == (int)$category_id){
					$sql = "INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "', is_main = '1'";
				}elseif(isset($data['main_relationships'])){
					$sql = "INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "', is_main = '0'";
				}else{
					$sql = "INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "', is_main = '1'";
				}
				$this->db->query($sql);
			}
		}


		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
				if ((int)$product_reward['points'] > 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$product_reward['points'] . "'");
				}
			}
		}

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['product_recurrings'])) {
			foreach ($data['product_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_recurring` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('product');

		$this->event->trigger('post.admin.product.add', $product_id);

		return $product_id;
	}

	
	public function updateProductImages($product_id, $images) {
		
		$sql = 'SELECT image FROM ' . DB_PREFIX . 'product WHERE product_id = '.(int)$product_id.' LIMIT 0,1';
		$r = $this->db->query($sql);
		
		if($r->num_rows){
			$product = $r->row;
			
			//Если у товара нет главной картинки
			if($product['image'] == '' OR $product['image'] == 'product/.jpg' OR !file_exists(DIR_IMAGE.$product['image'])){
				
				$image = array_shift($images);
				$sql = "UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($image) . "' WHERE product_id = '" . (int)$product_id . "'";
				$this->db->query($sql);
				//echo '<br>'.$sql;
			}
			
			
			//Если остались еще картинки
			if(count($images)){
				
				foreach($images as $image){
					$sql = "INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($image) . "', sort_order = '0'";
					$this->db->query($sql);
					//echo '<br>'.$sql;
				}
				
			}
			
		}
		//die();
	}
	
	public function editProduct($product_id, $data) {
		
		$this->event->trigger('pre.admin.product.edit', $data);

		if(!isset($data['moderation_id'])) $data['moderation_id'] = 0;
		
		$data['code'] = $data['keyword'];
		
		$this->db->query("UPDATE " . DB_PREFIX . "product SET
								model = '" . $this->db->escape($data['model']) . "',
								moderation_id = '" . $this->db->escape($data['moderation_id']) . "',
								original_url = '" . $this->db->escape($data['original_url']) . "',
								original_code = '" . $this->db->escape($data['original_code']) . "',
								sku = '" . $this->db->escape($data['sku']) . "',
								code = '" . $this->db->escape($data['code']) . "',
								upc = '" . $this->db->escape($data['upc']) . "',
								ean = '" . $this->db->escape($data['ean']) . "',
								jan = '" . $this->db->escape($data['jan']) . "',
								isbn = '" . $this->db->escape($data['isbn']) . "',
								mpn = '" . $this->db->escape($data['mpn']) . "',
								location = '" . $this->db->escape($data['location']) . "',
								garant = '" . (int)$data['garant'] . "',
								quantity = '" . (int)$data['quantity'] . "',
								minimum = '" . (int)$data['minimum'] . "',
								subtract = '" . (int)$data['subtract'] . "',
								stock_status_id = '" . (int)$data['stock_status_id'] . "',
								date_available = '" . $this->db->escape($data['date_available']) . "',
								manufacturer_id = '" . (int)$data['manufacturer_id'] . "',
								shipping = '" . (int)$data['shipping'] . "',
								zakup = '" . (float)$data['zakup'] . "',
								price = '" . (float)$data['price'] . "',
								points = '" . 1/*(int)$data['points']*/ . "',
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
								WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$product_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET
								product_id = '" . (int)$product_id . "',
								language_id = '" . (int)$language_id . "',
								name = '" . $this->db->escape($value['name']) . "',
								description = '" . $this->db->escape($value['description']) . "',
								description_detail = '" . $this->db->escape($value['description_detail']) . "',
								tag = '" . $this->db->escape($value['tag']) . "',
								meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

		if (!empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					if (isset($product_option['product_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");

						$product_option_id = $this->db->getLastId();
						
						foreach ($product_option['product_option_value'] as $product_option_value) {
							
							//Заэкранировано
							if(!isset($product_option_value['price_prefix'])) $product_option_value['price_prefix'] = 0;
							if(!isset($product_option_value['points'])) $product_option_value['points'] = 0;
							if(!isset($product_option_value['points_prefix'])) $product_option_value['points_prefix'] = 0;
							if(!isset($product_option_value['weight'])) $product_option_value['weight'] = 0;
							if(!isset($product_option_value['weight_prefix'])) $product_option_value['weight_prefix'] = 0;
							if(!isset($product_option_value['price'])) $product_option_value['price'] = 0;
							
							$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_params WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");
							
							$sql = "INSERT INTO " . DB_PREFIX . "product_option_value SET
												product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "',
												alternative_size = '" . (int)$product_option_value['alternative_size'] . "',
												product_option_id = '" . (int)$product_option_id . "',
												product_id = '" . (int)$product_id . "',
												option_id = '" . (int)$product_option['option_id'] . "',
												option_value_id = '" . (int)$product_option_value['option_value_id'] . "',
												quantity = '" . (int)$product_option_value['quantity'] . "',
												subtract = '" . (int)$product_option_value['subtract'] . "',
												price = '" . (float)$product_option_value['price'] . "',
												price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "',
												points = '" . (int)$product_option_value['points'] . "',
												points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "',
												weight = '" . (float)$product_option_value['weight'] . "',
												weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'";
												
							$this->db->query($sql);

							if(!(int)$product_option_value['product_option_value_id']) $product_option_value['product_option_value_id'] = $this->db->getLastId();
							
							if(isset($product_option_value['params'])){
								foreach ($product_option_value['params'] as $index => $value) {
									if($value > 0){
										
										$sql = "INSERT INTO " . DB_PREFIX . "product_option_params SET
													 product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "',
													 param_key = '" . $this->db->escape($index). "',
													 param_value = '" . $this->db->escape($value) . "'";
													 
										$this->db->query($sql);
										
									}
								}
							}
							
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($product_image['image']) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		//$this->_checkClausesAndMakeDecisionToUpdateRelationships($data, $product_id);
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				if(isset($data['main_relationships']) AND (int)$data['main_relationships'] == (int)$category_id){
					$sql = "INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "', is_main = '1'";
				}elseif(isset($data['main_relationships'])){
					$sql = "INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "', is_main = '0'";
				}else{
					$sql = "INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "', is_main = '1'";
				}
				$this->db->query($sql);
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $value) {
				if ((int)$value['points'] > 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		//$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");

		if ($data['keyword']) {
			//$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_recurring` WHERE product_id = " . (int)$product_id);

		if (isset($data['product_recurring'])) {
			foreach ($data['product_recurring'] as $product_recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_recurring` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$product_recurring['customer_group_id'] . ", `recurring_id` = " . (int)$product_recurring['recurring_id']);
			}
		}

		$this->cache->delete('product');

		$this->event->trigger('post.admin.product.edit', $product_id);
	}

	public function copyProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = $query->row;

			$data['sku'] = '';
			$data['upc'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$data['product_attribute'] = $this->getProductAttributes($product_id);
			$data['product_description'] = $this->getProductDescriptions($product_id);
			$data['product_discount'] = $this->getProductDiscounts($product_id);
			$data['product_filter'] = $this->getProductFilters($product_id);
			$data['product_image'] = $this->getProductImages($product_id);
			$data['product_option'] = $this->getProductOptions($product_id);
			$data['product_related'] = $this->getProductRelated($product_id);
			$data['product_reward'] = $this->getProductRewards($product_id);
			$data['product_special'] = $this->getProductSpecials($product_id);
			$data['product_category'] = $this->getProductCategories($product_id);
			$data['product_download'] = $this->getProductDownloads($product_id);
			$data['product_layout'] = $this->getProductLayouts($product_id);
			$data['product_store'] = $this->getProductStores($product_id);
			$data['product_recurrings'] = $this->getRecurrings($product_id);

			$this->addProduct($data);
		}
	}
	public function dellAllProduct(){
		$sql = 'SELECT product_id FROM ' . DB_PREFIX . 'product';
		$r = $this->db->query($sql) or die($sql);
		
		foreach($r->rows as $row){
			$this->deleteProduct($row['product_id']);
		}
	}
	
	public function deleteProduct($product_id) {
		$this->event->trigger('pre.admin.product.delete', $product_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_size WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_recurring WHERE product_id = " . (int)$product_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_money_limit WHERE money_product_id = '" . (int)$product_id . "'");

		$this->cache->delete('product');

		$this->event->trigger('post.admin.product.delete', $product_id);
	}

	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT *, p.code AS keyword
								  
								  /*(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword*/
								  
								  FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
								  WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		$query->row['name']     		= html_entity_decode($query->row['name'], ENT_QUOTES, 'UTF-8');				  
		$query->row['description']     		= html_entity_decode($query->row['description'], ENT_QUOTES, 'UTF-8');				  
		$query->row['description_detail'] 	= html_entity_decode($query->row['description_detail'], ENT_QUOTES, 'UTF-8');					  
								  
		return $query->row;
	}

	public function getProductsIdList($data = array()){
		$sql = "SELECT product_id FROM " . DB_PREFIX . "product;";
		
		$query = $this->db->query($sql);

		return $query->rows;		
		
	}
	public function getProducts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product p
					LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
					LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)
					WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (!empty($data['filter_category']) AND is_array($data['filter_category'])) {
			
			$sql1 = 'SELECT category_id FROM ' . DB_PREFIX . 'category_path WHERE path_id IN ('.implode(',', $data['filter_category']).')';
			$r = $this->db->query($sql1);
			
			if($r->num_rows){
				$arr = array();
				foreach($r->rows as $row){
					$arr[] = $row['category_id'];
				}
				$sql .= " AND p2c.category_id IN (" . implode(',', $arr) . ")";
			}
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}
		
		if (isset($data['no_category']) AND $data['no_category']) {
		
			$sql .= ' AND p.product_id IN (SELECT distinct product_id
									FROM fash_product p
									WHERE product_id NOT 
									IN (
									
									SELECT distinct product_id
									FROM fash_product_to_category
									))';
		}


		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
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

		//echo $sql;die();
		
		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function getProductsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getProductDescriptions($product_id) {
		$product_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'description_detail'      => $result['description_detail'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $product_description_data;
	}

	public function getProductCategories($product_id) {
		$product_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}

	public function getProductFilters($product_id) {
		$product_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_filter_data[] = $result['filter_id'];
		}

		return $product_filter_data;
	}

	public function getProductAttributes($product_id) {
		$product_attribute_data = array();

		$product_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' GROUP BY attribute_id");

		foreach ($product_attribute_query->rows as $product_attribute) {
			$product_attribute_description_data = array();

			$product_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

			foreach ($product_attribute_description_query->rows as $product_attribute_description) {
				$product_attribute_description_data[$product_attribute_description['language_id']] = array('text' => $product_attribute_description['text']);
			}

			$product_attribute_data[] = array(
				'attribute_id'                  => $product_attribute['attribute_id'],
				'product_attribute_description' => $product_attribute_description_data
			);
		}

		return $product_attribute_data;
	}

	public function getProductOptions($product_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");

			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'alternative_size'                => $product_option_value['alternative_size'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'points'                  => $product_option_value['points'],
					'points_prefix'           => $product_option_value['points_prefix'],
					'weight'                  => $product_option_value['weight'],
					'weight_prefix'           => $product_option_value['weight_prefix']
				);
			}

			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => $product_option['value'],
				'required'             => $product_option['required']
			);
		}

		return $product_option_data;
	}

	public function getProductOptionValue($product_id, $product_option_value_id) {
		$query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getProductRewards($product_id) {
		$product_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $product_reward_data;
	}

	public function getProductDownloads($product_id) {
		$product_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}

		return $product_download_data;
	}

	public function getProductStores($product_id) {
		$product_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_store_data[] = $result['store_id'];
		}

		return $product_store_data;
	}

	public function getProductLayouts($product_id) {
		$product_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $product_layout_data;
	}

	public function getProductRelated($product_id) {
		$product_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}

		return $product_related_data;
	}

	public function getRecurrings($product_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_recurring` WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}

	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total
						FROM " . DB_PREFIX . "product p
						LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)
						LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

			
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_category']) AND is_array($data['filter_category'])) {
			
			$sql1 = 'SELECT category_id FROM ' . DB_PREFIX . 'category_path WHERE path_id IN ('.implode(',', $data['filter_category']).')';
			$r = $this->db->query($sql1);
			
			if($r->num_rows){
				$arr = array();
				foreach($r->rows as $row){
					$arr[] = $row['category_id'];
				}
				$sql .= " AND p2c.category_id IN (" . implode(',', $arr) . ")";
			}
		}
		
		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['no_category']) AND $data['no_category']) {
				$sql .= ' AND p.product_id IN (SELECT distinct product_id
									FROM fash_product p
									WHERE product_id NOT 
									IN (
									
									SELECT distinct product_id
									FROM fash_product_to_category
									))';
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
//echo $sql; die();

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalProductsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}
	/**
	 * Check clauses and make decision to update relationships
	 *
	 * @param array $data
	 * @param int $product_id
	 */
	private function _checkClausesAndMakeDecisionToUpdateRelationships(array $data, $product_id) {

		$updateRelationships = isset($data['update_relationships']) && $data['update_relationships'] === true;
		$updateRelationshipsBySearching = isset($data['update_relationships_by_searching'])
			&& $data['update_relationships_by_searching'] === true;

		if ($updateRelationships) {
			if ($updateRelationshipsBySearching
				&& isset($data['product_category'])
				&& count($data['product_category']) > 0
				&& isset($data['root_id'])) {
				foreach ($data['product_category'] as $category_id) {
					$this->_updateRelationshipsBySearching($product_id, $category_id, $data['root_id']);
				}
			} else {
				$this->_updateRelationships($data, $product_id);
			}
		}
	}
		/**
	 * Update relationships by searching
	 *
	 * @param $product_id
	 * @param $category_id
	 * @param $root_id
	 * @return bool
	 */
	protected function _updateRelationshipsBySearching($product_id, $category_id, $root_id) {

		// Check args
		if (!is_numeric($product_id) || !is_numeric($category_id) || !is_numeric($root_id)) {
			return false;
		}

		// Select url aliases count
		$aliasesCount = $this->getUrlAliasCount($product_id);

		// Escape the data
		$product_id = $this->db->escape($product_id);
		$category_id = $this->db->escape($category_id);

		// Select a next action
		switch ($aliasesCount) {
			case 0:
				return false;
			case 1:
				$sql = "UPDATE `{$p}product_to_category` SET `is_main` = 1 WHERE `product_id` = $product_id AND `category_id` = $category_id";
				$this->db->query($sql);
				return true;
			default:
				if ($this->_isTheCategoryIsAChildOfARoot($category_id, $root_id)) {
					return false;
				}
				$sql = "UPDATE `{$p}product_to_category` SET `is_main` = 1 WHERE `category_id` = $category_id AND `product_id` = $product_id";
				$this->db->query($sql);
				return true;
		}
	}
	protected function _updateRelationships(array $data, $product_id) {
		if (isset($data['product_category'])) {

			$p = DB_PREFIX;
		
			$this->db->query("DELETE FROM `{$p}product_to_category` WHERE `product_id` = '" . (int)$product_id . "'");

			$isMainlRlSpecified = isset($data['main_relationships']);
			$mrlId = $isMainlRlSpecified ? filter_var($data['main_relationships'], FILTER_SANITIZE_NUMBER_INT) : null;

			foreach ($data['product_category'] as $category_id) {
				$sql = "INSERT INTO `{$p}product_to_category` SET `product_id` = $product_id, category_id = $category_id";
				if ($isMainlRlSpecified && $mrlId == $category_id) {
					$sql .= ', is_main = 1';
				}

				$this->db->query($sql);
			}
		}
	}
	
	public function getProductToCategoryMainRelationships($product_id) {
		$product_id = (int)$product_id;
		if ($product_id == 0) {
			return null;
		}

		$p = DB_PREFIX;
		$sql = "SELECT `category_id` FROM `{$p}product_to_category` WHERE `product_id` = $product_id AND `is_main` = 1 LIMIT 1";
	
		$result = $this->db->query($sql);
		if ($result->num_rows == 0) {
			return null;
		}

		return $result->row['category_id'];
	}
	public function getTotalProductsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByProfileId($recurring_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
	
		public function getCategoryTree() {
		
		$body = '<link rel="stylesheet" type="text/css" href="/'.TMP_DIR.'backend/libs/category_tree/type-for-get-admin.css">
					<script type="text/javascript" src="/'.TMP_DIR.'backend/libs/category_tree/script-for-get.js"></script>
					<!--script type="text/javascript" src="/'.TMP_DIR.'backend/category/category_tree.js"></script-->
					<input type="hidden" id="select_cetegory_target" value="">		
					<script>
						$(document).on("click", ".select_category", function(){
							$("#select_cetegory_target").val($(this).data("target"));
							var id = $(this).data("id");
							$("#target_categ_id").val(id);
							$("#target_categ_name").val($("#categ_name"+id).html());
							$("#container_tree").show();
							$("#container_back").show();
						});
						$(document).on("click", ".close_tree", function(){
							$("#container_tree").hide();
							$("#container_back").hide();
						});
						$(document).on("click", "#container_back", function(){
							$("#container_tree").hide();
							$("#container_back").hide();
						});
						
					
						
					</script>
						<input type="hidden" value="" id="category" class="selected_category">
						<div id="container_back"></div>
						<style>
							#container_back{width: 100%;height: 100%;z-index:11001;opacity: 0.7;display: none;position: absolute;background-color: gray;top:0;left:0;}
							#container_tree{    z-index: 11001;}
						</style>
					';				
		
        $Types = array();
        $Types[0] = array("id"=>0,"name"=>"Главная");
        //=======================================================================
            $sql = 'SELECT C.category_id AS id, C.parent_id, CD.name, A.keyword
                            FROM `'.DB_PREFIX.'category` C
                            LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
                            LEFT JOIN `'.DB_PREFIX.'url_alias` A ON A.query = CONCAT("category_id=",CD.category_id)
                            WHERE parent_id = "0" AND C.category_id > 0 AND CD.language_id = "'.(int)$this->config->get('config_language_id').'" ORDER BY name ASC;';
            //echo '<br>'.$sql;
            $rs = $this->db->query($sql);
            
            $body .= "
                    <input type='hidden' id=\"target_categ_id\" value='0'>
                    <input type='hidden' id=\"target_categ_name\" value=''>
                    <div id=\"container_tree\" class = \"product-type-tree\">
                        <h4>Выбрать категорию <span class='close_tree'>[закрыть]</span></h4><ul  id=\"celebTree\">
                ";
            foreach ($rs->rows as $Type) {
        
            if($Type['parent_id'] == 0){
                
                $body .=  "<li><span id=\"span_".$Type['id']."\"> <a class = \"tree category_id_".$Type['id']."\" href=\"javascript:;\" id=\"".$Type['id']."\">".$Type['name']."</a>";
                $body .= "</span>".$this->readTree($Type['id']);
                $body .= "</li>";
            }
            $Types[$Type['id']]['id'] = $Type['id'];
            $Types[$Type['id']]['name'] = $Type['name'];
            }
            $body .= "</ul>
                </li></ul></div>";
        
            return $body;
	}                
          //Рекурсия=================================================================
    protected function readTree($parent){
            $sql = 'SELECT C.category_id AS id, C.parent_id, CD.name, A.keyword
                        FROM `'.DB_PREFIX.'category` C
                        LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
                        LEFT JOIN `'.DB_PREFIX.'url_alias` A ON A.query = CONCAT("category_id=",CD.category_id)
                        WHERE parent_id = "'.$parent.'" AND C.category_id > 0 AND CD.language_id = "'.(int)$this->config->get('config_language_id').'" ORDER BY name ASC;';
                
            $rs = $this->db->query($sql);
        
            $body = "";
        
           foreach ($rs->rows as $Type) {
        
                //Посчитаем сколько есть описаний
                $sql = 'SELECT count(id) AS total FROM `'.DB_PREFIX.'alias_description` WHERE url LIKE "%'.$Type['keyword'].'";';
                
             
                $body .=  "<li><span id=\"span_".$Type['id']."\"><a class = \"tree category_id_".$Type['id']."\" href=\"javascript:;\" id=\"".$Type['id']."\">".$Type['name']."</a>";
                $body .= "</span>".$this->readTree($Type['id']);
                $body .= "</li>";
            }
            if($body != "") $body = "<ul>$body</ul>";
            return $body;
        
    }
  
	
}
