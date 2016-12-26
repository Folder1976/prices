<?php
class ModelDesignBanner extends Model {
	public function getBanner($banner_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_image bi LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE bi.banner_id = '" . (int)$banner_id . "' AND bid.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bi.sort_order ASC");

		return $query->rows;
	}
	
	public function getBannerLarge() {
	
		if(!isset($this->session->data['large_baner'])) $this->session->data['large_baner'] = 0;
		$count = $this->session->data['large_baner'];
		$count++;
		
		$sql = "SELECT count(baner_id) banners FROM " . DB_PREFIX . "baner  WHERE baner_type='large' AND is_view='1';";
		$query = $this->db->query($sql);
		$row = $query->row;
		
		if($count >= $row['banners']) $count = 0;
		
		$sql = "SELECT * FROM " . DB_PREFIX . "baner  WHERE baner_type='large' AND is_view='1' LIMIT $count, 1;";
	
		$query = $this->db->query($sql);
		$this->session->data['large_baner'] = $count;
		
		return $query->row;
	}
	
	public function getBannerLargeAll() {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "baner  WHERE baner_type='large' AND is_view='1';";
		$query = $this->db->query($sql);
		return $query->rows;

	}
	
	public function getBannerMediumAll() {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "baner  WHERE baner_type='medium' AND is_view='1';";
		$query = $this->db->query($sql);
		return $query->rows;

	}
	
	public function getBannerRandom($key, $items) {
	
		$sql = "SELECT baner_id FROM " . DB_PREFIX . "baner  WHERE baner_type='$key' AND is_view='1';";
		//echo $sql.'<br><br>';
		$query = $this->db->query($sql);
		$rows = array();
		foreach($query->rows as $row){
			$rows[$row['baner_id']] = $row['baner_id'];
		}
		
		$ids = array();
		while($items > 0){
			$id = array_rand($rows);
			unset($rows[$id]);
			$ids[] = (int)$id;
			$items--;
		}
		
			$sql = "SELECT * FROM " . DB_PREFIX . "baner  WHERE baner_id IN (".implode(',',$ids).");";
		
			$query = $this->db->query($sql);
					
			return $query->rows;
	}

}