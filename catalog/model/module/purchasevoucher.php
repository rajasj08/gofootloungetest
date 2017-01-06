<?php
class Modelmodulepurchasevoucher extends Model {

	public function getvoucherProducts($limit) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
			$product_data = array();	
		$product_data = $this->cache->get('product.voucher.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $customer_group_id . '.' . (int)$limit);

		if (!$product_data) { 
		
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.voucher='1' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);
			
		 	 $this->load->model('catalog/product');
			 
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
			}
			
			$this->cache->set('product.voucher.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit, $product_data);
		}
		
		return $product_data;
	}

public function fetchorder($order_id) {
  	   
	  $query=$this->db->query("SELECT * FROM " . DB_PREFIX . "voucher_pending where order_id='".$order_id."'");
	  return $query->row;
	
	}

	public function sendvoucher($order_id,$custemail,$custname,$storename,$order_status_id,$order_currency_code, $order_currency_value,$language_id,$storeurl,$configemail,$call) {
		
	
		if($order_status_id == $this->config->get('purchasevoucher_orderstatus')){
  		if($this->config->get('purchasevoucher_status')=='1'){
					
		
			  
			if($call == "0"){
			 $vemailpull=$this->db->query("SELECT vname,vemail FROM " . DB_PREFIX . "voucher_pending where order_id='".$order_id."'");
			 
			 if($vemailpull->row['vemail']) {
			 $_SESSION['vname'] = $vemailpull->row['vname'];
             $_SESSION['vemail'] = $vemailpull->row['vemail'];
			}
			}
			
				$message = html_entity_decode($this->config->get('purchasevoucher_message_'.$language_id.'_line'), ENT_QUOTES, 'UTF-8');
	
		
		
		
	
		
			$amountf=array();
			$imagepath=array();	
			$amountf[1]=0;
			$p=1;
			
			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
				
			foreach ($order_product_query->rows as $order_product) {
			
				
			    $variab = $this->db->query("SELECT voucheramount, image, voucher FROM " . DB_PREFIX . "product WHERE product_id='" . (int)$order_product['product_id'] . "'");
						
						
				$desc[$p] =$this->db->query("SELECT description FROM " . DB_PREFIX . "product_description WHERE product_id='" . (int)$order_product['product_id'] . "' AND language_id='" . (int)$language_id . "'");
		
			
				$desc[$p] = strip_tags($desc[$p]->row['description']);
				 
				/* Decode HTML entities */
				$desc[$p] = html_entity_decode( $desc[$p], ENT_QUOTES, "utf-8" );
				
					
				
		
				if ($variab->row['voucher']>0 ) {
				
					$product_id[$p] = $order_product['product_id'];
					
					$imagepath[$p] = $variab->row['image'];
					$amountf[$p] =  $variab->row['voucheramount']*$order_product['quantity'];
					
					$imagepath[$p]  = sprintf( $storeurl."/image/".$imagepath[$p]);
				
				
				
						$p= $p+1;
						
						
				}
					$limit= count($amountf);
						
			}
				
			
			if ($amountf[1]>0) {
				
				$mail_voucherdetailoop = html_entity_decode($this->config->get('purchasevoucher_voucherdetail_'.$language_id.'_line'), ENT_QUOTES, 'UTF-8');
				$mail_voucherdetail = html_entity_decode($this->config->get('purchasevoucher_voucherdetail_'.$language_id.'_line'), ENT_QUOTES, 'UTF-8');
			for ($p=1; $p<=$limit; $p++)	 {
				for ($i=1; $i<=$this->config->get('purchasevoucher_emailno'); $i++)	 {
					$random_id_length = 6; 
					$rnd_id = crypt(uniqid(rand(),1)); 	
					$rnd_id = strip_tags(stripslashes($rnd_id)); 
	
					if($this->config->get('purchasevoucher_status')=='1'){
	
						$rnd_id = str_replace(".","",$rnd_id); 
						$rnd_id = strrev(str_replace("/","",$rnd_id));  
						$rnd_id = substr($rnd_id,0,$random_id_length); 
						
						$prefix_length = 4; 
						$prefix = substr($this->config->get('purchasevoucher_prefix'),0,$prefix_length); 
						
						
	                 		if (isset($_SESSION['vemail'])) {
							
							$toemail=$_SESSION['vemail'];
							
							}
							else
							{
							
							$toemail=$custemail;
							
							}
							
							 if (isset($_SESSION['vname'])) {
							 $toname=$_SESSION['vname'];
							 }
							 else
							 {
							 $toname=$custname;
							 }
						
						
						
	                    $vouchercode[$i]  = strtoupper(sprintf($prefix.''. $rnd_id));
						$this->db->query("INSERT INTO " . DB_PREFIX . "voucher SET code = '" .$vouchercode[$i]. "', from_name = '" .$custname. "', 
						from_email = '" .$custemail. "', to_name = '" .$toname. "', 
						to_email = '" .$toemail. "', voucher_theme_id = '8', 
						message = '" .$message. "', amount = '" .$amountf[$p]."', 
						status = '1', date_added = NOW()");
	
						$voucher_id = $this->db->getLastId();
	
						$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "', product_id = '" . (int)$product_id[$p] . "', order_id = '" . (int)$order_id . "', description = '" . $message . "', code = '" . $vouchercode[$i] . "', from_name = '" . $custname . "', from_email = '" . $custemail . "', to_name = '" . $toname . "', to_email = '" . $toemail . "', voucher_theme_id = '8', message = '" . $message . "', amount = '" . $amountf[$p] . "'");
		
					   $productimage  = '<img style="padding: 1px; border: 1px solid #DDDDDD; height:300px; width:300px" src="'.$imagepath[$p].'" alt="'.$imagepath[$p].'" />';
	
	 
	$amountf[$p]=$this->currency->format($amountf[$p],$order_currency_code, $order_currency_value);
					
						
					  $mail_voucherdetail =str_replace('{voucher}', $vouchercode[$i], $mail_voucherdetail);
					  $mail_voucherdetail =str_replace('{voucheramount}', $amountf[$p], $mail_voucherdetail);
					  $mail_voucherdetail =str_replace('{productdescription}', $desc[$p], $mail_voucherdetail);
					  $mail_voucherdetail =str_replace('{productimage}', $productimage, $mail_voucherdetail);
					  $mail_voucherdetail =str_replace('{repeat}', $mail_voucherdetailoop, $mail_voucherdetail);
					}
				}
			}
			$mail_voucherdetail =str_replace($mail_voucherdetailoop, "", $mail_voucherdetail);
	
			if (isset($_SESSION['vemail'])) {	
				$mail_subject = $this->config->get('purchasevoucher_autosubject_'.$language_id.'_gift');
				$mail_message = html_entity_decode($this->config->get('purchasevoucher_automail_'.$language_id.'_gift'), ENT_QUOTES, 'UTF-8');
				$mail_subject =str_replace('{username}', $custname, $mail_subject);
				$mail_subject =str_replace('{useremail}', $custemail, $mail_subject);
					$mail_subject =str_replace('{storename}', $storename, $mail_subject);
					$mail_subject =str_replace('{orderid}', $order_id, $mail_subject);
					$mail_subject =str_replace('{giftuseremail}', $_SESSION['vemail'], $mail_subject);
					 if (isset($_SESSION['vname'])) {	
						$mail_subject =str_replace('{giftusername}', $_SESSION['vname'], $mail_subject);
					}
		
					$mail_message =str_replace('{username}', $custname, $mail_message);
					$mail_message =str_replace('{useremail}', $custemail, $mail_message);
					$mail_message =str_replace('{storelink}', $storeurl, $mail_message);
					$mail_message =str_replace('{storename}', $storename, $mail_message);
					$mail_message =str_replace('{orderid}', $order_id, $mail_message);
					$mail_message =str_replace('{voucherdetail}', $mail_voucherdetail, $mail_message);
					$mail_message =str_replace('{giftuseremail}', $_SESSION['vemail'], $mail_message);
					 if (isset($_SESSION['vname'])) {
						$mail_message =str_replace('{giftusername}', $_SESSION['vname'], $mail_message);
					}
					$sendemail=html_entity_decode($_SESSION['vemail']);
		
				} else {
					$mail_subject = $this->config->get('purchasevoucher_autosubject_'.$language_id.'_customer');
					$mail_message = html_entity_decode($this->config->get('purchasevoucher_automail_'.$language_id.'_customer'), ENT_QUOTES, 'UTF-8');
					
					$mail_subject =str_replace('{username}', $custname, $mail_subject);
					$mail_subject =str_replace('{useremail}', $custemail, $mail_subject);
					$mail_subject =str_replace('{storename}', $storename, $mail_subject);
					$mail_subject =str_replace('{orderid}', $order_id, $mail_subject);
		
					$mail_message =str_replace('{username}', $custname, $mail_message);
					$mail_message =str_replace('{useremail}', $custemail, $mail_message);
					$mail_message =str_replace('{storelink}', $storeurl, $mail_message);
					$mail_message =str_replace('{storename}', $storename, $mail_message);
					$mail_message =str_replace('{orderid}', $order_id, $mail_message);
					$mail_message =str_replace('{voucherdetail}', $mail_voucherdetail, $mail_message);
				}
				
				$mail_subject_admin = $this->config->get('purchasevoucher_autosubject_'.$language_id.'_admin');
				$mail_message_admin = html_entity_decode($this->config->get('purchasevoucher_automail_'.$language_id.'_admin'), ENT_QUOTES, 'UTF-8');
				$mail_message_admin =str_replace('{username}', $custname, $mail_message_admin);
				$mail_message_admin =str_replace('{useremail}', $custemail, $mail_message_admin);
				$mail_message_admin =str_replace('{storelink}', $storeurl, $mail_message_admin);
				$mail_message_admin =str_replace('{storename}', $storename, $mail_message_admin);
				$mail_message_admin =str_replace('{orderid}', $order_id, $mail_message_admin);
				$mail_message_admin =str_replace('{voucherdetail}', $mail_voucherdetail, $mail_message_admin);
				
				$mail_subject_admin =str_replace('{username}', $custname, $mail_subject_admin);
				$mail_subject_admin =str_replace('{useremail}', $custemail, $mail_subject_admin);
				$mail_subject_admin =str_replace('{storename}', $storename, $mail_subject_admin);
				$mail_subject_admin =str_replace('{orderid}', $order_id, $mail_subject_admin);
				
		
		
		
		
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');
		
		
				$mail->setFrom($configemail);
				$mail->setSender($storename);
				if (isset($sendemail)) {			
					$mail->setTo($sendemail);
				} else {
					$mail->setTo($custemail);
				}
				$mail->setSubject($mail_subject);
				$mail->setHtml($mail_message);
			
				$mail->send();  	
		
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');
		
		
				$mail->setFrom($configemail);
				$mail->setSender($storename);
		
				$mail->setTo($configemail);
				$mail->setSubject($mail_subject_admin);
				$mail->setHtml($mail_message_admin);
		
			   $mail->send();  
		
		
		
					if (isset($_SESSION['vemail'])) {	
				unset ($_SESSION['vemail']);
				unset ($_SESSION['vname']);
				}
				unset ($_SESSION["voucherproduct"]);
		
			}
			
		}
	if($call == "0"){
		$this->db->query("DELETE FROM " . DB_PREFIX . "voucher_pending WHERE order_id = '".$order_id."'");
		}
	}
	else
	{

	
	   $this->db->query("INSERT INTO " . DB_PREFIX . "voucher_pending SET order_id='".$order_id."',customer_email='".$custemail."',customer_name='".$custname."',storename='".$storename."',storeurl='".$storeurl."',order_status_id='".$order_status_id."',order_currency_code='".$order_currency_code."',order_currency_value='".$order_currency_value."',language_id='".$language_id."',configemail='".$configemail."',vemail='".$this->db->escape(isset($_SESSION['vemail'])?$_SESSION['vemail']:'')."',vname='".$this->db->escape(isset($_SESSION['vname'])?$_SESSION['vname']:'')."'");
	   if (isset($_SESSION['vemail'])) {	
	            unset ($_SESSION['vemail']);
				unset ($_SESSION['vname']);
				}
				unset ($_SESSION["voucherproduct"]);
	   
		   
	}
	}
}
?>