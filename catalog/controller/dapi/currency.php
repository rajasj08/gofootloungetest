<?php
/**
 * Currency resource.
 * Retrieves store currency.
 * Returns json data.
 *
 * @author Kovalev Yury, SpurIT <contact@spur-i-t.com>
 * @copyright Copyright (c) 2012 SpurIT <contact@spur-i-t.com>, All rights reserved
 * @link http://spur-i-t.com
 * @package D API
 * @version 1.0.0
 */
class ControllerDapiCurrency extends Controller
{

	public function index()
	{
		$currencies = array();
		$this->load->model('localisation/currency');
		$results = $this->model_localisation_currency->getCurrencies();
		foreach ($results as $result) {
			if ($result['status']) {
				$currencies[$result['code']] = array(
					'rate' => $result['value'],
					'sign_left' => $result['symbol_left'],
					'sign_right' => $result['symbol_right']
				);
			}
		}

		$this->response->setOutput( json_encode(
			array(
				'currentRate' => $this->currency->getValue(),
				'currencies' => $currencies
			)
		) );
	}

}

?>
