$(document).ready(function() {
           $("#Nmobileno").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });



    //$("p").mouseout(function(){
      //  $("p").css("background-color", "lightgray");
    //});

          
            
        } );
  
/*function notifyemail(productname,producthref,product_id)
{
 $.ajax({
    type: "POST",
    url: 'index.php?route=product/product/getproductoptioninfos/',   
    data: {
      product_id:product_id
    },
    success: function(jsonresp){


      $("#pro_name").val(productname);
      $("#pro_href").val(producthref);
      $("#npro_id").val(product_id);
      $("#myModal").modal('show');
      $("#respcontent").html(jsonresp); 
      $("#Nproductname").val(productname);
    }
  });
 
} */


function sendnotify()//send notify message
{

  var notify_mailid=$("#notify_mailid").val();
  //alert(notify_mailid);
  
  var Nemail=$("#Nemail").val();
  //var Nname=$("#Nname").val();
  var Nmobileno=$("#Nmobileno").val();
  //var NComments=$("#NComments").val();
  var Nproductname=$("#Nproductname").val();
  var proname=$("#pro_name").val();
  var prohref=$("#pro_href").val();
  var npro_id=$("#npro_id").val(); 
  var selectsize=$("#nselectsize").val(); 


  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;

  var flag=1;
    if(Nproductname=='')
      {
        $("#Nproductname").css('border','1px solid #F00');flag=0;
      } else { $("#Nproductname").css('border','1px solid #ccc');}

      if(Nemail=='')
      {
        $("#Nemail").css('border','1px solid #F00');flag=0;
      } else { $("#Nemail").css('border','1px solid #ccc');}

     if(Nemail!='')
        {
         if (re.test(Nemail) == false)  { $("#Nemail").css('border','1px solid #F00');
         flag=0; } else { $("#Nemail").css('border','1px solid #ccc');}
        }
       /*if(Nname=='')
      {
        $("#Nname").css('border','1px solid #F00');flag=0;
      } else { $("#Nname").css('border','1px solid #ccc');}

      if(Nmobileno=='')
      {
        $("#Nmobileno").css('border','1px solid #F00');flag=0;
      } else { $("#Nmobileno").css('border','1px solid #ccc');}
      */
        if(selectsize==0)
      {
        $("#optionvalueinfo").css('border','1px solid #F00');flag=0;
       
      }  
      else
      {
       $("#optionvalueinfo").css('border','1px solid #ccc');
      }
if(flag==1){
  $("#image_spinner").show();
   $("#sendbtn").prop('disabled', true);

   $.ajax({
    type: "POST",
    url: 'index.php?route=product/product/getproductinfos/',   
    data: {
      product_id:npro_id,
      Nemail:Nemail,
      //Nname:Nname,
      Nmobileno:Nmobileno,
    },
    success: function(jsonresp){
  
        
      var jsonres=jQuery.parseJSON(jsonresp); 
      var orgimage=jsonres.image;
      var nimage=orgimage.replace(/\s/g,'%20'); 
     // var nimage=nimage.replace(' ','%20');  
      var proimage="https://gofootlounge.in/image/"+nimage;
     //var proimage="";
      var prohightlight=jsonres.prod_highlight;
      var prodesc=jsonres.description;
       


    $.ajax({
        type: "POST",
        url: 'https://gofootlounge.in/sendmail.php', 
        data: {
          Nproductname:Nproductname,
          Nemail:Nemail,
          //Nname:Nname,
          Nmobileno:Nmobileno,
          //NComments:NComments,
          proname:proname,
          prohref:prohref,
          proimage:proimage,
          prohightlight:prohightlight,
          prodesc:prodesc,
          selectsize:selectsize

        },
        success: function(resp){

          $("#image_spinner").hide();
           $('#sendbtn').prop('disabled', false);
          if(resp==1)
          {
            $("#success_msgaa").html('Request Sent');
            $("#success_msgaa").show();
            //alert('Mail Send Successfully');

          setTimeout(function() { 
        $('#myModal').modal('hide');
         $("#success_msgaa").hide();
    }, 5000);
          
            $("#Nemail").val('');
          //$("#Nname").val('');
          $("#Nmobileno").val('');
          //$("#NComments").val('');
          $("#Nproductname").val('');
           $("#optionvalueinfo").val('');
           }
           else{
            $("#failure_msg").show();
           setTimeout(function() {
        $('#myModal').modal('show');
         $("#failure_msg").hide();
    }, 2000);
           

           } 
            
        }
     
      }); //inner ajax 
} 
}); //top ajax 
  }
}


