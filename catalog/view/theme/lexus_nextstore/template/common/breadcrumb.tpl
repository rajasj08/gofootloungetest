<div id="breadcrumb">
<?php if(isset($this->session->data['customer_id']) && isset($this->session->data['order_id']))
{
	?>
	
<div>
<a style="display: block;" id="sticky1" href="javascript:;" class="navbar-toggle test1 stick" onclick="showorderinfo();"> 	    
			       <!-- data-target="#navbar-collapseid" data-toggle="collapse" 
			       float:right !important; background-color:rgb(245, 134, 52) !important; bottom:18px !important; width:100% !important; padding:5px !imporatant; margin-top:10px !important; text-align:center; left:8px !important; margin-bottom:0px !important; height:35px;<span class="menucol"></span>--><span   class="currentorder" title="Current Order"><span class="filter-mark">You are editing the Order ID - <?php echo $this->session->data['order_id']; ?></span></span>	         
			     </a>
			     </div>
			     <?php }?>
<ol class="breadcrumb container">
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
	<li><a href="<?php echo $breadcrumb['href']; ?>"><span><?php echo $breadcrumb['text']; ?></span></a></li>
	<?php } ?>
</ol>
	
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="orderModal">
  <div class="modal-dialog"> 
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="closeordermodal();" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">View Order</h4>
      </div>
      <div class="modal-body">
      <div style="margin-bottom: 20px;" ><p> You are making modification to the order ID: <span class="ordernocls"><?php if(isset($this->session->data['customer_id']) && isset($this->session->data['order_id']))
{ echo $this->session->data['order_id'];}
	?> </span></p></div>
	<p> Would you like to clear this process?</p>

       	
      </div>
      <div class="modal-footer" style=" padding: 8px 20px 8px !important;">
      <span class="alert alert-success" style=" padding:5px !important; margin-bottom:0px; display:none;"  id="success_msg1">Your order has been cleared successfully.</span>
      <span class="alert alert-danger" style=" padding:5px !important; margin-bottom:0px;display:none;" id="failure_msg1">failed</span>
      	<img src="https://gofootlounge.in/image/loading_spinner.gif" alt="loading..." id="image_spinner">
        <button type="button" class="btn btn-default" id="closebtn" onclick="continueorder();">No</button>
        <button type="button" class="btn btn-primary" id="sendbtn" onclick="unsetorder();">Yes</button>
      </div> 
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->