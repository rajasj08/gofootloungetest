<input type="hidden" id="prodcutquan" value="<?php echo $prodcutquandata; ?>">

<table id="total" class="cartclswhole">
                                         <tr class="ordertrsumy">
                                              <td class="ordersumy">Order Summary:</td>
                                              <td></td> 
                                        </tr> 

                                       <tr>
						<td class="right txtleftalign"><b> Sub-Total :<?php //echo $total['title']; ?></b></td>
						<td class="right"><?php echo $bagtot; ?></td>
					</tr>
				
					<?php $couponvalue=0; foreach ($totals as $total) { 

						if($total['code']=='coupon')
						{ 
							$couponvalue=$total['value'];
						}
						if($total['code']=='total')
						{ 
							$total['value']=$total['value']+round($couponvalue); 
							$total['text']=$this->currency->format($total['value']); 
                                                        $total['title']='Order Total';
						}
                                                if($total['code']=='sub_total')
						{
                                                      // finding discount for the product
                                 $scda= $bagtot;
				$scda = preg_replace('/\D/', '', $scda);
				//$scda1 = $prod_orgprice;

                                                      $discount_tot=$scda - round($total['value']); ?>
                                                      <tr>
						      <td class="right txtleftalign"><b>Discount<?php //echo $total['title']; ?>:</b></td>
						      <td class="right cartfontcolorcls"><?php echo $this->currency->format(-$discount_tot); ?></td>
					              </tr> 
                                              <?php   } else { 
                                                      
						?>
					<tr>
						<td class="right <?php if($total['code']=='total'){ echo "mytotcolorcls"; }?> txtleftalign"><b><?php echo $total['title']; ?>:</b></td>
						<td class="right overall_info<?php echo $total['code']; if($total['code']=='sub_total') { echo "subtotclsinfo";} ?> <?php if($total['code']=='total'){ echo "mytotcolorcls"; } if($total['code']=='shipping'){ echo "mytotshipcolorcls"; }?>"><?php echo $total['text'];  ?></td>
					</tr>
					<?php } } ?>
				</table>