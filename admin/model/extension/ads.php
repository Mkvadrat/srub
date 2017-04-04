<?php
class ModelExtensionAds extends Model {
	public function addAds($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "ads SET image = '" . $this->db->escape($data['image']) . "', date_added = NOW(), status = '" . (int)$data['status'] . "'");
		
		$ads_id = $this->db->getLastId();
		
		foreach ($data['ads'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX ."ads_description SET ads_id = '" . (int)$ads_id . "', language_id = '" . (int)$key . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', short_description = '" . $this->db->escape($value['short_description']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'ads_id=" . (int)$ads_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
	
	public function editAds($ads_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "ads SET image = '" . $this->db->escape($data['image']) . "', status = '" . (int)$data['status'] . "' WHERE ads_id = '" . (int)$ads_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "ads_description WHERE ads_id = '" . (int)$ads_id. "'");
		
		foreach ($data['ads'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX ."ads_description SET ads_id = '" . (int)$ads_id . "', language_id = '" . (int)$key . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', short_description = '" . $this->db->escape($value['short_description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'ads_id=" . (int)$ads_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'ads_id=" . (int)$ads_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
	
	public function getAds($ads_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'ads_id=" . (int)$ads_id . "') AS keyword FROM " . DB_PREFIX . "ads WHERE ads_id = '" . (int)$ads_id . "'"); 
 
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
   
	public function getAdsDescription($ads_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ads_description WHERE ads_id = '" . (int)$ads_id . "'"); 
		
		foreach ($query->rows as $result) {
			$ads_description[$result['language_id']] = array(
				'title'       			=> $result['title'],
				'short_description'		=> $result['short_description'],
				'description' 			=> $result['description']
			);
		}
		
		return $ads_description;
	}
 
	public function getAllAds($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "ads n LEFT JOIN " . DB_PREFIX . "ads_description nd ON n.ads_id = nd.ads_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY date_added DESC";
		
		if (isset($data['start']) && isset($data['limit'])) {
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
   
	public function deleteAds($ads_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ads WHERE ads_id = '" . (int)$ads_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ads_description WHERE ads_id = '" . (int)$ads_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'ads_id=" . (int)$ads_id. "'");
	}
   
	public function getTotalAds() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ads");
	
		return $query->row['total'];
	}
	public function setModule($ads_id, $value){
		$this->db->query("UPDATE " . DB_PREFIX . "ads SET module = '" . (int)$value . "' WHERE ads_id = '" . (int)$ads_id . "'"); 
	}
}