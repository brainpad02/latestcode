<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';
use \Firebase\JWT\JWT;

class BD_Controller extends REST_Controller
{
    // protected $userSession;
    public function __construct(){
        parent::__construct();
    }
	
    public function auth()
    {
        $headers  = $this->input->get_request_header('Authorization');
        $key      = $this->config->item('thekey'); //secret key for encode and decode
        $token    = "token";
        if (!empty($headers)) {
        	if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
                $token = $matches[1];
        	}
        }

        try {
           $decoded = JWT::decode($token, $key, array('HS256'));
            $this->user = $decoded;
            
        } catch (Exception $e) {
            $invalid = ['msg' => $e->getMessage()]; //Respond if credential invalid
            $this->response($invalid, 401);//401
        }
    }
    
    public function get_token_data()
    {
        $headers = $this->input->get_request_header('Authorization');
        $kunci = $this->config->item('thekey'); //secret key for encode and decode
        $token= "token";
        if (!empty($headers)) {
        	if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
                $token = $matches[1];
        	}
        }
        
        try {
           $decoded = JWT::decode($token, $kunci, array('HS256'));
            
            return $this->user_data = $decoded;
            
        } catch (Exception $e) {
            $invalid = ['msg' => $e->getMessage()]; //Respon if credential invalid
            $this->response($invalid, 401);//401
        }
    }
    
    public function profile_data($id,$token = '')
	{
        $user_data = $this->db->get_where('users',['user_id'=>$id])->row();
        $standard = '';
        $board = '';
        if(!empty($user_data->standard) || $user_data->standard !='')
        {
            $std = $this->db->get_where('standard',['std_id'=>$user_data->standard])->row();
            $standard = $std->std_name;
        }
        if(!empty($user_data->board) || $user_data->board !='')
        {
            $brd = $this->db->get_where('board',['bd_id'=> $user_data->board])->row();
            $board = $brd->bd_name;
        }
        
        $data = [
            'username'                  => $user_data->username,
            'usercode'                  => $user_data->usercode,
            'profile_pic'               => ($user_data->profile_pic != '') ? base_url($user_data->profile_pic) : '',
            'phone_no'                  => $user_data->phone_no,
            'email'                     => $user_data->email_id,
            'dob'                       => ($user_data->dob=='0000-00-00')?'':date('d-m-Y', strtotime($user_data->dob)),
            'gender'                    => (($user_data->gender==1)?'Male':(($user_data->gender==2)?'Female':'')),
            // 'user_type'                 => (($user_data->user_type==1)?'Teacher':(($user_data->user_type==2)?'Student':'')),
            'user_type'                 => $user_data->user_type,
            'board'                     => $board,
            'standard'                  => $standard,
            'accept_privacy_policy'     => intval($user_data->accept_privacy_policy),
            'accept_date_time'          => date('d-m-Y h:i:s A',strtotime($user_data->accept_date_time)),
            'is_profile_complete'       => $user_data->is_profile_complete,
            'school_id'                 => $user_data->school_id
        ];

        if($token != ''){
            $data['token'] = $token;
        }
        return $data;
    }

	public function generate_token($data): string
	{
		$key = $this->config->item('thekey');
		$date = new DateTime();
		$data['iat'] = $date->getTimestamp();
		$data['exp'] = $date->getTimestamp() + 3600*24*180; //To here is to generate token
		return JWT::encode($data,$key ); //This is the output token
	}
}
