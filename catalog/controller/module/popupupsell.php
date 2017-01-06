<?php
class ControllerModulePopupUpsell extends Controller  {
	// Module Unifier
	private $moduleName = 'popupupsell';
	private $moduleNameSmall = 'popupupsell';
	private $moduleData_module = 'popupupsell_module';
	private $moduleModel = 'model_module_popupupsell';
	// Module Unifier

	protected function index($setting) {
		 

		$this->load->model('catalog/product');
		$this->load->model('module/popupupsell');
		$this->load->language('module/'.$this->moduleNameSmall);
		$this->data['popupupsell'] = $this->config->get('popupupsell');

		$this->data['upsells'] = $this->model_module_popupupsell->getUpsells();
		$this->data['add_to_cart'] = $this->language->get('add_to_cart');
		$this->data['text_tax'] = $this->language->get('text_tax');

		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');
		$this->data['showUpsellOffer'] = htmlspecialchars_decode($this->url->link('module/popupupsell/showUpsellOffer', '', 'SSL'));

		if(isset($this->request->get['product_id']))
			$this->data['product_id'] = $this->request->get['product_id'];
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/'.$this->moduleNameSmall.'/popupupsell.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/'.$this->moduleNameSmall.'/popupupsell.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/popupupsell.css');
		}



		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/'.$this->moduleNameSmall.'.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/'.$this->moduleNameSmall.'.tpl';
		} else {
			$this->template = 'default/template/module/'.$this->moduleNameSmall.'.tpl';
		}

		$this->render();

	}

	public function showUpsellOffer() {
		header('Access-Control-Allow-Origin: *');
		$this->load->model('catalog/product');
		$this->load->model('module/popupupsell');
		$this->load->language('module/'.$this->moduleNameSmall);
		$this->load->language('product/product');
		$this->data['popupupsell'] = $this->config->get('popupupsell');
		$this->data['upsells'] = $this->model_module_popupupsell->getUpsells();

		$this->data['add_to_cart'] = $this->language->get('add_to_cart');
		$this->data['text_tax'] = $this->language->get('text_tax');

		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');

		$text_price = $this->language->get('text_price');
		$text_points = $this->language->get('text_points');
		$text_qty = $this->language->get('text_qty');
		$button_cart = $this->language->get('button_cart');
		$button_wishlist = $this->language->get('button_wishlist');
		$button_compare = $this->language->get('button_compare');
		$text_or = $this->language->get('text_or');
		$text_tax = $this->language->get('text_tax');
		// START PATTERN
		//This is for product
		$re1='(\\[)';	# Any Single Character 1
		$re2='(product_upsell)';	# Variable Name 1
		$re3='(=)';	# Any Single Character 2
		$re4='(\\d+)';	# Integer Number 1
		$re5='(\\])';	# Any Single Character 3

		$productRegex=$re1.$re2.$re3.$re4.$re5;

		//this is for discount_in
		$rs1='(\\[)';	# Any Single Character 1
		$rs2='(discount_in)';	# Variable Name 1
		$rs3='(=)';	# Any Single Character 2
		$rs4='(\\d+)';	# Integer Number 1
		$rs5='(\\])';	# Any Single Character 3

		$discountiRegex=$rs1.$rs2.$rs3.$rs4.$rs5;

		//this is for discount value
		$rb1='(\\[)';	# Any Single Character 1
		$rb2='(value)';	# Variable Name 1 
		$rb3='(=)';	# Any Single Character 2
		$rb4='(\\d+)';	# Integer Number 1
		$rb5='(\\])';	# Any Single Character 3

		$discountvRegex=$rb1.$rb2.$rb3.$rb4.$rb5;

		
		$categoryRegex=$re1.'(category_upsell)'.$re3.$re4.$re5;
		$productsInCart = $this->cart->getProducts();



		$cartIDS = array();
		$ccount=0;
		foreach($productsInCart as $item) {
			$cartIDS[] = $item['product_id'];
			if(isset($this->session->data['upsell_array']))
			{
			
				foreach($this->session->data['upsell_array'] as $item1) {
				
					if($item1['upsell_productid']==$item['product_id'])
					{
						if($item1['upsell_productprice']==$item['total'] || $item1['upsell_productspecial']==$item['total'])
						{ 
							$ccount=$ccount+1;
						} 
					}
				}
			}
		}
		//print_r($this->session->data['upsell_array']);
	

		if($ccount==0)
		{ 
			//$this->data['upsell']['content']="<p>test report</p>"; 

		// END PATTERN
		foreach($this->data['upsells'] as $upsell) {
			if($upsell['status'] == '1') {


				//preg_match_all ("/".$productRegex."/is", $upsell['content'], $matches);
				//print_r($matches); die; 

				/* if(isset($this->session->data['upsellid'])){ unset($this->session->data['upsellid']); }
		if($upsell['upsell_id']){
		$this->session->data['upsellid']=$upsell['upsell_id']; } */ 
 
				if($upsell['method'] == '0') { // single product method


					$upsell_product_ids = explode(",", $upsell['product_ids']);
					if(isset($this->request->post['product_id'])) {
						$clicked_product_id = $this->request->post['product_id'];

						if (in_array($clicked_product_id, $upsell_product_ids)) {
						    $this->data['upsell'] = $upsell;
						   	$this->data['upsell']['content'] = unserialize($this->data['upsell']['content']);
							$this->data['upsell']['content'] = $this->data['upsell']['content'][$this->config->get('config_language_id')];
								
						    if ($c=preg_match_all ("/".$productRegex."/is", $this->data['upsell']['content'], $matches)) {
							      $c1=$matches[1][0];
							      $var1=$matches[2][0];
							      $c2=$matches[3][0];
							      $int1=$matches[4][0];
							      $c3=$matches[5][0];

							      //Discount_in regex
							      if ($c=preg_match_all ("/".$discountiRegex."/is", $this->data['upsell']['content'], $matches1)) {

							      $c2=$matches1[1][0];
							      $var2=$matches1[2][0];
							      $c3=$matches1[3][0];
							      $int2=$matches1[4][0];
							      $c4=$matches1[5][0];

							      } 

							      //Discount_value regex
							      if ($c1=preg_match_all ("/".$discountvRegex."/is", $this->data['upsell']['content'], $matches2)) {

							      $c3=$matches2[1][0];
							      $var3=$matches2[2][0];
							      $c4=$matches2[3][0];
							      $int3=$matches2[4][0];
							      $c5=$matches2[5][0];

							      } 

							     /* $discountiarr=array(); 
							      $discountvarr=array(); 
							      array_push($discountvarr,$int1,$int2,$int3);
							      array_push($discountiarr,$var1,$var2,$var3);
 									*/
							      $i=0; $z=1; $counttotval=count($matches[4]);
							      foreach($matches[4] as $product_id) {

							      	if(in_array($product_id, $cartIDS) || ($clicked_product_id == $product_id)) {$this->response->setOutput(array()); exit;} // When the suggested product is already in the cart


								  	$product = $this->getProduct($product_id, $this->data['upsell']['image_width'], $this->data['upsell']['image_height'], $this->data['upsell']['upsell_id'],$matches1[4][$i],$matches2[4][$i],$this->request->post['product_id'],$z,$counttotval);    

									     if(isset($product)) {

									     	$product_upsell = $this->getProductTemplate($product);
									     	

									     	//$product_upsell = $this->getProductTemplate($product);
									    	
									      $this->data['upsell']['content'] = str_replace('[product_upsell='.$product_id.']', $product_upsell, $this->data['upsell']['content']);

									      $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 

									     


									    } else {
									    	$this->data['upsell']['content'] = str_replace('[product_upsell='.$product_id.']', '', $this->data['upsell']['content']);

									    	$this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']);
									    } 
$i++; $z++;
								 	}
								 	
							  	} 

							  	if ($c=preg_match_all ("/".$categoryRegex."/is", $this->data['upsell']['content'], $matches)) {
								    $c1=$matches[1][0];
								    $var1=$matches[2][0];
								    $c2=$matches[3][0];
								    $int1=$matches[4][0];
								    $c3=$matches[5][0];

								    //Discount_in regex
							      if ($c=preg_match_all ("/".$discountiRegex."/is", $this->data['upsell']['content'], $matches1)) {

							      $c2=$matches1[1][0];
							      $var2=$matches1[2][0];
							      $c3=$matches1[3][0];
							      $int2=$matches1[4][0];
							      $c4=$matches1[5][0];

							      }

							       //Discount_value regex
							      if ($c=preg_match_all ("/".$discountvRegex."/is", $this->data['upsell']['content'], $matches2)) {

							      $c3=$matches2[1][0];
							      $var3=$matches2[2][0];
							      $c4=$matches2[3][0];
							      $int3=$matches2[4][0];
							      $c5=$matches2[5][0];

							      }
 
							    

							      	$i=0;$z=1; $counttotval=count($matches[4]);
							      	foreach($matches[4] as $category_id) {
							      		$filter_category_id = array('filter_category_id' => $category_id);
										$results = $this->model_catalog_product->getProducts($filter_category_id);

										if($results) {
											foreach($results as $item) {
												$productIDS[] = $item['product_id'];
											}
																		
											$randIndex = rand(0,count($productIDS)-1);
											if(in_array($productIDS[$randIndex], $cartIDS) || ($clicked_product_id == $productIDS[$randIndex])) {$this->response->setOutput(array()); exit;} // When the suggested product is already in the cart
											$product = $this->getProduct($productIDS[$randIndex], $this->data['upsell']['image_width'], $this->data['upsell']['image_height'], $this->data['upsell']['upsell_id'], $matches1[4][$i],$matches2[4][$i],$this->request->post['product_id'],$z,$counttotval);
											
										     if(isset($product)) {
										     	$product_upsell = $this->getProductTemplate($product);
										    	
										      $this->data['upsell']['content'] = str_replace('[category_upsell='.$category_id.']', $product_upsell, $this->data['upsell']['content']);

										      $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 
										    } else {
										    	$this->data['upsell']['content'] = str_replace('[category_upsell='.$category_id.']', '', $this->data['upsell']['content']);

										     $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 
										    } $i++; $z++;
										}
									}
							  	}
							   $this->data['upsell']['content']= htmlspecialchars_decode(trim(preg_replace('/\s+/', ' ', $this->data['upsell']['content'])));
							       
							   $this->response->setOutput(json_encode($this->data['upsell']));
						}
					}
				} else if ($upsell['method'] == '1') { // category method
					$upsell_category_ids = explode(",", $upsell['category_ids']);

					
					if(isset($this->request->get['product_id']))
						$clicked_product_id = $this->request->get['product_id'];
					else
						$clicked_product_id = $this->request->post['product_id'];

					$this->load->model('catalog/product');
					$categories = $this->model_catalog_product->getCategories($clicked_product_id);
					$cat_match = false;
					foreach($categories as $cat) {
						foreach($upsell_category_ids as $allowed_cat) {
							if($allowed_cat == $cat['category_id']) {
								$cat_match = true;
							}
						}
					}
					
					//how many products are there in the cart for particular category

					if($cat_match) { 


						$this->data['upsell'] = $upsell;

						$this->data['upsell']['content'] = unserialize($this->data['upsell']['content']);
						$this->data['upsell']['content'] = $this->data['upsell']['content'][$this->config->get('config_language_id')];
						
					    if ($c=preg_match_all ("/".$productRegex."/is", $this->data['upsell']['content'], $matches)) {
					    	
						      $c1=$matches[1][0];
						      $var1=$matches[2][0];
						      $c2=$matches[3][0];
						      $int1=$matches[4][0];
						      $c3=$matches[5][0];

						       //Discount_in regex
							      if ($c=preg_match_all ("/".$discountiRegex."/is", $this->data['upsell']['content'], $matches1)) {

							      $c2=$matches1[1][0];
							      $var2=$matches1[2][0];
							      $c3=$matches1[3][0];
							      $int2=$matches1[4][0];
							      $c4=$matches1[5][0];

							      }

							      //Discount_value regex
							      if ($c=preg_match_all ("/".$discountvRegex."/is", $this->data['upsell']['content'], $matches2)) {

							      $c3=$matches2[1][0];
							      $var3=$matches2[2][0];
							      $c4=$matches2[3][0];
							      $int3=$matches2[4][0];
							      $c5=$matches2[5][0];

							      }
							    
							      $i=0;$z=1; $counttotval=count($matches[4]);
						      foreach($matches[4] as $product_id) {
						      	if(in_array($product_id, $cartIDS) || ($clicked_product_id == $product_id)) {$this->response->setOutput(array()); exit;} // When the suggested product is already in the cart
							  	$product = $this->getProduct($product_id, $this->data['upsell']['image_width'], $this->data['upsell']['image_height'],$this->data['upsell']['upsell_id'], $matches1[4][$i],$matches2[4][$i],$this->request->post['product_id'],$z,$counttotval);
								     if(isset($product)) {

								     	$product_upsell = $this->getProductTemplate($product);
								     	

								     	//$product_upsell = $this->getProductTemplate($product);
								    	
								      $this->data['upsell']['content'] = str_replace('[product_upsell='.$product_id.']', $product_upsell, $this->data['upsell']['content']);
								      $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 
								    } else {
								    	$this->data['upsell']['content'] = str_replace('[product_upsell='.$product_id.']', '', $this->data['upsell']['content']);

								    $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 
								    }$i++; $z++;

							 	}
						  	}  

						  	if ($c=preg_match_all ("/".$categoryRegex."/is", $this->data['upsell']['content'], $matches)) {
							    $c1=$matches[1][0];
							    $var1=$matches[2][0];
							    $c2=$matches[3][0];
							    $int1=$matches[4][0];
							    $c3=$matches[5][0];


						       //Discount_in regex
							      if ($c=preg_match_all ("/".$discountiRegex."/is", $this->data['upsell']['content'], $matches1)) {

							      $c2=$matches1[1][0];
							      $var2=$matches1[2][0];
							      $c3=$matches1[3][0];
							      $int2=$matches1[4][0];
							      $c4=$matches1[5][0];

							      }

							      //Discount_value regex
							      if ($c=preg_match_all ("/".$discountvRegex."/is", $this->data['upsell']['content'], $matches2)) {

							      $c3=$matches2[1][0];
							      $var3=$matches2[2][0];
							      $c4=$matches2[3][0];
							      $int3=$matches2[4][0];
							      $c5=$matches2[5][0];

							      }
							     
						      	$i=0;$z=1; $counttotval=count($matches[4]);
						      	foreach($matches[4] as $category_id) {
						      		$filter_category_id = array('filter_category_id' => $category_id);
									$results = $this->model_catalog_product->getProducts($filter_category_id);

									if($results) {
										foreach($results as $item) {
											$productIDS[] = $item['product_id'];
										}
										    							
										$randIndex = rand(0,count($productIDS)-1);
										if(in_array($productIDS[$randIndex], $cartIDS) || ($clicked_product_id == $productIDS[$randIndex])) {$this->response->setOutput(array()); exit;} // When the suggested product is already in the cart
										$product = $this->getProduct($productIDS[$randIndex], $this->data['upsell']['image_width'], $this->data['upsell']['image_height'],$this->data['upsell']['upsell_id'],$matches1[4][$i],$matches2[4][$i],$this->request->post['product_id'],$z,$counttotval);
										
									     if(isset($product)) {
									     	$product_upsell = $this->getProductTemplate($product);
									    	
									      $this->data['upsell']['content'] = str_replace('[category_upsell='.$category_id.']', $product_upsell, $this->data['upsell']['content']);

									     $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 

									    } else {
									    	$this->data['upsell']['content'] = str_replace('[category_upsell='.$category_id.']', '', $this->data['upsell']['content']);

									    	 $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 

									    } $i++; $z++;
									}
								}
						  	}

						    $this->data['upsell']['content']= htmlspecialchars_decode(trim(preg_replace('/\s+/', ' ', $this->data['upsell']['content'])));
						  if(isset($this->data['upsell']))
						  {

						  	//print_r($this->data['upsell']); 
						  	/*if($this->data['upsell']['product_ids']==''){

						  		//this is for discount_in
									$crs1='(\\[)';	# Any Single Character 1
									$crs2='(discount_in)';	# Variable Name 1
									$crs3='(=)';	# Any Single Character 2
									$crs4='(\\d+)';	# Integer Number 1
									$crs5='(\\])';	# Any Single Character 3

									$cdiscountiRegex=$crs1.$crs2.$crs3.$crs4.$crs5;

									//this is for discount value
									$crb1='(\\[)';	# Any Single Character 1
									$crb2='(value)';	# Variable Name 1 
									$crb3='(=)';	# Any Single Character 2
									$crb4='(\\d+)';	# Integer Number 1
									$crb5='(\\])';	# Any Single Character 3

									$discountvRegex=$crb1.$crb2.$crb3.$crb4.$crb5;


									  //Discount_in regex
							      if ($c=preg_match_all ("/".$discountiRegex."/is", $this->data['upsell']['content'], $matches1)) {

							      $c2=$matches1[1][0];
							      $var2=$matches1[2][0];
							      $c3=$matches1[3][0];
							      $int2=$matches1[4][0];
							      $c4=$matches1[5][0];

							      } 

							      //Discount_value regex
							      if ($c1=preg_match_all ("/".$discountvRegex."/is", $this->data['upsell']['content'], $matches2)) {

							      $c3=$matches2[1][0];
							      $var3=$matches2[2][0];
							      $c4=$matches2[3][0];
							      $int3=$matches2[4][0];
							      $c5=$matches2[5][0];

							      }  
							      //echo "discount_in".$int2;
							      //echo "value".$int3; 	 
						  		 if($int2==1){ $this->data['upsell']['content']="<p><h3><b>Thanks for purchasing.</b></h3><p><h4>We are providing offer for you to buy this product</h4><br/><h3>If you buy product in the same category, you will get <b>".$int3." % Discount.</b> </h3>";}
							      else
							      {
							      	$this->data['upsell']['content']="<p><h3><b>Thanks for purchasing.</b></h3><p><h4>We are providing offer for you to buy this product</h4><br/><h3>If you buy product in the same category, you will get <b>".$int3." Rs Discount.</b> </h3>";}  


						  	 } */
						   $this->response->setOutput(json_encode($this->data['upsell']));
							}
						else{echo "null";}
					}
				}
			}
		}	
		}
		else echo "null";	
	} 

	public function getProductTemplate($product) {

		$Form = new Template();	
		$Form->data['button_cart'] = $this->language->get('add_to_cart');
		$Form->data['text_price'] = $this->language->get('text_price');
		$Form->data['text_or'] = $this->language->get('text_or');
		$Form->data['text_tax'] = $this->language->get('text_tax');
		$Form->data['button_wishlist'] = $this->language->get('button_wishlist');
		$Form->data['button_compare'] = $this->language->get('button_compare');
		$Form->data['product'] = $product;

		/***********get option value for the product start***********/

		$this->data['options'] = array();

		$this->language->load('product/product');
			//echo $this->request->get['product_id']; die;
			$this->load->model('catalog/product');
			$this->load->model('tool/image');

			foreach ($this->model_catalog_product->getProductOptions($product['product_id']) as $option) { 
				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') { 
					$option_value_data = array();
				 
					foreach ($option['option_value'] as $option_value) {

						/*if (!$option_value['subtract'] || (!$option_value['quantity'] > 0)) {*/
							if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
								$priceval = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
							} else {
								$priceval = false;
							}

							
							$option_value_data[] = array(
								'product_option_value_id' => $option_value['product_option_value_id'],
								'option_value_id'         => $option_value['option_value_id'],
								'name'                    => $option_value['name'],
								'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50), 
								'price'                   => $priceval,
								'price_prefix'            => $option_value['price_prefix'],
								'quantity'		=>$option_value['quantity'],
							);

						//}
						
					}
					
					$this->data['options'][] = array(
						'product_option_id' => $option['product_option_id'],
						'option_id'         => $option['option_id'],
						'name'              => $option['name'],
						'type'              => $option['type'],
						'option_value'      => $option_value_data,
						'required'          => $option['required']
					);					
				} elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$this->data['options'][] = array(
						'product_option_id' => $option['product_option_id'],
						'option_id'         => $option['option_id'],
						'name'              => $option['name'],
						'type'              => $option['type'],
						'option_value'      => $option['option_value'],
						'required'          => $option['required']
					);						
				}

				//print_r($option_value_data); die; 
				if($option_value_data){$this->data['optionsdisplay']=1;}else{$this->data['optionsdisplay']=0;}
				//echo $this->data['optionsdisplay']; die; 
			}
				$this->data['text_option'] = $this->language->get('text_option');

		/*********** get option value for the product end ***********/	
		$Form->data['options']=$this->data['options'];
		//print_r('<pre>'); print_r($this->data['options']); die; 

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/'.$this->moduleNameSmall.'_template.tpl')) {
			$template = $this->config->get('config_template') . '/template/module/'.$this->moduleNameSmall.'_template.tpl';
		} else {
			$template = 'default/template/module/'.$this->moduleNameSmall.'_template.tpl';
		}
		return $Form->fetch($template);
	}

	public function getProduct($product_id, $width=100, $height=100,$upsellid,$discount_in,$discount_value,$orgproductid,$z,$counttotval) { 
				

		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$this->data['product'] = array();

		$result = $this->model_catalog_product->getProduct($product_id);
 
		if ($result) {

			

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$orgprice = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$orgprice = false;
			}


			if($discount_in==1){ 
				//if(!$result['special']){
				if($result['price']){$result['price']=($result['price']/100)*(100 - $discount_value);}
				//}
				//if($result['special']){$result['special']=($result['price']/100)*(100 - $discount_value);}  
			}
			else
			{
				//if(!$result['special']){
				if($result['price']){$result['price']=$result['price'] - $discount_value;}
				//}
				//if($result['special']){$result['special']=$result['price']-$discount_value;}  
			}

			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $width, $height);
			} else {
				$image = false;
			}
						
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$special ? $special : $price);
			} else {
				$tax = false;
			}

			$discounts = $this->model_catalog_product->getProductDiscounts($product_id);

			$this->data['discounts'] = array();

			foreach ($discounts as $discount) {
				$this->data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $result['tax_class_id'], $this->config->get('config_tax')))
				);
			}
			
			/*setting discount price*/
			
		/*	if(!$result['special'])
			{ 
				//$price=trim($price,",");
				$price=($result['price']/$product_discount)*100;
				
			}
			else{
				//$special=trim($special,",");
				$special=($result['special']/$product_discount)*100;
			} */ 

			$this->data['product'] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'description'=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 400) . '..',
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => $rating,
				'points'	 => $result['points'],
				'tax'		 => $tax,
				'discounts'  => $this->data['discounts'],
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				'product_discount_in' =>$discount_in,
				'product_discount_value' =>$discount_value,
				'upsell_id'	=> $upsellid,
				'upsellproduct_price' => $result['price'],
				'upsellproduct_special' => $result['price'],
				'main_productid' => $orgproductid,
				'orgprice'   => $orgprice,
				'countval'	=>$z,
				'counttotval' => $counttotval
			);
		}	


		if(isset($this->data['product']))
			return $this->data['product'];

	}

	public function setpopupupsellprice()//set popup upsell price
	{
		$product_id=$this->request->post['product_id'];
		$upsellid=$this->request->post['upsellid'];
		$upsell_productprice=$this->request->post['upsell_productprice'];
		$upsell_productspecial=$this->request->post['upsell_productspecial'];
		$upsell_mainproductid=$this->request->post['upsell_mainproductid'];
		$this->load->model('module/popupupsell');
		$upsellsproductids = $this->model_module_popupupsell->getUpsellproductids($upsellid);
		
			
			if($upsellsproductids[0]['category_ids']=='')
			{
				
				if($upsellsproductids[0]['product_ids'])
				{
					$upsellsproductids[0]['product_ids']=trim($upsellsproductids[0]['product_ids']); 
					$productids=explode(",",$upsellsproductids[0]['product_ids']);

					//print_r($productids); 
					//get cart  products
					

					$productsInCart = $this->cart->getProducts();

					//print_r($productsInCart); die;
					$cartIDS = array();
					foreach($productsInCart as $item) {
					$cartIDS[] = $item['product_id'];
					}

					$temparray=0;
					if(count($productids) >0)
					{
						foreach ($productids as $val1) {
							foreach ($cartIDS as $value) {
								if($value==$val1)
								{
									$temparray=$temparray+1;

								}
							}
						}
					}

					if($temparray > 0)
					{  

						$upsellproducts=array();
						$upproductarray=array();
						$upproductarray[$upsell_mainproductid]=array('upsell_productid' => $product_id,
											  'upsell_productprice' => round($upsell_productprice),
											  'upsell_productspecial' => round($upsell_productspecial)	,
											  'upsellid' => $upsellid,
											  'upsell_mainproduct' => $upsell_mainproductid
							);
						
						//array_push($upsellproducts,$upproductarray);  
						//$upsellproducts[$upsellid]=array_push($upproductarray);
					/*							$this->session->data['upsell_productid']=$product_id;
						$this->session->data['upsell_productprice']=$upsell_productprice;
						$this->session->data['upsell_productspecial']=$upsell_productspecial;
						*/
						
						$this->session->data['upsell_array']=$upproductarray; 
						//print_r('<pre>'); 
						//print_r($this->session->data['upsell_array']); die;
					} 
				//}
			}

			}
			else
			{
				

				$upsellsproductids[0]['category_ids']=trim($upsellsproductids[0]['category_ids']); 
					$categoryids=explode(",",$upsellsproductids[0]['category_ids']);
				$upsellproductids1=array();
				
				foreach ($categoryids as $key) {

				$upsellproductids1=array_merge($upsellproductids1,$this->model_module_popupupsell->getproductidsforcategory($key));
	
				}
			
			
     		
				$productids = array();
					foreach($upsellproductids1 as $item1) {
					$productids[] = $item1['product_id'];
					}

					
				if($productids )
				{
					
					$productsInCart = $this->cart->getProducts();

					//print_r($productsInCart); die;
					$cartIDS = array();
					foreach($productsInCart as $item) {
					$cartIDS[] = $item['product_id'];
					}

					$temparray=0;
					if(count($productids) >0)
					{
						foreach ($productids as $val1) {
							foreach ($cartIDS as $value) {
								if($value==$val1)
								{
									$temparray=$temparray+1;

								}
							}
						}
					}

					//echo $temparray; die; 
					if($temparray > 0)
					{

						$upsellproducts=array();
						$upproductarray=array();
						$upproductarray[$upsell_mainproductid]=array('upsell_productid' => $product_id,
											  'upsell_productprice' => round($upsell_productprice),
											  'upsell_productspecial' => round($upsell_productspecial)	,
											  'upsellid' => $upsellid,
											  'upsell_mainproduct' => $upsell_mainproductid
							);
						
						//array_push($upsellproducts,$upproductarray);  
						//$upsellproducts[$upsellid]=array_push($upproductarray);
					/*							$this->session->data['upsell_productid']=$product_id;
						$this->session->data['upsell_productprice']=$upsell_productprice;
						$this->session->data['upsell_productspecial']=$upsell_productspecial;
						*/
						
						$this->session->data['upsell_array']=$upproductarray; 
						
					} 
				//}
			}
			}
		echo 1;  

	}
