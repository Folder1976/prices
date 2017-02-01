<?php
class Document {
	private $title;
	private $description;
	private $keywords;
	private $params;
	private $money;
	private $menu;
	private $is_sale;
	private $pathDomain = 'moscow';
	private $metateg = '';
	private $links = array();
	private $styles = array();
	private $scripts = array();
	private $shop = array();
	private $ip_list = array();
	private $extra_tags = array();

	public function addExtraTag($property, $content = '', $name=''){
		$this->extra_tags[md5($property)] = array(
			'property' => $property,
			'content'  => $content,
			'name'     => $name,
		);
	}
	
	public function getExtraTags(){
		return $this->extra_tags;
	}
	
	public function setSale($is_sale) {
		$this->is_sale = $is_sale;
	}
	
	public function isSale() {
		return $this->is_sale;
	}

	public function setCategoryMenu($menu) {
		$this->menu = $menu;
	}
	
	public function getCategoryMenu() {
		return $this->menu;
	}

	public function setPathDomain($pathDomain) {
		$this->pathDomain = $pathDomain;
	}
	
	public function getPathDomain() {
		return $this->pathDomain;
	}

	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setMetaTeg($metateg) {
		$this->metateg = $metateg;
	}

	public function getMetaTeg() {
		return $this->metateg;
	}
	
	public function setMoney($money) {
		$this->money = $money;
	}

	public function getMoney() {
		return $this->money;
	}
	
	public function setParam($params) {
		$this->params = $params;
	}

	public function getParam() {
		return $this->params;
	}

	public function getShop() {
		return $this->shop;
	}

	public function setShop($data) {
		$this->shop = $data;
	}

	public function getIpList() {
		return $this->ip_list;
	}

	public function setIpList($data) {
		$this->ip_list = $data;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	public function getKeywords() {
		return $this->keywords;
	}

	public function addLink($href, $rel) {
		$this->links[$href] = array(
			'href' => $href,
			'rel'  => $rel
		);
	}

	public function getLinks() {
		return $this->links;
	}

	public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
		$this->styles[$href] = array(
			'href'  => $href,
			'rel'   => $rel,
			'media' => $media
		);
	}

	public function getStyles() {
		return $this->styles;
	}

	public function addScript($href, $postion = 'header') {
		$this->scripts[$postion][$href] = $href;
	}

	public function getScripts($postion = 'header') {
		if (isset($this->scripts[$postion])) {
			return $this->scripts[$postion];
		} else {
			return array();
		}
	}
}
