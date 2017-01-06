<?php
class ControllerModuleCustomHTML extends Controller {
	private $error = array(); 

	public function get_list_of_pages(){
		$this->language->load('module/custom_html');
		$this->pages= array(
		"blog_locator"=>array(
		'label'=>$this->language->get('text_btn_go_to_custom_html_locator'),
		'url'=>$this->url->link('module/custom_html/locator', 'token=' . $this->session->data['token'], 'SSL')
		),
		);
		
		return $this->pages;
	}
	
	public function index() {
		$this->language->load('module/custom_html');
		$this->load->model('setting/setting');

		$this->document->setTitle($this->language->get('heading_title'));
		
		// Start Get Text
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_title_dashboard'] = $this->language->get('heading_title_dashboard');
		$this->data['description'] = $this->language->get('description');
		$this->data['text_btn_go_to_lookbook_category'] = $this->language->get('text_btn_go_to_lookbook_category');
		$this->data['text_btn_go_to_lookbook_products'] = $this->language->get('text_btn_go_to_lookbook_products');
		$this->data['text_btn_place_your_lookbook_on_opencart_page'] = $this->language
		->get('text_btn_place_your_lookbook_on_opencart_page');
		
		$this->data['text_btn_back'] = $this->language->get('text_btn_back');
		$this->data['button_save'] = $this->language->get('button_save');
		
		$this->data['pages']= $this->get_list_of_pages();
		// End Get Text
		
		$this->data['edit_link']= $this->url->link('module/email_template_manager/edit_template', 'token=' . 
		$this->session->data['token'], 'SSL');
	
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];	
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
				
		// Start BreadCrumb Trail
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_modules'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_custom_html_dashboard'),
			'href'      => $this->url->link('module/custom_html', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		// End BreadCrumb Trail
				
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . 
		$this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->template = 'module/custom_html/dashboard.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	public function locator() {   
		$this->language->load('module/custom_html/locator');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('setting/store');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ( isset($this->request->post['action']) && 
		$this->request->post['action'] == "save" ) && $this->validate()) {
			$POST= $this->request->post;
			
			$store_id= ( isset($this->request->post['store_id']) ) ? $this->request->post['store_id'] : 0;
			unset($POST['store_id'], $POST['action']);
			$this->model_setting_setting->editSetting('custom_html', $POST, $store_id);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('module/custom_html', 'token=' . 
			$this->session->data['token'], 'SSL'));
		}
		
		$store_id= ( isset($this->request->post['store_id']) ) ? $this->request->post['store_id'] : 0;
		$this->data['heading_title'] = ( isset($this->request->post['store_id']) ) ? $this->language->get('heading_title') : 
		$this->language->get('heading_title_multi_store');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['entry_multi_store'] = $this->language->get('entry_multi_store');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		
		$this->data['text_btn_set'] = $this->language->get('text_btn_set');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
		$this->data['tab_module'] = $this->language->get('tab_module');
		
		// Get MultiStore Support
		$stores= array(
		array('store_id'=>0, 'name'=>'Default'),
		);
		$stores_extended= $this->model_setting_store->getStores();
		$stores= array_merge($stores, $stores_extended);
		$this->data['stores']= $stores;
		$this->data['store_id']= $store_id;
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		// Start BreadCrumb Trail
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_modules'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_custom_html_dashboard'),
			'href'      => $this->url->link('module/custom_html', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_custom_html_locator'),
			'href'      => $this->url->link('module/custom_html/locator', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		// End BreadCrumb Trail
		
		$this->data['action'] = $this->url->link('module/custom_html/locator', 
		'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];

		$this->data['modules'] = array();
		
		if (isset($this->request->post['custom_html_module']) ) {
			$this->data['modules'] = $this->request->post['custom_html_module'];
		} elseif ($this->config->get('custom_html_module')) { 
			$res = $this->model_setting_setting->getSetting('custom_html', $store_id);
			$this->data['modules'] = ( ! empty($res['custom_html_module']) ) ? $res['custom_html_module'] : array();
		}
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		
		if( $this->request->server['REQUEST_METHOD'] != "POST" ){
			$this->template = 'module/custom_html/select_store.tpl';
		}else{
			$this->template = 'module/custom_html/locator.tpl';
		}
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/custom_html')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>