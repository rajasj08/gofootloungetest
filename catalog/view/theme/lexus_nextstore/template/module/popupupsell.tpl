<script type="text/javascript">
	var timeout = 5000;
	if (!$.fancybox) {
		$('head').append('<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/fancybox/jquery.fancybox.css" />');
		$('head').append('<script type="text/javascript" src="catalog/view/javascript/jquery/fancybox/jquery.fancybox.js"><'+'/script>');
	}
	
	var product_ids = [];
	var product_id = ["Empty"];

	var showPopupUpsell = function (content,width,height) { 

		setTimeout(function() {
			$.fancybox.open({
			content: content,
			width: width,
			height: height,
			autoSize: false,
			openEffect : 'fade',
			openSpeed  : 150,
			closeBtn  : true,
			wrapCSS : 'popupupsell',
			afterShow : function() {

				var test=content;
				var product_newpopup_count = (test.match(/product_newpopup/g) || []).length;
				
				if(product_newpopup_count >3)
 									{
 										for(var j=4;j<=product_newpopup_count;j++)
 										{
 											$(".pro"+j).css('display','none');
 										}
 										 
 									}  


 									$("body").css('opacity','1.0'); 
								$("#trest").remove();


			/*	$('.popupupsell [onclick^=]').on('click', function() {
					$.fancybox.close();
				});*/
			}
			});											
		}, timeout);
	};

	$(document).ready(function() {
		$('#button-cart').on('click', function() {
			
			<?php if(isset($product_id)) { ?>
				product_id = '<?php echo $product_id; ?>';
			<?php } else { ?>
				product_id = 0;
			<?php } ?>

		}); 

		$(document).ajaxSuccess(function(event, xhr, settings) {

			if(xhr.responseText) {
				
				if(xhr.responseText.indexOf('success')==2 && product_ids.indexOf(product_id)==-1) {
					product_ids.push(product_id);
					if(product_id) {
						$.ajax({
							url: 'index.php?route=module/popupupsell/showupselloffer',
							type: 'post',
							data: 'product_id=' + product_id,
							dataType: 'json',
							success: function(json) {
								
								//if(json) 
								//	showPopupUpsell(json.content, json.width, json.height);
							}
						});
					}
				}
			}

		});

		$('[onclick^="addToCart"]').on('click',function(i,e){

				var params = $(this).attr('onclick').match(/\d+/);
				product_id = params[0];
		}); 
		
	});


//popup add to cart button
/*$('#popupbutton-cart').bind('click', function() {
	 
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');


					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});*/

function checkupsellproduct(productid,upsellid,upsellproductprice,upsellproductspecial,mainproductid)//check upsell product
{ 
	//productid,upsellid,upsellproduct_price,upsellproduct_special
	var flag=1;
   var optionvalueinfo = $("#optionvalueinfo"+productid).val();
  if(optionvalueinfo=='')
  {
  	flag=0;
  	$("#optionvalueinfo"+productid).css('border','1px solid #F00');
  }
  else
  {
  	$("#optionvalueinfo"+productid).css('border','1px solid #ccc');
  }
   
   if(flag==1)
   {
   	var optionid = $('#optionvalueinfo'+productid).find(':selected').attr('optionid');
   var optionvalueid = $('#optionvalueinfo'+productid).find(':selected').attr('optionvalueid');
  $.ajax({
        type: "POST",
        url: 'index.php?route=module/popupupsell/setpopupupsellprice', 
        data: {  
          product_id:productid,
          upsellid:upsellid,
          //Nname:Nname,
          upsell_productprice:upsellproductprice,
          //NComments:NComments,
          upsell_productspecial:upsellproductspecial,
          upsell_mainproductid:mainproductid
        },  
        success: function(resp){
        	
          
          if(resp)
          {
          	addToCartpopup(productid,1,optionid,optionvalueid);
         //window.location.href="http://192.168.1.105/projects/Elakkiya/footloungeupdate_042016/index.php?route=product/product&product_id="+productid;     
      		} 
        }
     });
    }   
}

