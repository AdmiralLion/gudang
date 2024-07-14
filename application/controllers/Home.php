<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		// $this->load->model('m_master_ttd');
		// $this->load->model('m_rme');
		$this->load->model('m_transaksi');
		$this->load->model('m_master');
		$this->load->model('m_login');
		// $this->load->helper('date');
		// $this->load->library('upload');
		//  $this->db3 = $this->load->database('lokal3', TRUE);
		 date_default_timezone_set('Asia/Jakarta');
         $data['user'] = $this->get_user();
        if(count($data['user']) == 0){
            redirect('login');
        }
		
	}
    
	public function index()
	{
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->m_login->getuser($id_user);
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
        $data['last_activity'] = $session_duration_in_minutes;
        $data['JavaScriptTambahan'] = $this->load->view('v_main/main.js',$data,TRUE);
		$this->load->view('v_main/v_main.php',$data);
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

    public function master_barang()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['satuan'] = $this->m_master->get_mastersatuan();
            $data['JavaScriptTambahan'] = $this->load->view('v_master/master_barang.js',$data,TRUE);
            $this->load->view('v_master/v_master_barang.php',$data);
        }else{
            redirect('home');
        }
    }

    public function master_rekanan()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['JavaScriptTambahan'] = $this->load->view('v_master/master_rekanan.js',$data,TRUE);
		    $this->load->view('v_master/v_master_rekanan.php',$data);
        }else{
            redirect('home');
        }
        
    }

    public function master_satuan()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['JavaScriptTambahan'] = $this->load->view('v_master/master_satuan.js',$data,TRUE);
            $this->load->view('v_master/v_master_satuan.php',$data);
        }else{
            redirect('home');
        }
    }

    
    public function master_harga()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['JavaScriptTambahan'] = $this->load->view('v_master/master_harga.js',$data,TRUE);
            $this->load->view('v_master/v_master_harga.php',$data);
        }else{
            redirect('home');
        }

    }

    public function master_merk()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['JavaScriptTambahan'] = $this->load->view('v_master/master_merk.js',$data,TRUE);
            $this->load->view('v_master/v_master_merk.php',$data);
        }else{
            redirect('home');
        }

    }

    public function transaksi_masuk()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
            $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
            $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
            $data['JavaScriptTambahan'] = $this->load->view('v_transaksi/transaksi_masuk.js',$data,TRUE);
            $this->load->view('v_transaksi/v_transaksi_masuk.php',$data);
        }else{
            redirect('home');
        }
    }

    public function stok_barang()
    {
        $data['user'] = $this->get_user();
        $data['JavaScriptTambahan'] = $this->load->view('v_stok/stok_barang.js',$data,TRUE);
		$this->load->view('v_stok/v_stok_barang.php',$data);
    }

    public function transaksi_keluar()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
            $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
            $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
            $data['JavaScriptTambahan'] = $this->load->view('v_transaksi/transaksi_keluar.js',$data,TRUE);
            $this->load->view('v_transaksi/v_transaksi_keluar.php',$data);
        }else{
            redirect('home');
        }
    }

    public function transaksi_hutang()
    {
        $data['user'] = $this->get_user();
        $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
        $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
        $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
        $data['JavaScriptTambahan'] = $this->load->view('v_transaksi/transaksi_hutang.js',$data,TRUE);
		$this->load->view('v_transaksi/v_hutang.php',$data);
    }

    public function retur_jual()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
            $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
            $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
            $data['JavaScriptTambahan'] = $this->load->view('v_retur/retur_penjualan.js',$data,TRUE);
            $this->load->view('v_retur/v_retur_penjualan.php',$data);
        }else{
            redirect('home');
        }
    }

    public function retur_supplier()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
            $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
            $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
            $data['JavaScriptTambahan'] = $this->load->view('v_retur/retur_supplier.js',$data,TRUE);
            $this->load->view('v_retur/v_retur_supplier.php',$data);
        }else{
            redirect('home');
        }

    }

    public function laporan()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
            $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
            $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
            $data['JavaScriptTambahan'] = $this->load->view('v_laporan/laporan.js',$data,TRUE);
            $this->load->view('v_laporan/v_laporan.php',$data);
        }else{
            redirect('home');
        }
    }

    public function transaksi_klaim()
    {
        $data['user'] = $this->get_user();
        foreach($data['user'] as $rw):
            $akses = $rw -> hak_akses;
        endforeach;
        if($akses == '1'){
            $data['nama_rekanan'] = $this->m_transaksi->get_namarekanan();
            $data['nama_barang'] = $this -> m_transaksi->get_namabarang();
            $data['nama_merk'] = $this -> m_transaksi->get_namamerk();
            $data['master_barang'] = $this->m_master->get_masterbarangready();
            $data['JavaScriptTambahan'] = $this->load->view('v_transaksi/transaksi_klaim.js',$data,TRUE);
            $this->load->view('v_transaksi/v_transaksi_klaim.php',$data);
        }else{
            redirect('home');
        }

    }
}
