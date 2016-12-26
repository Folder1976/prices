<?php

class Brand
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
		
    public function getBrands(){
		$pp = $this->pp;
		
		$sql = 'SELECT
					manufacturer_id AS id,
					name,
					sort_order AS sort,
					enable
					FROM `'.$pp.'manufacturer` ORDER BY `sort_order`,`name`;';
		//echo $sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$return = array();
			while($tmp = $r->fetch_assoc()){
				$return[$tmp['id']] = $tmp;
			}
			return $return;
		}
		
		return 0;
		
	}

	
	
}

?>
