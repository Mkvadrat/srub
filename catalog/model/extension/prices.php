<?php
class ModelExtensionPrices extends Model {
	
	public function updateViewed($price_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "gallery_album SET viewed = (viewed + 1) WHERE price_id = '" . (int)$price_id . "'");
	}

	public function getAlbum($price_id) {
		
		$query = $this->db->query("SELECT DISTINCT *, ad.name AS name, a.image, a.sort_order FROM " . DB_PREFIX . "gallery_album a LEFT JOIN " . DB_PREFIX . "gallery_album_description ad ON (a.price_id = ad.price_id) LEFT JOIN " . DB_PREFIX . "gallery_album_to_store a2s ON (a.price_id = a2s.price_id) WHERE a.price_id = '" . (int)$price_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'price_id'         => $query->row['price_id'],
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

		/*$sql = "SELECT a.price_id ";
		
		$sql .= "FROM " . DB_PREFIX . "gallery_album a ";
		
		$sql .= "LEFT JOIN " . DB_PREFIX . "gallery_album_description ad ON (a.price_id = ad.price_id) LEFT JOIN " . DB_PREFIX . "gallery_album_to_store a2s ON (a.price_id = a2s.price_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ";
				
		$sql .= "GROUP BY a.price_id ";
	
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

		$query = $this->db->query($sql);*/
		
		$sql = "SELECT p.price_id";

		if (!empty($data['filter_category_prices_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_prices_path cp LEFT JOIN " . DB_PREFIX . "prices_to_category p2c ON (cp.category_prices_id = p2c.category_prices_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "prices_to_category p2c";
			}
			
			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.price_id = pf.price_id) LEFT JOIN " . DB_PREFIX . "gallery_album p ON (pf.price_id = p.price_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "gallery_album p ON (p2c.price_id = p.price_id)";
			}

		} else {
			$sql .= " FROM " . DB_PREFIX . "gallery_album p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "gallery_album_description pd ON (p.price_id = pd.price_id) LEFT JOIN " . DB_PREFIX . "gallery_album_to_store p2s ON (p.price_id = p2s.price_id)
		WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1'
		AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		
		if (!empty($data['filter_category_prices_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_prices_id'] . "'";
			} else {
				$sql .= " AND p2c.category_prices_id = '" . (int)$data['filter_category_prices_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}
		
		$sql .= "GROUP BY p.price_id ";

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
			$album_data[$result['price_id']] = $this->getAlbum($result['price_id']);
		}

		return $album_data;
	}

	public function getTotalAlbums($data = array()) {
		
		$sql = "SELECT COUNT(DISTINCT a.price_id) AS total FROM " . DB_PREFIX . "gallery_album a LEFT JOIN " . DB_PREFIX . "gallery_album_description ad ON (a.price_id = ad.price_id) LEFT JOIN " . DB_PREFIX . "gallery_album_to_store a2s ON (a.price_id = a2s.price_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getAlbumImages($price_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_image i WHERE i.price_id = '" . (int)$price_id . "' ORDER BY i.sort_order ASC");

		return $query->rows;
	}
	
	public function getDownload($download_id) {
			
			$query = $this->db->query("SELECT d.filename, d.mask FROM " . DB_PREFIX . "download d JOIN " . DB_PREFIX . "gallery_to_download g2d ON (g2d.download_id = d.download_id)WHERE d.download_id = '" . (int)$download_id . "'");

			return $query->row;

	}

	public function getDownloads($price_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}

			$query = $this->db->query("SELECT DISTINCT d.download_id, d.date_added, dd.name, d.filename, gtd.price_id FROM " . DB_PREFIX . "gallery_to_download gtd LEFT JOIN " . DB_PREFIX . "download d ON (gtd.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE gtd.price_id = '" . (int)$price_id . "' AND dd.language_id = '1' ORDER BY d.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
		
			return $query->rows;
	}	
}
?>