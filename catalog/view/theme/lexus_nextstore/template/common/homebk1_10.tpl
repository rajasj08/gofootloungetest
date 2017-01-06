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

<?php if( $SPAN[0] ): ?>
	<aside class="col-lg-<?php echo $SPAN[0];?> col-md-<?php echo $SPAN[0];?> col-sm-12 col-xs-12">
		<?php echo $column_left; ?>
	</aside>
<?php endif; ?>
		
<section class="col-lg-<?php echo $SPAN[1];?> col-md-<?php echo $SPAN[1];?> col-sm-12 col-xs-12">         
	<div id="content">
		<?php echo $content_top; ?>
		<h1 style="display: none;"><?php echo $heading_title; ?></h1>
		<?php echo $content_bottom; ?>
	</div>
</section>
	
<?php if( $SPAN[2] ): ?>
	<aside class="col-lg-<?php echo $SPAN[2];?> col-md-<?php echo $SPAN[2];?> col-sm-12 col-xs-12">	
		<?php echo $column_right; ?>
	</aside>
<?php endif; ?>
</div></div>
<?php if($this->customer->isLogged()) { ?>
   <div style="background-color:red;"> <center><h2>REGISTER NOW to get <span class="WebRupee" style="font-size:22px; height: 44px;line-height: 46px;">Rs</span>2500 instant shopping credits</h2></center></div>
</div>
<?php } else { ?>
    <div style="background-color:red;">
<center><h2>REGISTER NOW to get <span class="WebRupee" style="font-size:22px">Rs</span>2500 instant shopping credits <a onclick="load_popup();" style="display: inline-block;color:#cd0000;font-size: 24px;border-radius: 5px; padding:0px 10px 0px 28px;height: 44px;line-height: 46px; text-decoration:none; background:url('http://martjackstorage.blob.core.windows.net/fashos-resources/1d74fdce-5da7-48d5-aeb6-e53dc8acdefd/Images/userimages/design_2014/footer/hp_footer_signup_bg.png') no-repeat scroll left 5px center #fff;">SIGN UP</a></h2></center>
</div>	
<?php } ?>

<?php echo $footer; ?>