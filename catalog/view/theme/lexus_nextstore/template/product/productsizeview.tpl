<div class="options" >

<?php $sizecount1=0;
						
						//print_r('<pre>'); print_r($this->data['options']); die;
						
						
						foreach ($options as $option) { ?> <!--start foreach-->


						<?php if($option['name']=='Size')
							{
								$sizecount1=count($option['option_value']);

							}  }?>
						<?php if($sizecount1 >0 ){?>
						<label class="col-sm-4 control-label txttransform">Size<span class="mand_field">*</span><?php //echo $text_option; ?></label>  
						<input type="hidden" id="nselectsize" name="nselectsize" value="0">        
						<?php } else {?>
<input type="hidden" id="nselectsize" name="nselectsize" value="-1"> 
						<?php }?>
						<?php 

						$sizecount=0;
						
						//print_r('<pre>'); print_r($this->data['options']); die;
						
						
						foreach ($options as $option) { ?> <!--start foreach-->


						<?php if($option['name']=='Size')
							{
								$sizecount=count($option['option_value']);

							}  ?>

							<?php if ($option['type'] == 'select') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group" style="display:none">
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>
                                                        									
							<select name="option[<?php echo $option['product_option_id']; ?>]">
								<option value=""><?php echo $text_select; ?></option>
								<?php foreach ($option['option_value'] as $option_value) { ?>
								<option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
								<?php if ($option_value['price']) { ?>
								(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
								<?php } ?>
								</option>
								<?php } ?>
							</select>							
						</div>        
						<?php } ?>

						<?php if ($option['type'] == 'radio') { ?>
<?php if( $option['name'] == 'Size'){?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group">
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>	
												<select name="optionvalueinfo" id="optionvalueinfo">
							<?php foreach ($option['option_value'] as $option_value) { ?>
								<option optionid="option[<?php echo $option['product_option_id']; ?>]" optionvalueid="<?php echo $option_value['product_option_value_id']; ?>" value="<?php echo $option_value['product_option_value_id']; ?>">
									<?php echo $option_value['name']; ?>
									<?php if ($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
									<?php } ?>
								</option>
								
							<!--<div class="radio">
								<label for="option-value-<?php echo $option_value['product_option_value_id']; ?>">
									<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />	
									<?php echo $option_value['name']; ?>
									<?php if ($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
									<?php } ?>
								</label>							
							</div> -->
							<?php } ?>
							</select>
						</div>					
						<?php }} ?>

		
		
						<?php if ($option['type'] == 'checkbox') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group" style="display:none">
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>						
							<?php foreach ($option['option_value'] as $option_value) { ?>
							<div class="checkbox">
								<label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
									<input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
									<?php if ($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
									<?php } ?>
								</label>	
							</div>						
							<?php } ?>
						</div>					
						<?php }
						 ?>
			<?php  if ($option['type'] == 'image') {  ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group" >
							
							<div class="option-image">
								<span style="margin-right: 5px;">
								<?php if ($option['required']) { ?>
								<span class="required"></span>
								<?php } ?>
								<b><?php //echo $option['name']; ?></b></span>

								<select name="optionvalueinfo" id="optionvalueinfo" onchange="get_radio_value1()">
								<option value="">--Select Size--</option>   
								<?php foreach ($option['option_value'] as $option_value) {
//$ps = split("<span class='WebRupee'>Rs</span>", $option_value['price']); 
if($mytype == 2){
if( $option_value['quantity'] > 0) {
 ?>									<option optionid="option[<?php echo $option['product_option_id']; ?>]" optionvalueid="<?php echo $option_value['product_option_value_id']; ?>" optionvaluename="<?php echo $option_value['name']; ?>" value="<?php echo $option_value['product_option_value_id']; ?>">
									<?php echo $option_value['name']; ?>
									<?php if ($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
									<?php } ?>
								</option>
								<?php } } else { ?>
<option optionid="option[<?php echo $option['product_option_id']; ?>]" optionvalueid="<?php echo $option_value['product_option_value_id']; ?>" optionvaluename="<?php echo $option_value['name']; ?>" value="<?php echo $option_value['product_option_value_id']; ?>">
									<?php echo $option_value['name']; ?>
									<?php if ($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
									<?php } ?>
								</option>
<?php } ?>
								 
									<!--<span style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]"  value="<?php echo $option_value['product_option_value_id']; ?>" class="selected" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" style="position: absolute;margin-left: 27px;margin-top: 25px;opacity: 0.9; visibility: hidden;" /></span>

									<span><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"> -->
<!--<div class="small-images">
<img id="test<?php echo $option_value['product_option_value_id']; ?>"  width="30" height="30" src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="chstyle" />
</div>  
</label></span>
									<span>
										<label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php //echo $option_value['name']; ?>
											<?php if ($option_value['price']) { ?>
											<!--(<?php //echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)-->
											<!--<?php } ?>
										</label>
									</span>-->
								 
								<?php } ?> 
								</select><span class="caret caretcls" ></span>
								<span id="rid"></span>
								
							<!---	<span class="product-indv-know-your-size-cont">
									<button  class="btn btn-shopping-cart btn-cart-detail" onclick="getproperview();" data-toggle="modal" title="Know Your Foot Size">			 
				 						<span>Know Your Size</span>
									</button>
								</span> ------>

						
							<!---<span class="screndisp">
                                <span class="product-indv-know-your-size-cont">
									<a class="btn btn-shopping-cart btn-cart-detail" href="<?php echo $this->url->link('know-your-size-i7');?>" title="know-your-size">		
				 						<span>Know Your Size</span>
									</a>
								</span>
	</span> -->
							</div>
						</div>
						<?php } ?>

						<?php if ($option['type'] == 'textarea') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group" style="display:none">
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>
							<textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5" class="form-control"><?php echo $option['option_value']; ?></textarea>
						</div>        
						<?php } ?>
		
		
						<?php if ($option['type'] == 'file') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group" style="display:none"> 
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>
							<input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button btn btn-theme-default">
							<input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
						</div>		
						<?php } ?>
		
						<?php if ($option['type'] == 'date') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group" style="display:none">
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
						</div>		
						<?php } ?>		
		
						<?php if ($option['type'] == 'datetime') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group" style="display:none">
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
						</div>        
						<?php } ?>		
		
						<?php if ($option['type'] == 'time') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group" >
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
						</div>        
						<?php } ?>		

								 
		
					
						<?php } ?><!--end foreach-->
  

</div>    						