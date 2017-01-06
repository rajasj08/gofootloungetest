<?php
class ControllerModulepurchasevoucher extends Controller {
	private $error = array(); 
	
	public function index() {  

	$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product` WHERE 1;");
		
		$check = 0;

		foreach($query->rows as $rows) {

						if($rows['Field'] == 'voucher' )///column name

										$check = 1;

		}
//$check =0;
		if($check == 0){

	
	$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "voucher_pending` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `customer_email` varchar(225) NOT NULL,
  `customer_name` varchar(225) NOT NULL,
  `order_currency_code` varchar(225) NOT NULL,
  `order_currency_value` varchar(225) NOT NULL,
  `storename` varchar(10) NOT NULL,
  `storeurl` varchar(255) NOT NULL,
  `storelogo` varchar(255) NOT NULL,
  `order_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `configemail` varchar(225) NOT NULL,
  `vemail` varchar(225) NOT NULL,
  `vname` varchar(225) NOT NULL,

  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;");

$this->db->query("ALTER TABLE  `" . DB_PREFIX . "product` ADD  `voucher` INT(1) NULL;");
$this->db->query("ALTER TABLE  `" . DB_PREFIX . "product` ADD  `voucheramount` DECIMAL( 15, 4 ) NULL;");
$this->db->query("ALTER TABLE  `" . DB_PREFIX . "order_voucher` ADD  `product_id` INT(11) NULL;");


}
	
		$this->load->language('module/purchasevoucher');

		$this->document->setTitle($this->language->get('title'));
		
		$this->load->model('setting/setting');
		
		$this->init();
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {

			
	if(!empty($this->request->post['purchasevoucher_payment_methods_array'])){
		$this->request->post['purchasevoucher_payment_methods'] = implode('|',$this->request->post['purchasevoucher_payment_methods_array']);
  	}else{
		$this->request->post['purchasevoucher_payment_methods'] = NULL;
	}
			
		if(!empty($this->request->post['purchasevoucher_total_methods_array'])){
		$this->request->post['purchasevoucher_total_methods'] = implode('|',$this->request->post['purchasevoucher_total_methods_array']);
  	}else{
		$this->request->post['purchasevoucher_total_methods'] = NULL;
	}

			$this->model_setting_setting->editSetting('purchasevoucher', $this->request->post);		
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
					$this->session->data['success'] = $this->language->get('text_success');
			
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_title2'] = $this->language->get('heading_title2');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['force_payment_method'] = $this->language->get('force_payment_method');
		$this->data['force_total_method'] = $this->language->get('force_total_method');
		$this->data['entry_enabled'] = $this->language->get('entry_enabled');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['entry_transaction_id'] = $this->language->get('entry_transaction_id');
		$this->data['text_licence_info'] = $this->language->get('text_licence_info');
		$this->data['entry_transaction_email'] = $this->language->get('entry_transaction_email');
		$this->data['text_info'] = $this->language->get('text_info');
		$this->data['tab_support'] = $this->language->get('tab_support');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['entry_mailtemplate'] = $this->language->get('entry_mailtemplate');
		$this->data['entry_general'] = $this->language->get('entry_general');
		$this->data['entry_mail'] = $this->language->get('entry_mail');
		$this->data['entry_support'] = $this->language->get('entry_support');
		$this->data['entry_mailtemplate'] = $this->language->get('entry_mailtemplate');
		$this->data['entry_mail_customer'] = $this->language->get('entry_mail_customer');
		$this->data['entry_mail_admin'] = $this->language->get('entry_mail_admin');
		$this->data['entry_subject_admin'] = $this->language->get('entry_subject_admin');
		$this->data['entry_subject_customer'] = $this->language->get('entry_subject_customer');
		$this->data['entry_voucherdetail'] = $this->language->get('entry_voucherdetail');
		$this->data['entry_mail_gift'] = $this->language->get('entry_mail_gift');
		$this->data['entry_subject_gift'] = $this->language->get('entry_subject_gift');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['payment_status'] = $this->language->get('payment_status');
	  
	
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/purchasevoucher', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/purchasevoucher', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

	

   	
    $this->data['entry_code'] = $this->language->get('entry_code');
	$this->data['entry_reedem'] = $this->language->get('entry_reedem');		
    $this->data['entry_url'] = $this->language->get('entry_url');
	
    $this->data['entry_points'] = $this->language->get('entry_points');
	$this->data['entry_prefix'] = $this->language->get('entry_prefix');
	$this->data['entry_status'] = $this->language->get('entry_status');		
	$this->data['entry_emailno'] = $this->language->get('entry_emailno');
   $this->data['entry_message'] = $this->language->get('entry_message');		


	$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();
		$this->data['languages'] = $languages;
		
			$this->data['purchasevoucher_autosubject'] = array();
	$this->data['purchasevoucher_automail'] = array();
	$this->data['purchasevoucher_voucherdetail'] = array();
		foreach($this->data['languages'] as $language){
		
		 if(isset($this->request->post['purchasevoucher_autosubject_'.$language['language_id'].'_customer'])){
		$this->data['purchasevoucher_autosubject'][$language['language_id']]['customer'] = $this->request->post['purchasevoucher_autosubject_'.$language['language_id'].'_customer'];
	   }else{		
		if ($this->config->get('purchasevoucher_autosubject_'.$language['language_id'].'_customer')){
		 
		    $this->data['purchasevoucher_autosubject'][$language['language_id']]['customer'] = $this->config->get('purchasevoucher_autosubject_'.$language['language_id'].'_customer');
  
		}else{
		     $this->data['purchasevoucher_autosubject'][$language['language_id']]['customer'] = $this->language->get('purchasevoucher_autosubject_customer');
     		}}
			
				 if(isset($this->request->post['purchasevoucher_autosubject_'.$language['language_id'].'_gift'])){
		$this->data['purchasevoucher_autosubject'][$language['language_id']]['gift'] = $this->request->post['purchasevoucher_autosubject_'.$language['language_id'].'_gift'];
	   }else{		
		if ($this->config->get('purchasevoucher_autosubject_'.$language['language_id'].'_gift')){
		 
		    $this->data['purchasevoucher_autosubject'][$language['language_id']]['gift'] = $this->config->get('purchasevoucher_autosubject_'.$language['language_id'].'_gift');
  
		}else{
		     $this->data['purchasevoucher_autosubject'][$language['language_id']]['gift'] = $this->language->get('purchasevoucher_autosubject_gift');
     		}}
			
					 if(isset($this->request->post['purchasevoucher_autosubject_'.$language['language_id'].'_admin'])){
		$this->data['purchasevoucher_autosubject'][$language['language_id']]['admin'] = $this->request->post['purchasevoucher_autosubject_'.$language['language_id'].'_admin'];
	   }else{		
		if ($this->config->get('purchasevoucher_autosubject_'.$language['language_id'].'_admin')){
		 
		    $this->data['purchasevoucher_autosubject'][$language['language_id']]['admin'] = $this->config->get('purchasevoucher_autosubject_'.$language['language_id'].'_admin');
  
		}else{
		     $this->data['purchasevoucher_autosubject'][$language['language_id']]['admin'] = $this->language->get('purchasevoucher_autosubject_admin');
     		}}
			
			
			 if(isset($this->request->post['purchasevoucher_automail_'.$language['language_id'].'_customer'])){
		$this->data['purchasevoucher_automail'][$language['language_id']]['customer'] = $this->request->post['purchasevoucher_automail_'.$language['language_id'].'_customer'];
	   }else{		
		if ($this->config->get('purchasevoucher_automail_'.$language['language_id'].'_customer')){
		 
		    $this->data['purchasevoucher_automail'][$language['language_id']]['customer'] = $this->config->get('purchasevoucher_automail_'.$language['language_id'].'_customer');
  
		}else{
		     $this->data['purchasevoucher_automail'][$language['language_id']]['customer'] = $this->language->get('purchasevoucher_automail_customer');
     		}}	
			
				 if(isset($this->request->post['purchasevoucher_automail_'.$language['language_id'].'_gift'])){
		$this->data['purchasevoucher_automail'][$language['language_id']]['gift'] = $this->request->post['purchasevoucher_automail_'.$language['language_id'].'_gift'];
	   }else{		
		if ($this->config->get('purchasevoucher_automail_'.$language['language_id'].'_gift')){
		 
		    $this->data['purchasevoucher_automail'][$language['language_id']]['gift'] = $this->config->get('purchasevoucher_automail_'.$language['language_id'].'_gift');
  
		}else{
		     $this->data['purchasevoucher_automail'][$language['language_id']]['gift'] = $this->language->get('purchasevoucher_automail_gift');
     		}}	
			
				 if(isset($this->request->post['purchasevoucher_automail_'.$language['language_id'].'_admin'])){
		$this->data['purchasevoucher_automail'][$language['language_id']]['admin'] = $this->request->post['purchasevoucher_automail_'.$language['language_id'].'_admin'];
	   }else{		
		if ($this->config->get('purchasevoucher_automail_'.$language['language_id'].'_admin')){
		 
		    $this->data['purchasevoucher_automail'][$language['language_id']]['admin'] = $this->config->get('purchasevoucher_automail_'.$language['language_id'].'_admin');
  
		}else{
		     $this->data['purchasevoucher_automail'][$language['language_id']]['admin'] = $this->language->get('purchasevoucher_automail_admin');
     		}}
		
				 if(isset($this->request->post['purchasevoucher_voucherdetail_'.$language['language_id'].'_line'])){
		$this->data['purchasevoucher_voucherdetail'][$language['language_id']]['line'] = $this->request->post['purchasevoucher_voucherdetail_'.$language['language_id'].'_line'];
	   }else{		
		if ($this->config->get('purchasevoucher_voucherdetail_'.$language['language_id'].'_line')){
		 
		    $this->data['purchasevoucher_voucherdetail'][$language['language_id']]['line'] = $this->config->get('purchasevoucher_voucherdetail_'.$language['language_id'].'_line');
  
		}else{
		     $this->data['purchasevoucher_voucherdetail'][$language['language_id']]['line'] = $this->language->get('purchasevoucher_voucherdetail');
     		}}
		
			 if(isset($this->request->post['purchasevoucher_message_'.$language['language_id'].'_line'])){
		$this->data['purchasevoucher_message'][$language['language_id']]['line'] = $this->request->post['purchasevoucher_message_'.$language['language_id'].'_line'];
	   }else{		
		if ($this->config->get('purchasevoucher_message_'.$language['language_id'].'_line')){
		 
		    $this->data['purchasevoucher_message'][$language['language_id']]['line'] = $this->config->get('purchasevoucher_message_'.$language['language_id'].'_line');
  
		}else{
		     $this->data['purchasevoucher_message'][$language['language_id']]['line'] = $this->language->get('purchasevoucher_message');
     		}}

		
		}

		
				
		 if(isset($this->request->post['purchasevoucher_emailno'])){
 
			$this->data['purchasevoucher_emailno'] = $this->request->post['purchasevoucher_emailno'];
	  
	    }else{
		
		if ($this->config->get('purchasevoucher_emailno')){
		    
		    $this->data['purchasevoucher_emailno'] = $this->config->get('purchasevoucher_emailno'); 
	      
		}else{
		    
		    $this->data['purchasevoucher_emailno'] = '1';
		}}
		

		
		 if(isset($this->request->post['purchasevoucher_prefix'])){
 
			$this->data['purchasevoucher_prefix'] = $this->request->post['purchasevoucher_prefix'];
	  
	    }else{
		
		if ($this->config->get('purchasevoucher_prefix')){
		    
		    $this->data['purchasevoucher_prefix'] = $this->config->get('purchasevoucher_prefix'); 
	      
		}else{
		    
		    $this->data['purchasevoucher_prefix'] = 'PURV';
		}}
		
		
		
		 if(isset($this->request->post['purchasevoucher_points'])){
 
			$this->data['purchasevoucher_points'] = $this->request->post['purchasevoucher_points'];
	  
	    }else{
		
		if ($this->config->get('purchasevoucher_points')){
		    
		    $this->data['purchasevoucher_points'] = $this->config->get('purchasevoucher_points'); 
	      
		}else{
		    
		    $this->data['purchasevoucher_points'] = '0';
		}}


if (isset($this->request->post['purchasevoucher_status'])) {
			$this->data['purchasevoucher_status'] = $this->request->post['purchasevoucher_status'];
		} else {
			$this->data['purchasevoucher_status'] = $this->config->get('purchasevoucher_status');
		}
		

		
		
		if (isset($this->request->post['purchasevoucher_reedem'])) {
			$this->data['purchasevoucher_reedem'] = $this->request->post['purchasevoucher_reedem'];
		} else {
			$this->data['purchasevoucher_reedem'] = $this->config->get('purchasevoucher_reedem');
		}

	if (isset($this->request->post['purchasevoucher_transaction_id'])) {
			$this->data['purchasevoucher_transaction_id'] = $this->request->post['purchasevoucher_transaction_id'];
		} else {
			$this->data['purchasevoucher_transaction_id'] = $this->config->get('purchasevoucher_transaction_id');
		}
		

		
			if (isset($this->request->post['purchasevoucher_payment_limit'])) {
			$this->data['purchasevoucher_payment_limit'] = $this->request->post['purchasevoucher_payment_limit'];
		} else {
			$this->data['purchasevoucher_payment_limit'] = $this->config->get('purchasevoucher_payment_limit');
		}
			if (isset($this->request->post['purchasevoucher_total_limit'])) {
			$this->data['purchasevoucher_total_limit'] = $this->request->post['purchasevoucher_total_limit'];
		} else {
			$this->data['purchasevoucher_total_limit'] = $this->config->get('purchasevoucher_total_limit');
		}
		
		if (isset($this->request->post['purchasevoucher_payment_methods'])) {
			$this->data['purchasevoucher_payment_methods'] = $this->request->post['purchasevoucher_payment_methods'];
		} else {
			$this->data['purchasevoucher_payment_methods'] = $this->config->get('purchasevoucher_payment_methods');
		}
				if (isset($this->request->post['purchasevoucher_total_methods'])) {
			$this->data['purchasevoucher_total_methods'] = $this->request->post['purchasevoucher_total_methods'];
		} else {
			$this->data['purchasevoucher_total_methods'] = $this->config->get('purchasevoucher_total_methods');
		}
	
	$this->load->model('localisation/order_status');
		$this->data['orderstatus'] = $this->model_localisation_order_status->getOrderStatuses();
		
		
		if (isset($this->request->post['purchasevoucher_orderstatus'])) {
			$this->data['purchasevoucher_orderstatus'] = $this->request->post['purchasevoucher_orderstatus'];
		} elseif ($this->config->get('purchasevoucher_orderstatus')) { 
			$this->data['purchasevoucher_orderstatus'] = $this->config->get('purchasevoucher_orderstatus');
		}
		else {$this->data['purchasevoucher_orderstatus'] = 5; }
	     
		
	$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->data['modules'] = array();
				
		if (isset($this->request->post['purchasevoucher_module'])) {
			$this->data['modules'] = $this->request->post['purchasevoucher_module'];
		} elseif ($this->config->get('purchasevoucher_module')) { 
			$this->data['modules'] = $this->config->get('purchasevoucher_module');
		}
		$this->data['token'] = $this->session->data['token'];
		
		$this->template = 'module/purchasevoucher.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
		private function init() {
		$var='purchasevoucher';
		$name='Sell product as Voucher';
		$module='purchasevoucher';
	
		      eval(base64_decode('aWYgKCEkdGhpcy0+Y29uZmlnLT5nZXQoJ3B1cmNoYXNldm91Y2hlcl90cmFuc2FjdGlvbl9pZCcpKSB7IGlmICgkdGhpcy0+cmVxdWVzdC0+c2VydmVyWydSRVFVRVNUX01FVEhPRCddID09ICdQT1NUJyAmJiBpc3NldCgkdGhpcy0+cmVxdWVzdC0+cG9zdFsncHVyY2hhc2V2b3VjaGVyX3RyYW5zYWN0aW9uX2lkJ10pICYmICR0aGlzLT5yZXF1ZXN0LT5wb3N0WydwdXJjaGFzZXZvdWNoZXJfdHJhbnNhY3Rpb25faWQnXSAmJiBpc3NldCgkdGhpcy0+cmVxdWVzdC0+cG9zdFsnZW1haWwnXSkgJiYgZmlsdGVyX3ZhcigkdGhpcy0+cmVxdWVzdC0+cG9zdFsnZW1haWwnXSwgRklMVEVSX1ZBTElEQVRFX0VNQUlMKSkgeyAkc3RvcmVfaW5mbyA9ICR0aGlzLT5tb2RlbF9zZXR0aW5nX3NldHRpbmctPmdldFNldHRpbmcoJ2NvbmZpZycsIDApOyAkaGVhZGVycyA9ICdNSU1FLVZlcnNpb246IDEuMCcgLiAiXHJcbiI7ICRoZWFkZXJzIC49ICdDb250ZW50LXR5cGU6IHRleHQvaHRtbDsgY2hhcnNldD1pc28tODg1OS0xJyAuICJcclxuIjsgJGhlYWRlcnMgLj0gJ1RvOiBLb2RlY3ViZUxpY2Vuc29yICcgLiAiXHJcbiI7ICRoZWFkZXJzIC49ICdGcm9tOiAnIC4gJHN0b3JlX2luZm9bJ2NvbmZpZ19uYW1lJ10gLiAnIDwnIC4gJHN0b3JlX2luZm9bJ2NvbmZpZ19lbWFpbCddIC4gJz4nIC4gIlxyXG4iOyAkc2VydmVyID0gZXhwbG9kZSgnLycsIHJ0cmltKEhUVFBfU0VSVkVSLCAnLycpKTsgYXJyYXlfcG9wKCRzZXJ2ZXIpOyAkc2VydmVyID0gaW1wbG9kZSgnLycsICRzZXJ2ZXIpOyBAbWFpbCgnc3VwcG9ydEBrb2RlY3ViZS5jb20nLCAnTmV3IFJlZ2lzdHJhdGlvbiAnIC4gJHNlcnZlciwgIlRoZSAkc2VydmVyIHdpdGggb3JkZXI6ICIgLiAkdGhpcy0+cmVxdWVzdC0+cG9zdFsncHVyY2hhc2V2b3VjaGVyX3RyYW5zYWN0aW9uX2lkJ10gLiAiIGFuZCBlLW1haWw6ICIgLiAkdGhpcy0+cmVxdWVzdC0+cG9zdFsnZW1haWwnXSAuICIgaGFzIGFjdGl2YXRlZCBhIG5ldyBsaWNlbmNlIGZvciBtb2R1bGU6IiAuICRuYW1lIC4gIi4iLCAkaGVhZGVycyk7IA0KJHRoaXMtPmxvYWQtPm1vZGVsKCdzZXR0aW5nL3NldHRpbmcnKTsNCiR0aGlzLT5tb2RlbF9zZXR0aW5nX3NldHRpbmctPmVkaXRTZXR0aW5nKCR2YXIsICR0aGlzLT5yZXF1ZXN0LT5wb3N0KTsJCQ0KDQogJHRoaXMtPnJlZGlyZWN0KCR0aGlzLT51cmwtPmxpbmsoJ21vZHVsZS8nIC4gJG1vZHVsZSwgJ3Rva2VuPScgLiAkdGhpcy0+c2Vzc2lvbi0+ZGF0YVsndG9rZW4nXSwgJ1NTTCcpKTsgfSAkdGhpcy0+ZGF0YVsndGV4dF9saWNlbmNlX2luZm8nXSA9ICR0aGlzLT5sYW5ndWFnZS0+Z2V0KCd0ZXh0X2xpY2VuY2VfaW5mbycpOyAkdGhpcy0+ZGF0YVsnZW50cnlfdHJhbnNhY3Rpb25faWQnXSA9ICR0aGlzLT5sYW5ndWFnZS0+Z2V0KCdlbnRyeV90cmFuc2FjdGlvbl9pZCcpOyAkdGhpcy0+ZGF0YVsnZW50cnlfdHJhbnNhY3Rpb25fZW1haWwnXSA9ICR0aGlzLT5sYW5ndWFnZS0+Z2V0KCdlbnRyeV90cmFuc2FjdGlvbl9lbWFpbCcpOyAkdGhpcy0+ZGF0YVsndmFsaWRhdGlvbiddID0gdHJ1ZTsgJHRoaXMtPnRlbXBsYXRlID0gJ21vZHVsZS8nIC4gJG1vZHVsZSAuICcudHBsJzsgJHRoaXMtPmNoaWxkcmVuID0gYXJyYXkoICdjb21tb24vaGVhZGVyJywgJ2NvbW1vbi9mb290ZXInLCApOyAkdGhpcy0+cmVzcG9uc2UtPnNldE91dHB1dCgkdGhpcy0+cmVuZGVyKCkpOyB9'));
	
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/purchasevoucher')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
			if (isset($this->request->post['purchasevoucher_module'])) {
			foreach ($this->request->post['purchasevoucher_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}	
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>