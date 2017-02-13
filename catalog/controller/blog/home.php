<?php 
class ControllerBlogHome extends Controller {
	private $error = array();
	
	public function index() { 
	 	
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/blog.css');
		}
		
    	$this->language->load('blog/blog');
		
		$this->load->model('blog/blog');	
		
		$this->load->model('tool/image');
		
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
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$pagefix = ($page - 1) * $limit;
			
		if ($pagefix < 1) { $pagefix = 0;}
		
		if( isset($this->request->get['tag']) ){
				$filter_tag = $this->request->get['tag'];
		}else {
				$filter_tag = '';
		}
		
		$data['blogs'] = array();

		$filter_data = array(
			'start' => ($page - 1) * $limit,
			'limit' => $limit,
			'filter_tag'  => $filter_tag,
		);
		
		
		$blog_total = $this->model_blog_blog->getTotalBlogs($filter_data);
		
		$results = $this->model_blog_blog->getBlogs($filter_data, $pagefix, $limit);
 
    	foreach ($results as $result) {
						
			$data['blogs'][] = array(
			'count_read' => $result['count_read'],
			'comment_total' => $this->model_blog_blog->getTotalCommentsByBlogId($result['blog_id']),
			'blog_id' => $result['blog_id'],
			'title'      => $result['title'],
			'short_description'      => html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8'),
			'date_added_full' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
			'author' => $result['author'],
			'image'   		=> $this->model_tool_image->resize($result['image'], $img_width, $img_height),
			'href' => $result['keyword'],//$this->url->link('blog/blog', 'blog_id=' . $result['blog_id'])
			);
		}
		
		// Home page title
		$blog_page_title = $this->config->get('blogsetting_home_page_title');
		if (!empty($blog_page_title[$this->config->get('config_language_id')])) {
		$this->document->setTitle($blog_page_title[$this->config->get('config_language_id')]);
		} else {
		$this->document->setTitle($this->language->get('text_blog'));
		}
		
		// Home title
		$blog_title = $this->config->get('blogsetting_home_title');
		if (!empty($blog_title[$this->config->get('config_language_id')])) {
		$data['heading_title'] = $blog_title[$this->config->get('config_language_id')];
		} else {
		$data['heading_title'] = $this->language->get('text_blog');
		}
        
		// Home description
		$blog_description = $this->config->get('blogsetting_home_description');
		if (empty($blog_description[$this->config->get('config_language_id')]) || ($blog_description[$this->config->get('config_language_id')] == '&lt;p&gt;&lt;br&gt;&lt;/p&gt;')) {
		$data['description'] = false;
		} else {
		$data['description'] = html_entity_decode(($blog_description[$this->config->get('config_language_id')]), ENT_QUOTES, 'UTF-8');
		}
		
		// If searched on a blog tag
		if($filter_tag){
		$data['heading_title'] = $this->language->get('text_filter_by') . $filter_tag;
		$this->document->setTitle($this->language->get('text_filter_by') . $filter_tag);
		$data['description'] = false;
		}
					
		$blog_page_meta_description = $this->config->get('blogsetting_home_meta_description');
		if ($blog_page_meta_description[$this->config->get('config_language_id')]) {
		$this->document->setDescription($blog_page_meta_description[$this->config->get('config_language_id')]);
		}
		
		$blog_page_meta_keyword = $this->config->get('blogsetting_home_meta_keyword');
		if ($blog_page_meta_keyword[$this->config->get('config_language_id')]) {
		$this->document->setKeywords($blog_page_meta_keyword[$this->config->get('config_language_id')]);
		}

		$data['text_posted_on'] = $this->language->get('text_posted_on');
		$data['text_read'] = $this->language->get('text_read');
		$data['text_posted_by'] = $this->language->get('text_posted_by');
		$data['text_comments'] = $this->language->get('text_comments');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_read_more'] = $this->language->get('text_read_more');
		
		$url = '';
		
		/*if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}*/
		
		if( isset($this->request->get['tag']) ){
			$url .= '&tag=' . $filter_tag;
		}
		
		$pagination = new Pagination();
		$pagination->total = $blog_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('blogsetting_blogs_per_page');
		if (empty($pagination->limit)) {$pagination->limit = 5;}
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('blog/home', $url . '&page={page}');
		
		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($blog_total) ? ($pagefix) + 1 : 0, ((($page - 1) * $limit) > ($blog_total - $limit)) ? $blog_total : (($pagefix) + $limit), $blog_total, ceil($blog_total / $limit));
			
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		if ((float)VERSION >= 2.2) {
				$this->response->setOutput($this->load->view('blog/blog_home', $data));
			} else {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/blog/blog_home.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/blog/blog_home.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/blog/blog_home.tpl', $data));
				}
			}
	}
}