<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/config.tpl" );

	$themeConfig = (array)$this->config->get('themecontrol');
	$productConfig = array(  	  
		'product_enablezoom'         => 1,
		'product_zoommode'           => 'basic',
		'product_zoomeasing'         => 1,
		'product_zoomlensshape'      => "round",
		'product_zoomlenssize'       => "150",
		'product_zoomgallery'        => 0,
		'enable_product_customtab'   => 0,
		'product_customtab_name'     => '',
		'product_customtab_content'  => '',
		'product_related_column'     => 0,        
	);
  
	$categoryConfig = array( 	
		'category_pzoom'				          	=> 1,	
		'quickview'                                 => 0,
		'show_swap_image'                       	=> 0,
	); 

$categoryConfig  				= array_merge($categoryConfig, $themeConfig );
$categoryPzoom 	    			= $categoryConfig['category_pzoom']; 
$quickview          			= $categoryConfig['quickview'];
$swapimg           				= ($categoryConfig['show_swap_image'])?'swap':'';

$productConfig 		            = array_merge( $productConfig, $themeConfig );  
$languageID 			        = $this->config->get('config_language_id');   


?>


<?php echo $header; $this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js'); ?>

<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/breadcrumb.tpl" );  ?>
<div class="container">

	<?php if($lounge_guide) {  ?>
		<div class="row">
			<div class="col-md-12">
				<div id="lounge-guide">
					<div class="heading_title inline">Lounge Tip: </div>
					<div class="text inline"><?php echo $lounge_guide; ?></div>
				</div>
			</div>
		</div>
	<?php  } ?>
	
<div class="row">
 
<?php if( $SPAN[0] ): ?>
	<aside class="col-md-<?php echo $SPAN[0];?>">
		<?php echo $column_left; ?>
	</aside>
<?php endif; ?> 
<style>
.bb{ 
color:red;
}
</style>
<script type="text/javascript">
function get_radio_value(a) {
			
               if(a == ''){
document.getElementById('kdesc').style.display = "none";

}
else
{
                                 document.getElementById('kdesc').style.display = "block";
				 document.getElementById("kdesc").innerHTML = "+ <span class='WebRupee'>Rs</span> <font color=yellowgreen style='font-size:20px'>"+ a + " </font>";
}
          }

        </script>

<script type="text/javascript">
$(function(){

    $("#big-image img:eq(0)").nextAll().hide();
    $(".small-images img").click(function(e){
        var $this = $(this),
            index = $this.index();
        $(".small-images img").removeClass('selected');
        $this.addClass('selected');
        $("#big-image img").eq(index).show().siblings().hide();
    });
});
</script>


