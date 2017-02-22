<?php
class ControllerModuleMegareviews extends Controller {
	private $error = array();
	private $defaults=array(
	'version'         =>2,
	'captcha' => 1	,
		'mr_position'		=> "content_bottom",
		'mr_status'			=> 1,
		'rvalues'		=> "Poor, Fair, Average, Good, Excellent",
		'approve'		=> 1,
		'perpage'		=> 5,
		'sortnewest'		=> 1,
		'sorthighest'		=> 1,
		'sortlowest'		=> 1,
		'sorthelpful'		=> 1,
		'mr_optionstyle'		=> 1,
		'displayoptions'		=> 1,
		'displayaboutyou'		=> 1,
		'vote'				=> 1,
		'photo'				=> 1,
		'video'				=> 1,
		'rating'				=> 2,
		'recommend'				=> 2,
		'nickname'				=> 2,
		'displaytextcounter'				=> 1,
		'textcount'				=> 20,
		'text'				=> 2,
		'title'				=> 2,
		'displaytextcounter'		=> 2,
		'maxsize'				=> 500,
		'maxnumber'				=> 5,
		'minwidth'				=> 400,
		'displayimagehint'		=> 1,
		'displayvideohint'		=> 1,
		'displaycaptionhint'        => 1,
		'captionhint'		=> "Example: My demonstration of how to use this product",
		'imagehint'		=> "5 images max, 500Kb max per image",
		'videohint'		=> "Paste the URL of your video on YouTube or Vimeo",
		'texthint'		=> "20 character minimum. Focus on the product and your experience using it.",
		'titlehint'		=> "Example: This product has great features",
		'displayimagetips'		=> 1,
		'displayvideotips'		=> 1,
		'displaytexttips'		=> 1,
		'texttips'		=> "<p>When writing your review, please consider the following guidelines:</p><ul> <li>Focus on the product and your individual experience using it</li> <li>Provide details about why you liked or disliked a product</li> <li>Help others decide if the product will meet their needs</li> <li>All submitted reviews are subject to the terms set forth in our Privacy Policy, Terms of use and the Terms Service for this site feature.</li> </ul>",
		
		'imagetips'		=> "<ul> <li>Upload media related to the product</li> <li>Confirm you hold the copyright for the media</li> <li>Images must be at least 533 pixels in width and height</li> </ul>",
		'videotips'		=> "<ul> <li>Make sure your video is related to the product.</li> <li>Try to submit videos of you using the product.</li> <li>Inappropriate videos will be rejected along with your review.</li> <li>If you are not the copyright holder, you may not submit copyrighted videos.</li> </ul>",
			
	);
	private $settings = array("position" => 'content_bottom',
                          "layout_id" => "2",
                          "sort_order" => "10",
                          "status" => "1",
                          );
	
	public function index() {
		
		$this->document->setTitle($this->language->get('simple_heading_title'));

		$this->updateModule();

		$this->init(); 
	} 
	
	public function updateModule() {
	    $version=$this->defaults['version'];
        $this->load->model('setting/setting');
        $module= $this->config->get('megareviews_settings'); 
        $lastversion=isset($module['version']) ? $module['version'] : 1;       
        foreach($this->defaults as $key=>$value ){
            if(!isset($module[$key]))$module[$key]=$value;
        }
        $this->settings['status']=$module['mr_status'];
        $this->settings['position']=$module['mr_position'];
        $this->db->query("DELETE FROM " . DB_PREFIX . "layout_module WHERE code = 'megareviews'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '2', code = 'megareviews', position = '".$module['mr_position']."', sort_order = '10'");
        
        $this->model_setting_setting->editSetting('megareviews', array_merge(array("megareviews_module" => array(0 => $this->settings)), array("megareviews_settings" => $module),array("megareviews_status" =>  $module['mr_status'])));      
        
        if(!isset($lastversion))$lastversion=1;
        for($i=$lastversion+1;$i<=$version;$i++){
           
            switch($i){
                case 2: 
                    
                break;
            }
        }
        
        
        
    } 
	
