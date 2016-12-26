<?php
class ModelAccountCustomer extends Model {
	
	
	public function isDuplicate($data) {

		if(!isset($data['social_fb']) OR isset($data['social_vk']) OR isset($data['social_go'])){
			return false;
		}
		
		if(isset($data['social_fb']) AND isset($data['social_vk']) AND isset($data['social_go']) AND isset($data['email'])
			AND $data['social_fb'] == '' AND $data['social_vk'] == '' AND $data['social_go'] == '' AND $data['email'] == ''){
				return true;
			
		}
		
		$sql = 'SELECT customer_id FROM ' . DB_PREFIX . 'customer
					WHERE
					social_fb = "' . $this->db->escape($data['social_fb']) . '" OR
					social_vk = "' . $this->db->escape($data['social_vk']) . '" OR
					social_go = "' . $this->db->escape($data['social_go']) . '" OR
					email = "' . $this->db->escape($data['email']) . '"
					LIMIT 0, 1;';
		
		$r = $this->db->query($sql);
		
		if($r->num_rows){
			return true;
		}
		
		return false;
	}
	
	public function addCustomer($data) {
		$this->event->trigger('pre.customer.add', $data);

		if(isset($data['customer_group_id']) AND $data['customer_group_id'] == 3){
			$customer_group_id = 3;
		}else{
			if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
				$customer_group_id = $data['customer_group_id'];
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}
		}
			
		$this->load->model('account/customer_group');

		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

		if(!isset($data['social_fb'])) $data['social_fb'] = '';
		if(!isset($data['social_vk'])) $data['social_vk'] = '';
		if(!isset($data['social_go'])) $data['social_go'] = '';
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET
							customer_group_id = '" . (int)$customer_group_id . "',
							
							social_fb = '" . $this->db->escape($data['social_fb']) . "',
							social_vk = '" . $this->db->escape($data['social_vk']) . "',
							social_go = '" . $this->db->escape($data['social_go']) . "',
							
							store_id = '" . (int)$this->config->get('config_store_id') . "',
							firstname = '" . $this->db->escape($data['firstname']) . "',
							lastname = '" . $this->db->escape($data['lastname']) . "',
							email = '" . $this->db->escape($data['email']) . "',
							telephone = '" . $this->db->escape($data['telephone']) . "',
							fax = '" . $this->db->escape($data['fax']) . "',
							custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '') . "',
							salt = '" . $this->db->escape($salt = token(9)) . "',
							password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "',
							newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "',
							ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "',
							status = '1',
							approved = '" . (int)!$customer_group_info['approval'] . "',
							date_added = NOW()");

		$customer_id = $this->db->getLastId();

		$this->db->query("INSERT INTO " . DB_PREFIX . "address SET
									customer_id = '" . (int)$customer_id . "',
									firstname = '" . $this->db->escape($data['firstname']) . "',
									lastname = '" . $this->db->escape($data['lastname']) . "',
									company = '" . $this->db->escape($data['company']) . "',
									address_1 = '" . $this->db->escape($data['address_1']) . "',
									address_2 = '" . $this->db->escape($data['address_2']) . "',
									city = '" . $this->db->escape($data['city']) . "',
									postcode = '" . $this->db->escape($data['postcode']) . "',
									country_id = '" . (int)$data['country_id'] . "',
									zone_id = '" . (int)$data['zone_id'] . "',
									custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? json_encode($data['custom_field']['address']) : '') . "'");

		$address_id = $this->db->getLastId();

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");

		$this->load->language('mail/customer');

		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

		$message = sprintf($this->language->get('text_welcome'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";

		if (!$customer_group_info['approval']) {
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}

		$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

		if(isset($data['email']) AND $data['email'] != ''){
			
			$this->mail = new Mail();
			$this->mail->setTo($data['email']);
			$this->mail->setFrom('no-reply@fashion-u.com.ua'); 
			$this->mail->setSender('no-reply@fashion-u.com.ua'); 
			$this->mail->setSubject('Fashion востановление пароля');
			$this->mail->setText($message);
			$this->mail->setHtml($message);
			$test = $this->mail->send();

		}
		
		// Send to main admin email if new account email is enabled
		if ($this->config->get('config_account_mail') AND isset($data['email']) AND $data['email'] != '') {
			$message  = $this->language->get('text_signup') . "\n\n";
			$message .= $this->language->get('text_website') . ' ' . html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8') . "\n";
			$message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
			$message .= $this->language->get('text_lastname') . ' ' . $data['lastname'] . "\n";
			$message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";
			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";
			
			$this->mail = new Mail();
			$this->mail->setFrom('no-reply@fashion-u.com.ua'); 
			$this->mail->setSender('no-reply@fashion-u.com.ua'); 
			$this->mail->setSubject('Fashion востановление пароля');
			$this->mail->setText($message);
			$this->mail->setHtml($message);
		
			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_mail_alert'));

			foreach ($emails as $email) {
				if (utf8_strlen($email) > 0 && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
					$this->mail->setTo($email);
					$this->mail->send();
				}
			}
		}

		$this->event->trigger('post.customer.add', $customer_id);

		return $customer_id;
	}

	public function editCustomer($data) {
		$this->event->trigger('pre.customer.edit', $data);

		$customer_id = $this->customer->getId();

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "' WHERE customer_id = '" . (int)$customer_id . "'");

		$this->event->trigger('post.customer.edit', $customer_id);
	}

	public function editPassword($email, $password) {
		$this->event->trigger('pre.customer.edit.password');

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		$this->event->trigger('post.customer.edit.password');
	}

	public function editNewsletter($newsletter) {
		$this->event->trigger('pre.customer.edit.newsletter');

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		$this->event->trigger('post.customer.edit.newsletter');
	}

	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT DISTINCT C.*, CS.shop_id AS customer_shop_id
										FROM " . DB_PREFIX . "customer C
										LEFT JOIN " . DB_PREFIX . "customer_shops CS ON C.customer_id = CS.customer_id
										WHERE C.customer_id = '" . (int)$customer_id . "'");
		return $query->row;
	}

	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getCustomerByToken($token) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");

		return $query->row;
	}

	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row['total'];
	}

	public function getRewardTotal($customer_id) {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row['total'];
	}

	public function getIps($customer_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->rows;
	}

	public function addLoginAttempt($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_login WHERE email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

		if (!$query->num_rows) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_login SET email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query->row['customer_login_id'] . "'");
		}
	}

	public function getLoginAttempts($email) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function deleteLoginAttempts($email) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}
}
