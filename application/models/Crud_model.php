<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Crud_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function clear_cache()
	{
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
	}

	function get_type_name_by_id($type, $type_id = '',$value = '', $field = 'name')
	{
		if ($type_id != '') {
			$l = $this->db->get_where($type, array(
				$type_id => $value
			));
			$n = $l->num_rows();
			if ($n > 0) {
				return $l->row()->$field;
			}
		}
	}

	function get_single_row($table, $type = '', $value = '')
	{
		if ($type != '') {
			$l = $this->db->get_where($table, array(
				$type => $value
			));

			return $l->row_array();
		}
	}

	function get_table_data($table, $type = '', $value = '')
	{
		$this->db->select('*');
		$this->db->from($table);
		if($type != ''){
			$this->db->where($type, $value);
		}
		return $this->db->get()->result_array();
	}

	function get_table_data_by_sequence($table,$lang = false)
	{
		if($lang){
			return 	$this->db->where('lang',$this->getLanguage())->order_by('sequence','asc')->get($table)->result_array();
		}

		return 	$this->db->order_by('sequence','asc')->get($table)->result_array();
	}

	function addSequence($table,$db_id,$id){
		$data['sequence'] = $id;
		$this->db->where($db_id,$id)->update($table,$data);
	}

	public function file_up($file , $folder): string
	{
		$file_name = '';
		if ($file['name'] != '') {
			$this->load->library('image_lib');
			$config['upload_path'] = './uploads/' . $folder . '/';
			$config['allowed_types'] = '*';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			if($this->upload->do_upload('file')){
				$image_data = $this->upload->data();

				$configure = array(
					'image_library' => 'gd2',
					'source_image'  => $image_data['full_path'],
					'maintain_ratio'=> FALSE,
					// 'quality'       => "30%",
					// 'width'         => $width,
					// 'height'        => $height,
				);

				$this->image_lib->clear();
				$this->image_lib->initialize($configure);
				$this->image_lib->resize();

				$file_name =  "uploads/" . $folder . "/" . $image_data['file_name'];
			}
		}
		return $file_name;
	}

	public function single_file_up($files,$folder,$i): string
	{
		$filename = '';

		$_FILES['file']['name'] = $files['name'][$i];
		$_FILES['file']['type'] = $files['type'][$i];
		$_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
		$_FILES['file']['error'] = $files['error'][$i];
		$_FILES['file']['size'] = $files['size'][$i];

		$config['upload_path']   = './uploads/'.$folder.'/';
		$config['allowed_types'] = '*';
		$config['encrypt_name']  = TRUE;
		$config['file_name']     = $files['name'][$i];

		$this->load->library('upload',$config);

		if($this->upload->do_upload('file')){
			$uploadData = $this->upload->data();
			$filename = "uploads/" . $folder . "/" . $uploadData['file_name'];
		}
		return $filename;
	}

	public function multi_file_upload($file,$folder,$i,$j): string
	{
		$filename = "uploads/" . $folder . "/". random_string('unique'). '_' .$file['name'][$i][$j];

		if(move_uploaded_file($file['tmp_name'][$i][$j],$filename)){
			return $filename;
		}else{
			return '';
		}
	}

	public function sound_upload($name , $folder): string
	{
		$file_name = '';
		if ($_FILES[$name] != '') {
			$config['upload_path'] = './uploads/' . $folder . '/';
			$config['allowed_types'] = '*';
			$config['encrypt_name'] = TRUE;
			$config['file_name']     = $_FILES[$name]['name'];

			$this->load->library('upload',$config);

			if($this->upload->do_upload($name)){
				$image_data = $this->upload->data();

				$file_name =  "uploads/" . $folder . "/" . $image_data['file_name'];
			}
			return $file_name;
		}
	}

	public function get_example_data($id)
	{
		return $this->db->get_where('example_data', ['ex_id' => $id])->result();
	}

	public function get_question_data($id){
		return $this->db->where('ed_id',$id)->get('example_question_data')->result_array();
	}

	public function get_answer_data($id){
		return $this->db->where('ed_id',$id)->get('example_answer_data')->result_array();
	}

	public function getLanguage(){
		return $this->session->userdata('language');
	}

	public function getBoard(){
		return $this->session->userdata('board');
	}

	public function getBoardName(){
		return $this->session->userdata('board');
	}

	public function getBssCode(){
		return $this->db->where('bss_status',1)->where('lang',$this->getLanguage())->get('bssmap')->result();
	}

	public function duplicateRecord($table, $primary_key_field, $primary_key_val, $foreign_key_field = '', $foreign_key_val = '') {
		/* CREATE SELECT QUERY */
		$this->db->where($primary_key_field, $primary_key_val);
		$query = $this->db->get($table);
		foreach ($query->result() as $row){
			foreach($row as $key=>$val) {
				if($key != $primary_key_field) {
					if($foreign_key_field != '' && $key == $foreign_key_field){
						$this->db->set($key, $foreign_key_val);
					}else{
						$this->db->set($key, $val);
					}
				}
			}
		}
		//insert the new record into table
		$this->db->insert($table);

		return $this->db->insert_id();
	}
}
