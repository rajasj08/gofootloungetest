<?php echo $header; ?>
<div id="content" class="cp">
      <div class="heading">
        <h1><?php echo $heading_title2; ?></h1>
       
          <div class="buttons">
	
         <a onclick="$('#form').submit();" class="btn btn-success"><?php echo $button_save; ?></a>
			<a onclick="location = '<?php echo $cancel; ?>';" class="btn btn-danger"><?php echo $button_cancel; ?></a>
         </div>
      </div>
	    <a href="http://opencartmobileapp.com/" target="_blank" class="btn btn-success"><img src="view/javascript/kodecube/arrow.gif" />Check our Awsome Opencart Mobile APP</a>
			<a href="http://kodecube.com/" target="_blank" class="btn btn-success"><img src="view/javascript/kodecube/arrow.gif" />Visit Kodecube</a>
    <?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>

    <script>
    $(document).ready(function(){
      setTimeout(function() {
        $('.success').delay(3000).fadeOut('slow');
      }, 1000);
    });
    </script>
  	<div class="box">
	
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Oswald" />
		<link rel="stylesheet" type="text/css" href="view/javascript/kodecube/kodecube.css" />
		<link rel="stylesheet" type="text/css" href="view/javascript/kodecube/bootstrap/css/bootstrap.css" />
		<script type="text/javascript" src="view/javascript/kodecube/kodecube.js"></script>
		<script type="text/javascript" src="view/javascript/kodecube/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="view/javascript/kodecube/jquery.switch/jquery.switch.min.js"></script>
		<script type="text/javascript" src="view/javascript/kodecube/jquery.switch/prettyCheckable.js"></script>
		<script type="text/javascript" src="view/javascript/kodecube/jscolor.js"></script>
		<link rel="stylesheet" type="text/css" href="view/javascript/kodecube/jquery.switch/jquery.switch.css" />
		<link rel="stylesheet" type="view/javascript/kodecube/jquery.switch/prettyCheckable.css" />


	   <div class="content">
  
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <?php if (isset($validation)) { ?>
        <table class="form">
            <tr>
                <td colspan="2">
                    <span style='text-align: center;'><b><?php echo $text_licence_info; ?></b></span>
                </td>
            </tr>
            <tr>
                <td><?php echo $entry_transaction_email; ?></td>
                <td><input type="text" name="email" value="" /></td>
            </tr>
            <tr>
                <td><?php echo $entry_transaction_id; ?></td>
                <td><input type="text" name="purchasevoucher_transaction_id" value="" /></td>
            </tr>
        </table>
        <?php } else { ?>


		
<!-- horizontal tabs -->

        <div class="htabs main-tabs ui-tabs">

          
          <a href="#general"><?php echo $entry_general; ?></a>
   <a href="#mail"><?php echo $entry_mail; ?></a>
   
   <a href="#support"><?php echo $entry_support; ?></a>

        </div>
        <!-- horizontal tabs content -->
		
	
	<div id="general" class="ui-tabs-hide">
            <!-- vertical tabs -->
            
            <div class="vtabs vtabs ui-tabs">
          
              <a href="#vtab-1-1"><?php echo $entry_general; ?></a>
	
            </div>
           
            <!-- vertical tabs content -->
			
          
            <div id="vtab-1-1" class="vtabs-content ui-tabs-hide">
			<table class="form">
		 <input type="hidden" id="purchasevoucher_transaction_id" name="purchasevoucher_transaction_id" value="<?php echo $purchasevoucher_transaction_id; ?>">
    <input type="hidden" id="purchasevoucher_subscribemodule" name="purchasevoucher_subscribemodule" value="1">
  
        <tr>
          <td><?php echo $entry_enabled; ?></td>
          <td><select class="yes_no" name="purchasevoucher_status">
              <?php if ($purchasevoucher_status) { ?>
              <option value="1" selected="selected"><?php echo $text_yes; ?></option>
              <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_yes; ?></option>
              <option value="0" selected="selected"><?php echo $text_no; ?></option>

              <?php } ?>
            </select></td>
        </tr>
     <tr>
	 

	 
	 
          <td><?php echo $entry_prefix; ?> </td>
 <td><input class="small" type="text" name="purchasevoucher_prefix" value="<?php echo $purchasevoucher_prefix; ?>" /></td>
            </tr>
       
<tr>
          <td><?php echo $entry_emailno; ?> </td>
 <td><input class="small" type="text" name="purchasevoucher_emailno" value="<?php echo $purchasevoucher_emailno; ?>" /></td>
            </tr>
			
			
			        <tr>
          <td><?php echo $entry_reedem; ?></td>
          <td><select class="yes_no" name="purchasevoucher_reedem">
              <?php if ($purchasevoucher_reedem) { ?>
              <option value="1" selected="selected"><?php echo $text_yes; ?></option>
              <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_yes; ?></option>
              <option value="0" selected="selected"><?php echo $text_no; ?></option>

              <?php } ?>
            </select></td>
        </tr>
			
		<tr>
          <td><?php echo $entry_points; ?> </td>
 <td><input class="small" type="text" name="purchasevoucher_points" value="<?php echo $purchasevoucher_points; ?>" /></td>
            </tr>	
		
				  <tr>
          <td><?php echo $payment_status; ?></td>
		<td>
			<select name="purchasevoucher_orderstatus">
           <?php foreach($orderstatus as $status){ ?>
                <option value="<?php echo $status['order_status_id']; ?>" <?php if ($status['order_status_id']==$purchasevoucher_orderstatus) { ?> selected="selected" <?php }; ?> ><?php echo $status['name']; ?>
				
				</option>
           <?php }?>
		     </select></td> </tr>
			
			<tr>
    <td>
	
	<input type="checkbox" name="purchasevoucher_payment_limit" value="1" <?php echo $purchasevoucher_payment_limit?'checked="checked"':'' ; ?> />
	
	</td>

    <td><?php echo $force_payment_method; ?></td>
        <td>
		
		<div class="scrollbox">
                  <?php 
		 $payment_methods=array();
				  $files = glob(DIR_APPLICATION . 'controller/payment/*.php');
		
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				
				$this->load->language('payment/' . $extension);
	
				$action = array();				
				$payment_methods[] = array(
					'code'       => $extension,
					'name'       => $this->language->get('heading_title'),
					'status'     => $this->config->get($extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'sort_order' => $this->config->get($extension . '_sort_order'),
					'action'     => $action
				);
			}
		}
		
		$purchasevoucher_payment_limit=explode('|',$purchasevoucher_payment_methods);
				  $class = 'odd'; ?>
                  <?php foreach ($payment_methods as $payment_method) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    
                    <input type="checkbox" name="purchasevoucher_payment_methods_array[]" onclick="set_force_payment_methods()" value="<?php echo $payment_method['code']; ?>" <?php if (in_array($payment_method['code'], $purchasevoucher_payment_limit)) { ?>
                   checked="checked"
                    <?php }  ?> />
                    <?php echo $payment_method['name']; ?>
                  
                  </div>
                  <?php } ?>
				  
                </div>
				
				
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);">Select All</a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);">Unselect All</a>
	
	</td>
	 </tr>
	 
	 
	  <tr>
	  <td>
	
	<input type="checkbox" name="purchasevoucher_total_limit" value="1" <?php echo $purchasevoucher_total_limit?'checked="checked"':'' ; ?> />
	
	</td>
	
	
	     <td><?php echo $force_total_method; ?></td>
	<td>
		
		<div class="scrollbox">
                  <?php 
		 $total_methods=array();
				  $files = glob(DIR_APPLICATION . 'controller/total/*.php');
		
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				
				$this->load->language('total/' . $extension);
	
				$action = array();				
				$total_methods[] = array(
					'code'       => $extension,
					'name'       => $this->language->get('heading_title'),
					'status'     => $this->config->get($extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'sort_order' => $this->config->get($extension . '_sort_order'),
					'action'     => $action
				);
			}
		}
		
		$purchasevoucher_total_limit=explode('|',$purchasevoucher_total_methods);
				  $class = 'odd'; ?>
                  <?php foreach ($total_methods as $total_method) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    
                    <input type="checkbox" name="purchasevoucher_total_methods_array[]" onclick="set_force_total_methods()" value="<?php echo $total_method['code']; ?>" <?php if (in_array($total_method['code'], $purchasevoucher_total_limit)) { ?>
                   checked="checked"
                    <?php }  ?> />
                    <?php echo $total_method['name']; ?>
                  
                  </div>
                  <?php } ?>
				  
                </div>
				
				
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);">Select All</a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);">Unselect All</a>
	</td>
      </tr>
	


			
			</table>
           
