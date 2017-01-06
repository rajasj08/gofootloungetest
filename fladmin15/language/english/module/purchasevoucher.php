<?php
// Heading

$_['heading_title']       = '<img src="view/javascript/kodecube/arrow.gif" /> <span style="color:#449DD0; font-weight:bold">Purchase voucher<a target="_blank" href="http://kodecube.com/" >Kodecube.com</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; Check  awesome Opencart Mobile App at <a target="_blank" href="http://opencartmobileapp.com">Opencartmobileapp.com</span></a>';

$_['heading_title2']       = '<img src="view/javascript/kodecube/arrow.gif" /> <span style="color:#449DD0; font-weight:bold">Purchase voucher<a style="color:#A6D9FF; href="http://kodecube.com/">Kodecube.com</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span style="color:#FFFFFF; font-size:12px">Check  awesome Opencart Mobile App at <a style="color:#A6D9FF; font-size:12px href="http://opencartmobileapp.com">Opencartmobileapp.com</span></a>';

$_['title']       = 'Purchase voucher';
$_['purchasevoucher_autosubject_gift'] = '{username} sent you Gift voucher';
$_['purchasevoucher_autosubject_customer'] = 'Hi {username}- Here is your Voucher';
$_['purchasevoucher_autosubject_admin'] = 'Someone Ordered voucher';

$_['purchasevoucher_automail_customer']       = '<p>Dear {username},</p>

<p>Thanks for your Order.</p>

<p>Here is your voucher against your order id: {orderid}</p>

<p>{voucherdetail}</p>

<p>Regards,</p>

<p><a href="http://{storelink}">
{storename}</a></p>
';

$_['purchasevoucher_automail_gift']       = '<p>Hi {giftusername},</p>

<p>You got a voucher as gift from {username} with email {useremail} .</p>

<p>Here is your voucher against your order id: {orderid}</p>

<p>{voucherdetail}</p>

<p>Regards,</p>

<p><a href="http://{storelink}">
{storename}</a></p>
';

$_['purchasevoucher_automail_admin']       = '<p>Hi</p>



<p>voucher against order id: {orderid} was delivered to {username} with {useremail}</p>

<p>{voucherdetail}</p>

<p>Regards,</p>

<p><a href="http://{storelink}">
{storename}</a></p>
';

$_['purchasevoucher_voucherdetail']       = '
<p>{productdescription}</p>

<p>{productimage}</p>

<p>Voucher Code:{voucher}</p>

<p>voucher Amount: {voucheramount}</p>
<p>{repeat}</p>

';

$_['purchasevoucher_message']       = 'Sold Voucher!';
// Text

$_['text_success']        = 'Success: You have modified module Purchase voucher!';
$_['text_enabled']        = 'Enabled';
$_['text_disabled']        = 'Disabled';

$_['entry_status']          = 'Status:';
$_['entry_prefix']          = 'voucher Code Prefix:<br /><span class="help">Mention 4 digit voucher code prefix to use before 6 digit random voucher code generated</span>';
$_['force_payment_method']       = 'Select Payment method to enable for Voucher Selling:';
$_['force_total_method']       = 'Select Order Total method to disable for Voucher Selling:';

$_['entry_message']       = 'Voucher default message:';
$_['entry_emailno']   = 'Number of vouchers to be offered in each voucher product sell?:<span class="help">Normally its 1, but say for promotional offer you can give 2.</span>';
$_['entry_points']       = 'No of Reward points to give on each voucher unit amount used?:';
$_['entry_reedem']      = 'Give Reward Points to buyer of voucher when voucher is used for purchase?:<span class="help">Only valid if Voucher Buyer is registered customer</span>';
$_['payment_status']        = 'Payment status on which Voucher generates automatic <span class="help">On this status voucher generates automatic for other status admin confirms the order in admin and send by clicking button SEND VOUCHER in admin orders</span>';
// Error
$_['error_permission'] = 'Warning: You do not have permission to modify module Purchase voucher!';

//support
$_['tab_support']        = 'Support';
$_['text_info']           = '<p>Developed by <a href="http://kodecube.com/" target="_blank" alt="Kodecube"><img src="view/javascript/kodecube/logo.png" alt="Kodecube"></a></p> 
  <p>
<strong>Support Email:</strong> support@kodecube.com</p>

<p><strong>Development Request</strong>: Info@kodecube.com</p>

