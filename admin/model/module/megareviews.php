<?php
class ModelModuleMegareviews extends Model {
	public function addReview($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "review SET author = '" . $this->db->escape($data['author']) . "', product_id = '" . $this->db->escape($data['product_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$this->cache->delete('product');
	}
	
	public function updateOptions($data) {
		$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "megareviews_options");
		if(count($data)>0)
		foreach ($data as $option) {
			$this->addOption($option);
		}
		$this->cache->delete('product');
	}
	
	public function updateAys($data) {
		$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "megareviews_ays");
		if(count($data)>0)
		foreach ($data as $ay) {
			$this->addAy($ay);
		}
		$this->cache->delete('product');
	}
	
	public function addOption($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "megareviews_options SET
						 min = '" . $this->db->escape($data['min']) . "',
						 max = '" . $this->db->escape($data['max']) . "',
						 name = '" . $this->db->escape(strip_tags($data['name'])) . "' ,
						 `values` = '" . $this->db->escape(strip_tags($data['values'])) . "',
						 sort_order = '" . (int)$data['sort_order'] . "'");
		$this->cache->delete('product');
	}
	
	public function addAy($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "megareviews_ays SET
						 name = '" . $this->db->escape(strip_tags($data['name'])) . "' ,
						 `values` = '" . $this->db->escape(strip_tags($data['values'])) . "' ,
						 sort_order = '" . (int)$data['sort_order'] . "'");
		$this->cache->delete('product');
	}

	public function editReview($review_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "megareviews SET author = '" . $this->db->escape($data['author']) . "',recommend = '" . (int)$data['recommend'] . "', product_id = '" . $this->db->escape($data['product_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE review_id = '" . (int)$review_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "megareviewsoptions_to_review WHERE review_id = '" . (int)$review_id . "'");
        if(isset($data['options']))
        foreach($data['options'] as $id=>$value)
            if((int)$value>-1)$this->db->query("INSERT INTO " . DB_PREFIX . "megareviewsoptions_to_review SET option_id = '" . (int)($id) . "', review_id = '" . (int)$review_id . "', value = '" . (int)$value . "' ");
        
        unset($id);unset($value);
        $this->db->query("DELETE FROM " . DB_PREFIX . "megareviewsays_to_review WHERE review_id = '" . (int)$review_id . "'");
        if(isset($data['ays']))
        foreach($data['ays'] as $id=>$value)
            if((int)$value>-1){
                
                $this->db->query("INSERT INTO " . DB_PREFIX . "megareviewsays_to_review SET ay_id = '" . (int)($id) . "', review_id = '" . (int)$review_id . "', value = '" . (int)$value . "' ");
            }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "megareviewsimg_to_review WHERE review_id = '" . (int)$review_id . "'");
        if(isset($data['files']))
        foreach($data['files'] as $value)
            if((int)$value>-1)$this->db->query("INSERT INTO " . DB_PREFIX . "megareviewsimg_to_review SET url = '" . $this->db->escape($value) . "', review_id = '" . (int)$review_id . "'");
        
        
		$this->cache->delete('product');
	}

	public function deleteReview($review_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "megareviews WHERE review_id = '" . (int)$review_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "megareviewsoptions_to_review WHERE review_id = '" . (int)$review_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "megareviewsays_to_review WHERE review_id = '" . (int)$review_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "megareviewsimg_to_review WHERE review_id = '" . (int)$review_id . "'");
		
		$this->cache->delete('product');
	}

	public function getReview($review_id) {
		$query = $this->db->query("SELECT DISTINCT *,
								  (SELECT pd.name FROM " . DB_PREFIX . "product_description pd
										WHERE pd.product_id = r.product_id
											AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS product
								  FROM " . DB_PREFIX . "megareviews r
								  WHERE r.review_id = '" . (int)$review_id . "'");

		return $query->row;
	}
	
	public function updateSettings($data = array()) {
		if(isset($data['options']))$this->updateOptions($data['options']);else $this->updateOptions(null);
		if(isset($data['ay']))$this->updateAys($data['ay']); else $this->updateAys(null);
	}

	public function getReviews($data = array()) {
		$sql = "SELECT pd.name,r.review_id,r.product_id, r.author, r.rating, r.status, r.date_added, r.videotitle,r.upvotes,r.downvotes, r.text,r.title,r.recommend,r.videourl FROM " . DB_PREFIX . "megareviews r
					LEFT JOIN " . DB_PREFIX . "product_description pd ON (r.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "')
					WHERE TRUE";																																					  
		if (!empty($data['filter_product'])) {
            $sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_product']) . "%'";
        }

        if (!empty($data['filter_author'])) {
            $sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }
		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY r.date_added";	
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
	}

	public function getOptions() {
		$sql = "SELECT `option_id`, `sort_order`, `name`, `min`, `max`, `values` FROM " . DB_PREFIX . "megareviews_options";																																					  

		$query = $this->db->query($sql);																																				

		return $query->rows;	
	}
	public function getAys() {
		$sql = "SELECT `ay_id`, `sort_order`, `name`,`values` FROM " . DB_PREFIX . "megareviews_ays";																																					  

		$query = $this->db->query($sql);																																				

		return $query->rows;	
	}
    
    public function getOptionValues($id){
        $query = $this->db->query("SELECT o.option_id, o.value, oo.values, oo.name, oo.min, oo.max  FROM " . DB_PREFIX . "megareviewsoptions_to_review o LEFT JOIN " . DB_PREFIX . "megareviews_options oo ON (o.option_id = oo.option_id) WHERE review_id='".$id."' && value>'-1'");
        return $query->rows;    
    }
    public function getAyValues($id){
        $query = $this->db->query("SELECT a.ay_id, a.value, aa.values, aa.name, aa.sort_order  FROM " . DB_PREFIX . "megareviewsays_to_review a LEFT JOIN " . DB_PREFIX . "megareviews_ays aa ON (a.ay_id = aa.ay_id)  WHERE a.review_id='".$id."' && value>'-1' ORDER BY aa.sort_order");
        return $query->rows;    
    }
    public function getImages($id){
        $query = $this->db->query("SELECT url as big  FROM " . DB_PREFIX . "megareviewsimg_to_review  WHERE review_id='".$id."' && url!=''");
        return $query->rows;    
    }
	public function getTotalReviews() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "megareviews WHERE TRUE");
        if (!empty($data['filter_product'])) {
            $sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_product']) . "%'";
        }

        if (!empty($data['filter_author'])) {
            $sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }
		return $query->row['total'];
	}

	public function getTotalReviewsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review WHERE status = '0'");

		return $query->row['total'];
	}	
}
?>