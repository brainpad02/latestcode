<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent:: __construct();
		$this->general->session_check();
	}

	public function index()
	{
		redirect(base_url('backend/board'),'refresh');
	}
}
