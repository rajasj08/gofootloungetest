<?php
class ControllerModuleDaTrackButton extends Controller
{
	protected function index()
	{
		$this->language->load('module/da_track_button');

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['da_track_button_status'] = $this->config->get('da_track_button_status');

		$this->data['da_track_button_aftership'] = $this->config->get('da_track_button_aftership');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/da_track_button.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/da_track_button.tpl';
		} else {
			$this->template = 'default/template/module/da_track_button.tpl';
		}

		$this->render();
	}
}

?>
