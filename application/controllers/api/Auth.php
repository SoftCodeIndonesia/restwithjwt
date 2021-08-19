<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Auth extends BD_Controller {

    function __construct()
    {
        
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('M_main');
    }

    

    public function login_post()
    {
        $no_telp = $this->post('no_telp'); //Username Posted
        $password = md5($this->post('password')); //Pasword Posted
        $kunci = $this->config->item('thekey');
        $invalidLogin = ['status' => 'Invalid Login']; //Respon if login invalid
        $kunci = $this->config->item('thekey');
        // $val = $this->M_main->get_user($q)->row(); //Model to get single data row from database base on username
        // if($this->M_main->get_user($q)->num_rows() == 0){$this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);}

        $user = $this->db->get_where('users', ['nomor_telepon' => $no_telp, 'password' => $password])->row_array();
       
		// $match = $user->password;   //Get password for user from database
        if($user){  //Condition if password matched
        	$token['id'] = $user['id'];  //From here
            $token['username'] = $user['nama_lengkap'];
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60*60*5; //To here is to generate token
            $user['token'] = JWT::encode($token,$kunci ); //This is the output token
            $this->set_response([
                'status' => 'success',
                'data' => $user,
                'message' => 'is_loggedIn'], REST_Controller::HTTP_OK); //This is the respon if success
        }
        else {
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND); //This is the respon if failed
        }

        // echo 'welcome';
    }

}