<?php

class Shops
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
	
    public function getShopOnXmlName($name){
		$pp = $this->pp;
		
		$sql = 'SELECT id FROM `'.$pp.'shops` WHERE
				upper(`xml_name`) = "'.mb_strtoupper(addslashes($name),'UTF-8').'";';
		//echo $sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp['id'];
		}
		
		return 0;
		
	}
	
	public function getShop($id){
		$pp = $this->pp;
		
		$sql = 'SELECT id FROM `'.$pp.'shops` WHERE id = "'.$id.'";';
		//echo $sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp['id'];
		}
		
		return 0;
		
	}

	public function getShopName($id){
		$pp = $this->pp;
		
		$sql = 'SELECT name FROM `'.$pp.'shops` WHERE id = "'.$id.'";';
		//echo $sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp['name'];
		}
		
		return '';
		
	}

	public function getShopInfo($id){
		$pp = $this->pp;
		
		$sql = 'SELECT * FROM `'.$pp.'shops` WHERE id = "'.$id.'" LIMIT 0, 1;';
		//echo $sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp;
		}
		
		return array();
		
	}

	public function getShops(){
		$pp = $this->pp;
		
		$sql = 'SELECT id, name FROM `'.$pp.'shops` WHERE enable = "1" ORDER BY sort, name;';
		//echo $sql;
		$r = $this->db->query($sql);
		
		$return = array();
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
				$return[$tmp['id']] = $tmp;
			}
		}
		
		return $return;
		
	}

}

?>
