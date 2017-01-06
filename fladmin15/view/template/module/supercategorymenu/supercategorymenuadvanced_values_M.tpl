<?php if ($error_warning) { ?>

<div class="warning"><?php echo $error_warning; ?></div>
<?php }else{ ?>
<div id="notificationm2"></div>
<div class="box">
  <div class="heading">
  
    <div class="selectbox" style="float:left;padding-top: 15px;">
      <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>_2" type="checkbox" value="1" onclick="SelecboxM2(this);"/>
      <?php echo $entry_remove_tabs; ?></div>
    <div class="buttons"> <a class="button" id="editmanufacturers"  href="javascript:void(0)" ><span><?php echo $button_save; ?></span></a> <a onclick="$('#tr_nueva_m').fadeOut(1000, function() { $(this).remove(); });" class="button"><span><?php echo $button_close; ?></span></a> </div>
  </div>
  <form action="<?php echo $action_save_manu; ?>" method="get" enctype="multipart/form-data" id="manufacturers">
    <input name="dnd" type="hidden" value="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>" />
    <input name="token" type="hidden" value="<?php echo $this->session->data['token']; ?>" />
    <input name="manufacturer_id" type="hidden" value="<?php echo $manufacturers['manufacturer_id']; ?>" />
    <input name="store_id" type="hidden" value="<?php echo $manufacturers['store']; ?>" />
    <div style="margin-bottom:15px"></div>
    <div class="htabs" id="tabvaluesm">
      <div id="tabsValues" class="htabs-content"> <a href="#tab-attributesm"><?php echo $entry_attributes; ?></a> <a href="#tab-optionsm"><?php echo $entry_options; ?></a> <a href="#tab-ProductInfosm"><?php echo $entry_product_info; ?></a> </div>
    </div>
    <?php $i=0; ?>
    <div id="tab-attributesm" class="htabs-content">
      <?php if (empty($manufacturers['attributes'])) {?>
      <div class="attention"><?php echo $no_attributes_m; ?> </div>
      <?php }else{ ?>
      <table id="tblattributesm" width="100%" border="0" cellpadding="2" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_value; ?><img src="view/image/information.png" width="15" height="15" hspace="10" border="0" align="absmiddle" class="tooltip" title="<?php echo $entry_values_explanation; ?>" /></td>
            <td class="left"><?php echo $entry_num_products; ?></td>
            <td class="left"><?php echo $entry_sort_order; ?></td>
            <td class="left"><?php echo $entry_view; ?></td>
            <td class="left"><?php echo $entry_unit; ?></td>
            <td class="left"><?php echo $entry_separator; ?> <img src="view/image/information.png" width="15" height="15" hspace="10" border="0" align="absmiddle" class="tooltip" title="<?php echo $entry_separator_explanation; ?>" /></td>
            <td class="left"><?php echo $text_info; ?></td>
            <td class="left"><?php echo $entry_search; ?></td>
            <td class="left"><?php echo $entry_open; ?></td>
            <td class="left"><?php echo $entry_order; ?></td>
            <td class="left"><?php echo $entry_examples; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php  foreach ($manufacturers['attributes'] as $value) { ?>
          <tr>
            <td class="left"><?php
          	$str="attribute_id";
		  	
      if ($value['checked']) { ?>
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][<?php echo $str; ?>]" type="checkbox" value="<?php echo $value[$str]; ?>" checked="checked" />
              <?php echo $value['name']; ?>
              <?php }else{ ?>
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][<?php echo $str; ?>]" type="checkbox" value="<?php echo $value[$str]; ?>" />
              <?php echo $value['name']; ?>
              <?php } ?>
              <br />
              <span class="help"><?php echo substr(strtoupper($value['what']), 0, -1); ?></span>
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][name]" type="hidden" value="<?php echo $value['name']; ?>" />
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][short_name]" type="hidden" value="<?php echo $value['short_name']; ?>" /></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][number]" type="text" value="<?php echo $value['number']; ?>" size="5"/></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][sort_order]" type="text" value="<?php echo $value['sort_order']; ?>" size="5"/></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][view]">
                <?php if ($value['view'] == "slider") { ?>
                <option value="slider" selected="selected"><?php echo $entry_slider; ?></option>
                <?php } else { ?>
                <option value="slider"><?php echo $entry_slider; ?></option>
                <?php } ?>
                <?php if ($value['view'] == "list") { ?>
                <option value="list" selected="selected"><?php echo $entry_list; ?></option>
                <?php } else { ?>
                <option value="list"><?php echo $entry_list; ?></option>
                <?php } ?>
                <?php if ($value['view'] == "sele") { ?>
                <option value="sele" selected="selected"><?php echo $entry_select; ?></option>
                <?php } else { ?>
                <option value="sele"><?php echo $entry_select; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][unit]" type="text" value="<?php echo $value['unit']; ?>" size="5"/></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][separator]" type="text" value="<?php echo $value['separator']; ?>" size="5"/></td>
            <td class="left"><select class="infotext" name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][info]">
                <?php if ($value['info'] == "yes") { ?>
                <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                <?php } else { ?>
                <option value="yes"><?php echo $text_yes; ?></option>
                <?php } ?>
                <?php if ($value['info'] == "no") { ?>
                <option value="no" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="no"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
              <?php if ($value['info'] == "yes") { ?>
              <div class="edit_info" style="float:right;"><a rel="<?php echo $i; ?>" class="edit_info_link" href="javascript:void(0)">Edit</a></div>
              <?php } else { ?>
              <div class="edit_info" style="display:none;float:right;"><a rel="<?php echo $i; ?>" class="edit_info_link" href="javascript:void(0)">Edit</a></div>
              <?php } ?></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][searchinput]">
                <?php if ($value['searchinput'] == "yes") { ?>
                <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                <?php } else { ?>
                <option value="yes"><?php echo $text_yes; ?></option>
                <?php } ?>
                <?php if ($value['searchinput'] == "no") { ?>
                <option value="no" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="no"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][initval]">
                <?php if ($value['initval'] == "opened") { ?>
                <option value="opened" selected="selected"><?php echo $text_open; ?></option>
                <?php } else { ?>
                <option value="opened"><?php echo $text_open; ?></option>
                <?php } ?>
                <?php if ($value['initval'] == "closed") { ?>
                <option value="closed" selected="selected"><?php echo $text_close; ?></option>
                <?php } else { ?>
                <option value="closed"><?php echo $text_close; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][orderval]">
                <?php if ($value['orderval'] == "OHASC") { ?>
                <option value="OHASC" selected="selected"><?php echo $text_human; ?> <?php echo $ASC; ?></option>
                <?php } else { ?>
                <option value="OHASC"><?php echo $text_human; ?> <?php echo $ASC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OHDESC") { ?>
                <option value="OHDESC" selected="selected"><?php echo $text_human; ?> <?php echo $DESC; ?></option>
                <?php } else { ?>
                <option value="OHDESC"><?php echo $text_human; ?> <?php echo $DESC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OTASC") { ?>
                <option value="OTASC" selected="selected"><?php echo $text_count; ?> <?php echo $ASC; ?></option>
                <?php } else { ?>
                <option value="OTASC"><?php echo $text_count; ?> <?php echo $ASC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OTDESC") { ?>
                <option value="OTDESC" selected="selected"><?php echo $text_count; ?> <?php echo $DESC; ?></option>
                <?php } else { ?>
                <option value="OTDESC"><?php echo $text_count; ?> <?php echo $DESC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OCOASC") { ?>
                <option value="OCOASC" selected="selected"><?php echo $text_computer; ?> <?php echo $ASC; ?></option>
                <?php } else { ?>
                <option value="OCOASC"><?php echo $text_computer; ?> <?php echo $ASC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OCODESC") { ?>
                <option value="OCODESC" selected="selected"><?php echo $text_computer; ?> <?php echo $DESC; ?></option>
                <?php } else { ?>
                <option value="OCODESC"><?php echo $text_computer; ?> <?php echo $DESC; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><?php if($value['what']=="PRODUCT INFOS") { ?>
              <select  name="select" id="select<?php echo mt_rand(5, 15); ?>" style="width: 150px" >
                <?php if (count($value['values'])>0){  
				foreach ($value['values'] as $VALORESM_default){ ?>
                <option><?php echo trim($VALORESM_default); ?></option>
                <?php } ?>
                <?php }else{ ?>
                <option> <?php echo sprintf($text_none,$value['what']);?></option>
                <?php } ?>
              </select>
              <?php }else{ ?>
              <?php foreach ($languages as $language) { ?>
              <select  name="select" id="select<?php echo mt_rand(5, 15); ?>" style="width: 150px" >
                <?php  if ($value['values'][$language['language_id']]){ 
				      natsort($value['values'][$language['language_id']]);
			          foreach ($value['values'][$language['language_id']] as $VALORESM_default){ ?>
                <option><?php echo trim($VALORESM_default); ?></option>
                <?php } ?>
                <?php }else{ ?>
                <option> <?php echo sprintf($text_none,$value['what']);?></option>
                <?php } ?>
              </select>
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
              <?php } ?>
              <?php } ?></td>
          </tr>
          <tr class="tr_txtinfo_<?php echo $i; ?>" style="display:none;">
            <td>&nbsp;</td>
            <td colspan="9" align="left"><?php foreach ($languages as $language){?>
              <textarea id="editorm_<?php echo $i; ?>_<?php echo $language['language_id']; ?>" name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][text_info][<?php echo $language['language_id']; ?>]" cols="60" rows="8"><?php echo isset($value['text_info'][$language['language_id']]) ? $value['text_info'][$language['language_id']] : ''; ?></textarea>
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
              <?php } ?></td>
            <td valign="bottom"><a onclick="$('tr.tr_txtinfo_<?php echo $i; ?>').hide();" class="button"><span><?php echo $button_close; ?></span></a></td>
          </tr>
          <?php  $i++; } ?>
        </tbody>
      </table>
      <?php } ?>
    </div>
    <div id="tab-ProductInfosm" class="htabs-content">
      <table id="tblproductInfosm" width="100%" border="0" cellpadding="2" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_value; ?><img src="view/image/information.png" width="15" height="15" hspace="10" border="0" align="absmiddle" class="tooltip" title="<?php echo $entry_values_explanation; ?>" /></td>
            <td class="left"><?php echo $entry_num_products; ?></td>
            <td class="left"><?php echo $entry_sort_order; ?></td>
            <td class="left"><?php echo $entry_view; ?></td>
            <td class="left"><?php echo $entry_unit; ?></td>
            <td class="left"><?php echo $entry_separator; ?> <img src="view/image/information.png" width="15" height="15" hspace="10" border="0" align="absmiddle" class="tooltip" title="<?php echo $entry_separator_explanation; ?>" /></td>
            <td class="left"><?php echo $text_info; ?></td>
            <td class="left"><?php echo $entry_search; ?></td>
            <td class="left"><?php echo $entry_open; ?></td>
            <td class="left"><?php echo $entry_order; ?></td>
            <td class="left"><?php echo $entry_examples; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($manufacturers['productinfo'] as $value) { ?>
          <tr>
            <td class="left"><?php
          	 $str="productinfo_id"; 
            if ($value['checked']) { ?>
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][<?php echo $str; ?>]" type="checkbox" value="<?php echo $value[$str]; ?>" checked="checked" />
              <?php echo $value['name']; ?>
              <?php }else{ ?>
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][<?php echo $str; ?>]" type="checkbox" value="<?php echo $value[$str]; ?>" />
              <?php echo $value['name']; ?>
              <?php } ?>
              <br />
              <span class="help"><?php echo substr(strtoupper($value['what']), 0, -1); ?></span>
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][name]" type="hidden" value="<?php echo $value['name']; ?>" />
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][short_name]" type="hidden" value="<?php echo $value['short_name']; ?>" /></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][number]" type="text" value="<?php echo $value['number']; ?>" size="5"/></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][sort_order]" type="text" value="<?php echo $value['sort_order']; ?>" size="5"/></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][view]">
                <?php if ($value['view'] == "slider") { ?>
                <option value="slider" selected="selected"><?php echo $entry_slider; ?></option>
                <?php } else { ?>
                <option value="slider"><?php echo $entry_slider; ?></option>
                <?php } ?>
                <?php if ($value['view'] == "list") { ?>
                <option value="list" selected="selected"><?php echo $entry_list; ?></option>
                <?php } else { ?>
                <option value="list"><?php echo $entry_list; ?></option>
                <?php } ?>
                <?php if ($value['view'] == "sele") { ?>
                <option value="sele" selected="selected"><?php echo $entry_select; ?></option>
                <?php } else { ?>
                <option value="sele"><?php echo $entry_select; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][unit]" type="text" value="<?php echo $value['unit']; ?>" size="5"/></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][separator]" type="text" value="<?php echo $value['separator']; ?>" size="5"/></td>
            <td class="left"><select class="infotext" name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][info]">
                <?php if ($value['info'] == "yes") { ?>
                <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                <?php } else { ?>
                <option value="yes"><?php echo $text_yes; ?></option>
                <?php } ?>
                <?php if ($value['info'] == "no") { ?>
                <option value="no" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="no"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
              <?php if ($value['info'] == "yes") { ?>
              <div class="edit_info" style="float:right;"><a rel="<?php echo $i; ?>" class="edit_info_link" href="javascript:void(0)">Edit</a></div>
              <?php } else { ?>
              <div class="edit_info" style="display:none;float:right;"><a rel="<?php echo $i; ?>" class="edit_info_link" href="javascript:void(0)">Edit</a></div>
              <?php } ?></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][searchinput]">
                <?php if ($value['searchinput'] == "yes") { ?>
                <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                <?php } else { ?>
                <option value="yes"><?php echo $text_yes; ?></option>
                <?php } ?>
                <?php if ($value['searchinput'] == "no") { ?>
                <option value="no" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="no"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][initval]">
                <?php if ($value['initval'] == "opened") { ?>
                <option value="opened" selected="selected"><?php echo $text_open; ?></option>
                <?php } else { ?>
                <option value="opened"><?php echo $text_open; ?></option>
                <?php } ?>
                <?php if ($value['initval'] == "closed") { ?>
                <option value="closed" selected="selected"><?php echo $text_close; ?></option>
                <?php } else { ?>
                <option value="closed"><?php echo $text_close; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][orderval]">
                <?php if ($value['orderval'] == "OHASC") { ?>
                <option value="OHASC" selected="selected"><?php echo $text_human; ?> <?php echo $ASC; ?></option>
                <?php } else { ?>
                <option value="OHASC"><?php echo $text_human; ?> <?php echo $ASC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OHDESC") { ?>
                <option value="OHDESC" selected="selected"><?php echo $text_human; ?> <?php echo $DESC; ?></option>
                <?php } else { ?>
                <option value="OHDESC"><?php echo $text_human; ?> <?php echo $DESC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OTASC") { ?>
                <option value="OTASC" selected="selected"><?php echo $text_count; ?> <?php echo $ASC; ?></option>
                <?php } else { ?>
                <option value="OTASC"><?php echo $text_count; ?> <?php echo $ASC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OTDESC") { ?>
                <option value="OTDESC" selected="selected"><?php echo $text_count; ?> <?php echo $DESC; ?></option>
                <?php } else { ?>
                <option value="OTDESC"><?php echo $text_count; ?> <?php echo $DESC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OCOASC") { ?>
                <option value="OCOASC" selected="selected"><?php echo $text_computer; ?> <?php echo $ASC; ?></option>
                <?php } else { ?>
                <option value="OCOASC"><?php echo $text_computer; ?> <?php echo $ASC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OCODESC") { ?>
                <option value="OCODESC" selected="selected"><?php echo $text_computer; ?> <?php echo $DESC; ?></option>
                <?php } else { ?>
                <option value="OCODESC"><?php echo $text_computer; ?> <?php echo $DESC; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select  name="select" id="select<?php echo mt_rand(5, 15); ?>" style="width: 150px" >
                <?php if (count($value['values'])>0){  
				foreach ($value['values'] as $VALORESM_default){ ?>
                <option><?php echo trim($VALORESM_default); ?></option>
                <?php } ?>
                <?php }else{ ?>
                <option> <?php echo sprintf($text_none,$value['what']);?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr class="tr_txtinfo_<?php echo $i; ?>" style="display:none;">
            <td>&nbsp;</td>
            
            <td colspan="9" align="left"><?php foreach ($languages as $language){?>
              <textarea id="editorm_<?php echo $i; ?>_<?php echo $language['language_id']; ?>" name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][text_info][<?php echo $language['language_id']; ?>]" cols="60" rows="8"><?php echo isset($value['text_info'][$language['language_id']]) ? $value['text_info'][$language['language_id']] : ''; ?></textarea>
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
              <?php } ?></td>
            <td valign="bottom"><a onclick="$('tr.tr_txtinfo_<?php echo $i; ?>').hide();" class="button"><span><?php echo $button_close; ?></span></a></td>
          </tr>
          <?php  $i++;  } ?>
        </tbody>
      </table>
    </div>
    <?php } ?>
    <div id="tab-optionsm" class="htabs-content">
      <?php if (empty($manufacturers['options'])) {?>
      <div class="attention"><?php echo $no_options_m; ?> </div>
      <?php }else{ ?>
      <table id="tbloptionsm" width="100%" border="0" cellpadding="2" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_value; ?><img src="view/image/information.png" width="15" height="15" hspace="10" border="0" align="absmiddle" class="tooltip" title="<?php echo $entry_values_explanation; ?>" /></td>
            <td class="left"><?php echo $entry_num_products; ?></td>
            <td class="left"><?php echo $entry_sort_order; ?></td>
            <td class="left"><?php echo $entry_view; ?></td>
            <td class="left"><?php echo $entry_unit; ?></td>
            <td class="left"><?php echo $entry_separator; ?> <img src="view/image/information.png" width="15" height="15" hspace="10" border="0" align="absmiddle" class="tooltip" title="<?php echo $entry_separator_explanation; ?>" /></td>
            <td class="left"><?php echo $text_info; ?></td>
            <td class="left"><?php echo $entry_search; ?></td>
            <td class="left"><?php echo $entry_open; ?></td>
            <td class="left"><?php echo $entry_order; ?></td>
            <td class="left"><?php echo $entry_examples; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($manufacturers['options'] as $value) { ?>
          <tr>
            <td class="left"><?php
          	$str="option_id";
		    if ($value['checked']) { ?>
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][<?php echo $str; ?>]" type="checkbox" value="<?php echo $value[$str]; ?>" checked="checked" />
              <?php echo $value['name']; ?>
              <?php }else{ ?>
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][<?php echo $str; ?>]" type="checkbox" value="<?php echo $value[$str]; ?>" />
              <?php echo $value['name']; ?>
              <?php } ?>
              <br />
              <span class="help"><?php echo substr(strtoupper($value['what']), 0, -1); ?></span>
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][name]" type="hidden" value="<?php echo $value['name']; ?>" />
              <input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][short_name]" type="hidden" value="<?php echo $value['short_name']; ?>" /></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][number]" type="text" value="<?php echo $value['number']; ?>" size="5"/></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][sort_order]" type="text" value="<?php echo $value['sort_order']; ?>" size="5"/></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][view]">
               
                <?php if ($value['view'] == "list") { ?>
                <option value="list" selected="selected"><?php echo $entry_list; ?></option>
                <?php } else { ?>
                <option value="list"><?php echo $entry_list; ?></option>
                <?php } ?>
                <?php if ($value['view'] == "sele") { ?>
                <option value="sele" selected="selected"><?php echo $entry_select; ?></option>
                <?php } else { ?>
                <option value="sele"><?php echo $entry_select; ?></option>
                <?php } ?>
                <?php if ($value['what']=="options"){ ?>
                <?php if ($value['view'] == "image") { ?>
                <option value="image" selected="selected"><?php echo $entry_image; ?></option>
                <?php } else { ?>
                <option value="image"><?php echo $entry_image; ?></option>
                <?php } ?>
                <?php  } ?>
              </select></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][unit]" type="text" value="<?php echo $value['unit']; ?>" size="5"/></td>
            <td class="left"><input name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][separator]" type="text" value="<?php echo $value['separator']; ?>" size="5"/></td>
            <td class="left"><select class="infotext" name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][info]">
                <?php if ($value['info'] == "yes") { ?>
                <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                <?php } else { ?>
                <option value="yes"><?php echo $text_yes; ?></option>
                <?php } ?>
                <?php if ($value['info'] == "no") { ?>
                <option value="no" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="no"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
              <?php if ($value['info'] == "yes") { ?>
              <div class="edit_info" style="float:right;"><a rel="<?php echo $i; ?>" class="edit_info_link" href="javascript:void(0)">Edit</a></div>
              <?php } else { ?>
              <div class="edit_info" style="display:none;float:right;"><a rel="<?php echo $i; ?>" class="edit_info_link" href="javascript:void(0)">Edit</a></div>
              <?php } ?></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][searchinput]">
                <?php if ($value['searchinput'] == "yes") { ?>
                <option value="yes" selected="selected"><?php echo $text_yes; ?></option>
                <?php } else { ?>
                <option value="yes"><?php echo $text_yes; ?></option>
                <?php } ?>
                <?php if ($value['searchinput'] == "no") { ?>
                <option value="no" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="no"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][initval]">
                <?php if ($value['initval'] == "opened") { ?>
                <option value="opened" selected="selected"><?php echo $text_open; ?></option>
                <?php } else { ?>
                <option value="opened"><?php echo $text_open; ?></option>
                <?php } ?>
                <?php if ($value['initval'] == "closed") { ?>
                <option value="closed" selected="selected"><?php echo $text_close; ?></option>
                <?php } else { ?>
                <option value="closed"><?php echo $text_close; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][orderval]">
                <?php if ($value['what']=="options"){ ?>
                <?php if ($value['orderval'] == "OCASC") { ?>
                <option value="OCASC" selected="selected"><?php echo $opencart; ?> <?php echo $ASC; ?></option>
                <?php } else { ?>
                <option value="OCASC"><?php echo $opencart; ?> <?php echo $ASC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OCDESC") { ?>
                <option value="OCDESC" selected="selected"><?php echo $opencart; ?> <?php echo $DESC; ?></option>
                <?php } else { ?>
                <option value="OCDESC"><?php echo $opencart; ?> <?php echo $DESC; ?></option>
                <?php } ?>
                <?php } ?>
                <?php if ($value['orderval'] == "OHASC") { ?>
                <option value="OHASC" selected="selected"><?php echo $text_human; ?> <?php echo $ASC; ?></option>
                <?php } else { ?>
                <option value="OHASC"><?php echo $text_human; ?> <?php echo $ASC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OHDESC") { ?>
                <option value="OHDESC" selected="selected"><?php echo $text_human; ?> <?php echo $DESC; ?></option>
                <?php } else { ?>
                <option value="OHDESC"><?php echo $text_human; ?> <?php echo $DESC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OTASC") { ?>
                <option value="OTASC" selected="selected"><?php echo $text_count; ?> <?php echo $ASC; ?></option>
                <?php } else { ?>
                <option value="OTASC"><?php echo $text_count; ?> <?php echo $ASC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OTDESC") { ?>
                <option value="OTDESC" selected="selected"><?php echo $text_count; ?> <?php echo $DESC; ?></option>
                <?php } else { ?>
                <option value="OTDESC"><?php echo $text_count; ?> <?php echo $DESC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OCOASC") { ?>
                <option value="OCOASC" selected="selected"><?php echo $text_computer; ?> <?php echo $ASC; ?></option>
                <?php } else { ?>
                <option value="OCOASC"><?php echo $text_computer; ?> <?php echo $ASC; ?></option>
                <?php } ?>
                <?php if ($value['orderval'] == "OCODESC") { ?>
                <option value="OCODESC" selected="selected"><?php echo $text_computer; ?> <?php echo $DESC; ?></option>
                <?php } else { ?>
                <option value="OCODESC"><?php echo $text_computer; ?> <?php echo $DESC; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><?php foreach ($languages as $language) { ?>
              <select  name="select" id="select<?php echo mt_rand(5, 15); ?>" style="width: 150px" >
                <?php  if ($value['values'][$language['language_id']]){ 
				      natsort($value['values'][$language['language_id']]);
			          foreach ($value['values'][$language['language_id']] as $VALORESM_default){ ?>
                <option><?php echo trim($VALORESM_default); ?></option>
                <?php } ?>
                <?php }else{ ?>
                <option> <?php echo sprintf($text_none,$value['what']);?></option>
                <?php } ?>
              </select>
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
              <?php } ?></td>
          </tr>
          <tr class="tr_txtinfo_<?php echo $i; ?>" style="display:none;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="8" align="left"><?php foreach ($languages as $language){?>
              <textarea id="editorm_<?php echo $i; ?>_<?php echo $language['language_id']; ?>" name="VALORESM_<?php echo $manufacturers['manufacturer_id']; ?>[<?php echo $value['what']; ?>][<?php echo $value[$str]; ?>][text_info][<?php echo $language['language_id']; ?>]" cols="60" rows="8"><?php echo isset($value['text_info'][$language['language_id']]) ? $value['text_info'][$language['language_id']] : ''; ?></textarea>
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
              <?php } ?></td>
            <td valign="bottom"><a onclick="$('tr.tr_txtinfo_<?php echo $i; ?>').hide();" class="button"><span><?php echo $button_close; ?></span></a></td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
      <?php } ?>
    </div>
  </form>
