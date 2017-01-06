<?php
// ***************************************************
//               Advanced Smart Search   
//       
// Author : Francesco Pisanò - francesco1279@gmail.com
//              
//                   www.leverod.com		
//               © All rights reserved	  
// ***************************************************


// Admin Controller

class ControllerModuleAdsmartSearch extends Controller {

	private $error = array(); 
	
	
	public function __construct($registry) {
		parent::__construct($registry);
	

// uncomment it to test the function register_shutdown_function()
//ini_set("max_execution_time", "2");

		register_shutdown_function(array($this, 'shutdown')); 
		
// uncomment it to test the function register_shutdown_function()		
// sleep(1);


		// Paths and Files
		$this->vqmod_script = 'adsmart_search';
		
		$this->vqmod_dir = substr_replace(DIR_SYSTEM, '/vqmod/', -8); // -8 = /system/
		$this->vqmod_script_dir = substr_replace(DIR_SYSTEM, '/vqmod/xml/', -8);	
		$this->vqcache_files = substr_replace(DIR_SYSTEM, '/vqmod/vqcache/vq*', -8);
		$this->vqmod_modcache = substr_replace(DIR_SYSTEM, '/vqmod/mods.cache', -8);
		clearstatcache();
	}
	

	
	
	public function install() {

		// cleanup the system from old files and dirs

		// Example of file in the catalog:
		// DIR_CATALOG.'model/catalog/xyz.php';
		// Example of file in the admin:
		// DIR_APPLICATION.'model/catalog/xyz.php';
		
		$basepath = substr_replace(DIR_APPLICATION, '/', -7);	//   /admin/ = 7

		$files = array(
		
			// from v2.2 this file has been renamed to adsmartsearch_product_inc.php
			$basepath.'catalog/model/catalog/adsmartsrc_product_inc.php',
			
			// From v3.0 these files have been renamed from advanced_smart_search_* to adsmart_search_*
			// because on Oc 2.0 settings must start with a string equal to the file name which must be also 
			// equal to the setting group name, see for example the file catalog->content_top.php, variable, 
			// $code and admin/model/setting/setting.php, function editSettings()
			
			$basepath.'admin/controller/module/advanced_smart_search.php',
			$basepath.'admin/language/english/module/advanced_smart_search.php',
			$basepath.'admin/language/italian/module/advanced_smart_search.php',
			$basepath.'admin/view/template/module/advanced_smart_search.tpl',
			
			$basepath.'catalog/controller/module/advanced_smart_search.php',
			$basepath.'catalog/view/theme/lexus_nextstore/template/module/advanced_smart_search.tpl',
		
			$basepath.'vqmod/xml/advanced_smart_search.xml'	
		);
		
		foreach ($files as $file){
		
			if (file_exists($file)) {
				unlink($file);
			} 
		}
		
		// Remove dirs and their contents:
		
		$paths = array(
			// from v2.2 this dir has been renamed to adsmartsearch_repository
			DIR_CATALOG.'/view/javascript/adSmartSrc_repository',
			DIR_APPLICATION.'/view/javascript/adSmartSrc_repository',
		);
		
		foreach ($paths as $path) {
		
			 if (is_dir($path) === true) {
			
				$files = array_diff(scandir($path), array('.', '..'));

				foreach ($files as $file) {
					unlink(realpath($path) . '/' . $file);
				}
			
				rmdir($path);
			}
		}
		
		

	
	
		$this->language->load('module/adsmart_search');

	/*	if (!$this->user->hasPermission('modify', 'module/adsmart_search')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} 
		else {
		*/

			// If there is no need to rename the file (a file might be already there, for example when the user copies installation files 
			// on the server for updating)
			if (is_file($this->vqmod_script_dir . $this->vqmod_script . '.xml')) {

				$this->clear_vqcache();
				$this->session->data['success'] = $this->language->get('success_install');	
			}
			
			// If the extension was previously uninstalled
			elseif (is_file($this->vqmod_script_dir . $this->vqmod_script . '.xml_')) {
			
				rename($this->vqmod_script_dir . $this->vqmod_script . '.xml_', $this->vqmod_script_dir . $this->vqmod_script . '.xml');

				$this->clear_vqcache();
				$this->session->data['success'] = $this->language->get('success_install');	
			}
			
			else {
				$this->model_setting_extension->uninstall('module', $this->request->get['extension']); // force uninstall the extension if the xml was missing
				$this->session->data['error'] = $this->language->get('error_install');
			}
			
			

			
			// Some other extensions might already have played with indexes and set up their own settings. Take a snapshot of the database 
			// indexes AT THE FIRST BOOT OF THE EXTENSION, so we know which fields are alredy being used as index and for each table save the table name,
			// field name and index type (btree, primary, full text ecc.). 

			
			$index_snapshot = $this->index_snapshot();
			$snapshot['adsmart_search_index_snapshot'] = serialize($index_snapshot);


			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('adsmart_search', $snapshot);	
			$this->config->set('adsmart_search_index_snapshot', $snapshot['adsmart_search_index_snapshot']);
			
			// Reset all settings
			$this->reset();
			
			
			// Install Search Analytics if available
			if (file_exists(DIR_APPLICATION . 'controller/module/search_analytics.php')) {
			
				$link = 'extension=search_analytics&token=' . $this->session->data['token'];
				
				if (version_compare(VERSION, '2.0.0.0', '>=')) { 			
					$this->response->redirect($this->url->link('extension/module/install', $link , 'SSL'));
				} else {
					$this->redirect($this->url->link('extension/module/install', $link , 'SSL'));
				}		
			}	
			
	//	}
	
		
		// Opencart v1.5.4.1 uses the utf8_bin collation which doesn't allow case insensitive searches.
		// Change the collation to utf8_general_ci
		
		if (version_compare(VERSION, '1.5.4.1', '<=')) {
			$this->change_collation('utf8_bin', 'utf8_general_ci');
		}

	}
	
	
	
	
	public function uninstall() {
	
		$this->language->load('module/adsmart_search');

		if (!$this->user->hasPermission('modify', 'module/adsmart_search')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} 
		else {
		
			// Reset the db indexes as they were before installng Advanced Smart Search
			$index_snapshot = unserialize($this->config->get('adsmart_search_index_snapshot'));
			
			$tables = $this->get_tables();
			
			foreach ($tables as $table => $fields){
				
				foreach ($fields as $product_field_name => $db_field_name) {
				
					// First, check if the index exists:
					$query = $this->db->query("SHOW INDEX FROM " . DB_PREFIX . $table . " WHERE Key_name = '".$db_field_name."' ");
					$result = $query->row;
					
					$index_exists = !empty($result['Key_name']);
				
							
					// Before deleting an index, we must check that the index exists and that the array index_snapshot contains at least one element 
					// (the BTREE index "name" from the table "product_description", index requied by Opencart. If index_snapshot is empty, it could be due 
					// to some error occurred on the method call or because the user updated Advanced Smart Search from a version that didn't have yet 
					// the method index_snapshot(). In this case, don't do anything, to avoid deleting some required indexes.
					if ( $index_exists && !empty($index_snapshot) ) {

						// Cases to handle:
						// 1) the index didn't exist before: drop it;
						// 2) the index was BTREE: Drop and add it again;
						// 3) the index was FULL TEXT: no action. If FULL TEXT indexes were present before installing the extension, Advanced Smart Search  
						//	  doesn't drop indexes when the table indexing is enabled and users deselect a product field checkbox.
				
						// If the index didn't exist before installing Advanced Smart Search, we can delete it
						if (  !isset($index_snapshot[$table][$db_field_name]['index_type'])) {
						
							$this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` DROP INDEX `".$db_field_name."`");
						}
						// Drop and rebuild the index if it was of BTREE type before installing the extension
						else if ( isset($index_snapshot[$table][$db_field_name]['index_type']) && $index_snapshot[$table][$db_field_name]['index_type'] == 'BTREE'  ) {

							// The code wrapped between BEGIN and END is necessary only if before installing the extension, there were BTREE indexes on the fields:
							
							// - product_description.description
							// - product_description.tag
							// - product_attribute.text
							// - category_description.name
							
							// BEGIN
								// Limit the index length for the fields product_description.description
								// product_description.tag and product_attribute.text, otherwise we get this kind of MySQL error:
								
								// Error: BLOB/TEXT column 'description' used in key specification without a key length
								// Error No: 1170 ALTER TABLE `product_description` ADD INDEX (`description`) in \system\database\mysql.php</b> on line 50
								
								//	 the Max Field length is required only if the index is not of type FULL TEXT:	
								if ( in_array($product_field_name, array('description', 'tag', 'attribute_description', 'category_name' )) ) {
									
									$max_index_length = '(128)';
								}
								else $max_index_length = '';
							// END
				
										
							if ( 
								($table == 'product_description' && $db_field_name == 'name') ||
								($table == 'category_description' && $db_field_name == 'name') ){
							
								$this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` DROP INDEX `".$db_field_name."`");
							//  $this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` ADD INDEX (`".$db_field_name."`)");
								$this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` ADD INDEX (`".$db_field_name."`".$max_index_length.")");
							}
						}
					}
				}
			}
			
			
			// Clear the Search Cache
			$this->cache->adsmart_search_clear_cache('search_string');
	
			//Rrename the vQmod file extension from .xml to .xml_ and clear the vQmod cache
			if (is_file($this->vqmod_script_dir . $this->vqmod_script . '.xml')) {
				rename($this->vqmod_script_dir . $this->vqmod_script . '.xml', $this->vqmod_script_dir . $this->vqmod_script . '.xml_');

				$this->clear_vqcache();

				$this->session->data['success'] = $this->language->get('success_uninstall');
			} else {
				$this->session->data['error'] = $this->language->get('error_uninstall');
			}
		}
		
		
		// Change back the collation to utf8_bin for Opencart <= 1.5.4.1	
		if (version_compare(VERSION, '1.5.4.1', '<=')) {
			$this->change_collation('utf8_general_ci', 'utf8_bin');
		}	
	}
	
	

	
	public function reset() {
	
		$this->load->model('setting/setting');
		
		$relevance['name'] = '';
		$relevance['tag'] = '';
		
		
		// language settings for the translations
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$data['languages'] = $languages;
		
		// Init the text "Relevance"
		foreach ($languages as $language) {
			$sample_text_relevance[$language['language_id']] = $this->language->get('text_optn_relevance');
		}

		// Init the text "Date Added desc"
		foreach ($languages as $language) {
			$sample_text_date_desc[$language['language_id']] = $this->language->get('text_optn_date_desc');
		}
		
		// Init the text "Date Added asc"
		foreach ($languages as $language) {
			$sample_text_date_asc[$language['language_id']] = $this->language->get('text_optn_date_asc');
		}
		
		// Init the text "Show all results"
		foreach ($languages as $language) {
			$sample_text_show_all[$language['language_id']] = $this->language->get('text_dropdown_show_all_sample_text');
		}
		
		// Init the text "No results"
		foreach ($languages as $language) {
			$sample_text_no_results[$language['language_id']] = $this->language->get('text_dropdown_no_results_sample_text');
		}
		
		// Get the current date that will be used to save the last access date
		$now = new DateTime();
		

		$settings = array(
		
			'adsmart_search_first_boot'							=> null,				
			'adsmart_search_index_snapshot'						=> $this->config->get('adsmart_search_index_snapshot'), // see the function install()
	
	
// General Search Options			
			
			'adsmart_search_status'								=> 1,						// Enable/Disable the module
			'adsmart_search_algorithm'							=> 'fast',					// Search Algorithm
			
			'adsmart_search_exact_broad'						=> 'broad',					// Exact/Broad match
			
			'adsmart_search_sort_order'							=> 'relevance-DESC',
			'adsmart_search_translation_txt_relevance'			=> $sample_text_relevance,	// Init the text "Relevance"
			'adsmart_search_translation_txt_date_desc'			=> $sample_text_date_desc,	// Init the text "Date Added desc"
			'adsmart_search_translation_txt_date_asc'			=> $sample_text_date_asc, 	// Init the text "Date Added asc"
			
			'adsmart_search_fields'								=> '',
			'adsmart_search_relevance'							=> $relevance,				// Field relevances (no need to set any value)
			
		//	'adsmart_search_include_plurals'					=> 							// Do not set it at start
			
		//	'adsmart_search_include_partial_words'				=> 							// Do not set it at start
			'adsmart_search_partial_word_length'				=> 3,						// Min word length for partial word matches
			
		//	'adsmart_search_include_misspellings'				=> 							// Do not set it at start
			'adsmart_search_misspelling_tolerance'				=> 20,						// Misspelling tolerance
			
			'adsmart_search_enable_search_cache'				=> 1,						// Enable cache
			'adsmart_search_cache_update_frequency'				=> 604800, 					// Cache update frequency (604800=weekly)
			
			'adsmart_search_index_db'							=> 1,						// Index database
			'adsmart_search_rebuild_indexes'					=> '',						// Button rebuild indexes (no value)				
			

			
// Live Search Options & Style			
			
			'adsmart_search_dropdown_enabled'					=> 1,						// Live Search status
			'adsmart_search_dropdown_update_on_entire_word'		=> 0,						// Update results when entire words are typed
			'adsmart_search_dropdown_preset_style'				=> 'opencart_classic',		// Default style
			'adsmart_search_dropdown_display_img'				=> 1,						// Display images

			'adsmart_search_dropdown_display_price'				=> 1,						// Display prices
		//	'adsmart_search_dropdown_display_rating'			=> 							// FEATURE NOT YET IMPLEMENTED

			'adsmart_search_dropdown_img_border_color'			=> 'E7E7E7',	// Default	
			'adsmart_search_dropdown_img_size'					=> 30,			// Default
			'adsmart_search_dropdown_width'						=> 340,			// Default
			'adsmart_search_dropdown_text_size'					=> 16,			// Default
			'adsmart_search_dropdown_text_color'				=> '454545',	// Default
			'adsmart_search_dropdown_bg_color'					=> 'fafafa',	// Default
			'adsmart_search_dropdown_border_color'				=> 'E7E7E7',	// Default 
			'adsmart_search_dropdown_hover_bg_color'			=> 'ededed',	// Default

		//	'adsmart_search_dropdown_lighter_separator_color'	=>
		//	'adsmart_search_dropdown_darker_separator_color'	=>

		//	'adsmart_search_dropdown_hover_border_color'		=>
			'adsmart_search_dropdown_max_num_results'			=> 10,						// Maximum number of results
			'adsmart_search_dropdown_show_all'					=> $sample_text_show_all,	// Init the text "Show all results"
			'adsmart_search_dropdown_no_results'				=> $sample_text_no_results,	// Init the text "No results"
			
		//	'adsmart_search_dropdown_msg_bg_color'				=>
		//	'adsmart_search_dropdown_msg_text_color'			=>
		//	'adsmart_search_dropdown_msg_text_size'				=>
			
			'adsmart_search_last_cp_save_date'				=> $now->format('Y-m-d H:i:s')
		);
		
		
		
		$this->model_setting_setting->editSetting('adsmart_search', $settings);
		foreach ($settings as $setting => $value){
			$this->config->set($setting, $value);		
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
	
	
	
	
	public function shutdown() { 
	
		$error=error_get_last(); 
		
		// $error is an array with this structure:
		// ['type'] (1 = most errors, 2 = Exceptions, 3 = fatal errors)
		// ['message']
		// ['file']
		// ['line']
	
		if( $error==null ) {
			return;
		}
		else { 
			if ( $this->request->server['REQUEST_METHOD'] == 'POST' /* && isset($this->request->post['save']) && isset($this->request->post['is_ajax_request']) */ ) {
			
				if ( strpos($error['message'], 'Maximum execution time of') !== false ) {

					// clean the output buffer
					ob_clean();

					$err['max_time_exceeded']= true;		
					print_r(json_encode($err)); // when is json encoded, the error triggers the ajax function 'success'
				}
			}
		}		 
	}
	
	

	
	private function get_tables() {
	
		// Structure of the array $fields:
		// element[i]: 'table_name' => ( 'product_field_name1' => 'db_field1', 
		//								 'product_field_name2' => 'db_field2', 
		//								 'product_field_name3' => 'db_field3'...
		$tables = array(
			
			'product_description' => array (
			
				'meta_keyword'		=> 'meta_keyword',
				'meta_description'	=> 'meta_description',
				'name'				=> 'name',	// this field is a default Opencart key, we'll not add or drop it
/* BLOB/TEXT */		'description'		=> 'description',
/* BLOB/TEXT */		'tag'				=> 'tag'
			),
			
			'product' => array (	
				'model'				=> 'model',
				'sku'				=> 'sku',
				'upc'				=> 'upc',
				'ean'				=> 'ean',
				'jan'				=> 'jan',
				'isbn'				=> 'isbn',
				'mpn'				=> 'mpn',
				'location'			=> 'location'
			),
			
			'manufacturer' => array (
				'manufacturer_name' => 'name'
			),
			
			'attribute_group_description' => array (
				'attribute_group_name' => 'name'
			),
			
			'attribute_description' => array (
				'attribute_name' 	=> 'name'
			),
			
			'product_attribute' => array (
/* BLOB/TEXT */		'attribute_description' => 'text'
			),
			
			'option_description' => array (
				'option_name' 		=> 'name'
			),
			
			'option_value_description' => array (
				'option_value' 		=> 'name'
			),
			
			'category_description' => array (
				'category_name' 	=> 'name'
			)
		);
		
		// NOTE:
		// Fields marked with BLOB/TEXT are too big, when we create the BTREE indexes their length must be reduced 
		// For FULL TEXT indexes there is no need to set any length
		
		return $tables;

	}
	
	
	// Take a snapshot of the current index configuration, so we can restore the old database indexes in case of problems
	// The method returns an array in this format: $index_snapshot[$table][$db_field_name]['index_type'] (index_type can assume the values FULLTEXT, BTREE ecc.)
	private function index_snapshot(){
	
		$tables = $this->get_tables();
	
		$index_snapshot = array();
		foreach ($tables as $table => $fields){
				
			foreach ($fields as $product_field_name => $db_field_name) {
			
				// First, check if the index exists:
				$query = $this->db->query("SHOW INDEX FROM " . DB_PREFIX . $table . " WHERE Key_name = '".$db_field_name."' ");
				$result = $query->row;
				
				if (!empty($result)) {
					// Note: for each table there might be more than one field
					$index_snapshot[$table][$db_field_name]['index_type'] = $result['Index_type'];
				}
			}
		}
		
		return $index_snapshot;
	}
	
	
	
	
	public function index_db_tables() {
	
		$relevance = isset($this->request->post['adsmart_search_relevance']) ? $this->request->post['adsmart_search_relevance'] : array();

		// the FULL TEXT index for the field "description" (table product_description) must always be present because the field relevance
		// could not be included in the list of searchable fields from the control panel but a user might still want to search in product  
		// descriptions (see the checkbox on the search page). If there is no FULL TEXT index and the search uses a match() against() 
		// (not in boolean mode) on the field "description", it returns the error: "Can't find FULLTEXT index matching the column..."
		
		if ( !isset($relevance['description']) ){
			$relevance['description'] = '123'; // dummy value, no need to set any real value here
		} 
		
		// Get the list of available fields from the array keys "relevance":
		$product_fields = !empty($relevance) ? array_keys($relevance) : array();
			
		$tables = $this->get_tables();
		$index_snapshot = unserialize($this->config->get('adsmart_search_index_snapshot'));

		
		foreach ($tables as $table => $fields){
				
			foreach ($fields as $product_field_name => $db_field_name) {
			
				// First, check if the index exists:
				$query = $this->db->query("SHOW INDEX FROM " . DB_PREFIX . $table . " WHERE Key_name = '".$db_field_name."' AND index_type = 'FULLTEXT' ");
				$result = $query->row;
				
				
				$fulltext_index_exists = !empty($result['Key_name']);

	
			// If the table indexing IS enabled AND the current product field IS enabled:
				if ( ( isset($this->request->post['adsmart_search_index_db']) || isset($this->request->post['adsmart_search_rebuild_indexes']) ) && in_array($product_field_name, $product_fields)){

					// Limit the index length for the fields product_description.description
					// product_description.tag and product_attribute.text, otherwise we get this kind of MySQL error:
					
					 // Error: BLOB/TEXT column 'description' used in key specification without a key length
					 // Error No: 1170 ALTER TABLE `product_description` ADD INDEX (`description`) in \system\database\mysql.php</b> on line 50
					
				//	 the Max Field length is required only if the index is not of type FULL TEXT:
				//	
				//	if ( in_array($product_field_name, array('description', 'tag', 'attribute_description')) ) {
				//		
				//		$max_index_length = '(128)';
				//	}
				//	else $max_index_length = '';
				//	
					
										
					if ( 
						($table == 'product_description' && $db_field_name == 'name') || 
						($table == 'category_description' && $db_field_name == 'name') ){
					
						// Check whether the BTREE index exists:
						$query = $this->db->query("SHOW INDEX FROM " . DB_PREFIX . $table . " WHERE Key_name = '".$db_field_name."' AND index_type = 'BTREE' ");
						$result = $query->row;

						$btree_index_exists = !empty($result['Key_name']);
					
						// The field "name" (table 'product_description') is a default BTREE key that we have to delete before 
						// adding a FULL TEXT key with the same name
						if ( $btree_index_exists ){
							 $this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` DROP INDEX `".$db_field_name."`");
						}
					}
					
					// Add the index if it doesn't exist:	
					if ( !$fulltext_index_exists ){ 
					
					//	$this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` ADD INDEX (`".$db_field_name."`".$max_index_length.")");
						$this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` ADD FULLTEXT (`".$db_field_name."`)"); // For FULL TEXT indexes there is no need to set the length
					}
				}
				
				// Drop the FULL TEXT index if:
				// - id doesn't exist OR It exists and it was not previously created by some other extension 
				//   AND
				// - The table indexing IS NOT enabled    OR     the current product field IS NOT enabled 
				else if ( ( !isset($index_snapshot[$table][$db_field_name]['index_type']) || (isset($index_snapshot[$table][$db_field_name]['index_type']) && $index_snapshot[$table][$db_field_name]['index_type'] != 'FULLTEXT') )  &&  ( !isset($this->request->post['adsmart_search_index_db']) || !in_array($product_field_name, $product_fields) ) ) {
					
					if ($fulltext_index_exists  ) {
					
						$this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` DROP INDEX `".$db_field_name."`");
					}
					
					
					if ( 
						($table == 'product_description' && $db_field_name == 'name') || 
						($table == 'category_description' && $db_field_name == 'name') ){
					
						// Add again the default BTREE index for the field "name" (table 'product_description')
						$query = $this->db->query("SHOW INDEX FROM " . DB_PREFIX . $table . " WHERE Key_name = '".$db_field_name."' AND index_type = 'BTREE' ");
						$result = $query->row;

						$btree_index_exists = !empty($result['Key_name']);
						if (!$btree_index_exists) {
							$this->db->query("ALTER TABLE `" . DB_PREFIX . $table . "` ADD INDEX (`".$db_field_name."`)");
						}
					}
				}
			}
		}		
	}
	
	
	
	
	public function rebuild_db_indexes() {
		$this->index_db_tables();
		$json = array();
		$json['built']='true';
		$this->response->setOutput(json_encode($json));
		return;
	}
	
	
	
	
	// Opencart 1.5.4.1 table collation is set on utf8_bin. This collation make searches to be case sensitive.
	// The right collation to make case insensitive searches is utf8_general_ci, available by default from Opecnart 1.5.5
	// This method converts a collation to another

	
	private function change_collation($old_collation, $new_collation) {
	
		$charset = 'utf8'; 
		
		//	Opencart collations: 
		// 	utf8_bin			Oc <= 1.5.4.1
		//	utf8_general_ci		Oc >= 1.5.5

		// change database collation
		// $this->db->query("ALTER DATABASE `".DB_DATABASE."` DEFAULT CHARACTER SET ".$charset." COLLATE ".$new_collation);

		// Loop through all tables changing collation
		$query = $this->db->query("SHOW TABLES");
		$results = $query->rows;

		$tables = array();
	
		foreach ($results as $result) {	
		
			foreach ($result as $key => $tbl) {
				$tables[] = $tbl;
			}
		}
		
		foreach ($tables as $table) {	
		
			// get the collation of each table
			$query = $this->db->query("SELECT TABLE_COLLATION FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND  TABLE_NAME = '".$table."'");
			$result = $query->rows;
			
			$collation = $result[0]['TABLE_COLLATION'];
			
			if ($collation == $old_collation) {
			
				// This query converts the table collation including the collation of its columns
				$this->db->query("ALTER TABLE `".$table."` CONVERT TO CHARACTER SET ".$charset." COLLATE ".$new_collation );
				//	echo "<br>Changing charset and collation for the table $table (and its columns) to $charset and $new_collation<br>";
				
			}
		}
	

	
	
		// This foreach converts collation of the single columns. It is disabled because this is made 
		// by the previous query. I wrote this snipped this code without testing it.
		// Before to enable this code, TEST IT.
		/*
		foreach ($tables as $table) {				

			$this->db->query("ALTER TABLE $table DEFAULT CHARACTER SET $charset COLLATE $new_collation");
		//	echo "<br>Changing charset and collation for the table $table to $charset and $new_collation<br>";
			
			// loop through each column changing collation
			$columns = $this->db->query("SHOW FULL COLUMNS FROM $table WHERE COLLATION IS NOT NULL");
			
			foreach ($columns->rows as $column) {	
			
				$field		= $column[0];
				$type		= $column[1];
				$collation	= $column[2];
				
				if ($collation == $old_collation) {
					$this->db->query("ALTER TABLE $table MODIFY $field $type CHARACTER SET $charset COLLATE $new_collation");	
					// echo "<br>Changing charset and collation for the field $field $type to $charset and $new_collation<br>";
				}
			}
		}
		*/

	}
	
	

	
	public function index() {   
	
	
		// Js
		$this->document->addScript('view/javascript/adsmartsearch_repository/adsmart_search.js');
		
		// CSS
		$this->document->addStyle('view/stylesheet/adsmart_search.css');
	

		$this->language->load('module/adsmart_search');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		

		
	// ****************************************************************************************
	// This block sets the last control panel save date
	// (the date is contained in adsmart_search_last_cp_save_date)
	
		// If this script is called by a page save
		if ( $this->request->server['REQUEST_METHOD'] == 'POST' ) {
		
			$last_save_date_string = $this->request->post['adsmart_search_last_cp_save_date'];
		}
		// if this script is called by the "edit module" button
		else {
			$last_save_date_string = $this->config->get('adsmart_search_last_cp_save_date'); 
		}
		

		$last_cp_save_date					= new DateTime($last_save_date_string);
		$last_cp_save_date_plus_interval	= new DateTime($last_save_date_string);
		
		if ( ADSMART_SRC_DEMO && version_compare(phpversion(), '5.2', '>=') ) { 
			$last_cp_save_date_plus_interval->modify('+'. ADSMART_SRC_DEMO_RESET_TIME.' minutes'); // for php >= 5.2
		//	$last_cp_save_date_plus_interval->add(new DateInterval('PT'.ADSMART_SRC_DEMO_RESET_TIME.'M')); // for php >= 5.3
		}
		
		$current_cp_access_date = new DateTime();

		// ****************************************************************************************
		// This block of code is for the Demo, it resets settings after 45 mins	from the last save
		// (it only works for php 5.3 and later)
			if ( ADSMART_SRC_DEMO && version_compare(phpversion(), '5.3', '>=') ) { 
			
			// DateTime::diff() and the operators < and > for the dates are available from php 5.3
				if ($current_cp_access_date > $last_cp_save_date_plus_interval) {
					$this->reset();
				}
			}
		// end code for the Demo
		// ****************************************************************************************

  
		// pass the current date to a hidden input field
		$data['current_date'] = $current_cp_access_date->format('Y-m-d H:i:s');	
					
	// end code for the Demo
	// ****************************************************************************************
		
		
		
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
		
			// Save settings BEFORE to index the db tables. So if the script exceedes the maximum execution time (on Windows based systems) because of
			// large databases, we are sure that at least the module settings have been saved:
			
			// Add the index snapshot taken with the function install(). If we don't manually add it to the other post variable it will get lost
			$snapshot['adsmart_search_index_snapshot'] = $this->config->get('adsmart_search_index_snapshot');
			
			$save_date['adsmart_search_last_cp_save_date'] = $current_cp_access_date->format('Y-m-d H:i:s');
			
			$this->model_setting_setting->editSetting('adsmart_search', array_merge($this->request->post, $snapshot, $save_date));		

			
			// Index db tables (this operation could be slow on large databases):	
						
			// Note (from http://www.php.net/manual/en/function.set-time-limit.php):
			//
			// The function set_time_limit() and the configuration directive max_execution_time only affect the execution time of the script itself.
			// Any extra time spent on tasks run outside the execution of the script like system calls using system(), stream operations,
			// database queries, etc. is not added to the maximum script execution time. THIS IS NOT TRUE ON WINDOWS SYSTEMS, WHERE THE MEASURED 
			// TIME IS REAL.
						
			
			$this->index_db_tables();

			// the module can be saved by an ajax request (for example with the button "Save and Continue") 
			// or by the default Save button:
			if ( isset($this->request->post['is_ajax_request']) && $this->request->post['is_ajax_request'] ){
				
				$json = array();
				$json['saved']='true';
				$this->response->setOutput(json_encode($json));
				return;
			}

		}
		
		
		
		
		// language settings for the translations
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$data['languages'] = $languages;
		
					
		$text_strings = array(
				'heading_title',
				'text_demo_postit',
				
				'text_test_it',
				'text_test_it_placeholder',
				'text_keep_open',	
				
				'text_search_analytics',
				'text_search_options',
				'text_style',
				'text_user_guide',
				'text_license',
				
				'text_enable_module',
				'text_search_algorithm',
				'text_fast',
				'text_default',
				
				'text_match_type',
				'text_exact_match',
				'text_broad_match',
				
				'text_sort_order',
				
				'text_translate_extra_sort',
				'text_add_translation',
				
				'text_relevance',
				'text_enable_all',
				'text_disable_all',
				'text_field_name',
				
				'text_include_plurals',
				
				'text_include_partial_words',
				'text_partial_word_length',
				'text_current_search_algorithm',
				'text_what_is_this',
				
				'text_include_misspellings',
				'text_misspelling_tolerance',
				
				'text_cache_manager',
				'text_cache_update_frequency',
				'text_update_search_cache',
				'text_clear_search_cache',
				'text_search_cache_updated',
				'text_search_cache_cleared',
				
				'text_dialog_update_cache_title',
				'text_dialog_update_cache_text',
				
				'text_dialog_algorithm_fast_and_indexing_title',
				'text_dialog_algorithm_fast_and_indexing_text',
				
				'text_no_indexing_then_default_algorithm_title',
				'text_no_indexing_then_default_algorithm_text',
				
				'text_db_optimization',
				'text_index_db_tables',
				'text_rebuild_indexes',
				'text_rebuild',
				'text_indexes_rebuilt',
				'text_wait_slow_indexing',
				
				'text_curr_srv_conf',
				'text_mysql_var_name',	
				'text_mysql_var_value',
				
				'text_product_stats',
				'text_product_total',
				
				'text_help_fast',
				'text_help_default',
				'text_help_exact_match',
				'text_help_broad_match',	
				
				'text_help_sort_order',
				'text_help_translate_sort_order',
				
				'text_help_relevance',
				'text_help_partial_words',
				'text_help_db_optimization',
				
				'text_help_add_modules',
				'text_help_update_single_char',
				'text_help_update_entire_word',
			
				'text_preset_styles',
				'text_enable_live_search',
				
				'text_add_modules',
				'text_content_top',
				'text_content_bottom',	
				'text_column_left',
				'text_column_right',
				
				'text_live_search_options',
				'text_live_search_style',
				'text_dropdown_display_img',				
				'text_dropdown_img_size',
				'text_dropdown_img_border_color',
				
				'text_dropdown_display_price',
				'text_dropdown_display_rating',
				
				'text_dropdown_width',
				'text_dropdown_text_size',
				'text_dropdown_text_color',
				'text_dropdown_bg_color',
				'text_dropdown_border_color',
				'text_dropdown_hover_bg_color',
				
				'text_dropdown_update_on',
				'text_entire_word',
				'text_single_char',
				
				'text_dropdown_max_num_results',
								
				'text_dropdown_show_all',
				'text_dropdown_show_all_sample_text',
				
				'text_dropdown_no_results',
				'text_dropdown_no_results_sample_text',
				
				'text_warning_select_style',
				'text_info_save_in_custom_style',
				
				'text_entry',
				'text_show',
				'text_enable',
				'text_enabled',
				'text_disable',
				'text_disabled',
				'text_yes',
				'text_no',
				'text_help',
				
				
				'text_reset_default',
				
				'entry_meta_keyword',
				'entry_meta_description',
				'entry_name',
				'entry_description',
				'entry_tag',
				'entry_model',
				'entry_sku',
				'entry_upc',
				'entry_ean',
				'entry_jan',
				'entry_isbn',
				'entry_mpn',
				'entry_location',
				'entry_manufacturer_name',
				'entry_attribute_group_name',
				'entry_attribute_name',
				'entry_attribute_description',
				'entry_option_name',
				'entry_option_value',
				'entry_category_name',
				
				'entry_dimension',
				'entry_layout',
				'entry_position',
				'entry_status',
				'entry_sort_order',
				
				'user_guide',
				
				'entry_status',
				
				'button_add_module',
				'button_remove',
				'button_save',
				'button_save_continue',
				
				'text_cancel_save',
				'text_saving',
				'text_wait_slow_save',
				'save_aborted',
				'text_wait',
				
				'button_cancel',
				'text_save_success',
				'text_error',
		);

		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
		
