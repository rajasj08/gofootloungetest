<?php if ($coupon_status || $voucher_status || $reward_status) { ?>
    <h2><?php echo $text_next; ?></h2>
    <div class="content">
        <p><?php echo $text_next_choice; ?></p>
        <table class="radio table-hover">
        <?php if ($coupon_status) { ?>
            <tr class="highlight">
                <td>
                    <?php if ($next == 'coupon') { ?>
                        <input type="radio" name="next" value="coupon" id="use_coupon" checked="checked" />
                    <?php } else { ?>
                        <input type="radio" name="next" value="coupon" id="use_coupon" />
                    <?php } ?>
                </td>
                <td>
                    <label for="use_coupon"><?php echo $text_use_coupon; ?></label>
                </td>
            </tr>
        <?php } ?>
        
        <?php if ($voucher_status) { ?>
            <tr class="highlight">
                <td>
                    <?php if ($next == 'voucher') { ?>
                        <input type="radio" name="next" value="voucher" id="use_voucher" checked="checked" />
                    <?php } else { ?>
                        <input type="radio" name="next" value="voucher" id="use_voucher" />
                    <?php } ?>
                </td>
                <td>
                    <label for="use_voucher"><?php echo $text_use_voucher; ?></label>
                </td>
            </tr>
        <?php } ?>


        <?php if ($reward_status) { ?>
            <tr class="highlight">
                <td>
                    <?php if ($next == 'reward') { ?>
                        <input type="radio" name="next" value="reward" id="use_reward" checked="checked" />
                    <?php } else { ?>
                        <input type="radio" name="next" value="reward" id="use_reward" />
                    <?php } ?>
                </td>
                <td>
                    <label for="use_reward"><?php echo $text_use_reward; ?></label>
                </td>
            </tr>
        <?php } ?>


        <?php if ($shipping_status) { ?>
            <!--<tr class="highlight">
                 <td>
                    <?php if ($next == 'shipping') { ?>
                        <input type="radio" name="next" value="shipping" id="shipping_estimate" checked="checked" />
                    <?php } else { ?>
                        <input type="radio" name="next" value="shipping" id="shipping_estimate" />
                    <?php } ?>
                </td>
                <td>
                    <label for="shipping_estimate"><?php echo $text_shipping_estimate; ?></label>
                </td>
            </tr>-->
        <?php } ?>
    </table>
</div>


<div class="cart-module">
    <div id="coupon" class="content" style="display: <?php echo ($next == 'coupon' ? 'block' : 'none'); ?>;">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" role="form">
            <?php echo $entry_coupon; ?>&nbsp;
            <input type="text" name="coupon" id="button_checkout_coupon" value="<?php echo $coupon; ?>" />
            <input type="hidden" name="next" value="coupon" />
            &nbsp;
            <input type="button" id="button_checkout_apply_coupon" value="<?php echo $button_coupon; ?>" class="button btn btn-theme-default" />
            <span class="label label-success" id="checkout_coupon_msg"> </span>
        </form>
    </div>
    
    <div id="voucher" class="content" style="display: <?php echo ($next == 'voucher' ? 'block' : 'none'); ?>;">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" role="form">
            <?php echo $entry_voucher; ?>&nbsp;
            <input type="text" name="voucher" id="button_checkout_voucher" value="<?php echo $voucher; ?>" />
            <input type="hidden" name="next" value="voucher" />
            &nbsp;
            <input type="button" id="button_checkout_apply_voucher" value="<?php echo $button_voucher; ?>" class="button btn btn-theme-default" />
            <span class="label label-success" id="checkout_voucher_msg"> </span>
        </form>
    </div>
    
    <div id="reward" class="content" style="display: <?php echo ($next == 'reward' ? 'block' : 'none'); ?>;">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" role="form">
            <?php echo $entry_reward; ?>&nbsp;
            <input type="text" name="reward" id="button_checkout_reward" value="<?php echo $reward; ?>" />
            <input type="hidden" name="next" value="reward" />
            &nbsp;
            <input type="button" id="button_checkout_apply_reward" value="<?php echo $button_reward; ?>" class="button btn btn-theme-default" />
            <span class="label label-success" id="checkout_reward_msg"> </span>
        </form>
    </div>
</div>
<div class="buttons">
        <div class="right">
            <input type="button" class="button btn btn-theme-default" id="button-coupon-options" value="Continue">
        </div>
    </div>
<?php } ?>

<script type="text/javascript">
<!--
$('input[name=\'next\']').bind('change', function() {
    $('.cart-module > div').hide();
    
    $('#' + this.value).show();
});
//-->
</script>