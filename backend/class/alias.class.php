<?php

class Alias
{
	private $db;
	private $pp;
	
    function __construct ($conn, $pp){
		$this->db = $conn;
		$this->pp = $pp;
	}
		
    public function getProductAlias($product_id){
		$pp = $this->pp;
		$alias = '';
		
		$sql = 'SELECT category_id FROM `'.$pp.'product_to_category` where `product_id` = "'.$product_id.'" AND is_main=1 LIMIT 0,1;';
		$r = $this->db->query($sql) or die($sql);
		
		
		
		if($r->num_rows > 0){
			
			$row = $r->fetch_assoc();
			$alias = $this->getCategoryAlias($row['category_id']);
			
		}
		
		
		$alias = trim($alias,'-');
	
		
		
		$sql = 'SELECT sku, name, code
					FROM `'.$pp.'product` P
					LEFT JOIN `'.$pp.'product_description` PD ON (P.product_id = PD.product_id)
					WHERE P.product_id="'.$product_id.'" LIMIT 0,1;';
		$r = $this->db->query($sql) or die($sql);
		if($r->num_rows > 0){
			
			$row = $r->fetch_assoc();
			
			$row['code'] = urldecode($row['code']);
			$row['sku'] = urldecode($row['sku']);
			
			if($row['code'] != ''){
				$alias .= '/'.strtolower($this->translitArtkl(strtolower($row['code'])));
			}elseif($row['sku'] != ''){
				$alias .= '/'.strtolower($this->translitArtkl($row['name'].'-'.$row['sku']));
			}else{
				$alias .= '/'.strtolower($this->translitArtkl($row['name'].'-'.$product_id));
			}
		}
		
		
		
		
		$alias = trim($alias);
		$alias = str_replace('"','-', $alias);
		$alias = str_replace('%20','-', $alias);
		$alias = str_replace('®','-', $alias);
		$alias = str_replace('--','-', $alias);
		$alias = str_replace('--','-', $alias);
		$alias = str_replace('--','-', $alias);
		$alias = str_replace('--','-', $alias);
		
		echo $alias.'<br>';
		
		return $alias;
		
	}
	
	public function getCategoryAlias($category_id){
		$pp = $this->pp;
		$alias = '';
		
		while($category_id > 0){
			$sql = 'SELECT C.category_id, parent_id, C.code, name FROM `'.$pp.'category` C
							LEFT JOIN `'.$pp.'category_description` CD ON CD.category_id = C.category_id AND CD.language_id = 1
							WHERE C.category_id = "'.$category_id.'";';
			$r = $this->db->query($sql) or die($sql);
		
			if($r->num_rows > 0){
				$row = $r->fetch_assoc();
				
				if($row['parent_id'] > 0){
					$category_id = $row['parent_id'];
				}else{
					$category_id = 0;
				}
				
				if($row['code'] != ''){
					$alias = strtolower($this->translitArtkl(trim($row['code']))).'-'.$alias;	
				}else{
					$alias = strtolower($this->translitArtkl(trim($row['name']))).'-'.$alias;
				}
				
				
				
			}else{
				$category_id = 0;
			}
		
		}
	
		return trim($alias,'-');
		
	}

	public function setProductAlias($alias, $product_id){
		
		$pp = $this->pp;
		
		$sql = 'SELECT keyword FROM `'.$pp.'url_alias` where `query` = "product_id='.$product_id.'" LIMIT 0,1;';
		$r = $this->db->query($sql) or die($sql);
		if($r->num_rows > 0){
			
			$sql = 'UPDATE `'.$pp.'url_alias` SET keyword = "'.$alias.'" where `query` = "product_id='.$product_id.'";';
			
		}else{
			
			$sql = 'INSERT INTO `'.$pp.'url_alias` SET keyword = "'.$alias.'", `query` = "product_id='.$product_id.'";';
			
		}
		
		$this->db->query($sql);// or die($sql);
		
	}
	
