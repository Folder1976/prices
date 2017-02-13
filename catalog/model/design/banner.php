<?php
class ModelDesignBanner extends Model {
	public function getBanner($banner_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_image bi LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE bi.banner_id = '" . (int)$banner_id . "' AND bid.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bi.sort_order ASC");

		return $query->rows;
	}

	public function getMainTopPolosa() {
		
		if(!isset($_SESSION['MainTopPolosa'])) $_SESSION['MainTopPolosa'] = 0;
		
		$sql = "SELECT * FROM " . DB_PREFIX . "baner_line  BL
						LEFT JOIN " . DB_PREFIX . "baner_line_description  BLD ON BL.baner_line_id = BLD.baner_line_id
						WHERE BL.`enable`= 1 AND BLD.language_id = " . (int)$this->config->get('config_language_id') . "
						ORDER BY sort LIMIT ".(int)$_SESSION['MainTopPolosa'].", 1;";
		$query = $this->db->query($sql);
		$row = $query->row;
		
		
		$sql = "SELECT count(baner_line_id) as total FROM " . DB_PREFIX . "baner_line WHERE `enable`=1 ;";
		$query = $this->db->query($sql);
		$row2 = $query->row;
		
		if($_SESSION['MainTopPolosa'] >= ($row2['total'] - 1)){
			$_SESSION['MainTopPolosa'] = 0;
		}else{
			$_SESSION['MainTopPolosa']++;
		}
		
		
		return $row;

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
		
		$sql = "SELECT
					B.baner_id,
					B.baner_name,
					B.is_view,
					B.baner_url,
					B.baner_pic,
					B.baner_type,
					B.baner_place,
					BD.text AS baner_text,
					B.baner_text_color,
					BD.header AS baner_header,
					BD.title AS baner_title,
					BD.price AS baner_price,
					BD.slogan AS baner_slogan,
					B.baner_sort
					FROM " . DB_PREFIX . "baner B
					LEFT JOIN " . DB_PREFIX . "baner_description BD ON B.baner_id = BD.baner_id
					WHERE baner_type='large' AND language_id = '" . (int)$this->config->get('config_language_id') . "' AND is_view='1';";
		$query = $this->db->query($sql);
		return $query->rows;

	}
	
	public function getBannerMediumAll() {
		
		$sql = "SELECT
					B.baner_id,
					B.baner_name,
					B.is_view,
					B.baner_url,
					B.baner_pic,
					B.baner_type,
					B.baner_place,
					BD.text AS baner_text,
					B.baner_text_color,
					BD.header AS baner_header,
					BD.title AS baner_title,
					BD.price AS baner_price,
					BD.slogan AS baner_slogan,
					B.baner_sort
					FROM " . DB_PREFIX . "baner B
					LEFT JOIN " . DB_PREFIX . "baner_description BD ON B.baner_id = BD.baner_id
					WHERE baner_type='medium' AND language_id = '" . (int)$this->config->get('config_language_id') . "' AND is_view='1';";
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