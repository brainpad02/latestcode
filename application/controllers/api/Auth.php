<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Firebase\JWT\JWT;

class Auth extends BD_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function social_login_post(){ 
		$count = count($_POST); 
		if(!empty($this->input->post('usercode'))){
			if(!empty($this->input->post('school_id'))){
				if(!empty($this->input->post('device_id'))){
					$user_data = $this->db->where('usercode',$this->input->post('usercode'))->where('school_id',$this->input->post('school_id'))->get('users')->result();
					if(!empty($user_data)){
						$token['id'] = $user_data[0]->user_id;
						$new_token = $this->generate_token($token);
						$profile = $this->profile_data($token['id'], $new_token);

						// update device_id
						$update_device_id = array(
							'device_id'=>$this->input->post('device_id'),
						);
						$this->db->where('user_id', $user_data[0]->user_id)->update('users',$update_device_id);
						// update device_id

						$school_id = $profile['school_id'];
						$get_school_name = $this->db->where('school_id',$school_id)->get('school')->result();
											
						if(!empty($get_school_name)){
							$school_code = $get_school_name[0]->school_code;
							$school_name = $get_school_name[0]->school_name;
						}

						$profile['school_code'] = $school_code;
						$profile['school_name'] = $school_name;

						$response['data'] = $profile;
						$get_active = $this->db->where('user_id',$user_data[0]->user_id)->where('is_active_plan',1)->get('subscription')->result();
						if(!empty($get_active)){
							$plan_details = $this->db->where('plan_id',$get_active[0]->plan_id)->get('subscription_plans')->result();
							if(!empty($plan_details)){
								$response['data']['subscription_plan'] = $plan_details;
							}
						}

						$response['data']['is_existing'] = 1;
						$this->set_response($response, REST_Controller::HTTP_OK);
					} else {
						$this->set_response(['msg'=>'User Not Found'],422);
					}
		    	} else {
					$this->set_response(['msg'=>'Device Id Not Found'],422);
				}
		  } else {
			$this->set_response(['msg'=>'School Id Not Found'],422);
		  }
		} else if(!empty($this->input->post('social_id')) && ($count == 2)){  
			if(!empty($this->input->post('school_id'))){
				if(!empty($this->input->post('device_id'))){
					$user_data = $this->db->where('social_id',$this->input->post('social_id'))->where('school_id',$this->input->post('school_id'))->get('users')->result();
					if(!empty($user_data)){
						$token['id'] = $user_data[0]->user_id;
						$new_token = $this->generate_token($token);
						$profile = $this->profile_data($token['id'], $new_token);

						// update device_id
						$update_device_id = array(
							'device_id'=>$this->input->post('device_id'),
						);
						$this->db->where('user_id', $user_data[0]->user_id)->update('users',$update_device_id);
						// update device_id

						$school_id = $profile['school_id'];
						$get_school_name = $this->db->where('school_id',$school_id)->get('school')->result();
											
						if(!empty($get_school_name)){
							$school_code = $get_school_name[0]->school_code;
							$school_name = $get_school_name[0]->school_name;

							$profile['school_code'] = $school_code;
							$profile['school_name'] = $school_name;
						}

						$response['data'] = $profile;
						$get_active = $this->db->where('user_id',$user_data[0]->user_id)->where('is_active_plan',1)->get('subscription')->result();
						if(!empty($get_active)){
							$plan_details = $this->db->where('plan_id',$get_active[0]->plan_id)->get('subscription_plans')->result();
							if(!empty($plan_details)){
								$response['data']['subscription_plan'] = $plan_details;
							}
						}
						$response['data']['is_existing'] = 1;
						$this->set_response($response, REST_Controller::HTTP_OK);
					} else {
						$this->set_response(['msg'=>'User Not Found'],422);
					}
				} else {
					$this->set_response(['msg'=>'Device Id Not Found'],422);
				}
		  } else {
			$this->set_response(['msg'=>'School Id Not Found'],422);
		  }
		} else {
			if(!empty($this->input->post('lang'))){
				if(!empty($this->input->post('board_id'))){
					if(!empty($this->input->post('user_type'))){
						if(!empty($this->input->post('standard'))){
							  if(!empty($this->input->post('name'))){ 
								if(!empty($this->input->post('school_id'))){ 
									if(!empty($this->input->post('device_id'))){ 
										$lang = $this->db->where('id',$this->input->post('lang'))->get('languages')->result(); 
										
										if(!empty($lang[0]->symbol)){
											$name = ucfirst(substr($this->input->post('name'), 0, 4)).mt_rand(1111,9999);
											if(!empty($this->input->post('school_id'))){
												$school_id = $this->input->post('school_id');
											} else {
												$school_id = 7;
											}

											$get_school_name = $this->db->where('school_id',$school_id)->get('school')->result();
											
											if(!empty($get_school_name)){
												$school_code = $get_school_name[0]->school_code;
												$school_name = $get_school_name[0]->school_name;
												// $plan_id = $get_school_name[0]->plan_id;
												$licence = $get_school_name[0]->no_licence;
												$free_student = $get_school_name[0]->free_students;
											}

											$social_id = ''; $social_type = ''; $email_id = ''; $phone_no = '';$branch_id = '';
											if(!empty($this->input->post('social_id'))){
												$social_id = $this->input->post('social_id');
											}

											if(!empty($this->input->post('social_type'))){
												$social_type = $this->input->post('social_type');
											}

											if(!empty($this->input->post('email_id'))){
												$email_id = $this->input->post('email_id');
											}

											if(!empty($this->input->post('phone_no'))){
												$phone_no = $this->input->post('phone_no');
											}

											if(!empty($this->input->post('branch_id'))){
												$branch_id = $this->input->post('branch_id');
											}

											$data = array(
												'username'=>$this->input->post('name'),
												'usercode'=>$name,
												'user_type'=>$this->input->post('user_type'),
												'board'=>$this->input->post('board_id'),
												'lang'=>$lang[0]->symbol,
												'school_id'=>$school_id,
												'standard'=>$this->input->post('standard'),
												'is_profile_complete'=>1,
												'social_id'=>$social_id,
												'social_type'=>$social_type,
												'email_id'=>$email_id,
												'phone_no'=>$phone_no,
												'device_id'=>$this->input->post('device_id'),
												'branch_id'=>$branch_id,
											);

											$get_data  = $this->db->where('social_id',$this->input->post('social_id'))->get('users')->result();

											if(empty($get_data)){
												$this->db->insert('users', $data);
												$token['id'] = $this->db->insert_id();
											} else {
												$token['id'] = $get_data[0]->user_id;
											}
											
											$new_token = $this->generate_token($token);
											$profile = $this->profile_data($token['id'], $new_token);
			
											// $get_standard_list = $this->db->where('board_id',$this->input->post('board_id'))->get('standard')->result();
											// if(!empty($get_standard_list)){
											// 	$profile['standard_list'] = $get_standard_list;
											// }

											if($profile['is_profile_complete'] == 1){
												if($this->input->post('user_type') == 1){
													$type = 'Teacher';
												} else {
													$type = 'Student';
												}
												// $get_subscription_plan = $this->db->where('school_id',$school_id)->where('user_category',$type)->get('subscription_plans')->result();
												// if(!empty($get_subscription_plan)){
												// 	// $plan_id = $get_subscription_plan[0]->plan_id;
												// 	// $subscription_data = array(
												// 	// 	'user_id'=>$token['id'],
												// 	// 	'plan_id'=>$plan_id,
												// 	// 	'is_active_plan'=>1,
												// 	// 	'start_date'=>date('Y-m-d H:i:s'),
												// 	// 	'created_at' => date('Y-m-d H:i:s'),
												// 	// 	'updated_at' => date('Y-m-d H:i:s'),		
												// 	// );
												// 	// $this->db->insert('subscription', $subscription_data);
												// 	$profile['subscription_plan'] = $get_subscription_plan;
												// }
											}

											$profile['school_code'] = $school_code;
											$profile['school_name'] = $school_name;

											$response['data'] = $profile;
											$response['data']['is_existing'] = 0;
				
											$this->set_response($response, REST_Controller::HTTP_OK);
									} else {
										$this->set_response(['msg'=>'Language not found'],422);	
									}
							   } else {
								 $this->set_response(['msg'=>'Device Id is empty'],422);
							   } 
							 } else {
								$this->set_response(['msg'=>'School Id is empty'],422);	
							 } 
							} else {
								$this->set_response(['msg'=>'User Name is empty'],422);	
							}
						} else {
							$this->set_response(['msg'=>'Standard is empty'],422);
						}
					} else {
						$this->set_response(['msg'=>'User Type is empty'],422);
					}
				} else {
					$this->set_response(['msg'=>'Board Id is empty'],422);
				}
			} else {
				$this->set_response(['msg'=>'Language Id is empty'],422);
			}
		}

	}

	public function get_available_student_post(){
		if(!empty($this->input->post('school_id'))){
			if(!empty($this->input->post('plan_type'))){
				if(!empty($this->input->post('plan_id'))){
					if(!empty($this->input->post('user_id'))){
					// $get_plan = $this->db->where('plan_type_id',$this->input->post('plan_type'))->get('plan_type')->result();
					if(!empty($this->input->post('plan_type'))){
						if($this->input->post('plan_type') == 'Free'){
							$type = 0;
						} else {
							$type = 1;
						}
		
						$msg = '';
		
						$get_school_plan = $this->db->where('school_id',$this->input->post('school_id'))->get('school')->result();
						if(!empty($get_school_plan)){
							// $free_plan_id = $get_school_plan[0]->free_plan_id;
							// $paid_plan_id = $get_school_plan[0]->paid_plan_id;
							$free_student = $get_school_plan[0]->free_students;
							$paid_licence = $get_school_plan[0]->no_licence;
		
							// if($type == 0){
							// 	$plan_id = $free_plan_id;
							// } else {
							// 	$plan_id = $paid_plan_id;
							// }
		
							$get_users = $this->db->where('school_id',$this->input->post('school_id'))->where('user_type',2)->get('users')->result();
		
							if(!empty($get_users)){
								$count_array = array();
								foreach($get_users as $users){
									$user_id = $users->user_id;
									$subscription = $this->db->where('user_id',$user_id)->where('plan_id',$this->input->post('plan_id'))->get('subscription')->result();
									if(!empty($subscription)){
										$count_array[] = $subscription[0]->sub_id;
									}
								}
								
								$count = count($count_array);  
								if($type == 0){
									if($count < $free_student){
										$is_available = 1;
										$update_plan = array(
											'plan_id'=>$this->input->post('plan_id'),
										);
										$this->db->where('user_id', $this->input->post('user_id'))->update('users',$update_plan);

									} else {
										$is_available = 0;
										$msg = 'Please contact school admin and contact number is '.$get_school_plan[0]->school_phoneno;
									}
								} else {
									if($count < $paid_licence){
										$is_available = 1;
										$update_plan = array(
											'plan_id'=>$this->input->post('plan_id'),
										);
										$this->db->where('user_id', $this->input->post('user_id'))->update('users',$update_plan);
									} else {
										$is_available = 0;
										$msg = 'Please contact school admin and contact number is '.$get_school_plan[0]->school_phoneno;
									}
								}
							} else {
								$is_available = 1;
							}
		
							$response = array(
								'is_available'=>$is_available,
								'msg'=>$msg
							);
		
							$this->set_response($response, REST_Controller::HTTP_OK);
						}
					}
				  } else {
					$this->set_response(['msg'=>'User Id is Required'],422);
				  }
				} else {
					$this->set_response(['msg'=>'Subscription Plan is Required'],422);
				}
			} else {
				$this->set_response(['msg'=>'Plan Type is Required'],422);
			}
		} else {
			$this->set_response(['msg'=>'School is Required'],422);
		}
	}

	public function verify_user_post(){
		if(!empty($this->input->post('usercode'))){
			$user_data = $this->db->where('usercode',$this->input->post('usercode'))->get('users')->result();
			if(!empty($user_data)){
				$token['id'] = $user_data[0]->user_id;
				$new_token = $this->generate_token($token);
				$profile = $this->profile_data($token['id'], $new_token);

				$school_id = $profile['school_id'];
				$get_school_name = $this->db->where('school_id',$school_id)->get('school')->result();
									
				if(!empty($get_school_name)){
					$school_code = $get_school_name[0]->school_code;
					$school_name = $get_school_name[0]->school_name;
				}

				$profile['school_code'] = $school_code;
				$profile['school_name'] = $school_name;

				$response['data'] = $profile;
				$response['data']['user_verified'] = 1;
				$get_active = $this->db->where('user_id',$user_data[0]->user_id)->where('is_active_plan',1)->get('subscription')->result();
				if(!empty($get_active)){
					$plan_details = $this->db->where('plan_id',$get_active[0]->plan_id)->get('subscription_plans')->result();
					if(!empty($plan_details)){
						$response['data']['subscription_plan'] = $plan_details;
					}
				}
			} else {
				$response['data']['user_verified'] = 0;
			}
			$this->set_response($response, REST_Controller::HTTP_OK);
		} else {
			$this->set_response(['msg'=>'Usercode Required'],422);	
		}
	}

	public function social_user_exist_post(){
		if(!empty($this->input->post('social_id'))){
			$get_user = $this->db->where('social_id',$this->input->post('social_id'))->get('users')->result();
			if(empty($get_user)){ 
				$response['flag'] = 0;
			} else { 
				$response['flag'] = 1;
			} 
			$this->set_response($response, REST_Controller::HTTP_OK);
		} else {
			$this->set_response(['msg'=>'Social Id Required'],422);	
		}
	}

	
}
