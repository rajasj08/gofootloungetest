<?php 
class ControllerCheckoutCart extends Controller {
	private $error = array();
	
	public function index() {
		$this->language->load('checkout/cart');
		
		if (!isset($this->session->data['vouchers'])) {
			$this->session->data['vouchers'] = array();
		}

               //add products in the cart for abandoned user
               if(isset($this->request->get['abuserid'])) 
               {
                  
                $this->load->model('catalog/product');
                
                $abuserproducts = $this->model_catalog_product->getabuserProducts($this->request->get['abuserid']);
            
                $decodeprods=json_decode($abuserproducts);
               
                foreach($decodeprods  as $key => $value) 
                { 
                    $this->session->data['cart'][$key]= $value->quantity;
                   
                }
               
                
                }
               
  		
		// Update
		if (!empty($this->request->post['quantity'])) {
			foreach ($this->request->post['quantity'] as $key => $value) {
				$this->cart->update($key, $value);
			}
			
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']); 
			unset($this->session->data['reward']);
			
			$this->redirect($this->url->link('checkout/cart'));  			
		}

                 
       	
		// Remove
		if (isset($this->request->get['remove'])) {
			$this->cart->remove($this->request->get['remove']);
			
			unset($this->session->data['vouchers'][$this->request->get['remove']]);
			
			$this->session->data['success'] = $this->language->get('text_remove');
		
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']); 
			unset($this->session->data['reward']);  
								
			$this->redirect($this->url->link('checkout/cart'));
		}
			
		// Coupon    
		if (isset($this->request->post['coupon']) && $this->validateCoupon()) { 
			$this->session->data['coupon'] = $this->request->post['coupon'];
				
			$this->session->data['success'] = $this->language->get('text_coupon');
			
			$this->redirect($this->url->link('checkout/cart'));
		}
		
		// Voucher
		if (isset($this->request->post['voucher']) && $this->validateVoucher()) { 
			$this->session->data['voucher'] = $this->request->post['voucher'];
				
			$this->session->data['success'] = $this->language->get('text_voucher');
				
			$this->redirect($this->url->link('checkout/cart'));
		}

		// Reward
		if (isset($this->request->post['reward']) && $this->validateReward()) { 
			$this->session->data['reward'] = abs($this->request->post['reward']);
				
			$this->session->data['success'] = $this->language->get('text_reward');
				
			$this->redirect($this->url->link('checkout/cart'));
		}
		
		// Shipping
		if (isset($this->request->post['shipping_method']) && $this->validateShipping()) {
			$shipping = explode('.', $this->request->post['shipping_method']);
			
			$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
			
			$this->session->data['success'] = $this->language->get('text_shipping');
			
			$this->redirect($this->url->link('checkout/cart'));
		}
		
		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
			
      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'href'      => $this->url->link('common/home'),
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'href'      => $this->url->link('checkout/cart'),
        	'text'      => $this->language->get('heading_title'),
        	'separator' => $this->language->get('text_separator')
      	);
			
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
                $this->data['column_disc'] = $this->language->get('column_disc');
			
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



/* print_r('<pre>'); print_r($products); 
$products['1346:YToxOntpOjYzMDE7czo1OiIxNTYxNiI7fQ==']= array
        (

           'key' => '1346:YToxOntpOjYzMDE7czo1OiIxNTYxNiI7fQ==',
            'product_id' => 1346,
            'name' => 'Reebok Women Electrify Speed Grey Running Shoes',
            'model' => 'AR1011',
            'voucher' => '0',
            'shipping' => '1',
            'image' => 'data/Reebok Q2 16 Shoes/AR1011 Electrify Speed Grey Running Shoes/Reebok-Electrify-Speed-Grey-Running-Shoes-9102-8511991-1-pdp_slider_l.jpg'

            
        );
print_r('<pre>');
print_r($products); die; */$bagtot=0;


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
												$total = $this->currency->format($this->tax->calculate($product['price'], 0, $this->config->get('config_tax')) * ($product['quantity'] - 1) + $productpriceval); 
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
												$total = $this->currency->format($this->tax->calculate($product['price'], 0, $this->config->get('config_tax')) * $product['quantity']);
											} else {
												$total = false;
											}

										//}   
								//	} 

							} 

							else
							{
								if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
									$total = $this->currency->format($this->tax->calculate($product['price'], 0, $this->config->get('config_tax')) * $product['quantity']);
								} else {
									$total = false;
								} 
							}
						}

						else
							{
								if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
									$total = $this->currency->format($this->tax->calculate($product['price'],0, $this->config->get('config_tax')) * $product['quantity']);
								} else {
									$total = false;
								} 
							}

					
					}
				}
				else
							{
								if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                                                                         $total = $this->currency->format($this->tax->calculate($product['price'], 0, $this->config->get('config_tax')) * $product['quantity']);
 
									/*$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);*/
								} else {
									$total = false;
								} 
							}

				//echo "jkhjdfd"; die; 
		//***upsell product details end here
			
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                                        $price = $this->currency->format($this->tax->calculate($product['price'], 0, $this->config->get('config_tax')));   
					/*$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));*/
				} else {
					$price = false;
				}
				
				// Display prices
				/* if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
				} else {
					$total = false;
				} */

            
                             // get Origional price for  the product
                             $this->load->model('catalog/product');
                             $prod_orgprice=$this->model_catalog_product->getprodmrppricevalue($product['product_id']);
