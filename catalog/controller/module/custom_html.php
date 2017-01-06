<?php  
class ControllerModuleCustomHTML extends Controller {
	protected function index($setting) {
		
		$this->language->load('module/custom_html');
		
    	$this->data['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
    	
		$this->data['message'] = html_entity_decode($setting['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/custom_html.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/custom_html.tpl';
		} else {
			$this->template = 'default/template/module/custom_html.tpl';
		}
		
		$this->render();
	}
}
?>