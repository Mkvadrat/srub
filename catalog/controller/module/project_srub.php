<?php
class ControllerModuleProjectSrub extends Controller {
	public function index() {
		$this->load->language('module/project_srub');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();
		
		$data['all_object'] = $this->url->link('product/category&path=59', '');
		
		$categories = $this->model_catalog_category->getCategories(59);

		foreach ($categories as $category) {
			
			//var_dump($category);
			$children_data = array();

			if ($category['category_id'] == $data['category_id']) {
				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach($children as $child) {
					$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

					$children_data[] = array(
						'category_id' => $child['category_id'],
						'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}
			}

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);
			
			$this->load->model('tool/image');

			if ($category['image']) {
				$image = $this->model_tool_image->resize($category['image'], '542', '408');
			} else {
				$image = $this->model_tool_image->resize('no_image.png', '542', '408');
			}

			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'image'       => $image,
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/project_srub.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/project_srub.tpl', $data);
		} else {
			return $this->load->view('default/template/module/project_srub.tpl', $data);
		}
	}
}