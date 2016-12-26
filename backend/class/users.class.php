<?php

class Users
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
	
    public function getUserPermission($user_id){
		$pp = $this->pp;
		/*
		$sql = 'SELECT id FROM `'.$pp.'shops` WHERE
				upper(`xml_name`) = "'.mb_strtoupper(addslashes($name),'UTF-8').'";';
		//echo $sql;
		$r = $this->db->query($sql);
		
		if($r->num_rows > 0){
			$tmp = $r->fetch_assoc();
			return $tmp['id'];
		}
		*/
		return 0;
		
	}
	
	public function getUserMainMenu($user_id){
		$pp = $this->pp;
		
		$sql = 'SELECT modul_group_id, modul_group_nazv FROM `'.$this->pp.'user_moduls_groups` ORDER BY modul_group_poz;';
		//echo $sql;
		$r = $this->db->query($sql);
		
		$data = array();
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
				$data[$tmp['modul_group_id']]['name'] = $tmp['modul_group_nazv'];
			}
		}
		
		$sql = 'SELECT
					UR.ua_modul_id AS id,
					MS.ua_modul_nazv AS name,
					MS.ua_modul_dir AS dir,
					MS.is_show,
					MS.ua_modul_mfile AS file,
					MS.ua_modul_icon AS icon,
					MS.ua_modul_icon AS icon,
					MS.modul_group_id
					FROM `'.$this->pp.'user_moduls_rights` UR
					LEFT JOIN `'.$this->pp.'user_moduls_spis` MS ON MS.ua_modul_id = UR.ua_modul_id
					WHERE UR.uadm_flag = "1" AND uadm_id = "'.$user_id.'" AND modul_submenu = "0"
					ORDER BY UR.ua_modul_poz, MS.modul_sort;';
		//echo $sql;
		$r = $this->db->query($sql);
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
				$data[$tmp['modul_group_id']]['menu'][$tmp['id']]['id'] = $tmp['id'];
				$data[$tmp['modul_group_id']]['menu'][$tmp['id']]['name'] = $tmp['name'];
				$data[$tmp['modul_group_id']]['menu'][$tmp['id']]['dir'] = $tmp['dir'];
				$data[$tmp['modul_group_id']]['menu'][$tmp['id']]['file'] = $tmp['file'];
				$data[$tmp['modul_group_id']]['menu'][$tmp['id']]['is_show'] = $tmp['is_show'];
				$data[$tmp['modul_group_id']]['menu'][$tmp['id']]['icon'] = $tmp['icon'];
			}
		}
		
		return $data;
		
	}

	public function getUserSubMenu($user_id){
		$pp = $this->pp;
		
		$sql = 'SELECT modul_group_id, modul_group_nazv FROM `'.$this->pp.'user_moduls_groups` ORDER BY modul_group_poz;';
		//echo $sql;
		$r = $this->db->query($sql);
		
		$data = array();
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
				$data[$tmp['modul_group_id']]['name'] = $tmp['modul_group_nazv'];
			}
		}
		
		$sql = 'SELECT
					UR.ua_modul_id AS id,
					MS.modul_submenu,
					MS.ua_modul_nazv AS name,
					MS.ua_modul_dir AS dir,
					MS.is_show,
					MS.ua_modul_mfile AS file,
					MS.ua_modul_icon AS icon,
					MS.ua_modul_icon AS icon,
					MS.modul_group_id
					FROM `'.$this->pp.'user_moduls_rights` UR
					LEFT JOIN `'.$this->pp.'user_moduls_spis` MS ON MS.ua_modul_id = UR.ua_modul_id
					WHERE UR.uadm_flag = "1" AND uadm_id = "'.$user_id.'" AND modul_submenu > "0"
					ORDER BY UR.ua_modul_poz, MS.modul_sort;';
		//echo $sql;
		$r = $this->db->query($sql);
		if($r->num_rows > 0){
			while($tmp = $r->fetch_assoc()){
				$data[$tmp['modul_submenu']][$tmp['id']]['id'] = $tmp['id'];
				$data[$tmp['modul_submenu']][$tmp['id']]['name'] = $tmp['name'];
				$data[$tmp['modul_submenu']][$tmp['id']]['dir'] = $tmp['dir'];
				$data[$tmp['modul_submenu']][$tmp['id']]['file'] = $tmp['file'];
				$data[$tmp['modul_submenu']][$tmp['id']]['is_show'] = $tmp['is_show'];
				$data[$tmp['modul_submenu']][$tmp['id']]['icon'] = $tmp['icon'];
			}
		}
		
		return $data;
		
	}

}

?>