<style>
.small-images a, .big-images a {display:inline-block}
.small-images .selected {border:4px solid #f47116 !important}
</style>
<?php 

if($discountofferprod) {
	$sum_total1=0;

			if($special)
			{
				$scda= $price;
				$scda = preg_replace('/\D/', '', $scda);
				$scda1 = $special;
				$scda1 = preg_replace('/\D/', '', $scda1);
				$sum_total1 =   round((($scda  - $scda1)/$scda)*100, 0); 
			} 
			
			
			if($specialorg1)
			{
			$scd= $price;
			$scd = preg_replace('/\D/', '', $scd);
			$scd1 = $specialorg1;
			$scd1 = preg_replace('/\D/', '', $scd1);
			$sum_total =   round((($scd  - $scd1)/$scd)*100, 0);

			$sum_total1=$sum_total1-$sum_total;

			}

}
			
			
?>
<section class="col-md-<?php echo $SPAN[1];?>">  
	<div id="content" class="product-detail">
		<?php echo $content_top; ?>		
		<div class="product-info">
			<div class="row">	
			<input type="hidden" id="editorderid" value="<?php echo $this->session->data['editorder_id']; ?> ">		
				<?php if ($thumb || $images) { ?>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 image-container">
					<div class="product-cont">
						<?php if( isset($date_available) && $date_available == date('Y-m-d')) {   ?>	    	
							<span class="product-label product-label-new">
								<span><?php echo $this->language->get( 'text_new' ); ?></span>	
							</span>												
						<?php } ?>	
						
						<?php if($discountofferprod) { ?>
						<span class="product-label product-label-special popupdis popupdisprod">
									<span><?php if($specialorg1) { ?> + <?php } ?> Extra <?php echo $sum_total1; ?>%</span>  								
								</span>	
						<?php } ?>		

						<?php //if( $sum_total )  {
							if($discountofferprod){
if( $sum_total )  {
								?>
								<span class="product-label product-label-special"><span><?php echo $sum_total; ?>%</span></span>
								
							<?php } } else { if($saving) {
						 ?>          
							<span class="product-label product-label-special"><span><?php echo $saving; ?>%</span></span>
						<?php } }// } ?>
				
						<?php if ($thumb) { ?>
						<div class="image">
							<a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox">
								<img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image"  data-zoom-image="<?php echo $popup; ?>" class="product-image-zoom img-responsive"/>
							</a>
						</div>
						<?php } ?>		
				
				
						<?php if ($images) { ?>
						<div class="image-additional slide carousel" id="image-additional">
							<div id="image-additional-carousel" class="carousel-inner">
								<?php 
								if( $productConfig['product_zoomgallery'] == 'slider' && $thumb ) {  
									$eimages = array( 0=> array( 'popup'=>$popup,'thumb'=> $thumb )  ); 
									$images = array_merge( $eimages, $images );
								}
								$icols = 4; $i= 0;$z=1;
								foreach ($images as  $image) { ?>
									<?php if( (++$i)%$icols == 1 ) { ?>
									<div class="item clearfix">
									<?php } ?>
										<a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="<?php if($z>1) echo "colorbox"; ?>" data-zoom-image="<?php echo $image['popup']; ?>" data-image="<?php echo $image['popup']; ?>">
											<img src="<?php echo $image['thumb']; ?>" style="max-width:<?php echo $this->config->get('config_image_additional_width');?>px"  title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" data-zoom-image="<?php echo $image['popup']; ?>" class="product-image-zoom img-responsive" />
										</a>
									<?php if( $i%$icols == 0 || $i==count($images) ) { ?>
									</div>
								  <?php } $z++; ?>
								<?php } ?>		
							</div>

							<!-- Controls -->
							<a class="left carousel-control" href="#image-additional" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							</a>
							<a class="right carousel-control" href="#image-additional" data-slide="next">							
								<i class="fa fa-angle-right"></i>
							</a>

						</div>			
						<script type="text/javascript">
							$('#image-additional .item:first').addClass('active');
							$('#image-additional').carousel({interval:false})
					</script>
					<?php } ?>     
				</div>		
				</div>
				<?php } ?>
		
	
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 product-view">				
					<h1><?php echo $heading_title; ?></h1>	

					<?php if ($review_status) { ?>
					<div class="review" style="margin-bottom:5px!important">
						<div><img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $reviews; ?></a><a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php //echo $text_write; ?></a></div>
					</div>
					<?php } ?>

					<div class="description">
						<?php if ($manufacturer) { ?>
							 
								<b><?php echo $text_manufacturer; ?></b>
								<a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a>&nbsp;|&nbsp;								
							 	
						<?php } ?>
						 
							<b><?php echo $text_model; ?></b>
							<?php echo $model; ?> &nbsp;
						 
						<?php if ($reward) { ?>
							 
								<b><?php echo $text_reward; ?></b>
								<?php echo $reward; ?> &nbsp;	
							 
						<?php } ?>						
						 	
					</div>
							
		 		
							<?php if ($price) { ?>
					<div class="price" style="padding:0px!important">
						<div class="price-gruop">

							<?php if (!$special) { ?>
								<?php echo $price; ?>
							<?php } else { 
								if($discountofferprod){
								?>
							<span><span class="price-old"><?php echo $price; ?></span>&nbsp;
							<?php if($specialorg1){ ?>
							<!--<span class="price-old oldspecial">Regular Price:&nbsp;<?php echo $specialorg1; ?></span> -->
							<?php } ?>
							</span>
							
							&nbsp;<span class="price-new specialpricenew"><span class="showsploffmsg" data-toggle="popover" data-trigger="hover" data-content="<p class='proddisccontent'>(Special Price because you bought <span class='proddisccontent1'><a class='proddisccontent1' href='https://gofootlounge.in/index.php?route=product/product&product_id=<?php echo trim($mainproductidinfo); ?>'><?php echo $mainproductname; ?></a></span>)</p>"><i class='fa fa-check' aria-hidden='true'></i></span>You Pay:&nbsp;<?php echo $special; ?> <!--<span class="income"><?php echo $saving; ?>% <?php echo $text_income; ?></span> --></span> 
							
							<?php }
							else{
								?>
								<span class="price-old"><?php echo $price; ?></span>&nbsp;
								<span class="income">(<?php echo $saving; ?>% <?php echo $text_income; ?>)</span>&nbsp;
							<span class="price-new"><?php echo $special; ?></span> 
							
							<?php }

							} ?>
<div id="kdesc" style="font-size:19px;color:yellowgreen ;font-weight:bold;display:none"></div>
		
						</div>	
						<?php if($discountofferprod){
								?>		
		 			<!--<p class="proddisccontent">Special price by adding this product <span class="proddisccontent1"><a class="proddisccontent1" href="https://gofootlounge.in/index.php?route=product/product&product_id=<?php echo trim($mainproductidinfo); ?>"><?php echo $mainproductname; ?></a></span></p> -->
		 			
		 			<?php } ?> 
						<div class="other-price">
							<?php if ($tax) { ?>
								<!--<span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span><br/>-->
							<?php } ?>
							<?php if ($points) { ?>
								<span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span>
							<?php } ?>
						</div>			 		
						<?php if ($discounts) { ?>	 		
						<div class="discount"> 
							<ul>
								<?php foreach ($discounts as $discount) { ?>							
								<li class="new_product_org">Discount: <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?></li>
								<?php } ?>
							</ul>
						</div>
						<?php } ?>
					</div>
					<?php } ?>
						  	
 <?php if ($stock == "In Stock"){

			?>
					<?php if ($options) { ?>	

					
									
					<div class="options" >
						<h2><?php echo $text_option; ?></h2>        
						<?php 

						$sizecount=0;
						
						//print_r('<pre>'); print_r($this->data['options']); die;
						
						//print_r('<pre>'); print_r($options); die;
						foreach ($options as $option) { ?>


						<!-----code did by Elakkiya.R-------->
						<?php if($option['name']=='Size')
							{
								$sizecount=count($option['option_value']);

							}  ?>

						<?php if ($option['type'] == 'select') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group new_product_new1" >
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
							<?php foreach ($option['option_value'] as $option_value) { ?>
							<div class="radio">
								<label for="option-value-<?php echo $option_value['product_option_value_id']; ?>">
									<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />	
									<?php echo $option_value['name']; ?>
									<?php if ($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
									<?php } ?>
								</label>							
							</div>
							<?php } ?>
						</div>					
						<?php }} ?>

		
		
						<?php if ($option['type'] == 'checkbox') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group new_product_new1" >
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

		
		
						<?php if ($option['type'] == 'image') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group" >
							
							<div class="option-image">
								<span class="new_product_new2">
								<?php if ($option['required']) { ?>
								<span class="required"></span>
								<?php } ?>
								<b><?php echo $option['name']; ?>:</b></span>
								<?php foreach ($option['option_value'] as $option_value) {
$ps = split("<span class='WebRupee'>Rs</span>", $option_value['price']);

 ?>
								 
									<span class="new_product_new3"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]"  value="<?php echo $option_value['product_option_value_id']; ?>" class="selected new_product_new4" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></span>

									<span><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>">
<div class="small-images">
<img id="<?php echo $option_value['product_option_value_id']; ?>"  width="30" height="30" src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" onclick="get_radio_value('<?php echo @$ps[1]; ?>')"/>
</div>
</label></span>
									<span>
										<label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php //echo $option_value['name']; ?>
											<?php if ($option_value['price']) { ?>
											<!--(<?php //echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)-->
											<?php } ?>
										</label>
									</span>
								 
								<?php } ?> <span id="rid"></span>
								
								<span class="product-indv-know-your-size-cont">
									<a  class="sizechartnewc" onclick="getproperview();" data-toggle="modal" title="Size Chart"> 	  		 
				 						<span>Size Chart</span>
									</a>
								</span>

						
							<span class="screndisp">
                               <span class="product-indv-know-your-size-cont">
									<a  class="sizechartnewc" onclick="getproperview();" data-toggle="modal" title="Size Chart"> 	  		 
				 						<span>Size Chart</span>
									</a>
								</span>
	</span>
							</div>
						</div>
						<?php } ?>

		
						<?php if ($option['type'] == 'text') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group new_product_new1">
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
						</div>		
						<?php } ?>
	
	
						<?php if ($option['type'] == 'textarea') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group new_product_new1">
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>
							<textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5" class="form-control"><?php echo $option['option_value']; ?></textarea>
						</div>        
						<?php } ?>
		
		
						<?php if ($option['type'] == 'file') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group new_product_new1"> 
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>
							<input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button btn btn-theme-default">
							<input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
						</div>		
						<?php } ?>
		
						<?php if ($option['type'] == 'date') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group new_product_new1">
							<?php if ($option['required']) { ?>
							<p><span class="required">*</span>
							<?php } ?>
							<b><?php echo $option['name']; ?>:</b></p>
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
						</div>		
						<?php } ?>		
		
						<?php if ($option['type'] == 'datetime') { ?>
						<div id="option-<?php echo $option['product_option_id']; ?>" class="option form-group new_product_new1">
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
				
					<?php } ?>
				</div>
			<?php } 
}
			?>
			 <div class="product-availability <?php if ($stock == "Out Of Stock"){ echo "outofstockspace"; } ?>">
			 <?php if ($stock == "Out Of Stock"){ ?>
				<b><?php echo $text_stock; ?></b>

				
				<span class="availability <?php if ($stock == "Out Of Stock"){ echo "outofstockcls"; }?>
"><?php echo $stock; ?></span>

			<?php } ?>	
  			<?php if ($stock == "Out Of Stock"){ } else { ?>
  			<!--<?php if(isset($this->session->data['user_zipcode'])){ ?> 
  			<?php if(isset($this->session->data['user_zipcodeavail'])){ ?> 
  			<div id="codupdate"><span class="cds_style"> COD AVAILABLE for this pincode <?php echo $this->session->data['user_zipcode']; ?></span> <input type="button" class="cds_style cds_style1" onclick="showcod();" href="javascript:void(0);" value="EDIT"></div>
  			<?php } else{ ?>
  				<div id="codupdate"><span class="cds_style"> Prepaid Delivery Only for Pincode <?php echo $this->session->data['user_zipcode']; ?> <input type="button" class="cds_style cds_style1" onclick="showcod();" href="javascript:void(0);" value="EDIT"></div>
  			<?php }?>	 
  			 <?php } else { ?> 
			<span class="cds_style2" id="codupdate" onclick="showcod();" href="javascript:void(0);">Check COD Availability for Pincode</span> 
			<?php } ?> -->
			<?php } ?> 

			</div>

			<?php if ($stock == "Out Of Stock"){ ?>


		<div class="description">
				
			<!--	<p style=" font-weight:bold;">Notify me when this product is in stock</p> -->

				<form name="notify-me-form" onsubmit="notifyMe">
           <!-- <span class="email-text">Email</span>:

            <input type="hidden" name="fsn" value="">
            <input type="hidden" name="referrer" value="">
            <input type="hidden" name="price" value="">
            <input type="text" class="email-id" name="email-id" id="notify_mailid" autofocus="true" maxlength="32" value="" placeholder="Please enter your Email id" style=" border:1px solid #ccc;"> -->
            <!--<button type="button" class="btn-notify-me btn-new" name="notify-me" style=" color:#FFF; background:#3A3636; width:45px !important	;" onclick="notifyemail('<?php echo $heading_title; ?>','<?php echo "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>' );" title="Notify Me when In Stock"><em class="fa fa-envelope"></em><span></button> -->


								<div class="notifycls1"> 
								<a onclick="javascript:;notifyemail('<?php echo $heading_title; ?>','<?php echo $n_href; ?>','<?php echo $n_product_id; ?>');">Notify When In Stock</a> 
								</div> 
 
							
        </form>

				
			</div>  




			<?php } ?>


			<?php if ($stock == "In Stock"){

			?>
			
			
			
			<div class="product-extra">
				<!--<div class="quantity-adder pull-left">
					<div class="quantity-number pull-left">
						<span><?php echo $text_qty; ?></span>
						<input type="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
					</div>
					<div class="quantity-wrapper pull-left">
						<span class="add-up add-action fa fa-plus"></span> 
						<span class="add-down add-action fa fa-minus"></span>
					</div>					
					<input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />	
				</div>	-->										
				<div class="cart pull-left">	<input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />								
					<!-- <input type="button" value="<?php //echo $button_cart; ?>" id="button-cart" class="button btn btn-theme-default" /> -->

					<button id="button-buynow" class="btn btn-shopping-cart btn-cart-detail orange newstyleorangebtn">						
						<!-- <span class="product-icon hidden-sm hidden-md">&nbsp;</span> -->
						<span class="buynowbigbtn"> ADD TO CART <?php //echo $button_buynow; ?></span>
					</button>

					<!--<button id="button-cart" class="btn btn-shopping-cart btn-cart-detail grey">						
						<span class="fa fa-shopping-cart product-icon hidden-sm hidden-md">&nbsp;</span>
						<span><?php echo $button_cart; ?></span>
					</button> -->

					

				</div>
				<div class="pull-left">

					<div class="pull-left">
						<a class="wishlist newwishlistsyl" onclick="addToWishList('<?php echo $product_id; ?>');" title="add to wishlist">
							<i class="fa fa-heart"></i>
							<?php //echo $button_wishlist; ?>
						</a>				
					</div>&nbsp;&nbsp;&nbsp;
					
				</div>
				<!-- <span>&nbsp;&nbsp;<?php //echo $text_or; ?>&nbsp;&nbsp;</span> -->
			</div>

			<div class="prodpagecod">
			<?php if(isset($this->session->data['user_zipcode'])){ ?> 
  			<?php if(isset($this->session->data['user_zipcodeavail'])){ ?> 
  			<div id="codupdate"><span class="cds_style" data-toggle="tooltip" data-placement="right" title="Check COD Availability"> COD AVAILABLE <?php echo $this->session->data['user_zipcode']; ?></span> <input type="button" class="cds_style cds_style1" onclick="showcod();" href="javascript:void(0);" value="EDIT"></div>
  			<?php } else{ ?>
  				<div id="codupdate"><span class="cds_style" data-toggle="tooltip" data-placement="right" title="Check COD Availability"> Prepaid Delivery Only for Pincode <?php echo $this->session->data['user_zipcode']; ?> <input type="button" class="cds_style cds_style1" onclick="showcod();" href="javascript:void(0);" value="EDIT"></div>
  			<?php }?>	 
  			 <?php } else { ?> 
			<span class="cds_style2" id="codupdate" onclick="showcod();" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Check COD Availability">Check COD Availability</span>
			<?php } ?>
			<!--------Newly Added------>
			<p><i class='fa fa-check' aria-hidden='true'></i>&nbsp; Free Shipping&nbsp; &nbsp;<i class='fa fa-check' aria-hidden='true'></i>&nbsp;Free 15 day Returns &nbsp;&nbsp;<i class='fa fa-check' aria-hidden='true'></i>&nbsp; 100% Authentic Products</p> 
			</div>  
<?php

}



 ?>



			<?php if ($minimum > 1) { ?>
				<div class="minimum"><small><?php echo $text_minimum; ?></small></div>
			<?php } ?>			
				
			<div class="share">
			<a class="sharesocial">SHARE: &nbsp;</a> 
				<!-- AddThis Button END --> 				
				<div class="addthis_default_style">
				<a onclick="PopupCenter('https://plus.google.com/share?url=https://gofootlounge.in','xtf','450','400');"><img class="piconcls" src="https://gofootlounge.in/image/social-icons/google_plus27.png"></a>&nbsp;&nbsp;<a onclick="PopupCenter('https://twitter.com/intent/tweet?text=@go_footlounge&','xtf','450','400');"><img class="piconcls" src="https://gofootlounge.in/image/social-icons/twittersmall1.png"></a>&nbsp; 
				<a onclick="PopupCenter('http://www.facebook.com/sharer/sharer.php?u=https://gofootlounge.in','xtf','450','400');"> <img class="piconcls" src="https://gofootlounge.in/image/icon-facebook.png"></a>
				
				</div>
				<script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script> 
				<!-- AddThis Button BEGIN --> 
			</div>	
			<?php if ($tags) { ?>
			<div class="tags">
				<b><?php echo $text_tags; ?></b>
				<?php for ($i = 0; $i < count($tags); $i++) { ?>
				<?php if ($i < (count($tags) - 1)) { ?>
				<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
				<?php } else { ?>
				<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
				<?php } ?>
				<?php } ?>
			</div>
			<?php } ?>  
		</div>
	</div>
