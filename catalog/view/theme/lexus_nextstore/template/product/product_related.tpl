<?php if ($products) { ?>
<?php 	
$cols = ($productConfig['product_related_column'] == 0)?6:$productConfig['product_related_column'];
$span = 12/$cols; 

$cols = 4;
?>
<div id="tab-related" class="box product-related">	
	<?php /*
	<div class="box-heading">
		<span><?php echo $tab_related; ?> (<?php echo count($products); ?>)</span>
		<em class="shapes right"></em>	
		<em class="line"></em>
	</div>
	*/ ?>
	<div class="box-content">
		<div class="box-product">


			<?php
			//print_r('<pre>');
			//print_r($products); die;
			 foreach ($products as $i => $product) { $i=$i+1;?>
			<?php  	 
						$scd= $product['price'];
						$scd = preg_replace('/\D/', '', $scd);
						$scd1 = $product['special'];
						$scd1 = preg_replace('/\D/', '', $scd1);
						$sum_total =   round((($scd  - $scd1)/$scd)*100, 0);
					?>
			<?php if( $i%$cols == 1 && $cols > 1 ) { ?>
			<div class="row">
				<?php } ?>
				
				<div class="col-lg-3 col-md-3 col-sm-4 col-sm-6">
					<div class="product-block">				
						<?php if ($product['thumb']) { ?>
						<?php $product_images = $this->model_catalog_product->getProductImages( $product['product_id'] ); ?>
						<div class="image <?php echo isset($product_images[0])?$swapimg:''; ?>">

							<?php if( $product['is_newarrival'] &&  $product['is_newarrival']  != 0) {   ?>	
								<span class="product-label product-label-newarrival">
									<span>&nbsp;</span>  								
								</span>							
							<?php } ?>

							

							
							<!-- Swap image -->
							<div class="flip">

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
										<a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="btn btn-shopping-cart" title="Add to Cart">
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
										
									</div>
								</div>
							</div>
						</div>

						</div>
						<?php } ?>				

						<div class="product-meta">
							<div class="left">
								<h3 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h3>
								<?php if ($product['price']) { ?>
								<div class="price">
									<?php if (!$product['special']) { ?>
									<?php echo $product['price']; ?>
									<?php } else { ?>
									<span class="price-old"><?php echo $product['price']; ?></span> 
									<span class="price-new"><?php echo $product['special']; ?></span>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
							<?php if ($product['rating']) { ?>
								<div class="right">
									<div class="rating">
									
										<img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" />
									
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>				
				<?php if( $cols > 1  && ($i%$cols == 0 || $i==count($products)) ) { ?>
			</div>
			<?php } ?>				
			<?php } ?>			  
		</div>			  
	</div>
</div>	
<?php } ?>