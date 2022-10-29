<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Topic extends CI_Controller
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
		$data['title'] = 'Topic :: BrainPad Wave';
		$data['page'] = 'admin/page/topic/index';
		$data['rec'] = $this->db->join('chapter','chapter.ch_id=topics.ch_id','left')->join('subject', 'subject.sub_id=chapter.subject_id', 'left')
			->join('board','board.bd_id=chapter.board_id','left')->join('standard','standard.std_id=chapter.std_id','left')
			->select('board.bd_name,standard.std_name,subject.sub_name,chapter.chapter_text,topics.topic_text,topics.topic_img,topics.tp_id,topics.sequence as se,topics.topic_status')
			->where('topics.lang',$this->language)->order_by("topics.sequence","asc")->get('topics')->result_array();
			// echo $this->db->last_query(); 

		// echo "<pre>"; print_r($data); exit;
		$data['method'] = 'create';
		$this->load->view('admin/partials/layout', $data);
	}

	public function create()
	{
		$data['title']      = 'Create Topic :: BrainPad Wave';
		$data['board']      =  $this->crud_model->get_table_data('board','lang',$this->language);
		$data['action']     = base_url('backend/topic/store');
		$data['page']       = 'admin/page/topic/create';

		$this->load->view('admin/partials/layout', $data);
	}

	public function store(){

		$ch_id = $this->input->post('chapter');
		$topic = $this->input->post('tp_text');

		for ($i = 0; $i < count($topic);  $i++) {

			if (isset($_FILES['tp_img']) && ($_FILES['tp_img']['name'][$i] != '')) {
				$ex_tp_img = $this->crud_model->single_file_up($_FILES['tp_img'],'topics',$i);
			}

			$get_data = $this->db->select_max('sequence')->where('ch_id',$ch_id)->get('topics')->result();
			if(!empty($get_data)){
				$sequence = $get_data[0]->sequence + 1 ;
			} else {
				$sequence = 1;
			}

			$this->db->insert('topics',[
				'ch_id'      => $ch_id,
				'ad_id'      => $this->session->userdata('brain_sess')['id'],
				'topic_text' => $topic[$i],
				'topic_img'  => $ex_tp_img,
				'lang'       => $this->language,
				'sequence'   => $sequence,
//				'board_id'   => $this->input->post('board_id'),
//				'std_id'     => $this->input->post('std_id'),
//				'subject_id' => $this->input->post('sub_id'),
			]);
		}

		$this->session->set_flashdata('success','Topics added successfully');
		redirect(base_url('backend/topic'),'refresh');

	}

	public function edit($id)
	{
		$data['title']    = 'Topic - Edit:: BrainPad Wave';
		$data['action']   = base_url('backend/topic/update/'.$id);
		$data['page']     = 'admin/page/topic/edit';
		$data['board']      =  $this->crud_model->get_table_data('board','lang',$this->language);
		$data['editData'] = $this->db->join('chapter','chapter.ch_id=topics.ch_id','LEFT')->where('tp_id',$id)->get('topics')->row();

		$this->load->view('admin/partials/layout',$data);
	}

	public function update($id){

		$data['ch_id']       =  $this->input->post('chapter');
		$data['topic_text']  =  $this->input->post('tp_text');
		$data['lang']        =  $this->input->post('lang');
//		$data['board_id'] 	     = $this->input->post('board_id');
//		$data['std_id'] 	     = $this->input->post('std_id');
//		$data['subject_id'] 	 = $this->input->post('sub_id');

		if (isset($_FILES['file']) && ($_FILES['file']['name'] != '')) {
			$data['topic_img'] = $this->crud_model->file_up($_FILES['file'],'topics');
			}

		$this->db->where('tp_id', $id)->update('topics',$data);

		$getsubtopics = $this->db->where('tp_id',$id)->get('subtopics')->result();
		if(!empty($getsubtopics)){
			$getlanguage = $this->db->where('symbol',$this->input->post('lang'))->get('languages')->result();
			foreach($getsubtopics as $topics){
				if($topics->lang != $this->input->post('lang')){
					$subdata = array(
						'lang'=>$this->input->post('lang')
					);
					$this->db->where('stp_id', $topics->stp_id)->update('subtopics',$subdata);

					$getExample = $this->db->where('stp_id',$topics->stp_id)->get('example')->result();
					if(!empty($getExample)){
						foreach($getExample as $example){
							$exdata = array(
								'board_id'=>$this->input->post('board_id'),
								'std_id'=>$this->input->post('std_id'),
								'subject_id'=>$this->input->post('sub_id'),
								'ch_id'=>$this->input->post('chapter'),
								'tp_id'=>$id,
								'stp_id'=>$topics->stp_id,
								'lang'=>$getlanguage[0]->name
							);
							$this->db->where('ex_id', $example->ex_id)->update('example',$exdata);
						}
					}
				}
			}
		}

		$this->session->set_flashdata('success','Topics updated successfully');
		redirect(base_url('backend/topic'),'refresh');
	}

	public function remove($id)
	{
		$rec = $this->db->get_where('topics',['tp_id'=>$id])->row();

		(!empty($rec)  && file_exists($rec->topic_img !='')) ? unlink($rec->topic_img) : '';

		$upd_res = $this->db->where('tp_id',$id)->update('subtopics',['tp_id'=>0]);
		$del_res = $this->db->where('tp_id',$id)->delete('topics');

		if($del_res)
		{
			$this->session->set_flashdata('success','Topic removed successfully');
			redirect(base_url('backend/topic'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/topic'),'refresh');
		}
	}

	public function status($id, $status)
	{
		if($status == 1)
		{
			$res = $this->db->where('tp_id',$id)->update('topics',['topic_status'=>0]);
		}
		else
		{
			$res = $this->db->where('tp_id',$id)->update('topics',['topic_status'=>1]);
		}

		if($res)
		{
			$this->session->set_flashdata('success','Status Updated Successfully');
			redirect(base_url('backend/topic'),'refresh');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong');
			redirect(base_url('backend/topic'),'refresh');
		}
	}

	public function getChapter()
	{
		$bssid = $this->input->post('bssid');
		$ch_list = $this->db->get_where('chapter',['chapter_status'=>1,'bss_id'=>$bssid])->result();
		$chapter = '';

		if(!empty($ch_list))
		{
			$chapter.='<option value="">------- Choose Chapter ------</option>';
			foreach($ch_list as $ch)
			{
				$chapter.='<option value="'.$ch->ch_id.'">'.$ch->chapter_text.'</option>';
			}
		}
		else
		{
			$chapter.= '<option value=""> ---  No Chapter Found ! --- </option>';
		}
		echo $chapter;
	}

	public function getEditChapter()
	{
		$bssid = $this->input->post('bssid');
		$chid = $this->input->post('chid');
		$ch_list = $this->db->get_where('chapter',['chapter_status'=>1,'bss_id'=>$bssid])->result();
		$chapter = '';

		if(!empty($ch_list))
		{
			$chapter.='<option value="">------- Choose Chapter ------</option>';
			foreach($ch_list as $ch)
			{
				$chapter.='<option value="'.$ch->ch_id.'" '.(($chid!='')?(($chid==$ch->ch_id)?"selected":""):"").'>'.$ch->chapter_text.'</option>';
			}
		}
		else
		{
			$chapter.= '<option value=""> ---  No Chapter Found ! --- </option>';
		}
		echo $chapter;
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);

			$this->db->where_in('tp_id', $ids)->delete('topics');
			$this->session->set_flashdata('success', 'Data Deleted successfully');
			echo 'Deleted successfully.';
		} else {
			$this->session->set_flashdata('error', 'Error');
			echo 'Error';
		}
	}

	public function copy($id){
		$get_subtopics = $this->db->select('stp_id')->where('tp_id',$id)->get('subtopics')->result_array();

		$topic_insert_id = $this->crud_model->duplicateRecord('topics','tp_id',$id);

		if(!empty($get_subtopics)){
			foreach($get_subtopics as $subtopics){
				$subtopic_id = $subtopics['stp_id'];
				$sub_insert_id = $this->crud_model->duplicateRecord('subtopics','stp_id',$subtopic_id);
				$subdata = array(
					'tp_id'=>$topic_insert_id
				);
				$this->db->where('stp_id', $subtopic_inserted_id)->update('subtopics',$subdata);

				$get_examples = $this->db->select('ex_id')->where('stp_id',$subtopic_id)->get('example')->result_array();

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
			}
		}

		echo 'success';
	}

	public function index_api(){
		$std_id = $this->input->post('std_id');
		$board_id = $this->input->post('board_id');
		$sub_id = $this->input->post('sub_id');
		$ch_id = $this->input->post('ch_id');
		$query =	 $this->db
				->select('topics.*,chapter.*,subject.*,board.*,standard.*,topics.sequence as se')
				->join('chapter','chapter.ch_id=topics.ch_id','left')
				->join('board','chapter.board_id=board.bd_id','left')	
				->join('standard','chapter.std_id=standard.std_id','left')
				->join('subject','subject.sub_id=chapter.subject_id','left')
				->where('topics.ch_id',$ch_id)
				->order_by("topics.sequence","asc");
		$query = $query->get('topics');
		// echo $this->db->last_query(); exit;
		$data = [];
		$all_data = [];
		foreach($query->result() as $r) { 
			$data['tp_id'] = $r->tp_id;
			$data['bd_name'] = $r->bd_name;
			$data['std_name'] = $r->std_name;
			$data['sub_name'] = $r->sub_name;
			$data['chapter_text'] = $r->chapter_text;
			$data['topic_text'] = $r->topic_text;
			$data['topic_img'] = $r->topic_img;
			$data['se'] = $r->se;
			$data['topic_status'] = $r->topic_status;
			$all_data[] = $data;
		} 
		$result = array(
			"data" => $all_data
		);
		$data = $this->load->view('admin/page/topic/table',$result, TRUE);
		
		// echo "<pre>"; print_r($data); exit;
		echo json_encode($data);
	}
}
