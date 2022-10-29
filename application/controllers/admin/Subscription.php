<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller
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
		$data['title']     = 'Subscription :: BrainPad Wave';
		$data['action']    = base_url('backend/subscription');
		$data['page']      = 'admin/page/subscription/index';
		$data['rec']       = $this->db
							->join('subscription_plans','subscription_plans.plan_id=subscription.plan_id','left')
							->join('users','users.user_id=subscription.user_id','left')
							->where('subscription.is_deleted',0)
							->get('subscription')
							->result_array();

		$this->load->view('admin/partials/layout',$data);
	}

	public function remove($id)
	{
		$data['is_deleted'] = 1;
		$del_res = $this->db->where('sub_id', $id)->update('subscription',$data);

		if($del_res)
		{
			$this->session->set_flashdata('success','Subscription removed successfully');
			redirect(base_url('backend/subscription'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/subscription'),'refresh');
		}
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);
			if(!empty($ids)){
				foreach($ids as $id){
					$this->db->where('sub_id', $id)->update('subscription',['is_deleted'=>1]);
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
