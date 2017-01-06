<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<title>Super Category Menu</title>
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" ></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/ui-lightness/jquery-ui.css" />
</head>
<body>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/product.png" alt="" /> <?php echo $entry_cache_del_list; ; ?></h1>
    <div class="buttons">
      <?php if (!$text_error_no_cache) { ?>
      <a id="delete_caches" class="button"><span><?php echo $button_delete; ?></span></a>
      <?php } ?>
      <a onclick="parent.$.fancybox.close();" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
</div>
<div class="attention"><?php echo $text_cache_del_remenber; ?></div>
<div id="notification"></div>
<div class="content">
  <form action="<?php echo $action_del_cache; ?>" method="post" enctype="multipart/form-data" id="form">
    <table class="list">
      <thead>
        <tr>
          <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
          <td class="right">cat/man</td>
          <td class="left">reference</td>
          <td class="left">cached</td>
          <td class="left">date</td>
        </tr>
      </thead>
      <tbody>
        <?php if ($cache_records) { ?>
        <?php foreach ($cache_records as $cache_record) { ?>
        <tr>
          <td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $cache_record['cache_id']; ?>" /></td>
          <td class="right"><?php echo $cache_record['cat']; ?> / <?php echo $cache_record['man']; ?></td>
          <td class="left"><?php echo $cache_record['name']; ?></td>
          <td class="left"><?php echo $cache_record['cached']; ?></td>
          <td class="left"><?php echo $cache_record['date']; ?></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
          <td class="center" colspan="5"><?php echo $text_error_no_cache; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </form>
</div>
</div>
<script>

  

  $('a#delete_caches').click(function() { 
	 if(!$('input[type=checkbox]:checked').length) {
        //stop the form from submitting
		alert("Please select at least one to upgrade.");
        return false
     }else{
	   	$('#form').submit();
	  }
});

  <?php if ($successdel) { ?>

 $("#notification").html('<div class="success" style="display: none;"><?php echo $successdel; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

   $(".success").fadeIn("slow");

   $('.success').delay(2500).fadeOut('slow');

   $("html, body").animate({

      scrollTop: 0

   }, "slow")

  <?php } ?>

  </script>
</body>
</html>