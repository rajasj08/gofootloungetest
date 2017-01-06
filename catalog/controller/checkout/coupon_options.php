<?php  
class ControllerCheckoutCouponOptions extends Controller {

	private $error = array();
  	public function index() {


		$this->language->load('checkout/checkout');
		$this->language->load('checkout/cart');

		if (!isset($this->session->data['vouchers'])) {
			$this->session->data['vouchers'] = array();
		}

		// Coupon 

		if (!isset($this->session->data['coupon']))
		{
			$this->session->data['coupon'] = "";
		}
		
		if (isset($this->request->post['coupon'])) 
		{
			$this->session->data['coupon'] = $this->request->post['coupon'];
		}

		if (isset($this->session->data['coupon']) && ($this->session->data['coupon'] != "") && !$this->validateCouponInitial()) { 
			$this->error['warning'] = $this->language->get('error_coupon');
		}

		// Voucher
		

		if (!isset($this->session->data['coupon']))
		{
			$this->session->data['voucher'] = "";
		}

		if (isset($this->request->post['voucher'])) 
		{
			$this->session->data['voucher'] = $this->request->post['voucher'];
		}
		if (isset($this->session->data['voucher']) && ($this->session->data['voucher'] != "") && !$this->validateVoucherInitial()) { 
			$this->error['warning'] = $this->language->get('error_voucher');
		}

		// Reward
		

		if (!isset($this->session->data['coupon']))
		{
			$this->session->data['reward'] = "";
		}

		if (isset($this->request->post['reward'])) 
		{
			$this->session->data['reward'] = $this->request->post['reward'];
		}
		if (isset($this->session->data['reward']) && ($this->session->data['reward'] != "") && !$this->validateRewardInitial()) { 
			$this->error['warning'] = $this->language->get('error_reward');
		}
		
	

		if ($this->cart->hasProducts() || !empty($this->session->data['vouchers'])) {
			$points = $this->customer->getRewardPoints();
			
			$points_total = 0;
			
			foreach ($this->cart->getProducts() as $product) {
				if ($product['points']) {
					$points_total += $product['points'];
				}
			}		
				
      		$this->data['heading_title'] = $this->language->get('heading_title');
			
			$this->data['text_next'] = $this->language->get('text_next');
			$this->data['text_next_choice'] = $this->language->get('text_next_choice');
     		$this->data['text_use_coupon'] = $this->language->get('text_use_coupon');
			$this->data['text_use_voucher'] = $this->language->get('text_use_voucher');
			$this->data['text_use_reward'] = sprintf($this->language->get('text_use_reward'), $points);
			$this->data['text_shipping_estimate'] = $this->language->get('text_shipping_estimate');
			$this->data['text_shipping_detail'] = $this->language->get('text_shipping_detail');
			$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$this->data['text_select'] = $this->language->get('text_select');
			$this->data['text_none'] = $this->language->get('text_none');
						
			$this->data['column_image'] = $this->language->get('column_image');
      		$this->data['column_name'] = $this->language->get('column_name');
      		$this->data['column_model'] = $this->language->get('column_model');
      		$this->data['column_quantity'] = $this->language->get('column_quantity');
			$this->data['column_price'] = $this->language->get('column_price');
      		$this->data['column_total'] = $this->language->get('column_total');
			
			$this->data['entry_coupon'] = $this->language->get('entry_coupon');
			$this->data['entry_voucher'] = $this->language->get('entry_voucher');
			$this->data['entry_reward'] = sprintf($this->language->get('entry_reward'), $points_total);
			$this->data['entry_country'] = $this->language->get('entry_country');
			$this->data['entry_zone'] = $this->language->get('entry_zone');
			$this->data['entry_postcode'] = $this->language->get('entry_postcode');
						
			$this->data['button_update'] = $this->language->get('button_update');
			$this->data['button_remove'] = $this->language->get('button_remove');
			$this->data['button_coupon'] = $this->language->get('button_coupon');
			$this->data['button_voucher'] = $this->language->get('button_voucher');
			$this->data['button_reward'] = $this->language->get('button_reward');
			$this->data['button_quote'] = $this->language->get('button_quote');
			$this->data['button_shipping'] = $this->language->get('button_shipping');			
      		$this->data['button_shopping'] = $this->language->get('button_shopping');
      		$this->data['button_checkout'] = $this->language->get('button_checkout');
			
			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} elseif (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
      			$this->data['error_warning'] = $this->language->get('error_stock');		
			} else {
				$this->data['error_warning'] = '';
			}
			
			if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
				$this->data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
			} else {
				$this->data['attention'] = '';
			}
						
