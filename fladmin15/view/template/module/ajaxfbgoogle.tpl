<?php 
/* This module is copywrite to ozxmod
 * Author: ozxmod(ozxmod@gmail.com)
 * It is illegal to remove this comment without prior notice to ozxmod(ozxmod@gmail.com)
*/ 
?>
<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
	<?php if ($error_code) { ?>
        <tr>
          <td colspan="2"><span class="error"><?php echo $error_code; ?></span></td>
        </tr>
	<?php } ?>
		
	 	<tr>
	 	 <td colspan="2"><h2><?php echo $text_modulesetting; ?></h2></td>
	 	</tr>
	 	<tr>
	 	 <td><?php echo $entry_display_at_login; ?></td>
	 	 <td>
	 	 <input type="radio" name="ajaxfbgoogle_display_at_login" <?php if($ajaxfbgoogle_display_at_login == "yes") echo 'checked'; ?> value="yes"><?php echo $entry_yes; ?>
	 	 <input type="radio" name="ajaxfbgoogle_display_at_login" <?php if($ajaxfbgoogle_display_at_login == "no") echo 'checked'; ?> value="no"><?php echo $entry_no; ?>
	 	 </td>
	 	</tr>
	 	<tr>
	 	 <td  ><?php echo $entry_display_at_checkout; ?></td>
	 	 <td  >
	 	 <input type="radio" name="ajaxfbgoogle_display_at_checkout" <?php if($ajaxfbgoogle_display_at_checkout == "yes") echo 'checked'; ?> value="yes"><?php echo $entry_yes; ?>
	 	 <input type="radio" name="ajaxfbgoogle_display_at_checkout" <?php if($ajaxfbgoogle_display_at_checkout == "no") echo 'checked'; ?> value="no"><?php echo $entry_no; ?>
	 	 </td>
	 	</tr>
	 	<tr>
	 	 <td><?php echo $entry_display; ?></td>
	 	 <td  >
	 	 <input type="checkbox" name="ajaxfbgoogle_display_fb" <?php echo ($ajaxfbgoogle_display_fb)? 'checked':''; ?> value="1"><?php echo $entry_fb; ?>
	 	 <input type="checkbox" name="ajaxfbgoogle_display_google" <?php echo ($ajaxfbgoogle_display_google)? 'checked':''; ?> value="1"><?php echo $entry_google; ?>
	 	 </td>
	 	</tr>
	 	<tr>
	 	 <td  ><?php echo $entry_status; ?></td>
	 	 <td  >
	 	 <select name="ajaxfbgoogle_status">
	 	 <option value="1" <?php echo ($ajaxfbgoogle_status)? 'selected="selected"':''; ?> >Enable</option>
	 	 <option value="0" <?php echo ($ajaxfbgoogle_status)? '' : 'selected="selected"'; ?>>Disable</option>
	 	 </select>
	 	 </td>
	 	</tr>
	 	<tr>
	 	 <td colspan="2"><h2><?php echo $text_apisetting; ?></h2></td>
	 	</tr>
      	<tr>
          <td><span class="required">*</span> <?php echo $entry_apikey; ?></td>
          <td><input type="text" name="ajaxfbgoogle_apikey" id="ajaxfbgoogle_apikey" size="50" value="<?php echo $ajaxfbgoogle_apikey; ?>" /> 
          <?php echo $text_newfbapp; ?>
          </td>
		</tr>
	      	<tr>
	          <td><span class="required">*</span> <?php echo $entry_apisecret; ?></td>
	          <td><input type="text" name="ajaxfbgoogle_apisecret" id="ajaxfbgoogle_apisecret" size="50" value="<?php echo $ajaxfbgoogle_apisecret; ?>" /> </td>
	</tr>
		<tr>
          <td><span class="required">*</span> <?php echo $entry_googleapikey; ?></td>
          <td><input type="text" name="ajaxfbgoogle_googleapikey" id="ajaxfbgoogle_googleapikey" size="50" value="<?php echo $ajaxfbgoogle_googleapikey; ?>" /> 
          <?php echo $text_newgoogleapp; ?>
          </td>
		</tr>
	      	<tr>
	          <td><span class="required">*</span> <?php echo $entry_googleapisecret; ?></td>
	          <td><input type="text" name="ajaxfbgoogle_googleapisecret" id="ajaxfbgoogle_googleapisecret" size="50" value="<?php echo $ajaxfbgoogle_googleapisecret; ?>" />
	          </td>
		</tr>
		<tr>
	          <td colspan="2">
	          <?php echo $text_googlenote; ?>
	          </td>
		</tr>
    
      </table>
      
    </form>
  </div>
</div>
<?php echo $footer; ?>

<?php 
/* This module is copywrite to ozxmod
 * Author: ozxmod(ozxmod@gmail.com)
 * It is illegal to remove this comment without prior notice to ozxmod(ozxmod@gmail.com)
*/ 
?>