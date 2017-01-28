<?php 
class ControllernewsHeadlines extends Controller {  
	public function index() { 
		$this->redirect($this->url->link('news/ncategory'));
  	}
}
?>