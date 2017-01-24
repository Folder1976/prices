<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		$this->load->model('catalog/product');
		$product_tags = $this->model_catalog_product->getProductsTags(array(0=>0));
	
		$this->load->model('localisation/currency');
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();
	
		foreach($product_tags as $find => $replace){

			$this->document->setTitle(str_replace($find, $replace, $this->document->getTitle()));
			$this->document->setDescription(str_replace($find, $replace, $this->document->getDescription()));
			$this->document->setKeywords(str_replace($find, $replace, $this->document->getKeywords()));

		}
		
		//Получим последние 10 просмотренные пользователем
		$data['customer_viewed_products'] = array();	
		if(isset($_COOKIE['customer_viewed_products'])){
			
			$viewed_list = json_decode($_COOKIE['customer_viewed_products'],true);
			
			if(is_array($viewed_list)){
				
				foreach($viewed_list as $row){
					$data['customer_viewed_products'][] = $this->model_catalog_product->getProduct((int)$row);
				}
				
			}
			
		}
		
		
		
		//Получим 20 самых просматриваемых
		$filter_data = array(
				'filter_category_id' 	=> 0,
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
		
		//Массив магазинов
		$this->load->model('catalog/shop');
		$data['shops'] = $this->model_catalog_shop->getShops();
		
		//Массив Брендов
	 	$this->load->model('catalog/manufacturer');
		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
		

		
		
		$data['description'] = html_entity_decode($this->config->get('config_comment'), ENT_QUOTES, 'UTF-8');
		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		/*
		$this->load->model('catalog/mainmenu');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('catalog/manufacturer');
		$this->load->model('design/banner');
		$this->load->model('catalog/shops');

		$left_menu = $this->model_catalog_mainmenu->getLeftMenuCategory();
		$left_menu_categorys = array();
		foreach($left_menu as $row){
			
			$tmp = $row['params'];
			if(strpos($tmp, '##') !== false){
				$tmp = explode('##', $tmp);
				$params = $tmp[0];
				$name = $tmp[1];
			}else{
				$params = $tmp;
				$name = '';
			}
			
			$category_info = $this->model_catalog_category->getCategory((int)$params);
		
			if($name != ''){
				$category_info['name'] = $name;
			}
			
			$left_menu_categorys[$row['params']]['name'] = $category_info['name'];
			$left_menu_categorys[$row['params']]['href'] = $this->model_catalog_category->getCategoryAlias((int)$params);;
		}
		
		//Получим назначеный на страницу магазин
		$shop_id = $this->model_catalog_shops->getMainPageShopId();
		
		//Если нет назначенного магазина - возьмем его по популярному товару		
		if($shop_id){
			//$product_id = $this->model_catalog_product->getSuperViewProduct(1, $shop_id);
			//$product = $this->model_catalog_product->getProduct($product_id[0]['product_id']);
		}else{
			$product_id = $this->model_catalog_product->getSuperViewProduct(1);
			$product = $this->model_catalog_product->getProduct($product_id[0]['product_id']);
			$shop_id = $product['shop_id'];
		}
		
		$data['shop'] = $this->model_catalog_shops->getShop($shop_id);
		$products = $this->model_catalog_product->getSuperViewProduct(4, $shop_id);

		//Создаем список продаваемых продуктов
		$viewed_products = array();
		foreach($products as $product){
			$result = $this->model_catalog_product->getProduct($product['product_id']);
			
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			}
			
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
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

			$viewed_products[] = array(
							'product_id'  => $result['product_id'],
							'thumb'       => $image,
							'original_url'      => $result['original_url'],
							'name'        		=> $result['name'],
							'shop_id'        	=> $result['shop_id'],
							'shop_name'        	=> $result['shop_name'],
							'shop_href'        	=> $result['shop_href'],
							'manufacturer_id'   => $result['manufacturer_id'],
							'manufacturer'      => $result['manufacturer'],
							'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
							'price'       => $price,
							'special'     => $special,
							'tax'         => $tax,
							'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
							'rating'      => $result['rating'],
							'href'        => $this->model_catalog_product->getProductAlias($result['product_id'])
							);
		}
		
		$data['viewed_products'] = $viewed_products;
		unset($viewed_products);
	*/	
		
		
		//$data['left_category'] = $left_menu_categorys;
		$data['large_banners'] = $this->model_design_banner->getBannerLargeAll();
		//$data['large_banner'] = $this->model_design_banner->getBannerLarge();
		//$data['medium_banners'] = $this->model_design_banner->getBannerMediumAll();
		//$data['medium_banners'] = $this->model_design_banner->getBannerRandom('medium', 3);
		//$data['season_products'] = $this->model_design_banner->getBannerRandom('season_pro', 5);
		//$data['manufacturer_baners'] = $this->model_catalog_manufacturer->getManufacturerBanner();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}