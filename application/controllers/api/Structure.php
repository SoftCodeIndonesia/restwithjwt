<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
class Structure extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }


    public function position_get()
    {


        $structure = $this->db->get('posisi')->result_array();


        if($structure){
            $this->response(["status" => "success", "data" => $structure, "message" => "Successfully"], REST_Controller::HTTP_OK);
        }else{
            
            $this->response([
                'status' => "fail",
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            
        }

    }

    public function index_get()
    {

    }
    
    public function index_post()
    {

    }
}   