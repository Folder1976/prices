<?php
class ControllerModuleBlogLatest extends Controller {
	public function index($setting) {
		
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css')) {
		$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/blog.css');
		} else {
		$this->document->addStyle('catalog/view/theme/default/stylesheet/blog.css');
		}
		
		static $module = 0;
		
		$this->load->language('blog/blog');
		$this->load->model('blog/blog');
		$this->load->model('tool/image');
		
		$data = array(
			'start' => 0,
			'limit' => $setting['limit']
		);
		
		$data['characters'] = $setting['characters'];
		$data['carousel'] = $setting['carousel'];
		$data['columns'] = $setting['columns'];
		$data['thumb'] = $setting['thumb'];
		
		if ($data['carousel']) {
		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
		}
		

		foreach ($this->model_blog_blog->getLatestBlogs($data) as $result) {
      		$data['posts'][] = array(
        		'title' => $result['title'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				
				'author' => $result['author'],
				'comment_total' => $this->model_blog_blog->getTotalCommentsByBlogId($result['blog_id']),
				'date_added_full' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'description' => utf8_substr(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8')), 0, $setting['characters']) . '..',
				'count_read' => $result['count_read'],
				'image'   		=> $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
	    		'href'  => $this->url->link('blog/blog', 'blog_id=' . $result['blog_id'])
      		);
    	}
		
		$data['blog_show_all'] = $this->url->link('blog/home');
		
		$data['text_show_all'] = $this->language->get('text_show_all');
		$data['text_posted_on'] = $this->language->get('text_posted_on');
		$data['text_posted_by'] = $this->language->get('text_posted_by');
		$data['text_read'] = $this->language->get('text_read');
		$data['text_comments'] = $this->language->get('text_comments');
		$data['text_not_found'] = $this->language->get('text_not_found');
		$data['heading_title_latest'] = $this->language->get('heading_title_latest');
		$data['text_read_more'] = $this->language->get('text_read_more');
		
		$data['date_added_status'] = $this->config->get('blogsetting_date_added');
		$data['comments_count_status'] = $this->config->get('blogsetting_comments_count');
		$data['page_view_status'] = $this->config->get('blogsetting_page_view');
		$data['author_status'] = $this->config->get('blogsetting_author');
		

		$data['module'] = $module++;

		if ((float)VERSION >= 2.2) {
				return $this->load->view('module/blog_latest', $data);
			} else {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blog_latest.tpl')) {
					return $this->load->view($this->config->get('config_template') . '/template/module/blog_latest.tpl', $data);
				} else {
					return $this->load->view('default/template/module/blog_latest.tpl', $data);
				}
			}
	}
}