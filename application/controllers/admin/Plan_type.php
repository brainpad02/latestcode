<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_type extends CI_Controller
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
		$data['title']     = 'Plan Type :: BrainPad Wave';
		$data['action']    = base_url('backend/plan_type/create');
		$data['page']      = 'admin/page/subscription/plan_type_list';
		$data['rec']       = $this->db->where('is_deleted',0)->order_by("plan_type_id","desc")->get('plan_type')->result_array();

		$this->load->view('admin/partials/layout',$data);
	}

    public function create()
	{
		$data['title']      = 'Create Plan Type :: BrainPad Wave';
		$data['action']     = base_url('backend/plan_type/store');
		$data['page']       = 'admin/page/subscription/create_plan_type';
		
        $this->load->view('admin/partials/layout', $data);
	}

	public function store(){
		$this->db->insert('plan_type',[
			'user_type'     => $this->input->post('user_type'),
			'type_name'     => $this->input->post('type_name'),
			'is_free_plan'	=> $this->input->post('is_free') ? 1 : 0 , 
			'created_at'    => date('Y-m-d H:i:s'),
			'updated_at'    => date('Y-m-d H:i:s'),
		]);

		$this->session->set_flashdata('success','Plan Type added successfully');
		redirect(base_url('backend/plan_type'),'refresh');
	}

	public function edit($id)
	{
		$data['title']     = 'Plan Type - Edit :: BrainPad Wave';
		$data['action']    =  base_url('backend/plan_type/update/'.$id);
		$data['page']      = 'admin/page/subscription/plan_type_edit';
		$data['editData'] = $this->db->where('plan_type_id',$id)->get('plan_type')->row();

		$this->load->view('admin/partials/layout',$data);
	}

	public function update($id){

		$data['user_type']     = $this->input->post('user_type');
		$data['type_name']     = $this->input->post('plan_type_name');
		$data['is_free_plan']  = $this->input->post('is_free') ? 1 : 0 ;
		$data['updated_at']    = date('Y-m-d H:i:s');
		
		$this->db->where('plan_type_id', $id)->update('plan_type',$data);

		$this->session->set_flashdata('success','Plan Type updated successfully');
		redirect(base_url('backend/plan_type'),'refresh');
	}

	public function remove($id)
	{
		$data['is_deleted'] = 1;
		$del_res = $this->db->where('plan_type_id', $id)->update('plan_type',$data);

		if($del_res)
		{
			$this->session->set_flashdata('success','Plan Type removed successfully');
			redirect(base_url('backend/plan_type'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/plan_type'),'refresh');
		}
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);
			if(!empty($ids)){
				foreach($ids as $id){
					$this->db->where('plan_type_id', $id)->update('plan_type',['is_deleted'=>1]);
				}
			}
			$this->session->set_flashdata('success', 'Data Deleted successfully');
			echo 'Deleted successfully.';
		} else {
			$this->session->set_flashdata('error', 'Error');
			echo 'Error';
		}
	}

}
