<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chapter extends CI_Controller
{

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
		$data['title'] 		=  'Chapter :: BrainPad Wave';
		$data['page'] 		=  'admin/page/chapter/index';
		$data['action'] 	=  base_url('backend/chapter/store');
		$data['rec'] 		=  $this->db->select('board.*,subject.*,standard.*,chapter.*,chapter.sequence as se')->join('board', 'board.bd_id=chapter.board_id', 'left')->join('subject', 'subject.sub_id=chapter.subject_id', 'left')
			->join('standard', 'standard.std_id=chapter.std_id', 'left')->where('chapter.lang',$this->language)->order_by("chapter.sequence", "asc")
			->get('chapter')->result_array();
		$data['board']      =  $this->crud_model->get_table_data('board','lang',$this->language);
		$data['method'] 	=  'create';

		$this->load->view('admin/partials/layout',$data);
	}

	public function store()
	{
		$get_data = $this->db->select_max('sequence')->where('std_id',$this->input->post('std_id'))->where('board_id',$this->input->post('board_id'))->where('subject_id',$this->input->post('sub_id'))->get('chapter')->result();
		if(!empty($get_data)){
			$sequence = $get_data[0]->sequence + 1 ;
		} else {
			$sequence = 1;
		}

		$data['chapter_text']    = $this->input->post('name');
		$data['ad_id']           = $this->session->userdata('brain_sess')['id'];
		$data['created_at']      = date('Y-m-d H:i:s');
		$data['chapter_img']     = $this->crud_model->file_up($_FILES['file'],'chapter');
		$data['lang']            = $this->language;
		$data['board_id'] 	     = $this->input->post('board_id');
		$data['std_id'] 	     = $this->input->post('std_id');
		$data['subject_id'] 	 = $this->input->post('sub_id');


		$this->db->insert('chapter', $data);
		// $this->crud_model->addSequence('chapter','ch_id',$this->db->insert_id());

		$this->session->set_flashdata('success','Chapter added successfully');
		redirect(base_url('backend/chapter'),'refresh');
	}

	public function edit($id)
	{
		$data['title'] 		= 'Chapter - Edit :: BrainPad Wave';
		$data['action'] 	=  base_url('backend/chapter/update/'.$id);
		$data['page'] 		= 'admin/page/chapter/index';
		$data['board']      =  $this->crud_model->get_table_data('board','lang',$this->language);
		$data['rec'] 		=  $this->db->select('board.*,subject.*,standard.*,chapter.*,chapter.sequence as se')->join('board', 'board.bd_id=chapter.board_id', 'left')->join('subject', 'subject.sub_id=chapter.subject_id', 'left')
			->join('standard', 'standard.std_id=chapter.std_id', 'left')->where('chapter.lang',$this->language)->order_by("chapter.sequence", "asc")
			->get('chapter')->result_array();
		$data['editData']   = $this->crud_model->get_single_row('chapter','ch_id',$id);
		$data['method'] 	= 'edit';

		$this->load->view('admin/partials/layout',$data);
	}

	public function update($id)
	{
		$data['chapter_text']    =  $this->input->post('name');
		$data['lang']            =  $this->language;
		$data['board_id'] 	     = $this->input->post('board_id');
		$data['std_id'] 	     = $this->input->post('std_id');
		$data['subject_id'] 	 = $this->input->post('sub_id');

		if($_FILES['file']['name'] != ''){
			$data['chapter_img'] = $this->crud_model->file_up($_FILES['file'],'chapter');
		}

		$this->db->where('ch_id', $id)->update('chapter', $data);

		$this->session->set_flashdata('success','Chapter update successfully');

		redirect(base_url('backend/chapter'));
	}

	public function remove($id)
	{
		$rec = $this->db->get_where('chapter',['ch_id'=>$id])->row();

		(!empty($rec) && $rec->chapter_img!='')? ( ($rec->chapter_img!='assets/img404.jpg')? unlink($rec->chapter_img):'') : '';
		$del_res = $this->db->where('ch_id',$id)->delete('chapter');

		if($del_res)
		{
			$upd_res = $this->db->where('ch_id',$id)->update('topics',['ch_id'=>'']);
			if($upd_res)
			{
				$this->session->set_flashdata('success','Chapter removed successfully');
				redirect(base_url('backend/chapter'),'refresh');
			}
			else
			{
				$this->session->set_flashdata('error','Something went wrong');
				redirect(base_url('backend/chapter'),'refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/chapter'),'refresh');
		}
	}

	public function status($id, $status)
	{
		if($status == 1)
		{
			$res = $this->db->where('ch_id',$id)->update('chapter',['chapter_status'=>0]);
		}
		else
		{
			$res = $this->db->where('ch_id',$id)->update('chapter',['chapter_status'=>1]);
		}

		if($res)
		{
			$this->session->set_flashdata('success','Status Updated Successfully');
			redirect(base_url('backend/chapter'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/chapter'),'refresh');
		}
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);

			$this->db->where_in('ch_id', $ids)->delete('chapter');
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
		$sub_id = $this->input->post('sub_id');
		$query =	 $this->db
				->select('chapter.*,subject.*,board.*,standard.*,chapter.sequence as se')
				->join('board','chapter.board_id=board.bd_id','left')	
				->join('standard','chapter.std_id=standard.std_id','left')
				->join('subject','subject.sub_id=chapter.subject_id','left')
				->where('chapter.board_id',$board_id)
				->where('chapter.std_id',$std_id)
				->where('chapter.subject_id',$sub_id)
				->order_by("chapter.sequence","asc");
		$query = $query->get('chapter');
		// echo $this->db->last_query(); exit;
		$data = [];
		$all_data = [];
		foreach($query->result() as $r) { 
			$data['ch_id'] = $r->ch_id;
			$data['bd_name'] = $r->bd_name;
			$data['std_name'] = $r->std_name;
			$data['sub_name'] = $r->sub_name;
			$data['chapter_text'] = $r->chapter_text;
			$data['chapter_img'] = $r->chapter_img;
			$data['se'] = $r->se;
			$data['chapter_status'] = $r->chapter_status;
			$all_data[] = $data;
		} 
		$result = array(
			"data" => $all_data
		);
		$data = $this->load->view('admin/page/chapter/table',$result, TRUE);
		
		// echo "<pre>"; print_r($data); exit;
		echo json_encode($data);
	}


}
