<?php 
/******************************************************
 * @package Pav Opencart Theme Framework for Opencart 1.5.x
 * @version 1.1
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Augus 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/config.tpl" );

?>

<?php echo $header; ?>

<div class="container">
<div class="row"> 

<?php if( $SPAN_HOME[0] ): ?>
	<aside class="col-lg-<?php echo $SPAN_HOME[0];?> col-md-<?php echo $SPAN_HOME[0];?> col-sm-12 col-xs-12">
		<?php echo $column_left; ?>
	</aside>
<?php endif; ?>
		
<!-- <section class="col-lg-<?php echo $SPAN_HOME[1];?> col-md-<?php echo $SPAN_HOME[1];?> col-sm-12 col-xs-12">  -->
<section>	    
	<div id="content">
		<?php echo $offer_slideshow; ?>
		<?php echo $content_top; ?>
		<h1 class="new_page_disp1"><?php echo @$heading_title; ?></h1>
		<?php echo $content_bottom; ?>
	</div>
</section>
	
<?php if( $SPAN_HOME[2] ): ?>
	<aside class="col-lg-<?php echo $SPAN_HOME[2];?> col-md-<?php echo $SPAN_HOME[2];?> col-sm-12 col-xs-12">	
		<?php echo $column_right; ?>
	</aside>
<?php endif; ?>

</div>

</div> 

<script type="text/javascript"> 
var google_tag_params = { 

ecomm_pagetype: "home"

}; 

</script> 

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "name" : "footlounge",
  "url": "https://gofootlounge.in",
  "logo": "https://gofootlounge.in/image/data/lo2logo.png",
  "contactPoint": [{
    "@type": "ContactPoint",
    "telephone": "+91-91768-70701",
    "contactType": "customer service"
  }],
  "sameAs" : [
"http://www.facebook.com/footlounge.online",
"http://www.twitter.com/go_footlounge",
"http://www.instagram.com/go_footlounge",
"https://in.pinterest.com/footloungeindia/"
]
} 
</script>

<?php echo $footer; ?>
