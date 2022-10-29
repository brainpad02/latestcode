<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School extends CI_Controller
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
		$data['title']     = 'School :: BrainPad Wave';
		$data['action']    = base_url('backend/school/create');
		$data['page']      = 'admin/page/school/index';
		$data['rec']       = $this->db
                            ->where('is_deleted',0)
							->get('school')
                            ->result_array();

		$this->load->view('admin/partials/layout',$data);
	}

    public function create()
	{
		$data['title']      = 'Create School :: BrainPad Wave';
		$data['action']     = base_url('backend/school/store');
		$data['page']       = 'admin/page/school/create';
		$data['studentplan']       = $this->db->where('user_category', 'Student')->get('subscription_plans')->result();
		$data['teacherplan']       = $this->db->where('user_category', 'Teacher')->get('subscription_plans')->result();
        
        $this->load->view('admin/partials/layout', $data);
	}

	public function store(){

		
        $logo = $this->crud_model->file_up($_FILES['file'],'school');

        $school_name = ucfirst(substr($this->input->post('school_name'), 0, 4)).mt_rand(1111,9999);
		$this->db->insert('school',[
			'school_code' => $school_name,
            'school_name' => $this->input->post('school_name'),
            'school_logo' => $logo,
            'school_description' => $this->input->post('school_description'),
            'school_phoneno' => $this->input->post('school_phone'),
            'school_address' => $this->input->post('school_address'),
            'school_city' => $this->input->post('school_city'),
            'school_state' => $this->input->post('school_state'),
            'school_country' => $this->input->post('school_country'),
            'school_zipcode' => $this->input->post('school_zipcode'),
			'applink' => $this->input->post('school_applink'),
			'paymentlink' => $this->input->post('school_paymentlink'),
			'free_students' => $this->input->post('free_students'),
			'no_licence' => $this->input->post('no_licence'),
			'expiry_date' => $this->input->post('expiry_date'),
			'language' => $this->input->post('language'),
			'board' => $this->input->post('board'),
			'std_id' => $this->input->post('std_id'),
			'branch_code' => $this->input->post('branch_code'),
			'student_plans' => implode(",",$this->input->post('student_plans')),
			'teacher_plans' => implode(",",$this->input->post('teacher_plans')),
			'google_package_token' => $this->input->post('package_token'),
			'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
		]);

		$this->session->set_flashdata('success','School added successfully');
		redirect(base_url('backend/school'),'refresh');
	}

	public function edit($id)
	{
		$data['title']     = 'School - Edit :: BrainPad Wave';
		$data['action']    =  base_url('backend/school/update/'.$id);
		$data['page']      = 'admin/page/school/edit';
		$data['editData'] = $this->db->where('school_id',$id)->get('school')->row();
		$data['studentplan']       = $this->db->where('user_category', 'Student')->get('subscription_plans')->result();
		$data['teacherplan']       = $this->db->where('user_category', 'Teacher')->get('subscription_plans')->result();
        $this->load->view('admin/partials/layout',$data);
	}

	public function view($id)
	{
		$data['title']     = 'School - View :: BrainPad Wave';
		$data['page']      = 'admin/page/school/view';
		$data['editData'] = $this->db->where('school_id',$id)->get('school')->row();
		$data['studentplan']       = $this->db->where('user_category', 'Student')->get('subscription_plans')->result();
		$data['teacherplan']       = $this->db->where('user_category', 'Teacher')->get('subscription_plans')->result();
        $this->load->view('admin/partials/layout',$data);
	}

	public function update($id)
	{
		$school_name = ucfirst(substr($this->input->post('school_name'), 0, 4)).mt_rand(1111,9999);
        $data = array(
            // 'school_code' => $school_name,
            'school_name' => $this->input->post('school_name'),
            'school_description' => $this->input->post('school_description'),
            'school_phoneno' => $this->input->post('school_phone'),
            'school_address' => $this->input->post('school_address'),
            'school_city' => $this->input->post('school_city'),
            'school_state' => $this->input->post('school_state'),
            'school_country' => $this->input->post('school_country'),
            'school_zipcode' => $this->input->post('school_zipcode'),
			'applink' => $this->input->post('school_applink'),
			'paymentlink' => $this->input->post('school_paymentlink'),
			'free_students' => $this->input->post('free_students'),
			'no_licence' => $this->input->post('no_licence'),
			'expiry_date' => $this->input->post('expiry_date'),
			'language' => $this->input->post('language'),
			'board' => $this->input->post('board'),
			'std_id' => $this->input->post('std_id'),
			'branch_code' => $this->input->post('branch_code'),
			'student_plans' => implode(",",$this->input->post('student_plans')),
			'teacher_plans' => implode(",",$this->input->post('teacher_plans')),
			'google_package_token' => $this->input->post('package_token'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
	
		if(!empty($_FILES['file']['name'])){ 
            $logo = $this->crud_model->file_up($_FILES['file'],'school');
            $data['school_logo'] = $logo; 
        } else { 
			$data['school_logo'] = $this->input->post('oldlogo');
		}
		
		$this->db->where('school_id', $id)->update('school',$data);

		$this->session->set_flashdata('success','School updated successfully');
		redirect(base_url('backend/school'),'refresh');
	}

	public function remove($id)
	{
		$data['is_deleted'] = 1;
		$del_res = $this->db->where('school_id', $id)->update('school',$data);

		if($del_res)
		{
			$this->session->set_flashdata('success','School removed successfully');
			redirect(base_url('backend/school'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/school'),'refresh');
		}
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);
			if(!empty($ids)){
				foreach($ids as $id){
					$this->db->where('school_id', $id)->update('school',['is_deleted'=>1]);
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
