<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
// require APPPATH . '/libraries/REST_Controller.php';
// require APPPATH . '/libraries/Format.php';

// use namespace
// use Restserver\Libraries\REST_Controller;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Users extends BD_Controller {
    
    // public function index_get()
    // {

    //     $users = [
    //         ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
    //         ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
    //         ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
    //     ];

    //     $this->response(["data" => $users, "message" => "Successfully"], REST_Controller::HTTP_OK);
    // }
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }

    public function index_get()
    {
       

        $user_id = $this->get('userId');

        if($user_id)
        {
            $userdata = $this->db->get_where('users', ['id' => $user_id])->row_array();
            $this->response(["status" => REST_Controller::HTTP_OK, "data" => $userdata, "message" => "Successfully"], REST_Controller::HTTP_OK);

        }else{
            $userdata = $this->db->get('users')->result_array();
            $this->response(["status" => REST_Controller::HTTP_OK, "data" => $userdata, "message" => "Successfully"], REST_Controller::HTTP_OK);
        }

    }


    public function index_post()
    {
        $this->load->helper(array('form', 'url'));

        $users['no_telp'] = $this->post('nama_lengkap');
        $users['email'] = $this->post('email');
        $users['no_telepon'] = $this->post('no_telepon');
        $users['tanggal_lahir'] = $this->post('tanggal_lahir');
        $users['alamat'] = $this->post('alamat');
        $users['alamat_domisili'] = $this->post('alamat_domisili');
        $users['jenis_kelamin'] = $this->post('jenis_kelamin');
        $users['is_admin'] = $this->post('is_admin');
        $users['password'] = md5('123');

        

        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('no_telepon', 'nomor telepon', 'required');
        $this->form_validation->set_rules('alamat', 'alamat', 'required');
        $this->form_validation->set_rules('alamat_domisili', 'alamat domisili', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis kelamin', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if($this->form_validation->run()){
            if($this->db->insert('users', $users) > 0){
                $this->response(["data" => $users, "message" => "Successfully"], REST_Controller::HTTP_OK);
            }else{
                $this->response(["data" => $users, "message" => 'Failed inserting data!'], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response(["data" => $users, "message" => 'Form Error'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    
}