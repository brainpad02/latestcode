<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General {

	public function __construct()
	{
		$this->CI = &get_instance();
	}

	public function session_check()
	{
		if(!$this->CI->session->userdata('brain_sess'))
		{
			redirect(base_url('backend'));
			exit;
		}
	}
}
