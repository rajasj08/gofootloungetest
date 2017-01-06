<?php 
/******************************************************
 * @package Pav Megamenu module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
?>
<?php if ($modules) { ?>
<div id="offer-slideshow">
	<?php 
		$i = 0;
		$moduleCount = count($modules);

	 ?>
	<?php foreach ($modules as $module) { ?>
		<?php 
			echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ';
			if($i == 0 ) { echo "first"; }
			else if($i == ($moduleCount - 1)) { echo 'last'; }
			else { echo 'item'; }
			echo '">';  
		?>
		<?php echo $module; ?>
		<?php $i++; ?>
		<?php echo '</div>';  ?>
	<?php } ?>
</div>
<div class="clrBoth">&nbsp;</div>
<?php } ?> 
