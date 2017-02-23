<?php
class ControllerCommonSeoUrl extends Controller {


	private $url_list = array (
        'common/home'       => '',
        'checkout/cart'     => 'cart',
        'account/register'  => 'register',
        'account/voucher'	=> 'voucher',
        'account/wishlist'  => 'wishlist',
        'checkout/checkout' => 'checkout',
        'account/login'     => 'login',
        'product/special'   => 'online-shopping-offers',
        'affiliate/account' => 'affiliate',
        'checkout/voucher'  => 'voucher',
        'product/manufacturer' => 'brands',
        'account/newsletter'   => 'newsletter',
        'account/order'        => 'order',
        'account/order/editorder'        => 'editorder',
        'account/account'      => 'account',
        'information/contact'  => 'contact',
        'account/return/insert' => 'return',
        'information/sitemap'   => 'sitemap',
		'product/new-arrivals' 	=> 'new-arrivals',
		'product/bestseller' 	=> 'bestseller',
		'pavdeals/deals' 	=> 'deals', 
		'product/search'    => 'search'     
    ); 

	public function index() {  
		// Add rewrite to url class
		
		$this->load->model('catalog/category');

		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}

			$test404link = $_SERVER['REQUEST_URI'];
 
			$test404link=trim($test404link);
			
            
            if($test404link=="/index.php?route=themecontrol/product&amp;amp;product_id=1626" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1627" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1628" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1629" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1630" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1631" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1632" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1633" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1634" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1635" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1636" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1637" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1638" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1640" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1641" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1642" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1643" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1644" || $test404link== "/index.php?route=themecontrol/product&amp;amp;product_id=1645") 
            {
            	
            	$this->request->get['route']='common/home/page404';
               	return $this->forward($this->request->get['route']);

            }
           

		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);
                        

			$categoryArray = array();

			foreach ($parts as $partKey => $part) {
				if($part != "")
				{
					
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
					
					if ($query->num_rows) {


						$url = explode('=', $query->row['query']);
						
						if ($url[0] == 'product_id') {
							$this->request->get['product_id'] = $url[1];
						}
						

						if ($url[0] == 'manufacturer_id') {
							$this->request->get['manufacturer_id'] = $url[1];
						}
						
						if ($url[0] == 'information_id') {
							$this->request->get['information_id'] = $url[1];
						}

						if ($url[0] == 'category_id') {
							if($query->num_rows > 1)
							{
                                                         
								foreach($query->rows as $catSingle)
								{
									$urlNew = explode('=', $catSingle['query']);
									if ($urlNew[0] == 'category_id') {
										$currCatId = $urlNew[1];
										if($partKey == 0)
										{
											$getCategoryInfo			= $this->model_catalog_category->getCategory($currCatId);
											if($getCategoryInfo['parent_id'] == 0)
											{
												$this->request->get['path'] = $currCatId;
												$categoryArray[] = $currCatId;
												break;
											}

											
										}    
										else
										{
											$getCategories 			= array();
											$getCategoriesIDS 		= array();
											$getCategories 			= $this->model_catalog_category->getCategories($categoryArray[$partKey-1]);
											foreach($getCategories as $categoryInd)
											{
												$getCategoriesIDS[] = $categoryInd['category_id'];
											}
											if(in_array($currCatId, $getCategoriesIDS))
											{
												$this->request->get['path'] .= '_' . $currCatId;
												$categoryArray[] = $currCatId;
												break;
											}
										}
									}
								}  //foreach end
							} //inner if end
							else
							{
								
								if (!isset($this->request->get['path'])) {
									$this->request->get['path'] = $url[1];
								} else {
									$this->request->get['path'] .= '_' . $url[1];
								}
								$categoryArray[] = $url[1];
							}
						}		//outer if end	
						
							
					} //query if end 
					else {

						
						$this->request->get['route'] = 'common/home/page404';	
					}
				} //outer query if

			} //foreach end
			

		
			if ( $_s = $this->setURL($this->request->get['_route_']) ) {
				
                $this->request->get['route'] = $_s;
            }
		
			
			if (isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product/product';
			} elseif (isset($this->request->get['path'])) {
				$this->request->get['route'] = 'product/category';
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'product/manufacturer/info';
			} elseif (isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information/information';
			} 

