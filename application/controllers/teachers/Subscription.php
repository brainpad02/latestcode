<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//PhpSpreadsheet

class Subscription extends CI_Controller
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
		$data['title'] = 'Subscription :: BrainPad Wave';
		$data['page']  = 'teachers/page/subscription/index';
		$school_id =  $this->session->userdata('brain_sess')['school_id'];
		$data['users'] = $this->db->join('subscription_plans','users.plan_id=subscription_plans.plan_id','left')->join('standard','standard.std_id=users.standard','left')->where('users.school_id',$school_id)->get('users')->result();
		$subscription_plan = $this->db->where('school_id',$school_id)->get('school')->result();
		if(!empty($subscription_plan)){
			$plans = explode(',',$subscription_plan[0]->student_plans);
			foreach($plans as $plan){
				$plans =  $this->db->where('plan_id',$plan)->get('subscription_plans')->result();
				$plan_data[] = array(
					'plan_id'=>$plan,
					'plan_name'=>$plans[0]->plan_name
				);
			}
		}
		$data['plan_data'] = $plan_data; 
        $this->load->view('teachers/partials/layout', $data);
	}

	public function change_plan(){
		$data = array(
			'plan_id'=>$this->input->post('plan_id'),
		);
		$this->db->where('user_id', $this->input->post('user_id'))->update('users',$data);
	}

}