		// load the translations for the "Sort by" dropdown (from the CATALOG language file /product/search.php)
		foreach($languages as $lang){               
			if($lang['code'] == $this->config->get('config_language')){
				$lang_dir = $lang['directory'];
				break;
			}
		}
		
		$this->language->load('../../../catalog/language/' . $lang_dir . '/product/search');

		// Opencart preset sort orders
		$data['text_optn_default']		= $this->language->get('text_default');
		$data['text_optn_name_asc']		= $this->language->get('text_name_asc');
		$data['text_optn_name_desc']	= $this->language->get('text_name_desc');
		$data['text_optn_price_asc']	= $this->language->get('text_price_asc');
		$data['text_optn_price_desc']	= $this->language->get('text_price_desc');
		$data['text_optn_rating_asc']	= $this->language->get('text_rating_asc');
		$data['text_optn_rating_desc']	= $this->language->get('text_rating_desc');
		$data['text_optn_model_asc']	= $this->language->get('text_model_asc');
		$data['text_optn_model_desc']	= $this->language->get('text_model_desc');
		
		// Texts for the new sort orders are read from the language file of Advanced Smart Search
		$data['text_optn_relevance']	= $this->language->get('text_optn_relevance');
		$data['text_optn_date_desc']	= $this->language->get('text_optn_date_desc');
		$data['text_optn_date_asc']		= $this->language->get('text_optn_date_asc');
		
		
		
