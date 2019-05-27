<?php
	class MY_Controller extends CI_Controller {
		private $_defaults = array(
			'header' => array('file' => 'header', 'data' => array()),
			'footer' => array('file' => 'footer', 'data' => array()),
		);
    public function __construct() {
			parent::__construct();
			$this->_verifyLogin();
			$this->load->model(ucfirst(controller()). '_model', ucfirst(controller()));
      $this->load->library('form_validation');
    }
    public function loadLayout($layout, $data = array(), $config = array()) {
    	$this->_loadLayout(controller(). '/' .$layout, $data, $config);
    }
    public function loadTemplate($layout, $data = array(), $config = array()) {
    	$this->_loadLayout('templates/'. $layout, $data, $config);
    }
    public function isUnique($field, $value, $id = 0) {
			$result = $this->{ucfirst(controller())}->basicSelect(array($field => $value));
			if (!empty($result) && $result[0]['id'] != (int)$id) {
        return FALSE;
			}
			return TRUE;
    }
    private function _loadLayout($layout, $data = array(), $config = array()) {
    	$header = $this->_resetViewData(isset($config['header']) && isset($config['header']['file']) ? $config['header'] : $this->_defaults['header']);
    	$footer = $this->_resetViewData(isset($config['footer']) && isset($config['header']['file']) ? $config['footer'] : $this->_defaults['footer']);
    	!empty($header['data']) ? $this->load->view($header['file'], $header['data']) : $this->load->view($header['file']);
    	!empty($data) ? $this->load->view($layout, $data) : $this->load->view($layout);
    	!empty($footer['data']) ? $this->load->view($footer['file'], $footer['data']) : $this->load->view($footer['file']);
    }
    private function _resetViewData($viewConfig) {
    	if (!isset($viewConfig['data'])) {
  			$viewConfig['data'] = array();
  		}
  		return $viewConfig;
    }
    private function _verifyLogin() {
    	if (!$this->User_model->verifyUser()) {
    		redirect(base_url(), 'auto');
    	}
    }
	}