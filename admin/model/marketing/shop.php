<?php
class ModelMarketingShop extends Model {

	public function getShops(){
		$sql = "SELECT * FROM " . DB_PREFIX . "shop ORDER BY sort, name";

		$query = $this->db->query($sql);

		return $query->rows;
	}


}