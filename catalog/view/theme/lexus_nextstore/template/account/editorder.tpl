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
	<div id="content">
		<?php echo $content_top; ?> 
		<h1><?php echo $heading_title; ?></h1>
		
		<div class="content table-responsive">
					<table class="form">
						<tr>
							<td>
								<span class="required">*</span> 
								<?php echo $entry_orderno; ?>
							</td>
							<td>
								<input type="text" name="orderno" id="orderno" value="" />
								<?php if ($error_password) { ?>
								<span class="error"></span>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td>
								
							</td>
							<td>
								<div class="right"><input type="button" value="<?php echo $button_submitcontinue; ?>" class="button btn btn-theme-default" onclick="editorderinfo();" /></div>
							</td>
						</tr>
					</table>
				</div>
				
				<!--<div class="buttons">
					<div class="left"><a href="<?php echo $back; ?>" class="button btn btn-theme-default"><?php echo $button_back; ?></a></div>
					<div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button btn btn-theme-default" /></div>
				</div>-->
		<?php echo $content_bottom; ?>
	</div>
</section> 
		
<?php if( $SPAN[2] ): ?>
	<aside class="col-lg-<?php echo $SPAN[2];?> col-md-<?php echo $SPAN[2];?> col-sm-12 col-xs-12">	
		<?php echo $column_right; ?>
	</aside>
<?php endif; ?>

</div></div>

<script>

$(document).ready(function () {
  //called when key is pressed in textbox
 /* $("#orderno").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
      
               return false;
    }
   }); */ 
});
	function editorderinfo()//edit order info
	{
		var orderno=$("#orderno").val();
		var flag=1;
		if(orderno=='')
		{
			$("#orderno").css('border','1px solid #F00');
			flag=0;
		}
		else{
			/*$.ajax({
			    type: "POST",
			    url: 'index.php?route=account/order/editorderinfos/',   
			    data: {
			      orderno:orderno
			    },
			    success: function(resp){
			     alert(resp);
			  }
			}); */
		} 
		if(flag==1)
		{
		$.ajax({
			    type: "POST",
			    url: 'index.php?route=account/order/ordersession/',   
			    data: {
			      orderno:orderno
			    },
			    success: function(resp){
			    alert(resp);
			      
			    	if(resp==1){
			      window.location.href='https://gofootlounge.in/index.php?route=account/order/goorderinfos';  
			  		}
			  		else
			  		{
			  			alert('Sorry, Invalid Order Number'); 
			  		}
			  }
			});
	}
		

	}

</script>
<?php echo $footer; ?>	