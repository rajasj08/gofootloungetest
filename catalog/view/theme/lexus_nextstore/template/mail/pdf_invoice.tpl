	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td align="<?php echo $config['text_align']; ?>" valign="top">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td><img alt="<?php echo $store['config_logo']; ?>" src="<?php echo $store['config_logo']; ?>" /></td>
						</tr>
						<tr>
							<td class="new_pdf_line">&nbsp;</td>
						</tr>
						<tr>
							<td align="<?php echo $config['text_align']; ?>">
								<table border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<td width="90"><?php echo $text_date_added; ?></td>
											<td><?php echo $order['date_added']; ?></td>
										</tr>
										
										<tr>
											<td width="90"><?php echo $text_order_id; ?></td>
											<td><?php echo $order['order_id']; ?></td>
										</tr>
										
										<?php if($order['invoice_no']){ ?>
										<tr>
											<td width="90"><?php echo $text_invoice_no; ?></td>
											<td><?php echo $order['invoice_prefix'] . $order['invoice_no']; ?></td>
										</tr>
										<?php } ?>
										
										<?php if($order['payment_method']){ ?>
										<tr>
											<td width="90"><?php echo $text_payment_method; ?></td>
											<td><?php echo $order['payment_method']; ?></td>
										</tr>
										<?php } ?>
										
										<?php if($order['shipping_method']){ ?>
										<tr>
											<td width="90"><?php echo $text_shipping_method; ?></td>
											<td><?php echo $order['shipping_method']; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td align="right" valign="top">
				<b class="new_pdf_ctext"><?php if($store['config_url']){ ?><a href="<?php echo $store['config_url']; ?>" class="new_pdf_text" target="_blank"><?php echo $store['config_name']; ?></a><?php } else { echo $store['config_name']; } ?></b>
				
				<?php if($store['config_address']){ ?>
					<br /><?php echo $store['config_address']; ?>
				<?php } ?>
				
				<?php if($store['config_telephone']){ ?>
					<br /><i class="fa fa-phone"></i><?php echo $store['config_telephone']; ?>
				<?php } ?>
				
				<?php if($store['config_email']){ ?>
					<br /><i class="fa fa-mail"></i><a href="mailto:<?php echo $store['config_email']; ?>" class="new_pdf_textcc" target="_blank"><?php echo $store['config_email']; ?></a>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td colspan="2" height="8">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
			<table border="0" cellpadding="5" cellspacing="0" width="100%">
				<tbody>
					<tr>
						<td bgcolor="<?php echo $config['invoice_color']; ?>" class="new_pdf_colorr" <?php if($order['shipping_address']){ ?> width="50%"<?php } ?> align="<?php echo $config['text_align']; ?>"><b><?php echo $text_to; ?></b></td>
						<?php if($order['shipping_address']){ ?>
							<td bgcolor="<?php echo $config['invoice_color']; ?>" class="new_pdf_colorr" width="50%" align="<?php echo $config['text_align']; ?>"><b><?php echo $text_ship_to; ?></b></td>
						<?php } ?>
					</tr>
					<tr>
						<td align="<?php echo $config['text_align']; ?>">
							<p>
								<?php echo $order['payment_address']; ?>
								
								<?php if($order['payment_company_id'] || $order['payment_tax_id']){ ?>
									<br class="new_pdf_lineee" />
								<?php } ?>
								
								<?php if($order['payment_company_id']){ ?>
									<br /><b><?php echo $text_company_id; ?></b> <?php echo $order['payment_company_id']; ?>
								<?php } ?>
								
								<?php if($order['payment_tax_id']){ ?>
									<br /><b><?php echo $text_tax_id; ?></b> <?php echo $order['payment_tax_id']; ?>
								<?php } ?>
							</p>
						</td>
						<?php if($order['shipping_address']){ ?>
						<td width="50%" align="<?php echo $config['text_align']; ?>">
							<p><?php echo $order['shipping_address']; ?></p>
						</td>
						<?php } ?>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>
