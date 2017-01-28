<?php
class ModelCatalogShops extends Model {
	public function getMainPageShopId() {
		$query = $this->db->query("SELECT id FROM " . DB_PREFIX . "shop WHERE on_main_page = '1' LIMIT 0,1");

		if($query->num_rows){
			return $query->row['id'];
		}
		
		return false;
	}
	public function getShop($shop_id) {
		
		$sql = "SELECT  	S.*,
							C.CityLable AS city_name,
							CO.name AS country_name
						FROM " . DB_PREFIX . "shop S
						LEFT JOIN " . DB_PREFIX . "citys C ON S.cityid = C.CityID
						LEFT JOIN " . DB_PREFIX . "country CO ON CO.country_id = C.country_id
						WHERE id = '$shop_id' LIMIT 0,1";
		
		$query = $this->db->query($sql);
		
		//echo $sql;
		return $query->row;
	}

	public function getShops() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shop WHERE status='1' AND id > 0 ORDER BY name");

		return $query->rows;
	}
	
	
	/*
     *Вернет массив адресов магазина
     *
     *input $id = ид товара
     */
    public function getMagazinAddress($id){
   
	    $sql = 'SELECT
                A.*,
				C.CityLable AS city_name,
				CO.name AS country_name
            FROM ' . DB_PREFIX . 'shop_address A
			LEFT JOIN ' . DB_PREFIX . 'citys C ON A.cityid = C.CityID
			LEFT JOIN ' . DB_PREFIX . 'country CO ON CO.country_id = C.country_id
			WHERE shop_id = \''.$id.'\';';
        // echo '=='.$sql;      
        
        $r = $this->db->query($sql) or die($sql.'<br>'.mysqli_error($this->base));
        
        if($r->num_rows == 0){
		
			return false;
		
		}
			
		return $r->rows;
		   
	}
    
	public function getShopInfo($shop_id = 0) {
		
		if((int)$shop_id < 1) return false;
		
		
		$shop = $this->getShop($shop_id);
		
		//echo $shop_id;
		
		if($shop){
			
			$shop['addresses'] = $this->getMagazinAddress($shop_id);
			
			return $shop;
			
		}
		
		return false;
		
	}
	
	/*
     *Вернет Ид магазина по Ид адреса
     *
     *input $id = ид адреса
     */
    public function getMagazinInOnAddressID($id){
        
        $sql = 'SELECT magazinid FROM magazin_address
						WHERE id = \''.$id.'\';';
        $r = $this->db->query($sql) or die($sql.'<br>'.mysqli_error($this->base));
        
        if($r->num_rows == 0){
		
			return false;
		
		}
			
			$tmp = $r->fetch_assoc();
			return $tmp['magazinid'];
	
	}
	
	/*
     *Вернет массив магазинных адресов
     *
     *input $id = ид адреса
     */
    public function getMagazinAddresss($id){
        
        $sql = 'SELECT
                M.id AS magazin_id,
                C.name AS city_name,
                M.name AS magazin_name,
                CO.name AS country_name,
                M.logo,
                M.phone AS main_phone,
                M.siteurl,
                M.address AS main_addres,
                MA.*
            FROM magazin_address MA
            LEFT JOIN magazin M ON MA.magazinid = M.id
            LEFT JOIN city C ON MA.cityid = C.id
            LEFT JOIN country CO ON CO.id = C.countryid
			WHERE MA.status="1" AND M.status="1" AND MA.magazinid = "'.$id.'" ORDER BY address ASC;';
        // echo '=='.$sql;      
        
        $r = $this->db->query($sql) or die($sql.'<br>'.mysqli_error($this->base));
        
        if($r->num_rows == 0){
		
			return false;
		
		}
		
			$return = array();
			while($tmp = $r->fetch_assoc()){
				$return[$tmp['id']] =  $tmp;
			}
			
		return $return;
        
    }
	
	/*
	 *Вернет список работающих магазинов
	 */
	public function getOpenedMagazinesID(){
		
			$sql = "SELECT magazinid AS id, worktime".date('N')." AS worktime FROM magazin_address WHERE status=1";
			$r = $this->db->query($sql) or die('не удалось получить магазины 2 '.$sql);
			
			$return = array();
			
			while($tmp = $r->fetch_assoc()){
				
				$time = $tmp['worktime'];
				//Определяем работает ли магазин
				str_replace(' ', '', $time);
				$time_a = explode('-', $time);
				$time_a[0] = trim($time_a[0]);
				if(isset($time_a[1])){
					$time_a[1] = trim($time_a[1]);
				}else{
					$time_a[1] = $time_a[0];
				}
				
				if(date('H:i') >= date('H:i', strtotime($time_a[0])) AND date('H:i') <= date('H:i', strtotime($time_a[1])) ){
					$return[$tmp['id']] = $tmp['id'];
				}
				
			}
		return $return;
	}
	
	/*
	 * Получим все магазины
	 */
	public function getMagazins(){
        
		$sql = "SELECT
                M.id,
                C.name AS city_name,
                M.name,
                CO.name AS country_name,
                M.logo,
                M.phone,
                M.siteurl,
                M.address,
                M.worktime
            FROM magazin M
            LEFT JOIN city C ON cityid = C.id
            LEFT JOIN country CO ON CO.id = C.countryid
			WHERE M.status='1';";
        //$sql = 'SELECT * FROM magazin ORDER BY name ASC;';
        //echo '=='.$sql;      
        
        $r = $this->db->query($sql) or die(mysqli_error($this->base));
        
        if($r->num_rows == 0){
		
			return false;
		
		}
		
			$return = array();
			while($tmp = $r->fetch_assoc()){
				$return[$tmp['id']] =  $tmp;
			}
			
		return $return;
        
    }


}