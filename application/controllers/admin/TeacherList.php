<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//PhpSpreadsheet

class Teacherlist extends CI_Controller
{

	function __construct()
	{
		parent:: __construct();
		$this->general->session_check();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	public function listdata()
	{
		$data['title'] = 'TeacherList :: BrainPad Wave';
		$data['page']  = 'admin/page/teacherlist/index';
        $data['rec'] = $this->db->select('users.user_id,users.usercode,users.username,users.password,school.school_name,users.email_id,users.phone_no')->join('school','users.school_id=school.school_id','left')->where('user_type',1)->get('users')->result_array();
        $this->load->view('admin/partials/layout', $data);
	}

	public function edit($id){
        $data['title']    = 'Teachers - Edit:: BrainPad Wave';
		$data['action']   = base_url('backend/teacherlist/update/'.$id);
		$data['page']     = 'admin/page/teacherlist/edit';
		$data['editData'] = $this->db->where('user_id',$id)->get('users')->result();
		$this->load->view('admin/partials/layout',$data);
    }

    public function update($id){
        $data = array(
            'username'=>$this->input->post('username'),
            'password'=>$this->input->post('password'),
        );
        $this->db->where('user_id', $id)->update('users',$data);
        $this->session->set_flashdata('success','Teachers data updated successfully');
		redirect(base_url('backend/teacherlist'),'refresh');
    }

	

}
