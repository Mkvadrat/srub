<?php
class ControllerModuleOpencartGalleryAlbum extends Controller {
	public function index($setting) {
				
		$this->load->language('module/opencart_gallery_album');
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['button_cart'] = $this->language->get('button_cart');
				
		$this->load->model('gallery/album');
		
		$this->load->model('tool/image');

		$this->load->model('setting/setting');
		
		$data['albums'] = array();
		
		$data['all_gallery'] = $this->url->link('gallery/album','');
		
		$extensions = $this->model_setting_setting->getSetting('opencart_gallery_album'); 
		
		$settings = array_chunk($extensions['opencart_gallery_album_module'], 1);
						
		if($settings[0][0]['as'] == 1) {
			$image_width = 120;
			$image_height = 120;
		} else if ($settings[0][0]['as'] == 2) {
			$image_width = 160;
			$image_height = 160;
		} else if ($settings[0][0]['as'] == 3) { 
			$image_width = 542;
			$image_height = 408;
		}
		
		$results = $this->model_gallery_album->getModuleAlbum();
		
		$albums = array_slice($results, 0, (int)$settings[0][0]['limit']);
		
		foreach ($albums as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
			} else {
				$image = false;
			}
						
			$data['albums'][] = array(
				'album_id'   => $result['album_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'href'    	 => $this->url->link('gallery/album', 'album_id=' . $result['album_id']),
			);
		}
		
		if ($data['albums']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/opencart_gallery_album.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/opencart_gallery_album.tpl', $data);
			} else {
				return $this->load->view('default/template/module/opencart_gallery_album.tpl', $data);
			}
		}
	}
}
?>