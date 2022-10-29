<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->general->session_check();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{
		$data['title'] 	    	= 'Dashboard :: BrainPad Wave';
		$data['page'] 		    = 'admin/page/dashboard';
		$data['total_board'] 	= $this->crud_model->get_table_data('board');

		$this->load->view('admin/partials/layout',$data);
	}

}
