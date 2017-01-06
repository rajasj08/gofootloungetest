<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>

<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<table class="radio">
    <?php foreach ($payment_methods as $payment_method) { ?>
    <tr class="highlight">
        <td>
            <?php if(isset($this->session->data['customer_id']) && isset($this->session->data['order_id'])) { 
                if($payment_method['code']=='cod'){
                if(isset($this->session->data['user_zipcode'])) {
                 ?>
                 <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" />
                 </td>
                      <td><label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></label></td>
              <?php } }
                    else {

                ?>
                <?php if ($payment_method['code'] == $code || !$code) { ?>
        <?php $code = $payment_method['code']; ?>

        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" checked="checked" />
        <?php } else { ?>
        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" />
        <?php } ?></td>
        <td><label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></label>
       
                <?php  }
                 } else {?>

                <?php  if(!isset($this->session->data['user_zipcode'])) {

                    if($payment_method['code']=='cod'){}
                        else { ?> 

                       
                 <?php if ($payment_method['code'] == $code || !$code) { ?>
                
        <?php $code = $payment_method['code']; ?>

        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" checked="checked" />
        <?php } else { ?>
        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" />
        <?php } ?></td>
        <td><label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></label>
        <?php  }

                    } else { ?> 
                    <?php if ($payment_method['code'] == $code || !$code) { ?>
                
        <?php $code = $payment_method['code']; ?>

        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" checked="checked" />
        <?php } else { ?>
        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" />
        <?php } ?></td>
        <td><label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></label>
         
        <?php } } ?>
        </td>

    </tr>
    <?php } ?>
</table>
<br />
<?php } ?>

<!--<p>Would you like to receive SMS alert for this Order? &nbsp;
	<?php if($smsalertcode=='' || $smsalertcode==1) { ?>
	<input type="radio" value="1" name="smsalert" checked="checked">Yes &nbsp; <input type="radio" value="0" name="smsalert">No</p>
	<?php } else { ?>
	<input type="radio" value="1" name="smsalert">Yes &nbsp; <input type="radio" value="0" name="smsalert" checked="checked">No</p>
	<?php } ?> -->


<!--
<b><?php echo $text_comments; ?></b>-->
 
<textarea style="visibility: hidden;" name="comment" rows="1" cols="1"><?php echo $comment; ?></textarea>
 


<?php if ($text_agree) { ?>
<div class="buttons">
    <div class="right">
		<?php echo $text_agree; ?>
        <?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?>
        <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="button btn btn-theme-default" />
    </div>
</div>
<?php } else { ?>
<div class="buttons">
    <div class="right">
        <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="button btn btn-theme-default" />
    </div>
</div>
<?php } ?>



<script type="text/javascript">
<!--
    $('.colorbox').colorbox({
       width: 640,
       height: 480
   });
//-->
</script> 