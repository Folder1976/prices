<?php
class ModelCatalogManufacturer extends Model {
	public function getManufacturer($manufacturer_id) {
		$sql = "SELECT m.*,
											ua.keyword,
											md.description,
											md.meta_title,
											md.meta_description,
											md.meta_keyword
											FROM " . DB_PREFIX . "manufacturer m
									LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id)
									LEFT JOIN " . DB_PREFIX . "url_alias ua ON ua.query = CONCAT('manufacturer_id=',m.manufacturer_id)
									LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) 
									WHERE m.manufacturer_id = '" . (int)$manufacturer_id . "' AND `enable` = '1'
									/*AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'*/
									";
		$query = $this->db->query($sql);

		
		$return = $query->row;
		
		$return['name'] = html_entity_decode(html_entity_decode($return['name']));
		$return['title_h1'] = html_entity_decode(html_entity_decode($return['name']));
		$return['description'] = html_entity_decode(html_entity_decode($return['description']));
		$return['meta_title'] = html_entity_decode(html_entity_decode($return['meta_title']));
		$return['meta_description'] = html_entity_decode(html_entity_decode($return['meta_description']));
		$return['meta_keyword'] = html_entity_decode(html_entity_decode($return['meta_keyword']));
		
		return $return;
				
	}

	
	public function getManufacturerBanner() {
		$items = 7;
		
		$sql = "SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer  WHERE enable='1' AND on_main_page='1' AND `enable` = '1';";
		$query = $this->db->query($sql);
		$rows = array();
		
		if($query->num_rows < 7){
			return false;	
		}
		
		foreach($query->rows as $row){
			$rows[$row['manufacturer_id']] = $row['manufacturer_id'];
		}
		
		$ids = array();
		while($items > 0){
			$id = array_rand($rows);
			unset($rows[$id]);
			$ids[] = $id;
			$items--;
		}
		
		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer  WHERE manufacturer_id IN (".implode(',',$ids).") AND `enable` = '1';";

		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getManufacturers($data = array()) {
		
		
		
		if ($data) {
			
			$sql = "SELECT m.*,
							ua.keyword,
							md.description,
							md.meta_title,
							md.meta_description,
							md.meta_keyword
						FROM " . DB_PREFIX . "manufacturer m
						LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id)
						LEFT JOIN " . DB_PREFIX . "url_alias ua ON ua.query = CONCAT('manufacturer_id=',m.manufacturer_id)
									
						WHERE `enable`='1' ";

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

			
			return $query->rows;
		} else {
		
			$manufacturer_data = $this->cache->get('manufacturer.' . (int)$this->config->get('config_store_id'));

			if (!$manufacturer_data) {
				$sql = "SELECT m.*, ua.keyword FROM " . DB_PREFIX . "manufacturer m
									LEFT JOIN " . DB_PREFIX . "url_alias ua ON ua.query = CONCAT('manufacturer_id=',m.manufacturer_id)
									WHERE `enable`='1' 
									ORDER BY name";
									
				$query = $this->db->query($sql);
				$manufacturer_data = $query->rows;

				$this->cache->set('manufacturer.' . (int)$this->config->get('config_store_id'), $manufacturer_data);
			}

			return $manufacturer_data;
		}
	}
	public function getManufacturersByCategoryId($categoryId)
                {
                    $p = DB_PREFIX;
                    $categoryId = $this->db->escape($categoryId);
                    $sql = "SELECT `m`.`name`, `m`.`manufacturer_id`, `m`.`code` FROM `{$p}manufacturer` `m`"
                        . " INNER JOIN `{$p}product` `p` ON `p`.`manufacturer_id` = `m`.`manufacturer_id`"
                        . " INNER JOIN `{$p}product_to_category` `p2c` ON `p2c`.`product_id` = `p`.`product_id`"
                        . " INNER JOIN `{$p}category_path` `cp` ON `cp`.`category_id` = `p2c`.`category_id`"
                        . " WHERE `cp`.`path_id` = $categoryId AND `p`.`status` = 1 AND `p`.`date_available` <= NOW()  AND `enable` = '1'"
                        . " GROUP BY `m`.`manufacturer_id` ORDER BY LCASE(`m`.`name`)";
                    $result = $this->db->query($sql);
                    if ($result->num_rows == 0) {
                        return false;
                    }

                    return $result->rows;
        }
	public function getManufacturersByProductIds($product_ids){
                    $p = DB_PREFIX;
         
				    $sql = "SELECT `m`.`name`, `m`.`manufacturer_id`, `m`.`code` FROM `{$p}manufacturer` `m`"
                        . " INNER JOIN `{$p}product` `p` ON `p`.`manufacturer_id` = `m`.`manufacturer_id`"
                          . " WHERE `p`.`product_id` IN (".implode(',',$product_ids).") AND `p`.`status` = 1 AND `p`.`date_available` <= NOW()  AND `enable` = '1'"
                        . " GROUP BY `m`.`manufacturer_id` ORDER BY LCASE(`m`.`name`)";
                    $result = $this->db->query($sql);
                    if ($result->num_rows == 0) {
                        return false;
                    }

                    return $result->rows;
        }
}