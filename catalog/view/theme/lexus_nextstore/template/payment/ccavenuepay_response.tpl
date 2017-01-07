<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">

<head>

<title><?php echo $title; ?></title>

<base href="<?php echo $base; ?>" />

</head>

<body>

<div class="new_cc_text">

  <h1><?php echo $heading_title; ?></h1>

  <p><?php echo $text_response; ?></p>

  <div class="new_cc_bor">

    <WPDISPLAY ITEM=banner>

  </div>

  <p><?php echo $payment_status_message; ?></p>

  <p><?php echo $text_payment_wait; ?></p>

</div>

<script type="text/javascript"><!--

setTimeout('location = \'<?php echo $continue; ?>\';', 5500);

//--></script>

</body>

</html>