	public function setCategoryAlias($alias, $category_id){
		
		$pp = $this->pp;
		
		$sql = 'SELECT keyword FROM `'.$pp.'url_alias` where `query` = "category_id='.$category_id.'" LIMIT 0,1;';
		$r = $this->db->query($sql) or die($sql);
		if($r->num_rows > 0){
			
			$sql = 'UPDATE `'.$pp.'url_alias` SET keyword = "'.$alias.'" where `query` = "category_id='.$category_id.'";';
			
		}else{
			
			$sql = 'INSERT INTO `'.$pp.'url_alias` SET keyword = "'.$alias.'", `query` = "category_id='.$category_id.'";';
			
		}
		
		$this->db->query($sql);// or die($sql);
		
	}
	
	public function getArrayFromAlias($alias){
	
		$aliases = explode('-', $alias);
		
		$categ = $alias;
		$data = array();
		$attributes = array();
		$sizes = array();
		$attributes_name = array();
		
		$attr_array = array();
		if(count($aliases) > 0){
				
			$attr_array['group_id'] = 0;
			$attr_array['attribute_name'] = 'none';
			$attr_array['group_name'] = 'none';			
			
			foreach($aliases as $alias){
				
				//Если есть подчеркивание - Это размер
				if(strpos($alias,'_') !== false){
					$size = explode('_',$alias);
					
					$sql = "SELECT size_id FROM " . $this->pp . "size
									WHERE name LIKE '" . $size[1] . "' AND
										group_id = (SELECT id FROM " . $this->pp . "size_group WHERE filter_name LIKE '" . $size[0] . "')
									LIMIT 0,1;";
					$query = $this->db->query($sql);
					if($query->num_rows){
						$row = $query->fetch_assoc();
						$sizes[] = $row['size_id'];
					}
					//echo '<br>'.$sql;
					
					$sql = "SELECT query FROM " . $this->pp . "url_alias WHERE keyword LIKE '" . $categ . "' AND `query` LIKE 'category_id=%' LIMIT 0,1;";
					$query = $this->db->query($sql);
					//echo '<br>'.$sql;
				
					if($query->num_rows){
						
						$row = $query->fetch_assoc();
						
						$url = explode('=', $row['query']);
						$data['sizes'] = implode(',',$sizes);
						$data['attributes'] = implode(',',$attributes);
						if((int)$attr_array['group_id'] > 0){
							$data['attributes_array'] = $attr_array;
						}
						$data['attributes_name'] = implode(',',$attributes_name);
						$data['category_id'] = $url[1];
						$data['path'] = true;
						break;
					
					}elseif($categ == 'lovedproducts'  OR
						
						$categ == 'lastviewed'){

						$data['sizes'] = implode(',',$sizes);
						$data['attributes'] = implode(',',$attributes);
						$data['attributes_name'] = implode(',',$attributes_name);
						$data['category_id'] = 0;
						break;

					}
			
				}else{
				
					$sql = "SELECT A.attribute_id, A.attribute_group_id, AD.name AS attribute_name, AGD.name AS group_name
							FROM " . $this->pp . "attribute A
							LEFT JOIN " . $this->pp . "attribute_description AD ON AD.attribute_id = A.attribute_id
							LEFT JOIN " . $this->pp . "attribute_group_description AGD ON AGD.attribute_group_id = A.attribute_group_id
							WHERE filter_name LIKE '" . $alias . "' LIMIT 0,1;";
					//echo '<br><br>'.$sql;
					$query = $this->db->query($sql);
					
					if($query->num_rows){
						$row = $query->fetch_assoc();
						
						$attributes[] = $row['attribute_group_id'].'*'.$row['attribute_id'];
						$attributes_name[] = $alias;
						
						$attr_array['group_id'] = $row['attribute_group_id'];
						$attr_array['attribute_name'] = $row['attribute_name'];
						$attr_array['group_name'] = $row['group_name'];
					}
					$attr_array['sql'] = $sql;
					//echo '<br>'.$sql;
					
					$sql = "SELECT query FROM " . $this->pp . "url_alias WHERE keyword LIKE '" . $categ . "' AND `query` LIKE 'category_id=%' LIMIT 0,1;";
					$query = $this->db->query($sql);
					//echo '<br>'.$sql;
					
					if($query->num_rows){
						
						$row = $query->fetch_assoc();
						
						$url = explode('=', $row['query']);
						$data['sizes'] = implode(',',$sizes);
						$data['attributes'] = implode(',',$attributes);
						$data['attributes_array'] = $attr_array;
						$data['attributes_name'] = implode(',',$attributes_name);
						$data['category_id'] = $url[1];
						$data['path'] = true;
						break;
							  
					}elseif($categ == 'lovedproducts'  OR
						
						$categ == 'lastviewed'){

						$data['_route_'] = $categ;
						$data['route'] = 'product/category';
						$data['sizes'] = implode(',',$sizes);
						$data['attributes'] = implode(',',$attributes);
						if((int)$attr_array['group_id'] > 0){
							$data['attributes_array'] = $attr_array;
						}
						$data['attributes_name'] = implode(',',$attributes_name);
						$data['category_id'] = 0;
						break;

					}
				}
				$categ = str_replace($alias.'-', '', $categ);
			}
			
			return $data;
		
		}else{

			return false;
		}
		
	
	}
	
	
	public function getBlogCategoryAlias($category_id){
		$pp = $this->pp;
		$alias = '';
		
		/*
		$sql = 'SELECT C.category_id, parent_id, C.code, name FROM `'.$pp.'category` C
						LEFT JOIN `'.$pp.'category_description` CD ON CD.category_id = C.category_id AND CD.language_id = 1
						WHERE C.category_id = "'.$category_id.'";';
						*/
		$sql = 'SELECT blog_category_id, name FROM `'.$pp.'blog_category_description` WHERE language_id = "1" AND blog_category_id = "'.$category_id.'"';
		$r = $this->db->query($sql) or die($sql);
		
		if($r->num_rows > 0){
		
			$row = $r->fetch_assoc();
			
			$alias = strtolower($this->translitArtkl(trim($row['name'])));	
			
		}
			
		return trim($alias,'-');
		
	}

