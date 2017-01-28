<?php
class ControllerModuleNewsarchive extends Controller {
	private $error = array(); 
	
	public function index() {  
		$data = array();
		
		$data += $this->language->load('module/news_archive');

		$this->document->setTitle($this->language->get('title_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('news_archive', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->buildArchive();
						
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/news_archive', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
		$data['action'] = $this->url->link('module/news_archive', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		
		if (isset($this->request->post['news_archive_months'])) {
			$data['news_archive_months'] = $this->request->post['news_archive_months'];
		} elseif($this->config->get('news_archive_months')) {
			$data['news_archive_months'] = $this->config->get('news_archive_months');
		} else {
			$data['news_archive_months'] = array();
		}
		if (isset($this->request->post['news_archive_date'])) {
			$data['news_archive_date'] = $this->request->post['news_archive_date'];
		} else {
			$data['news_archive_date'] = $this->config->get('news_archive_date');
		}
		if (isset($this->request->post['news_archive_build'])) {
			$data['news_archive_build'] = $this->request->post['news_archive_build'];
		} else {
			$data['news_archive_build'] = $this->config->get('news_archive_build');
		}
		
		if (isset($this->request->post['news_archive_status'])) {
			$data['news_archive_status'] = $this->request->post['news_archive_status'];
		} else {
			$data['news_archive_status'] = $this->config->get('news_archive_status');
		}	
				
		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		
		//opencart 2.2.0.0 code

	  	if (version_compare(VERSION, '2.2.0.0') >= 0) {
	  		$languages = $data['languages'];
	  		$data['languages'] = array();
	  		foreach ($languages as $language) {
	  			$data['languages'][] = array(
	  				'name' => $language['name'],
	  				'language_id' => $language['language_id'],
	  				'image' => "../../../language/$language[code]/$language[code].png",
	  				'code' => $language['code']
	  				);
	  		}

	  	}

	  	//opencart 2.2.0.0 code ends


		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['newspanel'] = $this->load->controller('common/newspanel');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/news_archive.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/news_archive')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	private function buildArchive() {
	  if ($this->validate()) {
		  
		$this->load->model('catalog/news');

		if (version_compare(VERSION, '2.1.0.0') >= 0 || VERSION =='2.1.0.0_rc1') {
			$this->load->model('customer/customer_group');

			$customer_groups = $this->model_customer_customer_group->getCustomerGroups();
		} else {
			$this->load->model('sale/customer_group');

			$customer_groups = $this->model_sale_customer_group->getCustomerGroups();
		}

		$restr = $this->config->get('ncategory_bnews_restrictgroup');
		
		$this->load->model('setting/store');
		
		$stores = $this->model_setting_store->getStores();
		
		$this->language->load('module/news_archive');
		  
		if ($this->config->get('news_archive_date') == "dp") {
			$articles = $this->model_catalog_news->getNewsDP(); //get all articles with date published
			$field = 'date_pub'; // archive grouping field set to date_pub
		} elseif($this->config->get('news_archive_date') == "du") {
			$articles = $this->model_catalog_news->getNewsDU(); //get all articles with date updated
			$field = 'date_updated'; // archive grouping field set to date update
		} else {
			$articles = $this->model_catalog_news->getNewsDA(); //get all articles
			$field = 'date_added'; // archive grouping field
		}
		
		
		$this->model_catalog_news->deleteArchive(); //clear the archive
		
		
		
		/*for default store*/
		$archive_data = array();
if ($restr) {  

	foreach($customer_groups as $group) {
		$archive_data = array();
		foreach ($articles as $article) {
		  if ($article['store_id'] == 0) {
		  if ($article['group_id'] == $group['customer_group_id']) {
			$date = strtotime($article[$field]);
			$year = date("Y",$date);
			$month = (int)date("m",$date);
			if (!array_key_exists($year, $archive_data)) {
				$archive_data[$year] = array(
					'year' => $year,
					'months' => array()
				);
			}
			if(!array_key_exists($month, $archive_data[$year]['months'])) {
				$archive_data[$year]['months'][$month] = 1;
			} else {
				$archive_data[$year]['months'][$month]++;
			}
		  }
		  }
		}
		
		if ($archive_data) {
			$rid =  10000 + ($group['customer_group_id'] * 10);
			foreach ($archive_data as $archive) {
				$this->model_catalog_news->addArchiveYear($archive, $rid);
			}
		}
		/*end of default store*/
	}
		
		/*start aditional stores*/
		foreach ($stores as $store) {
		foreach($customer_groups as $group) {
			$archive_data = array();
			foreach ($articles as $article) {
		  	  if ($article['store_id'] == $store['store_id']) {
		  	  if ($article['group_id'] == $group['customer_group_id']) {
				$date = strtotime($article[$field]);
				$year = date("Y",$date);
				$month = (int)date("m",$date);
				if (!array_key_exists($year, $archive_data)) {
					$archive_data[$year] = array(
						'year' => $year,
						'months' => array()
					);
				}
				if(!array_key_exists($month, $archive_data[$year]['months'])) {
					$archive_data[$year]['months'][$month] = 1;
				} else {
					$archive_data[$year]['months'][$month]++;
				}
			  }
			  }
		  	}
		
			if ($archive_data) {
				$rid =  (($store['store_id']+1) * 10000) + ($group['customer_group_id'] * 10);
				foreach ($archive_data as $archive) {
					$this->model_catalog_news->addArchiveYear($archive, $rid);
				}
			}
		}
		}
} else {
		foreach ($articles as $article) {
		  if ($article['store_id'] == 0) {
			$date = strtotime($article[$field]);
			$year = date("Y",$date);
			$month = (int)date("m",$date);
			if (!array_key_exists($year, $archive_data)) {
				$archive_data[$year] = array(
					'year' => $year,
					'months' => array()
				);
			}
			if(!array_key_exists($month, $archive_data[$year]['months'])) {
				$archive_data[$year]['months'][$month] = 1;
			} else {
				$archive_data[$year]['months'][$month]++;
			}
		  }
		}
		
		if ($archive_data) {
			foreach ($archive_data as $archive) {
				$this->model_catalog_news->addArchiveYear($archive);
			}
		}
		/*end of default store*/
		
		/*start aditional stores*/
		foreach ($stores as $store) {
			$archive_data = array();
			foreach ($articles as $article) {
		  	  if ($article['store_id'] == $store['store_id']) {
				$date = strtotime($article[$field]);
				$year = date("Y",$date);
				$month = (int)date("m",$date);
				if (!array_key_exists($year, $archive_data)) {
					$archive_data[$year] = array(
						'year' => $year,
						'months' => array()
					);
				}
				if(!array_key_exists($month, $archive_data[$year]['months'])) {
					$archive_data[$year]['months'][$month] = 1;
				} else {
					$archive_data[$year]['months'][$month]++;
				}
			  }
		  	}
		
			if ($archive_data) {
				foreach ($archive_data as $archive) {
					$this->model_catalog_news->addArchiveYear($archive, (int)$store['store_id']);
				}
			}
		}
}
		/*end of additional stores*/
	
		$this->session->data['success'] .= '<br />Archive Index Created!';
	
      } else {
	
		$this->session->data['warning'] .= '<br />You don\'t have permissions to modify the blog!';
	
	  }
	}
}
?>