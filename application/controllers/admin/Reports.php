<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller
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
		$data['title']     = 'Report :: BrainPad Wave';
		$data['page']      = 'admin/page/report/index';
		$data['school']    = $this->db->where('is_deleted',0)->get('school')->result_array();
		$data['subtopic']  = $this->db->get('subtopics')->result_array();
		$school_data       = $this->db
							->join('languages','languages.symbol=school.language','left')
							->join('board','board.bd_id=school.board','left')
							->join('standard','standard.std_id=school.std_id','left')
							->where('school.is_deleted',0)->get('school')->result_array();

		if(!empty($school_data)){
			foreach($school_data as $key => $school){
				$school_data[$key]['registerd_students'] = $this->db->where('user_type',2)->where('school_id',$school['school_id'])->get('users')->num_rows();
				$school_data[$key]['registerd_teachers'] = $this->db->where('user_type',1)->where('school_id',$school['school_id'])->get('users')->num_rows();

				$plan_data = '';
				$school_data[$key]['total_free_students'] = 0;
				$school_data[$key]['total_paid_students'] = 0;
				$get_st_plan = explode(',',$school['student_plans']);
				if(!empty($get_st_plan)){
					$plans = array();
					foreach($get_st_plan as $plan){
						$plan_name = $this->db->join('plan_type','plan_type.plan_type_id = subscription_plans.plan_type','left')->where('subscription_plans.plan_id',$plan)->get('subscription_plans')->result_array();
						$plans[] = $plan_name[0]['plan_name'];
						
						if($plan_name[0]['is_free_plan'] == 1) {
							$free_plan = $plan;
							$school_data[$key]['total_free_students'] = $this->db->where('plan_id',$plan)->where('is_active_plan',1)->where('is_deleted',0)->get('subscription')->num_rows();
						} else {
							$school_data[$key]['total_paid_students'] = $this->db->where('plan_id',$plan)->where('is_active_plan',1)->where('is_deleted',0)->get('subscription')->num_rows();
						}  
					}
					$plan_data = implode(',',$plans);
				}
				$school_data[$key]['student_plan'] = $plan_data;

				$tplan_data = '';
				$school_data[$key]['total_free_teachers'] = 0;
				$school_data[$key]['total_paid_teachers'] = 0;
				$get_t_plan = explode(',',$school['teacher_plans']);
				if(!empty($get_t_plan)){
					$plans = array();
					foreach($get_t_plan as $plan){
						$plan_name = $this->db->join('plan_type','plan_type.plan_type_id = subscription_plans.plan_type','left')->where('subscription_plans.plan_id',$plan)->get('subscription_plans')->result_array();
						$plans[] = $plan_name[0]['plan_name'];
						
						if($plan_name[0]['is_free_plan'] == 1) {
							$free_plan = $plan;
							$school_data[$key]['total_free_teachers'] = $this->db->where('plan_id',$plan)->where('is_active_plan',1)->where('is_deleted',0)->get('subscription')->num_rows();
						} else {
							$school_data[$key]['total_paid_teachers'] = $this->db->where('plan_id',$plan)->where('is_active_plan',1)->where('is_deleted',0)->get('subscription')->num_rows();
						}  
					}
					$tplan_data = implode(',',$plans);
				}
				$school_data[$key]['teacher_plan'] = $tplan_data;
			}
		}

		$data['school'] = $school_data;

		$this->load->view('admin/partials/layout',$data);
	}

}
