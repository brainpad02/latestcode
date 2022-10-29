<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_plans extends CI_Controller
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
		$data['title']     = 'Subscription Plans :: BrainPad Wave';
		$data['action']    = base_url('backend/subscription_plans/store');
		$data['page']      = 'admin/page/subscription/plan_list';
		$data['rec']       = $this->db->where('is_deleted',0)->order_by("plan_id","desc")->get('subscription_plans')->result_array();

		$this->load->view('admin/partials/layout',$data);
	}

    public function create()
	{
		$data['title']      = 'Create Subscription Plans :: BrainPad Wave';
		$data['action']     = base_url('backend/subscription_plans/store');
		$data['page']       = 'admin/page/subscription/create_plan';
		$data['schools']    = $this->db->where('is_deleted',0)->get('school')->result_array();
		$data['languages']    = $this->db->get('languages')->result_array();
		
        $this->load->view('admin/partials/layout', $data);
	}

	public function store(){
		$this->db->insert('subscription_plans',[
			'user_category' => $this->input->post('user_type'),
			'plan_type'     => $this->input->post('plan_type'),
			// 'school_id'     => $this->input->post('school_id'),
			// 'language_id'   => $this->input->post('language_id'),
			'plan_name'     => $this->input->post('plan_name'),
			'plan_description'  => $this->input->post('plan_desc'),
			'plan_price'    => $this->input->post('plan_price') ? $this->input->post('plan_price') : 0,
			'start_date'    => $this->input->post('start_date') ? $this->input->post('start_date') : '',
			'end_date'      => $this->input->post('end_date') ? $this->input->post('end_date') : '',
			'resume_time'   => $this->input->post('resume_time') ? $this->input->post('resume_time') : '',
			'plan_notes'    => $this->input->post('plan_notes') ? $this->input->post('plan_notes') : '',
			'access_no_topics' => $this->input->post('no_topics') ? $this->input->post('no_topics') : '',
			// 'is_default_free_plan' => $this->input->post('is_free_plan') ? 1 : 0,
			'status'        => 1,
			'created_at'    => date('Y-m-d H:i:s'),
			'updated_at'    => date('Y-m-d H:i:s'),
		]);

		$this->session->set_flashdata('success','Subscription Plan added successfully');
		redirect(base_url('backend/subscription_plans'),'refresh');
	}

	public function edit($id)
	{
		$data['title']     = 'Subscription Plan -Edit :: BrainPad Wave';
		$data['action']    =  base_url('backend/subscription_plans/update/'.$id);
		$data['page']      = 'admin/page/subscription/plan_edit';
		$data['editData'] = $this->db->where('plan_id',$id)->get('subscription_plans')->row();
		// $data['get_plan_type'] = $this->db->where('user_type',$data['editData']->user_category)->get('plan_type')->result_array();
		// $data['schools']    = $this->db->where('is_deleted',0)->get('school')->result_array();
		// $data['languages']    = $this->db->get('languages')->result_array();
		
		
		$this->load->view('admin/partials/layout',$data);
	}

	public function update($id){

		$data['user_category'] = $this->input->post('user_type');
		$data['plan_type']     = $this->input->post('plan_type');
		// $data['school_id']     = $this->input->post('school_id');
		// $data['language_id']     = $this->input->post('language_id');
		$data['plan_name']     = $this->input->post('plan_name');
		$data['plan_description']  = $this->input->post('plan_desc');
		$data['plan_price']    = $this->input->post('plan_price') ? $this->input->post('plan_price') : 0;
		$data['start_date']    = $this->input->post('start_date') ? $this->input->post('start_date') : '';
		$data['end_date']      = $this->input->post('end_date') ? $this->input->post('end_date') : '';
		$data['resume_time']   = $this->input->post('resume_time') ? $this->input->post('resume_time') : '';
		$data['plan_notes']    = $this->input->post('plan_notes') ? $this->input->post('plan_notes') : '';
		$data['access_no_topics'] = $this->input->post('no_topics') ? $this->input->post('no_topics') : '';
		// $data['is_default_free_plan'] = $this->input->post('is_free_plan') ? 1 : 0;
		$data['updated_at']    = date('Y-m-d H:i:s');
		
		$this->db->where('plan_id', $id)->update('subscription_plans',$data);

		$this->session->set_flashdata('success','Subscription Plan updated successfully');
		redirect(base_url('backend/subscription_plans'),'refresh');
	}

	public function remove($id)
	{
		$data['is_deleted'] = 1;
		$del_res = $this->db->where('plan_id', $id)->update('subscription_plans',$data);

		if($del_res)
		{
			$this->session->set_flashdata('success','Subscription Plan removed successfully');
			redirect(base_url('backend/subscription_plans'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/subscription_plans'),'refresh');
		}
	}

	public function status($id, $status)
	{
		if($status == 1)
		{
			$res = $this->db->where('plan_id',$id)->update('subscription_plans',['status'=>0]);
		}
		else
		{
			$res = $this->db->where('plan_id',$id)->update('subscription_plans',['status'=>1]);
		}

		if($res)
		{
			$this->session->set_flashdata('success','Status Updated Successfully');
			redirect(base_url('backend/subscription_plans'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/subscription_plans'),'refresh');
		}
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);
			if(!empty($ids)){
				foreach($ids as $id){
					$this->db->where('plan_id', $id)->update('subscription_plans',['is_deleted'=>1]);
				}
			}
			$this->session->set_flashdata('success', 'Data Deleted successfully');
			echo 'Deleted successfully.';
		} else {
			$this->session->set_flashdata('error', 'Error');
			echo 'Error';
		}
	}

	public function get_plan_type(){
		$get_type = $this->db->where('user_type',$this->input->post('user_type'))->where('is_deleted',0)->get('plan_type')->result_array();
		echo json_encode($get_type);
	}

}