<p>
 Check our other modules at <a href="http://www.opencart.com/index.php?route=extension/extension&filter_username=kodecube" target="_blank"><img src="view/javascript/kodecube/opencart.png" alt="Opencart"> </a></p>
 
 <p>
 To buy Our modules at Kodecube Shop <a href="http://support.kodecube.com" target="_blank" alt="Kodecube Shop" >Click Here</a></p>
 
  <p>
 Log a Support Ticket Here: <a href="http://kodecube.com/shop/" target="_blank" alt="Kodecube Shop" >http://kodecube.com/shop/</a></p>';  
 
 $_['text_licence_info'] 					= 'To activate module please provide your email which was used for module purchasing and order ID.';
 $_['entry_transaction_id'] 				= 'Order ID';
  $_['entry_transaction_email'] 			= 'Email ID';
  
  
  
    $_['entry_mailtemplate'] 				= 'Mail Template';
	$_['entry_general'] 					= 'General';
	$_['entry_mail'] 					    = 'Mail';
	$_['entry_support'] 					= 'Support';
	$_['entry_mailtemplate'] 				= 'Mail Template';
  $_['entry_limit']         = 'Limit:'; 
$_['entry_image']         = 'Image (W x H) and Resize Type:';
$_['error_image']         = 'Image width &amp; height dimensions required!';
  
  //module display
  $_['entry_enabled']    = 'Enabled:';
$_['entry_sort_order']   = 'Sort Order:';
$_['entry_layout']       = 'Layout:';
$_['entry_position']     = 'Position:';
$_['text_content_top']   = 'Content Top';
$_['text_content_bottom'] = 'Content Bottom';
$_['text_column_left']    = 'Column Left';
$_['text_column_right']   = 'Column Right';

$_['entry_mail_customer'] = 'Customer mail body:
  <span class="help">Use the following keywords:<br/>
   <b>{username}</b> for customer name<br/>
  <b>{useremail}</b> for customer email<br/>
  <b>{storelink}</b> for Store link<br/>
  <b>{storename}</b> for store name<br/>
   <b>{orderid}</b> for Orderid<br/>
  <b>{voucherdetail}</b> for voucherdetail<br/>';
  
  $_['entry_subject_customer'] = 'Customer mail subject:
<span class="help">Use the following keywords:<br/>
  <b>{username}</b> for customer name<br/>
  <b>{useremail}</b> for customer email<br/>
   <b>{orderid}</b> for Orderid<br/>
  <b>{storename}</b> for store name<br/>';

  
  $_['entry_mail_gift'] = 'Send voucher to gift email- mail body:
  <span class="help">Use the following keywords:<br/>
   <b>{username}</b> for customer name<br/>
  <b>{useremail}</b> for customer email<br/>
  <b>{storelink}</b> for Store link<br/>
  <b>{storename}</b> for store name<br/>
   <b>{orderid}</b> for Orderid<br/>
  <b>{giftusername}</b> for gift reciever`s name<br/>
  <b>{giftuseremail}</b> for gift reciever`s email<br/>
  <b>{voucherdetail}</b> for voucherdetail<br/>';
  
  $_['entry_subject_gift'] = 'Send voucher to gift email- mail subject:
<span class="help">Use the following keywords:<br/>
  <b>{username}</b> for customer name<br/>
  <b>{useremail}</b> for customer email<br/>
   <b>{orderid}</b> for Orderid<br/>
  <b>{giftusername}</b> for gift receiver`s name<br/>
    <b>{giftuseremail}</b> for gift receiver`s email<br/>
  <b>{storename}</b> for store name<br/>';
  
  
$_['entry_mail_admin'] = 'Admin mail body:
  <span class="help">Use the following keywords:<br/>
  <b>{username}</b> for customer name<br/>
  <b>{useremail}</b> for customer email<br/>
  <b>{storelink}</b> for Store link<br/>
  <b>{orderid}</b> for Orderid<br/>
  <b>{storename}</b> for store name<br/>
  <b>{voucherdetail}</b> for voucherdetail<br/>';

  
$_['entry_subject_admin'] = 'Admin mail subject:
<span class="help">Use the following keywords:<br/>
  <b>{username}</b> for customer name<br/>
  <b>{useremail}</b> for customer email<br/>
  <b>{orderid}</b> for Orderid<br/>
  <b>{storename}</b> for store name<br/>';


  $_['entry_voucherdetail'] = 'Define keyword {voucherdetail}:
  <span class="help">Use the following keywords:<br/>
  <b>{voucher}</b> for Voucher Code<br/>
  <b>{voucheramount}</b> for Voucher Amount<br/>
   <b>{productimage}</b> for Product Image<br/>
    <b>{productdescription}</b> for Product Description<br/>
	<b>{repeat}</b> this is required at bottom always<br/>
  ';

?>