<?php  
class ControllerModuleSkype extends Controller {
	protected function index() {
		$this->language->load('module/skype');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['code'] = html_entity_decode($this->config->get('skype_code'));
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/skype.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/skype.tpl';
		} else {
			$this->template = 'default/template/module/skype.tpl';
		}
		
		$this->render();
	}
}
?>