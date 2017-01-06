<?php
require DIR_APPLICATION . "controller/dapi/DapiResource.php";

/**
 * API oprder resource.
 * Provides with specific access to orders to be available for api requests.
 * And processes requests to orders by means of HTTP methods.
 *
 * @author Polyakov Ivan, SpurIT <contact@spur-i-t.com>
 * @copyright Copyright (c) 2012 SpurIT <contact@spur-i-t.com>, All rights reserved
 * @link http://spur-i-t.com
 * @package D API
 * @version 1.0.1
 */
class ControllerDapiOrders extends DapiResource
{

	protected $_filter = array(
		'limit',
		'date_modified',
		'order_status'
	);

	public function get()
	{
		$this->load->model( 'dapi/orders' );
		$this->_getVars();
		// Get certain order.
		if ( isset ( $this->_vars[ 'id' ] ) ) {
			$product = $this->model_dapi_orders->getOrder( $this->_vars[ 'id' ] );
			if ( $product !== false ) {
				$this->_data = $product;
			}
		} // Get all orders.
		else {
			$filter = $this->_filter();
			$orders = $this->model_dapi_orders->getOrders( $filter );
			if ( !empty ( $orders ) ) {
				$orders = array_values( $orders );
				foreach ( $orders as $key => $order ) {
					$orders[ $key ][ 'products' ] = $this->model_dapi_orders->getOrderProducts( $order[ 'order_id' ] );
				}
				$this->_data = $orders;
			}
		}
		// Set output.
		parent::_response( $this->response, $this->output );
	}
}
