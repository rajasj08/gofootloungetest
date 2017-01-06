<?php
/* This module is copywrite to ozxmod
 * Author: ozxmod(ozxmod@gmail.com)
 * It is illegal to remove this comment without prior notice to oxzmod(ozxmod@gmail.com)
*/ 
class ControllerModuleajaxfbgoogle extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/ajaxfbgoogle');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		$opencartversion = (int)VERSION.'.'.str_replace('.',"",substr(VERSION,2));

				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ajaxfbgoogle', $this->request->post);					
			$this->session->data['success'] = $this->language->get('text_success');						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();
		$this->data['languages'] = $languages;
		
		$this->data['text_modulesetting'] = $this->language->get('text_modulesetting');
		$this->data['entry_display_at_login'] = $this->language->get('entry_display_at_login');
		$this->data['entry_display_at_checkout'] = $this->language->get('entry_display_at_checkout');
		$this->data['entry_display'] = $this->language->get('entry_display');
		$this->data['entry_fb'] = $this->language->get('entry_fb');
		$this->data['entry_google'] = $this->language->get('entry_google');
		$this->data['entry_enable'] = $this->language->get('entry_enable');
		$this->data['entry_disable'] = $this->language->get('entry_disable');
		$this->data['text_apisetting'] = $this->language->get('text_apisetting');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_yes'] = $this->language->get('entry_yes');
		$this->data['entry_no'] = $this->language->get('entry_no');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['entry_apikey'] = $this->language->get('entry_apikey');
		$this->data['entry_apisecret'] = $this->language->get('entry_apisecret');
		$this->data['entry_googleapikey'] = $this->language->get('entry_googleapikey');
		$this->data['entry_googleapisecret'] = $this->language->get('entry_googleapisecret');
		
		$this->data['text_newfbapp'] = $this->language->get('text_newfbapp');
		$this->data['text_googlenote'] = $this->language->get('text_googlenote');
		$this->data['text_newgoogleapp'] = $this->language->get('text_newgoogleapp');
				
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/ajaxfbgoogle', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/ajaxfbgoogle', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();

		foreach ($languages as $language) {
			if (isset($this->request->post['ajaxfbgoogle_button_' . $language['language_id']])) {
				$this->data['ajaxfbgoogle_button_' . $language['language_id']] = $this->request->post['ajaxfbgoogle_button_' . $language['language_id']];
			} else {
				$this->data['ajaxfbgoogle_button_' . $language['language_id']] = $this->config->get('ajaxfbgoogle_button_' . $language['language_id']);
			}
		}
		
		if (isset($this->request->post['ajaxfbgoogle_display_at_login'])) {
			$this->data['ajaxfbgoogle_display_at_login'] = $this->request->post['ajaxfbgoogle_display_at_login'];
		} elseif ($this->config->get('ajaxfbgoogle_display_at_login')) {
			$this->data['ajaxfbgoogle_display_at_login'] = $this->config->get('ajaxfbgoogle_display_at_login');
		} else $this->data['ajaxfbgoogle_display_at_login'] = '';

		if (isset($this->request->post['ajaxfbgoogle_display_at_checkout'])) {
			$this->data['ajaxfbgoogle_display_at_checkout'] = $this->request->post['ajaxfbgoogle_display_at_checkout'];
		} elseif ($this->config->get('ajaxfbgoogle_display_at_checkout')) {
			$this->data['ajaxfbgoogle_display_at_checkout'] = $this->config->get('ajaxfbgoogle_display_at_checkout');
		} else $this->data['ajaxfbgoogle_display_at_checkout'] = '';
		
		
		if (isset($this->request->post['ajaxfbgoogle_display_fb'])) {
			$this->data['ajaxfbgoogle_display_fb'] = $this->request->post['ajaxfbgoogle_display_fb'];
		} elseif ($this->config->get('ajaxfbgoogle_display_fb')) {
			$this->data['ajaxfbgoogle_display_fb'] = $this->config->get('ajaxfbgoogle_display_fb');
		} else $this->data['ajaxfbgoogle_display_fb'] = '';
		
		if (isset($this->request->post['ajaxfbgoogle_display_google'])) {
			$this->data['ajaxfbgoogle_display_google'] = $this->request->post['ajaxfbgoogle_display_google'];
		} elseif ($this->config->get('ajaxfbgoogle_display_google')) {
			$this->data['ajaxfbgoogle_display_google'] = $this->config->get('ajaxfbgoogle_display_google');
		} else $this->data['ajaxfbgoogle_display_google'] = '';
		
		if (isset($this->request->post['ajaxfbgoogle_status'])) {
			$this->data['ajaxfbgoogle_status'] = $this->request->post['ajaxfbgoogle_status'];
		} elseif ($this->config->get('ajaxfbgoogle_status')) {
			$this->data['ajaxfbgoogle_status'] = $this->config->get('ajaxfbgoogle_status');
		} else $this->data['ajaxfbgoogle_status'] = '';
		
		

		if (isset($this->request->post['ajaxfbgoogle_apikey'])) {
			$this->data['ajaxfbgoogle_apikey'] = $this->request->post['ajaxfbgoogle_apikey'];
		} elseif ($this->config->get('ajaxfbgoogle_apikey')) { 
			$this->data['ajaxfbgoogle_apikey'] = $this->config->get('ajaxfbgoogle_apikey');
		} else $this->data['ajaxfbgoogle_apikey'] = '';

		if (isset($this->request->post['ajaxfbgoogle_apisecret'])) {
			$this->data['ajaxfbgoogle_apisecret'] = $this->request->post['ajaxfbgoogle_apisecret'];
		} elseif ($this->config->get('ajaxfbgoogle_apisecret')) { 
			$this->data['ajaxfbgoogle_apisecret'] = $this->config->get('ajaxfbgoogle_apisecret');
		} else $this->data['ajaxfbgoogle_apisecret'] = '';
		
		if (isset($this->request->post['ajaxfbgoogle_googleapikey'])) {
			$this->data['ajaxfbgoogle_googleapikey'] = $this->request->post['ajaxfbgoogle_googleapikey'];
		} elseif ($this->config->get('ajaxfbgoogle_googleapikey')) {
			$this->data['ajaxfbgoogle_googleapikey'] = $this->config->get('ajaxfbgoogle_googleapikey');
		} else $this->data['ajaxfbgoogle_googleapikey'] = '';
		
		if (isset($this->request->post['ajaxfbgoogle_googleapisecret'])) {
			$this->data['ajaxfbgoogle_googleapisecret'] = $this->request->post['ajaxfbgoogle_googleapisecret'];
		} elseif ($this->config->get('ajaxfbgoogle_googleapisecret')) {
			$this->data['ajaxfbgoogle_googleapisecret'] = $this->config->get('ajaxfbgoogle_googleapisecret');
		} else $this->data['ajaxfbgoogle_googleapisecret'] = '';
		
				
		if (isset($this->request->post['ajaxfbgoogle'])) {
			$this->data['modules'] = $this->request->post['ajaxfbgoogle'];
		} elseif ($this->config->get('ajaxfbgoogle')) { 
			$this->data['modules'] = $this->config->get('ajaxfbgoogle');
		}		
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/ajaxfbgoogle.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ajaxfbgoogle')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['ajaxfbgoogle_apikey'] || !$this->request->post['ajaxfbgoogle_apisecret'] || !$this->request->post['ajaxfbgoogle_googleapikey'] || !$this->request->post['ajaxfbgoogle_googleapisecret']) {
			//$this->error['code'] = $this->language->get('error_code');
			$this->error['warning'] = $this->language->get('error_code');
		}
		
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}

/* This module is copywrite to ozxmod
 * Author: ozxmod(ozxmod@gmail.com)
 * It is illegal to remove this comment without prior notice to oxzmod(ozxmod@gmail.com)
*/ 
?>