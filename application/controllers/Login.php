<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('DbOperations');
    }

    function index_post() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $result = $this->DbOperations->LoginApi($email, $password);
        
        $this->response($result);
    }

}