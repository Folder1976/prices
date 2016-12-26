<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['scripts'] = $this->document->getScripts('footer');

		//Урл для блока выбора языка
		if(isset($this->request->get['_route_'])){
			$data['url_no_lang'] = str_replace($this->session->data['language'].'/','/',$this->request->get['_route_']);
		}else{
			$data['url_no_lang'] = '/';
		}
		
		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');

		$data['text_country'] = $this->language->get('text_country');
		$data['text_change'] = $this->language->get('text_change');
		$data['text_select_country'] = $this->language->get('text_select_country');
		$data['text_language'] = $this->language->get('text_language');
		$data['text_select_language'] = $this->language->get('text_select_language');
		$data['text_more_country'] = $this->language->get('text_more_country');
		$data['text_customer_care'] = $this->language->get('text_customer_care');

		$data['language_href'] = $this->session->data['language_href'];
		$data['language_code'] = $this->session->data['language'];
		
		$data['currency_text'] 			= $this->language->get('currency_text');
		$data['country_language_text'] 	= $this->language->get('country_language_text');
		$data['text_select_currency'] 	= $this->language->get('text_select_currency');
		//$data['currency_text'] 	= $this->language->get('currency_text');



		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $result['keyword'] //$this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

				$data['categories'] = array();

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');
		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			//if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);
				foreach ($children as $child) {
					if($child['is_menu'] == 1){
						
						$children2 = $this->model_catalog_category->getCategories($child['category_id']);
						$children_data2 = array();
						foreach ($children2 as $child2) {
							if($child2['is_menu'] == 1){
								$filter_data2 = array(
									'filter_category_id'  => $child2['category_id'],
									'filter_sub_category' => true
								);
								
								$children_data2[] = array(
									'category_id'	=> $child2['category_id'],
									'name'  => $child2['name'],// . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data2) . ')' : ''),
									'href'  => $this->model_catalog_category->getCategoryAlias($child2['category_id'])
								);
							}
						}
						
						$filter_data = array(
							'filter_category_id'  => $child['category_id'],
							'filter_sub_category' => true
						);
	
						$children_data[] = array(
							'category_id'	=> $child['category_id'],
							'name'  => $child['name'],// . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
							'href'  => $this->model_catalog_category->getCategoryAlias($child['category_id']),
							'children' => $children_data2,
						);
					
					}
				}

				// Level 1
				if($category['is_menu'] == 1){
					$data['categories'][] = array(
						'category_id'	=> $category['category_id'],
						'name'     => $category['name'],
						'column'   => $category['column'] ? $category['column'] : 1,
						'href'     => $this->model_catalog_category->getCategoryAlias($category['category_id']),
						'children' => $children_data
					);
				}
			//}
		}

		$this->document->setCategoryMenu($data['categories']);
		
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();
	
		$this->load->model('localisation/currency');
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();
		$data['currency'] = $this->load->controller('common/currency');
	
		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/common/footer.tpl', $data);
		}
	}
}
