<?php  
class ControllerInformationSitemap extends Controller {
	public function index() {
    	$this->language->load('information/sitemap');
 
		$this->document->setTitle($this->language->get('heading_title')); 

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/sitemap'),      	
        	'separator' => $this->language->get('text_separator')
      	);	
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_special'] = $this->language->get('text_special');
		$this->data['text_account'] = $this->language->get('text_account');
    	$this->data['text_edit'] = $this->language->get('text_edit');
    	$this->data['text_password'] = $this->language->get('text_password');
    	$this->data['text_address'] = $this->language->get('text_address');
    	$this->data['text_history'] = $this->language->get('text_history');
    	$this->data['text_download'] = $this->language->get('text_download');
    	$this->data['text_cart'] = $this->language->get('text_cart');
    	$this->data['text_checkout'] = $this->language->get('text_checkout');
    	$this->data['text_search'] = $this->language->get('text_search');
    	$this->data['text_information'] = $this->language->get('text_information');
    	$this->data['text_contact'] = $this->language->get('text_contact');
			
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

	/*	$this->data['categories'] = array();
					
		$categories = $this->model_catalog_category->getCategories(0);

		
		foreach ($categories as $category) {
				echo '<pre>';
		print_r($category);
		echo '</pre>';
		die;
			if ($category['top']) {
				// Level 2

			
				$children_data = array();
				
				$children = $this->model_catalog_category->getCategories($category['category_id']);
				
				foreach ($children as $child) {
					$data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);
					
					$product_total = $this->model_catalog_product->getTotalProducts($data);
									
					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);						
				}
				
				// Level 1
				$this->data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		echo '<pre>';
		print_r($children_data);
		echo '</pre>';
		die; */



		
		$this->data['categories'] = array();

		$this->data['firstrow']=array();
					
		$categories_1 = $this->model_catalog_category->getCategories(0);

		
		
		foreach ($categories_1 as $category_1) {
			$level_2_data = array();
			
			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);
			
			foreach ($categories_2 as $category_2) {
				$level_3_data = array();
				
				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);
				
				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'name' => $category_3['name'],
						'href' => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id'])
					);
				}
				
				$level_2_data[] = array(
					'name'     => $category_2['name'],
					'children' => $level_3_data,
					'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'])	
				);					
			}
			
			$this->data['categories'][] = array(
				'name'     => $category_1['name'],
				'children' => $level_2_data,
				'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'])
			);
		}



		/*foreach ($this->data['categories'] as $data1) {
			if($data1['name']=='MEN')
			{
				array_push($this->data['firstrow'], $this->data['categories']);
			}
			elseif ($data1['name']=='WOMEN') {
				array_push($this->data['firstrow'], $this->data['categories']);
			}
			elseif ($data1['name']=='KIDS') {
				array_push($this->data['firstrow'], $this->data['categories']);
			}
		}*/

		

		
		 $this->moveElement($this->data['categories'], 7, 0);		

		 $this->moveElement($this->data['categories'], 9, 1);

		$this->moveElement($this->data['categories'], 5, 2);

		$this->moveElement($this->data['categories'], 4, 3);



		  /*echo '<pre>';
		print_r($this->data['categories']);
		echo '</pre>';
		die; */

		
		
		$this->data['special'] = $this->url->link('product/special');
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
    	$this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
    	$this->data['password'] = $this->url->link('account/password', '', 'SSL');
    	$this->data['address'] = $this->url->link('account/address', '', 'SSL');
    	$this->data['history'] = $this->url->link('account/order', '', 'SSL');
    	$this->data['download'] = $this->url->link('account/download', '', 'SSL');
    	$this->data['cart'] = $this->url->link('checkout/cart');
    	$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
    	$this->data['search'] = $this->url->link('product/search');
    	$this->data['contact'] = $this->url->link('information/contact');
		
		$this->load->model('catalog/information');
		
		$this->data['informations'] = array();
    	
		foreach ($this->model_catalog_information->getInformations() as $result) {
      		$this->data['informations'][] = array(
        		'title' => $result['title'],
        		'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id']) 
      		);
    	}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/sitemap.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/sitemap.tpl';
		} else {
			$this->template = 'default/template/information/sitemap.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
				
 		$this->response->setOutput($this->render());		
	}

	public function moveElement(&$array, $a, $b) {
   $out = array_splice($array, $a, 1);
   array_splice($array, $b, 0, $out);
	}
}
?>