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

<section class="col-md-<?php echo $SPAN[1];?> <?php echo $class_3cols;?> test">	
	<div id="content">
		<?php echo $content_top; ?>   
		<div class="search">
			<h1><?php echo $heading_title; ?></h1>
			<label for="input-search" class="control-label" style="font-size:12px !important; font-weight:bold;" ><?php echo $text_critea; ?></label>
			<div class="content">
				<div class="wrapper search_styles"> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-horizontal">
								<div class="form-group">
									<label for="search" class="col-md-4 control-label hidden-xs hidden-sm" style="font-size:12px !important;font-weight:bold;"><?php echo $entry_search; ?> </label>
									<div class="col-md-8">
										<?php if ($search) { ?>
										<input type="text" name="search" value="<?php echo $search; ?>" class="input-text form-control" style="font-size:12px !important;" />
										<?php } else { ?>
										<input type="text" name="search" value="<?php echo $search; ?>" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;"  class="input-text form-control" style="font-size:12px !important;" />
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<select name="category_id" class="form-control" style="font-size:12px !important;">
								<option value="0"><?php echo $text_category; ?></option>
								<?php foreach ($categories as $category_1) { ?>
								<?php if ($category_1['category_id'] == $category_id) { ?>
								<option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
								<?php } ?>
								<?php foreach ($category_1['children'] as $category_2) { ?>
								<?php if ($category_2['category_id'] == $category_id) { ?>
								<option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
								<?php } ?>
								<?php foreach ($category_2['children'] as $category_3) { ?>
								<?php if ($category_3['category_id'] == $category_id) { ?>
								<option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
								<?php } ?>
								<?php } ?>
								<?php } ?>
								<?php } ?>
							</select>
						</div>

 
						<div class="col-md-2">
								<div class="buttons btnstyle">
									<div class="left"><input type="button" value="<?php echo $button_search; ?>" id="button-search" class="button btn btn-theme-default" style="font-size:12px !important; width:130px;"/></div>
								</div>
						</div>  
						<!--<div class="col-md-4">
							<label for="sub_category" class="checkbox">
								<?php if ($sub_category) { ?>
								<input type="checkbox" name="sub_category" value="1" id="sub_category" checked="checked" />
								<?php } else { ?>
								<input type="checkbox" name="sub_category" value="1" id="sub_category" />
								<?php } ?>
								<?php echo $text_sub_category; ?>
							</label>
						</div>--> 
					</div>
					<!--<p>
						<label for="description" class="checkbox">
							<?php if ($description) { ?>
							<input type="checkbox" name="description" value="1" id="description" checked="checked" />
							<?php } else { ?>
							<input type="checkbox" name="description" value="1" id="description" />
							<?php } ?>
							<?php echo $entry_description; ?>
						</label>
					</p>-->
				</div>				
			</div>
  
			
  
			<h2><?php echo $text_search; ?></h2> 
			
			<?php if ($products) { ?>
				<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/product/product_collection_searchresult.tpl" );  ?>
			<?php } ?>
  
			<?php if (!$categories && !$products) { ?>
			<div class="content"><div class="wrapper"><?php echo $text_empty; ?></div></div>
			<div class="buttons">
				<div class="right"><a href="<?php echo $continue; ?>" class="button btn btn-theme-default"><?php echo $button_continue; ?></a></div>
			</div>
			<?php } ?>
    
			<?php echo $content_bottom; ?>
		</div>
  
  
<script type="text/javascript"><!--
$('#content input[name=\'search\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').bind('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').attr('disabled', 'disabled');
		$('input[name=\'sub_category\']').removeAttr('checked');
	} else {
		$('input[name=\'sub_category\']').removeAttr('disabled');
	}
});

$('select[name=\'category_id\']').trigger('change');

$('#button-search').bind('click', function() {
	url = 'search?'; 
	 
	var search = $('#content input[name=\'search\']').attr('value');
	
	if (search) {
		url += 'term=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').attr('value');
	
	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}
	
	var sub_category = $('#content input[name=\'sub_category\']:checked').attr('value');
	
	if (sub_category) {
		url += '&sub_category=true';
	}
		
	var filter_description = $('#content input[name=\'description\']:checked').attr('value');
	
	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});
  
function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');
		
		$('.products-block  .product-block').each(function(index, element) {
 
			 $(element).parent().addClass("col-fullwidth");
		});		
		
		$('.display').html('<span style="float: left;"><?php echo $text_display; ?></span><a class="list active"><i class="fa fa-th-list"></i><em><?php echo $text_list; ?></em></a><a class="grid" onclick="display(\'grid\');"><i class="fa fa-th"></i><em><?php echo $text_grid; ?></em></a>');
	
		$.totalStorage('display', 'list'); 
	} else {
		$('.product-list').attr('class', 'product-grid');
		
		$('.products-block  .product-block').each(function(index, element) {
			 $(element).parent().removeClass("col-fullwidth");  
		});	
					
		$('.display').html('<span style="float: left;"><?php echo $text_display; ?></span><a class="list" onclick="display(\'list\');"><i class="fa fa-th-list"></i><em><?php echo $text_list; ?></em></a><a class="grid active"><i class="fa fa-th"></i><em><?php echo $text_grid; ?></em></a>');
	
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
</div></div></div>



<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="closemodal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">EMAIL NOTIFICATION</h4>
      </div>
      <div class="modal-body">
     <div style="margin-bottom: 20px;" ><p> Notify me when the product is back in Stock!</p></div>

       	<form class="form-horizontal">
       	<input type="hidden" id="npro_id" name="npro_id">
       	<input type="hidden" id="pro_name" name="pro_name">
       		<input type="hidden" id="pro_href" name="pro_href">
       	<div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Product Name</label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="Nproductname" placeholder="Product Name" disabled="disabled" style=" font-weight:bold;">
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
		  <!--<div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Name<span class="mand_field">*</span></label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="Nname" placeholder="Name">
		    </div>
		  </div>-->

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
      <div class="modal-footer" style=" padding: 8px 20px 8px !important;">
      <span class="alert alert-success" style=" padding:5px !important; margin-bottom:0px; display:none;"  id="success_msgaa">send successfully</span>
      <span class="alert alert-danger" style=" padding:5px !important; margin-bottom:0px;display:none;" id="failure_msg">sending failed</span>
      	<img src="https://gofootlounge.in/image/loading_spinner.gif" alt="loading..." id="image_spinner">
        <button type="button" class="btn btn-default" id="closebtn" onclick="closemodal();">Close</button>
        <button type="button" class="btn btn-primary" id="sendbtn" onclick="sendnotify();">Send</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript"> 

var google_tag_params = {  

ecomm_pagetype: "searchresults",

}; 
</script>

<script>
	// Search
// Track searches on your website (ex. product searches)
fbq('track', 'Search');
</script>

<?php echo $footer; ?>