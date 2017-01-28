<?php
class ControllerProductShops extends Controller {
	
	public function index() {
	
		$this->load->model('catalog/shops');

	}
	
	public function getShopInfoAjax() {
		
		if(isset($this->request->post['shop_id']) AND $this->request->post['shop_id'] > 0){
			
			$shop_id = (int)$this->request->post['shop_id'];
			
		}elseif(isset($this->request->get['shop_id']) AND $this->request->get['shop_id'] > 0){
			
			$shop_id = (int)$this->request->get['shop_id'];

		}
		
		$this->load->model('catalog/shops');
		
		$shop = $this->model_catalog_shops->getShopInfo($shop_id);
			
		echo json_encode($shop);
		
		
	}
	
	public function getShopInfo($shop_id = 0) {
		
		$this->load->model('catalog/shops');
		
		$shop = $this->model_catalog_shops->getShopInfo($shop_id);
			
		return $shop;
		
		
	}
	
}
