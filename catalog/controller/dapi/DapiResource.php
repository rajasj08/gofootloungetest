<?php
	/**
	 * Abstract class for API resource controllers.
	 *
	 * @author Polyakov Ivan, SpurIT <contact@spur-i-t.com>
	 * @copyright Copyright (c) 2012 SpurIT <contact@spur-i-t.com>, All rights reserved
	 * @link http://spur-i-t.com
	 * @package D API
	 * @version 1.0.0
	 */
	abstract class DapiResource extends Controller
	{
		/**
		 * Request variables.
		 * @var array
		 */
		protected $_vars = null;

		/**
		 * Data for response.
		 * @var mixed
		 */
		protected $_data = null;

		/**
		 * Available filter fields.
		 * @var array
		 */
		protected $_filter = array ();

		/**
		 * @internal GET http method.
		 */
		abstract public function get();

		/**
		 * Sets request variables.
		 */
		protected function _getVars() {
			parse_str( file_get_contents( 'php://input' ), $this->_vars );
		}

		/**
		 * Sets action response.
		 * @param object $response - action response field.
		 * @param object $output - action output field.
		 */
		protected function _response( &$response, &$output )
		{
			if ( $this->_data ) {
				$output = json_encode( $this->_data );
				$response->setOutput( $output );
			}
		}

		/**
		 * Paginates data if specific parameters were given.
		 * Accepts following parameters :
		 * page - page number.
		 * items_per_page - item count per page.
		 */
		protected function _paginate()
		{
			if ( isset ( $this->_vars['page'] ) ) {
				$itemsPerPage = isset ( $this->_vars['items_per_page'] ) ? (integer) $this->_vars['items_per_page'] : 10;
				$offset = ( $this->_vars['page'] * $itemsPerPage ) - $itemsPerPage;
				if ( isset ( $this->_data[ $offset ] ) ) {
					$this->_data = array_slice( $this->_data, $offset, $itemsPerPage );
				}
			}
		}

		/**
		 * Checks filter parameters and returns only available.
		 * @return array | null
		 */
		protected function _filter()
		{
			if ( isset ( $this->_vars['filter'] ) && is_array( $this->_vars['filter'] ) ) {
				foreach ( $this->_vars['filter'] as $field => $value ) {
					if ( !in_array( $field, $this->_filter ) ) {
						unset ( $this->_vars['filter'][ $field ] );
					}
				}
				return $this->_vars['filter'];
			}
			return null;
		}
	}
