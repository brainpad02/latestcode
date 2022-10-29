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
		$data['page']  = 'teachers/page/user/index';
        $this->load->view('teachers/partials/layout', $data);
	}

	public function getSubtopics(){
		$school_id =  $this->session->userdata('brain_sess')['school_id'];
		$subtopics = $this->db->select('stp_id,subtopic_text,sequence')->where('tp_id',$this->input->post('topic'))->get('subtopics')->result();
		if(!empty($subtopics)){
			foreach($subtopics as $key=>$sub){
				$get_user[] = $this->db->join('users','users.user_id=user_achievement.user_id','left')->where('user_achievement.subtopic_id',$sub->stp_id)->where('users.school_id',$school_id)->get('user_achievement')->result();
			}
		}
		$data['subtopics'] = $subtopics;
		$data['user_list'] = $get_user;
		$html_data = $this->load->view('teachers/page/user/list', $data);
		return $html_data;
	}

	

}
