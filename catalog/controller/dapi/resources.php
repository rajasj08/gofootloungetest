<?php
	/**
	 * API resource controller.
	 * Accepts all api requests and calls specific resource controller to process it.
	 *
	 * Requests can be four types : GET, POST, PUT, DELETE.
	 * GET - getting some entities or their data.
	 * POST - editing some entities or their data.
	 * PUT - creating some entities or their data.
	 * DELETE - deleting some entities or their data.
	 *
	 * All resource controllers contains actions to process each method.
	 * Response data has json format.
	 *
	 * Available resources : stores, categories, products, orders, count.
	 * Full resource route is dapi/resources/RESOURCE.
	 * @example http://site.com/index.php?route=dapi/resources/products&id=0
	 *
	 * @author Polyakov Ivan, SpurIT <contact@spur-i-t.com>
	 * @copyright Copyright (c) 2012 SpurIT <contact@spur-i-t.com>, All rights reserved
	 * @link http://spur-i-t.com
	 * @package D API
	 * @version 1.0.1
	 */
	class ControllerDapiResources extends Controller
	{
		/**
		 * Message key.
		 * @var integer
		 */
		protected $_messageKey = null;

		/**
		 * Response messages.
		 * @var array
		 */
		protected $_messages = array (
			'Token is missed.',
			'Wrong token.',
			'Wrong resource.',
			'No data for such parameters.'
		);

		/**
		 * Available responses.
		 * @var array
		 */
		protected $_resources = array (
			'stores', 'categories', 'products', 'orders', 'count', 'orderstatuses'
		);

		/**
		 * Returns http method.
		 * @return string
		 */
		private function _getHttpMethod() {
			return $method = strtolower( $this->request->server['REQUEST_METHOD'] );
		}

		/**
		 * Forms opencart route to call controller of requested resource.
		 * @param string $resource - resource name.
		 * @return string
		 */
		private function _getRoute( $resource )
		{
			if ( in_array( $resource, $this->_resources ) ) {
				return 'dapi/'. $resource .'/'. $this->_getHttpMethod();
			} else {
				$this->_messageKey = 2;
				return null;
			}
		}

		/**
		 * Token validation.
		 * @return bool
		 */
		private function _validate()
		{
			if ( !isset ( $this->request->server['HTTP_DAPI_TOKEN'] ) ) {
				$this->_messageKey = 0;
				return false;
			}
			$this->load->model( 'dapi/token' );
			$row = $this->model_dapi_token->find(
				$this->request->server['HTTP_DAPI_TOKEN']
			);
			if ( $row ) {
				$this->_storeId = $row['store_id'];
				return true;
			} else {
				$this->_messageKey = 1;
				return false;
			}
		}

		/**
		 * Calls resource controller.
		 * @param string $route - opencart route.
		 * @return string | null
		 */
		private function _call( $route )
		{
			if ( $this->hasAction( $route ) ) {
				return $this->getChild( $route );
			}
		}

		/**
		 * Forms a response.
		 * @param string $resource - type of resource that was requested.
		 * @param string $data - found data for resource in json format.
		 * @return json
		 */
		private function _response( $resource, $data = null )
		{
			// Success.
			if ( $this->_messageKey === null ) {
				$response = json_encode( array (
					'resource' => $resource,
					'method' => $this->_getHttpMethod(),
					'status' => 'success',
					'data' => json_decode( $data )
				) );
			// Failure.
			} else {
				$response = json_encode( array (
					'resource' => $resource,
					'method' => $this->_getHttpMethod(),
					'status' => 'failure',
					'message' => $this->_messages[ $this->_messageKey ]
				) );
			}
			return $response;
		}

		/**
		 * Processes requests and calls specific resource controller.
		 */
		public function __call( $name, $arguments )
		{
			$data = null;
			$route = $this->_getRoute( $name );
			if ( $this->_validate() && $route ) {
				$data = $this->_call( $route );
			}
			$this->response->setOutput(
				$this->_response( $name, $data )
			);
		}
	}
