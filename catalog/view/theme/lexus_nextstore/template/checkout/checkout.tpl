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
	<div id="content" class="checkpagebanner">
		<?php echo $content_top; ?>
		<h1><?php echo $heading_title; ?></h1>
		<div class="checkout wrapper">
			<div id="checkout">
				<div class="checkout-heading"><?php echo $text_checkout_option; ?></div>
				<div class="checkout-content"></div>
			</div>
				
			<?php if (!$logged) { ?>
			<div id="payment-address">
				<div class="checkout-heading"><span><?php echo $text_checkout_account; ?></span></div>
				<div class="checkout-content"></div>
			</div>
				
			<?php } else { ?>
			<div id="payment-address">
				<div class="checkout-heading"><span><?php echo $text_checkout_payment_address; ?></span></div>
				<div class="checkout-content"></div>
			</div> 
			<?php } ?>
				
			<?php if ($shipping_required) { ?>
			<!--<div id="shipping-address">
				<div class="checkout-heading"><?php echo $text_checkout_shipping_address; ?></div>
				<div class="checkout-content"></div>
			</div>
			<div id="shipping-method">
				<div class="checkout-heading"><?php echo $text_checkout_shipping_method; ?></div>
				<div class="checkout-content"></div>
			</div> -->
			<?php } ?>
			
			<!--<div id="coupon-options">
				<div class="checkout-heading"><?php echo $text_checkout_coupon_options; ?></div>
				<div class="checkout-content"></div>
			</div>-->

			<div id="payment-method">
				<div class="checkout-heading"><?php echo $text_checkout_payment_method; ?></div>
				<div class="checkout-content"></div>
			</div>
				
			<div id="confirm">
				<div class="checkout-heading"><?php echo $text_checkout_confirm; ?></div>
				<div class="checkout-content"></div>
			</div>
		</div>		
		<div class="pav-checkout"><?php echo $content_bottom; ?></div>
	</div>

		 <div class="modal fade" tabindex="-1" role="dialog" id="resetcodModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="rclosemodal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Reset Pincode</h4>
      </div>
      <div class="modal-body">  
      <!--<div style="margin-bottom: 20px;" ><p>This product has been solded out! Kindly fill the following details, our executive will contact you in another 48 hours. <a href="https://gofootlounge.in/new-arrivals"><span style="color: #CD6927 " id="modal_content">Happy Shopping</span><a></p></div>-->
		<div style="margin-bottom: 20px;" ><p> Seems like the pincode is missing or an invalid entry. You can either replace the pincode to your current address  or ignore this process and go with adding the new address. (Pincode tells you the availability of the COD).</p></div>

       	<form class="form-horizontal"> 
       	<input type="hidden" id="npro_id" name="npro_id">
       	<input type="hidden" id="pro_name" name="pro_name">
       		<input type="hidden" id="pro_href" name="pro_href">
       	<div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Pincode</label>
		    <div class="col-sm-4">
		      <input type="text" class="form-control" id="rpincode" placeholder="Pincode" style=" font-weight:bold;">
		      <input type="hidden" id="hiddenaddressid">
		    </div>
		    <div class="col-sm-2">
		       <button type="button" class="btn btn-primary" id="sendbtn" onclick="resetpincode1();">Replace</button>
		    </div> 
		  </div> 
		   <div class="form-group">
		    <div class="col-sm-8">
		   	 <span class="alert alert-success" style=" padding:5px !important; margin-bottom:0px; display:none; float:right;"  id="rsuccess_msgaa">pincode updated successfully</span> 
		   	 </div>
		   </div>
		 
		</form>
      </div>
      <div class="modal-footer" style=" padding: 8px 20px 8px !important;">
     <!--<span class="alert alert-success" style=" padding:5px !important; margin-bottom:0px; display:none;"  id="rsuccess_msgaa">pincode updated successfully</span>-->
      <span class="alert alert-danger" style=" padding:5px !important; margin-bottom:0px;display:none;" id="rfailure_msg">sending failed</span>
      	<img src="https://gofootlounge.in/image/loading_spinner.gif" alt="loading..." id="image_spinner">
        <button type="button" class="btn btn-default" id="closebtn" onclick="rclosemodal();">Close</button>
        <button type="button" class="btn btn-primary" id="sendbtn" onclick="resetaddnewaddress();">Add New Address</button>
        <button type="button" class="btn btn-primary" id="sendbtn" onclick="resetpincode();">Next Step</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	
	
