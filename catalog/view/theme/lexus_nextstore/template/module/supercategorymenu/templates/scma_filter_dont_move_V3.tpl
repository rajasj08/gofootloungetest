  <?php if ($menu) { ?>
<div id="menuscm">     
  <?php $i=1; ?>
  <div class="box">
    <div class="filter_box">
     
      <?php  
     // print_r($all_values);
      //count($all_values[]);


     /* if(isset($this->session->data['filterp2'])){
      echo $this->session->data['filterp2']."first";    
    if($this->session->data['filterp2']!='test')
      { $this->session->data['filterp2']="closed";  
      }
        else{$this->session->data['filterp2']="";}
        echo $this->session->data['filterp2']."asdfdfd";         
      } */ 


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
      $j=1;

      
       if (!empty($all_values)) { 
         ksort($all_values); 

      ?>

       <?php $g=1; $valinfo=0;
      foreach ($all_values as $all_value) {
        foreach ($all_value as $all_val) { 
        $valinfo++;
        ?>
        <input type="hidden" id="hidden_p<?php echo $g; ?>" name="hidden_p<?php echo $g; ?>"/>    
      <?php $g++; }}     
       
      ?>   
      <?php $k=0; $totcount=count($all_values); foreach ($all_values as $all_value) { ?>
      <?php foreach ($all_value as $all_val) {  
       
        ?> 

      <?php  $i==1 ? $liclass="first upper" : $liclass="upper";?>
      <dl id="filter_p<?php echo $i; ?>" class="filters <?php echo $all_val['initval']; ?> <?php 
  
      if($this->session->data['custom_filter']!="")  { echo $this->session->data['custom_filter'][$k];  } else{ if($i==1 || $all_val['name']=='Availability'){echo ""; } else { echo "closed"; }}          
     ?>">                 
      <dt class="<?php echo $liclass; ?> ffff"  onClick="dtclick('<?php echo $all_val['name']; ?>','<?php echo $valinfo; ?>','<?php echo $i;?>');"><span><em>&nbsp;</em><?php echo $all_val['name']; ?></span><?php echo $all_val['tip_code']; ?></dt> 
       <?php echo html_entity_decode(nl2br($all_val['tip_div'])); ?>
      <dd class="page_preload"><?php echo $all_val['html']; ?></dd>   
      </dl>
      <?php $i++; $j++;$k++;} ?>  
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