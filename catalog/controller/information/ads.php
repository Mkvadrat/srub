<?php
class ControllerInformationAds extends Controller {
	public function index() {
		$this->language->load('information/ads');
		
		$this->load->model('extension/ads');
	 
		$this->document->setTitle($this->language->get('heading_title')); 
	 
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' 		=> 'Главная',
			'href' 		=> $this->url->link('common/home'),
			'separator' => $this->language->get('text_separator')
		);
		$data['breadcrumbs'][] = array(
			'text' 		=> $this->language->get('heading_title'),
			'href' 		=> $this->url->link('information/ads'),
			'separator' => $this->language->get('text_separator')
		);
		  
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}	

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}
		
		$filter_data = array(
			'page' 	=> $page,
			'limit' => 10,
			'start' => 10 * ($page - 1),
		);
		
		$total = $this->model_extension_ads->getTotalAds();
		
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_product_limit');;
		$pagination->url = $this->url->link('information/ads', 'page={page}');
		
		$data['pagination'] = $pagination->render();
	 
		$data['results'] = sprintf($this->language->get('text_pagination'), ($total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($total - 10)) ? $total : ((($page - 1) * 10) + 10), $total, ceil($total / 10));

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_title'] = $this->language->get('text_title');
		$data['text_description'] = $this->language->get('text_description');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_view'] = $this->language->get('text_view');
		$data['continue'] = $this->url->link('common/home');
	
		$all_ads = $this->model_extension_ads->getAllAds($filter_data);
	 
		$data['all_ads'] = array();
		
		$this->load->model('tool/image');
	 
		foreach ($all_ads as $ads) {
			$data['all_ads'][] = array (
				'title' 		=> $ads['title'],
				'image'			=> $this->model_tool_image->resize($ads['image'], '189', '140'),
				'description' => utf8_substr(strip_tags(html_entity_decode($ads['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
				'view' 			=> $this->url->link('information/ads/ads', 'ads_id=' . $ads['ads_id']),
				'date_added' 	=> date($this->language->get('date_format_short'), strtotime($ads['date_added']))
			);
		}
	 
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/ads_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/ads_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/ads_list.tpl', $data));
		}
	}
 
	public function ads() {
		$this->load->model('extension/ads');
	  
		$this->language->load('information/ads');
 
		if (isset($this->request->get['ads_id']) && !empty($this->request->get['ads_id'])) {
			$ads_id = $this->request->get['ads_id'];
		} else {
			$ads_id = 0;
		}
 
		$ads = $this->model_extension_ads->getAds($ads_id);
 
		$data['breadcrumbs'] = array();
	  
		$data['breadcrumbs'][] = array(
			'text' 			=> 'Главная',
			'href' 			=> $this->url->link('common/home'),
			'separator' => $this->language->get('text_separator')
		);
	  
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/ads'),
			'separator' => $this->language->get('text_separator')
		);
 
		if ($ads) {
			$data['breadcrumbs'][] = array(
				'text' 		=> $ads['title'],
				'href' 		=> $this->url->link('information/ads/ads', 'ads_id=' . $ads_id),
				'separator' => $this->language->get('text_separator')
			);
 
			$this->document->setTitle($ads['title']);
			
			$this->load->model('tool/image');
			
			$data['image'] = $this->model_tool_image->resize($ads['image'], 200, 200);
 
			$data['heading_title'] = $ads['title'];
			$data['description'] = html_entity_decode($ads['description']);
			$data['date_added'] = date('d.m.Y', strtotime($ads['date_added']));
			$data['project_srub'] = $this->url->link('product/category&path=59');
			$data['gallery'] = $this->url->link('gallery/album');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/ads.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/ads.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/ads.tpl', $data));
			}
		} else {
			$data['breadcrumbs'][] = array(
				'text' 		=> $this->language->get('text_error'),
				'href' 		=> $this->url->link('information/ads', 'ads_id=' . $ads_id),
				'separator' => $this->language->get('text_separator')
			);
	 
			$this->document->setTitle($this->language->get('text_error'));
	 
			$data['heading_title'] = $this->language->get('text_error');
			$data['text_error'] = $this->language->get('text_error');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['continue'] = $this->url->link('common/home');
	 
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
}