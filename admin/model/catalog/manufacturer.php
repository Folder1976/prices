<?php
class ModelCatalogManufacturer extends Model {
	public function addManufacturer($data) {
		$this->event->trigger('pre.admin.manufacturer.add', $data);

		$manufacturer_id = '';
		if(isset($data['manufacturer_id']) AND (int)$data['manufacturer_id'] > 0) $manufacturer_id = (int)$data['manufacturer_id'];
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET
						 manufacturer_id = '".$manufacturer_id."',
						 name = '" . $this->db->escape($data['name']) . "',
						 code = '" . $this->db->escape($data['code']) . "',
						 name_sush = '" . $this->db->escape($data['name_sush']) . "',
						 name_rod = '" . $this->db->escape($data['name_rod']) . "',
						 name_several = '" . $this->db->escape($data['name_several']) . "',
						 sort_order = '" . (int)$data['sort_order'] . "'");

		$manufacturer_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}

		if (isset($data['manufacturer_store'])) {
			foreach ($data['manufacturer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		//description
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['manufacturer_description'])) {
			foreach ($data['manufacturer_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_description SET
								manufacturer_id = '" . (int)$manufacturer_id . "',
								language_id = '".$language_id."',
								title_h1 = '" . $this->db->escape($value['title_h1']) . "',
								description = '" . $this->db->escape($value['description']) . "',
								meta_title = '" . $this->db->escape($value['meta_title']) . "',
								meta_description = '" . $this->db->escape($value['meta_description']) . "',
								meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'
								");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_alternative WHERE brand_id=" . (int)$manufacturer_id . "");
		if (isset($data['alternative'])) {
			foreach ($data['alternative'] as $alternative) {
				
				if(!isset($alternative['enable'])) $alternative['enable'] = 0;
			
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_alternative SET
								 brand_id = '" . (int)$manufacturer_id . "',
								 shop_id = '" . $this->db->escape($alternative['shop_id']) . "',
								 name = '" . $this->db->escape($alternative['name']) . "',
								 enable = '" . (int)$alternative['enable'] . "',
								 sort = '" . (int)$alternative['sort'] . "'
								 ");
			}
		}
		
				
		$this->cache->delete('manufacturer');

		$this->event->trigger('post.admin.manufacturer.add', $manufacturer_id);

		return $manufacturer_id;
	}

	public function editManufacturerStatus($manufacturer_id, $status) {
		
		$sql = "UPDATE " . DB_PREFIX . "manufacturer SET
							enable = '" . (int)$status . "'
							WHERE manufacturer_id = '" . (int)$manufacturer_id . "'";
		
		$this->db->query($sql);
		$this->cache->delete('manufacturer');
	}
	
	public function editManufacturer($manufacturer_id, $data) {
		
		$this->event->trigger('pre.admin.manufacturer.edit', $data);

		$sql = "UPDATE " . DB_PREFIX . "manufacturer SET
							name = '" . $this->db->escape($data['name']) . "',
							code = '" . $this->db->escape($data['code']) . "',
							name_sush = '" . $this->db->escape($data['name_sush']) . "',
							name_rod = '" . $this->db->escape($data['name_rod']) . "',
							name_several = '" . $this->db->escape($data['name_several']) . "',
					
							sort_order = '" . (int)$data['sort_order'] . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'";
		//echo $sql; die();
		$this->db->query($sql);

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['manufacturer_store'])) {
			foreach ($data['manufacturer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		//description
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['manufacturer_description'])) {
			foreach ($data['manufacturer_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_description SET
								manufacturer_id = '" . (int)$manufacturer_id . "',
								language_id = '".$language_id."',
								title_h1 = '" . $this->db->escape($value['title_h1']) . "',
								description = '" . $this->db->escape($value['description']) . "',
								meta_title = '" . $this->db->escape($value['meta_title']) . "',
								meta_description = '" . $this->db->escape($value['meta_description']) . "',
								meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'
								");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_alternative WHERE brand_id=" . (int)$manufacturer_id . "");
		if (isset($data['alternative'])) {
			foreach ($data['alternative'] as $alternative) {
				
				if(!isset($alternative['enable'])) $alternative['enable'] = 0;
				
				
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_alternative SET
								 brand_id = '" . (int)$manufacturer_id . "',
								 shop_id = '" . $this->db->escape($alternative['shop_id']) . "',
								 name = '" . $this->db->escape($alternative['name']) . "',
								 enable = '" . (int)$alternative['enable'] . "',
								 sort = '" . (int)$alternative['sort'] . "'
								 ");
			}
		}

		
		$this->cache->delete('manufacturer');

		$this->event->trigger('post.admin.manufacturer.edit', $manufacturer_id);
	}

	public function deleteManufacturer($manufacturer_id) {
		$this->event->trigger('pre.admin.manufacturer.delete', $manufacturer_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "'");

		$this->cache->delete('manufacturer');

		$this->event->trigger('post.admin.manufacturer.delete', $manufacturer_id);
	}

	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT DISTINCT *,
									(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id . "') AS keyword
									FROM " . DB_PREFIX . "manufacturer
									WHERE manufacturer_id = '" . (int)$manufacturer_id . "' LIMIT 0, 1");
		
		$query1 = $this->db->query("SELECT *
									FROM " . DB_PREFIX . "manufacturer_description
									WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		
		$return = $query->row;
		
		$return['name'] = html_entity_decode($return['name'], ENT_QUOTES, 'UTF-8');
		$return['code'] = html_entity_decode($return['code'], ENT_QUOTES, 'UTF-8');
		
		if($query1->num_rows){
			foreach($query1->rows as $row){
				$return['description'][$row['language_id']]['name'] = ($row['name'] != '') ? $row['name'] : $query->row['name'];
				$return['description'][$row['language_id']]['name'] = html_entity_decode($return['description'][$row['language_id']]['name'], ENT_QUOTES, 'UTF-8');
				$return['description'][$row['language_id']]['title_h1'] = html_entity_decode($row['title_h1'], ENT_QUOTES, 'UTF-8');
				$return['description'][$row['language_id']]['meta_title'] = html_entity_decode($row['meta_title'], ENT_QUOTES, 'UTF-8');
				$return['description'][$row['language_id']]['meta_keyword'] = html_entity_decode($row['meta_keyword'], ENT_QUOTES, 'UTF-8');
				$return['description'][$row['language_id']]['meta_description'] = html_entity_decode($row['meta_description'], ENT_QUOTES, 'UTF-8');
				$return['description'][$row['language_id']]['description'] = html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8');
			}
		}else{
			$return['title_h1'] = '';
			$return['name'] = '';
			$return['meta_title'] = '';
			$return['meta_keyword'] = '';
			$return['meta_description'] = '';
			$return['description'] = '';
		}

		return $return;
	}

	public function getManufacturers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

		$query = $this->db->query($sql);

		$return = array();
		foreach($query->rows as $row){
			
			$return[$row['manufacturer_id']] = $row;
			$return[$row['manufacturer_id']]['name'] = html_entity_decode($row['name'], ENT_QUOTES, 'UTF-8');
			
		}
		
		return $return;
	}

	public function getManufacturerStores($manufacturer_id) {
		$manufacturer_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		foreach ($query->rows as $result) {
			$manufacturer_store_data[] = $result['store_id'];
		}

		return $manufacturer_store_data;
	}

	public function getTotalManufacturers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manufacturer");

		return $query->row['total'];
	}
	public function deleteManufacturerAliases() {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query LIKE 'manufacturer_id=%'");

	}
	
	
	
	public function updateManufacturerImages($manufacturer_id, $images) {
		
		foreach($images as $image){
			$sql = "UPDATE " . DB_PREFIX . "manufacturer SET image = '" . $this->db->escape($image) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'";
			$this->db->query($sql);
			//echo '<br>'.$sql;
		}
		
	}
	
	public function getManufacturerAlternative($manufacturer_id){
	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_alternative WHERE brand_id = '" . (int)$manufacturer_id . "' ORDER BY shop_id ASC, `name` ASC;");

	
		return $query->rows;
	}
	
	


}

