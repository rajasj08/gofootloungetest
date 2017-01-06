<?php
class ControllerSalepurchasevoucher extends Controller {
    private $error = array();
    
	public function index() {
		$this->load->language('sale/purchasevoucher');
		
       
	   $this->document->setTitle($this->language->get('heading_title'));
       
	   $this->load->model('sale/purchasevoucher');

        if(isset($this->request->get['filter_order_id'])) {

            $filter_order_id = $this->request->get['filter_order_id'];

        }else {

            $filter_order_id = null;

        }
  
		
		if (isset($this->request->get['filter_code'])) {

			$filter_code = $this->request->get['filter_code'];

		}else {

			$filter_code = null;

		}

      
		
		if(isset($this->request->get['filter_to_email'])) {

            $filter_to_email = $this->request->get['filter_to_email'];

        }else {

            $filter_to_email = null;

        }
		
              
        
		if(isset($this->request->get['sort'])) {

            $sort = $this->request->get['sort'];

        }else {

            $sort = 'od.order_voucher_id';

        }
        if(isset($this->request->get['order'])) {

            $order = $this->request->get['order'];

        }else {

            $order = 'DESC';

        }
        if(isset($this->request->get['page'])) {

            $page = $this->request->get['page'];

        }else {

            $page = 1;

        }
       
	    $url = '';
		
		
		
        if(isset($this->request->get['filter_order_id'])) {

            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];

        }
 

		if (isset($this->request->get['filter_code'])) {

			$url .= '&filter_code=' . $this->request->get['filter_code'];

		}
	
      
		if(isset($this->request->get['filter_to_email'])) {

            $url .= '&filter_to_email =' . urlencode(html_entity_decode($this->request->get['filter_to_email'], ENT_QUOTES, 'UTF-8'));

        }
     
        if(isset($this->request->get['sort'])) {

            $url .= '&sort=' . $this->request->get['sort'];

        }
        if(isset($this->request->get['order'])) {

            $url .= '&order=' . $this->request->get['order'];

        }
        if(isset($this->request->get['page'])) {

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

            'href'      => $this->url->link('sale/purchasevoucher', 'token=' . $this->session->data['token'] . $url, 'SSL'),

            'separator' => ' :: '

        );
      

        $this->data['orders'] = array();
        $data = array(

            'filter_order_id'        => $filter_order_id,

          
			
			'filter_code'	     => $filter_code, 

            
			
			'filter_to_email'      => $filter_to_email,

            'sort'                   => $sort,

            'order'                  => $order,

            'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),

            'limit'                  => $this->config->get('config_admin_limit')

        );
       
	    
        
		$results = $this->model_sale_purchasevoucher->getOrders($data);
		
		$order_total = count($results);
		
       
	    foreach($results as $result) {
		
			
            $this->data['orders'][] = array(
				
				'order_voucher_id'     => $result['order_voucher_id'],
				
                'order_id'      	=> $result['order_id'],

				'description'      	=> $result['description'],	
				
				'code'   			=> $result['code'],
				
				
				'to_email'   		=> $result['to_email'],
				
				
				'amount'			=> $result['amount'],
				
				'info'		=> $this->url->link('sale/voucher/update', 'token=' . $this->session->data['token'] . '&voucher_id=' . $result['order_voucher_id'], 'SSL'),
				
				'orderinfo'		=> $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL'),
				
				
				
			
  
              );

        }
		
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_missing']    = $this->language->get('text_missing');
		$this->data['text_view']    = $this->language->get('text_view');
		$this->data['text_pdf']    = $this->language->get('text_pdf');
		$this->data['column_order_voucher_id']      = $this->language->get('column_order_voucher_id');
        $this->data['column_order_id']      = $this->language->get('column_order_id');

		$this->data['column_code']			= $this->language->get('column_code');
		$this->data['column_to_email']        = $this->language->get('column_to_email');
		
		$this->data['column_description']        = $this->language->get('column_description');
		$this->data['column_amount']        = $this->language->get('column_amount');
        
        $this->data['column_action']        = $this->language->get('column_action');
        $this->data['button_filter']  = $this->language->get('button_filter');
		$this->data['export_select'] = $this->url->link('sale/order/export', 'token=' . $this->session->data['token']. $url, 'SSL');
		
		$this->data['button_sendmail'] = $this->language->get('button_sendmail');
        $this->data['token'] = $this->session->data['token'];
       
