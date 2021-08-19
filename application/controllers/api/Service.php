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
class Service extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }


    public function index_get()
    {

        $tipe_id = $this->get('tipe_id');

        $tipe_jasa = $this->db->get_where('jasa', ['tipe_jasa_id' => $tipe_id])->result_array();


        if($tipe_jasa){
            $this->response(["status" => "success", "data" => $tipe_jasa, "message" => "Successfully"], REST_Controller::HTTP_OK);
        }else{
            
            $this->response([
                'status' => "fail",
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            
        }

    }


}   