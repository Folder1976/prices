<?php
class ModelLocalisationCurrency extends Model {
	public function getCurrencyByCode($currency) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "currency WHERE code = '" . $this->db->escape($currency) . "'");

		return $query->row;
	}

	public function getCurrencies() {
		$currency_data = $this->cache->get('currency');

		if (!$currency_data) {
			$currency_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency ORDER BY title ASC");

			foreach ($query->rows as $result) {
				$currency_data[$result['code']] = array(
					'currency_id'   => $result['currency_id'],
					'title'         => $result['title'],
					'code'          => $result['code'],
					'symbol_left'   => $result['symbol_left'],
					'symbol_right'  => $result['symbol_right'],
					'decimal_place' => $result['decimal_place'],
					'value'         => $result['value'],
					'status'        => $result['status'],
					'date_modified' => $result['date_modified']
				);
			}

			$this->cache->set('currency', $currency_data);
		}

		return $currency_data;
	}
	
	public function convert($value, $from, $to) {
		return $value * ($to / $from);
	}
	
	public function getCurrenciesLine() {
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE code = '".$this->session->data['currency']."' LIMIT 1");
		$selected_cur = $query->row;
		
		$currency_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency ORDER BY title ASC");

		foreach ($query->rows as $result) {
			
			if($result['code'] != $this->session->data['currency']){
			
				$value = $this->convert(1, $result['value'], $selected_cur['value'] );
				$last_value = $this->convert(1, $result['last_value'], $selected_cur['value']);
					
				$currency_data[$result['code']] = array(
					'currency_id'   => $result['currency_id'],
					'title'         => $result['title'],
					'code'          => $result['code'],
					'symbol_left'   => $result['symbol_left'],
					'symbol_right'  => $result['symbol_right'],
					'decimal_place' => $result['decimal_place'],
					'kurs'         => number_format($value, 2, '.', ''),
					'up_down'         => ($value > $last_value) ? '+':'-',
					'value'         => $result['value'],
					'last_value'    => $result['last_value'],
					'status'        => $result['status'],
					'date_modified' => $result['date_modified']
				);
			}
		}

	
		return $currency_data;
	}

}