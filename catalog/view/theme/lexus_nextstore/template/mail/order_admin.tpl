<div class="emailContent">{$emailtemplate.content1}</div>

<?php if(!empty($comment)){ ?>
<br />
<b><?php echo $text_new_comment; ?></b><br />
<?php echo $comment; ?><br />
<?php } ?>

<?php if(!empty($products)){ ?>
<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15">&nbsp;</td></tr></table>

<table cellpadding="5" cellspacing="0" width="100%" class="table1">
<thead>
	<tr>
    	<th bgcolor="#ededed" class="textCenter"><?php echo $text_order_detail; ?></th>
   	</tr>
</thead>
<tbody>
	<tr>
		<td bgcolor="#fafafa">
			<table cellpadding="5" cellspacing="0" width="100%" class="tableStack">
			<tbody>
				<tr>
			    	<td width="50%" valign="top">
			          	<b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?>
			    		<?php if(!empty($invoice_no)){?><br /><b><?php echo $text_invoice_no; ?>:</b> <?php echo $invoice_no; } ?>
			    		<?php if(!empty($post_data_txn_id)){?><br /><b>PayPal Transaction ID:</b> <?php echo $post_data_txn_id; } ?>
			          	<br /><b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?>
			          	<br /><b><?php echo $text_new_order_status; ?></b> <?php echo $new_order_status; ?>
			          	<?php if($order_weight > 0){ ?><br /><b><?php echo $text_weight; ?></b> <?php echo $order_weight; } ?>
			        </td>
			        <td width="50%" valign="top">
			        	<b><?php echo $text_email; ?></b> <a href="mailto:<?php echo $email; ?>?subject=Re: <?php echo htmlspecialchars($subject, ENT_COMPAT, 'UTF-8'); ?>" style="color:<?php echo $config['body_link_color']; ?>; word-wrap:break-word;"><?php echo $email; ?></a>
			          	<br /><b><?php echo $text_telephone; ?></b> <a href="tel:<?php echo $telephone; ?>"><?php echo $telephone; ?></a>
			          	<br /><b><?php echo $text_ip; ?></b> <?php echo $ip; ?>
			          	<?php if($customer_group){ ?><br /><b><?php echo $text_customer_group; ?></b> <?php echo $customer_group['name']; ?><?php } ?>
			          	<?php if($affiliate){ ?><br /><b><?php echo $text_affiliate; ?></b> [#<?php echo $affiliate['affiliate_id']; ?>] <a href="mailto:<?php echo $affiliate['email']; ?>"><?php echo $affiliate['firstname'].' '.$affiliate['lastname']; ?></a><?php } ?>
			        </td>
				</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td bgcolor="#f6f6f6">
			<table cellpadding="5" cellspacing="0" width="100%" class="tableStack">
			<tbody>
				<tr>
			    	<td class="address">
		    			<b><?php echo $text_new_payment_address; ?></b><br />
		    			<p><?php echo $payment_address; ?></p>
		    			<?php if($payment_method){ ?><b><?php echo $text_new_payment_method; ?></b> <?php echo $payment_method; } ?>
			    	</td>
			    	<?php if ($shipping_address) { ?>
			        <td class="address">
		        		<b><?php echo $text_new_shipping_address; ?></b><br />
		        		<p><?php echo $shipping_address; ?></p>
		        		<?php if ($shipping_method) { ?><b><?php echo $text_new_shipping_method; ?></b> <?php echo $shipping_method; } ?>
			        </td>
			        <?php } ?>
				</tr>
			</tbody>
			</table>
		</td>
	</tr>
</tbody>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15">&nbsp;</td></tr></table>

<table cellpadding="5" cellspacing="0" width="100%" class="table1">
<thead>
	<tr>
        <th width="50%" bgcolor="#ededed"><b><?php echo $text_product; ?></b></th>
        <?php if($config['table_quantity']){ ?>
        	<th width="10%" bgcolor="#ededed" align="center" class="textCenter"><b><?php echo $text_quantity; ?></b></th>
        <?php } ?>
        <th width="<?php if($config['table_quantity']){ ?>20<?php } else { ?>25<?php } ?>%" bgcolor="#ededed" align="right" class="textRight"><b><?php echo $text_price; ?></b></th>
        <th width="<?php if($config['table_quantity']){ ?>20<?php } else { ?>25<?php } ?>%" bgcolor="#ededed" align="right" class="textRight"><b><?php echo $text_total; ?></b></th>
	</tr>
</thead>
<tbody>
	<?php $colspan = ($config['table_quantity']) ? 3 : 2; ?>
	<?php $i = 0;
	foreach ($products as $product) {
		$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
    <tr>
		<td bgcolor="<?php echo $row_style_background; ?>">
			<?php if($product['image']){ ?>
				<img src="<?php echo $product['image']; ?>" alt="<?php echo $product['image']; ?>" class="product-image" />
			<?php } ?>

			<a href="<?php echo $product['url_tracking']; ?>"><strong class="product-name"><?php echo $product['name']; ?></strong></a>

			<?php if(!empty($product['option'])){ ?>
			<span class="list-product-options">
				<?php foreach ($product['option'] as $option) { ?>
					<br />- <strong><?php echo $option['name']; ?>:</strong> <?php echo $option['value']; ?>
					<?php if($option['stock_subtract']) { ?>(<span style="color: <?php if($product['stock_quantity'] <= 0) { echo '#FF0000'; } elseif($product['stock_quantity'] <= 5) { echo '#FFA500'; } else { echo '#008000'; }?>"><?php echo $option['stock_quantity']; ?></span>)<?php } ?>
				<?php } ?>
			</span>
			<?php } ?>

			<br />
			<span class="product-data">
				<?php echo $text_model; ?> <?php echo $product['model']; ?>
				<?php if(!empty($product['sku'])){ ?><br /><?php echo $text_sku; ?>: <?php echo $product['sku']; ?><?php } ?>
				<?php if(!empty($product['weight'])){ ?><br /><?php echo $text_product_weight; ?>: <?php echo $product['weight']; ?><?php } ?>
				<?php if(!empty($product['manufacturer'])){ ?><br /><?php echo $text_manufacturer; ?>: <?php echo $product['manufacturer']; ?><?php } ?>
				<?php if(!empty($product['stock_quantity']) && $product['stock_subtract']){ ?><br /><?php echo $text_stock_quantity; ?>: <span style="color: <?php if($product['stock_quantity'] <= 0) { echo '#FF0000'; } elseif($product['stock_quantity'] <= 5) { echo '#FFA500'; } else { echo '#008000'; }?>"><?php echo $product['stock_quantity']; ?></span><?php } ?>
			</span>
		</td>
		<?php if($config['table_quantity']){ ?>
			<td bgcolor="<?php echo $row_style_background; ?>" align="center" class="textCenter"><?php echo $product['quantity']; ?></td>
			<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price"><?php echo $product['price']; ?></td>
		<?php } else { ?>
			<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price"><?php echo $product['quantity']; ?> <b>x</b> <?php echo $product['price']; ?></td>
		<?php } ?>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price">
			<?php echo $product['total']; ?>
		</td>
	</tr>
	<?php } ?>
	<?php
	if(isset($vouchers)){
		foreach ($vouchers as $voucher) {
			$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
	<tr>
        <td bgcolor="<?php echo $row_style_background; ?>" colspan="<?php echo $colspan; ?>"><?php echo $voucher['description']; ?></td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price"><?php echo $voucher['amount']; ?></td>
	</tr>
	<?php }
	} ?>
</tbody>
<?php if (isset($totals)) { ?>
<tfoot>
	<?php foreach ($totals as $total) {
		$row_style_background = "#ededed"; ?>
	<tr>
		<td bgcolor="<?php echo $row_style_background; ?>" colspan="<?php echo $colspan; ?>" align="right" class="textRight"><b><?php echo $total['title']; ?></b></td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price"><?php echo $total['text']; ?></td>
	</tr>
	<?php } ?>
</tfoot>
<?php } ?>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15">&nbsp;</td></tr></table>

<?php } ?>

<?php if(!empty($order_link)){ ?>
<div class="link">
	<b><?php echo $text_order_link; ?></b><br />
	<span class="icon">&raquo;</span>
	<a href="<?php echo $order_link; ?>" target="_blank">
		<b><?php echo $order_link; ?></b>
	</a>
</div>
<?php } ?>

<div class="emailContent">{$emailtemplate.content2}</div>