<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller
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
		$data['title']      = 'Teacher Access :: BrainPad Wave';
		$data['board']      =  $this->crud_model->get_table_data('board','lang',$this->language);
		$data['accessdata'] = $this->db->get('teacher_access')->result();
		$data['action']     = base_url('backend/teacher/store');
		$data['page']       = 'admin/page/teacher/create';
		$this->load->view('admin/partials/layout', $data);
	}

	public function store(){
        if(!empty($this->input->post('access_module'))){
            $data = array();
            foreach($this->input->post('access_module') as $teacher){
               $data[] = $teacher;
            }
        }

		if(empty($this->input->post('id'))){
			if(!empty($data)){
				$data = implode(',',$data);
				$this->db->insert('teacher_access',[
					 'access_topics' => $data,
					 'created_at' => date('Y-m-d H:i:s'),
					 'updated_at' => date('Y-m-d H:i:s'),
				]);
			 }
		} else {
			if(!empty($data)){
				$data = implode(',',$data);
				$this->db->where('id',$this->input->post('id'))->update('teacher_access',[
					 'access_topics' => $data,
					 'updated_at' => date('Y-m-d H:i:s'),
				]);
			 }
		}
        
		$this->session->set_flashdata('success','Teacher Access successfully');
		redirect(base_url('backend/teacher'),'refresh');

	}

	
}