$bagtot+=round($prod_orgprice * $product['quantity'] );  
                             //assign org price value
                             if ($prod_orgprice) {
                                        $n_orgprice = $this->currency->format($this->tax->calculate(($prod_orgprice * $product['quantity']), 0, $this->config->get('config_tax')));   
					/*$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));*/
				} else {
					$n_orgprice = false;
				}

//echo $n_orgprice; die; 
                             
                             // finding discount for the product
                                 $scda= $price;
				$scda = preg_replace('/\D/', '', $scda);
				$scda1 = $prod_orgprice;
				//$scda1 = preg_replace('/\D/', '', $scda1);
				$disc_percent =   round((($scda1  - $scda)/$scda1)*100, 0); 
                              // echo $sum_total1; die; 
				 
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
                                        'orgprice' => $n_orgprice, 
                                        'discount' => $disc_percent, 
					'total'    => $total,
					'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id']),
					'remove'   => $this->url->link('checkout/cart', 'remove=' . $product['key'])
				);
      		}

      		//print_r('<pre>');
      	       // print_r($this->data['products']); die;
 $this->data['bagtotdispval']=$bagtot;
if ($bagtot) {
                                        $this->data['bagtot'] = $this->currency->format($this->tax->calculate($bagtot, 0, $this->config->get('config_tax')));   
					/*$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));*/
				} else {
					$this->data['bagtot'] = false;
				} 

$this->data['bagtotdisp']=$this->data['bagtot'];
 
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
				
			     //print_r('<pre>'); print_r($results); die; 

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
                 
              
              if(isset($total_data[1]['code']))
             {
                   $cont=count($total_data)-2;
                  if($total_data[1]['code'] == 'shipping'){
           
                        $temp = $total_data[1];
                        $total_data[1] = $total_data[$cont];
                        $total_data[$cont] = $temp;
                 }
               }
                if(isset($total_data[1]['code']) && isset($total_data[2]['code'])) {
                 if($total_data[1]['code'] == 'coupon' && $total_data[2]['code'] == 'tax'){
           
                        $temp = $total_data[1];
                        $total_data[1] = $total_data[2];
                        $total_data[2] = $temp;
                 }
                /*else if($total_data[2]['code'] == 'coupon' && $total_data[3]['code'] == 'tax')
                { 
                    $temp = $total_data[2];
                        $total_data[2] = $total_data[3];
                        $total_data[3] = $temp;
                } */  
                   
  
              }
                     // print_r('<pre>'); print_r($total_data); die;   
		        
                    /*   foreach($total_data as $datas)
                       { 
                         if($datas['code'] == 'coupon')
                         {
                             $couval= $datas['value'];
                         }  
                         
                         if($datas['code'] == 'coupon')
                         {
                             $couval= $datas['value'];
                         }
                         if($datas['code'] == 'tax')
                         {
                             $couval= $datas['value'];
                         }

                       }*/
			
