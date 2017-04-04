<?php
class ControllerCommonImageManager extends Controller {
	public function index() {

		$this->load->language('common/imagemanager');

		$this->document->setTitle($this->language->get('text_imagemanager'));

		$data['heading_title'] = $this->language->get('text_imagemanager');

		if (isset($this->request->get['thumb'])) {
            $data['thumb'] = $this->request->get['thumb'];
        } else {
            $data['thumb'] = '';
        }

		if (isset($this->request->get['target'])) {
            $data['target'] = $this->request->get['target'];
        } else {
            $data['target'] = '';
        }

		if ($this->config->get('imagemanager_language')) {
			$data['language'] = strtolower($this->config->get('imagemanager_language'));
		} else {
			$data['language'] = 'en';
		}

		$this->response->setOutput($this->load->view('common/imagemanager.tpl', $data));

	}

	public function getTmb(){
		$this->load->model('tool/image');

		if (isset($this->request->get['thumb'])) {
			$link = urldecode($this->request->get['thumb']);
		}

		$data['thumb'] = $this->model_tool_image->resize($link, 100, 100);

		$this->response->setOutput(json_encode($data));
	}

	public function init(){

		include_once DIR_SYSTEM . 'library/imagemanager/elFinderConnector.class.php';
		include_once DIR_SYSTEM . 'library/imagemanager/elFinder.class.php';
		include_once DIR_SYSTEM . 'library/imagemanager/elFinderVolumeDriver.class.php';
		include_once DIR_SYSTEM . 'library/imagemanager/elFinderVolumeLocalFileSystem.class.php';

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			   $catalog_protocol = HTTPS_CATALOG;
		} else {
			  $catalog_protocol = HTTP_CATALOG;
		}

		$opts = array(
			'debug' => true,

			'roots' => array(
				array(
					'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
					'path'          => DIR_IMAGE . 'catalog/',         // path to files (REQUIRED)
					'URL'           => $catalog_protocol . 'image/catalog/', // URL to files (REQUIRED)
					'accessControl' => 'access' ,            // disable and hide dot starting files (OPTIONAL)
					//'alias'=>'Images',
					'defaults' => array('read' => true, 'write' => true),
					'uploadMaxSize'=>'250M',
					'uploadAllow' => array(
						'image/jpeg',
						'image/pjpeg',
						'image/png',
						'image/x-png',
						'image/gif',
						'application/x-shockwave-flash'
					),
					'uploadOverwrite'=>true,
					'uploadOrder'=> array( 'allow', 'deny' ),
					'attributes' => array(
						array(
							'pattern' => '~/\.~',
							// 'pattern' => '/^\/\./',
							'read' => true,
							'write' => true,
							'hidden' => true,
							'locked' => false
						)
					)
				)
			)
		);

		// run elFinder
		$connector = new elFinderConnector(new elFinder($opts));
		$connector->run();

	}
}
