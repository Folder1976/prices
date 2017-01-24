<?php
class ControllerCatalogCategory extends Controller {
	private $error = array();
	private $mysqli2;
	
	public function index() {
		
		$this->language->load('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		$this->getList();
	}

	public function add() {
		$this->language->load('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			if(isset($this->request->post['is_menu'])){
				$this->request->post['is_menu'] = 1;
			}else{
				$this->request->post['is_menu'] = 0;
			}
		
			if(isset($this->request->post['is_filter'])){
				$this->request->post['is_filter'] = 1;
			}else{
				$this->request->post['is_filter'] = 0;
			}
		
			if(isset($this->request->post['on_main_page'])){
				$this->request->post['on_main_page'] = 1;
			}else{
				$this->request->post['on_main_page'] = 0;
			}
		
			
			$category_id = $this->model_catalog_category->addCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '&category_id='.$category_id;

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category/edit', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function import() {
		define('DB_DATABASE2', 'folder_temp');
		$this->mysqli2 = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE2) or die("Error " . mysqli_error($this->mysqli2)); 
		mysqli_set_charset($this->mysqli2,"utf8");
	

		$this->importCategory();
	

die('Удаление пустых товаров');
		$this->dellNullCategoryLinks();
		$this->importProducts();
		die('11111111');
		
		$this->dellNullProducts();
		$this->fixPhotos();
		die('11111111');
		$this->ClearCategorys();
		
die('Импорт старого товара');

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query LIKE 'product_id=%' OR  query LIKE 'category_id=%'");
		$this->importCategory();
		$this->importManufacturer();
		$this->importProducts();
		$this->ClearCategorys();
		$this->setAllAttribute();
		
		
die('stop');
$this->ClearCategorys();


die('Таблица размеров');	
	//$this->model_catalog_product->getProducts();
	$this->importProducts();
	$this->dellNullProducts();
	
	}

//Удалим привязки к левым категориям
	public function dellNullCategoryLinks(){
		$sql = "SELECT * FROM " . DB_PREFIX . "product_to_category";
		$r = $this->db->query($sql);
		foreach($r->rows as $row){
			
			$sql = "SELECT product_id FROM " . DB_PREFIX . "product WHERE product_id = '".$row['product_id']."'";
			$prod = $this->db->query($sql);
			
			$sql = "SELECT category_id FROM " . DB_PREFIX . "category WHERE category_id = '".$row['category_id']."'";
			$categ = $this->db->query($sql);
			
			if($prod->num_rows == 0 OR $categ->num_rows == 0){
				$sql = "DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '".$row['product_id']."' AND category_id = '".$row['category_id']."'";
				$this->db->query($sql);
			}
		}
		
	}
//Чиним фотки
	public function fixPhotos(){
		header("Content-Type: text/html; charset=UTF-8");
		
		$this->load->model('catalog/product');
		
		$path = '/home/adminroot/www/plazamilano.com/image/';
		
		$sql = 'SELECT product_id, image FROM ' . DB_PREFIX . 'product';// WHERE product_id = "463904464"';
		$products = $this->db->query($sql);
		
		foreach($products->rows as $row){
			
			$images = $this->model_catalog_product->getProductImages($row['product_id']);
				
			$filename = $path . $row['image'];
			
			if (file_exists($filename) AND $row['image']) {
				//echo "<br>The file $filename exists";
			} else {
				
				//echo "<pre>".$filename.'<br>';  print_r(var_dump( $images )); echo "</pre>";
				
				if(is_array($images) AND count($images) > 0){
					$sql = 'UPDATE fash_product SET image = "'.$images['0']["image"].'" WHERE product_id="'.$row['product_id'].'"';
					$this->db->query($sql);
					$sql = 'DELETE FROM fash_product_image WHERE image = "'.$images['0']["image"].'" AND product_id="'.$row['product_id'].'"';
					$this->db->query($sql);
				}else{
					$sql = 'UPDATE fash_product SET image = "" WHERE product_id="'.$row['product_id'].'"';
					$this->db->query($sql);
					
				}
			}
				
			
		}
	}

//Переносим таблицу размеров
	public function getDimension(){
		$mysqli2 = $this->mysqli2;
		$this->load->model('catalog/option');
		$this->load->model('catalog/attribute');
		
		
		$sql = 'SELECT id_goodcolor, id_good, color_rus, color FROM goodcolors GC
					LEFT JOIN colors C ON C.id_color = GC.id_color';
		$products = $mysqli2->query($sql) or die($sql);
		while($product = $products->fetch_assoc()){
			
			//Размеры
			$sql = "SELECT GD.*, GZ.goodsize FROM gooddimensions GD
									LEFT JOIN goodsizes GZ ON GZ.id_goodsize = GD.id_goodsize
									WHERE GD.id_good = '".$product['id_good']."';";
			
			$r = $mysqli2->query($sql) or die($sql);
			if($r->num_rows){
				
				$product_option = array();
				
				while($option = $r->fetch_assoc()){
					
					$option_value_id = 0;
					$option_id = 11;
					$option_value_id = $this->model_catalog_option->getOptionValueOrAdd($option['goodsize'], $option_id, $option); // 11 - Это группа размеров Одежды
					
					$attribute_group_id = 15;
					$attribute_id = 0;
					$attr_name = array();
					$attr_name[1] = $product['color_rus'];
					$attr_name[2] = $product['color'];
					$id_goodcolor = $this->model_catalog_attribute->getAttributeOrAdd($attr_name, $attribute_group_id);
					
					
					if($option['shoulders']) $params['shirina_plech'] = number_format(((float)$option['shoulders'] * 2.54),2,'.','');
					if($option['width']) $params['shirina_grudi'] = number_format(((float)$option['width'] * 2.54),2,'.','');
					if($option['length']) $params['dlina_verh'] = number_format(((float)$option['length'] * 2.54),2,'.','');
					if($option['sleeve']) $params['dlina_rukava'] = number_format(((float)$option['sleeve'] * 2.54),2,'.','');
					if($option['collar']) $params['vorotnik'] = number_format(((float)$option['collar'] * 2.54),2,'.','');
					if($option['waist']) $params['shirina_talii'] = number_format(((float)$option['waist'] * 2.54),2,'.','');
					if($option['hips']) $params['shirina_beder'] = number_format(((float)$option['hips'] * 2.54),2,'.','');
					if($option['rise']) $params['podiem'] = number_format(((float)$option['rise'] * 2.54),2,'.','');
					
					$product_id = $option['id_good'] + ($id_goodcolor * 100000);
					
					
					header("Content-Type: text/html; charset=UTF-8");
					echo $product['color'];
					echo "<pre>";  print_r(var_dump( $product_id )); echo "</pre>"; 
					echo "<pre>";  print_r(var_dump( $option_value_id )); echo "</pre>"; 
					echo "<pre>";  print_r(var_dump( $params )); echo "</pre>"; 
					echo "<pre>";  print_r(var_dump( $option )); echo "</pre>"; die();
				
					
				}
			}
		
		}
		
	}
	
//Удаляем пустые товары
	public function	dellNullProducts(){
		$this->load->model('catalog/product');
		
		$products = $this->model_catalog_product->getProductsIdList();
		
		foreach($products as $row){
		
			$option = $this->model_catalog_product->getProductOptions($row['product_id']);
			
			$quantity = 0;
			
			if(isset($option['0']['product_option_value'])){
				foreach($option['0']['product_option_value'] as $size){
					$quantity += $size['quantity'];
				}
			}
			
			if($quantity < 1){
				$this->model_catalog_product->deleteProduct($row['product_id']);
			}
			
		}
		
	}
	
//Почистим пустые категории
	public function	ClearCategorys(){
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		
		$rwww = $this->model_catalog_category->getCategories(array('parent_id'=>'0'));
		
		header("Content-Type: text/html; charset=UTF-8");
		
		foreach($rwww as $row){
			
			$r1 = $this->model_catalog_category->getCategories(array('parent_id'=>$row['category_id']));
			foreach($r1 as $row1){
				
				$product_total = $this->model_catalog_product->getTotalProducts(array('filter_category'=>array($row1['category_id'])));
				
				echo '<br>'.$product_total.' - ('.$row1['category_id'].') '.$row1['name'];
				
				if($product_total == 0){
					
					$r2 = $this->model_catalog_category->getSubCategories($row1['category_id']);
					
					$this->model_catalog_category->deleteCategory($row1['category_id']);
					
					foreach($r2 as $row2){
						$this->model_catalog_category->deleteCategory($row2['category_id']);
						echo '+';
					}
					
				}
								
			}
			
		}
		
		$sql = 'DELETE FROM '.DB_PREFIX.'product_to_category WHERE category_id NOT IN (SELECT category_id FROM '.DB_PREFIX.'category)';
		$this->db->query($sql);
	
	}
	
//товары	
	public function importProducts(){
		$this->load->model('catalog/product');
		$this->load->model('catalog/option');
		$this->load->model('catalog/attribute');
		$this->load->model('catalog/category');
		$mysqli2 = $this->mysqli2;
		
		//$this->model_catalog_product->dellAllProduct();
		
		$r_m = $mysqli2->query("SELECT * FROM goods WHERE id_good = 10586;");
		
		while($product = $r_m->fetch_assoc()){
		
			$sql = "SELECT GC.*, C.color, C.color_rus, artikul FROM goodcolors GC
							LEFT JOIN colors C ON C.id_color = GC.id_color
							WHERE GC.id_good = '".$product['id_good']."'";
			$r_size = $mysqli2->query($sql);
				while($color = $r_size->fetch_assoc()){
					
					$color_id = $color['id_goodcolor'];
					
					$product['good_rus'] = str_replace('  ',' ', $product['good_rus']);
					$product['good_rus'] = str_replace('  ',' ', $product['good_rus']);
					$product['good_rus'] = str_replace('  ',' ', $product['good_rus']);
					
					$product['good'] = str_replace('  ',' ', $product['good']);
					$product['good'] = str_replace('  ',' ', $product['good']);
					$product['good'] = str_replace('  ',' ', $product['good']);
					
					
					$data_P = array();
					$data_P['product_id'] = $product['id_good'] + ($color_id * 100000);
					$data_P['upc'] = $data_P['ean'] = $data_P['jan'] = $data_P['isbn'] = $data_P['mpn'] = $data_P['location'] = $data_P['subtract'] = $data_P['points'] = $data_P['weight'] = $data_P['weight_class_id'] = $data_P['length'] = $data_P['width'] = $data_P['height'] = $data_P['stock_status_id'] = '';
					$data_P['date_available'] = date('Y-m-d', strtotime('-1 day'));
					$data_P['length_class_id'] = '';
					$data_P['tax_class_id'] = '';
					$data_P['sort_order'] = 0;
					$data_P['product_description'][1]['name'] = ($product['good_rus'] != '') ? $product['good_rus'] : $product['good'];
					$data_P['product_description'][1]['description'] = htmlspecialchars($product['mat_rus'].'<br>'.$product['text_rus'],ENT_QUOTES);
					$data_P['product_description'][1]['meta_title'] = ($product['good_rus'] != '') ? $product['good_rus'] : $product['good'];
					$data_P['product_description'][1]['meta_description'] = $product['keywords1_rus'];
					$data_P['product_description'][1]['description_detail'] = $product['keywords_rus'];
					$data_P['product_description'][1]['meta_keyword'] = $product['keywords_rus'];
					$data_P['product_description'][1]['tag'] = $product['good_rus'];
			
					$data_P['product_description'][2]['name'] = $product['good'];
					$data_P['product_description'][2]['description'] = htmlspecialchars($product['mat'].'<br>'.$product['text'],ENT_QUOTES);
					$data_P['product_description'][2]['meta_title'] = $product['good'];
					$data_P['product_description'][2]['meta_description'] = $product['keywords1'];
					$data_P['product_description'][2]['description_detail'] = $product['keywords1'];
					$data_P['product_description'][2]['meta_keyword'] = $product['keywords'];
					$data_P['product_description'][2]['tag'] = $product['good'];
				
					$data_P['original_url'] = $product['id_good'] + ($color_id * 100000).' old_id=['.$product['id_good'].']'.' old_color_id=['.$color_id.']';
					
					$data_P['original_code'] = $color['artikul'];
					$data_P['model'] = $color['artikul'];//strtolower(translitArtkl($shop_name.'-'.$data['id']));//$product['code'];
					$data_P['sku'] = $color['artikul'];//strtolower(translitArtkl($shop_name.'-'.$data['id']));//$product['code'];
					$data_P['price'] = $product['price'];
					$data_P['zakup'] = 0;
					$data_P['quantity'] = 10;
					$data_P['minimum'] = 1;
					$data_P['shipping'] = 1;
					$data_P['keyword'] = str_replace(array('/',' '),'-','product-'.strtolower($product['article'].'-'.$product['good'])); //'product/view/'.
					$data_P['keyword'] = trim($data_P['keyword'],'-');
					$data_P['keyword'] = trim($data_P['keyword'],'-');
					$data_P['keyword'] = str_replace('--', '-', $data_P['keyword']);
					$data_P['keyword'] = str_replace('--', '-', $data_P['keyword']);
					$data_P['keyword'] = $data_P['keyword'] . $data_P['product_id'];
					
					//echo $data_P['keyword']; die();
					
					$data_P['keyword_add_id'] = 1; //'product/view/'.
					$data_P['status'] = 1;
					$data_P['stock_status_id'] = 1;
					
					$data_P['moderation_id'] ='0';
					$data_P['manufacturer_id'] = $product['id_brand'];
					$data_P['product_store'] = array(0 => 0);
					$data_P['product_shop'] = array(0 => 1);
					
					//Картинки
					$sql = "SELECT * FROM goodphotos GP
							LEFT JOIN goodphoto_largeimages CL ON GP.id_goodphoto = CL.id_goodphoto
							LEFT JOIN goodphoto_mediumimages CM ON GP.id_goodphoto = CM.id_goodphoto
							WHERE GP.id_goodcolor = '".$color_id."' ORDER BY GP.priority";
					$r_photo = $mysqli2->query($sql);
				echo $sql;
					if($r_photo->num_rows){
						$p_count = 1;
						
						if($r_photo->num_rows > 1) $data_P['product_image'] = array();
						
						while($photo = $r_photo->fetch_assoc()){
							
							if($photo['id_goodphoto_largeimage'] OR $photo['id_goodphoto_mediumimage']){
								$image = 'product/'.$photo['id_goodphoto_largeimage'].'.'.$photo['ext'];
								$image1 = 'product/'.$photo['id_goodphoto_mediumimage'].'.'.$photo['ext'];
			
			echo '<br>'.$image.'<br>'.$image1;
								if($p_count == 1){
									$data_P['image'] = $image;
								}else{
									$data_P['product_image'][] = array('image' => $image, 'sort_order'=>'0');
								}
							}
						
							$p_count++;
							
						}
					}
					
					
					//Категория
					$category_id = 1;
					
					$count = 1;
					while($count < 10){
						//echo '<br>'.$product['category'.$count];
						if(isset($product['category'.$count]) AND $product['category'.$count] and $count != 5 and $count !=6){
							$category_id = $count;
							//break;
					
							//Основную категорию по подтипу
							if($product['id_goodsubtype']){
								$id_goodsubtype = (int)$product['id_goodsubtype'] + (($count) * 10000) + 100;
								
								if($id_goodsubtype < 1)	{
									echo '=> '.$product['id_goodsubtype'].'  '.$id_goodsubtype.'=='.$category_id;die();
								}
								
								$data_P['product_category'][$id_goodsubtype] = $id_goodsubtype;
								$data_P['main_relationships'] = $id_goodsubtype;
							}
							
							$count2 = 1;
							while($count2 < 11){
								if(isset($product['subcategory'.$count2]) AND $product['subcategory'.$count2]){
									//$id_subcategory = (int)$product['id_subcategory'] + ($category_id * 100);
									$id_subcategory = (int)$count2 + ($category_id * 100);
									$data_P['product_category'][$id_subcategory] = $id_subcategory;
									if(!isset($data_P['main_relationships'])) $data_P['main_relationships'] = $id_subcategory;
								}
								$count2++;
							}
					
						}
						$count++;
					}
	
	//Атрибуты - ЦВЕТ
					$product_attribute = array();
										
						$attribute_group_id = 15;
						$attribute_id = 0;
					
						//$attribute_group_id = $Attribute->getAttributeGroupOrAdd($attr_group_name);
						$attr_name = array();
						$attr_name[1] = $color['color_rus'];
						$attr_name[2] = $color['color'];
						$attribute_id = $this->model_catalog_attribute->getAttributeOrAdd($attr_name, $attribute_group_id);
						
						$product_attribute[] = array(
												'attribute_id'=>$attribute_id,
												'product_attribute_description' => array(
													'1' => array(
														'text' => ''
													),
													'2' => array(
														'text' => ''
													)
												)
											);
	//Атрибуты материал				
					$sql = "SELECT GM.id_material, GM.percent, M.material, M.material_rus FROM goodmaterials GM
											LEFT JOIN materials M ON M.id_material = GM.id_material
											WHERE GM.id_good = '".$product['id_good']."';";
					$r_mat = $mysqli2->query($sql) or die($sql);
					if($r_mat->num_rows){
						$attribute_group_id = 49;
						
						while($option = $r_mat->fetch_assoc()){
							
							$attribute_id = 0;
					
							//$attribute_group_id = $Attribute->getAttributeGroupOrAdd($attr_group_name);
							$attr_name = array();
							$attr_name[1] = $option['material'];
							$attr_name[2] = $option['material_rus'];
							$attribute_id = $this->model_catalog_attribute->getAttributeOrAdd($attr_name, $attribute_group_id);
							
							$product_attribute[] = array(
													'attribute_id'=>$attribute_id,
													'product_attribute_description' => array(
														'1' => array(
															'text' => $option['percent'].'%'
														),
														'2' => array(
															'text' => $option['percent'].'%'
														)
													)
											);
						}
					}
					
					
					$data_P['product_attribute'] = $product_attribute;
					
					
					
					//Размеры
					$sql = "SELECT GD.*, GZ.goodsize FROM gooddimensions GD
											LEFT JOIN goodsizes GZ ON GZ.id_goodsize = GD.id_goodsize
											WHERE GD.id_good = '".$product['id_good']."';";
					//echo '<br>'.$sql;die();
					//Количество товаров содержится в таблице цветов!!!
					
					$r = $mysqli2->query($sql) or die($sql);
					if($r->num_rows){
						
						$product_option = array();
						
						while($option = $r->fetch_assoc()){
							
							$option_value_id = 0;
							$option_id = 11;
							
							$option_value_id = $this->model_catalog_option->getOptionValueOrAdd($option['goodsize'], $option_id, $option); // 11 - Это группа размеров Одежды 
						
							$quantity = 0;
							if(isset($color['goodsize'.$option['id_goodsize']])) $quantity = (int)$color['goodsize'.$option['id_goodsize']];
							
							$params = array();
							if($option['shoulders']) $params['shirina_plech'] = number_format(((float)$option['shoulders'] * 2.54),2,'.','');
							if($option['width']) $params['shirina_grudi'] = number_format(((float)$option['width'] * 2.54),2,'.','');
							if($option['length']) $params['dlina_verh'] = number_format(((float)$option['length'] * 2.54),2,'.','');
							if($option['sleeve']) $params['dlina_rukava'] = number_format(((float)$option['sleeve'] * 2.54),2,'.','');
							if($option['collar']) $params['vorotnik'] = number_format(((float)$option['collar'] * 2.54),2,'.','');
							if($option['waist']) $params['shirina_talii'] = number_format(((float)$option['waist'] * 2.54),2,'.','');
							if($option['hips']) $params['shirina_beder'] = number_format(((float)$option['hips'] * 2.54),2,'.','');
							if($option['rise']) $params['podiem'] = number_format(((float)$option['rise'] * 2.54),2,'.','');
					
							
							$product_option[] = array(
													'option_value_id' => $option_value_id,
													'option_id' => $option_id,
													'quantity' => $quantity,
													'price' => $data_P['price'],
													'alternative_size' => $option_value_id,
													'price_prefix' => '',
													'points' => '',
													'points_prefix' => '',
													'weight' => '',
													'weight_prefix' => '',
													'subtract' => 1,
													'params' => $params
												);
							
						}
						
						$data_P['product_option'][] = array(
													'product_option_id' => 0,
													'type' => 'radio',
													'option_id' => $option_id,
													'required' => 1,
													'product_option_value' => $product_option
													);
						
					
					}
					
					header("Content-Type: text/html; charset=UTF-8");
					echo "<pre>";  print_r(var_dump( $data_P )); echo "</pre>";
							
					//$this->model_catalog_product->addProduct($data_P);
				}
		}
	
	}
//Установим все атрибуты для всех категорий
public function setAllAttribute(){
	
	$this->load->model('catalog/category');
	
	$sql = 'SELECT attribute_id FROM ' . DB_PREFIX . 'attribute WHERE enable = 1';
	$r = $this->db->query($sql);

	$sql = 'DELETE FROM ' . DB_PREFIX . 'category_to_attribute';
	$this->db->query($sql);
	
	$attributes = array();
	foreach($r->rows as $row){
		$attributes[] = $row['attribute_id'];
	}
	
	$r = $this->model_catalog_category->getCategoriesID();
	foreach($r as $row){
		foreach($attributes as $attribute){
			$sql = 'INSERT INTO ' . DB_PREFIX . 'category_to_attribute SET category_id="'.$row['category_id'].'", attribute_id="'.$attribute.'"';
			$this->db->query($sql);
		}
	}
	
}

//Бренды	
	public function importManufacturer(){
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query LIKE 'manufacturer_id=%'");
		
		//$this->load->model('catalog/category');
		//$this->load->model('catalog/product');
		$this->load->model('catalog/manufacturer');
		$mysqli2 = $this->mysqli2;
	
	
		$sql = "SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer";
		$r2 = $this->db->query($sql);
		if($r2->num_rows){
			foreach($r2->rows as $tmp){
				$this->model_catalog_manufacturer->deleteManufacturer($tmp['manufacturer_id']);
			}
		}
	
		//Бренды
		$r = $mysqli2->query("SELECT * FROM brands;");
		while($row = $r->fetch_assoc()){
			
			$sql = "SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer WHERE
						upper(`name`) LIKE '".mb_strtoupper(addslashes(trim($row['brand'])),'UTF-8')."'
						OR upper(`code`) LIKE '".mb_strtoupper(addslashes(trim($row['brand'])),'UTF-8')."'
						LIMIT 1";
			$r2 = $this->db->query($sql);
			
			if($r2->num_rows){
				$tmp = $r2->row;
				$this->model_catalog_manufacturer->deleteManufacturer($tmp['manufacturer_id']);
			}
			
			$data = array(
						'manufacturer_id' => ((int)$row['id_brand']),
						'name' => $row['brand'],
						'code' => strtolower(str_replace(' ','',$row['brand'])),
						'name_sush' => '',
						'name_rod' => '',
						'name_several' => '',
						'sort_order' => '',
						'manufacturer_store' => array('0' => '0'),
						'manufacturer_layout' => array('0' => '0'),
						'keyword' => strtolower(str_replace(array(' ','&',"'"),'',$row['brand'])),
						'manufacturer_description' => array(
									'1' => array(
										'description' => $row['htmlafter_rus'],
										'meta_title' => $row['title_rus'],
										'name' => $row['brand_rus'],
										'title_h1' => $row['title_rus'],
										'meta_description' => $row['keywords1_rus'],
										'meta_keyword' => $row['keywords_rus']
									),
									'2' => array(
										'description' => $row['htmlafter'],
										'meta_title' => $row['title'],
										'name' => $row['brand'],
										'title_h1' => $row['title'],
										'meta_description' => $row['keywords1'],
										'meta_keyword' => $row['keywords']
									),
								
								),
					);
			
			$this->model_catalog_manufacturer->deleteManufacturer($data['manufacturer_id']);
			$this->model_catalog_manufacturer->addManufacturer($data);
			
		}
	}
		