</div>

  
<div class="product-desc">
	


	
	
	
<h3 class="heading-title">Product Specification</h3>
	<div id="product-description">
		<?php echo $description; ?>
	</div>

	<?php if($prod_highlight) {  ?>
		<h3 class="heading-title">Product Highlight</h3>
			<div id="product-highlight" class="table-responsive">
				<?php echo $prod_highlight; ?>
			</div>
	<?php  } ?>

	<?php if ($attribute_groups) { ?>

		<h3 class="heading-title">Product Highlight</h3>

	<div id="product-attribute" class="no-margin table-responsive">
		<table class="attribute table">
			<?php foreach ($attribute_groups as $attribute_group) { ?>
			<thead>
				<tr>
					<td colspan="2"><?php echo $attribute_group['name']; ?></td>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
				<tr>
					<td><?php echo $attribute['name']; ?></td>
					<td><?php echo $attribute['text']; ?></td>
				</tr>
			<?php } ?>
			</tbody>
			<?php } ?>
		</table>
	</div>
	<?php } ?>


	<?php if ($review_status) { ?>
		<h3 class="heading-title"><span>Review</span></h3>
	
	<div id="tab-review" class="tab-content no-margin">
		<div id="review"></div>
		<div id="write-review">
			<span class="inline">To write a review </span>
			<a href="javascript:void(0);" id="review-title" class="inline" data-toggle="collapse" data-target="#review-form-cont">Click Here</a>
		</div>
		
		<div id="review-form-cont" class="collapse">
			<div class="form-group row">
				<div class="col-md-2">
					<label><?php echo $entry_name; ?></label>
				</div>
				<div class="col-md-6">
					<input type="text" name="name" value="" />
				</div>	
			</div>
			
			<div class="form-group row">
				<div class="col-md-2">
					<label><?php echo $entry_review; ?></label>
				</div>
				<div class="col-md-6">
					<textarea name="text" cols="50" rows="8" class="form-control"></textarea>
					<span class="new_product_new5"><?php echo $text_note; ?></span>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-2">
					<label><?php echo $entry_rating; ?></label>
				</div>
				<div class="col-md-6">
					<span><?php echo $entry_bad; ?></span>	
					<input type="radio" name="rating" value="1" />				
					<input type="radio" name="rating" value="2" />				
					<input type="radio" name="rating" value="3" />				
					<input type="radio" name="rating" value="4" />				
					<input type="radio" name="rating" value="5" />
					<span><?php echo $entry_good; ?></span>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-2">
					<label><?php echo $entry_captcha; ?></label>
				</div>
				<div class="col-md-6">
					<span class="captcha-image inline">
						<img src="index.php?route=product/product/captcha" alt="captcha" id="captcha" />
					</span>	
					<span class="captcha-inp inline"><input type="text" name="captcha" value="" /></span>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-2">
					&nbsp;
				</div>
				<div class="col-md-6">
					<div class="buttons no-padding">
						<div class="col-md-2"><a id="button-review" class="button btn btn-theme-default">Submit</a></div>
						<div class="col-md-2"><a id="button-review1" class="button btn btn-theme-default" data-target="#review-form-cont" data-toggle="collapse">close</a></div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
	<?php } ?>
	
	<h3 class="heading-title"><span>SIMILAR PRODUCTS</span></h3>
	<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/product/product_related.tpl" );  ?>


	<?php if( $productConfig['enable_product_customtab'] && isset($productConfig['product_customtab_content'][$languageID]) ) { ?>
	<div id="tab-customtab" class="tab-content custom-tab">
		<div class="inner">
			<?php echo html_entity_decode( $productConfig['product_customtab_content'][$languageID], ENT_QUOTES, 'UTF-8'); ?>
		</div>
	</div>
	<?php } ?> 
	
