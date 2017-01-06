<?php 
class ControllerModuleCart extends Controller {
	public function index() {
		$this->language->load('module/cart');
		
      	if (isset($this->request->get['remove'])) {
          	$this->cart->remove($this->request->get['remove']);
			
			unset($this->session->data['vouchers'][$this->request->get['remove']]);
      	}	

      	if(isset($this->request->get['order_id']))
      	{
      		$order_id=$this->request->get['order_id'];
      	}
      	else
      		$order_id='';

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
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_your_cart'] = $this->language->get('text_your_cart');
		
		$this->data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		
		$this->data['button_remove'] = $this->language->get('button_remove');
		
		$this->load->model('tool/image');
		
		$this->data['products'] = array();

		$newcartproducts=array();
			$newcartproductsqty=array(); 

			foreach ($this->session->data['cart'] as $key => $quantity) {
				$product = explode(':', $key);
				
				$newcartproducts[$product[0]]=$quantity;
				//array_push($newcartproducts[$product[0]],5);
				
				//array_push($newcartproductsqty,$product[0]);
				
			}
			
		foreach ($this->cart->getProducts() as $product) {
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
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}

				//***upsell product details start here		
				
					$cartIDS = array();
					foreach($newcartproducts as $key3 => $value3) {
						$cartIDS[] = $key3;
					}

					$count=0;$in_product='';

					if (is_array($this->session->data['upsell_array'])) {
						# code...
					
			
						// get upsell product array
						foreach ($this->session->data['upsell_array'] as $key1 => $value1) {
					
						if(in_array($key1, $cartIDS))
						{

							 
							
							//$in_product=$key1; 
							//$count=0;		
									
							if($value1['upsell_productid']==$product['product_id'])
							{ 
								
								/*if(isset($this->session->data['upsell_array'][$key1]['upsell_status']))
								{
									unset($this->session->data['upsell_array'][$key1]['upsell_status']);    
								}*/
								/*if(in_array($product['product_id'], $cartIDS)){
									$productz=$product['product_id'];
									if(isset($this->session->data['upsell_array'][$key1]['upsell_status']))

									{$this->session->data['upsell_array'][$key1]['upsell_status']=2;
									
									} else{$this->session->data['upsell_array'][$key1]['upsell_status']=1;} 

									
								} */
								
									
								/*if($this->session->data['upsell_array'][$key]['upsell_status']){

									}

									else
									{	 
								*/	
										if($product['quantity'] > 1) {

											 
											$productpriceval=$value1['upsell_productprice'];
											
											if($value1['upsell_productspecial'])
											{
												
												$productpriceval=$value1['upsell_productspecial']; 
											}

											if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
												$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * ($product['quantity'] - 1) + $productpriceval); 
											} else {
												$total = false;
											}


											
										}
										else
										{
											
											$product['price']=$value1['upsell_productprice'];
											
											if($value1['upsell_productspecial'])
											{
												
												$product['price']=$value1['upsell_productspecial']; 
											}


											if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
												$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
											} else {
												$total = false;
											}

										}   
								//	} 

							}

							else
							{
								if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
									$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
								} else {
									$total = false;
								} 
							}
						}

						else
							{
								if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
									$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
								} else {
									$total = false;
								} 
							}

					
					}
				}
				else
							{
								if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
									$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
								} else {
									$total = false;
								} 
							}

				//echo "jkhjdfd"; die; 
		//***upsell product details end here
			
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
			
			// Display prices
			/*if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
			} else {
				$total = false;
			}*/
													
			$this->data['products'][] = array(
				'key'      => $product['key'],
				'thumb'    => $image,
				'name'     => $product['name'],
				'model'    => $product['model'], 
				'option'   => $option_data,
				'quantity' => $product['quantity'],
				'price'    => $price,	
				'total'    => $total,	
				'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id'])		
			);
		}
		
		//print_r('<pre>');
		//print_r($this->data['products']); die; 
		// Gift Voucher
		$this->data['vouchers'] = array();
		
		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$this->data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'])
				);
			}
		}
		
			$this->data['cart'] = $this->url->link('checkout/cart');   
		
			$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL'); 
		
		
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cart.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/cart.tpl';
		} else {
			$this->template = 'default/template/module/cart.tpl';
		}
				
		$this->response->setOutput($this->render());		
	}
	
	
	public function respcartcontent()
	{
		$this->language->load('module/cart');
		
      	if (isset($this->request->get['remove'])) {
          	$this->cart->remove($this->request->get['remove']);
			
			unset($this->session->data['vouchers'][$this->request->get['remove']]);
      	}	

      	if(isset($this->request->get['order_id']))
      	{
      		$order_id=$this->request->get['order_id'];
      	}
      	else
      		$order_id='';

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
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_your_cart'] = $this->language->get('text_your_cart');
		
		$this->data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		
		$this->data['button_remove'] = $this->language->get('button_remove');
		
		$this->load->model('tool/image');
		
		$this->data['products'] = array();

		$newcartproducts=array();
			$newcartproductsqty=array(); 

			foreach ($this->session->data['cart'] as $key => $quantity) {
				$product = explode(':', $key);
				
				$newcartproducts[$product[0]]=$quantity;
				//array_push($newcartproducts[$product[0]],5);
				
				//array_push($newcartproductsqty,$product[0]);
				
			}
			
		foreach ($this->cart->getProducts() as $product) {
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
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}

				//***upsell product details start here		
				
					$cartIDS = array();
					foreach($newcartproducts as $key3 => $value3) {
						$cartIDS[] = $key3;
					}

					$count=0;$in_product='';

					if (is_array($this->session->data['upsell_array'])) {
						# code...
					
			
						// get upsell product array
						foreach ($this->session->data['upsell_array'] as $key1 => $value1) {
					
						if(in_array($key1, $cartIDS))
						{

							 
							
							//$in_product=$key1; 
							//$count=0;		
									
							if($value1['upsell_productid']==$product['product_id'])
							{ 
								
								/*if(isset($this->session->data['upsell_array'][$key1]['upsell_status']))
								{
									unset($this->session->data['upsell_array'][$key1]['upsell_status']);    
								}*/
								/*if(in_array($product['product_id'], $cartIDS)){
									$productz=$product['product_id'];
									if(isset($this->session->data['upsell_array'][$key1]['upsell_status']))

									{$this->session->data['upsell_array'][$key1]['upsell_status']=2;
									
									} else{$this->session->data['upsell_array'][$key1]['upsell_status']=1;} 

									
								} */
								
									
								/*if($this->session->data['upsell_array'][$key]['upsell_status']){

									}

									else
									{	 
								*/	
										if($product['quantity'] > 1) {

											 
											$productpriceval=$value1['upsell_productprice'];
											
											if($value1['upsell_productspecial'])
											{
												
												$productpriceval=$value1['upsell_productspecial']; 
											}

											if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
												$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * ($product['quantity'] - 1) + $productpriceval); 
											} else {
												$total = false;
											}


											
										}
										else
										{
											
											$product['price']=$value1['upsell_productprice'];
											
											if($value1['upsell_productspecial'])
											{
												
												$product['price']=$value1['upsell_productspecial']; 
											}


											if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
												$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
											} else {
												$total = false;
											}

										}   
								//	} 

							}

							else
							{
								if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
									$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
								} else {
									$total = false;
								} 
							}
						}

						else
							{
								if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
									$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
								} else {
									$total = false;
								} 
							}

					
					}
				}
				else
							{
								if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
									$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
								} else {
									$total = false;
								} 
							}

				//echo "jkhjdfd"; die; 
		//***upsell product details end here
			
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
			
			// Display prices
			/*if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
			} else {
				$total = false;
			}*/
													
			$this->data['products'][] = array(
				'key'      => $product['key'],
				'thumb'    => $image,
				'name'     => $product['name'],
				'model'    => $product['model'], 
				'option'   => $option_data,
				'quantity' => $product['quantity'],
				'price'    => $price,	
				'total'    => $total,	
				'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id'])		
			);
		}
		
		//print_r('<pre>');
		//print_r($this->data['products']); die; 
		// Gift Voucher
		$this->data['vouchers'] = array();
		
		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$this->data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'])
				);
			}
		}
		
			$this->data['cart'] = $this->url->link('checkout/cart');   
		
			$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL'); 
		
		
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/respmodulecart.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/respmodulecart.tpl';
		} else {
			$this->template = 'default/template/module/respmodulecart.tpl';
		} 
				
		$this->response->setOutput($this->render());	
	}
}
?>