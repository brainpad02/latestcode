<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class User extends BD_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/kolkata');
		$this->auth();
	}

	public function update_profile_post(){
		$user_id = $this->user->id;
		$i = 0;
		$update_data = [];

		if($this->input->post('gender') != null)   { $update_data['gender']    = $this->input->post('gender'); }
		if($this->input->post('user_type') != null){ $update_data['user_type'] = $this->input->post('user_type'); $i++; }
		if($this->input->post('board') != null)    { $update_data['board']     = $this->input->post('board'); $i++; }
		if($this->input->post('standard') != null) { $update_data['standard']  = $this->input->post('standard'); $i++;}
		if($this->input->post('lang') != null)     { $update_data['lang']      = $this->input->post('lang'); }
		if($this->input->post('name') != null)     { $update_data['username']  = $this->input->post('name'); }
		if($this->input->post('accept_privacy_policy') != null)  {
			$update_data['accept_privacy_policy']  = $this->input->post('accept_privacy_policy');
			$update_data['accept_date_time']       = date('Y-m-d H:i:s');
		}

		

		if(!empty($_FILES)){
			if($_FILES['file']['size'] > 0) {
				 $update_data['profile_pic'] = $this->crud_model->file_up($_FILES['file'],'profile_pic'); 
			}
		}

		if($i == 3){
			$update_data['is_profile_complete'] = 1;
		}

		if(!empty($update_data)){
			$this->db->where('user_id', $user_id)->update('users', $update_data);

			$this->set_response(['status'=>0,'msg'=>'User Updated Successfully'],REST_Controller::HTTP_OK);
		} 

	}

	public function name_avatar_post()
	{
		$user_id = $this->user->id;
		$this->form_validation->set_rules('name','Name','required|trim',['required'=>'Please fill name field']);
		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){$errors [] = $err;}
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		}
		else
		{
			$name = $this->input->post('name');
			if($_FILES['file']['size']>0)
			{
				$bmimage = '';
				$config['upload_path']  =   './uploads/profile_pic/';
				$config['allowed_types'] = 'jpg|png|jpeg|JPEG|JPG|PNG';
				$config['encrypt_name']  =   TRUE;

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('file'))
				{
					print_r($this->upload->display_errors());
					die;
				}
				else
				{
					$bmimage = $this->upload->data();
				}
				$insert = ['username'=>$name,'profile_pic'=>'uploads/profile_pic/'.$bmimage['file_name']];
				$upd_res = $this->db->where('user_id',$user_id)->update('users',$insert);
				if($upd_res)
				{
					$profile = $this->profile_data($user_id);
					$this->set_response($profile,200);
				}
				else
				{
					$this->set_response(['msg'=>'Something went wrong'],422);
				}
			}
			else
			{
				$insert = ['username'=>$name];
				$upd_res = $this->db->where('user_id',$user_id)->update('users',$insert);
				if($upd_res)
				{
					$profile = $this->profile_data($user_id);
					$this->set_response($profile,200);
				}
				else
				{
					$this->set_response(['msg'=>'Something went wrong'],422);
				}
			}
		}
	}

	public function get_user_profile_get(){
		$user_id = $this->user->id;
		$this->set_response($this->profile_data($user_id),REST_Controller::HTTP_OK);
	}

	public function register_user_post(){  
		
		$this->form_validation->set_rules('phone_no','Phone No','required|trim',['required'=>'Please fill phone no field']);
		$this->form_validation->set_rules('dob','Date of birth','required|trim',['required'=>'Please fill date of birth field']);
		$this->form_validation->set_rules('gender','Gender','required|trim',['required'=>'Please fill gender field']);
		$this->form_validation->set_rules('user_type','User Type','required|trim',['required'=>'Please fill user type field']);

		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){$errors [] = $err;}
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			if(empty($this->input->post('school_id'))){
				$school_id = 1;
			} else {
				$school_id = $this->input->post('school_id');
			}

			$data = array(
				'phone_no'=>$this->input->post('phone_no'),
				'dob'=>$this->input->post('dob'),
				'gender'=>$this->input->post('gender'),
				'user_type'=>$this->input->post('user_type'),
				'subscribe_default_school'=>$this->input->post('subscribe_default_school'),
				'board'=>$this->input->post('board'),
				'standard'=>$this->input->post('standard'),
				'lang'=>$this->input->post('lang'),
				'school_id'=>$school_id
			);

			$this->db->where('user_id', $this->input->post('user_id'))->update('users', $data);
			
			$user_id = $this->input->post('user_id');

			if($this->input->post('user_type') == 1){
				$user_category = 'Teacher';
			} else {
				$user_category = 'Student';
			}
			$get_plan_id = $this->db->where('is_default_free_plan',1)->where('user_category',$user_category)->get('subscription_plans')->row();
			$access_no_topics =$get_plan_id->access_no_topics;
			if($this->input->post('subscribe_default_school') == 1){
				$subscribe_data = array(
					'user_id'=>$user_id,
					'plan_id'=>$get_plan_id->plan_id,
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')
				);

				$this->db->insert('subscription',$subscribe_data);
				// $sub_id = $this->db->insert_id();

				// $get_subjects = $this->db->where('board_id',$this->input->post('board'))->where('std_id',$this->input->post('standard'))->where('lang',$this->input->post('lang'))->get('subject')->result_array();

				// if(!empty($get_subjects)){
				// 	foreach($get_subjects as $subjects){
				// 		$sub_details = array(
				// 			'subscription_id'=>$sub_id,
				// 			'subject_id'=>$subjects['sub_id'],
				// 			'topic_id'=>0,
				// 			'access_content_no'=>$access_no_topics,
				// 			'remaining_access_content_no'=>$access_no_topics,
				// 			'created_at'=>date('Y-m-d H:i:s')
				// 		);

				// 		$this->db->insert('subscription_details',$sub_details);
				// 	}
				// }
			}

			$response["data"] = $this->profile_data($user_id);
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}

	public function add_school_post() { 
		$this->form_validation->set_rules('school_name','School Name','required|trim',['required'=>'Please fill school name field']);
		$this->form_validation->set_rules('school_phoneno','Phone No','required|trim',['required'=>'Please fill phone no field']);

		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){$errors [] = $err;}
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$school_code = ucfirst(substr($this->input->post('school_name'), 0, 4)).mt_rand(1111,9999);
			$data = array(
				'user_id'=>$this->input->post('user_id'),
				'school_code'=>$school_code,
				'school_name'=>$this->input->post('school_name'),
				'school_description'=>$this->input->post('school_description'),
				'school_phoneno'=>$this->input->post('school_phoneno'),
				'school_address'=>$this->input->post('school_address'),
				'school_city'=>$this->input->post('school_city'),
				'school_state'=>$this->input->post('school_state'),
				'school_country'=>$this->input->post('school_country'),
				'school_zipcode'=>$this->input->post('school_zipcode')
			);

			$this->db->insert('school',$data);
			$school_id = $this->db->insert_id();
			if(!empty($this->input->post('is_branch'))){
				$branch_array = array(
					'school_id'=>$school_id,
					'branch_name'=>$this->input->post('school_name')
				);
				$this->db->insert('branch',$branch_array);
			}
			
			$response["msg"] = "School added successfully";
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
		
	}

	function get_subscription_plan_post(){ 
		$this->form_validation->set_rules('school_id','School Id','required|trim',['required'=>'Please select school']);
		$this->form_validation->set_rules('user_type','User Type','required|trim',['required'=>'Please select User Type']);
		$this->form_validation->set_rules('language_id','Language Id','required|trim',['required'=>'Please select Language']);

		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){$errors [] = $err;}
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			if($this->input->post('user_type') == 'student'){
				 $type = 'student_plans';
			} else {
				$type = 'teacher_plans';
			}
			$school_plan = $this->db->select($type)->where('school_id',$this->input->post('school_id'))
							->get('school')
							->result_array();
			
			if(!empty($school_plan)){
				$plans = $school_plan[0][$type];
				if(!empty($plans)){
					$plan = explode(',',$plans);
					foreach($plan as $key => $p){ 
						$plan_data[]	= $this->db->where('plan_id',$p)
										->get('subscription_plans')
										->result();
					}
				}
			}
			$singleArrayForCategory = array_reduce($plan_data, 'array_merge', array());
			$response['data'] = $singleArrayForCategory;
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}



	public function user_achievement_post()
	{ 
		$this->form_validation->set_rules('subtopic_id','Subtopic Id','required|trim',['required'=>'Please select Subtopic']);
		$this->form_validation->set_rules('user_id','User ID','required|trim',['required'=>'Please select User']);
		$this->form_validation->set_rules('device_id','Device ID','required|trim',['required'=>'Please add device id']);
		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){$errors [] = $err;}
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$response = array();
			
			$check_session = $this->db->where('device_id',$this->input->post('device_id'))->where('user_id',$this->input->post('user_id'))->get('users')->result_array();
			if(empty($check_session)){
				$this->set_response(['msg'=>"You're registered with other device"],422);
			}

			$exist_subtopic = $this->db->where('subtopic_id',$this->input->post('subtopic_id'))
			->where('user_id',$this->input->post('user_id'))->where('created_at',date('Y-m-d'))
			->get('user_achievement')
			->result_array();
			
			$data = array(
				'subtopic_id'=>$this->input->post('subtopic_id'),
				'user_id'=>$this->input->post('user_id'),
				'time'=>$this->input->post('time') ? $this->input->post('time') : '',
				'crown'=>$this->input->post('crown') ? $this->input->post('crown') : '',
				'star'=>$this->input->post('star') ? $this->input->post('star') : '',
			);
			
			
			if(!empty($exist_subtopic)){
				$data['updated_at'] = date('Y-m-d');
				$data['time'] = $exist_subtopic[0]['time'] + $this->input->post('time');
				$this->db->where('user_id', $this->input->post('user_id'))
				->where('subtopic_id', $this->input->post('subtopic_id'))
				->where('id',$exist_subtopic[0]['id'])
				->update('user_achievement', $data);
				// $response["msg"] = "User Achivement updated successfully";
			} else {
				$data['created_at'] = date('Y-m-d');
				$this->db->insert('user_achievement',$data);
				// $response["msg"] = "User Achivement added successfully";
			}

			// $exist = $this->db->where('subtopic_id',$this->input->post('subtopic_id'))
			// 		->where('user_id',$this->input->post('user_id'))->where('created_at',date('Y-m-d'))
			// 		->get('user_achievement')
			// 		->result_array();
			$total_time = 0;$total_star = 0; $total_crown = 0;
			if(!empty($exist_subtopic)){
				foreach($exist_subtopic as $a){
					$total_time += $a['time'];
					$total_star += $a['star'];
					$total_crown += $a['crown'];
					$created_date = $a['created_at'];
				}
				$response['subtopic_id'] = $this->input->post('subtopic_id');
				$response['user_id'] = $this->input->post('user_id');
				$response['total_time'] = $total_time;
				$response['total_star'] = $total_star;
				$response['total_crown'] = $total_crown;
				$response['created_date'] = $created_date;
			}

			if(!empty($this->input->post('star'))){
				$get_user_total_star = $this->db->where('user_id',$this->input->post('user_id'))->get('users')->result();
				if(!empty($get_user_total_star)){
				   $total_s = $get_user_total_star[0]->total_star + $this->input->post('star');
				   $update_s = array(
					   'total_star'=>$total_s,
				   );
				   $update_star = $this->db->where('user_id', $this->input->post('user_id'))
				   ->update('users', $update_s);
				   $response['user_total_star'] = $total_s;
				}
			}
			$this->set_response($response, REST_Controller::HTTP_OK);
		}
	}

	public function subtopic_time_post(){
		$this->form_validation->set_rules('subtopic_id','Subtopic Id','required|trim',['required'=>'Please select Subtopic']);
		$this->form_validation->set_rules('user_id','User ID','required|trim',['required'=>'Please select User']);
		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){ $errors [] = $err; }
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$exist_subtopic = $this->db->where('subtopic_id',$this->input->post('subtopic_id'))
			->where('user_id',$this->input->post('user_id'))
			->where("created_at >= DATE(NOW()) - INTERVAL 7 DAY")
			->get('user_achievement')
			->result_array();
			$data = array();
			if(!empty($exist_subtopic)){
				$total_time = $total_crown = $total_star = 0;
				foreach($exist_subtopic as $a){
				   $data['data'][] = array(
					  'time'=>$a['time'],
					  'crown'=>$a['crown'],
					  'star'=>$a['star'],
					  'date'=>$a['created_at']
				   );
				   $total_time += $a['time'];
				   $total_crown += $a['crown'];
				   $total_star += $a['star'];
				}
				$data['total_time'] = $total_time;
				$data['total_crown'] = $total_crown;
				$data['total_star'] = $total_star;
			}
			$this->set_response($data, REST_Controller::HTTP_OK);
		}
	}

	public function last_week_time_post(){
		$this->form_validation->set_rules('user_id','User ID','required|trim',['required'=>'Please select User']);
		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){ $errors [] = $err; }
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$exist_subtopic = $this->db->where('user_id',$this->input->post('user_id'))
			->where("created_at >= DATE(NOW()) - INTERVAL 7 DAY")
			->get('user_achievement')
			->result_array();
			$data = array();
			if(!empty($exist_subtopic)){
				$total_time = $total_crown = $total_star = 0;
				foreach($exist_subtopic as $a){
				   $day = date("D", strtotime($a['created_at']));
				   $seconds = $a['time']*60;
				   $t = round($seconds);
  				   $time = sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
				   $data['data'][] = array(
					  'time'=>$time,
					  'day'=>$day,
					  'crown'=>$a['crown'],
					  'star'=>$a['star'],
					  'date'=>$a['created_at']
				   );
				   $total_time += $a['time'];
				   $hours = floor($total_time / 60);
				   $minutes = ($total_time % 60);
				   $time = sprintf('%02d:%02d', $hours, $minutes);
				   $total_crown += $a['crown'];
				   $total_star += $a['star'];
				}
				$data['total_time'] = $time;
				$data['total_crown'] = $total_crown;
				$data['total_star'] = $total_star;
			}
			$this->set_response($data, REST_Controller::HTTP_OK);
		}
	}

	public function get_total_star_post(){
		$this->form_validation->set_rules('user_id','User ID','required|trim',['required'=>'Please select User']);
		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){ $errors [] = $err; }
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$get_user_total_star = $this->db->where('user_id',$this->input->post('user_id'))->get('users')->result();
			if(!empty($get_user_total_star)){
				$data = array(
					'user_id'=>$get_user_total_star[0]->user_id,
					'total_star'=>$get_user_total_star[0]->total_star,
				);
				$this->set_response($data, REST_Controller::HTTP_OK);
			}
		}
	}

	public function get_school_total_star_post(){
		$this->form_validation->set_rules('school_id','School ID','required|trim',['required'=>'Please select School']);
		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){ $errors [] = $err; }
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$school_s = 0;
			$get_star_school = $this->db->where('school.school_id',$this->input->post('school_id'))
							   ->join('users','users.school_id=school.school_id','left')
							   ->join('user_achievement','user_achievement.user_id=users.user_id','left')
							   ->get('school')->result();
			if(!empty($get_star_school)){
				foreach($get_star_school as $school){ 
					$school_s+= $school->star;
				}
			}
			$data=array(
				'school_id'=>$this->input->post('school_id'),
				'total_star'=>$school_s
			);
			$this->set_response($data, REST_Controller::HTTP_OK);
		}
	}

	public function lock_unlock_example_post(){
		$this->form_validation->set_rules('crown','Crown','required|trim',['required'=>'Please select Crown']);
		$this->form_validation->set_rules('user_id','User ID','required|trim',['required'=>'Please select User']);
		$this->form_validation->set_rules('star','Star','required|trim',['required'=>'Please select Star']);
		$this->form_validation->set_rules('subtopic_id','Subtopic Id','required|trim',['required'=>'Please select Subtopic']);
		$this->form_validation->set_rules('time','Used Time','required|trim',['required'=>'Please insert used time']);
		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){ $errors [] = $err; }
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$get_data = $this->db->where('user_id',$this->input->post('user_id'))->where('subtopic_id',$this->input->post('subtopic_id'))->get('example_lock_unlock')->result();

			$get_min_star = $this->db->get('splash')->result();

			$min_star = $get_min_star[0]->unlock_min_star;
			
			if($this->input->post('star') >= $min_star){
				$flag = 1;
				$is_unlock = 1;
			} else {
				$flag = 0;
				$is_unlock = 0;
			}

			$data = array(
				'user_id'=>$this->input->post('user_id'),
				'crown'=>$this->input->post('crown'),
				'star'=>$this->input->post('star'),
				'lock_flag'=>$flag,
				'subtopic_id'=>$this->input->post('subtopic_id'),
				'is_unlock'=>$is_unlock,
			);
			if(!empty($get_data)){
				if($get_data[0]->is_unlock == 1){
					$data['is_unlock'] = 1;
				}
				if($get_data[0]->lock_flag == 1){
					$data['lock_flag'] = 1;
				}
				$data['updated_at'] = date('Y-m-d H:i:s');
				$update = $this->db->where('user_id', $this->input->post('user_id'))->where('subtopic_id',$this->input->post('subtopic_id'))->update('example_lock_unlock', $data);

			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$update = $this->db->insert('example_lock_unlock',$data);
			}

			$user_plan = $this->db->where('user_id',$this->input->post('user_id'))->get('users')->result();
			if(!empty($user_plan)){
				$plan_id = $user_plan[0]->plan_id;
				$get_plan = $this->db->where('plan_id',$plan_id)->get('subscription_plans')->result();
				if(!empty($get_plan)){
					$resume_time = $get_plan[0]->resume_time;
					if($this->input->post('time') <= $resume_time ){
						$data['restrict_time_flag'] = 1;
					} else {
						$data['restrict_time_flag'] = 0;
					}

					$daily_app_usage_time = $this->db->where('user_id', $this->input->post('user_id'))->get('users')->result();

					// $get_time = $this->db->where('user_id', $this->input->post('user_id'))->where('subtopic_id',$this->input->post('subtopic_id'))->where('created_at',date('Y-m-d'))->get('user_achievement')->result();

					if(!empty($daily_app_usage_time)){
						$time = $daily_app_usage_time[0]->daily_app_usage_time;
						$total_time = $time + $this->input->post('time'); 

						if($resume_time <= $total_time){
							$data['restrict_time_flag'] = 0;
						} else {
							$data['restrict_time_flag'] = 1;
						}


						$update_time = array(
							'daily_app_usage_time'=>$total_time
						);
						$update = $this->db->where('user_id', $this->input->post('user_id'))->update('users', $update_time);
					}

					$access_no_topics = $get_plan[0]->access_no_topics;
					$get_user = $this->db->where('user_id',$this->input->post('user_id'))->get('users')->result();
					if(!empty($get_user)){
						$new_date = date('Y-m-d', strtotime($get_user[0]->created_on. ' + '.$access_no_topics.' days'));
						$date_now = date("Y-m-d");
						if($new_date <= $date_now){
							$data['restricted_user'] = 0;
						} else {
							$data['restricted_user'] = 1;
						}
					}
				}

				$get_sbtopic = $this->db->where('stp_id',$this->input->post('subtopic_id'))->get('subtopics')->result();
				if(!empty($get_sbtopic)){
					$get_topic = $this->db->where('tp_id',$get_sbtopic[0]->tp_id)->get('topics')->result();
					if(!empty($get_topic)){
						$get_chapter = $this->db->where('ch_id',$get_topic[0]->ch_id)->get('chapter')->result();
						if(!empty($get_chapter)){
							$get_subject = $this->db->where('subject_id',$get_chapter[0]->subject_id)->where('user_id',$this->input->post('user_id'))->get('subject_achievement')->result();
							if(!empty($get_subject)){
								$t_star = $get_subject[0]->total_star + $this->input->post('star');
								$t_time = $get_subject[0]->total_time + $this->input->post('time');
								$update_data = array(
									'total_star'=>$t_star,
									'total_time'=>$t_time
								);
								$this->db->where('id', $get_subject[0]->id)->update('subject_achievement', $update_data);
							} else {
								$insert_data = array(
									'user_id'=>$this->input->post('user_id'),
									'subject_id'=>$get_chapter[0]->subject_id,
									'total_time'=>$this->input->post('time'),
									'total_star'=>$this->input->post('star')
								);
								$this->db->insert('subject_achievement',$insert_data);
							}
						}
					}
				}
			}
		}
		$this->set_response($data, REST_Controller::HTTP_OK);
	}

	public function  get_lock_unlock_flag_post(){
		$this->form_validation->set_rules('user_id','User ID','required|trim',['required'=>'Please select User']);
		$this->form_validation->set_rules('subtopic_id','Subtopic Id','required|trim',['required'=>'Please select Subtopic']);
		if($this->form_validation->run()==false)
		{
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){ $errors [] = $err; }
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$get_data = $this->db->where('user_id',$this->input->post('user_id'))->where('subtopic_id',$this->input->post('subtopic_id'))->get('example_lock_unlock')->result();
			$data = array();
			if(!empty($get_data)){
				$data = $get_data;
			}
		}
		$this->set_response($data, REST_Controller::HTTP_OK);
	}

	public function get_restricted_data_post(){
		$this->form_validation->set_rules('plan_id','Plan Id','required|trim',['required'=>'Please Select Plan']);
		$this->form_validation->set_rules('user_id','User Id','required|trim',['required'=>'Please Select User']);
		if($this->form_validation->run()==false){ 
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){ $errors [] = $err; }
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$data = array();
			$get_plan_data = $this->db->where('plan_id',$this->input->post('plan_id'))->get('subscription_plans')->result();
			if(!empty($get_plan_data)){
				$data['plan_suspend_time'] = $get_plan_data[0]->resume_time;
				$data['plan_name'] = $get_plan_data[0]->plan_name;
				$data['access_no_topics'] = $get_plan_data[0]->access_no_topics;

				$get_user = $this->db->where('user_id',$this->input->post('user_id'))->get('users')->result();
				if(!empty($get_user)){
				   $new_date = date('Y-m-d', strtotime($get_user[0]->created_on. ' + '.$get_plan_data[0]->access_no_topics.' days'));
				   $data['restricted_date'] = $new_date;
				}

			}
			$this->set_response($data, REST_Controller::HTTP_OK);
		}
		
	}

	public function student_subject_achivement_post(){
		$this->form_validation->set_rules('user_id','User Id','required|trim',['required'=>'Please Select User']);
		if($this->form_validation->run()==false){ 
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){ $errors [] = $err; }
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$get_user = $this->db->where('user_id',$this->input->post('user_id'))->get('users')->result();
			if(!empty($get_user)){
				$get_subjects['data'] =  $this->db->where('user_id',$this->input->post('user_id'))->get('subject_achievement')->result(); 
				if(!empty($get_subjects)){
					$this->set_response($get_subjects, REST_Controller::HTTP_OK);
				} else {
					$this->set_response(['msg'=>"Ops..! Let's Play and Learn Something..."],422);
				}
			} else {
				$this->set_response(['msg'=>"User not found."],422);
			}
		}
	}

	public function teacher_subject_achivement_post(){
		$this->form_validation->set_rules('school_id','School Id','required|trim',['required'=>'Please Select School']);
		if($this->form_validation->run()==false){ 
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){ $errors [] = $err; }
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$get_user = $this->db->where('school_id',$this->input->post('school_id'))->get('users')->result();
			if(!empty($get_user)){
				$data = array();
				foreach($get_user as $key=>$users){
					$data[$key] = $users; 
					$get_subjects =  $this->db->where('user_id',$users->user_id)->get('subject_achievement')->result(); 
					if(!empty($get_subjects)){
						$data[$key]->subjects = $get_subjects;
					} 
				} 
				$this->set_response($data, REST_Controller::HTTP_OK);
			}
		}
	}

	public function school_paid_link_post(){
		$this->form_validation->set_rules('school_id','School Id','required|trim',['required'=>'Please Select School']);
		if($this->form_validation->run()==false){ 
			$errs = $this->form_validation->error_array();
			$errors = [];
			foreach($errs as $err){ $errors [] = $err; }
			$invalidCredentials = ['msg'=>implode(',',$errors)];
			$this->set_response($invalidCredentials,422);
		} else {
			$get_school = $this->db->where('school_id',$this->input->post('school_id'))->get('school')->result();
			if(!empty($get_school)){
				$data['paymentlink'] = $get_school[0]->paymentlink;
				$this->set_response($data, REST_Controller::HTTP_OK);
			} else {
				$this->set_response(['msg'=>'School Not Found'],422);
			}
		}
	}

	public function get_school_user_post(){
		if(empty($this->input->post('topic_id')) && empty($this->input->post('school_id'))) {
			$this->form_validation->set_rules('school_id','School Id','required|trim',['required'=>'Please Select School']);
			$this->form_validation->set_rules('topic_id','Topic Id','required|trim',['required'=>'Please Select Topic']);

			if($this->form_validation->run()==false){ 
				$errs = $this->form_validation->error_array();
				$errors = [];
				foreach($errs as $err){ $errors [] = $err; }
				$invalidCredentials = ['msg'=>implode(',',$errors)];
				$this->set_response($invalidCredentials,422);
			}
		}
		else {
			$school_id =  $this->input->post('school_id');
			$subtopics = $this->db->select('stp_id,subtopic_text,sequence')->where('tp_id',$this->input->post('topic_id'))->get('subtopics')->result();
			if(!empty($subtopics)){
				foreach($subtopics as $key=>$sub){
					if(!empty($this->input->post('branch_id'))){
						$get_user_data = $this->db->join('users','users.user_id=user_achievement.user_id','left')->where('user_achievement.subtopic_id',$sub->stp_id)->where('users.school_id',$school_id)->where('users.branch_id',$this->input->post('branch_id'))->get('user_achievement')->result();
					} else {
						$get_user_data = $this->db->join('users','users.user_id=user_achievement.user_id','left')->where('user_achievement.subtopic_id',$sub->stp_id)->where('users.school_id',$school_id)->where('users.branch_id',0)->get('user_achievement')->result();
					}
					if(!empty($get_user_data)){
						$get_user[] = $get_user_data;
					}
				}
			}
			if(!empty($get_user)){
				$data['user_list'] = $get_user;
			}
			$data['subtopics'] = $subtopics;
			$this->set_response($data, REST_Controller::HTTP_OK);
		}
	}



	
}
