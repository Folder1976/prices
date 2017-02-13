<?php 
class ControllerBlogCategory extends Controller {
	
	public function index() {  
	
	if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css')) {
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css');
	} else {
		$this->document->addStyle('catalog/view/theme/default/stylesheet/blog.css');
	}
		
	$this->language->load('blog/blog');
	
	$this->load->model('blog/blog_category');
	
	$this->load->model('blog/blog');
	
	// Fall back values
	$limit = $this->config->get('blogsetting_blogs_per_page');
	if (empty($limit)) {
	$limit = 5;
	}
	
	$img_width = $this->config->get('blogsetting_thumbs_w');
	if (empty($img_width)) {
	$img_width = 848;
	}
	
	$img_height = $this->config->get('blogsetting_thumbs_h');
	if (empty($img_height)) {
	$img_height = 424;
	}
	
	$data['date_added_status'] = $this->config->get('blogsetting_date_added');
	if (empty($data['date_added_status'])) {
	$data['date_added_status'] = 1;
	}
	
	$data['comments_count_status'] = $this->config->get('blogsetting_comments_count');
	if (empty($data['comments_count_status'])) {
	$data['comments_count_status'] = 1;
	}
	
	$data['page_view_status'] = $this->config->get('blogsetting_page_view');
	if (empty($data['page_view_status'])) {
	$data['page_view_status'] = 1;
	}
	
	$data['author_status'] = $this->config->get('blogsetting_author');
	if (empty($data['blogsetting_author'])) {
	$data['author_status'] = 1;
	}
	
	$data['list_columns'] = $this->config->get('blogsetting_layout');
	if (empty($data['list_columns'])) {
	$data['list_columns'] = 1;
	}
		
	
	$data['breadcrumbs'] = array();

	$data['breadcrumbs'][] = array(
		'text'      => $this->language->get('text_home'),
		'href'      => $this->url->link('common/home')
	);

	$data['breadcrumbs'][] = array(
		'text'      => $this->language->get('text_blog'),
		'href'      => $this->url->link('blog/home')
	);	
		
				
	if (isset($this->request->get['blogpath'])) {
		$path = '';
		
		$parts = explode('_', $this->request->get['blogpath']);
		
		foreach ($parts as $path_id) {
			$blog_category_info = $this->model_blog_blog_category->getBlogCategory($path_id);
	
	
			if ($blog_category_info) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

	       		$data['breadcrumbs'] [] = array(
   	    			'href'      => $blog_category_info['keyword'],//$this->url->link('blog/category', 'blogpath=' . $path),
    	   			'text'      => $blog_category_info['name']
        		);
			}
		}
		
		$blog_category_id = array_pop($parts);
			} else {
		$blog_category_id = 0;
			}
		
		$blog_category_info = $this->model_blog_blog_category->getBlogCategory($blog_category_id);
		
		if ($blog_category_info) {
			
			if ($blog_category_info['page_title']) {
			$this->document->setTitle($blog_category_info['page_title']);
			} else {
			$this->document->setTitle($blog_category_info['name']);
			}
			
			$this->document->setDescription($blog_category_info['meta_description']);
			$this->document->setKeywords($blog_category_info['meta_keywords']);
			
			$data['heading_title'] = $blog_category_info['name'];
			
			if ($blog_category_info['description'] == '&lt;p&gt;&lt;br&gt;&lt;/p&gt;') {
			$data['blog_category_description'] = '';
			} else {
			$data['blog_category_description'] = html_entity_decode($blog_category_info['description']);
			}
			
      		$data['text_posted_on'] = $this->language->get('text_posted_on');
			$data['text_read'] = $this->language->get('text_read');
			$data['text_posted_by'] = $this->language->get('text_posted_by');
			$data['text_comments'] = $this->language->get('text_comments');
			$data['text_posted_on'] = $this->language->get('text_posted_on');
			
      		$data['text_no_results'] = $this->language->get('text_no_results');
         	$data['text_read_more'] = $this->language->get('text_read_more');

			$blog_description = $blog_category_info['description'];
			if (empty($blog_description) || ($blog_description == '&lt;p&gt;&lt;br&gt;&lt;/p&gt;')) {
			$data['description'] = false;
			} else {
			$data['description'] = html_entity_decode($blog_category_info['description'], ENT_QUOTES, 'UTF-8');
			}
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			} 
			
			$pagefix = ($page - 1) * $limit;
			
			if ($pagefix < 1) { $pagefix = 0;}
			
			$this->load->model('blog/blog');
			$this->load->model('tool/image');
				
			$data['blogs'] = array();
			
			$blogs = array(
				'start' => ($page - 1) * $limit,
				'limit' => $limit,
			);
			        		
			$results = $this->model_blog_blog->getBlogsByBlogCategoryId($blog_category_id, $pagefix, $limit);
						
			foreach ($results as $result) {
      		
			$data['blogs'][] = array(
				'count_read' => $result['count_read'],
        		'title' => $result['title'],
				'author' => $result['author'],
				'comment_total' => $this->model_blog_blog->getTotalCommentsByBlogId($result['blog_id']),
        		'date_added_full' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
        		'description' => html_entity_decode($result['description']),
        		'short_description' => html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8'),
        		'image' => $this->model_tool_image->resize($result['image'], $img_width, $img_height),
				'href'  => $result['keyword'],//$this->url->link('blog/blog', 'blogpath=' . $this->request->get['blogpath'] . '&blog_id=' . $result['blog_id'])
				
      		);
    		}
					
			$blog_total = $this->model_blog_blog->getTotalBlogsByBlogCategoryId($blog_category_id);
			
			$pagination = new Pagination();
			$pagination->total = $blog_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('blogsetting_blogs_per_page');
			if (empty($pagination->limit)) {$pagination->limit = 5;}
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('blog/category', 'blogpath=' . $this->request->get['blogpath'] . '&page={page}');
			
			$data['pagination'] = $pagination->render();
			
			$data['results'] = sprintf($this->language->get('text_pagination'), ($blog_total) ? ($pagefix) + 1 : 0, ((($page - 1) * $limit) > ($blog_total - $limit)) ? $blog_total : (($pagefix) + $limit), $blog_total, ceil($blog_total / $limit));
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			if ((float)VERSION >= 2.2) {
				$this->response->setOutput($this->load->view('blog/blog_category', $data));
			} else {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/blog/blog_category.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/blog/blog_category.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/blog/blog_category.tpl', $data));
				}
			}

		} else {
		
			$this->language->load('error/not_found');
			
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}	
			
			if (isset($this->request->get['blogpath'])) {	
				$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('blog/category', 'blogpath=' . $path)
			);
			}
			
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
			
			if ((float)VERSION >= 2.2) {
				$this->response->setOutput($this->load->view('error/not_found', $data));
			} else {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
				} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
				}
			}
		}
	}
	
}