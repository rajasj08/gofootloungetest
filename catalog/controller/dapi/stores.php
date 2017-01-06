<?php
	require DIR_APPLICATION . "controller/dapi/DapiResource.php";

	/**
	 * API store resource.
	 * Provides with specific access to stores to be available for api requests.
	 * And processes requests to stores by means of HTTP methods.
	 *
	 * @author Polyakov Ivan, SpurIT <contact@spur-i-t.com>
	 * @copyright Copyright (c) 2012 SpurIT <contact@spur-i-t.com>, All rights reserved
	 * @link http://spur-i-t.com
	 * @package D API
	 * @version 1.0.0
	 */
	class ControllerDapiStores extends DapiResource
	{
		public function get()
		{
			$this->load->model( 'dapi/setting' );
			$this->_getVars();
			// Get settings.
			if ( isset ( $this->_vars['group'] ) ) {
				$group = $this->_vars['group'];
				$storeId = isset ( $this->_vars['store_id'] ) ? $this->_vars['store_id'] : 0;
				$settings = $this->model_dapi_setting->getSetting( $group, $storeId );
				if ( !empty ( $settings ) ) {
					$this->_data = $settings;
				}
			}
			// Set output.
			parent::_response( $this->response, $this->output );
		}
	}
