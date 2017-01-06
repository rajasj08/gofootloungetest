<?php if ($addresses) { ?>
<input type="radio" name="payment_address" value="existing" id="payment-address-existing" checked="checked" />
<label for="payment-address-existing">Select Delivery Address<?php // echo $text_address_existing; ?></label>

<div id="payment-existing">
	<select name="address_id" style="width: 100%; margin-bottom: 15px;">
		<?php foreach ($addresses as $address) { ?>
		<?php if ($address['address_id'] == $address_id) { ?>
		<option value="<?php echo $address['address_id']; ?>" selected="selected"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?>, <?php echo $address['address_2']; ?>, <?php echo $address['postcode']; ?></option>
		<?php } else { ?>
		<option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?>, <?php echo $address['address_2']; ?>, <?php echo $address['postcode']; ?></option>
		<?php } ?>
		<?php } ?>
	</select>
</div>
<p>
	<input type="radio" name="payment_address" value="new" id="payment-address-new" />
	<label for="payment-address-new" data-toggle="tooltip" data-placement="right" title="Add Delivery Address" class="deliverytool">&nbsp;<!--<i class="fa fa-plus"></i>-->Add New Delivery Address<?php //echo $text_address_new; ?></label> 
</p>
<?php } ?>


<div id="payment-new" style="display: <?php echo ($addresses ? 'none' : 'block'); ?>;">
	<table class="form">
		<tr>
			<td><span class="required">*</span> <?php echo $entry_firstname; ?></td>			
		</tr>
		<tr>
			<td><input type="text" name="firstname" value="" class="large-field" /></td>
		</tr>
		<tr>
			<td><span class="required">*</span> <?php echo $entry_lastname; ?></td>			
		</tr>
		<tr>
			<td><input type="text" name="lastname" value="" class="large-field" /></td>
		</tr>
		<!--<tr>
			<td><?php echo $entry_company; ?></td>			
		</tr>
		<tr>
			<td><input type="text" name="company" value="" class="large-field" /></td>
		</tr> -->
		
		<?php if ($company_id_display) { ?>
		<tr>
			<td>
				<?php if ($company_id_required) { ?>
				<span class="required">*</span>
				<?php } ?>
				<?php echo $entry_company_id; ?>
			</td>			
		</tr>
		<tr>
			<td>
				<input type="text" name="company_id" value="" class="large-field" />
			</td>
		</tr>
		<?php } ?>
		
		<?php if ($tax_id_display) { ?>
		<tr>
			<td>
				<?php if ($tax_id_required) { ?>
				<span class="required">*</span>
				<?php } ?>
				<?php echo $entry_tax_id; ?>
			</td>			
		</tr>
		<tr>
			<td>
				<input type="text" name="tax_id" value="" class="large-field" />
			</td>
		</tr>
		<?php } ?>
		
		<tr>
			<td><span class="required">*</span> <?php echo $entry_address_1; ?></td>			
		</tr>
		<tr>
			<td><input type="text" name="address_1" value="" class="large-field" /></td>
		</tr>
		<tr>
			<td><span class="required">*</span> <?php echo $entry_address_2; ?></td>			
		</tr>
		<tr>
			<td><input type="text" name="address_2" value="" class="large-field" /></td>
		</tr>

		<tr>
			<td><span class="required">*</span> <?php echo $entry_postcode; ?></td>			
		</tr>
		<tr>
			<td><input type="text" name="postcode" class="large-field" value="<?php  //if(isset($this->session->data['user_zipcode'])) echo $this->session->data['user_zipcode']; ?>" onchange="rgetchangedvalues();"/></td>
		</tr>
	<!--	<tr>
			<td> <?php echo $entry_city; ?></td>			
		</tr>
		<tr>
			<td><input type="text" name="city" value="" class="large-field" /></td>
		</tr>
		
		<tr>
			<td>  
				 <?php echo $entry_country; ?>
			</td>			
		</tr>
		<tr>
			<td>  
				<select name="country_id" class="large-field">
					<option value=""><?php echo $text_select; ?></option>
					<?php foreach ($countries as $country) { ?>
					<?php if ($country['country_id'] == $country_id) { ?>
					<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td> <?php echo $entry_zone; ?></td>			
		</tr>
		<tr>
			<td>
				<select name="zone_id" class="large-field"></select>
			</td>
		</tr> -->
	</table>
	
	<!------------hidden field for country state city------>
<input type="hidden" name="city" value="" class="large-field" />
<input name="country_id" type="hidden" class="large-field" value='99' /> 
<input type="hidden" name="zone_id" class="large-field" /> 
		<div id="resppincodecont" style="display:none; ">
		
		<span class="lbladdress">CITY :</span> &nbsp; <span id="respcity"></span>
		<br/><br/>
		<span class="lbladdress">STATE :</span> &nbsp; <span id="respstate"></span>
		</div>
</div>

<br />
<!--<p>Would you like to receive SMS alert for this Order? &nbsp;
    <?php if($smsalertcode=='' || $smsalertcode==1) { ?>
    <input type="radio" value="1" name="smsalert" checked="checked">Yes &nbsp; <input type="radio" value="0" name="smsalert">No</p>
    <?php } else { ?>
    <input type="radio" value="1" name="smsalert">Yes &nbsp; <input type="radio" value="0" name="smsalert" checked="checked">No</p>
    <?php } ?>-->
    
<div class="buttons">
	<div class="right">
		<input type="button" value="<?php echo $button_continue; ?>" id="button-payment-address" class="button btn btn-theme-default" />
	</div>
</div>


<script type="text/javascript">
<!--
$('#payment-address input[name=\'payment_address\']').live('change', function() {
	if (this.value == 'new') {
		$('#payment-existing').hide();
		$('#payment-new').show();
	} else {
		$('#payment-existing').show();
		$('#payment-new').hide();
	}
});
//-->
</script> 

<script type="text/javascript">
<!--
$('#payment-address select[name=\'country_id\']').bind('change', function() {
	if (this.value == '') return;
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#payment-address select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#payment-postcode-required').show();
			} else {
				$('#payment-postcode-required').hide();
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
			
			$('#payment-address select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#payment-address select[name=\'country_id\']').trigger('change');
//-->
</script>
<script type="text/javascript">	

$( document ).ready(function() {
	$(".deliverytool").tooltip();  
	rgetchangedvalues();
   });       
function rgetchangedvalues() 
{
	 
 var zip = '<?php if(isset($this->session->data['user_zipcode'])){ echo $this->session->data['user_zipcode'];  }  ?>'; 
var newzip=document.getElementsByName("postcode")[0].value; 
	 
if(zip!=newzip)
{
	zip=newzip; 
} 
	 if(zip != '')
	 {
 
	  $.ajax({
              type: "POST",
             
              url: 'index.php?route=common/home/getstatecity/', 
              data:
              {
              	zipcode:zip,                               
              },
              success: function(resp){
              if(resp !=0){
              var jsonresp=JSON.parse(resp);   

              document.getElementsByName("city")[0].value=jsonresp.city; 
                $("#resppincodecont").show(); 
                $("#respcity").html(jsonresp.city) ;
                $("#respstate").html(jsonresp.state); 
                         
              $.ajax({
              type: "POST",             
              url: 'index.php?route=common/home/getstatecodeinfo/', 
              data:
              {
              	
              	statename:jsonresp.state,                               
              },
              success: function(respnew){
              	if(respnew !=0 ){
              	document.getElementsByName("zone_id")[0].value=respnew; } 
              	
              }
              });
              }
              else
              	{
              	  $("#resppincodecont").hide(); 

              		 document.getElementsByName("city")[0].value="";
              		 document.getElementsByName("zone_id")[0].value="";
              	}	  

              }
        });
      } 
      }
	</script>