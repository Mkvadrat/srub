<?php
class ControllerInformationCategoryPrices extends Controller {
	public function index() {
		$this->load->language('information/category_prices');

		$this->load->model('extension/category_prices');

		$this->load->model('extension/prices');

		$this->load->model('tool/image');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home'),
			'separator' => $this->language->get('text_separator')
		);

		if (isset($this->request->get['link'])) {
			$url = '';

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$link = '';

			$parts = explode('_', (string)$this->request->get['link']);

			$category_prices_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$link) {
					$link = (int)$path_id;
				} else {
					$link .= '_' . (int)$path_id;
				}

				$category_info = $this->model_extension_category_prices->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('information/category_prices', 'link=' . $link . $url),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
		} else {
			$category_prices_id = 0;
		}

		$category_info = $this->model_extension_category_prices->getCategory($category_prices_id);

		if ($category_info) {

			if ($category_info['meta_title']) {
				$this->document->setTitle($category_info['meta_title']);
			} else {
				$this->document->setTitle($category_info['name']);
			}

			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

			if ($category_info['meta_h1']) {
				$data['heading_title'] = $category_info['meta_h1'];
			} else {
				$data['heading_title'] = $category_info['name'];
			}

			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('information/category_prices', 'link=' . $this->request->get['link']),
				'separator' => $this->language->get('text_separator')
			);

			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
				$this->document->setOgImage($data['thumb']);
			} else {
				$data['thumb'] = '';
			}

			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');

			$url = '';
			
			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['categories'] = array();

			$results = $this->model_extension_category_prices->getCategories($category_prices_id);

			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_prices_id'  => $result['category_prices_id'],
					'filter_sub_category' => true
				);

				$data['categories'][] = array(
					'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_extension_prices->getTotalAlbums($filter_data) . ')' : ''),
					'href' => $this->url->link('information/category_prices', 'link=' . $this->request->get['link'] . '_' . $result['category_prices_id'] . $url)
				);
			}

			$data['products'] = array();

			$filter_data = array(
				'filter_category_prices_id' => $category_prices_id,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);

			/*$product_total = $this->model_extension_prices->getTotalAlbums($filter_data);

			$results = $this->model_extension_prices->getAlbums($filter_data);
			
			$downloads = array();
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				}
				
				$data['products'][] = array(
					'price_id'    => $result['price_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '...',
					'href'        => $this->url->link('information/prices', 'path=' . $this->request->get['path'] . '&price_id=' . $result['price_id'] . $url)
				);
			}*/
			
			$product_total = $this->model_extension_prices->getTotalAlbums($filter_data);
		
			$results = $this->model_extension_prices->getAlbums($filter_data);
		
			$downloads = array();
			
			$data['albums'] = array();
		
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
				} else {
					$image = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));;
				}
		
				//Download
				$this->load->model('extension/prices');
		
				$download = $this->model_extension_prices->getDownloads($result['price_id'], 0, 10);
		
				foreach ($download as $download_file) {
					if (file_exists(DIR_DOWNLOAD . $download_file['filename'])) {
						$size = filesize(DIR_DOWNLOAD . $download_file['filename']);
		
						$i = 0;
		
						$suffix = array(
							'B',
							'KB',
							'MB',
							'GB',
							'TB',
							'PB',
							'EB',
							'ZB',
							'YB'
						);
		
						while (($size / 1024) > 1) {
							$size = $size / 1024;
							$i++;
						}
		
						$downloads[] = array(
						  'price_id'	 => $download_file['price_id'],
							'date_added' => date($this->language->get('date_format_short'), strtotime($download_file['date_added'])),
							'name'       => $download_file['name'],
							'size'       => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
							'href'       => $this->url->link('information/category_prices/download', 'download_id=' . $download_file['download_id'], 'SSL')
						);
					}
				}
		
				$data['albums'][] = array(
					'price_id'    => $result['price_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'category_text' => $result['category_text'],
					//'href'        => $this->url->link('information/prices', '&price_id=' . $result['price_id'] ),
					'href'        => $this->url->link('information/prices', 'link=' . $this->request->get['link'] . '&price_id=' . $result['price_id'] . $url),
					'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'short_description' => html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8'),
					'downloads' => $downloads
				);
			}
			
			
			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('information/category_prices', 'link=' . $this->request->get['link'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('information/category_prices', 'link=' . $this->request->get['link'] . $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('information/category_prices', 'link=' . $category_info['category_prices_id'], 'SSL'), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('information/category_prices', 'link=' . $category_info['category_prices_id'], 'SSL'), 'prev');
			} else {
			    $this->document->addLink($this->url->link('information/category_prices', 'link=' . $category_info['category_prices_id'] . '&page='. ($page - 1), 'SSL'), 'prev');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('information/category_prices', 'link=' . $category_info['category_prices_id'] . '&page='. ($page + 1), 'SSL'), 'next');
			}

			$data['limit'] = $limit;

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/category_prices.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/category_prices.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/category_prices.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['link'])) {
				$url .= '&link=' . $this->request->get['link'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/category_prices', $url),
				'separator' => $this->language->get('text_separator')
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');
			
			$data['gallery'] = $this->url->link('gallery/album');
		
			$data['all_object'] = $this->url->link('product/category&path=59');
		
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}
	
	public function download() {

		$this->session->data['redirect'] = $this->url->link('information/prices', '', 'SSL');

		$this->load->model('extension/prices');

		if (isset($this->request->get['download_id'])) {
			$download_id = $this->request->get['download_id'];
		} else {
			$download_id = 0;
		}

		$download_info = $this->model_extension_prices->getDownload($download_id);

		if ($download_info) {
			$file = DIR_DOWNLOAD . $download_info['filename'];
			$mask = basename($download_info['mask']);

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					if (ob_get_level()) {
						ob_end_clean();
					}

					readfile($file, 'rb');

					exit();
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}
		} else {
			$this->response->redirect($this->url->link('information/prices', '', 'SSL'));
		}
	}
}
