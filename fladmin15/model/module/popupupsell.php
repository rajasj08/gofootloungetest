<?php 
class ModelModulePopupUpsell extends Model {

  	public function getSetting($group, $store_id = 0) {
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
  
  	public function editSetting($group, $data, $store_id = 0) {
	    $this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
	    foreach ($data as $key => $value) {
	      if (!is_array($value)) {
	        $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
	      } else {
	        $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
	      }
	    }
	}

	public function addUpsell($data) {
		$content = serialize(array_map(array($this, "sanitizeData"), $data['content']));
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "upsell_offers` SET name='" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', method = '" . (int)$data['method'] . "', product_ids = '" . $this->db->escape($data['product_ids']) . "', category_ids = '" . $this->db->escape($data['category_ids']) . "', width = '" . (int)$data['width'] . "', height = '" . (int)$data['height'] . "', image_width = '" . (int)$data['image_width'] . "', image_height = '" . (int)$data['image_height'] . "', `content` = '" . $this->db->escape($content) . "'"); 
	}

	private function sanitizeData($data) {
		return trim(preg_replace('/\s+/', ' ', $data));
	}

	public function getUpsells() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "upsell_offers`");
		
		return $query->rows;
	}

	public function getUpsell($upsell_id) {
		
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "upsell_offers` WHERE upsell_id=".(int)$upsell_id);
		
		return $query->row;
	}

	public function editUpsell($upsell_id, $data) {
		$content = serialize(array_map(array($this, "sanitizeData"), $data['content']));
		$query = $this->db->query("UPDATE `" . DB_PREFIX . "upsell_offers` SET name='" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "', method = '" . (int)$data['method'] . "', product_ids = '" . $this->db->escape($data['product_ids']) . "', category_ids = '" . $this->db->escape($data['category_ids']) . "', width = '" . (int)$data['width'] . "', height = '" . (int)$data['height'] . "', image_width = '" . (int)$data['image_width'] . "', image_height = '" . (int)$data['image_height'] . "', `content` = '" . $this->db->escape($content) . "' WHERE upsell_id = ".(int)$upsell_id);
	}

	public function deleteUpsell($id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "upsell_offers` WHERE upsell_id='" . (int)$id . "'");
	}
	
  	public function install($moduleName) {
	  $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "upsell_offers` (
		`upsell_id` int(11) NOT NULL AUTO_INCREMENT,
		`name` VARCHAR(255) NOT NULL DEFAULT '',
		`status` tinyint(1) NOT NULL DEFAULT '0',
		`method` tinyint(1) NOT NULL DEFAULT '0',
		`product_ids` text NOT NULL DEFAULT '',
		`category_ids` text NOT NULL DEFAULT '',
		`content` text NOT NULL DEFAULT '',
		`width` smallint(6) NOT NULL DEFAULT '0',
		`height` smallint(6) NOT NULL DEFAULT '0',
		`image_width` smallint(6) NOT NULL DEFAULT '0',
		`image_height` smallint(6) NOT NULL DEFAULT '0',
		PRIMARY KEY (`upsell_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

		/*$this->load->model('design/layout');
		$layouts = array();
		$layouts = $this->model_design_layout->getLayouts();
			
		foreach ($layouts as $layout) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module 
				SET layout_id = '" . (int)$layout['layout_id'] . "', code = '" . $this->db->escape($moduleName) . "', position = '" . 
				$this->db->escape('content_bottom') . "', sort_order = '0'");
			$this->event->trigger('post.admin.edit.layout', $layout['id']);
		}*/
  	} 
  
  	public function uninstall($moduleName) {
  		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "upsell_offers`");
		/*$this->load->model('design/layout');
		$layouts = array();
		$layouts = $this->model_design_layout->getLayouts();
			
		foreach ($layouts as $layout) {
			$this->db->query("DELETE FROM " . DB_PREFIX . 
				"layout_module 
				WHERE layout_id = '" . (int)$layout['layout_id'] . "' and  
				code = '" . $this->db->escape($moduleName)."'");
		}*/
  	}
	
  }
?>