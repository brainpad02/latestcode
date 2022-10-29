<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent:: __construct();
	}

	public function index()
	{
		// echo $this->encryption->encrypt('123456');
		$this->session_check();
		$data['title'] = 'TeacherLogin :: BrainPad Wave';
		$data['action'] = base_url('teachers/authenticate');

		$this->load->view('teachers/auth/login',$data);
	}


	public function authenticate()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$login_data = $this->db->where('username',$username)->where('password',$password)->get('users')->row();
		if(!empty($login_data))
		{
			$pass = $this->input->post('password');
			if($pass==$password)
			{
				$sess = array(
					'name'      => $login_data->username,
					'email'     => $login_data->email_id,
					'mobile'    => $login_data->phone_no,
					'id'        => $login_data->user_id,
					'school_id'=> $login_data->school_id,
					'is_login'  => TRUE
				);
				$this->session->set_userdata('brain_sess',$sess);
				redirect(base_url('teachers/dashboard'));
			}
			else
			{
				$this->session->set_flashdata('error','Enter Password is invalid');
				redirect(base_url('teachers'));
			}
		}
		else
		{
			$this->session->set_flashdata('error','Enter Username is invalid');
			redirect(base_url('teachers'));
		}
	}


	public function session_check()
	{
		$sess = $this->session->userdata('brain_sess');
		if(!empty($sess))
		{
			redirect(base_url('teachers/dashboard'));
		}
	}


	public function logout()
	{
		$unset_data = $this->session->sess_destroy();
		redirect(base_url('teachers'));
	}
}
