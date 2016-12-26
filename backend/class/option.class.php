<?php

class Option
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
	
	public function getOptionValueIdOnName($name, $option_id = 0){
		
		$name = str_replace("'",'&#39;', $name);
		$name = str_replace("\\",'', $name);
		$name = str_replace("&amp;",'&', $name);
		
		$pp = $this->pp;
		
		$sql = 'SELECT option_value_id FROM `'.$pp.'option_value_description` WHERE
				upper(`name`) = \''.mb_strtoupper(addslashes($name),'UTF-8').'\' ';
		
		if(	$option_id > 0 ){
			$sql .= ' AND option_id = "'.$option_id.'";';
		}
		
		$r = $this->db->query($sql) or die($sql);
		
		
		if($r->num_rows > 0){
			
			$tmp = $r->fetch_assoc();
			return $tmp['option_value_id'];
		
		}else{
			/* Тут код для альтернативных размеров
			$sql = 'SELECT id FROM `'.$pp.'manufacturer_alternative` WHERE
				(upper(`name`) = "'.mb_strtoupper(addslashes($name),'UTF-8').'" AND shop_id="'.$shop_id.'") OR
				(upper(`name`) = "'.mb_strtoupper(addslashes($name),'UTF-8').'" AND shop_id="0") ;';
			//echo $sql;
			$r = $this->db->query($sql);
			
			if($r->num_rows > 0){
				$tmp = $r->fetch_assoc();
				return $tmp['id'];
			}*/
		}
		
		return 0;

	}

	public function getOptionValueOrAdd($name, $option_id = 0){
		
		$option_value_id = $this->getOptionValueIdOnName($name, $option_id);
		
		if($option_value_id) return $option_value_id;
		
		$data = array();
		$data['name'] = $name;
		$data['option_id'] = $option_id;
		$data['language_id'] = 1;
		$data['image'] = '';
		$data['sort_order'] = 0;
		
		$option_value_id = $this->addOptionValue($data);
		
		return $option_value_id;
		
	}
	

	public function addOptionValue($data) {
	
		$this->db->query("INSERT INTO " . $this->pp . "option_value SET
						 option_id = '" .$data['option_id'] . "',
						 image = '" .$data['image'] . "',
						 sort_order = '" .$data['sort_order'] . "'");

		$option_value_id = $this->db->insert_id;

		$sql = "INSERT INTO " . $this->pp . "option_value_description SET
						 option_value_id = '" .$option_value_id . "',
						 option_id = '" .$data['option_id'] . "',
						 language_id = '" .$data['language_id'] . "',
						 name = '" .$data['name'] . "'";
		$this->db->query($sql);
	
		return $option_value_id;
	}

	
	public function translit($str) {
		$rus = array(',', 'І','и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
		$lat = array('', 'I','u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
		return str_replace($rus, $lat, $str);
	}
}

?>
