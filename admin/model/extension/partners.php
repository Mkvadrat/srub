<?php
class ModelExtensionPartners extends Model {
	public function addPartners($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "partners SET image = '" . $this->db->escape($data['image']) . "', date_added = NOW(), status = '" . (int)$data['status'] . "'");
		
		$partners_id = $this->db->getLastId();
		
		foreach ($data['partners'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX ."partners_description SET partners_id = '" . (int)$partners_id . "', language_id = '" . (int)$key . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', short_description = '" . $this->db->escape($value['short_description']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'partners_id=" . (int)$partners_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
	
	public function editPartners($partners_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "partners SET image = '" . $this->db->escape($data['image']) . "', status = '" . (int)$data['status'] . "' WHERE partners_id = '" . (int)$partners_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "partners_description WHERE partners_id = '" . (int)$partners_id. "'");
		
		foreach ($data['partners'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX ."partners_description SET partners_id = '" . (int)$partners_id . "', language_id = '" . (int)$key . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', short_description = '" . $this->db->escape($value['short_description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'partners_id=" . (int)$partners_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'partners_id=" . (int)$partners_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
	
	public function getPartners($partners_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'partners_id=" . (int)$partners_id . "') AS keyword FROM " . DB_PREFIX . "partners WHERE partners_id = '" . (int)$partners_id . "'"); 
 
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
   
	public function getPartnersDescription($partners_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "partners_description WHERE partners_id = '" . (int)$partners_id . "'"); 
		
		foreach ($query->rows as $result) {
			$partners_description[$result['language_id']] = array(
				'title'       			=> $result['title'],
				'short_description'		=> $result['short_description'],
				'description' 			=> $result['description']
			);
		}
		
		return $partners_description;
	}
 
	public function getAllPartners($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "partners n LEFT JOIN " . DB_PREFIX . "partners_description nd ON n.partners_id = nd.partners_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY date_added DESC";
		
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
   
	public function deletePartners($partners_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "partners WHERE partners_id = '" . (int)$partners_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "partners_description WHERE partners_id = '" . (int)$partners_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'partners_id=" . (int)$partners_id. "'");
	}
   
	public function getTotalPartners() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "partners");
	
		return $query->row['total'];
	}
	public function setModule($partners_id, $value){
		$this->db->query("UPDATE " . DB_PREFIX . "partners SET module = '" . (int)$value . "' WHERE partners_id = '" . (int)$partners_id . "'"); 
	}
}