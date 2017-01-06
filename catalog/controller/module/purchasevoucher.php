<?php  
class ControllerModulepurchasevoucher extends Controller {
  	private $error = array();
	
	protected function index($setting) {
		$this->language->load('module/purchasevoucher');
 
      	$this->data['heading_title'] = $this->language->get('heading_title');
				
		$this->data['button_cart'] = $this->language->get('button_cart');
		
		$this->load->model('module/purchasevoucher');
		
		$this->load->model('tool/image');

		$this->data['products'] = array();
		
		

		$results = $this->model_module_purchasevoucher->getvoucherProducts($setting['limit']);
		if ($results) {
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
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
							
			$this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/purchasevoucher.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/purchasevoucher.tpl';
		} else {
			$this->template = 'default/template/module/purchasevoucher.tpl';
		}

		$this->render();
	}
	
	public function admincall(){
	$order_id= $this->request->get['order_id'];
	$this->load->model('module/purchasevoucher');

  	$result=$this->model_module_purchasevoucher->fetchorder($order_id);
$custemail= 	$result['customer_email'];
$custname= 	$result['customer_name'];
$storename= 	$result['storename'];
$order_status_id=$this->config->get('purchasevoucher_orderstatus');
$order_currency_code= 	$result['order_currency_code'];
$order_currency_value= 	$result['order_currency_value'];
$language_id= 	$result['language_id'];
$storeurl= 	$result['storeurl'];
$configemail= 	$result['configemail'];
$call=0;


    $this->model_module_purchasevoucher->sendvoucher($order_id,$custemail,$custname,$storename,$order_status_id,$order_currency_code, $order_currency_value,$language_id,$storeurl,$configemail,$call);
	   
	}
	
	public function emailid(){
	$this->language->load('module/purchasevoucher');

$prefix_eval = "";


if(isset($_POST["vemail"]) and $this->validate() ){

 
$_SESSION['vname'] = $_POST["vname"];
$_SESSION['vemail'] = $_POST["vemail"];

echo('$("'.$prefix_eval.' #email_result").html("'.$this->language->get('success').'");$("'.$prefix_eval.' #subscribe")[0].reset();');
	    

}
else{

	    		
  echo('$("'.$prefix_eval.' #email_result").html("<span class=\"error\">'.$this->error['warning'].'</span>")');
	 unset($_SESSION['vemail']);
unset($_SESSION['vname']); 

	}
die();
}	

private function validate() {



    	
    	if ((utf8_strlen($_POST['vname']) < 1) || (utf8_strlen($_POST['vname']) > 32)) {
      		$this->error['warning'] = $this->language->get('invalid_name');
			}
			
 if ((utf8_strlen($_POST['vemail']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $_POST['vemail'])) {
      		$this->error['warning'] = $this->language->get('invalid_email');
    	}

		
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
			

}
	
}
?>