//print_r('<pre>'); print_r($total_data); die;  
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
  	}
	
	protected function validateCoupon() {
		$this->load->model('checkout/coupon');
				
		$coupon_info = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);			
		
		if (!$coupon_info) {			
			$this->error['warning'] = $this->language->get('error_coupon');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}		
	}
	
	protected function validateVoucher() {
		$this->load->model('checkout/voucher');
				
		$voucher_info = $this->model_checkout_voucher->getVoucher($this->request->post['voucher']);			
		
		if (!$voucher_info) {			
			$this->error['warning'] = $this->language->get('error_voucher');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}		
	}
	
	protected function validateReward() {
		$points = $this->customer->getRewardPoints();
		
		$points_total = 0;
		
		foreach ($this->cart->getProducts() as $product) {
			if ($product['points']) {
				$points_total += $product['points'];
			}
		}	
				
		if (empty($this->request->post['reward'])) {
			$this->error['warning'] = $this->language->get('error_reward');
		}
	
		if ($this->request->post['reward'] > $points) {
			$this->error['warning'] = sprintf($this->language->get('error_points'), $this->request->post['reward']);
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
	
	protected function validateShipping() {
		if (!empty($this->request->post['shipping_method'])) {
			$shipping = explode('.', $this->request->post['shipping_method']);
					
			if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {			
				$this->error['warning'] = $this->language->get('error_shipping');
			}
		} else {
			$this->error['warning'] = $this->language->get('error_shipping');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}		
	}
								
	public function add() {
		$this->language->load('checkout/cart');
		
		$json = array();
		
		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}
		
		$this->load->model('catalog/product');
						
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {			
			if (isset($this->request->post['quantity'])) {
				$quantity = $this->request->post['quantity'];
			} else {
				$quantity = 1;
			}
			
												
			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();	
			}
			
			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);
			
			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}
				
			if (!$json) {
				$this->cart->add($this->request->post['product_id'], $quantity, $option);


				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));
				
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
				
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
				
				$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
			}
		}
		
		$this->response->setOutput(json_encode($json));		
	}
	
	public function quote() {
		$this->language->load('checkout/cart');
		
		$json = array();	
		
		if (!$this->cart->hasProducts()) {
			$json['error']['warning'] = $this->language->get('error_product');				
		}				

		if (!$this->cart->hasShipping()) {
			$json['error']['warning'] = sprintf($this->language->get('error_no_shipping'), $this->url->link('information/contact'));				
		}				
		
		if ($this->request->post['country_id'] == '') {
			$json['error']['country'] = $this->language->get('error_country');
		}
		
		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
			$json['error']['zone'] = $this->language->get('error_zone');
		}
			
		$this->load->model('localisation/country');
		
		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
		
		if ($country_info && $country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
			$json['error']['postcode'] = $this->language->get('error_postcode');
		}
						
		if (!$json) {		
			$this->tax->setShippingAddress($this->request->post['country_id'], $this->request->post['zone_id']);
		
			// Default Shipping Address
			$this->session->data['shipping_country_id'] = $this->request->post['country_id'];
			$this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
			$this->session->data['shipping_postcode'] = $this->request->post['postcode'];
		
			if ($country_info) {
				$country = $country_info['name'];
				$iso_code_2 = $country_info['iso_code_2'];
				$iso_code_3 = $country_info['iso_code_3'];
				$address_format = $country_info['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';	
				$address_format = '';
			}
			
			$this->load->model('localisation/zone');
		
			$zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);
			
			if ($zone_info) {
				$zone = $zone_info['name'];
				$zone_code = $zone_info['code'];
			} else {
				$zone = '';
				$zone_code = ''; 
			}	
		 
			$address_data = array(
				'firstname'      => '',
				'lastname'       => '',
				'company'        => '',
				'address_1'      => '',
				'address_2'      => '',
				'postcode'       => $this->request->post['postcode'],
				'city'           => '',
				'zone_id'        => $this->request->post['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => $this->request->post['country_id'],
				'country'        => $country,	
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format
			);
		
			$quote_data = array();
			
			$this->load->model('setting/extension');
			
			$results = $this->model_setting_extension->getExtensions('shipping');
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('shipping/' . $result['code']);
					
					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($address_data); 
		
					if ($quote) {
						$quote_data[$result['code']] = array( 
							'title'      => $quote['title'],
							'quote'      => $quote['quote'], 
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}
	
			$sort_order = array();
		  
			foreach ($quote_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
	
			array_multisort($sort_order, SORT_ASC, $quote_data);
			
			$this->session->data['shipping_methods'] = $quote_data;
			
			if ($this->session->data['shipping_methods']) {
				$json['shipping_method'] = $this->session->data['shipping_methods']; 
			} else {
				$json['error']['warning'] = sprintf($this->language->get('error_no_shipping'), $this->url->link('information/contact'));
			}				
		}	
		
		$this->response->setOutput(json_encode($json));						
	}
	
	public function country() {
		$json = array();
		
		$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	}
	public function replacecarttotal()//replace cart total value
	{
                        $this->load->model('tool/image');
                        $this->data['products'] = array();
			
			$products = $this->cart->getProducts();



/* print_r('<pre>'); print_r($products); 
$products['1346:YToxOntpOjYzMDE7czo1OiIxNTYxNiI7fQ==']= array
        (

           'key' => '1346:YToxOntpOjYzMDE7czo1OiIxNTYxNiI7fQ==',
            'product_id' => 1346,
            'name' => 'Reebok Women Electrify Speed Grey Running Shoes',
            'model' => 'AR1011',
            'voucher' => '0',
            'shipping' => '1',
            'image' => 'data/Reebok Q2 16 Shoes/AR1011 Electrify Speed Grey Running Shoes/Reebok-Electrify-Speed-Grey-Running-Shoes-9102-8511991-1-pdp_slider_l.jpg'

            
        );
print_r('<pre>');
print_r($products); die; */ $bagtot=0;
$prodcutquan=0;
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
                                                                         $total = $this->currency->format($this->tax->calculate($product['price'], 0, $this->config->get('config_tax')) * $product['quantity']);
 
									/*$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);*/
								} else {
									$total = false;
								} 
							}

				//echo "jkhjdfd"; die; 
		//***upsell product details end here
			
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                                        $price = $this->currency->format($this->tax->calculate($product['price'], 0, $this->config->get('config_tax')));   
					/*$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));*/
				} else {
					$price = false;
				}
				
				// Display prices
				/* if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
				} else {
					$total = false;
				} */

            
                             // get Origional price for  the product
                             $this->load->model('catalog/product');

                             $prod_orgprice=$this->model_catalog_product->getprodmrppricevalue($product['product_id']);
