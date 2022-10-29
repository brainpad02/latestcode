<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller
{

	function __construct()
	{
		parent:: __construct();
		$this->general->session_check();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{
		$data['title']        = 'Setting :: BrainPad Wave';
		$data['page']         = 'admin/page/setting/index';
		$data['gamesound']    = $this->db->get_where('gamesound')->row();
		$data['splashscreen'] = $this->db->get_where('splash')->row();
		$this->load->view('admin/partials/layout', $data);
	}

	public function setGameSound($id){
		if (isset($_FILES['file']) && ($_FILES['file']['name'] != '')) {
			$data['game_sound'] = $this->crud_model->sound_upload('file', 'game_sound');

			$this->db->where('gs_id', $id)->update('gamesound', $data);

			$this->session->set_flashdata('success', 'Setting successfully');
			redirect(base_url('backend/setting'), 'refresh');
		}
	}

	public function setSplashScreen($id){
		if (isset($_FILES['file']) && ($_FILES['file']['name'] != '')) {
			$data['sp_img_path'] = $this->crud_model->sound_upload('file', 'splashscreen');
		}
		$data['sp_name']    = $this->input->post('name');
		$data['sp_copy']    = $this->input->post('cpy');
		$data['sp_color']   = $this->input->post('color');

		$this->db->where('sp_id', $id)->update('splash', $data);

		$this->session->set_flashdata('success', 'Setting successfully');
		redirect(base_url('backend/setting'), 'refresh');
	}

	public function next_level_details($id){ 
		$data = array(
			'unlock_min_star'=>$this->input->post('unlock_star'),
			'ulock_usage_time'=>$this->input->post('unlock_time'),
		);

		$this->db->where('sp_id', $id)->update('splash', $data);

		$this->session->set_flashdata('success', 'Setting successfully');
		redirect(base_url('backend/setting'), 'refresh');
	}


}
