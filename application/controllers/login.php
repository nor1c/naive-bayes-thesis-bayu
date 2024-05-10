<?php

class Login extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->load->view('login');
	}

	public function sign() {
		$this->session->set_userdata(array('authorized' => true));

		redirect('');
	}

	public function logout() {
		$this->session->set_userdata(array('authorized' => false));

		redirect('');
	}
}
