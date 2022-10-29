<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends BD_Controller
{

	function __construct()
	{
		parent:: __construct();
	}

	public function test_api_get()
	{
		$this->set_response(['msg'=>"Its Working"],REST_Controller::HTTP_OK);
	}

	public function language_get(){
		// $res = $this->db->get_where('languages')->result_array();
		$res = $this->db->distinct('languages.name')
				// ->join('example','example.lang=languages.name','left')
				// ->where('example.ex_id != ""')
				->select('languages.id,languages.symbol,languages.name')
				->group_by('languages.name')
			    ->get('languages')->result_array();
		if(!empty($res))
		{
			$this->set_response($res,REST_Controller::HTTP_OK);
		}
		else
		{
			$this->set_response(['msg'=>'Data is empty'],REST_Controller::HTTP_OK);
		}
	}

	public function category_get()
	{
		$category_rec = $this->db->get_where('category',['status'=>1])->result_array();
		if(!empty($category_rec))
		{
			$response = [];
			foreach($category_rec as $c_rec)
			{
				$response[] = ['category_id'=>$c_rec['c_id'], 'category_name'=>$c_rec['c_name']];
			}
			$this->set_response($response,200);
		}
		else
		{
			$this->set_response(['msg'=>'Category Not Found'],422);
		}
	}

	public function privacy_policy_get()
	{
		$ad = $this->db->select('policy')->limit(1,0)->get_where('admin',['id'=>1])->row();
		$this->set_response($ad,200);
	}

	public function splashscreen_post()
	{
		// $res = $this->db->get_where('splash',['status'=>1,'ad_id'=>1])->row_array();
		// if(!empty($res))
		// {
		// 	$this->set_response(['name'=>$res['sp_name'],'img'=>base_url('uploads/splashscreen/'.$res['sp_img_path']),'copyright'=>$res['sp_copy'],'color'=>$res['sp_color']],REST_Controller::HTTP_OK);
		// }
		// else
		// {
		// 	$this->set_response(['msg'=>'Data is empty'],REST_Controller::HTTP_OK);
		// }
		$school_id = $this->input->post('school_id');
		if($school_id != '')
		{
			$school_logo = $this->db->where('school_id',$this->input->post('school_id'))->get('school')->result();
			if (!empty($school_logo)) {
				$response['logo'] = base_url($school_logo[0]->school_logo);
				$response['google_package_token'] = $school_logo[0]->google_package_token;
				$this->set_response($response, REST_Controller::HTTP_OK);
			}
			else {
				$this->set_response(['msg' => 'School Not Found'], 200);
			}
		}
		else
		{
			$this->set_response(['msg'=>'Choose School first'], 422);
		}

	}

	public function game_sound_get()
	{
		$response = [];
		$rec = $this->db->get_where('gamesound',['ad_id'=>1,'status'=>1])->result_array();
		$i=1;
		foreach($rec as $r)
		{
			$response['sound'.$i] = base_url($r['game_sound']);
			$i++;
		}
		$this->set_response($response,200);
	}

	public function board_list_post()
	{
		$lang_id  = $this->input->post('lang_id');
		$lang = $this->db->get_where('languages',['id' => $lang_id])->row();

		if($lang != '') {
			$brdList = [];
			$board = $this->db->get_where('board',['lang'=>$lang->symbol,'status'=>1])->result_array();
			if (!empty($board)) {
				foreach ($board as $brd) {
					// if($this->db->where('board_id',$brd['bd_id'])->get('example')->row() != '' ) {
						$brdList[] = [
							'id' => intval($brd['bd_id']),
							'board' => $brd['bd_name'],
							'image' => base_url($brd['bd_img_path'])
						];
					// }
				}
			}

			if (!empty($brdList)) {
				$this->set_response($brdList, 200);
			} else {
				$this->set_response(['msg' => 'Board Not Found'], 200);
			}
		} else {
			$this->set_response(['msg'=>'Choose Language first'],422);
		}
	}

	public function standard_list_post()
	{
		$board_id = $this->input->post('board_id');

		if($board_id != '') {
			$std = $this->db->order_by("sequence", "asc")->get_where('standard', ['std_status' => 1, 'board_id' => $board_id])->result_array();
			$stdList = [];

			if (!empty($std)) {
				foreach ($std as $s) {
					// if ($this->db->where('std_id', $s['std_id'])->get('example')->row() != '') {
						$stdList[] = [
							'id' => intval($s['std_id']),
							'standard' => $s['std_name']];
					// }
				}
			}
			if (!empty($stdList)) {
				$this->set_response($stdList, 200);
			} else {
				$this->set_response(['msg' => 'Standard Not Found'], 200);
			}
		} else {
				$this->set_response(['msg'=>'Choose Board first'],422);
		}
	}

	public function subject_list_post()
	{
		$standard_id = $this->input->post('standard_id');

		if($standard_id != '')
		{
			$all_sub_list = [];
			$sub_list   = $this->db->order_by('sequence',"asc")->get_where('subject',['sub_status'=>1, 'std_id'=>$standard_id])->result_array();
			if(!empty($sub_list)){
				foreach($sub_list as $sl) {
					// if($this->db->where('subject_id',$sl['sub_id'])->get('example')->row() != '' ) {
						$all_sub_list[] = [
							'id' => $sl['sub_id'],
							'subject' => $sl['sub_name'],
							'image' => base_url($sl['sub_img_path'])
						];
					// }
				}
			}

			if (!empty($all_sub_list)) {
				$this->set_response($all_sub_list, 200);
			} else {
				$this->set_response(['msg' => 'Subject Not Found'], 200);
			}
		} else	{
			$this->set_response(['msg'=>'Choose standard first'],422);
		}
	}

	public function chapter_list_post()
	{
		$subject_id = $this->input->post('subject_id');
		if($subject_id != '')
		{
			$chList = [];
			$chapter = $this->db->order_by("sequence", "asc")->get_where('chapter', ['chapter_status' => 1, 'subject_id' => $subject_id])->result_array();
			if (!empty($chapter)) {
				foreach ($chapter as $ch) {
					// if($this->db->where('ch_id',$ch['ch_id'])->get('example')->row() != '' ) {
						$chList[] = [
							'id' => intval($ch['ch_id']),
							'chapter' => $ch['chapter_text'],
							'image' => base_url($ch['chapter_img'])
						];
					// }
				}
			}
			if (!empty($chList)) {
				$this->set_response($chList, 200);
			} else {
				$this->set_response(['msg' => 'Chapters Not Found'], 200);
			}
		}
		else
		{
			$this->set_response(['msg'=>'Choose Subject first'], 422);
		}
	}

	public function topics_list_post()
	{
		$chapter_id = $this->input->post('chapter_id');
		if($chapter_id != '')
		{
			$topics = $this->db->order_by("sequence","asc")->get_where('topics',['topic_status'=>1,'ch_id'=>$chapter_id])->result_array();
			$tpList = [];
			foreach($topics as $tp) {
				// if($this->db->where('tp_id',$tp['tp_id'])->get('example')->row() != '' ) {
					$tpList[] = [
						'id' => intval($tp['tp_id']),
						'topic' => $tp['topic_text'],
						'image' => base_url($tp['topic_img'])
					];
				// }
			}

			if(!empty($tpList))	{
				$this->set_response($tpList, 200);
			} else {
				$this->set_response(['msg'=>'Topics Not Found'], 200);
			}
		} else {
			$this->set_response(['msg'=>'choose chapter first'], 200);
		}
	}

	public function subtopics_list_post()
	{
		$topic_id = $this->input->post('topic_id');

		if($topic_id != '')
		{
			$subtopics = $this->db->order_by("sequence","asc")->get_where('subtopics',['subtopic_status'=>1,'tp_id'=>$topic_id])->result_array();
			$stpList = [];
			foreach($subtopics as $stp)
			{
				if(!empty($stp)){
					$get_data = $this->db->where('user_id',$this->input->post('user_id'))->where('subtopic_id',$stp['stp_id'])->get('example_lock_unlock')->result();
					// echo "<pre>"; print_r($get_data);
					$flag = 0;$star = 0;$crown = 0;
					if($stp['sequence'] == 1){
						$flag = 1;
					}

					$get_min_star = $this->db->get('splash')->result();
					$min_star = $get_min_star[0]->unlock_min_star;

					if(!empty($get_data)){
						if($get_data[0]->star >= $min_star){
							$flag = 1;
						}
						$star = $get_data[0]->star;
						$crown = $get_data[0]->crown; 
					}

					$sequence = $stp['sequence'] - 1;
					$check_sub = $this->db->get_where('subtopics',['sequence'=>$sequence,'tp_id'=>$topic_id])->result_array();
					if(!empty($check_sub)){
						$st_id = $check_sub[0]['stp_id'];
						$get = $this->db->where('user_id',$this->input->post('user_id'))->where('subtopic_id',$st_id)->get('example_lock_unlock')->result();
						if(!empty($get)){
							if($get[0]->star >= $min_star){
								$flag = 1;
							}
						}
					}
					if(!empty($get_data)){
					  if($get_data[0]->is_unlock == 1){
						  $flag = 1;
					  }
					}
				}
				if($this->db->where('stp_id',$stp['stp_id'])->get('example')->row() != '' ) {
					$stpList[] = [
						'id' => intval($stp['stp_id']),
						'topic' => $stp['subtopic_text'],
						'image' => base_url($stp['subtopic_img']),
						'flag'=>$flag,
						'star'=>$star,
						'crown'=>$crown,
						'sequence'=>$stp['sequence']
					];
				}
			}
			if(!empty($stpList)) {
				$this->set_response($stpList, 200);
			} else {
				$this->set_response(['msg'=>'Sub Topics Not Found'], 200);
			}
		} else	{
			$this->set_response(['msg'=>'Choose Topic First'], 200);
		}

	}

}