</div> 
		
		
               </div>
	
	
	
        <div id="mail" class="ui-tabs-hide">
            <!-- vertical tabs -->
            
            <div class="vtabs vtabs ui-tabs">
          
              
<?php foreach ($languages as $language) { ?>
 <a href="#mail<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php echo $entry_mailtemplate; ?>-<?php echo $language['name']; ?></a>

  

  
                                    <?php } ?>	
         
            </div>
           

			  
   <?php foreach ($languages as $language) { ?>
          <div id="mail<?php echo $language['language_id']; ?>" class="vtabs-content ui-tabs-hide">
             <table class="form">
		

			<tr>
          <td><?php echo $entry_subject_customer; ?> </td>
		 <td><textarea name="purchasevoucher_autosubject_<?php echo $language['language_id']; ?>_customer" cols="100" rows="10"><?php echo isset($purchasevoucher_autosubject[$language['language_id']]['customer']) ? $purchasevoucher_autosubject[$language['language_id']]['customer'] : ''; ?></textarea></td>
                                            </tr>
		
		<tr>
          <td><?php echo $entry_mail_customer; ?> </td>
		  
		  <td><textarea name="purchasevoucher_automail_<?php echo $language['language_id']; ?>_customer" cols="200" rows="2"><?php echo isset($purchasevoucher_automail[$language['language_id']]['customer']) ? $purchasevoucher_automail[$language['language_id']]['customer'] : ''; ?></textarea></td>
              </tr>	
			

			
		 
			
		<tr>
          <td><?php echo $entry_subject_admin; ?> </td>
		  <td><textarea name="purchasevoucher_autosubject_<?php echo $language['language_id']; ?>_admin" cols="200" rows="2"><?php echo isset($purchasevoucher_autosubject[$language['language_id']]['admin']) ? $purchasevoucher_autosubject[$language['language_id']]['admin'] : ''; ?></textarea></td>
              </tr>	

			
			<tr>
          <td><?php echo $entry_mail_admin; ?> </td>
		  	  <td><textarea name="purchasevoucher_automail_<?php echo $language['language_id']; ?>_admin" cols="100" rows="10"><?php echo isset($purchasevoucher_automail[$language['language_id']]['admin']) ? $purchasevoucher_automail[$language['language_id']]['admin'] : ''; ?></textarea></td>
                                            </tr>
											
											
						<tr>
          <td><?php echo $entry_voucherdetail; ?> </td>
		  	  <td><textarea name="purchasevoucher_voucherdetail_<?php echo $language['language_id']; ?>_line" cols="100" rows="10"><?php echo isset($purchasevoucher_voucherdetail[$language['language_id']]['line']) ? $purchasevoucher_voucherdetail[$language['language_id']]['line'] : ''; ?></textarea></td>
                                            </tr>
											
											
	
			<tr>
          <td><?php echo $entry_subject_gift; ?> </td>
		 <td><textarea name="purchasevoucher_autosubject_<?php echo $language['language_id']; ?>_gift" cols="100" rows="10"><?php echo isset($purchasevoucher_autosubject[$language['language_id']]['gift']) ? $purchasevoucher_autosubject[$language['language_id']]['gift'] : ''; ?></textarea></td>
                                            </tr>
		
		<tr>
          <td><?php echo $entry_mail_gift; ?> </td>
		  
		  <td><textarea name="purchasevoucher_automail_<?php echo $language['language_id']; ?>_gift" cols="200" rows="2"><?php echo isset($purchasevoucher_automail[$language['language_id']]['gift']) ? $purchasevoucher_automail[$language['language_id']]['gift'] : ''; ?></textarea></td>
              </tr>	
	
	
	<tr>
          <td><?php echo $entry_message; ?> </td>
		  	  <td><textarea name="purchasevoucher_message_<?php echo $language['language_id']; ?>_line" cols="100" rows="4"><?php echo isset($purchasevoucher_message[$language['language_id']]['line']) ? $purchasevoucher_message[$language['language_id']]['line'] : ''; ?></textarea></td>
                                            </tr>
	
			</table>  
			</div>
			<?php } ?>
	
		  
		   </div>
	   
	  
	   
	   
	   <div id="support" class="ui-tabs-hide">
	               <div class="vtabs vtabs ui-tabs">
          
     <a href="#vtab-1-4"><?php echo $tab_support; ?></a>
         
            </div>
	         <div id="vtab-1-4" class="vtabs-content ui-tabs-hide">
    <iframe src="http://kodecube.com/ocadds/add1.html" width="730" height="500"></iframe>
			<table class="form">  
			
			<?php echo $text_info; ?>

		</table>
        </div>
	   </div>

      <table id="module" class="list">
        <thead>
          <tr>
		  <td class="left"><?php echo $entry_limit; ?></td>
              <td class="left"><?php echo $entry_image; ?></td>
            <td class="left"><?php echo $entry_layout; ?></td>
            <td class="left"><?php echo $entry_position; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="right"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>
        <?php $module_row = 0; ?>
        <?php foreach ($modules as $module) { ?>
        <tbody id="module-row<?php echo $module_row; ?>">
          <tr> 
		       <td class="left"><input type="text" name="purchasevoucher_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="1" /></td>
              <td class="left"><input type="text" name="purchasevoucher_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" />
                <input type="text" name="purchasevoucher_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" />
                <?php if (isset($error_image[$module_row])) { ?>
                <span class="error"><?php echo $error_image[$module_row]; ?></span>
                <?php } ?></td>
            <td class="left"><select name="purchasevoucher_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                <?php if($layout['layout_id'] == $module['layout_id']){ ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td class="left"><select name="purchasevoucher_module[<?php echo $module_row; ?>][position]">
                <?php if ($module['position'] == 'content_top') { ?>
                <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                <?php } else { ?>
                <option value="content_top"><?php echo $text_content_top; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'content_bottom') { ?>
                <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                <?php } else { ?>
                <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'column_left') { ?>
                <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                <?php } else { ?>
                <option value="column_left"><?php echo $text_column_left; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'column_right') { ?>
                <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                <?php } else { ?>
                <option value="column_right"><?php echo $text_column_right; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="purchasevoucher_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="right"><input type="text" name="purchasevoucher_module[<?php echo $module_row; ?>][sort_order]" class="small" value="<?php echo $module['sort_order'];  ?>" size="3" /></td>
            <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
          </tr>
        </tbody>
        <?php $module_row++; ?>
        <?php } ?>
        <tfoot>
          <tr>
            <td colspan="5"></td>
            <td class="left"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
          </tr>
        </tfoot>
      </table>
	  
	  <?php } ?>
	
    </form>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
