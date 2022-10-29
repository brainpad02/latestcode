<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends CI_Controller {

	private $language;

	function __construct()
	{
		parent::__construct();

		$this->general->session_check();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->language = $this->crud_model->getLanguage();
	}

	public function index()
	{
		$data['title'] 		= 'Board :: BrainPad Wave';
		$data['action'] 	= base_url('backend/board/store');
		$data['page'] 		= 'admin/page/board/index';
		$data['rec'] 		= $this->crud_model->get_table_data('board','lang',$this->language);
		$data['method'] 	= 'create';

		$this->load->view('admin/partials/layout',$data);
	}

	public function store()
	{
		$data['bd_name']     = $this->input->post('bd_name');
		$data['ad_id']       = $this->session->userdata('brain_sess')['id'];
		$data['created_at']  = date('Y-m-d H:i:s');
		$data['lang']        = $this->crud_model->getLanguage();
		$data['bd_img_path'] = $this->crud_model->file_up($_FILES['file'],'boards');

		$this->db->insert('board', $data);

		 $this->session->set_flashdata('success','Board added successfully');
		 redirect(base_url('backend/board'),'refresh');
	}

	public function edit($id)
	{
		$data['title'] 		= 'Board - Edit :: BrainPad Wave';
		$data['action'] 	= base_url('backend/board/update/'.$id);
		$data['page'] 		= 'admin/page/board/index';
		$data['rec'] 		= $this->crud_model->get_table_data('board');
		$data['editData']   = $this->crud_model->get_single_row('board','bd_id',$id);
		$data['method'] 	= 'edit';

		$this->load->view('admin/partials/layout',$data);
	}

	public function update($id)
	{
		$data['bd_name']     = $this->input->post('bd_name');
		$data['lang']        = $this->crud_model->getLanguage();
		if($_FILES['file']['name'] != ''){
			$data['bd_img_path'] = $this->crud_model->file_up($_FILES['file'],'boards');
		}

		$this->db->where('bd_id', $id)->update('board', $data);

		$this->session->set_flashdata('success','Board update successfully');
		redirect(base_url('backend/board'));
	}

	public function remove($id)
	{
		unlink("uploads/boards/" .$this->crud_model->get_type_name_by_id('board','bd_id',$id,'bd_img_path'));
		$this->db->where('bd_id', $id);
		$this->db->delete('board');

		$this->session->set_flashdata('success','Board update successfully');
		redirect(base_url('backend/board'));
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);

			$this->db->where_in('bd_id', $ids)->delete('board');
			$this->session->set_flashdata('success', 'Data Deleted successfully');
			echo 'Deleted successfully.';
		} else {
			$this->session->set_flashdata('error', 'Error');
			echo 'Error';
		}
	}
}
