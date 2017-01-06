<div class="container-fluid">
    <div class="row">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left">Upsell Name</td>
            <td class="text-left">Status</td>
            <td class="text-right">Action</td>
          </tr>
        </thead>
        <tbody>
          <?php if ($upsells) { ?>
            <?php foreach($upsells as $upsell) { ?>
              <tr>
                <td class="text-left"><?php echo $upsell['name']; ?></td>
                <td class="text-left"><?php if($upsell['status'] == 0) echo 'Disabled'; else echo 'Enabled'; ?></td>
                <td class="text-right">
                  <a data-upsell-id="<?php echo $upsell['upsell_id'] ?>" data-toggle="modal" data-target="#myModal" title="Edit" class="btn btn-primary editUpsell"><i class="fa fa-pencil"></i></a>
                  <a data-upsell-id="<?php echo $upsell['upsell_id'] ?>" data-toggle="tooltip" title="Delete" class="btn btn-danger deleteUpsell"><i class="fa fa-trash-o"></i></a>
                </td>
              </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="text-center" colspan="3">No upsell offers</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <br />
</div>

<div class="modal" id="myModal">
  <div class="modal-dialog"  style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add upsell offer</h4>
      </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <h5><strong>Name:</strong></h5>
                <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Upsell name</span>
              </div>
              <div class="col-md-8">
                <input name="name" class="form-control" placeholder="Upsell name"/>
              </div>
            </div>
            <br />
            <div class="row">
              <div class="col-md-4">
                <h5><strong>Status:</strong></h5>
                <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable or disable the upsell offer</span>
              </div>
              <div class="col-md-8">
                <select name="status" class="form-control">
                  <option value="0" <?php echo (!empty($popup_data['method']) && $popup_data['method'] == '0') ? 'selected=selected' : '' ?>>Disabled</option>
                  <option value="1" <?php echo (!empty($popup_data['method']) && $popup_data['method'] == '1') ? 'selected=selected' : '' ?>>Enabled</option>
                </select>
              </div>
            </div>
            <br />
            <div class="row">
              <div class="col-md-4">
                <h5><strong>Popup dimensions:</strong></h5>
              </div>
              <div class="col-md-8" style="padding-left: 0; padding-right: 0;">
                <div class="col-md-5">
                  <span style="float:left;line-height: 34px;margin-right: 7px;">Width: </span>
                  <div class="input-group">
                    <input type="number" name="width" min="0" placholer="Width" class="form-control" />
                    <span class="input-group-addon">px</span>
                  </div>
                </div>
                <div class="col-md-5">
                  <span style="float:left;line-height: 34px;margin-right: 7px;">Height: </span>
                  <div class="input-group">
                    <input type="number" name="height" min="0" placholer="Height" class="form-control" />
                    <span class="input-group-addon">px</span>
                  </div>
                </div>
              </div>
            </div>
            <br />
            <div class="row">
              <div class="col-md-4">
                <h5><strong>Image dimensions:</strong></h5>
              </div>
              <div class="col-md-8" style="padding-left: 0; padding-right: 0;">
                <div class="col-md-5">
                    <span style="float:left;line-height: 34px;margin-right: 7px;">Width: </span>
                    <div class="input-group">
                      <input type="number" name="image_width" min="0" placholer="Width" class="form-control" />
                      <span class="input-group-addon">px</span>
                    </div>
                </div>
                <div class="col-md-5">
                    <span style="float:left;line-height: 34px;margin-right: 7px;">Height: </span>
                    <div class="input-group">
                      <input type="number" name="image_height" min="0" placholer="Height" class="form-control" />
                      <span class="input-group-addon">px</span>
                    </div>
                </div>
              </div>
            </div>
            <br />
            <br />
            <div class="row">
              <label class="col-sm-4" for="input-upsell-products"><span title="">Method</span></label>
              <div class="col-sm-8">
                <select name="method" class="form-control">
                  <option value="0">Specific products</option>
                  <option value="1">Specific categories</option>
                </select>
              </div>
            </div>
            <br />
            <div class="row upsell_products">
              <label class="col-sm-4" for="input-upsell-products"><span title="">Enabled for products</span></label>
              <div class="col-sm-8">
                <input type="text" name="upsell_products" value="" placeholder="" id="input-upsell-products" class="form-control" />
                <div id="product-upsells" class="well well-sm" style="height: 100px; overflow: auto;">
                  <?php foreach ($product_relateds as $product_related) { ?>
                    <div id="product-upsells" class="removable"><i class="fa fa-minus-circle"></i> 
                      <input type="hidden" name="product_upsells[]" value="" />
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="row upsell_categories">
              <label class="col-sm-4" for="input-upsell-categories"><span title="">Enabled for categories</span></label>
              <div class="col-sm-8">
                <div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($category['category_id'], $product_category)) { ?>
                    <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                    <?php echo $category['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);">Select all</a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);">Unselect all</a>
              </div>
            </div>
            <span>Ex: discount_in: 1 for (discount in percentage), 0 for (discount in amount)</span>
            <br />

            <ul class="nav nav-tabs popup_tabs">
              <?php $i=0; foreach ($languages as $language) { ?>
                <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
              <?php $i++; }?>
            </ul>
            <div class="tab-content">
              <?php $i=0; foreach ($languages as $language) { ?>
                    <div id="tab-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
                        <div class="row">
                            <div class="col-md-2">
                                <h5><strong>Popup Content:</strong></h5>
                                <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Here you can customize the content in the popup.<br /><br /><strong>Shortcodes:</strong><br />[product_upsell=id]<br />[category_upsell=id]<br /><i>Replace "id" with the id of the product or category.</i></span>
                            </div>
                            <div class="col-md-10">
                                <textarea id="message_<?php echo $language['language_id']; ?>" name="content">
                                    <?php if(!empty($popup_data['content'][$language['language_id']])) echo $popup_data['content'][$language['language_id']]; else echo ''; ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                <?php $i++; } ?>
            </div>
           
            <script type="text/javascript">
                    <?php foreach ($languages as $language) { ?>
                        $('#message_<?php echo $language['language_id']; ?>').summernote({height:200});
                    <?php } ?>
            </script>

           <!-- <br/>

             <div class="row">
              <div class="col-md-4">
                <h5><strong>Product Discount:</strong></h5>
                <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Upsell product discount</span>
              </div>
              <div class="col-md-8">
                <input name="pdiscount" class="form-control" placeholder="Product Discount"/> 
                <span>(In percent)%</span>
              </div>
            </div> --> 

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" id="saveUpsell" data-edit-mode="0" class="btn btn-primary">Save changes</button>
          </div>
        </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

function validate () {
  var validate = true;
  if(!($('#myModal input[name="name"]').val())) {
    if($('#myModal input[name="name"]').nextAll('.error').length == 0)
      $('#myModal input[name="name"]').after("<span class='error'>Error: Upsell name cannot be empty!</span>");
    validate = false;
  } else {
    $('#myModal input[name="name"]').nextAll($('.error')).remove();
  }

  if($('#myModal input[name="width"]').val() < 100) {
    if($('#myModal input[name="width"]').parent().nextAll('.error').length == 0)
      $('#myModal input[name="width"]').parent().after("<span class='error'>Error: Width has to be 100 px or greater!</span>");
    validate = false;
  } else {
    $('#myModal input[name="width"]').parent().nextAll($('.error')).remove();
  }

  if($('#myModal input[name="height"]').val() < 100) {
    if($('#myModal input[name="height"]').parent().nextAll('.error').length == 0)
      $('#myModal input[name="height"]').parent().after("<span class='error'>Error: Height has to be 100 px or greater!</span>");
    validate = false;
  } else {
    $('#myModal input[name="height"]').parent().nextAll($('.error')).remove();
  }

  return validate;
}

var upsell_id = 0;
  $('#addUpsell').on('click', function(e) {
    $('#myModal input[name="name"]').val("");
    $('#myModal select[name="status"]').val("0");
    $('#myModal select[name="method"]').val("0");
    $('#myModal input[name="width"]').val("0");
    $('#myModal input[name="height"]').val("0");
    $('#myModal input[name="image_width"]').val("0");
    $('#myModal input[name="image_height"]').val("0");
    //$('#myModal input[name="pdiscount"]').val("");  
    <?php foreach ($languages as $language) { ?>
      content[<?php echo $language['language_id']; ?>]= $('#message_<?php echo $language['language_id']; ?>').code("");
    <?php } ?>
    $('#product-upsells .removable').remove();

    $('#saveUpsell').attr('data-edit-mode','0');
  });

  $('#saveUpsell').on('click', function(e) {

    if(validate()) {
        var name = $('#myModal input[name="name"]').val();
        var status = $('#myModal select[name="status"]').val();
        var method = $('#myModal select[name="method"]').val();
        var width = $('#myModal input[name="width"]').val();
        var height = $('#myModal input[name="height"]').val();
        var image_width = $('#myModal input[name="image_width"]').val();
        var image_height = $('#myModal input[name="image_height"]').val();
        //var discount = $('#myModal input[name="pdiscount"]').val();  

        //var content = $('#myModal textarea[name="content"]').code();
        var content = new Array();
        <?php foreach ($languages as $language) { ?>
          content[<?php echo $language['language_id']; ?>]= $('#message_<?php echo $language['language_id']; ?>').code();
        <?php } ?>

        var tempID = [];
        $('input[name="product_upsells[]"]').each(function(i,e){
          tempID.push($(this).val());
        });
        var product_ids = tempID.join(',');

        var tempID = [];
        $('input[name="product_category[]"]:checked').each(function(i,e){
          tempID.push($(this).val());
        });
        var category_ids = tempID.join(',');

        if($('#saveUpsell').attr('data-edit-mode') == 0) {
          $.ajax({
              url: '<?php echo $addUpsellUrl; ?>',
              type: 'POST',
              data: {name:name, status:status, method:method, width:width, height:height, image_width:image_width, image_height:image_height, product_ids: product_ids, category_ids: category_ids, content:content},
              dataType: 'json',
              success: function(json) {
                if(json == 'success') {
                  location.reload();
                } else {
                  alert('Permission denied!');
                }
              }
          });
        } else {
          $.ajax({
              url: '<?php echo $editUpsellUrl; ?>',
              type: 'POST',
              data: {upsell_id:upsell_id ,name:name, width:width, height:height, image_width:image_width, image_height:image_height, status:status, method:method, product_ids: product_ids, category_ids: category_ids, content:content},
              dataType: 'json',
              success: function(json) {
                if(json == 'success') {
                  location.reload();
                } else {
                  alert('Permission denied!');
                }
              }
          });
        }
    }
    
  });

  function alreadyAddedProducts(product_ids) {
        $.ajax({
          url: '<?php echo $getProductDescriptionUrl; ?>',
          type: 'POST',
          data: {product_ids: product_ids},
          dataType: 'json',
          success: function(response) {
            for(entry in response) {
              $('#product-upsells').append('<div id="product-upsells' + product_ids[entry] + '" class="removable"><i class="fa fa-minus-circle"></i> '+response[entry][1].name+'<input type="hidden" name="product_upsells[]" value="' + product_ids[entry]  + '" /></div>'); 
            }
          }
        });
  }

  function alreadyAddedCategories(category_ids) {
        $.ajax({
          url: '<?php echo $getCategoryDescriptionUrl; ?>',
          type: 'POST',
          data: {category_ids: category_ids},
          dataType: 'json',
          success: function(response) {
            for(entry in response) {
              $('input[name="product_category[]"][value="'+response[entry].category_id+'"]').prop('checked',true);
            }
          }
        });
  }

 

  $('.editUpsell').on('click', function() {
    upsell_id = $(this).attr('data-upsell-id');
    
    $('#saveUpsell').attr('data-edit-mode','1');
    $.ajax({
          url: '<?php echo $getUpsellUrl; ?>',
          type: 'POST',
          data: {upsell_id:upsell_id},
          dataType: 'json',
          success: function(json) {

            $('#myModal input[name="name"]').val(json.name);
            $('#myModal  select[name="status"]').val(json.status)
            $('#myModal  input[name="width"]').val(json.width)
            $('#myModal  input[name="height"]').val(json.height)
            $('#myModal  select[name="method"]').val(json.method);
            $('#myModal  input[name="image_width"]').val(json.image_width)
            $('#myModal  input[name="image_height"]').val(json.image_height)
            // $('#myModal input[name="pdiscount"]').val(json.product_discount); 

            $('select[name="method"]').each(function(e){ 
              if($(this).val() == 0) {
                $('.upsell_products').show(200);
                $('.upsell_categories').hide(200);
              } else if($(this).val() == 1) {
                $('.upsell_products').hide(200);
                $('.upsell_categories').show(200);
              }
            });

            <?php foreach ($languages as $language) { ?>
                var language_id = '<?php echo $language['language_id']; ?>';
                $('#message_'+language_id).code(json.content[language_id]);
            <?php } ?>

            //$('#myModal textarea[name="content"]').code(json.content);
            $('#product-upsells .removable').remove();
            $('#product-category-upsells .removable').remove();
            var product_ids = json.product_ids.split(',').map(Number);
            alreadyAddedProducts(product_ids);

            var category_ids = json.category_ids.split(',').map(Number);
            alreadyAddedCategories(category_ids);
          }
    });
  });

  $('.deleteUpsell').on('click', function() {
    var upsell_id = $(this).attr('data-upsell-id');

    if (confirm("Do you really want to delete this upsell offer?")) {
        $.ajax({
          url: '<?php echo $deleteUpsellUrl; ?>',
          type: 'POST',
          data: {upsell_id:upsell_id},
          dataType: 'json',
          success: function(json) {
            if(json == 'success') {
              location.reload();
            } else {
              alert('Permission denied!');
            }
          }
        });
    }

  });

  $('#myModal').on('shown.bs.modal', function () {
    $('select[name="method"]').each(function(e){ 
      if($(this).val() == 0) {
        $('.upsell_products').show(200);
        $('.upsell_categories').hide(200);
      } else if($(this).val() == 1) {
        $('.upsell_products').hide(200);
        $('.upsell_categories').show(200);
      }
    });

    $('select[name="method"]').on('change', function(e){ 
      if($(this).val() == 0) {
        $('.upsell_products').show(200);
        $('.upsell_categories').hide(200);
      } else if($(this).val() == 1) {
        $('.upsell_products').hide(200);
        $('.upsell_categories').show(200);
      }
    });
  })

  $('select[name="method"]').each(function(e){ 
    if($(this).val() == 0) {
      $('.upsell_products').show(200);
      $('.upsell_categories').hide(200);
    } else if($(this).val() == 1) {
      $('.upsell_products').hide(200);
      $('.upsell_categories').show(200);
    }
  });

  $('select[name="method"]').on('change', function(e){ 
    if($(this).val() == 0) {
      $('.upsell_products').show(200);
      $('.upsell_categories').hide(200);
    } else if($(this).val() == 1) {
      $('.upsell_products').hide(200);
      $('.upsell_categories').show(200);
    }
  });

  $('input[name=\'upsell_products\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',     
      success: function(json) {

        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['product_id']
          }
        }));
      }
    });
  },
  focus: function(event, ui) {
      return false;
   },
  'select': function(event, ui) {
    $('input[name=\'upsell_products\']').val('');
    
    $('#product-upsells' + ui.item.value).remove();
    
    $('#product-upsells').append('<div id="product-upsells' + ui.item.value + '"><i class="fa fa-minus-circle"></i> ' + ui.item.label + '<input type="hidden" name="product_upsells[]" value="' + ui.item.value + '" /></div>');  
    return false;
  } 
});

$('#product-upsells').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});

</script>