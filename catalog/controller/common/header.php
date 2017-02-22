<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		
		//Префикс языка
		$data['language_href'] = $this->session->data['language_href'];
		
		//Город по ИП
        $ip = $_SERVER['REMOTE_ADDR'];
        $url = 'http://api.sypexgeo.net/xml/'. $ip .'';
        $xml = simplexml_load_string(file_get_contents($url));
        $loc_array = array('lat' => $xml->ip->city->lat,
                           'lon' => $xml->ip->city->lon,
                           );
        
		if($data['language_href']  == ''){
			$loc_array['name'] = $xml->ip->city->name_ru;
		}else{
			$loc_array['name'] = $xml->ip->city->name_en;
		}
		$data['loc_array'] = $loc_array;
		
		if($_SERVER['REMOTE_ADDR'] != '127.0.0.1'){
		
			//Погода
			if($data['language_href'] == ''){
				$api = '//api.openweathermap.org/data/2.5/weather?lat='.$loc_array['lat'].'&lon='.$loc_array['lon'].'&units=metric&lang=ru&apikey=696ae1f68d3357bed87558d884706976';
			}else{
				$api = '//api.openweathermap.org/data/2.5/weather?lat='.$loc_array['lat'].'&lon='.$loc_array['lon'].'&units=metric&lang=en&apikey=696ae1f68d3357bed87558d884706976';
			}
			$data['weather'] = json_decode(file_get_contents($api), true);
		}else{
			$data['weather'] = array('main' => array(
										'temp' => 25,
										'weather' => 'да'
										)
									);
		}
		
		//Получим строку прям из базы
		$this->load->model('design/banner');
		$data['main_top_polosa'] = $this->model_design_banner->getMainTopPolosa();
		
		
		//Урл для блока выбора языка
		if(isset($this->request->get['_route_'])){
			$data['url_no_lang'] = str_replace($this->session->data['language'].'/','/',$this->request->get['_route_']);
		}else{
			$data['url_no_lang'] = '/';
		}
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();
	
		$this->load->model('localisation/currency');
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();
		$data['currency'] = $this->load->controller('common/currency');
		$data['currency_line'] = $this->model_localisation_currency->getCurrenciesLine();
		
		
		//$this->load->model('catalog/shop');
		//$data['shops'] = $this->model_catalog_shop->getShops();
		
	 	//$this->load->model('catalog/manufacturer');
		//$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
		
		$this->load->model('catalog/information');
		$data['menu']['shops'] = $this->model_catalog_information->getInformationMenuInformation(25);
		$data['menu']['manufacterers'] = $this->model_catalog_information->getInformationMenuInformation(26);
		$data['menu']['contact'] = $this->model_catalog_information->getInformationMenuInformation(27);
		$data['menu']['wishlist'] = $this->model_catalog_information->getInformationMenuInformation(28);
		
		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		
		
		//Социальные сети
		global $adapters;
		$data['adapters'] = $adapters;
		global $social_images;
		$data['social_images'] = $social_images;
		//==========================================	
		
		
		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('analytics/' . $analytic['code']);
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();
		$data['meta_teg'] = $this->document->getMetaTeg();
		//$data['shop'] = $this->document->getShop();

		if(isset($this->request->get['category_id'])){
			$data['category_id'] = $this->request->get['category_id'];
		}else{
			$data['category_id'] = 0;
		}

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = $this->document->getCategoryMenu();

		$data['category_path'] =$this->model_catalog_category->getCategoryPath($data['category_id']);
		
		
		
		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['money'] = $this->document->getMoney();
		$data['param'] = $this->document->getParam();
		$data['ip_list'] = $this->document->getIpList();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['extra_tags'] = $this->document->getExtraTags();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');
	
	$data['cart_products_total'] = $this->cart->countProducts();
	$data['language_href'] = $this->session->data['language_href'];
	
		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');

		$data['text_alert_copy'] = $this->language->get('text_alert_copy');
		$data['text_cookies_off_copy'] = $this->language->get('text_cookies_off_copy');
		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_search'] = $this->language->get('text_search');
		$data['text_search_legend'] = $this->language->get('text_search_legend');
		$data['text_search_submit_button'] = $this->language->get('text_search_submit_button');
		$data['text_cart_title'] = $this->language->get('text_cart_title');
		$data['text_cart_qty'] = $this->language->get('text_cart_qty');
		$data['text_login_enter'] = $this->language->get('text_login_enter');
		$data['text_email_required'] = $this->language->get('text_email_required');
		$data['text_pass_required'] = $this->language->get('text_pass_required');
		$data['text_pass'] = $this->language->get('text_pass');
		$data['text_rememberme'] = $this->language->get('text_rememberme');
		$data['text_wanted_spam'] = $this->language->get('text_wanted_spam');
		$data['text_privacy_box_1'] = $this->language->get('text_privacy_box_1');
		$data['text_privacy_box_2'] = $this->language->get('text_privacy_box_2');
		$data['text_enter'] = $this->language->get('text_enter');
		$data['text_enter_to_account'] = $this->language->get('text_enter_to_account');
		$data['text_qtn'] = $this->language->get('text_qtn');
		$data['text_total'] = $this->language->get('text_total');
		$data['text_content_asset'] = $this->language->get('text_content_asset');
		$data['text_register_now'] = $this->language->get('text_register_now');
		$data['text_make_account_now'] = $this->language->get('text_make_account_now');
		$data['text_forgotten_pass'] = $this->language->get('text_forgotten_pass');
		$data['text_next'] = $this->language->get('text_next');
		$data['text_cookie_error'] = $this->language->get('text_cookie_error');

		$data['text_email'] = $this->language->get('text_email');
