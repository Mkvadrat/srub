<?php
class ModelOpencartGalleryImage extends Model {

	public function CreateDB() {

		$this->db->query("
		INSERT INTO " . DB_PREFIX . "setting (`setting_id`, `store_id`, `key`, `value`, `serialized`) VALUES
		(NULL, 0, 'og_heading_title_font', '27', 0),
		(NULL, 0, 'og_heading_title_size', '18', 0),
		(NULL, 0, 'og_heading_title_line', '8', 0),
		(NULL, 0, 'og_title_font', '27', 0),
		(NULL, 0, 'og_title_size', '12', 0),
		(NULL, 0, 'og_title_font_weight', '0', 0),
		(NULL, 0, 'og_allow_review', '0', 0),
		(NULL, 0, 'og_album_per_row', '4', 0),
		(NULL, 0, 'og_album_size', '2', 0),
		(NULL, 0, 'og_album_height', '220', 0),
		(NULL, 0, 'og_album_per_page', '12', 0),
		(NULL, 0, 'og_album_image_type', '0', 0),
		(NULL, 0, 'og_album_display_rating', '0', 0),
		(NULL, 0, 'og_image_pu_width', '800', 0),
		(NULL, 0, 'og_image_pu_height', '600', 0),
		(NULL, 0, 'og_video_btn', '1', 0),
		(NULL, 0, 'og_video_per_row', '4', 0),
		(NULL, 0, 'og_video_list_size', '3', 0),
		(NULL, 0, 'og_video_height', '200', 0),
		(NULL, 0, 'og_video_per_page', '12', 0),
		(NULL, 0, 'og_video_display_rating', '0', 0),
		(NULL, 0, 'og_video_size', '8', 0),
		(NULL, 0, 'gallery_db_insert', '1', 0);
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `po_opencart_gallery_album` (
			  `album_id` int(11) NOT NULL AUTO_INCREMENT,
			  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `status` tinyint(1) NOT NULL,
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `viewed` int(5) NOT NULL,
			  PRIMARY KEY (`album_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=16 ;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `po_opencart_gallery_album_description` (
			  `album_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  `meta_description` varchar(255) NOT NULL,
			  `meta_keyword` varchar(255) NOT NULL,
			  PRIMARY KEY (`album_id`,`language_id`),
			  KEY `name` (`name`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `po_opencart_gallery_album_review` (
			  `review_id` int(11) NOT NULL AUTO_INCREMENT,
			  `album_id` int(11) NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `author` varchar(64) COLLATE utf8_bin NOT NULL,
			  `text` text COLLATE utf8_bin NOT NULL,
			  `rating` int(1) NOT NULL,
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (`review_id`),
			  KEY `product_id` (`album_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `po_opencart_gallery_album_to_store` (
			  `album_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY (`album_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `po_opencart_gallery_image` (
			  `image_id` int(11) NOT NULL AUTO_INCREMENT,
			  `album_id` int(11) NOT NULL,
			  `name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (`image_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=33 ;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `po_opencart_gallery_video` (
			  `video_id` int(11) NOT NULL AUTO_INCREMENT,
			  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `video` varchar(255) COLLATE utf8_bin NOT NULL,
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `status` tinyint(1) NOT NULL,
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `viewed` int(5) NOT NULL,
			  PRIMARY KEY (`video_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=16 ;

		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `po_opencart_gallery_video_description` (
			  `video_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  `meta_description` varchar(255) NOT NULL,
			  `meta_keyword` varchar(255) NOT NULL,
			  PRIMARY KEY (`video_id`,`language_id`),
			  KEY `name` (`name`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;

		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `po_opencart_gallery_video_review` (
			  `review_id` int(11) NOT NULL AUTO_INCREMENT,
			  `video_id` int(11) NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `author` varchar(64) COLLATE utf8_bin NOT NULL,
			  `text` text COLLATE utf8_bin NOT NULL,
			  `rating` int(1) NOT NULL,
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (`review_id`),
			  KEY `product_id` (`video_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;
		");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `po_opencart_gallery_video_to_store` (
			  `video_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL,
			  PRIMARY KEY (`video_id`,`store_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		");

	}

	public function getTotalImages() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM po_opencart_gallery_image");

		return $query->row['total'];

	}

	public function getTotalAlbums() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM po_opencart_gallery_album");

		return $query->row['total'];
	}

	public function getAlbum($album_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'album_id=" . (int)$album_id . "') AS keyword FROM po_opencart_gallery_album a LEFT JOIN po_opencart_gallery_album_description ad ON (a.album_id = ad.album_id) WHERE a.album_id = '" . (int)$album_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getAlbums($data) {

		$sql = "SELECT * FROM po_opencart_gallery_album a LEFT JOIN po_opencart_gallery_album_description ad ON (a.album_id = ad.album_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";


		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}


		$sql .= " GROUP BY a.album_id ORDER BY a.sort_order ASC";

		$sort_data = array(
			'a.viewed',
		);

		/*if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY ad.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}*/

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
		$this->db->query("INSERT INTO po_opencart_gallery_album SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$album_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE po_opencart_gallery_album SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE album_id = '" . (int)$album_id . "'");
		}

		foreach ($data['album_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO po_opencart_gallery_album_description SET album_id = '" . (int)$album_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "' , meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "' , description = '" . $this->db->escape($value['description']) . "'");
		}

		if (isset($data['album_store'])) {
			foreach ($data['album_store'] as $store_id) {
				$this->db->query("INSERT INTO po_opencart_gallery_album_to_store SET album_id = '" . (int)$album_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['album_image'])) {
			foreach ($data['album_image'] as $album_image) {
				$this->db->query("INSERT INTO po_opencart_gallery_image SET name = '" . $this->db->escape($album_image['name']) . "' , album_id = '" . (int)$album_id . "', image = '" . $this->db->escape($album_image['image']) . "', sort_order = '" . (int)$album_image['sort_order'] . "'");
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'album_id=" . (int)$album_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('album');
	}

	public function editAlbum($album_id, $data) {
		$this->db->query("UPDATE po_opencart_gallery_album SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE album_id = '" . (int)$album_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE po_opencart_gallery_album SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE album_id = '" . (int)$album_id . "'");
		}

		$this->db->query("DELETE FROM po_opencart_gallery_album_description WHERE album_id = '" . (int)$album_id . "'");

		foreach ($data['album_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO po_opencart_gallery_album_description SET album_id = '" . (int)$album_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "' , meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "' , description = '" . $this->db->escape($value['description']) . "'");
		}


		$this->db->query("DELETE FROM po_opencart_gallery_album_to_store WHERE album_id = '" . (int)$album_id . "'");

		if (isset($data['album_store'])) {
			foreach ($data['album_store'] as $store_id) {
				$this->db->query("INSERT INTO po_opencart_gallery_album_to_store SET album_id = '" . (int)$album_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM po_opencart_gallery_image WHERE album_id = '" . (int)$album_id . "'");

		if (isset($data['album_image'])) {
			foreach ($data['album_image'] as $album_image) {
				$this->db->query("INSERT INTO po_opencart_gallery_image SET name = '" . $this->db->escape($album_image['name']) . "' , album_id = '" . (int)$album_id . "', image = '" . $this->db->escape($album_image['image']) . "', sort_order = '" . (int)$album_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'album_id=" . (int)$album_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'album_id=" . (int)$album_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('album');
	}

	public function deleteAlbum($album_id) {

		$this->db->query("DELETE FROM po_opencart_gallery_album WHERE album_id = '" . (int)$album_id . "'");
		$this->db->query("DELETE FROM po_opencart_gallery_album_description WHERE album_id = '" . (int)$album_id . "'");
		$this->db->query("DELETE FROM po_opencart_gallery_album_to_store WHERE album_id = '" . (int)$album_id . "'");
		$this->db->query("DELETE FROM po_opencart_gallery_image WHERE album_id = '" . (int)$album_id . "'");

		$this->cache->delete('album');
	}

	public function getAlbumDescriptions($album_id) {
		$album_description_data = array();

		$query = $this->db->query("SELECT * FROM po_opencart_gallery_album_description WHERE album_id = '" . (int)$album_id . "'");

		foreach ($query->rows as $result) {
			$album_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
			);
		}

		return $album_description_data;
	}

	public function getAlbumStores($album_id) {
		$album_store_data = array();

		$query = $this->db->query("SELECT * FROM po_opencart_gallery_album_to_store WHERE album_id = '" . (int)$album_id . "'");

		foreach ($query->rows as $result) {
			$album_store_data[] = $result['store_id'];
		}

		return $album_store_data;
	}

	public function getImageAlbum($album_id) {

		$query = $this->db->query("SELECT * FROM po_opencart_gallery_image WHERE album_id = '" . (int)$album_id . "' ORDER BY sort_order");

		return $query->rows;
	}

}
?>
