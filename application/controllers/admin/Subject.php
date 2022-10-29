<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends CI_Controller {

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
		$data['title']  = 'Subject :: BrainPad Wave';
		$data['action'] = base_url('backend/subject/store');
		$data['page']   = 'admin/page/subject/index';
		$data['rec']    =  $this->db->select('board.*,standard.*,subject.*,subject.sequence as se')->join('board','board.bd_id=subject.board_id','left')->join('standard','standard.std_id=subject.std_id','left')
			->where('subject.lang',$this->language)->order_by("subject.sequence","asc")->get('subject')->result_array();
		$data['board']  =  $this->crud_model->get_table_data('board','lang',$this->language);
		$data['method'] = 'create';
		$this->load->view('admin/partials/layout',$data);
	}

	public function store()
	{
		$get_data = $this->db->select_max('sequence')->where('std_id',$this->input->post('std_id'))->where('board_id',$this->input->post('board_id'))->get('subject')->result();
		if(!empty($get_data)){
			$sequence = $get_data[0]->sequence + 1 ;
		} else {
			$sequence = 1;
		}

		$data = [
			'ad_id'      => $this->session->userdata('brain_sess')['id'],
			'sub_name'   => $this->input->post('name'),
			'lang'       => $this->language,
			'board_id'   => $this->input->post('board_id'),
			'std_id'     => $this->input->post('std_id'),
			'created_at' => date('Y-m-d H:i:s'),
			'sequence'   => $sequence,
		];

		$data['sub_img_path'] = $this->crud_model->file_up($_FILES['file'],'subjects');

		$res = $this->db->insert('subject',$data);
		// $this->crud_model->addSequence('subject','sub_id',$this->db->insert_id());

		if($res)
		{
			$this->session->set_flashdata('success','Subject Added successfully');
			redirect(base_url('backend/subject'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something wrong');
			redirect(base_url('backend/subject'),'refresh');
		}

	}

	public function edit($id)
	{
		$data['title']     = 'Subject -Edit :: BrainPad Wave';
		$data['action']    =  base_url('backend/subject/update/'.$id);
		$data['page']      = 'admin/page/subject/index';
		$data['rec']       = $this->db->select('board.*,standard.*,subject.*,subject.sequence as se')->join('board','board.bd_id=subject.board_id','left')->join('standard','standard.std_id=subject.std_id','left')
			->where('subject.lang',$this->language)->order_by("subject.sequence","asc")->get('subject')->result_array();
		$data['board']     = $this->crud_model->get_table_data('board','lang',$this->language);
		$data['editData']  = $this->crud_model->get_single_row('subject','sub_id',$id);
		$data['method']    = 'edit';

		$this->load->view('admin/partials/layout',$data);
	}

	public function update($id)
	{
		$name = $this->input->post('name');
		$updData = ['sub_name'=> $name , 'lang' => $this->language, 'board_id' => $this->input->post('board_id'),'std_id'   => $this->input->post('std_id')];
		if($_FILES['file']['name'] != ''){
			$updData['sub_img_path'] = $this->crud_model->file_up($_FILES['file'],'subjects');
		}
		$res = $this->db->where('sub_id',$id)->update('subject', $updData);
		if($res)
		{
			$this->session->set_flashdata('success','Standards updated successfully');
			redirect(base_url('backend/subject'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('err','Something wrong when updated Standards');
			redirect(base_url('backend/subject'),'refresh');
		}
	}

	public function remove($id)
	{
		$this->db->where('sub_id', $id);
		$this->db->delete('subject');

		$this->session->set_flashdata('success','Standard remove successfully');
		redirect(base_url('backend/subject'));
	}

	public function status($id, $status)
	{
		$upd_res = "";
		if($status==1)
		{
			$upd_res = $this->db->where('sub_id',$id)->update('subject',['sub_status'=>0]);
		}
		else
		{
			$upd_res = $this->db->where('sub_id',$id)->update('subject',['sub_status'=>1]);
		}
		if($upd_res)
		{
			$this->session->set_flashdata('success','Status Updated Successfully');
			redirect(base_url('backend/subject'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('err','Something went wrong');
			redirect(base_url('backend/subject'),'refresh');
		}
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);

			$this->db->where_in('sub_id', $ids)->delete('subject');
			$this->session->set_flashdata('success', 'Data Deleted successfully');
			echo 'Deleted successfully.';
		} else {
			$this->session->set_flashdata('error', 'Error');
			echo 'Error';
		}
	}

	public function index_api(){
		$std_id = $this->input->post('std_id');
		$board_id = $this->input->post('board_id');
		$query =	 $this->db
				->select('subject.*,board.*,standard.*,subject.sequence as se')
				->join('board','subject.board_id=board.bd_id','left')	
				->join('standard','standard.std_id=subject.std_id','left')
				->where('subject.board_id',$board_id)
				->where('subject.std_id',$std_id)
				->order_by("subject.sequence","asc");
		$query = $query->get('subject');
		// echo $this->db->last_query(); exit;
		$data = [];
		$all_data = [];
		foreach($query->result() as $r) { 
			$data['sub_id'] = $r->sub_id;
			$data['bd_name'] = $r->bd_name;
			$data['std_name'] = $r->std_name;
			$data['sub_name'] = $r->sub_name;
			$data['sub_img_path'] = $r->sub_img_path;
			$data['se'] = $r->se;
			$data['sub_status'] = $r->sub_status;
			$all_data[] = $data;
		} 
		$result = array(
			"data" => $all_data
		);
		$data = $this->load->view('admin/page/subject/table',$result, TRUE);
		
		// echo "<pre>"; print_r($data); exit;
		echo json_encode($data);
	}

}
