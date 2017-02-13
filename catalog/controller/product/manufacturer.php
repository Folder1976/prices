<?php
class ControllerProductManufacturer extends Controller {
	public function index() {
		
		$data['language_href'] = $this->session->data['language_href'];
		
		
		$this->load->language('product/manufacturer');

		$this->load->model('catalog/manufacturer');

		$this->load->model('tool/image');
		
		$data['language_href'] = $this->session->data['language_href'];

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_index'] = $this->language->get('text_index');
		$data['text_empty'] = $this->language->get('text_empty');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => '/'.$data['language_href'].''//$this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_brand'),
			'href' => '/'.$data['language_href'].'brands_and_shops' //$this->url->link('product/manufacturer')
		);

		$data['categories'] = array();

		die('manufactura 39');
		
		$results = $this->model_catalog_manufacturer->getManufacturers();

		foreach ($results as $result) {
			if (is_numeric(utf8_substr($result['name'], 0, 1))) {
				$key = '0 - 9';
			} else {
				$key = utf8_substr(utf8_strtoupper($result['name']), 0, 1);
			}

			if (!isset($data['categories'][$key])) {
				$data['categories'][$key]['name'] = $key;
			}

			$data['categories'][$key]['manufacturer'][] = array(
				'name' => $result['name'],
				'href' => '/'.$data['language_href'].$result['keyword']//$this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
			);
		}

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/manufacturer_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/product/manufacturer_list.tpl', $data));
		}
	}

	public function info() {
		
		$this->load->language('product/manufacturer');

		$this->load->model('catalog/manufacturer');

		$this->load->model('catalog/product');
		
		$this->load->model('catalog/category');

		$this->load->model('catalog/shops');
		
		$this->load->model('tool/image');
		
		$this->load->model('catalog/attribute');

		$data['language_href'] = $this->session->data['language_href'];
		
		if(isset($this->request->get['helikopter'])){
			$data['helikopter'] = (int)$this->request->get['helikopter'];
		}else{
			$data['helikopter'] = 0;
		}
	
		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = (int)$this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}

		if (isset($this->request->get['shop_id'])) {
			$shop_id = (int)$this->request->get['shop_id'];
		} else {
			$shop_id = 0;
		}

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		$data['selected_attributes'] = array();
		$attributes = array();
		if (isset($this->request->get['attributes'])) {
			
			$tmps = explode(',',$this->request->get['attributes']);
			
			if(count($tmps) > 0){	
				foreach($tmps as $tmp){
					$tmp = explode('*', $tmp);
					
					if(isset($tmp[1])){
						$attributes[(int)$tmp[0]][(int)$tmp[1]] = (int)$tmp[1];
						$data['selected_attributes'][(int)$tmp[1]] = (int)$tmp[1];
					}
				}
			}
			
		}
		
		$data['selected_sizes'] = array();
		if (isset($this->request->get['sizes'])) {
			$sizes = $this->request->get['sizes'];
			
			$tmps = explode(',',$sizes);
			foreach($tmps as $tmp){
				$data['selected_sizes'][$tmp] = $tmp;
			}
			
		} else {
			$sizes = '';
		}

		if (isset($this->request->get['sort'])) {
			if($this->request->get['sort'] == 'viewed'){
				$sort = 'p.viewed';
			}elseif($this->request->get['sort'] == 'cheap'){
				$sort = 'p.price';
			}elseif($this->request->get['sort'] == 'expensive'){
				$sort = 'p.price_Z';
			}elseif($this->request->get['sort'] == 'a-z'){
				$sort = 'pd.name';
			}elseif($this->request->get['sort'] == 'z-a'){
				$sort = 'pd.name_Z';
			}else{
				$sort = 'pd.name';
			}
		} else {
			$sort = 'pd.name';
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
			$limit = (int)$this->config->get('config_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => '/'.TMP_URL.$data['language_href'] //$this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_brand'),
			'href' => '/'.TMP_URL.$data['language_href'].'brands_and_shops' //$this->url->link('product/manufacturer')
		);

		if(isset($shop_id) AND $shop_id > 0){
			$manufacturer_info = $this->model_catalog_shops->getShop((int)$shop_id);
			$manufacturer_info['keyword'] = $manufacturer_info['href'];
		}else{
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer((int)$manufacturer_id);	
		}
	
	
		if ($manufacturer_info) {
			$this->document->setTitle($manufacturer_info['name']);

			$url = '';

			if (isset($this->request->get['sort']) AND $this->request->get['sort'] != '') {
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

			
			if(isset($shop_id) AND $shop_id > 0){
				$data['breadcrumbs'][] = array(
				'text' => $manufacturer_info['name'],
				'href' => '/'.$data['language_href'].$manufacturer_info['keyword']
				);
			}else{
				$data['breadcrumbs'][] = array(
				'text' => $manufacturer_info['name'],
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
				);
			}
	
			$data['heading_title'] = $manufacturer_info['name'];
			$data['description'] = $manufacturer_info['description'];

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
		
			
			$data['compare'] = $this->url->link('product/compare');

			$data['products'] = array();

			$filter_data = array(
				'filter_manufacturer_id' => $manufacturer_id,
				'filter_sizes'      	 => $sizes,
				'filter_filter'      	 => $filter,
				'filter_shop_id'      	 => $shop_id,
				'filter_attributes' 	 => $attributes,
				'sort'                   => $sort,
				'order'                  => $order,
				'start'                  => ($page - 1) * $limit,
				'limit'                  => $limit
			);
			
			//Если есть назначенные данные для категории
			if(isset($this->request->get['_route_'])){
				$categorize = $this->model_catalog_category->getCategorize($this->request->get['_route_']);
			}

			if(isset($categorize) AND $categorize){
				$this->document->setTitle($categorize['title']);
				$this->document->setDescription(strip_tags($categorize['text2']));
				$this->document->setKeywords($categorize['title']);
				$data['heading_title'] = $categorize['title_h1'];
				$data['description'] = html_entity_decode($categorize['text2'], ENT_QUOTES, 'UTF-8');
				
			}

			//$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
			$product_ids = $this->model_catalog_product->getTotalProductIds($filter_data);
			
			$product_total = count($product_ids);

			$results = $this->model_catalog_product->getProducts($filter_data);
		
			$data['category_alias'] = '';
		
			foreach ($results as $result) {

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
					$rabat = number_format((100 - ((int)$result['price'] / ((int)$result['old_price'] / 100))), '2', '.', '');
				}else{
					$rabat = '';	
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
			
	
				$data['category_alias'] = $result['manufacturer_href'];
	
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'thumb_second'       => $image_second,
					'options'        	=> $options,
					'original_url'      => $result['original_url'],
					'name'        		=> $result['name'],
					'loved'        		=> $result['loved'],
					/*'size'        		=> $result['size'],*/
					'shop_id'        	=> $result['shop_id'],
					'shop_name'        	=> $result['shop_name'],
					'shop_href'        	=> $result['shop_href'],
					'manufacturer_id'   => $result['manufacturer_id'],
					'manufacturer'      => $result['manufacturer'],
					'manufacturer_href'      => $result['manufacturer_href'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'old_price'       => $old_price,
					'rabat'		  => $rabat,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->model_catalog_product->getProductAlias($result['product_id'])
					);
			}

			
			//Если это аякс запрос следующей страницы - можем уже тут и закончить
			if(isset($this->request->post['autoload']) AND $this->request->post['autoload'] == true){
				echo  json_encode($data['products']);
				return true;
			}
			
		
			$url = '';

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));

			sort($limits);
