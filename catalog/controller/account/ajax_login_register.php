<?php
/* This module is copywrite to ozxmod
 * Author: ozxmod(ozxmod@gmail.com)
* It is illegal to remove this comment without prior notice to ozxmod(ozxmod@gmail.com)
*/
class ControllerAccountAjaxLoginRegister extends Controller {
	private $error;
	public function validateAjaxLogin(){
	
		$this->language->load('account/ajax_login_register');
		$json = array();
		
		if(!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['ajax_email'])){
			$json["error"] = $this->language->get('error_email');
		}else if (!$this->customer->login($this->request->post['ajax_email'], $this->request->post['ajax_password'])) {
			$json['error'] = $this->language->get('error_login');
		}else{
			$json['success'] = $this->language->get('text_success');
		}
		if ($this->customer->isLogged()) {
			$json['redirect']=$this->url->link('account/account', '', 'SSL');
		}
		
		return	$this->response->setOutput(json_encode($json));
	}
	
	public function ajaxregister(){
		
		$this->language->load('account/ajax_login_register');
		
		$this->load->model('account/customer');
		
		$json = array();
		$data = array();
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$email = $this->request->post["ajax_register_email"];
			$password = $this->request->post["ajax_register_password"];
			$re_password = $this->request->post["re_ajax_register_password"];
			$robotics = $this->request->post["robotest"];
		
			 if($robotest){
     		 $json["error"] = $this->language->get('error_email');
			 }
			if(!empty($email) && !empty($password) && !empty($re_password)){
				if(!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)){
					$json["error"] = $this->language->get('error_email');
				} else if($password != $re_password){
					$json["error"] = $this->language->get("error_password_match");
				} else if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['ajax_register_email'])) {
					$json["error"] = $this->language->get('error_exists');
				}else {
					
					$name_arr = explode('@',$email);
					
					$config_customer_approval = $this->config->get('config_customer_approval');
					$this->config->set('config_customer_approval',0);
					
					$this->request->post['email'] = $email;
						
					$add_data=array();
					$add_data['email'] = $email;
					$add_data['password'] = $password;
					$add_data['firstname'] = $name_arr[0];
					$add_data['lastname'] = '';
					$add_data['fax'] = '';
					$add_data['telephone'] = '';
					$add_data['company'] = '';
					$add_data['company_id'] = '';
					$add_data['tax_id'] = '';
					$add_data['address_1'] = '';
					$add_data['address_2'] = '';
					$add_data['city'] = '';
					$add_data['city_id'] = '';
					$add_data['postcode'] = '';
					$add_data['country_id'] = 0;
					$add_data['zone_id'] = 0;
					
					$this->model_account_customer->addCustomer($add_data);
					$this->config->set('config_customer_approval',$config_customer_approval);
					
					if($this->customer->login($email, $password)){
						// Delete address
						$this->deleteAddress();
							
						unset($this->session->data['guest']);
						$json['success'] = "Success";
						$json['redirect'] = $this->url->link('account/success');
					}
				}
			}else{
				$json["error"] = $this->language->get('error_all_fields');
			}
		} else{
			$json["error"] = $this->language->get('error_hack');
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function sendForgotPassword(){
		$json = array();
		
		$this->language->load('account/ajax_login_register');
		
		if($this->validate()) {
		$this->language->load('mail/forgotten');
		
		$password = substr(sha1(uniqid(mt_rand(), true)), 0, 10);
		
		$this->model_account_customer->editPassword($this->request->post['ajax_forgot_email'], $password);
		
		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
		
		$message  = sprintf($this->language->get('text_greeting'), $this->config->get('config_name')) . "\n\n";
		$message .= $this->language->get('text_password') . "\n\n";
		$message .= $password;
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');
		$mail->setTo($this->request->post['ajax_forgot_email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();
		
		$json['success'] = sprintf($this->language->get('text_email_sent'), $this->request->post['ajax_forgot_email']);
		
		} else {
			$json["error"] = $this->language->get('error_no_accounts');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	protected function validate() {
		$this->load->model("account/customer");
		
		if (!isset($this->request->post['ajax_forgot_email'])) {
			$this->error['warning'] = $this->language->get('error_ajax_forgot_email');
		} elseif (!$this->model_account_customer->getTotalCustomersByEmail($this->request->post['ajax_forgot_email'])) {
			$this->error['warning'] = $this->language->get('error_ajax_forgot_email');
		}
	
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	public function fblogin() {
		$a = "";
		$loc = $this->url->link("account/account", "", 'SSL');
		
		if(isset($this->session->data['ajaxfblogin_from'])) {
			$a= $this->session->data['ajaxfblogin_from'];
			unset($this->session->data['ajaxfblogin_from']);
		}
		
		if(isset($this->session->data['ajaxfblogin_loc'])) {
			$loc = urldecode($this->session->data['ajaxfblogin_loc']);
			unset($this->session->data['ajaxfblogin_loc']);
			
			$loc_arr = explode("route=", $loc);
			
			if(isset($loc_arr[1]) && $loc_arr[1] == "account/logout")
				$loc = $this->url->link("account/account", '', "SSL");
		}
		
		if ($this->customer->isLogged())	
			$this->redirect($loc);
		 
		if(!isset($this->myfbconnect)){
						
			require_once(DIR_SYSTEM . 'social-login/facebook-sdk/facebook.php');
	
			$this->myfbconnect = new Facebook(array(
					'appId'  => $this->config->get('ajaxfbgoogle_apikey'),
					'secret' => $this->config->get('ajaxfbgoogle_apisecret'),
			));
		}
	
		$_SERVER_CLEANED = $_SERVER;
		$_SERVER = $this->clean_decode($_SERVER);
	
		$fbuser = $this->myfbconnect->getUser();
		$fbuser_profile = null;
		if ($fbuser){
			try {
				$fbuser_profile = $this->myfbconnect->api("/$fbuser");
			} catch (FacebookApiException $e) {
				error_log($e);
				$fbuser = null;
			}
		}
	
		$_SERVER = $_SERVER_CLEANED;
	
		if($fbuser_profile['id'] && $fbuser_profile['email']){
			$this->load->model('account/customer');
	
			$email = $fbuser_profile['email'];
			$password = $this->get_password($fbuser_profile['id']);
			if($this->customer->login($email, $password, true)){
				if($a=='checkout') {
					$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
				} else {
					$this->redirect($loc);
				}
			}
	
			$email_query = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "'");
			if($email_query->num_rows){
				//$this->model_account_customer->editPassword($email, $password);
				if($this->customer->login($email, $password, true)){
					if($a=='checkout') {
						$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
					} else{
						$this->redirect($loc);
					}
				}
			}
			else{
	
				$config_customer_approval = $this->config->get('config_customer_approval');
				$this->config->set('config_customer_approval',0);
	
				$this->request->post['email'] = $email;
					
				$add_data=array();
				$add_data['email'] = $fbuser_profile['email'];
				$add_data['password'] = $password;
				$add_data['firstname'] = isset($fbuser_profile['first_name']) ? $fbuser_profile['first_name'] : '';
				$add_data['lastname'] = isset($fbuser_profile['last_name']) ? $fbuser_profile['last_name'] : '';
				$add_data['fax'] = '';
				$add_data['telephone'] = '';
				$add_data['company'] = '';
				$add_data['company_id'] = '';
				$add_data['tax_id'] = '';
				$add_data['address_1'] = '';
				$add_data['address_2'] = '';
				$add_data['city'] = '';
				$add_data['city_id'] = '';
				$add_data['postcode'] = '';
				$add_data['country_id'] = 0;
				$add_data['zone_id'] = 0;
	
				$this->model_account_customer->addCustomer($add_data);
				$this->config->set('config_customer_approval',$config_customer_approval);
	
				if($this->customer->login($email, $password, true)){
					
					// Delete address
					$this->deleteAddress();
					
					unset($this->session->data['guest']);
					if($a=='checkout')
					{
						$this->redirect($this->url->link('checkout/checkout'));
					}
					else{
						$this->redirect($loc);
					}
				}
			}
	
		}
		$this->redirect($loc);
		
	}
	
	// Google Login Code
	
	public function glogin() {
		
		require_once DIR_SYSTEM.'social-login/google/src/apiClient.php';
		require_once DIR_SYSTEM.'social-login/google/src/contrib/apiOauth2Service.php';
		
		$client = new apiClient();
		$client->setApplicationName("Google+ PHP Starter Application");
		// Visit https://code.google.com/apis/console to generate your
		// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
		$client->setClientId($this->config->get('ajaxfbgoogle_googleapikey'));
		$client->setClientSecret($this->config->get('ajaxfbgoogle_googleapisecret'));
		$client->setRedirectUri($this->url->link('account/ajax_login_register/glogin', '', 'SSL'));
		$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));
		$client->setDeveloperKey('');
		$plus = new apiOauth2Service($client);
		
		if (isset($_REQUEST['logout'])) {
			unset($_SESSION['access_token']);
		}
		
		if (isset($_GET['code'])) {
			$client->authenticate($_GET['code']);
			$access_token = $client->getAccessToken();
			$client->setAccessToken($access_token);
			//header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
		}
		
		if ($client->getAccessToken()) {
			$userinfo = $plus->userinfo;
			$data = $userinfo->get();
		 
			$a = "";
			$loc = $this->url->link("account/account", "", 'SSL');
			
			
			if(isset($this->session->data['ajaxfblogin_from'])) {
				$a= $this->session->data['ajaxfblogin_from'];
				unset($this->session->data['ajaxfblogin_from']);
			}
			
			if(isset($this->session->data['ajaxfblogin_loc'])) {
				$loc = urldecode($this->session->data['ajaxfblogin_loc']);
				unset($this->session->data['ajaxfblogin_loc']);
				
				$loc_arr = explode("route=", $loc);
					
				if(isset($loc_arr[1]) && $loc_arr[1] == "account/logout")
					$loc = $this->url->link("account/account", '', "SSL");
				
			}
			
			$this->load->model('account/customer');

			// Checking email id if already registered
			$email = $data["email"];
			$password = $this->get_password($email);

			if($this->customer->login($email, $password, true)){
				if($a=='checkout') {
					$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
				} else {
					$this->redirect($loc);
				}
			}

			$email_query = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "'");

			if($email_query->num_rows){
				//$this->model_account_customer->editPassword($email, $password);
				if($this->customer->login($email, $password, true)){
					if($a=='checkout'){
						$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
					} else {
						$this->redirect($loc);
					}
				}
			} else {
				$name = $data['name'];
				$name_split = explode(" ", $name);
				
				$f_name = $name_split[0];
				$l_name = '';
				if(isset($name_split[1]))
					$l_name = $name_split[1];
				
				if(isset($name_split[2]))
					$l_name .= $name_split[2];
					
				$config_customer_approval = $this->config->get('config_customer_approval');
				$this->config->set('config_customer_approval',0);
					
				$this->request->post['email'] = $email;

				$add_data=array();
				$add_data['email'] = $email;
				$add_data['password'] = $password;
				$add_data['firstname'] = $f_name;
				$add_data['lastname'] = $l_name;
				$add_data['fax'] = '';
				$add_data['telephone'] = '';
				$add_data['company'] = '';
				$add_data['company_id'] = '';
				$add_data['tax_id'] = '';
				$add_data['address_1'] = '';
				$add_data['address_2'] = '';
				$add_data['city'] = '';
				$add_data['city_id'] = '';
				$add_data['postcode'] = '';
				$add_data['country_id'] = 0;
				$add_data['zone_id'] = 0;
					
				$this->model_account_customer->addCustomer($add_data);
				$this->config->set('config_customer_approval',$config_customer_approval);
				
					
				if($this->customer->login($email, $password, true)){
					
					// Delete address
					$this->deleteAddress();
					
					
					unset($this->session->data['guest']);
					if($a=='checkout')
					{
						$this->redirect($this->url->link('checkout/checkout'));
					}
					else{
						$this->redirect($loc);
					}
				}
			}
		}else{
			$this->redirect($this->url->link('common/home'));		
		}
	}
	
	// End Google Login Code
	
	
	private function get_password($str) {
		$password = 'newpassword';
		$password.=substr('74993889fa88dc03c2e6b83bab88e845',0,3).substr($str,0,3).substr('74993889fa88dc03c2e6b83bab88e845',-3).substr($str,-3);
		return strtolower($password);
	}
	
	private function clean_decode($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				unset($data[$key]);
				$data[$this->clean_decode($key)] = $this->clean_decode($value);
			}
		} else {
			$data = htmlspecialchars_decode($data, ENT_COMPAT);
		}
	
		return $data;
	}
	
	private function deleteAddress(){
		$customer_id = $this->session->data['customer_id'];
		$this->db->query("DELETE FROM ".DB_PREFIX."address WHERE customer_id = '".(int)$customer_id."' AND country_id=0 AND zone_id = 0 ");	
	}
	
	
}

/* This module is copywrite to ozxmod
 * Author: ozxmod(ozxmod@gmail.com)
* It is illegal to remove this comment without prior notice to ozxmod(ozxmod@gmail.com)
*/
?>