$data['text_password_reset'] = $this->language->get('text_password_reset');
$data['text_i_remember_password'] = $this->language->get('text_i_remember_password');
$data['text_reestablish'] = $this->language->get('text_reestablish');
$data['text_name'] = $this->language->get('text_name');
$data['text_register_new_buyer'] = $this->language->get('text_register_new_buyer');
$data['text_register_new_wholesale_buyer'] = $this->language->get('text_register_new_wholesale_buyer');
$data['text_sign_up'] = $this->language->get('text_sign_up');
$data['text_cabinet'] = $this->language->get('text_cabinet');
$data['text_enter_in_account'] = $this->language->get('text_enter_in_account');
$data['text_back_to_shopping'] = $this->language->get('text_back_to_shopping');
$data['text_go_back'] = $this->language->get('text_go_back');
$data['text_error_name'] = $this->language->get('text_error_name');
$data['text_error_email'] = $this->language->get('text_error_email');
$data['text_error_password'] = $this->language->get('text_error_password');
$data['text_error_password_confirm'] = $this->language->get('text_error_password_confirm');
$data['text_error_form_valid'] = $this->language->get('text_error_form_valid');
$data['text_cart'] = $this->language->get('text_cart');
$data['text_wishlist'] = $this->language->get('text_wishlist');
$data['text_service_center'] = $this->language->get('text_service_center');
$data[''] = $this->language->get('');
$data[''] = $this->language->get('');


		$data['language_href'] = $this->session->data['language_href'];
		$data['language_code'] = $this->session->data['language'];
		
		$data['currency_text'] 			= $this->language->get('currency_text');
		$data['country_language_text'] 	= $this->language->get('country_language_text');
		$data['text_select_currency'] 	= $this->language->get('text_select_currency');
	

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');
			$this->load->model('account/customer');
			$this->load->model('catalog/shops');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
			
			$data['customer_info'] = $customer_info = $this->model_account_customer->getCustomer($this->customer->isLogged());
		
			if(isset($customer_info['customer_shop_id'])){
				//основные данные по магазину и деньгам
				$data['shop'] = $this->model_catalog_shops->getShop($customer_info['customer_shop_id']);
				$this->document->setShop($data['shop']);
			}
			
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['logged'] = $this->customer->isLogged();
	
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['login'] = $this->url->link('account/login', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

	$data['text_sale'] = $this->language->get('text_sale');
	$data['text_brands'] = $this->language->get('text_brands');

	if(!$this->document->isSale() AND isset($this->request->get['category_id'])){
		unset($data['text_sale']);
	}
	
		
		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

	
	

		$data['language'] = $this->load->controller('common/language');
		//$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');
		$data['cart_array'] = $this->load->controller('common/cart/getArray');
		
		if ($this->config->get('ncategory_bnews_top_link')) {
			$this->language->load('module/news');
			$blog_url = $this->url->link('news/ncategory');
			$blog_name = $this->language->get('text_blogpage');
			if (isset($data['categories']) && count($data['categories'])) {
				$data['categories'][] = array(
					'name'     => $blog_name,
					'children' => array(),
					'column'   => 1,
					'href'     => $blog_url
				);
			}
		}
		
		if($this->customer->isLogged()){
			$data['total_viewed_products'] = (int)$this->model_catalog_product->getTotalViewedProducts();
			if($data['total_viewed_products'] > 99){
				$data['total_viewed_products'] = '99';
			}if($data['total_viewed_products'] < 0){
				$data['total_viewed_products'] = '';
			}
			
			$data['total_loved_products'] = (int)$this->model_catalog_product->getTotalLovedProducts();
			if($data['total_loved_products'] > 99){
				$data['total_loved_products'] = '99';
			}elseif($data['total_loved_products'] < 1){
				$data['total_loved_products'] = '';
			}
		}else{
			$data['total_viewed_products'] = $data['total_loved_products'] = 0;
		}
		
		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
		} else {
			return $this->load->view('default/template/common/header.tpl', $data);
		}
	}
}
