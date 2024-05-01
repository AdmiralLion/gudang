<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

     function __construct()
	{
		parent::__construct();
		// $this->load->model('m_master_ttd');
		// $this->load->model('m_rme');
		// $this->load->model('m_rme_rj');
		$this->load->model('m_login');
		// $this->load->helper('date');
		// $this->load->library('upload');
		//  $this->db3 = $this->load->database('lokal3', TRUE);
		 date_default_timezone_set('Asia/Jakarta');
		
	}
	public function index()
	{
        $data['user'] = '';
        $data['JavaScriptTambahan'] = $this->load->view('v_login/login.js',$data,TRUE);
		$this->load->view('v_login/v_login.php',$data);
	}

    public function login_act()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if($username == '' OR $username == null OR $password == '' OR $password == null){
            $error_msgs = [
                '400' => 'Username atau password belum terisi'
            ];
            echo json_encode($error_msgs);
            die();
        }

        $data['cek'] = $this->m_login->ceklogin($username,$password);
        $tes = count($data['cek']);
        foreach($data['cek'] as $row):
            $id_user = $row -> id;
        endforeach; 
        if($tes == 0){
            $data = 0;
            $response = [
                'status' => '400',
                'message' => 'Username atau password salah'
            ];
        }else{
            $data = 1;
            $response = [
                'status' => '200',
                'message' => 'Berhasil Login',
                'id_user' => $id_user
            ];
            $this->session->set_userdata('id_user', $id_user);
        } 
        header('Content-Type: application/json');

        echo json_encode($response);
        die();
    }

    public function logout() {
        // Lakukan proses logout di sini
        // Contoh:
        $this->session->unset_userdata('id_user');
        // Jika menggunakan session lain, unset juga di sini

        // Setelah logout, bisa redirect ke halaman lain
        // atau kirim response ke client
        echo json_encode(['status' => 'success', 'message' => 'Logout berhasil']);
    }

}
