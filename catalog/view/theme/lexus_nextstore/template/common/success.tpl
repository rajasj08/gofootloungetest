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
			<div class="wrapper underline">
				<?php echo $text_message; ?>
			</div>
			<div class="buttons">
				<div class="right"><a href="<?php echo $continue; ?>" class="button btn btn-theme-default"><?php echo $button_continue; ?></a></div>
			</div>
			<?php echo $content_bottom; ?>
		</div>
	</section> 

	<?php if( $SPAN[2] ): ?>
		<aside class="col-lg-<?php echo $SPAN[2];?> col-md-<?php echo $SPAN[2];?> col-sm-12 col-xs-12">	
			<?php echo $column_right; ?>
		</aside>
	<?php endif; ?>
	
</div></div>
<script type="text/javascript"> 
 
var google_tag_params = { 
<?php if(count($order_products)>1) { ?>
ecomm_prodid: [<?php $idsval='';$count=count($order_products); $j=1;

  foreach ($order_products as $i => $product) { 
  	
  	if($j<$count)
  		{$comma=",";}else{$comma="";} 
  	
  	$idsval.='"'.$product["product_id"].'"'.$comma;
  	$j++;
  	 }   
  	 echo $idsval; ?>], 
  	 <?php } else { ?>
  	 ecomm_prodid: <?php $idsval='';$count=count($order_products); $j=1;

  foreach ($order_products as $i => $product) { 
  	$idsval.='"'.$product["product_id"].'"';
  	$j++;
  	 }    
  	if($idsval) {echo $idsval;} else echo '""'; ?>, 	
  	 	<?php }?>
ecomm_pagetype: "purchase",  
<?php if(count($order_products)>1) { ?>			  
ecomm_totalvalue: [<?php $count=count($order_products); $j=1;$priceval='';
  foreach ($order_products as $i => $product) { 
  	
  	if($j<$count)
  		{$comma=",";}else{$comma="";} 
  	//if (!$product['special']) {$finalprice=$product['price'];}else{$finalprice=$product['special'];}
  	$finalprice=$product['price'];
  	$finalprice=str_replace(",","",$finalprice); 
  	$orgprice=str_replace("<span class='WebRupee'>Rs</span>","",$finalprice);
   	$priceval.=number_format($orgprice,2, '.', '').$comma;   
  	$j++;  
  	 }     
  	 echo $priceval; ?>], 
<?php } else { ?>
	ecomm_totalvalue: <?php $count=count($order_products); $j=1;$priceval='';
  foreach ($order_products as $i => $product) {   	
  	
  	//if (!$product['special']) {$finalprice=$product['price'];}else{$finalprice=$product['special'];}
  	$finalprice=$product['price'];
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