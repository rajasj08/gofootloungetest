<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/config.tpl" ); ?>
<?php echo $header; ?>
<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/breadcrumb.tpl" );  ?>

<div class="container">
<div class="row">

<?php if( $SPAN[0] ): ?>
<aside class="col-lg-<?php echo $SPAN[0];?> col-md-<?php echo $SPAN[0];?> col-sm-12 col-xs-12">
	<?php echo $column_left; ?>
</aside>
<?php endif; ?> 

<section class="col-lg-<?php echo $SPAN[1];?> col-md-<?php echo $SPAN[1];?> col-sm-12 col-xs-12">
	<?php if ($attention) { ?>
	<div class="attention"><?php echo $attention; ?><img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>
	<?php } ?>
 
	<?php if ($success) { ?>
	<div class="success"><?php echo $success; ?><img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>
	<?php } ?>

	<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?><img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>
	<?php } ?>
   
 
	<div id="content">
		<?php //echo $content_top; ?>
		<h1>
			<?php echo $heading_title; ?>
			<?php if ($weight) { ?>
				&nbsp;(<?php echo $weight; ?>)
			<?php } ?>
		</h1>
		
		<div class="checkout wrapper no-margin">		
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" role="form">
				<div class="cart-info table-responsive">
					<table class="table">
						<thead>
							<tr>
								<td class="image"><?php echo $column_image; ?></td>
								<td class="name"><?php echo $column_name; ?></td>
								<td class="model"><?php echo $column_model; ?></td>
								<td class="quantity"><?php echo $column_quantity; ?></td>
								<td class="price"><?php echo $column_price; ?></td>
								<td class="total"><?php echo $column_total; ?></td>
							</tr>
						</thead>
						<tbody>
							<?php 
							 foreach ($products as $product) { ?> 
							<tr>
								<td class="image" data-label="<?php echo $column_image; ?>">
									<?php if ($product['thumb']) { ?>
										<a href="<?php echo $product['href']; ?>">
											<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" />
										</a>
									<?php } ?>
								</td>
								<td class="name" data-label="<?php echo $column_name; ?>">
									<a href="<?php echo $product['href']; ?>">
										<?php echo $product['name']; ?>
									</a>
									<?php if (!$product['stock']) { ?>
										<span class="stock">***</span>
									<?php } ?>
									<div class="cart-option">
										<?php foreach ($product['option'] as $option) { ?>
										- <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>&nbsp; <a class="cartchangesize" onclick="changecartprodsize('<?php echo $product['product_id']; ?>','<?php echo $option['option_val_id']; ?>');">CHANGE SIZE</a><br />
										<?php } ?>
									</div>									
									<?php if ($product['reward']) { ?>
										<small><?php echo $product['reward']; ?></small>
									<?php } ?>
								</td>
									
								<td class="model" data-label="<?php echo $column_model; ?>"><?php echo $product['model']; ?></td>
								<td class="quantity" data-label="<?php echo $column_quantity; ?>" >
									<input type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" />
									&nbsp;
									<input type="image" src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/update.png" alt="<?php echo $button_update; ?>" title="<?php echo $button_update; ?>" />
									&nbsp;<a href="<?php echo $product['remove']; ?>"><img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /></a>
								</td>
								<td class="price" data-label="<?php echo $column_price; ?>"  ><?php echo $product['price']; ?></td>
								<td class="total" data-label="<?php echo $column_total; ?>"  ><?php echo $product['total']; ?></td>
							</tr>
							<?php } ?>
						
							<?php foreach ($vouchers as $vouchers) { ?>
							<tr>
								<td class="image"></td>
								<td class="name"><?php echo $vouchers['description']; ?></td>
								<td class="model"></td>
								<td class="quantity">
									<input type="text" name="" value="1" size="1" disabled="disabled" />
									&nbsp;<a href="<?php echo $vouchers['remove']; ?>"><img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /></a>
								</td>
								<td class="price"><?php echo $vouchers['amount']; ?></td>
								<td class="total"><?php echo $vouchers['amount']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
			
			<!--<div class="cart_coupon_voucher_reward_msg"> <h5 class="text-right">All coupon codes/gift vouchers can be applied at checkout.</h5></div>-->
		  
		<div class="wrapper-cart-total">
		
			<!----------Apply coupons start-------->

			<div class="cart-total clearfix notopborder" id="couponapplybtnresp1">
			<?php if(isset($this->session->data['coupon'])){ ?>
			<input type="button" value="Remove Coupon" class="button btn btn-theme-default cartcoupon" id="removecartcoupon" onclick="removecartcoupon();" style=" background:#444c63" />

			<?php } else { ?>
				 <input type="button" value="<?php echo $button_coupon; ?>" class="button btn btn-theme-default cartcoupon" id="removecartcoupon" onclick="addcartcoupon();"/>
				 <?php } ?>
			</div>

		<!----------Apply coupons end-------->
		
			<div class="cart-total clearfix">
				<table id="total">
					<?php foreach ($totals as $total) { ?>
					<tr>
						<td class="right"><b><?php echo $total['title']; ?>:</b></td>
						<td class="right"><?php echo $total['text']; ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>  		

		<?php echo $content_bottom; ?>	

		</div>	
		
		<div class="buttons">
			<div class="right"><a onclick="smartcheckoutpopup();" class="button btn btn-theme-default">CHECKOUT NOW<?php //echo $button_checkout; ?></a></div>
			<div class="left"><a href="<?php echo $continue; ?>" class="button btn btn-theme-default"><?php echo $button_shopping; ?></a></div>
		</div>	

	<div class="col-md-12 marginsecuredmain">
			
				<div class="col-md-6 marginsecured">
				<div class="row topclasspay">
				<h3><b>Secured Shopping by &nbsp;<img src="image/Secures-Shopping/file_d44if0o2qr40m0o.png" class="payoptclsmain"/></b></h3>
					<div class="payoptdivcls"><img src="image/Secures-Shopping/FootLoungeSecuredShopping.jpg" class="payoptcls"/></div> 

				</div>
			</div>	 

			<div class="col-md-6">
				<div class="row topclasspay">
				<h3><b>Payment Options</b></h3>
					<div class="payoptdivcls"><img src="image/Payment-Options/Payment-Options-FootLounge.jpg" class="payoptcls1"/></div> 
					
				</div>
			</div>	
		
			</div>

	</div>  


  
<script type="text/javascript">
<!--
$('input[name=\'next\']').bind('change', function() {
	$('.cart-module > div').hide();
	
	$('#' + this.value).show();
});
//-->
</script>

<?php if ($shipping_status) { ?>
<script type="text/javascript">
<!--
$('#button-quote').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/quote',
		type: 'post',
		data: 'country_id=' + $('select[name=\'country_id\']').val() + '&zone_id=' + $('select[name=\'zone_id\']').val() + '&postcode=' + encodeURIComponent($('input[name=\'postcode\']').val()),
		dataType: 'json',		
		beforeSend: function() {
			$('#button-quote').attr('disabled', true);
			$('#button-quote').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},
		complete: function() {
			$('#button-quote').attr('disabled', false);
			$('.wait').remove();
		},		
		success: function(json) {
			$('.success, .warning, .attention, .error').remove();			
						
			if (json['error']) {
				if (json['error']['warning']) {
					$('#notification').html('<div class="warning new_cart">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
					
					$('html, body').animate({ scrollTop: 0 }, 'slow'); 
				}	
							
				if (json['error']['country']) {
					$('select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
				
				if (json['error']['postcode']) {
					$('input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}					
			}
			
			if (json['shipping_method']) {
				html  = '<h2><?php echo $text_shipping_method; ?></h2>';
				html += '<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" role="form">';
				html += '  <table class="radio">';
				
				for (i in json['shipping_method']) {
					html += '<tr>';
					html += '  <td colspan="3"><b>' + json['shipping_method'][i]['title'] + '</b></td>';
					html += '</tr>';
				
					if (!json['shipping_method'][i]['error']) {
						for (j in json['shipping_method'][i]['quote']) {
							html += '<tr class="highlight">';
							
							if (json['shipping_method'][i]['quote'][j]['code'] == '<?php echo $shipping_method; ?>') {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" checked="checked" /></td>';
							} else {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" /></td>';
							}
								
							html += '  <td><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['title'] + '</label></td>';
							html += '  <td class="new_cart_td"><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['text'] + '</label></td>';
							html += '</tr>';
						}		
					} else {
						html += '<tr>';
						html += '  <td colspan="3"><div class="error">' + json['shipping_method'][i]['error'] + '</div></td>';
						html += '</tr>';						
					} 
				}
				
				html += '  </table>';
				html += '  <br />';
				html += '  <input type="hidden" name="next" value="shipping" />';
				
				<?php if ($shipping_method) { ?>
				html += '  <input type="submit" value="<?php echo $button_shipping; ?>" id="button-shipping" class="button btn btn-theme-default" />';	
				<?php } else { ?>
				html += '  <input type="submit" value="<?php echo $button_shipping; ?>" id="button-shipping" class="button btn btn-theme-default" disabled="disabled" />';	
				<?php } ?>
							
				html += '</form>';
				
				$.colorbox({
					overlayClose: true,
					opacity: 0.5,
					width: '600px',
					height: '400px',
					href: false,
					html: html
				});
				
				$('input[name=\'shipping_method\']').bind('change', function() {
					$('#button-shipping').attr('disabled', false);
				});
			}
		}
	});
});
//-->
</script> 


<script type="text/javascript">
<!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//-->
</script>
<?php } ?>

</section> 


<?php if( $SPAN[2] ): ?>
	<aside class="col-lg-<?php echo $SPAN[2];?> col-md-<?php echo $SPAN[2];?> col-sm-12 col-xs-12">	
		<?php echo $column_right; ?>
	</aside>
<?php endif; ?>

</div></div>

<script type="text/javascript">  
 
var google_tag_params = { 
	<?php if(count($products)>1) { ?>
ecomm_prodid: [<?php $idsval='';$count=count($products); $j=1;
  foreach ($products as $i => $product) { 
  	
  	if($j<$count)
  		{$comma=",";}else{$comma="";} 
  	
  	$idsval.='"'.$product["product_id"].'"'.$comma;
  	$j++;
  	 }   
  	 echo $idsval; ?>],
  	 <?php } else { ?>
  	 	ecomm_prodid: <?php $idsval='';$count=count($products); $j=1;
  foreach ($products as $i => $product) { 
  	
  	
  	$idsval.='"'.$product["product_id"].'"';
  	$j++;
  	 }   
  	if( $idsval) { echo $idsval;} else { echo '""'; } ?>,
  	 	<?php }?>
ecomm_pagetype: "cart", 
<?php if(count($products)>1) { ?>
ecomm_totalvalue: [<?php $count=count($products); $j=1;$priceval='';
  foreach ($products as $i => $product) { 
  	
  	if($j<$count)
  		{$comma=",";}else{$comma="";} 
  	$orgprice=str_replace("<span class='WebRupee'>Rs</span>","",$product['price']); 
  	$orgprice1=str_replace(",","",$orgprice); 
  	$priceval.=number_format($orgprice1,2, '.', '').$comma;  
  	$j++;
  	 }   
  	 echo $priceval; ?>], 
  	 <?php } else { ?>
  	 	ecomm_totalvalue: <?php $count=count($products); $j=1;$priceval='';
  foreach ($products as $i => $product) { 
  	
  	$orgprice=str_replace("<span class='WebRupee'>Rs</span>","",$product['price']); 
  	$orgprice1=str_replace(",","",$orgprice); 
  	$priceval.=number_format($orgprice1,2, '.', '');  
  	$j++;
  	 } if( $priceval) { echo $priceval;} else { echo '""'; }  
  	  ?>, 
  	 	<?php } ?>
};


</script> 

<div class="modal fade" tabindex="-1" role="dialog" id="cartcouponModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="closecouponmodal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">APPLY COUPON</h4>
      </div>
      <div class="modal-body">
      <!--<div style="margin-bottom: 20px;" ><p>This product has been solded out! Kindly fill the following details, our executive will contact you in another 48 hours. <a href="https://gofootlounge.in/new-arrivals"><span style="color: #CD6927 " id="modal_content">Happy Shopping</span><a></p></div>-->
		<!--<div style="margin-bottom: 20px;" ><p> Notify me when the product is back in Stock!</p></div> -->

       	<form class="form-horizontal">
       	<input type="hidden" id="npro_id" name="npro_id">
       	<input type="hidden" id="pro_name" name="pro_name">
       		<input type="hidden" id="pro_href" name="pro_href">
       	<div class="form-group">
		   <!-- <label for="inputPassword3" class="col-sm-4 control-label">Coupon Code</label>-->
		    <div class="col-sm-8">
		      <input type="text" class="form-control cartcouponcode" id="cartcouponcode" placeholder="Enter coupon code">
		    </div>
		     <div class="col-sm-2">
		     <button type="button" class="btn btn-primary couponapplybtn" onclick="applycouponcart();" id="couponapplybtn">Apply</button>
		    </div>
		  </div>
		 <div class="col-sm-12">
		 	<span id="checkout_coupon_msg" class="checkout_coupon_msgaa"></span>
		 	
		 	<input type="hidden" id="couponamount">
		 	</div>
		 </div>
		 
		</form>
      </div>
      	
      <!---<div class="modal-footer" style=" padding: 8px 20px 8px !important;">
      <span class="alert alert-success" style=" padding:5px !important; margin-bottom:0px; display:none;"  id="success_msgaa">Request sent successfully</span>
      <span class="alert alert-danger" style=" padding:5px !important; margin-bottom:0px;display:none;" id="failure_msg">sending failed</span>
      	<img src="https://gofootlounge.in/image/loading_spinner.gif" alt="loading..." id="image_spinner">
        <button type="button" class="btn btn-default" id="closebtn" onclick="closemodal();">Close</button>
        <button type="button" class="btn btn-primary" id="sendbtn" onclick="sendnotify();">Send</button>
      </div> -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="productSizeModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="closeproductSizeModal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Change Product Size</h4>
      </div>
      <div class="modal-body">
      <!--<div style="margin-bottom: 20px;" ><p>This product has been solded out! Kindly fill the following details, our executive will contact you in another 48 hours. <a href="https://gofootlounge.in/new-arrivals"><span style="color: #CD6927 " id="modal_content">Happy Shopping</span><a></p></div>-->
		<div style="margin-bottom: 20px;" ><p></p></div>

       	<form class="form-horizontal">
       	<input type="hidden" id="oldprodsize" name="oldprodsize">
       	<input type="hidden" id="mainproductid" name="mainproductid">
       	
      <!-- 	<div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Product Name</label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="Nproductname" placeholder="Product Name" disabled="disabled" style=" font-weight:bold;">
		    </div>
		  </div> -->
		   <div class="form-group" id="respcontent">
		  
		  </div> 

		  <!--<div class="form-group">
		    <label for="inputEmail3" class="col-sm-4 control-label">Email<span class="mand_field">*</span></label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="Nemail" placeholder="Required">
		    </div>
		  </div>
		 <div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Name<span class="mand_field">*</span></label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="Nname" placeholder="Name">
		    </div>
		  </div> 

		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Mobile Number</label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="Nmobileno" placeholder="Optional">
		    </div>
		  </div>--> 
		  
		 	

		<!--  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Comments</label>
		    <div class="col-sm-6">
		      <textarea class="form-control" id="NComments" placeholder="Comments"></textarea>
		    </div>
		  </div> -->

		</form>
      </div>
      <div class="modal-footer" style=" padding: 8px 20px 8px !important;">
      <span class="alert alert-success" style=" padding:5px !important; margin-bottom:0px; display:none;"  id="success_msgaa">Request sent successfully</span>
      <span class="alert alert-danger" style=" padding:5px !important; margin-bottom:0px;display:none;" id="failure_msg">sending failed</span>
      	<img src="https://gofootlounge.in/image/loading_spinner.gif" alt="loading..." id="image_spinner">
        <button type="button" class="btn btn-default" id="closebtn" onclick="closeproductSizeModal();">Close</button>
        <button type="button" class="btn btn-primary" id="sendbtn" onclick="updatecartprodsize();">Submit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
	
	function addcartcoupon() // add coupon for the cart
	{
		$("#cartcouponModal").modal('show'); 
	}

	function applycouponcart()// apply coupon
	{
		var cartcouponcode=$('#cartcouponcode').val();
		$.ajax({
		url: 'index.php?route=checkout/coupon_options/cartvalidate', 
		type: 'post',
		data: {coupon:cartcouponcode},
		dataType: 'json',	
		beforeSend: function() {

			$('#couponapplybtn').attr('disabled', true);
			$('#couponapplybtn').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	 
		complete: function() {
			$('#couponapplybtn').attr('disabled', false);
			$('.wait').remove();
		},		
		success: function(json) {
			
			$("#checkout_coupon_msg").html(json.msg);
			$("#checkout_coupon_msg").removeClass('label-danger');
			$("#checkout_coupon_msg").removeClass('label-success');
			if(json.success)
			{

				$("#checkout_coupon_msg").addClass('label-success');

				$.ajax({
		        type: "POST",
		        url: 'index.php?route=checkout/cart/replacecarttotal', 
		        data:{coupon:cartcouponcode} ,
		        success: function(resp){
		        	if(resp) {
		        		$("#coupontotal").html(resp);
		        		$("#cartcouponModal").modal('hide');
		        		$("#couponapplybtnresp1").html(' <input type="button" value="Remove Coupon" class="button btn btn-theme-default cartcoupon" id="removecartcoupon" style=" background:#444c63" onclick="removecartcoupon();"/>');  
		        		$("#cartcouponcode").val('');
		        		$("#checkout_coupon_msg").hide();
		        	}
		        }
		    });
				//$("#coupontotal").html();
			}
			else
			{
				$("#checkout_coupon_msg").addClass('label-danger');
			}
			$("#checkout_coupon_msg").show('slow');
			setTimeout(function(){ $("#checkout_coupon_msg").hide('slow') }, 3000);
			return false;
		},
		error: function(xhr, ajaxOptions, thrownError) {
			
		}
	});	
	}
	function closecouponmodal()//close coupon model
	{
		$("#cartcouponModal").modal('hide'); 
	}

	function removecartcoupon()
	{
		
		var a=confirm('Woule you like romove coupon');
		if(a==1)
		{
			
			
		$.ajax({
		        type: "POST",
		        url: 'index.php?route=checkout/cart/replacecarttotal1', 
		        data:{} ,
		        beforeSend: function() {

		        	
			$('#removecartcoupon').attr('disabled', true);
			$('#removecartcoupon').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" style="float:right;" /></span>');
		},	
		complete: function() {
			$('#removecartcoupon').attr('disabled', false);
			$('.wait').remove();
		},	 
		        success: function(resp){
		        	if(resp) {
		        	
		        			$("#coupontotal").html(resp);
						$("#couponapplybtnresp1").html('<input type="button" value="<?php echo $button_coupon; ?>" id="removecartcoupon" class="button btn btn-theme-default cartcoupon" onclick="addcartcoupon();"/>'); 

		        	

		        		
		        	}
		        }
		    });

		}
	}
	// change product size from the cart
	function changecartprodsize(product_id,oldsizeval)
	{
		$.ajax({
		    type: "POST",
		    url: 'index.php?route=product/product/getproductoptioninfos/',   
		    data: {
		      product_id:product_id,
                      type:2
		    },
		    success: function(jsonresp){
		    	
		      $("#productSizeModal").modal('show');   
		      $("#respcontent").html(jsonresp); 
		      $("#oldprodsize").val(oldsizeval);  
		      $("#mainproductid").val(product_id); 
		    }
  		});
	}
	function updatecartprodsize() //changecartproductsize
	{
		var oldprodsize=$("#oldprodsize").val();
		var mainproductid=$("#mainproductid").val(); 
		var optionvalueinfo=$("#optionvalueinfo").val(); 
		var optionarray = $('#optionvalueinfo option:selected').attr('optionid');
		
		$.ajax({
		    type: "POST",
		    url: 'index.php?route=checkout/cart/changeproductoptioninfos/',   
		    data: {
		      oldprodsize:oldprodsize,
		      mainproductid:mainproductid,
		      optionvalueinfo:optionvalueinfo,
		      optionarray:optionarray
		    },
		    success: function(jsonresp){
		    $("#productSizeModal").modal('hide');

			/*$.ajax({
			    type: "POST",
			    url: 'index.php?route=checkout/cart/getcartcontentinfo/',   
			    data: {
			      oldprodsize:oldprodsize,
			      mainproductid:mainproductid,
			      optionvalueinfo:optionvalueinfo,
			      optionarray:optionarray
			    },
			    success: function(resp){
			    }
			});*/
			location.reload();  

		    } 
  		});
	}
	function closeproductSizeModal()
	{
		$("#productSizeModal").modal('hide'); 
	}
	
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
<script type="text/javascript">
	
	// AddToCart
// Track when items are added to a shopping cart (ex. click/landing page on Add to Cart button)
fbq('track', 'AddToCart');
</script>

<?php echo $footer; ?> 