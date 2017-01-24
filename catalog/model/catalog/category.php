<?php
class ModelCatalogCategory extends Model {
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c
								  LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
								  LEFT JOIN " . DB_PREFIX . "url_alias ua ON (ua.query = CONCAT('category_id=', c.category_id))
								  LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row;
	}

	public function getCategoryNameKeyword($category_id) {
		$query = $this->db->query("SELECT DISTINCT name, keyword FROM " . DB_PREFIX . "category_description cd
										LEFT JOIN " . DB_PREFIX . "url_alias a ON (a.query = CONCAT('category_id=', cd.category_id))
										WHERE cd.category_id = '" . (int)$category_id . "' AND
											cd.language_id = '" . (int)$this->config->get('config_language_id') . "';");

		return $query->row;
	}

	public function getCategoryDomain($category_id) {
		
		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "category_description_domain
					WHERE category_id = '" . (int)$category_id . "' LIMIT 0, 1";
	
		$query = $this->db->query($sql);
		
		$return = $query->row;
		
			$sql = 'SELECT * FROM '. DB_PREFIX .'seo_tpl;';
		
			$r1 = $this->db->query($sql);
			
			foreach($r1->rows as $row){
				
				if($row['target'] == 'domain_title'){
					$return['title'] = $row['value'];
				}elseif($row['target'] == 'domain_title_h1'){
					$return['title_h1'] = $row['value'];
				}elseif($row['target'] == 'domain_meta_description'){
					$return['text1'] = $row['value'];
				}elseif($row['target'] == 'domain_text1'){
					$return['text2'] = $row['value'];
				}
			}

		return $return;
		
	}

	public function getCategories($parent_id = 0, $tree = false) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "category c
						LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
						LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id)
						LEFT JOIN " . DB_PREFIX . "category_path cp ON (c.category_id = cp.category_id)
						LEFT JOIN " . DB_PREFIX . "url_alias A ON (query = CONCAT('category_id=',c.category_id))
						WHERE ";
		if($parent_id > 0 AND $tree){
			$sql .= "cp.path_id = '" . (int)$parent_id . "' AND ";
		}else{
			$sql .= "c.parent_id = '" . (int)$parent_id . "' AND ";
		}
		
		$sql .= "cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND
						c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND
						c.status = '1'
						
						GROUP BY c.category_id
						
						ORDER BY c.sort_order, LCASE(cd.name)
						";
	
		$query = $this->db->query($sql) or die($sql);

		return $query->rows;
	}

	public function getMainPageCategories() {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "category c
						LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
						LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id)
						LEFT JOIN " . DB_PREFIX . "category_path cp ON (c.category_id = cp.category_id)
						LEFT JOIN " . DB_PREFIX . "url_alias A ON (query = CONCAT('category_id=',c.category_id))
						WHERE ";
		$sql .= "c.on_main_page = '1' AND ";
		
		$sql .= "cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND
						c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND
						c.status = '1'
						
						GROUP BY c.category_id
						
						ORDER BY c.sort_order, LCASE(cd.name)
						";
	
		$query = $this->db->query($sql) or die($sql);

		return $query->rows;
	}

	public function getCategoriesTree($parent_id = 0, $tree = false) {
		
		$sql = "SELECT c.category_id, c.parent_id, cd.name, A.keyword FROM " . DB_PREFIX . "category c
						LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
						LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id)
						LEFT JOIN " . DB_PREFIX . "category_path cp ON (c.category_id = cp.category_id)
						LEFT JOIN " . DB_PREFIX . "url_alias A ON (query = CONCAT('category_id=',c.category_id))
						WHERE ";
		if($parent_id > 0 AND $tree){
			$sql .= "cp.path_id = '" . (int)$parent_id . "' AND ";
		}else{
			$sql .= "c.parent_id = '" . (int)$parent_id . "' AND ";
		}
		
		$sql .= "cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND
						c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND
						c.status = '1'
						
						GROUP BY c.category_id
						
						ORDER BY c.sort_order, LCASE(cd.name)
						";
	
		$query = $this->db->query($sql) or die($sql);

		$array = array();
		$rows = array();
		foreach($query->rows as $row){
			$rows[$row['category_id']] = $row;
		}
	
		
		foreach($rows as $row){
			
			if($row['parent_id'] == $parent_id){
				$array[$row['category_id']]['name'] = $row['name'];
				$array[$row['category_id']]['keyword'] = $row['keyword'];
				$array[$row['category_id']]['children'] = $this->_makeTree($rows, $row['category_id']);
			}
		}
		
		$array0[(int)$parent_id]['name'] = isset($rows[(int)$parent_id]['name']) ? $rows[(int)$parent_id]['name'] : '';
		$array0[(int)$parent_id]['keyword'] = isset($rows[(int)$parent_id]['keyword']) ? $rows[(int)$parent_id]['keyword'] : '';
		$array0[(int)$parent_id]['children'] = $array;
	
		
		return $array0;
	}
	
	public function getCategoriesIsFilter($category_id = 0, $tree = false) {
		
		//Получим все фильтры
		$sql = "SELECT category_id FROM " . DB_PREFIX . "category WHERE is_filter = 1;";
		$r = $this->db->query($sql);
		
		if($r->num_rows == 0) return false;
		
		//Получим путь нашей категории
		$sql = 'SELECT path_id FROM '. DB_PREFIX .'category_path WHERE category_id = "'.$category_id.'" ORDER BY level;';
		$r_main = $this->db->query($sql);
		
		$main_path = array();
		foreach($r_main->rows as $row){
			$main_path[] = $row['path_id'];
		}

		//Найдем какой из них сосед нашей категории
		$filter_id = 0;
		foreach($r->rows as $row){
			
			$sql = 'SELECT path_id FROM '. DB_PREFIX .'category_path WHERE category_id = "'.$row['category_id'].'" ORDER BY level;';
			$r_filter = $this->db->query($sql);
			
			foreach($r_filter->rows as $row_filter){
			
				if(in_array($row_filter['path_id'],$main_path )){
					$filter_id = $row['category_id'];
					break;
				}
			}
			if($filter_id > 0) break;
		}
		
		if($filter_id > 0)	return $this->getCategoriesTree($filter_id, true);
		
		return false;
	}
	
	private function _makeTree($rows, $parent_id){
		//unset($rows[$parent_id]);
		
		$array = array();
		
		foreach($rows as $row){
			
			if($row['parent_id'] == $parent_id){
				$array[$row['category_id']]['name'] = $row['name'];
				$array[$row['category_id']]['keyword'] = $row['keyword'];
				$array[$row['category_id']]['children'] = $this->_makeTree($rows, $row['category_id']);
			}
		}
		
		return $array;
	}

	public function getSubCategories($parent_id = 0) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "category c
						LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
						LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id)
						WHERE c.parent_id = '" . (int)$parent_id . "' AND
						cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND
						c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND
						c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)";
	
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getCategoryFilters($category_id) {
		$implode = array();

		$query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$implode[] = (int)$result['filter_id'];
		}

		$filter_group_data = array();

		if ($implode) {
			$filter_group_query = $this->db->query("SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");

			foreach ($filter_group_query->rows as $filter_group) {
				$filter_data = array();

				$filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");

				foreach ($filter_query->rows as $filter) {
					$filter_data[] = array(
						'filter_id' => $filter['filter_id'],
						'name'      => $filter['name']
					);
				}

				if ($filter_data) {
					$filter_group_data[] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'filter'          => $filter_data
					);
				}
			}
		}

		return $filter_group_data;
	}

	public function getCategoryLayoutId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row['total'];
	}
	
	public function getCategoryAlias($category_id = 0) {
			
		$sql = 'SELECT keyword FROM '. DB_PREFIX .'url_alias WHERE `query` = "category_id='.$category_id.'" LIMIT 0,1;';
		$r1 = $this->db->query($sql);
		
		if($r1->num_rows){
			return $r1->row['keyword'];
		}
		return '';
		
	}

	public function getCategorize($alias) {
			
		$sql = 'SELECT * FROM '. DB_PREFIX .'alias_description WHERE `url` = "'.$alias.'" LIMIT 0,1;';
		$r1 = $this->db->query($sql);
			
			$return = $r1->row;
					
			$sql = 'SELECT * FROM '. DB_PREFIX .'seo_tpl;';
		
			$r1 = $this->db->query($sql);
			
			foreach($r1->rows as $row){
				
				if($row['target'] == 'title' AND (!isset($return['title']) OR $return['title'] == '')){
					
					$return['title'] = $row['value'];
				
				}elseif($row['target'] == 'title_h1' AND (!isset($return['title_h1']) OR $return['title_h1'] == '')){
				
					$return['title_h1'] = $row['value'];
				
				}elseif($row['target'] == 'meta_description' AND (!isset($return['text1']) OR $return['text1'] == '')){
				
					$return['text1'] = $row['value'];
				
				}elseif($row['target'] == 'meta_keywords' AND !isset($return['meta_keywords'])){
				
					$return['meta_keywords'] = $row['value'];
				
				}
			}
			
		
		return $return;
		
	}
	public function getCategorizeName($alias) {
			
		$sql = 'SELECT name FROM '. DB_PREFIX .'alias_description WHERE `url` = "'.$alias.'" LIMIT 0,1;';
		
		$r1 = $this->db->query($sql);
		if($r1->num_rows){
			return $r1->row['name'];
		}
		return '';
		
	}

	public function getCategorizeDomain($url) {
	
		$sql = 'SELECT DD.*, D.name_sush, D.name_rod, D.name_several FROM '. DB_PREFIX .'alias_description  D
						LEFT JOIN '. DB_PREFIX .'alias_description_domain  DD ON D.id = DD.id
						WHERE D.`url` = "'.$url.'" LIMIT 0,1;';
		
		$r1 = $this->db->query($sql);
		
		$return = $r1->row;
		
			
			$sql = 'SELECT * FROM '. DB_PREFIX .'seo_tpl;';
		
			$r1 = $this->db->query($sql);
			
			foreach($r1->rows as $row){
				
				if($row['target'] == 'domain_title'){
					$return['title'] = $row['value'];
				}elseif($row['target'] == 'domain_title_h1'){
					$return['title_h1'] = $row['value'];
				}elseif($row['target'] == 'domain_meta_description'){
					$return['text1'] = $row['value'];
				}elseif($row['target'] == 'domain_text1'){
					$return['text2'] = $row['value'];
				}
			}
			
		
		return $return;
	
	}

	public function getCategoryPath($category_id = 0) {
		$sql = 'SELECT path_id FROM '. DB_PREFIX .'category_path WHERE category_id = "'.$category_id.'" ORDER BY level;';
		$r = $this->db->query($sql);
		
		$return = array();
		foreach($r->rows as $row){
			
			$return[] = $row['path_id'];

		}
		
		return $return;
		
	}

	public function getCategoryAliasPath($category_id = 0) {
		$sql = 'SELECT path_id FROM '. DB_PREFIX .'category_path WHERE category_id = "'.$category_id.'" ORDER BY level;';
		$r = $this->db->query($sql);
		
		$return = '';
		foreach($r->rows as $row){
			
			$sql = 'SELECT keyword FROM '. DB_PREFIX .'url_alias WHERE `query` = "category_id='.$row['path_id'].'" LIMIT 0,1;';
			$r1 = $this->db->query($sql);
			$return .= $r1->row['keyword'] . '/';

		}
		
		$return = trim($return, '/');
		return $return;
		
		
	}
	public function getCategoryAttribute($category_id = 0) {
		$sql = 'SELECT attribute_id FROM '. DB_PREFIX .'category_to_attribute WHERE category_id = "'.$category_id.'";';
		$r = $this->db->query($sql);
		
		$return = array();
		foreach($r->rows as $row){
			
			$return[$row['attribute_id']] = $row['attribute_id'];

		}
		
		return $return;
		
	}
	public function getUniversaLDescription() {
		$sql = 'SELECT value FROM '. DB_PREFIX .'seo_tpl WHERE target = "domain_text1" LIMIT 0,1;';
	
		$r = $this->db->query($sql);
		
		if($r->num_rows){
			return $r->row['value'];
		}
		
		return '';
		
	}
	public function getCategoryTree() {
		
		$body = '<link rel="stylesheet" type="text/css" href="/'.TMP_DIR.'backend/libs/category_tree/type-for-get-admin.css">
					<script type="text/javascript" src="/'.TMP_DIR.'backend/libs/category_tree/script-for-get.js"></script>
					<script type="text/javascript" src="/'.TMP_DIR.'backend/category/category_tree.js"></script>
					<input type="hidden" id="select_cetegory_target" value="">		
					<script>
						$(document).ready(function(){
							$("#0").parent("span").parent("li").children("span").first().toggleClass("closed opened").nextAll("ul").toggle();;
						});
						$(document).on("click", ".select_category", function(){
							$("#select_cetegory_target").val($(this).data("target"));
							var id = $(this).data("id");
							$("#target_categ_id").val(id);
							$("#target_categ_name").val($("#categ_name"+id).html());
							$("#container_tree").show();
							$("#container_back").show();
						});
						$(document).on("click", ".close_tree", function(){
							$("#container_tree").hide();
							$("#container_back").hide();
						});
						$(document).on("click", "#container_back", function(){
							$("#container_tree").hide();
							$("#container_back").hide();
						});
					</script>
						<input type="hidden" value="" id="category" class="selected_category">
						<div id="container_back"></div>
						<style>
							#container_back{width: 100%;height: 100%;z-index:11001;opacity: 0.7;display: none;position: fixed;background-color: gray;top:0;left:0;}
							#container_tree{    z-index: 11001;}
						</style>
					';				
		
        $Types = array();
        $Types[0] = array("id"=>0,"name"=>"Главная");
        //=======================================================================
            $sql = 'SELECT C.category_id AS id, C.parent_id, CD.name, A.keyword
                            FROM `'.DB_PREFIX.'category` C
                            LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
                            LEFT JOIN `'.DB_PREFIX.'url_alias` A ON A.query = CONCAT("category_id=",CD.category_id)
                            WHERE parent_id = "0" ORDER BY name ASC;';
            //echo '<br>'.$sql;
            $rs = $this->db->query($sql);
            
            $body .= "
                    <input type='hidden' id=\"target_categ_id\" value='0'>
                    <input type='hidden' id=\"target_categ_name\" value=''>
                    <div id=\"container_tree\" class = \"product-type-tree\">
                        <h4>Выбрать категорию <span class='close_tree'>[закрыть]</span></h4><ul  id=\"celebTree\">
                ";
            foreach ($rs->rows as $Type) {
        
            if($Type['parent_id'] == 0){
                
                $body .=  "<li><span id=\"span_".$Type['id']."\"> <a class = \"tree category_id_".$Type['id']."\" href=\"javascript:;\" id=\"".$Type['id']."\">".$Type['name']."</a>";
                $body .= "</span>".$this->readTree($Type['id']);
                $body .= "</li>";
            }
            $Types[$Type['id']]['id'] = $Type['id'];
            $Types[$Type['id']]['name'] = $Type['name'];
            }
            $body .= "</ul>
                </li></ul></div>";
        
            return $body;
	}                
    //Рекурсия=================================================================
    protected function readTree($parent){
            $sql = 'SELECT C.category_id AS id, C.parent_id, CD.name, A.keyword
                        FROM `'.DB_PREFIX.'category` C
                        LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
                        LEFT JOIN `'.DB_PREFIX.'url_alias` A ON A.query = CONCAT("category_id=",CD.category_id)
                        WHERE parent_id = "'.$parent.'" ORDER BY name ASC;';
                
            $rs = $this->db->query($sql);
        
            $body = "";
        
           foreach ($rs->rows as $Type) {
        
                //Посчитаем сколько есть описаний
                $sql = 'SELECT count(id) AS total FROM `'.DB_PREFIX.'alias_description` WHERE url LIKE "%'.$Type['keyword'].'";';
                
             
                $body .=  "<li><span id=\"span_".$Type['id']."\"><a class = \"tree category_id_".$Type['id']."\" href=\"javascript:;\" id=\"".$Type['id']."\">".$Type['name']."</a>";
                $body .= "</span>".$this->readTree($Type['id']);
                $body .= "</li>";
            }
            if($body != "") $body = "<ul>$body</ul>";
            return $body;
        
    }
        

}