/*
			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&limit=' . $value)
				);
			}
*/
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

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $data['category_alias'] . $url;
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
			
			if (isset($shop_id) AND $shop_id > 0) {
				$this->document->addLink('/'.$manufacturer_info['keyword'], 'canonical');
			}else{
				$this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'], 'SSL'), 'canonical');
			}
			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    //$this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'], 'SSL'), 'canonical');
			} elseif ($page == 2) {
			    //$this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'], 'SSL'), 'prev');
			} else {
			    //$this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&page='. ($page - 1), 'SSL'), 'prev');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    //$this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&page='. ($page + 1), 'SSL'), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$ids = array();
			foreach($product_ids as $row){
				$ids[] = $row['product_id'];
			}
			
			$product_tags = $this->model_catalog_product->getProductsTags($ids);
			
			foreach($product_tags as $find => $replace){

				$data['heading_title'] = str_replace($find, $replace, $data['heading_title']);
				$data['description'] = str_replace($find, $replace, $data['description']);
				$this->document->setTitle(str_replace($find, $replace, $this->document->getTitle()));
				$this->document->setDescription(str_replace($find, $replace, $this->document->getDescription()));
				$this->document->setKeywords(str_replace($find, $replace, $this->document->getKeywords()));
	
			}
	
			$this->document->setParam('no_registration');
			
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
			}
			
			
			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer_info.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/manufacturer_info.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/product/manufacturer_info.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
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
				'href' => $this->url->link('product/manufacturer/info', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}
}
