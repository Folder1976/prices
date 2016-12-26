<?php
class ModelCatalogShop extends Model {
	public function getShop($shop_id) {
		$sql = "SELECT *
					FROM " . DB_PREFIX . "shops
					WHERE id = '" . (int)$shop_id . "'
					";
		$query = $this->db->query($sql);

		return $query->row;
	}

	
}