<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//PhpSpreadsheet

class User extends CI_Controller
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
		$data['title'] = 'Users :: BrainPad Wave';
		$data['page']  = 'admin/page/user/index';
		// $data['rec']   =   $this->crud_model->get_table_data('users');
		$users = $this->db
						->select('users.user_id,users.username,plan_type.type_name,users.created_on,school.expiry_date,users.phone_no,users.email_id,users.status,users.usercode,users.school_id,subscription_plans.plan_name')
						->join('school','school.school_id=users.school_id','left')
						->join('subscription_plans','subscription_plans.plan_id=school.student_plans','left')
						->join('plan_type','plan_type.plan_type_id=subscription_plans.plan_type','left')
						->join('languages','languages.symbol=users.lang','left')
						->join('board','board.bd_id=users.board','left')
						->join('standard','standard.std_id=users.standard','left')
						->where('users.user_type',2)
						->order_by('users.user_id','DESC')
						->get('users')
						->result_array();
		if(!empty($users)){
			foreach($users as $key => $user){
				$achivment = $this->db
							->select_sum('time')
							->where('user_id',$user['user_id'])
							->get('user_achievement')
							->result_array();
				$users[$key]['time'] = $achivment[0]['time'];
			} 
		}
		// echo "<pre>"; print_r($users); exit;
		$data['rec'] = $users; 
		$data['school']    = $this->db->where('is_deleted',0)->get('school')->result_array();
		$this->load->view('admin/partials/layout', $data);
	}

	public function export_user()
	{
		// file name
		$filename = 'users_'.date('Ymd').'.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/csv; ");
		// get data
		// $usersData = $this->db->select('username,phone_no,email_id')->get('users')->result_array();
		// file creation
		$users = $this->db
						->select('users.user_id,users.usercode,users.username,plan_type.type_name,users.created_on,school.acamedic_date,users.phone_no,users.email_id,users.status,users.usercode,users.school_id,subscription_plans.plan_name')
						->join('school','school.school_id=users.school_id','left')
						->join('subscription_plans','subscription_plans.plan_id=school.plan_id','left')
						->join('plan_type','plan_type.plan_type_id=subscription_plans.plan_type','left')
						->where('users.user_type',2)
						->get('users')
						->result_array();
		if(!empty($users)){
			foreach($users as $key => $user){
				$achivment = $this->db
							->select_sum('time')
							->where('user_id',$user['user_id'])
							->get('user_achievement')
							->result_array();
				$users[$key]['time'] = $achivment[0]['time'];
			} 
		}

		// echo "<pre>"; print_r($users); exit;

		$file = fopen('php://output','w');
		$header = ["User Id","School Id","User Code","Username","Subscription Type","Subscription Plan","Registerd Date","Licence Exp Date","Phone no", "Email Id","Status","Total App Usage"];
		fputcsv($file, $header);
		foreach ($users as $key=>$line){
			fputcsv($file,$line);
		}
		fclose($file);
		exit;
	}

	public function index_api(){
		$school_id = $this->input->post('school_id');
		$query =	 $this->db
						->join('languages','languages.symbol=school.language','left')
						->join('board','board.bd_id=school.board','left')
						->join('standard','standard.std_id=school.std_id','left')
						->where('school.school_id',$school_id);
		$query = $query->get('school');
		
		// echo $this->db->last_query(); exit;
		$data = [];
		$all_data = [];
		foreach($query->result() as $r) {   
			$data['school_logo'] = $r->school_logo;
			$data['school_name'] = $r->school_name;
			$data['school_code'] = $r->school_code;
			$data['free_licence'] = $r->free_students;
			$data['paid_licence'] = $r->no_licence;
			$data['registerd_students'] = $this->db->where('user_type',2)->where('school_id',$school_id)->get('users')->num_rows();
			$data['registerd_teachers'] = $this->db->where('user_type',1)->where('school_id',$school_id)->get('users')->num_rows();
			$data['phoneno'] = $r->school_phoneno;
			$data['city'] = $r->school_city;
			$data['state'] = $r->school_state;
			$data['zipcode'] = $r->school_zipcode;
			$data['branch_code'] = $r->branch_code;
			$data['applink'] = $r->applink;
			$data['paymentlink'] = $r->paymentlink;
			$data['expiry_date'] = $r->expiry_date;
			$plan_data = ''; $data['total_free_students'] = 0; $data['total_paid_students'] = 0;
			$get_st_plan = explode(',',$r->student_plans);
			if(!empty($get_st_plan)){
				$plans = array();
				foreach($get_st_plan as $plan){
					$plan_name = $this->db->join('plan_type','plan_type.plan_type_id = subscription_plans.plan_type','left')->where('subscription_plans.plan_id',$plan)->get('subscription_plans')->result_array();
						$plans[] = $plan_name[0]['plan_name'];
						
						if($plan_name[0]['is_free_plan'] == 1) {
							$free_plan = $plan;
							$data['total_free_students'] = $this->db->where('plan_id',$plan)->where('is_active_plan',1)->where('is_deleted',0)->get('subscription')->num_rows();
						} else {
							$data['total_paid_students'] = $this->db->where('plan_id',$plan)->where('is_active_plan',1)->where('is_deleted',0)->get('subscription')->num_rows();
						}
				}
				$plan_data = implode(',',$plans);
			}

			$data['student_plan'] = $plan_data;

			$plant_data = ''; $data['total_free_teachers'] = 0; $data['total_paid_teachers'] = 0;
			$get_st_plan = explode(',',$r->teacher_plans);
			if(!empty($get_st_plan)){
				$plans = array();
				foreach($get_st_plan as $plan){
					$plan_name = $this->db->join('plan_type','plan_type.plan_type_id = subscription_plans.plan_type','left')->where('subscription_plans.plan_id',$plan)->get('subscription_plans')->result_array();
						$plans[] = $plan_name[0]['plan_name'];
						
						if($plan_name[0]['is_free_plan'] == 1) {
							$free_plan = $plan;
							$data['total_free_teachers'] = $this->db->where('plan_id',$plan)->where('is_active_plan',1)->where('is_deleted',0)->get('subscription')->num_rows();
						} else {
							$data['total_paid_teachers'] = $this->db->where('plan_id',$plan)->where('is_active_plan',1)->where('is_deleted',0)->get('subscription')->num_rows();
						}
				}
				$plant_data = implode(',',$plans);
			}
			$data['teacher_plan'] = $plant_data;
			$data['language'] = $r->name;
			$data['board'] = $r->bd_name;
			$data['standard'] = $r->std_name;
			$all_data[] = $data;
		}
		
		$result = array(
			"data" => $all_data
		);
		$table = $this->load->view('admin/page/user/table',$result, TRUE);
		
		echo json_encode($table);
	}

	public function school_filter(){
		$school_id = $this->input->post('school_id');
		$users = $this->db
			->select('users.user_id,users.username,plan_type.type_name,users.created_on,school.expiry_date,users.phone_no,users.email_id,users.status,users.status,users.usercode,users.school_id,subscription_plans.plan_name')
			->join('school','school.school_id=users.school_id','left')
			->join('subscription_plans','subscription_plans.plan_id=school.student_plans','left')
			->join('plan_type','plan_type.plan_type_id=subscription_plans.plan_type','left')
			->join('languages','languages.symbol=users.lang','left')
			->join('board','board.bd_id=users.board','left')
			->join('standard','standard.std_id=users.standard','left')
			->where('users.user_type',2)
			->where('users.school_id',$school_id);
			
			$query = $users->get('users');
			$data = [];
			$all_data = [];
			foreach($query->result() as $r) {   
				$data['user_id'] = $r->user_id;
				$data['username'] = $r->username;
				$data['type_name'] = $r->type_name;
				$data['created_on'] = $r->created_on;
				$data['expiry_date'] = $r->expiry_date;
				$data['phone_no'] = $r->phone_no;
				$data['email_id'] = $r->email_id;
				$data['status'] = $r->status;
				$data['school_id'] = $r->school_id;
				$data['usercode'] = $r->usercode;
				$data['plan_name'] = $r->plan_name;

				$achivment = $this->db
							->select_sum('time')
							->where('user_id',$r->user_id)
							->get('user_achievement')
							->result_array();
				$data['time'] = $achivment[0]['time'];
				$all_data[] = $data;
			}

			$result = array(
				"data" => $all_data
			);
			$table = $this->load->view('admin/page/user/usertable',$result, TRUE);
			
			echo json_encode($table);
	}

}