			if (isset($this->session->data['success'])) {
				$this->data['success'] = $this->session->data['success'];
			
				unset($this->session->data['success']);
			} else {
				$this->data['success'] = '';
			}
			
			$this->data['action'] = $this->url->link('checkout/cart');   
						
			if ($this->config->get('config_cart_weight')) {
				$this->data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
			} else {
				$this->data['weight'] = '';
			}
						 
			$this->load->model('tool/image');
			
      		$this->data['products'] = array();
			
			$products = $this->cart->getProducts();

      		foreach ($products as $product) {
				$product_total = 0;
					
				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}			
				
				if ($product['minimum'] > $product_total) {
					$this->data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}				
					
				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				} else {
					$image = '';
				}

				$option_data = array();

        		foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['option_value'];	
					} else {
						$filename = $this->encryption->decrypt($option['option_value']);
						
						$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
					}
					
					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
        		}
				
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
				} else {
					$total = false;
				}
				
        		$this->data['products'][] = array(
          			'key'      => $product['key'],
          			'thumb'    => $image,
					'name'     => $product['name'],
          			'model'    => $product['model'],
          			'option'   => $option_data,
          			'quantity' => $product['quantity'],
          			'stock'    => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					'reward'   => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
					'price'    => $price,
					'total'    => $total,
					'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id']),
					'remove'   => $this->url->link('checkout/cart', 'remove=' . $product['key'])
				);
      		}
			
			// Gift Voucher
			$this->data['vouchers'] = array();
			
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$this->data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)   
					);
				}
			}

			if (isset($this->request->post['next'])) {
				$this->data['next'] = $this->request->post['next'];
			} else {
				$this->data['next'] = '';
			}
						 
			$this->data['coupon_status'] = $this->config->get('coupon_status');
			
			if (isset($this->request->post['coupon'])) {
				$this->data['coupon'] = $this->request->post['coupon'];			
			} elseif (isset($this->session->data['coupon'])) {
				$this->data['coupon'] = $this->session->data['coupon'];
			} else {
				$this->data['coupon'] = '';
			}
			
			$this->data['voucher_status'] = $this->config->get('voucher_status');
			
			if (isset($this->request->post['voucher'])) {
				$this->data['voucher'] = $this->request->post['voucher'];				
			} elseif (isset($this->session->data['voucher'])) {
				$this->data['voucher'] = $this->session->data['voucher'];
			} else {
				$this->data['voucher'] = '';
			}
			
			$this->data['reward_status'] = ($points && $points_total && $this->config->get('reward_status'));
			
			if (isset($this->request->post['reward'])) {
				$this->data['reward'] = $this->request->post['reward'];				
			} elseif (isset($this->session->data['reward'])) {
				$this->data['reward'] = $this->session->data['reward'];
			} else {
				$this->data['reward'] = '';
			}

			$this->data['shipping_status'] = $this->config->get('shipping_status') && $this->config->get('shipping_estimator') && $this->cart->hasShipping();	
								
			if (isset($this->request->post['country_id'])) {
				$this->data['country_id'] = $this->request->post['country_id'];				
			} elseif (isset($this->session->data['shipping_country_id'])) {
				$this->data['country_id'] = $this->session->data['shipping_country_id'];			  	
			} else {
				$this->data['country_id'] = $this->config->get('config_country_id');
			}
				
			$this->load->model('localisation/country');
			
			$this->data['countries'] = $this->model_localisation_country->getCountries();
						
			if (isset($this->request->post['zone_id'])) {
				$this->data['zone_id'] = $this->request->post['zone_id'];				
			} elseif (isset($this->session->data['shipping_zone_id'])) {
				$this->data['zone_id'] = $this->session->data['shipping_zone_id'];			
			} else {
				$this->data['zone_id'] = '';
			}
			
			if (isset($this->request->post['postcode'])) {
				$this->data['postcode'] = $this->request->post['postcode'];				
			} elseif (isset($this->session->data['shipping_postcode'])) {
				$this->data['postcode'] = $this->session->data['shipping_postcode'];					
			} else {
				$this->data['postcode'] = '';
			}
			
			if (isset($this->request->post['shipping_method'])) {
				$this->data['shipping_method'] = $this->request->post['shipping_method'];				
			} elseif (isset($this->session->data['shipping_method'])) {
				$this->data['shipping_method'] = $this->session->data['shipping_method']['code']; 
			} else {
				$this->data['shipping_method'] = '';
			}
						
			// Totals
			$this->load->model('setting/extension');
			
			$total_data = array();					
			$total = 0;
			$taxes = $this->cart->getTaxes();
			
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array(); 
				
				$results = $this->model_setting_extension->getExtensions('total');
				
				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}
				
				array_multisort($sort_order, SORT_ASC, $results);
				
				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);
			
						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
					
					$sort_order = array(); 
				  
					foreach ($total_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}
		
					array_multisort($sort_order, SORT_ASC, $total_data);			
				}
			}
			
			$this->data['totals'] = $total_data;
						
			$this->data['continue'] = $this->url->link('common/home');
						
			$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/cart.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/checkout/cart.tpl';
			} else {
				$this->template = 'default/template/checkout/cart.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_bottom',
				'common/content_top',
				'common/footer',
				'common/header'	
			);
						
			$this->response->setOutput($this->render());					
    	} else {
      		$this->data['heading_title'] = $this->language->get('heading_title');

      		$this->data['text_error'] = $this->language->get('text_empty');

      		$this->data['button_continue'] = $this->language->get('button_continue');
			
      		$this->data['continue'] = $this->url->link('common/home');

			unset($this->session->data['success']);

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
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
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/coupon_options.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/coupon_options.tpl';
		} else {
			$this->template = 'default/template/checkout/coupon_options.tpl';
		}
		
		$this->response->setOutput($this->render());
  	}
	
	protected function validateCouponInitial() {
		$this->load->model('checkout/coupon');
				
		$coupon_info = $this->model_checkout_coupon->getCoupon($this->session->data['coupon']);			
		
		if (!$coupon_info) {			
			$this->error['warning'] = $this->language->get('error_coupon');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}		
	}
	
	protected function validateVoucherInitial() {
		$this->load->model('checkout/voucher');
				
		$voucher_info = $this->model_checkout_voucher->getVoucher($this->session->data['voucher']);			
		
		if (!$voucher_info) {			
			$this->error['warning'] = $this->language->get('error_voucher');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}		
	}
	
	protected function validateRewardInitial() {
		$points = $this->customer->getRewardPoints();
		
		$points_total = 0;
		
		foreach ($this->cart->getProducts() as $product) {
			if ($product['points']) {
				$points_total += $product['points'];
			}
		}	
				
		if (empty($this->session->data['reward'])) {
			$this->error['warning'] = $this->language->get('error_reward');
		}
	
		if ($this->request->post['reward'] > $points) {
			$this->error['warning'] = sprintf($this->language->get('error_points'), $this->session->data['reward']);
		}
		
		if ($this->request->post['reward'] > $points_total) {
			$this->error['warning'] = sprintf($this->language->get('error_maximum'), $points_total);
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}		
	}

	protected function validateCoupon() {
		$this->load->model('checkout/coupon');
				
		$coupon_info = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);			
		
		$errorExist = "";
		if (!$coupon_info) {	
			$errorExist = $this->language->get('error_coupon');	
		}
		return $errorExist;	
	}
	
	protected function validateVoucher() {
		$this->load->model('checkout/voucher');
				
		$voucher_info = $this->model_checkout_voucher->getVoucher($this->request->post['voucher']);			
		
		$errorExist = "";
		if (!$voucher_info) {	
			$errorExist = $this->language->get('error_voucher');	
		}
		return $errorExist;		
	}
	
	protected function validateReward() {
		$points = $this->customer->getRewardPoints();
		
		$points_total = 0;
		
		foreach ($this->cart->getProducts() as $product) {
			if ($product['points']) {
				$points_total += $product['points'];
			}
		}	
		
		$errorExist = "";

		if (empty($this->request->post['reward'])) {
			$errorExist = $this->language->get('error_reward');
		}
	
		if ($this->request->post['reward'] > $points) {
			$errorExist = sprintf($this->language->get('error_points'), $this->request->post['reward']);
		}
		
		if ($this->request->post['reward'] > $points_total) {
			$errorExist = sprintf($this->language->get('error_maximum'), $points_total);
		}
		
		return $errorExist;		
	}

	public function validate() {
		$this->language->load('checkout/checkout');
		$this->language->load('checkout/cart');
		//Coupon
		if (isset($this->request->post['coupon'])) { 

			$validateCoupon = $this->validateCoupon();
			$output = array("success"  => false, "msg" => "");
			if($validateCoupon == "")
			{
				$this->session->data['coupon'] 			= $this->request->post['coupon'];
				$this->session->data['success'] 		= $this->language->get('text_coupon');
				//$this->data['success'] 					= $this->language->get('text_coupon')
				$output['success'] 						= true;
				$output['msg'] 							= $this->language->get('text_coupon');
			}
			else
			{
				$output['msg'] 							= $validateCoupon;
				//$this->data['error_warning'] 			= $validateCoupon;;
			}

			echo json_encode($output);
			die;
		}

		// Voucher
		if (isset($this->request->post['voucher'])) { 

			$validateVoucher = $this->validateVoucher();
			$output = array("success"  => false, "msg" => "");
			if($validateVoucher == "")
			{
				$this->session->data['voucher'] 	= $this->request->post['voucher'];
				$this->session->data['success'] 	= $this->language->get('text_voucher');
				//$this->data['success'] 				= $this->language->get('text_voucher')
				$output['success'] 					= true;
				$output['msg'] 						= $this->language->get('text_voucher');
			}
			else
			{
				$output['msg'] 						= $validateVoucher;
				//$this->data['error_warning'] 		= $validateVoucher;;
			}
			echo json_encode($output);
			die;

		}

		// Reward
		if (isset($this->request->post['reward'])) { 
			$validateReward = $this->validateReward();
			$output = array("success"  => false, "msg" => "");
			if($validateReward == "")
			{
				$this->session->data['reward'] 		= $this->request->post['reward'];
				$this->session->data['success'] 	= $this->language->get('text_reward');
				//$this->data['success'] 				= $this->language->get('text_reward')
				$output['success'] 					= true;
				$output['msg']						= $this->language->get('text_reward');
			}
			else
			{
				$output['msg'] 						= $validateReward;
				//$this->data['error_warning'] 		= $validateReward;;
			}
			echo json_encode($output);
			die;
		}

	}
	
	function cartvalidate()// validate counpon in cart
	{
		$this->language->load('checkout/checkout');
		$this->language->load('checkout/cart');
		//Coupon
		if (isset($this->request->post['coupon'])) { 

			$validateCoupon = $this->validateCoupon();
			$output = array("success"  => false, "msg" => "");
			if($validateCoupon == "")
			{
				$this->session->data['coupon'] 			= $this->request->post['coupon'];
				$this->session->data['success'] 		= $this->language->get('text_coupon');
				//$this->data['success'] 					= $this->language->get('text_coupon')
				$output['success'] 						= true;
				$output['msg'] 							= $this->language->get('text_coupon');
			}
			else
			{
				$output['msg'] 							= $validateCoupon;
				//$this->data['error_warning'] 			= $validateCoupon;;
			}

			echo json_encode($output);
			die;
		}

		// Voucher
		if (isset($this->request->post['voucher'])) { 

			$validateVoucher = $this->validateVoucher();
			$output = array("success"  => false, "msg" => "");
			if($validateVoucher == "")
			{
				$this->session->data['voucher'] 	= $this->request->post['voucher'];
				$this->session->data['success'] 	= $this->language->get('text_voucher');
				//$this->data['success'] 				= $this->language->get('text_voucher')
				$output['success'] 					= true;
				$output['msg'] 						= $this->language->get('text_voucher');
			}
			else
			{
				$output['msg'] 						= $validateVoucher;
				//$this->data['error_warning'] 		= $validateVoucher;;
			}
			echo json_encode($output);
			die;

		}

		// Reward
		if (isset($this->request->post['reward'])) { 
			$validateReward = $this->validateReward();
			$output = array("success"  => false, "msg" => "");
			if($validateReward == "")
			{
				$this->session->data['reward'] 		= $this->request->post['reward'];
				$this->session->data['success'] 	= $this->language->get('text_reward');
				//$this->data['success'] 				= $this->language->get('text_reward')
				$output['success'] 					= true;
				$output['msg']						= $this->language->get('text_reward');
			}
			else
			{
				$output['msg'] 						= $validateReward;
				//$this->data['error_warning'] 		= $validateReward;;
			}
			echo json_encode($output);
			die;
		}

	}
}
?>