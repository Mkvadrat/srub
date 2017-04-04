<?php
class ModelExtensionAds extends Model {	
	public function getAds($ads_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ads n LEFT JOIN " . DB_PREFIX . "ads_description nd ON n.ads_id = nd.ads_id WHERE n.ads_id = '" . (int)$ads_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
 
	public function getAllAds($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "ads n LEFT JOIN " . DB_PREFIX . "ads_description nd ON n.ads_id = nd.ads_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' ORDER BY date_added DESC";
		
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

	public function getModuleAds($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "ads n LEFT JOIN " . DB_PREFIX . "ads_description nd ON n.ads_id = nd.ads_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n.module = '1' ORDER BY date_added DESC";
		
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
	
	public function getTotalAds() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ads WHERE status = '1'");
	
		return $query->row['total'];
	}
}