<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Order extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // //Menampilkan data produk
    function index_get($id=null) {
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where('user_id', $id);
        $produk = $this->db->get()->row();
        
        if (empty($produk)) {
            $this->response(array('status'=>'empty'), 200);
        }else {
            $this->response(array('status'=>'success', 'data'=>$produk), 200);            
        }
    }

    //Mengirim atau menambah data produk baru
    function index_post() {

        $data = array(
            'product_id'    => $this->post('product_id'),
            'user_id'    => $this->post('user_id'),
            'quantity'    => $this->post('quantity'),
            'total'    => $this->post('total'),
            'file_path'   => $this->post('file_path'),
            'notes'   => $this->post('notes'),
            'address' => $this->post('address'),
            'courier' => $this->post('courier')
        );
        // var_dump($data); die;
        
        if (!empty($_FILES['file_path']['name'])) {
            $config['upload_path']          = './orders/';
            $config['allowed_types']        = 'jpg|png|jpeg|rar|zip|psd|cdr';
            $config['max_size']             = 10000;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file_path')){
                $msg = $this->upload->display_errors();
                return $this->response(array('status'=>'fail','msg'=>$msg),502);
                
            }else{
                $uploaded = $this->upload->data();
                $data['file_path'] = base_url().$uploaded['file_name'];
            }
        }else {
            $data['file_path'] = '';
        }
        $insert = $this->db->insert('orders', $data);
        if ($insert) {
            $this->response(array('status'=>'success','msg'=>'sukses memasukan data', 'data'=>$data),200);
        } else {
            $this->response(array('status' => 'fail'), 502);
        }
    }
}
?>