                     $produnavailarr = array(903,316,261,1133,393,415,710,968,879,818,417,893,814,951,779,1061,868,1361,855,1289,553,1148,61,809,406,1203,866,823,308,1031,770,819,928,1036,838,1014,671,229,109,904,238,952,801,466,907,227,728,462,619,675,843,685,736,557,573,225,216,438,668,570,630,217,756,640,821,263,167, 664,626,446,687,730,233,524,173,483,305,585,593,698,401,693,362,93,580,564,637,57,276,325,1001,73,35,711,744,727,702,677,44,442,936,80,692,954,655,380,906,373,508,749,955,41,543,447,480,745,754,769,645,206,683,454,58,259,274,377,207,676,441,213,228,684,469,94,84,509,395,542,243,278,194,390,471,144,729,345,156,236,198,646,586,178,865,962,1006,958,600,359,929,416,298,789,807,1288,599,825,608,761,867,842,398,817,820,365,787,896,837,959,1135,613,912,870,391,835,764,647,1276,1156,1097,498,300,513,419,905,468,302,260,841,780,864,816,877,812,1360,925,1029,635,697,923,922,622,627,464,601,562,464,576,642,349,461,219,483,327,793,775,120,449,554,998,822,622,601,361,538,461,464,908,240,89,162,775,116,219);
                    
                     $catunavail=array('61','45','70','101','151_89_171','152_179_189','151_105_25_70');
         
                     if(in_array($this->request->get['product_id'], $produnavailarr) )
		                {
		                    $this->request->get['route']='common/home/page410';
		                }  
		            if(in_array($this->request->get['path'], $catunavail) )
		                {
		                    $this->request->get['route']='common/home/page410';
		                }   

		                if($this->request->get['_route_']=='american-tourister-travel-bags-online/at-buzz-14-brn/yel-brown-back-pack' || $this->request->get['_route_']=='men/adidas-base-mid-dd-white-tee' || $this->request->get['_route_']=='women/adidas-ten-wb-l-2-multi-color---wristband' || $this->request->get['_route_']=='men/accessories/adidas-clmlt-6p-3soff-pink-cap' || $this->request->get['_route_']=='women/clothing/track-pants/reebok-wor-pp-grey-tights' || $this->request->get['_route_']=='men/reebok-os-kn-dark-grey-trackster' || $this->request->get['_route_']=='men/shoes/sports/basketball-shoes/adidas-cross-em3-grey-basketball-shoes' || $this->request->get['_route_']=='MEN/ADIDAS/Adidas-Ace-16-4-Fxg-p1103c151' || $this->request->get['_route_']=='reebok-shoes-online/reebok-os-grph-multi-color-1shortb' || $this->request->get['_route_']=='men/clothing/shorts/reebok-os-grph-multi-color-1shortb' || $this->request->get['_route_']=='men/shoes/running-shoes/nike-relentless-4-msl-grey-running-shoes' || $this->request->get['_route_']=='men/shoes/running-shoes/nike-revolve-gry-running-shoes' || $this->request->get['_route_']=='MEN/ADIDAS/Adidas-Andorian-Navy-Blue-Outdoor-Shoes-p1131c151' || $this->request->get['_route_']=='men/reebok-zquick-dash-city-navy-blue-training-shoes' ||  $this->request->get['_route_']=='MEN/ADIDAS/Adidas-Andorian-Navy-Blue-Outdoor-Shoes-p1131c151' ||  $this->request->get['_route_']=='MEN/ADIDAS/Adidas-X-15-4-FXG-Green-Football-Shoes-p765c151'){$this->request->get['route']='common/home/page410';} 

