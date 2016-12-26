<?php
class ControllerAccountMyAccount extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		//Социальные сети
		global $adapters;
		$data['adapters'] = $adapters;
		global $social_images;
		$data['social_images'] = $social_images;
		//==========================================	
	
	
		$this->load->language('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('account/customer');
		$this->load->model('catalog/shops');
		
		$data['customer_info'] = $customer_info= $this->model_account_customer->getCustomer($this->customer->isLogged());
		
		if(isset($customer_info['customer_shop_id'])){
			
			//основные данные по магазину и деньгам
			$data['shop'] = $this->model_catalog_shops->getShop($customer_info['customer_shop_id']);
			
			$money['summ'] = $this->model_catalog_shops->getShopMoneySumm($customer_info['customer_shop_id']);
			$data['shop']['money'] = $money;
				
			$data['ip_list'] = $this->model_catalog_shops->getIgnoreClickIpList($customer_info['customer_shop_id']);
			
			$this->document->setIpList($data['ip_list']);
			$this->document->setMoney($money);
			$this->document->setShop($data['shop']);
		
			//Выбираем продукты
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$url = '';
			
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
				
			}else{
				
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
				$sort = $this->request->get['sort'];
			}else{
				$sort = 'pd.name';
			}

			if (isset($this->request->get['sort_product'])) {
				if($this->request->get['sort_product'] == 'asc'){
					$sort = 'pd.name';	
				}else{
					$sort = 'pd.name_Z';
				}
			}

			if (isset($this->request->get['sort_limit'])) {
				if($this->request->get['sort_limit'] == 'asc'){
					$sort = 'sort_limit_asc';	
				}else{
					$sort = 'sort_limit_desc';
				}
			}

			if (isset($this->request->get['sort_status'])) {
				if($this->request->get['sort_status'] == 'asc'){
					$sort = 'p.status ASC';	
				}else{
					$sort = 'p.status DESC';
				}
			}

			if (isset($this->request->get['sort_views'])) {
				if($this->request->get['sort_views'] == 'asc'){
					$sort = 'p.count_view ASC';	
				}else{
					$sort = 'p.count_view DESC';
				}
			}

		
			if (isset($this->request->get['sort_clicks'])) {
				if($this->request->get['sort_clicks'] == 'asc'){
					$sort = 'sort_clicks_asc';	
				}else{
					$sort = 'sort_clicks_desc';
				}
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
				$order = $this->request->get['order'];
			}else{
				$order = 'pd.name';
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
				$page = (int)$this->request->get['page'];
			}else{
				$page = 1;
			}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
				$limit = (int)$this->request->get['limit'];
			}else{
				$limit = 100;
			}
			
			if (isset($this->request->get['count_day'])) {
				$url .= '&count_day=' . $this->request->get['count_day'];
				$count_day = (int)$this->request->get['count_day'];
			}else{
				$count_day = 30;
			}
			
			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
				$category_id = (int)$this->request->get['category_id'];
			}else{
				$category_id = 0;
			}

			$search = '';
			$filter_data = array(
				'filter_category_id' 	=> $category_id,
				'filter_sub_category' 	=> true,
				'my_accont' 			=> true,
				'filter_shop_id'      	=> $customer_info['customer_shop_id'],
				'filter_name'      		=> $search,
				'status'               	=> 'all',
				'sort'               	=> $sort,
				'order'              	=> $order,
				'start'              	=> ($page - 1) * $limit,
				'limit'              	=> $limit
			);
			
			if(isset($this->request->get['sort_manufacture']) AND $this->request->get['sort_manufacture'] > 0){
				$filter_data['filter_manufacturer_id'] = (int)$this->request->get['sort_manufacture'];
			}

			$data['category_tree'] = $this->model_catalog_category->getCategoryTree();
			
			$data['manufacturer_list'] = $this->model_catalog_shops->getShopManufacturers((int)$customer_info['customer_shop_id']);

			$product_ids = $this->model_catalog_product->getTotalProductIds($filter_data);
			
			$data['total_product_info'] = $total_product_info = $this->model_catalog_product->getTotalProductsInfo($filter_data);
	
			$product_total = count($product_ids);

			$results = $this->model_catalog_product->getProducts($filter_data);
	
			$data['products'] = array();
			
			foreach($results as $result){
				
				$date_v = date('Y-m-d');
				if(isset($result['viewed']) AND $result['viewed']) $date_v = $result['viewed'];
	
				$data['products'][] = array(
					'product_id'  		=> $result['product_id'],
					/*'thumb'       		=> $image,*/
					'viewed'			=> $date_v,
					'count_view'      	=> $result['count_view'],
					'unique_count_view' => $this->model_catalog_product->getProductUniqueClicks($result['product_id']),
					'money_click'      	=> $result['money_click'],
					'money_limit'      	=> $result['money_limit'],
					'original_url'      => $result['original_url'],
					'name'        		=> $result['name'],
					'categories'        => $this->model_catalog_product->getProductCategories($result['product_id']),
					'loved'        		=> $result['loved'],
					'size'        		=> $result['size'],
					'status'        	=> $result['status'],
					'shop_id'        	=> $result['shop_id'],
					'shop_name'        	=> $result['shop_name'],
					'shop_href'        	=> $result['shop_href'],
					'manufacturer_id'   => $result['manufacturer_id'],
					'manufacturer'      => $result['manufacturer'],
					'manufacturer_href' => $result['manufacturer_href'],
					'description' 		=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'rating'      		=> $result['rating'],
					'href'        		=> $this->model_catalog_product->getProductAlias($result['product_id'])
				);
		
			}
	
			$this->load->model('localisation/currency');
			$currency = $this->model_localisation_currency->getCurrencyByCode($this->config->get('config_currency'));
			$data['currency'] = $currency['symbol_right'];
		
	
			//Pagination ==============================================
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

		}
	
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/my_account.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/account.tpl', $data));
		}
	}
	
	public function save_ignore_ip(){
		
		$shop_id = $this->request->post['shop_id'];
		$ip_list = trim($this->request->post['ip_list'],',');
		
		$ip_list_array = explode(',', $ip_list);
		
		$this->load->model('account/customer');
		$this->load->model('catalog/shops');
		$data['customer_info'] = $customer_info= $this->model_account_customer->getCustomer($this->customer->isLogged());
		
		if(isset($customer_info['customer_shop_id'])){
			$shop_info = $this->model_catalog_shops->getShop($customer_info['customer_shop_id']);
			
			//В дальнейшем возможно несколько магазинов у одного человека! Пока тут просто проверка на 				
			if($shop_info['id'] == $shop_id){
				$this->load->model('account/my_account');	
		
				$this->model_account_my_account->saveIpList($shop_id, $ip_list_array);
			}
		
		}
				
	}

	public function set_status_ajax(){
		
		$product_id = $this->request->post['product_id'];
		$status_id = $this->request->post['status_id'];
		
		$this->load->model('catalog/product');
		
		$this->model_catalog_product->setProductStatus($product_id, $status_id);	
	}

	public function set_money_limit_ajax(){
		
		$product_id = $this->request->post['product_id'];
		$money_limit = $this->request->post['money_limit'];
		
		$this->load->model('catalog/product');
		
		$this->model_catalog_product->setProductMoneyLimit($product_id, $money_limit);	
	}

	public function set_money_click_ajax(){
		
		$product_id = $this->request->post['product_id'];
		$money_click = $this->request->post['money_click'];
		
		$this->load->model('catalog/product');
		
		$this->model_catalog_product->setProductMoneyClick($product_id, $money_click);	
	}

	
}
