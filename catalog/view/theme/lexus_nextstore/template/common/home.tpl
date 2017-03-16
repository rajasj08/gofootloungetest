<?php 
/******************************************************
 * @package Pav Opencart Theme Framework for Opencart 1.5.x
 * @version 1.1
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Augus 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/config.tpl" );

?>

<?php echo $header; ?>

<div class="container">
<div class="row"> 

<?php if( $SPAN_HOME[0] ): ?>
	<aside class="col-lg-<?php echo $SPAN_HOME[0];?> col-md-<?php echo $SPAN_HOME[0];?> col-sm-12 col-xs-12">
		<?php echo $column_left; ?>
	</aside>
<?php endif; ?>
		
<!-- <section class="col-lg-<?php echo $SPAN_HOME[1];?> col-md-<?php echo $SPAN_HOME[1];?> col-sm-12 col-xs-12">  -->
<section>	    
	<div id="content">
		<?php echo $offer_slideshow; ?>
		<?php echo $content_top; ?>
		<h1 class="new_page_disp1"><?php echo @$heading_title; ?></h1>
		<?php echo $content_bottom; ?>
	</div>
</section>
	
<?php if( $SPAN_HOME[2] ): ?>
	<aside class="col-lg-<?php echo $SPAN_HOME[2];?> col-md-<?php echo $SPAN_HOME[2];?> col-sm-12 col-xs-12">	
		<?php echo $column_right; ?>
	</aside>
<?php endif; ?>

</div>

</div> 

<script type="text/javascript"> 
var google_tag_params = { 

ecomm_pagetype: "home"

}; 

</script> 

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "name" : "footlounge",
  "url": "https://footlounge.in",
  "logo": "https://footlounge.in/image/data/lo2logo.png",
  "contactPoint": [{
    "@type": "ContactPoint",
    "telephone": "+91-91768-70701",
    "contactType": "customer service"
  }],
  "sameAs" : [
"http://www.facebook.com/footlounge.online",
"http://www.twitter.com/go_footlounge",
"http://www.instagram.com/go_footlounge",
"https://in.pinterest.com/footloungeindia/"
]
} 
</script>

<!-------------Newsletter implementation -------------->
<div class="modal fade" tabindex="-1" role="dialog" id="NewssubscribeModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="closesubsmodal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Subscribe To Our Newsletter</h4>
      </div>
      <div class="modal-body">
      <div style="margin-bottom: 20px;" ></div>

        <form class="form-horizontal">
      
        <div class="form-group">
        <label for="inputPassword3" class="col-sm-4 control-label nfont">Email ID</label>
        <div class="col-sm-6">
          <input type="text" class="form-control nfont" id="semailid" placeholder="Enter Your Email ID" style=" font-weight:bold;">
        </div>
      </div>

    </form>
      </div>
      <div class="modal-footer" style=" padding: 8px 20px 8px !important;">
      <span class="alert alert-success" style=" padding:5px !important; margin-bottom:0px; display:none;"  id="success_msgs">Please check email and confirm by clicking on link</span>
      <span class="alert alert-danger" style=" padding:5px !important; margin-bottom:0px;display:none;" id="failure_msgs">failed to subscribe</span>
        <img src="http://192.168.1.105/projects/Elakkiya/footloungeupdate_042016/image/ loading_spinner.gif" alt="loading..." id="image_spinner">
        <button type="button" class="btn btn-default" id="closebtn" onclick="closesubsmodal();">Close</button>
        <button type="button" class="btn btn-primary" id="sendbtn" onclick="subscribenews();">Subscribe</button>  
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

  $( document ).ready(function() {

setTimeout(function(){
 
 <?php if(!(isset( $this->session->data['newsletter_sess'])))
{ ?> 
  
  /*$("#NewssubscribeModal").modal('show'); 
  var cookieset=1;
  $.ajax({
        type: "POST",
        url: 'index.php?route=common/home/subscibemecookie/', 
        data: {
          cookieset:cookieset
        },
        success: function(resp){
          
        } 
    });*/
    // IS SET and has a true value
<?php } ?>    

 }, 15000);   //set timeout end

   
});
</script>  
  
<script>
//newsletter subscribe
function subscribenews()
{

  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;
  var Nemail=$("#semailid").val();
  var flag=1; 
  if(Nemail=='')
      {
        $("#semailid").css('border','1px solid #F00');flag=0;
      } else { $("#semailid").css('border','1px solid #ccc');}

     if(Nemail!='')
        {
         if (re.test(Nemail) == false)  { $("#semailid").css('border','1px solid #F00');
         flag=0; } else { $("#semailid").css('border','1px solid #ccc');}
        }
    if(flag==1)
    {
      $.ajax({
         type: "POST",        
         url: 'https://footlounge.in/subscribeme.php',  
         data: {
          Nemail:Nemail
        },
        success: function(resp){

          
          if(resp==1)
          {
             $("#success_msgs").show(); 
             setTimeout(function() { 
              $('#NewssubscribeModal').modal('hide');
              $("#success_msgs").hide();
            }, 4000); 
             $("#semailid").val(''); 
          } 
          else if(resp==0)
          {
            $("#failure_msgs").show();
           setTimeout(function() {
        $('#NewssubscribeModal').modal('show');
         $("#failure_msgs").hide();
    }, 4000);
          }
          else if(resp==2)
          {
            $("#failure_msgs").html('User already subscribed'); 
            $("#failure_msgs").show();
           setTimeout(function() {
        $('#NewssubscribeModal').modal('show');
         $("#failure_msgs").hide();
    }, 2000);
          }
          $("#semailid").val(''); 
        }
    });

       
    }    

}

function closesubsmodal()//close subscriber model
{
   $("#NewssubscribeModal").modal('hide'); 
   
} 


</script>


<?php echo $footer; ?>
