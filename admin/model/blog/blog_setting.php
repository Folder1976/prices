<?php
class ModelBlogBlogSetting extends Model { 
	
	
	// Get blog home SEO url
	public function getHomeKeyword() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'blog/home'");
		return $query->row;
	}
		
	// Save blog home SEO url
	public function saveHomeKeyword($code, $data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog/home'");
		if ($data['blog_home_url']) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog/home', keyword = '" . $this->db->escape($data['blog_home_url']) . "'");
		}
	}
	
	

}