<?php
class ModelExtensionCategoryPrices extends Model {
	public function addCategory($data) {
		$this->event->trigger('pre.admin.category.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "category_prices SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$category_prices_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category_prices SET image = '" . $this->db->escape($data['image']) . "' WHERE category_prices_id = '" . (int)$category_prices_id . "'");
		}

		foreach ($data['category_prices_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_prices_description SET category_prices_id = '" . (int)$category_prices_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_prices_path` WHERE category_prices_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_prices_path` SET `category_prices_id` = '" . (int)$category_prices_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_prices_path` SET `category_prices_id` = '" . (int)$category_prices_id . "', `path_id` = '" . (int)$category_prices_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['category_prices_filter'])) {
			foreach ($data['category_prices_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_prices_filter SET category_prices_id = '" . (int)$category_prices_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['category_prices_to_store'])) {
			foreach ($data['category_prices_to_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_prices_to_store SET category_prices_id = '" . (int)$category_prices_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this category
		if (isset($data['category_prices_to_layout'])) {
			foreach ($data['category_prices_to_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_prices_to_layout SET category_prices_id = '" . (int)$category_prices_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_prices_id=" . (int)$category_prices_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('category');

		$this->event->trigger('post.admin.category.add', $category_prices_id);

		return $category_prices_id;
	}

	public function editCategory($category_prices_id, $data) {
		$this->event->trigger('pre.admin.category.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "category_prices SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE category_prices_id = '" . (int)$category_prices_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category_prices SET image = '" . $this->db->escape($data['image']) . "' WHERE category_prices_id = '" . (int)$category_prices_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_prices_description WHERE category_prices_id = '" . (int)$category_prices_id . "'");

		foreach ($data['category_prices_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_prices_description SET category_prices_id = '" . (int)$category_prices_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_prices_path` WHERE path_id = '" . (int)$category_prices_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $category_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "category_prices_path` WHERE category_prices_id = '" . (int)$category_path['category_prices_id'] . "' AND level < '" . (int)$category_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_prices_path` WHERE category_prices_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_prices_path` WHERE category_prices_id = '" . (int)$category_path['category_prices_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_prices_path` SET category_prices_id = '" . (int)$category_path['category_prices_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_prices_path` WHERE category_prices_id = '" . (int)$category_prices_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_prices_path` WHERE category_prices_id = '" . (int)$data['category_prices_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_prices_path` SET category_prices_id = '" . (int)$category_prices_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_prices_path` SET category_prices_id = '" . (int)$category_prices_id . "', `path_id` = '" . (int)$category_prices_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_prices_filter WHERE category_prices_id = '" . (int)$category_prices_id . "'");

		if (isset($data['category_prices_filter'])) {
			foreach ($data['category_prices_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_prices_filter SET category_prices_id = '" . (int)$category_prices_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_prices_to_store WHERE category_prices_id = '" . (int)$category_prices_id . "'");

		if (isset($data['category_prices_to_store'])) {
			foreach ($data['category_prices_to_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_prices_to_store SET category_prices_id = '" . (int)$category_prices_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_prices_to_layout WHERE category_prices_id = '" . (int)$category_prices_id . "'");

		if (isset($data['category_prices_to_layout'])) {
			foreach ($data['category_prices_to_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_prices_to_layout SET category_prices_id = '" . (int)$category_prices_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_prices_id=" . (int)$category_prices_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_prices_id=" . (int)$category_prices_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('category');

		$this->event->trigger('post.admin.category.edit', $category_prices_id);
	}

	public function deleteCategory($category_prices_id) {
		$this->event->trigger('pre.admin.category.delete', $category_prices_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_prices_path WHERE category_prices_id = '" . (int)$category_prices_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_prices_path WHERE path_id = '" . (int)$category_prices_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_prices_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_prices WHERE category_prices_id = '" . (int)$category_prices_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_prices_description WHERE category_prices_id = '" . (int)$category_prices_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_prices_filter WHERE category_prices_id = '" . (int)$category_prices_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_prices_to_store WHERE category_prices_id = '" . (int)$category_prices_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_prices_to_layout WHERE category_prices_id = '" . (int)$category_prices_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "prices_to_category WHERE category_prices_id = '" . (int)$category_prices_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_prices_id=" . (int)$category_prices_id . "'");

		$this->cache->delete('category');

		$this->event->trigger('post.admin.category.delete', $category_prices_id);
	}

	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_prices WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_prices_path` WHERE category_prices_id = '" . (int)$category['category_prices_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_prices_path` WHERE category_prices_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_prices_path` SET category_prices_id = '" . (int)$category['category_prices_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_prices_path` SET category_prices_id = '" . (int)$category['category_prices_id'] . "', `path_id` = '" . (int)$category['category_prices_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($category['category_prices_id']);
		}
	}

	public function getCategory($category_prices_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "category_prices_path cp LEFT JOIN " . DB_PREFIX . "category_prices_description cd1 ON (cp.path_id = cd1.category_prices_id AND cp.category_prices_id != cp.path_id) WHERE cp.category_prices_id = c.category_prices_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_prices_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_prices_id=" . (int)$category_prices_id . "') AS keyword FROM " . DB_PREFIX . "category_prices c LEFT JOIN " . DB_PREFIX . "category_prices_description cd2 ON (c.category_prices_id = cd2.category_prices_id) WHERE c.category_prices_id = '" . (int)$category_prices_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCategoriesByParentId($parent_id = 0) {
		$query = $this->db->query("SELECT *, (SELECT COUNT(parent_id) FROM " . DB_PREFIX . "category_prices WHERE parent_id = c.category_prices_id) AS children FROM " . DB_PREFIX . "category_prices c LEFT JOIN " . DB_PREFIX . "category_prices_description cd ON (c.category_prices_id = cd.category_prices_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name");

		return $query->rows;
	}

	public function getCategories($data = array()) {
		$sql = "SELECT cp.category_prices_id AS category_prices_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order, c1.status,(select count(price_id) as product_count from " . DB_PREFIX . "prices_to_category pc where pc.category_prices_id = c1.category_prices_id) as product_count FROM " . DB_PREFIX . "category_prices_path cp LEFT JOIN " . DB_PREFIX . "category_prices c1 ON (cp.category_prices_id = c1.category_prices_id) LEFT JOIN " . DB_PREFIX . "category_prices c2 ON (cp.path_id = c2.category_prices_id) LEFT JOIN " . DB_PREFIX . "category_prices_description cd1 ON (cp.path_id = cd1.category_prices_id) LEFT JOIN " . DB_PREFIX . "category_prices_description cd2 ON (cp.category_prices_id = cd2.category_prices_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.category_prices_id";

		$sort_data = array(
			'product_count',
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getCategoryDescriptions($category_prices_id) {
		$category_prices_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_prices_description WHERE category_prices_id = '" . (int)$category_prices_id . "'");

		foreach ($query->rows as $result) {
			$category_prices_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'          => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $category_prices_description_data;
	}

	public function getCategoryFilters($category_prices_id) {
		$category_prices_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_prices_filter WHERE category_prices_id = '" . (int)$category_prices_id . "'");

		foreach ($query->rows as $result) {
			$category_prices_filter_data[] = $result['filter_id'];
		}

		return $category_prices_filter_data;
	}

	public function getCategoryStores($category_prices_id) {
		$category_prices_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_prices_to_store WHERE category_prices_id = '" . (int)$category_prices_id . "'");

		foreach ($query->rows as $result) {
			$category_prices_store_data[] = $result['store_id'];
		}

		return $category_prices_store_data;
	}

	public function getCategoryLayouts($category_prices_id) {
		$category_prices_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_prices_to_layout WHERE category_prices_id = '" . (int)$category_prices_id . "'");

		foreach ($query->rows as $result) {
			$category_prices_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $category_prices_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_prices");

		return $query->row['total'];
	}

	public function getAllCategories() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_prices c LEFT JOIN " . DB_PREFIX . "category_prices_description cd ON (c.category_prices_id = cd.category_prices_id) LEFT JOIN " . DB_PREFIX . "category_prices_to_store c2s ON (c.category_prices_id = c2s.category_prices_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  ORDER BY c.parent_id, c.sort_order, cd.name");

		$category_prices_data = array();
		
		foreach ($query->rows as $row) {
			$category_prices_data[$row['parent_id']][$row['category_prices_id']] = $row;
		}

		return $category_prices_data;
	}
	
	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_prices_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}
