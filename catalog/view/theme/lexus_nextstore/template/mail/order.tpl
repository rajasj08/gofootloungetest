<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo $title; ?></title>
	</head>
	<body class="new_order_font">
	<div class="new_order_fontoo">
	<!--	<a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>">
			<img src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" style="margin-bottom: 20px; border: none;" />
		</a>
 -->

    <table width="700" cellspacing="0" cellpadding="0" border="0"  align="center">

  <tbody><tr>
    <td valign="top" align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	     <tbody><tr>
	       <td width="150" valign="middle" height="75" align="left" class="new_order_padd"><a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>">
           <img src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" class="new_order_none" /></a></td>
	       <td valign="top" align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	         <tbody><tr>
	           <td class="new_order_padding"><table width="200" height="21" align="right">
	             <tbody><tr>
	              <td> 
 <a class="new_order_text" href="#14ad24ec8c2bf6af_14ad24d32399553c_14ad249f79bf65b3_14aca23085d85ca4_146c2260d4597c2f_"><span class="new_order_colc">Lets Talk</span></a></td>
	               <td width="28" valign="middle" align="right" class="new_order_fonts"><a target="_blank" href="#">
                   <img width="21" height="20" border="0" class="CToWUd" src="https://gofootlounge.in/catalog/view/theme/lexus_nextstore/template/common/ins.jpg" alt="<?php echo $title; ?>"></a></td>

	               <td width="26" valign="middle" align="right"class="new_order_fonts"><a target="_blank" href="https://twitter.com/Footlounge_in"><img width="21" height="20" border="0" class="CToWUd" src="https://gofootlounge.in/catalog/view/theme/lexus_nextstore/template/common/tw.jpg" alt="<?php echo $title; ?>"></a></td>

	               <td width="24" valign="middle" align="right" class="new_order_fonts"><a target="_blank" href="https://www.facebook.com/pages/Footlounge/1524200924491161"><img width="21" height="20" border="0" class="CToWUd" src="https://gofootlounge.in/catalog/view/theme/lexus_nextstore/template/common/fb.png" alt="<?php echo $title; ?>"></a>

</td>
	               </tr>
	               </tbody></table></td>
	           </tr>
	         
	         </tbody></table></td>
	       </tr>
	     </tbody></table></td>
  </tr>
  
  <tr>
    <td valign="top" align="left">&nbsp;</td>
  </tr>
  
</tbody></table>
		<p class="new_order_mb"><?php echo $text_greeting; ?></p>
		<?php if ($customer_id) { ?>
		<p class="new_order_mb"><?php echo $text_link; ?></p>
		<p class="new_order_mb"><a href="<?php echo $link; ?>"><?php echo $link; ?></a></p>
		<?php } ?>
		<?php if ($download) { ?>
		<p class="new_order_mb"><?php echo $text_download; ?></p>
		<p class="new_order_mb"><a href="<?php echo $download; ?>"><?php echo $download; ?></a></p>
		<?php } ?>
		<table class="new_order_collapse">
			<thead>
				<tr>
					<td class="new_order_bor" colspan="2"><?php echo $text_order_detail; ?></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="new_order_bor1"><b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?><br />
						<b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
						<b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
						<?php if ($shipping_method) { ?>
						<b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
						<?php } ?>
					</td>
					<td class="new_order_bor1"><b><?php echo $text_email; ?></b> <?php echo $email; ?><br />
						<b><?php echo $text_telephone; ?></b> <?php echo $telephone; ?><br />
						<b><?php echo $text_ip; ?></b> <?php echo $ip; ?><br />
					</td>
				</tr>
			</tbody>
		</table>
  
  
		<?php if ($comment) { ?>
		<table class="new_order_collapse">
			<thead>
				<tr>
					<td class="new_order_bor"><?php echo $text_instruction; ?></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="new_order_bor1"><?php echo $comment; ?></td>
				</tr>
			</tbody>
		</table>
		<?php } ?>
		<table class="new_order_collapse">
			<thead>
				<tr>
					<td class="new_order_bor"><?php echo $text_payment_address; ?></td>
					<?php if ($shipping_address) { ?>
					<td class="new_order_bor"><?php echo $text_shipping_address; ?></td>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="new_order_bor1"><?php echo $payment_address; ?></td>
					<?php if ($shipping_address) { ?>
					<td class="new_order_bor1"><?php echo $shipping_address; ?></td>
					<?php } ?>
				</tr>
			</tbody>
		</table>
		
		<table class="new_order_collapse">
			<thead>
				<tr>
					<td class="new_order_bor"><?php echo $text_product; ?></td>
					<td class="new_order_bor"><?php echo $text_model; ?></td>
					<td class="new_order_bor"><?php echo $text_quantity; ?></td>
					<td class="new_order_bor"><?php echo $text_price; ?></td>
					<td class="new_order_bor"><?php echo $text_total; ?></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($products as $product) { ?>
				<tr>
					<td class="new_order_bor1"><?php echo $product['name']; ?>
					<?php foreach ($product['option'] as $option) { ?>
					<br />
					&nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
					<?php } ?></td>
					<td class="new_order_bor1"><?php echo $product['model']; ?></td>
					<td class="new_order_bor1"><?php echo $product['quantity']; ?></td>
					<td class="new_order_bor1"><?php echo $product['price']; ?></td>
					<td class="new_order_bor1"><?php echo $product['total']; ?></td>
				</tr>
				<?php } ?>
				<?php foreach ($vouchers as $voucher) { ?>
				<tr>
					<td class="new_order_bor1"><?php echo $voucher['description']; ?></td>
					<td class="new_order_bor1"></td>
					<td class="new_order_bor1">1</td>
					<td class="new_order_bor1"><?php echo $voucher['amount']; ?></td>
					<td class="new_order_bor1"><?php echo $voucher['amount']; ?></td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<?php foreach ($totals as $total) { ?>
				<tr>
					<td class="new_order_bor1" colspan="4"><b><?php echo $total['title']; ?>:</b></td>
					<td class="new_order_bor1"><?php echo $total['text']; ?></td>
				</tr>
				<?php } ?>
			</tfoot>
		</table>    
		<p class="new_order_marbot"><?php echo $text_footer; ?></p>
		<p class="new_order_marbot"><?php echo $text_powered; ?></p>
	</div>
</body>
</html>