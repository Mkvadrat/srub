<?php
class ModelExtensionImportant extends Model {
	public function addImportant($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "important SET image = '" . $this->db->escape($data['image']) . "', date_added = NOW(), status = '" . (int)$data['status'] . "'");
		
		$important_id = $this->db->getLastId();
		
		foreach ($data['important'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX ."important_description SET important_id = '" . (int)$important_id . "', language_id = '" . (int)$key . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', short_description = '" . $this->db->escape($value['short_description']) . "'");
		}
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'important_id=" . (int)$important_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
	
	public function editImportant($important_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "important SET image = '" . $this->db->escape($data['image']) . "', status = '" . (int)$data['status'] . "' WHERE important_id = '" . (int)$important_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "important_description WHERE important_id = '" . (int)$important_id. "'");
		
		foreach ($data['important'] as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX ."important_description SET important_id = '" . (int)$important_id . "', language_id = '" . (int)$key . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', short_description = '" . $this->db->escape($value['short_description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'important_id=" . (int)$important_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'important_id=" . (int)$important_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
	}
	
	public function getImportant($important_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'important_id=" . (int)$important_id . "') AS keyword FROM " . DB_PREFIX . "important WHERE important_id = '" . (int)$important_id . "'"); 
 
		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}
   
	public function getImportantDescription($important_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "important_description WHERE important_id = '" . (int)$important_id . "'"); 
		
		foreach ($query->rows as $result) {
			$important_description[$result['language_id']] = array(
				'title'       			=> $result['title'],
				'short_description'		=> $result['short_description'],
				'description' 			=> $result['description']
			);
		}
		
		return $important_description;
	}
 
	public function getAllImportant($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "important n LEFT JOIN " . DB_PREFIX . "important_description nd ON n.important_id = nd.important_id WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY date_added DESC";
		
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
   
	public function deleteImportant($important_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "important WHERE important_id = '" . (int)$important_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "important_description WHERE important_id = '" . (int)$important_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'important_id=" . (int)$important_id. "'");
	}
   
	public function getTotalImportant() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "important");
	
		return $query->row['total'];
	}
	public function setModule($important_id, $value){
		$this->db->query("UPDATE " . DB_PREFIX . "important SET module = '" . (int)$value . "' WHERE important_id = '" . (int)$important_id . "'"); 
	}
}