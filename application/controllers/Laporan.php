<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		// $this->load->model('m_master_ttd');
		$this->load->model('m_transaksi');
		$this->load->model('m_master');
		$this->load->model('m_login');
        $this->load->model('m_laporan');
		// $this->load->helper('date');
		// $this->load->library('upload');
        $this->db = $this->load->database('default', TRUE);
		 date_default_timezone_set('Asia/Jakarta');
         $data['user'] = $this->get_user();
         if(count($data['user']) == 0){
             redirect('login');
         }
		
	}

    public function get_user()
    {
        $id_user = $this->session->userdata('id_user');
        $data = $this->m_login->getuser($id_user);
        $last_activity_timestamp = $this->session->userdata('last_activity');

        // If last_activity is not available, set it to the current time
        if (!$last_activity_timestamp) {
            $last_activity_timestamp = time();
            $this->session->set_userdata('last_activity', $last_activity_timestamp);
        }

        // Calculate the duration of the session in seconds
        $current_time = time();
        $session_duration = $current_time - $last_activity_timestamp;

        // Convert the duration to a more readable format (e.g., minutes)
        $session_duration_in_minutes = round($session_duration / 60);
        // $data['last_activity'] = $session_duration_in_minutes;
        return $data;
    }


    public function print_barang_masuk(){
        $jangka_waktu = $_GET['jangka_waktu'];
        $tgl = $_GET['tgl'];
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->m_master->getuser($id_user);
        $data['get_barang'] = $this->m_laporan->lap_barang_masuk($jangka_waktu,$tgl);
        // var_dump($data);
        // die();
		$this->load->view('v_laporan/print_laporan_barang_masuk.php',$data);
    }

    public function print_barang_keluar(){
        $jangka_waktu = $_GET['jangka_waktu'];
        if($jangka_waktu == 'Rentang Waktu'){
            $tgl = '';
            $tgl1 = $_GET['tgl1'];
            $tgl2 = $_GET['tgl2'];
            $data['get_barang'] = $this->m_laporan->lap_barang_keluar($jangka_waktu,$tgl,$tgl1,
            $tgl2);
        }else{
            $tgl = $_GET['tgl'];
            $tgl1 = '';
            $tgl2 = '';
            $data['get_barang'] = $this->m_laporan->lap_barang_keluar($jangka_waktu,$tgl,$tgl1,
            $tgl2);
        }
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->m_master->getuser($id_user);
        // $data['get_retur'] = $this->m_laporan->get_retur_pengganti($jangka_waktu,$tgl);
        $temp = [];
        // $temp2 = [];
        $totpotongan = 0;
        foreach($data['get_barang'] as $row):
            $kodetrans = $row -> kode_transaksi;
            if(!in_array($kodetrans,$temp)){
                array_push($temp,$kodetrans);
                $res = $this -> m_laporan -> potongan_barang_keluar2($kodetrans);
                if(!empty($res)){
                    $nilai =  $res[0] -> potongan;
                    $totpotongan = $nilai + $totpotongan;
                }
            }
        endforeach;
        $data['totpotongan'] = $totpotongan;
		$this->load->view('v_laporan/print_laporan_barang_keluar.php',$data);
    }


    public function print_retur_supplier(){
        $jangka_waktu = $_GET['jangka_waktu'];
        $tgl = $_GET['tgl'];
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->m_master->getuser($id_user);
        $data['get_barang'] = $this->m_laporan->lap_retur_supplier($jangka_waktu,$tgl);
		$this->load->view('v_laporan/print_laporan_retursupplier.php',$data);
    }


    public function print_retur_penjualan(){
        $jangka_waktu = $_GET['jangka_waktu'];
        $tgl = $_GET['tgl'];
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->m_master->getuser($id_user);
        $data['get_barang'] = $this->m_laporan->lap_retur_penjualan($jangka_waktu,$tgl);
		$this->load->view('v_laporan/print_laporan_returpenjualan.php',$data);
    }


    public function print_penghasilan(){
        $jangka_waktu = $_GET['jangka_waktu'];
        $tgl = $_GET['tgl'];
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->m_master->getuser($id_user);
        $data['get_barang'] = $this->m_laporan->lap_penghasilan($jangka_waktu,$tgl);
		$this->load->view('v_laporan/print_laporan_penghasilan.php',$data);
    }

    public function print_pembayaran_hutang(){
        $jangka_waktu = $_GET['jangka_waktu'];
        $tgl = $_GET['tgl'];
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->m_master->getuser($id_user);
        $data['get_barang'] = $this->m_laporan->lap_pembayaran_hutang($jangka_waktu,$tgl);
		$this->load->view('v_laporan/print_laporan_pembayaran_hutang.php',$data);
    }

    public function print_jatuh_tempo(){
        $jangka_waktu = $_GET['jangka_waktu'];
        $tgl = $_GET['tgl'];
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->m_master->getuser($id_user);
        $data['get_barang'] = $this->m_laporan->lap_jatuh_tempo($jangka_waktu,$tgl);
		$this->load->view('v_laporan/print_laporan_jatuh_tempo.php',$data);
    }

    public function print_stok_gudang(){
        #$jangka_waktu = $_GET['jangka_waktu'];
        #$tgl = $_GET['tgl'];
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->m_master->getuser($id_user);
        $data['get_barang'] = $this->m_laporan->lap_stok_gudang();
        // var_dump($data);die();
		$this->load->view('v_laporan/print_laporan_stok.php',$data);
    }
}
