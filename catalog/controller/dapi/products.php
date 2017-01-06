<?php
require DIR_APPLICATION . "controller/dapi/DapiResource.php";

/**
 * API product resource & retrieves JSON product data.
 * Provides with specific access to products to be available for api requests.
 * And processes requests to products by means of HTTP methods.
 *
 * @author Polyakov Ivan, SpurIT <contact@spur-i-t.com>
 * @copyright Copyright (c) 2012 SpurIT <contact@spur-i-t.com>, All rights reserved
 * @link http://spur-i-t.com
 * @package D API
 * @version 1.0.1
 */
class ControllerDapiProducts extends DapiResource
{

	protected $_filter = array(
		'filter_category_id',
		'filter_sub_category',
		'filter_filter',
		'filter_name',
		'filter_tag',
		'filter_description',
		'filter_manufacturer_id',
		'limit'
	);

	/**
	 * JSON Product data for the front
	 */
	public function index()
	{
		if ( isset( $this->request->get[ 'product_id' ] ) && (int)$this->request->get[ 'product_id' ] ) {
			$this->load->model( 'catalog/product' );
			$product = $this->model_catalog_product->getProduct( (int)$this->request->get[ 'product_id' ] );
		}
		if ( isset( $product ) && $product ) {
			// Image
			$this->load->model( 'tool/image' );
			if ( $product[ 'image' ] ) {
				$image = $this->model_tool_image->resize( $product[ 'image' ], $this->config->get( 'config_image_popup_width' ), $this->config->get( 'config_image_popup_height' ) );
			} else {
				$image = '';
			}

			// Prices
			if ( ( $this->config->get( 'config_customer_price' ) && $this->customer->isLogged() ) || !$this->config->get( 'config_customer_price' ) ) {
				$price = $this->currency->format( $this->tax->calculate( $product[ 'price' ], $product[ 'tax_class_id' ], $this->config->get( 'config_tax' ) ) );
			} else {
				$price = $this->currency->format( 0 );
			}

			if ( (float)$product[ 'special' ] ) {
				$special = $this->currency->format( $this->tax->calculate( $product[ 'special' ], $product[ 'tax_class_id' ], $this->config->get( 'config_tax' ) ) );
			} else {
				$special = $this->currency->format( 0 );
			}

			// Options
			$option_data = count( $this->model_catalog_product->getProductOptions( $product[ 'product_id' ] ) );

			$data = array(
				'id' => (int)$product[ 'product_id' ],
				'title' => $product[ 'name' ],
				'sku' => $product[ 'sku' ],
				'price' => (float)$product[ 'special' ] ? $special : $price,
				'old_price' => (float)$product[ 'special' ] ? $price : $this->currency->format( 0 ),
				'url' => $this->url->link( 'product/product', 'product_id=' . $product[ 'product_id' ] ),
				'image' => $image,
				'options' => $option_data,
				'available' => ($product['quantity'] <= 0) ? false : true,
				'visible' => true
			);

			$this->response->setOutput( json_encode( $data ) );
		} else {
			header( 'HTTP/1.1 404 Not Found' );
			header( 'Status: 404 Not Found' );
			$this->response->setOutput( json_encode( array( 'hasError' => true, 'errors' => 'Product not found' ) ) );
		}

	}

	/**
	 * Api request
	 */
	public function get()
	{
		$this->load->model( 'catalog/product' );
		$this->_getVars();
		// Get certain product.
		if ( isset ( $this->_vars[ 'id' ] ) ) {
			$product = $this->model_catalog_product->getProduct( $this->_vars[ 'id' ] );
			if ( $product !== false ) {
				$this->_data = $product;
			}
		} // Get all products.
		else {
			$filter = $this->_filter();
			$products = $this->model_catalog_product->getProducts( $filter );
			if ( !empty ( $products ) ) {
				$this->_data = array_values( $products );
				$this->_paginate();
			}
		}
		// Set output.
		parent::_response( $this->response, $this->output );
	}
}
