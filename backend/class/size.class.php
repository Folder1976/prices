<?php

class Size
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
		
    public function getSizeGroups(){
		$pp = $this->pp;
		
		$sql = 'SELECT * FROM `'.$pp.'size_group` where `enable` = "1" ORDER BY `sort`, `name`;';
		//echo $sql;
		$r = $this->db->query($sql) or die($sql);
		
		if($r->num_rows > 0){
			$return = array();
			while($tmp = $r->fetch_assoc()){
				$return[$tmp['id']] = $tmp;
			}
			return $return;
		}
		
		return 0;
		
	}

	public function getProductSizeStandart($product_id){
		$pp = $this->pp;
		
		$sql = 'SELECT S.group_id
					FROM `'.$pp.'product_to_size` P2S
					LEFT JOIN `'.$pp.'size` S ON S.size_id = P2S.size_id
					WHERE P2S.product_id = "'.$product_id.'" ORDER BY group_id DESC LIMIT 0,1;';

		//echo '<br>'.$sql;
		$r = $this->db->query($sql) or die($sql);
		
		if($r->num_rows > 0){
			
			$tmp = $r->fetch_assoc();
			return $tmp['group_id'];
		}
		
		return 0;
		
	}

	public function resetAllProductQantityOnShopId($shop_id){
		$pp = $this->pp;
		
		$sql = 'SELECT * FROM `'.$pp.'size_group` where `enable` = "1" ORDER BY `sort`, `name`;';
		
	}
	
	
	public function getSizesOnGroup(){
		$pp = $this->pp;
		
		$sql = 'SELECT * FROM `'.$pp.'size` where `enable` = "1" ORDER BY `sort`, `name`;';
		//echo $sql;
		$r = $this->db->query($sql) or die($sql);
		
		if($r->num_rows > 0){
			$return = array();
			while($tmp = $r->fetch_assoc()){
				$return[$tmp['size_id']] = $tmp;
			}
			return $return;
		}
		
		return 0;
		
	}

	
	
}

?>