function closemodal()//closemodal
{
  $("#Nproductname").css('border','1px solid #ededed');
  $("#Nemail").css('border','1px solid #ededed');
  $("#Nmobileno").css('border','1px solid #ededed');
  $("#Nemail").val('');
  $("#Nmobileno").val('');
  //$("#Nname").css('border','1px solid #ededed');
  //$("#Nmobileno").css('border','1px solid #ededed');
  $("#success_msg").hide();
   $("#failure_msg").hide();
  $("#myModal").modal('hide'); 
}   
  

  function sticky_relocate() { 
    var window_top = $(window).scrollTop();
    var div_top = $('.custom-menu').offset().top; 
    var div_bottom = $("#pav-mass-bottom").offset().top;   
    
   //window top view
    if (window_top > div_top && window_top < div_bottom) {


      if($( "#sticky" ).hasClass( "filterdisplay" ) && $('#navbar-collapseid').css('display') == 'block')
      { 
       
      }
    //  else if ($( "#sticky" ).hasClass( "filterdisplay" ) && $('#navbar-collapseid').css('display') == 'none') {
   // alert('Car 2 is hidden');
    //  } 
      else{ $( "#sticky" ).removeClass('filterdisplay');}  
    $("#sticky").css('display','block');
        $('#sticky').addClass('stick');
        //$('#sticky-anchor').height($('#sticky').outerHeight());
    }

    //window bottom view

    else if(window_top > div_bottom)
    {
     

       if($( "#sticky" ).hasClass( "filterdisplay" ) && $('#navbar-collapseid').css('display') == 'block')
      {
       $('#navbar-collapseid').hide();
      }
      else {$( "#sticky" ).addClass('filterdisplay');}

    } 

    //without scroll 
     else {
      
      $("#sticky").css('display','none');
       $("#navbar-collapseid").hide();
     // $("#navbar-collapseid").removeClass('in'); 
      // $("#navbar-collapseid").addClass('collapse'); 
        $('#sticky').removeClass('stick');
        //$('#sticky-anchor').height(0);
    }
    
    //console.log(div_bottom);
}

$(function() {
if($( window ).width()<768)
  {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
  } 
}); 

function dtclick(name,filter_count,idval) 
{  
  
  $("#totalids").val(filter_count);  
  for(var i=1;i<=filter_count;i++)
  {
    //except click other menu status
    if($( "#filter_p"+i ).hasClass( "closed" ))
      {
        $("#hidden_p"+i).val('closed');
      }  else { $("#hidden_p"+i).val('test');} 

    //clicked menu status

    if(i==idval)
    {
      if($( "#filter_p"+i ).hasClass( "closed" ))
        {
           $("#hidden_p"+i).val('test');
        }  else { $("#hidden_p"+i).val('closed');} 
     }

    
  }   

    
}