$bagtot+=round($prod_orgprice * $product['quantity']); 
                             //assign org price value
                             if ($prod_orgprice) {
                                        $n_orgprice = $this->currency->format($this->tax->calculate($prod_orgprice, 0, $this->config->get('config_tax')));   
					/*$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));*/
				} else {
					$n_orgprice = false;
				}

                             
                             // finding discount for the product
                                 $scda= $price;
				$scda = preg_replace('/\D/', '', $scda);
				$scda1 = $prod_orgprice;
				//$scda1 = preg_replace('/\D/', '', $scda1);
				$disc_percent =   round((($scda1  - $scda)/$scda1)*100, 0); 
                              // echo $sum_total1; die; 
				 
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
                                        'orgprice' => $n_orgprice, 
                                        'discount' => $disc_percent, 
					'total'    => $total,
					'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id']),
					'remove'   => $this->url->link('checkout/cart', 'remove=' . $product['key'])
				);
$prodcutquan+=$product['quantity'];
      		}   
 

if ($bagtot) {
                                        $this->data['bagtot'] = $this->currency->format($this->tax->calculate($bagtot, 0, $this->config->get('config_tax')));   
					/*$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));*/
				} else {
					$this->data['bagtot'] = false;
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
				
			  
 				//print_r('<pre>'); print_r($results); die; 	
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
                          if(isset($total_data[1]['code']) && isset($total_data[2]['code'])) {
                 if($total_data[1]['code'] == 'coupon' && $total_data[2]['code'] == 'tax'){
           
                        $temp = $total_data[1];
                        $total_data[1] = $total_data[2];
                        $total_data[2] = $temp;
                 } }
		 
		
			$this->data['totals'] = $total_data;
$this->data['prodcutquandata']=$prodcutquan;

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/couponrespcart.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/checkout/couponrespcart.tpl';
			} else {
				$this->template = 'default/template/checkout/cart.tpl';
			}
			 
			echo $this->response->setOutput($this->render());	
	}
	public function replacecarttotal1()//replace cart total value
	{

		if(isset($this->session->data['coupon'])) { unset($this->session->data['coupon']);}
  $this->load->model('tool/image');
                        $this->data['products'] = array();
			
			$products = $this->cart->getProducts();



/* print_r('<pre>'); print_r($products); 
$products['1346:YToxOntpOjYzMDE7czo1OiIxNTYxNiI7fQ==']= array
        (

           'key' => '1346:YToxOntpOjYzMDE7czo1OiIxNTYxNiI7fQ==',
            'product_id' => 1346,
            'name' => 'Reebok Women Electrify Speed Grey Running Shoes',
            'model' => 'AR1011',
            'voucher' => '0',
            'shipping' => '1',
            'image' => 'data/Reebok Q2 16 Shoes/AR1011 Electrify Speed Grey Running Shoes/Reebok-Electrify-Speed-Grey-Running-Shoes-9102-8511991-1-pdp_slider_l.jpg'

            
        );
print_r('<pre>');
print_r($products); die; */$bagtot=0;$prodcutquan=0;

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
                                                                         $total = $this->currency->format($this->tax->calculate($product['price'], 0, $this->config->get('config_tax')) * $product['quantity']);
 
									/*$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);*/
								} else {
									$total = false;
								} 
							}

				//echo "jkhjdfd"; die; 
		//***upsell product details end here
			
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                                        $price = $this->currency->format($this->tax->calculate($product['price'], 0, $this->config->get('config_tax')));   
					/*$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));*/
				} else {
					$price = false;
				}
				
				// Display prices
				/* if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
				} else {
					$total = false;
				} */

            
                             // get Origional price for  the product
                             $this->load->model('catalog/product');

                             $prod_orgprice=$this->model_catalog_product->getprodmrppricevalue($product['product_id']);
