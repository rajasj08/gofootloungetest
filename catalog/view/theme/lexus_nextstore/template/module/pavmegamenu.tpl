	<div class="pav-megamenu">
	<div class="navbar navbar-default">
		<div id="mainmenutop" class="megamenu" role="navigation">
			<div class="navbar-header">
				<a href="javascript:;" data-target=".navbar-collapse" data-toggle="" class="navbar-toggle" >       
			        <span class="menucol">MENU</span><span class="fa fa-bars"></span>		        
			     </a> 
				<div class="collapse navbar-collapse navbar-ex1-collapse">
				<?php echo $treemenu; ?>
				</div>        
			</div> 
			<div  id="footsizedone" class="header-foot-size pull-right">
				<a href="javascript:void(0);" title="Know Your Foot Size" data-toggle="modal" data-target="#knowYourSize">
					<span class="fs-img">&nbsp;</span>
					<span class="text">Size</span>
				</a>
			</div>
			<div id="footsizeblock" class="header-foot-size pull-right">
				<a href="https://gofootlounge.in/know-your-size">
					<span class="fs-img">&nbsp;</span>
					<span class="text">Size</span>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="CODModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="closecodmodal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cash On Delivery Status</h4>
      </div>
      <div class="modal-body">
      <div style="margin-bottom: 20px;" ><p> Please check cash on delivery status for your pincode</p></div>

       	<form class="form-horizontal">
      
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-4 control-label">Zip Code<span class="mand_field">*</span></label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="zipcode" placeholder="Required" value="<?php if(isset($this->session->data['user_zipcode'])){ echo $this->session->data['user_zipcode']; }?>">
		    </div>
		  </div>
		 <!-- <div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Name<span class="mand_field">*</span></label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="Nname" placeholder="Name">
		    </div>
		  </div> -->

		 

		 <!-- <div class="form-group">
		    <label for="inputPassword3" class="col-sm-4 control-label">Comments</label>
		    <div class="col-sm-6">
		      <textarea class="form-control" id="NComments" placeholder="Comments"></textarea>
		    </div>
		  </div> -->

		</form>
      </div>
      <div class="modal-footer" style=" padding: 8px 20px 8px !important;">
       <span class="newspanpopup"><span class="alert alert-success" style=" padding:5px !important; margin-bottom:0px; display:none;"  id="success_msg">COD Available for Pincode <span id="dzipcode"></span></span>
      <span class="alert alert-danger" style=" padding:5px !important; margin-bottom:0px;display:none;" id="failure_msg">Prepaid Delivery Only for Pincode <span id="dzipcode1"></span></span><span class="alert alert-danger" style=" padding:5px !important; margin-bottom:0px;display:none;" id="failure_msg2">Invalid pincode <span id="dzipcode2"></span></span>  
      </span>
      	<img src="https://gofootlounge.in/image/loading_spinner.gif" alt="loading..." id="image_spinner">
        <button type="button" class="btn btn-default" id="closebtn" onclick="closecodmodal();">Close</button> 
        <button type="button" class="btn btn-primary" id="sendbtn" onclick="codstatus();">Submit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$( document ).ready(function() {
    if($( window ).width()<767) 
	    { 

	    	$(".secondlink .cumenu:nth-of-type(1) ul li:first-child").css('display','none');  
	    	$(".thirdlink .cumenu:nth-of-type(1) ul li:first-child").css('display','none'); 
	    	$(".four .cumenu1:nth-of-type(1) ul li:first-child").css('display','none'); 
	    	$(".travelneeds .cumenu:nth-of-type(1) ul li:first-child").css('display','none'); 
	    	
	    	$(".secondlink a").removeAttr('data-toggle');  
	    	$(".thirdlink a").removeAttr('data-toggle');
	    	$(".four a").removeAttr('data-toggle');
	    	$(".main-menu-brand a").removeAttr('data-toggle');  
	    	$(".travelneeds a").removeAttr('data-toggle'); 
	    	
	    	$( ".secondlink .caret" ).click(function() {
	    		if( $(".secondlink div.dropdown-menu").css('display') == 'block') {
	    		$(".secondlink div.dropdown-menu").hide(); 
	    		}else{$(".secondlink div.dropdown-menu").show();  }
			 
			}); 
			$( ".thirdlink .caret" ).click(function() {
	    		if( $(".thirdlink div.dropdown-menu").css('display') == 'block') {
	    		$(".thirdlink div.dropdown-menu").hide(); 
	    		}else{$(".thirdlink div.dropdown-menu").show();  }
			 
			});  
			$( ".four .caret" ).click(function() {
	    		if( $(".four div.dropdown-menu").css('display') == 'block') {
	    		$(".four div.dropdown-menu").hide(); 
	    		}else{$(".four div.dropdown-menu").show();  }
			 
			});   
			$( ".main-menu-brand .caret" ).click(function() {
	    		if( $(".main-menu-brand div.dropdown-menu").css('display') == 'block') {
	    		$(".main-menu-brand div.dropdown-menu").hide(); 
	    		}else{$(".main-menu-brand div.dropdown-menu").show();  }
			 
			});   
			$( ".travelneeds .caret" ).click(function() {
	    		if( $(".travelneeds div.dropdown-menu").css('display') == 'block') {
	    		$(".travelneeds div.dropdown-menu").hide(); 
	    		}else{$(".travelneeds div.dropdown-menu").show();  } 
			 
			}); 
	    } 
	}); 

	function showlink(link)//show link
	{
		window.location.href='https://gofootlounge.in/'+link;  
		
	}
</script>  