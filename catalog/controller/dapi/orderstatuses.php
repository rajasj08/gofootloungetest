<?php
require DIR_APPLICATION . "controller/dapi/DapiResource.php";

/**
 * API order statuses resource.
 * Provides with specific access to orders to be available for api requests.
 * And processes requests to orders by means of HTTP methods.
 *
 * @author Kovalev Yury, SpurIT <contact@spur-i-t.com>
 * @copyright Copyright (c) 2012 SpurIT <contact@spur-i-t.com>, All rights reserved
 * @link http://spur-i-t.com
 * @package D API
 * @version 1.0.0
 */
class ControllerDapiOrderStatuses extends DapiResource
{

	public function get()
	{
		$this->load->model( 'dapi/orders' );
		// Get all order statuses.
		$statuses = $this->model_dapi_orders->getOrderStatuses();
		if ( !empty ( $statuses ) ) {
			$this->_data = array_values( $statuses );
		}
		// Set output.
		parent::_response( $this->response, $this->output );
	}
}
