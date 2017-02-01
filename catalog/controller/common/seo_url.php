<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		
		//Если прилетел мусор в УРЛ (-)
		if (isset($this->request->get['_route_']) AND substr($this->request->get['_route_'], -1, 1) == '-') {
	
			$redirect = trim($this->request->get['_route_'], '-');

			if($redirect == '') $redirect = '/';
			header('HTTP/1.1 301 Moved Permanently');
			header("Location: ".$redirect ."");
			exit(0);
		}

		
		//Смена языка
		// перенесено в index.php
		$this->session->data['language_href'] = '';
		if(isset($this->request->get['_route_']) AND $this->session->data['language'] != 'ru'){
				
			$this->request->get['_route_'] = str_replace($this->session->data['language'].'/','',$this->request->get['_route_']);
			$this->session->data['language_href'] = $this->session->data['language'].'/';
			
		}



		//Если прилетела смена валюты
		if (isset($this->request->get['currency'])) {
			
			$this->currency->set($this->request->get['currency']);

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			
			if(isset($_SERVER['REDIRECT_URL'])){
				$redirect = $_SERVER['REDIRECT_URL'];
			}else{
				$redirect = '';
			}
			
			if($redirect == '') $redirect = '/';
			header('HTTP/1.1 301 Moved Permanently');
			header("Location: ".$redirect ."");
			exit(0);
		}

	
		//Статичные Алиасы без обращения в базу
		if(isset($this->request->get['_route_'])){
			
			$redirect = array(
							  'forgotten_pass'=>'account/forgotten',
							  'register'=>'account/register',
							  'cart'=>'common/cart/info',
							  'brands'=>'product/manufacturer',
							  'contact_us'=>'information/contact',
							  'account'=>'account/account',
							  'order'=>'account/order',
							  'wishlist'=>'account/wishlist',
							  'newsletter'=>'account/newsletter',
							  );
			
			if(isset($redirect[$this->request->get['_route_']])){
				$this->request->get['route'] = $redirect[$this->request->get['_route_']];
			}
			
			if(isset($this->request->get['route'])){
				return new Action($this->request->get['route']);
			}
			
		}

		
		
	
		//Уберем ошибки и дубляжи
		if(isset($this->request->get['_route_'])){
			
			$tmp = str_replace('://', '', $this->request->get['_route_']);
			
			if(strpos($tmp, '//') !== false){
				$this->request->get['_route_'] = str_replace('http://','##$$##', $this->request->get['_route_']);	
				$this->request->get['_route_'] = str_replace('//','/', $this->request->get['_route_']);
				$this->request->get['_route_'] = str_replace('##$$##', 'http://',$this->request->get['_route_']);	
		
				header('HTTP/1.1 301 Moved Permanently');
				header("Location: ".$this->request->get['_route_'] ."");
				exit(0);
			}
	
		}
		//Проверяем или это не город в адресной строке
		$pach_city = '';
		if(isset($this->request->get['_route_'])){
			
			$sql = 'SELECT Domain FROM '.DB_PREFIX.'citys WHERE IsDomain="0";';
			$query = $this->db->query($sql);
			foreach($query->rows as $row){
				if(strpos($this->request->get['_route_'], $row['Domain']) !== false){
					$pach_city = $row['Domain'].'/';
				}
			}
			
			if($pach_city != ''){
				$this->request->get['_route_'] = str_replace($pach_city.'', '', $this->request->get['_route_']);
				$_GET['_route_'] = $this->request->get['_route_'];
				$this->document->setPathDomain(str_replace('/','',$pach_city));
				define('TMP_URL', TMP_URL_1.$pach_city);
			}
			
		}
		
		if($pach_city == ''){
			$domain = explode('.', $_SERVER['HTTP_HOST']);
			if($domain[0] == 'shopsplum' OR $domain[0] == ''){
				$domain[0] = 'moscow';
			}
			$this->document->setPathDomain(str_replace('/','',$domain[0]));
		}
		
		//Если не прилетел домен - Определим главный суффикс
		if(!defined('TMP_URL')) define('TMP_URL', TMP_URL_1);

		//Залетает иногда пустая страница
		if(isset($_GET['page']) AND !is_numeric($_GET['page'])){
			unset($_GET['page']);
			
			$get = '';
			foreach($_GET as $index => $value){
				if($index != '_route_'){
					$get .= $index.'='.$value.'&';
				}
			}
			
			if(strlen($get) > 0){
				$get = '?'.trim($get, '&');
			}
			
			if(isset($this->request->get['_route_'])){
				$get = '/'.$this->request->get['_route_'].$get;
			}
			
			header('HTTP/1.1 301 Moved Permanently');
			header("Location: http://".$_SERVER['SERVER_NAME'] . $get . "");
			exit(0);
			
		}
	
		//Два слеша
		if(strpos($_SERVER['REQUEST_URI'], '//') !== false){
			
			header('HTTP/1.1 301 Moved Permanently');
			header("Location: http://".$_SERVER['SERVER_NAME'] ."");
			exit(0);
			
		}
		
		
		//Обрежем динамическую приставку языка
		if(isset($this->request->get['_route_'])){
			
			$this->request->get['_route_'] = str_replace(TMP_URL,'/', $this->request->get['_route_']);
	
		}
	
	    //В самом начале - не прилетел ли нам логин из социалки!!! ===========================================
		global $user;
		
		//if($this->request->get['_route_']){
			//header('HTTP/1.1 301 Moved Permanently');
			//header("Location: /?");
			//exit(0);
		//}

		if(isset($user) AND is_array($user) AND isset($user['id']) AND strlen($user['id']) > 0){
	
			if(isset($this->request->get['provider'])){
				unset($sql);
				
				//Если пользователь залогинен - обновим информацию о социалке
				if ($this->customer->isLogged()) {
					
					if($this->request->get['provider'] == 'facebook'){
						$sql = 'UPDATE ' . DB_PREFIX . 'customer SET social_fb = "'.$this->db->escape($user['id']).'"  WHERE customer_id = "'.$this->customer->isLogged().'"';
					}elseif($this->request->get['provider'] == 'vk'){
						$sql = 'UPDATE ' . DB_PREFIX . 'customer SET social_vk = "'.$this->db->escape($user['id']).'"  WHERE customer_id = "'.$this->customer->isLogged().'"';
					}elseif($this->request->get['provider'] == 'google'){
						$sql = 'UPDATE ' . DB_PREFIX . 'customer SET social_go = "'.$this->db->escape($user['id']).'"  WHERE customer_id = "'.$this->customer->isLogged().'"';
					}
					
					if(isset($sql)){
						$this->db->query($sql);
						header('HTTP/1.1 301 Moved Permanently');
						header("Location: ".HTTP_SERVER.TMP_DIR."");
						exit(0);
					}
				}else{
					//Если нет логина - ищем пользователя
					if($this->request->get['provider'] == 'facebook'){
						
						$sql = 'SELECT customer_id, firstname, lastname FROM ' . DB_PREFIX . 'customer WHERE social_fb = "'.$this->db->escape($user['id']).'" LIMIT 0, 1;';
						$this->request->post['social_fb'] = $user['id'];
						$this->request->post['social_vk'] = '';
						$this->request->post['social_go'] = '';
							
					}elseif($this->request->get['provider'] == 'vk'){
						
						$sql = 'SELECT customer_id, firstname, lastname FROM ' . DB_PREFIX . 'customer WHERE social_vk = "'.$this->db->escape($user['id']).'" LIMIT 0, 1;';
						$this->request->post['social_fb'] = '';
						$this->request->post['social_vk'] = $user['id'];
						$this->request->post['social_go'] = '';
						
					}elseif($this->request->get['provider'] == 'google'){
						
						$sql = 'SELECT customer_id, firstname, lastname FROM ' . DB_PREFIX . 'customer WHERE social_go = "'.$this->db->escape($user['id']).'" LIMIT 0, 1;';
						$this->request->post['social_fb'] = '';
						$this->request->post['social_vk'] = '';
						$this->request->post['social_go'] = $user['id'];
						
					}
					
					//Если выбранная сеть
					if(isset($sql)){
						
						$name = '';
						
						$query = $this->db->query($sql);
				
						if($query->num_rows){
							$customer_id = $query->row['customer_id'];
							$name = $query->row['firstname'] . ' ' . $query->row['lastname'];
						
						}else{
							
							$this->load->model('account/customer');
							
							$first = '';
							$last = '';
							
							if(isset($user['name'])){
								if(strpos($user['name'], ' ') !== false){
									$tmp = explode(' ', $user['name']);
									$first = $tmp[0];
									$last = $tmp[1];
								}else{
									$first = $user['name'];
									$last = $user['name'];
								}
							}
							
							$this->request->post['email'] = '';
							$this->request->post['password'] =  sha1(date('Y-m-d H:i:s'));
							$this->request->post['firstname'] = $first;
							$this->request->post['lastname'] = $last;
							$this->request->post['telephone'] = '';
							$this->request->post['address_1'] = '';
							$this->request->post['city'] = '';
							$this->request->post['fax'] = '';
							$this->request->post['company'] = '';
							$this->request->post['address_2'] = '';
							$this->request->post['postcode'] = '';
					
							$this->request->post['country_id'] = '';
					
							$this->request->post['zone_id'] = '';
					
							$customer_id = $this->model_account_customer->addCustomer($this->request->post);
							
						}
						
						$this->load->model('account/activity');
	
						$activity_data = array(
							'customer_id' => $customer_id,
							'name'        => $name
						);
			
						
						$this->customer->login($customer_id, 'vdsfluighLKSSAS45F9tG85pE3upEREsdoru');
						$this->model_account_activity->addActivity('login', $activity_data);
						
						$this->event->trigger('post.customer.login');
						
						header('HTTP/1.1 301 Moved Permanently');
						header("Location: /".TMP_DIR."");
						exit(0);
					
					}
				}
			}
			
		}
		
		//Account
		if(isset($this->request->get['_route_']) AND $this->request->get['_route_'] == 'my_account'){
			
			$this->request->get['route'] = 'account/my_account';
			return new Action($this->request->get['route']);
	
		}
	
	
		//Первым делом проверяем не редирект ли это )
		if (isset($_SERVER['REQUEST_URI']) AND $_SERVER['REQUEST_URI'] != '') {
			
			$sql = "SELECT url_to FROM " . DB_PREFIX . "redirect WHERE upper(url_from) LIKE '" . strtoupper($this->db->escape(ltrim($_SERVER['REQUEST_URI'],'/'))) . "' LIMIT 0,1;";
			
			$query = $this->db->query($sql);
			
			if($query->num_rows){
				//echo $query->row['url_to']; die();
				header('HTTP/1.1 301 Moved Permanently');
				header("Location: /".$query->row['url_to']."", true, 301);
				exit(0);
			}
			
		}
	
		//Вертолет
		if(isset($this->request->get['_route_']) AND $this->request->get['_route_'] != ''){
			
			$s = @eregi("-[0-9]*click",$this->request->get['_route_'],$regs);
		
			if(isset($regs[0]) AND $regs != ''){
				$this->request->get['helikopter'] = (int)str_replace('click','',ltrim($regs[0],'-'));
				$_GET['_route_'] = $this->request->get['_route_'] = str_replace($regs[0],'', $this->request->get['_route_']);
			}
		}
		
		//Сортировка
		$this->request->get['sort'] = $_GET['sort'] = '';
		if (isset($this->request->get['_route_'])) {
			$tmps = explode('-',$this->request->get['_route_']);
			
			foreach($tmps as $tmp){
				if($tmp == 'viewed'){
					
					$this->request->get['sort'] = $_GET['sort'] = 'viewed';
					
				}elseif($tmp == 'cheap'){
					
					$this->request->get['sort'] = $_GET['sort'] = 'cheap';	
			
				}elseif($tmp == 'sale'){
					
					$this->request->get['sort'] = $_GET['sort'] = 'sale';	
			
				}elseif($tmp == 'expensive'){
				
					$this->request->get['sort'] = $_GET['sort'] = 'expensive';	
				
				}
			}
			$this->request->get['_route_'] = str_replace(array('viewed-'),'',$this->request->get['_route_']);
			
		}

		//Тут установим язык по умолчанию
		//$this->config->set('config_language_id',1);
		
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}
		
		//Если прилетел поиск
		if (isset($this->request->get['search'])) {
			$this->request->get['route'] = 'product/category';
			return new Action($this->request->get['route']);
		}
		

		//Если нам прилетело чтото в ГЕТ кроме _roure_
		if(isset($_GET) AND count($_GET) > 1 AND !isset($GET['reload']) AND isset($_GET['_route_']) AND false){
			$route = $_GET['_route_'];
			$add_alias = '';
	
			//Найдем реальный урл категории
			$categs = explode('-', $route);
			foreach($categs as $item){
				
				$sql = "SELECT query FROM " . DB_PREFIX . "url_alias WHERE keyword LIKE '" . $this->db->escape($route) . "' AND `query` LIKE 'category_id=%' LIMIT 0,1;";
			
				$query = $this->db->query($sql);
				if($query->num_rows){
					
					$url = explode('=', $query->row['query']);
					$this->request->get['category_id'] = $url[1];
					$this->request->get['path'] = true;
					$this->request->get['route'] = 'product/category';
					break;
				}else{
					$route = str_replace($item.'-', '', $route);
				}
					
			}

			$params = '';
			foreach($_GET as $get => $value){
				
				if($get != '_route_' AND $get != 'filter'){

					if($get != 'search' AND
						$get != 'email' AND
						$get != 'password' AND
							$get != 'sort' AND
							$get != 'order' AND
							$get != 'price_from' AND
							$get != 'price_to' AND
							$get != 'limit' AND
							$get != 'autoload' AND
								$get != 'page'){
						
						$add_alias .= $get.'-';
						$route = str_replace($get.'-','', $route);
						unset($_GET[$get]);
						
					}else{
						if($get != 'sort'){
							$params .= $get.'='.$value.'&';
						}
					}

				}
			}
			


			$params = trim($params, '&');
			//$add_alias .= $this->request->get['_route_'];

			if($add_alias != '' OR isset($_GET['filter'])){
				if(isset($params) AND $params != ''){
					header("Location: http://". $_SERVER['HTTP_HOST'].'/'.TMP_URL.$add_alias.$route.'?'.$params, true);
				}else{
					header("Location: http://". $_SERVER['HTTP_HOST'].'/'.TMP_URL.$add_alias.$route, true);	
				}
			}

			if (isset($this->request->get['route'])) {
				//return new Action($this->request->get['route']);
			}
			
		}
		//end Если нам прилетело чтото в ГЕТ кроме _roure_
		
		//А это блог Новостей
		if (isset($this->request->get['_route_'])) {
			$blog_headlines = $this->config->get('ncategory_bnews_headlines_url') ? $this->config->get('ncategory_bnews_headlines_url') : 'blog-headlines';
			
			$blogparts = explode('/', $this->request->get['_route_']);
			
			if (utf8_strlen(end($blogparts)) == 0) {
				array_pop($blogparts);
			}

			
			foreach ($blogparts as $part) {
					/* default article seo urls */
					if (strpos($part, 'blogcat') === 0) {
						$ncatid = (int)str_replace("blogcat", "", $part);
						if (!isset($this->request->get['ncat'])) {
							$this->request->get['ncat'] = $ncatid;
						} else {
							$this->request->get['ncat'] .= '_' . $ncatid;
						}
					}
					if (strpos($part, 'blogart') === 0) {
						$this->request->get['news_id'] = (int)str_replace("blogart", "", $part);
					}
					if (strpos($part, 'blogauthor') === 0) {
						$this->request->get['author'] = (int)str_replace("blogauthor", "", $part);
					}
					if (strpos($part, 'blogarchive-') === 0) {
						$this->request->get['archive'] = (string)str_replace("blogarchive-", "", $part);
					}
					/* end of default article urls */
				$query     =     $this->db->query( " SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "' " );
				
				if ($part == $blog_headlines) {
					$query->num_rows = true;
					$query->row['query'] = "-=-";
				}

				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					/* custom article urls */
					if ($url[0] == 'news_id') {
						$this->request->get['news_id'] = $url[1];
					}
					if ($url[0] == 'nauthor_id') {
						$this->request->get['author'] = $url[1];
					}
					if ($url[0] == 'ncategory_id') {
						if (!isset($this->request->get['ncat'])) {
							$this->request->get['ncat'] = $url[1];
						} else {
							$this->request->get['ncat'] .= '_' . $url[1];
						}
					}
					/* end of custom article urls */
				}
			}
			if (!isset($this->request->get['route']) || (isset($this->request->get['route']) && $this->request->get['route'] == "error/not_found")) {
					
				if (isset($this->request->get['news_id'])) {
					$this->request->get['route'] = 'news/article';
				} elseif (isset($this->request->get['ncat']) || isset($this->request->get['author']) || $this->request->get['_route_'] ==  $blog_headlines || isset($this->request->get['archive'])) {
					$this->request->get['route'] = 'news/ncategory';
				}
			}
        }
		//end А это блог Новостей2
		
		//А это блог Новостей
		if (isset($this->request->get['_route_'])) {
			$blog_headlines = $this->config->get('ncategory_bnews_headlines_url') ? $this->config->get('ncategory_bnews_headlines_url') : 'blog-headlines';
			
			$blogparts = explode('/', $this->request->get['_route_']);
			
			if (utf8_strlen(end($blogparts)) == 0) {
				array_pop($blogparts);
			}

			
			foreach ($blogparts as $part) {
					/* default article seo urls */
					if (strpos($part, 'blogcat') === 0) {
						$ncatid = (int)str_replace("blogcat", "", $part);
						if (!isset($this->request->get['ncat'])) {
							$this->request->get['ncat'] = $ncatid;
						} else {
							$this->request->get['ncat'] .= '_' . $ncatid;
						}
					}
					if (strpos($part, 'blogart') === 0) {
						$this->request->get['news_id'] = (int)str_replace("blogart", "", $part);
					}
					if (strpos($part, 'blogauthor') === 0) {
						$this->request->get['author'] = (int)str_replace("blogauthor", "", $part);
					}
					if (strpos($part, 'blogarchive-') === 0) {
						$this->request->get['archive'] = (string)str_replace("blogarchive-", "", $part);
					}
					/* end of default article urls */
				$query     =     $this->db->query( " SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "' " );
				
				if ($part == $blog_headlines) {
					$query->num_rows = true;
					$query->row['query'] = "-=-";
				}

				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					/* custom article urls */
					if ($url[0] == 'news_id') {
						$this->request->get['news_id'] = $url[1];
					}
					if ($url[0] == 'nauthor_id') {
						$this->request->get['author'] = $url[1];
					}
					if ($url[0] == 'ncategory_id') {
						if (!isset($this->request->get['ncat'])) {
							$this->request->get['ncat'] = $url[1];
						} else {
							$this->request->get['ncat'] .= '_' . $url[1];
						}
					}
					/* end of custom article urls */
				}
			}
			if (!isset($this->request->get['route']) || (isset($this->request->get['route']) && $this->request->get['route'] == "error/not_found")) {
					
				if (isset($this->request->get['news_id'])) {
					$this->request->get['route'] = 'news/article';
				} elseif (isset($this->request->get['ncat']) || isset($this->request->get['author']) || $this->request->get['_route_'] ==  $blog_headlines || isset($this->request->get['archive'])) {
					$this->request->get['route'] = 'news/ncategory';
				}
			}
			
			if (isset($this->request->get['route'])) {
			
				return new Action($this->request->get['route']);
				die();
			}
			
        }
		//end А это блог Новостей
		
		
		//Проверим блоги статей
		if(isset($this->request->get['_route_'])){
			
			if ($this->request->get['_route_'] ==  'blog_home') { 
				$this->request->get['route'] = 'blog/home';
			}else{
				
				$sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($this->request->get['_route_']) . "' AND (`query` LIKE 'blog_id=%' OR `query` LIKE 'blog_category_id=%') LIMIT 0,1;";
				$query = $this->db->query($sql);
				//echo $query->num_rows; die($sql);
				
				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					
					if ($url[0] && $url[1]){
						if ($url[0] == 'blog_id') {$this->request->get['blog_id'] = $url[1]; }
						if ($url[0] == 'blog_category_id') {
							if (!isset($this->request->get['blogpath'])) {
								$this->request->get['blogpath'] = $url[1];
							} else {
								$this->request->get['blogpath'] .= '_' . $url[1];
							}
						}
					
						if (isset($this->request->get['blog_id'])) {
							$this->request->get['route'] = 'blog/blog';
						} elseif (isset($this->request->get['blogpath'])) {
							$this->request->get['route'] = 'blog/category';
						}
					}	
				}		
			}
				
				if (isset($this->request->get['route'])) {
			
					return new Action($this->request->get['route']);
					die();
				}
				
		}
		//Проверим магазин - Он без фильтров
		if(isset($this->request->get['_route_'])){
			
			$sql = "SELECT id AS shop_id FROM " . DB_PREFIX . "shop WHERE href = '" . $this->db->escape($this->request->get['_route_']) . "' LIMIT 0,1;";
			$query = $this->db->query($sql);
		
			if ($query->num_rows) {
			
				$this->request->get['shop_id'] = $_GET['shop_id'] = $shop_id = $query->row['shop_id'];
				$this->request->get['route'] = 'product/manufacturer/info';
				return new Action($this->request->get['route']);
			
			}
		
		}

		
		//Если фиксированные ЧПУ
		/*
		if (isset($this->request->get['_route_'])) {
			if (isset($this->request->get['_route_'] == 'lovedproducts') {	
				$this->request->get['route'] = 'product/category';
			} elseif ($this->request->get['_route_'] == 'last-viewed'){
				$this->request->get['route'] = 'product/category';
			}
			
			if (isset($this->request->get['route'])) {
				return new Action($this->request->get['route']);
			}
		}
		*/

		// Decode URL
		if (isset($this->request->get['_route_']) AND $this->request->get['_route_'] != '' AND $this->request->get['_route_'] != '/') {
			
			$this->request->get['_route_'] = str_replace(TMP_URL,'',$this->request->get['_route_']);
			//$this->request->get['_route_'] = str_replace('product/view/','',$this->request->get['_route_']);
			
			$tmp = $this->request->get['_route_'];
			//$tmp = str_replace('product/view/', '', $tmp);
			$parts = array($tmp);//explode('/', $tmp);

			// remove any empty arrays from trailing
			if (utf8_strlen(end($parts)) == 0) {
				array_pop($parts);
			}

			foreach ($parts as $part) {
				
				//$sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($this->request->get['_route_']) . "'";
				//if(strpos($this->request->get['_route_'], 'product/view/') !== false){
					
					$url = str_replace('/product/view/','', $this->request->get['_route_']);
					$url = str_replace('product/view/','', $this->request->get['_route_']);
					
					$sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($url) . "' AND `query` LIKE 'product_id=%' LIMIT 0,1;";
					$query = $this->db->query($sql);
				
					if($query->num_rows == 0){
						$sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "' AND `query` NOT LIKE 'product_id=%' LIMIT 0,1;";
						$query = $this->db->query($sql);
					}
				//echo $query->num_rows; die($sql);
				
				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);

					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}

					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
						$this->request->get['category_id'] = $url[1];
					}
