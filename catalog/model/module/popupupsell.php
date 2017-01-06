<?php
class ModelModulePopupUpsell extends Model {
  	public function getSetting($group, $store_id) {
    	$data = array(); 
    	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
    	foreach ($query->rows as $result) {
      		if (!$result['serialized']) {
        		$data[$result['key']] = $result['value'];
      		} else {
        		$data[$result['key']] = unserialize($result['value']);
      		}
    	} 
    	return $data;
  	}

    public function getUpsells() {
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "upsell_offers`");

    return $query->rows;
  }

  public function getUpsellproductids($upsellid)//get upsell product ids
  {
    
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "upsell_offers` where upsell_id=$upsellid");

    return $query->rows;
  }

  public function getproductidsforcategory($categoryid)
  {
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_to_category` where category_id=$categoryid");

    return $query->rows;
  }

}
?>