	    if(isset($this->error['warning'])) {

            $this->data['error_warning'] = $this->error['warning'];

        }

        else {

            $this->data['error_warning'] = '';

        }
        if(isset($this->session->data['success'])) {

            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);

        }

        elseif(isset($this->session->data['error'])) {

            $this->data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);

        }else {

            $this->data['success'] = '';

        }
		$url = '';
         if(isset($this->request->get['filter_order_id'])) {

            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];

        }
        if(isset($this->request->get['filter_customer'])) {

            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));

        }

		if (isset($this->request->get['filter_code'])) {

			$url .= '&filter_code=' . $this->request->get['filter_code'];

		}
	
       
        if(isset($this->request->get['filter_to_email'])) {

            $url .= '&filter_to_email =' . urlencode(html_entity_decode($this->request->get['filter_to_email'], ENT_QUOTES, 'UTF-8'));

        }
	
        if($order == 'ASC') {

            $url .= '&order=DESC';

        }else {

            $url .= '&order=ASC';

        }
        if(isset($this->request->get['page'])) {

            $url .= '&page=' . $this->request->get['page'];

        }
		
        $this->data['sort_order']         = $this->url->link('sale/purchasevoucher', 'token=' . $this->session->data['token'] . '&sort=od.order_id' . $url, 'SSL');

    
		
        $this->data['sort_code']    = $this->url->link('sale/purchasevoucher', 'token=' . $this->session->data['token'] . '&sort=od.cdoe' . $url, 'SSL');
		
		
		$this->data['sort_to_email'] = $this->url->link('sale/purchasevoucher', 'token=' . $this->session->data['token'] . '&sort=od.to_email' . $url, 'SSL');
		
	
		

		
     
        $url = '';
        
		 if(isset($this->request->get['filter_order_id'])) {

            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];

        }
        if(isset($this->request->get['filter_customer'])) {

            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));

        }

		if (isset($this->request->get['filter_code'])) {

			$url .= '&filter_code=' . $this->request->get['filter_code'];

		}
	
           
		if(isset($this->request->get['filter_to_email'])) {

            $url .= '&filter_to_email =' . urlencode(html_entity_decode($this->request->get['filter_to_email'], ENT_QUOTES, 'UTF-8'));

        }
	
        if(isset($this->request->get['sort'])) {

            $url .= '&sort=' . $this->request->get['sort'];

        }
        if(isset($this->request->get['order'])) {

            $url .= '&order=' . $this->request->get['order'];

        }
		if(isset($this->request->get['page'])) {

            $url .= '&page=' . $this->request->get['page'];

        }
        $pagination        = new Pagination();

        $pagination->total = $order_total;

        $pagination->page  = $page;

        $pagination->limit = $this->config->get('config_admin_limit');

        $pagination->text  = $this->language->get('text_pagination');

        $pagination->url   = $this->url->link('sale/purchasevoucher', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        
		$this->data['pagination'] = $pagination->render();
		
        $this->data['filter_order_id']        = $filter_order_id;
     
        $this->data['filter_code']      = $filter_code;
      
		$this->data['filter_to_email']   = $filter_to_email;
	
		
        $this->data['sort']  = $sort;
        $this->data['order'] = $order;
		
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		array_unshift($this->data['stores'],array('store_id' => 0, 'name' => $this->config->get('config_name')));
				
        $this->template = 'sale/purchasevoucher.tpl';

        $this->children = array(

            'common/header',
            'common/footer'

        );
        $this->response->setOutput($this->render());
    }

	public function pending(){
		$this->load->language('sale/purchasevoucher');
       
	   $this->document->setTitle($this->language->get('pending_heading_title'));
       
	   $this->load->model('sale/purchasevoucher');

	

        if(isset($this->request->get['filter_order_id'])) {

            $filter_order_id = $this->request->get['filter_order_id'];

        }else {

            $filter_order_id = null;

        }
        if(isset($this->request->get['filter_customer_name'])) {

            $filter_customer_name = $this->request->get['filter_customer_name'];

        }else {

            $filter_customer_name = null;

        }
		
		if (isset($this->request->get['filter_order_status_id'])) {

			$filter_order_status_id = $this->request->get['filter_order_status_id'];

		}else {

			$filter_order_status_id = null;

		}
		if(isset($this->request->get['filter_customer_email'])) {

            $filter_customer_email = $this->request->get['filter_customer_email'];

        }else {

            $filter_customer_email = null;

        }
	
       if(isset($this->request->get['filter_storename'])) {

            $filter_storename = $this->request->get['filter_storename'];

        }else {

            $filter_storename = null;

        }       
        
		if(isset($this->request->get['sort'])) {

            $sort = $this->request->get['sort'];

        }else {

            $sort = 'id';

        }
        if(isset($this->request->get['order'])) {

            $order = $this->request->get['order'];

        }else {

            $order = 'DESC';

        }
        if(isset($this->request->get['page'])) {

            $page = $this->request->get['page'];

        }else {

            $page = 1;

        }
       
	    $url = '';
		
        if(isset($this->request->get['filter_order_id'])) {

            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];

        }
        if(isset($this->request->get['filter_customer_name'])) {

            $url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));

        }
		   if(isset($this->request->get['filter_storename'])) {

            $url .= '&filter_storename =' . urlencode(html_entity_decode($this->request->get['filter_storename'], ENT_QUOTES, 'UTF-8'));

        }

		if (isset($this->request->get['filter_order_status_id'])) {

			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];

		}
	
		if(isset($this->request->get['filter_customer_email'])) {

            $url .= '&filter_customer_email =' . urlencode(html_entity_decode($this->request->get['filter_customer_email'], ENT_QUOTES, 'UTF-8'));

        }
       
        if(isset($this->request->get['sort'])) {

            $url .= '&sort=' . $this->request->get['sort'];

        }
        if(isset($this->request->get['order'])) {

            $url .= '&order=' . $this->request->get['order'];

        }
        if(isset($this->request->get['page'])) {

            $url .= '&page=' . $this->request->get['page'];

        }
        $this->data['breadcrumbs'] = array();
        
		$this->data['breadcrumbs'][] = array(

            'text'      => $this->language->get('text_home'),

            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),

            'separator' => false

        );
        $this->data['breadcrumbs'][] = array(

            'text'      => $this->language->get('pending_heading_title'),

            'href'      => $this->url->link('sale/purchasevoucher/pending', 'token=' . $this->session->data['token'] . $url, 'SSL'),

            'separator' => ' :: '

        );
      

        $this->data['orderspending'] = array();
        
		$data = array(

            'filter_order_id'        => $filter_order_id,
              'filter_storename'        => $filter_storename,
          	
			'filter_order_status_id'	     	  => $filter_order_status_id, 

            'filter_customer_name'      => $filter_customer_name,
			
			'filter_customer_email'      => $filter_customer_email,

            'sort'                   => $sort,

            'order'                  => $order,

            'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),

            'limit'                  => $this->config->get('config_admin_limit')

        );
       
	    
        
		$results = $this->model_sale_purchasevoucher->pendingvouchers($data);
		
	
		
		
		$order_total = count($results);
		
       
	    foreach($results as $result) {
		
			
            $this->data['orderspending'][] = array(
				
				
				
                'order_id'      	=> $result['order_id'],          
				
			
				
				'status'   			=> $result['order_status'],		
				
				'customer_email'   		=> $result['customer_email'],				
				'customer_name'   		=> $result['customer_name'],	
				'storename'   		=> $result['storename'],				
					'orderinfo'   		=> $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			
				
			
				
				
  
              );

        }
		
        $this->data['heading_title'] = $this->language->get('pending_heading_title');
        $this->data['column_customer_name'] = $this->language->get('column_customer_name');
        $this->data['column_order_status'] = $this->language->get('column_order_status');
        $this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_missing']    = $this->language->get('text_missing');
		$this->data['text_view']    = $this->language->get('text_view');
		$this->data['text_pdf']    = $this->language->get('text_pdf');
		$this->data['column_storename']        = $this->language->get('column_storename');
		$this->data['column_order_voucher_id']      = $this->language->get('column_order_voucher_id');
        $this->data['column_order_id']      = $this->language->get('column_order_id');
       	$this->data['column_to_email']        = $this->language->get('column_to_email');
		$this->data['column_action']        = $this->language->get('column_action');
        $this->data['button_filter']  = $this->language->get('button_filter');
		$this->data['export_select'] = $this->url->link('sale/order/export', 'token=' . $this->session->data['token']. $url, 'SSL');
		
		$this->data['button_sendmail'] = $this->language->get('button_sendmail');
        $this->data['token'] = $this->session->data['token'];
       
	   
	    if(isset($this->error['warning'])) {

            $this->data['error_warning'] = $this->error['warning'];

        }else {

            $this->data['error_warning'] = '';

        }
        if(isset($this->session->data['success'])) {

            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);

        }

        elseif(isset($this->session->data['error'])) {

            $this->data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);

        }else {

            $this->data['success'] = '';

        }
		 $url = '';
		
        if(isset($this->request->get['filter_order_id'])) {

            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];

        }
        if(isset($this->request->get['filter_customer_name'])) {

            $url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));

        }

		if (isset($this->request->get['filter_order_status_id'])) {

			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];

		}
		        if(isset($this->request->get['filter_storename'])) {

            $url .= '&filter_storename =' . urlencode(html_entity_decode($this->request->get['filter_storename'], ENT_QUOTES, 'UTF-8'));

        }
	
		if(isset($this->request->get['filter_customer_email'])) {

            $url .= '&filter_customer_email =' . urlencode(html_entity_decode($this->request->get['filter_customer_email'], ENT_QUOTES, 'UTF-8'));

        }
     
        if(isset($this->request->get['sort'])) {

            $url .= '&sort=' . $this->request->get['sort'];

        }
        if($order == 'ASC') {

            $url .= '&order=DESC';

        }else {

            $url .= '&order=ASC';

        }
        if(isset($this->request->get['page'])) {

            $url .= '&page=' . $this->request->get['page'];

        }
		
        $this->data['sort_order']         = $this->url->link('sale/purchasevoucher/pending', 'token=' . $this->session->data['token'] . '&sort=dp.order_id' . $url, 'SSL');

        $this->data['sort_customer_name']      = $this->url->link('sale/purchasevoucher/pending', 'token=' . $this->session->data['token'] . '&sort=dp.customer_name' . $url, 'SSL');
		
        $this->data['sort_customer_email']    = $this->url->link('sale/purchasevoucher/pending', 'token=' . $this->session->data['token'] . '&sort=dp.customer_email' . $url, 'SSL');
		
		$this->data['sort_storename'] = $this->url->link('sale/purchasevoucher/pending', 'token=' . $this->session->data['token'] . '&sort=dp.storename' . $url, 'SSL');		
		
		$this->data['sort_status'] = $this->url->link('sale/purchasevoucher/pending', 'token=' . $this->session->data['token'] . '&sort=dp.order_status_id' . $url, 'SSL');
		
		
      $url = '';
		
        if(isset($this->request->get['filter_order_id'])) {

            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];

        }
        if(isset($this->request->get['filter_customer_name'])) {

            $url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));

        }

		if (isset($this->request->get['filter_order_status_id'])) {

			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];

		}
	
	    if(isset($this->request->get['filter_storename'])) {

            $url .= '&filter_storename =' . urlencode(html_entity_decode($this->request->get['filter_storename'], ENT_QUOTES, 'UTF-8'));

        }
		if(isset($this->request->get['filter_customer_email'])) {

            $url .= '&filter_customer_email =' . urlencode(html_entity_decode($this->request->get['filter_customer_email'], ENT_QUOTES, 'UTF-8'));

        }
      
        if(isset($this->request->get['sort'])) {

            $url .= '&sort=' . $this->request->get['sort'];

        }
        if(isset($this->request->get['order'])) {

            $url .= '&order=' . $this->request->get['order'];

        }
        if(isset($this->request->get['page'])) {

            $url .= '&page=' . $this->request->get['page'];

        }
        $pagination        = new Pagination();

        $pagination->total = $order_total;

        $pagination->page  = $page;

        $pagination->limit = $this->config->get('config_admin_limit');

        $pagination->text  = $this->language->get('text_pagination');

        $pagination->url   = $this->url->link('sale/purchasevoucher', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        
		$this->data['pagination'] = $pagination->render();
		
        $this->data['filter_order_id'] = $filter_order_id;
        $this->data['filter_customer_name']  = $filter_customer_name;
        $this->data['filter_order_status_id']  = $filter_order_status_id;
		$this->data['filter_customer_email'] = $filter_customer_email;
		
        $this->data['sort']  = $sort;
        $this->data['order'] = $order;
		
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		array_unshift($this->data['stores'],array('store_id' => 0, 'name' => $this->config->get('config_name')));
		
		$this->load->model('localisation/order_status');

    	$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
				
        $this->template = 'sale/purchasevoucher_pending.tpl';

        $this->children = array(

            'common/header',
            'common/footer'

        );
        $this->response->setOutput($this->render());
	}    
}
?>