<?php
	require DIR_APPLICATION . "controller/dapi/DapiResource.php";

	/**
	 * API category resource.
	 * Provides with specific access to categories to be available for api requests.
	 * And processes requests to categories by means of HTTP methods.
	 *
	 * @author Polyakov Ivan, SpurIT <contact@spur-i-t.com>
	 * @copyright Copyright (c) 2012 SpurIT <contact@spur-i-t.com>, All rights reserved
	 * @link http://spur-i-t.com
	 * @package D API
	 * @version 1.0.0
	 */
	class ControllerDapiCategories extends DapiResource
	{
		protected $_filter = array (
			'parent_id'
		);

		public function get()
		{
			$this->load->model( 'catalog/category' );
			$this->_getVars();
			// Get certain category.
			if ( isset ( $this->_vars['id'] ) ) {
				$category = $this->model_catalog_category->getCategory( $this->_vars['id'] );
				if ( $category !== false ) {
					$this->_data = $category;
				}
			}
			// Get all categories.
			else {
				$filter = $this->_filter();
				$parent_id = isset ( $filter['parent_id'] ) ? (integer) $filter['parent_id'] : 0;
				$categories = $this->model_catalog_category->getCategories( $parent_id );
				if ( !empty ( $categories ) ) {
					$this->_data = array_values( $categories );
					$this->_paginate();
				}
			}
			// Set output.
			parent::_response( $this->response, $this->output );
		}
	}
