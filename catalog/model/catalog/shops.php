<?php
class ModelCatalogShops extends Model {
	public function getMainPageShopId() {
		$query = $this->db->query("SELECT id FROM " . DB_PREFIX . "shops WHERE on_main_page = '1' LIMIT 0,1");

		if($query->num_rows){
			return $query->row['id'];
		}
		
		return false;
	}
	public function getShop($shop_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shops WHERE id = '$shop_id' LIMIT 0,1");

		return $query->row;
	}

	public function getShops() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shops WHERE enable='1' AND id > 0 ORDER BY name");

		return $query->rows;
	}
	public function getIgnoreClickIpList($shop_id) {
			$query = $this->db->query("SELECT ip FROM " . DB_PREFIX . "shops_ignore_click_ip WHERE shop_id = '" . (int)$shop_id . "'") or die('1sdg dsvb dsf ds1');
			
			$return = array();
			foreach($query->rows as $row){
				$return[$row['ip']] = $row['ip'];
			}
		return $return;
	}

	public function getShopMoneySumm($shop_id) {
		$query = $this->db->query("SELECT SUM(`money_summ`) as summ FROM " . DB_PREFIX . "shops_money WHERE shop_id = '".$shop_id."'");
		
		$return = 0;
		if($query->num_rows){
			$return = $query->row['summ'];
		}
		return $return;
	}

	public function getShopManufacturers($shop_id) {
		$query = $this->db->query("SELECT distinct P.manufacturer_id, M.name
									FROM " . DB_PREFIX . "product_to_shop P2S
									LEFT JOIN " . DB_PREFIX . "product P ON P.product_id = P2S.product_id
									LEFT JOIN " . DB_PREFIX . "manufacturer M ON P.manufacturer_id = M.manufacturer_id
									WHERE P2S.shop_id = '".$shop_id."'
										GROUP BY P.manufacturer_id
										ORDER BY M.name ASC
										");
		
		return $query->rows;
	}


}