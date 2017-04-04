<?php
class ModelGalleryAlbum extends Model {
	public function getModuleAlbum() {
		$query = $this->db->query("SELECT * FROM po_opencart_gallery_album a JOIN po_opencart_gallery_album_description b JOIN po_opencart_gallery_album_to_store c WHERE a.album_id = b.album_id AND a.album_id = c.album_id AND b.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND c.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function updateViewed($album_id) {
		$this->db->query("UPDATE po_opencart_gallery_album SET viewed = (viewed + 1) WHERE album_id = '" . (int)$album_id . "'");
	}

	public function getAlbum($album_id) {

		$query = $this->db->query("SELECT DISTINCT *, ad.name AS name, a.image, (SELECT AVG(rating) AS total FROM po_opencart_gallery_album_review r1 WHERE r1.album_id = a.album_id AND r1.status = '1' GROUP BY r1.album_id) AS rating, (SELECT COUNT(*) AS total FROM po_opencart_gallery_album_review r2 WHERE r2.album_id = a.album_id AND r2.status = '1' GROUP BY r2.album_id) AS reviews, a.sort_order FROM po_opencart_gallery_album a LEFT JOIN po_opencart_gallery_album_description ad ON (a.album_id = ad.album_id) LEFT JOIN po_opencart_gallery_album_to_store a2s ON (a.album_id = a2s.album_id) WHERE a.album_id = '" . (int)$album_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'album_id'         => $query->row['album_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'image'            => $query->row['image'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
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

		$sql = "SELECT a.album_id, (SELECT AVG(rating) AS total FROM po_opencart_gallery_album_review r1 WHERE r1.album_id = a.album_id AND r1.status = '1' GROUP BY r1.album_id) AS rating";


		$sql .= " FROM po_opencart_gallery_album a";


		$sql .= " LEFT JOIN po_opencart_gallery_album_description ad ON (a.album_id = ad.album_id) LEFT JOIN po_opencart_gallery_album_to_store a2s ON (a.album_id = a2s.album_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "ad.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR ad.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			$sql .= ")";
		}

		$sql .= " GROUP BY a.album_id";

		$sort_data = array(
			'ad.name',
			'a.viewed',
			'a.date_added',
			'rating',
			'a.sort_order',
			'a.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'ad.name') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY a.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(ad.name) DESC";
		} else {
			$sql .= " ASC, LCASE(ad.name) ASC";
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

		$album_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$album_data[$result['album_id']] = $this->getAlbum($result['album_id']);
		}

		return $album_data;
	}

	public function getTotalAlbums($data = array()) {

		$sql = "SELECT COUNT(DISTINCT a.album_id) AS total";

		$sql .= " FROM po_opencart_gallery_album a";

		$sql .= " LEFT JOIN po_opencart_gallery_album_description ad ON (a.album_id = ad.album_id) LEFT JOIN po_opencart_gallery_album_to_store a2s ON (a.album_id = a2s.album_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";


		if (!empty($data['filter_name'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "ad.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR ad.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			$sql .= ")";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getAlbumImages($album_id) {
		$query = $this->db->query("SELECT * FROM po_opencart_gallery_image i WHERE i.album_id = '" . (int)$album_id . "' ORDER BY i.sort_order ASC");

		return $query->rows;
	}
}
?>