function togglefilter()//toggle filter info
{ 
  $("#sticky").addClass('filterdisplay');
  $("#navbar-collapseid").show(); 
}
function closefilter()//close filter info
{
  $("#sticky").removeClass('filterdisplay');
  $("#navbar-collapseid").hide(); 
}
function testme()
{
  var countval=$("#totalids").val();
 
  var hid_array=[];
   var finclass='';
 
  for(var i=1; i<=countval;i++)
  {
    var farray=$( "#filter_p"+i ).attr('class');
    var result = farray.split(' ');
    var lenval=(result.length)-1;
   
    if(result[lenval]=='' || result[lenval]=='test'){ finclass='test'; }else{finclass='closed';}  
    if($("#hidden_p"+i).val()!='')
    {hid_array.push($("#hidden_p"+i).val());}
    else   {    hid_array.push(finclass);   }
     
  }
 
   $.ajax({
              type: "POST",
              url: 'index.php?route=module/supercategorymenuadvanced/testrecord',
              data:
              {
                hid_array:hid_array
               
              },
              success: function(resp){
              
              } 

             }); 
 }   
 
 
 function showorderinfo()//show order details
 {
 
  $("#orderModal").modal('show');  
 }
 function continueorder()//continue order
 {
  $("#orderModal").modal('hide');  
    /*$.ajax({
              type: "POST",
              url: 'index.php?route=account/order/continue',
              data:
              {
                hid_array:hid_array
               
              },
              success: function(resp){
              
              } 

             }); */
 }
 function unsetorder()//continue order
 {
   
    $.ajax({
              type: "POST",
              url: 'index.php?route=account/order/unsetorder',
              success: function(resp){
               
                if(resp==1)
                {
                    $("#success_msg1").show();
                  //alert('Mail Send Successfully');

                      setTimeout(function() { 
                    $('#orderModal').modal('hide');
                     $("#success_msg1").hide();
                }, 5000);
                
                window.location.href='https://gofootlounge.in/new-arrivals'; 
                } 
                else
                {
                  $("#failure_msg1").show();
                     setTimeout(function() {
                  $('#orderModal').modal('show');
                   $("#failure_msg1").hide();
              }, 2000);
                }
              } 

             }); 
 }
 function closeordermodal()//close order modal
 {
   $("#orderModal").modal('hide');
 }
 $(document).ready(function() {
           $("#Nmobileno").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });



    //$("p").mouseout(function(){
      //  $("p").css("background-color", "lightgray");
    //});

          
            
        } );

//edit order
jQuery(function($) {
  function fixDiv() {
    var $cache = $('#editorderbanner');
    if ($(window).scrollTop() > 100)
      $cache.css({
        'position': 'fixed',
        'top': '10px',
        'float':'right'
      });
    else
      $cache.css({
        'position': 'relative',
        'top': 'auto'
      });
  }
  $(window).scroll(fixDiv);
  fixDiv();
});
  
function notifyemail(productname,producthref,product_id) 
{



  $.ajax({
    type: "POST",
    url: 'index.php?route=product/product/getproductoptioninfos/',   
    data: {
      product_id:product_id
    },
    success: function(jsonresp){
      
      $("#pro_name").val(productname);
      $("#pro_href").val(producthref);
      $("#npro_id").val(product_id);
      $("#myModal").modal('show');
      $("#respcontent").html(jsonresp); 
      $("#Nproductname").val(productname);
    }
  });
}



function closemodal()//closemodal
{
  $("#Nproductname").css('border','1px solid #ededed');
  $("#Nemail").css('border','1px solid #ededed');
  $("#Nmobileno").css('border','1px solid #ededed');
  $("#Nemail").val('');
  $("#Nmobileno").val('');
  //$("#Nname").css('border','1px solid #ededed');
  //$("#Nmobileno").css('border','1px solid #ededed');
  $("#success_msg").hide();
   $("#failure_msg").hide();
  $("#myModal").modal('hide'); 
}   
  

  function sticky_relocate() { 
    var window_top = $(window).scrollTop();
    var div_top = $('.custom-menu').offset().top; 
    var div_bottom = $("#pav-mass-bottom").offset().top;   
    
   //window top view
    if (window_top > div_top && window_top < div_bottom) {


      if($( "#sticky" ).hasClass( "filterdisplay" ) && $('#navbar-collapseid').css('display') == 'block')
      { 
       
      }
    //  else if ($( "#sticky" ).hasClass( "filterdisplay" ) && $('#navbar-collapseid').css('display') == 'none') {
   // alert('Car 2 is hidden');
    //  } 
      else{ $( "#sticky" ).removeClass('filterdisplay');}  
    $("#sticky").css('display','block');
        $('#sticky').addClass('stick');
        //$('#sticky-anchor').height($('#sticky').outerHeight());
    }

    //window bottom view

    else if(window_top > div_bottom)
    {
     

       if($( "#sticky" ).hasClass( "filterdisplay" ) && $('#navbar-collapseid').css('display') == 'block')
      {
       $('#navbar-collapseid').hide();
      }
      else {$( "#sticky" ).addClass('filterdisplay');}

    } 

    //without scroll 
     else {
      
      $("#sticky").css('display','none');
       $("#navbar-collapseid").hide();
     // $("#navbar-collapseid").removeClass('in'); 
      // $("#navbar-collapseid").addClass('collapse'); 
        $('#sticky').removeClass('stick');
        //$('#sticky-anchor').height(0);
    }
    
    //console.log(div_bottom);
}

