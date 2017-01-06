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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/order.png" alt="" /> All Customers List<?php //echo $heading_title; ?></h1>
     <!-- <div class="buttons"><a onclick="$('#form').attr('action', '<?php echo $invoice; ?>'); $('#form').attr('target', '_blank'); $('#form').submit();" class="button"><?php echo $button_invoice; ?></a><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('#form').attr('action', '<?php echo $delete; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><?php echo $button_delete; ?></a></div> -->
    </div>
    <div class="content">

      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
             <!-- <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>-->
             
              <td class="center">
                <a class="">S.No</a>
                </td>
               <!-- <td class="center">
               User Name
               </td> -->
               <td class="center">
                <a class="">User Type</a>
               </td>
              

              <td class="center">
                <a  class="">Mail Id</a>
               </td>
             
               
              
              <td class="center">
                <a >Mobile No.</a>
               </td>
 
            <!--  <td class="center">
                <a class="<?php echo strtolower($order); ?>">Order Date</a>
                </td> -->
            
              <td class="center"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
               <tr class="filter">
               
             <!-- <td align="center"><input type="text" name="filter_userid" value="<?php echo $filter_userid; ?>" size="4" style="text-align: right;" /></td> -->
            <td></td>
           

             
              
<td align="center"><select name="filter_usertype">
<option value="" <?php if($filter_usertype=='') { echo "selected"; }?>>Select</option>
<option value="Guest" <?php if($filter_usertype=='Guest') { echo "selected"; }?>>Guest</option>
<option value="Registered" <?php if($filter_usertype=='Registered') { echo "selected"; }?>>Registered</option>
<option value="Out Of Stock" <?php if($filter_usertype=='Out Of Stock') { echo "selected"; }?>>Out Of Stock</option>

</select></td> 
   

             <td align="center"><input type="text" name="filter_cust_mailid" value="<?php echo $filter_cust_mailid; ?>" /></td> <td></td>
             
             
           
              
              <td align="center"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($abusers) {  $z=1;$muc=count($abusers);
if($mypage=='' || $mypage==1 ){$start=0;if($muc<20){$end=$muc;} else {$end=20;}} else{$newp=($mypage-1)*20;$endp=(($mypage-1)*20)+20;$start=$newp; if(count($abusers)>$endp){$end=$endp;} else {$end=$endp-($endp-$muc);} }
?>
            <?php  $z=(1*$start)+1;for($i=$start; $i<$end; $i++) {
//foreach ($abusers as $abuser) { 
 //if($mypage=='') {  
?>
            <tr>
             <td class="left"><?php echo $z; ?></td>
             <td class="center"><?php echo $abusers[$i]['usertype']; ?></td>
              <td class="left"><?php echo $abusers[$i]['cust_mailid']; ?></td>
              
              <td class="center"><?php echo $abusers[$i]['mobileno']; ?></td>

             <!-- <td class="left"><?php echo $abusers[$i]['products']; ?></td>

              <td class="center"><?php if($abusers['order_date']) { echo date("d/m/Y", strtotime($abusers['order_date'])); } ?></td> -->
              <td class="center">
               <a class="button">View / Send</a> 
              
                </td>
            </tr>
            <?php $z++; } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>


<div id="orderModal" title="Send Mail" style="display:none;">
<div style=" margin-top:12px;">
<input type="hidden" id="abuserid" value="">
 <div style="width:100px; float:left;">Email ID: </div>
<input type="text" name="c_emailid" id="c_emailid" style=" width:200px;" >
 <br/>
<div style="margin-top:10px; ">
<div style="width:100px; float:left;">Coupon Code:  </div>
<select name="couponcodes" id="couponcodes" style=" width:210px;" >
<option value="">-- Select --</option>
<?php if($couponcodes){
foreach($couponcodes as $cdata){
echo '<option value="'.$cdata['coupon_id'].'">'.$cdata['coupon_name'].'</option>';
}
}?>
</select>
</div>
 <p style="text-align:center; "><a class="button" style="
    border-radius: 0px;
    width: 45px;
    color: rgb(255, 255, 255);" onclick="send_orderdetails();" id="mailsendbtnnew">Send</a><br/>
    <span id="s_sendmail" style="color: rgb(54, 125, 12); font-weight: bold; display:none;"> Mail Send successfully</span>  
    </p>
 </div>
</div>
<script type="text/javascript"><!--
function filter() {


	url = 'index.php?route=tool/export/getallcustomer&token=<?php echo $token; ?>';
	
	var filter_usertype = $('select[name=\'filter_usertype\'] option:selected').val();
	
       $('select[name="' + name + '"] option:selected').val()
	if (filter_usertype) {
		url += '&filter_usertype=' + encodeURIComponent(filter_usertype);
	}
        
	
	/*var filter_userid = $('input[name=\'filter_userid\']').attr('value');
	
	if (filter_userid) {
		url += '&filter_userid=' + encodeURIComponent(filter_userid);
	} */
	
	var filter_cust_mailid = $('input[name=\'filter_cust_mailid\']').attr('value');
	
	if (filter_cust_mailid) {
		url += '&filter_cust_mailid=' + encodeURIComponent(filter_cust_mailid);
	}	

	/*var filter_order_date = $('input[name=\'filter_order_date\']').attr('value');

	if (filter_order_date) {
		url += '&filter_order_date=' + encodeURIComponent(filter_order_date);
	}*/ 	
	
		
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
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		
		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				
				currentCategory = item.category;
			}
			
			self._renderItem(ul, item);
		});
	}
});