$bagtot+=round($prod_orgprice * $product['quantity']);
                             //assign org price value
                             if ($prod_orgprice) {
                                        $n_orgprice = $this->currency->format($this->tax->calculate(($prod_orgprice * $product['quantity']), 0, $this->config->get('config_tax')));   
					/*$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));*/
				} else {
					$n_orgprice = false;
				}

                             
                             // finding discount for the product
                                 $scda= $price;
				$scda = preg_replace('/\D/', '', $scda);
				$scda1 = $prod_orgprice;
				//$scda1 = preg_replace('/\D/', '', $scda1);
				$disc_percent =   round((($scda1  - $scda)/$scda1)*100, 0); 
                              // echo $sum_total1; die; 
				 
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
                                        'orgprice' => $n_orgprice, 
                                        'discount' => $disc_percent, 
					'total'    => $total,
					'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id']),
					'remove'   => $this->url->link('checkout/cart', 'remove=' . $product['key'])
				);
$prodcutquan+=$product['quantity'];
      		}


if ($bagtot) {
                                        $this->data['bagtot'] = $this->currency->format($this->tax->calculate($bagtot, 0, $this->config->get('config_tax')));   
					/*$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));*/
				} else {
					$this->data['bagtot'] = false;
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
		 
			$this->data['prodcutquandata']=$prodcutquan;
			$this->data['totals'] = $total_data;

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/couponrespcart.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/checkout/couponrespcart.tpl';
			} else {
				$this->template = 'default/template/checkout/cart.tpl';
			}
			
			echo $this->response->setOutput($this->render());	
	}
	public function changeproductoptioninfos()
	{$optionnew=array();
		foreach ($this->session->data['cart'] as $key => $quantity) {
				$product = explode(':', $key);

				$product_id = $product[0];
				$stock = true;

				// Options
				if (isset($product[1])) {
					$options = unserialize(base64_decode($product[1]));
				} else {
					$options = array();
				} 
				foreach ($options as $product_option_id => $option_value) {
					
					if($product_id == $this->request->post['mainproductid'] && $option_value == $this->request->post['oldprodsize'])
						{

							$arrayinfo=explode("[",$this->request->post['optionarray']);
							$optionvali=rtrim($arrayinfo[1],']');
							$option = array($optionvali => $this->request->post['optionvalueinfo']); 

							$key1 =(int)$product_id . ':' . base64_encode(serialize($option));
								//array_combine(array_merge($this->session->data['cart'], $keyReplaceInfoz), $old);
							//reset key option info
							$this->session->data['cart'][$key1]=$this->session->data['cart'][$key];
							unset($this->session->data['cart'][$key]);

							
						}	
			
				}
		}

		$redirect = '';
			
		if ($this->cart->hasShipping()) {
			
			// Validate if shipping address has been set.		
			$this->load->model('account/address');
	
			if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {					
				$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);		
			} elseif (isset($this->session->data['guest'])) {
				$shipping_address = $this->session->data['guest']['shipping'];
			}
			
			if (empty($shipping_address)) {								
				$redirect = $this->url->link('checkout/checkout', '', 'SSL');
			}
			
			// Validate if shipping method has been set.	
			if (!isset($this->session->data['shipping_method'])) {
				$redirect = $this->url->link('checkout/checkout', '', 'SSL');
			}
		} else {
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}
		

	} 
	
	public function setsmssession()
	{
		 if(isset($this->session->data['smsalert_s'])){ unset($this->session->data['smsalert_s']);}
		if($this->request->post['smsalert']==1)
		{
			$this->session->data['smsalert_s']=1;
		}
	}

        public function checkoutreplacecarttotal()
        {
             // Totals
			$this->load->model('setting/extension');

                    $products = $this->cart->getProducts();
                   
                    $prodcutquan=0;
      		foreach ($products as $product) {
                    $prodcutquan+=$product['quantity']; 
                } 
                $data['prodcutquan']=$prodcutquan; 
			
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
				
			  
 				//print_r('<pre>'); print_r($results); die; 	
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
                          if(isset($total_data[1]['code']) && isset($total_data[2]['code'])) {
                 if($total_data[1]['code'] == 'coupon' && $total_data[2]['code'] == 'tax'){
           
                        $temp = $total_data[1];
                        $total_data[1] = $total_data[2];
                        $total_data[2] = $temp;
                 } }//$totalarr=array();
$couval=0;
                 
		 foreach($total_data as $data){
                         if($data['code']=='coupon'){ $couval=$data['value'];}
                      if($data['code']=='total'){  $totval=$data['value']+$couval; echo $prodcutquan." Item(s)-<span class='WebRupee'>Rs</span>".round($totval); }
                 }
	   }  

}
?>