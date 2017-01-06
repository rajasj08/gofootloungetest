<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
var smsalert=$('input[name=smsalert]:checked').val();
	$.ajax({ 
		type: 'get',
		url: 'index.php?route=payment/cod/confirm',
		data:{order_id:$("#edit_orderid").val(),
			smsalert:smsalert
			},
		success: function() {
			location = '<?php echo $continue; ?>';
		}		
	});
});
//--></script> 