<?php

// ***************************************************
//                  Search Analytics    
//  
//       Standalone extension and component of 
//               Advanced Smart Search
//
// Author : Francesco Pisanò - francesco1279@gmail.com
//              
//                   www.leverod.com		
//               © All rights reserved	  
// ***************************************************


class ControllerModuleSearchAnalytics extends Controller {
	
	private $error = array(); 

	private $page;
	private $match_type;
	private $filter_date_start;
	private $filter_date_end;
	private $filter_keyphrases;
	
	
	public function __construct($params) {
		
		parent::__construct($params); // In this way we can declare a constructor in the controller without getting errors
		
		// Paths and Files
		$this->vqmod_script = array('search_analytics');
		
		$this->vqmod_dir		= substr_replace(DIR_SYSTEM, '/vqmod/', -8); // -8 = /system/
		$this->vqmod_script_dir	= substr_replace(DIR_SYSTEM, '/vqmod/xml/', -8);	
		$this->vqcache_files	= substr_replace(DIR_SYSTEM, '/vqmod/vqcache/vq*', -8);
		$this->vqmod_modcache	= substr_replace(DIR_SYSTEM, '/vqmod/mods.cache', -8);
		clearstatcache();
		
		
		$this->load->model('catalog/search_analytics');

		$date_period = $this->model_catalog_search_analytics->get_search_period();
		
		if ( version_compare(VERSION, '2.0.0.0', '>=') ) {
			// Oc >= 2
			$limit = $this->config->get('config_limit_admin');
		} else {
			// Oc <= 1.5.6.4
			$limit = $this->config->get('config_admin_limit');
		}
		
		$this->page					= (isset($this->request->get['page']))				?	$this->request->get['page']					: 1;
		$this->limit				= (isset($this->request->get['limit']))				?	$this->request->get['limit']				: $limit;
		$this->filter_date_start 	= (isset($this->request->get['filter_date_start']))	?	$this->request->get['filter_date_start']	: $date_period['min'];
		$this->filter_date_end		= (isset($this->request->get['filter_date_end']))	?	$this->request->get['filter_date_end']		: $date_period['max'];
		$this->filter_keyphrases	= (isset($this->request->get['filter_keyphrases']))	?	$this->request->get['filter_keyphrases']	: array('','',''); // 3 empty keyphrases
		$this->match_type			= (isset($this->request->get['match_type']))		?	$this->request->get['match_type']			: 'broad';
		$this->aggregation_period	= (isset($this->request->get['aggregation_period']))?	$this->request->get['aggregation_period']	: 'day';
		
		$this->demo = false;
		$this->demo_reset_time = 45;

	}

	
	public function index($settings = array()) {
	
	
		$this->demo_check();
	

		// this variable tells whether the module runs in standalone mode or is embedded in Advanced Smart Search
		$standalone = (isset($settings['standalone']))? $settings['standalone'] : true;
	
		$data['standalone'] = $standalone;
	
		$this->document->addStyle('view/stylesheet/search_analytics.css');

		//	Customized version of Flot 0.7 
		//
		//	Includes:
		//
		//	 - jquery.flot.resize.js
		//	 - jquery.flot.pie.js
		//	 - jquery.flot.stack.min.js

		$this->document->addScript('view/javascript/search_analytics/jquery.flot.js');
		
		// Search Analytics Js Core 
		$this->document->addScript('view/javascript/search_analytics/search_analytics.js');


		$this->language->load('module/search_analytics');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		// "Translation" allows Javascript to translate strings into the current language (see js function getText() 

		// Heading
		$translation['heading_title']					= $this->language->get('heading_title'); 

		// Text
		$translation['text_module']						= $this->language->get('text_module');
		$translation['text_success']					= $this->language->get('text_success');

		$translation['text_export_csv']					= $this->language->get('text_export_csv');
		$translation['text_delete_history']				= $this->language->get('text_delete_history');
		$translation['text_confirm_delete_history']		= $this->language->get('text_confirm_delete_history');
		
		$translation['text_confirm_delete_rows']				= $this->language->get('text_confirm_delete_rows');

		$translation['text_hbar_pie_label']				= $this->language->get('text_hbar_pie_label');
		$translation['text_bar_line_label']				= $this->language->get('text_bar_line_label');

		$translation['text_compare']					= $this->language->get('text_compare');
		$translation['text_added']						= $this->language->get('text_added');

		$translation['text_search_history']				= $this->language->get('text_search_history');
		$translation['text_top_searches']				= $this->language->get('text_top_searches');
		$translation['text_top_searches_n']				= $this->language->get('text_top_searches_n');
		$translation['text_top_searches_percent']		= $this->language->get('text_top_searches_percent');

		$translation['text_total_daily_searches']		= $this->language->get('text_total_daily_searches');
		$translation['text_total_monthly_searches']		= $this->language->get('text_total_monthly_searches');
		$translation['text_total_yearly_searches']		= $this->language->get('text_total_yearly_searches');
		$translation['text_page_number']				= $this->language->get('text_page_number');

		// Table column names
		$translation['text_keyphrase']					= $this->language->get('text_keyphrase');
		$translation['text_total']						= $this->language->get('text_total');

		$translation['text_id']							= $this->language->get('text_id');
		$translation['text_ip']							= $this->language->get('text_ip');
		$translation['text_customer_name']				= $this->language->get('text_customer_name');
		$translation['text_date']						= $this->language->get('text_date');
		$translation['text_time']						= $this->language->get('text_time');
		$translation['text_delete']						= $this->language->get('text_delete');

		// Entry
		$translation['entry_date_start']				= $this->language->get('entry_date_start');
		$translation['entry_date_end']					= $this->language->get('entry_date_end');
		$translation['entry_filter_keyphrase_0']		= $this->language->get('entry_filter_keyphrase_0');
		$translation['entry_filter_keyphrase_1']		= $this->language->get('entry_filter_keyphrase_1');
		$translation['entry_filter_keyphrase_2']		= $this->language->get('entry_filter_keyphrase_2');
		$translation['entry_exact_match']				= $this->language->get('entry_exact_match');
		$translation['entry_broad_match']				= $this->language->get('entry_broad_match');
		$translation['entry_day']						= $this->language->get('entry_day');
		$translation['entry_month']						= $this->language->get('entry_month');
		$translation['entry_year']						= $this->language->get('entry_year');

		// Buttons
		$translation['button_filter']					= $this->language->get('button_filter');
		$translation['button_reset']					= $this->language->get('button_reset');

		// Error
		$translation['error_permission']				= $this->language->get('error_permission');


		$data['translation'] = $translation;

		
		// Shorthand to load all the language strings in one shoot:
	 	$data = array_merge($data, $data['translation']); 
		
		
		$data['filter_date_start']			= $this->filter_date_start;
		$data['filter_date_end']			= $this->filter_date_end;
		$data['filter_keyphrases']			= $this->filter_keyphrases;
		$data['match_type']					= $this->match_type;
		$data['aggregation_period']			= $this->aggregation_period;
		

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      =>  $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => 'Module',
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),       		
			'separator' => ' :: '
		);
		
		$data['breadcrumbs'][] = array(
			'text'      => 'Search Analytics',
			'href'      => $this->url->link('module/search_analytics', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

			
		$data['delete_history']	= $this->url->link('module/search_analytics/delete_search&page='.$this->page, 'token=' . $this->session->data['token'], 'SSL');
		$data['filter']			= $this->url->link('module/search_analytics/map', 'token=' . $this->session->data['token'], 'SSL');
		$data['export_csv']		= $this->url->link('module/search_analytics/export_csv', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];
				
		$path = 'module/search_analytics.tpl';
		
		if ( version_compare(VERSION, '1.5.6.4', '<=') ) {
		
			$this->load->model('design/layout');
			$data['layouts'] = $this->model_design_layout->getLayouts();
		
			$this->data = $data;
			
			$this->template = $path;
			
			if ($standalone) {
				$this->children = array(
					'common/header',
					'common/footer'
				);
				$this->response->setOutput($this->render());	
			} else {
				$this->render();
			}	
			
		} else {
		
			if ($standalone) {
				$data['header'] = $this->load->controller('common/header');
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['footer'] = $this->load->controller('common/footer');
			
				$this->response->setOutput($this->load->view($path, $data));	
			} else {
				return $this->load->view($path, $data);
			}	
	
		}

	}

	/*	
	$total_unique_searches = $this->model_catalog_search_analytics->get_total_unique_searches($filter_data);
	
	$pagination = new Pagination();
	$pagination->total	= $total_unique_searches;
	$pagination->page	= $this->page;
	$pagination->limit	= $this->config->get('config_admin_limit');
	$pagination->text	= $this->language->get('text_pagination');
	$pagination->url	= $this->url->link('module/search_analytics/summary_chart', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
	
	$data['pagination'] = $pagination->render();
	*/
	
	
	public function install() {
	
		if (!$this->user->hasPermission('modify', 'module/search_analytics')) {
			
			$this->session->data['error'] = $this->language->get('error_permission');
		
		} else {
	
			foreach ( $this->vqmod_script as $vqmod_script){
			
				if (is_file($this->vqmod_script_dir . $vqmod_script . '.xml_')) {
					rename($this->vqmod_script_dir . $vqmod_script . '.xml_', $this->vqmod_script_dir . $vqmod_script . '.xml');

					$this->clear_vqcache();
					$this->session->data['success'] = $this->language->get('success_install');	
				}
				// if there is no need of renaming the file
				elseif (is_file($this->vqmod_script_dir . $vqmod_script . '.xml')) {

					$this->clear_vqcache();
					$this->session->data['success'] = $this->language->get('success_install');	
				}
				else {
					$this->model_setting_extension->uninstall('module', $this->request->get['extension']); // force the uninstallation if the xml is missing
					$this->session->data['error'] = $this->language->get('error_install');
				}
			}
		
		   $this->model_catalog_search_analytics->create_tables(); 
		}
	}
			 

		 
	public function uninstall() {
	
		$this->language->load('module/search_analytics');

		if (!$this->user->hasPermission('modify', 'module/search_analytics')) {
			
			$this->session->data['error'] = $this->language->get('error_permission');
		
		} else {
		
			foreach ( $this->vqmod_script as $vqmod_script){
				if (is_file($this->vqmod_script_dir . $vqmod_script . '.xml')) {
					rename($this->vqmod_script_dir . $vqmod_script . '.xml', $this->vqmod_script_dir . $vqmod_script . '.xml_');

					$this->clear_vqcache();

					$this->session->data['success'] = $this->language->get('success_uninstall');
				} else {
					$this->session->data['error'] = $this->language->get('error_uninstall');
				}
			}
		}	
	}

	
	public function clear_vqcache() {
	
		$files = glob($this->vqcache_files);
		if ($files) {
			foreach ($files as $file) {
				if (is_file($file)) {
					unlink($file);
				}
			}
		}
		if (is_file($this->vqmod_modcache)) {
			unlink($this->vqmod_modcache);
		}
		return;
	}
	
			 

	public function get_chart() {

		$filter_data = array(
			'filter_date_start'	=> $this->filter_date_start,
			'filter_date_end'	=> $this->filter_date_end,
			'filter_keyphrases'	=> $this->filter_keyphrases,
			'match_type'		=> $this->match_type,
			'aggregation_period'=> $this->aggregation_period
		);
		

		$results = $this->model_catalog_search_analytics->get_chart($filter_data);
		
		$json = array();
		
		foreach ( $results as $result ) {
		
			$date		= new DateTime($result['date']);
			$timestamp	= $date->getTimestamp() * 1000;			// Javascript requires the timestamp in milliseconds.

			if ( array_filter($this->filter_keyphrases) ) {		// Trick to check whether there is at least one array element  ( !array_filter($array) => all elements are empty )

			
				// Example: Search query : sony vaio
				
				// string_0 => string from the array $strings whose index is 0
				
				// Database table:
				
				//	#id		keyphrase			customer_id 	ip			timestamp					matches
				//	---------------------------------------------------------------------------
				//	130 	sony vaio	 		0 				127.0.0.1 	2015-04-14 18:53:50			#
				//	131 	sony vaio vaio 		0 				127.0.0.1 	2015-04-14 18:53:50			#
				//	132 	sony vaio vaio 		0 				127.0.0.1 	2015-04-14 18:53:50			#
				//	129 	sony 				0 				127.0.0.1 	2015-04-14 18:51:37			#
				//	128 	fhhh 				0 				127.0.0.1 	2015-04-14 15:36:34
				//	127 	fhhh 				0 				127.0.0.1 	2015-04-13 21:08:16
				//	126 	sony 				0 				127.0.0.1 	2015-04-13 15:20:46			#
				//	126 	sony 				0 				127.0.0.1 	2015-04-13 15:20:46			#
				//	125 	sony 				0 				127.0.0.1 	2015-03-10 13:10:16			#		
				
				// Table of results
				
				
				//  Broad match:                                 Exact Match:
				
				
				//	date 			string_0 	string_1      	//	date 			string_0 	string_1
				//	-------------------------------------       //	-------------------------------------------
				//	2015-03-10 		1 			0       
				//	2015-04-13 		1 			0
				//	2015-04-14 		4			3
			
			
				if ( isset($filter_data['match_type']) && $filter_data['match_type'] == 'broad' ) {
					
					$strings = $this->model_catalog_search_analytics->get_unique_keywords($this->filter_keyphrases);

				} else {
					$strings = $this->filter_keyphrases;	
				}
				
				foreach ( $strings as $i => $string ) {
				
				// To bypass a bug with the stacking bar charts, we must include all the points, also the ones with the value = 0
				// and then exclude them from the line chart (see tpl file)
				//	if ( $result['string_'.$i] > 0 ) { 	// Discard values = 0 
						
						$json[$string][] = array( $timestamp, $result['string_'.$i] ); // Javascript requires the timestamp in milliseconds.
				//	}
				}

			} else {
			
				// If no fitler by keyphrases (exact and broad) 
			
				//	date 			total
				//	---------------------
				//	2015-03-10 		20
				//	2015-03-17 		5
				//	2015-03-18 		1
				//	2015-03-21 		13
				//	2015-03-22 		1
				//	2015-03-25 		4
				//	2015-03-26 		27
				//	2015-04-13 		2
				//	2015-04-14 		5
				//	2015-04-16 		1
			
				$json[] =  array( $timestamp, $result['total'] );
			}	
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	

	
	public function get_keyword_hits() {

		$sort_order			= 'DESC';
		
		$filter_data = array(
		
			'start' 			=> ($this->page - 1) * $this->limit,
			'limit'				=> $this->limit,
			
			'filter_date_start'	=> $this->filter_date_start,
			'filter_date_end'	=> $this->filter_date_end,
			'filter_keyphrases'	=> $this->filter_keyphrases,
			'match_type'		=> $this->match_type,
			
			'sort_order'		=> $sort_order
		);
		

		$columns = $this->model_catalog_search_analytics->keyword_hits($filter_data);
		
		$json = array();
		
		if ($columns) {
		
			$total_unique_searches = $this->model_catalog_search_analytics->get_total_unique_searches($filter_data);

			$json = array(	'page'		=> $this->page,
							'columns'	=> $columns,				
							'limit'		=> $this->limit,
							'total'		=> $total_unique_searches
			);	
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	
	
	public function get_search_history() {

		$order_by			= 'date';
		$sort_order			= 'DESC';
		
		
		$filter_data = array(
		
			'start'				=> ($this->page - 1) * $this->limit,
			'limit'				=> $this->limit,

			'filter_date_start'	=> $this->filter_date_start,
			'filter_date_end'	=> $this->filter_date_end,
			'filter_keyphrases'	=> $this->filter_keyphrases,
			'match_type'		=> $this->match_type,

			'order_by'			=> $order_by,
			'sort_order'		=> $sort_order
		);

		
		$columns = $this->model_catalog_search_analytics->get_searches($filter_data);
		
		foreach ($columns as &$column) {
			$column['delete'] = '<input type="checkbox" name="id_list[]" value="'.$column['id'].'" />';
		}
		
		$json = array();
		
		if ($columns) {
		
			$search_total = $this->model_catalog_search_analytics->get_search_total($filter_data); 

			$json = array(	'page'		=> $this->page,
							'columns'	=> $columns,				
							'limit'		=> $this->limit,
							'total'		=> $search_total
			);
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	
	
	public function delete_search(){
	
		$this->load->model('setting/setting');
		// save the current deleting time/date        
		$this->model_setting_setting->editSetting('search_analytics', array('search_analytics_del_datetime' => date('Y-m-d H:i:s')));

		// If id_list is an empty array, the whole table will be emptied
		$id_list = (isset($this->request->get['id_list']))? $this->request->get['id_list'] : array();
	
		$json['success'] = $this->model_catalog_search_analytics->delete_search($id_list); // true if deleted, false if error

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));	
	}

	
	
	public function export_csv() {
	
		$order_by			= 'date'; // For the search history
		$sort_order			= 'DESC';
		
		$filter_data = array(
		
			'filter_date_start'	=> $this->filter_date_start,
			'filter_date_end'	=> $this->filter_date_end,
			'filter_keyphrases'	=> $this->filter_keyphrases,
			'match_type'		=> $this->match_type,
			
			'order_by'			=> $order_by,
			'sort_order'		=> $sort_order
		);
	
		$results = array();
		switch ($this->request->get['table']) {
			case 'keyword_hits':
				$results = $this->model_catalog_search_analytics->keyword_hits($filter_data);
				break;
			case 'search_history':
				$results = $this->model_catalog_search_analytics->get_searches($filter_data);
				break;  
		}
	
 
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=report-from_' . $this->filter_date_start . '_to_' . $this->filter_date_end . '.csv');
		
		$output = fopen('php://output', 'w');
		
		if ( !empty($results) ) {

			// Column names
			fputcsv($output, array_keys($results[0]));
		
			// Results
			foreach($results as $key => $result) {
				fputcsv($output, $result);		
			}
	
		}
		
		fclose($output);
		exit;

		$this->index();		
	}

	
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/search_analytics')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	

	
	public function demo_check() {
	
		if ( $this->demo == true && $this->config->get('search_analytics_del_datetime') ) { 
		
			$last_del_datetime =  new DateTime($this->config->get('search_analytics_del_datetime')); 
		
			$last_del_datetime_plus_interval = $last_del_datetime->modify('+'. $this->demo_reset_time .' minutes');
		
			$current_datetime = new DateTime();
				
			if ( $current_datetime > $last_del_datetime_plus_interval ) {
			
				$strings = $this->model_catalog_search_analytics->restore_demo();
				
				// Clear the deleting time to avoid restoring the table every time the control panel is called
				$this->load->model('setting/setting');
				$this->model_setting_setting->editSetting('search_analytics', array('search_analytics_del_datetime' => false));
			}	
		}
	}
	
	
}
?>