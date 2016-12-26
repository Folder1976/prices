<?php

class Category
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
	
	public function getCategoryIdOnAlternativeName($id, $name, $shop_id){
		$pp = $this->pp;
		
		$sql = 'SELECT CA.category_id AS id, CD.name FROM `'.$pp.'category_alternative` CA
					LEFT JOIN `'.$pp.'category_description` CD ON CD.category_id = CA.category_id
					WHERE
				alt_category_id = "'.$id.'" AND
				shop_id = "'.$shop_id.'" ORDER BY id DESC;';
		//echo '<br>'.$sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp;
		}
	
		
		$sql = 'SELECT CA.category_id AS id, CD.name FROM `'.$pp.'category_alternative` CA
							LEFT JOIN `'.$pp.'category_description` CD ON CD.category_id = CA.category_id
							WHERE
				(upper(`alt_category_name`) = "'.mb_strtoupper(addslashes($name),'UTF-8').'" AND	shop_id = "'.$shop_id.'") OR
				(upper(`alt_category_name`) = "'.mb_strtoupper(addslashes($name),'UTF-8').'" AND	shop_id = "0");';
		//echo $sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp;
		}
		
		return false;
		
	}

	
	
}

?>
