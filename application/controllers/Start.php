<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Start extends MY_Controller {

	public function index()
	{ 
		$this->loadLayout('welcome_message');
	}
}
