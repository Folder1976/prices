<?php
class ControllerCheckoutDelivery extends Controller {
	public function index() {
	}

	public function getDeliveryOnCountryId() {
		$json = array();

		$json = $this->getDeliveryOnCountryIdArray();
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function getDeliveryOnCountryIdArray() {
		$json = array();

		
		if (isset($this->request->post['country_id'])) {
			$this->session->data['country_id'] = $country_id = (int)$this->request->post['country_id'];
		}elseif (isset($this->session->data['country_id'])) {
			$country_id = (int)$this->session->data['country_id'];
		}else {
			$this->session->data['country_id'] = $country_id = 176;
		}

		if (isset($this->request->post['country_code'])) {
			$this->load->model('localisation/country');
			$this->session->data['country_code'] = $this->request->post['country_code'];
			$country_info = $this->model_localisation_country->getCountryOnCode($this->request->post['country_code']);
			$country_id = $country_info['country_id'];
		}else{
			$country_info = $this->model_localisation_country->getCountry($country_id);
			$this->session->data['country_code'] = $country_info['iso_code_2'];
		}
		
		$this->load->model('checkout/delivery');

		if(is_numeric($country_id)){
			$json = $this->model_checkout_delivery->getDeliveryOnCountryId($country_id);
		}else{
			$json = $this->model_checkout_delivery->getDeliveryOnCountryCode($country_id);	
		}
		
		if(!$json){
			$json = $this->model_checkout_delivery->getDeliveryOnCountryId(176);
		}
		
		$this->session->data['country_id'] = $country_id;
		
		foreach($json as $index => $row){
			
			$json[$index]['realprice'] = number_format($this->currency->convert($row['price'], $row['code'], $this->session->data['currency']),2,'.',' ');
			$json[$index]['real_simbol_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
			$json[$index]['real_simbol_right'] = $this->currency->getSymbolRight($this->session->data['currency']);
			
		}
		
	
		return $json;
	}

	
	
}
