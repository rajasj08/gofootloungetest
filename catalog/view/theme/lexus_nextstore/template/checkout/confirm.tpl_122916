<?php if (!isset($redirect)) { ?>
<div class="checkout-product table-responsive <?php echo $order_id; ?>">
	<table class="table">
		<thead>
			<tr>
				<td class="name"><?php echo $column_name; ?></td>
				<td class="model"><?php echo $column_model; ?></td>
				<td class="quantity"><?php echo $column_quantity; ?></td>
				<td class="price"><?php echo $column_price; ?></td>
				<td class="total"><?php echo $column_total; ?></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($products as $product) { ?>    
			<tr>
				<td class="name">
					<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
					<?php foreach ($product['option'] as $option) { ?>
					<br />
					&nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
					<?php } ?>
				</td>
				<td class="model"><?php echo $product['model']; ?></td>
				<td class="quantity"><?php echo $product['quantity']; ?> 
					&nbsp;
									
				</td>
				<td class="price"><?php echo $product['price']; ?></td>
				<td class="total"><?php echo $product['total']; ?></td>
			</tr>
			<?php } ?>
			<?php foreach ($vouchers as $voucher) { ?>
			<tr>
				<td class="name"><?php echo $voucher['description']; ?></td>
				<td class="model"></td>
				<td class="quantity">1</td>
				<td class="price"><?php echo $voucher['amount']; ?></td>
				<td class="total"><?php echo $voucher['amount']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	
		<tfoot>
			<?php foreach ($totals as $total) { ?>
			<tr>
				<td colspan="4" class="price"><b><?php echo $total['title']; ?>:</b></td>
				<td class="total"><?php echo $total['text']; ?></td>
			</tr>
			<?php } ?>
		</tfoot>
	</table>
</div>
<p>Would you like to receive SMS alert for this Order? &nbsp;
    <?php if($smsalertcode=='' || $smsalertcode==1) { ?>
    <input type="radio" value="1" name="smsalert" checked="checked">Yes &nbsp; <input type="radio" value="0" name="smsalert">No</p>
    <?php } else { ?>
    <input type="radio" value="1" name="smsalert">Yes &nbsp; <input type="radio" value="0" name="smsalert" checked="checked">No</p>
    <?php } ?>

<div class="payment"><?php echo $payment; ?></div>


<?php } else { ?>
<script type="text/javascript">
	<!--
		location = '<?php echo $redirect; ?>';
	//-->
	
</script> 
<?php } ?>

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
<script type="text/javascript">
	
	// change product size from the cart
	function changecartprodsize(product_id,oldsizeval)
	{
		$.ajax({
		    type: "POST",
		    url: 'index.php?route=product/product/getproductoptioninfos/',   
		    data: {
		      product_id:product_id
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
		    alert(jsonresp);

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
			//location.reload();  

		    } 
  		});
	}
	function closeproductSizeModal()
	{
		$("#productSizeModal").modal('hide'); 
	}

</script>