</div>	
	<?php echo $content_bottom; ?>
</div>

<?php if( $productConfig['product_enablezoom'] ) { ?>
<script type="text/javascript" src=" catalog/view/javascript/jquery/elevatezoom/elevatezoom-min.js"></script>
<script type="text/javascript">
	<?php if( $productConfig['product_zoomgallery'] == 'slider' ) {  ?>		
		$("#image").elevateZoom({gallery:'image-additional-carousel', cursor: 'pointer', galleryActiveClass: 'active'}); 
		<?php } else { ?>
		var zoomCollection = '<?php echo $productConfig["product_zoomgallery"]=="basic"?".product-image-zoom":"#image";?>';
		$( zoomCollection ).elevateZoom({
		<?php if( $productConfig['product_zoommode'] != 'basic' ) { ?>
		zoomType        : "<?php echo $productConfig['product_zoommode'];?>",
		<?php } ?>
		lensShape : "<?php echo $productConfig['product_zoomlensshape'];?>",
		lensSize    : <?php echo (int)$productConfig['product_zoomlenssize'];?>,
	});
	<?php } ?> 
</script>
<?php } ?>

<script type="text/javascript">
<!--
$(document).ready(function() {
  $('.colorbox').colorbox({
    overlayClose: true,
    opacity: 0.5,
    rel: "colorbox"
  });
   $('#zipcode').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {

  	 codstatus();
    return false;  
  }
});
});
//-->
</script> 

