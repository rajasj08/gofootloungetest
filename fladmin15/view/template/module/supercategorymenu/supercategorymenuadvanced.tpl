<?php echo $header; ?>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div id="notification"></div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"> <a onclick="location = '<?php echo $settings_btn; ?>'" class="button"><span><?php echo $button_settings; ?></span></a> <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_exit; ?></span></a> </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div class="htabs" id="principal">
          <?php foreach ($stores as $store){ ?>
          <a href="#tab-store_id_<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></a>
          <?php  }  ?>
        </div>
        <div class="htabs" id="principal2">
          <?php foreach ($stores as $store){ ?>
          <div id="tab-store_id_<?php echo $store['store_id']; ?>" class="htabs-content"> <a href="#tab-category_id_s<?php echo $store['store_id']; ?>">Categories <?php echo $store['name']; ?></a> <a href="#tab-manufacturer_id_s<?php echo $store['store_id']; ?>">Manufacturers <?php echo $store['name']; ?></a> </div>
          <?php  }  ?>
        </div>
        <?php foreach ($stores as $store){ ?>
        <div id="tab-category_id_s<?php echo $store['store_id']; ?>" class="htabs-content">
          <?php

    if ($categories) {?>
          <div id="accordion<?php echo $store['store_id']; ?>">
            <?php foreach ($categories['str'.$store['store_id']] as $category) { ?>
            <h3><a href="#"><?php echo $category['name']; ?></a></h3>
            <div>
              <table class="list">
                <thead>
                  <tr>
                    <td class="left"><?php echo $column_name; ?></td>
                    <td class="Letf"><?php echo $column_action; ?></td>
                    <?php /* <td class="right"><?php echo $entry_build_cache_att; ?></td> */ ?>
                    <td class="right"><?php echo $entry_delete_cache_att; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($category['subcategories'] as $cat) { ?>
                  <tr id="<?php echo $cat['category_id']; ?>_<?php echo $store['store_id']; ?>">
                    <td class="left"><?php echo $cat['name']; ?></td>
                    <td class="left"><a class="edit" href="javascript:void(0)" store_id="<?php echo $store['store_id']; ?>" category_id="<?php echo $cat['category_id']; ?>" ><?php echo $entry_select_att; ?> <?php echo $cat['name']; ?></a></td>
                    <?php /*   <td class="right"><a class="build" href="index.php?route=module/supercategorymenuadvanced/BuildCache&token=<?php echo $this->session->data['token']; ?>&category_id=<?php echo $cat['category_id']; ?>" category_id="<?php echo $cat['category_id']; ?>" ><?php echo $entry_build_cache_att; ?></a></td> */?>
                    <td class="right"><a class="delete" href="index.php?route=module/supercategorymenuadvanced/DeleteCache&token=<?php echo $this->session->data['token']; ?>&store_id=<?php echo $store['store_id']; ?>&category_id=<?php echo $cat['category_id']; ?>"><?php echo $entry_delete_cache_att; ?></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
        <div id="tab-manufacturer_id_s<?php echo $store['store_id']; ?>" class="htabs-content">
          <?php 

       

     if ($manufacturers) {?>
          <div id="accordion2<?php echo $store['store_id']; ?>">
            <?php foreach ($manufacturers['str'.$store['store_id']] as $manufacturer) { ?>
            <h3><a href="#"><?php echo $manufacturer['name']; ?></a></h3>
            <div>
              <table class="list">
                <thead>
                  <tr>
                    <td class="left"><?php echo $column_name; ?></td>
                    <td class="Letf"><?php echo $column_action; ?></td>
                    <td class="right"><?php echo $entry_delete_cache_att; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($manufacturer['submanufacturer'] as $man) { ?>
                  <tr id="M<?php echo $man['manufacturer_id']; ?>_<?php echo $store['store_id']; ?>">
                    <td class="left"><?php echo $man['name']; ?></td>
                    <td class="left"><a class="edit_manu" href="javascript:void(0)" store_id="<?php echo $store['store_id']; ?>" manufacturer_id="<?php echo $man['manufacturer_id']; ?>" ><?php echo $entry_select_att; ?> <?php echo $man['name']; ?></a></td>
                    <td class="right"><a class="delete" href="index.php?route=module/supercategorymenuadvanced/DeleteCacheManufacturer&token=<?php echo $this->session->data['token']; ?>&store_id=<?php echo $store['store_id']; ?>&manufacturer_id=<?php echo $man['manufacturer_id']; ?>"><?php echo $entry_delete_cache_att; ?></a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
        <?php  }  ?>
      </form>
    </div>
    
    <!-- end content--> 
    
  </div>
  
  <!-- end box--> 
  
</div>
<script type="text/javascript"><!--
	function AjaxCategories(id,store){        
		$.ajax({
			success:showResponseAttributes,
			url: 'index.php?route=module/supercategorymenuadvanced/GetAllValues',
			data: 'token=<?php echo $this->session->data['token']; ?>&category_id='+id+'&store_id='+store,
			type: "GET",
			cache: true,
			error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		    }
      });};
	
	function showResponseAttributes(responseText, statusText, xhr)  { $('#valores_nuevos').fadeOut('slow', function(){$("#valores_nuevos").html(''); $("#valores_nuevos").replaceWith(responseText).fadeIn(2000); $('.loading').remove();});}
	
	$('a.edit').click(function() {
	   for(name in CKEDITOR.instances){
   		 CKEDITOR.instances[name].destroy();
	   }		
		var id = $(this).attr("category_id"); var store =$(this).attr("store_id"); 
		$(this).after('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#tr_nueva').remove();
		html='<tr id="tr_nueva"><td class="center" colspan="7"><div id="valores_nuevos"></div></td></tr>';
		$('tr#'+id+"_"+store).after(html);
		AjaxCategories(id,store);
		return false;		
	});

	function AjaxManufactures(id,store){        
		$.ajax({
			success:showResponseManufactures,  // post-submit callback 
			url: 'index.php?route=module/supercategorymenuadvanced/GetAllValuesManufacturer',
			data: 'token=<?php echo $this->session->data['token']; ?>&manufacturer_id='+id+'&store_id='+store,
			type: "GET",
			cache: true,
			error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		    }

		});
	};

	function showResponseManufactures(responseText, statusText, xhr)  { 
		   $('#valores_nuevos_manu').fadeOut('slow', function(){
		   $("#valores_nuevos_manu").html('');
		   $("#valores_nuevos_manu").replaceWith(responseText).fadeIn(2000);
		   $('.loading').remove();	
		});
	}
	$('a.edit_manu').click(function() {
		for(name in CKEDITOR.instances){
   		 CKEDITOR.instances[name].destroy();
		}	
		var  id= $(this).attr("manufacturer_id"); 
		var store =$(this).attr("store_id"); 
		$(this).after('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#tr_nueva_m').remove();
		html='<tr id="tr_nueva_m"><td class="center" colspan="7"><div id="valores_nuevos_manu"></div></td></tr>';
		$('tr#M'+id+"_"+store).after(html);
		AjaxManufactures(id,store);
		return false;		
	});

    $('a.delete').fancybox({'type':'iframe','transitionIn':'elastic','transitionOut':'elastic','speedIn':600,'speedOut':200,'scrolling':'yes','showCloseButton':false,'overlayShow':false,'autoDimensions':false,'width': 800,'height': 700,});
	
	$('a.build').fancybox({'type':'iframe','transitionIn':'elastic','transitionOut':'elastic','speedIn':600,'speedOut':200,'showCloseButton':false,'overlayShow':false,'autoDimensions':true});

<?php if ($error_warning) { ?>
   $("#notification").html('<div class="warning" style="display: none;"><?php echo $error_warning; ?></div>');
   $(".warning").fadeIn("slow");
   $('.warning').delay(2500).fadeOut('slow');
   $("html, body").animate({
         scrollTop: 0
     }, "slow")
<?php } ?>
<?php if ($success) { ?>
 $("#notification").html('<div class="success" style="display: none;"><?php echo $success; ?></div>');
   $(".success").fadeIn("slow");
   $('.success').delay(2500).fadeOut('slow');
   $("html, body").animate({
      scrollTop: 0
   }, "slow")
<?php } ?>

function Selecbox(me){
  	var dnd = me.name;
    var checked_status = me.checked;
        $('input[name^='+dnd+']:checkbox').each(function(){
              this.checked = checked_status;
       });
	obj=$('input[name^='+dnd+']:text'); obj2=$('select[name*="VALORES"]'); obj3=$('name$="[name]"');  obj4=$('textarea[name^='+dnd+']');
	if (checked_status == true) {
		obj.removeAttr('disabled');	obj2.removeAttr('disabled');obj3.removeAttr('disabled');obj4.removeAttr('disabled');
		obj.css({'background-color': '#EAF7D9','border': '1px solid #BBDF8D','color': '#555555',});
		obj2.css({'background-color': '#EAF7D9','border': '1px solid #BBDF8D','color': '#555555',});
		} else {
		obj.attr('disabled', true);	obj2.attr('disabled', true);obj3.attr('disabled', true);obj4.attr('disabled', true);
		obj.css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': '#555555',});
		obj2.css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': '#555555',});
		$('input[name$="[separator]"]').val('no');
		$('input[name$="[sort_order]"]').val('0');
		$('input[name$="[number]"]').val('8');
    }
} 

jQuery(document).ready(function(){
<?php foreach ($stores as $store){ ?>
$( "#accordion<?php echo $store['store_id']; ?>" ).accordion({autoHeight: false,navigation: true,collapsible: true,animated: 'bounceslide',active : 'none'});
$( "#accordion2<?php echo $store['store_id']; ?>" ).accordion({autoHeight: false,navigation: true,collapsible: true,animated: 'bounceslide',active : 'none'});
<?php } ?>
});
$('#principal a').tabs(); $('#principal2 a').tabs(); 
$('#principal a').click(
function() {
	var step1=$(this).attr('href');
	if (step1.slice(-1)==1){
		$('#tab-category_id_s0').hide();
		$('#tab-category_id_s1').show();
		$('#tab-store_id_1 a').first().click();
	}else{
		$('#tab-category_id_s0').show();
		$('#tab-category_id_s1').hide();
		$('#tab-store_id_0 a').first().click(); 
	}
});
//--></script> 
<?php echo $footer; ?>