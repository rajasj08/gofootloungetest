<?php 
	require_once DIR_TEMPLATE. $this->config->get('config_template').'/external-lib/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
	
	$slideCount = 8;
	$cols = 4;
	if($deviceType == 'phone')
	{
		$slideCount = 1;
		$cols = 1;
	}

	
	$span = 12/$cols;

	$themeConfig  	 			= (array)$this->config->get('themecontrol');
	$categoryConfig  			= array( 		
		'category_pzoom' 		=> 1,
		'show_swap_image' 		=> 0,
		'quickview' 			=> 0,
	); 
	$categoryConfig  			= array_merge($categoryConfig, $themeConfig );
	$categoryPzoom 	    		= $categoryConfig['category_pzoom'];
	$quickview 					= $categoryConfig['quickview'];
	$swapimg 					= ($categoryConfig['show_swap_image'])?'swap':'';
?>


<div id="latest-products">
	<div id="pavcarousel_latest" class="box white carousel slide pavcarousel hidden-sm hidden-xs">
		<div class="box-heading">
			<span><?php if($deviceType == 'phone') { echo "Recommended";} else { echo $heading_title; } ?> </span>
			<span></span>
			<em class="shapes right"></em>	
			<em class="line"></em>
		</div>  

		<div class="box-content">	
			<div class="carousel-controls">
				<a class="carousel-control left" href="#pavcarousel_latest" data-slide="prev">
					<em class="fa fa-angle-left"></em>
				</a>
				<a class="carousel-control right" href="#pavcarousel_latest" data-slide="next">
					<em class="fa fa-angle-right"></em>
				</a>
			</div>	

			<div class="carousel-inner">	
				<?php
				//print_r('<pre>'); print_r($products); die;
				 foreach ($products as $i => $product) { $i=$i+1; ?>

				<?php  	 
					$scd= $product['price'];
					$scd = preg_replace('/\D/', '', $scd);
					$scd1 = $product['special'];
					$scd1 = preg_replace('/\D/', '', $scd1);
					$sum_total =   round((($scd  - $scd1)/$scd)*100, 0);
				?>

				<?php if($deviceType == 'phone') { ?>
					<div class="slide-items item <?php if($i==1) {?>active<?php } ?>">
						<div class="row product-items">
				<?php } else { ?>
					<?php if( $i%$slideCount == 1 && $slideCount > 1 ) { ?>
						<div class="slide-items item <?php if($i==1) {?>active<?php } ?>">
					<?php } ?> 

					<?php if( $i%$cols == 1 && $cols > 1 ) { ?>
						<div class="row product-items">
					<?php } ?> 
				<?php } ?>
				

				
					<div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-<?php echo $span;?> product-cols">
						<div class="product-block">
							<?php if ($product['thumb']) { ?>
								
								<?php $product_images = $this->model_catalog_product->getProductImages( $product['product_id'] ); ?>
								<div class="image <?php echo isset($product_images[0])?$swapimg:''; ?>">
									

									<?php /*if( $categoryPzoom ) { $zimage = str_replace( "cache/","", preg_replace("#-\d+x\d+#", "",  $product['thumb'] ));  ?>
										<a href="<?php echo $zimage;?>" class="info-view colorbox product-zoom" rel="colorbox" title="<?php echo $product['name']; ?>"><i class="fa fa-search-plus"></i></a>
									<?php }*/ ?>

									<!-- Swap image -->
									<div class="flip1">

										<?php if($product['quantity']<=0) { ?>
							<a href="javascript:void(0);"><span class="stockOutBg">&nbsp;</span><span class="stockOutText">Out Of Stock</span></a> 
							<?php } 

							?>
										<a href="<?php echo $product['href']; ?>" class="swap-image">
											<img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" class="front" />
											<?php 
											if( $categoryConfig['show_swap_image'] ){
												$product_images = $this->model_catalog_product->getProductImages( $product['product_id'] );
												if(isset($product_images) && !empty($product_images)) {
													$thumb2 = $this->model_tool_image->resize($product_images[0]['image'],  $this->config->get('config_image_product_width'),  $this->config->get('config_image_product_height') );
												?>	
												<img src="<?php echo $thumb2; ?>" alt="<?php echo $product['name']; ?>" class="back" />
											<?php } } ?>								
										</a>
									</div>

									<div class="product-cont">
										<?php if( $product['is_newarrival'] &&  $product['is_newarrival']  != 0) {   ?>	
											<span class="product-label product-label-newarrival">
												<span>&nbsp;</span>  								
											</span>							
										<?php } ?>
										<?php if( $product['special'] ) {   ?>	
											<span class="product-label product-label-special">
												<span><?php echo $sum_total; ?>%</span>  								
											</span>							
										<?php } ?>
										<a href="<?php echo $product['href']; ?>"><span class="product-cont-overlay">
											&nbsp;
										</span></a>

										<div class="action">
											<div class="action-cont">
												<div class="cart">									
													<a title="Add to Cart" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="btn btn-shopping-cart">
														<span class="fa fa-shopping-cart product-icon hidden-sm hidden-md">&nbsp;</span>
														<span><?php echo $button_cart; ?></span>
													</a>										
												</div>
												<div class="quick-view">
													<?php if ($quickview) { ?>
														<a class="pav-colorbox btn btn-theme-default" href="<?php echo $this->url->link("themecontrol/product",'product_id='.$product['product_id'] );?>"><em class="fa fa-plus"></em><span><?php echo $this->language->get('quick_view'); ?></span></a>
													<?php } ?>
												</div>
												<div class="button-group">
													<div class="wishlist"> 
														<a onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get("button_wishlist"); ?>" class="fa fa-heart product-icon">
															<?php //echo $this->language->get("button_wishlist"); ?>
														</a>
													</div>
													<div class="compare">
														<a onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get("button_compare"); ?>" class="fa fa-refresh product-icon">
															<?php //echo $this->language->get("button_compare"); ?>
														</a>
													</div>
												</div>
												<div class="clrBoth">&nbsp;</div>
											</div>
											
										</div>
									</div>	
								</div>
							<?php } ?>
							
							<div class="product-meta">
								<div class="left">
									<div class="name modulenname"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
									<?php if ($product['price']) { ?>
									<div class="price">
										<?php if (!$product['special']) { ?>
										<?php echo $product['price']; ?>
										<?php } else { ?>
										<span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>  

			<!-- <span style=" font-size:12px;font-weight: 800;color:#e55e5e">[<?php echo $sum_total; ?>% <?php echo 'OFF'; ?>]</span> -->
			           
										<?php } ?>
									</div>
									<?php } ?>
								</div>																	
							</div>		
						</div>
					</div>	

					<?php if($deviceType == 'phone') { ?>
							</div>
						</div>
					<?php } else { ?>
						<?php if( ($i%$cols == 0 || $i==count($products) ) && $cols > 1 ) { ?>
							</div>
						<?php } ?>		

						<?php if( ($i%$slideCount == 0 || $i==count($products) ) && $slideCount > 1 ) { ?>
							</div>
						<?php } ?>	
					<?php } ?>	
					

				<?php } ?>	
			</div>	
		</div>	
	</div>
</div>

<script type="text/javascript">
$('#pavcarousel_latest').carousel({auto:false, interval: false});
</script>