function checkupsellproduct1(productid,upsellid,upsellproductprice,upsellproductspecial,mainproductid)//check upsell product
{ 
	//productid,upsellid,upsellproduct_price,upsellproduct_special
	var flag=1;
 /*  var optionvalueinfo = $("#optionvalueinfo"+productid).val();
  if(optionvalueinfo=='')
  {
  	flag=0;
  	$("#optionvalueinfo"+productid).css('border','1px solid #F00');
  }
  else
  {
  	$("#optionvalueinfo"+productid).css('border','1px solid #ccc');
  }*/ 
   
   if(flag==1)
   {
   	var optionid = $('#optionvalueinfo'+productid).find(':selected').attr('optionid');
   var optionvalueid = $('#optionvalueinfo'+productid).find(':selected').attr('optionvalueid');
  $.ajax({
        type: "POST",
        url: 'index.php?route=module/popupupsell/setpopupupsellprice', 
        data: {  
          product_id:productid,
          upsellid:upsellid,
          //Nname:Nname,
          upsell_productprice:upsellproductprice,
          //NComments:NComments,
          upsell_productspecial:upsellproductspecial,
          upsell_mainproductid:mainproductid
        },  
        success: function(resp){
        
          if(resp)
          {
          	//addToCartpopup(productid,1,optionid,optionvalueid);
         window.location.href="index.php?route=product/product&product_id="+productid;     
      		} 
        }
     });
    }   
}
 
 /*function closemodaldialog()
 {
 	location.reload(); 
 }*/


 function addToCartpopup(product_id, quantity,option,optionvalueid) {

	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity + '&'+option+'=' + optionvalueid,
		dataType: 'json', 
		success: function(json) {
		
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$('#notificationpopup').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow');
        
        setTimeout(function(){ //
        	window.location.href = 'index.php?route=checkout/cart';  }, 1000);
         // Added by Best-Byte //   
			}	
		}
	});
}

/* function shownextdiscount(nextstart,total)//show next set
{
	for(var i=(nextstart-1);i>=1;i--)
	{
		$(".pro"+i).hide();
	}  	
	for(var j=nextstart;j<=6;j++)
	{
		$(".pro"+j).show(); 
	}
} */ 
/*
function shownextdiscount1(endvalue,totalvalue)//show value
{
	var totval=parseInt(endvalue)+ parseInt(3);
	if(endvalue ==1)
	{ 
		
		for(var i=1;i<=totalvalue;i++)
		{
			if(i<=3)
			{
				$(".pro"+i).show();
			}
			else{
				 
				//if(i<=totval)
				//{
					$(".pro"+i).hide();
				//}	 
			} 
		} 
	}
	else
	{
	  for(var i=totalvalue;i>=1;i--)
		{
			
			if(i<=endvalue && i!=totalvalue)
			{
				$(".pro"+i).hide();
			}
			else{ 
				
				if(i<=totval)
				{
					
					$(".pro"+i).show();
				}	
			} 
                       
                        
		} 
	}	 	
} */

function shownextdiscount1(endvalue,totalvalue)//show value
{
	var totval=parseInt(endvalue)+ parseInt(3);
	if(endvalue ==1)
	{ 
		
		for(var i=1;i<=totalvalue;i++)
		{
			if(i<=3)
			{
				$(".pro"+i).show();
			}
			else{
				 
				//if(i<=totval)
				//{
					$(".pro"+i).hide();
				//}	 
			} 
		} 
	}
	else
	{
	  for(var i=totalvalue;i>=1;i--)
		{
			
                      
			if(i<=parseInt(endvalue))
			{
                                
				$(".pro"+i).hide();
			}
			else{
				
				if(i<=totval)
				{
					
					$(".pro"+i).show();
				}
                                 else
                                {
                                        
                                        $(".pro"+i).hide();   
                                }		
			} 
		} 
	}	 	
}

function pshownextdiscount1(endvalue,totalvalue)//show value
{
	var totval=parseInt(endvalue) - parseInt(3);
	if(totalvalue ==1)
	{ 
		
		for(var i=endvalue;i>=totalvalue;i++)
		{
			if(i>=3)
			{
				$(".pro"+i).show();
			}
			else{
				 
				//if(i<=totval)
				//{
					$(".pro"+i).hide();
				//}	 
			} 
		} 
	}
	else
	{
	  for(var i=totalvalue;i>=1;i--)
		{
			alert('sdfds'); 
			if(i<=endvalue)
			{
				$(".pro"+i).hide();
			}
			else{ 
				 
				if(i<=totval)
				{
					
					$(".pro"+i).show();
				}
                                else
                                {
                                        alert('sfsdfd'); 
                                        $(".pro"+i).hide();   
                                }	
			} 
		} 
	}	 	
}

</script> 