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

  <div id="success"></div>

  <div class="box">

    <div class="heading">

      <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">

      <form action="" method="post" enctype="multipart/form-data" id="form">

        <table class="list">

          <thead>

            <tr>

                
              <td class="right"><?php if ($sort == 'od.order_id') { ?>

                <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>

                <?php } ?></td>
           
                
                <td class="left">

                <?php echo $column_description; ?>

                </td>

              <td class="left"><?php if ($sort == 'od.code') { ?>

                <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>

                <?php } ?></td>  
               
                 <td class="left"><?php if ($sort == 'od.to_email') { ?>

                <a href="<?php echo $sort_to_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_to_email; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_to_email; ?>"><?php echo $column_to_email; ?></a>

                <?php } ?></td>            

            	 
                
             
              
              <td class="left"><?php echo $column_amount; ?></td>
                           
              <td class="right"><?php echo $column_action; ?></td>

            </tr>

          </thead>

          <tbody>

            <tr class="filter">

            

             <td align="right"><input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" size="4" style="text-align: right;" /></td>
			
            
             
             <td ></td>
             
             <td><input type="text" name="filter_code" value="<?php echo $filter_code; ?>" /></td>
             
       
             
              <td><input type="text" name="filter_to_email" value="<?php echo $filter_to_email; ?>" /></td>
              
             
              
			 

             <td ></td>

              

              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>

            </tr>

            <?php if ($orders) { ?>
            
            

            <?php foreach ($orders as $order) { ?>

            <tr>
                
              <td class="right"> <a href="<?php echo $order['orderinfo']; ?>"><?php echo $order['order_id']; ?></a></td>

           
              <td class="left"><?php echo $order['description']; ?></td>
              
             <td class="left"><?php echo $order['code']; ?></td>

           
              
              <td class="left"><?php echo $order['to_email']; ?></td>
			
            
              
               <td class="left"><?php echo $order['amount']; ?></td>
             
              <td class="right">
               
             
          
              <a href="<?php echo $order['info']; ?>"><?php echo $text_view; ?></a>
              </td>

            </tr>

            <?php } ?>

            <?php } else { ?>

            <tr>

              <td class="center" colspan="10"><?php echo $text_no_results; ?></td>

            </tr>

            <?php } ?>

          </tbody>

        </table>

      </form>

      <div class="pagination"><?php echo $pagination; ?></div>

    </div>

  </div>

</div>

<script type="text/javascript"><!--

function filter() {

	url = 'index.php?route=sale/purchasevoucher&token=<?php echo $token; ?>';


	var filter_order_id = $('input[name=\'filter_order_id\']').attr('value');


	if (filter_order_id) {

		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);

	}


	var filter_product_name = $('input[name=\'filter_product_name\']').attr('value');
	

	if (filter_product_name) {

		url += '&filter_product_name=' + encodeURIComponent(filter_product_name);

	}
	var filter_code = $('input[name=\'filter_code\']').attr('value');

	

	if (filter_code) {

		url += '&filter_code=' + encodeURIComponent(filter_code);

	}

	
	var filter_to_email = $('input[name=\'filter_to_email\']').attr('value');

	

	if (filter_to_email) {

		url += '&filter_to_email=' + encodeURIComponent(filter_to_email);

	}

	
	
	location = url;

}

//--></script>

<script type="text/javascript"><!--

$(document).ready(function() {

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});

});

//--></script>

<script type="text/javascript"><!--

$('#form input').keydown(function(e) {

	if (e.keyCode == 13) {

		filter();

	}

});

//--></script>

<script type="text/javascript"><!--

$('input[name=\'filter_product_name\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_product_name\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});


//--></script>

<?php echo $footer; ?>