$(function() {
if($( window ).width()<768)
  {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
  } 
}); 

function dtclick(name,filter_count,idval) 
{  
  
  $("#totalids").val(filter_count);  
  for(var i=1;i<=filter_count;i++)
  {
    //except click other menu status
    if($( "#filter_p"+i ).hasClass( "closed" ))
      {
        $("#hidden_p"+i).val('closed');
      }  else { $("#hidden_p"+i).val('test');} 

    //clicked menu status

    if(i==idval)
    {
      if($( "#filter_p"+i ).hasClass( "closed" ))
        {
           $("#hidden_p"+i).val('test');
        }  else { $("#hidden_p"+i).val('closed');} 
     }

    
  }   

    
}



function togglefilter()//toggle filter info
{ 
  $("#sticky").addClass('filterdisplay');
  $("#navbar-collapseid").show(); 
}
function closefilter()//close filter info
{
  $("#sticky").removeClass('filterdisplay');
  $("#navbar-collapseid").hide(); 
}
function testme()
{
  var countval=$("#totalids").val();
 
  var hid_array=[];
   var finclass='';
 
  for(var i=1; i<=countval;i++)
  {
    var farray=$( "#filter_p"+i ).attr('class');
    var result = farray.split(' ');
    var lenval=(result.length)-1;
   
    if(result[lenval]=='' || result[lenval]=='test'){ finclass='test'; }else{finclass='closed';}  
    if($("#hidden_p"+i).val()!='')
    {hid_array.push($("#hidden_p"+i).val());}
    else   {    hid_array.push(finclass);   }
     
  }
 
   $.ajax({
              type: "POST",
              url: 'index.php?route=module/supercategorymenuadvanced/testrecord',
              data:
              {
                hid_array:hid_array
               
              },
              success: function(resp){
              
              } 

             }); 
 }   

 function showorderinfo()//show order details
 {
 
  $("#orderModal").modal('show');  
 }
 function continueorder()//continue order
 {
  $("#orderModal").modal('hide');  
    /*$.ajax({
              type: "POST",
              url: 'index.php?route=account/order/continue',
              data:
              {
                hid_array:hid_array
               
              },
              success: function(resp){
              
              } 

             }); */
 }
 function unsetorder()//continue order
 {
   
    $.ajax({
              type: "POST",
              url: 'index.php?route=account/order/unsetorder',
              success: function(resp){
               
                if(resp==1)
                {
                    $("#success_msg1").show();
                  //alert('Mail Send Successfully');

                      setTimeout(function() { 
                    $('#orderModal').modal('hide');
                     $("#success_msg1").hide();
                }, 5000);
                
                window.location.href='https://gofootlounge.in/new-arrivals'; 
                } 
                else
                {
                  $("#failure_msg1").show();
                     setTimeout(function() {
                  $('#orderModal').modal('show');
                   $("#failure_msg1").hide();
              }, 2000);
                }
              } 

             }); 
 }
 function closeordermodal()//close order modal
 {
   $("#orderModal").modal('hide');
 }
 function get_radio_value(a,productoptionvalid,optionname) { 

        $("div.small-images img.chstyle").removeClass('selected');
        $(".small-images #test"+productoptionvalid).addClass('selected');
        $("#nselectsize").val(optionname);  
             /*  if(a == ''){
        document.getElementById('kdesc').style.display = "none";

        }
        else
        {
                                         document.getElementById('kdesc').style.display = "block";
                 document.getElementById("kdesc").innerHTML = "+ <span class='WebRupee'>Rs</span> <font color=yellowgreen style='font-size:20px'>"+ a + " </font>";
        }*/
}   

function get_radio_value1() { 

        var optionvalueinfo=$("#optionvalueinfo").val(); 
        var optionname = $('#optionvalueinfo').find(':selected').attr('optionvaluename');
      
        $("#nselectsize").val(optionname);  
             /*  if(a == ''){ 
        document.getElementById('kdesc').style.display = "none";

        }
        else
        {
                                         document.getElementById('kdesc').style.display = "block";
                 document.getElementById("kdesc").innerHTML = "+ <span class='WebRupee'>Rs</span> <font color=yellowgreen style='font-size:20px'>"+ a + " </font>";
        }*/
}   