	public function importCategory(){
		
		
		$this->load->model('catalog/category');
		//$this->load->model('catalog/product');
		//$this->load->model('catalog/manufacturer');
		$mysqli2 = $this->mysqli2;

		//Категории
		$r = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category;");
		foreach($r->rows as $row){
			$this->model_catalog_category->deleteCategory($row['category_id']);
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query LIKE 'category_id=%'");

		//die();
		
		$sql = 'SELECT * FROM menu';
		$r = $mysqli2->query($sql);
		
		$categ_ids = array();
		
		while($row = $r->fetch_assoc()){
			
			$data = array(
						  'category_id' => $row['id'],
						  'parent_id' => $row['wmotmenuid'],
						  'code' => strtolower(str_replace(' ','',$row['name_en'])),
							'top' => ($row['wmotmenuid'] == 0) ? '1' : '0',
							'column' => '0',
							'is_menu' => '1',
							'is_filter' => '0',
							'sort_order' => '0',
							'status' => '1',
							'category_description' => array(
									'1' => array(
										'name' => $row['name'],
										'name_sush' => $row['name'],
										'name_rod' => $row['name'],
										'name_several' => $row['name'],
										'description' => $row['metadesc'],
										'meta_title' => $row['metatitle'],
										'title_h1' => $row['metatitle'],
										'meta_description' => $row['metadesc'],
										'meta_keyword' => $row['metakeywords']
									),
									'3' => array(
										'name' => $row['name_en'],
										'name_sush' => $row['name_en'],
										'name_rod' => $row['name_en'],
										'name_several' => $row['name_en'],
										'description' => $row['metadesc_en'],
										'meta_title' => $row['metatitle_en'],
										'title_h1' => $row['metatitle_en'],
										'meta_description' => $row['metadesc_en'],
										'meta_keyword' => $row['metakeywords_en']
									),
									'4' => array(
										'name' => $row['name_rm'],
										'name_sush' => $row['name_rm'],
										'name_rod' => $row['name_rm'],
										'name_several' => $row['name_rm'],
										'description' => $row['metadesc_rm'],
										'meta_title' => $row['metatitle_rm'],
										'title_h1' => $row['metatitle_rm'],
										'meta_description' => $row['metadesc_rm'],
										'meta_keyword' => $row['metakeywords_rm']
									),
									
								
								),
							'category_store' => array('0' => '0'),
							'category_layout' => array('0' => '0'),
							'keyword' => strtolower(str_replace(' ','',$row['name_en']))
						);
			
			$this->model_catalog_category->addCategory($data);
		}
	
		//Создание нулевой категории
		$this->db->query("INSERT INTO  `".DB_PREFIX."category` (`category_id` ,`image` ,`parent_id` ,`code` ,`top` ,`is_menu` ,`is_filter` ,`column` ,`sort_order` ,`status` ,`date_added` ,`date_modified`)VALUES ('0', NULL ,  '0',  '/',  '0',  '0',  '0',  '0',  '0',  '1',  '2016-12-31 03:09:55',  '2016-12-31 03:09:55');") or die('4');
		$category_id = $this->db->getLastId();
		$this->db->query("UPDATE `".DB_PREFIX."category` SET `category_id` = '0' WHERE `category_id` = '".$category_id."'");
		$this->db->query("INSERT INTO  `".DB_PREFIX."category_description` (`category_id` ,`language_id` ,`name` ,`name_sush` ,`name_rod` ,`name_several` ,`title_h1` ,`description` ,`meta_title` ,`meta_description` ,`meta_keyword`) VALUES ('0',  '1',  'Главная',  '',  '',  '',  'Главная',  '',  'Главная',  'Главная',  'Главная');") or die('1');
		$this->db->query("INSERT INTO  `".DB_PREFIX."category_description` (`category_id` ,`language_id` ,`name` ,`name_sush` ,`name_rod` ,`name_several` ,`title_h1` ,`description` ,`meta_title` ,`meta_description` ,`meta_keyword`) VALUES ('0',  '2',  'Main',  '',  '',  '',  'Main',  '',  'Main',  'Main',  'Main');") or die('2');
		$this->db->query("INSERT INTO  `".DB_PREFIX."category_description` (`category_id` ,`language_id` ,`name` ,`name_sush` ,`name_rod` ,`name_several` ,`title_h1` ,`description` ,`meta_title` ,`meta_description` ,`meta_keyword`) VALUES ('0',  '4',  'Main',  '',  '',  '',  'Main',  '',  'Main',  'Main',  'Main');") or die('2');
		$this->db->query("INSERT INTO  `".DB_PREFIX."url_alias` (`url_alias_id` ,`query` ,`keyword`)VALUES (NULL ,  'category_id=0',  '/');") or die('3');
		$this->db->query("INSERT INTO  `".DB_PREFIX."category_to_layout` (`category_id` ,`store_id` ,`layout_id`)VALUES ('0',  '0',  '0');") or die('6');
		$this->db->query("INSERT INTO  `".DB_PREFIX."category_to_store` (`category_id` ,`store_id`)VALUES ('0',  '0');") or die('7');
		
		$this->model_catalog_category->restoreAllCategoryesPath();
	}
	
	public function restore_path() {
		$this->language->load('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		$this->model_catalog_category->restoreAllCategoryesPath();

		$this->session->data['success'] = $this->language->get('text_success');

		$this->getList();
	}


	public function edit() {
		$this->language->load('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			if(isset($this->request->post['is_menu'])){
				$this->request->post['is_menu'] = 1;
			}else{
				$this->request->post['is_menu'] = 0;
			}
			
			if(isset($this->request->post['on_main_page'])){
				$this->request->post['on_main_page'] = 1;
			}else{
				$this->request->post['on_main_page'] = 0;
			}
		
			if(isset($this->request->post['is_filter'])){
				$this->request->post['is_filter'] = 1;
			}else{
				$this->request->post['is_filter'] = 0;
			}
			
			if(isset($this->request->post['domain_is_menu'])){
				$this->request->post['domain_is_menu'] = 1;
			}else{
				$this->request->post['domain_is_menu'] = 0;
			}
			
			$this->model_catalog_category->editCategory($this->request->get['category_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '&category_id='.(int)$this->request->get['category_id'];

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category/edit', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $category_id) {
				$this->model_catalog_category->deleteCategory($category_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function deleteAjax() {
		
		$this->language->load('catalog/category');

		$this->load->model('catalog/category');

		$this->model_catalog_category->deleteCategory($this->request->get['category_id']);
		
	}

	public function repair() {
		$this->language->load('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		if ($this->validateRepair()) {
			$this->model_catalog_category->repairCategories();

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['restore_path'] = $this->url->link('catalog/category/restore_path', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['import'] = $this->url->link('catalog/category/import', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['add'] = $this->url->link('catalog/category/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/category/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['repair'] = $this->url->link('catalog/category/repair', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['categories'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$category_total = $this->model_catalog_category->getTotalCategories();
		$results = $this->model_catalog_category->getCategories($filter_data);

		
		foreach ($results as $result) {
			$data['categories'][] = array(
				'category_id' => $result['category_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'edit'        => $this->url->link('catalog/category/edit', 'token=' . $this->session->data['token'] . '&category_id=' . $result['category_id'] . $url, 'SSL'),
				'delete'      => $this->url->link('catalog/category/delete', 'token=' . $this->session->data['token'] . '&category_id=' . $result['category_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_restore_path'] = $this->language->get('button_restore_path');
		$data['button_import'] = $this->language->get('button_import');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_rebuild'] = $this->language->get('button_rebuild');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $category_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['category_tree'] = $this->model_catalog_category->getCategoryTree();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($category_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($category_total - $this->config->get('config_limit_admin'))) ? $category_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $category_total, ceil($category_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/category_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['category_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_is_menu'] = $this->language->get('entry_is_menu');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_name_sush'] = $this->language->get('entry_name_sush');
		$data['entry_name_rod'] = $this->language->get('entry_name_rod');
		$data['entry_name_several'] = $this->language->get('entry_name_several');
		$data['entry_title_h1'] = $this->language->get('entry_title_h1');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_top'] = $this->language->get('entry_top');
		$data['entry_column'] = $this->language->get('entry_column');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_is_filter'] = $this->language->get('entry_is_filter');

		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_top'] = $this->language->get('help_top');
		$data['help_column'] = $this->language->get('help_column');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_design'] = $this->language->get('tab_design');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['category_id'])) {
			$data['action'] = $this->url->link('catalog/category/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/category/edit', 'token=' . $this->session->data['token'] . '&category_id=' . $this->request->get['category_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$category_info = $this->model_catalog_category->getCategory($this->request->get['category_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['category_description'])) {
			$data['category_description'] = $this->request->post['category_description'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['category_description'] = $this->model_catalog_category->getCategoryDescriptions($this->request->get['category_id']);
		} else {
			$data['category_description'] = array();
		}

		if (isset($this->request->post['domain_category_description'])) {
			$data['domain_category_description'] = $this->request->post['domain_category_description'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['domain_category_description'] = $this->model_catalog_category->getCategoryDomainDescriptions($this->request->get['category_id']);
		} else {
			$data['domain_category_description'] = array();
		}

		if (isset($this->request->post['path'])) {
			$data['path'] = $this->request->post['path'];
		} elseif (!empty($category_info)) {
			$data['path'] = $category_info['path'];
		} else {
			$data['path'] = '';
		}

	
		if (isset($this->request->post['is_menu'])) {
			$data['is_menu'] = 1;
		} elseif (!empty($category_info)) {
			$data['is_menu'] = $category_info['is_menu'];
		} else {
			$data['is_menu'] = 0;
		}

		if (isset($this->request->post['is_filter'])) {
			$data['is_filter'] = 1;
		} elseif (!empty($category_info)) {
			$data['is_filter'] = $category_info['is_filter'];
		} else {
			$data['is_filter'] = 0;
		}

		if (isset($this->request->post['on_main_page'])) {
			$data['on_main_page'] = 1;
		} elseif (!empty($category_info)) {
			$data['on_main_page'] = $category_info['on_main_page'];
		} else {
			$data['on_main_page'] = 0;
		}

		if (isset($this->request->post['domain_is_menu'])) {
			$data['domain_is_menu'] = 1;
		} elseif (isset($this->request->get['category_id'])) {
			$data['domain_is_menu'] = $this->model_catalog_category->getCategoryDomainIsMenu($this->request->get['category_id']);
		} else {
			$data['domain_is_menu'] = 0;
		}

		if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($category_info)) {
			$data['parent_id'] = $category_info['parent_id'];
		} else {
			$data['parent_id'] = 0;
		}

		$this->load->model('catalog/filter');

		if (isset($this->request->post['category_filter'])) {
			$filters = $this->request->post['category_filter'];
		} elseif (isset($this->request->get['category_id'])) {
			$filters = $this->model_catalog_category->getCategoryFilters($this->request->get['category_id']);
		} else {
			$filters = array();
		}

		//Атрибуты
		$this->load->model('catalog/attribute');
		$this->load->model('catalog/attribute_group');
		
		$data['attributes'] = $this->model_catalog_attribute->getAttributes();
		$data['attribute_groups'] = $this->model_catalog_attribute_group->getAttributeGroups();
		
		if (isset($this->request->get['category_id'])) {
			$data['selected_attributes'] = $this->model_catalog_category->getCategoryAttribute($this->request->get['category_id']);
		} else {
			$data['selected_attributes'] = array();
		}
		
		$data['category_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['category_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['category_store'])) {
			$data['category_store'] = $this->request->post['category_store'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['category_store'] = $this->model_catalog_category->getCategoryStores($this->request->get['category_id']);
		} else {
			$data['category_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($category_info)) {
			$data['keyword'] = $category_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($category_info)) {
			$data['image'] = $category_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($category_info) && is_file(DIR_IMAGE . $category_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['top'])) {
			$data['top'] = $this->request->post['top'];
		} elseif (!empty($category_info)) {
			$data['top'] = $category_info['top'];
		} else {
			$data['top'] = 0;
		}

		if (isset($this->request->post['column'])) {
			$data['column'] = $this->request->post['column'];
		} elseif (!empty($category_info)) {
			$data['column'] = $category_info['column'];
		} else {
			$data['column'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($category_info)) {
			$data['sort_order'] = $category_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($category_info)) {
			$data['status'] = $category_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['category_layout'])) {
			$data['category_layout'] = $this->request->post['category_layout'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['category_layout'] = $this->model_catalog_category->getCategoryLayouts($this->request->get['category_id']);
		} else {
			$data['category_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/category_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['category_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['category_id']) && $url_alias_info['query'] != 'category_id=' . $this->request->get['category_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['category_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($this->error && !isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_warning');
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateRepair() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_category->getCategories($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}