<?php

class Attribute
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
		
  
	public function getAttributeGroupOnName($attribute_group_name){
		$sql = "SELECT attribute_group_id FROM " . $this->pp . "attribute_group_description
									WHERE upper(`name`) LIKE '".mb_strtoupper(addslashes($attribute_group_name),'UTF-8')."' LIMIT 0,1;";
		$r = $this->db->query($sql);
	
		if($r->num_rows){
			
			$row = $r->fetch_assoc();
			return $row['attribute_group_id'];
			
		}
		
		return 0;
		
	}
	
	public function addAttributeGroupOnName($data){
		
		$sql = "INSERT INTO " . $this->pp . "attribute_group SET `enable` = '1', `sort_order` = '".$data['sort_order']."';";
		$this->db->query($sql);
	
		$attribute_group_id = $this->db->insert_id;
		
		$sql = "INSERT INTO " . $this->pp . "attribute_group_description SET
						`attribute_group_id` = '".$attribute_group_id."',
						`language_id` = '1',
						`name` = '".$data['name']."',
						`description` = '".$data['description']."';";
		$this->db->query($sql);
		
		return $attribute_group_id;
	}
	
	public function getAttributeGroupOrAdd($attribute_group_name){
	
		$attribute_group_id = $this->getAttributeGroupOnName($attribute_group_name);
	
		if($attribute_group_id) return $attribute_group_id;
	
		$data = array();
		$data['name'] = $attribute_group_name;
		$data['description'] = $attribute_group_name;
		$data['sort_order'] = 1;
		
		return $this->addAttributeGroupOnName($data);
		
	}
	
	//===========================================================================
	
	public function getAttributeOnName($attribute_name){
	
		$sql = "SELECT attribute_id FROM " . $this->pp . "attribute_description
									WHERE upper(`name`) LIKE '".mb_strtoupper(addslashes($attribute_name),'UTF-8')."' LIMIT 0,1;";
		$r = $this->db->query($sql);
		
		if($r->num_rows){
			
			$row = $r->fetch_assoc();
			return $row['attribute_id'];
			
		}
		
		return 0;
		
	}
	
	public function addAttributeOnName($data){
		
		$sql = "INSERT INTO " . $this->pp . "attribute SET
					`attribute_group_id` = '".$data['attribute_group_id']."',
					`filter_name` = '".$this->translit($data['name'])."',
					`enable` = '1',
					`sort_order` = '".$data['sort_order']."'
					;";
		$this->db->query($sql);
	
		$attribute_id = $this->db->insert_id;
		
		$sql = "INSERT INTO " . $this->pp . "attribute_description SET
						`attribute_id` = '".$attribute_id."',
						`language_id` = '1',
						`name` = '".$data['name']."';";
		$this->db->query($sql);
		
		return $attribute_id;
	}
	
	public function getAttributeOrAdd($attribute_name, $attribute_group_id = 0){
	
		$attribute_id = $this->getAttributeOnName($attribute_name, $attribute_group_id);
		
		if($attribute_id) return $attribute_id;
		
		$data = array();
		$data['name'] = $attribute_name;
		$data['description'] = $attribute_name;
		$data['attribute_group_id'] = $attribute_group_id;
		$data['sort_order'] = 1;
		
		return $this->addAttributeOnName($data);
		
	}
	
	//===========================================================================
	public function translit($str) {
		$rus = array(',',':',';','#','#039;','(',')',"\\",'/','№','»','«',"'",'"','и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
	    $lat = array('','','','','','','','','','','','','','','u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
		
		return  strtolower(trim(str_replace($rus, $lat, $str)));
	}

	
}

?>