            if(isset($this->request->get['term'])){ if($this->request->get['term']=='R53043006') {$this->request->get['route']='common/home/page410'; }
            }

              if(isset($parts[0])){   
                     
                     if($parts[0]=='adidas-yago-m-black-running-shoes' || $parts[0]=='adidas-hellion-m-black-running-shoe' || $parts[0]=='reebok-os-el-green-back-pack' || $parts[0]=='at-code-14-grey-back-pack' || $parts[0]=='at-citi-pro-13-pur-purple-back-pack' || $parts[0]=='adidas-w-ap-blue-tee' || $parts[0]=='adidas-response-black-tee' || $parts[0] == 'reebok-zig-squared-rush-black-running-shoes' || $parts[0] == 'reebok-zcut-tr-black-running-shoes' || $parts[0] =='adidas-ess-standford-b-black-track-pant' || $parts[0]=='adidas-ess-standford-b-navy-blue-track-pant' || $parts[0] =='fila-smash-lite-black-running-shoes'|| $parts[0]=='adidas-poly-solar-gold-bottle-0.7-' || $parts[0]=='adidas-poly-black-bottle-0.7-' || $parts[0]=='adidas-poly-pink-bottle-0.7-' || $parts[0]=='adidas-ten-black-headband' || $parts[0]=='adidas-lin-per-royal-blue-wallet' || $parts[0]=='adidas-3s-per-navy-blue-wallet' || $parts[0]=='adidas-3s-ess-black-wallet' || $parts[0]=='reebok-rcf-triblend-1-olive-tees' || $parts[0] == 'reebok-rcf-triblend-1-pink-tees' || $parts[0]=='reebok-os-ss-comp-a-blue-jersey' || $parts[0]=='reebok-se-core-knit-navy-blue-track-pants' || $parts[0]=='reebok-se-pp-fit-bt-black-track-pant' || $parts[0]=='adidas-sq-cc-run-black-short-m' || $parts[0]=='adidas-ess-chelsea-white-shorts' || $parts[0]=='adidas-lite-pacer-3-m-green-running-shoe' || $parts[0]=='adidas-sonic-rally-white-tennis-shoes' || $parts[0]=='adidas-argo-w-navy-blue-sandal' || $parts[0]=='adidas-tf-base-ss-white-tee' || $parts[0]=='adidas-resp-trad-black-polo' ||$parts[0]=='reebok-os-knit-black-tee' || $parts[0]=='reebok-wor-95-yellow-tee' || $parts[0]=='reebok-wor-95-green-tee' || $parts[0]=='reebok-os-knit-dark-grey-trkstr' || $parts[0]=='reebok-wor-knit-navy-blue-track-pant' || $parts[0]=='adidas-adwen-multi-color-sandal' || $parts[0]=='adidas-eezay-gr-grey-flip-flop' || $parts[0]=='puma-woody-dp-navy-blue-sandal' || $parts[0]=='adidas-eezay-gr-blue-flip-flop' || $parts[0]=='reebok-zquick-tr-4.0-grey-training-shoes' || $parts[0]=='adidas-ess-yd-black-polo' ||  $parts[0]=='adidas-base-wv-black-short' || $parts[0]=='adidas-base-wv-navy-blue-short' || $parts[0]=='adidas-ess-3s-wv-navy-blue-pant' || $parts[0]=='adidas-ess-3s-wv-grey-pant' || $parts[0]=='puma-atom-fashion-dp-black-running-shoe' || $parts[0]=='adidas-resp-trad-red-polo' || $parts[0]=='reebok-re-ss-solar-yellow-tees' || $parts[0]=='reebok-re-ss-black-tees' || $parts[0]=='reebok-train-conquer-white-tee' || $parts[0]=='reebok-train-conquer-black-tee' || $parts[0]=='reebok-re-ss-black-tees' || $parts[0]=='reebok-se-pp-fit-bt-royal-orchid-track-pant' || $parts[0]=='reebok-se-pd-core-dark-pink-tee' || $parts[0]=='reebok-se-pd-core-black-tee' || $parts[0]=='reebok-se-pd-core-vital-green-tee' || $parts[0]=='reebok-wor-knit-black-track-pant' || $parts[0]=='reebok-os-gr-knit-black-shorts' || $parts[0]=='reebok-os-knit-black-trkstr' || $parts[0]=='reebok-os-adv-wvn-indigo-track-pant-' || $parts[0]=='reebok-wor-camo-b-olive-short' || $parts[0]=='reebok-wor-camo-b-blue-short' || $parts[0]=='adidas-lite-runner-m-black-running-shoe' || $parts[0]=='adidas-lite-runner-m-oliver-running-shoe' || $parts[0]=='adidas-sq-cc-run-black-short-m' || $parts[0]=='adidas-aron-1.0-navy-blue-sandal' || $parts[0]=='reebok-electrify-speed-black-running-shoes' || $parts[0]=='reebok-cf-ls-midwt-com-brown-tee' || $parts[0]=='reebok-el-woven-oh-navy-blue-track-pant' || $parts[0]=='reebok-el-woven-oh-grphite-track-pant' || $parts[0]=='reebok-el-woven-oh-blacktrack-pant' || $parts[0]=='reebok-ms-cor-black-jacket' || $parts[0]=='reebok-ms-cor-yellow-jacket' || $parts[0]=='adidas-aril-dark-blue-flip-flop' || $parts[0]=='adidas-aril-red-flip-flop' || $parts[0]=='reebok-fury-road-black-running-shos' || $parts[0]=='adidas-m-clima-purple-polo' || $parts[0]=='adidas-m-clima-black-polo' || $parts[0]=='adidas-ace-15.4-fxg-green-football-shoes' || $parts[0]=='adidas-ace-15.4-fxg-green-football-shoes' || $parts[0]=='adidas-ace-15.4-fxg-green-football-shoes' || $parts[0]=='adidas-ace-15.4-fxg-green-football-shoes' || $parts[0]=='Adidas-Storm-Raiser-1-0' || $parts[0]=='adidas-ais-prime-pink-tee' || $parts[0]=='adidas-x-15.4-fxg-green-football-shoes' || $parts[0]=='reebok-quick-win-black-running-shoes' || $parts[0]=='reebok-sublite-authentic-2.0-red-running-shoes' || $parts[0]=='reebok-electrify-speed-black-running-shoes' || $parts[0]=='reebok-sublite-authentic-2.0-mtm-grey-running-shoes' || $parts[0]=='reebok-electrify-speed-blue-running-shoes' || $parts[0]=='reebok-sublite-authentic-2.0-grey-running-shoes' || $parts[0]=='reebok-electro-run-red-running-shoes' || $parts[0]=='reebok-sublite-authentic-2.0-mtm-black-running-shoesreebok-jet-dashride-2.0-black-running-shoes' || $parts[0]=='reebok-zjet-burst-black-running-shoes' || $parts[0]=='reebok-twisform-gr-grey-running-shoes' || $parts[0]=='reebok-twisform-city-black-running-shoes' || $parts[0]=='reebok-tempo-speedster-black-running-shoes' || $parts[0]=='reebok-sublite-super-duo-navy-blue-running-shoe' || $parts[0]=='reebok-sublite-super-duo-gr-olive-running-shoe' || $parts[0]=='reebok-sublite-super-duo-gr-black-running-shoes' || $parts[0]=='reebok-advent-ii-black-flip-flops' || $parts[0]=='reebok-advent-ii-lp-black-flip-flops' || $parts[0]=='reebok-adventure-chrome-navy-blue-sandals' || $parts[0]=='reebok-adventure-serpant-black-sandal' || $parts[0]=='reebok-cardio-low-black-shoes' || $parts[0]=='reebok-cardio-low-grey-shoes' || $parts[0]=='reebok-cardio-ultra-green-cardio-shoes' || $parts[0]=='reebok-sublite-dual-dash-pink-running-shoes' || $parts[0]=='reebok-sublite-authentic-2.0-black-running-shoes' || $parts[0]=='reebok-duo-runner-blue-running-shoe' || $parts[0]=='reebok-sublite-super-duo-2.0-black-womens-running-shoes' || $parts[0]=='reebok-electrify-speed-blue-running-shoes1' || $parts[0]=='reebok-electrify-speed-grey-running-shoes9' || $parts[0]=='reebok-workout-ready-green-tech-t-shirts' || $parts[0]=='reebok-wor-grph-supremium-red-tees' || $parts[0]=='reebok-wor-grph-supremium-blue-tees' || $parts[0]=='reebok-wor-grph-supremium-black-tees' || $parts[0]=='reebok-se-core-knit-navy-blue-track-pant' || $parts[0]=='reebok-os-pw3r-ls-comp-green-tshirts' || $parts[0]=='reebok-os-adv-wvn-black-track-pant' || $parts[0]=='reebok-os-wv-dark-grey-trackster' || $parts[0]=='reebok-re-5-inch-black-shorts' || $parts[0]=='reebok-re-3-inch-yellow-shorts' || $parts[0]=='reebok-el-woven-grey-short' || $parts[0]=='reebok-se-pp-tight-black-track-pants' || $parts[0]=='reebok-one-distance-grey-running-shoes' || $parts[0]=='reebok-elsft-ply-shrt-black-sports-shorts' || $parts[0]=='reebok-elsft-ply-shrt-navy-blue-crossfit-shorts' || $parts[0]=='reebok-elsft-ply-shrt-grey-running-shorts' || $parts[0]=='nike-downshifter-6-msl-grey-running-shoes' || $parts[0]=='nike-chroma-thong-5-navy-blue-flip-flops' || $parts[0]=='fila-rock-in-black-sneakers' || $parts[0]=='fila-luna-plus-3-black-sneakers' || $parts[0]=='reebok-adventure-navy-blue-flip-flops' || $parts[0]=='reebok-adventure-black-flip-flops' || $parts[0]=='reebok-twistform-3.0-dark-grey-running-shoes' || $parts[0]=='reebok-electro-run-grey-running-shoes' || $parts[0]=='reebok-acciomax-6.0-white-running-shoes' || $parts[0]=='adidas-jaso-stripe-m-green-flip-flops' || $parts[0]=='adidas-ace-15.4-fxg-orange-football-shoes' || $parts[0]=='reebok-sublite-super-duo-2.0-brown-running-shoes' || $parts[0]=='reebok-sublite-dual-dash-blue-running-shoes' || $parts[0]=='reebok-sport-flip-multi-color-flip-flops' || $parts[0]=='reebok-realflex-train-4.0-grey-training-shoes' || $parts[0]=='reebok-realflex-train-4.0-black-training-shoes' || $parts[0]=='adidas-ryzo-3.0-m-grey-running-shoes' || $parts[0]=='adidas-merrick-white-tennis-shoes' || $parts[0]=='adidas-merrick-tennis-grey-shoes' || $parts[0]=='adidas-jaso-stripe-m-red-flip-flops' || $parts[0]=='adidas-torus-in-white-tennis-shoes' || $parts[0]=='adidas-storm-raiser-2-black-outdoor-shoes' || $parts[0]=='adidas-marlin-6.0-m-black-running-shoes' || $parts[0]=='adidas-hewis-black-sandals' || $parts[0]=='adidas-marengo-grey-sandal' || $parts[0]=='adidas-galactus-silver-running-shoes' || $parts[0]=='adidas-galactus-m-grey-running-shoes' || $parts[0]=='adidas-energy-bounce-2-navy-blue-running-shoes' || $parts[0]=='adidas-energy-bounce-2-black-running-shoes' || $parts[0]=='adidas-durok-20-blue-flip-flops' || $parts[0]=='adidas-all-rounder-power-white-cricket-shoes' || $parts[0]=='reebok-hexaffect-run-3.0-grey-running-shoes' || $parts[0]=='reebok-hexaffect-run-3.0-black-running-shoes' || $parts[0]=='adidas-all-rounder-power-1-white-cricket-shoes' || $parts[0]=='reebok-sublite-authentic-2.0-grey-running-shoes' || $parts[0]=='adidas-messi-15.4--fxg-black-football-shoes' || $parts[0]=='adidas-galaxy-elite-men\'s-grey-running-shoes' || $parts[0]=='adidas-ax2-black-outdoor-shoes' || $parts[0]=='adidas-andorian-navy-blue-outdoor-shoes' || $parts[0]=='adidas-adiray-m-silver-running-shoes' || $parts[0]=='adidas-adipure-cf-blue-flip-flops' || $parts[0]=='reebok-quantum-tr-grey-training-shoes' || $parts[0]=='reebok-quantum-tr-black-training-shoes' || $parts[0]=='reebok-everchill-train-black-training-shoes' || $parts[0]=='woodland-olive-casual-shoes' || $parts[0]=='woodland-khaki-lace-outdoor-shoe' || $parts[0]=='woodland-khaki-casual-shoes' || $parts[0]=='woodland-olive-outdoor-shoes' || $parts[0]=='reebok-zquick-lite-navy-blue-running-shoes' || $parts[0]=='reebok-zpump-fusion-2.0-black-running-shoes' || $parts[0]=='reebok-zprint-train-black-training-shoes' || $parts[0]=='reebok-ultra-flex-navy-blue-sandals' || $parts[0]=='reebok-ultra-flex-black-sandals' || $parts[0]=='reebok-train-fast-xt-grey-running-shoe' || $parts[0]=='reebok-train-fast-xt-blue-running-shoe' || $parts[0]=='nike-wild-trail-black-running-shoes' || $parts[0]=='nike-the-air-overplay-ix-black-basketball-shoes' || $parts[0]=='nike-revolve-black-running-shoes' || $parts[0]=='nike-matira-thong-grey-flip-flops' || $parts[0]=='nike-matira-thong-blue-flip-flops' || $parts[0]=='nike-lite-force-iii-grey-running-shoes' || $parts[0]=='nike-lite-force-iii-grey-casual-shoes' || $parts[0]=='nike-emerge-blue-running-shoes' || $parts[0]=='nike-dart-12-msl-black-running-shoes' || $parts[0]=='nike-dart-11-msl-navy-blue-running-shoes' || $parts[0]=='nike-dart-10-msl-running-shoes' || $parts[0]=='nike-dart-10-gry-running-shoes' || $parts[0]=='nike-cp-trainer-gry-running-shoes' || $parts[0]=='nike-cp-trainer-blu-running-shoes' || $parts[0]=='nike-chroma-thong-black-flip-flops' || $parts[0]=='lee-cooper-brown-lace-formal-shoe' || $parts[0]=='lee-cooper-black-lace-formal-shoes' || $parts[0]=='lee-cooper-black-formal-shoes' || $parts[0]=='adidas-marengo-navy-blue-sandal' || $parts[0]=='adidas-elevate-grey-sandal' || $parts[0]=='fila-lara-ii-black-running-shoes' || $parts[0]=='fila-dove-iii-grey-running-shoes' || $parts[0]=='reebok-ultra-speed-blue-running-shoes' || $parts[0]=='reebok-tempo-speedster-womens-black-running-shoes' || $parts[0]=='reebok-twistform-blaze-2.0-mtm-navy-blue-running-shoes' || $parts[0]=='reebok-ultra-speed-grey-running-shoes' || $parts[0]=='reebok-ultra-speed-black-running-shoes' || $parts[0]=='reebok-ultra-flex-navy-blue-sandals' || $parts[0]=='reebok-ultra-flex-black-sandals' || $parts[0]=='reebok-skyscape-viva-multi-color-casual-shoes' || $parts[0]=='reebok-skyscape-viva-grey-casual-shoes' || $parts[0]=='reebok-skyscape-revolution-black-casual-shoes' || $parts[0]=='reebok-hayasu-dancing-blue-sneakers' || $parts[0]=='reebok-hayasu-black-dance-shoes' || $parts[0]=='reebok-cardio-workout-low-rs-cardio-shoes' || $parts[0]=='nike-emerge-wns-running-shoes'){$this->request->get['route']='common/home/page410';} } 
			       