	public function init() {
		//$this->getList(); 
		
		
		$this->load->model('module/megareviews');
		$this->load->model('setting/setting');

		$this->getList();
		//$this->getSettings();
	}
	public function settings() {
		
		
		$this->getSettings();
	}
	public function insert() {
		$this->language->load('module/megareviews');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('module/megareviews');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_review->addReview($this->request->post);

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

			$this->response->redirect($this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('module/megareviews');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('module/megareviews');
		$data=$this->request->post;
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
             if(count($_FILES['upload'])) {
                for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
                    $target_path = "../image/catalog/mr/"; //Declaring Path for uploaded images
                        if(!is_dir($target_path)) mkdir($target_path);
                        $validextensions = array("jpeg", "jpg", "png","JPEG", "JPG", "PNG");  //Extensions which are allowed
                        $ext = explode('.', basename($_FILES['upload']['name'][$i]));//explode file name from dot(.) 
                        $file_extension = end($ext); //store extenions in the variable
                        
                        $target_name = rand(1,10000). $ext[0]. "." . $ext[count($ext) - 1];//set the target path with a new name of image
                        $target_path = $target_path.$target_name;
                        
                      if (($_FILES['upload']['size'][$i] < 10000000) //Approx. 100kb files can be uploaded.
                                && in_array($file_extension, $validextensions)) {
                            if (move_uploaded_file($_FILES['upload']['tmp_name'][$i], $target_path)) {//if file moved to uploads folder
                                $data['files'][]="catalog/mr/".$target_name;
                            } else {//if file was not moved.
                                
                            }
                        } 
                    
                }
            }  
			$this->model_module_megareviews->editReview($this->request->get['review_id'], $data);

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

			$this->response->redirect($this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	
	public function updateSettings() {
		$this->language->load('module/megareviews');

		$this->document->setTitle($this->language->get('simple_heading_title'));
		$this->load->model('setting/setting');
		$this->load->model('module/megareviews');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePermission()) {
			$this->model_module_megareviews->updateSettings($this->request->post);
			$this->settings['status']=$this->request->post['mr']['mr_status'];
            $this->settings['position']=$this->request->post['mr']['mr_position'];
            $this->db->query("DELETE FROM " . DB_PREFIX . "layout_module WHERE code = 'megareviews'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '2', code = 'megareviews', position = '".$this->settings['position']."', sort_order = '10'");
        		
			$this->model_setting_setting->editSetting('megareviews', array_merge(array("megareviews_module" => array(0 => $this->settings)), array("megareviews_settings" => $this->request->post['mr']),array("megareviews_status" =>  $this->request->post['mr']['mr_status'])));		
					$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			

			$this->response->redirect($this->url->link('module/megareviews/settings', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		//$this->getForm();
	}

	public function delete() { 
		$this->language->load('module/megareviews');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('module/megareviews');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $review_id) {
				$this->model_module_megareviews->deleteReview($review_id);
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

			$this->response->redirect($this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
	    $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $data = array_merge($data, $this->load->language('module/megareviews'));
		if (isset($this->request->get['filter_product'])) {
            $filter_product = $this->request->get['filter_product'];
        } else {
            $filter_product = null;
        }

        if (isset($this->request->get['filter_author'])) {
            $filter_author = $this->request->get['filter_author'];
        } else {
            $filter_author = null;
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = null;
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'r.date_added';
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_product'])) {
            $url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_author'])) {
            $url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
        $data['token'] = $this->session->data['token'];


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('simple_heading_title'),
			'href'      => $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$data['insert'] = $this->url->link('module/megareviews/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('module/megareviews/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$data['settings'] = $this->url->link('module/megareviews/settings', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['reviews'] = array();

		$filter_data = array(
            'filter_product'    => $filter_product,
            'filter_author'     => $filter_author,
            'filter_status'     => $filter_status,
            'filter_date_added' => $filter_date_added,
            'sort'              => $sort,
            'order'             => $order,
            'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'             => $this->config->get('config_limit_admin')
        );


		$review_total = $this->model_module_megareviews->getTotalReviews($filter_data);

		$results = $this->model_module_megareviews->getReviews($filter_data);

		foreach ($results as $result) {
			
			$data['reviews'][] = array(
				'review_id'  => $result['review_id'],
				'name'       => $result['name'],
				'author'     => $result['author'],
				'rating'     => $result['rating'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['review_id'], $this->request->post['selected']),
				'edit'     => $this->url->link('module/megareviews/update', 'token=' . $this->session->data['token'] . '&review_id=' . $result['review_id'] . $url, 'SSL')
			);
		}	

		
		

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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_product'] = $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_author'] = $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . '&sort=r.author' . $url, 'SSL');
		$data['sort_rating'] = $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . '&sort=r.rating' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . '&sort=r.status' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . '&sort=r.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
        $data['filter_product'] = $filter_product;
        $data['filter_author'] = $filter_author;
        $data['filter_status'] = $filter_status;
        $data['filter_date_added'] = $filter_date_added;

        $data['sort'] = $sort;
        $data['order'] = $order;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('module/megareviews_list.tpl', $data));
	}

	protected function getForm() {
		$data = $this->load->language('module/megareviews');
        

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['product'])) {
			$data['error_product'] = $this->error['product'];
		} else {
			$data['error_product'] = '';
		}

		if (isset($this->error['author'])) {
			$data['error_author'] = $this->error['author'];
		} else {
			$data['error_author'] = '';
		}

		if (isset($this->error['text'])) {
			$data['error_text'] = $this->error['text'];
		} else {
			$data['error_text'] = '';
		}

		if (isset($this->error['rating'])) {
			$data['error_rating'] = $this->error['rating'];
		} else {
			$data['error_rating'] = '';
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
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('simple_heading_title'),
			'href'      => $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['review_id'])) { 
			$data['action'] = $this->url->link('module/megareviews/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('module/megareviews/update', 'token=' . $this->session->data['token'] . '&review_id=' . $this->request->get['review_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['review_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$review_info = $this->model_module_megareviews->getReview($this->request->get['review_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('catalog/product');
        $this->load->model('tool/image');

		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($review_info)) {
			$data['product_id'] = $review_info['product_id'];
		} else {
			$data['product_id'] = '';
		}

		if (isset($this->request->post['product'])) {
			$data['product'] = $this->request->post['product'];
		} elseif (!empty($review_info)) {
			$data['product'] = $review_info['product'];
		} else {
			$data['product'] = '';
		}

		if (isset($this->request->post['author'])) {
			$data['author'] = $this->request->post['author'];
		} elseif (!empty($review_info)) {
			$data['author'] = $review_info['author'];
		} else {
			$data['author'] = '';
		}

		if (isset($this->request->post['text_plus'])) {
			$data['text_plus'] = $this->request->post['text_plus'];
		} elseif (!empty($review_info)) {
			$data['text_plus'] = $review_info['text_plus'];
		} else {
			$data['text_plus'] = '';
		}

		if (isset($this->request->post['text_minus'])) {
			$data['text_minus'] = $this->request->post['text_minus'];
		} elseif (!empty($review_info)) {
			$data['text_minus'] = $review_info['text_minus'];
		} else {
			$data['text_minus'] = '';
		}

		if (isset($this->request->post['text'])) {
			$data['text'] = $this->request->post['text'];
		} elseif (!empty($review_info)) {
			$data['text'] = $review_info['text'];
		} else {
			$data['text'] = '';
		}

		if (isset($this->request->post['rating'])) {
			$data['rating'] = $this->request->post['rating'];
		} elseif (!empty($review_info)) {
			$data['rating'] = $review_info['rating'];
		} else {
			$data['rating'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($review_info)) {
			$data['status'] = $review_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($this->request->post['recommend'])) {
			$data['recommend'] = $this->request->post['recommend'];
		} elseif (!empty($review_info)) {
			$data['recommend'] = $review_info['recommend'];
		} else {
			$data['recommend'] = '';
		}
        $data['options']=$this->model_module_megareviews->getOptionValues($this->request->get['review_id']);
        $data['ays']=$this->model_module_megareviews->getAyValues($this->request->get['review_id']);
        $data['files']=$this->model_module_megareviews->getImages($this->request->get['review_id']);
        foreach($data['files'] as &$im){
                $im['small'] = $this->model_tool_image->resize($im['big'], 300, 300);
            }
		$this->template = 'module/megareviews_form.tpl';
		$data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/megareviews_form.tpl', $data));
	}

protected function getSettings() {
    $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $data = array_merge($data, $this->load->language('module/megareviews'));
        $this->load->model('module/megareviews');
        $this->load->model('setting/setting');
		$data['heading_title'] = $this->language->get('heading_title');

		$data = array_merge($data, $this->load->language('module/megareviews'));
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['module'] = array();

		$data['module'] =$this->config->get('megareviews_settings');		
			
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$data['error'] = '';
		}
		

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		
		$url = '';

		

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('simple_heading_title'),
			'href'      => $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('module/megareviews/updateSettings', 'token=' . $this->session->data['token'] .  $url, 'SSL');
		

		$data['cancel'] = $this->url->link('module/megareviews', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['options'] = $this->model_module_megareviews->getOptions();
		$data['ays'] = $this->model_module_megareviews->getAys();
		
		$data['token'] = $this->session->data['token'];

		
		$this->template = 'module/megareviews_settings.tpl';
		$data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/megareviews_settings.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/megareviews')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['product_id']) {
			$this->error['product'] = $this->language->get('error_product');
		}

		if ((utf8_strlen($this->request->post['author']) < 3) || (utf8_strlen($this->request->post['author']) > 64)) {
			$this->error['author'] = $this->language->get('error_author');
		}

		if (utf8_strlen($this->request->post['text']) < 1) {
			$this->error['text'] = $this->language->get('error_text');
		}

		if (!isset($this->request->post['rating'])) {
			$this->error['rating'] = $this->language->get('error_rating');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'module/megareviews')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	protected function validatePermission() {
		if (!$this->user->hasPermission('modify', 'module/megareviews')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	
		
	public function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "megareviews` (
		  `review_id` int(11) NOT NULL AUTO_INCREMENT,
		  `product_id` int(11) NOT NULL,
		  `customer_id` int(11) DEFAULT '0',
		  `author` varchar(64) DEFAULT NULL,
		  `title` varchar(128) DEFAULT NULL,
		  `text` text DEFAULT NULL,
		  `rating` int(1) DEFAULT '-1',
		  `videourl` varchar(128) DEFAULT NULL,
		  `videotitle` varchar(128) DEFAULT NULL,
		  `upvotes` int(5) NOT NULL DEFAULT '0',
		  `downvotes` int(5) NOT NULL DEFAULT '0',
		  `status` tinyint(1) NOT NULL DEFAULT '0',
		  `recommend` tinyint(1) NOT NULL DEFAULT '-1',
		  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  PRIMARY KEY (review_id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
 
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "megareviews_options` (
		  `option_id` int(11) NOT NULL AUTO_INCREMENT,
		  `sort_order` int(2) NOT NULL,
		  `name` varchar(64) NOT NULL,
		  `min` varchar(64) DEFAULT NULL,
		  `max` varchar(64) DEFAULT NULL,
		  `values` varchar(256) DEFAULT NULL,
		  PRIMARY KEY (option_id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "megareviewsoptions_to_review` (
		  `option_id` int(11) NOT NULL,
		  `review_id` int(11) NOT NULL,
		  `value` int(2) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "megareviews_ays` (
		  `ay_id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(64) NOT NULL,
		  `sort_order` int(2) NOT NULL,
		  `values` varchar(256) DEFAULT NULL,
		  PRIMARY KEY (ay_id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "megareviewsays_to_review` (
		  `ay_id` int(11) NOT NULL,
		  `review_id` int(11) NOT NULL,
		  `value` int(2) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "megareviewsimg_to_review` (
		  `url` varchar(128) NOT NULL,
		  `review_id` int(11) NOT NULL
		  
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "megareviewsimg_to_review` ADD UNIQUE( `url`)");
		
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "megareviewsays_to_review` ADD UNIQUE( `ay_id`, `review_id`)");
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "megareviewsoptions_to_review` ADD UNIQUE( `option_id`, `review_id`)");
		$this->load->model('setting/setting');
		
		$this->model_setting_setting->editSetting("megareviews", array_merge(array("megareviews_module" => array(0 => $this->settings)),array("megareviews_settings" =>  $this->defaults),array("megareviews_status" =>  1)));      
        $this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '2', code = 'megareviews', position = 'content_bottom', sort_order = '10'");
               
        	
	}
	public function uninstall() {
		//$this->db->query("DROP TABLE `" . DB_PREFIX . "megareviews`");
 		//$this->db->query("DROP TABLE `" . DB_PREFIX . "megareviews_options`");
 		//$this->db->query("DROP TABLE `" . DB_PREFIX . "megareviewsoptions_to_review`");
 		//$this->db->query("DROP TABLE `" . DB_PREFIX . "megareviews_ays`");
 		//$this->db->query("DROP TABLE `" . DB_PREFIX . "megareviewsays_to_review`");
		//$this->db->query("DROP TABLE `" . DB_PREFIX . "megareviewsimg_to_review`");
	}
}
?>