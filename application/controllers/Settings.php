<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {
	private $_pages = array(
		'admins' => array(
				'add' => 'admins_add',
				'edit' => 'admins_edit',
				'list' => 'admins', 
			),
		'groups' => array(
				'add' => 'admingroups_add',
				'edit' => 'admingroups_edit',
				'list' => 'admingroups', 
			),
	);
	public function index()
	{ 
		if ($this->User_model->verifyUser()) {
			redirect(base_url(), 'auto');
		} 
	}

	public function admins($page = 'list', $adminid = 0) {
		if ($adminid == null) {
			$adminid = 0;
		}
		if ($this->input->post()){
			$postData = $this->input->post();
			$this->User_model->updateAdmins($postData, $postData["action"]);
		}
		if (!in_array($page, array('add', 'edit', 'list'))) {
			$page = "list";
		}
		switch ($page) {
			case 'add':
				$data["admin_groups"] = $this->User_model->getAdminGroups();
				break;
			case 'edit': 
				$data["admin_groups"] = $this->User_model->getAdminGroups();
				$data["result"] = $this->User_model->getAdminInfo($adminid);
				break;
			default:
				$data["admins"] = $this->User_model->getAdmins();
				break;
		}
		$this->_getTemplate('admins', $page, $data);
	}

	public function groups($page = 'list', $groupid = 0) {
		if ($this->User_model->verifyUser()) {
			if ($this->input->post()){
				$postData = $this->input->post();
				$this->User_model->updateGroups($postData, $postData["action"]);
			}
			if (!in_array($page, array('add', 'edit', 'list'))) {
				$page = "list";
			}
			switch ($page) {
				case 'add':
					$data = array();
					break;
				case 'edit': 
					$data["result"] = $this->User_model->getAdminGroups($groupid);
					break;
				default:
					$data["groups"] = $this->User_model->getAdminGroups();
					break;
			}
			$this->_getTemplate('groups', $page, $data);
		}
	}

	private function _getTemplate($action, $option, $data) {
		if (isset($this->_pages[$action][$option])) {
			$this->loadLayout("settings/". $this->_pages[$action][$option], $data);
		} else {
			die("Error: template $action/$option not found");
		}
	}
}
