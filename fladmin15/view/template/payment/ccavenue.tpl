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
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_Merchant_Id; ?></td>
            <td><input type="text" name="ccavenue_Merchant_Id" value="<?php echo $ccavenue_Merchant_Id; ?>" />
              <?php if ($error_Merchant_Id) { ?>
              <span class="error"><?php echo $error_Merchant_Id; ?></span>
              <?php } ?></td>
          </tr>				
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_total; ?></td>
            <td><input type="text" name="ccavenue_total" value="<?php echo $ccavenue_total; ?>" /><?php if ($error_total) { ?>
              <span class="error"><?php echo $error_total; ?></span>
              <?php } ?></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_workingkey; ?></td>
            <td><input type="text" name="ccavenue_workingkey" value="<?php echo $ccavenue_workingkey; ?>" /><?php if ($error_workingkey) { ?>
              <span class="error"><?php echo $error_workingkey; ?></span>
              <?php } ?></td>
          </tr>

			 <tr>
            <td><span class="required">*</span> <?php echo $entry_access_code; ?></td>
            <td><input type="text" name="ccavenue_access_code" value="<?php echo $ccavenue_access_code; ?>" /><?php if ($error_access_code) { ?>
              <span class="error"><?php echo $error_access_code; ?></span>
              <?php } ?></td>
          </tr>  
          
          <tr>
            <td><?php echo $entry_completed_status; ?></td>
            <td><select name="ccavenue_completed_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $ccavenue_completed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          
          <tr>
            <td><?php echo $entry_failed_status; ?></td>
            <td><select name="ccavenue_failed_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $ccavenue_failed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_pending_status; ?></td>
            <td><select name="ccavenue_pending_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $ccavenue_pending_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="ccavenue_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $ccavenue_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
					<tr>
							<td><?php echo $entry_checkout_method ?></td>
							<td>
								<select name="ccavenue_checkout_method">
									<?php if ($ccavenue_checkout_method == 'iframe'){ ?>									
									<option value="iframe" selected="selected"><?php echo $text_iframe ?></option>
									<option value="redirect"><?php echo $text_redirect ?></option>									
									<?php }else{ ?>
									<option value="iframe"><?php echo $text_iframe ?></option>
									<option value="redirect" selected="selected"><?php echo $text_redirect ?></option>									
									<?php } ?>
								</select>
							</td>
					</tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="ccavenue_status">
                <?php if ($ccavenue_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="ccavenue_sort_order" value="<?php echo $ccavenue_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 