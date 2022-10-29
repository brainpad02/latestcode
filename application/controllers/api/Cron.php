<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends BD_Controller
{

	function __construct()
	{
		parent:: __construct();
	}

    public function update_app_usage_time(){
        $data = array(
			'daily_app_usage_time'=>0,
		);

		$this->db-update('users', $data);
    }
}
