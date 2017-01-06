<div class="row">
	<div class="col-lg-6 col-sm-6 col-xs-12">
		<h2><?php echo $text_new_customer; ?></h2>
		<!--<p><?php echo $text_checkout; ?></p> -->
		
		<div class="radio">
			<label for="register">
				<?php if ($account == 'register') { ?>
				<input type="radio" name="account" value="register" id="register" checked="checked" onclick="getaccountbox();"/>
				<?php } else { ?>
				<input type="radio" name="account" value="register" id="register" onclick="getaccountbox();"/>
				<?php } ?>
				<?php echo $text_register; ?>
			</label>
		</div> 

		<div class="form-group register">
		<input type="text" name="emailid_newuser" id="emailid_newuser" class="emailid_newusercls" placeholder="Enter Your Email ID">
		</div>
		
		<div class="radio">
			<?php if ($guest_checkout) { ?>
			<label for="guest">
				<?php if ($account == 'guest') { ?>
				<input type="radio" name="account" value="guest" id="guest" checked="checked" onclick="getaccountbox();"/>
				<?php } else { ?>
				<input type="radio" name="account" value="guest" id="guest" onclick="getaccountbox();"/>
				<?php } ?>
				<?php echo $text_guest; ?>
			</label>
			<?php } ?>
		</div>
		<div class="form-group guest" style="display:none;">
		<input type="text" name="emailid_newuser1" id="emailid_newuser1" class="emailid_newusercls" placeholder="Enter Your Email ID">
		</div>
		
		<div class="form-group">
			<!--<p><?php //echo $text_register_account; ?></p> -->
			<input type="button" value="<?php echo $button_continue; ?>" id="button-account" class="button btn btn-theme-default" />
		</div>
	</div>
	
	
	<div id="login" class="col-lg-6 col-sm-6 col-xs-12 underline">
		<h2><?php echo $text_returning_customer; ?></h2>
		<!--<p><?php echo $text_i_am_returning_customer; ?></p>-->
		
		<div class="form-group">
			<label><?php echo $entry_email; ?></label>
			<input type="text" name="email" value="" class="form-control" />
		</div>
		
		<div class="form-group">
			<label><?php echo $entry_password; ?></label>	  
			<input type="password" name="password" value="" class="form-control" />
		</div>
		
		<div class="form-group">
			<p><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></p>
			<input type="button" value="<?php echo $button_login; ?>" id="button-login" class="button btn btn-theme-default" />
		</div>		
	</div>
</div>
<script>
	function getaccountbox()
	{

		var radioValue = $("input[name='account']:checked"). val();

		if(radioValue == 'guest')
		{
			$('.guest').show();
			$('.register').hide();
		}
		else
		{
			$('.guest').hide();
			$('.register').show(); 
		}
		$("#emailid_newuser").css('border','1px solid #ccc');
		$("#emailid_newuser1").css('border','1px solid #ccc');
	}

</script>