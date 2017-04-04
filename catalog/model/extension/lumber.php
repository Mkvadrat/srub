<?php
class ModelExtensionLumber extends Model {

	public function updateViewed($lumber_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "lumber SET viewed = (viewed + 1) WHERE lumber_id = '" . (int)$lumber_id . "'");
	}

	public function getAlbum($lumber_id) {

		$query = $this->db->query("SELECT DISTINCT *, ad.name AS name, a.image, a.sort_order FROM " . DB_PREFIX . "lumber a LEFT JOIN " . DB_PREFIX . "lumber_description ad ON (a.lumber_id = ad.lumber_id) LEFT JOIN " . DB_PREFIX . "lumber_to_store a2s ON (a.lumber_id = a2s.lumber_id) WHERE a.lumber_id = '" . (int)$lumber_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'lumber_id'         => $query->row['lumber_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'category_text'      => $query->row['category_text'],
				'name_gallery'     => $query->row['name_gallery'],
				'short_description' => $query->row['short_description'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'image'            => $query->row['image'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'viewed'           => $query->row['viewed']
			);
		} else {
			return false;
		}
	}

	public function getAlbums($data = array()) {

		$sql = "SELECT a.lumber_id ";

		$sql .= "FROM " . DB_PREFIX . "lumber a ";

		$sql .= "LEFT JOIN " . DB_PREFIX . "lumber_description ad ON (a.lumber_id = ad.lumber_id) LEFT JOIN " . DB_PREFIX . "lumber_to_store a2s ON (a.lumber_id = a2s.lumber_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ";

		$sql .= "GROUP BY a.lumber_id ";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$album_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$album_data[$result['lumber_id']] = $this->getAlbum($result['lumber_id']);
		}

		return $album_data;
	}

	public function getTotalAlbums($data = array()) {

		$sql = "SELECT COUNT(DISTINCT a.lumber_id) AS total FROM " . DB_PREFIX . "lumber a LEFT JOIN " . DB_PREFIX . "lumber_description ad ON (a.lumber_id = ad.lumber_id) LEFT JOIN " . DB_PREFIX . "lumber_to_store a2s ON (a.lumber_id = a2s.lumber_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getAlbumImages($lumber_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "lumber_image i WHERE i.lumber_id = '" . (int)$lumber_id . "' ORDER BY i.sort_order ASC");

		return $query->rows;
	}

	public function getDownload($download_id) {

			$query = $this->db->query("SELECT d.filename, d.mask FROM " . DB_PREFIX . "download d JOIN " . DB_PREFIX . "lumber_to_download g2d ON (g2d.download_id = d.download_id)WHERE d.download_id = '" . (int)$download_id . "'");

			return $query->row;

	}

	public function getDownloads($lumber_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}

			$query = $this->db->query("SELECT DISTINCT d.download_id, d.date_added, dd.name, d.filename, gtd.lumber_id FROM " . DB_PREFIX . "lumber_to_download gtd LEFT JOIN " . DB_PREFIX . "download d ON (gtd.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE gtd.lumber_id = '" . (int)$lumber_id . "' AND dd.language_id = '1' ORDER BY d.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

			return $query->rows;

	}
}
?>
