<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		
		$data['language_href'] = $this->session->data['language_href'];
		
		$this->load->language('common/footer');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

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

		//Получим последние 10 просмотренные пользователем
		$data['viewed_products'] = array();	
		if(isset($_COOKIE['viewed_list'])){
			
			$viewed_list = json_decode($_COOKIE['viewed_list'],true);
			
			if(is_array($viewed_list)){
				
				foreach($viewed_list as $row){
					$data['viewed_products'][] = $this->model_catalog_product->getProduct((int)$row);
				}
				
			}
			
		}
	
		$this->language->load('module/news');
		$data['blog_url'] = $this->url->link('news/ncategory');
		$data['blog_name'] = $this->language->get('text_blogpage');

		$this->load->model('catalog/information');

		$data['$informations'] = array();

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
		
		
		$this->load->model('blog/blog_category');
		$this->load->model('blog/blog');
		$data['blog_main_categories'] = $this->model_blog_blog_category->getBlogCategories(0);
		
		//$data['blogs'] = array();
		
		
		foreach($data['blog_main_categories'] as $key => $row){
	
			$data['blog_main_categories'][$key]['children'] = $this->model_blog_blog->getBlogsByBlogCategoryIdMainInfo($row['blog_category_id']);
	
		}
		
	
		
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

		
		//Товары для сравнения
		$data['compare_products'] = array();
		$data['compare_attribute_groups'] = array();

		if(isset($this->session->data['compare'])){
			foreach ($this->session->data['compare'] as $key => $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);
	
				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_compare_width'), $this->config->get('config_image_compare_height'));
					} else {
						$image = false;
					}
	
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}
	
					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}
	
					if ($product_info['quantity'] <= 0) {
						$availability = $product_info['stock_status'];
					} elseif ($this->config->get('config_stock_display')) {
						$availability = $product_info['quantity'];
					} else {
						$availability = $this->language->get('text_instock');
					}
	
					$attribute_data = array();
	
					$attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);
	
					foreach ($attribute_groups as $attribute_group) {
						foreach ($attribute_group['attribute'] as $attribute) {
							$attribute_data[$attribute['attribute_id']] = $attribute['text'];
						}
					}
	
					$data['compare_products'][$product_id] = array(
						'product_id'   => $product_info['product_id'],
						'name'         => $product_info['name'],
						'thumb'        => $image,
						'price'        => $price,
						'special'      => $special,
						'description'  => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
						'model'        => $product_info['model'],
						'manufacturer' => $product_info['manufacturer'],
						'availability' => $availability,
						'minimum'      => $product_info['minimum'] > 0 ? $product_info['minimum'] : 1,
						'rating'       => (int)$product_info['rating'],
						'reviews'      => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
						'weight'       => $this->weight->format($product_info['weight'], $product_info['weight_class_id']),
						'length'       => $this->length->format($product_info['length'], $product_info['length_class_id']),
						'width'        => $this->length->format($product_info['width'], $product_info['length_class_id']),
						'height'       => $this->length->format($product_info['height'], $product_info['length_class_id']),
						'attribute'    => $attribute_data,
						'href'         => $this->url->link('product/product', 'product_id=' . $product_id),
						'remove'       => $this->url->link('product/compare', 'remove=' . $product_id)
					);
	
					foreach ($attribute_groups as $attribute_group) {
						$data['compare_attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];
	
						foreach ($attribute_group['attribute'] as $attribute) {
							$data['compare_attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
						}
					}
				} else {
					unset($this->session->data['compare'][$key]);
				}
			}
			
			
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
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/common/footer.tpl', $data);
		}
	}
}
