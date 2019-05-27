<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Products extends MY_Controller {

		public function __construct() {
			parent::__construct();
			$this->load->model('Categories_model', 'Categories');
    }

		public function index()	{
			$data = array('dtFields' => array('Name', 'Code', 'Price'));
			$this->loadTemplate('list', $data);
		}

		public function add() {
			$this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|max_length[255]|callback_nameUnique',
            				array('required' => 'You must provide a %s.'));
			$this->form_validation->set_rules('name', 'Code', 'required|min_length[3]|max_length[255]|callback_codeUnique',
            				array('required' => 'You must provide a %s.'));
			$prodCategories = $this->Categories->basicSelect(array('parent' => 0, 'status' => 1));
			$data = array('categories' => $prodCategories);
			if ($this->form_validation->run()) {
				$postRaw = array(
					'name' => $this->input->post('name'),
					'code' => $this->input->post('code'),
					'price' => $this->input->post('price'),
					'description' => $this->input->post('description'),
					'description_raw' => strip_tags($this->input->post('description'))
				);
				$postRaw['status'] = 0;
				if ($this->input->post('status')) {
					$postRaw['status'] = 1;
				}
				$post = $this->security->xss_clean($postRaw);
				try {
					$productId = $this->Products->insert($post);
					$categories = $this->security->xss_clean($this->input->post('categories'));
					foreach ($categories as $category) {
						$this->Products->insertRelation($productId, $category, 'product_categories');
					}
					redirect('products/');
				} catch (Exception $e) {
					$this->loadTemplate('error', array('error' => $e->getMessage()));
				}
			} else {
				$this->loadLayout('add', $data);
			}
		}

		public function edit($id = 0) {
			$this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|max_length[255]|callback_nameUnique',
          				array('required' => 'You must provide a %s.'));
			$this->form_validation->set_rules('name', 'Code', 'required|min_length[3]|max_length[255]|callback_codeUnique',
          				array('required' => 'You must provide a %s.'));
			$product = $this->Products->getOne($id);
			if (empty($product)) {
				redirect('products/');
			}
			$parents = $this->Categories->basicSelect(array('parent' => 0, 'status' => 1));
			$data = array('category' => $category, 'categories' => $parents);
			if ($this->form_validation->run()) {
				$postRaw = array(
					'name' => $this->input->post('name'),
					'code' => $this->input->post('code'),
					'price' => $this->input->post('price'),
					'description' => $this->input->post('description'),
					'description_raw' => strip_tags($this->input->post('description'))
				);
				$postRaw['status'] = 0;
				if ($this->input->post('status')) {
					$postRaw['status'] = 1;
				}
				$post = $this->security->xss_clean($postRaw);
				try {
					$productId = $this->Products->insert($post);

					redirect('products/');
				} catch (Exception $e) {
					$this->loadTemplate('error', array('error' => $e->getMessage()));
				}
			} else {
				$this->loadLayout('edit', $data);
			}
		}

		public function page() {
			$dtData = $this->security->xss_clean($_GET);
			$i = $dtData['start'];
			$categories = $this->Categories->getDtRows($dtData);
			foreach($categories as $loopIndex => $category){
        $i++;
        $categories[$loopIndex]['dt_id'] = $i;
      }

      $response = array(
        "draw" => $dtData['draw'],
        "recordsTotal" => $this->Categories->count(),
        "recordsFiltered" => $this->Categories->countDtFiltered($dtData),
        "data" => $categories,
      );
			echo json_encode($response);
		}

		public function delete($id) {
			$this->Categories->fakeDelete(array('id' => $id));
			redirect('categories/');
		}

		public function nameUnique($name) {
			if (!$this->isUNique('name', $name, $this->input->post('id'))) {
				$this->form_validation->set_message('nameUnique', 'This name is already taken. Please choose another');
        return FALSE;
			}
			return TRUE;
		}

		public function codeUnique($code) {
			if (!$this->isUNique('code', $code, $this->input->post('id'))) {
				$this->form_validation->set_message('codeUnique', 'This code is already taken. Please choose another');
        return FALSE;
			}
			return TRUE;
		}
	}