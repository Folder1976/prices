<?php
class ModelModuleMegareviews extends Model {
	public function addReview($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "megareviews SET author = '" . $this->db->escape($data['author']) . "', title = '" . $this->db->escape($data['title']) . "',videotitle = '" . $this->db->escape($data['videotitle']) . "',videourl= '" . $this->db->escape($data['videourl']) . "', product_id = '" . (int)($data['product_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "',recommend = '" . (int)$data['recommend'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
		$review_id = $this->db->getLastId();
		foreach($data['options'] as $id=>$value)
			if((int)$value>-1)$this->db->query("INSERT INTO " . DB_PREFIX . "megareviewsoptions_to_review SET option_id = '" . (int)($id) . "', review_id = '" . (int)$review_id . "', value = '" . (int)$value . "' ");
		unset($id);unset($value);
		foreach($data['ay'] as $id=>$value)
			if((int)$value>-1)$this->db->query("INSERT INTO " . DB_PREFIX . "megareviewsays_to_review SET ay_id = '" . (int)($id) . "', review_id = '" . (int)$review_id . "', value = '" . (int)$value . "' ");
		foreach($data['files'] as $value)
			if((int)$value>-1)$this->db->query("INSERT INTO " . DB_PREFIX . "megareviewsimg_to_review SET url = '" . $this->db->escape($value) . "', review_id = '" . (int)$review_id . "'");
		
		$this->cache->delete('product');
	}
	
	public function updateOptions($data) {
		$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "megareviews_options");
		foreach ($data as $option) {
			$this->addOption($option);
		}
		$this->cache->delete('product');
	}
	
	public function addOption($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "megareviews_options_to_review SET option_id = '" . $this->db->escape($data['min']) . "', max = '" . $this->db->escape($data['max']) . "', name = '" . $this->db->escape(strip_tags($data['name'])) . "' , `values` = '" . $this->db->escape(strip_tags($data['values'])) . "'");
		$this->cache->delete('product');
	}

	public function editReview($review_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "review SET author = '" . $this->db->escape($data['author']) . "', product_id = '" . $this->db->escape($data['product_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW() WHERE review_id = '" . (int)$review_id . "'");

		$this->cache->delete('product');
	}

	public function deleteReview($review_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE review_id = '" . (int)$review_id . "'");

		$this->cache->delete('product');
	}
	
	public function downVote($review_id, $count) {
		$this->db->query("UPDATE " . DB_PREFIX . "megareviews SET downVotes = downvotes+" . $count . " WHERE review_id = '" . (int)$review_id . "'");

	}
	public function upVote($review_id, $count) {
		$this->db->query("UPDATE " . DB_PREFIX . "megareviews SET upvotes = upvotes+" . $count . " WHERE review_id = '" . (int)$review_id . "'");

	}
	public function getReview($review_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.name FROM " . DB_PREFIX . "product_description pd WHERE pd.product_id = r.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS product FROM " . DB_PREFIX . "review r WHERE r.review_id = '" . (int)$review_id . "'");

		return $query->row;
	}
	
	public function updateSettings($data = array()) {
		$this->updateOptions($data['options']);
	}

	public function getReviews($data = array()) {
		$sql = "SELECT r.review_id, r.author, r.rating, r.status, r.date_added, r.videotitle,r.upvotes,r.downvotes, r.text,r.title,r.recommend,r.videourl FROM " . DB_PREFIX . "megareviews r WHERE product_id='".$data['product_id']."' AND status=1";																																					  
		
		$sort_data = array(
			'pd.name',
			'r.upvotes',
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
		if($data['sort']=='r.upvotes')$sql .= ", downvotes ASC";
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 5;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}																																							  

		
		$query = $this->db->query($sql);																																				
		
		return $query->rows;	
	}

	public function getOptions() {
		$sql = "SELECT `option_id`, `sort_order`, `name`, `min`, `max`, `values` FROM " . DB_PREFIX . "megareviews_options ORDER BY sort_order ASC";																																					  

		$query = $this->db->query($sql);																																				

		return $query->rows;	
	}
	public function getReviewsInfo($pr_id) {
		$query = $this->db->query("SELECT FORMAT(AVG(rating),1) as avg FROM " . DB_PREFIX . "megareviews WHERE product_id='".$pr_id."' AND rating>-1 AND status=1");																																					  
		$result["rating"] = $query->row['avg'];
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "megareviews WHERE product_id='".$pr_id."' AND status=1");																																					  
		$result["count"] = $query->row['total'];
		$query = $this->db->query("SELECT COUNT(*) AS recommend FROM " . DB_PREFIX . "megareviews WHERE product_id='".$pr_id."' AND recommend=1 AND status=1");
		$query1 = $this->db->query("SELECT COUNT(*) AS notrecommend FROM " . DB_PREFIX . "megareviews WHERE product_id='".$pr_id."' AND recommend=0 AND status=1");
		if(($query->row['recommend']+$query1->row['notrecommend'])!=0)$result["recommend"] = (int)($query->row['recommend']*100/($query->row['recommend']+$query1->row['notrecommend']));
		//$query = $this->db->query("SELECT option_id, value  FROM " . DB_PREFIX . "megareviewsoptions_to_review WHERE product_id='".$pr_id."'");
		$options = $this->db->query("SELECT * FROM " . DB_PREFIX . "megareviews_options ORDER BY sort_order ASC");																																					  

		foreach($options->rows as $option){
			$query = $this->db->query("SELECT FORMAT(AVG(value),1) AS avg FROM " . DB_PREFIX . "megareviewsoptions_to_review WHERE review_id IN (SELECT review_id FROM " . DB_PREFIX . "megareviews WHERE product_id='".$pr_id."'  AND status=1) AND option_id='".$option['option_id']."' AND value!='-1' ");
			$result["options"][$option['option_id']]=$query->row['avg'];
		}
		$ays = $this->db->query("SELECT * FROM " . DB_PREFIX . "megareviews_ays ORDER BY sort_order ASC");																																					  

		foreach($ays->rows as $ay){
			$query = $this->db->query("SELECT FORMAT(AVG(value),1) AS avg FROM " . DB_PREFIX . "megareviewsays_to_review WHERE review_id IN (SELECT review_id FROM " . DB_PREFIX . "megareviews WHERE product_id='".$pr_id."'  AND status=1) AND ay_id='".$ay['ay_id']."' AND value!='-1'");
			$result["ays"][$ay['ay_id']]=$query->row['avg'];
		}
		
		//$query = $this->db->query("SELECT ay_id, value  FROM " . DB_PREFIX . "megareviewsays_to_review WHERE product_id='".$pr_id."'");
		return $result;	
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
	public function getAys() {
		$sql = "SELECT `ay_id`, `sort_order`, `name`,`values` FROM " . DB_PREFIX . "megareviews_ays ORDER BY sort_order ASC";																																					  

		$query = $this->db->query($sql);																																				

		return $query->rows;	
	}
	

	public function getTotalReviews() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review");

		return $query->row['total'];
	}

	public function getTotalReviewsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review WHERE status = '0'");

		return $query->row['total'];
	}	
}
?>