$('input[name=\'filter_customer\']').catcomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						category: item.customer_group,
						label: item.name,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_customer\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

function sendupdateorder(abuserid,mailid) //send update order
{
$("#abuserid").val(abuserid);
  $("#c_emailid").val(mailid.trim());
        $("#orderModal").dialog({
      modal: true,
      draggable: false,
      width: 400
     
    /*  buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }*/
    });
  
  /* */ 
}

function send_orderdetails()//send orderdetails
{
  
  var abuserid=$("#abuserid").val();
  var mailid=$("#c_emailid").val();
  var couponcode=$("#couponcodes").val();
  var flag=1;

  if(mailid=='')
    {$("#c_emailid").css('border','1px solid #F00'); flag=0;}
  else{$("#c_emailid").css('border','1px solid #ccc'); }
   var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;

if(mailid!='')
        {
         if (re.test(mailid) == false)  { $("#c_emailid").css('border','1px solid #F00');
         flag=0; } else { $("#c_emailid").css('border','1px solid #ccc');}
        }
if(couponcode=='')
{
$("#couponcodes").css('border','1px solid #F00');
flag=0;} else {$("#couponcodes").css('border','1px solid #ccc');}

  if(flag==1) 
  {

    $("#mailsendbtnnew").prop('disabled', true);


$.ajax({
    type: "POST",
    url: 'http://testourwork.com/footlounge/discountmail.php', 
    data: {
     abuserid:abuserid,
     
    },
     
      success: function(disresp) {  
alert(disresp);  

    $.ajax({
    type: "POST",
    url: 'index.php?route=tool/export/updateabuserorder&token=<?php echo $token; ?>', 
    data: {
     abuserid:abuserid,
      mailid:mailid,
     couponcode:couponcode,
     //message1:''+disresp
    },
     
      success: function(resp) {  
  $("#mailsendbtn").prop('disabled', false); 
     
      if(resp==1)
      {
        $("#s_sendmail").show();

        setTimeout(function() {
                 $("#s_sendmail").hide();
                 $("#orderModal").dialog("close");
                   
              }, 3000);  

      }

     else{ $("#s_sendmail").html('Sending Failed'); 
            $("#s_sendmail").show();
                setTimeout(function() {
                   $("#orderModal").dialog("close");
                   $("#s_sendmail").hide();
              }, 3000);
 }
     
       }
    });  
}
});

  }
}
//--></script> 
<?php echo $footer; ?>