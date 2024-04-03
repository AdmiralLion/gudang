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
		// $this->load->helper('date');
		// $this->load->library('upload');
        $this->db = $this->load->database('default', TRUE);
		 date_default_timezone_set('Asia/Jakarta');
		
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


    public function lap_barang_masuk(){
        $data['user'] = $this->get_user();
        $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
        $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
        $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
        $data['JavaScriptTambahan'] = $this->load->view('v_laporan/laporan_barang_masuk.js',$data,TRUE);
		$this->load->view('v_laporan/v_laporan_barang_masuk.php',$data);
    }

    public function lap_barang_keluar(){
        $data['user'] = $this->get_user();
        $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
        $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
        $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
        $data['JavaScriptTambahan'] = $this->load->view('v_laporan/laporan_barang_keluar.js',$data,TRUE);
		$this->load->view('v_laporan/v_laporan_barang_keluar.php',$data);
    }


    public function lap_retur_supplier(){
        $data['user'] = $this->get_user();
        $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
        $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
        $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
        $data['JavaScriptTambahan'] = $this->load->view('v_laporan/laporan_retursupplier.js',$data,TRUE);
		$this->load->view('v_laporan/v_laporan_retursupplier.php',$data);
    }


    public function lap_retur_penjualan(){
        $data['user'] = $this->get_user();
        $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
        $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
        $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
        $data['JavaScriptTambahan'] = $this->load->view('v_laporan/laporan_returpenjualan.js',$data,TRUE);
		$this->load->view('v_laporan/v_laporan_returpenjualan.php',$data);
    }


    public function lap_penghasilan(){
        $data['user'] = $this->get_user();
        $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
        $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
        $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
        $data['JavaScriptTambahan'] = $this->load->view('v_laporan/laporan_penghasilan.js',$data,TRUE);
		$this->load->view('v_laporan/v_laporan_penghasilan.php',$data);
    }


}
