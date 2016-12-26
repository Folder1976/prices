<?php
class ModelCatalogMainmenu extends Model {
	public function getLeftMenuCategory() {
		
		$sql = 'SELECT * FROM '.DB_PREFIX.'main_page WHERE target="left_menu" AND `enable`="1" ORDER BY sort;';
		
		$query = $this->db->query($sql);

		return $query->rows;
	}

}