<script type="text/javascript">
<!--
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="Close" class="close" /></div>');

/*var url = "index.php/#latest-products";    
$(location).attr('href',url);*/
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//-->

$('#button-buynow').bind('click', function() {


	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				var order_id='<?php if(isset($this->session->data["order_id"])) echo $this->session->data["order_id"]; else "";?>';
				var totalval=json['total'];


				

				/*************Popup upsell code starts here *************/
				var product_id='<?php echo $product_id; ?>';   	

				if(product_id) {
				/*		$.ajax({
							url: 'index.php?route=module/popupupsell/showupselloffer',
							type: 'post',
							data: 'product_id=' + product_id,
							dataType: 'json',
							success: function(json1) { 
								
													  
								if(json1) 
								{ */



									 $.ajax({
							url: 'index.php?route=module/cart/respcartcontent',
							type: 'post',
							dataType: 'text',
							success: function(respinfo) { 
								
								$(".respmodulecart").html(respinfo);  
								 $("#cart").addClass('active'); 
								// $("#page").css('cursor','none');
									$("#page > *").not('.offcanvas-pusher #header').css("opacity", '0.2');  
									$("#header > *").not('#header-main').css("opacity", '0.2');  
									$(".container > *").not('.right-cont').css("opacity", '0.2');  
									$(".right-cont > *").not('.bottompart').css("opacity", '0.2');  
									$(".bottompart > *").not('.cart-mini-right').css("opacity", '0.2'); 

									$("#page > *").not('.offcanvas-pusher #header').css("cursor", 'none');  
									$("#header > *").not('#header-main').css("cursor", 'none');  
									$(".container > *").not('.right-cont').css("cursor", 'none');  
									$(".right-cont > *").not('.bottompart').css("cursor", 'none');  
									$(".bottompart > *").not('.cart-mini-right').css("cursor", 'none');  
									
									  $('.success').fadeIn('slow');
										
									$('#cart-total').html(totalval);
									
									$('html, body').animate({ scrollTop: 0 }, 'slow');
								
									 
									   setTimeout(function(){  
									 $("#page > *").not('.offcanvas-pusher #header').css("cursor", 'default');  
									$("#header > *").not('#header-main').css("cursor", 'default');  
									$(".container > *").not('.right-cont').css("cursor", 'default');  
									$(".right-cont > *").not('.bottompart').css("cursor", 'default');  
									$(".bottompart > *").not('.cart-mini-right').css("cursor", 'default');  
									  $("#page > *").not('.offcanvas-pusher #header').css("opacity", '1.0');  
									$("#header > *").not('#header-main').css("opacity", '1.0');  
									$(".container > *").not('.right-cont').css("opacity", '1.0');  
									$(".right-cont > *").not('.bottompart').css("opacity", '1.0');  
									$(".bottompart > *").not('.cart-mini-right').css("opacity", '1.0');
									  $("#cart").removeClass('active'); 

									 //setTimeout(function(){  
									 // $("body").css('opacity','0.3'); 
								//$('#page').prepend('<div id="trest" class="load"></div>');
									//set session product id

									/*json1.content="<p><span class='popuptitle'>Buy More Save More!</span>&nbsp - &nbsp <span class='popupsubtitle'>Items at Special Price Just for You!</span></p><p id='notificationpopup'></p><div class='popupmainouter'>"+json1.content+"</div>"; 
 									
									showPopupUpsell(json1.content, json1.width, json1.height); */

									//if(order_id)
										
									//	{//var url = "checkout";  
									//	  }  
									//else{
									//	var url = "index.php?route=checkout/checkout";    
									//	}
										//$(location).attr('href',url);
										  
									//$('.success').fadeIn('slow');
										
									//$('#cart-total').html(totalval);
									
									//$('html, body').animate({ scrollTop: 0 }, 'slow');
									//}, 2000); 
									 
									}, 10000);  
							}
						});
									    
								
									


 

							//	}  //if json


						/*		else
								{
									

											if(order_id)
										
										{var url = "checkout";    } 
									else{
										var url = "index.php?route=checkout/checkout";    
										} 
										//$(location).attr('href',url);
										  
									$('.success').fadeIn('slow');
										
									$('#cart-total').html(json['total']);
									
									$('html, body').animate({ scrollTop: 0 }, 'slow');
									//$("#page").addClass('opacitypclass'); 
									//$("div.cart-mini-right div.shopping-cart").addClass('opacitycclass'); 
									//$("div.shopping-cart #cart").css('opacity','1.0 !important');   
									//$("#offcanvas-container").addClass('modal-open'); 
									    // $('div#header').children().css('opacity', '0.3');
									
									 $.ajax({
							url: 'index.php?route=module/cart/respcartcontent',
							type: 'post',
							dataType: 'text',
							success: function(respinfo) { 
								
								$(".respmodulecart").html(respinfo); 
								 $("#cart").addClass('active'); 
								// $("#page").css('cursor','none');
									$("#page > *").not('.offcanvas-pusher #header').css("opacity", '0.2');  
									$("#header > *").not('#header-main').css("opacity", '0.2');  
									$(".container > *").not('.right-cont').css("opacity", '0.2');  
									$(".right-cont > *").not('.bottompart').css("opacity", '0.2');  
									$(".bottompart > *").not('.cart-mini-right').css("opacity", '0.2'); 

									$("#page > *").not('.offcanvas-pusher #header').css("cursor", 'none');  
									$("#header > *").not('#header-main').css("cursor", 'none');  
									$(".container > *").not('.right-cont').css("cursor", 'none');  
									$(".right-cont > *").not('.bottompart').css("cursor", 'none');  
									$(".bottompart > *").not('.cart-mini-right').css("cursor", 'none');  
									
								
									 
									   setTimeout(function(){  
									 $("#page > *").not('.offcanvas-pusher #header').css("cursor", 'default');  
									$("#header > *").not('#header-main').css("cursor", 'default');  
									$(".container > *").not('.right-cont').css("cursor", 'default');  
									$(".right-cont > *").not('.bottompart').css("cursor", 'default');  
									$(".bottompart > *").not('.cart-mini-right').css("cursor", 'default');  
									  $("#page > *").not('.offcanvas-pusher #header').css("opacity", '1.0');  
									$("#header > *").not('#header-main').css("opacity", '1.0');  
									$(".container > *").not('.right-cont').css("opacity", '1.0');  
									$(".right-cont > *").not('.bottompart').css("opacity", '1.0');  
									$(".bottompart > *").not('.cart-mini-right').css("opacity", '1.0');
									  $("#cart").removeClass('active'); 
									 
									}, 6000);  
							}
						});
									    

									

										
									//$(".bottompart > *").not('.cart-mini-right').css("opacity", '0.5');  
 
										//alert($("div.shopping-cart #cart").length); 
										//$("div.shopping-cart #cart").addClass('active');  

								}  */
									//}
								//});
							} 


				/*************Popup upsell code end here *************/



				/*	if(order_id)
					{var url = "checkout";    } 
				else{
					var url = "index.php?route=checkout/checkout";    
					}
					$(location).attr('href',url);
					  
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); */


			}	
		}
	});
});
</script>