		$data['config_language_id']		= (int)$this->config->get('config_language_id');

		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/adsmart_search', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('module/adsmart_search', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];
	
	
		$data['redirect'] = html_entity_decode($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
	
	
		// Select the right protocol for the urls that will be prepended to the autocomplete url.  If the protocol or the website name
		// doesn't match exactly the url of the current page, browsers will not allow the ajax request. For further details see:
		// XMLHttpRequest: Error 0x80070005  Access denied - (visible with IE Development Tools)
		$is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;

		if ($is_https) {
			$data['catalog_url'] = HTTPS_CATALOG;
		}
		else {
			$data['catalog_url'] = HTTP_CATALOG;
		}
				
		

		// This "if" is run only when the mdule loads for the first time.
		// At the first boot the var $this->config->get('adsmart_search_first_boot') is empty
		if ( $this->config->get('adsmart_search_first_boot') == '' ) { 
		
			// After the first boot, the template sets the flag "adsmart_search_first_boot" to 0 	
		
		}	
		
		
		$settings = array(	
			'first_boot',
			'index_snapshot',
			
			'algorithm',
			'status',
			'exact_broad',
			
			'sort_order',
			'translation_txt_relevance',
			'translation_txt_date_desc',
			'translation_txt_date_asc',
			
			'fields',
			'relevance',
			
			'include_plurals',
			
			'include_partial_words',
			'partial_word_length',
			
			'include_misspellings',
			'misspelling_tolerance',
			
			'enable_search_cache',
			'cache_update_frequency',
			
			'index_db',
			'rebuild_indexes',
			
			'dropdown_enabled',
			'dropdown_update_on_entire_word',
			'dropdown_preset_style',
			'dropdown_display_img',
			'dropdown_img_size',
			'dropdown_img_border_color',
			'dropdown_display_price',
			'dropdown_display_rating',
			'dropdown_width',
			'dropdown_text_size',
			'dropdown_text_color',
			'dropdown_bg_color',
			'dropdown_border_color',
			'dropdown_lighter_separator_color',
			'dropdown_darker_separator_color',
			'dropdown_hover_bg_color',
			'dropdown_hover_border_color',
			'dropdown_max_num_results',
			'dropdown_show_all',
			'dropdown_no_results',
			'dropdown_msg_bg_color',
			'dropdown_msg_text_color',
			'dropdown_msg_text_size',
			
			'last_cp_save_date'
		);
		
		foreach ($settings as $setting){

			if (isset($this->request->post['adsmart_search_'.$setting])) {
				$data['adsmart_search_'.$setting] = $this->request->post['adsmart_search_'.$setting];
			} else {
				$data['adsmart_search_'.$setting] = $this->config->get('adsmart_search_'.$setting);
			}		
		}
		
		

		// Modules and Layouts
		// This code handles the situation where you have multiple instances of this module, for different layouts.
		$data['modules'] = array();

		if (isset($this->request->post['adsmart_search_module'])) {
			$data['modules'] = $this->request->post['adsmart_search_module'];
		} elseif ($this->config->get('adsmart_search_module')) { 
			$data['modules'] = $this->config->get('adsmart_search_module');
		}	

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();
		
		
		
		
		
		// Db variables:
		
		// Get ft_min_word_len:
		$query = $this->db->query("SHOW VARIABLES LIKE 'ft_min_word_len'");
		$result = $query->row;
		$data['adsmart_search_ft_min_word_len'] = intval($result['Value']);
		
		// Get ft_min_word_len:
		$query = $this->db->query("SHOW VARIABLES LIKE 'ft_stopword_file'");
		$result = $query->row;
		$data['adsmart_search_ft_stopword_file'] = $result['Value'];
		
		// Get the total number of products (only enabled products, filter_status = 1):
		$this->load->model('catalog/product');
		$filters['filter_status']=1;
		$data['product_total'] = number_format($this->model_catalog_product->getTotalProducts($filters), 0, ',', ' ');
		
							
		// language settings for the text "Show all results" on the bottom of the dropdown window
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$data['languages'] = $languages;
		
		
		$path = 'module/adsmart_search.tpl';
		
		
		if ( version_compare(VERSION, '1.5.6.4', '<=') ) {
		
			// Load the module "Search Analytics" if available
			if ( file_exists(DIR_APPLICATION . 'controller/module/search_analytics.php') ) {
				$data['search_analytics'] = $this->getChild('module/search_analytics', array('standalone' => false));
			}
		
			$this->load->model('design/layout');
			$data['layouts'] = $this->model_design_layout->getLayouts();
		
			$this->children = array(
				'common/header',
				'common/footer'
			);

			$this->data = $data;
			
			$this->template = $path;
			$this->response->setOutput($this->render());
		}
		else {
		
			// Load the module "Search Analytics" if available
			if ( file_exists(DIR_APPLICATION . 'controller/module/search_analytics.php') ) {
			
				$data['search_analytics'] = $this->load->controller('module/search_analytics', array('standalone' => false));	
			}
					
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view($path, $data));
		}
	}
	
	
	
		
	public function clear_cache() {
	
		$label = $this->request->get['label'];
		$result = $this->cache->adsmart_search_clear_cache($label); // $result can be "true" or "false"
		$this->response->setOutput($result);
	}
	
	
			
			
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/adsmart_search')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		return !$this->error;	
	}
	
}
?>