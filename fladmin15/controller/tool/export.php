<?php 
class ControllerToolExport extends Controller { 
	private $error = array();
	
	public function index() {
		$this->load->language('tool/export');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('tool/export');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			if ((isset( $this->request->files['upload'] )) && (is_uploaded_file($this->request->files['upload']['tmp_name']))) {
				$file = $this->request->files['upload']['tmp_name'];
				
				if ($this->model_tool_export->upload($file)===TRUE) {
					$this->session->data['success'] = $this->language->get('text_success');
					$this->redirect($this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL'));
				}
				else {

					$this->error['warning'] = $this->language->get('error_upload');
				}
			}
			else if ((isset( $this->request->files['sizeupload'] )) && (is_uploaded_file($this->request->files['sizeupload']['tmp_name']))) {
				$file = $this->request->files['sizeupload']['tmp_name'];
				


                                     $outputarray=$this->model_tool_export->size_upload($file);

       
                               

                           
				if ($outputarray[0][0]=="TRUE") {
$excelid="";

for($i=0;$i<count($outputarray[1]);$i++){

if(count($outputarray[1])==$i+1){
$excelid.=$outputarray[1][$i];
}
else{

$excelid.=$outputarray[1][$i].",";
}
}


if(count($outputarray[1])!=0){
			
					$this->session->data['success'] = "You Have Imported Options Successfully But ".$excelid." These row numbers of excel sheet doesnot have the MODEL for particular ProductID" ;
                                         }


else{

	
					$this->session->data['success'] = "You Have Imported Options Successfully";

}
					$this->redirect($this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL'));
				}
				else {

					$this->error['warning'] = $this->language->get('error_upload');
				}		
				
			}
		}

		if (!empty($this->session->data['export_error']['errstr'])) {
			$this->error['warning'] = $this->session->data['export_error']['errstr'];
			if (!empty($this->session->data['export_nochange'])) {
				$this->error['warning'] .= '<br />'.$this->language->get( 'text_nochange' );
			}
			$this->error['warning'] .= '<br />'.$this->language->get( 'text_log_details' );
		}
		unset($this->session->data['export_error']);
		unset($this->session->data['export_nochange']);

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['entry_restore'] = $this->language->get('entry_restore');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['button_import'] = $this->language->get('button_import');
		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['error_select_file'] = $this->language->get('error_select_file');
		$this->data['error_post_max_size'] = str_replace( '%1', ini_get('post_max_size'), $this->language->get('error_post_max_size') );
		$this->data['error_upload_max_filesize'] = str_replace( '%1', ini_get('upload_max_filesize'), $this->language->get('error_upload_max_filesize') );

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => FALSE
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		
		$this->data['action'] = $this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['export'] = $this->url->link('tool/export/download', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['sizeexport'] = $this->url->link('tool/export/sizedownload', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['post_max_size'] = $this->return_bytes( ini_get('post_max_size') );
		$this->data['upload_max_filesize'] = $this->return_bytes( ini_get('upload_max_filesize') );

		$this->template = 'tool/export.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		$this->response->setOutput($this->render());
	}


	function return_bytes($val)
	{
		$val = trim($val);
	
		switch (strtolower(substr($val, -1)))
		{
			case 'm': $val = (int)substr($val, 0, -1) * 1048576; break;
			case 'k': $val = (int)substr($val, 0, -1) * 1024; break;
			case 'g': $val = (int)substr($val, 0, -1) * 1073741824; break;
			case 'b':
				switch (strtolower(substr($val, -2, 1)))
				{
					case 'm': $val = (int)substr($val, 0, -2) * 1048576; break;
					case 'k': $val = (int)substr($val, 0, -2) * 1024; break;
					case 'g': $val = (int)substr($val, 0, -2) * 1073741824; break;
					default : break;
				} break;
			default: break;
		}
		return $val;
	}


	public function download() {
		if ($this->validate()) {
                         ini_set('memory_limit', '2048M'); //Extend memory limit 

			// send the categories, products and options as a spreadsheet file
			$this->load->model('tool/export');
			$this->model_tool_export->download();
			$this->redirect( $this->url->link( 'tool/export', 'token='.$this->request->get['token'], 'SSL' ) );

		} else {

			// return a permission error page
			return $this->forward('error/permission');
		}
	}

	public function sizedownload() {
		if ($this->validate()) {

			// send the categories, products and options as a spreadsheet file
			$this->load->model('tool/export');
			$this->model_tool_export->sizedownload();
			
			//$this->redirect( $this->url->link( 'tool/export', 'token='.$this->request->get['token'], 'SSL' ) );

		} else {

			// return a permission error page
			return $this->forward('error/permission');
		}
	}


	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/export')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

       public function getabandonedusers() // get abandoned user list
        {
          $this->language->load('sale/order');
          //$this->language->get('heading_title')='Abandoned Users';

		$this->document->setTitle($this->language->get('Abandoned Users'));

		$this->load->model('sale/order');

    	  $this->getabuserList();
            
        }
         
        protected function getabuserList() {

		if (isset($this->request->get['filter_ab_cust_id'])) {
			$filter_ab_cust_id = $this->request->get['filter_ab_cust_id'];
		} else {
			$filter_ab_cust_id = null;
		}

		if (isset($this->request->get['filter_userid'])) {
			$filter_userid= $this->request->get['filter_userid'];
		} else {
			$filter_userid = null;
		}

		if (isset($this->request->get['filter_cust_mailid'])) {
			$filter_cust_mailid = $this->request->get['filter_cust_mailid'];
		} else {
			$filter_cust_mailid = null;
		}
		
		if (isset($this->request->get['filter_order_date'])) {
			$filter_order_date = $this->request->get['filter_order_date'];
		} else {
			$filter_order_date = null;
		}


		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ab_cust_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		$url = '';

		if (isset($this->request->get['filter_ab_cust_id'])) {
			$url .= '&filter_ab_cust_id=' . $this->request->get['filter_ab_cust_id'];
		}
		
		if (isset($this->request->get['filter_userid'])) {
			$url .= '&filter_userid=' . $this->request->get['filter_userid'];
		}
											
		if (isset($this->request->get['filter_cust_mailid'])) {
			$url .= '&filter_cust_mailid=' . $this->request->get['filter_cust_mailid'];
		}
		
		if (isset($this->request->get['filter_order_date'])) {
			$url .= '&filter_order_date=' . $this->request->get['filter_order_date'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		/* $this->data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['insert'] = $this->url->link('sale/order/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('sale/order/delete', 'token=' . $this->session->data['token'] . $url, 'SSL'); */ 

		$this->data['orders'] = array();

		$data = array(
			'filter_ab_cust_id'        => $filter_ab_cust_id,
			'filter_userid'	     => $filter_userid,
			'filter_cust_mailid' => $filter_cust_mailid,
			'filter_order_date'           => $filter_order_date,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);


		$order_total = $this->model_sale_order->getTotalabuserOrders($data);

		$newresults = $this->model_sale_order->getabuserOrders($data);
                
                $couponcodes= $this->model_sale_order->getcouponcodeinfos(); //get coupon code for abandoned user 
              
    	foreach ($newresults as $result) {

			/*$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);
			
			if (strtotime($result['date_added']) > strtotime('-' . (int)$this->config->get('config_order_edit') . ' day')) {
				$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('sale/order/update', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
				);
			}*/

 if($result['userid']){
                         $username = $this->model_sale_order->getusernameinfo($result['userid']); 
                         }
                         else
                         {$username ='guest'; }

                          // This is for fetching product details

                         if($result['ab_cust_id']){
                         $username = $this->model_sale_order->getusernameinfo($result['ab_cust_id']); 
                         }
                         else
                         {$username ='guest'; }
                         $prodarray=array();$prodstr='';
                         if($result['product_json']){

            	         $productjson=json_decode($result['product_json']);
             
               
	                   foreach($productjson as $keyn => $valuen)
			         {
			         	array_push($prodarray, $valuen->name) ;
			         
			         }


                         }

          if(count($prodarray) > 1) {
			$prodstr=implode(" , ",$prodarray);}
			else {if(isset($prodarray[0])) {$prodstr=$prodarray[0];} else {$prodstr='';}}
 

			
			$this->data['abusers'][] = array(
				'ab_cust_id'      => $result['ab_cust_id'],
				'userid'      => $result['userid'],
				'cust_mailid'        => $result['cust_mailid'],
				'username' =>$username,
				'st1'    => $result['st1'],
				'st2'    => $result['st2'],
				'st3'    => $result['st3'],
				'st4'    => $result['st4'],
                                'status'    => $result['status'],
                                  'products'  =>$prodstr,
                                'order_date'    => $result['order_date'],
			);
		}
                
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_missing'] = $this->language->get('text_missing');

		$this->data['column_order_id'] = $this->language->get('column_order_id');
    	$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_date_modified'] = $this->language->get('column_date_modified');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_invoice'] = $this->language->get('button_invoice');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
											
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$this->data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$this->data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$this->data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
											
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('tool/export/getabandonedusers', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
                
		$this->data['pagination'] = $pagination->render();

		$this->data['filter_ab_cust_id'] = $filter_ab_cust_id;
		$this->data['filter_userid'] = $filter_userid;
		$this->data['filter_cust_mailid'] = $filter_cust_mailid;
		$this->data['filter_order_date'] = $filter_order_date;
                $this->data['couponcodes'] = $couponcodes;
		$this->load->model('localisation/order_status');
          

    	//$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
       // $this->data['test12']="sdfdf";
       
    	//foreach ($results as $result) {
       // }

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/abuser_order_list.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
  	}
  public function updateabuserorder() //update abandoned user details
      {

         $abuserid= $this->request->post['abuserid'];
         $mailid=  $this->request->post['mailid'];
         $couponcode=$this->request->post['couponcode'];
         $username='';

         if($mailid){ $usernames=explode("@",$mailid); $username=$usernames[0];} 
       
         $this->load->model('sale/order');
         $couponcodes= $this->model_sale_order->updatecouponcodeinfos(); //get coupon code for abandoned user 
         $coupondata= $this->model_sale_order->getcoupondatainfos($couponcode);
          $discountdisn=''; $discountcoden='';$discounttypen='';
         if(isset($coupondata[0]['discount'])){ $discountdisn= round($coupondata[0]['discount']);}
          if(isset($coupondata[0]['code'])){ $discountcoden= $coupondata[0]['code'];}  
        if(isset($coupondata[0]['type'])){ $discounttypen= $coupondata[0]['type'];}  
         //get abuser product info

         $abuserproducts= $this->model_sale_order->getabuserprodinfos($abuserid);



if(isset($abuserproducts[0]['product_json']))
{
     $decodeprodinfo=json_decode($abuserproducts[0]['product_json']);
      
}



if($decodeprodinfo){

          $shopbag='<table class="table table-bordered border col-xs-12 col-sm-12 col-md-12 removepadd" style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;padding: 0px !important; padding:5%; margin-top:12px;">
<thead>
<tr style="background:#f0f0c3; "><th>Product Image</th><th>Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr>
</thead>
						<tbody style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">';
						

        
$totalval=0;

         foreach($decodeprodinfo as $keyn => $valuen)
         {
         $option_value='';
              foreach($valuen->option as $keyn1 => $valuen1)   { 

                  if($valuen1->name == 'Size'){
                  $product_option_id=$valuen1->product_option_id;
                  $product_option_value_id=$valuen1->product_option_value_id;
                  $option_id=$valuen1->option_id;
                  $option_value_id=$valuen1->option_value_id; 
                  $option_value=$valuen1->option_value;
            
                   }
                  } 

         	if($valuen->product_id){
         							//$nab_product_ids=explode(",",$data['product_ids']);
         							//foreach($nab_product_ids as $new1)
         							//{	
         							
 
$cutimage= "https://gofootlounge.in/image/".$valuen->image;
$cutimage = str_replace(' ', '%20', $cutimage);
if($valuen->price){$shopprodprice=$valuen->price;}

 						
			$totalval=$totalval+round($shopprodprice);
 

         							$shopbag.='<tr width="100%" style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;"><td style="text-align:left; width:15%;"><img class="front" src="'.$cutimage.'" style="height:40px; width:40px;"></td>
<td style="text-align:left; width:40%;"><p>'.$valuen->name.'</p>';$optvalabuser='';

if($option_value){ $shopbag.='<p><span>- Size : '.$option_value.'</span></p>'; }
$shopbag.='</td>
<td style="text-align:left; width:15%">* '.$valuen->quantity.'</td>
<td style="text-align:right; width:15%"><img src="https://gofootlounge.in/image/data/Social%20Icons/IndianRupee.png" style="height:8px; width:8px;"> '.round($shopprodprice).'</td>
<td style="text-align:right; width:15%"><img src="https://gofootlounge.in/image/data/Social%20Icons/IndianRupee.png" style="height:8px;width:8px;"> '.round($shopprodprice).'</td>
</tr>';


         						    //}

         						}
         }  

         $shopbag.='<tr style="background:#f0f0c3; "><td colspan="4" align="right">Sub-Total : </td><td style="float:right;"><img src="https://gofootlounge.in/image/data/Social%20Icons/IndianRupee.png" style="height:8px;width:8px;"> '.round($totalval).'</td></tr>
<tr style="background:#f0f0c3; "><td colspan="4" align="right">Total : </td><td style="float:right;"><img src="https://gofootlounge.in/image/data/Social%20Icons/IndianRupee.png" style="height:8px;width:8px;"> '.round($totalval).'</td></tr></tbody></table>'; 

} 


//get latest product list

$latestpros='';
$datatest = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 4
		);


//$this->load->model('catalog/product');
//$this->load->model('tool/image');
$productcinfos= $this->model_sale_order->getProductinfodetais($datatest);

$newarrivalProductIDS = explode(',', $this->config->get('featured_product'));

foreach ($productcinfos as $result) {
 

			$currProductID = $result['product_id'];
			$isNewArrivalKEY = in_array($currProductID, $newarrivalProductIDS);

			$productNewArrival = 0;

			if($isNewArrivalKEY)
			{
				$productNewArrival = 1;
			}
                        $image=$result['image'];
			/*if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}*/
                       $price =round($result['price'],2);						
			/*if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}*/
				 $special =round($result['special'],2);	
			/*if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}*/
			
			/*if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}*/

                       

		
		
			$this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'href'    	 => 'https://gofootlounge.in/index.php?route=product/product&amp;product_id='.$result['product_id'],
				'quantity' =>$result['quantity'],
				
			);
		}



$latestpros='<table class="col-xs-12 col-sm-12 col-md-12 removepadd" style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;width: 100%;padding: 0px !important; padding:5%; margin-top:12px; margin-bottom:50px;">

<tbody style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">
<tr width="100%" style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;">';

foreach($this->data['products'] as $info)
{
/*$search='x';
$pos = strrpos($info['thumb'], $search);

    if($pos !== false)
    {
        $subjectaa = substr_replace($info['thumb'], '220x180', $pos, strlen($search));
    }*/
$subjectaa=$info['thumb'];
$subjectaa = str_replace(' ', '%20', $subjectaa);
$subjectaa ="https://gofootlounge.in/image/".$subjectaa;
if($info['special']) $pricevali=$info['special']; else $pricevali=$info['price'];
 
  $latestpros.= '<td class="col-md-3 testssls" style="width:25%;"><p class="latcls" style="font-size:14px; text-align:center;"><img src="'.$subjectaa.'" style="height:50px; width:50px;" title="'.$name.'" class="product-image-zoom img-responsive"></p><p>'.$info['name'].'</p>
<p style="text-align:center;"><span><img src="https://gofootlounge.in/image/data/Social%20Icons/IndianRupee.png" style="height:8px;width:8px;"> '.round($pricevali).'</span></p>
<p style="text-align:center;">
<a style="color:#FFF !important; text-align:center; cursor:pointer;" href="'.$info['href'].'" class="shopnownbtn"><div style="cursor:pointer;"><button class="mybtnccls" style="height:35px; width:80%; color: #000;border: 2px solid #ccc !important; cursor:pointer;">Shop Now</button></div></a></p>
</td>';
} 

 $latestpros.='</tr>

</tbody></table>';
 

          $message='';

          $domain1 = strstr($mailid, '@',true);
	$changename= ucfirst($domain1);
         
        //shopping bag product list
       if($abuserid){
	$checkoutnowbtnval='https://gofootlounge.in/cart?abuserid='.$abuserid; } 
else{$checkoutnowbtnval='https://gofootlounge.in/';}
//echo 'http://'. $_SERVER['SERVER_NAME']."<br/>" . $_SERVER['REQUEST_URI']; 
/*
$url = "https://gofootlounge.in/discountmsg.html";
$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$contents = curl_exec($ch);
if (curl_errno($ch)) {
  echo curl_error($ch);
  echo "\n<br />";
  $contents = '';
} else {
  curl_close($ch);
}

if (!is_string($contents) || !strlen($contents)) {

$contents = '';
}
*/
        $message1= htmlentities(file_get_contents("https://gofootlounge.in/discountmsg.html"));   

        //$message1= htmlentities(file_get_contents("discountmsg.html"));  

 //$message1=$contents;
             
           if($discounttypen=='P'){
$discountdisn=$discountdisn.'%';
              $strn2=str_replace('ndispercent',$discountdisn,$message1);
} else if($discounttypen=='F')
{
$discountdisn='<img src="https://gofootlounge.in/image/data/Social%20Icons/IndianRupee.png" style="height:10px;width:10px;">'.$discountdisn;
              $strn2=str_replace('ndispercent',$discountdisn,$message1);  
}
              $strn3=str_replace('ndiscode',$discountcoden,$strn2);
             $str=str_replace('changecustomername',$changename,$strn3);
             $strn=str_replace('abusershoppingbag',$shopbag,$str);
              $strn1=str_replace('nhotpicksforyou',$latestpros,$strn);
              $strn2=str_replace('checkoutnowbtnval',$checkoutnowbtnval,$strn1); 
              $str1=html_entity_decode($strn2);  
            
         if($mailid)
        { 
         
        	$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        	$headers .= 'From: order@footlounge.in'."\r\n".
        	
        	//'CC: order@footlounge.in'.
    		//'Reply-To: '.$emailid."\r\n" .
    		'X-Mailer: PHP/' . phpversion();

        	// Create email headers$emailid
			
	      // if( mail('Pooja_khatri@yahoo.com', 'Email Notification Request Received', $str1, $headers))
	      if( mail($mailid, 'Alert! Your Cart item is on Discount', $str1, $headers))
	     { echo 1; } else echo 0;        
 
        }  
       
 
      } 
   public function getallcustomer() // get abandoned user list
        {
          $this->language->load('sale/order');
          //$this->language->get('heading_title')='Abandoned Users';

		$this->document->setTitle($this->language->get('Customers List'));

		$this->load->model('sale/order');

    	  $this->getallcustomerList();
            
        }
         
        protected function getallcustomerList() {

		if (isset($this->request->get['filter_usertype'])) {
			$filter_usertype = $this->request->get['filter_usertype'];
		} else {
			$filter_usertype = null;
		}
                if (isset($this->request->get['filter_cust_mailid'])) {
			$filter_cust_mailid = $this->request->get['filter_cust_mailid'];
		} else {
			$filter_cust_mailid = null;
		}

		/*if (isset($this->request->get['filter_userid'])) {
			$filter_userid= $this->request->get['filter_userid'];
		} else {
			$filter_userid = null;
		}

		
		
		if (isset($this->request->get['filter_order_date'])) {
			$filter_order_date = $this->request->get['filter_order_date'];
		} else {
			$filter_order_date = null;
		}


		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ab_cust_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}*/
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		} 
				
		$url = '';



		if (isset($this->request->get['filter_usertype'])) {
			$url .= '&filter_usertype=' . $this->request->get['filter_usertype'];
		}

		if (isset($this->request->get['filter_cust_mailid'])) {
			$url .= '&filter_cust_mailid=' . $this->request->get['filter_cust_mailid'];
		}

		/*if (isset($this->request->get['filter_userid'])) {
			$url .= '&filter_userid=' . $this->request->get['filter_userid'];
		}
											
		
		
		if (isset($this->request->get['filter_order_date'])) {
			$url .= '&filter_order_date=' . $this->request->get['filter_order_date'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}*/
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		/* $this->data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['insert'] = $this->url->link('sale/order/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('sale/order/delete', 'token=' . $this->session->data['token'] . $url, 'SSL'); */ 

		$this->data['orders'] = array();

		$data = array(
			'filter_usertype'        => $filter_usertype,
                        'filter_cust_mailid' => $filter_cust_mailid,
			/*'filter_userid'	     => $filter_userid,
			
			'filter_order_date'           => $filter_order_date,
			'sort'                   => $sort,
			'order'                  => $order,*/
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

                
		//if($data['filter_usertype']) {  } 

		$newresults = $this->model_sale_order->getallcusts($data);
                
                //$couponcodes= $this->model_sale_order->getcouponcodeinfos(); //get coupon code for abandoned user 
              
    	foreach ($newresults as $result) {

			/*$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);
			
			if (strtotime($result['date_added']) > strtotime('-' . (int)$this->config->get('config_order_edit') . ' day')) {
				$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('sale/order/update', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
				);
			}*/

                         if($result['userid']){
                         $username = 'Registered'; 
                         }
                         else
                         {$username ='Guest'; }

			$this->data['abusers'][] = array(
				/*'ab_cust_id'      => $result['ab_cust_id'],*/
				'userid'      => $result['userid'],
                                'usertype'    =>$username,
				'cust_mailid'        => $result['cust_mailid'],
				'mobileno' =>'',
				);
		}


                //get all registered customer list

                 $newresults2 = $this->model_sale_order->getallregcusts($data);
                
                //$couponcodes= $this->model_sale_order->getcouponcodeinfos(); //get coupon code for abandoned user 
              
    	        foreach ($newresults2 as $result2) {
                    // if(in_array($result1['os_mailid'],$this->data['abusers']))

                      $this->data['abusers'][] = array(
				/*'ab_cust_id'      => $result2['ab_cust_id'],*/
				'userid'      => $result2['customer_id'],
                                'usertype'    =>'Registered',
				'cust_mailid'        => $result2['email'],
				'mobileno' =>$result2['telephone'],
				);
                 
                }

                
                //get out of stockuser list
                $newresults1 = $this->model_sale_order->getalloscusts($data);
                
                //$couponcodes= $this->model_sale_order->getcouponcodeinfos(); //get coupon code for abandoned user 
              
    	        foreach ($newresults1 as $result1) {
                    // if(in_array($result1['os_mailid'],$this->data['abusers']))

                      $this->data['abusers'][] = array(
				/*'ab_cust_id'      => $result1['ab_cust_id'],*/
				'userid'      => '',
                                'usertype'    =>'Out Of Stock',
				'cust_mailid'        => $result1['os_mailid'],
				'mobileno' =>$result1['os_phoneno'],
				);
                 
                }

                $order_total = count( $this->data['abusers']);
              // print_r('<pre>'); print_r($this->data['abusers']); die; 
                
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_missing'] = $this->language->get('text_missing');

		$this->data['column_order_id'] = $this->language->get('column_order_id');
    	$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_date_modified'] = $this->language->get('column_date_modified');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_invoice'] = $this->language->get('button_invoice');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
											
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
                
		if (isset($this->request->get['page'])) {
                     $this->data['mypage']=$this->request->get['page'];
			$url .= '&page=' . $this->request->get['page'];
		}else { $this->data['mypage']='';}

		$this->data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$this->data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$this->data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$this->data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_usertype'])) {
			$url .= '&filter_usertype=' . $this->request->get['filter_usertype'];
		}
		
		/*if (isset($this->request->get['filter_cust_mailid'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}*/
											
		if (isset($this->request->get['filter_cust_mailid'])) {
			$url .= '&filter_cust_mailid=' . $this->request->get['filter_cust_mailid'];
		}
		
		/*if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}*/

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('tool/export/getallcustomer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
                
		$this->data['pagination'] = $pagination->render();

		$this->data['filter_usertype'] = $filter_usertype;
		$this->data['filter_cust_mailid'] = $filter_cust_mailid;
		/*$this->data['filter_cust_mailid'] = $filter_cust_mailid;
		$this->data['filter_order_date'] = $filter_order_date;
                $this->data['couponcodes'] = $couponcodes;*/
		$this->load->model('localisation/order_status');
          

    	//$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
       // $this->data['test12']="sdfdf";
       
    	//foreach ($results as $result) {
       // }

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/all_customer_list.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
  	}
    
}
?>
