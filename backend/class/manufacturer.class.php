<?php

class Manufacturer
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
	
	public function getManufacturerIdOnName($name, $shop_id = 0){
		
		$name = str_replace("'",'&#39;', $name);
		$name = str_replace("\\",'', $name);
		$name = str_replace("&amp;",'&', $name);
		
		$pp = $this->pp;
		
		$sql = 'SELECT manufacturer_id FROM `'.$pp.'manufacturer` WHERE
				upper(`name`) = \''.mb_strtoupper(addslashes($name),'UTF-8').'\' OR
				upper(`name`) = "'.mb_strtoupper(addslashes($this->translit(htmlentities($name,ENT_QUOTES, 'UTF-8'))),'UTF-8').'";';
		
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

	}

	public function getManufacturerOrAdd($name, $shop_id = 0){
		
		$manufacturer_id = $this->getManufacturerIdOnName($name, $shop_id);
		
		if($manufacturer_id) return $manufacturer_id;
		
		$data = array();
		$data['name'] = $name;
		$data['name_sush'] = $name;
		$data['name_rod'] = $name;
		$data['name_several'] = $name;
		$data['sort_order'] = 0;
		$data['keyword'] = strtolower($this->translit($name));;
		$data['manufacturer_store'] = array(1);
		$data['manufacturer_description'] = array(
												  'title_h1'=>$name,
												  'description'=>$name,
												  'meta_title'=>$name,
												  'meta_description'=>$name,
												  'meta_keyword'=>$name
												  );
		
		$manufacturer_id = $this->addManufacturer($data);
		
		return $manufacturer_id;
		
	}
	
	public function getManufacturer($id){
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
	
	public function addManufacturer($data) {
	
		$this->db->query("INSERT INTO " . $this->pp . "manufacturer SET
						 name = '" .$this->translit(htmlentities($data['name'],ENT_QUOTES,'UTF-8')) . "',
						 code = '" .htmlentities($data['name'],ENT_QUOTES,'UTF-8') . "',
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

	
	public function translit($str) {
		$rus = array(',', 'І','и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
		$lat = array('', 'I','u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
		return str_replace($rus, $lat, $str);
	}
}

?>
