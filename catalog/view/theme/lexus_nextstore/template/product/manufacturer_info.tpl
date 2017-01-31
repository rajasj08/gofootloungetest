<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/config.tpl" ); 
	$themeConfig = (array)$this->config->get('themecontrol');
	 
	$categoryConfig = array( 
		'listing_products_columns' 		     		=> 0,
		'listing_products_columns_small' 	     	=> 2,
		'listing_products_columns_minismall'    	=> 1,
		'cateogry_display_mode' 			     	=> 'grid',
		'category_pzoom'				          	=> 1,	
		'quickview'                                 => 0,
		'show_swap_image'                       	=> 0,
	); 
	$categoryConfig  	= array_merge($categoryConfig, $themeConfig );
	$DISPLAY_MODE 	 	= $categoryConfig['cateogry_display_mode'];
	$MAX_ITEM_ROW 	 	= $themeConfig['listing_products_columns']?$themeConfig['listing_products_columns']:4; 
	$MAX_ITEM_ROW_SMALL = $categoryConfig['listing_products_columns_small']?$categoryConfig['listing_products_columns_small']:2;
	$MAX_ITEM_ROW_MINI  = $categoryConfig['listing_products_columns_minismall']?$categoryConfig['listing_products_columns_minismall']:1; 
	$categoryPzoom 	    = $categoryConfig['category_pzoom']; 
	$quickview          = $categoryConfig['quickview'];
	$swapimg            = ($categoryConfig['show_swap_image'])?'swap':'';
?>

<?php echo $header; ?>
<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/breadcrumb.tpl" );  ?>
<div class="container">
	<div class="row">
		<?php if( $SPAN[0] ): ?>
			<aside class="col-md-<?php echo $SPAN[0];?>">
				<?php echo $column_left; ?>
			</aside>
		<?php endif; ?> 

		<?php $class_3cols = (!empty($column_left) && !empty($column_left))?'three-columns':''; ?>
		
		<section class="col-md-<?php echo $SPAN[1];?> <?php echo $class_3cols;?> ">
			<div id="content">
				<?php echo $content_top; ?>
				<div class="heading-cont clearfix">
				<h1><?php echo $heading_title; ?></h1>	
					<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/product/product_filter.tpl" );  ?>	
					</div>					
				<?php if ($products) { ?>
					<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/product/product_collection.tpl" );  ?>
				<?php } else { ?>
				<div class="content"><div class="wrapper"><?php echo $text_empty; ?></div></div>				
				<div class="buttons">
					<div class="right"><a href="<?php echo $continue; ?>" class="button btn btn-theme-default"><?php echo $button_continue; ?></a></div>
				</div>
				<?php } ?>
				<?php echo $content_bottom; ?>
			</div>
  
<script type="text/javascript">
<!--
function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');
		
		$('.products-block  .product-block').each(function(index, element) {
 
			 $(element).parent().addClass("col-fullwidth");
		});		
		
		$('.display').html('<span class="new_asearch_fl"><?php echo $text_display; ?></span><a class="list active"><i class="fa fa-th-list"></i><em><?php echo $text_list; ?></em></a><a class="grid" onclick="display(\'grid\');"><i class="fa fa-th"></i><em><?php echo $text_grid; ?></em></a>');
	
		$.totalStorage('display', 'list'); 
	} else {
		$('.product-list').attr('class', 'product-grid');
		
		$('.products-block  .product-block').each(function(index, element) {
			 $(element).parent().removeClass("col-fullwidth");  
		});	
					
		$('.display').html('<span class="new_asearch_fl"><?php echo $text_display; ?></span><a class="list" onclick="display(\'list\');"><i class="fa fa-th-list"></i><em><?php echo $text_list; ?></em></a><a class="grid active"><i class="fa fa-th"></i><em><?php echo $text_grid; ?></em></a>');
	
		$.totalStorage('display', 'grid');
	}
}

view = $.totalStorage('display');

if (view) {
	display(view);
} else {
	display('<?php echo $DISPLAY_MODE;?>');
}
//-->
</script> 

</section>

<?php if( $SPAN[2] ): ?>
<aside class="col-md-<?php echo $SPAN[2];?>">	
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
      <!--<div style="margin-bottom: 20px;" ><p>This product has been solded out! Kindly fill the following details, our executive will contact you in another 48 hours. <a href="https://gofootlounge.in/new-arrivals"><span style="color: #CD6927 " id="modal_content">Happy Shopping</span><a></p></div>-->
		<div class="new_asearch_mb" ><p> Notify me when the product is back in Stock!</p></div>

       	<form class="form-horizontal">
       	<input type="hidden" id="npro_id" name="npro_id">
       	<input type="hidden" id="pro_name" name="pro_name">
       		<input type="hidden" id="pro_href" name="pro_href">
       	<div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Product Name</label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control new_asearch_fw" id="Nproductname" placeholder="Product Name" disabled="disabled">
		    </div>
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
      <span class="alert alert-success new_asearch_padd1" id="success_msg">send successfully</span>
      <span class="alert alert-danger new_asearch_padd1" id="failure_msg">sending failed</span>
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
ecomm_category: "Category > <?php  $actual_link ="$_SERVER[REQUEST_URI]";

					$subval=strstr($actual_link,'/'); 
					
					$subval1=str_replace('/',' > ',$subval);
					
					
					$subval2=str_replace('/',' > ',$subval1);   
					  
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
  	 if($priceval) { echo $priceval; } else { echo '""'; }?>, 
<?php } ?>  
};
</script>
<?php echo $footer; ?>