<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
  action: 'index.php?route=product/product/upload',
  name: 'file',
  autoSubmit: true,
  responseType: 'json',
  onSubmit: function(file, extension) {
    $('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" class="loading" style="padding-left: 5px;" />');
    $('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
  },
  onComplete: function(file, json) {
    $('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
    
    $('.error').remove();
    
    if (json['success']) {
      alert(json['success']);
      
      $('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
    }
    
    if (json['error']) {
      $('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
    }
    
    $('.loading').remove(); 
  }
});
//-->
</script>

<?php } ?>
<?php } ?>
<?php } ?>

<script type="text/javascript">
<!--
$('#review .pagination a').live('click', function() {
  $('#review').fadeOut('slow');
    
  $('#review').load(this.href);
  
  $('#review').fadeIn('slow');
  
  return false;
});     

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
  $.ajax({
    url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
    type: 'post',
    dataType: 'json',
    data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
    beforeSend: function() {
      $('.success, .warning').remove();
      $('#button-review').attr('disabled', true);
      $('#review-title').after('<div class="attention"><img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/loading.gif" alt="loading" /> <?php echo $text_wait; ?></div>');
    },
    complete: function() {
      $('#button-review').attr('disabled', false);
      $('.attention').remove();
    },
    success: function(data) {
    	
      if (data['error']) {
        $('#review-title').after('<div class="warning">' + data['error'] + '</div>');
      }
      
      if (data['success']) {
        $('#review-title').after('<div class="success">' + data['success'] + '</div>');
                
        $('input[name=\'name\']').val('');
        $('textarea[name=\'text\']').val('');
        $('input[name=\'rating\']:checked').prop('checked', false);
        $('input[name=\'captcha\']').val('');  
      }
    }
  });
});
//-->
</script> 

