<?php echo $header; ?>
<div class="row">
	<?php echo $column_left; ?>
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
			<div class="control-group <?php echo (isset($error["email"]))?'error':""; ?>">
				<label class="control-label" for="inputEmail"><?php echo $entry_email; ?></label>
				<div class="controls">
					<input type="text" id="inputEmail" name="email" placeholder="<?php echo $entry_email; ?>" value="<?php echo htmlentities($email, ENT_QUOTES, "UTF-8"); ?>">
					<?php if (isset($error["email"])) { ?>
					<span class="help-block error"><?php echo $error["email"]; ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="control-group <?php echo (isset($error["order_id"]))?'error':""; ?>">
				<label class="control-label" for="inputOrderId"><?php echo $entry_order_id; ?></label>
				<div class="controls">
					<input type="text" id="inputOrderId" name="order_id" placeholder="<?php echo $entry_order_id; ?>" value="<?php echo htmlentities($order_id, ENT_QUOTES, "UTF-8"); ?>">
					<?php if (isset($error["order_id"])) { ?>
					<span class="help-block error"><?php echo $error["order_id"]; ?></span>
					<?php } ?>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-primary"><?php echo $btn_track_order; ?></button>
				</div>
			</div>
		</form>

		<div id="widget-track-box">
			<div id="as-root"></div><script>(function(e,t,n){var r,i=e.getElementsByTagName(t)[0];if(e.getElementById(n))return;r=e.createElement(t);r.id=n;r.src="//apps.aftership.com/all.js";i.parentNode.insertBefore(r,i)})(document,"script","aftership-jssdk")</script>
			<div class="as-track-button" data-counter="true" data-support="true" data-width="300" data-size="large"></div>
		</div>

		<?php echo $content_bottom; ?>
	</div>
	<?php echo $column_right; ?>
</div>
<?php echo $footer; ?>
