<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Example extends BD_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/kolkata');
	}

	public function method_mapping_post()
	{
		$subtopic_id = $this->input->post('subtopic_id');
		$rec = $this->db->where('stp_id',$subtopic_id)
						->where('ex_status',1)
						->order_by('sequence')
						->get('example')
						->result_array();
		$data = [];
		if (!empty($rec)) {
			foreach ($rec as $r) {
				$data[] = array('cat_id' => $r['cat_id'], 'example_id' => $r['ex_id']);
			}
			$this->set_response($data, 200);
		} else {

			$this->set_response(['msg' => 'Examples not found'], 422);
		}
	}

	public function example_data_post()
	{
		$cat_id = $this->input->post('cat_id');
		$example_id = $this->input->post('example_id');
		$response = [];

		$get_examples = $this->db->join('layout', 'layout.lay_id=example.layout_id', 'left')
								 ->join('animation', 'animation.anim_id=example.animation_id', 'left')
							     ->get_where('example', ['ex_id' => $example_id])->row();

		if (!empty($get_examples)) {
			$e_data = [];
			$example_data = $this->db->query("SELECT * from example_data where ex_id =" . $get_examples->ex_id)->result();
			foreach ($example_data as $exd) {
				$eq_data = [];
				$ea_data = [];

				$example_question_data = $this->db->query("SELECT * from example_question_data where ed_id =" . $exd->ed_id)->result();
				foreach ($example_question_data as $eqd) {
					$eq_data[] = [
						'que_img' => ($eqd->eqd_img != '') ? base_url($eqd->eqd_img) : "",
						'que_text' => $eqd->eqd_text ?? "",
						'true_sound' => ($eqd->eqd_audio != '') ? base_url($eqd->eqd_audio) : "",
						'touch_sound' => ($eqd->eqd_touch_audio != '') ? base_url($eqd->eqd_touch_audio) : ""
					];
				}

				$example_answer_data = $this->db->query("SELECT * from example_answer_data where ed_id =" . $exd->ed_id)->result();
				foreach ($example_answer_data as $ead) {
					$ea_data[] = [
						'ans_img' => ($ead->ead_img != '') ? base_url($ead->ead_img) : "",
						'ans_text' => $ead->ead_text ?? "",
						'true_sound' => ($ead->ead_audio != '') ? base_url($ead->ead_audio) : "",
						'touch_sound' => ($ead->ead_touch_audio != '') ? base_url($ead->ead_touch_audio) : ""
					];
				}

				$e_data[] = [
					'que_data' => $eq_data,
					'ans_data' => $ea_data
				];

			}

			$response[] = [
				'heading' => $get_examples->ex_heading,
				'instruction' => $get_examples->ex_title,
				'ex_explaination' => $get_examples->ex_explaination,
				'audio' => ($get_examples->ex_audio != '') ? base_url($get_examples->ex_audio) : '',
				'layout' => (int)$get_examples->lay_id,
				'animation' => (int)$get_examples->anim_id,
				'data' => $e_data
			];
		}

		$this->set_response($response, 200);
	}

}