;
					if ($url[0] == 'manufacturer_id') {
						
						$this->request->get['manufacturer_id'] = $url[1];
						$this->request->get['filter_manufacturer_id'][$url[1]] = $url[1];
						$this->request->get['manufacturer_main_category'] = true;
						$this->request->get['path'] = true;
						
					}

					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}

					if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'category_id' && $url[0] != 'product_id') {
						$this->request->get['route'] = $query->row['query'];
					}
		
				} else {
					
					
						//Прилетел не стандарный УРЛ . проверим не фильтры ли это
						$aliases = explode('-', $this->request->get['_route_']);
						$categ = $this->request->get['_route_'];
						$attributes = array();
						$sizes = array();
						$attributes_name = array();
						
						
						
						if(count($aliases) > 0){
							
							$error = false;
							
							foreach($aliases as $alias){
							
								//Если разпродажа
								if($alias == 'sale'){
									
									//Если это главная распродажа
									if($categ == 'sale'){
										$this->request->get['_route_'] = $categ;
										$this->request->get['main_sale'] = true;
										$this->request->get['route'] = 'product/category';
										$this->request->get['sizes'] = implode(',',$sizes);
										$this->request->get['attributes'] = implode(',',$attributes);
										$this->request->get['attributes_name'] = implode(',',$attributes_name);
										$this->request->get['category_id'] = 0;
										$this->request->get['path'] = true;
										$this->request->get['sale'] = true;
										break;
									}else{
										$this->request->get['sale'] = true;
										$categ = str_replace($alias.'-', '', $categ);
										continue;	
									}
									
								//Если есть подчеркивание - Это размер
								}elseif(strpos($alias,'_') !== false){
									$size = explode('_',$alias);
									
									//Это размер
										$sql = "SELECT distinct option_value_id FROM " . DB_PREFIX . "option_value_description
														WHERE name LIKE '" . $this->db->escape($size[1]) . "';";
										$query_A = $this->db->query($sql);
										if($query_A->num_rows){
											$sizes[] = $query_A->row['option_value_id'];
											$categ = str_replace($alias.'-', '', $categ);
										}
										
										$sql = "SELECT query FROM " . DB_PREFIX . "url_alias WHERE keyword LIKE '" . $this->db->escape($categ) . "' AND `query` LIKE 'category_id=%' LIMIT 0,1;";
										$query = $this->db->query($sql);
										//echo '<br>'.$sql;
									
										if($query->num_rows){
											
											$url = explode('=', $query->row['query']);
											$this->request->get['sizes'] = implode(',',$sizes);
											$this->request->get['attributes'] = implode(',',$attributes);
											$this->request->get['attributes_name'] = implode(',',$attributes_name);
											$this->request->get['category_id'] = $url[1];
											$this->request->get['path'] = true;
											break;
										
								
										}elseif($categ == 'lovedproducts'  OR
													$categ == 'lastviewed'){
	
											$this->request->get['_route_'] = $categ;
											$this->request->get['route'] = 'product/category';
											$this->request->get['sizes'] = implode(',',$sizes);
											$this->request->get['attributes'] = implode(',',$attributes);
											$this->request->get['attributes_name'] = implode(',',$attributes_name);
											$this->request->get['category_id'] = 0;
											break;
	
										}
									
									
								}else{
							
									$sql = "SELECT attribute_id, attribute_group_id FROM " . DB_PREFIX . "attribute WHERE filter_name LIKE '" . $this->db->escape($alias) . "' LIMIT 0,1;";
									$query_A = $this->db->query($sql);
									if($query_A->num_rows){
										$attributes[] = $query_A->row['attribute_group_id'].'*'.$query_A->row['attribute_id'];
										$attributes_name[] = $alias;
										//$categ = str_replace($alias.'-', '', $categ);
									}else{
										//Если это подкатегория
										
										$alias = str_replace('@','-',$alias);
										$sql = "SELECT query FROM " . DB_PREFIX . "url_alias WHERE keyword LIKE '" . $this->db->escape($alias) . "' AND (`query` LIKE 'category_id=%' OR `query` LIKE 'manufacturer_id=%') LIMIT 0,1;";
										$query_B = $this->db->query($sql);
										$alias = str_replace('-','@',$alias);
										
										//Проверим или это не конечная категория
										$sql = "SELECT query FROM " . DB_PREFIX . "url_alias WHERE keyword LIKE '" . $this->db->escape($categ) . "' AND `query` LIKE 'category_id=%' LIMIT 0,1;";
										$query_C = $this->db->query($sql);
								
										if($query_B->num_rows AND !$query_C->num_rows){
											
											$url = explode('=', $query_B->row['query']);
										
											if($url[0] == 'manufacturer_id'){
												$this->request->get['filter_manufacturer_id'][$url[1]] = $url[1];
												//continue;
											}else{
												$filtered_category[] = $url[1];
												
											}
											
											$attributes_name[] = $alias;
											$filtered_category_keyword[] = $alias;
											
										}
									}
									//echo '<br>'.$sql;
									
									
									$sql = "SELECT query FROM " . DB_PREFIX . "url_alias WHERE keyword LIKE '" . $this->db->escape($categ) . "' AND (`query` LIKE 'category_id=%' OR `query` LIKE 'manufacturer_id=%') LIMIT 0,1;";
									$query = $this->db->query($sql);
									
									if($query->num_rows){
										
										$url = explode('=', $query->row['query']);
										
										//Если крайний якорь - категория
										if($url[0] == 'category_id'){
											$this->request->get['sizes'] = implode(',',$sizes);
											$this->request->get['attributes'] = implode(',',$attributes);
											$this->request->get['attributes_name'] = implode(',',$attributes_name);
											$this->request->get['category_id'] = $url[1];
											$this->request->get['path'] = true;
											
											if(isset($filtered_category)){
												$this->request->get['filtered_category']  = implode(',',$filtered_category);
											}
											
											if(isset($filtered_category_keyword)){
												$this->request->get['filtered_category_keyword']  = implode(',',$filtered_category_keyword);
											}
											
											break;
										}else{
											//Если крайний якорь - бренд
											$this->request->get['manufacturer_id'] = $url[1];
											$this->request->get['filter_manufacturer_id'][$url[1]] = $url[1];
											$this->request->get['manufacturer_main_category'] = true;
											$this->request->get['path'] = true;
				
											$this->request->get['sizes'] = implode(',',$sizes);
											$this->request->get['attributes'] = implode(',',$attributes);
											$this->request->get['attributes_name'] = implode(',',$attributes_name);
											
											if(isset($filtered_category)){
												$this->request->get['filtered_category']  = implode(',',$filtered_category);
											}
											
											if(isset($filtered_category_keyword)){
												$this->request->get['filtered_category_keyword']  = implode(',',$filtered_category_keyword);
											}
											
											break;
											  
										}
								
									}elseif($categ == 'lovedproducts'  OR
												$categ == 'lastviewed'){

										$this->request->get['_route_'] = $categ;
										$this->request->get['route'] = 'product/category';
										$this->request->get['sizes'] = implode(',',$sizes);
										$this->request->get['attributes'] = implode(',',$attributes);
										$this->request->get['attributes_name'] = implode(',',$attributes_name);
										$this->request->get['category_id'] = 0;
										break;

									}elseif($query->num_rows AND $query_A->num_rows){
									
										$this->request->get['route'] = 'error/not_found';
										break;
									}
									
									$categ = str_replace($alias.'-', '', $categ);
								}
								
								//Мы сделали полный круг по поиску и ничего не нашели - вылет на уровень ниже
								if($query->num_rows == 0 AND $query_A->num_rows == 0){
									$error = true;
								}
							}
							
							if($error){
								if(isset($params) AND $params != ''){
									//header("Location: http://". $_SERVER['HTTP_HOST'].'/'.TMP_URL.$categ.'?'.$params, true);
								}else{
									//header("Location: http://". $_SERVER['HTTP_HOST'].'/'.TMP_URL.$categ, true);	
								}
							}
							
						}else{

							$this->request->get['route'] = 'error/not_found';
							break;
						}
				}
			}

			if (!isset($this->request->get['route'])) {
				if (isset($this->request->get['product_id'])) {
					$this->request->get['route'] = 'product/product';
				} elseif (isset($this->request->get['path'])) {
					$this->request->get['route'] = 'product/category';
				} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['route'] = 'product/category';//'product/manufacturer/info';
				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'information/information';
				} 
			}


			if (isset($this->request->get['route'])) {
				
				return new Action($this->request->get['route']);
			}else{
				
				$this->request->get['route'] = 'error/not_found';
				return new Action($this->request->get['route']);
			}
		}

	}

	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));

		$url = '';

		$data = array();

		parse_str($url_info['query'], $data);

		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");

					if ($query->num_rows && $query->row['keyword']) {
						$url .= '/' . $query->row['keyword'];

						unset($data[$key]);
					}
				
				
				//Блок новостей
				} elseif ($data['route'] == 'news/article' && $key == 'news_id') { 
					$query    =    $this->db->query( "SELECT * FROM " . DB_PREFIX . "url_alias where  `query` = '" . $this->db->escape($key . '=' . (int)$value ) . "'");
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword'];
						unset($data[$key]);
					} else {
						$url .= '/blogart' . (int)$value;	
						unset($data[$key]);
					}
				} elseif (($data['route'] == 'news/ncategory' || $data['route'] == 'news/article') && $key == 'author') { 
					$realkey = "nauthor_id";
					$query   =    $this->db->query( "SELECT * FROM " . DB_PREFIX . "url_alias where  `query` = '" . $this->db->escape($realkey . '=' . (int)$value) . "'" );
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword'];
						unset($data[$key]);
					} else {
						$url .= '/blogauthor' . (int)$value;	
						unset($data[$key]);
					}
				} elseif (($data['route'] == 'news/ncategory' || $data['route'] == 'news/article') && $key == 'archive') { 
					$url .= '/blogarchive-' . (string)$value;	
					unset($data[$key]);
				} elseif ($key == 'ncat') {
					$ncategories = explode('_', $value);
							
					foreach ($ncategories as $ncategory) {
						$query    =    $this->db->query( "SELECT * FROM " . DB_PREFIX . "url_alias where  `query` = 'ncategory_id=" . (int)$ncategory . "'" );
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url .= '/blogcat' . $ncategory;
						}
					}
					unset($data[$key]);
				} elseif ((isset($data['route']) && $data['route'] == 'news/ncategory' && $key != 'ncat' && $key != 'author' && $key != 'page' && $key != 'archive') || (isset($data['route']) && $data['route'] == 'news/article' && $key != 'page')) { 
					$blog_headlines = $this->config->get('ncategory_bnews_headlines_url') ? $this->config->get('ncategory_bnews_headlines_url') : 'blog-headlines';
					$url .=  '/'.$blog_headlines;
				} elseif ($data['route'] == 'news/article' && $key == 'news_id') { 
				$query    =    $this->db->query( "SELECT * FROM " . DB_PREFIX . "url_alias where  `query` = '" . $this->db->escape($key . '=' . (int)$value ) . "'");
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword'];
						unset($data[$key]);
					} else {
						$url .= '/blogart' . (int)$value;	
						unset($data[$key]);
					}
				} elseif (($data['route'] == 'news/ncategory' || $data['route'] == 'news/article') && $key == 'author') { 
					$realkey = "nauthor_id";
					$query   =    $this->db->query( "SELECT * FROM " . DB_PREFIX . "url_alias where  `query` = '" . $this->db->escape($realkey . '=' . (int)$value) . "'" );
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword'];
						unset($data[$key]);
					} else {
						$url .= '/blogauthor' . (int)$value;	
						unset($data[$key]);
					}
				} elseif (($data['route'] == 'news/ncategory' || $data['route'] == 'news/article') && $key == 'archive') { 
					$url .= '/blogarchive-' . (string)$value;	
					unset($data[$key]);
				} elseif ($key == 'ncat') {
					$ncategories = explode('_', $value);
							
					foreach ($ncategories as $ncategory) {
						$query    =    $this->db->query( "SELECT * FROM " . DB_PREFIX . "url_alias where  `query` = 'ncategory_id=" . (int)$ncategory . "'" );
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url .= '/blogcat' . $ncategory;
						}
					}
					unset($data[$key]);
				} elseif ((isset($data['route']) && $data['route'] == 'news/ncategory' && $key != 'ncat' && $key != 'author' && $key != 'page' && $key != 'archive') || (isset($data['route']) && $data['route'] == 'news/article' && $key != 'page')) { 
					$blog_headlines = $this->config->get('ncategory_bnews_headlines_url') ? $this->config->get('ncategory_bnews_headlines_url') : 'blog-headlines';
					$url .=  '/'.$blog_headlines;
				} elseif ($key == 'path') {
				
				//end  Блок новостей
				//} elseif ($key == 'path') {
					$categories = explode('_', $value);

					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");

						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';

							break;
						}
					}

					unset($data[$key]);
				}
			}
		}

		if ($url) {
			unset($data['route']);

			$query = '';

			if ($data) {
				foreach ($data as $key => $value) {
					if(is_array($value)){
						
						foreach ($value as $key1 => $value1) {
							$query .= '&' . rawurlencode((string)$key1) . '=' . rawurlencode((string)$value1);
						}
						
					}else{
						$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((string)$value);
					}
				}

				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
			}

			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}
}
