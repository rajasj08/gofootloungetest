<?php if ($menu) { ?>
<div id="menuscm">
  <?php $i=1; ?>
  <div class="box">
   
    <div class="filter_box">
      <?php if (!empty($values_selected)) { ?>
      
      <?php $liclass= ($i==1) ? "first upper" : "upper";?>
      <dl id="filter_p<?php echo $i; ?>" class="filters opened" >
        <dt class="<?php echo $liclass; ?>"><span><em>&nbsp;</em><?php echo $txt_your_selections; ?><?php echo $reset_all_filter; ?></dt>
        <dd class="page_preload">
        <?php foreach ($values_selected as $value_sel) {?>
		<?php 
     	//remove semore link
        echo preg_replace('#(<li class="more_filters">).*?(</li>)#', '', $value_sel['html']);?> 
        
        <?php } ?>
     </dd>
      </dl>
      <?php $i++; } ?>
     
     
      <?php if (!empty($values_no_selected)) { 
      
      ksort($values_no_selected);
      
      ?>
      <?php foreach ($values_no_selected as $value_no_select) { ?>
      <?php foreach ($value_no_select as $value_no_sel) { ?>
      <?php  $i==1 ? $liclass="first upper" : $liclass="upper";?>
      <dl id="filter_p<?php echo $i; ?>" class="filters <?php echo $value_no_sel['initval']; ?>">
        <dt class="<?php echo $liclass; ?>"><span><em>&nbsp;</em><?php echo $value_no_sel['name']; ?></span><?php echo $value_no_sel['tip_code']; ?></dt>
       <?php echo html_entity_decode(nl2br($value_no_sel['tip_div'])); ?>
       
       <dd class="page_preload"><?php echo $value_no_sel['html']; ?></dd>
      </dl>
      <?php $i++; } ?>
      <?php } ?>
      <?php } ?>
      <!-- <dl class="filters">
        <dt class="last"><span>&nbsp;</span></dt>
      </dl> -->
    </div>
  </div>
</div>
<!!!!!! INSERT JAVASCRIPT VQMOD !!!!!!!!!!!>
<?php  } ?>