<script type="text/javascript">
<!--
$('#tabs a').tabs();
//-->
</script> 

<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript">
<!--
$(document).ready(function() {
  if ($.browser.msie && $.browser.version == 6) {
    $('.date, .datetime, .time').bgIframe();
  }

  $('.date').datepicker({dateFormat: 'yy-mm-dd'});
  $('.datetime').datetimepicker({
    dateFormat: 'yy-mm-dd',
    timeFormat: 'h:m'
  });
  $('.time').timepicker({timeFormat: 'h:m'});
  if ($(window).width() < 767) {

    $('[data-toggle="popover"]').popover({
	html: true, 
	 placement: 'bottom',   
	 trigger: "manual" 
}) .on("mouseenter", function () {
        var _this = this;

        $(this).popover("show");
        $('.popover.bottom .arrow').addClass('arrowtop'); 
       
        $(".popover").on("mouseleave", function () {
           //$(_this).popover('hide');
        });
         
    }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
               // $(_this).popover("hide");
            }
        }, 3000);
});
  //mouseover effect
}
else
{
	
	 $('[data-toggle="popover"]').popover({
	html: true, 
	 placement: 'left',   
	 trigger: "manual" 
}) .on("mouseenter", function () {
        var _this = this;
        $(this).popover("show");       
         
        $(".popover").on("mouseleave", function () {
            $(_this).popover('hide');
        });
    }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide");
            }
        }, 300);
});

   
  //mouseover effect
  //mouseover effect
} 
 
  
 
});



//-->
</script> 
</section>
 
<?php if( $SPAN[2] ): ?>
<aside class="col-md-<?php echo $SPAN[2];?>">	
	<?php echo $column_right; ?>
</aside>
<?php endif; ?>

</div></div>



<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable
information or placed on pages related to sensitive categories. See more
information and instructions on how to setup the tag on:
http://google.com/ads/remarketingsetup
----------------------------------------------------> 
<script type="text/javascript">
var google_tag_params = {
ecomm_prodid: "<?php echo $product_id; ?>",
ecomm_pagetype: "product",
ecomm_totalvalue: <?php if (!$special) { $finalprice=$price;} else {$finalprice=$special;} 
$finalprice1=str_replace(",","",$finalprice);
$finval=str_replace("<span class='WebRupee'>Rs</span>","",$finalprice1); echo number_format($finval,2, '.', '');   ?>  
};   
</script>  


<script type="application/ld+json">
{
 "@context": "http://schema.org/",
  "@type": "Product",
  "name": "<?php echo $heading_title; ?>",
  "image": "<?php echo $thumb; ?>",
   
  "mpn": "<?php echo $model; ?>",
 
   "brand": {
    "@type": "Thing",
    "name": "<?php echo $manufacturer; ?>"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php if($zrating > 0) echo $zrating; else echo 1; ?>",
    "reviewCount": "<?php if($zreviews > 0) echo $zreviews; else echo 1; ?>"
  },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "INR",
    "price": "<?php if (!$special) { $finalprice=$price;} else {$finalprice=$special;} 
$finalprice1=str_replace(",","",$finalprice);
$finval=str_replace("<span class='WebRupee'>Rs</span>","",$finalprice1); echo number_format($finval,2, '.', '');   ?>" ,
    "priceValidUntil": "2020-11-05",
    "itemCondition": "http://schema.org/UsedCondition",
    "availability": "http://schema.org/<?php if ($stock == "Out Of Stock"){ echo "Out Of Stock"; } else echo "In Stock"; ?>",
    "seller": {
      "@type": "Organization",
      "name": "FootLounge"
    }
  }
}
</script>
<?php echo $footer; ?> 


