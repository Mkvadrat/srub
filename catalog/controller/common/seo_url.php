<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}

		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);

			// remove any empty arrays from trailing
			if (utf8_strlen(end($parts)) == 0) {
				array_pop($parts);
			}

			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");

				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);

					if ($url[0] == 'album_id') {
						$this->request->get['album_id'] = $url[1];
					}

					if ($url[0] == 'video_id') {
                        $this->request->get['video_id'] = $url[1];
                    }

					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}
					
					if ($url[0] == 'price_id') {
						$this->request->get['price_id'] = $url[1];
					}

					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}
					
					if ($url[0] == 'category_prices_id') {
						if (!isset($this->request->get['link'])) {
							$this->request->get['link'] = $url[1];
						} else {
							$this->request->get['link'] .= '_' . $url[1];
						}
					}

					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}

					if ($url[0] == 'posts_id') {
						$this->request->get['posts_id'] = $url[1];
					}

					if ($url[0] == 'important_id') {
						$this->request->get['important_id'] = $url[1];
					}

					if ($url[0] == 'ads_id') {
						$this->request->get['ads_id'] = $url[1];
					}

					if ($url[0] == 'partners_id') {
						$this->request->get['partners_id'] = $url[1];
					}

					if ($url[0] == 'news_id') {
						$this->request->get['news_id'] = $url[1];
					}

					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}

					if ($url[0] == 'lumber_id') {
						$this->request->get['lumber_id'] = $url[1];
					}

					if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'category_id' && $url[0] != 'product_id' && $url[0] != 'category_prices_id' && $url[0] != 'news_id' && $url[0] != 'important_id' && $url[0] != 'ads_id' && $url[0] != 'partners_id' && $url[0] != 'album_id' && $url[0] != 'posts_id' && $url[0] != 'price_id' && $url[0] != 'lumber_id') {
						$this->request->get['route'] = $query->row['query'];
					}
				} else {
					$this->request->get['route'] = 'error/not_found';

					break;
				}
			}

			if (!isset($this->request->get['route'])) {
				if (isset($this->request->get['product_id'])) {
					$this->request->get['route'] = 'product/product';
				} elseif (isset($this->request->get['price_id'])) {
					$this->request->get['route'] = 'information/prices';
				} elseif (isset($this->request->get['path'])) {
					$this->request->get['route'] = 'product/category';
				} elseif (isset($this->request->get['link'])) {
					$this->request->get['route'] = 'information/category_prices';
				} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['route'] = 'product/manufacturer/info';
				} elseif (isset($this->request->get['album_id'])) {
					$this->request->get['route'] = 'gallery/album';
				} elseif (isset($this->request->get['video_id'])) {
					$this->request->get['route'] = 'gallery/video';
				} elseif (isset($this->request->get['posts_id'])) {
					$this->request->get['route'] = 'information/posts/posts';
				} elseif (isset($this->request->get['ads_id'])) {
					$this->request->get['route'] = 'information/ads/ads';
				} elseif (isset($this->request->get['important_id'])) {
					$this->request->get['route'] = 'information/important/important';
				} elseif (isset($this->request->get['lumber_id'])) {
					$this->request->get['route'] = 'information/lumber';
				} elseif (isset($this->request->get['partners_id'])) {
					$this->request->get['route'] = 'information/partners/partners';
				} elseif (isset($this->request->get['news_id'])) {
					$this->request->get['route'] = 'information/news/news';
				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'information/information';
				}
			}

			if (isset($this->request->get['route'])) {
				return new Action($this->request->get['route']);
			}
		}
	}

	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));

		$url = '';

		$data = array();

		parse_str($url_info['query'], $data);
		
		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'information/prices' && $key == 'price_id') || ($data['route'] == 'information/lumber' && $key == 'lumber_id') || ($data['route'] == 'information/partners/partners' && $key == 'partners_id') || ($data['route'] == 'information/important/important' && $key == 'important_id') || ($data['route'] == 'information/ads/ads' && $key == 'ads_id') || ($data['route'] == 'information/news/news' && $key == 'news_id') || ($data['route'] == 'information/posts/posts' && $key == 'posts_id') || ($data['route'] == 'product/product' && $key == 'product_id') || ($data['route'] == 'gallery/album' && $key == 'album_id') || ($data['route'] == 'gallery/video' && $key == 'video_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
						
					if ($query->num_rows && $query->row['keyword']) {
						$url .= '/' . $query->row['keyword'];

						unset($data[$key]);
					}
				} elseif ($key == 'path' || $key == 'npath') {
					$categories = explode('_', $value);
					
					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");

						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';

							break;
						}
					}

					unset($data[$key]);
				}elseif ($key == 'link') {
					$prices_categories = explode('_', $value);
					
					foreach ($prices_categories as $prices_category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_prices_id=" . (int)$prices_category . "'");
					
						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';

							break;
						}
					}

					unset($data[$key]);
				}
			}
		}

		if ($url) {
			unset($data['route']);

			$query = '';

			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((string)$value);
				}

				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
			}
			
			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}
}
