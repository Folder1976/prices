<?php
class ModelAccountMyAccount extends Model {
	public function saveIpList($shop_id, $ip_list) {
		
		$sql = 'DELETE FROM ' . DB_PREFIX . 'shops_ignore_click_ip WHERE shop_id = "'.(int)$shop_id.'";';
		$this->db->query($sql);
		
		foreach($ip_list as $ip){
			$sql = 'INSERT INTO ' . DB_PREFIX . 'shops_ignore_click_ip SET ip = "'.$this->db->escape($ip).'", shop_id = "'.(int)$shop_id.'";';
			$this->db->query($sql);
		}
		
	}

	
}