<script type="text/javascript">
<!--
	$('#checkout .checkout-content input[name=\'account\']').live('change', function() {
		if ($(this).attr('value') == 'register') {
			$('#payment-address .checkout-heading span').html('<?php echo $text_checkout_account; ?>');
		} else {
			$('#payment-address .checkout-heading span').html('<?php echo $text_checkout_payment_address; ?>');
		}
	});

	$('.checkout-heading a').live('click', function() {
		$('.checkout-content').slideUp('slow');	
		$(this).parent().parent().find('.checkout-content').slideDown('slow');
	});


	<?php if (!$logged) { ?> 
	$(document).ready(function() {
		$.ajax({
			url: 'index.php?route=checkout/login',
			dataType: 'html',
			success: function(html) {
				$('#checkout .checkout-content').html(html);
					
				$('#checkout .checkout-content').slideDown('slow');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});	
	});		
	<?php } else { ?>
	$(document).ready(function() {
		$.ajax({
			url: 'index.php?route=checkout/payment_address',
			dataType: 'html',
			success: function(html) {
				$('#payment-address .checkout-content').html(html);
					
				$('#payment-address .checkout-content').slideDown('slow');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});	
	});
	<?php } ?>


// Checkout
$('#button-account').live('click', function() {
	var radioValue = $("input[name='account']:checked"). val();
	 var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;
  
	var flag=1;
	if(radioValue == 'guest')
	{
		var emailid=$("#emailid_newuser1").val();
		if(emailid=='')
		{
			$("#emailid_newuser1").css('border','1px solid #F00'); 
			flag=0;
		}else{$("#emailid_newuser1").css('border','1px solid #ccc'); }

		if(emailid != '')
		{
			if (re.test(emailid) == false){$("#emailid_newuser1").css('border','1px solid #F00'); 
			flag=0;}else{$("#emailid_newuser1").css('border','1px solid #ccc'); 
			}
		}
		
	}
	else
	{
		var emailid=$("#emailid_newuser").val();
		if(emailid=='')
		{
			$("#emailid_newuser").css('border','1px solid #F00'); 
			flag=0;
		}else{$("#emailid_newuser").css('border','1px solid #ccc');}
		if(emailid != '')
		{
			if (re.test(emailid) == false){$("#emailid_newuser").css('border','1px solid #F00'); 
			flag=0;}else{$("#emailid_newuser").css('border','1px solid #ccc'); 
			}
		}
	}
	if(flag==1){

		$.ajax({
    type: "POST",
    url: 'index.php?route=checkout/login/sendnewusernotify',   
    data: {
      emailid:emailid
    },
    beforeSend: function() {
						$('#button-account').attr('disabled', true);
						$('#button-account').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
					},		
    success: function(response){ 
    

    <?php 	//if(isset($this->session->data['newuserid']))
    	//{ //onetime mail send to the user 
    	?>
		    	//send mail uding mailgun
		    /*	$.ajax({
				    type: "POST",
				    url: 'newusernotify.php',   
				    data: {
				      emailid:emailid,
				      message:response,
				    },
				    success: function(respalert){
				    	if(respalert == 1){
			*/	    
						$.ajax({ 
							url: 'index.php?route=checkout/' + $('input[name=\'account\']:checked').attr('value'),
							dataType: 'html',
							beforeSend: function() {
								$('.wait').remove();
								$('#button-account').attr('disabled', true);
								$('#button-account').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
							},		
							complete: function() {
								$('#button-account').attr('disabled', false);
								$('.wait').remove();
							},			
							success: function(html) {
								$('.warning, .error').remove();
								
								$('#payment-address .checkout-content').html(html);
									
								$('#checkout .checkout-content').slideUp('slow');
									
								$('#payment-address .checkout-content').slideDown('slow');
									
								$('.checkout-heading a').remove();
									
								$('#checkout .checkout-heading').append('<a><?php echo $text_modify; ?></a>');

                                                                 //save product details for abandoned user start*****
                                  
                                                                  $.ajax({
				                                type: "POST",
				                                url: 'index.php?route=checkout/login/saveabuserproduct',   
				                                data: {
				                               
				                                },
				                                success: function(respnew1){
                                                                    //alert(respnew1); 
                                                                } 
                                                                });

                                                              //save product details for abandoned user end***** 

							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						}); //redirect ajax end
					/*  } // if respalert end

					} // inner ajax success end
				}); // inner ajax end */
			<?php //}//onetime mail send to the user
			//else
			//{ ?>
				/*$.ajax({ 
							url: 'index.php?route=checkout/' + $('input[name=\'account\']:checked').attr('value'),
							dataType: 'html',
							beforeSend: function() {
								$('#button-account').attr('disabled', true);
								$('#button-account').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
							},		
							complete: function() {
								$('#button-account').attr('disabled', false);
								$('.wait').remove();
							},			
							success: function(html) {
								$('.warning, .error').remove();
								
								$('#payment-address .checkout-content').html(html);
									
								$('#checkout .checkout-content').slideUp('slow');
									
								$('#payment-address .checkout-content').slideDown('slow');
									
								$('.checkout-heading a').remove();
									
								$('#checkout .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						}); //redirect ajax end */
			<?php //} ?>

 	}// outer ajax success end
 }); // outer ajax end
} // if flag end

});

// Login
$('#button-login').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/login/validate',
		type: 'post',
		data: $('#checkout #login :input'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-login').attr('disabled', true);
			$('#button-login').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	
		complete: function() {
			$('#button-login').attr('disabled', false);
			$('.wait').remove();
		},				
		success: function(json) {
			$('.warning, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				$('#checkout .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
				
				$('.warning').fadeIn('slow');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

// Login
$('#button-login').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/login/validate',
		type: 'post',
		data: $('#checkout #login :input'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-login').attr('disabled', true);
			$('#button-login').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	
		complete: function() {
			$('#button-login').attr('disabled', false);
			$('.wait').remove();
		},				
		success: function(json) {
			$('.warning, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				$('#checkout .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
				
				$('.warning').fadeIn('slow');
			}
                         $.ajax({
				                                type: "POST",
				                                url: 'index.php?route=checkout/login/saveabuserproduct',   
				                                data: {
				                               
				                                },
				                                success: function(respnew1){
                                                                    //alert(respnew1); 
                                                                } 
                                                                });
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

// Register
$('#button-register').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/register/validate',
		type: 'post',
		data: $('#payment-address input[type=\'text\'], #payment-address input[type=\'password\'], #payment-address input[type=\'checkbox\']:checked, #payment-address input[type=\'radio\']:checked, #payment-address input[type=\'hidden\'], #payment-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-register').attr('disabled', true);
			$('#button-register').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>'); 
		},	
		complete: function() {
			$('#button-register').attr('disabled', false); 
			$('.wait').remove();
		},			
		success: function(json) {
			$('.warning, .error').remove();
						
			if (json['redirect']) {
				location = json['redirect'];				
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#payment-address .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>'); 
					
					$('.warning').fadeIn('slow');
				}
				
				if (json['error']['firstname']) {
					$('#payment-address input[name=\'firstname\'] + br').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					$('#payment-address input[name=\'lastname\'] + br').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
				
				if (json['error']['email']) {
					$('#payment-address input[name=\'email\'] + br').after('<span class="error">' + json['error']['email'] + '</span>');
				}
				
				if (json['error']['telephone']) {
					$('#payment-address input[name=\'telephone\'] + br').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}	
					
				if (json['error']['company_id']) {
					$('#payment-address input[name=\'company_id\'] + br').after('<span class="error">' + json['error']['company_id'] + '</span>');
				}	
				
				if (json['error']['tax_id']) {
					$('#payment-address input[name=\'tax_id\'] + br').after('<span class="error">' + json['error']['tax_id'] + '</span>');
				}	
																		
				if (json['error']['address_1']) {
					$('#payment-address input[name=\'address_1\'] + br').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}
				
				if (json['error']['address_2']) {
					$('#payment-address input[name=\'address_2\'] + br').after('<span class="error">' + json['error']['address_2'] + '</span>');
				}	
				
					
				if (json['error']['city']) {
					$('#payment-address input[name=\'city\'] + br').after('<span class="error">' + json['error']['city'] + '</span>');
				}	 
				
				
				if (json['error']['postcode']) {
					$('#payment-address input[name=\'postcode\'] + br').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					$('#payment-address select[name=\'country_id\'] + br').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('#payment-address select[name=\'zone_id\'] + br').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
				
				if (json['error']['password']) {
					$('#payment-address input[name=\'password\'] + br').after('<span class="error">' + json['error']['password'] + '</span>');
				}	
				
				if (json['error']['confirm']) {
					$('#payment-address input[name=\'confirm\'] + br').after('<span class="error">' + json['error']['confirm'] + '</span>');
				}																																	
			} else {
				<?php if ($shipping_required) { ?>	

                                /********* code for saving abandoned user details *********/
//code for updating abandonent custiomer table
					$.ajax({
					    type: "POST",
					    url: 'index.php?route=checkout/guest/updateabandoncustomer',      
					    data: {
					      step2:1
					    },
					  	
					    success: function(dresp){ 

			
				var shipping_address = $('#payment-address input[name=\'shipping_address\']:checked').attr('value');
				shipping_address =1;
				if (shipping_address) {
					/*$.ajax({
						url: 'index.php?route=checkout/shipping_method',
						dataType: 'html',
						success: function(html) {
							$('#shipping-method .checkout-content').html(html);
							
							$('#payment-address .checkout-content').slideUp('slow');
							
							$('#shipping-method .checkout-content').slideDown('slow');
							
							$('#checkout .checkout-heading a').remove();
							$('#payment-address .checkout-heading a').remove();
							$('#shipping-address .checkout-heading a').remove();
							$('#shipping-method .checkout-heading a').remove();
							$('#payment-method .checkout-heading a').remove();											
							
							$('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');									
							$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>'); */
							
						$.ajax({
							url: 'index.php?route=checkout/payment_method',
							dataType: 'html',
							success: function(html) {
								$('#payment-method .checkout-content').html(html);
								
								$('#payment-address .checkout-content').slideUp('slow');
									
								$('#payment-method .checkout-content').slideDown('slow');
									
								$('#payment-address .checkout-heading a').remove();
									$('#shipping-address .checkout-heading a').remove();
									$('#shipping-method .checkout-heading a').remove();
								$('#payment-method .checkout-heading a').remove();
																
								$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
									$('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	

							$.ajax({
								url: 'index.php?route=checkout/shipping_address',
								dataType: 'html',
								success: function(html) {
									$('#shipping-address .checkout-content').html(html);
								},
								error: function(xhr, ajaxOptions, thrownError) {
									alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
								}
							});	
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});	
				} else {
					$.ajax({
						url: 'index.php?route=checkout/shipping_address',
						dataType: 'html',
						success: function(html) {
							$('#shipping-address .checkout-content').html(html);
							
							$('#payment-address .checkout-content').slideUp('slow');
							
							$('#shipping-address .checkout-content').slideDown('slow');
							
							$('#checkout .checkout-heading a').remove();
							$('#payment-address .checkout-heading a').remove();
							$('#shipping-address .checkout-heading a').remove();
							$('#shipping-method .checkout-heading a').remove();
							$('#payment-method .checkout-heading a').remove();							

							$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});			
				}
                             } //abdandoned user success resp end

                             });	//abdandoned user ajax end

				<?php } else { ?>
				$.ajax({
					url: 'index.php?route=checkout/payment_method',
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);
						
						$('#payment-address .checkout-content').slideUp('slow');
						
						$('#payment-method .checkout-content').slideDown('slow');
						
						$('#checkout .checkout-heading a').remove();
						$('#payment-address .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();								
						
						$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});					
				<?php } ?>

				$.ajax({
					url: 'index.php?route=checkout/payment_address',
					dataType: 'html',
					success: function(html) {
						$('#payment-address .checkout-content').html(html);
							
						$('#payment-address .checkout-heading span').html('<?php echo $text_checkout_payment_address; ?>');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			}	 
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

// Payment Address	
$('#button-payment-address').live('click', function() {

if($("#payment-address-new").prop( "checked" ))
	{
		var address_id=0;

	}
	else

		{var address_id=$('select[name="address_id"]').val();}

  $.ajax({
    type: "POST",
    url: 'index.php?route=checkout/payment_address/getpincode/',   
    data: {
      address_id:address_id
    },
    success: function(resp1){
   if(resp1!=1 && address_id != 0 ){
    	$("#resetcodModal").modal('show'); 
    	$("#hiddenaddressid").val(address_id); 
    	

 	}
    	
     else {

	$.ajax({
		url: 'index.php?route=checkout/payment_address/validate',
		type: 'post',
		data: $('#payment-address input[type=\'text\'], #payment-address input[type=\'password\'], #payment-address input[type=\'checkbox\']:checked, #payment-address input[type=\'radio\']:checked, #payment-address input[type=\'hidden\'], #payment-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-payment-address').attr('disabled', true);
			$('#button-payment-address').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	
		complete: function() {
			$('#button-payment-address').attr('disabled', false);
			$('.wait').remove();
		},			
		success: function(json) {
			
			$('.warning, .error').remove();
			
			if (json['redirect']) {
			
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#payment-address .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
				}
								
				if (json['error']['firstname']) {
					$('#payment-address input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					$('#payment-address input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
				
				if (json['error']['telephone']) {
					$('#payment-address input[name=\'telephone\']').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}		
				
				if (json['error']['company_id']) {
					$('#payment-address input[name=\'company_id\']').after('<span class="error">' + json['error']['company_id'] + '</span>');
				}	
				
				if (json['error']['tax_id']) {
					$('#payment-address input[name=\'tax_id\']').after('<span class="error">' + json['error']['tax_id'] + '</span>');
				}	
														
				if (json['error']['address_1']) {
					$('#payment-address input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				
				if (json['error']['address_2']) {
					$('#payment-address input[name=\'address_2\']').after('<span class="error">' + json['error']['address_2'] + '</span>');
				}	
				
				if (json['error']['city']) {
					$('#payment-address input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					$('#payment-address input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					$('#payment-address select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('#payment-address select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
			} else {
				var n_postcodeaddr=$('#payment-address select[name=\'address_id\']').val(); 
				
					 $.ajax({
			              type: "POST",
			             
			              url: 'index.php?route=common/home/checkpostcodeaddress/', 
			              data:
			              {
			              	n_postcodeaddr:n_postcodeaddr,                               
			              },
			              success: function(resp){
			            
				
				<?php if ($shipping_required) { ?>
                             
                                 $.ajax({
					    type: "POST",
					    url: 'index.php?route=checkout/guest/updateabandoncustomer',   
					    data: {
					      step2:1
					    },
					  	
					    success: function(dresp){ 
					
						
				$.ajax({
					url: 'index.php?route=checkout/payment_method',
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);
					
						$('#payment-address .checkout-content').slideUp('slow');
						
						$('#payment-method .checkout-content').slideDown('slow');
						
						$('#payment-address .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
													
						$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});		
			              
                               }
                            });
			              


			/*	$.ajax({
					url: 'index.php?route=checkout/shipping_address',
					dataType: 'html',
					success: function(html) {
						$('#shipping-address .checkout-content').html(html);
					
						$('#payment-address .checkout-content').slideUp('slow');
						
						$('#shipping-address .checkout-content').slideDown('slow');
						
						$('#payment-address .checkout-heading a').remove();
						$('#shipping-address .checkout-heading a').remove();
						$('#shipping-method .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
						
						$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});*/
			
				<?php } else { ?>

				$.ajax({
					url: 'index.php?route=checkout/payment_method', 
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);
					
						$('#payment-address .checkout-content').slideUp('slow');
						
						$('#payment-method .checkout-content').slideDown('slow');
						
						$('#payment-address .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
													
						$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});	
				<?php } 	 ?>
				}
			          });  
				$.ajax({
					url: 'index.php?route=checkout/payment_address',
					dataType: 'html',
					success: function(html) {
						$('#payment-address .checkout-content').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});				
			}	  
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
	}

    }
	}); 
});

// Shipping Address			
$('#button-shipping-address').live('click', function() {
	var address_id=document.getElementsByName("address_id")[1].value;
	//var address_id=$('select[name="address_id"][1]').val();
	
  $.ajax({
    type: "POST",
    url: 'index.php?route=checkout/payment_address/getpincode/',   
    data: {
      address_id:address_id
    },
    success: function(resp1){
    	
     if(resp1!=1){
    	$("#resetcodModal").modal('show'); 
    	$("#hiddenaddressid").val(address_id); 
    	

 	}
 	else {

 		$.ajax({
		url: 'index.php?route=checkout/shipping_address/validate',
		type: 'post',
		data: $('#shipping-address input[type=\'text\'], #shipping-address input[type=\'password\'], #shipping-address input[type=\'checkbox\']:checked, #shipping-address input[type=\'radio\']:checked, #shipping-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-shipping-address').attr('disabled', true);
			$('#button-shipping-address').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	
		complete: function() {
			$('#button-shipping-address').attr('disabled', false);
			$('.wait').remove();
		},			
		success: function(json) {
			$('.warning, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#shipping-address .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
				}
								
				if (json['error']['firstname']) {
					$('#shipping-address input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					$('#shipping-address input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
				
				if (json['error']['email']) {
					$('#shipping-address input[name=\'email\']').after('<span class="error">' + json['error']['email'] + '</span>');
				}
				
				if (json['error']['telephone']) {
					$('#shipping-address input[name=\'telephone\']').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}		
										
				if (json['error']['address_1']) {
					$('#shipping-address input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				if (json['error']['address_2']) {
					$('#shipping-address input[name=\'address_2\']').after('<span class="error">' + json['error']['address_2'] + '</span>');
				}	
				
				if (json['error']['city']) {
					$('#shipping-address input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					$('#shipping-address input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					$('#shipping-address select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('#shipping-address select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
			} else {
				/*$.ajax({
					url: 'index.php?route=checkout/shipping_method',
					dataType: 'html',
					success: function(html) {
						$('#shipping-method .checkout-content').html(html);
						
						$('#shipping-address .checkout-content').slideUp('slow');
						
						$('#shipping-method .checkout-content').slideDown('slow');
						
						$('#shipping-address .checkout-heading a').remove();
						$('#shipping-method .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
						
						$('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	*/
						
						$.ajax({
					url: 'index.php?route=checkout/payment_method',
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);
						
						$('#shipping-address .checkout-content').slideUp('slow');
							
						$('#payment-method .checkout-content').slideDown('slow');
							
						$('#payment-address .checkout-heading a').remove();
							$('#shipping-address .checkout-heading a').remove();
							$('#shipping-method .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
														
						$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
							$('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');						
						
						$.ajax({
							url: 'index.php?route=checkout/shipping_address',
							dataType: 'html',
							success: function(html) {
								$('#shipping-address .checkout-content').html(html);
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						});
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});	
				
				$.ajax({
					url: 'index.php?route=checkout/payment_address',
					dataType: 'html',
					success: function(html) {
						$('#payment-address .checkout-content').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});					
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	//main ajax end	
	}

    }
	});
});

// Guest
$('#button-guest').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/guest/validate',
		type: 'post',
		data: $('#payment-address input[type=\'text\'], #payment-address input[type=\'checkbox\']:checked, #payment-address input[type=\'radio\']:checked, #payment-address input[type=\'hidden\'], #payment-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-guest').attr('disabled', true);
			$('#button-guest').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>'); 
		},	
		complete: function() {
			$('#button-guest').attr('disabled', false); 
			$('.wait').remove();
		},			
		success: function(json) {
			$('.warning, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#payment-address .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
				}
								
				if (json['error']['firstname']) {
					$('#payment-address input[name=\'firstname\'] + br').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					$('#payment-address input[name=\'lastname\'] + br').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
				
				if (json['error']['email']) {
					$('#payment-address input[name=\'email\'] + br').after('<span class="error">' + json['error']['email'] + '</span>');
				}
				
				if (json['error']['telephone']) {
					$('#payment-address input[name=\'telephone\'] + br').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}	
					
				if (json['error']['company_id']) {
					$('#payment-address input[name=\'company_id\'] + br').after('<span class="error">' + json['error']['company_id'] + '</span>');
				}	
				
				if (json['error']['tax_id']) {
					$('#payment-address input[name=\'tax_id\'] + br').after('<span class="error">' + json['error']['tax_id'] + '</span>');
				}	
																		
				if (json['error']['address_1']) {
					$('#payment-address input[name=\'address_1\'] + br').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}
				
				if (json['error']['address_2']) {
					$('#payment-address input[name=\'address_2\'] + br').after('<span class="error">' + json['error']['address_2'] + '</span>');
				}	
				
				if (json['error']['city']) {
					$('#payment-address input[name=\'city\'] + br').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					$('#payment-address input[name=\'postcode\'] + br').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					$('#payment-address select[name=\'country_id\'] + br').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('#payment-address select[name=\'zone_id\'] + br').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
			} else {
				<?php if ($shipping_required) { ?>	

                                //code for updating abandonent custiomer table
					$.ajax({
					    type: "POST",
					    url: 'index.php?route=checkout/guest/updateabandoncustomer',   
					    data: {
					      step2:1
					    },
					  	
					    success: function(dresp){ 

				var shipping_address = $('#payment-address input[name=\'shipping_address\']:checked').attr('value');
				shipping_address=1;
				if (shipping_address) {

					$.ajax({
						url: 'index.php?route=checkout/payment_method',
						dataType: 'html',
						beforeSend: function() {
							$('#button-coupon-options').attr('disabled', true);
							$('#button-coupon-options').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>'); 
						},	
						complete: function() {
							$('#button-coupon-options').attr('disabled', false);
							$('.wait').remove();
						},	
						success: function(html) {
							
							$('#payment-method .checkout-content').html(html);
							
							$('#payment-address .checkout-content').slideUp('slow');
							
							$('#payment-method .checkout-content').slideDown('slow');

							//$('#coupon-options .checkout-heading a').remove();
							//$('#payment-method .checkout-heading a').remove();
							$('#payment-address .checkout-heading a').remove();
							$('#shipping-address .checkout-heading a').remove();
							$('#shipping-method .checkout-heading a').remove();
							$('#payment-method .checkout-heading a').remove();
										
										$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
							$('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>'); /*			
							
							
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});*/
					/*$.ajax({
						url: 'index.php?route=checkout/shipping_method',
						dataType: 'html',
						success: function(html) {
							$('#shipping-method .checkout-content').html(html);
							
							$('#payment-address .checkout-content').slideUp('slow');
							
							$('#shipping-method .checkout-content').slideDown('slow');
							
							$('#payment-address .checkout-heading a').remove();
							$('#shipping-address .checkout-heading a').remove();
							$('#shipping-method .checkout-heading a').remove();
							$('#payment-method .checkout-heading a').remove();		
															
							$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
							$('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');						*/				
							
							$.ajax({
								url: 'index.php?route=checkout/guest_shipping',
								dataType: 'html',
								success: function(html) {
									$('#shipping-address .checkout-content').html(html);
								},
								error: function(xhr, ajaxOptions, thrownError) {
									alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
								}
							});
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});				
				} else {
					$.ajax({
						url: 'index.php?route=checkout/guest_shipping',
						dataType: 'html',
						success: function(html) {
							$('#shipping-address .checkout-content').html(html);
							
							$('#payment-address .checkout-content').slideUp('slow');
							
							$('#shipping-address .checkout-content').slideDown('slow');
							
							$('#payment-address .checkout-heading a').remove();
							$('#shipping-address .checkout-heading a').remove();
							$('#shipping-method .checkout-heading a').remove();
							$('#payment-method .checkout-heading a').remove();
							
							$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				}
                             }
			});

				<?php } else { ?>				
				$.ajax({
					url: 'index.php?route=checkout/payment_method',
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);
						
						$('#payment-address .checkout-content').slideUp('slow');
							
						$('#payment-method .checkout-content').slideDown('slow');
							
						$('#payment-address .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
														
						$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});				
				<?php } ?>
			}	 
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

// Guest Shipping
$('#button-guest-shipping').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/guest_shipping/validate',
		type: 'post',
		data: $('#shipping-address input[type=\'text\'], #shipping-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-guest-shipping').attr('disabled', true);
			$('#button-guest-shipping').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	
		complete: function() {
			$('#button-guest-shipping').attr('disabled', false); 
			$('.wait').remove();
		},			
		success: function(json) {
			$('.warning, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#shipping-address .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>'); 
					
					$('.warning').fadeIn('slow');
				}
								
				if (json['error']['firstname']) {
					$('#shipping-address input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					$('#shipping-address input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
										
				if (json['error']['address_1']) {
					$('#shipping-address input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				
				if (json['error']['city']) {
					$('#shipping-address input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					$('#shipping-address input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					$('#shipping-address select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('#shipping-address select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
			} else {
				/*$.ajax({
					url: 'index.php?route=checkout/shipping_method',
					dataType: 'html',
					success: function(html) {
						$('#shipping-method .checkout-content').html(html);
						
						$('#shipping-address .checkout-content').slideUp('slow');
						
						$('#shipping-method .checkout-content').slideDown('slow');
						
						$('#shipping-address .checkout-heading a').remove();
						$('#shipping-method .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
							
						$('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});	*/

				$.ajax({
						url: 'index.php?route=checkout/payment_method',
						dataType: 'html',
						beforeSend: function() {
							$('#button-coupon-options').attr('disabled', true);
							$('#button-coupon-options').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>'); 
						},	
						complete: function() {
							$('#button-coupon-options').attr('disabled', false);
							$('.wait').remove();
						},	
						success: function(html) {
							
							$('#payment-method .checkout-content').html(html);
							
							$('#shipping-address .checkout-content').slideUp('slow');
							
							$('#payment-method .checkout-content').slideDown('slow');

							//$('#coupon-options .checkout-heading a').remove();
							//$('#payment-method .checkout-heading a').remove();
							$('#shipping-address .checkout-heading a').remove();
						$('#shipping-method .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
										
									$('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');
							
							
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});			
			}	 
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

$('#button-shipping-method').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/shipping_method/validate',
		type: 'post',
		data: $('#shipping-method input[type=\'radio\']:checked, #shipping-method textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-shipping-method').attr('disabled', true);
			$('#button-shipping-method').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>'); 
		},	
		complete: function() {
			$('#button-shipping-method').attr('disabled', false);
			$('.wait').remove();
		},			
		success: function(json) {
		
		
			
			$('.warning, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#shipping-method .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>');
					 
					$('.warning').fadeIn('slow');
				}			
			} else {

				/*$.ajax({
					url: 'index.php?route=checkout/coupon_options',
					dataType: 'html',
					success: function(html) {
						$('#coupon-options .checkout-content').html(html);
						$('#shipping-method .checkout-content').slideUp('slow');
						$('#coupon-options .checkout-content').slideDown('slow');
						$('#shipping-method .checkout-heading a').remove();
						
						$('#shipping-method .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
						//console.log(html);	
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});*/
				$.ajax({
		url: 'index.php?route=checkout/payment_method',
		dataType: 'html',
		beforeSend: function() {
			$('#button-coupon-options').attr('disabled', true);
			$('#button-coupon-options').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>'); 
		},	
		complete: function() {
			$('#button-coupon-options').attr('disabled', false);
			$('.wait').remove();
		},	
		success: function(html) {
			
			$('#payment-method .checkout-content').html(html);
			
			$('#shipping-method .checkout-content').slideUp('slow');
			
			$('#payment-method .checkout-content').slideDown('slow');

			//$('#coupon-options .checkout-heading a').remove();
			//$('#payment-method .checkout-heading a').remove();
			$('#shipping-method .checkout-heading a').remove();
						
						$('#shipping-method .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
			
			
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});


				/*$.ajax({
					url: 'index.php?route=checkout/payment_method',
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);
						
						$('#shipping-method .checkout-content').slideUp('slow');
						
						$('#payment-method .checkout-content').slideDown('slow');

						$('#shipping-method .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
						
						$('#shipping-method .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});	*/				
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

$('#button_checkout_apply_coupon').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/coupon_options/validate', 
		type: 'post',
		data: $('#button_checkout_coupon'),
		dataType: 'json',	
		beforeSend: function() {
			$('#button_checkout_apply_coupon').attr('disabled', true);
			$('#button_checkout_apply_coupon').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	 
		complete: function() {
			$('#button_checkout_apply_coupon').attr('disabled', false);
			$('.wait').remove();
		},		
		success: function(json) {
			$("#checkout_coupon_msg").html(json.msg);
			$("#checkout_coupon_msg").removeClass('label-danger');
			$("#checkout_coupon_msg").removeClass('label-success');
			if(json.success)
			{
				$("#checkout_coupon_msg").addClass('label-success');
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
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

$('#button_checkout_apply_voucher').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/coupon_options/validate', 
		type: 'post',
		data: $('#button_checkout_voucher'),
		dataType: 'json',	
		beforeSend: function() {
			$('#button_checkout_apply_voucher').attr('disabled', true);
			$('#button_checkout_apply_voucher').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	
		complete: function() {
			$('#button_checkout_apply_voucher').attr('disabled', false);
			$('.wait').remove();
		},		
		success: function(json) {
			$("#checkout_voucher_msg").html(json.msg);
			$("#checkout_voucher_msg").removeClass('label-danger');
			$("#checkout_voucher_msg").removeClass('label-success');
			if(json.success)
			{
				$("#checkout_voucher_msg").addClass('label-success');
			}
			else
			{
				$("#checkout_voucher_msg").addClass('label-danger');
			}
			$("#checkout_voucher_msg").show('slow');
			setTimeout(function(){ $("#checkout_voucher_msg").hide('slow') }, 3000);
			return false;
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

$('#button_checkout_apply_reward').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/coupon_options/validate', 
		type: 'post',
		data: $('#button_checkout_reward'),
		dataType: 'json',
		beforeSend: function() {
			$('#button_checkout_apply_reward').attr('disabled', true);
			$('#button_checkout_apply_reward').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>'); 
		},	
		complete: function() {
			$('#button_checkout_apply_reward').attr('disabled', false);
			$('.wait').remove();
		},			
		success: function(json) {
			$("#checkout_reward_msg").html(json.msg);
			$("#checkout_reward_msg").removeClass('label-danger');
			$("#checkout_reward_msg").removeClass('label-success');
			if(json.success)
			{
				$("#checkout_reward_msg").addClass('label-success');
			}
			else
			{
				$("#checkout_reward_msg").addClass('label-danger');
			}
			$("#checkout_reward_msg").show('slow');
			setTimeout(function(){ $("#checkout_reward_msg").hide('slow') }, 3000);
			return false;
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

$('#button-coupon-options').live('click', function() {
	 
	$.ajax({
		url: 'index.php?route=checkout/payment_method',
		dataType: 'html',
		beforeSend: function() {
			$('#button-coupon-options').attr('disabled', true);
			$('#button-coupon-options').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>'); 
		},	
		complete: function() {
			$('#button-coupon-options').attr('disabled', false);
			$('.wait').remove();
		},	
		success: function(html) {
			
			$('#payment-method .checkout-content').html(html);
			
			$('#coupon-options .checkout-content').slideUp('slow');
			
			$('#payment-method .checkout-content').slideDown('slow');

			$('#coupon-options .checkout-heading a').remove();
			$('#payment-method .checkout-heading a').remove();
			
			$('#coupon-options .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#button-payment-method').live('click', function() {
	/* var payment_method=$("input[name=payment_method]").val(); 
	 var flag=1; 
	 if(payment_method=='cod')
	 {
	 	var postcode=$("input[name=postcode]").val(); 
	 	zipcode=postcode.trim();  
	 	//check for the cod status
	 	 $.ajax({
              type: "POST",
             
              url: 'index.php?route=common/home/codstatus/', 
              data:
              {zipcode:zipcode,
                               
              },
              success: function(resp){    
              //alert(resp);
                //resp=0; 
                alert(resp); 
                if(resp > 0)
                  {  
                  	alert('COD Available for your postcode'); 
                  }
                  else
                  {                     
             		alert('COD not Available for your postcode');  
             		$('#button-payment-method').attr('disabled', true); 
             		flag=0; 
           		  }
            }); 

	 }
	 if(flag==1)
	 {*/
	$.ajax({
		url: 'index.php?route=checkout/payment_method/validate', 
		type: 'post',
		data: $('#payment-method input[type=\'radio\']:checked, #payment-method input[type=\'checkbox\']:checked, #payment-method textarea,  #payment-method input[type=\'hidden\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-payment-method').attr('disabled', true);
			$('#button-payment-method').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	
		complete: function() {
			$('#button-payment-method').attr('disabled', false);
			$('.wait').remove();
		},			
		success: function(json) {
		       
                         //code for updating abandonent custiomer table
					$.ajax({
					    type: "POST",
					    url: 'index.php?route=checkout/payment_method/updateabandoncustomer1',   
					    data: {
					      step3:1
					    },
					  	
					    success: function(dresp){
			
			$('.warning, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#payment-method .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>');
					 
					$('.warning').fadeIn('slow');
				}			
			} else {
			
			
				$.ajax({
					url: 'index.php?route=checkout/confirm',
					
					
					dataType: 'html',
					success: function(html) {
						$('#confirm .checkout-content').html(html);
						
						$('#payment-method .checkout-content').slideUp('slow');
						
						$('#confirm .checkout-content').slideDown('slow');
						
						$('#payment-method .checkout-heading a').remove();
						
						$('#payment-method .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});	
			}
                   }  //inner suceess end
		 });
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
	// }  
});


//-->
</script> 
</section> 

<?php if( $SPAN[2] ): ?>
<aside class="col-lg-<?php echo $SPAN[2];?> col-md-<?php echo $SPAN[2];?> col-sm-12 col-xs-12">	
	<?php echo $column_right; ?>
</aside>
<?php endif; ?>

</div></div>
<script type="text/javascript"> 
var google_tag_params = { 
<?php if(count($productsn)>1) { ?>
ecomm_prodid: [<?php $idsval='';$count=count($productsn); $j=1;

  foreach ($productsn as $i => $product) { 
  	
  	if($j<$count)
  		{$comma=",";}else{$comma="";} 
  	
  	$idsval.='"'.$product["product_id"].'"'.$comma;
  	$j++;
  	 }   
  	 echo $idsval; ?>], 
  	 <?php } else { ?>
  	 ecomm_prodid: <?php $idsval='';$count=count($productsn); $j=1;

  foreach ($productsn as $i => $product) { 
  	$idsval.='"'.$product["product_id"].'"';
  	$j++;
  	 }    
  	if($idsval) {echo $idsval;} else echo '""'; ?>, 	
  	 	<?php }?>
ecomm_pagetype: "checkout", 
<?php if(count($productsn)>1) { ?>			  
ecomm_totalvalue: [<?php $count=count($productsn); $j=1;$priceval='';
  foreach ($productsn as $i => $product) { 
  	
  	if($j<$count)
  		{$comma=",";}else{$comma="";} 
  	//if (!$product['price']) {$finalprice=$product['price'];}else{$finalprice=$product['special'];}
  	$finalprice=$product['price'];
  	$finalprice=str_replace(",","",$finalprice); 
  	$orgprice=str_replace("<span class='WebRupee'>Rs</span>","",$finalprice);
   	$priceval.=number_format($orgprice,2, '.', '').$comma;   
  	$j++;  
  	 }     
  	 echo $priceval; ?>], 
<?php } else { ?>
	ecomm_totalvalue: <?php $count=count($productsn); $j=1;$priceval='';
  foreach ($productsn as $i => $product) {   	
  	
  	//if (!$product['special']) {$finalprice=$product['price'];}else{$finalprice=$product['special'];}
  	$finalprice=$product['price'];
  	$finalprice=str_replace(",","",$finalprice); 
  	$orgprice=str_replace("<span class='WebRupee'>Rs</span>","",$finalprice);
   	$priceval.=number_format($orgprice,2, '.', '');   
  	$j++;  
  	 }       
  	
  	 if($priceval) {echo $priceval;} else echo '""'; ?>, 
<?php } ?>    
};  

function resetpincode() // reset pincode
{
	$('#resetcodModal').modal('hide');
	
	/* $.ajax({
		url: 'index.php?route=checkout/shipping_address/validate',
		type: 'post',
		data: $('#shipping-address input[type=\'text\'], #shipping-address input[type=\'password\'], #shipping-address input[type=\'checkbox\']:checked, #shipping-address input[type=\'radio\']:checked, #shipping-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-shipping-address').attr('disabled', true);
			$('#button-shipping-address').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	
		complete: function() {
			$('#button-shipping-address').attr('disabled', false);
			$('.wait').remove();
		},			
		success: function(json) {
			$('.warning, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#shipping-address .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
				}
								
				if (json['error']['firstname']) {
					$('#shipping-address input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					$('#shipping-address input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
				
				if (json['error']['email']) {
					$('#shipping-address input[name=\'email\']').after('<span class="error">' + json['error']['email'] + '</span>');
				}
				
				if (json['error']['telephone']) {
					$('#shipping-address input[name=\'telephone\']').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}		
										
				if (json['error']['address_1']) {
					$('#shipping-address input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				if (json['error']['address_2']) {
					$('#shipping-address input[name=\'address_2\']').after('<span class="error">' + json['error']['address_2'] + '</span>');
				}	
				
				if (json['error']['city']) {
					$('#shipping-address input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					$('#shipping-address input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					$('#shipping-address select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('#shipping-address select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
			} else {
				$.ajax({
					url: 'index.php?route=checkout/shipping_method',
					dataType: 'html',
					success: function(html) {
						$('#shipping-method .checkout-content').html(html);
						
						$('#shipping-address .checkout-content').slideUp('slow');
						
						$('#shipping-method .checkout-content').slideDown('slow');
						
						$('#shipping-address .checkout-heading a').remove();
						$('#shipping-method .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
						
						$('#shipping-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');							
						
						$.ajax({
							url: 'index.php?route=checkout/shipping_address',
							dataType: 'html',
							success: function(html) {
								$('#shipping-address .checkout-content').html(html);
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						});
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});	
				
				$.ajax({
					url: 'index.php?route=checkout/payment_address',
					dataType: 'html',
					success: function(html) {
						$('#payment-address .checkout-content').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});					
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	}); //main ajax end	*/
	$.ajax({
		url: 'index.php?route=checkout/payment_address/validate',
		type: 'post',
		data: $('#payment-address input[type=\'text\'], #payment-address input[type=\'password\'], #payment-address input[type=\'checkbox\']:checked, #payment-address input[type=\'radio\']:checked, #payment-address input[type=\'hidden\'], #payment-address select'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-payment-address').attr('disabled', true);
			$('#button-payment-address').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},	
		complete: function() {
			$('#button-payment-address').attr('disabled', false);
			$('.wait').remove();
		},			
		success: function(json) {
			
			$('.warning, .error').remove();
			
			if (json['redirect']) {
			
				location = json['redirect'];
			} else if (json['error']) {
				if (json['error']['warning']) {
					$('#payment-address .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/close.png" alt="close" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
				}
								
				if (json['error']['firstname']) {
					$('#payment-address input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
				}
				
				if (json['error']['lastname']) {
					$('#payment-address input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
				}	
				
				if (json['error']['telephone']) {
					$('#payment-address input[name=\'telephone\']').after('<span class="error">' + json['error']['telephone'] + '</span>');
				}		
				
				if (json['error']['company_id']) {
					$('#payment-address input[name=\'company_id\']').after('<span class="error">' + json['error']['company_id'] + '</span>');
				}	
				
				if (json['error']['tax_id']) {
					$('#payment-address input[name=\'tax_id\']').after('<span class="error">' + json['error']['tax_id'] + '</span>');
				}	
														
				if (json['error']['address_1']) {
					$('#payment-address input[name=\'address_1\']').after('<span class="error">' + json['error']['address_1'] + '</span>');
				}	
				
				if (json['error']['address_2']) {
					$('#payment-address input[name=\'address_2\']').after('<span class="error">' + json['error']['address_2'] + '</span>');
				}	
				
				if (json['error']['city']) {
					$('#payment-address input[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
				}	
				
				if (json['error']['postcode']) {
					$('#payment-address input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}	
				
				if (json['error']['country']) {
					$('#payment-address select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('#payment-address select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
			} else {
				var n_postcodeaddr=$('#payment-address select[name=\'address_id\']').val(); 
					 $.ajax({
			              type: "POST",
			             
			              url: 'index.php?route=common/home/checkpostcodeaddress/', 
			              data:
			              {
			              	n_postcodeaddr:n_postcodeaddr,                               
			              },
			              success: function(resp){
				
				<?php if ($shipping_required) { ?>
					
						
				$.ajax({
					url: 'index.php?route=checkout/payment_method',
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);
					
						$('#payment-address .checkout-content').slideUp('slow');
						
						$('#payment-method .checkout-content').slideDown('slow');
						
						$('#payment-address .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
													
						$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});		
			              

			              


			/*	$.ajax({
					url: 'index.php?route=checkout/shipping_address',
					dataType: 'html',
					success: function(html) {
						$('#shipping-address .checkout-content').html(html);
					
						$('#payment-address .checkout-content').slideUp('slow');
						
						$('#shipping-address .checkout-content').slideDown('slow');
						
						$('#payment-address .checkout-heading a').remove();
						$('#shipping-address .checkout-heading a').remove();
						$('#shipping-method .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
						
						$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});*/
			
				<?php } else { ?>

				$.ajax({
					url: 'index.php?route=checkout/payment_method',
					dataType: 'html',
					success: function(html) {
						$('#payment-method .checkout-content').html(html);
					
						$('#payment-address .checkout-content').slideUp('slow');
						
						$('#payment-method .checkout-content').slideDown('slow');
						
						$('#payment-address .checkout-heading a').remove();
						$('#payment-method .checkout-heading a').remove();
													
						$('#payment-address .checkout-heading').append('<a><?php echo $text_modify; ?></a>');	
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});	
				<?php } 	 ?>
				}
			          });  
				$.ajax({
					url: 'index.php?route=checkout/payment_address',
					dataType: 'html',
					success: function(html) {
						$('#payment-address .checkout-content').html(html);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});				
			}	  
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
				   
}
function resetpincode1()
{ 
	var rpincode=$("#rpincode").val(); 
	var address_id=$("#hiddenaddressid").val(); 
	var flag=1;
	if(rpincode == ''){$("#rpincode").css('border','1px solid #F00'); flag=0;}
	else{$("#rpincode").css('border','1px solid #ccc'); }
	if(flag == 1)
	{
		$.ajax({
		    type: "POST",
		    url: 'index.php?route=checkout/payment_address/resetpincode/',   
		    data: {
		      rpincode:rpincode,
		      address_id:address_id  
		    },
		    success: function(resp1){
		    	 
		            //alert('Mail Send Successfully');
		         $.ajax({
				    type: "POST",
				    url: 'index.php?route=checkout/payment_address/respresetpincode/',   
				    data: {
				      address_id:address_id,
				     },
				    success: function(resp2){
				    
		         $("#payment-existing").html(resp2);
		         $("#rsuccess_msgaa").show();
		    	 }
		 		});
		          setTimeout(function() { 
		       // $('#resetcodModal').modal('hide');
		         $("#rsuccess_msgaa").hide();
		       
		         }, 2000); 

		       }
		});
	} 
}


function rclosemodal()//close modal
{
	$('#resetcodModal').modal('hide');
	
}

function resetaddnewaddress()//goto new address
{
	$('#resetcodModal').modal('hide');
	/*$("#shipping-address-new").attr('checked', 'checked');
	$("#shipping-existing").hide(); 
	$("#shipping-new").show();  */
	$("#payment-address-new").attr('checked', 'checked');
	$("#payment-existing").hide(); 
	$("#payment-new").show(); 
}
</script>  
<script type="text/javascript">
	
	// InitiateCheckout
// Track when people enter the checkout flow (ex. click/landing page on checkout button)
fbq('track', 'InitiateCheckout');
</script>

<?php echo $footer; ?>