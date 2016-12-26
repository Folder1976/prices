<?php
class ModelCatalogAttribute extends Model {
	public function getAttributesIdOnProduct($product_id) {
		
		$query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "product_attribute WHERE product_id = '$product_id'");

		return $query->rows;
	}

	public function getAttributesOnIds($attribute_id) {
		
		if(is_array($attribute_id)){
			$attributes = implode(',',$attribute_id);
		}else{
			$attributes = (int)$attribute_id;
		}
		
		$sql = "SELECT
						A.attribute_id,
						A.attribute_group_id,
						A.filter_name,
						AD.name,
						AGD.name AS group_name,
						AGD.description
						
						FROM " . DB_PREFIX . "attribute A
						LEFT JOIN " . DB_PREFIX . "attribute_description AD ON A.attribute_id = AD.attribute_id
						LEFT JOIN " . DB_PREFIX . "attribute_group AG ON A.attribute_group_id = AG.attribute_group_id
						LEFT JOIN " . DB_PREFIX . "attribute_group_description AGD ON A.attribute_group_id = AGD.attribute_group_id
						
						WHERE A.attribute_id IN ($attributes) AND A.enable='1' AND AD.language_id = '" . (int)$this->config->get('config_language_id') . "'
						GROUP BY A.attribute_id
						ORDER BY A.sort_order, AD.name ;";
		//echo $sql;
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getAttributesOnGroupId($attribute_group_id) {
		
		
		$query = $this->db->query("SELECT
										A.attribute_id,
										A.attribute_group_id,
										A.filter_name,
										AD.name,
										AGD.name AS group_name,
										AGD.description
										
										FROM " . DB_PREFIX . "attribute A
										LEFT JOIN " . DB_PREFIX . "attribute_description AD ON A.attribute_id = AD.attribute_id
										LEFT JOIN " . DB_PREFIX . "attribute_group AG ON A.attribute_group_id = AG.attribute_group_id
										LEFT JOIN " . DB_PREFIX . "attribute_group_description AGD ON A.attribute_group_id = AGD.attribute_group_id
										
										WHERE A.attribute_group_id = '".(int)$attribute_group_id."' AND A.enable='1' AND AD.language_id = '" . (int)$this->config->get('config_language_id') . "'
										GROUP BY A.attribute_id
										ORDER BY A.sort_order, AD.name ;");

		return $query->rows;
	}
	
	public function getAttribute($attribute_id) {
		
		$attributes = (int)$attribute_id;
		
		$query = $this->db->query("SELECT
										A.attribute_id,
										A.attribute_group_id,
										A.filter_name,
										AD.name,
										AGD.name AS group_name,
										AGD.description
										
										FROM " . DB_PREFIX . "attribute A
										LEFT JOIN " . DB_PREFIX . "attribute_description AD ON A.attribute_id = AD.attribute_id
										LEFT JOIN " . DB_PREFIX . "attribute_group AG ON A.attribute_group_id = AG.attribute_group_id
										LEFT JOIN " . DB_PREFIX . "attribute_group_description AGD ON A.attribute_group_id = AGD.attribute_group_id
										
										WHERE A.attribute_id IN ($attributes) AND A.enable='1' AND AD.language_id = '" . (int)$this->config->get('config_language_id') . "'
										GROUP BY A.attribute_id
										LIMIT 0, 1;");

		return $query->row;
	}
	
	public function getAttributeAlias($attribute_id) {
		
		$attributes = (int)$attribute_id;
		
		$query = $this->db->query("SELECT filter_name
										FROM " . DB_PREFIX . "attribute 
										WHERE attribute_id IN ($attributes)
										LIMIT 0, 1;");

		if($query->num_rows){									
			return $query->row['filter_name'];
		}
		return '';
	}
	
	public function getAttributeName($attribute_id) {
		
		$attributes = (int)$attribute_id;
		
		$query = $this->db->query("SELECT name
										FROM " . DB_PREFIX . "attribute_description
										WHERE attribute_id IN ($attributes) AND language_id = '" . (int)$this->config->get('config_language_id') . "'
										LIMIT 0, 1;");

		if($query->num_rows){									
			return $query->row['name'];
		}
		return '';
	}
	
	public function getStringFromAttributes($attributes) {
		
		$return = '';
		
		foreach($attributes as $grp_id  => $attr_grp){
			
			$query = $this->db->query("SELECT name
										FROM " . DB_PREFIX . "attribute_group_description
										WHERE attribute_group_id = '$grp_id' LIMIT 0, 1;");
			if($query->num_rows){									
				$return .= $query->row['name'].': ';
			}
		
			
			$query = $this->db->query("SELECT name
										FROM " . DB_PREFIX . "attribute_description
										WHERE attribute_id IN (".implode(',',$attr_grp).");");
			
			if($query->num_rows){									
				foreach($query->rows as $row){
					$return .= mb_strtolower($row['name'],'UTF-8').', ';
				}
				$return = trim($return, ', ');
				$return .= '. ';
			}
			

		}

		return $return;
	}
	
	public function getSisezOnProduct($product_id) {
		
		if(is_array($product_id)){
			$product_id = implode(',',$product_id);
		}else{
			$product_id = (int)$product_id;
		}
		
		if(strlen($product_id) == 0) return array();
		$query = $this->db->query("SELECT
										S.size_id,
										S.name AS size_name,
										S.group_id,
										SG.name AS group_name,
										SG.filter_name AS filter_group_name
										
										FROM " . DB_PREFIX . "size S
										LEFT JOIN " . DB_PREFIX . "product_to_size P2S ON S.size_id = P2S.size_id
										LEFT JOIN " . DB_PREFIX . "size_group SG ON SG.id = S.group_id
										
										WHERE P2S.product_id IN ($product_id) AND S.enable='1'
										GROUP BY S.size_id
										ORDER BY S.sort, S.name ;");

		$data = array();
		
		foreach($query->rows as $size){
			$data[$size['group_id']]['group_id'] = $size['group_id'];
			$data[$size['group_id']]['group_name'] = $size['group_name'];
			$data[$size['group_id']]['filter_group_name'] = $size['filter_group_name'];
			$data[$size['group_id']]['sizes'][$size['size_id']]['size_id'] = $size['size_id'];
			$data[$size['group_id']]['sizes'][$size['size_id']]['size_name'] = $size['size_name'];
		}
	
		return $data;
	}
	
	public function getSisezOnProductNoGroup($product_id) {
		
		if(is_array($product_id)){
			$product_id = implode(',',$product_id);
		}else{
			$product_id = (int)$product_id;
		}
		
		if(strlen($product_id) == 0) return array();
		$query = $this->db->query("SELECT
										S.size_id,
										S.name AS size_name,
										S.group_id
										
										FROM " . DB_PREFIX . "size S
										LEFT JOIN " . DB_PREFIX . "product_to_size P2S ON S.size_id = P2S.size_id
										
										WHERE P2S.product_id IN ($product_id) AND S.enable='1'
										GROUP BY S.size_id
										ORDER BY S.sort, S.name ;");

		$data = array();
		
		foreach($query->rows as $size){
			$data[$size['size_id']]['size_id'] = $size['size_id'];
			$data[$size['size_id']]['size_name'] = $size['size_name'];
		}
	
		return $data;
	}

	
}