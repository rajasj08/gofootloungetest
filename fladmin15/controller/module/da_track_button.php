<?php
class ControllerModuleDaTrackButton extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->language('module/da_track_button');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_setting_setting->editSetting('da_track_button', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_get_track_button_code'] = $this->language->get('text_get_track_button_code');

		$this->data['entry_track_button'] = $this->language->get('entry_track_button');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['key'])) {
			$this->data['error_key'] = $this->error['key'];
		} else {
			$this->data['error_key'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/da_track_button', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/da_track_button', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');


		// START real data store
		if (isset($this->request->post['da_track_button_status'])) {
			$this->data['da_track_button_status'] = $this->request->post['da_track_button_status'];
		} else {
			$this->data['da_track_button_status'] = $this->config->get('da_track_button_status');
		}

		if (isset($this->request->post['da_track_button_aftership'])) {
			$this->data['da_track_button_aftership'] = $this->request->post['da_track_button_aftership'];
		} else {
			$this->data['da_track_button_aftership'] = $this->config->get('da_track_button_aftership');

			if ($this->data['da_track_button_aftership'] == '') {
				$this->data['da_track_button_aftership'] = '<div id="as-root"></div><script>(function(e,t,n){var r,i=e.getElementsByTagName(t)[0];if(e.getElementById(n))return;r=e.createElement(t);r.id=n;r.src="//apps.aftership.com/all.js";i.parentNode.insertBefore(r,i)})(document,"script","aftership-jssdk")</script>

				<div class="as-track-button" data-counter="false" data-support="true" data-width="200" data-size="large"></div>';
			}
		}
		// END real data store


		$this->data['modules'] = array();

		if (isset($this->request->post['da_track_button_module'])) {
			$this->data['modules'] = $this->request->post['da_track_button_module'];
		} elseif ($this->config->get('da_track_button_module')) {
			$this->data['modules'] = $this->config->get('da_track_button_module');
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/da_track_button.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}


	public function install()
	{
//		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "da_track_button` (
//        `store_id` int(11),
//        `track_button` text,
//        PRIMARY KEY (`store_id`)
//        )");
	}

	public function uninstall()
	{
		//$this->db->query("DROP TABLE " . DB_PREFIX . "da_track_button");
	}


}

?>
