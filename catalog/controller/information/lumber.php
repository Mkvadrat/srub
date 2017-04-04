<?php
class ControllerInformationLumber extends Controller {
	public function index() {
		$this->load->language('information/lumber');

		$this->load->model('extension/lumber');

		$this->load->model('tool/image');

		// Set the last category breadcrumb
		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => $this->language->get('text_separator')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_extension_lumber'),
			'href'      => $this->url->link('information/lumber', $url),
			'separator' => $this->language->get('text_separator')
		);

		if (isset($this->request->get['lumber_id'])) {
			$lumber_id = (int)$this->request->get['lumber_id'];
		} else {
			$lumber_id = 0;
		}

		$album_info = $this->model_extension_lumber->getAlbum($lumber_id);

		if ($album_info) {
			$this->document->setTitle($album_info['name']);
			$this->document->setDescription($album_info['meta_description']);
			$this->document->setKeywords($album_info['meta_keyword']);

			$data['heading_title'] = $album_info['name'];
			$data['description'] = html_entity_decode($album_info['description'], ENT_QUOTES, 'UTF-8');
			$data['name_gallery'] = $album_info['name_gallery'];
			$data['short_description'] = html_entity_decode($album_info['short_description'], ENT_QUOTES, 'UTF-8');
			$data['back_lumber'] = $this->url->link('information/lumber');
			$data['home'] = $this->url->link('common/home');

			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_write'] = $this->language->get('text_write');
			$data['text_note'] = $this->language->get('text_note');
			$data['text_share'] = $this->language->get('text_share');
			$data['text_wait'] = $this->language->get('text_wait');

			$data['entry_name'] = $this->language->get('entry_name');

			$data['text_extension_lumber'] = $this->language->get('text_extension_lumber');

			$data['tab_description'] = $this->language->get('tab_description');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['breadcrumbs'][] = array(
				'text'      => $album_info['name'],
				'href'      => $this->url->link('information/lumber', 'lumber_id=' . $this->request->get['lumber_id'] . $url),
				'separator' => $this->language->get('text_separator')
			);

			$data['lumber_id'] = $this->request->get['lumber_id'];

			$this->load->model('tool/image');

			if ($album_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($album_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			} else {
				$data['popup'] = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			}

			$data['images'] = array();

			//Download
			$this->load->model('extension/lumber');

			$data['downloads'] = array();

			$download = $this->model_extension_lumber->getDownloads($this->request->get['lumber_id'], 0, 10);

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

					$data['downloads'][] = array(
						'date_added' => date($this->language->get('date_format_short'), strtotime($download_file['date_added'])),
						'name'       => $download_file['name'],
						'size'       => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
						'href'       => $this->url->link('information/lumber/download', 'download_id=' . $download_file['download_id'], 'SSL')
					);
				}
			}

			$results = $this->model_extension_lumber->getAlbumImages($this->request->get['lumber_id']);

			foreach ($results as $result) {
				$data['images'][] = array(
					'name'  => $result['name'],
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
				);
			}

			$data['description'] = html_entity_decode($album_info['description'], ENT_QUOTES, 'UTF-8');

			$data['viewed'] = $album_info['viewed'];

			$url = '';

			$this->model_extension_lumber->updateViewed($this->request->get['lumber_id']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/lumber_info.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/lumber_info.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/lumber_info.tpl', $data));
			}

		} else {

			$url = '';

			if(isset($this->request->get['lumber_id'])) {

				$data['breadcrumbs'][] = array(
					'text'      => $this->language->get('text_error'),
					'href'      => $this->url->link('information/lumber', $url),
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

				$data['continue'] = $this->url->link('common/home');

				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}

				if (isset($this->request->get['limit'])) {
					$limit = $this->request->get['limit'];
				} else {
					$limit = $this->config->get('config_product_limit');
				}

				$url = '';

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['albums'] = array();

				$data_albums = array(
					'start'              => ($page - 1) * $limit,
					'limit'              => $limit
				);

				$album_total = $this->model_extension_lumber->getTotalAlbums($data_albums);

				$results = $this->model_extension_lumber->getAlbums($data_albums);

				$downloads = array();

				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
					} else {
						$image = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));;
					}

					//Download
					$this->load->model('extension/lumber');

					$download = $this->model_extension_lumber->getDownloads($result['lumber_id'], 0, 10);

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
							  'lumber_id'	 => $download_file['lumber_id'],
								'date_added' => date($this->language->get('date_format_short'), strtotime($download_file['date_added'])),
								'name'       => $download_file['name'],
								'size'       => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
								'href'       => $this->url->link('information/lumber/download', 'download_id=' . $download_file['download_id'], 'SSL')
							);
						}
					}

					$data['albums'][] = array(
						'lumber_id'    => $result['lumber_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
						'category_text' => $result['category_text'],
						'href'        => $this->url->link('information/lumber', '&lumber_id=' . $result['lumber_id'] ),
						'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
						'short_description' => html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8'),
						'downloads' => $downloads
					);
				}

				$url = '';

				$pagination = new Pagination();
				$pagination->total = $album_total;
				$pagination->page = $page;
				$pagination->limit = 10;
				$pagination->text = $this->language->get('text_pagination');
				$pagination->url = $this->url->link('information/lumber', $url . '&page={page}');

				$data['pagination'] = $pagination->render();
				$data['results'] = sprintf($this->language->get('text_pagination'), ($album_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($album_total - 10)) ? $album_total : ((($page - 1) * 10) + 10), $album_total, ceil($album_total / 10));

				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/lumber.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/lumber.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/information/lumber.tpl', $data));
				}

			}
		}
	}

	public function download() {

		$this->session->data['redirect'] = $this->url->link('information/lumber', '', 'SSL');

		$this->load->model('extension/lumber');

		if (isset($this->request->get['download_id'])) {
			$download_id = $this->request->get['download_id'];
		} else {
			$download_id = 0;
		}

		$download_info = $this->model_extension_lumber->getDownload($download_id);

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
			$this->response->redirect($this->url->link('information/lumber', '', 'SSL'));
		}
	}
}
?>
