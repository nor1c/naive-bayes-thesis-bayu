<?php

class MY_Controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array(
			'url',
			'form',
			'file',
		));

		$this->load->library(array(
			'session',
			'form_validation',
		));
	}
}
