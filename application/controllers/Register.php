<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Register extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('DbOperations');
    }

    //Mengirim atau menambah user baru (register)
    function index_post() {

        $hash_password = password_hash($this->post('password'), PASSWORD_DEFAULT);

        $data = array(
        'id' => $this->post('id'),
        'email' => $this->post('email'),
        'name' => $this->post('name'),
        'password' => $hash_password,
        'role' => 2);

        $insert = $this->db->insert('user', $data);
        if ($insert) {
            $this->response(array('status' => 200, 'error' => false, 'message' => 'berhasil register', 'data' => $data));
        } else {
            $this->response(array('status' => 502, 'error' => false, 'message' => 'gagal'));
        }
    }

    function index_put($id) {

        $data = array(
                    'name'    => $this->put('name'),
                    'email'    => $this->put('email')
                );

        if ($data['name'] && $data['email'] != null) {
            $this->db->where('id', $id);
            $update = $this->db->update('user', $data);
            if ($update) {
                $this->response(array('status' => 200 , 'error' => false, 'message' => 'data berhasil di-update', 'data' => $data));    
            } else {
                $this->response(array('status' => 502 , 'error' => true, 'message' => 'data gagal di-update'));
            }
        } else {
            $this->response(array('status' => 502 , 'error' => true, 'message' => 'data gagal di-update'));
        }
    }
}