html += '  <tr>';
   	html += '    <td class="left"><input type="text" name="purchasevoucher_module[' + module_row + '][limit]" value="5" size="1" /></td>';
	html += '    <td class="left"><input type="text" name="purchasevoucher_module[' + module_row + '][image_width]" value="80" size="3" /> <input type="text" name="purchasevoucher_module[' + module_row + '][image_height]" value="80" size="3" /></td>';

	
	html += '    <td class="left"><select name="purchasevoucher_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="purchasevoucher_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="purchasevoucher_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" class="small" name="purchasevoucher_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}

$('#form').bind('submit', function() {
	var module = new Array(); 

	$('#module tbody').each(function(index, element) {
		module[index] = $(element).attr('id').substr(10);
	});
	
	$('input[name=\'purchasevoucher_module\']').attr('value', module.join(','));
});
//--></script>

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo 'image manager'; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
 
<script type="text/javascript">

$(function(){
  $('.htabs a').click(function(){
    $.address.value($(this).attr('href').substr(1));
  });

  $('.vtabs a').click(function(){
    $.address.value($('.htabs a.selected').attr('href').substr(1) + '/' + $(this).attr('href').substr(1));
  });

  $.address.init(function(event){
    var main = event.pathNames.length > 0 ? event.pathNames[0] : $('.htabs a').first().attr('href').substr(1);
    var sec = event.pathNames.length > 1 ? event.pathNames[1] : $('#' + main + ' .vtabs a').first().attr('href').substr(1);
    $('a[href="#' + main +'"]').click();
    $('a[href="#' + sec +'"]').click();
  });
});

