<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extra extends CI_Controller
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

	public function reOrdering($type,$p_key)
	{
		$data = $this->input->post('data');
		for($count = 0;  $count < count($data); $count++)
		{
			$this->db->where($p_key,$data[$count])->update($type, ['sequence' => $count+1]);
			echo $this->db->last_query();
		} 
		
		echo 'Reordering successfully.';
	}

	public function getLanguag()
	{
		$lng = $this->input->post('lang_id'); 
		$language_list = $this->db->get('languages')->result();
		$board = '';
		if(!empty($language_list))
		{
			$board.='<option value="">Choose Language </option>';
			foreach($language_list as $lg)
			{
				$select = ($lng==$lg->symbol) ? "selected" : "";
				$board.='<option value="'.$lg->symbol.'" '.$select.'>'.$lg->name.'</option>';
			}
		}
		else
		{
			$board.= '<option value=""> ---  No Languages Found ! --- </option>';
		}

		echo $board;
	}

	public function getBoard()
	{
		$boardID = $this->input->post('board_id');
		$langID = $this->input->post('lang_id');

		$board_list = $this->db->get_where('board',[ 'lang'=> $langID, 'status'=>1 ])->result();
		$board = '';
		if(!empty($board_list))
		{
			$board.='<option value="">Choose Board </option>';
			foreach($board_list as $bd)
			{
				$select = ($boardID==$bd->bd_id) ? "selected" : "";
				$board.='<option value="'.$bd->bd_id.'"  '.$select.'>'.$bd->bd_name.'</option>';
			}
		}
		else
		{
			$board.= '<option value=""> ---  No Board Found ! --- </option>';
		}

		echo $board;
	}

	public function getStandard()
	{
		$boardID = $this->input->post('board_id');
		$stdID = $this->input->post('std_id');

		$std_list = $this->db->where('std_status',1)->where('board_id',$boardID)->order_by("sequence","asc")->get('standard')->result();  
		$standard = '';
		if(!empty($std_list))
		{
			$standard.='<option value="">Choose Standard </option>';
			foreach($std_list as $std)
			{
				$select = ($stdID==$std->std_id) ? "selected" : "";
				$st = $this->session->userdata('syllabus');
				if(!empty($st)){
					$select = ($st['std_id'] == $std->std_id) ? "selected" : "";
				}
				$standard.='<option value="'.$std->std_id.'"  '.$select.'>'.$std->std_name.'</option>';
			}
		}
		else
		{
			$standard.= '<option value=""> ---  No Standard Found ! --- </option>';
		}

		echo $standard;
	}

	public function getSubject()
	{
		$stdID = $this->input->post('std_id');
		$subID = $this->input->post('sub_id');

		$sub_list = $this->db->where('sub_status',1)->where('std_id',$stdID)->order_by("sequence","asc")->get('subject')->result();
		$subject = '';
		if(!empty($sub_list))
		{
			$subject.='<option value="">Choose Subject </option>';
			foreach($sub_list as $std)
			{
				$select = ($subID==$std->sub_id) ? "selected" : "";
				$st = $this->session->userdata('syllabus');
				if(!empty($st)){
					$select = ($st['subject_id'] == $std->sub_id) ? "selected" : "";
				}
				$subject.='<option value="'.$std->sub_id.'"  '.$select.'>'.$std->sub_name.'</option>';
			}
		}
		else
		{
			$subject.= '<option value=""> ---  No Subject Found ! --- </option>';
		}
		echo $subject;
	}

	public function getTopics()
	{
		$chid = $this->input->post('chid');
		$tp_list = $this->db->where('topic_status',1)->where('ch_id',$chid)->order_by("sequence","asc")->get('topics')->result();
		$topic = '';
		if(!empty($tp_list))
		{
			$topic.='<option value="">------- Choose Topic ------</option>';
			foreach($tp_list as $tp)
			{
				$select = '';
				$st = $this->session->userdata('syllabus');
				if(!empty($st)){
					$select = ($st['topic_id'] == $tp->tp_id) ? "selected" : "";
				}
				$topic.='<option value="'.$tp->tp_id.'" '.$select.'>'.$tp->topic_text.'</option>';
			}
		} else {
			$topic.= '<option value=""> ---  No Topic Found ! --- </option>';
		}
		echo $topic;
	}

	public function getEditTopics()
	{
		$chid = $this->input->post('chid');
		$tpid = $this->input->post('tpid');
		$tp_list = $this->db->get_where('topics',['topic_status'=>1,'ch_id'=>$chid])->result();
		$topic = '';
		if(!empty($tp_list))
		{
			$topic.='<option value="">------- Choose Topic ------</option>';
			foreach($tp_list as $tp)
			{
				$topic.='<option value="'.$tp->tp_id.'" '.(($tpid!='')?(($tpid==$tp->tp_id)?"selected":""):"").'>'.$tp->topic_text.'</option>';
			}
		} else {
			$topic.= '<option value=""> ---  No Topic Found ! --- </option>';
		}
		echo $topic;
	}

	public function getLayout(){

		$c_id   = $this->input->post('cat_id');
		$lay_id = $this->input->post('lay_id');

		$cat_list = $this->db->get_where('layout',[ 'cat_id'=>$c_id ])->result();

		$layout = '';
		if(!empty($cat_list))
		{
			$layout.='<option value="">------- Choose Layout ------</option>';
			foreach($cat_list as $cat)
			{
				$select = ($lay_id==$cat->lay_id) ? "selected" : "";
				$layout.='<option value="'.$cat->lay_id.'"  '.$select.'>'.$cat->lay_name.'-'.$cat->lay_description.'</option>';
			}
		}
		else
		{
			$layout.= '<option value=""> ---  No Layout Found ! --- </option>';
		}

		echo $layout;
	}

	public function getLayoutDesign(){
		if(!empty($this->input->post('lay_id'))){
			$layout = $this->db->get_where('layout',['lay_id'=>$this->input->post('lay_id')])->result();
			if(!empty($layout)){
				echo json_encode($layout);
			}
		}
	}

	public function getSubTopics()
	{
		$topicID = $this->input->post('topic_id');
		$subtopicID = $this->input->post('sub_topic_id');
		
		$stp_list = $this->db->where('subtopic_status',1)->where('tp_id',$topicID)->order_by("sequence","asc")->get('subtopics')->result();
		$subtopic = '';
		if(!empty($stp_list))
		{
			$subtopic.='<option value="">Choose SubTopic or Add new</option>';
			foreach($stp_list as $stp)
			{
				$select = '';

				$st = $this->session->userdata('syllabus');
				if(!empty($st)){
					$select = ($st['subtopic_id'] == $stp->stp_id) ? "selected" : "";
				} else {
					$select = ($subtopicID==$stp->stp_id) ? "selected" : "";
				}

				$subtopic.='<option value="'.$stp->stp_id.'"  '.$select.'>'.$stp->subtopic_text.'</option>';
			}
		}
		else
		{
			$subtopic.= '<option value=""> ---  No Sub Topic Found ! --- </option>';
		}

		echo $subtopic;

	}

	public function getChapter()
	{
		$boardID = $this->input->post('board_id');
		$subID   = $this->input->post('sub_id');
		$stdID   = $this->input->post('std_id');
		$chid    = $this->input->post('echid');

		$ch_list = $this->db->where('chapter_status',1)->where('board_id',$boardID)->where('std_id', $stdID)->where('subject_id',$subID)->order_by("sequence","asc")->get('chapter')->result();

		// echo $this->db->last_query(); exit;

		$chapter = '';
		if(!empty($ch_list))
		{
			$chapter.='<option value="">------- Choose Chapter ------</option>';
			foreach($ch_list as $ch)
			{
				$select = ($chid==$ch->ch_id) ? "selected" : "";
				$st = $this->session->userdata('syllabus');
				if(!empty($st)){
					$select = ($st['chapter_id'] == $ch->ch_id) ? "selected" : "";
				}
				$chapter.='<option value="'.$ch->ch_id.'" '.$select.'>'.$ch->chapter_text.'</option>';
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

	public function getEditMethod()
	{
		$topicID = $this->input->post('tpid');
		$selectedVal = explode(',',$this->input->post('selected_val'));
		$example = '';
		if(!empty($topicID)) {
			$ex_list = $this->db->get_where('example', ['ex_status' => 1, 'tp_id' => $topicID])->result();
			if (!empty($ex_list)) {
				$example.='<option value="">------- Choose Method ------</option>';
				foreach ($ex_list as $exp) {
					if(in_array($exp->ex_id,$selectedVal)){
						$example .= '<option selected value="' . $exp->ex_id . '">' . $exp->ex_heading . '&nbsp;-&nbsp;' . $exp->ex_title . '</option>';
					}else{
						$example .= '<option value="' . $exp->ex_id . '">' . $exp->ex_heading . '&nbsp;-&nbsp;' . $exp->ex_title . '</option>';
					}
				}
			} else {
				$example .= '<option value=""> ---  No Example Found ! --- </option>';
			}
			echo $example;
		}
	}

	public function setLanguage(){
		$this->session->set_userdata('language', $this->input->post('language'));
		$this->session->set_userdata('board', $this->input->post('board'));

		$board = $this->db->where('bd_id',$this->input->post('board'))->get('board')->row();

		$this->session->set_userdata('board_name', $board->bd_name);


		$response = array(
			'status' => 'success',
			'message' => "Options set successfully",
		);
		echo json_encode($response);
	}


}

//UPDATE chapter ,bssmap
//SET chapter.board_id = bssmap.board_id, chapter.std_id = bssmap.standard_id,chapter.subject_id = bssmap.subject_id
//WHERE chapter.bss_id = bssmap.bss_id
