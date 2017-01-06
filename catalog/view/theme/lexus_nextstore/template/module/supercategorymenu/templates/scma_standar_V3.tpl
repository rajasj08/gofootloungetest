<?php if ($menu) { ?>

<div id="menuscm">  
  <?php $i=1; ?>
  <div class="box">
    <div class="filter_box"> 
      <?php
      $a='';$b='';$c='';
      if(count($dndvalue[0])>0)
      {
        
        for($k=0;$k<count($dndvalue[0]);$k++)
        {
          if($dndvalue[0][$k]=='Discount')
          {
           
           $a='Discount';
          }
          if($dndvalue[0][$k]=='Brand')
          {
            $b='Brand';
          }
          if($dndvalue[0][$k]=='Size')
          {
           $c='Size';
          }
        }
    } 
       $j=1; if (!empty($values_selected)) { ?>
      <?php foreach ($values_selected as $value_sel) {?>
      <?php  $i==1 ? $liclass="first upper" : $liclass="upper";?>
      <dl id="filter_p<?php echo $i; ?>" class="filters opened" >
        <dt class="<?php echo $liclass; ?>"><span><em>&nbsp;</em><?php echo $value_sel['dnd']; ?></span><?php echo $value_sel['tip_code']; ?></dt>
        <?php echo html_entity_decode(nl2br($value_sel['tip_div'])); ?>
		<dd class="page_preload"><?php echo $value_sel['html']; ?></dd>
      </dl>
      <?php $i++; } ?>
     
      <?php } ?>
      <?php if (!empty($values_no_selected)) { 
      
      ksort($values_no_selected);
      
      ?> 
        <?php $g=1; $valinfo=0;
      foreach ($all_values as $all_value) {
        foreach ($all_value as $all_val) { 
        $valinfo++;
        ?>
        <input type="hidden" id="hidden_p<?php echo $g; ?>" name="hidden_p<?php echo $g; ?>"/>    
      <?php $g++; }}     
       
      ?>   
      <?php $k=0; foreach ($values_no_selected as $value_no_select) { ?>
      <?php foreach ($value_no_select as $value_no_sel) { ?>
      <?php  $i==1 ? $liclass="first upper" : $liclass="upper";?>
      <dl id="filter_p<?php echo $i; ?>" class="filters <?php echo $value_no_sel['initval']; ?> <?php  if($this->session->data['custom_filter']!="")  { echo $this->session->data['custom_filter'][$k];  } else{ if($i==1 || $all_val['name']=='Availability'){echo ""; } else { echo "closed"; }} 
        ?>">
        <dt class="<?php echo $liclass; ?>" onClick="dtclick('<?php echo $all_val['name']; ?>');"><span><em>&nbsp;</em><?php echo $value_no_sel['name']; ?></span><?php echo $value_no_sel['tip_code']; ?></dt>
       <?php echo html_entity_decode(nl2br($value_no_sel['tip_div'])); ?>
       
       <dd class="page_preload"><?php echo $value_no_sel['html']; ?></dd>
      </dl>   
      <?php $i++; $j++; $k++; } ?> 
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

