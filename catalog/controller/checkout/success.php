<?php
class ControllerCheckoutSuccess extends Controller { 
	public function index() { 	
	
	//send sms
		$this->load->model('checkout/order');

		//send sms
		include(DOCUMENT_ROOT . 'sms/sendsms.php');
		 
		//to know payment method and zipcode
		if(isset($this->session->data['user_zipcode'])) unset($this->session->data['user_zipcode']);   
		
			if($this->session->data['order_id'])
		{	
		
		$order_status_info=$this->model_checkout_order->getorder_statusdetails($this->session->data['order_id']);  
		 
                //code for abandonened user update table
                if(isset($this->session->data['abduserid'])){
                            $resultsdata = $this->model_checkout_order->updateabdandoneduser1('step4',$this->session->data['abduserid'],$this->customer->isLogged());
                $resultsdata = $this->model_checkout_order->updateabdandoneduserfinal($this->session->data['abduserid'],$this->customer->isLogged());

          
                } 

    		if($this->customer->isLogged())
    		{

    			$smsalertmobile=$this->model_checkout_order->getcustomersmsprealert($this->customer->isLogged()); 

    			//if($smsalert==1 || $smsalert==2)
    			if($this->session->data['smsalert_s']==1) 
    			{ 
    			if($smsalertmobile)
    			{
    				//send sms
    				$dynmsg="Thank you for Shopping at FootLounge! Your Order ID: ".$this->session->data['order_id']." has been received.  We will keep you informed on the status of your order - Team FL (+91-91768-70701)"; 
					//}
					  
		    		$sendsms=new sendsms("http://dnd.bdsindia.net/api/v3",'sms', "A12dc88995cc17ee8970123b6abda7059", "FLoung");
					$sendsms->send_sms($smsalertmobile, $dynmsg, 'xml'); 
 
  					 

					$sendsms->schedule_sms($smsalertmobile, "message"
					                     , "http://www.techbee.domain/yourdlrpage&custom=XX", 'xml',
					                      'YYYY-MM-DD HH:MM PM/AM');
					/*$sendsms->unicode_sms("8438334672","unicode message",
					                      "http://www.techbee.domain/yourdlrpage&custom=XX",'xml','1');*/ 
					$sendsms->messagedelivery_status("".$smsalertmobile."-1");
					$sendsms->groupdelivery_status($smsalertmobile);    
					}

    			}

    		}
    		else
    		{
    			if($this->session->data['smsalert_s']==1)
				{
    			$dynmsg="Thank you for Shopping at FootLounge! Your Order ID: ".$this->session->data['order_id']." has been received.  We will keep you informed on the status of your order - Team FL (+91-91768-70701)"; 
					//}
					  
		    		$sendsms=new sendsms("http://dnd.bdsindia.net/api/v3",'sms', "A12dc88995cc17ee8970123b6abda7059", "FLoung");
					$sendsms->send_sms($order_status_info[1], $dynmsg, 'xml'); 
 
  					 

					$sendsms->schedule_sms($order_status_info[1], "message"
					                     , "http://www.techbee.domain/yourdlrpage&custom=XX", 'xml',
					                      'YYYY-MM-DD HH:MM PM/AM');
					/*$sendsms->unicode_sms("8438334672","unicode message",
					                      "http://www.techbee.domain/yourdlrpage&custom=XX",'xml','1');*/ 
					$sendsms->messagedelivery_status("".$order_status_info[1]."-1");
					$sendsms->groupdelivery_status($order_status_info[1]); 
					}   
    		}
    				//if($order_status_info[2] == 'Pending')
    				//{
    				
		 
		}   
		
		
		if (isset($this->session->data['order_id'])) {
			$this->cart->clear();

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);	
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
		}	
									   
		$this->language->load('checkout/success');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['breadcrumbs'] = array(); 

      	$this->data['breadcrumbs'][] = array(
        	'href'      => $this->url->link('common/home'),
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	); 
		
      	$this->data['breadcrumbs'][] = array(
        	'href'      => $this->url->link('checkout/cart'),
        	'text'      => $this->language->get('text_basket'),
        	'separator' => $this->language->get('text_separator')
      	);
				
		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
			'text'      => $this->language->get('text_checkout'),
			'separator' => $this->language->get('text_separator')
		);	
					
      	$this->data['breadcrumbs'][] = array(
        	'href'      => $this->url->link('checkout/success'),
        	'text'      => $this->language->get('text_success'),
        	'separator' => $this->language->get('text_separator')
      	);

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		if ($this->customer->isLogged()) {
    		$this->data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
	
		} else {
    		$this->data['text_message'] = $this->language->get('text_guest_message');
		}
		
    	$this->data['button_continue'] = $this->language->get('button_continue');

    	$this->data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
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
?>