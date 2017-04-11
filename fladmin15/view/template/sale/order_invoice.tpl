<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
  <link rel="stylesheet" type="text/css" href="http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/catalog/view/javascript/webrupee_font.min.css" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
<style>
.righttxtcls{ margin-bottom: 0px !important; border-bottom: none !important; padding-top: 10px;}
.divtopcls{ min-height: 50px; border-bottom: 1px solid #ccc;}
.storetopcls{ margin-top: 15px;}
</style>
</head>
<body>
<?php foreach ($orders as $order) { ?>
<div style="page-break-after: always;">
  <div class="divtopcls">
        <div style="float:left;"><a href="http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/"><img style="height:50px;" src="http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/image/data/lo2logo.png" title="FootLounge" alt="FootLounge"></a></div>
        <h1 style="float:right;" class="righttxtcls"><?php echo $text_invoice; ?></h1>
  </div>
  <table class="store storetopcls">
    <tr>
      <td><?php echo $order['store_name']; ?><br />
        <?php echo $order['store_address']; ?><br />
        <?php echo $text_telephone; ?> <?php echo $order['store_telephone']; ?><br />
        <?php if ($order['store_fax']) { ?>
        <?php echo $text_fax; ?> <?php echo $order['store_fax']; ?><br />
        <?php } ?>
        <?php echo $order['store_email']; ?><br />
        <?php echo $order['store_url']; ?></td>
      <td align="right" valign="top"><table>
          <tr>
            <td><b><?php echo $text_date_added; ?></b></td>
            <td><?php echo $order['date_added']; ?></td>
          </tr>
          <?php if ($order['invoice_no']) { ?>
          <tr>
            <td><b><?php echo $text_invoice_no; ?></b></td>
            <td><?php echo $order['invoice_no']; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td><b><?php echo $text_order_id; ?></b></td>
            <td><?php echo $order['order_id']; ?></td>
          </tr>
          <tr>
            <td><b><?php echo $text_payment_method; ?></b></td>
            <td><?php echo $order['payment_method']; ?></td>
          </tr>
          <?php if ($order['shipping_method']) { ?>
          <tr>
            <td><b><?php echo $text_shipping_method; ?></b></td>
            <td><?php echo $order['shipping_method']; ?></td>
          </tr>
          <?php } ?>
        </table></td>
    </tr>
  </table>
  <table class="address">
    <tr class="heading">
      <td width="50%"><b><?php echo $text_to; ?></b></td>
      <td width="50%"><b><?php echo $text_ship_to; ?></b></td>
    </tr>
    <tr>
      <td><?php echo $order['payment_address']; ?><br/>
        <!--<?php echo $order['email']; ?><br/>-->
        <?php echo $order['telephone']; ?>
        <?php if ($order['payment_company_id']) { ?>
        <br/>
        <br/>
        <?php echo $text_company_id; ?> <?php echo $order['payment_company_id']; ?>
        <?php } ?>
        <?php if ($order['payment_tax_id']) { ?>
        <br/>
        <?php echo $text_tax_id; ?> <?php echo $order['payment_tax_id']; ?>
        <?php } ?></td>
      <td><?php echo $order['shipping_address']; ?></td>
    </tr>
  </table>
  <table class="product">
    <tr class="heading">
      <td><b><?php echo $column_product; ?></b></td>
      <td><b><?php echo $column_model; ?></b></td>
      <td align="right"><b><?php echo $column_quantity; ?></b></td>
      <td align="right"><b><?php echo $column_price; ?></b></td>
      <td align="right"><b><?php echo $column_total; ?></b></td>
    </tr>
    <?php foreach ($order['product'] as $product) { ?>
    <tr>
      <td><?php echo $product['name']; ?>
        <?php foreach ($product['option'] as $option) { ?>
        <br />
        &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
        <?php } ?></td>
      <td><?php echo $product['model']; ?></td>
      <td align="right"><?php echo $product['quantity']; ?></td>
      <td align="right"><?php echo $product['price']; ?></td>
      <td align="right"><?php echo $product['total']; ?></td>
    </tr>
    <?php } ?>
    <?php foreach ($order['voucher'] as $voucher) { ?>
    <tr>
      <td align="left"><?php echo $voucher['description']; ?></td>
      <td align="left"></td>
      <td align="right">1</td>
      <td align="right"><?php echo $voucher['amount']; ?></td>
      <td align="right"><?php echo $voucher['amount']; ?></td>
    </tr>
    <?php } ?>
    <?php $coupon_tot=0; foreach ($order['total'] as $total) {

      if($total['code']=='coupon')
      {
        $coupon_tot=round($total['value']); 
      }

      if($total['code']=='shipping')
      {
         $total['title']='Delivery Charges';
         $total['text']='Free';
         $total['value']='Free';
      }

      if($total['code']=='total')
      {
        $total['value']=round($total['value']+$coupon_tot);
        $total['text']='<span class="WebRupee">Rs</span>'.$total['value']; 
      }

     ?>
    <tr>
      <td align="right" colspan="4"><b><?php echo $total['title']; ?>:</b></td>
       <?php if($total['code']=='shipping')  { ?>
      <td align="right">Free</td>
      <?php } else { ?>
      <td align="right"><span class="WebRupee">Rs</span><?php echo round($total['value']); ?></td>
      <?php } ?>
    </tr>
    <?php } ?>
  </table>
  <?php if ($order['comment']) { ?>
  <table class="comment">
    <tr class="heading">
      <td><b><?php echo $column_comment; ?></b></td>
    </tr>
    <tr>
      <td><?php echo $order['comment']; ?></td>
    </tr>
  </table>
  <?php } ?>
</div>
<?php } ?>

  <p><h2  style="text-align:center;">Thank you for shopping at Footlounge!</h2></p>
  <div style=" min-height:50px;">
    <div style="width:30%; float:left; text-align:right;"><a class="swap-image">
                <img src="http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/image/cache/data/AdidasQ2 Accessories/AJ9639 3s Crew HC 1PP Black Socks/Unisex_TRAINING_CREWSOCKS_AJ9639_1.jpg.zoom-220x180.jpeg" title="Adidas 3s Crew HC 1PP Black Socks" alt="Adidas 3s Crew HC 1PP Black Socks" class="front" style="height:50px; width:50px;">
                                
              </a></div>
    <div style="width:40%; float:left;"><p style=" margin-top:20px; font-weight:bold"><h3>Leave us a Review and Earn a FREE pair of socks from FootLounge.</h3></p></div>
    <div style="width:30%; float:left; text-align:left;"><a class="swap-image">
                <img src="http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/image/cache/data/AdidasQ2 Accessories/AJ9639 3s Crew HC 1PP Black Socks/Unisex_TRAINING_CREWSOCKS_AJ9639_1.jpg.zoom-220x180.jpeg" title="Adidas 3s Crew HC 1PP Black Socks" alt="Adidas 3s Crew HC 1PP Black Socks" class="front" style="height:50px; width:50px;">
                                
              </a></div>
    </div>          

    <div style=" margin-top:10px;">
    <div style="width:50%; float:left;"><a href="https://www.facebook.com/footlounge.online/" class="swap-image">
                <img src="http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/image/social-icons/FootLounge-FaceBook-Logo.png" title="Adidas 3s Crew HC 1PP Black Socks" alt="Adidas 3s Crew HC 1PP Black Socks" class="front" style="width: 50px; height: 50px;margin-top: 20px;">
                                
              </a></div>
    <div style="width:50%; float:left; text-align:right;"><a href="http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/"><img src="http://gofootlounge-env.ap-south-1.elasticbeanstalk.com/image/social-icons/FootLounge-WWW-Logo.png" title="FootLounge" alt="FootLounge" style="height:55px; margin-top:15px;"></a></div>
        
  </div>
</body>
</html>