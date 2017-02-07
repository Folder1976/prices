<?php
class ControllerProductCategory extends Controller {
	
	public function setHideMenuHelp(){
		
		setcookie('hide_menu_help', '1', time()+3600);
		
	}
	
	public function index() {

		$data['language_href'] = $this->session->data['language_href'];
		
		
		$this->load->model('setting/setting');
		$this->load->model('module/megareviews');
		$settings=$this->model_setting_setting->getSetting('megareviews');	
		if(isset($settings['megareviews_module'][0]['status'])){
			$data['mr_tab']=($settings['megareviews_module'][0]['position']=="content_mr" && $settings['megareviews_module'][0]['status']);
			$data['mr_status']=$settings['megareviews_module'][0]['status'];    
		}else{
			$data['mr_status']=0;
			$data['mr_tab']=0;
		}
		
		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');
	
		$this->load->model('catalog/attribute');

		$this->load->model('tool/image');
		
		$this->load->model('catalog/manufacturer');

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		$data['language_href'] = $this->session->data['language_href'];
		
		$price = array('price_from'=>0, 'price_to'=>1000000);
		if (isset($this->request->get['price_from']) AND (int)$this->request->get['price_from'] > 0) {
			$price['price_from'] = (int)$this->request->get['price_from'];
		}
		if (isset($this->request->get['price_to']) AND (int)$this->request->get['price_to'] > 0) {
			$price['price_to'] = (int)$this->request->get['price_to'];
		}
	
//setcookie('hide_menu_help', '0', time()+3600);
		$data['selected_attributes'] = array();
		$attributes = array();
		$filters_count = 0;
		if (isset($this->request->get['attributes'])) {
			
			$tmps = explode(',',$this->request->get['attributes']);
	
			if(count($tmps) > 0){	
				foreach($tmps as $tmp){
					$tmp = explode('*', $tmp);
					
					if(isset($tmp[1])){
						//Сортировки не участвуют в фильтре
						if((int)$tmp[1] != 169 AND (int)$tmp[1] != 168){
							$attributes[(int)$tmp[0]][(int)$tmp[1]] = (int)$tmp[1];
							$filters_count++;
						}
						$data['selected_attributes'][(int)$tmp[1]] = (int)$tmp[1];
					}
				}
			}
			
		}
	
		if(isset($this->request->get['helikopter'])){
			$data['helikopter'] = (int)$this->request->get['helikopter'];
		}else{
			$data['helikopter'] = 0;
		}
		
		if(isset($this->request->get['_route_'])){
			$data['_route_'] = $this->request->get['_route_'];
		}else{
			$data['_route_'] = '';
		}
		
		$data['selected_sizes'] = array();
		if (isset($this->request->get['sizes'])) {
			$sizes = $this->request->get['sizes'];
			
			$tmps = explode(',',$sizes);
			foreach($tmps as $tmp){
				
				if($tmp != ''){
					$data['selected_sizes'][$tmp] = $tmp;
				}
				
			}
			
		} else {
			$sizes = '';
		}

		if (isset($this->request->get['sort']) AND $this->request->get['sort'] != '') {
			if($this->request->get['sort'] == 'viewed'){
				$sort = 'p.viewed';
			}elseif($this->request->get['sort'] == 'cheap'){
				$filters_count++;
				$sort = 'p.price';
			}elseif($this->request->get['sort'] == 'expensive'){
				$filters_count++;
				$sort = 'p.price_Z';
			}elseif($this->request->get['sort'] == 'a-z'){
				$filters_count++;
				$sort = 'pd.name';
			}elseif($this->request->get['sort'] == 'z-a'){
				$filters_count++;
				$sort = 'pd.name_Z';
			}else{
				$sort = 'pd.name';
			}
		} else {
			$sort = ' p.click_price DESC, p.price ASC, pd.name ASC';
		}

		if(isset($this->request->get['_route_'])){
			$data['nosort_alias'] = str_replace(array('viewed-','cheap-','expensive-'),'', $this->request->get['_route_']);
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

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => TMP_URL.$data['language_href'].'' /*HTTP_SERVER /*$this->url->link('common/home')*/
		);

		if (isset($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}


			$path = '';

			//Если это страница списков товаров (Поиск, вы смотрели и тд - без определенной категории)			
			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
				$category_id = $this->request->get['category_id'] = 0;
				$parts = array();
			}elseif (isset($this->request->get['manufacturer_main_category'])) {
				$category_id = $this->request->get['category_id'] = 0;
				$parts = array();
			}elseif (isset($this->request->get['_route_']) AND $this->request->get['_route_']== 'lovedproducts') {
				$this->request->get['category_id'] = 0;
				$parts = array();
			}elseif (isset($this->request->get['_route_']) AND $this->request->get['_route_'] == 'lastviewed'){
				$this->request->get['category_id'] = 0;
				$parts = array();
			}else{
				$parts = $this->model_catalog_category->getCategoryPath((int)$this->request->get['category_id']);
				$parent_id = 0;
				$category_id = (int)array_pop($parts);
			}
	
	
			$count = 0;
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory((int)$path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => ''.$category_info['name'],
						'href' => TMP_URL.$data['language_href'].$this->model_catalog_category->getCategoryAlias((int)$path_id)//.$url
					);
				}
		