</div>
<script type="text/javascript"><!--
	function CKupdate(){
		for ( instance in CKEDITOR.instances )
			CKEDITOR.instances[instance].updateElement();
	}

	$('a#editmanufacturers').click(function() {

     if(!$('#manufacturers input[type=checkbox]:checked').length) {
        //stop the form from submitting
		alert("Please select at least one to upgrade. Or click on close");
        return false
     
	 }else{
   
	 CKupdate();	
	 $.ajax({
     success :editsuccessm,  // post-submit callback 
     url: "index.php?route=module/supercategorymenuadvanced/SetAllValuesManufacturer&token=<?php echo $this->session->data['token']; ?>",
     data: $('#manufacturers').serialize(),
     type: "POST",
	 cache: true,
	 error: function(xhr, ajaxOptions, thrownError){
			alert('responseText: \n' + thrownError +'.'); }
    });}});


function editsuccessm(responseText, statusText, xhr){
	$("#notificationm2").html("<div class=\"success\" style=\"display:none;\"><?php echo $success; ?></div>");
	$(".success").fadeIn("slow");
    $('.success').delay(3500).fadeOut('slow');
}
$("img.tooltip").tooltip({
	track: true, 
    delay: 0, 
    showURL: false, 
    showBody: " - ", 
    fade: 250 
});

