<html dir="ltr" lang="en">
<head>
    <title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body class="new_ebay_bg">
	<div class="new_ebay_width">
		<div class="new_ebay_height">
			<div class="new_ebay_float">
				<img src="https://uk.openbaypro.com/account/live/images/obp.png" alt="obp">
			</div>
			<div class="new_ebay_width1">
				<h3 class="new_ebay_margin"><a href="http://support.welfordmedia.co.uk/" class="new_ebay_text"><?php echo $help; ?></a></h3>

				<a href="http://www.facebook.com/welfordmedia" title="WM Facebook"><img height="32" class="new_ebay_margin1" src="https://uk.openbaypro.com/account/live/images/facebook.png" border="0" alt="facebook"></a>
				<a href="http://twitter.com/welfordmedia" title="WM Twitter"><img height="32" class="new_ebay_margin1" src="https://uk.openbaypro.com/account/live/images/twitter.png" border="0" alt="twitter"></a>
			</div>
		</div>
		<div>
			<div class="new_ebay_width1">
				<div class="new_ebay_width2">
					<h1 class="new_ebay_margins">Your OpenBay Stock report</h1>
					<p class="new_ebay_padd">This report details all of your products listed on eBay and what is linked to your OpenCart products. It is important that you link all items on eBay so that your stock levels are correct on your store and eBay when items sell. You should also ensure that if stock levels are different (they will be shown below), update them asap to avoid over or underselling. </p>
					<?php if($summary == 1){ ?>
						<p>Items which have sold on eBay but are not paid for are not included in the figures - you need to account for these as they will already be deducted from your stock levels.</p>
					<?php } ?>
				</div>
				<table align="right;" class="new_ebay_mb" cellpadding="2" cellspacing="0">
					<thead>
					<tr>
						<td class="new_ebay_bor" colspan="2">Summary</td>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td class="new_ebay_padding">Report created</td>
						<td class="new_ebay_paddtext"><?php echo date("d/m/Y"); ?></td>
					</tr>
					<tr>
						<td class="new_ebay_padding">Total eBay listings</td>
						<td class="new_ebay_paddtext"><?php echo $ebay_products; ?></td>
					</tr>
					<tr>
						<td class="new_ebay_padding">Total OpenCart items</td>
						<td class="new_ebay_paddtext"><?php echo $store_products; ?></td>
					</tr>
					<tr>
						<td class="new_ebay_padding">Linked items</td>
						<td class="new_ebay_paddtext"><?php echo $storelinked_products; ?> (<?php echo $storelinked_percent; ?>%)</td>
					</tr>
					<tr>
						<td class="new_ebay_padding">Items with errors</td>
						<td class="new_ebay_paddtext"><?php echo $product_errors; ?> (<?php echo $errorlinked_percent; ?>%)</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="new_ebay_c"></div>
			<?php if($summary == 1){ ?>
			<table class="new_ebay_bc" cellpadding="2" cellspacing="0">
				<thead>
				<tr>
					<td class="new_ebay_paddbor">Product name</td>
					<td class="new_ebay_paddbor1">eBay<br />Qty</td>
					<td class="new_ebay_paddbor1">Store<br />Qty</td>
					<td class="new_ebay_paddbor2">Status</td>
				</tr>
				</thead>
				<tbody>
				<?php foreach($products as $product){ ?>
				<tr>
					<td class="new_ebay_bor1"><?php echo $product['name']; ?></td>
					<td class="new_ebay_bor2"><?php echo $product['eQty']; ?></td>
					<td class="new_ebay_bor2"><?php echo $product['sQty']; ?></td>
					<td class="new_ebay_bor3"><?php echo $product['status']; ?></td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
			<?php } ?>
		</div>
		<div class="new_ebay_border">
			<div class="new_ebay_wid">
				<img height="40" class="new_ebay1" src="https://uk.openbaypro.com/account/live/images/wm80.png" alt="openbaypro">
				<p class="new_ebay2">Handmade by <a target="_BLANK" href="http://www.welfordmedia.co.uk" class="new_ebay_new">Welford Media Limited</a></p>
			</div>
			<div class="new_ebay_wid1">
				<a href="http://www.facebook.com/welfordmedia" title="WM Facebook"><img height="32" class="new_ebay3" src="https://uk.openbaypro.com/account/live/images/facebook.png" border="0" alt="facebook"></a>
				<a href="http://twitter.com/welfordmedia" title="WM Twitter"><img height="32" class="new_ebay3" src="https://uk.openbaypro.com/account/live/images/twitter.png" border="0" alt="twitter"></a>
			</div> 
		</div>
	</div>
</body>
</html>