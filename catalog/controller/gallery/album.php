<?php
class ControllerGalleryAlbum extends Controller {
	public function index() {
		$this->load->language('gallery/album');

		$this->load->model('gallery/album');

		$this->load->model('tool/image');

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'a.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('og_album_per_page');
		}

		// Set the last category breadcrumb
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => $this->language->get('text_separator')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_gallery_album'),
			'href'      => $this->url->link('gallery/album', $url),
			'separator' => $this->language->get('text_separator')
		);

		if (isset($this->request->get['album_id'])) {
			$album_id = (int)$this->request->get['album_id'];
		} else {
			$album_id = 0;
		}

		$album_info = $this->model_gallery_album->getAlbum($album_id);

		if ($album_info) {
			$this->document->setTitle($album_info['name']);
			$this->document->setDescription($album_info['meta_description']);
			$this->document->setKeywords($album_info['meta_keyword']);

			$data['heading_title'] = $album_info['name'];

			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_write'] = $this->language->get('text_write');
			$data['text_note'] = $this->language->get('text_note');
			$data['text_share'] = $this->language->get('text_share');
			$data['text_wait'] = $this->language->get('text_wait');

			$data['text_list'] = $this->language->get('text_list');
			$data['text_grid'] = $this->language->get('text_grid');
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');

			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_review'] = $this->language->get('entry_review');
			$data['entry_rating'] = $this->language->get('entry_rating');
			$data['entry_good'] = $this->language->get('entry_good');
			$data['entry_bad'] = $this->language->get('entry_bad');
			$data['entry_captcha'] = $this->language->get('entry_captcha');

			$data['tab_description'] = $this->language->get('tab_description');
			$data['tab_review'] = sprintf($this->language->get('tab_review'), $album_info['reviews']);

			$data['button_continue'] = $this->language->get('button_continue');

			$data['breadcrumbs'][] = array(
				'text'      => $album_info['name'],
				'href'      => $this->url->link('gallery/album', 'album_id=' . $this->request->get['album_id'] . $url),
				'separator' => $this->language->get('text_separator')
			);

			$data['album_id'] = $this->request->get['album_id'];

			$this->load->model('tool/image');

			if ($album_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($album_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			} else {
				$data['popup'] = '';
			}

			if ($album_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($album_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			} else {
				$data['thumb'] = '';
			}

			$data['images'] = array();

			$results = $this->model_gallery_album->getAlbumImages($this->request->get['album_id']);

			foreach ($results as $result) {
				$data['images'][] = array(
					'name'  => $result['name'],
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
				);
			}

			$data['description'] = html_entity_decode($album_info['description'], ENT_QUOTES, 'UTF-8');

			$data['viewed'] = $album_info['viewed'];

			$data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$album_info['reviews']);
			$data['rating'] = (int)$album_info['rating'];

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('gallery/album', 'album_id=' . $this->request->get['album_id'] . '&sort=a.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('gallery/album', 'album_id=' . $this->request->get['album_id'] . '&sort=ad.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('gallery/album', 'album_id=' . $this->request->get['album_id'] . '&sort=ad.name&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('gallery/album', 'album_id=' . $this->request->get['album_id'] . '&sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('gallery/album', 'album_id=' . $this->request->get['album_id'] . '&sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('gallery/album', 'album_id=' . $this->request->get['album_id'] . '&sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('gallery/album', 'album_id=' . $this->request->get['album_id'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['continue_album'] = $this->url->link('gallery/album');
			$data['home'] = $this->url->link('common/home');

			$this->model_gallery_album->updateViewed($this->request->get['album_id']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/gallery/album_info.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/gallery/album_info.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/gallery/album_info.tpl', $data));
			}

		} else {

			$url = '';

			if (isset($this->request->get['album_id'])) {
				$url .= '&album_id=' . $this->request->get['album_id'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if(isset($this->request->get['album_id'])) {

				$data['breadcrumbs'][] = array(
					'text'      => $this->language->get('text_error'),
					'href'      => $this->url->link('gallery/album', $url),
					'separator' => $this->language->get('text_separator')
				);

				$this->document->setTitle($this->language->get('text_error'));

				$data['heading_title'] = $this->language->get('text_error');

				$data['text_error'] = $this->language->get('text_error');

				$data['button_continue'] = $this->language->get('button_continue');

				$data['continue'] = $this->url->link('common/home');

				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');

				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
				} else {
					$this->template = 'default/template/error/not_found.tpl';
				}

			} else {

				$this->document->setTitle($this->language->get('heading_title'));

				$data['heading_title'] = $this->language->get('heading_title');

				$data['text_display'] = $this->language->get('text_display');
				$data['text_list'] = $this->language->get('text_list');
				$data['text_grid'] = $this->language->get('text_grid');
				$data['text_sort'] = $this->language->get('text_sort');
				$data['text_limit'] = $this->language->get('text_limit');

				$data['continue'] = $this->url->link('common/home');

				if (isset($this->request->get['sort'])) {
					$sort = $this->request->get['sort'];
				} else {
					$sort = 'a.sort_order';
				}

				if (isset($this->request->get['order'])) {
					$order = $this->request->get['order'];
				} else {
					$order = 'ASC';
				}

				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}

				if (isset($this->request->get['limit'])) {
					$limit = $this->request->get['limit'];
				} else {
					//Кол-ва на вывод(пагинация)
					//$limit = $this->config->get('config_product_limit');
					$limit = 999;
				}


				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['albums'] = array();

				$data_albums = array(
					'sort'               => $sort,
					'order'              => $order,
					'start'              => ($page - 1) * $limit,
					'limit'              => $limit
				);

				$album_total = $this->model_gallery_album->getTotalAlbums($data_albums);

				$results = $this->model_gallery_album->getAlbums($data_albums);


				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], '542', '406');
					} else {
						$image = false;
					}

					$data['albums'][] = array(
						'album_id'  => $result['album_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
						'href'        => $this->url->link('gallery/album', '&album_id=' . $result['album_id'] ),
						'date_added' 	=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					);
				}

				$url = '';

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['sorts'] = array();

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_default'),
					'value' => 'a.sort_order-ASC',
					'href'  => $this->url->link('gallery/album', '&sort=a.sort_order&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_name_asc'),
					'value' => 'ad.name-ASC',
					'href'  => $this->url->link('gallery/album', '&sort=ad.name&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_name_desc'),
					'value' => 'ad.name-DESC',
					'href'  => $this->url->link('gallery/album', '&sort=ad.name&order=DESC' . $url)
				);

				if ($this->config->get('config_review_status')) {
					$data['sorts'][] = array(
						'text'  => $this->language->get('text_rating_desc'),
						'value' => 'rating-DESC',
						'href'  => $this->url->link('gallery/album', '&sort=rating&order=DESC' . $url)
					);

					$data['sorts'][] = array(
						'text'  => $this->language->get('text_rating_asc'),
						'value' => 'rating-ASC',
						'href'  => $this->url->link('gallery/album', '&sort=rating&order=ASC' . $url)
					);
				}

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_viewed_asc'),
					'value' => 'a.viewed-ASC',
					'href'  => $this->url->link('gallery/album', '&sort=a.viewed&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_viewed_desc'),
					'value' => 'a.viewed-DESC',
					'href'  => $this->url->link('gallery/album', '&sort=a.viewed&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_date_asc'),
					'value' => 'a.date_added-ASC',
					'href'  => $this->url->link('gallery/album', '&sort=a.date_added&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_date_desc'),
					'value' => 'a.date_added-DESC',
					'href'  => $this->url->link('gallery/album', '&sort=a.date_added&order=DESC' . $url)
				);

				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				$data['limits'] = array();

				$limits = array_unique(array($this->config->get('og_album_per_page'), $this->config->get('og_album_per_page')*2, $this->config->get('og_album_per_page')*4, $this->config->get('og_album_per_page')*8, $this->config->get('og_album_per_page')*16 ));

				sort($limits);

				foreach($limits as $value){
					$data['limits'][] = array(
						'text'  => $value,
						'value' => $value,
						'href'  => $this->url->link('gallery/album', $url . '&limit=' . $value)
					);
				}

				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$pagination = new Pagination();
				$pagination->total = $album_total;
				$pagination->page = $page;
				$pagination->limit =  $limit;
				$pagination->text = $this->language->get('text_pagination');
				$pagination->url = $this->url->link('gallery/album', $url . '&page={page}');

				$data['pagination'] = $pagination->render();
				$data['results'] = sprintf($this->language->get('text_pagination'), ($album_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($album_total - $limit)) ? $album_total : ((($page - 1) * $limit) + $limit), $album_total, ceil($album_total / $limit));


				$data['sort'] = $sort;
				$data['order'] = $order;
				$data['limit'] = $limit;

				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/gallery/album.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/gallery/album.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/gallery/album.tpl', $data));
				}

			}
		}
	}
}
?>
