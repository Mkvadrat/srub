<?php
class ModelExtensionPartners extends Model {	
	public function getPartners($partners_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "partners n LEFT JOIN " . DB_PREFIX . "partners_description nd ON n.partners_id = nd.partners_id WHERE n.partners_id = '" . (int)$partners_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
 
	public function getAllPartners($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "partners n LEFT JOIN " . DB_PREFIX . "partners_description nd ON n.partners_id = nd.partners_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' ORDER BY date_added DESC";
		
		if (isset($data['start']) && isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			
			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getModulePartners($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "partners n LEFT JOIN " . DB_PREFIX . "partners_description nd ON n.partners_id = nd.partners_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n.module = '1' ORDER BY date_added DESC";
		
		if (isset($data['start']) && isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			
			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getTotalPartners() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "partners WHERE status = '1'");
	
		return $query->row['total'];
	}
}