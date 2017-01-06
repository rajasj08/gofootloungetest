<?php
	require DIR_APPLICATION . "controller/dapi/DapiResource.php";

	/**
	 * API count resource.
	 * Provides with information about resource entity amount.
	 *
	 * @author Polyakov Ivan, SpurIT <contact@spur-i-t.com>
	 * @copyright Copyright (c) 2012 SpurIT <contact@spur-i-t.com>, All rights reserved
	 * @link http://spur-i-t.com
	 * @package D API
	 * @version 1.0.0
	 */
	class ControllerDapiCount extends DapiResource
	{
		public function get()
		{
			$this->_getVars();
			// Count.
			if ( isset ( $this->_vars['resource'] ) ) {
				switch ( $this->_vars['resource'] ) {
					// Products.
					case 'products':
						$this->load->model( 'catalog/product' );
						$this->_filter = array (
							'filter_category_id',
							'filter_sub_category',
							'filter_filter',
							'filter_name',
							'filter_tag',
							'filter_description',
							'filter_manufacturer_id',
							'limit'
						);
						$filter = $this->_filter();
						$count = $this->model_catalog_product->getTotalProducts( $filter );
						$this->_data = $count;
						break;
					// Categories.
					case 'categories':
						$this->load->model( 'catalog/category' );
						$this->_filter = array (
							'parent_id'
						);
						$filter = $this->_filter();
						$parent_id = isset ( $filter['parent_id'] ) ? (integer) $filter['parent_id'] : 0;
						$count = $this->model_catalog_category->getTotalCategoriesByCategoryId( $parent_id );
						$this->_data = $count;
						break;
					// Orders.
					case 'orders':
						$this->load->model( 'dapi/orders' );
						$this->_filter = array (
							'date_modified',
							'order_status'
						);
						$filter = $this->_filter();
						$count = $this->model_dapi_orders->getTotalOrders( $filter );
						$this->_data = $count;
						break;
				}
			}
			// Set output.
			parent::_response( $this->response, $this->output );
		}
	}
