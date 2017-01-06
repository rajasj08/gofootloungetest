<?php
class ModelSalepurchasevoucher extends Model
{
	 private function check_db(){    
	    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "voucher_pending` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `customer_email` varchar(225) NOT NULL,
  `customer_name` varchar(225) NOT NULL,
  `order_currency_code` varchar(225) NOT NULL,
  `order_currency_value` varchar(225) NOT NULL,
  `storename` varchar(10) NOT NULL,
  `storelogo` varchar(255) NOT NULL,
  `storeurl` varchar(255) NOT NULL,
  `order_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `configemail` varchar(225) NOT NULL,
  `vemail` varchar(225) NOT NULL,
  `vname` varchar(225) NOT NULL,

  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;");

   }

    public function getOrders($data = array())
    {
		$table = DB_PREFIX . "order_voucher";
		$query = $this->db->query("SHOW TABLES LIKE '".$table."'");
		if($query->num_rows == 0)
			$this->check_db();
		
		
		
        $sql = "SELECT * FROM " . DB_PREFIX . "order_voucher as od WHERE 1";

		

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND od.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

	
		
		if (!empty($data['filter_code'])) {
			$sql .= " AND od.code LIKE '%" . $data['filter_code'] . "%'";
		}
	
		if (!empty($data['filter_to_email'])) {
			$sql .= " AND od.to_email = '" . $data['filter_to_email'] . "'";
		}
	
		$sort_data = array(
			'od.order_id',
			'od.title',
			'od.code',
		
			'od.to_email',
			
	
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY od.order_voucher_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

        $query = $this->db->query($sql);

        return $query->rows;
    }

	public function pendingvouchers($data){
		
		$sql = "SELECT *,(SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = dp.order_status_id AND os.language_id = dp.language_id) AS order_status FROM " . DB_PREFIX . "voucher_pending as dp";
		
		if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {
			$sql .= " WHERE dp.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE dp.order_status_id > '0'";
		}
		
		if (!empty($data['filter_order_id'])) {
			$sql .= " AND dp.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer_name'])) {
			$sql .= " AND dp.customer_name LIKE '%" . $this->db->escape($data['filter_customer_name']) . "%'";
		}

		
		if (!empty($data['filter_customer_email'])) {
			$sql .= " AND dp.customer_email = '" . $this->db->escape($data['filter_customer_email']) . "'";
		}
			if (!empty($data['filter_storename'])) {
			$sql .= " AND dp.storename = '" . $data['filter_storename'] . "'";
		}
		
	
		$sort_data = array(
			'dp.order_id',
			'dp.customer_name',
			'dp.customer_email',
			'dp.order_status_id',
			'dp.storename',
			
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY dp.id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
}

?>