$('#tblattributesm,#tbloptionsm,#tblproductInfosm').delegate(':checkbox', 'change', function() {

	obj=$(this).closest('tr').find('input:text');
	obj2=$(this).closest('tr').find('select[name*="VALORES"]');   
    obj3=$(this).closest('tr').find('input:hidden');
	obj4=$(this).closest('tr').next().find('textarea');

    if (this.checked) {

       obj.removeAttr('disabled'); obj2.removeAttr('disabled'); obj3.removeAttr('disabled');  obj4.removeAttr('disabled');
       obj.css({'background-color': '#EAF7D9','border': '1px solid #BBDF8D','color': '#555555', });
	   obj2.css({'background-color': '#EAF7D9','border': '1px solid #BBDF8D','color': '#555555', });

    } else {

	  obj.attr('disabled', true); obj2.attr('disabled', true); obj3.attr('disabled', true); obj4.attr('disabled', true);
      obj.css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': '#555555',});
	  obj2.css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': '#555555',});
        $(this).closest('tr').find('input:text:eq(0)').val('8');  
        $(this).closest('tr').find('input:text:eq(1)').val('0');  
        $(this).closest('tr').find('input:text:eq(3)').val('no');  
	}
});



$(':checkbox').change(); //set initially

$('.infotext').change(function() {
	obj=$(this).closest('td').find('div.edit_info');
	value=$(this).val();
		if (value=="yes"){
		obj.show();
		}else{
		obj.hide();
		}
});

$('a.edit_info_link').click(function() {		
	var wrt=$(this).attr('rel');
	$(this).closest('tr').next().show();
	<?php foreach ($languages as $language){?>
	CKEDITOR.replace('editorm_'+wrt+'_<?php echo $language['language_id']; ?>', {
		filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $this->session->data['token']; ?>',
		filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $this->session->data['token']; ?>',
		filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $this->session->data['token']; ?>',
		filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $this->session->data['token']; ?>',
		filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $this->session->data['token']; ?>',
		filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $this->session->data['token']; ?>'
	});
	<?php } ?>
});
$('#tabvaluesm a').tabs(); 

function SelecboxM2(me){
  	var dnd = me.name;
	var checked_status = me.checked;
        $('input[name^='+dnd+'_2]:checkbox').each(function(){
              this.checked = checked_status;
       });
	
	
	if (checked_status == true) {
		$('#tabvaluesm,#tblproductInfosm thead ,#tbloptionsm thead').hide();
		$('#tab-attributesm,#tab-optionsm,#tab-ProductInfosm').show();
    } else {
		$('#tabvaluesm,#tblproductInfosm thead ,#tbloptionsm thead').show();
		$('#tabvaluesm a').tabs();
    }
	
} 
//--></script> 