	public function getBlogAlias($blog_id){
		$pp = $this->pp;
		$alias = 'blog_id='.$blog_id;
		
		/*
		$sql = 'SELECT C.category_id, parent_id, C.code, name FROM `'.$pp.'category` C
						LEFT JOIN `'.$pp.'category_description` CD ON CD.category_id = C.category_id AND CD.language_id = 1
						WHERE C.category_id = "'.$category_id.'";';
						*/
		$sql = 'SELECT blog_id, title FROM `'.$pp.'blog_description` WHERE language_id = "1" AND blog_id = "'.$blog_id.'"';
		$r = $this->db->query($sql) or die($sql);
		
		$alias = '';
		
		if($r->num_rows > 0){
	
			$row = $r->fetch_assoc();
			
			$alias = strtolower($this->translitArtkl(trim($row['title'])));	
			
		}
		
			
		return trim($alias,'-');
		
	}

	public function setBlogAlias($alias, $blog_id){
		
		$pp = $this->pp;
		
		$sql = 'SELECT keyword FROM `'.$pp.'url_alias` where `query` = "blog_id='.$blog_id.'" LIMIT 0,1;';
		$r = $this->db->query($sql) or die($sql);
		
		if($r->num_rows > 0){
			
			$sql = 'UPDATE `'.$pp.'url_alias` SET keyword = "'.$alias.'" where `query` = "blog_id='.$blog_id.'";';
			
		}else{
			
			$sql = 'INSERT INTO `'.$pp.'url_alias` SET keyword = "'.$alias.'", `query` = "blog_id='.$blog_id.'";';
			
		}
		
		$this->db->query($sql);// or die($sql);
		
	}
	public function setBlogCategoryAlias($alias, $blog_category_id){
		
		$pp = $this->pp;
		
		$sql = 'SELECT keyword FROM `'.$pp.'url_alias` where `query` = "blog_category_id='.$blog_category_id.'" LIMIT 0,1;';
		$r = $this->db->query($sql) or die($sql);
		
		if($r->num_rows > 0){
			
			$sql = 'UPDATE `'.$pp.'url_alias` SET keyword = "'.$alias.'" where `query` = "blog_category_id='.$blog_category_id.'";';
			
		}else{
			
			$sql = 'INSERT INTO `'.$pp.'url_alias` SET keyword = "'.$alias.'", `query` = "blog_category_id='.$blog_category_id.'";';
			
		}
		
		$this->db->query($sql);// or die($sql);
		
	}
	
	
	
	private function translitArtkl($str) {
		$rus = array('?','~','+','и','<','>','/','%20','(',')',':','.',',','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
	    $lat = array('','','','u','','','','-','','','','','','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
	return str_replace($rus, $lat, $str);
  }
	
}

?>
