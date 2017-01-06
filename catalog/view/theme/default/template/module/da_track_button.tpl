<?php
if ($da_track_button_status) {
?>
<div class="box">
	<div class="box-heading"><?php echo $heading_title; ?></div>
	<div class="box-content center">
		<?php
			echo html_entity_decode($da_track_button_aftership, ENT_QUOTES, 'UTF-8');
		?>
	</div>
</div>

<?php
}
?>

