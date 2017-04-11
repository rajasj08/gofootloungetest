<?php
class ControllerPaymentccavenue extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/ccavenue');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->request->post['ccavenue_action']='https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
			$this->model_setting_setting->editSetting('ccavenue', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_redirect'] = $this->language->get('text_redirect');
		$this->data['text_iframe'] = $this->language->get('text_iframe');
		

		$this->data['entry_Merchant_Id'] = $this->language->get('entry_Merchant_Id');
		$this->data['entry_action'] = $this->language->get('entry_action');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_workingkey'] = $this->language->get('entry_workingkey');
		$this->data['entry_access_code'] = $this->language->get('entry_access_code');
		$this->data['entry_completed_status'] = $this->language->get('entry_completed_status');
		$this->data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$this->data['entry_pending_status'] = $this->language->get('entry_pending_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_checkout_method'] = $this->language->get('entry_checkout_method');
		$this->data['help_checkout_method'] = $this->language->get('help_checkout_method');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['Merchant_Id'])) {
			$this->data['error_Merchant_Id'] = $this->error['Merchant_Id'];
		} else {
			$this->data['error_Merchant_Id'] = '';
		}
		if (isset($this->error['access_code'])) {
			$this->data['error_access_code'] = $this->error['access_code'];
		} else {
			$this->data['error_access_code'] = '';
		}
		if (isset($this->error['total'])) {
			$this->data['error_total'] = $this->error['total'];
		} else {
			$this->data['error_total'] = '';
		}
		if (isset($this->error['workingkey'])) {
			$this->data['error_workingkey'] = $this->error['workingkey'];
		} else {
			$this->data['error_workingkey'] = '';
		}


		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/ccavenue', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/ccavenue', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['ccavenue_Merchant_Id'])) {
			$this->data['ccavenue_Merchant_Id'] = $this->request->post['ccavenue_Merchant_Id'];
		} else {
			$this->data['ccavenue_Merchant_Id'] = $this->config->get('ccavenue_Merchant_Id');
		}

			
		if (isset($this->request->post['ccavenue_total'])) {
			$this->data['ccavenue_total'] = $this->request->post['ccavenue_total'];
		} else {
			$this->data['ccavenue_total'] = $this->config->get('ccavenue_total'); 
		} 
	
		if (isset($this->request->post['ccavenue_action'])) {
			$this->data['ccavenue_action'] = $this->request->post['ccavenue_action'];
		} else {
			$this->data['ccavenue_action'] = $this->config->get('ccavenue_action'); 
		} 
		if (isset($this->request->post['ccavenue_access_code'])) {
			$this->data['ccavenue_access_code'] = $this->request->post['ccavenue_access_code'];
		} else {
			$this->data['ccavenue_access_code'] = $this->config->get('ccavenue_access_code'); 
		} 
		
		if (isset($this->request->post['ccavenue_workingkey'])) {
			$this->data['ccavenue_workingkey'] = $this->request->post['ccavenue_workingkey'];
		} else {
			$this->data['ccavenue_workingkey'] = $this->config->get('ccavenue_workingkey'); 
		} 

		
		if (isset($this->request->post['ccavenue_completed_status_id'])) {
			$this->data['ccavenue_completed_status_id'] = $this->request->post['ccavenue_completed_status_id'];
		} else {
			$this->data['ccavenue_completed_status_id'] = $this->config->get('ccavenue_completed_status_id');
		}	
		
			
		if (isset($this->request->post['ccavenue_failed_status_id'])) {
			$this->data['ccavenue_failed_status_id'] = $this->request->post['ccavenue_failed_status_id'];
		} else {
			$this->data['ccavenue_failed_status_id'] = $this->config->get('ccavenue_failed_status_id');
		}	
								
		if (isset($this->request->post['ccavenue_pending_status_id'])) {
			$this->data['ccavenue_pending_status_id'] = $this->request->post['ccavenue_pending_status_id'];
		} else {
			$this->data['ccavenue_pending_status_id'] = $this->config->get('ccavenue_pending_status_id');
		}
									
		

		if (isset($this->request->post['ccavenue_voided_status_id'])) {
			$this->data['ccavenue_voided_status_id'] = $this->request->post['ccavenue_voided_status_id'];
		} else {
			$this->data['ccavenue_voided_status_id'] = $this->config->get('ccavenue_voided_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['ccavenue_geo_zone_id'])) {
			$this->data['ccavenue_geo_zone_id'] = $this->request->post['ccavenue_geo_zone_id'];
		} else {
			$this->data['ccavenue_geo_zone_id'] = $this->config->get('ccavenue_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['ccavenue_checkout_method'])) {
			$this->data['ccavenue_checkout_method'] = $this->request->post['ccavenue_checkout_method'];
		} else {
			$this->data['ccavenue_checkout_method'] = $this->config->get('ccavenue_checkout_method');
		}
		
		if (isset($this->request->post['ccavenue_status'])) {
			$this->data['ccavenue_status'] = $this->request->post['ccavenue_status'];
		} else {
			$this->data['ccavenue_status'] = $this->config->get('ccavenue_status');
		}
		
		if (isset($this->request->post['ccavenue_sort_order'])) {
			$this->data['ccavenue_sort_order'] = $this->request->post['ccavenue_sort_order'];
		} else {
			$this->data['ccavenue_sort_order'] = $this->config->get('ccavenue_sort_order');
		}

		$this->template = 'payment/ccavenue.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/ccavenue')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!isset($this->request->post['ccavenue_Merchant_Id'])) {
			$this->error['Merchant_Id'] = $this->language->get('error_Merchant_Id');
		}
		if (!isset($this->request->post['ccavenue_Merchant_Id'])) {
			$this->error['Merchant_Id'] = $this->language->get('error_Merchant_Id');
		}
		if (!isset($this->request->post['ccavenue_total'])) {
			$this->error['total'] = $this->language->get('error_total');
		}		
		if (!isset($this->request->post['ccavenue_access_code'])) {
			$this->error['access_code'] = $this->language->get('error_access_code');
		}
		if (!isset($this->request->post['ccavenue_workingkey'])) {
			$this->error['workingkey'] = $this->language->get('error_workingkey');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>