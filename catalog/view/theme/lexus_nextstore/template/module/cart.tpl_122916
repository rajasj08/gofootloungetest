<div id="cart" class="clearfix">
	<div class="heading media">		
		<div class="pull-left">
			<i class="icon-cart fa fa-shopping-cart"></i>
			<em class="shapes left"></em>
		</div>
		<div class="cart-inner media-body">
			<h4><?php echo $text_your_cart; ?></h4>
			<a><span id="cart-total"><?php echo $text_items; ?></span><i class="fa fa-angle-down"></i></a>
		</div>
	</div>
	
	<div class="content">
	<div class="respmodulecart">
		<?php if ($products || $vouchers) { ?>
		<div class="mini-cart-info">
			<table>
				<?php foreach ($products as $product) { ?>
				<tr>
					<td class="image">
						<?php if ($product['thumb']) { ?>
						<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
						<?php } ?>
					</td>
					<td class="name">
						<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
						<div>
							<?php foreach ($product['option'] as $option) { ?>
							- <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
							<?php } ?>
						</div>
					</td>
					<td class="quantity">x&nbsp;<?php echo $product['quantity']; ?></td>
					<td class="total"><?php echo $product['total']; ?></td>
					<td class="remove"><img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/remove-small.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $product['key']; ?>' : $('#cart').load('index.php?route=module/cart&remove=<?php echo $product['key']; ?>' + ' #cart > *');" /></td>
				</tr>
				<?php } ?>
				<?php foreach ($vouchers as $voucher) { ?>
				<tr>
					<td class="image"></td>
					<td class="name"><?php echo $voucher['description']; ?></td>
					<td class="quantity">x&nbsp;1</td>
					<td class="total"><?php echo $voucher['amount']; ?></td>
					<td class="remove"><img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/remove-small.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $voucher['key']; ?>' : $('#cart').load('index.php?route=module/cart&remove=<?php echo $voucher['key']; ?>' + ' #cart > *');" /></td>
				</tr>
				<?php } ?>
			</table>
		</div>
		<div class="mini-cart-total">
			<table>
				<?php foreach ($totals as $total) { ?>
				<tr>
					<td class="right"><b><?php echo $total['title']; ?>:</b></td>
					<td class="right"><?php echo $total['text']; ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
		<div class="checkout">
			<a href="<?php echo $cart; ?>" class="button btn btn-theme-default checkoutnbtn"><?php echo $text_cart; ?></a> 
			<a onclick="smartcheckoutpopup();" class="button btn btn-theme-default"> CHECKOUT NOW <?php //echo $text_checkout; ?></a>
		</div>
		<?php } else { ?>
		<div class="empty"><?php echo $text_empty; ?></div>
		<div class="continue-shopping"><a href="new-arrivals">Continue Shopping</a></div>
		<?php } ?>
		</div>
	</div>  
</div>

<script>
	
	function smartcheckoutpopup() //smart checkout popup
	{
	
		/*************Popup upsell code starts here *************/
				//var product_id='<?php echo $product_id; ?>';   	
		
				
						$.ajax({
							url: 'index.php?route=module/popupupsell/showupselloffer1',
							type: 'post',
							//data: 'product_id=' + product_id,
							dataType: 'json',
							success: function(json1) { 
							

													  
								if(json1) 
								{
									  $("#cart").removeClass('active'); 
									json1.content="<p><span class='popuptitle'>Buy More Save More!</span>&nbsp - &nbsp <span class='popupsubtitle'>Items at Special Price Just for You!</span></p><p id='notificationpopup'></p><div class='popupmainouter'>"+json1.content+"</div>"; 
		 									
											showPopupUpsell(json1.content, json1.width, json1.height); 

										


							
								}  //if json
								else
								{  
									//alert('sfsdf'); 
								window.location.href='<?php echo $checkout; ?>';
								 } 
									    
							}
								});
								


 

							
	}
	
</script>