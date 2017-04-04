<?php
class ModelExtensionImportant extends Model {	
	public function getImportant($important_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "important n LEFT JOIN " . DB_PREFIX . "important_description nd ON n.important_id = nd.important_id WHERE n.important_id = '" . (int)$important_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
 
	public function getAllImportant($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "important n LEFT JOIN " . DB_PREFIX . "important_description nd ON n.important_id = nd.important_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' ORDER BY date_added DESC";
		
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

	public function getModuleImportant($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "important n LEFT JOIN " . DB_PREFIX . "important_description nd ON n.important_id = nd.important_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n.module = '1' ORDER BY date_added DESC";
		
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
	
	public function getTotalImportant() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "important");
	
		return $query->row['total'];
	}
}