(function(){
  $('.main-tabs a').tabs();
  $('.vtabs a').tabs();
  $('.main-tabs a').click(function(){
      var tab = $(this).attr("href");
      $(tab + ' .vtabs a').first().click();
      if (tab === '#main-tabs-fonts') {
        $('.preview-fonts').show();
      } else {
        $('.preview-fonts').hide();
      }
  });
  $('.ui-tabs-hide').removeClass('ui-tabs-hide');
  // $('a[href=#main-tabs-menus]').click();
  // $('a[href=#vtab-menus-categories_menu]').click();
})();
function showValue(str,name){//////////this is possible in class name only not in id.
	
	
	document.getElementsByName(name)[0].value = str;
	
}


</script>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
        
 			
		        CKEDITOR.replace('purchasevoucher_automail_<?php echo $language['language_id']; ?>_customer', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });
		   
        CKEDITOR.replace('purchasevoucher_automail_<?php echo $language['language_id']; ?>_admin', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });

   CKEDITOR.replace('purchasevoucher_voucherdetail_<?php echo $language['language_id']; ?>_line', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });			
		

		      CKEDITOR.replace('purchasevoucher_automail_<?php echo $language['language_id']; ?>_gift', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });	
		
		    CKEDITOR.replace('purchasevoucher_voucherdetail_<?php echo $language['language_id']; ?>_line', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });	

		
		
		
		
		
<?php } ?>

//--></script> 