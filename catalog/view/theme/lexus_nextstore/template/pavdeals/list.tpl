<?php
require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/config.tpl" ); 
$cols=3;
$span = floor(12/$cols);
$categoryConfig = array( 		
	'category_pzoom'       => 1,
);

$categoryPzoom 	= $categoryConfig['category_pzoom'];  	
?>

<?php echo $header; ?>
<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/breadcrumb.tpl" );  ?>

<div class="container">
	<div class="row">
		<?php if( $SPAN_DEALS[0] ): ?>
			<aside class="col-lg-<?php echo $SPAN_DEALS[0];?> col-md-<?php echo $SPAN_DEALS[0];?> col-sm-12 col-xs-12">
				<?php echo $column_left; ?>
			</aside>	
		<?php endif; ?>	

		<section class="col-lg-<?php echo $SPAN_DEALS[1];?> col-md-<?php echo $SPAN_DEALS[1];?> col-sm-12 col-xs-12">
			<div id="content">
				<?php echo $content_top; ?>
				<div class="box productdeals list-deals">
					<div class="heading-cont clearfix">
						<h1><?php echo $heading_title; ?></h1>
						<div class="product-filter clearfix">
							<div class="limit">
								<b><?php echo $this->language->get('text_limit');?></b>
								<select onchange="location = this.value;">
									<?php foreach ($limits as $limits) { ?>
									<?php if ($limits['value'] == $limit) { ?>
									<option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</div><!--end limit-->
							<div class="category">
								<b><?php echo $this->language->get('text_category');?></b>
								<select name="category_id" onchange="location = this.value;">
									<option value="<?php echo $href_default;?>"><?php echo $this->language->get("text_category_all"); ?></option>
									<?php foreach ($categories as $category_1) { ?>
									<?php if ($category_1['category_id'] == $category_id) { ?>
									<option value="<?php echo $category_1['href']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></option>
									<?php } ?>
									
									<?php } //endforeach categories_0?>
								</select>
							</div><!--end category-->
							<div class="sort">
								<b><?php echo $this->language->get('text_sort');?></b>
								<select onchange="location = this.value;">
									<?php foreach ($sorts as $sorts) { ?>
									<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
									<option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</div><!--end sort-->
							
						</div><!--end product-filter-->    
					</div>
					<!-- <ul class="box-heading nav nav-tabs">
						<?php foreach ($head_titles as $item): ?>
							<?php if ($item['active']): ?>
								<li class="active"><a href="<?php echo $item['href'];?>"><?php echo $item['text'];?></a></li>
							<?php else: ?>
								<li><a href="<?php echo $item['href'];?>"><?php echo $item['text'];?></a></li>
							<?php endif;?>
						<?php endforeach;?>
					</ul>	-->		

						<div class="product-grid new_list_padd">
							<?php if (count($products) > 0): ?>
								<?php 
								
								foreach( $products as $i => $product ):  $i=$i+1;?>
								<?php  	 
									$scd= $product['price'];
									$scd = preg_replace('/\D/', '', $scd);
									$scd1 = $product['special'];
									$scd1 = preg_replace('/\D/', '', $scd1);
									$sum_total =   round((($scd  - $scd1)/$scd)*100, 0);


									foreach($product['size'] as $datan)
									{
									 if($datan['name'] == 'Size')
									  {$sizearrayq=array(); 
									$sizearray=array();
									      foreach($datan['option_value'] as $data1)
									        {      
									            $sizearray[]=$data1['name']; 
									           if($data1['quantity'] > 0)
									           {
									              $sizearrayq[]=$data1['name'];
									           }
									        }
									  } 
									}



		?>
									<?php if( $i%$cols == 1 || $cols == 1): ?>
										<div class="row new_list_mb">
										<?php endif; ?>
										<div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-4 col-xs-12">
											<div class="product-block">
													<?php if ($product['thumb']) { ?>
					<?php $product_images = $this->model_catalog_product->getProductImages( $product['product_id'] ); ?>
					<div class="image <?php echo isset($product_images[0])?$swapimg:''; ?>">
												
						
						<?php /*if( $categoryPzoom ) { $zimage = str_replace( "cache/","", preg_replace("#-\d+x\d+#", "",  $product['thumb'] ));  ?>
							<a href="<?php echo $product['thumb']; ?>" class="info-view colorbox product-zoom" rel="colorbox" title="<?php echo $product['name']; ?>"><i class="fa fa-search-plus"></i></a>
						<?php } */ ?>



						<!-- Swap image -->
						<div class="flip">

							<?php if($product['quantity']<=0) { ?>
							<a href="javascript:void(0);"><span class="stockOutBg">&nbsp;</span><span class="stockOutText">Out Of Stock</span></a> 
							<?php }
							
							

							 ?>


						
							<a href="<?php echo $product['href']; ?>" class="swap-image">
								<img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" class="front" />
								<?php 
								if( $categoryConfig['show_swap_image'] ){
									$product_images = $this->model_catalog_product->getProductImages( $product['product_id'] );
									if(isset($product_images) && !empty($product_images)) {
										$thumb2 = $this->model_tool_image->resize($product_images[0]['image'],  $this->config->get('config_image_product_width'),  $this->config->get('config_image_product_height') );
									?>	
									<img src="<?php echo $thumb2; ?>" alt="<?php echo $product['name']; ?>" class="back" />
								<?php } } ?>								
							</a>
						</div>




						<div class="product-cont">
							<?php if( $product['is_newarrival'] &&  $product['is_newarrival']  != 0) {   ?>	
								<span class="product-label product-label-newarrival">
									<span>&nbsp;</span>  								
								</span>							
							<?php } ?>
							<?php if( $product['special'] ) {   ?>	
								<span class="product-label product-label-special">
									<span><?php echo $sum_total; ?>%</span>  								
								</span>							
							<?php } ?>	
							<?php if($product['quantity']<=0) { ?>
								
							<?php } else { ?>
								<a href="<?php echo $product['href']; ?>"><span class="product-cont-overlay">
									&nbsp;
								</span></a>
							<?php } ?>

							<div class="action">

								<div class="action-cont <?php if($product['quantity'] <= 0) { ?>out-of-stock<?php } ?>">
								<?php if($product['quantity'] <= 0) {  } else { ?>
									<div class="crtbtn">
									<div class="cart">									
										<a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="btn btn-shopping-cart" title="Add to Cart">
											<span class="fa fa-shopping-cart product-icon hidden-sm hidden-md">&nbsp;</span>
											<span><?php echo $button_cart; ?></span>
										</a>										
									</div>
								    </div>
									
									<div class="button-group">
										<div class="wtbutton">
										<div class="wishlist" <?php if($product['quantity'] <= 0) { ?>style=" width:35px;"<?php } ?>> 
											<a onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get("button_wishlist"); ?>" class="fa fa-heart product-icon">
												<?php //echo $this->language->get("button_wishlist"); ?>
											</a>
										</div>
									</div>
										<div class="compare">
											<a onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get("button_compare"); ?>" class="fa fa-refresh product-icon">
												<?php //echo $this->language->get("button_compare"); ?>
											</a>
										</div>
									</div>
									<?php } ?>
								</div>

									<?php if($product['quantity']<=0) { ?>
									<!--<div class="quick-view mailview" id="mailview1" style=""> 
										
											<a class="btn btn-theme-default" onclick="javascript:;notifyemail('<?php echo $product['name']; ?>','<?php echo $product['href']; ?>','<?php echo $product['product_id']; ?>');" id="mainbtn" style=" height:34px !important; width:34px !important; padding-top:5px !important;" title="Notify Me when In Stock"><em class="fa fa-envelope"></em><span>&nbsp;&nbsp;<?php //echo $sendmail_text; ?></span></a>       
																		
									</div> -->
								<?php } if($product['quantity']<=0) { ?>

								<div class="notifycls listcls"> 
								<a onclick="javascript:;notifyemail('<?php echo $product['name']; ?>','<?php echo $product['href']; ?>','<?php echo $product['product_id']; ?>');">Notify When In Stock</a>
								</div>

								<?php } ?>   
							</div>
						</div>

					</div>
				<?php } ?>
												<div class="product-meta">

													
													<h3 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h3>
												
													<!--<div class="rating">
														<?php if ($product['rating']): ?>
															<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" />
														<?php endif; ?>
													</div>-->
													<?php if ($product['price']): ?>
														<div class="price">
															<?php if (!$product['special']): ?>
																<?php echo $product['price']; ?>
															<?php else: ?>
																<span class="price-old"><?php echo $product['price']; ?></span> 
																<span class="price-new"><?php echo $product['special']; ?></span>
															<?php endif; ?>
														</div>
													<?php endif; ?>													

													<div class="group-deals">
														<div id="item<?php echo $module; ?>countdown_<?php echo $product['product_id']; ?>" class="item-countdown"></div>
														<script type="text/javascript">
															jQuery(document).ready(function($){
																$("#item<?php echo $module; ?>countdown_<?php echo $product['product_id']; ?>").lofCountDown({
																	formatStyle:2,
																	TargetDate:"<?php echo date('m/d/Y G:i:s', strtotime($product['date_end_string'])); ?>",
																	DisplayFormat:"<ul><li>%%D%% <div><?php echo $this->language->get("text_days");?></div></li><li> %%H%% <div><?php echo $this->language->get("text_hours");?></div></li><li> %%M%% <div><?php echo $this->language->get("text_minutes");?></div></li><li> %%S%% <div><?php echo $this->language->get("text_seconds");?></div></li></ul>",
																	FinishMessage: "<?php echo $this->language->get('text_finish');?>"
																});
															});
														</script>
														<div class="deal-collection">
															<div class="deal_detail">
																<ul>
																	<!--<li>
																		<span><?php echo $this->language->get("text_discount");?></span>
																		<span class="deal_detail_num"><?php echo $product['deal_discount'];?>%</span>
																	</li> -->
																	<li>
																		<span><?php echo $this->language->get("text_you_save");?></span>
																		<span class="deal_detail_num"><span class="price"><?php echo $product["save_price"]; ?></span></span>
																	</li>
																	<!--<li>
																		<span> <?php echo $this->language->get("text_bought");?> </span>
																		<span class="deal_detail_num"><?php echo $product['bought'];?></span>
																	</li> -->
																</ul>
															</div>
															<div class="deal-qty-box">
																<?php //echo sprintf($this->language->get("text_quantity_deal"), $product["quantity"]);?>
                                                                
																<?php 
                                                                 
																$resultq='';  if($sizearrayq) { 

																	$resultq=array_diff($sizearray,$sizearrayq);

																	if($resultq)
																	{
																	/*$qdata=''; 

																	foreach($sizearrayq as &$qdata)
																	{
																	 $qdata = 'Size '.$qdata;

																	}
																	*/


																	$sizestr=implode(", ",$sizearrayq);
																	echo 'Hurry, Just Size '.$sizestr.' left'; 
																	}
																	}?>
															</div>
															<div class="item-detail">
																<div class="timer-explain">(<?php echo date($this->language->get("date_format_short"), strtotime($product['date_end_string'])); ?>)</div>
															</div>
														</div>
													</div>
													
													<div class="action">							
														
														<div class="cart">						
							        						<!-- <input type="button" value="<?php //echo $button_cart; ?>" onclick="addToCart('<?php //echo $product['product_id']; ?>');" class="product-icon fa fa-shopping-cart shopping-cart" /> -->
															<button onclick="addToCart('<?php echo $product['product_id']; ?>');" class="btn btn-shopping-cart">
																<span class="fa fa-shopping-cart product-icon hidden-sm hidden-md">&nbsp;</span>
																<span><?php echo $button_cart; ?></span>
															</button>
							      						</div>
							      					 
														<div class="button-group">
															
															<div class="wishlist">
																<a onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get("button_wishlist"); ?>" class="fa fa-heart product-icon">
																	<?php // echo $this->language->get("button_wishlist"); ?>
																</a>	
															</div>
														    
															<div class="compare">			
																<a onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get("button_compare"); ?>" class="fa fa-refresh product-icon">
																	<?php // echo $this->language->get("button_compare"); ?>
																</a>	
															</div>
														</div>														
													</div>

												
												</div>
											</div>
										</div>

										<?php if($i%$cols == 0): ?>
										</div>
									<?php endif; ?>

								<?php endforeach; ?>

							</div><!--end carousel-inner-->

						<?php else: ?>
							<div class="product-empty"><?php echo $this->language->get('text_not_empty');?></div>
						<?php endif; ?>

					</div><!--end product-grid-->
				</div><!--end box-content-->

				<div class="pagination paging clearfix"><?php echo $pagination?></div>
			</div>
			<?php echo $content_bottom; ?>

		</section>

		<?php if( $categoryPzoom ) {  ?>
		<script type="text/javascript">
			<!--
			$(document).ready(function() {
				$('.colorbox').colorbox({
					overlayClose: true,
					opacity: 0.5,
					rel: false,
					onLoad:function(){
						$("#cboxNext").remove(0);
						$("#cboxPrevious").remove(0);
						$("#cboxCurrent").remove(0);
					}
				});	 
			});
//-->
</script>
<?php } ?>

<?php if( $SPAN_DEALS[2] ): ?>
	<aside class="col-lg-<?php echo $SPAN_DEALS[2];?> col-md-<?php echo $SPAN_DEALS[2];?> col-sm-12 col-xs-12">	
		<?php echo $column_right; ?>
	</aside>
<?php endif; ?>

</div></div>



<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="closemodal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">EMAIL NOTIFICATION</h4>
      </div>
      <div class="modal-body">
     <!-- <div style="margin-bottom: 20px;" ><p>This product has been solded out! Kindly fill the following details, our executive will contact you in another 48 hours. <a href="https://gofootlounge.in/new-arrivals"><span style="color: #CD6927 " id="modal_content">Happy Shopping</span><a></p></div> -->
     <div class="new_list_mb" ><p> Notify me when the product is back in Stock!</p></div>

       	<form class="form-horizontal">
       	<input type="hidden" id="npro_id" name="npro_id">
       	<input type="hidden" id="pro_name" name="pro_name">
       		<input type="hidden" id="pro_href" name="pro_href">
       	<div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Product Name</label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control new_list_cstyle" id="Nproductname" placeholder="Product Name" disabled="disabled">
		    </div>
		  </div>
		   <div class="form-group" id="respcontent">
		  
		  </div> 

		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-4 control-label">Email<span class="mand_field">*</span></label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="Nemail" placeholder="Required">
		    </div>
		  </div>
		 <!-- <div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Name<span class="mand_field">*</span></label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="Nname" placeholder="Name">
		    </div>
		  </div> -->

		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Mobile Number</label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="Nmobileno" placeholder="Optional"> 
		    </div>
		  </div>

		<!-- <div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Comments</label>
		    <div class="col-sm-6">
		      <textarea class="form-control" id="NComments" placeholder="Comments"></textarea>
		    </div>
		  </div> -->

		</form>
      </div>
      <div class="modal-footer new_list_padds">
      <span class="alert alert-success new_list_padds1" id="success_msgaa">send successfully</span>
      <span class="alert alert-danger new_list_padds1" id="failure_msg">sending failed</span>
      	<img src="https://gofootlounge.in/image/loading_spinner.gif" alt="loading..." id="image_spinner">
        <button type="button" class="btn btn-default" id="closebtn" onclick="closemodal();">Close</button>
        <button type="button" class="btn btn-primary" id="sendbtn" onclick="sendnotify();">Send</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
  	if($idsval) {echo $idsval;} else echo '""'; ?>, 	
  	 	<?php }?>
ecomm_pagetype: "category",
ecomm_categorytype: "Category > <?php  $actual_link ="$_SERVER[REQUEST_URI]";

					$subval=strstr($actual_link,'/'); 
					
					$subval1=str_replace('/',' > ',$subval);
					$subvaln=strstr($subval1,'?');
					$subval3=str_replace($subvaln,'',$subval1);
					$subval2=str_replace('/',' > ',$subval3);   
					echo trim($subval2,"> ");  
					 ?>",  
<?php if(count($products)>1) { ?>			  
ecomm_totalvalue: [<?php $count=count($products); $j=1;$priceval='';
  foreach ($products as $i => $product) { 
  	
  	if($j<$count)
  		{$comma=",";}else{$comma="";} 
  	if (!$product['special']) {$finalprice=$product['price'];}else{$finalprice=$product['special'];}
  	$finalprice=str_replace(",","",$finalprice); 
  	$orgprice=str_replace("<span class='WebRupee'>Rs</span>","",$finalprice);
   	$priceval.=number_format($orgprice,2, '.', '').$comma;   
  	$j++;  
  	 }     
  	 echo $priceval; ?>], 
<?php } else { ?>
	ecomm_totalvalue: <?php $count=count($products); $j=1;$priceval='';
  foreach ($products as $i => $product) {   	
  	
  	if (!$product['special']) {$finalprice=$product['price'];}else{$finalprice=$product['special'];}
  	$finalprice=str_replace(",","",$finalprice); 
  	$orgprice=str_replace("<span class='WebRupee'>Rs</span>","",$finalprice);
   	$priceval.=number_format($orgprice,2, '.', '');   
  	$j++;  
  	 }     
  	
  	 if($priceval) {echo $priceval;} else echo '""'; ?>, 
<?php } ?>  
};
</script>
<?php echo $footer; ?> 