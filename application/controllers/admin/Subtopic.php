<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subtopic extends CI_Controller
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
		$this->session->unset_userdata('syllabus');
		$data['title']     = 'Sub Topics :: BrainPad Wave';
		$data['action']    = base_url('backend/subtopic/store');
		$data['page']      = 'admin/page/subtopic/index';
		$data['rec']       = $this->db->join('topics','topics.tp_id=subtopics.tp_id','left')
					->join('chapter','chapter.ch_id=topics.ch_id','left')->join('subject', 'subject.sub_id=chapter.subject_id', 'left')
					->join('board','board.bd_id=chapter.board_id','left')->join('standard','standard.std_id=chapter.std_id','left')
					->where('subtopics.lang',$this->language)->order_by("subtopics.sequence","asc")->get('subtopics')->result_array();

		$this->load->view('admin/partials/layout',$data);
	}

	public function create()
	{
		$data['title']      = 'Create Sub Topics :: BrainPad Wave';
		$data['action']     = base_url('backend/subtopic/store');
		$data['page']       = 'admin/page/subtopic/create';
		$data['board']      =  $this->crud_model->get_table_data('board','lang',$this->language);

		$this->load->view('admin/partials/layout', $data);
	}

	public function store(){

		$tp_id         = $this->input->post('topics');
		$subtopic_text = $this->input->post('stp_text');
		$file_img      = '';

		for ($i = 0; $i < count($subtopic_text);  $i++) {

			if (isset($_FILES['file']) && ($_FILES['file']['name'][$i] != '')) {
				$file_img = $this->crud_model->single_file_up($_FILES['file'],'subtopics',$i);
			}

			$get_data = $this->db->select_max('sequence')->where('tp_id',$tp_id)->get('subtopics')->result();
			if(!empty($get_data)){
				$sequence = $get_data[0]->sequence + 1 ;
			} else {
				$sequence = 1;
			}

			$this->db->insert('subtopics',[
				'tp_id'         => $tp_id,
				'ad_id'         => $this->session->userdata('brain_sess')['id'],
				'subtopic_text' => $subtopic_text[$i],
				'subtopic_img'  => $file_img,
				'lang'          => $this->language,
				'sequence'      => $sequence,
//				'board_id'   	=> $this->input->post('board_id'),
//				'std_id'     	=> $this->input->post('std_id'),
//				'subject_id' 	=> $this->input->post('sub_id')
			]);

		}

		$this->session->set_flashdata('success','Sub Topic added successfully');
		redirect(base_url('backend/subtopic'),'refresh');
	}

	public function edit($id)
	{
		$data['title']    = 'Sub Topic - Edit:: BrainPad Wave';
		$data['action']   = base_url('backend/subtopic/update/'.$id);
		$data['page']     = 'admin/page/subtopic/edit';
		$data['board']    =  $this->crud_model->get_table_data('board','lang',$this->language);
		$data['editData'] = $this->db->join('topics','topics.tp_id=subtopics.tp_id','left')
			->join('chapter','chapter.ch_id=topics.ch_id','left')->join('subject', 'subject.sub_id=chapter.subject_id', 'left')
			->join('board','board.bd_id=chapter.board_id','left')->join('standard','standard.std_id=chapter.std_id','left')
			->where('subtopics.stp_id',$id)->get('subtopics')->row();
		$this->load->view('admin/partials/layout',$data);
	}

	public function update($id){

		$data['tp_id']          = $this->input->post('topics');
		$data['subtopic_text']  = $this->input->post('stp_text');
		$data['lang']           = $this->input->post('language');
//		$data['board_id'] 	    = $this->input->post('board_id');
//		$data['std_id'] 	    = $this->input->post('std_id');
//		$data['subject_id'] 	= $this->input->post('sub_id');

		if (isset($_FILES['file']) && ($_FILES['file']['name'] != '')) {
			$data['subtopic_img'] = $this->crud_model->file_up($_FILES['file'],'subtopics');
		}

		$this->db->where('stp_id', $id)->update('subtopics',$data);

		$getExample = $this->db->where('stp_id',$id)->get('example')->result();
		if(!empty($getExample)){
			$getlanguage = $this->db->where('symbol',$this->input->post('language'))->get('languages')->result();
			
			foreach($getExample as $example){
				$exdata = array(
					'board_id'=>$this->input->post('board'),
					'std_id'=>$this->input->post('std_id'),
					'subject_id'=>$this->input->post('sub_id'),
					'ch_id'=>$this->input->post('chapter'),
					'tp_id'=>$this->input->post('topics'),
					'stp_id'=>$id,
					'lang'=>$getlanguage[0]->name
				);
				$this->db->where('ex_id', $example->ex_id)->update('example',$exdata);
			}
		}

		$this->session->set_flashdata('success','Sub Topic updated successfully');
		redirect(base_url('backend/subtopic'),'refresh');
	}

	public function remove($id)
	{
		$rec = $this->db->get_where('subtopics',['stp_id'=>$id])->row();

		(!empty($rec) && file_exists($rec->subtopic_img)) ? unlink($rec->subtopic_img) : '';

		$del_res = $this->db->where('stp_id',$id)->delete('subtopics');

		if($del_res)
		{
			$upd_res = $this->db->where('stp_id',$id)->update('example',['stp_id'=>'']);
			if($upd_res)
			{
				$this->session->set_flashdata('success','Sub Topic removed successfully');
				redirect(base_url('backend/subtopic'),'refresh');
			}
			else
			{
				$this->session->set_flashdata('error','Something went wrong');
				redirect(base_url('backend/subtopic'),'refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/subtopic'),'refresh');
		}
	}

	public function status($id, $status)
	{
		if($status == 1)
		{
			$res = $this->db->where('stp_id',$id)->update('subtopics',['subtopic_status'=>0]);
		}
		else
		{
			$res = $this->db->where('stp_id',$id)->update('subtopics',['subtopic_status'=>1]);
		}

		if($res)
		{
			$this->session->set_flashdata('success','Status Updated Successfully');
			redirect(base_url('backend/subtopic'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/subtopic'),'refresh');
		}
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);

			foreach($ids as $id){
				$get_example = $this->db->where('stp_id',$id)->get('example')->result();
				if(!empty($get_example)){
					foreach($get_example as $example){
						$get_ex = $this->db->where('ex_id',$example->ex_id)->get('example_data')->result();
						if(!empty($get_ex)){
							foreach($get_ex as $ex){
								$this->db->where('ed_id', $ex->ed_id)->delete('example_question_data');
								$this->db->where('ed_id', $ex->ed_id)->delete('example_answer_data');
							}
							$this->db->where('ex_id', $example->ex_id)->delete('example_data');
						}
					}
					$this->db->where('stp_id', $id)->delete('example');
					$this->db->where('subtopic_id', $id)->delete('example_lock_unlock');
				}
			}

			$this->db->where_in('stp_id', $ids)->delete('subtopics');
			$this->session->set_flashdata('success', 'Data Deleted successfully');
			echo 'Deleted successfully.';
		} else {
			$this->session->set_flashdata('error', 'Error');
			echo 'Error';
		}
	}

	public function index_api(){
		$board_id 	  = $this->input->post('board_id');
		$std_id 	  = $this->input->post('std_id');
		$subject_id   = $this->input->post('sub_id');
		$chapter_id   = $this->input->post('chapter_id');
		$topic_id 	  = $this->input->post('topic_id');

		// $this->session->unset_userdata('subtopics');

		if(!empty($topic_id)){
			$query = $this->db->where('subtopics.tp_id',$topic_id)
				->join('topics','topics.tp_id=subtopics.tp_id','left')
				->join('chapter','chapter.ch_id=topics.ch_id','left')
				->join('standard','chapter.std_id=standard.std_id','left')
				->join('subject','chapter.subject_id=subject.sub_id','left')
				->select('standard.std_name,subject.sub_name,chapter.chapter_text,topics.topic_text,subtopics.subtopic_text,subtopics.subtopic_img,subtopics.subtopic_status,subtopics.stp_id,chapter.ch_id,topics.tp_id,subtopics.sequence')
				->order_by("subtopics.sequence","asc");
			$query = $query->get('subtopics');
		} else {
			$query = $this->db->where('subtopics.tp_id',0)
				->join('topics','topics.tp_id=subtopics.tp_id','left')
				->join('chapter','chapter.ch_id=topics.ch_id','left')
				->join('standard','chapter.std_id=standard.std_id','left')
				->join('subject','chapter.subject_id=subject.sub_id','left')
				->select('standard.std_name,subject.sub_name,chapter.chapter_text,topics.topic_text,subtopics.subtopic_text,subtopics.subtopic_img,subtopics.subtopic_status,subtopics.stp_id,chapter.ch_id,topics.tp_id,subtopics.sequence')
				->order_by("subtopics.sequence","asc");
			$query = $query->get('subtopics');
		}

		// echo $this->db->last_query(); exit;
		
		$data = [];
		$all_data = [];
		foreach($query->result() as $r) { 
			$query_example = $this->db->where('stp_id',$r->stp_id)->get('example')->result_array();
			if(!empty($query_example)){
				$data['no_example'] = count($query_example);
			} else {
				$data['no_example'] = 0;
			}
			$data['stp_id']    = $r->stp_id;
			$data['std_name']  = $r->std_name;
			$data['subject_id']= $r->sub_name;
			$data['chapter']  =	$r->chapter_text;
			$data['topic']    =	$r->topic_text;
			$data['subtopic'] =	$r->subtopic_text;
			$data['image']    =	$r->subtopic_img;
			$data['status']   = $r->subtopic_status;
			$data['sequence'] = $r->sequence;
			$data['ids']      =	'board_id='. $board_id. '&std_id='. $std_id. '&subject_id='. $subject_id. '&ch_id='. $r->ch_id. '&tp_id='. $r->tp_id. '&stp_id='. $r->stp_id;
			$all_data[] = $data;
		} 
		

		$result = array(
			"data" => $all_data
		); 

		$data= $this->load->view('admin/page/subtopic/table',$result, TRUE);

		echo $data;

		// $subtopics = array( 
		// 	'board_id'=>$board_id, 	  
		// 	'std_id'=>$std_id, 	  
		// 	'subject_id'=>$subject_id,   
		// 	'chapter_id'=>$chapter_id,   
		// 	'topic_id'=>$topic_id 	  
		//  );  
		 
		//  $this->session->set_userdata('subtopics', $subtopics);
	}

	public function copy($id){
		$get_examples = $this->db->select('ex_id')->where('stp_id',$id)->get('example')->result_array();

		$sub_insert_id = $this->crud_model->duplicateRecord('subtopics','stp_id',$id);
		
		if(!empty($get_examples)){
			foreach($get_examples as $example){
				$ex_id = $example['ex_id'];
				$insert_id = $this->crud_model->duplicateRecord('example','ex_id',$ex_id);
				
				$data = array(
					'stp_id'=>$sub_insert_id	
				);
				
				$this->db->where('ex_id', $insert_id)->update('example',$data);

				$e_data = $this->crud_model->get_table_data('example_data','ex_id',$ex_id);

				foreach ($e_data as $ed){

					// Duplicate Example Data
					$ed_data_id = $this->crud_model->duplicateRecord('example_data','ed_id',$ed['ed_id'],'ex_id',$insert_id);

					// Duplicate Question
					$eq_data = $this->crud_model->get_table_data('example_question_data','ed_id',$ed['ed_id']);
					foreach ($eq_data as $eqd) {
						$this->crud_model->duplicateRecord('example_question_data', 'eqd_id', $eqd['eqd_id'],'ed_id',$ed_data_id);
					}
					// Duplicate Answer
					$ea_data = $this->crud_model->get_table_data('example_answer_data','ed_id',$ed['ed_id']);
					foreach ($ea_data as $eqd) {
						$this->crud_model->duplicateRecord('example_answer_data', 'ead_id', $eqd['ead_id'],'ed_id',$ed_data_id);
					}
				}
			} 
		}
		
		echo 'success';
	}
}
