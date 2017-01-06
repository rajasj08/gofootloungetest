<?php  
class ControllerModuleSuperCategoryMenuAdvancedSeeMore extends Controller {
	
		public function seemore() { 
		
		$this->language->load('module/supercategorymenuadvanced');
		$this->load->model('module/supercategorymenuadvanced');
		$settings_module=$this->config->get('supercategorymenuadvanced_settings');
		
		$this->data['see_more_text'] 		= $this->language->get('see_more_text');
		$this->data['remove_filter_text'] 	= $this->language->get('remove_filter_text');
		$this->data['pricerange_text'] 		= $this->language->get('pricerange_text');
		$this->data['no_data_text'] 		= $this->language->get('no_data_text');
		$this->data['manufacturer_text'] 	= $this->language->get('manufacturer_text');
		$this->data['category_text'] 		= $this->language->get('category_text');
	    $this->data['search_in'] 			= $this->language->get('search_in');
	    $rating_text 					= $this->language->get('rating_text');
		
		if (isset($this->request->get['path'])) {
			$path = '';
			$parts = explode('_', (string)$this->request->get['path']);
			$category_id = array_pop($parts);
		}
		
		if (isset($this->request->get['what'])) {
			$what = $this->request->get['what'];
		}else{
			$what = "C";	
		}
		
		if ($what=="M"){
			
			$url_where2go=(isset($this->request->get['manufacturer_id'])) ? 'manufacturer_id='.$this->request->get['manufacturer_id'] : "manufacturer_id=0";
		    $url_where2go.=(isset($this->request->get['path'])) ? '&path='.$this->request->get['path'] : "&path=0";
		}elseif($what=="C"){
			
			$url_where2go=(isset($this->request->get['path'])) ? 'path='.$this->request->get['path'] : "path=0";
		}
		
	    //variable with enable/disable count.
		if (isset($settings_module['countp'])){
			$this->data['count_products']=$settings_module['countp'];
		}else{
			$this->data['count_products']=1;
		}
		//variable with enable/disable follow.
		if (isset($settings_module['nofollow'])){
			$this->data['nofollow']='rel="nofollow"';
		}else{
			$this->data['nofollow']='';
		}
		//variable with enable/disable tracking.
		if (isset($settings_module['track_google'])){
			$this->data['track_google']=$settings_module['track_google'];
		}else{
			$this->data['track_google']=0;
		}
		//variable with enable/disable ajax.		
		if (isset($settings_module['ajax']['ajax'])){
			$this->data['is_ajax']=$settings_module['ajax']['ajax'];
		}else{
			$this->data['is_ajax']=0;
		}
		
		if (isset($settings_module['menu_filters'])){
			$this->data['menu_filters']=$settings_module['menu_filters'];
		}else{
			$this->data['menu_filters']=1;
		}
		
		//variable with enable/disable count.
		if (isset($settings_module['option_tip'])){
			$this->data['option_tip']=$settings_module['option_tip'];
		}else{
			$this->data['option_tip']=0;
		}
		
		if(version_compare(VERSION,'1.5.5','>')) {
		    
			if (isset($this->request->get['search'])) {
				$filter_name = $this->request->get['search'];
			} else {
				$filter_name = '';
			} 
		
		}else{
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			} 
			
		}
		
		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
		} else {
			$filter_tag = '';
		} 
				
		if (isset($this->request->get['filter_description'])) {
			$filter_description = $this->request->get['filter_description'];
		} else {
			$filter_description = '';
		} 
				
		if (isset($this->request->get['filter_category_id'])) {
			
			if ($category_id==0){
				$category_id = $this->request->get['filter_category_id'];
			}
		} else {
			$filter_category_id = false;
		} 
		
		if (isset($this->request->get['filter_sub_category'])) {
			$filter_sub_category = $this->request->get['filter_sub_category'];
		} else {
			$filter_sub_category = '';
		} 
			
		$url_pr='';
		
		if (isset($this->request->get['PRICERANGE'])) {
			$url_pr.= '&amp;PRICERANGE=' . $this->request->get['PRICERANGE'];
	        $price_range_filter=$this->request->get['PRICERANGE'];
		}else{
			$this->data['enable_pricerange']=false;
			$price_range_filter=false;
		}
		if (isset($this->request->get['C'])) {
			$url_pr .= '&amp;C=' . $this->request->get['C'];
			$filter_coin=$this->request->get['C'];
		} else{
			
			$filter_coin=isset($this->session->data['currency']) ? $this->session->data['currency'] : $this->config->get('config_currency');
			$url_pr .= '&amp;C=' . $filter_coin;
		}
		
		
				
		//searh url filters
		$url_search='';
		
		if(version_compare(VERSION,'1.5.5','>')) {
			if (isset($this->request->get['search'])) {
				$url_search .= '&amp;search=' . $this->request->get['search'];
			}
		
		}else{
			if (isset($this->request->get['filter_name'])) {
			$url_search .= '&amp;filter_name=' . $this->request->get['filter_name'];
		    }
			
		}
		
		if (isset($this->request->get['filter_tag'])) {
			$url_search .= '&amp;filter_tag=' . $this->request->get['filter_tag'];
		}
				
		if (isset($this->request->get['filter_description'])) {
			$url_search .= '&amp;filter_description=' . $this->request->get['filter_description'];
		}
						
		if (isset($this->request->get['filter_category_id'])) {
			$url_search .= '&amp;filter_category_id=' . $this->request->get['filter_category_id'];
		}
		if (isset($this->request->get['filter_sub_category'])) {
			$url_search .= '&amp;filter_sub_category=' . $this->request->get['filter_sub_category'];
		}
		
		if (!isset($this->request->get['path']) or empty($this->request->get['path'])) {
			
			if (isset($this->request->get['filter_category_id'])) {
			
				$this->request->get['path']=$this->request->get['filter_category_id'];
			}else{
				$this->request->get['path']=0;
			}
		}
		
		$url_limits='';
	
		if (isset($this->request->get['sort'])) {
			$url_limits.= '&amp;sort=' . $this->request->get['sort'];
		}	
		if (isset($this->request->get['order'])) {
			$url_limits.= '&amp;order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['limit'])) {
			$url_limits.= '&amp;limit=' . $this->request->get['limit'];
		}
		//init filters
		$filter = false;
				
		//init filters
		$filter_manufacturers_by_id='';	$filter_manufacturers_by_id_string='';	$filter_attributes_by_name='';
		$filter_attribute_id=''; $filter_options_by_name=''; $filter_option_id=''; $filter_attribute_string='';
		$filter_min_price=''; $filter_max_price='';	$filter_stock_id=''; $filter_by_name='';
		$filter_ids=''; $filter_stock=''; $filter_special=''; $filter_clearance='';	$filter_arrivals=''; $filter_width='';
		$filter_height=''; $filter_length=''; $filter_model='';	$filter_sku='';	$filter_upc='';	$filter_location='';$filter_productinfo_id='';
		$filter_weight='';$filter_options_by_ids=''; 
		$filter_ean=''; $filter_isbn=''; $filter_mpn=''; $filter_jan='';
		$filter_rating='';
							
		$manufacturer_text= $this->language->get('manufacturer_text');
		$stock_text= $this->language->get('stock_text');	
		
		//BEGIN CHECKING FILTERS
	
	    if (!empty($this->request->get['filter'])){
			$has_filter=$this->request->get['filter'];
			$filter=true;
		}else{
			$has_filter=false;
			$filter=false;
		}
		
	    if ($has_filter){
		
			$filter=true;
			
		//BEGIN CHECKING FILTERS
		$filtros_seleccionados= array();
			
		$filtros = explode("@@",$has_filter);
		
			foreach ($filtros as $filtro){
				//fix filter string for href[first_position-Second position - only this filter]
				$arr=array();
				$arr = array_diff($filtros,(array)$filtro);
				$links=implode ("@@",$arr);
				list($part1,$name)=explode("=",$filtro);
				list($dnd,$part2)=explode("_",$part1);
						
				$filter_parts=explode("-", $part2);  
					$tipo =$filter_parts[0];
					$special=$filter_parts[1];
					$id=$filter_parts[2];
						
				if (!empty($filter_parts[3])){
					$option_value_id=$filter_parts[3];
				}
						
				if ($special=="i"){
					$image=$this->model_module_supercategorymenuadvanced->getoptionImage($id,$name);
				}else{
					$image='';
				}
						
				$namefinal=html_entity_decode($name)=="NDDDDDN" ? html_entity_decode($no_data_text): html_entity_decode($name);
				        
				if($links){
				    $urlfilter='&amp;filter='.urlencode(str_replace("&amp;","&",$links));
					$hav_filter=1;
				}else{
				    $urlfilter='&amp;filter=';
					$hav_filter=0;
				}		
						
				$see_more_url="index.php?route=module/supercategorymenuadvancedseemore/seemore&amp;path=".$this->request->get['path'].$url_pr.$url_limits.$url_search."&amp;id=".$id."&amp;".$url_where2go."&amp;dnd=".urlencode($dnd)."&amp;what=".urlencode($what)."&amp;tipo=".urlencode($tipo)."&amp;name=".urlencode($namefinal).$urlfilter;
						
				switch($tipo) {
					case 'a': //attribute
						$filter_options_by_ids.="0,";
						switch ($special){
							case 's':
							$filter_attributes_by_name.=$name."sATTNNATT";		
							$filter_attribute_id.=$id.",";	
							$filter_by_name.=$this->model_module_supercategorymenuadvanced->CleanName($name)."sATTNNATT@@@";
							$filter_ids.=$id.",";
							break;
							case 'p':
							$filter_attributes_by_name.=$name."pATTNNATT";		
							$filter_attribute_id.=$id.",";	
							$filter_by_name.=$this->model_module_supercategorymenuadvanced->CleanName($name)."pATTNNATT@@@";
							$filter_ids.=$id.",";
							break;
							case 'n':
							$filter_attributes_by_name.=$name."nATTNNATT";		
							$filter_attribute_id.=$id.",";	
							$filter_by_name.=$this->model_module_supercategorymenuadvanced->CleanName($name)."nATTNNATT@@@";
							$filter_ids.=$id.",";
							break;
						 }
					break;
					case 'm':
						$filter_manufacturers_by_id.=$id.",";
					break;	
			   		case 'o':
						$filter_options_by_name.=$name."OPTTOP";		
						$filter_option_id.=$id.",";	
						$filter_by_name.=$this->model_module_supercategorymenuadvanced->CleanName($name)."OPTTOP@@@";
						$filter_ids.=$id.",";
						$filter_options_by_ids.=$option_value_id.",";
					break;	
					case 'sc':
						$filter_clearance=true;
						$namefinal=$this->language->get('clearance_text');
						$dnd=$this->language->get('stock_text');
						$see_more_url=false;
						break;	
					case 'sn':
						$filter_arrivals=true;
						$namefinal=$this->language->get('new_products_text');
						$dnd=$this->language->get('stock_text');
						$see_more_url=false;
					break;		
					case 'ss':
						$filter_stock=true;
						$dnd=$this->language->get('stock_text');
						$see_more_url=false;
						$namefinal=$this->language->get('in_stock_text');
					break;		
					case 'sp':
						$filter_special=true;
						$dnd=$this->language->get('stock_text');
						$namefinal= $this->language->get('special_prices_text');
						$see_more_url=false;
					break;	
					case 'ra':
						$filter_rating=(int)$name;
						$dnd=$this->language->get('rating_text');
						$namefinal= $this->language->get('rating_text');
						
					break;		
					case 'w':
						switch ($special){
							case 's':
							$filter_width=$name;
							$filter_productinfo_id=$id.",";
							break;
							case 'n':
							$filter_width=$name;
							$filter_productinfo_id=$id.",";
							break;
							}
						break;	
					case 'h':
						switch ($special){
							case 's':
								$filter_height=$name;
								$filter_productinfo_id.=$id.",";
							break;
							case 'n':
								$filter_height=$name;
								$filter_productinfo_id.=$id.",";
								break;
							}
							break;								
							case 'l':
								switch ($special){
									case 's':
									$filter_length=$name;
									$filter_productinfo_id.=$id.",";
									break;
									case 'n':
									$filter_length=$name;
									$filter_productinfo_id.=$id.",";
									break;
									}
								break;									
							case 'sk':
								switch ($special){
									case 's':
									$filter_sku="s".$name;
									$filter_productinfo_id.=$id.",";
									break;
									case 'n':
									$filter_sku=$name;
									$filter_productinfo_id.=$id.",";
									break;
									}
								break;								
							case 'up':
								switch ($special){
									case 's':
									$filter_upc="s".$name;
									$filter_productinfo_id.=$id.",";
									break;
									case 'n':
									$filter_upc=$name;
									$filter_productinfo_id.=$id.",";
									break;
									}
								break;	

							case 'lo':
								switch ($special){
									case 's':
									$filter_location="s".$name;
									$filter_productinfo_id.=$id.",";
									break;
									case 'n':
									$filter_location=$name;
									$filter_productinfo_id.=$id.",";
									break;
									}
								break;
							case 'mo':
								switch ($special){
									case 's':
									$filter_model="s".$name;
									$filter_productinfo_id.=$id.",";
									break;
									case 'n':
									$filter_model=$name;
									$filter_productinfo_id.=$id.",";
									break;
									}
								break;
							case 'wg':
								switch ($special){
									case 's':
									$filter_weight="s".$name;
									$filter_productinfo_id.=$id.",";
									break;
									case 'n':
									$filter_weight=$name;
									$filter_productinfo_id.=$id.",";
									break;
									}
								break;	
							
							case 'e':
								switch ($special){
									case 's':
									$filter_ean="s".$name;
									$filter_productinfo_id.=$id.",";
									break;
									case 'n':
									$filter_ean=$name;
									$filter_productinfo_id.=$id.",";
									break;
									}
								break;	
							
						   case 'i':
								switch ($special){
									case 's':
									$filter_isbn="s".$name;
									$filter_productinfo_id.=$id.",";
									break;
									case 'n':
									$filter_isbn=$name;
									$filter_productinfo_id.=$id.",";
									break;
									}
								break;	
							case 'p':
								switch ($special){
									case 's':
									$filter_mpn="s".$name;
									$filter_productinfo_id.=$id.",";
									break;
									case 'n':
									$filter_mpn=$name;
									$filter_productinfo_id.=$id.",";
									break;
									}
								break;	
		
							case 'j':
								switch ($special){
									case 's':
									$filter_jan="s".$name;
									$filter_productinfo_id.=$id.",";
									break;
									case 'n':
									$filter_jan=$name;
									$filter_productinfo_id.=$id.",";
									break;
									}
								break;	
													
							}
			}
	
	     }
	
	
	
		//FILTER
		if (!empty($this->request->get['filter'])){//fix problem with filter=empty
						
		
		}//End FILTER
	 
		 //mount urlfilter for the rest of the filter
		 if ($has_filter){
			
			$min_urls = explode("@@",str_replace("&amp;","&",$has_filter));
			$url_filter=array();
			foreach ($min_urls as $min_url){
				
				
				list($part1,$name)=explode("=",$min_url);
				list($dnd,$part2)=explode("_",$part1);
				$filter_parts=explode("-", $part2);  
					$tipo=$filter_parts[0];
					$special=$filter_parts[1];
					$id=$filter_parts[2];
						
				if (!empty($filter_parts[3])){
					$option_value_id=$filter_parts[3];
				}else{
					$option_value_id="";
				}
				
				//$url_filter[]=urlencode($tipo) ."=". urlencode($name) ."=". urlencode($id) ."=". urlencode($dnd);
				//list($tipo,$name,$id,$dnd)=explode("=",$min_url);
				$url_filter[]=urlencode($dnd)."_".urlencode($tipo)."-".$special."-".$id."-".$option_value_id."=".urlencode($name);
				
			}
				$url_filter="&amp;filter=".implode("@@",$url_filter);
			
			}else{
				$url_filter='&amp;filter=';	
			}	
				
		
		//PRICE RANGE
			if (isset($price_range_filter) and !empty($price_range_filter)) {
				
				list($filter_min_price,$filter_max_price)=explode(";",$price_range_filter);
											
				//remove currency from price
				$filter_min_price=floor($this->model_module_supercategorymenuadvanced->UnformatMoney($filter_min_price,$filter_coin)); 
				$filter_max_price=ceil($this->model_module_supercategorymenuadvanced->UnformatMoney($filter_max_price,$filter_coin));
				//remove tax from price
				 if ($this->config->get('config_tax') && $settings_module['pricerange']['setvat']) {
					    $tax_value= $this->tax->calculate(1, $settings_module['pricerange']['tax_class_id'], $this->config->get('config_tax'));
						$filter_min_price=floor( $filter_min_price/$tax_value ); 
						$filter_max_price=ceil( $filter_max_price/$tax_value );
				 }
				 
			} //END PRICE RANGE 
			
	
	
		//array with filters to search in database.
			$data_filter = array(
				'filter_manufacturers_by_id'=> (isset($this->request->get['manufacturer_id']))? $this->request->get['manufacturer_id'].",": $filter_manufacturers_by_id, 
				'filter_min_price'  		=> $filter_min_price,
				'filter_max_price'  	 	=> $filter_max_price, 
				'filter_category_id'    	=> $category_id,
				'filter_stock_id'    	    => $filter_stock_id, 
				'filter_by_name' 			=> substr($filter_by_name,0,-3),
				'filter_ids'				=> substr($filter_ids,0,-1),
				'filter_name'         		=> $filter_name, 
				'filter_tag'          		=> $filter_tag, 
				'filter_description'  		=> $filter_description,
				'filter_sub_category' 		=> $filter_sub_category, 
				'filter_stock'				=> $filter_stock,
				'filter_special'			=> $filter_special, 
				'filter_clearance'			=> $filter_clearance,
				'filter_arrivals'			=> $filter_arrivals,
				'filter_width' 				=> $filter_width,
				'filter_height'				=> $filter_height,
				'filter_length' 			=> $filter_length,
				'filter_model' 				=> $filter_model,
				'filter_sku' 				=> $filter_sku,
				'filter_upc' 				=> $filter_upc,
				'filter_location'			=> $filter_location,
				'filter_option_id' 			=> $filter_option_id,
				'filter_attribute_id'		=> $filter_attribute_id,				
				'filter_productinfo_id'		=> $filter_productinfo_id,
				'filter_options_by_ids'		=> $filter_options_by_ids,
				'filter_weight'				=> $filter_weight,
				'filter_ean'				=> $filter_ean,				
				'filter_isbn'				=> $filter_isbn,
				'filter_mpn'				=> $filter_mpn,
				'filter_jan'				=> $filter_jan,				
			    'filter_rating'				=> $filter_rating,
				'filter_see_more'			=> $this->request->get['tipo'].$this->request->get['dnd'].$this->request->get['id'].str_replace("&amp;","&",$this->request->get['name']).$this->request->get['path'].$this->request->get['what']
			);

        // $productos_filtrados= $this->model_module_supercategorymenuadvanced->getProductsFiltered($data_filter);
		$productos_filtrados= $this->model_module_supercategorymenuadvanced->getProductsFiltered($data_filter,$settings_module['stock']['clearance_value'],$settings_module['stock']['number_day'],$settings_module['reviews']['tipo']);
	
		$total_productos=count($productos_filtrados);
	    
		
		if ($this->request->get['what']=="M"){
			
			if(isset($this->request->get['manufacturer_id'])){
				$m_id=$this->request->get['manufacturer_id'];
			}else{
				$m_id=0;
			}
			
			$values_in_category= $this->config->get('VALORESM_'.$m_id, (int)$this->config->get('config_store_id') );
		}else{
			$values_in_category= $this->config->get('VALORES_'.$category_id,(int)$this->config->get('config_store_id'));
		}
		
		
		
		
		
		$que_buscar=$this->request->get['tipo'];
	    $nombre_seleccionado=str_replace("&amp;","&",$this->request->get['name']);  
		$dnd=$this->request->get['dnd'];
		$id=$this->request->get['id'];
			
		$product_infos_values=array("w","h","l","sk","up","lo","mo","wg","e","i","p","j");
	
		if ($que_buscar=="a"){
			
		   isset($values_in_category['attributes']) ? $attributes_in_category=$values_in_category['attributes'] : $attributes_in_category="no hay atributos";
	         //WE HAVE VALUES
			if (is_array($attributes_in_category)){ 
			
			//define id for selected attribute
			$attribute_we_want_info=array($id=>$id);	
		
			//FILTER ATRIBUTES.
			//Get attributes filtered
			$attributes_in_category_filtered = $this->model_module_supercategorymenuadvanced->getAtributesFiltered($productos_filtrados,$data_filter,$attribute_we_want_info);
		 
			//remove all attributes we dont need
			$attributes_filtered=array_intersect_key($attributes_in_category,$attribute_we_want_info);
			
			//remove other attributes in filter.
			$delete_attributes=array();
			
			if ($filter_attribute_id){
				$attributos_filtrados=explode(",",substr($filter_attribute_id, 0, -1));
				foreach ($attributos_filtrados as $attributo_filtrado){
					$delete_attributes[$attributo_filtrado] =$attributo_filtrado;
					
				}
				
			}
	
				//remove attributes in filter we don`t need info.		
			$results=array_diff_key($attributes_filtered,$delete_attributes);

				foreach ($results as $result){
		
				//GET DEFAULT VALUES
				$attribute_name= $this->model_module_supercategorymenuadvanced->getAttributeName($result['attribute_id']);	
				$attribute_id=$result['attribute_id'];
				$attribute_number=$result['number'];
				$attribute_sort_order=$result['sort_order'];
                $attribute_orderval=$result['orderval'];
                $attribute_separator=$result['separator'];
				$attribute_view=$result['view'];
				$attribute_initval=isset($result['initval']) ? $result['initval']  : "opened";
				$attribute_searchinput=isset($result['searchinput']) ? $result['searchinput']  : "no";
				
				
				
				
				//echo $attribute_id;
				//echo "<br>";

				//GET ALL ATRIBUTE VALUES FILTERED
			    $attribute_values = $attributes_in_category_filtered[$attribute_id];
			    //$attribute_values = $this->model_module_supercategorymenuadvanced->getAtributesFiltered($productos_filtrados,$data_filter);
				//Mount real values with the separator.
					if ($attribute_separator!="no"){
						$new_array_values= array();
							if($attribute_values){
							foreach ($attribute_values as $attribute_value){
									
								$attributes = explode($attribute_separator, $attribute_value['text']);	
									$total=0;			
									foreach ($attributes as $attribute) {
										
										if (array_key_exists(trim($attribute), $new_array_values)) {
											$new_array_values[trim($attribute)]=array(
												'text'=>trim($attribute),
												'total'=>$attribute_value['total'] + $new_array_values[trim($attribute)]['total'],
												'separator'=>'YES'
											);
										}else{
											$new_array_values[trim($attribute)]=array(
												'text'=>trim($attribute),
												'total'=>$attribute_value['total'],
												'separator'=>'YES'
											);
										}
									}
								
							}
							$attribute_values=$new_array_values;
							}
					}
				
			   $atributos_final = array();

			if($attribute_values){ 
					foreach ($attribute_values as $attribute_value){
													
						//check if attribute value have no data:
						$attribute_value_name= ($attribute_value['text']=="") ? "NDDDDDN" : $attribute_value['text'];
												
					    //this is only for separator	
						if ($attribute_separator!="no"){
							$string_filtering=urlencode($attribute_name)."_a-p-".$attribute_id."=".urlencode($attribute_value_name);
						}else{
							$string_filtering=urlencode($attribute_name)."_a-".$this->model_module_supercategorymenuadvanced->GetView($attribute_view)."-".$attribute_id."=".urlencode($attribute_value_name);
						}
					

					
					   if ($attribute_value_name==$nombre_seleccionado){
							//reset filter 
							if ($filter){					
								$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter;		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
							}else{				
								$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter;;										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;
							}		
							
						}else{ //no es seleccionado
						
						if ($filter){					
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter.'@@'.$string_filtering;
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter.'@@'.$string_filtering;
						}else{				
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.'&amp;filter='.$string_filtering;
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$string_filtering;
						}	
						
						}
							
						$namer=$attribute_value['text']=="" ? $attribute_value_name=$this->data['no_data_text'] : $attribute_value_name=$attribute_value['text'];
						     $atributos_final['str'.(string)$namer] = array(
								'name'    	   => $namer,
								'href'         => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
								'total'		   => $attribute_value['total'],
								'ajax_url'	   => $ajax_url,
								'seleccionado' => ($namer==$nombre_seleccionado) ? "is_seleccionado" : "no_seleccionado",
							);
					}
			
				}//
			
			$attributes_ord = array_values($this->model_module_supercategorymenuadvanced->OrderArray($atributos_final,$attribute_orderval));
			   if(!empty($atributos_final)){
					$atributos[$attribute_id] = array(
						'attribute_id' => $attribute_id,
						'name'    	   => html_entity_decode($attribute_name),
						'total'		   => count($atributos_final), 
						'ajax_url'	   => $ajax_url,
						'tipo'         => 'ATTRIBUTE',
						'list_number'  => $attribute_number,
				       	'order'	       => $attribute_orderval,
					    'sort_order'   => $attribute_sort_order,
						'jurjur'	   => $attributes_ord,
						'view'		   => $attribute_view,
						'initval'	   => $attribute_initval,
						'searchinput'  => $attribute_searchinput,				
						);
				}
			
			
			
			}// END FOR EACH RESULTS
			
			}//WE HAVE VALUES is_array
			
			if(!empty($atributos)){
				
				$this->data['values_no_selected'][]=$atributos;
			}else{
				
				if ($filter){					
					$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter;		
					$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
			   }else{				
					$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_filter;										
					$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
				}		
							
				$atributos_final['str'] = array(
					'name'    	   => $nombre_seleccionado,
					'href'         => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
					'total'		   => "-",
					'ajax_url'	   => $ajax_url,
					'seleccionado' => "is_seleccionado",
				);
					
				$atributos[$id] = array(
						'attribute_id' => $id,
						'name'    	   => html_entity_decode($nombre_seleccionado),
						'total'		   => 1, 
						'ajax_url'	   => $ajax_url,
						'tipo'         => $que_buscar,
     					'jurjur'	   => $atributos_final,
						'view'		   => "list",
						'initval'	   => "opened",
						'searchinput'  => "no",	
						);
					
				$this->data['values_no_selected'][]=$atributos;
				
			}	
	
		/////////////////////////////////////
		//PRODUCT INFOS.-
		////////////////////////////////////
		
			
		}elseif (in_array($que_buscar,$product_infos_values)){
			
		   $productinfos_in_category=isset($values_in_category['productinfo']) ? $values_in_category['productinfo'] : "no infos";

	         //WE HAVE VALUES
			if (is_array($productinfos_in_category)){
			
			//define id for selected attribute
			$product_info_we_want_info=array($id=>$id);	
			
			//FILTER ATRIBUTES.
			//Get attributes filtered
					
			$product_in_product_info_filtered = $this->model_module_supercategorymenuadvanced->getProductInfosFiltered($productos_filtrados,$data_filter,$dnd,$id);
		
			
			
			//remove all attributes we dont need
			$product_info_filtered=array_intersect_key($productinfos_in_category,$product_info_we_want_info);
			
			//remove other attributes in filter.
			$delete_product_info=array();


			
			if ($filter_productinfo_id){
				$product_info_filtrados=explode(",",substr($filter_productinfo_id, 0, -1));
				foreach ($product_info_filtrados as $product_info_filtrado){
					$delete_product_info[$product_info_filtrado] =$product_info_filtrado;
					
				}
				
			}
	
				//remove attributes in filter we don`t need info.		
			$results=array_diff_key($product_info_filtered,$delete_product_info);
			foreach ($results as $result){
		
				//GET DEFAULT VALUES
				$product_info_name=$result['name'];	
				$product_info_id=$result['productinfo_id'];
				$product_info_number=$result['number'];
				$product_info_sort_order=$result['sort_order'];
                $product_info_orderval=$result['orderval'];
                $product_info_separator=$result['separator'];
				$product_info_view=$result['view'];
				$product_info_initval=$result['initval'];
				$product_info_searchinput=$result['searchinput'];
			
				//GET ALL PRODUCT INFO VALUES FILTERED
			    $product_info_values = $product_in_product_info_filtered[$product_info_id];
			    
				$productos_info_final = array();

				if($product_info_values){ 
					foreach ($product_info_values as $product_info_value){
													
					 //check if product_info value have no data:
					 $product_info_value_name= ($product_info_value['text']=="") ? "NDDDDDN" : $product_info_value['text'];
					 $string_filtering=urlencode($product_info_name)."_".$que_buscar."-".$this->model_module_supercategorymenuadvanced->GetView($product_info_view)."-".$product_info_id."=".urlencode($product_info_value_name);
					
					 if ($product_info_value_name==$nombre_seleccionado){
						//reset filter 
						if ($filter){					
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter;				
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
						}else{				
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter;;				
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;
						}		
					}else{ //no es seleccionado
						if ($filter){					
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter.'@@'.$string_filtering;
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter.'@@'.$string_filtering;
						}else{				
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.'&amp;filter='.$string_filtering;
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$string_filtering;
						}	
						
				   }
							
							$namer=$product_info_value['text']=="" ? $product_info_value_name=$this->data['no_data_text'] : $product_info_value_name=$product_info_value['text'];						    
							
							
							
							if ($que_buscar=="w" || $que_buscar=="h" || $que_buscar=="l"){
          
               $val=$this->length->format($namer, $this->config->get('config_length_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
          
            }elseif($que_buscar=="wg" ) { 
          
               $val=$this->weight->format($namer, $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
          
            }else{
				
				$val=$namer;
				
			}
							
				 $productos_info_final['str'.(string)$namer] = array(
								'name'    	   => $namer,
								'href'         => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
								'total'		   => $product_info_value['total'],
								'ajax_url'	   => $ajax_url,
								'seleccionado' => ($namer==$nombre_seleccionado) ? "is_seleccionado" : "no_seleccionado",
								'val_formatted' =>$val
							);
					}
			
				}//
				
			
			
			$product_infos_ord = array_values($this->model_module_supercategorymenuadvanced->OrderArray($productos_info_final,$product_info_orderval));
			   if(!empty($productos_info_final)){
					$productos_info[$product_info_id] = array(
						'product_info_id' => $product_info_id,
						'name'    	   => html_entity_decode($product_info_name),
						'total'		   => count($productos_info_final), 
						'ajax_url'	   => $ajax_url,
						'tipo'         => 'product_info',
						'list_number'  => $product_info_number,
				       	'order'	       => $product_info_orderval,
					    'sort_order'   => $product_info_sort_order,
						'jurjur'	   => $product_infos_ord,
						'view'		   => $product_info_view,
						'initval'	   => $product_info_initval,
						'searchinput'  => $product_info_searchinput,				
						);
				}
			
			
			
			}// END FOR EACH RESULTS
			
			}//WE HAVE VALUES is_array
			
			if(!empty($productos_info)){
				
				$this->data['values_no_selected'][]=$productos_info;
			}else{
				
				if ($filter){					
					$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter;		
					$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
			   }else{				
					$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_filter;										
					$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
				}		
							
				$productos_info_final['str'] = array(
					'name'    	   => $nombre_seleccionado,
					'href'         => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
					'total'		   => "-",
					'ajax_url'	   => $ajax_url,
					'seleccionado' => "is_seleccionado",
				);
					
				$productos_info[$id] = array(
						'product_info_id' => $id,
						'name'    	   => html_entity_decode($nombre_seleccionado),
						'total'		   => 1, 
						'ajax_url'	   => $ajax_url,
						'tipo'         => $que_buscar,
     					'jurjur'	   => $productos_info_final,
						'view'		   => "list",
						'initval'	   => "opened",
						'searchinput'  => "no",	
						);
					
				$this->data['values_no_selected'][]=$productos_info;
				
			}	
		
		}elseif($que_buscar=="ra"){
			
			if($settings_module['reviews']['reviews']){
				
			$this->data['re_extra_text']=$this->language->get('rating_text_'.$settings_module['reviews']['tipo']);
			
			
				
			  $reviews_final=array();	
			  $results = $this->model_module_supercategorymenuadvanced->getReviewsFiltered($productos_filtrados,$data_filter,$settings_module['reviews']['tipo']);
			
			
			    if(!empty($results)){
					
					foreach ($results as $result) {
					
						$string_filtering=urlencode($rating_text)."_ra-r-a=".urlencode($result['rating']);
						$review_name=$result['rating'];
			
						if ($review_name==$nombre_seleccionado){
							if ($filter){		
								$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter;		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
							}else{				
								$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_filter;										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
							}	 	
							
						}else{ //no es seleccionado
																		
							if ($filter){																																
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter.'@@'.$string_filtering;
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter.'@@'.$string_filtering;
								
							}else{
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.'&amp;filter='.$string_filtering;
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$string_filtering;

							}
				
				
						}
				
				
						$reviews_final["str".$result['rating']] = array(
							'reviews_id'=> $result['rating'],
							'seleccionado' => ($result['rating']==$nombre_seleccionado) ? "is_seleccionado" : "no_seleccionado",
							'name'    	     => $result['rating'],
							'total'		     => $result['total'],
							'href'    	     => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
							'ajax_url'	     => $ajax_url,
							'tipo'			 => "REVIEWS",
							'order'			 => $result['order'],
							
						);
					
					}
					
					$reviews[] = array(
					'name'    	     => $rating_text,
					'total'		     => count($reviews_final),
					'jurjur'    	 => $reviews_final,
					'list_number' 	 => 10000000000000000000000,
				    'order'			 => '',
				    'view'			 => 'rimage',
					'initval'	     => isset($settings_module['reviews']['initval']) ? $settings_module['reviews']['initval']  : "opened",
					'searchinput'    => "no",
						'tipo'			 => "REVIEWS",
				);
						
				$this->data['values_no_selected'][]=$reviews;
						
				}// end !empty results
					
					
							
			}//if($settings_module['reviews']['reviews']){
			
			
		}elseif($que_buscar=="m"){
         
		 	//check admin configuration
			if ($settings_module['manufacturer']['manufacturer']){
				
				$manufactures = array();
				$results = $this->model_module_supercategorymenuadvanced->getManufacturesFiltered($productos_filtrados,$data_filter);
					
				
				if(!empty($results)){
					
					foreach ($results as $result) {
						
						$result['name']=="" ? $manufacturer_name="NDDDDDN" : $manufacturer_name=$result['name'];		
						
						$string_filtering=urlencode($manufacturer_text)."_m-".$this->model_module_supercategorymenuadvanced->GetView($settings_module['manufacturer']['view'])."-".$result['manufacturer_id']."=".urlencode($result['name']);
						
						if ($manufacturer_name==$nombre_seleccionado){
							if ($filter){		
								$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter;		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
							}else{				
								$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_filter;										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
							}	 	
							
						}else{ //no es seleccionado
																		
							if ($filter){																																
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter.'@@'.$string_filtering;
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter.'@@'.$string_filtering;
								
							}else{
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.'&amp;filter='.$string_filtering;
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$string_filtering;

							}
											
							
						}
						
						$manufactures_final["str".$result['name']] = array(
							'manufacturer_id'=> $result['manufacturer_id'],
							'seleccionado' => ($result['name']==$nombre_seleccionado) ? "is_seleccionado" : "no_seleccionado",
							'name'    	     => $result['name'],
							'total'		     => $result['total'],
							'href'    	     => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
							'ajax_url'	     => $ajax_url,
							'tipo'			 => "MANUFACTURER",
							
							
						);
						
					}
		
				$manufactures_ord = array_values($this->model_module_supercategorymenuadvanced->OrderArray($manufactures_final,$settings_module['manufacturer']['order']));
				
				$manufactures[] = array(
					'name'    	     => $manufacturer_text,
					'total'		     => count($manufactures_final),
					'jurjur'    	 => $manufactures_ord,
					'list_number' 	 => $settings_module['manufacturer']['list_number'],
				    'order'			 => $settings_module['manufacturer']['order'],
				    'view'			 => $settings_module['manufacturer']['view'],
					'initval'	     => isset($settings_module['manufacturer']['initval']) ? $settings_module['manufacturer']['initval']  : "opened",
					'searchinput'    => isset($settings_module['manufacturer']['searchinput']) ? $settings_module['manufacturer']['searchinput'] : "no",
					'tipo'			 => "MANUFACTURER",	
				);
						
				$this->data['values_no_selected'][]=$manufactures;
						
				}// end !empty results
				
	
			}// end if ($settings_module["manufacturer"] && !$filter_manufacturers_by_id ){
		
		
		}elseif ($que_buscar=="o"){
			
		  isset($values_in_category['options']) ? $options_in_category=$values_in_category['options'] : $options_in_category="no hay opciones";
	
			//WE HAVE VALUES
			if (is_array($options_in_category)){
			
			//define id for selected OPTION
			$options_we_want_info=array($id=>$id);	
					
			//FILTER OPTIONS.
			//Get options filtered
			$options_in_category_filtered = $this->model_module_supercategorymenuadvanced->getOptionsFiltered($productos_filtrados,$data_filter,$options_we_want_info);
	
			//remove all options we dont need
			$options_filtered=array_intersect_key($options_in_category,$options_we_want_info);
			
			//remove options selected by user
			$delete_options=array();
			
			if ($filter_option_id){
				//Clean string
				$opciones_filtrados=explode(",",substr($filter_option_id, 0, -1));
				foreach ($opciones_filtrados as $opciones_filtrado){
					$delete_options[$opciones_filtrado] =$opciones_filtrado;
					
				}
				
			}


			//remove options in filter we don`t need info.		
			$results=array_diff_key($options_filtered,$delete_options);
			
			foreach ($results as $result){
		
				//GET DEFAULT VALUES
				$option_name=$this->model_module_supercategorymenuadvanced->getOptionName($result['option_id']);	
				$option_id=$result['option_id'];
				$option_number=$result['number'];
				$option_sort_order=$result['sort_order'];
                $option_orderval=$result['orderval'];
                $option_separator=$result['separator'];
				$option_view=$result['view'];
				$option_initval= isset($result['initval']) ? $result['initval']  : "opened";
				$option_searchinput=isset($result['searchinput']) ? $result['searchinput']  : "no";
				//GET ALL OPTIONS VALUES FILTERED
			    $options_values = $options_in_category_filtered[$option_id];	
				
				$options_final = array();

				if($options_values){ 
					foreach ($options_values as $option_value){
					
								
						//check if option value have no data:
						$option_value['text']=="" ? $option_value_name="NDDDDDN" : $option_value_name=$option_value['text'];						
								
						if ($option_value_name==$nombre_seleccionado){
							
							if ($filter){					
								$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter;		
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
							}else{				
								$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_filter;										
								$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
							}	 	
							
						}else{ //no es seleccionado
						
						$string_filtering=urlencode($option_name)."_o-".$this->model_module_supercategorymenuadvanced->GetView($option_view)."-".$option_id."-".$option_value['option_value_id']."=".urlencode($option_value_name);
											
						if ($filter){					
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter.'@@'.$string_filtering;
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter.'@@'.$string_filtering;
						}else{				
							$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.'&amp;filter='.$string_filtering;
							$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.'&amp;filter='.$string_filtering;
						}	
						
					
								
						}
						
						
						$namer=$option_value['text']=="" ? $no_data_text : $option_value['text'];
						
						$options_final['str'.(string)$namer] = array(
								'name'    	   => $namer,
								'seleccionado' => ($namer==$nombre_seleccionado) ? "is_seleccionado" : "no_seleccionado",
								'href'         => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
								'total'		   => $option_value['total'],
								'ajax_url'	   => $ajax_url,
								'image_thumb'  => $option_value['image_thumb'],
								'order'	       => $option_value['order'],
							);
					}
			
			
			
				}//

					
			        $sort_order = array();
	  				
					
					if ($option_value['image_thumb']){
						 foreach ($options_final as $key => $value) {
							 $sort_order[] = $value['seleccionado'];
						 }
						array_multisort($sort_order,SORT_ASC,$options_final); 
						
						$options_ord =array_values($options_final);
				
					}else{
				
						$options_ord = array_values($this->model_module_supercategorymenuadvanced->OrderArray($options_final,$option_orderval));
			
					}
					
					if(!empty($options_final)){
						$opciones[$option_id] = array(
							'option_id' => $option_id,
							'name'    	   => html_entity_decode($option_name),
							'total'		   => count($options_final), 
							'ajax_url'	   => $ajax_url,
							'tipo'         => 'OPTION',
							'list_number'  => $option_number,
							'order'	       => $option_orderval,
							'sort_order'   => $option_sort_order,
							'jurjur'	   => $options_ord,
							'view'		   => $option_view,
							'initval'	   => $option_initval,
							'searchinput'  => $option_searchinput,
							
												
							);
					}
			
			
			}// END FOR EACH RESULTS
			
			
			//if(!empty($opciones)){$this->data['values_no_selected'][]=$opciones;}
		}//is_array(option_category)
		
		
		if(!empty($opciones)){
				
				$this->data['values_no_selected'][]=$opciones;
		}else{
				
				if ($filter){					
					$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_search.$url_filter;		
					$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_search.$url_filter;	
			   }else{				
					$filter_url=$this->url->link('product/asearch', $url_where2go).$url_pr.$url_limits.$url_filter;										
					$ajax_url='path='.$this->request->get['path'].$url_pr.$url_limits.$url_filter;	
				}		
							
				$options_final['str'] = array(
					'name'    	   => $nombre_seleccionado,
					'href'         => $this->model_module_supercategorymenuadvanced->SeoFix($filter_url),
					'total'		   => "-",
					'ajax_url'	   => $ajax_url,
					'seleccionado' => "is_seleccionado",
				);
					
				$opciones[$id] = array(
						'option_id' => $id,
						'name'    	   => html_entity_decode($nombre_seleccionado),
						'total'		   => 1, 
						'ajax_url'	   => $ajax_url,
						'tipo'         => $que_buscar,
						'jurjur'	   => $options_final,
						'view'		   => "list",
						'initval'	   => "opened",
						'searchinput'  => "no",	
						);
					
				$this->data['values_no_selected'][]=$opciones;
				
			}	
		} 
		
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/supercategorymenu/supercategorymenuadvanced_seemore.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/supercategorymenu/supercategorymenuadvanced_seemore.tpl';
		} else {
				$this->template = 'default/template/module/supercategorymenu/supercategorymenuadvanced_seemore.tpl';
		}
				$this->response->setOutput($this->render());
		
			
	}
	
	}
	
?>