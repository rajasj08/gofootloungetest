<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/config.tpl" ); ?>
<?php echo $header; ?>
<?php require( DIR_TEMPLATE.$this->config->get('config_template')."/template/common/breadcrumb.tpl" );  ?>

<div class="container">
<div class="row">
<div class="row">

<?php if( $SPAN[0] ): ?>
	<aside class="col-lg-<?php echo $SPAN[0];?> col-md-<?php echo $SPAN[0];?> col-sm-12 col-xs-12">
		<?php echo $column_left; ?>
	</aside>
<?php endif; ?> 
<section class="col-lg-<?php echo $SPAN[1];?> col-md-<?php echo $SPAN[1];?> col-sm-12 col-xs-12">  

	<div class="span<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?php echo $content_top; ?>
		<div class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
			<?php } ?>
		</div>
		<h1><?php echo $heading_title; ?></h1>

		<?php if (isset($error_warning)) { ?>
		<div class="alert alert-error"><?php echo $error_warning; ?></div>
		<?php } ?>

		<form class="form-horizontal" action="<?php echo $this->url->link('account/track_order', '', 'SSL'); ?>" method="post">
			<!--<input type="hidden" name="route" value="account/track_order" />-->
			<div class="control-group <?php echo (isset($error["email"]))?'error':""; ?>" align="center">
				<label class="control-label" for="inputEmail"><?php echo $entry_email; ?></label>
				<div class="controls">
					<Span class="new_track_mail">Enter Your Mail-Id&nbsp;&nbsp;:&nbsp;</Span> <input type="text" id="inputEmail" name="email" placeholder="<?php echo $entry_email; ?>" value="<?php echo htmlentities($email, ENT_QUOTES, "UTF-8"); ?>">
					<?php if (isset($error["email"])) { ?>
					<span class="help-block error"><?php echo $error["email"]; ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="control-group <?php echo (isset($error["order_id"]))?'error':""; ?>" align="center">
				<label class="control-label" for="inputOrderId"><?php echo $entry_order_id; ?></label>
				<div class="controls">
					<Span class="new_track_orderid">Enter Your Order-Id:</Span> <input type="text" id="inputOrderId" name="order_id" placeholder="<?php echo $entry_order_id; ?>" value="<?php echo htmlentities($order_id, ENT_QUOTES, "UTF-8"); ?>">
					<?php if (isset($error["order_id"])) { ?>
					<span class="help-block error"><?php echo $error["order_id"]; ?></span>
					<?php } ?>
				</div>
			</div>
            <div class="new_track_clear">&nbsp;</div>
			<div class="control-group">
				<div class="controls" align="center">
					<button type="submit" class="new_track_btn" class="btn btn-primary"><?php echo $btn_track_order; ?></button>
				</div>
			</div>
		</form>

		<!--<div id="widget-track-box">
			<div id="as-root"></div><script>(function(e,t,n){var r,i=e.getElementsByTagName(t)[0];if(e.getElementById(n))return;r=e.createElement(t);r.id=n;r.src="//apps.aftership.com/all.js";i.parentNode.insertBefore(r,i)})(document,"script","aftership-jssdk")</script>
			<div class="as-track-button" data-counter="true" data-support="true" data-width="300" data-size="large"></div>
		</div>-->

		<?php echo $content_bottom; ?>
	</div>
	<?php echo $column_right; ?>
</div>
<?php echo $footer; ?>