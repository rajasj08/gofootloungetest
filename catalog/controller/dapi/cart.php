<?php
/**
 * Cart resource.
 * Retrieves products from the cart.
 * Returns json data.
 *
 * @author Kovalev Yury, SpurIT <contact@spur-i-t.com>
 * @copyright Copyright (c) 2012 SpurIT <contact@spur-i-t.com>, All rights reserved
 * @link http://spur-i-t.com
 * @package D API
 * @version 1.0.0
 */
class ControllerDapiCart extends Controller
{

	public function index()
	{
		$data = array();

		if ( $this->cart->hasProducts() ) {
			$this->load->model( 'tool/image' );

			$product_total = 0;
			$products = $this->cart->getProducts();
			foreach ( $products as $product ) {
				// Total qty
				foreach ( $products as $product_2 ) {
					if ( $product_2[ 'product_id' ] == $product[ 'product_id' ] ) {
						$product_total += $product_2[ 'quantity' ];
					}
				}

				// Image
				if ( $product[ 'image' ] ) {
					$image = $this->model_tool_image->resize( $product[ 'image' ], $this->config->get( 'config_image_popup_width' ), $this->config->get( 'config_image_popup_width' ) );
				} else {
					$image = '';
				}

				// Options
				$option_data = count( $product[ 'option' ] );

				// Price
				if ( ( $this->config->get( 'config_customer_price' ) && $this->customer->isLogged() ) || !$this->config->get( 'config_customer_price' ) ) {
					$price = $this->currency->format( $this->tax->calculate( $product[ 'price' ], $product[ 'tax_class_id' ], $this->config->get( 'config_tax' ) ), '', '', false );
				} else {
					$price = false;
				}

				// Total Price
				if ( ( $this->config->get( 'config_customer_price' ) && $this->customer->isLogged() ) || !$this->config->get( 'config_customer_price' ) ) {
					$total = $this->currency->format( $this->tax->calculate( $product[ 'price' ], $product[ 'tax_class_id' ], $this->config->get( 'config_tax' ) ) * $product[ 'quantity' ], '', '', false );
				} else {
					$total = false;
				}

				$data[ 'items' ][ ] = array(
					'id' => (int)$product[ 'product_id' ],
					'image' => $image,
					'title' => $product[ 'name' ],
					'option' => $option_data,
					'price' => $price,
					'total' => $total,
					'quantity' => $product[ 'quantity' ],
					'url' => $this->url->link( 'product/product', 'product_id=' . $product[ 'product_id' ] ),
					'remove' => html_entity_decode( $this->url->link( 'checkout/cart', 'remove=' . $product[ 'key' ] ) ),
				);
			}

			// Total item count
			$data[ 'item_count' ] = $product_total;

			// Totals
			$this->load->model( 'setting/extension' );

			// Total Cart Prices
			if ( ( $this->config->get( 'config_customer_price' ) && $this->customer->isLogged() ) || !$this->config->get( 'config_customer_price' ) ) {
				$total_data = $total_value = array();
				$total = 0;
				$taxes = $this->cart->getTaxes();
				$results = $this->model_setting_extension->getExtensions( 'total' );
				foreach ( $results as $result ) {
					if ( $result[ 'code' ] !== 'total' ) continue;
					if ( $this->config->get( $result[ 'code' ] . '_status' ) ) {
						$this->load->model( 'total/' . $result[ 'code' ] );

						$this->{'model_total_' . $result[ 'code' ]}->getTotal( $total_data, $total, $taxes );
					}
				}
				foreach ( $total_data as $key => $value ) {
					if ( $value[ 'code' ] == 'total' ) {
						$total_value = $value;
						break;
					}
				}
			}

			$data[ 'totals' ] = $total_value;
		}

		$this->response->setOutput( json_encode( $data ) );
	}

}

?>