			             if($this->request->get['idcat'] == '151_153')
                        {
                           $this->request->get['route']='common/home/page410';
                        }  
						
						if (isset($this->request->get['route'])) {
							//echo $this->request->get['route']; die;
							return $this->forward($this->request->get['route']); 
						}
		}
 
                 $produnavailarr = array(903,316,261,1133,393,415,710,968,879,818,417,893,814,951,779,1061,868,1361,855,1289,553,1148,61,809,406,1203,866,823,308,1031,770,819,928,1036,838,1014,671,229,109,904,238,952,801,466,907,227,728,462,619,675,843,685,736,557,573,225,216,438,668,570,630,217,756,640,821,263,167, 664,626,446,687,730,233,524,173,483,305,585,593,698,401,693,362,93,580,564,637,57,276,325,1001,73,35,711,744,727,702,677,44,442,936,80,692,954,655,380,906,373,508,749,955,41,543,447,480,745,754,769,645,206,683,454,58,259,274,377,207,676,441,213,228,684,469,94,84,509,395,542,243,278,194,390,471,144,729,345,156,236,198,646,586,178,865,962,1006,958,600,359,929,416,298,789,807,1288,599,825,608,761,867,842,398,817,820,365,787,896,837,959,1135,613,912,870,391,835,764,647,1276,1156,1097,498,300,513,419,905,468,302,260,841,780,864,816,877,812,1360,925,1029,635,697,923,922,622,627,464,601,562,464,576,642,349,461,219,483,327,793,775,120,449,554,998,822,622,601,361,538,461,464,908,240,89,162,775,116,219);
         
                    if(in_array($this->request->get['product_id'], $produnavailarr) )
                     {
                    	$this->request->get['route']='common/home/page410';
                   		return $this->forward($this->request->get['route']);
                 	 } 

                    $catunavail=array('61','45','70','101','151_89_171','152_179_189','151_105_25_70');

                    if(in_array($this->request->get['path'], $catunavail) )
                     {
                      	$this->request->get['route']='common/home/page410';
                      	return $this->forward($this->request->get['route']);
                 	 }


         
	}
	
	public function rewrite($link) {  
		
		$url_info = parse_url(str_replace('&amp;', '&', $link));
		 
		$url = ''; 
		
		$data = array();
		
		parse_str($url_info['query'], $data);
		
		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
				
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword'];
						
						unset($data[$key]);
					}					
				} elseif ($key == 'path') {
					$categories = explode('_', $value);
					
					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");
				
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
						}							
					}
					
					unset($data[$key]);
				}
				
				/* SEO Custom URL */
                if( $_u = $this->getURL($data['route']) ){
                	$url .= $_u;
                    unset($data[$key]);
                }/* SEO Custom URL */ 
			}
		}
	
		if ($url) {
			$url = strtolower($url);
			unset($data['route']);
		
			$query = '';
		
			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . $key . '=' . $value;
				}
				
				if ($query) {
					$query = '?' . trim($query, '&');
				}
			}

			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			$link = strtolower($link);
			return $link;
		}
	}	

	/* SEO Custom URL */
    public function getURL($route) {
    	
            if( count($this->url_list) > 0) {
                 foreach ($this->url_list as $key => $value) {

                    if($route == $key) {

                        return '/'.$value;
                    }
                 }
            }
            return false; 
    }  
    public function setURL($_route) {

            if( count($this->url_list) > 0 ){
                 foreach ($this->url_list as $key => $value) {
                    if($_route == $value) {
                        return $key;
                    }
                 }
            }
            return false;
    }/* SEO Custom URL */
}
?>