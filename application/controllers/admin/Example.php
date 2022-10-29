<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Example extends CI_Controller
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
		$data['title'] = 'Example List :: BrainPad Wave';
		$data['page']  = 'admin/page/example/index';
		$data['board'] =  $this->crud_model->get_table_data('board','lang',$this->language);

		$this->load->view('admin/partials/layout', $data);
	}

	public function index_api()
	{
		$board_id 	  = $this->input->post('board_id');
		$std_id 	  = $this->input->post('std_id');
		$subject_id   = $this->input->post('sub_id');
		$chapter_id   = $this->input->post('chapter_id');
		$topic_id 	  = $this->input->post('topic_id');

		$query = $this->db->where('example.board_id',$board_id)->where('example.std_id',$std_id)->where('example.subject_id',$subject_id)->where('example.tp_id',$topic_id)
				->join('chapter','chapter.ch_id=example.ch_id','left')
				->join('topics','topics.tp_id=example.tp_id','left')
				->join('subtopics','subtopics.stp_id=example.stp_id','left')
				->group_by('example.stp_id')
				->select('example.ch_id,example.tp_id,example.stp_id,chapter_text,topic_text,subtopic_text,count(ex_id) as total');

			if($chapter_id != ''){
				$query->where('example.ch_id',$chapter_id);
			}

		$query = $query->get('example');
		$data = [];
		$all_data = [];
		foreach($query->result() as $r) {
			$data['subject_id']= $subject_id;
			$data['chapter']  =	$r->chapter_text;
			$data['topic']    =	$r->topic_text;
			$data['subtopic'] =	$r->subtopic_text;
			$data['total']    =	$r->total;
			$data['ids']      =	'board_id='. $board_id. '&std_id='. $std_id. '&subject_id='. $subject_id. '&ch_id='. $r->ch_id. '&tp_id='. $r->tp_id. '&stp_id='. $r->stp_id;
			$all_data[] = $data;
		}

		$result = array(
			"data" => $all_data
		);
		$data= $this->load->view('admin/page/example/table',$result, TRUE);

		echo $data;
	}

	public function create()
	{
		$data['title']      = 'Create Example :: BrainPad Wave';
		$data['action']     = base_url('backend/example/store');
		$data['page']       = 'admin/page/example/create';
		$data['sub_topics'] = $this->db->get('subtopics')->result();
		$data['category']   = $this->db->get('category')->result_array();
		$data['layout']     = $this->db->get('layout')->result_array();
		$data['animation']  = $this->db->get('animation')->result_array();
		$data['lang']       = $this->crud_model->getLanguage();
		$data['board']      = $this->crud_model->get_table_data('board','lang',$this->language);
		$data['board_id']   = $_GET['board_id'] ?? 0;
		$data['std_id']     = $_GET['std_id'] ?? 0;
		$data['subject_id'] = $_GET['subject_id'] ?? 0;
		$data['ch_id']      = $_GET['ch_id'] ?? 0;
		$data['tp_id']      = $_GET['tp_id'] ?? 0;
		$data['stp_id']     = $_GET['stp_id'] ?? 0;

		$this->load->view('admin/partials/layout', $data);
	}

	public function store()
	{
		try {
			$category      = $this->input->post('category');
			$audio         = $this->crud_model->sound_upload('sound', 'example');

			$explaination  = $this->crud_model->sound_upload('explaination', 'example');

			$tp_id = $this->input->post('topics');
			$this->db->trans_start();

			// Insert subtopic
			if (is_numeric($this->input->post('sub_topic'))) {
				$sub_topic_id = $this->input->post('sub_topic');
			} else {
				$subtopic_text = $this->db->get_where('subtopics',['subtopic_text' => $this->input->post('sub_topic')])->row();
				if($subtopic_text == ''){
					$this->db->insert('subtopics', [
						'tp_id'         => $tp_id,
						'ad_id'         => $this->session->userdata('brain_sess')['id'],
						'subtopic_text' => $this->input->post('sub_topic'),
					]);
					$sub_topic_id = $this->db->insert_id();
				} else {
					$sub_topic_id = $subtopic_text->stp_id;
				}
			}

			$get_data = $this->db->select_max('sequence')->where('tp_id',$tp_id)->where('stp_id',$sub_topic_id)->get('example')->result();
			if(!empty($get_data)){
				$sequence = $get_data[0]->sequence + 1 ;
			} else {
				$sequence = 1;
			}

			// Insert Example
			$ins = $this->db->insert('example', [
				'board_id'   	=> $this->input->post('board_id'),
				'std_id'     	=> $this->input->post('std_id'),
				'subject_id' 	=> $this->input->post('sub_id'),
				'lang' 			=> $this->input->post('lang'),
				'ch_id' => $this->input->post('chapter'),
				'tp_id' => $tp_id,
				'stp_id' => $sub_topic_id,
				'ad_id' => $this->session->userdata('brain_sess')['id'],
				'cat_id' => $category,
				'ex_heading' => $this->input->post('heading'),
				'ex_title' => $this->input->post('title'),
				'ex_audio' => $audio,
				'ex_explaination' => $explaination,
				'layout_id' => $this->input->post('layout_id'),
				'animation_id'=> $this->input->post('animation_id'),
				'sequence' => $sequence,
			]);

			$insert_example_id = $this->db->insert_id();

			$hidden_value  = $this->input->post('hidden_value');
			$total_que_item = $this->input->post('total_que_item');
			$total_ans_item = $this->input->post('total_ans_item');

			if ($ins) {
				foreach ($hidden_value as $i) {
					$ins = [
						'ex_id' => $insert_example_id,
					];

					$this->db->insert('example_data', $ins);
					$example_data_insert_id = $this->db->insert_id();

					// Question Add
					for($j = 0; $j < count($total_que_item[$i]); $j++){
						$true_audio    = '';
						$question_img  = '';
						$touch_audio   = '';
						$question_text = $this->input->post('qm2text');

						// Question Item
						if (isset($_FILES['qm2files']) && isset($_FILES['qm2files']['name'][$i][$j])  && ($_FILES['qm2files']['name'][$i][$j] != '')) {
							$question_img = $this->crud_model->multi_file_upload($_FILES['qm2files'],'example',$i,$j);
						}

						// True Audio
						if (isset($_FILES['audio']) && isset($_FILES['audio']['name'][$i][$j]) && ($_FILES['audio']['name'][$i][$j] != '')) {
							$true_audio = $this->crud_model->multi_file_upload($_FILES['audio'], 'example',$i,$j);
						}

						// Touch Audio
						if (isset($_FILES['touch_audio']) && isset($_FILES['touch_audio']['name'][$i][$j]) && ($_FILES['touch_audio']['name'][$i][$j] != '')) {
							$touch_audio = $this->crud_model->multi_file_upload($_FILES['touch_audio'], 'example',$i,$j);
						}
						$ins_que = [
							'ed_id' => $example_data_insert_id,
							'eqd_img' => $question_img,
							'eqd_text' => $question_text[$i][$j],
							'eqd_audio' => $true_audio,
							'eqd_touch_audio' => $touch_audio
						];

						$this->db->insert('example_question_data', $ins_que);
					}

					// Answer Add
					for($a = 0; $a < count($total_ans_item[$i]); $a++){
						$answer_audio  = '';
						$answer_img    = '';
						$answer_text   = $this->input->post('ead_text');

						// Answer Item
						if (isset($_FILES['ead_img']) && isset($_FILES['ead_img']['name'][$i][$a]) && ($_FILES['ead_img']['name'][$i][$a] != '')) {
							$answer_img = $this->crud_model->multi_file_upload($_FILES['ead_img'],'example',$i,$a);
						}

						// Answer Audio
						if (isset($_FILES['ead_audio']) && isset($_FILES['ead_audio']['name'][$i][$a]) && ($_FILES['ead_audio']['name'][$i][$a] != '')) {
							$answer_audio = $this->crud_model->multi_file_upload($_FILES['ead_audio'], 'example',$i,$a);
						}

						// Touch Audio
						if (isset($_FILES['ead_touch_audio']) && isset($_FILES['ead_touch_audio']['name'][$i][$a]) &&($_FILES['ead_touch_audio']['name'][$i][$a] != '')) {
							$touch_audio = $this->crud_model->multi_file_upload($_FILES['ead_touch_audio'], 'example',$i,$a);
						}

						$ans_ins = [
							'ed_id'     => $example_data_insert_id,
							'ead_img'   => $answer_img,
							'ead_text'  => $answer_text[$i][$a] ?? '',
							'ead_audio' => $answer_audio,
							'ead_touch_audio' => $touch_audio
						];


						$this->db->insert('example_answer_data', $ans_ins);
					}
				}

				$this->db->trans_complete();
				$response = array(
					'status' => 'success',
					'message' => "Data Added successfully",
					'stp_id' => $sub_topic_id
				);
			} else {
				$response = array(
					'status' => 'error',
					'message' => "Something went wrong"
				);
			}
		}
		//catch exception
		catch(Exception $e) {
			$response = array(
				'status' => 'error',
				'message' => $e->getMessage()
			);
		}
		echo json_encode($response);
	}

	public function edit($id)
	{
		$data['title']           = 'Example Edit :: BrainPad Wave';
		$data['action']          = base_url('backend/example/update/' . $id);
		$data['page']            = 'admin/page/example/edit';
		$data['board']     		 = $this->crud_model->get_table_data('board','lang',$this->language);
		$data['category']        = $this->db->get('category')->result_array();
		$data['layout']          = $this->db->get('layout')->result_array();
		$data['animation']       = $this->db->get('animation')->result_array();
		$data['sub_topics']      = $this->db->get('subtopics')->result();
		$data['example']         = $this->db->join('topics','topics.tp_id=example.tp_id','left')->join('chapter','chapter.ch_id=topics.ch_id','left')
			->join('subtopics','subtopics.stp_id=example.stp_id','left')->join('board','board.bd_id=example.board_id','left')
			->join('standard','standard.std_id=example.std_id','left')->join('subject','subject.sub_id=example.subject_id','left')
			->get_where('example', ['ex_id' => $id])->row();
		$data['exampleDataArray']= $this->db->get_where('example_data', ['ex_id' => $id])->result_array();

		$this->load->view('admin/partials/layout', $data);
	}

	public function update($id){

		// Insert subtopic
		if (is_numeric($this->input->post('sub_topic'))) {
			$sub_topic_id = $this->input->post('sub_topic');
		}else{
			$subtopic_text = $this->db->get_where('subtopics',['subtopic_text' => $this->input->post('sub_topic')])->row();
			if($subtopic_text == '') {
				$this->db->insert('subtopics', [
					'tp_id'         => $this->input->post('topics'),
					'ad_id'         => $this->session->userdata('brain_sess')['id'],
					'subtopic_text' => $this->input->post('sub_topic'),
				]);
				$sub_topic_id = $this->db->insert_id();
			} else {
				$sub_topic_id = $subtopic_text->stp_id;
			}
		}

		// ======= update heading ===== //
		$updatedData = [
			'board_id'   	=> $this->input->post('board_id'),
			'std_id'     	=> $this->input->post('std_id'),
			'subject_id' 	=> $this->input->post('sub_id'),
			'lang' 			=> $this->input->post('lang'),
			'ch_id' => $this->input->post('chapter'),
			'stp_id' => $sub_topic_id,
			'cat_id' => $this->input->post('category'),
			'ex_heading' => $this->input->post('heading'),
			'ex_title' => $this->input->post('title'),
			'tp_id' =>  $this->input->post('topics'),
			'animation_id' => $this->input->post('animation_id'),
			'layout_id'   => $this->input->post('layout_id')
		];

		if ($_FILES['sound']['error'] == 0) {
			$audio = $this->crud_model->sound_upload('sound', 'example');
			$updatedData['ex_audio'] = $audio;
		} 

		if(!empty($this->input->post('ex_audio'))){
			$updatedData['ex_audio'] = '';
		}
		$this->db->trans_start();
		$this->db->where('ex_id', $id)->update('example', $updatedData);
		
		if(!empty($_FILES['explaination'])){
			if ($_FILES['explaination']['error'] == 0) {
				$audio = $this->crud_model->sound_upload('explaination', 'example');
				$updatedData['ex_explaination'] = $audio;
			} 
	
			if(!empty($this->input->post('explaination'))){
				$updatedData['ex_explaination'] = '';
			}
			$this->db->trans_start();
			$this->db->where('ex_id', $id)->update('example', $updatedData);
		}

		$hidden_value   = $this->input->post('hidden_value');
		$answer_text    = $this->input->post('am2text');
		$total_que_item = $this->input->post('total_que_item');
		$total_ans_item = $this->input->post('total_ans_item');
		$example_data_ids =  $this->input->post('ed_id');
		$question_item_ids = $this->input->post('eqd_id');
		$answer_item_ids = $this->input->post('ead_id');
		
		foreach ($hidden_value as $i) {

			if(isset($example_data_ids[$i]) && $example_data_ids[$i] != 0) {
				$example_data_insert_id = $example_data_ids[$i];
			}else{
				$this->db->insert('example_data',['ex_id' => $id]);
				$example_data_insert_id = $this->db->insert_id();
			}
			
			for( $j=0; $j < count($total_que_item[$i]); $j++){
				$k = $j-1;
				$question_text = $this->input->post('qm2text');

				if(!empty($example_data_ids[$i]) && $j == 0){
					continue;
				}
				$ins_item = [
					'ed_id' => $example_data_insert_id,
					'eqd_text' => $question_text[$i][$j],
				];

				// Question Item
				if (isset($_FILES['qm2files']) && isset($_FILES['qm2files']['name'][$i][$j]) && ($_FILES['qm2files']['name'][$i][$j] != '')) {
					$ins_item['eqd_img']  = $this->crud_model->multi_file_upload($_FILES['qm2files'],'example',$i,$j);
				}
				 
				// Remove question audio/image
				if(!empty($this->input->post('eqd_img')[$i][$k])){
					$udate_question['eqd_img'] = '';
					$this->db->where('eqd_id', $this->input->post('eqd_img')[$i][$k])->update('example_question_data', $udate_question);
				}

				// Remove question touch
				if(!empty($this->input->post('eqd_touch')[$i][$k])){
					$udate_question['eqd_touch_audio'] = '';
					$this->db->where('eqd_id', $this->input->post('eqd_touch')[$i][$k])->update('example_question_data', $udate_question);
				}

				// Remove question true
				if(!empty($this->input->post('eqd_audio')[$i][$k])){
					$udate_question['eqd_audio'] = '';
					$this->db->where('eqd_id', $this->input->post('eqd_audio')[$i][$k])->update('example_question_data', $udate_question);
				}

				// True Audio
				if (isset($_FILES['audio']) && isset($_FILES['audio']['name'][$i][$j]) && ($_FILES['audio']['name'][$i][$j] != '')) {
					$ins_item['eqd_audio']= $this->crud_model->multi_file_upload($_FILES['audio'], 'example',$i,$j);
				}

				// Touch Audio
				if (isset($_FILES['touch_audio']) && isset($_FILES['touch_audio']['name'][$i][$j]) && ($_FILES['touch_audio']['name'][$i][$j] != '')) {
					$ins_item['eqd_touch_audio'] = $this->crud_model->multi_file_upload($_FILES['touch_audio'], 'example',$i,$j);
				}

				if(!empty($question_item_ids[$i][$j])){
					if($question_item_ids[$i][$j] != 0){
						$this->db->where('eqd_id',$question_item_ids[$i][$j])->update('example_question_data', $ins_item);
					}
				}
				else{
					$this->db->insert('example_question_data', $ins_item);
				}
			}

			// For Answer
			for( $a=0; $a < count($total_ans_item[$i]); $a++){
				$l = $a-1;
				$answer_text = $this->input->post('ead_text');

				if(!empty($example_data_ids[$i]) && $a == 0){
					continue;
				}
				$ins_ans_item = [
					'ed_id' => $example_data_insert_id,
					'ead_text' => $answer_text[$i][$a],
				];

				// Question Item
				if (isset($_FILES['ead_img']) && isset($_FILES['ead_img']['name'][$i][$a]) && ($_FILES['ead_img']['name'][$i][$a] != '')) {
					$ins_ans_item['ead_img']  = $this->crud_model->multi_file_upload($_FILES['ead_img'],'example',$i,$a);
				}

				// Audio
				if (isset($_FILES['ead_audio']) && isset($_FILES['ead_audio']['name'][$i][$a]) && ($_FILES['ead_audio']['name'][$i][$a] != '')) {
					$ins_ans_item['ead_audio']= $this->crud_model->multi_file_upload($_FILES['ead_audio'], 'example',$i,$a);
				}

				// Touch Audio
				if (isset($_FILES['ead_touch_audio']) && isset($_FILES['ead_touch_audio']['name'][$i][$a]) && ($_FILES['ead_touch_audio']['name'][$i][$a] != '')) {
					$ins_ans_item['ead_touch_audio']= $this->crud_model->multi_file_upload($_FILES['ead_touch_audio'], 'example',$i,$a);
				}

				if($answer_item_ids[$i][$a] != 0){
					$this->db->where('ead_id',$answer_item_ids[$i][$a])->update('example_answer_data', $ins_ans_item);
				}else{
					$this->db->insert('example_answer_data', $ins_ans_item);
				}

				// Remove answer audio/image
				if(!empty($this->input->post('ead_img')[$i][$l])){
					$udate_question['ead_img'] = '';
					$this->db->where('ead_id', $this->input->post('ead_img')[$i][$l])->update('example_answer_data', $udate_question);
				}

				// Remove answer touch
				if(!empty($this->input->post('ead_touch_audio')[$i][$l])){
					$udate_question['ead_touch_audio'] = '';
					$this->db->where('ead_id', $this->input->post('ead_touch_audio')[$i][$l])->update('example_answer_data', $udate_question);
				}

				// Remove answer true
				if(!empty($this->input->post('ead_audio')[$i][$l])){
					$udate_question['ead_audio'] = '';
					$this->db->where('ead_id', $this->input->post('ead_audio')[$i][$l])->update('example_answer_data', $udate_question);
				}
			}

		}
		
		$this->db->trans_complete();
		$this->session->set_flashdata('success', 'Data Added successfully');
		$id = 'board_id='. $updatedData['board_id']. '&std_id='. $updatedData['std_id']. '&subject_id='. $updatedData['subject_id']. '&ch_id='. $updatedData['ch_id']. '&tp_id='. $updatedData['tp_id']. '&stp_id='. $updatedData['stp_id'];
		// redirect(base_url('backend/example/view?'.$id));
		redirect(base_url('backend/syllabus'));
	}

	public function show($id)
	{
		$data['title']    = 'Sorting Method :: BrainPad Wave';
		$data['sess']     = $this->session->userdata('brain_sess');
		$data['page']     = 'admin/page/example/view';
		$data['example'] = $this->db->join('category', 'category.c_id = example.cat_id', 'inner')->join('subtopics','subtopics.stp_id=example.stp_id','left')
			->join('topics','topics.tp_id=example.tp_id','left')->join('chapter','chapter.ch_id=example.ch_id','left')
			->join('layout','layout.lay_id=example.layout_id','left')->join('animation','animation.anim_id=example.animation_id','left')
			->where('example.ex_id',$id)->order_by('example.sequence')->get('example')->row();
		$data['exampleDataArray'] = $this->db->get_where('example_data', ['ex_id' => $id])->result();

		$this->load->view('admin/partials/layout',$data);
	}

	public function copy($id){
		$insert_id = $this->crud_model->duplicateRecord('example','ex_id',$id);
		$e_data = $this->crud_model->get_table_data('example_data','ex_id',$id);

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

		echo 'success';
	}

	public function view(){

		$data['title'] = 'Example View :: BrainPad Wave';
		$data['page']  = 'admin/page/example/view';
		$data['example'] = $this->db->join('category', 'category.c_id = example.cat_id', 'inner')->join('subtopics','subtopics.stp_id=example.stp_id','left')
			->join('board', 'board.bd_id=example.board_id', 'left')->join('subject', 'subject.sub_id=example.subject_id', 'left')
			->join('standard', 'standard.std_id=example.std_id', 'left')
			->join('topics','topics.tp_id=example.tp_id','left')->join('chapter','chapter.ch_id=example.ch_id','left')
			->join('layout','layout.lay_id=example.layout_id','left')->join('animation','animation.anim_id=example.animation_id','left')
			->where('example.board_id',$_GET['board_id'])->where('example.std_id',$_GET['std_id'])->where('example.subject_id',$_GET['subject_id'])
			->where('example.ch_id',$_GET['ch_id'])->where('example.tp_id',$_GET['tp_id'])->where('example.stp_id',$_GET['stp_id'])->order_by('example.sequence')
			->get('example')->result_array();
		$this->load->view('admin/partials/layout',$data);

	}

	public function status($id, $status)
	{
		$upd_res = '';
		if ($status == 1) {
			$upd_res = $this->db->where('ex_id', $id)->update('example', ['ex_status' => 0]);
		} else {
			$upd_res = $this->db->where('ex_id', $id)->update('example', ['ex_status' => 1]);
		}
		if ($upd_res) {
			$this->session->set_flashdata('success', 'Status updated successfully');
			redirect(base_url('backend/example'),'refresh');
		} else {
			$this->session->set_flashdata('err', 'Something went wrong');
			redirect(base_url('backend/example'),'refresh');
		}
	}

	public function remove($id)
	{
		try {
			$this->db->delete('example', ['ex_id' => $id]);
			$this->db->delete('example_data', ['ex_id' => $id]);

			$this->session->set_flashdata('success', 'Data Deleted successfully');
		}
		catch (Exception $e) {
			$this->session->set_flashdata('err', $e->getMessage());
		}
		echo 'success';
	}

	public function removeQuestion($id)
	{
		$this->db->delete('example_data', ['ed_id' => $id]);
		echo 'Deleted successfully.';
	}

	public function removeQuestionItem($id)
	{
		$this->db->delete('example_question_data', ['eqd_id' => $id]);
		echo 'Deleted successfully.';
	}

	public function removeAnswerItem($id)
	{
		$this->db->delete('example_answer_data', ['ead_id' => $id]);
		echo 'Deleted successfully.';
	}

	public function getData($id){

		$query = $this->db->where('stp_id',$id)->get("example");

		$data = [];

		foreach($query->result() as $r) {
			$data[] = array(
				$r->ex_id,
				$r->ex_heading,
				$r->ex_title ?? '-'
			);
		}

		$result = array(
			"data" => $data
		);


		echo json_encode($result);
		exit();
	}

	public function removeSelected(){
		if (isset($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);

			$this->db->where_in('ex_id', $ids)->delete('example');
			$this->session->set_flashdata('success', 'Data Deleted successfully');
			echo 'Deleted successfully.';
		} else {
			$this->session->set_flashdata('error', 'Error');
			echo 'Error';
		}
	}
}
