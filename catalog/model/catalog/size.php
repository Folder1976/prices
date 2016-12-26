<?php
class ModelCatalogSize extends Model {

	public function getSizes($sizes_id) {
		if(is_array($sizes_id) AND count($sizes_id) > 0){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value_description
									WHERE option_value_id IN (".implode(',',$sizes_id).")
									AND language_id = '" . (int)$this->config->get('config_language_id') . "';");
		}else{
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value_description
									WHERE option_value_id = '".(int)$sizes_id."'
									AND language_id = '" . (int)$this->config->get('config_language_id') . "';");
		}
		
		return $query->rows;
	}

	public function getSizesOLD($sizes_id) {
		if(is_array($sizes_id) AND count($sizes_id) > 0){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "size
									WHERE size_id IN (".implode(',',$sizes_id).")");
		}else{
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "size
									WHERE size_id = '".(int)$sizes_id."'");
		}
		
		return $query->rows;
	}

}