<?php

class Designer
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
	
	public function getDesignerIdOnName($name, $shop_id){
		
		$name = str_replace("'",'&#39;', $name);
		$name = str_replace("\\",'', $name);
		$name = str_replace("&amp;",'&', $name);
		
		$pp = $this->pp;
		
		$sql = 'SELECT manufacturer_id FROM `'.$pp.'manufacturer` WHERE
				upper(`name`) = \''.mb_strtoupper(addslashes($name),'UTF-8').'\' OR
				upper(`name`) = "'.mb_strtoupper(addslashes(htmlentities($name,ENT_QUOTES, 'UTF-8')),'UTF-8').'";';
		
		$r = $this->db->query($sql) or die($sql);
		
		//echo '<br>'.$sql.' '.$r->num_rows;
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp['manufacturer_id'];
		}else{
			$sql = 'SELECT id FROM `'.$pp.'manufacturer_alternative` WHERE
				(upper(`name`) = "'.mb_strtoupper(addslashes($name),'UTF-8').'" AND shop_id="'.$shop_id.'") OR
				(upper(`name`) = "'.mb_strtoupper(addslashes($name),'UTF-8').'" AND shop_id="0") ;';
			//echo $sql;
			$r = $this->db->query($sql);
			
			if($r->num_rows > 0){
				$tmp = $r->fetch_assoc();
				return $tmp['id'];
			}
		}
		
		return 0;

		
		/*
		$pp = $this->pp;
		
		$sql = 'SELECT id FROM `'.$pp.'guidedesigner` WHERE
				upper(`name`) = "'.mb_strtoupper(addslashes($name),'UTF-8').'" OR
				upper(`alternative_name`) LIKE "%'.mb_strtoupper(addslashes($name),'UTF-8').'%";';
		//echo $sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp['id'];
		}
		
		return 0;
		*/
		
	}

	public function getDesigner($id){
		$pp = $this->pp;
		
		$sql = 'SELECT * FROM `'.$pp.'manufacturer` WHERE
						manufacturer_id = "'.$id.'";';
		//echo $sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp;
		}
		
		return false;
		
	}
	
	public function getManufacturers(){
		return $this->getDesigners();
	}
	
	public function getDesigners(){
		$pp = $this->pp;
		
		$sql = 'SELECT * FROM `'.$pp.'manufacturer` ORDER BY name;';
		//echo $sql;
		$r = $this->db->query($sql);
		
		$return = array();
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
				$return[$tmp['manufacturer_id']] = $tmp;
			}
		}
		
		return $return;
		
	}
	
	public function addManufacturer($data) {
	
		$this->db->query("INSERT INTO " . $this->pp . "manufacturer SET
						 name = '" .htmlentities($data['name'],ENT_QUOTES,'UTF-8') . "',
						 name_sush = '" . htmlentities($data['name_sush'],ENT_QUOTES,'UTF-8') . "',
						 name_rod = '" . htmlentities($data['name_rod'],ENT_QUOTES,'UTF-8') . "',
						 name_several = '" . htmlentities($data['name_several'],ENT_QUOTES,'UTF-8') . "',
						 sort_order = '" . (int)$data['sort_order'] . "'");

		$manufacturer_id = $this->db->insert_id;

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . $this->pp . "manufacturer SET
							 image = '" . htmlentities($data['image'],ENT_QUOTES,'UTF-8') . "'
														WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		}

		if (isset($data['manufacturer_store'])) {
			foreach ($data['manufacturer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . $this->pp . "manufacturer_to_store SET
								 manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		//description
		$this->db->query("DELETE FROM " . $this->pp . "manufacturer_description WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		if (isset($data['manufacturer_description'])) {
			$this->db->query("INSERT INTO " . $this->pp . "manufacturer_description SET
								manufacturer_id = '" . (int)$manufacturer_id . "',
								title_h1 = '" . htmlentities($data['manufacturer_description']['title_h1'],ENT_QUOTES,'UTF-8') . "',
								description = '" . htmlentities($data['manufacturer_description']['description'],ENT_QUOTES,'UTF-8') . "',
								meta_title = '" . htmlentities($data['manufacturer_description']['meta_title'],ENT_QUOTES,'UTF-8') . "',
								meta_description = '" . htmlentities($data['manufacturer_description']['meta_description'],ENT_QUOTES,'UTF-8') . "',
								meta_keyword = '" . htmlentities($data['manufacturer_description']['meta_keyword'],ENT_QUOTES,'UTF-8') . "'
								");
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . $this->pp . "url_alias SET
							 query = 'manufacturer_id=" . (int)$manufacturer_id . "',
							 keyword = '" . htmlentities($data['keyword'],ENT_QUOTES,'UTF-8') . "'");
		}

		return $manufacturer_id;
	}

}

?>
