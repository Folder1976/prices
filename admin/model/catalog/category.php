<?php
class ModelCatalogCategory extends Model {
	
	
	public function addCategory($data) {
		$this->event->trigger('pre.admin.category.add', $data);
		
		$category_id = '';
		if(isset($data['category_id']) AND $data['category_id'] > 0){
			$category_id = $data['category_id'];
		}
		
		$data['code'] = $data['keyword'];
		
		if(!isset($data['is_menu'])) $data['is_menu'] = '0';
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET category_id = '" . (int)$category_id . "',
						 parent_id = '" . (int)$data['parent_id'] . "',
						 code = '" . $data['code'] . "',
						 `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "',
						 `column` = '" . (int)$data['column'] . "', 
						 is_menu = '" . (int)$data['is_menu'] . "',
						 is_filter = '" . (int)$data['is_filter'] . "',
						 sort_order = '" . (int)$data['sort_order'] . "',
						 status = '" . (int)$data['status'] . "',
						 date_modified = NOW(), date_added = NOW()");

		$category_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		foreach ($data['category_description'] as $language_id => $value) {
			
			if(!isset($value['name_sush'])) $value['name_sush'] = '';
			if(!isset($value['name_rod'])) $value['name_rod'] = '';
			if(!isset($value['name_several'])) $value['name_several'] = '';
	
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET
										category_id = '" . (int)$category_id . "',
										language_id = '" . (int)$language_id . "',
										name = '" . $this->db->escape($value['name']) . "',
										/*name_sush = '" . $this->db->escape($value['name_sush']) . "',
										name_rod = '" . $this->db->escape($value['name_rod']) . "',
										name_several = '" . $this->db->escape($value['name_several']) . "',*/
										description = '" . $this->db->escape($value['description']) . "',
										meta_title = '" . $this->db->escape($value['meta_title']) . "',
										title_h1 = '" . $this->db->escape($value['title_h1']) . "',
										meta_description = '" . $this->db->escape($value['meta_description']) . "',
										meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

/*		
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description_domain WHERE category_id = '" . (int)$category_id . "'");

		foreach ($data['category_description_domain'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description_domain SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', title_h1 = '" . $this->db->escape($value['title_h1']) . "',meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}
	
		$domain_is_menu = 0;
		if(isset($data['domain_is_menu'])) $domain_is_menu = $data['domain_is_menu'];
		
		$this->db->query("UPDATE " . DB_PREFIX . "category_description_domain SET is_menu = '" . (int)$domain_is_menu . "' WHERE category_id = '" . (int)$category_id . "'");
	*/
		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['category_to_attribute'])) {
			foreach ($data['category_to_attribute'] as $attribute_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_attribute SET category_id = '" . (int)$category_id . "', attribute_id = '" . (int)$attribute_id . "'");
			}
		}

		
		// Set which layout to use with this category
		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('category');

		$this->event->trigger('post.admin.category.add', $category_id);

		return $category_id;
	}
	
	public function updateCategoryID($category_from, $category_to) {
		$this->db->query("UPDATE " . DB_PREFIX . "category SET category_id = '" . (int)$category_to . "', date_modified = NOW() WHERE category_id = '" . (int)$category_from . "'");
		//$this->db->query("UPDATE " . DB_PREFIX . "category SET category_id = '" . (int)$category_to . "', date_modified = NOW() WHERE category_id = '" . (int)$category_from . "'");
	}

	
	public function tmp11() {
		
			$sql = 'DELETE FROM fash_category_to_attribute WHERE category_id IN(24,82, 85,272,304,305,306,307,308,309,310,311,312,313,314,315)';
			$r = $this->db->query($sql);

		
			$sql = 'SELECT * FROM fash_category_attributes_dell WHERE category_id IN(24,82, 85,272,304,305,306,307,308,309,310,311,312,313,314,315)';
			$r = $this->db->query($sql);
			
			foreach($r->rows as $row){
				
				$sql = 'INSERT INTO fash_category_to_attribute SET category_id = "'.$row['category_id'].'", attribute_id = "'.$row['attribute_id'].'"';
				echo '<br>'.$sql;
				$this->db->query($sql);
				
			}
			
	}

	public function editCategory($category_id, $data) {
		$this->event->trigger('pre.admin.category.edit', $data);

		
		$data['code'] = $data['keyword'];
		if(!isset($data['is_menu'])) $data['is_menu'] = '0';
		if(!isset($data['is_filter'])) $data['is_filter'] = '0';
		
		$this->db->query("UPDATE " . DB_PREFIX . "category SET
									parent_id = '" . (int)$data['parent_id'] . "',
									`top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "',
									`column` = '" . (int)$data['column'] . "',
									`code` = '" . $data['code'] . "',
									is_menu = '" . (int)$data['is_menu'] . "',
									is_filter = '" . (int)$data['is_filter'] . "',
									sort_order = '" . (int)$data['sort_order'] . "',
									status = '" . (int)$data['status'] . "',
									date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			
			if(!isset($value['name_sush'])) $value['name_sush'] = '';
			if(!isset($value['name_rod'])) $value['name_rod'] = '';
			if(!isset($value['name_several'])) $value['name_several'] = '';
	
			
			$sql = "INSERT INTO " . DB_PREFIX . "category_description SET
									category_id = '" . (int)$category_id . "',
									language_id = '" . (int)$language_id . "',
									name = '" . $this->db->escape($value['name']) . "', 
									description = '" . $this->db->escape($value['description']) . "',
									title_h1 = '" . $this->db->escape($value['title_h1']) . "',
									meta_title = '" . $this->db->escape($value['meta_title']) . "',
									meta_description = '" . $this->db->escape($value['meta_description']) . "',
									meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'";
									
			$this->db->query($sql) or die($sql);
			/*name_sush = '" . $this->db->escape($value['name_sush']) . "',
									name_rod = '" . $this->db->escape($value['name_rod']) . "',
									name_several = '" .$this->db->escape($value['name_several']) . "',*/
									
		}
		/*
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description_domain WHERE category_id = '" . (int)$category_id . "'");

		foreach ($data['domain_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description_domain SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "',
							 name = '" . $this->db->escape($value['name']) . "',
							 description = '" . $this->db->escape($value['description']) . "',
							 title_h1 = '" . $this->db->escape($value['title_h1']) . "',
							 meta_title = '" . $this->db->escape($value['meta_title']) . "',
							 meta_description = '" . $this->db->escape($value['meta_description']) . "',
							 meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}
		
		$domain_is_menu = 0;
		if(isset($data['domain_is_menu'])) $domain_is_menu = $data['domain_is_menu'];
		
		$this->db->query("UPDATE " . DB_PREFIX . "category_description_domain SET is_menu = '" . (int)$domain_is_menu . "' WHERE category_id = '" . (int)$category_id . "'");
		*/

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE path_id = '" . (int)$category_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $category_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_attribute WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_to_attribute'])) {
			foreach ($data['category_to_attribute'] as $attribute_id) {
				$sql = "INSERT INTO " . DB_PREFIX . "category_to_attribute SET category_id = '" . (int)$category_id . "', attribute_id = '" . (int)$attribute_id . "'";
				//echo $sql.'<br>';
				$this->db->query($sql);
			}
		}

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");

		if ($data['keyword']) {
			//$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('category');

		$this->event->trigger('post.admin.category.edit', $category_id);
	}

	public function deleteCategory($category_id) {
		$this->event->trigger('pre.admin.category.delete', $category_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$category_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description_domain WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");

		$this->cache->delete('category');

		$this->event->trigger('post.admin.category.delete', $category_id);
	}
	
	public function deleteCategoryAll() {
		$this->event->trigger('pre.admin.category.delete', $category_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_path");

		$this->db->query("DELETE FROM " . DB_PREFIX . "category");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description_domain");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias");

		$this->cache->delete('category');

		$this->event->trigger('post.admin.category.delete', $category_id);
	}

	public function restoreAllCategoryesPath() {
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path`");
		
		$query = $this->db->query("SELECT category_id FROM `" . DB_PREFIX . "category`");
		
		foreach($query->rows as $row){
			$this->restoreCategoryPath($row['category_id']);
		}
	}
	
	public function restoreCategoryPath($category_id) {

		$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_id. "'");
		
		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;
		$categories = array();
		$categories[] = $categ = $category_id;
		
		while($categ > 0){
			$query = $this->db->query("SELECT parent_id FROM `" . DB_PREFIX . "category` WHERE category_id = '" . (int)$categ . "' LIMIT 0, 1");
			
			$categories[] = $categ = $query->row['parent_id'];
		}
		
		$level = count($categories) - 1;
		foreach($categories as $path_id){
			
			$sql = "INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$path_id . "', `level` = '" . (int)$level . "'";
			//echo '<br>'.$sql;
			
			$this->db->query($sql);
			$level--;
		}

	}
	
	
	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category['category_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$sql = "INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'";
				echo '<br>'.$sql;
				$this->db->query($sql);

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$category['category_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($category['category_id']);
		}
		die();
	}

	public function getCategory($category_id) {
		$sql = "SELECT DISTINCT *, code as keyword, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;')
				FROM " . DB_PREFIX . "category_path cp
				LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND
							cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND
							cd1.language_id = '" . (int)$this->config->get('config_language_id') . "'
						GROUP BY cp.category_id) AS path /*,
				(SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias
					WHERE query = 'category_id=" . (int)$category_id . "') AS keyword */
				FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd2 ON
						(c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND
						cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$query = $this->db->query($sql);

		return $query->row;
	}
	public function getCategoryOnNameAndParent($name, $parent_id) {
		
		$sql = "SELECT C.category_id FROM " . DB_PREFIX . "category C
								  LEFT JOIN " . DB_PREFIX . "category_description CD ON CD.category_id = C.category_id
								  WHERE parent_id = '" . (int)$parent_id . "' AND name LIKE '" . $name . "'  ";
		//echo $sql; die();
		$query = $this->db->query($sql);

		if($query->num_rows == 0){
			return false;
		}
		return $query->row;
	}

	public function getCategoriesID() {
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category");

		return $query->rows;
	}

	public function getCategories($data = array()) {
		$sql = "SELECT cp.category_id AS category_id,
				GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name,
				c1.parent_id,
				c1.sort_order,
				c1.is_menu,
				c1.is_filter
				FROM " . DB_PREFIX . "category_path cp
				LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id)
				LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id)
				LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id)
				LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id)
				WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND
				cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['parent_id']) ) {
			$sql .= " AND c1.parent_id = '" . (int)$data['parent_id'] . "'";
		}

		$sql .= " GROUP BY cp.category_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description
								  WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				/*'name_sush'         => $result['name_sush'],
				'name_rod'          => $result['name_rod'],
				'name_several'      => $result['name_several'],*/
				'title_h1'       	=> $result['title_h1'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $category_description_data;
	}

	public function getCategoryDomainDescriptions($category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description_domain WHERE category_id = '" . (int)$category_id . "' LIMIT 0,1");

		if($query->num_rows == 0){
			$category_description_data[1] = array(
			'name'             	=> '',
			'title_h1'       	=> '',
			'meta_title'       	=> '',
			'meta_description' 	=> '',
			'meta_keyword'     	=> '',
			'description'      	=> ''
		);

		}else{
		
			$result = $query->row;
			$category_description_data[1] = array(
				'name'             => $result['name'],
				'title_h1'       	=> $result['title_h1'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}
		
		return $category_description_data;
	}

	public function getCategoryDomainIsMenu($category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT is_menu FROM " . DB_PREFIX . "category_description_domain WHERE category_id = '" . (int)$category_id . "' LIMIT 0, 1");

		if($query->num_rows == 0){
			return 0;	
		}
		
		$result = $query->row;
			
		return $result['is_menu'];
	}

	public function getCategoryFilters($category_id) {
		$category_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_filter_data[] = $result['filter_id'];
		}

		return $category_filter_data;
	}

	public function getCategoryStores($category_id) {
		$category_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}

		return $category_store_data;
	}

	public function getCategoryLayouts($category_id) {
		$category_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $category_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");

		return $query->row['total'];
	}
	
	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
	
	
	public function getCategoryTree() {
		
		$body = '<link rel="stylesheet" type="text/css" href="/'.TMP_DIR.'backend/libs/category_tree/type-for-get-admin.css">
					<script type="text/javascript" src="/'.TMP_DIR.'backend/libs/category_tree/script-for-get.js"></script>
					<script type="text/javascript" src="/'.TMP_DIR.'backend/category/category_tree.js"></script>
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
                            WHERE parent_id = "0" AND C.category_id > "0" AND CD.language_id = "'.(int)$this->config->get('config_language_id').'" ORDER BY name ASC;';
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
                
                $body .=  "<li><span id=\"span_".$Type['id']."\"> <a class = \"tree category_id_".$Type['id']."\" href=\"/".TMP_DIR."admin/index.php?route=catalog/category/edit&token=".$this->request->get['token']."&category_id=".$Type['id']."\" id=\"".$Type['id']."\">".$Type['name']."</a>";
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
                        WHERE parent_id = "'.$parent.'" AND C.category_id > "0" AND CD.language_id = "'.(int)$this->config->get('config_language_id').'" ORDER BY name ASC;';
                
            $rs = $this->db->query($sql);
        
            $body = "";
        
           foreach ($rs->rows as $Type) {
        
                //Посчитаем сколько есть описаний
                $sql = 'SELECT count(id) AS total FROM `'.DB_PREFIX.'alias_description` WHERE url LIKE "%'.$Type['keyword'].'";';
                
             
                $body .=  "<li><span id=\"span_".$Type['id']."\"><a class = \"tree category_id_".$Type['id']."\" href=\"/".TMP_DIR."admin/index.php?route=catalog/category/edit&token=".$this->request->get['token']."&category_id=".$Type['id']."\" id=\"".$Type['id']."\">".$Type['name']."</a>";
                $body .= "</span>".$this->readTree($Type['id']);
                $body .= "</li>";
            }
            if($body != "") $body = "<ul>$body</ul>";
            return $body;
        
    }
        
	public function getCategoryAttribute($category_id = 0) {
		$sql = 'SELECT attribute_id FROM '. DB_PREFIX .'category_to_attribute WHERE category_id = "'.$category_id.'";';
	
		$r = $this->db->query($sql);
		
		$return = array();
		foreach($r->rows as $row){
			
			$return[$row['attribute_id']] = $row['attribute_id'];

		}
		
		return $return;
		
	}
	public function getSubCategories($parent_id = 0) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "category c
						LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
						WHERE c.parent_id = '" . (int)$parent_id . "' AND
						cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
	
		$query = $this->db->query($sql);

		return $query->rows;
	}
}
