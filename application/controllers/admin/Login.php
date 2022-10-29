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
		$data['title'] = 'AdminLogin :: BrainPad Wave';
		$data['action'] = base_url('backend/authenticate');

		$this->load->view('admin/auth/login',$data);
	}


	public function authenticate()
	{
		$username = $this->input->post('email');
		$password = $this->input->post('password');

		$login_data = $this->db->get_where('admin',['ad_email'=>$username])->row();
		if(!empty($login_data))
		{
			$pass = $this->encryption->decrypt($login_data->ad_password);
			if($pass==$password)
			{
				$sess = array(
					'name'      => $login_data->ad_name,
					'email'     => $login_data->ad_email,
					'mobile'    => $login_data->ad_mobile,
					'id'        => $login_data->id,
					'is_login'  => TRUE
				);
				$this->session->set_userdata('brain_sess',$sess);
				redirect(base_url('backend/dashboard'));
			}
			else
			{
				$this->session->set_flashdata('error','Enter Password is invalid');
				redirect(base_url('backend'));
			}
		}
		else
		{
			$this->session->set_flashdata('error','Enter Email is invalid');
			redirect(base_url('backend'));
		}
	}


	public function session_check()
	{
		$sess = $this->session->userdata('brain_sess');
		if(!empty($sess))
		{
			redirect(base_url('backend/dashboard'));
		}
	}


	public function logout()
	{
		$unset_data = $this->session->sess_destroy();
		redirect(base_url('backend'));
	}
}
