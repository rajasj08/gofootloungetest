<select name="address_id" style="width: 100%; margin-bottom: 15px;">
		<?php foreach ($addresses as $address) { ?>
		<?php if ($address['address_id'] == $address_id) { ?>
		<option value="<?php echo $address['address_id']; ?>" selected="selected"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?>, <?php echo $address['postcode']; ?></option>
		<?php } else { ?>
		<option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?>,<?php echo $address['postcode']; ?></option>
		<?php } ?>
		<?php } ?>
	</select>  