				if((int)$path_id > 0){
					if($count == 1){
						$parent_id = (int)$path_id;
						$parent_name = $category_info['name'];
					}
					$count++;
				}
			}
		} else {
			$category_id = 0;
		}

		
		
		$search = '';
		if (isset($this->request->get['search'])) {
			
			$this->load->model('catalog/information'); 
			$category_info = $this->model_catalog_information->getInformation(7); // id 7 = search
			$like_info = 'search';
			$search = $this->request->get['search'];
			$category_info['name'] = $category_info['title'];
			
			foreach($category_info as $index => $name){
				$category_info[$index] = str_replace('@search@', $this->request->get['search'], $name);
			}
		
		//Если это полная выборка по бренуд - подставим массив категории
		}elseif (isset($this->request->get['manufacturer_main_category'])) {
			$category_id = 0;
			$data['manufacturer_main_category'] = true;
			$this->load->model('catalog/information'); 
			$category_info = $this->model_catalog_information->getInformation(24); // id 23 = страница для бренда
			
			$data['breadcrumbs'][] = array(
				'text' => $category_info['title'],
				'href' => TMP_URL.$data['language_href'].'brands'
			);
			
			$category_info = $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer((int)$this->request->get['manufacturer_id']);
			$selected_attributes_alias = $manufacturer_info['keyword'];
			
			$category_info['category_id'] = $category_id;
			$category_info['image'] = array();
			$category_info['href'] = $category_info['keyword'];
			
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => TMP_URL.$data['language_href'].''.$category_info['href']
			);
				
	
		//Если это полная выборка по разпродаже
		}elseif (isset($this->request->get['main_sale'])) {
			$category_id = 0;
			$data['main_sale'] = true;
			$this->load->model('catalog/information'); 
			$category_info = $this->model_catalog_information->getInformation(23); // id 23 = страница для бренда
			$category_info['name'] = $category_info['title'];
			$category_info['category_id'] = $category_id;
			$category_info['image'] = array();
			
			$data['manufacturer_main_category'] = true;
	
		}elseif (isset($this->request->get['_route_']) AND $this->request->get['_route_']== 'lovedproducts') {
			
			$this->load->model('catalog/information'); 
			$category_info = $this->model_catalog_information->getInformation(8); // id 7 = search
			$like_info = true;
			
		}elseif (isset($this->request->get['_route_']) AND $this->request->get['_route_'] == 'lastviewed'){
			
			$this->load->model('catalog/information'); 
			$category_info = $this->model_catalog_information->getInformation(9); // id 7 = search
			$like_info = true;
		}else{
			
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if(defined('IS_SUBDOMAIN') AND $this->document->getPathDomain() != 'moscow'){

				$tmp = $this->model_catalog_category->getCategoryDomain($category_id);
			
				if($tmp){

					if($tmp['name'] != '') $category_info['name'] = $tmp['name'];
					if($tmp['title_h1'] != '') $category_info['title_h1'] = $tmp['title_h1'];
					if($tmp['description'] != '') $category_info['description'] = $tmp['description'];
					if($tmp['meta_title'] != '') $category_info['meta_title'] = $tmp['meta_title'];
					if($tmp['meta_description'] != '') $category_info['meta_description'] = $tmp['meta_description'];
					if($tmp['meta_keyword'] != '') $category_info['meta_keyword'] = $tmp['meta_keyword'];
				}
			}
		
		}
		
		$short_tags = array();
		
		if ($category_info) {
			
			$short_tags['@block_name@'] 			= '';
			$short_tags['@block_name_rod@'] 		= '';
			$short_tags['@block_name_several@'] 	= '';

			if(isset($category_info['name_sush'])) 			$short_tags['@block_name@'] = $category_info['name_sush'];;
			if(isset($category_info['block_name_rod'])) 	$short_tags['@block_name_rod@'] = $category_info['block_name_rod'];;
			if(isset($category_info['block_name_several'])) $short_tags['@block_name_several@'] = $category_info['block_name_several'];;
			
			
			//Если есть назначенные данные для категории
			if(isset($this->request->get['_route_'])){
				
				if($this->document->getPathDomain() != 'moscow'){
					$categorize = $this->model_catalog_category->getCategorizeDomain($this->request->get['_route_']);
				}else{
					$categorize = $this->model_catalog_category->getCategorize($this->request->get['_route_']);
				}
			}

			if(isset($categorize) AND $categorize){

				$short_tags['@block_name@'] = isset($categorize['name_sush']) ? $categorize['name_sush'] : '';
				$short_tags['@block_name_rod@'] = isset($categorize['name_rod']) ? $categorize['name_rod'] : '';
				$short_tags['@block_name_several@'] = isset($categorize['name_several']) ? $categorize['name_several'] : '';
				
				$this->document->setTitle($categorize['title']);
				$this->document->setDescription(strip_tags(htmlspecialchars_decode($categorize['text1'], ENT_QUOTES)));
				$this->document->setKeywords($categorize['title']);
				$data['heading_title'] = $categorize['title_h1'];
				$data['description'] = html_entity_decode($categorize['text2'], ENT_QUOTES, 'UTF-8');
			
			}elseif(isset($like_info) AND $like_info){

				$this->document->setTitle($category_info['meta_title']);
				$this->document->setDescription(strip_tags(htmlspecialchars_decode($category_info['meta_description'], ENT_QUOTES)));
				$this->document->setKeywords($category_info['meta_keyword']);
				$data['heading_title'] = $category_info['title'];
				$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
				$category_info['name'] = $category_info['title'];
			
			}else{
			
				
				$data['heading_title'] = ($category_info['title_h1'] == '') ? $category_info['name'] : $category_info['title_h1'];
				$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
				
				
				//Если есть фильтры но они не подпадают по назначенные алиасы
				if(isset($attributes) AND count($attributes) > 0){
					$attributes_as_string = $this->model_catalog_attribute->getStringFromAttributes($attributes);
					
					$tmp = explode(':', $data['heading_title']);
					$data['heading_title'] = $tmp[0] . ': ' . $attributes_as_string;
					
					$data['description'] = '';
					$this->document->setTitle($data['heading_title']);
					$this->document->setDescription($data['heading_title']);
					$this->document->setKeywords($data['heading_title']);
					
					$data['heading_title'] = $category_info['title_h1'];
					$this->document->setTitle($category_info['meta_title']);
					$this->document->setDescription($category_info['meta_description']);
					$this->document->setKeywords($category_info['meta_keyword']);
				
					
				}else{
					
					//Описания по умолчанию
					$this->document->setTitle($category_info['meta_title']);
					$this->document->setDescription($category_info['meta_description']);
					$this->document->setKeywords($category_info['meta_keyword']);
				}
				
			}

		
			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');

			
			$data['text_search_detail'] = $this->language->get('text_search_detail');
			$data['text_close'] = $this->language->get('text_close');
			$data['text_onesize'] = $this->language->get('text_onesize');
			$data['text_select_size'] = $this->language->get('text_select_size');
			$data['text_size_help'] = $this->language->get('text_size_help');
			$data['text_filter'] = $this->language->get('text_filter');
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_size'] = $this->language->get('text_size');
			$data['text_category'] = $this->language->get('text_category');
			$data['text_color'] = $this->language->get('text_color');
			$data['text_clear_all'] = $this->language->get('text_clear_all');
			$data[''] = $this->language->get('');
			
			
			//Запрет на роботс
			$no_index = 0;
			if($search != '') $no_index = 2;
			$no_index += $filters_count;
			
			if($no_index > 1) $this->document->setMetaTeg('<meta name="robots"  content="noindex">');
		
			
			// Set the last category breadcrumb
			if(isset($like_info) AND $like_info){
				//Для информационной страницы
				$data['breadcrumbs'][] = array(
					'text' => $category_info['title'],
					'href' => TMP_URL.$data['language_href'].''
				);
	
				$data['thumb'] = '';

			}else{
				
				//Для конечной категории
				if($category_info['category_id'] > 0){
					if($no_index > 0){
						$data['breadcrumbs'][] = array(
							'text' => '1'.$category_info['name'],
							'href' => TMP_URL.$data['language_href'].$this->model_catalog_category->getCategoryAlias((int)$category_info['category_id']),
							'as_link' => true
						);
					}else{
						$data['breadcrumbs'][] = array(
							'text' => $category_info['name'],
							'href' => TMP_URL.$data['language_href'].$this->model_catalog_category->getCategoryAlias((int)$category_info['category_id'])
						);
					}
				}
	
				if ($category_info['image']) {
					$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
				} else {
					$data['thumb'] = '';
				}
			}
				
			$data['compare'] = $this->url->link('product/compare');

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			
			$data['categories'] = array();
			
			if(isset($parent_id) AND $parent_id > 0){
				$results = $this->model_catalog_category->getCategories($parent_id);
				$data['categories']['header'] = $parent_name;
			}else{
				$results = $this->model_catalog_category->getCategories($category_id);
				if(isset($category_info['name']))
						$data['categories']['header'] = $category_info['name'];
			}



			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

				$data['categories']['categories'][] = array(
					'category_id' => $result['category_id'],
					'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->model_catalog_category->getCategoryAlias($result['category_id']) //. $url
				);
			}

			$data['products'] = array();

			
			if(isset($this->request->get['filtered_category'])){
				$filter_category_id = $this->request->get['filtered_category'];
			}else{
				$filter_category_id = $category_id;
			}
			
			$filter_manufacturer_id = '';
			if(isset($this->request->get['filter_manufacturer_id'])) $filter_manufacturer_id = $this->request->get['filter_manufacturer_id'];
			
			$filter_sale = '';
			if(isset($this->request->get['sale'])) $filter_sale = $this->request->get['sale'];
			
			$filter_data = array(
				'filter_category_id' 	=> $category_id,
				'filter_sub_category' 	=> true,
				'filter_sizes'      	=> $sizes,
				'filter_name'      		=> $search,
				'filter_manufacturer_id'=> $filter_manufacturer_id,
				'filter_price'      	=> $price,
				'filter_sale'      		=> $filter_sale,
				'filter_filter'      	=> $filter,
				'filter_attributes' 	=> $attributes,
				'sort'               	=> $sort,
				'order'              	=> $order,
				'start'              	=> ($page - 1) * $limit,
				'limit'              	=> $limit
			);
	
			//Фиксированные ЧПУ
			if (isset($this->request->get['_route_']) AND $this->request->get['_route_']== 'lovedproducts') {
			
				$data['lovedproducts'] = true;
				$filter_data['lovedproducts'] = true;
				//$filter_data['start'] = 0;
				//$filter_data['limit'] = 100000;
				
			}elseif (isset($this->request->get['_route_']) AND $this->request->get['_route_'] == 'lastviewed'){
				
				$filter_data['lastviewed'] = true;
			
			}
			
			if (isset($this->request->get['main_sale'])) {
				$data['category_alias'] = 'sale';
			}else{
				$data['category_alias'] = $this->model_catalog_category->getCategoryAlias($category_id);
			}

			$product_ids = $this->model_catalog_product->getTotalProductIds($filter_data);
			$data['total_product_info'] = $total_product_info = $this->model_catalog_product->getTotalProductsInfo($filter_data);
	
			$product_total = count($product_ids);

			$results = $this->model_catalog_product->getProducts($filter_data);
		
			//Соберем все атрибуты
			$attr_ids = array();
			if(count($attributes) > 0){
				$filter_data_tmp = $filter_data;
				unset($filter_data_tmp['filter_attributes']);
				$tmp = $this->model_catalog_product->getTotalProductIds($filter_data_tmp);
			}else{
				$tmp = $product_ids;
			}
	
			//Догружаем фильтрованные товары
			//$product_addons_line = array();
			if(count($attributes) > 0 AND $product_total < (($page - 1) * $limit + $limit)){
				/*
				foreach($attributes as $grp_id  => $attr_grp){
					
					//Если фильтр один
					if(count($attributes) < 2 AND count($attr_grp) < 2){
						continue;
					}
					
					foreach($attr_grp as $attr_id){
						
						$filter_data_tmp = $filter_data;
						
						$filter_data_tmp['filter_attributes'] = array($grp_id => array($attr_id=>$attr_id));
						$filter_data_tmp['limit'] 	= 4;
						$filter_data_tmp['sort'] 	= 'p.viewed';
					
						$tmp_array = $this->model_catalog_product->getProducts($filter_data_tmp);
					
						if(count($tmp_array) > 0){
							
							$filter_alias = $this->model_catalog_attribute->getAttributeAlias($attr_id);
							
							$name = $this->model_catalog_category->getCategorizeName($filter_alias.'-'.$data['category_alias']);
							
							if($name == ''){
								$name = $this->model_catalog_attribute->getAttributeName($attr_id).' '.$data['heading_title'] ;
							}
							
							$results[] = array(
											   'product_id'	=> 'system',
											   'name'		=> 'break_stop_line',
											   'href'		=> ''.$filter_alias . '-' . $data['category_alias'],
											   'header_name'=> $name
											   );
							foreach($tmp_array as $product){
								$results[] = $product;
							}
						}
					}
				}
				*/
			}elseif($product_total < (($page - 1) * $limit + $limit)){
				//Если нет фильтров - возьмем немного товаров с соседних категорий
				/*
				if(isset($data['categories']) AND isset($data['categories']['categories'])){
					foreach($data['categories']['categories'] as $brother_category){
						
						if($category_id != $brother_category['category_id']){
							$filter_data_tmp = $filter_data;
							
							$filter_data_tmp['filter_category_id'] = $brother_category['category_id'];
							$filter_data_tmp['limit'] 	= 4;
							$filter_data_tmp['sort'] 	= 'p.viewed';
						
							$tmp_array = $this->model_catalog_product->getProducts($filter_data_tmp);
						
							if(count($tmp_array) > 0){
								
								$filter_alias = $brother_category['href'];
								$name = $brother_category['name'];
								
								//echo '<br>'.$filter_alias;
								$results[] = array(
												   'product_id'	=> 'system',
												   'name'		=> 'break_stop_line',
												   'href'		=> ''.$filter_alias,
												   'header_name'=> $name
												   );
								foreach($tmp_array as $product){
									$results[] = $product;
								}
							}
						}
					}
				}*/
			}
			
			//Если это конец списка
			$data['last_page'] = 0;
			if($product_total < (($page - 1) * $limit + $limit)){
				$data['last_page'] = 1;	
			}
			
			if(is_array($tmp)){
				foreach ($tmp as $result) {
			
					$tmp1 = $this->model_catalog_attribute->getAttributesIdOnProduct($result['product_id']);
						if($tmp1){
						foreach($tmp1 as $value){
							$attr_ids[$value['attribute_id']] = $value['attribute_id'];
						}
					}
				}
			}
			//end Соберем все атрибуты
	
	
			//Если есть выбранные размеры - нам нужно получить ИД продуктов без фильтрации по размерам
			if(count($sizes) > 0){
				$filter_data_tmp = $filter_data;
				unset($filter_data_tmp['filter_sizes']);
				$tmp = $this->model_catalog_product->getTotalProductIds($filter_data_tmp);
			}else{
				$tmp = $product_ids;
			}
			
			$product_ids_no_size_filter = array();
			foreach($tmp as $value){
				$product_ids_no_size_filter[] = $value['product_id'];
			}
			//end Если есть выбранные размеры - нам нужно получить ИД продуктов без фильтрации по размерам
			
			//Соберем размеры
			//$data['sizes'] = $this->model_catalog_product->getProductsOptions($product_ids_no_size_filter);
			//$data['sizes'] = $this->model_catalog_attribute->getSisezOnProductNoGroup($product_ids_no_size_filter);

				
			//Тут все бренды по категории
			//$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturersByCategoryId($category_id);
			
			
			//Выберем ИД товаров без учера фильтра брендов если он был
			if(isset($filter_data_tmp['filter_manufacturer_id']) AND $filter_data_tmp['filter_manufacturer_id'] != ''){
				$filter_data_tmp = $filter_data;
				unset($filter_data_tmp['filter_manufacturer_id']);
				$tmp = $this->model_catalog_product->getTotalProductIds($filter_data_tmp);
			}else{
				$tmp = $product_ids;
			}

			$product_ids_no_size_filter = array();
			foreach($tmp as $value){
				$product_ids_no_manuf_filter[] = $value['product_id'];
			}
				
					
			//Тут все бренды с учетом выбранных товаров
			$data['manufacturers'] = array();
			if(isset($product_ids_no_manuf_filter)){
				$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturersByProductIds($product_ids_no_manuf_filter);
			}
		
			unset($product_ids_no_size_filter);
			//end Соберем размеры
		
			//Тут будут ИД всех категорий продуктов которые мы выводим
			$product_attributes = array();

		
		
			//Прилепим рекламные продукты если есть
			foreach ($results as $result) {
				
				if($result['product_id'] == 'system'){
					$data['products'][] = array(
										'product_id'	=> 'system',
										'name'       	=> $result['name'],
										'href'			=> $result['href'],
										'header_name'	=> $result['header_name'],
										);
					continue;
				}
				
				$product_attributes[$result['category_id']] = $result['category_id'];
				
				$tmp = $this->model_catalog_attribute->getAttributesIdOnProduct($result['product_id']);
			
				if($tmp){
					foreach($tmp as $value){
						$attr_ids[$value['attribute_id']] = $value['attribute_id'];
					}
				}
			
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					$image_second = $this->model_tool_image->resize($result['image_second'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
					$image_second = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				}

				
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					$old_price = $this->currency->format($this->tax->calculate($result['old_price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
					$old_price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
				
	
				if($result['old_price'] > 0 AND $result['old_price'] > $result['price']){
					$sale = number_format((100 - ((int)$result['price'] / ((int)$result['old_price'] / 100))), '2', '.', '');
				}else{
					$sale = '';	
				}
			
				$options = array();
				foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
					$product_option_value_data = array();
	
					foreach ($option['product_option_value'] as $option_value) {
						//if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
							$product_option_value_data[] = array(
								'product_option_value_id' => $option_value['product_option_value_id'],
								'option_value_id'         => $option_value['option_value_id'],
								'quantity'         => $option_value['quantity'],
								'name'                    => $option_value['name'],
								'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
								'price_prefix'            => $option_value['price_prefix']
							);
						//}
					}
	
					$options[] = array(
						'product_option_id'    => $option['product_option_id'],
						'product_option_value' => $product_option_value_data,
						'option_id'            => $option['option_id'],
						'name'                 => $option['name'],
						'type'                 => $option['type'],
						'value'                => $option['value'],
						'required'             => $option['required']
					);
				}
			
			
				$date_v = date('Y-m-d');
				if(isset($result['viewed']) AND $result['viewed']) $date_v = $result['viewed'];
	
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'thumb_second'       => $image_second,
					'viewed'	=> $date_v,
					'original_url'      => $result['original_url'],
					'options'        	=> $options,
					'name'        		=> $result['name'],
					'loved'        		=> $result['loved'],
					'garant'        		=> $result['garant'],
					'total_comments' => $this->model_module_megareviews->getProductTotalReviews($product_id),
					'total_images' => $this->model_catalog_product->getProductTotalImages($product_id),
					/*'size'        		=> $result['size'],*/
					'shop_id'        	=> $result['shop_id'],
					'shop_name'        	=> $result['shop_name'],
					'videos'        	=> $result['videos'],
					'shop_href'        	=> $result['shop_href'],
					'manufacturer_id'   => $result['manufacturer_id'],
					'manufacturer'      => $result['manufacturer'],
					'manufacturer_image'      => $result['manufacturer_image'],
					'manufacturer_href' => $result['manufacturer_href'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'old_price'   => $old_price,
					'sale'		  => $sale,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->model_catalog_product->getProductAlias($result['product_id'])
				);
			}
			
			//Флаг на распродажу
			$this->document->setSale(true);
			
			//Если это аякс запрос следующей страницы - можем уже тут и закончить
			if((isset($this->request->post['autoload']) AND $this->request->post['autoload'] == true) OR (isset($this->request->get['autoload']) AND $this->request->get['autoload'] == true)){
				echo  json_encode($data['products']);
				return true;
			}
		
		
		
			
			//Если нужно вывести категории только тех товаров что выбраны (поиск или просмотренные)
			if(isset($like_info) AND $like_info){
				unset($data['categories']);
				$data['categories'] = array();
			
				foreach ($product_attributes as $category_id) {
					
					$result = $this->model_catalog_category->getCategory($category_id);
					
					//Если это суббодомен - подменим
					if(defined('IS_SUBDOMAIN')){
						$tmp = $this->model_catalog_category->getCategoryDomain($category_id);
						if($tmp){
							if($tmp['name'] != '') $category_info['name'] = $tmp['name'];
							if($tmp['title_h1'] != '') $category_info['title_h1'] = $tmp['title_h1'];
							if($tmp['description'] != '') $category_info['description'] = $tmp['description'];
							if($tmp['meta_title'] != '') $category_info['meta_title'] = $tmp['meta_title'];
							if($tmp['meta_description'] != '') $category_info['meta_description'] = $tmp['meta_description'];
							if($tmp['meta_keyword'] != '') $category_info['meta_keyword'] = $tmp['meta_keyword'];
						}
					}

					
					if(isset($filter_data['lastviewed']) OR isset($filter_data['lovedproducts'])){
						$data['categories']['categories'][] = array(
							'category_id' => (int)$category_id,
							'name' => $result['name'],
							'href' => $this->model_catalog_category->getCategoryAlias($category_id) //. $url
						);
					}else{
						$data['categories']['categories'][] = array(
							'category_id' => (int)$category_id,
							'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
							'href' => $this->model_catalog_category->getCategoryAlias($category_id) //. $url
						);
					}
				}
			}		
			
			//Массив атрибутов для фильтров
			$product_attributes = array();
			/*	
			$add_filters = array();
			$add_filters[] = array('name'=>'Цена','attribute_id'=>169,'filter_name'=>'Недорогие','filter_alias'=>'cheap');
			$add_filters[] = array('name'=>'Цена','attribute_id'=>168,'filter_name'=>'Дорогие','filter_alias'=>'expensive');
			
			foreach($add_filters as $filter){
				$product_attributes[22]['attribute_group_id'] = 22;
				$product_attributes[22]['attribute_group_name'] = $filter['name'];
				$product_attributes[22]['description'] = $filter['name'];
				$product_attributes[22]['attributes'][$filter['attribute_id']]['attribute_id'] = $filter['attribute_id'];
				$product_attributes[22]['attributes'][$filter['attribute_id']]['name'] = $filter['filter_name'];
				$product_attributes[22]['attributes'][$filter['attribute_id']]['filter_name'] = $filter['filter_alias'];
			}
			
			$product_attributes[22]['attribute_group_id'] = 22;
			$product_attributes[22]['attributes'][0]['attribute_id'] = -1;
			$product_attributes[22]['attribute_group_name'] = 'Цена';
			$product_attributes[22]['description'] = 'Цена';
			*/
			//Подчистим атрибуты по тем что назначены
			//Тут идет отсечение не активных у категории атрибутов
			// Если это категория бренда - открываем все фильтры
			if($attr_ids AND count($attr_ids)  AND !isset($data['manufacturer_main_category'])){
				
				$category_attr = $this->model_catalog_category->getCategoryAttribute($category_id);
				
				foreach($attr_ids as $attr_id => $tmp){
					if(!isset($category_attr[$attr_id])) unset($attr_ids[$attr_id]);
				}
	
			}
		
			
			if($attr_ids AND count($attr_ids) ){
	
				$results = $this->model_catalog_attribute->getAttributesOnIds($attr_ids);
	
				if($results){
					
					foreach($results as $result){
						
						$product_attributes[$result['attribute_group_id']]['attribute_group_id'] = $result['attribute_group_id'];
						$product_attributes[$result['attribute_group_id']]['attribute_group_name'] = $result['group_name'];
						$product_attributes[$result['attribute_group_id']]['description'] = $result['description'];
						$product_attributes[$result['attribute_group_id']]['attributes'][$result['attribute_id']]['attribute_id'] = $result['attribute_id'];
						$product_attributes[$result['attribute_group_id']]['attributes'][$result['attribute_id']]['name'] = $result['name'];
						$product_attributes[$result['attribute_group_id']]['attributes'][$result['attribute_id']]['filter_name'] = $result['filter_name'];
						
					}
					
				}
			}
		
		
			if(isset($this->request->get['filtered_category'])){
				$filter = explode(',',$this->request->get['filtered_category']);
				if($filter AND count($filter)){
					
					$selected_categories = array();
					
					foreach($filter as $categ_id){
						$selected_categories[] = $this->model_catalog_category->getCategoryNameKeyword($categ_id);
					}
					
					$data['selected_categories'] = $selected_categories;
				}
					
			}
		
		
		
			$data['product_attributes'] = $product_attributes;
		
			if(isset($this->request->get['attributes_name'])){
				$selected_attributes_alias = str_replace(',','-',$this->request->get['attributes_name']).'-';
			}
			
			if(isset($selected_attributes_alias) AND $selected_attributes_alias == '-') $selected_attributes_alias = '';
			
			
			//Возможно залетел системный фильтр
			$results = $this->model_catalog_attribute->getAttributesOnGroupId(0);
			
			foreach($results as $attributes){
				if(isset($selected_attributes[$attributes['attribute_id']])){
					$selected_attributes_alias .= $attributes['filter_name'].'-';
				}
			}

			if(isset($data['selected_sizes']) AND is_array($data['selected_sizes']) ){
				
				$this->load->model('catalog/size');
				
				$data['selected_sizes'] = $sizes = $this->model_catalog_size->getSizes($data['selected_sizes']);
				
				foreach($sizes as $size){
					$selected_attributes_alias = 'sz_'.$size['name'].'-'.$selected_attributes_alias;
				}

			}

			$data['selected_attributes_alias'] = isset($selected_attributes_alias) ? $selected_attributes_alias : '';
			
			
			//Вынесем атрибут цвета в отдельный массив
			/*
			$data['product_attribute_colors'] = array();
			if(isset($product_attributes[15])){
				$data['product_attribute_colors'] = $product_attributes[15];
				unset($product_attributes[15]);
				unset($data['product_attributes'][15]);
			}
		`	*/
			$url = '';

			$data['subcategories'] = $this->model_catalog_category->getCategoriesTree($category_id, true);
			$data['categories_is_filter'] = $this->model_catalog_category->getCategoriesIsFilter($category_id, true);
		
			
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			if(isset($like_info) AND $like_info){
				$this->request->get['path'] = '';
			}

			
			//Получим 20 самых просматриваемых
			$filter_data = array(
					'filter_category_id' 	=> $category_id,
					'filter_sub_category' 	=> true,
					'sort'               	=> 'p.count_view DESC',
					'order'              	=> '',
					'start'              	=> 0,
					'limit'              	=> 20
				);
		
			$data['popular_products'] = $this->model_catalog_product->getProducts($filter_data);
			
			$filter_data['sort']	= 'count(pv.date) DESC';
			$filter_data['lastviewed']	= true;
			$filter_data['lastviewed_where']	= ' AND pv.date > "'.date('Y-m-d H:i:s', strtotime('-24 hour')).'"';
			$data['last_viewed_products_day'] = $this->model_catalog_product->getProducts($filter_data);
			
			$filter_data['lastviewed_where'] = ' AND pv.date > "'.date('Y-m-d H:i:s', strtotime('-1 week')).'"';
			$data['last_viewed_products_week'] = $this->model_catalog_product->getProducts($filter_data);
			
			$filter_data['lastviewed_where'] = ' AND pv.date > "'.date('Y-m-d H:i:s', strtotime('-1 month')).'"';
			$data['last_viewed_products_month'] = $this->model_catalog_product->getProducts($filter_data);
	
			$data['category_page_products'] = $this->model_catalog_product->getCategoryPageProducts($category_id);
			
				
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => '&sort=p.sort_order&order=ASC' . $url
			);


			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => '&sort=p.price&order=ASC' . $url
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => '&sort=p.price&order=DESC' . $url
			);


			$url = '';

			
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_product_limit'), 20, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			
			
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			//$pagination->url = $data['category_alias'] . $url;
			if(isset($this->request->get['_route_'] )){
				$pagination->url = $this->request->get['_route_'] . $url;
			}elseif(isset($this->request->get['search'] )){
				$pagination->url = '?search='.$this->request->get['search'];
			}else{
				$pagination->url = '';
			}
			
			
			if(strpos($pagination->url, '?') === false){
				$pagination->url .= '?page={page}';
			}else{
				$pagination->url .= '&page={page}';
			}
			
		
			$data['pagination'] = $pagination->render();
			$data['pagination_array']['total'] = $product_total;
			$data['pagination_array']['page'] = $page;
			$data['pagination_array']['limit'] = $limit;
			$data['pagination_array']['url'] = $pagination->url;
			
			if($product_total <= $limit OR ceil($product_total/$limit) == $page){
				$data['is_last_page'] = true;
			}
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if (isset($this->request->get['_route_']) AND $this->request->get['_route_']== 'lovedproducts') {

				$this->document->addLink('http://'.$_SERVER['SERVER_NAME'].'/'.TMP_URL.$this->request->get['_route_'], 'canonical');

			}elseif(isset($like_info) AND $like_info AND is_string($like_info)){
				
				$this->document->addLink('http://'.$_SERVER['SERVER_NAME'].'/'.TMP_URL.'?'.$like_info . '=' . $this->request->get[$like_info], 'canonical');

			}else{

				$this->document->addLink('http://'.$_SERVER['SERVER_NAME'].'/'.TMP_URL.$this->request->get['_route_'], 'canonical');

			}
			
			
			//Делаем прогонку на короткие теги автозамены
			/*
			 * Памятка по кодам
			 * @min_price@ - Минимальная цена
			 * @products_count@ - Количество продуктов
			 * @shops_count@ - Количество магазинов
			 * @design_count@ - Количество дизайнеров
			 * @prev_year@ - Предыдущий год
			 * @now_year@ - Текущий год
			 * @next_year@ - Следующий год
			 * @dinamic_year@ - Динамический диапазон 2016-2016
			 *
			 * @city@ - Город [именительный] (Москва)
			 * @sity_to@ - Кород [дательный] (В Москву)
			 * @city_on@ - Город [предложный](По Москве)
			 */
		
			$ids = array();
			foreach($product_ids as $row){
				$ids[] = $row['product_id'];
			}
			
			$product_tags = $this->model_catalog_product->getProductsTags($ids);
			
			//Добавим еще теги
			foreach($short_tags as $index => $value){
				$product_tags[$index] = $value;
			}
	
	
			if(strlen(strip_tags($data['description'])) < 3){
				
				$data['description'] = $this->model_catalog_category->getUniversaLDescription();
				$this->document->setDescription($data['description']);
			}
	
			foreach($product_tags as $find => $replace){

				$data['heading_title'] = str_replace($find, $replace, $data['heading_title']);
				$data['description'] = str_replace($find, $replace, $data['description']);
				$this->document->setTitle(str_replace($find, $replace, $this->document->getTitle()));
				$this->document->setDescription(str_replace($find, $replace, $this->document->getDescription()));
				$this->document->setKeywords(str_replace($find, $replace, $this->document->getKeywords()));
	
			}
			
			//Вертолет
			if($data['helikopter'] > 0){
				//$data['heading_title'] = не меняем
				$data['description'] = '';
				$this->document->setTitle($this->document->getTitle().' '.$data['helikopter']);
				$this->document->setDescription($data['helikopter'] . ' ' . $this->document->getDescription());
				//$this->document->setKeywords(str_replace($find, $replace, $this->document->getKeywords()));
			}
			
			//Сгенерим линк на следующий клик вертолета
			if(isset($this->request->get['_route_'])){
				$data['helikopter_next_href'] = 'http://'.$_SERVER['SERVER_NAME'].'/'.TMP_URL.$this->request->get['_route_'].'-'.($data['helikopter']+1).'click';
				if(strpos($_SERVER['REQUEST_URI'],'?') !== false){
					$tmp = explode('?', $_SERVER['REQUEST_URI']);
					if(isset($tmp[1]) AND $tmp[1] !== ''){
						$data['helikopter_next_href'] .= '?'.$tmp[1];
					}
				}
			}else{
				$data['helikopter_next_href'] = 'http://'.$_SERVER['SERVER_NAME'].'/'.TMP_URL.'-'.($data['helikopter']+1).'click';
				$get = '?';
				foreach($_GET as $index => $value){
					$get .= $index.'='.$value.'&';
				}
				$data['helikopter_next_href'] .= $get;
			}
			
			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
			$data['category_id'] = $category_id;

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
	
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/category.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/product/category.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => TMP_URL.$this->url->link('product/category', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}
	
	
	
}
