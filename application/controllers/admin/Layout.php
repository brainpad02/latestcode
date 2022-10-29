<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layout extends CI_Controller
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
		$data['title']     = 'Layout :: BrainPad Wave';
		$data['action']    = base_url('backend/layout/create');
		$data['page']      = 'admin/page/layout/index';
		$data['rec']       = $this->db
							->select('layout.*,category.c_id,category.c_name')
                            ->join('category','category.c_id=layout.cat_id','left')
                            ->where('layout.is_deleted',0)
                            ->order_by("layout.lay_id","desc")
                            ->get('layout')
                            ->result_array();

		$this->load->view('admin/partials/layout',$data);
	}

    public function create()
	{
		$data['title']      = 'Create Layout :: BrainPad Wave';
		$data['action']     = base_url('backend/layout/store');
		$data['page']       = 'admin/page/layout/create';
        $data['category']   = $this->db
                                ->where('is_deleted',0)
                                ->where('status',1)
                                ->get('category')
                                ->result_array();
		
        $this->load->view('admin/partials/layout', $data);
	}

	public function store(){
		$question_type = $answer_type = $extras = $explaination = '';
		if(!empty($this->input->post('question_type'))){
			$question_type = implode(',',$this->input->post('question_type'));
		}
        if(!empty($this->input->post('answer_type'))){
			$answer_type = implode(',',$this->input->post('answer_type'));
		}
        if(!empty($this->input->post('extras'))){
			$extras = implode(',',$this->input->post('extras'));
		}

		if(!empty($this->input->post('explanation'))){
			$explaination = $this->input->post('explanation');
		}
        
       
		$this->db->insert('layout',[
			'cat_id'     => $this->input->post('cat_id'),
            'lay_name'   => $this->input->post('lay_name'),
            'lay_description' => $this->input->post('lay_description'),
            'question_type' => $question_type,
            'answer_type'   => $answer_type,
            'extras' => $extras,
			'explaination'=> $explaination,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
		]);

		$this->session->set_flashdata('success','Layout added successfully');
		redirect(base_url('backend/layout'),'refresh');
	}

	public function edit($id)
	{
		$data['title']     = 'Layout - Edit :: BrainPad Wave';
		$data['action']    =  base_url('backend/layout/update/'.$id);
		$data['page']      = 'admin/page/layout/edit';
		$data['editData'] = $this->db->where('lay_id',$id)->get('layout')->row();
        $data['category'] = $this->db->where('is_deleted',0)->get('category')->result_array();
		$this->load->view('admin/partials/layout',$data);
	}

	public function update($id){

        $question_type = $this->input->post('question_type') ? implode(',',$this->input->post('question_type')): '';
        $answer_type = $this->input->post('answer_type') ? implode(',',$this->input->post('answer_type')) : '';
        $extras = $this->input->post('extras') ? implode(',',$this->input->post('extras')) :'';

		$explaination = $this->input->post('explanation') ? $this->input->post('explanation') :'';

        $data = array(
            'cat_id'     => $this->input->post('cat_id'),
            'lay_name'   => $this->input->post('lay_name'),
            'lay_description' => $this->input->post('lay_description'),
            'question_type' => $question_type,
            'answer_type'   => $answer_type,
            'extras' => $extras,
			'explaination'=> $explaination,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
		
		$this->db->where('lay_id', $id)->update('layout',$data);

		$this->session->set_flashdata('success','Layout updated successfully');
		redirect(base_url('backend/layout'),'refresh');
	}

	public function remove($id)
	{
		$data['is_deleted'] = 1;
		$del_res = $this->db->where('lay_id', $id)->update('layout',$data);

		if($del_res)
		{
			$this->session->set_flashdata('success','Layout removed successfully');
			redirect(base_url('backend/layout'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/layout'),'refresh');
		}
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);
			if(!empty($ids)){
				foreach($ids as $id){
					$this->db->where('lay_id', $id)->update('layout',['is_deleted'=>1]);
				}
			}
			$this->session->set_flashdata('success', 'Data Deleted successfully');
			echo 'Deleted successfully.';
		} else {
			$this->session->set_flashdata('error', 'Error');
			echo 'Error';
		}
	}

	public function status($id, $status)
	{
		if($status == 1)
		{
			$res = $this->db->where('lay_id',$id)->update('layout',['status'=>0]);
		}
		else
		{
			$res = $this->db->where('lay_id',$id)->update('layout',['status'=>1]);
		}

		if($res)
		{
			$this->session->set_flashdata('success','Status Updated Successfully');
			redirect(base_url('backend/layout'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/layout'),'refresh');
		}
	}

}
