<?php
// ***************************************************
//               Advanced Smart Search   
//       
// Author : Francesco Pisanò - francesco1279@gmail.com
//              
//                   www.leverod.com		
//               © All rights reserved	  
// ***************************************************


// Live Search CSS

?>

<?php 
global $config;
?>

<style>	

<?php // Default template fixes - Oc 2.0+ ?>

		<?php // z-index fix - field doesn't focus on low res devices ?>
		#search {
			z-index:102;
		}
		<?php // Remove extra viewport height on top - fix for Oc 2.0+, default template ?>
		#search.input-group .form-control {
			float:none !important;
		}
		<?php // Search button position fix when the dropdown is displayed ?>
		.adsmart_container  + .input-group-btn {
			vertical-align:top !important;	
		}

<?php // End Default template fixes ?>



<?php // We need this container for the absolute positioning of the dropdown list ?>
.adsmart_container {
	position:relative !important;
	padding:0; margin:0;
}


.adsmart_search {

	width:377px !important;

	z-index:99999999 !important; 
	position:relative;

	<?php 
	// width: !!! // For the property "width", see the function set_dropdown_width(), adsmartsearch_livesrc_js.php ?>
	
	display:block; <?php // DO NOT ADD the attribute !important here ?>
	
	padding:2px !important;
	padding-bottom:0 !important;
	padding-right: 10px; 
	
	/*border: 1px solid #<?php echo $config->get('adsmart_search_dropdown_border_color') ?>	<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;*/
	background-color: #ffffff !important;

	
	-webkit-border-radius: 4px;
	-webkit-border-top-left-radius: 2px;
	-webkit-border-top-right-radius: 2px;
	-moz-border-radius: 4px;
	-moz-border-radius-topleft: 2px;
	-moz-border-radius-topright: 2px;
	border-radius: 4px;
	border-top-left-radius: 2px;
	border-top-right-radius: 2px;
	
	<?php	
	// "user-select: none" prevents an uwanted mouse selection of the scrollbar (it's
	// just a div box and if it is selected instead of being scrolled, it doesn't work) 
	?>
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

.adsmart_search * {
	box-sizing: border-box;
}

.adsmart_search ul{
	box-sizing: border-box;
	list-style-type: none !important;
	padding:0;margin:0;
}

.adsmart_search li {
	list-style-type: none !important;
	display: table !important;	
	width:100%;
	padding: 6px !important;
} 

.adsmart_search a.item_link {
	display: table-row !important;	
	width:100% !important;	
	margin:0;
	line-height:normal;
	text-decoration:none;
	overflow:visible !important;
}


.adsmart_search .adsmart_info_msg {
	background-image:none;
	border-top:none;
	list-style-type: none;
}


.adsmart_search div.image {

	display: table-cell <?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	
	vertical-align: middle !important;
	margin:0 !important;
	padding:0px !important;
	box-sizing: content-box !important;
}

.adsmart_search div.image, 
.adsmart_search div.image img {			<?php
										// set witdh and height also for img because there seems to be a problem with display: table-cell, + width/height, 
										// when images and their sizes are loaded, jQuery already computed the viewport height and if images are big, they
										// alter the total viewport height which, overlapping the bar 	"Show all results"								
										// and their size are loaded AFTER jquery measures the viewport height
										?>
	<?php if (defined('DIR_CATALOG')) { // this costant is defined on the back end only ?>
	/*
	width: 15px !important;
	height: 15px !important; 
	*/
	<?php } else { ?>
	width: <?php echo  $config->get('adsmart_search_dropdown_img_size') ?>px !important;
	height: <?php echo  $config->get('adsmart_search_dropdown_img_size') ?>px !important;
	<?php } ?>	
}

.adsmart_search div.image img {
	float:left !important;
	padding:0 !important; 
	margin:0 !important;
	border:1px solid #<?php echo $config->get('adsmart_search_dropdown_img_border_color') ?> <?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
	border-radius: 2px;
}


.adsmart_search div.name {
	
	/*font-size: <?php echo $config->get('adsmart_search_dropdown_text_size') ?>px	<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;*/
	font-weight:normal;
	color: #<?php echo $config->get('adsmart_search_dropdown_text_color') ?>		<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	display: table-cell !important;				
	/*vertical-align: middle !important;*/
	padding-left:10px !important;
	text-align:left;

	width:210px;
}
.adsmart_search div.modelconcat{

padding-top:5px;



}



.adsmart_search div.price {

	font-style: normal !important;
	font-weight: normal !important;

	font-size: <?php echo intval(intval($config->get('adsmart_search_dropdown_text_size')*80/100)) ?>px <?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	color: #<?php echo $config->get('adsmart_search_dropdown_text_color') ?> <?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;

	display: table-cell <?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	white-space: nowrap !important;
	/*vertical-align: middle !important;*/
	padding: 0 5px 0 20px !important;
	text-align:right !important;
}

.adsmart_search div.price s {
	color: #FF0000 !important;
}


.adsmart_search scroll{

width:377px !important;


}

.modelleft{

text-align: left !important



}



<?php // "loading" & "no results" ?>

.adsmart_search .adsmart_info_msg {
	height: 0px !important;	
	
	position:relative; top:0px; <?php // keeps the icon above the second li element ?>
}

.adsmart_search .adsmart_info_msg div.adsmart_loading {
	
	margin: 0 auto !important;
	position:relative; top:-38px;left:130px;
	width: 30px !important;
	height: 30px !important;	
	background-color: transparent !important;	
	z-index:10000 !important;
}

.adsmart_search .adsmart_info_msg.no_results {
	text-align:center !important;
	padding: 5px 0 !important; 
	height:auto !important;
}

<?php // End "loading" ?>


.adsmart_search li.menu_item {
	padding:0;margin:0;
	line-height:0;
	/*border-top:		1px solid	#<?php echo $config->get('adsmart_search_dropdown_lighter_separator_color') ?>	<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;*/
	border-bottom:	1px solid	#<?php echo $config->get('adsmart_search_dropdown_darker_separator_color') ?>	<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
}

.adsmart_search li.menu_item:hover { 
	border-color:	#<?php echo $config->get('adsmart_search_dropdown_hover_border_color') ?>	<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	background-color: #<?php echo $config->get('adsmart_search_dropdown_hover_bg_color') ?>		<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
}

.adsmart_search .show_all_results {

	border-top:1px solid #ededed !important;
	vertical-align:middle !important;
	text-align:right !important;
	/*background-color:#<?php echo $config->get('adsmart_search_dropdown_msg_bg_color') ?> <?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;		*/			
}

.adsmart_search .show_all_results a {

	color:#<?php echo $config->get('adsmart_search_dropdown_msg_text_color') ?>		<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	font-size:16 !important;
	background:transparent !important;
	display:block !important;
	margin:0 !important;
	height:40px !important;
	padding-top:10px !important;
	padding-right:30px !important;
	font-weight:normal !important;
}

.adsmart_search .show_all_results a:hover {
	text-decoration:underline !important;
	background:transparent !important;
	margin:0 !important;
	border:none !important;
}
	
	.adsmart_search .models {

position:absolute;
bottom:5px;

	}


.adsmart_search .menu_item{

position:relative;


}
	

/* Scrollbar */	
	
<?php // viewport ?>
.adsmart_search .viewport {
	overflow:visible;
	height:100%; 
}

<?php // overview ?>
.adsmart_search .viewport ul {
    list-style:none;
	position:relative;
	padding:0;
    margin:0;
	width:100%;
}


<?php // dropdown scroll ?>
.adsmart_search.scroll  {
	position:absolute;

	border :1px solid #bebfc1;
}

.adsmart_search.scroll .viewport {
	overflow:hidden;
	position:relative;	
}	

.adsmart_search.scroll .viewport ul {
    position:absolute;
    top:0; left:0;	
}


.adsmart_search.scroll .scrollbar {
    position:absolute;
    top:0px; right:0px;
	<?php // width: see plugin adsmart_scroll, this.scrollbarWidth = 15; ?>
	background-color: #<?php echo $config->get('adsmart_search_dropdown_darker_separator_color') ?>	<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	z-index:10;
	-webkit-box-sizing: border-box; 
	-moz-box-sizing: border-box;   
	box-sizing: border-box;         
}

.adsmart_search.scroll .track { 
    height:100%;
    position:relative;
    padding:0px 1px;
}

.adsmart_search.scroll .thumb{ 
    height:20px;
    overflow:hidden;
    position:absolute;
    top:0; left:0px;
	box-sizing: border-box;
	-moz-box-sizing:border-box;
	-webkit-box-sizing:border-box;
	background-color: #<?php echo $config->get('adsmart_search_dropdown_lighter_separator_color') ?>	<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	
	border-style: solid;
	border-color: #<?php echo $config->get('adsmart_search_dropdown_darker_separator_color') ?>	<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	border-width: 15px 1px;
	
	-webkit-box-shadow: inset 0px 0px 8px 0px rgba(202, 202, 202, 0.5);
	-moz-box-shadow:    inset 0px 0px 8px 0px rgba(202, 202, 202, 0.5);
	box-shadow:         inset 0px 0px 8px 0px rgba(202, 202, 202, 0.5);
}

.adsmart_search.scroll .track,
.adsmart_search.scroll .thumb,
.adsmart_search.scroll .src_lst_up,
.adsmart_search.scroll .src_lst_down {
	width:100%;
}

.adsmart_search.scroll .src_lst_up,
.adsmart_search.scroll .src_lst_down {
	left:0px;
    height:15px;
	background:gray;
	z-index:10;
	position:absolute;
	cursor:pointer;
	line-height:11px;
	font-size:12px;
	text-align:center;
	padding:0;
	color: #<?php echo $config->get('adsmart_search_dropdown_text_color') ?> <?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	background-color: #<?php echo $config->get('adsmart_search_dropdown_lighter_separator_color') ?>	<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
	border:1px solid #<?php echo $config->get('adsmart_search_dropdown_darker_separator_color') ?>	<?php if (!defined('DIR_CATALOG')) { ?> !important <?php } ?>;
}

.adsmart_search.scroll .src_lst_up {
	top:0px;
}


.adsmart_search.scroll .src_lst_down {
	bottom:0px;
}

.adsmart_search.scroll .disable {
    display:none;
}

.noSelect {
    user-select:none;
    -o-user-select:none;
    -moz-user-select:none;
    -khtml-user-select:none;
    -webkit-user-select:none;
}	
</style>