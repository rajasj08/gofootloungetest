<?php  
class ControllerCheckoutLogin extends Controller { 
	public function index() {
		$this->language->load('checkout/checkout');
		
		$this->data['text_new_customer'] = $this->language->get('text_new_customer');
		$this->data['text_returning_customer'] = $this->language->get('text_returning_customer');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		$this->data['text_register'] = $this->language->get('text_register');
		$this->data['text_guest'] = $this->language->get('text_guest');
		$this->data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
		$this->data['text_register_account'] = $this->language->get('text_register_account');
		$this->data['text_forgotten'] = $this->language->get('text_forgotten');
 
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_password'] = $this->language->get('entry_password');
		
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_login'] = $this->language->get('button_login');
		
		$this->data['guest_checkout'] = ($this->config->get('config_guest_checkout') && !$this->config->get('config_customer_price') && !$this->cart->hasDownload());
		
		if (isset($this->session->data['account'])) {
			$this->data['account'] = $this->session->data['account'];
		} else {
			$this->data['account'] = 'register';
		}
		
		$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/login.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/login.tpl';
		} else {
			$this->template = 'default/template/checkout/login.tpl';
		}
				
		$this->response->setOutput($this->render());
	}
	
	public function validate() {
		$this->language->load('checkout/checkout');
		
		$json = array();
		
		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');			
		}
		
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}	
		
		if (!$json) {
			if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
				$json['error']['warning'] = $this->language->get('error_login');
			}
		
			$this->load->model('account/customer');
		
			$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
			
			if ($customer_info && !$customer_info['approved']) {
				$json['error']['warning'] = $this->language->get('error_approved');
			}		
		}
		
		if (!$json) {
			unset($this->session->data['guest']);
				
			// Default Addresses
			$this->load->model('account/address');
				
			$address_info = $this->model_account_address->getAddress($this->customer->getAddressId());
									
			if ($address_info) {
				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_country_id'] = $address_info['country_id'];
					$this->session->data['shipping_zone_id'] = $address_info['zone_id'];
					$this->session->data['shipping_postcode'] = $address_info['postcode'];	
				}
				
				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_country_id'] = $address_info['country_id'];
					$this->session->data['payment_zone_id'] = $address_info['zone_id'];
				}
			} else {
				unset($this->session->data['shipping_country_id']);	
				unset($this->session->data['shipping_zone_id']);	
				unset($this->session->data['shipping_postcode']);
				unset($this->session->data['payment_country_id']);	
				unset($this->session->data['payment_zone_id']);	
			}	

                        if($this->customer->isLogged()){
                        if(!isset($this->session->data['abduserid'])){

                        $resultsdata = $this->model_account_address->saveabdandoneduser1($this->request->post['email'],$this->customer->isLogged());

                        $this->session->data['abduserid']=$resultsdata; 
                        } }	 				
				
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
					
		$this->response->setOutput(json_encode($json));		
	}
	public function sendnewusernotify() //send new user notification message
	{


		$emailid=$this->request->post['emailid'];  

		if(!isset($this->session->data['newuserid'])){

			$this->load->model('tool/image');
			
      		$this->data['products'] = array();
      		$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
			 
			$this->load->model('setting/extension');
			
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
			}
			
			$sort_order = array(); 
		  
			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
	
			array_multisort($sort_order, SORT_ASC, $total_data);

			$data['totals'] = $total_data;
			
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
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
						'option_val_id' => $option['product_option_value_id']
					);
        		}


        		//***upsell product details start here		

				
					$cartIDS = array();
					//print_r('<pre>'); print_r($products); die;  
					foreach($products as $item) {
						//$cartIDS[] = $item['product_id'];
					
						$newcartproducts[$item['product_id']]=$item['quantity'];
					}


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
									/*	if($product['quantity'] > 1) {

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
										{ */
											
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

										//}   
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
				/* if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
				} else {
					$total = false;
				} */


				
        		$this->data['products'][] = array(
        			'product_id' =>$product['product_id'],  
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

      		//print_r('<pre>');
      		//print_r($this->data['products']); die; 

			// Gift Voucher
		/*	$this->data['vouchers'] = array();
			
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$this->data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)   
					);
				}
			}*/


	/* Send mail to the admin for the new user purchased products */
$message='';
		 if ($this->data['products'] || $this->data['vouchers']) { 
		$message='<div class="mini-cart-info">
			<table style="border:1px solid #e0e0e0;border-collapse:collapse;margin:0;table-layout:auto;width:100%;border-radius:3px;color:#666666" width="100%" cellpadding="5" cellspacing="0"><thead><tr>
				<th style="font-size:14px;font-weight:bold;padding:10px 8px;white-space:nowrap;text-align:center!important" width="30%" bgcolor="#ededed">Product Image</th>
				<th style="font-size:14px;font-weight:bold;padding:10px 8px;white-space:nowrap;text-align:center!important" width="30%" bgcolor="#ededed">Name</th>
				<th style="font-size:14px;font-weight:bold;padding:10px 8px;white-space:nowrap;text-align:center!important" width="10%" bgcolor="#ededed">Quantity</th>
                <th style="font-size:14px;font-weight:bold;padding:10px 8px;white-space:nowrap;text-align:right!important" width="15%" bgcolor="#ededed" align="right">Price</th>
        <th style="font-size:14px;font-weight:bold;padding:10px 8px;white-space:nowrap;text-align:right!important" width="15%" bgcolor="#ededed" align="right">Total</th>
	</tr></thead><tbody>';
				 foreach ($this->data['products'] as $product) { 
				 	
				 	$product['thumb']=str_replace(" ","%20",$product['thumb']);
				 	
            
			$message.=	'<tr>
					<td style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;padding:5px 8px;text-align:left;vertical-align:middle;border-bottom:1px solid #e0e0e0;border-left:1px solid #e0e0e0;word-break:break-all" width="1" bgcolor="#fafafa">';
						 if ($product['thumb']) { 
			$message.='<a href="'.$product['href'].'"><img src="'.$product['thumb'].'" alt="'.$product['name'].'" title="'.$product['name'].'" /></a>';
						}  
			$message.='</td>'; 
			$message.='<td style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;padding:5px 8px;text-align:left;vertical-align:middle;border-bottom:1px solid #e0e0e0;border-left:1px solid #e0e0e0;word-break:break-all" width="1" bgcolor="#fafafa">
						<a href='.$product['href'].'>'.$product['name'].'</a>
						<div>';
					  foreach ($product['option'] as $option) { 
			$message.='- <small>'.$option['name'] .' - '.$option['value'].'</small><br />';
							 } 
			$message.='</div>
					</td>
					<td style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;padding:5px 8px;text-align:left;vertical-align:middle;border-bottom:1px solid #e0e0e0;border-left:1px solid #e0e0e0;word-break:break-all" width="1" bgcolor="#fafafa">x&nbsp;'.$product['quantity'].'</td>
					<td style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;padding:5px 8px;text-align:left;vertical-align:middle;border-bottom:1px solid #e0e0e0;border-left:1px solid #e0e0e0;word-break:break-all" width="1" bgcolor="#fafafa">'.$product['total'].'</td>
					<td style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;padding:5px 8px;text-align:left;vertical-align:middle;border-bottom:1px solid #e0e0e0;border-left:1px solid #e0e0e0;word-break:break-all" width="1" bgcolor="#fafafa">'.$product['total'].'</td>
					
				</tr>'; }

				$message.='</tbody><tfoot>';
					foreach ($data['totals'] as $total) { 
				$message.='<tr><td colspan="4" style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;padding:5px 8px;text-align:right!important;vertical-align:middle;border-bottom:1px solid #e0e0e0;border-left:1px solid #e0e0e0;word-break:break-all;padding-bottom:3px;padding-top:3px" bgcolor="#ededed" align="right"><b>'.$total['title'].':</b></td>
				<td colspan="4" style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;padding:5px 8px;text-align:right!important;vertical-align:middle;border-bottom:1px solid #e0e0e0;border-left:1px solid #e0e0e0;word-break:break-all;padding-bottom:3px;padding-top:3px" bgcolor="#ededed" align="right">'.$total['text'].'</td></tr>';
					}
					$message.='</table>
								</div>'; 
				
			
		
	}
}//not isset of usermailid
	
	if($this->request->post['emailid'])
	{
	
		if(!isset($this->session->data['newuserid'])){
	//sending mail using php
	
	

		$emailid=$this->request->post['emailid'];
        $message=$message;
        $subject='New User Prior Check Out Notification';
        $message="Dear Footlounge Admin,<br/><br/>The below products are added by the new user - ".$_POST['emailid']." <br/><br/>".$message;
       		
	 	$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
		$headers .= 'From: '.$emailid."\r\n".
    		//'Reply-To: '.$emailid."\r\n" .
    		'X-Mailer: PHP/' . phpversion();
    	$returnval=0;	
	        // Sending email
	       
			if(mail('service@footlounge.in', $subject, $message, $headers)){
			
			   $returnval=1;	
			} else{ 
			   $returnval=0;	
			}  
 
		}
	}	


        /*************oct 14th for abdandoned use ***************/

       //$this->customer->isLogged()

      //$this->request->post['emailid'];
 
     $this->load->model('checkout/order');

     if(!isset($this->session->data['abduserid'])){

     $resultsdata = $this->model_checkout_order->saveabdandoneduser($this->request->post['emailid']);
 
    $this->session->data['abduserid']=$resultsdata; 
    } 
		 
 

		if(isset($this->session->data['newuserid'])){ unset($this->session->data['newuserid']);}
		$this->session->data['newuserid']=$this->request->post['emailid']; 

		echo 1;  

	}

        public function saveabuserproduct()
        { 
          $this->load->model('checkout/order');

          $resultsdata = $this->model_checkout_order->saveabdandoneduserproducts();
          echo $resultsdata;
        }
}
?>