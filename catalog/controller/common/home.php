<?php  
class ControllerCommonHome extends Controller {

	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		
		

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header',
			'common/offer_slideshow',
		);
										
		$this->response->setOutput($this->render());
	}

	public function page404() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/page404.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/page404.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl'; 
		} 
		
		$this->children = array( 
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header',
			'common/offer_slideshow',
		);
		http_response_code(404);								
		$this->response->setOutput($this->render());
	}

        public function page410() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/page410.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/page410.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl'; 
		} 
		
		$this->children = array( 
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header',
			'common/offer_slideshow',
		);
		http_response_code(410);								
		$this->response->setOutput($this->render());
	}
  
	public function emailus()//email us
	{
	$username=$this->request->post['username'];
	$comment=$this->request->post['comment'];
        $emailid=$this->request->post['emailid'];
        $productname=$this->request->post['productname'];  
        $phoneno=$this->request->post['phoneno'];  
        $to=' order@footlounge.in';            
   
       $subject='Product Enquiry';
        $message="Dear Admin,<br/><p>You have received an enquiry for the below product.</p><br/>Name:&nbsp; ".$username."<br/>Product:&nbsp; ".$productname."<br/>Phone Number: &nbsp; ".$phoneno."<br/>Comment:&nbsp; ".$comment."<br/>Email : &nbsp; ".$emailid."<br/><br/>Thank you.";

//$headers = "From: webmaster@example.com\r\n";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: order@footlounge.in' . "\r\n";

/*// Always set content-type when sending HTML email
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion();  
// More headers
$headers .= 'From: info@tech-bee.com' . "\r\n";  */

if(mail($to,$subject,$message,$headers)) echo 1; else echo 0;   
  

	} 
	
	public function getproductcategory(){ // get product category 
	$this->load->model('menu/megamenu'); 	 
	$tproductid=$this->request->post['tproductid'];
	$countval=0;	
	 //echo $this->model_menu_megamenu->getstatecityinfos($zipcode);
	$resarray=$this->model_menu_megamenu->getproductcategoryinfos($tproductid); 
	if(count($resarray) > 0)
	{
		foreach ($resarray as $val) {
			if($val=='clothing' || $val=='CLOTHING')  $countval=1; 
		}
	}
	echo $countval;
}


public function checkpostcodeaddress()//check post code address
{
	$this->load->model('menu/megamenu'); 	 
	$n_postcodeaddr=$this->request->post['n_postcodeaddr'];
	$countval=0;	
	 //echo $this->model_menu_megamenu->getstatecityinfos($zipcode);
	$postcode=$this->model_menu_megamenu->checkpostcodeaddressinfos($n_postcodeaddr); 
	
		$this->load->model('menu/megamenu'); 	 
			$zipcode=$postcode;
			$codstatus = $this->model_menu_megamenu->getcodstatus($zipcode); 
			
			if($codstatus == 1)
			{
				$this->session->data['user_zipcode']=$zipcode;  	
			}
			else
			{
				if(isset($this->session->data['user_zipcode'])) unset($this->session->data['user_zipcode']); 
			} 
}	

public function codstatus()//get productiunfos
{
	$this->load->model('menu/megamenu'); 	 
	$zipcode=$this->request->post['zipcode'];
	$codstatus = $this->model_menu_megamenu->getcodstatus($zipcode); 
	if(isset($this->session->data['user_zipcodeavail'])){ unset($this->session->data['user_zipcodeavail']);}
	if($codstatus==1)
	{
		$this->session->data['user_zipcodeavail']=$zipcode;
		 
	} $this->session->data['user_zipcode']=$zipcode;  
	echo $codstatus;  
}	

public function getstatecity()
{
	$this->load->model('menu/megamenu'); 	 
	 $zipcode=$this->request->post['zipcode'];
	 //echo $this->model_menu_megamenu->getstatecityinfos($zipcode);
	echo json_encode($this->model_menu_megamenu->getstatecityinfos($zipcode));  
	 
}

public function getstatecodeinfo()
{
	$this->load->model('menu/megamenu'); 	 
	 $statename=$this->request->post['statename'];
	
	 //echo $this->model_menu_megamenu->getstatecityinfos($zipcode);
	echo $this->model_menu_megamenu->getstatecodeinfos($statename);  
	 
}

}

?>