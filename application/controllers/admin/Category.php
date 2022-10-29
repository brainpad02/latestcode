<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller
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
		$data['title']     = 'Category :: BrainPad Wave';
		$data['action']    = base_url('backend/category/create');
		$data['page']      = 'admin/page/category/index';
		$data['rec']       = $this->db->where('is_deleted',0)->order_by("c_id","desc")->get('category')->result_array();

		$this->load->view('admin/partials/layout',$data);
	}

    public function create()
	{
		$data['title']      = 'Create Category :: BrainPad Wave';
		$data['action']     = base_url('backend/category/store');
		$data['page']       = 'admin/page/category/create';
		
        $this->load->view('admin/partials/layout', $data);
	}

	public function store(){
		$this->db->insert('category',[
			'ad_id'      => $this->session->userdata['brain_sess']['id'],
			'c_name'     => $this->input->post('category'),
			'unlock_min_star' => $this->input->post('unlock_star'),
			'unlock_usag_time' => $this->input->post('usage_time'),
			'created_at' => date('Y-m-d H:i:s'),
		]);

		$this->session->set_flashdata('success','Category added successfully');
		redirect(base_url('backend/category'),'refresh');
	}

	public function edit($id)
	{
		$data['title']     = 'Category - Edit :: BrainPad Wave';
		$data['action']    =  base_url('backend/category/update/'.$id);
		$data['page']      = 'admin/page/category/edit';
		$data['editData'] = $this->db->where('c_id',$id)->get('category')->row();

		$this->load->view('admin/partials/layout',$data);
	}

	public function update($id){

		$data['c_name']     = $this->input->post('c_name');
		$data['unlock_min_star'] = $this->input->post('unlock_star');
		$data['unlock_usag_time'] = $this->input->post('usage_time');
		$data['created_at']    = date('Y-m-d H:i:s');
		
		$this->db->where('c_id', $id)->update('category',$data);

		$this->session->set_flashdata('success','Category updated successfully');
		redirect(base_url('backend/category'),'refresh');
	}

	public function remove($id)
	{
		$data['is_deleted'] = 1;
		$del_res = $this->db->where('c_id', $id)->update('category',$data);

		if($del_res)
		{
			$this->session->set_flashdata('success','Category removed successfully');
			redirect(base_url('backend/category'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/category'),'refresh');
		}
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);
			if(!empty($ids)){
				foreach($ids as $id){
					$this->db->where('c_id', $id)->update('category',['is_deleted'=>1]);
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
			$res = $this->db->where('c_id',$id)->update('category',['status'=>0]);
		}
		else
		{
			$res = $this->db->where('c_id',$id)->update('category',['status'=>1]);
		}

		if($res)
		{
			$this->session->set_flashdata('success','Status Updated Successfully');
			redirect(base_url('backend/category'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/category'),'refresh');
		}
	}

}
