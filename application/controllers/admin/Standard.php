<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Standard extends CI_Controller {

	private $language;

	function __construct()
	{
		parent:: __construct();
		$this->general->session_check();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->language = $this->crud_model->getLanguage();
	}
	public function index()
	{
		$data['title']  = 'Standards :: BrainPad Wave';
		$data['action'] = base_url('backend/standard/store');
		$data['page']   = 'admin/page/standard/index';
		$data['rec']    = $this->db->join('board','board.bd_id=standard.board_id','left')->where('standard.lang',$this->language)
			->order_by("standard.sequence","asc")->get('standard')->result_array();
		$data['board']  = $this->crud_model->get_table_data('board','lang',$this->language);
		$data['method'] = 'create';
		$this->load->view('admin/partials/layout',$data);
	}

	public function store()
	{
		$get_data = $this->db->select_max('sequence')->where('board_id',$this->input->post('board_id'))->get('standard')->result();
		if(!empty($get_data)){
			$sequence = $get_data[0]->sequence + 1 ;
		} else {
			$sequence = 1;
		}
		
		$data = [
			'ad_id'      => $this->session->userdata('brain_sess')['id'],
			'std_name'   => $this->input->post('name'),
			'created_at' => date('Y-m-d H:i:s'),
			'lang'       => $this->crud_model->getLanguage(),
			'board_id'   => $this->input->post('board_id'),
			'sequence'   => $sequence,
		];

		$res = $this->db->insert('standard',$data);
		// $this->crud_model->addSequence('standard','std_id',$this->db->insert_id());


		if($res)
		{
			$this->session->set_flashdata('success','Standard Added successfully');
			redirect(base_url('backend/standard'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something wrong');
			redirect(base_url('backend/standard'),'refresh');
		}

	}

	public function edit($id)
	{
		$data['title']     = 'Standard -Edit :: BrainPad Wave';
		$data['action']    = base_url('backend/standard/update/'.$id);
		$data['page']      = 'admin/page/standard/index';
		$data['rec']       = $this->db->join('board','board.bd_id=standard.board_id','left')->where('standard.lang',$this->language)
			->order_by("standard.sequence","asc")->get('standard')->result_array();
		$data['board']     =  $this->crud_model->get_table_data('board','lang',$this->language);
		$data['editData']  = $this->crud_model->get_single_row('standard','std_id',$id);
		$data['method']    = 'edit';

		$this->load->view('admin/partials/layout',$data);
	}

	public function update($id)
	{
		$name = $this->input->post('name');
		$updData = ['std_name'=>$name , 'lang' => $this->crud_model->getLanguage(), 'board_id' => $this->input->post('board_id')];
		$res = $this->db->where('std_id',$id)->update('standard', $updData);
		if($res)
		{
			$this->session->set_flashdata('success','Standards updated successfully');
			redirect(base_url('backend/standard'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('err','Something wrong when updated Standards');
			redirect(base_url('backend/standard'),'refresh');
		}
	}

	public function remove($id)
	{
		$this->db->where('std_id', $id);
		$this->db->delete('standard');

		$this->session->set_flashdata('success','Standard remove successfully');
		redirect(base_url('backend/standard'));
	}

	public function status($id, $status)
	{
		$upd_res = "";
		if($status==1)
		{
			$upd_res = $this->db->where('std_id',$id)->update('standard',['std_status'=>0]);
		}
		else
		{
			$upd_res = $this->db->where('std_id',$id)->update('standard',['std_status'=>1]);
		}
		if($upd_res)
		{
			$this->session->set_flashdata('success','Status Updated Successfully');
			redirect(base_url('backend/standard'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('err','Something went wrong');
			redirect(base_url('backend/standard'),'refresh');
		}
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);

			$this->db->where_in('std_id', $ids)->delete('standard');
			$this->session->set_flashdata('success', 'Data Deleted successfully');
			echo 'Deleted successfully.';
		} else {
			$this->session->set_flashdata('error', 'Error');
			echo 'Error';
		}
	}

}
