<?php 
class ControllerAccountTrackOrder extends Controller {
	private $error = array();
		
	public function index() {
		if ($this->customer->isLogged()) {
			$this->redirect($this->url->link('account/order', '', 'SSL'));
		}

		$this->language->load('account/order');
		$this->language->load('account/track_order');


		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/track_order', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] 		= $this->language->get('heading_title');
		$this->data['text_order'] 			= $this->language->get('text_order');
		$this->data['text_account'] 		= $this->language->get('text_account');

		$this->data['entry_email'] 			= $this->language->get('entry_email');
		$this->data['entry_order_id'] 		= $this->language->get('entry_order_id');

		$this->data['btn_track_order'] 		= $this->language->get('btn_track_order');

		$this->data['error_email_empty']	= $this->language->get('error_email_empty');
		$this->data['error_order_id_empty']	= $this->language->get('error_order_id_empty');
		$this->data['error_no_order_found']	= $this->language->get('error_no_order_found');

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = "";
		}

		if (isset($this->request->post['order_id'])) {
			$this->data['order_id'] = $this->request->post['order_id'];
		} else {
			$this->data['order_id'] = "";
		}

		$template = "track_order";

		if (isset($this->request->get['email']) && isset($this->request->get['order_id']))
		{
			$this->request->post['email']		= $this->request->get['email'];
			$this->request->post['order_id']	= $this->request->get['order_id'];
		}

		if (isset($this->request->post['email']) && isset($this->request->post['order_id']) && $this->validateForm())
		{
			$this->load->model('account/track_order');

			$order_info = $this->model_account_track_order->getOrder($this->request->post['order_id'], $this->request->post['email']);

			if (!$order_info) //if no order found
			{
				$this->data['error_warning'] = $this->data['error_no_order_found'];
			}
			else
			{
				$template = "order_info";

				$this->language->load('account/order');

				$this->data['heading_title'] = $this->language->get('text_order');

				$this->data['text_order_detail'] 		= $this->language->get('text_order_detail');
				$this->data['text_invoice_no'] 			= $this->language->get('text_invoice_no');
				$this->data['text_order_id'] 			= $this->language->get('text_order_id');
				$this->data['text_date_added'] 			= $this->language->get('text_date_added');
				$this->data['text_shipping_method'] 	= $this->language->get('text_shipping_method');
				$this->data['text_shipping_address'] 	= $this->language->get('text_shipping_address');
				$this->data['text_payment_method'] 		= $this->language->get('text_payment_method');
				$this->data['text_payment_address'] 	= $this->language->get('text_payment_address');
				$this->data['text_history'] 			= $this->language->get('text_history');
				$this->data['text_comment'] 			= $this->language->get('text_comment');
				$this->data['text_shipping_status']		= $this->language->get('text_shipping_status');
				$this->data['text_tracking_no']			= $this->language->get('text_tracking_no');

				$this->data['column_name'] = $this->language->get('column_name');
				$this->data['column_model'] = $this->language->get('column_model');
				$this->data['column_quantity'] = $this->language->get('column_quantity');
				$this->data['column_price'] = $this->language->get('column_price');
				$this->data['column_total'] = $this->language->get('column_total');
				$this->data['column_action'] = $this->language->get('column_action');
				$this->data['column_date_added'] = $this->language->get('column_date_added');
				$this->data['column_status'] = $this->language->get('column_status');
				$this->data['column_comment'] = $this->language->get('column_comment');

				$this->data['button_return'] = $this->language->get('button_return');
				$this->data['button_continue'] = $this->language->get('button_continue');

				if ($order_info['invoice_no']) {
					$this->data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$this->data['invoice_no'] = '';
				}

				$this->data['order_id'] = $this->request->post['order_id'];
				$this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->data['payment_method'] = $order_info['payment_method'];

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->data['shipping_method'] = $order_info['shipping_method'];

				$this->data['products'] = array();

				$products = $this->model_account_track_order->getOrderProducts($this->request->post['order_id']);

				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_account_track_order->getOrderOptions($this->request->post['order_id'], $product['order_product_id']);

					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
						);
					}

					$this->data['products'][] = array(
						'name'    	 	=> $product['name'],
						'model'   	 	=> $product['model'],
						'option'  	 	=> $option_data,
						'quantity'	 	=> $product['quantity'],
						'price'  	  	=> $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'  	  	=> $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
						'return' 	  	=> $this->url->link('account/return/insert', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL'),
					);
				}

				// Voucher
				$this->data['vouchers'] = array();

				$vouchers = $this->model_account_track_order->getOrderVouchers($this->request->post['order_id']);

				foreach ($vouchers as $voucher) {
					$this->data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}

				$this->data['totals'] = $this->model_account_track_order->getOrderTotals($this->request->post['order_id']);

				$this->data['comment'] = nl2br($order_info['comment']);

				$this->data['histories'] = array();

				$results = $this->model_account_track_order->getOrderHistories($this->request->post['order_id']);

				foreach ($results as $result) {
					$this->data['histories'][] = array(
						'date_added' 	=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
						'status'     	=> $result['status'],
						'comment'    	=> nl2br($result['comment'])
					);
				}

				$this->data['shipping_status'] = false;


				$this->data['continue'] = $this->url->link('account/order', '', 'SSL');

			}
		}

		$this->data["error"] = $this->error;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/'.$template.'.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/'.$template.'.tpl';
		} else {
			$this->template = 'default/template/account/'.$template.'.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());

	}

	private function validateForm() {

		if ($this->request->post['email'] == '') {
			$this->error['email'] = $this->language->get('error_email_empty');
		}

		if ($this->request->post['order_id'] == '') {
			$this->error['order_id'] = $this->language->get('error_order_id_empty');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}

?>