/* This is for onclick cart */
	/* This is for onclick cart */
	public function showUpsellOffer1() {
		header('Access-Control-Allow-Origin: *');
		$this->load->model('catalog/product');
		$this->load->model('module/popupupsell');
		$this->load->language('module/'.$this->moduleNameSmall);
		$this->load->language('product/product');
		$this->data['popupupsell'] = $this->config->get('popupupsell');
		$this->data['upsells'] = $this->model_module_popupupsell->getUpsells();

		$this->data['add_to_cart'] = $this->language->get('add_to_cart');
		$this->data['text_tax'] = $this->language->get('text_tax');

		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');

		$text_price = $this->language->get('text_price');
		$text_points = $this->language->get('text_points');
		$text_qty = $this->language->get('text_qty');
		$button_cart = $this->language->get('button_cart');
		$button_wishlist = $this->language->get('button_wishlist');
		$button_compare = $this->language->get('button_compare');
		$text_or = $this->language->get('text_or');
		$text_tax = $this->language->get('text_tax');
		// START PATTERN
		//This is for product
		$re1='(\\[)';	# Any Single Character 1
		$re2='(product_upsell)';	# Variable Name 1
		$re3='(=)';	# Any Single Character 2
		$re4='(\\d+)';	# Integer Number 1
		$re5='(\\])';	# Any Single Character 3

		$productRegex=$re1.$re2.$re3.$re4.$re5;

		//this is for discount_in
		$rs1='(\\[)';	# Any Single Character 1
		$rs2='(discount_in)';	# Variable Name 1
		$rs3='(=)';	# Any Single Character 2
		$rs4='(\\d+)';	# Integer Number 1
		$rs5='(\\])';	# Any Single Character 3

		$discountiRegex=$rs1.$rs2.$rs3.$rs4.$rs5;

		//this is for discount value
		$rb1='(\\[)';	# Any Single Character 1
		$rb2='(value)';	# Variable Name 1 
		$rb3='(=)';	# Any Single Character 2
		$rb4='(\\d+)';	# Integer Number 1
		$rb5='(\\])';	# Any Single Character 3

		$discountvRegex=$rb1.$rb2.$rb3.$rb4.$rb5;

		
		$categoryRegex=$re1.'(category_upsell)'.$re3.$re4.$re5;
		$productsInCart = $this->cart->getProducts();



		$cartIDS = array();
		$ccount=0;
		foreach($productsInCart as $item) {
			$cartIDS[] = $item['product_id'];
			if(isset($this->session->data['upsell_array']))
			{
			
				foreach($this->session->data['upsell_array'] as $item1) {
				
					if($item1['upsell_productid']==$item['product_id'])
					{
						if($item1['upsell_productprice']==$item['total'] || $item1['upsell_productspecial']==$item['total'])
						{ 
							$ccount=$ccount+1;
						} 
					}
				}
			}
		}
		//print_r($this->session->data['upsell_array']);
	

		if($ccount==0)
		{ 
			//$this->data['upsell']['content']="<p>test report</p>"; 

		// END PATTERN
			$ncountnew=0;
		foreach($this->data['upsells'] as $upsell) {
			if($upsell['status'] == '1') {


				//preg_match_all ("/".$productRegex."/is", $upsell['content'], $matches);
				//print_r($matches); die; 

				/* if(isset($this->session->data['upsellid'])){ unset($this->session->data['upsellid']); }
		if($upsell['upsell_id']){
		$this->session->data['upsellid']=$upsell['upsell_id']; } */ 
 
				if($upsell['method'] == '0') { // single product method


					$upsell_product_ids = explode(",", $upsell['product_ids']);

					//get first product id ******
					
					foreach($productsInCart as $itemn) {
						if (in_array($itemn['product_id'], $upsell_product_ids)) {
							$ncountnew=$ncountnew+1;
							if($ncountnew ==1)
							{
								$tnewproduct_id=$itemn['product_id']; 
								$this->request->post['product_id']=$tnewproduct_id;
							}

						}
					}

				/*	if(!isset($tnewproduct_id))
					{


						$upsellsproductids[0]['category_ids']=trim($upsellsproductids[0]['category_ids']); 
							$categoryids=explode(",",$upsellsproductids[0]['category_ids']);
						$upsellproductids1=array();
						
						foreach ($categoryids as $key) {

						$upsellproductids1=array_merge($upsellproductids1,$this->model_module_popupupsell->getproductidsforcategory($key));
			
						}
			
				
     				 
						$productids = array();
						foreach($upsellproductids1 as $item1) {
						$productids[] = $item1['product_id'];
						}
					
						foreach($productsInCart as $itemnn) {
						if (in_array($itemnn['product_id'], $productids)) {
							$ncountnew=$ncountnew+1;
								if($ncountnew ==1)
								{
									$tnewproduct_id=$itemnn['product_id']; 
									$this->request->post['product_id']=$tnewproduct_id;
								}

							}
						}

					} */



					if(isset($tnewproduct_id)) {
						$clicked_product_id = $tnewproduct_id;

						if (in_array($clicked_product_id, $upsell_product_ids)) {
						    $this->data['upsell'] = $upsell;
						   	$this->data['upsell']['content'] = unserialize($this->data['upsell']['content']);
							$this->data['upsell']['content'] = $this->data['upsell']['content'][$this->config->get('config_language_id')];
								
						    if ($c=preg_match_all ("/".$productRegex."/is", $this->data['upsell']['content'], $matches)) {
							      $c1=$matches[1][0];
							      $var1=$matches[2][0];
							      $c2=$matches[3][0];
							      $int1=$matches[4][0];
							      $c3=$matches[5][0];

							      //Discount_in regex
							      if ($c=preg_match_all ("/".$discountiRegex."/is", $this->data['upsell']['content'], $matches1)) {

							      $c2=$matches1[1][0];
							      $var2=$matches1[2][0];
							      $c3=$matches1[3][0];
							      $int2=$matches1[4][0];
							      $c4=$matches1[5][0];

							      } 

							      //Discount_value regex
							      if ($c1=preg_match_all ("/".$discountvRegex."/is", $this->data['upsell']['content'], $matches2)) {

							      $c3=$matches2[1][0];
							      $var3=$matches2[2][0];
							      $c4=$matches2[3][0];
							      $int3=$matches2[4][0];
							      $c5=$matches2[5][0];

							      } 

							     /* $discountiarr=array(); 
							      $discountvarr=array(); 
							      array_push($discountvarr,$int1,$int2,$int3);
							      array_push($discountiarr,$var1,$var2,$var3);
 									*/
							      $i=0; $z=1; $counttotval=count($matches[4]);
							      foreach($matches[4] as $product_id) {

							      	if(in_array($product_id, $cartIDS) || ($clicked_product_id == $product_id)) {$this->response->setOutput(array()); exit;} // When the suggested product is already in the cart


								  	$product = $this->getProduct($product_id, $this->data['upsell']['image_width'], $this->data['upsell']['image_height'], $this->data['upsell']['upsell_id'],$matches1[4][$i],$matches2[4][$i],$this->request->post['product_id'],$z,$counttotval);    

									     if(isset($product)) {

									     	$product_upsell = $this->getProductTemplate($product);
									     	

									     	//$product_upsell = $this->getProductTemplate($product);
									    	
									      $this->data['upsell']['content'] = str_replace('[product_upsell='.$product_id.']', $product_upsell, $this->data['upsell']['content']);

									      $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 

									     


									    } else {
									    	$this->data['upsell']['content'] = str_replace('[product_upsell='.$product_id.']', '', $this->data['upsell']['content']);

									    	$this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']);
									    } 
$i++; $z++;
								 	}
								 	
							  	} 

							  	if ($c=preg_match_all ("/".$categoryRegex."/is", $this->data['upsell']['content'], $matches)) {
								    $c1=$matches[1][0];
								    $var1=$matches[2][0];
								    $c2=$matches[3][0];
								    $int1=$matches[4][0];
								    $c3=$matches[5][0];

								    //Discount_in regex
							      if ($c=preg_match_all ("/".$discountiRegex."/is", $this->data['upsell']['content'], $matches1)) {

							      $c2=$matches1[1][0];
							      $var2=$matches1[2][0];
							      $c3=$matches1[3][0];
							      $int2=$matches1[4][0];
							      $c4=$matches1[5][0];

							      }

							       //Discount_value regex
							      if ($c=preg_match_all ("/".$discountvRegex."/is", $this->data['upsell']['content'], $matches2)) {

							      $c3=$matches2[1][0];
							      $var3=$matches2[2][0];
							      $c4=$matches2[3][0];
							      $int3=$matches2[4][0];
							      $c5=$matches2[5][0];

							      }
 
							    

							      	$i=0;$z=1; $counttotval=count($matches[4]);
							      	foreach($matches[4] as $category_id) {
							      		$filter_category_id = array('filter_category_id' => $category_id);
										$results = $this->model_catalog_product->getProducts($filter_category_id);

										if($results) {
											foreach($results as $item) {
												$productIDS[] = $item['product_id'];
											}
																		
											$randIndex = rand(0,count($productIDS)-1);
											if(in_array($productIDS[$randIndex], $cartIDS) || ($clicked_product_id == $productIDS[$randIndex])) {$this->response->setOutput(array()); exit;} // When the suggested product is already in the cart
											$product = $this->getProduct($productIDS[$randIndex], $this->data['upsell']['image_width'], $this->data['upsell']['image_height'], $this->data['upsell']['upsell_id'], $matches1[4][$i],$matches2[4][$i],$this->request->post['product_id'],$z,$counttotval);
											
										     if(isset($product)) {
										     	$product_upsell = $this->getProductTemplate($product);
										    	
										      $this->data['upsell']['content'] = str_replace('[category_upsell='.$category_id.']', $product_upsell, $this->data['upsell']['content']);

										      $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 
										    } else {
										    	$this->data['upsell']['content'] = str_replace('[category_upsell='.$category_id.']', '', $this->data['upsell']['content']);

										     $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 
										    } $i++; $z++;
										}
									}
							  	}
							   $this->data['upsell']['content']= htmlspecialchars_decode(trim(preg_replace('/\s+/', ' ', $this->data['upsell']['content'])));
							       
							   $this->response->setOutput(json_encode($this->data['upsell']));
						}
					}
				} else if ($upsell['method'] == '1') { // category method
					$upsell_category_ids = explode(",", $upsell['category_ids']);

					
					if(!isset($tnewproduct_id))
					{


						$upsell['category_ids']=trim($upsell['category_ids']); 
							$categoryids=explode(",",$upsell['category_ids']);
						$upsellproductids1=array();
						
						foreach ($categoryids as $key) {

						$upsellproductids1=array_merge($upsellproductids1,$this->model_module_popupupsell->getproductidsforcategory($key));
			
						}
			
				
     				 
						$productids = array();
						foreach($upsellproductids1 as $item1) {
						$productids[] = $item1['product_id'];
						}
						
						foreach($productsInCart as $itemnn) {
						
						if (in_array($itemnn['product_id'], $productids)) {
							$ncountnew=$ncountnew+1;
								if($ncountnew ==1)
								{
									$tnewproduct_id=$itemnn['product_id']; 
									$this->request->post['product_id']=$tnewproduct_id;
								}

							}
						}

					}
					
					if(isset($tnewproduct_id))
						$clicked_product_id = $tnewproduct_id;
					//else
					//	$clicked_product_id = $this->request->post['product_id'];
					
					$this->load->model('catalog/product');
					$categories = $this->model_catalog_product->getCategories($clicked_product_id);
					$cat_match = false;
					foreach($categories as $cat) {
						foreach($upsell_category_ids as $allowed_cat) {
							if($allowed_cat == $cat['category_id']) {
								$cat_match = true;
							}
						}
					}
					
					//how many products are there in the cart for particular category

					if($cat_match) { 


						$this->data['upsell'] = $upsell;

						$this->data['upsell']['content'] = unserialize($this->data['upsell']['content']);
						$this->data['upsell']['content'] = $this->data['upsell']['content'][$this->config->get('config_language_id')];
						
					    if ($c=preg_match_all ("/".$productRegex."/is", $this->data['upsell']['content'], $matches)) {
					    	
						      $c1=$matches[1][0];
						      $var1=$matches[2][0];
						      $c2=$matches[3][0];
						      $int1=$matches[4][0];
						      $c3=$matches[5][0];

						       //Discount_in regex
							      if ($c=preg_match_all ("/".$discountiRegex."/is", $this->data['upsell']['content'], $matches1)) {

							      $c2=$matches1[1][0];
							      $var2=$matches1[2][0];
							      $c3=$matches1[3][0];
							      $int2=$matches1[4][0];
							      $c4=$matches1[5][0];

							      }

							      //Discount_value regex
							      if ($c=preg_match_all ("/".$discountvRegex."/is", $this->data['upsell']['content'], $matches2)) {

							      $c3=$matches2[1][0];
							      $var3=$matches2[2][0];
							      $c4=$matches2[3][0];
							      $int3=$matches2[4][0];
							      $c5=$matches2[5][0];

							      }
							    
							      $i=0;$z=1; $counttotval=count($matches[4]);
						      foreach($matches[4] as $product_id) {
						      	if(in_array($product_id, $cartIDS) || ($clicked_product_id == $product_id)) {$this->response->setOutput(array()); exit;} // When the suggested product is already in the cart
							  	$product = $this->getProduct($product_id, $this->data['upsell']['image_width'], $this->data['upsell']['image_height'],$this->data['upsell']['upsell_id'], $matches1[4][$i],$matches2[4][$i],$this->request->post['product_id'],$z,$counttotval);
								     if(isset($product)) {

								     	$product_upsell = $this->getProductTemplate($product);
								     	

								     	//$product_upsell = $this->getProductTemplate($product);
								    	
								      $this->data['upsell']['content'] = str_replace('[product_upsell='.$product_id.']', $product_upsell, $this->data['upsell']['content']);
								      $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 
								    } else {
								    	$this->data['upsell']['content'] = str_replace('[product_upsell='.$product_id.']', '', $this->data['upsell']['content']);

								    $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 
								    }$i++; $z++;

							 	}
						  	}  

						  	if ($c=preg_match_all ("/".$categoryRegex."/is", $this->data['upsell']['content'], $matches)) {
							    $c1=$matches[1][0];
							    $var1=$matches[2][0];
							    $c2=$matches[3][0];
							    $int1=$matches[4][0];
							    $c3=$matches[5][0];


						       //Discount_in regex
							      if ($c=preg_match_all ("/".$discountiRegex."/is", $this->data['upsell']['content'], $matches1)) {

							      $c2=$matches1[1][0];
							      $var2=$matches1[2][0];
							      $c3=$matches1[3][0];
							      $int2=$matches1[4][0];
							      $c4=$matches1[5][0];

							      }

							      //Discount_value regex
							      if ($c=preg_match_all ("/".$discountvRegex."/is", $this->data['upsell']['content'], $matches2)) {

							      $c3=$matches2[1][0];
							      $var3=$matches2[2][0];
							      $c4=$matches2[3][0];
							      $int3=$matches2[4][0];
							      $c5=$matches2[5][0];

							      }
							     
						      	$i=0;$z=1; $counttotval=count($matches[4]);
						      	foreach($matches[4] as $category_id) {
						      		$filter_category_id = array('filter_category_id' => $category_id);
									$results = $this->model_catalog_product->getProducts($filter_category_id);

									if($results) {
										foreach($results as $item) {
											$productIDS[] = $item['product_id'];
										}
										    							
										$randIndex = rand(0,count($productIDS)-1);
										if(in_array($productIDS[$randIndex], $cartIDS) || ($clicked_product_id == $productIDS[$randIndex])) {$this->response->setOutput(array()); exit;} // When the suggested product is already in the cart
										$product = $this->getProduct($productIDS[$randIndex], $this->data['upsell']['image_width'], $this->data['upsell']['image_height'],$this->data['upsell']['upsell_id'],$matches1[4][$i],$matches2[4][$i],$this->request->post['product_id'],$z,$counttotval);
										
									     if(isset($product)) {
									     	$product_upsell = $this->getProductTemplate($product);
									    	
									      $this->data['upsell']['content'] = str_replace('[category_upsell='.$category_id.']', $product_upsell, $this->data['upsell']['content']);

									     $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 

									    } else {
									    	$this->data['upsell']['content'] = str_replace('[category_upsell='.$category_id.']', '', $this->data['upsell']['content']);

									    	 $this->data['upsell']['content'] = str_replace('[discount_in='.$matches1[4][$i].'][value='.$matches2[4][$i].']','', $this->data['upsell']['content']); 

									    } $i++; $z++;
									}
								}
						  	}

						    $this->data['upsell']['content']= htmlspecialchars_decode(trim(preg_replace('/\s+/', ' ', $this->data['upsell']['content'])));
						  if(isset($this->data['upsell']))
						  {

						  	//print_r($this->data['upsell']); 
						  	/*if($this->data['upsell']['product_ids']==''){

						  		//this is for discount_in
									$crs1='(\\[)';	# Any Single Character 1
									$crs2='(discount_in)';	# Variable Name 1
									$crs3='(=)';	# Any Single Character 2
									$crs4='(\\d+)';	# Integer Number 1
									$crs5='(\\])';	# Any Single Character 3

									$cdiscountiRegex=$crs1.$crs2.$crs3.$crs4.$crs5;

									//this is for discount value
									$crb1='(\\[)';	# Any Single Character 1
									$crb2='(value)';	# Variable Name 1 
									$crb3='(=)';	# Any Single Character 2
									$crb4='(\\d+)';	# Integer Number 1
									$crb5='(\\])';	# Any Single Character 3

									$discountvRegex=$crb1.$crb2.$crb3.$crb4.$crb5;


									  //Discount_in regex
							      if ($c=preg_match_all ("/".$discountiRegex."/is", $this->data['upsell']['content'], $matches1)) {

							      $c2=$matches1[1][0];
							      $var2=$matches1[2][0];
							      $c3=$matches1[3][0];
							      $int2=$matches1[4][0];
							      $c4=$matches1[5][0];

							      } 

							      //Discount_value regex
							      if ($c1=preg_match_all ("/".$discountvRegex."/is", $this->data['upsell']['content'], $matches2)) {

							      $c3=$matches2[1][0];
							      $var3=$matches2[2][0];
							      $c4=$matches2[3][0];
							      $int3=$matches2[4][0];
							      $c5=$matches2[5][0];

							      }  
							      //echo "discount_in".$int2;
							      //echo "value".$int3; 	 
						  		 if($int2==1){ $this->data['upsell']['content']="<p><h3><b>Thanks for purchasing.</b></h3><p><h4>We are providing offer for you to buy this product</h4><br/><h3>If you buy product in the same category, you will get <b>".$int3." % Discount.</b> </h3>";}
							      else
							      {
							      	$this->data['upsell']['content']="<p><h3><b>Thanks for purchasing.</b></h3><p><h4>We are providing offer for you to buy this product</h4><br/><h3>If you buy product in the same category, you will get <b>".$int3." Rs Discount.</b> </h3>";}  


						  	 } */
                                                
						   $this->response->setOutput(json_encode($this->data['upsell']));
							}
						else{echo "null";}
					}
				}
			}
		}	
		}
		else echo "null";	
	} 
}
?>