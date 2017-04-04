<?php
class ControllerInformationPartners extends Controller {
	public function index() {
		$this->language->load('information/partners');
		
		$this->load->model('extension/partners');
	 
		$this->document->setTitle($this->language->get('heading_title')); 
	 
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' 		=> 'Главная',
			'href' 		=> $this->url->link('common/home'),
			'separator' => $this->language->get('text_separator')
		);
		$data['breadcrumbs'][] = array(
			'text' 		=> $this->language->get('heading_title'),
			'href' 		=> $this->url->link('information/partners'),
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
		
		$total = $this->model_extension_partners->getTotalPartners();
		
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_product_limit');;
		$pagination->url = $this->url->link('information/partners', 'page={page}');
		
		$data['pagination'] = $pagination->render();
	 
		$data['results'] = sprintf($this->language->get('text_pagination'), ($total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($total - 10)) ? $total : ((($page - 1) * 10) + 10), $total, ceil($total / 10));

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_title'] = $this->language->get('text_title');
		$data['text_description'] = $this->language->get('text_description');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_view'] = $this->language->get('text_view');
		$data['continue'] = $this->url->link('common/home');
	
		$all_partners = $this->model_extension_partners->getAllPartners($filter_data);
	 
		$data['all_partners'] = array();
		
		$this->load->model('tool/image');
	 
		foreach ($all_partners as $partners) {
			$data['all_partners'][] = array (
				'title' 		=> $partners['title'],
				'image'			=> $this->model_tool_image->resize($partners['image'], '189', '140'),
				'description' => utf8_substr(strip_tags(html_entity_decode($partners['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
				'view' 			=> $this->url->link('information/partners/partners', 'partners_id=' . $partners['partners_id']),
				'date_added' 	=> date($this->language->get('date_format_short'), strtotime($partners['date_added']))
			);
		}
	 
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/partners_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/partners_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/partners_list.tpl', $data));
		}
	}
 
	public function partners() {
		$this->load->model('extension/partners');
	  
		$this->language->load('information/partners');
 
		if (isset($this->request->get['partners_id']) && !empty($this->request->get['partners_id'])) {
			$partners_id = $this->request->get['partners_id'];
		} else {
			$partners_id = 0;
		}
 
		$partners = $this->model_extension_partners->getPartners($partners_id);
 
		$data['breadcrumbs'] = array();
	  
		$data['breadcrumbs'][] = array(
			'text' 			=> 'Главная',
			'href' 			=> $this->url->link('common/home'),
			'separator' => $this->language->get('text_separator')
		);
	  
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/partners'),
			'separator' => $this->language->get('text_separator')
		);
 
		if ($partners) {
			$data['breadcrumbs'][] = array(
				'text' 		=> $partners['title'],
				'href' 		=> $this->url->link('information/partners/partners', 'partners_id=' . $partners_id),
				'separator' => $this->language->get('text_separator')
			);
 
			$this->document->setTitle($partners['title']);
			
			$this->load->model('tool/image');
			
			$data['image'] = $this->model_tool_image->resize($partners['image'], 200, 200);
 
			$data['heading_title'] = $partners['title'];
			$data['description'] = html_entity_decode($partners['description']);
			$data['date_added'] = date('d.m.Y', strtotime($partners['date_added']));
			$data['project_srub'] = $this->url->link('product/category&path=59');
			$data['gallery'] = $this->url->link('gallery/album');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/partners.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/partners.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/partners.tpl', $data));
			}
		} else {
			$data['breadcrumbs'][] = array(
				'text' 		=> $this->language->get('text_error'),
				'href' 		=> $this->url->link('information/partners', 'partners_id=' . $partners_id),
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