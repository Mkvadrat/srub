<?php
class ModelExtensionPrices extends Model {

	public function getTotalImages() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gallery_image");

		return $query->row['total'];

	}
	
	public function getTotalAlbums() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gallery_album");

		return $query->row['total'];
	}

	public function getAlbum($price_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'price_id=" . (int)$price_id . "') AS keyword FROM " . DB_PREFIX . "gallery_album a LEFT JOIN " . DB_PREFIX . "gallery_album_description ad ON (a.price_id = ad.price_id) WHERE a.price_id = '" . (int)$price_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	} 

	public function getAlbums($data) {

		$sql = "SELECT * FROM " . DB_PREFIX . "gallery_album a LEFT JOIN " . DB_PREFIX . "gallery_album_description ad ON (a.price_id = ad.price_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		
		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		
		$sql .= " GROUP BY a.price_id";

		$sort_data = array(
			'a.viewed',		
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY ad.name";	
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

	public function addAlbum($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_album SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$price_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "gallery_album SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE price_id = '" . (int)$price_id . "'");
		}

		foreach ($data['album_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_album_description SET price_id = '" . (int)$price_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "' , name_gallery = '" . $this->db->escape($value['name_gallery']) . "', category_text = '" . $this->db->escape($value['category_text']) . "', short_description = '" . $this->db->escape($value['short_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "' , description = '" . $this->db->escape($value['description']) . "'");
		}

		if (isset($data['album_store'])) {
			foreach ($data['album_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_album_to_store SET price_id = '" . (int)$price_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['album_image'])) {
			foreach ($data['album_image'] as $album_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_image SET name = '" . $this->db->escape($album_image['name']) . "' , price_id = '" . (int)$price_id . "', image = '" . $this->db->escape($album_image['image']) . "', sort_order = '" . (int)$album_image['sort_order'] . "'");
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'price_id=" . (int)$price_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		if (isset($data['album_download'])) {
			foreach ($data['album_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_to_download SET price_id = '" . (int)$price_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		if (isset($data['prices_to_category'])) {
			foreach ($data['prices_to_category'] as $category_prices_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "prices_to_category SET price_id = '" . (int)$price_id . "', category_prices_id = '" . (int)$category_prices_id . "'");
			}
		}

		if(isset($data['main_category_prices_id']) && $data['main_category_prices_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "prices_to_category WHERE price_id = '" . (int)$price_id . "' AND category_prices_id = '" . (int)$data['main_category_prices_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "prices_to_category SET price_id = '" . (int)$price_id . "', category_prices_id = '" . (int)$data['main_category_prices_id'] . "', main_category = 1");
		} elseif(isset($data['product_category'][0])) {
			$this->db->query("UPDATE " . DB_PREFIX . "prices_to_category SET main_category = 1 WHERE price_id = '" . (int)$price_id . "' AND category_prices_id = '" . (int)$data['product_category'][0] . "'");
		}
		
		$this->cache->delete('album');
	}

	public function editAlbum($price_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "gallery_album SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE price_id = '" . (int)$price_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "gallery_album SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE price_id = '" . (int)$price_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_album_description WHERE price_id = '" . (int)$price_id . "'");

		foreach ($data['album_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_album_description SET price_id = '" . (int)$price_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "' , name_gallery = '" . $this->db->escape($value['name_gallery']) . "', category_text = '" . $this->db->escape($value['category_text']) . "', short_description = '" . $this->db->escape($value['short_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "' , description = '" . $this->db->escape($value['description']) . "'");
		}

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_album_to_store WHERE price_id = '" . (int)$price_id . "'");

		if (isset($data['album_store'])) {		
			foreach ($data['album_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_album_to_store SET price_id = '" . (int)$price_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_image WHERE price_id = '" . (int)$price_id . "'");

		if (isset($data['album_image'])) {
			foreach ($data['album_image'] as $album_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_image SET name = '" . $this->db->escape($album_image['name']) . "' , price_id = '" . (int)$price_id . "', image = '" . $this->db->escape($album_image['image']) . "', sort_order = '" . (int)$album_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'price_id=" . (int)$price_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'price_id=" . (int)$price_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_to_download WHERE price_id = '" . (int)$price_id . "'");

		if (isset($data['album_download'])) {
			foreach ($data['album_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "gallery_to_download SET price_id = '" . (int)$price_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "prices_to_category WHERE price_id = '" . (int)$price_id . "'");

		if (isset($data['prices_to_category'])) {
			foreach ($data['prices_to_category'] as $category_prices_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "prices_to_category SET price_id = '" . (int)$price_id . "', category_prices_id = '" . (int)$category_prices_id . "'");
			}
		}

		if(isset($data['main_category_prices_id']) && $data['main_category_prices_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "prices_to_category WHERE price_id = '" . (int)$price_id . "' AND category_prices_id = '" . (int)$data['main_category_prices_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "prices_to_category SET price_id = '" . (int)$price_id . "', category_prices_id = '" . (int)$data['main_category_prices_id'] . "', main_category = 1");
		} elseif(isset($data['prices_to_category'][0])) {
			$this->db->query("UPDATE " . DB_PREFIX . "prices_to_category SET main_category = 1 WHERE price_id = '" . (int)$price_id . "' AND category_prices_id = '" . (int)$data['prices_to_category'][0] . "'");
		}

		$this->cache->delete('album');
	}

	public function deleteAlbum($price_id) {

		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_album WHERE price_id = '" . (int)$price_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_album_description WHERE price_id = '" . (int)$price_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_album_to_store WHERE price_id = '" . (int)$price_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_image WHERE price_id = '" . (int)$price_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "gallery_to_download WHERE price_id = '" . (int)$price_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "prices_to_category WHERE price_id = '" . (int)$price_id . "'");

		$this->cache->delete('album');
	}

	public function getAlbumDescriptions($price_id) {
		$album_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_album_description WHERE price_id = '" . (int)$price_id . "'");

		foreach ($query->rows as $result) {
			$album_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'name_gallery'     => $result['name_gallery'],
				'category_text'     => $result['category_text'],
				'short_description' => $result['short_description'],
				'description'      => $result['description'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
			);
		}

		return $album_description_data;
	}

	public function getAlbumStores($price_id) {
		$album_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_album_to_store WHERE price_id = '" . (int)$price_id . "'");

		foreach ($query->rows as $result) {
			$album_store_data[] = $result['store_id'];
		}

		return $album_store_data;
	}

	public function getImageAlbum($price_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_image WHERE price_id = '" . (int)$price_id . "' ORDER BY sort_order");

		return $query->rows;
	}	
	
	public function getPricesDownloads($price_id) {
		$album_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery_to_download WHERE price_id = '" . (int)$price_id . "'");

		foreach ($query->rows as $result) {
			$album_download_data[] = $result['download_id'];
		}

		return $album_download_data;
	}
	
	public function getTotalPricesByDownloadId($price_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gallery_to_download WHERE price_id = '" . (int)$price_id . "'");

		return $query->row['total'];
	}
	
	
	public function getDownloadFile($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE d.download_id = '" . (int)$download_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	
	public function getProductCategories($price_id) {
		$product_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "prices_to_category WHERE price_id = '" . (int)$price_id . "'");

		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_prices_id'];
		}

		return $product_category_data;
	}
	
	public function getProductMainCategoryId($price_id) {
		$query = $this->db->query("SELECT category_prices_id FROM " . DB_PREFIX . "prices_to_category WHERE price_id = '" . (int)$price_id . "' AND main_category = '1' LIMIT 1");

		return ($query->num_rows ? (int)$query->row['category_prices_id'] : 0);
	}
}
?>