<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="closemodal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">EMAIL NOTIFICATION</h4>
      </div>
      <div class="modal-body">
      <!--<div style="margin-bottom: 20px;" ><p>This product has been solded out! Kindly fill the following details, our executive will contact you in another 48 hours. <a href="https://gofootlounge.in/new-arrivals"><span style="color: #CD6927 " id="modal_content">Happy Shopping</span><a></p></div>-->
		<div class="new_asearch_mb" ><p> Notify me when the product is back in Stock!</p></div>

       	<form class="form-horizontal">
       	<input type="hidden" id="npro_id" name="npro_id">
       	<input type="hidden" id="pro_name" name="pro_name">
       		<input type="hidden" id="pro_href" name="pro_href">
       	<div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Product Name</label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control new_asearch_fw" id="Nproductname" placeholder="Product Name" disabled="disabled" >
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

		<!--  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Comments</label>
		    <div class="col-sm-6">
		      <textarea class="form-control" id="NComments" placeholder="Comments"></textarea>
		    </div>
		  </div> -->

		</form>
      </div>
      <div class="modal-footer new_asearch_padd">
      <span class="alert alert-success new_asearch_padd1" id="success_msgaa">send successfully</span>
      <span class="alert alert-danger new_asearch_padd1" id="failure_msg">sending failed</span>
      	<img src="https://gofootlounge.in/image/loading_spinner.gif" alt="loading..." id="image_spinner">
        <button type="button" class="btn btn-default" id="closebtn" onclick="closemodal();">Close</button>
        <button type="button" class="btn btn-primary" id="sendbtn" onclick="sendnotify();">Send</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript"> 
  function getproperview()
	  {
	  	var tproductid='<?php echo $n_product_id; ?>';
	  	$.ajax({
              type: "POST",             
              url: 'index.php?route=common/home/getproductcategory/', 
              data:
              {
              	tproductid:tproductid,                               
              },
              success: function(respnew){
              	if(respnew==1)
	    {

	    	$("#knowYourSize").modal('show');
	    	$(".tab-interface ul.nav li.first").removeClass('active');
	    	$(".tab-interface ul.nav li.last").addClass('active');
	    	
	    	//$(".tab-interface ul.nav li").removeClass('active'); 
	    	$("#tab-adidas").removeClass('active');
	   	 	$("#tab-nike").removeClass('active');
	   	 	$("#tab-reebok").removeClass('active');
	    	$("#tab-puma").removeClass('active');
	    	$("#tab-franco-leone").removeClass('active');
	    	$("#tab-woodland").removeClass('active');
	    	$("#tab-apparel").addClass('active');    
	    	 	 
	    	
	    	$("div.modal-body p:first-child").hide();
	    	$("div.modal-body p:nth-child(2)").hide(); 
	    	$("div.know-your-size-info-page div.row:first-child").hide(); 
	    }
	    else
	    {
	    	$("#knowYourSize").modal('show');  
	    	$(".tab-interface ul.nav li.first").addClass('active');
	    	$(".tab-interface ul.nav li.last").removeClass('active');
	    	 
	   	 	$("#tab-nike").removeClass('active');
	   	 	$("#tab-reebok").removeClass('active');
	    	$("#tab-puma").removeClass('active');
	    	$("#tab-franco-leone").removeClass('active');
	    	$("#tab-woodland").removeClass('active');
	    	$("#tab-apparel").removeClass('active'); 
	    	$("#tab-adidas").addClass('active'); 	
	    	$("div.modal-body p:first-child").show();
	    	$("div.modal-body p:nth-child(2)").show(); 
	    	$("div.know-your-size-info-page div.row:first-child").show();    
	    }

              }
            });  	

	  	/*var flag=1; 
	    var urlval='<?php $org= array(); $org=$_SERVER['REQUEST_URI']; if($_SERVER['REQUEST_URI'])  { $exarray= explode("/",$org); if (in_array("clothing", $exarray)) { echo "yes"; } else echo "no"; }?>';

	    if(urlval=='no')
	    {
	    	var urlval1='<?php $org= array(); $org=$_SERVER['REQUEST_URI']; if($_SERVER['REQUEST_URI'])  { $exarray= explode("/",$org); $count=count($exarray)-1; echo $exarray[$count]; }?>';
	    	alert(urlval1); 
	    }*/


	    
	  }	
 $(document).ready(function() {
          

            $('.nav-tabs li:nth-child(1) a').click(function(e) {
            	          	
	    	 	 $("div.modal-body p:first-child").show();
	    		 $("div.modal-body p:nth-child(2)").show(); 
	    		 $("div.know-your-size-info-page div.row:first-child").show();  
            });
            $('.nav-tabs li:nth-child(2) a').click(function(e) {
            	 $("div.modal-body p:first-child").show();
	    		 $("div.modal-body p:nth-child(2)").show(); 
	    		 $("div.know-your-size-info-page div.row:first-child").show(); 
            });
            $('.nav-tabs li:nth-child(3) a').click(function(e) {
            	 $("div.modal-body p:first-child").show();
	    		 $("div.modal-body p:nth-child(2)").show(); 
	    	     $("div.know-your-size-info-page div.row:first-child").show(); 
            });
            $('.nav-tabs li:nth-child(4) a').click(function(e) {
            	 $("div.modal-body p:first-child").show();
	    		 $("div.modal-body p:nth-child(2)").show(); 
	    		 $("div.know-your-size-info-page div.row:first-child").show(); 
            });
            $('.nav-tabs li:nth-child(5) a').click(function(e) {
            	 $("div.modal-body p:first-child").show();
	    		 $("div.modal-body p:nth-child(2)").show(); 
	    		 $("div.know-your-size-info-page div.row:first-child").show(); 
            });
            $('.nav-tabs li:nth-child(6) a').click(function(e) {
            	 $("div.modal-body p:first-child").show();
	    		 $("div.modal-body p:nth-child(2)").show(); 
	    		 $("div.know-your-size-info-page div.row:first-child").show(); 
            });
            $('.nav-tabs li:nth-child(7) a').click(function(e) {
            	$("div.modal-body p:first-child").hide(); 
	    	    $("div.modal-body p:nth-child(2)").hide();  
	    	    $("div.know-your-size-info-page div.row:first-child").hide(); 
            }); 
         });   
      //popup center social link
    function PopupCenter(url, title, w, h) {
	    // Fixes dual-screen position                         Most browsers      Firefox
	    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
	    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

	    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
	    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

	    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
	    var top = ((height / 2) - (h / 2)) + dualScreenTop;
	    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

	    // Puts focus on the newWindow
	    if (window.focus) {
	        newWindow.focus();
	    } 
	}  
</script> 