<?php
class ModelCheckoutDelivery extends Model {
	public function getDeliveryOnCountryId($country_id) {
		
		$r = $this->db->query("SELECT D2C.*, D.name, C.* FROM `" . DB_PREFIX . "delivery_to_country` D2C
								LEFT JOIN `" . DB_PREFIX . "delivery` D ON D.delivery_id = D2C.delivery_id 
								LEFT JOIN `" . DB_PREFIX . "currency` C ON C.currency_id = D2C.currency_id
								WHERE D2C.country_id = '" . (int)$country_id . "';");

		
		return $r->rows;
		
	}
	
	public function getDeliveryOnCountryCode($code) {
		
		$this->load->model('localisation/country');
		$country_info = $this->model_localisation_country->getCountryOnCode($code);
		$country_id = $country_info['country_id'];
		
		return $this->getDeliveryOnCountryId($country_id);
		
	}
}
