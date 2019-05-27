<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Categories extends MY_Controller {

		public function __construct() {
			parent::__construct();
    }

		public function index()	{
			$data = array('dtFields' => array('Name'));
			$this->loadTemplate('list', $data);
		}

		public function add() {
			$this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|max_length[255]|callback_nameUnique',
            				array('required' => 'You must provide a %s.'));
			$parents = $this->Categories->basicSelect(array('parent' => 1, 'status' => 1));
			$data = array('categories' => $parents);
			if ($this->form_validation->run()) {
				$postRaw = array('name' => $this->input->post('name'), 'parent' => (int) $this->input->post('parent'));
				$postRaw['status'] = 0;
				if ($this->input->post('status')) {
					$postRaw['status'] = 1;
				}
				$post = $this->security->xss_clean($postRaw);
				try {
					$this->Categories->insert($post);
					redirect(controller());
				} catch (Exception $e) {
					$this->loadTemplate('error', array('error' => $e->getMessage()));
				}
			} else {
				$this->loadLayout('add', $data);
			}
		}

		public function edit($id = 0) {
			if ($id > 0) {
				$this->form_validation->set_rules('name', 'Name', 'required|min_length[3]|max_length[255]|callback_nameUnique');
				$category = $this->Categories->getOne($id);
				if (empty($category)) {
					redirect(controller());
				}
				$parents = $this->Categories->basicSelect(array('parent' => 0, 'status' => 1));
				$data = array('category' => $category, 'categories' => $parents);
			}
			if ($this->form_validation->run()) {
				$postRaw = array('name' => $this->input->post('name'), 'parent' => (int) $this->input->post('parent'));
				$postRaw['status'] = 0;
				if ($this->input->post('status')) {
					$postRaw['status'] = 1;
				}
				$post = $this->security->xss_clean($postRaw);
				try {
					$this->Categories->update($post, array('id' => $id));
					redirect(controller());
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
			redirect(controller());
		}

		public function nameUnique($name) {
			if (!$this->isUNique('name', $name, $this->input->post('id'))) {
				$this->form_validation->set_message('nameUnique', 'This name is already taken. Please choose another');
        return FALSE;
			}
			return TRUE;
		}
	}