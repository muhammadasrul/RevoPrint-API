<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class DbOperations extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function LoginApi($email, $password) {
        $q = $this->db->query("SELECT * FROM user WHERE email = '$email'")->result_array();
        foreach ($q as $key) {
            $hash = $key['password'];
        }

        if (password_verify($password, $hash)) {
            $result = $this->db->query("SELECT id, name, email FROM user WHERE email = '$email' AND PASSWORD = '$hash'");
            foreach ($result->result_array() as $key) {
                $id = $key['id'];
                $name = $key['name'];
                $email = $key['email'];
            }

            $data = [
                'status' => 200,
                'error' => false,
                'message' => 'berhasil login',
                'data' => [
                    'id' => $id,
                    'name' => $name,
                    'email' => $email]
                ];
                
            return $data;
        } else {
            $result = array(
                'error' => true,
                'message' => 'password atau email salah',
            );
            return $result;
        }
    }
}