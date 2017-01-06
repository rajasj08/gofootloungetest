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

              <td class="right"><?php if ($sort == 'dp.order_id') { ?>

                <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>

                <?php } ?></td>
                <td class="left"><?php if ($sort == 'dp.customer_name') { ?>

                <a href="<?php echo $sort_customer_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_name; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_customer_name; ?>"><?php echo $column_customer_name; ?></a>

                <?php } ?></td>
                
                    <td class="left"><?php if ($sort == 'dp.customer_email') { ?>

                <a href="<?php echo $sort_customer_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_to_email; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_customer_email; ?>"><?php echo $column_to_email; ?></a>

                <?php } ?></td>

              <td class="left"><?php if ($sort == 'dp.order_status_id') { ?>

                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_status; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_status; ?>"><?php echo $column_order_status; ?></a>

                <?php } ?></td>  
               
               <td class="left"><?php if ($sort == 'dp.storename') { ?>

                <a href="<?php echo $sort_storename; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_storename; ?></a>

                <?php } else { ?>

                <a href="<?php echo $sort_storename; ?>"><?php echo $column_storename; ?></a>

                <?php } ?></td>  
         
               <td class="right"><?php echo $column_action; ?></td>

            </tr>

          </thead>

          <tbody>

            <tr class="filter">

            

             <td align="right"><input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" size="4" style="text-align: right;" /></td>
			
             <td><input type="text" name="filter_customer_name" value="<?php echo $filter_customer_name; ?>" size="15"  /></td>
             
			 
			   <td><input type="text" name="filter_customer_email" value="<?php echo $filter_customer_email; ?>" /></td>
              
           
             
             <td><select name="filter_order_status_id">
                  <option value="*"></option>
                  <?php if ($filter_order_status_id == '0') { ?>
                  <option value="0" selected="selected"><?php echo $text_missing; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_missing; ?></option>
                  <?php } ?>
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
             
        
             
            
              <td><select  name="filter_storename">
              		<option value="*"></option>
                    <?php foreach($stores as $store){ ?>
                    	<?php if($store['name'] == $filter_storename ){?>
                    		<option value="<?php echo $store['name']; ?>" selected="selected"><?php echo $store['name']; ?></option>
                    	<?php }else { ?>
                        	<option value="<?php echo $store['name']; ?>"><?php echo $store['name']; ?></option>
                        <?php }?>
                    <?php }?>
                    </select>
              </td>
    

              

              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>

            </tr>

            <?php if ($orderspending) { ?>
            
            

            <?php foreach ($orderspending as $order) { ?>

            <tr>
                
              <td class="right"><a href="<?php echo $order['orderinfo']; ?>"><?php echo $order['order_id']; ?></a></td>

             <td class="left"><?php echo $order['customer_name']; ?></td> 

              
             <td class="left"><?php echo $order['customer_email']; ?></td>
             
             <td class="left"><?php echo $order['status']; ?></td>

              <td class="left"><?php echo $order['storename']; ?></td>
            
              <td class="right"><a href="<?php echo $order['orderinfo']; ?>" ><?php echo $text_view; ?></a></td>

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

	url = 'index.php?route=sale/purchasevoucher/pending&token=<?php echo $token; ?>';


	var filter_order_id = $('input[name=\'filter_order_id\']').attr('value');


	if (filter_order_id) {

		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);

	}


	var filter_customer_name = $('input[name=\'filter_customer_name\']').attr('value');
	

	if (filter_customer_name) {

		url += '&filter_customer_name=' + encodeURIComponent(filter_customer_name);

	}
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');

	

	if (filter_order_status_id!='*') {

		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);

	}

	
	var filter_customer_email = $('input[name=\'filter_customer_email\']').attr('value');

	

	if (filter_customer_email) {

		url += '&filter_customer_email=' + encodeURIComponent(filter_customer_email);

	}
	
	var filter_storename = $('select[name=\'filter_storename\']').attr('value');

	

	if (filter_storename!='*') {

		url += '&filter_storename=' + encodeURIComponent(filter_storename);

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

	if (e.keystatus == 13) {

		filter();

	}

});

//--></script>



<?php echo $footer; ?>