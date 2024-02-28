<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

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

    public function generate_kodetransmasuk()
    {
        $monthYear = date('m-Y');
        $tampung = explode('-', $monthYear);
        $bulan = $tampung[0];
        $tahun = $tampung[1];

        // Get the number of transactions occurred in the current month
        $transactionCount = $this->m_transaksi->getkodetrans($bulan,$tahun);
        foreach($transactionCount as $row):
            $temp = $row->jumlah;
        endforeach;
        $jumlah = $temp + 1;
        // Generate the transaction code
        $transactionCode = 'SJ/J3/BHN/' . $jumlah;
    
        return $transactionCode;
    }
    
    public function transaksi_masuk_act()
    {
        $transaksi_temp = $this->input->post('transaksi_temp');
        $id_transaksi = $this->input->post('id_transaksi');
        $nama_barang = $this->input->post('nama_barang');
        $nama_merk = $this->input->post('nama_merk');
        $tahun_barang = $this->input->post('tahun_barang');
        $seri_barang = $this->input->post('seri_barang');
        $kode_bulan = $this->input->post('kode_bulan');
        $kode_urut = $this->input->post('kode_urut');
        $harga_masuk = $this->input->post('harga_masuk');
        $id_user = $this->session->userdata('id_user');

        foreach($transaksi_temp as $rows):
            $id_transaksi = $rows['id_transaksi'];
            $id_rekanan = $rows ['id_rekanan'];
        endforeach;
        if($id_transaksi == '' OR $id_transaksi == null){
            $kd_transaksi = $this->generate_kodetransmasuk();
            $data['insert'] = $this -> m_transaksi -> insert_transaksi($kd_transaksi,$id_rekanan,$id_user);
            foreach($transaksi_temp as $row):
                $nama_barang = $row['nama_barang'];
                $nama_merk = $row['nama_merk'];
                $tahun_barang = $row['tahun_barang'];
                $seri_barang = $row['seri_barang'];
                $kode_bulan = $row['kode_bulan'];
                $kode_urut = $row['kode_urut'];
                $harga_masuk = $row['harga_masuk'];
                $data['insert_barang'] = $this -> m_transaksi -> insert_stok($kd_transaksi,$nama_barang,$nama_merk,$tahun_barang,$seri_barang,$kode_bulan,$kode_urut,$harga_masuk,$id_user);
            endforeach;
            if($data['insert_barang'] == 'true' OR $data['insert_barang'] == TRUE OR $data['insert_barang'] == 'TRUE'){
                $response = [
                    'status' => '200',
                    'message' =>  'Barang berhasil terinput'
                ];
            }else{
                $response = [
                    'status' => '400',
                    'message' =>  'Barang gagal terinput'
                ];
    
            }
        }
        header('Content-Type: application/json');

        echo json_encode($response);
        die();
        
    }

    public function getdatatransaksimasuk()
    {
        $tgl_transaksi = $this->input->post('tanggal_transaksi');
        if($tgl_transaksi == '' OR $tgl_transaksi == null){
            $tgl_transaksi = date('Y-m-d');
        }else{
            $tgl_transaksi = date('Y-m-d', strtotime($tgl_transaksi));
        }
        $data = $this->m_transaksi->get_transaksimasuk($tgl_transaksi);
        echo json_encode($data);
    }

    public function print_transaksimasuk($id)
    {
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->m_master->getuser($id_user);
        $data['get_barang'] = $this->m_transaksi->get_barang_masuk($id);
		$this->load->view('v_transaksi/print_transaksi_masuk.php',$data);
    }

    public function master_barang_act()
    {
        $id_barang = $this->input->post('id_barang');
        $nama_barang = $this->input->post('nama_barang');
        $satuan_barang = $this->input->post('satuan_barang');
        $jenis_barang = $this->input->post('jenis_barang');

        if($id_barang == '' OR $id_barang == NULL){
            $data['insert'] = $this -> m_master -> insert_barang($nama_barang,$satuan_barang,$jenis_barang);
            if($data['insert'] == 'true' OR $data['insert'] == TRUE OR $data['insert'] == 'TRUE'){
                $response = [
                    'status' => '200',
                    'message' =>  'Barang berhasil terinput'
                ];
            }else{
                $response = [
                    'status' => '400',
                    'message' =>  'Barang gagal terinput'
                ];
    
            }
        }else{
            $data['insert'] = $this -> m_master -> update_barang($id_barang,$nama_barang,$satuan_barang,$jenis_barang);
            if($data['insert'] == 'true' OR $data['insert'] == TRUE OR $data['insert'] == 'TRUE'){
                $response = [
                    'status' => '200',
                    'message' =>  'Barang berhasil teredit'
                ];
            }else{
                $response = [
                    'status' => '400',
                    'message' =>  'Barang gagal terinput'
                ];

            }
        }

        
        header('Content-Type: application/json');

        echo json_encode($response);
        die();
    }

    public function getdatamasterbarang()
    {
        $data = $this->m_master->get_masterbarang();
        echo json_encode($data);
    }

    public function get_dataeditmasterbarang()
    {
        $id = $this->input->post('id');
        $data = $this->m_master->get_datamasterbarang($id);
        echo json_encode($data);
    }

    public function hapus_master()
    {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $cek = $this->db->delete($table, array('id' => $id));
        if($cek == TRUE OR $cek == true){
            $response = [
                'status' => '200',
                'message' => 'Berhasil hapus data'
            ];
        }else{
            $response = [
                'status' => '400',
                'message' => 'Gagal hapus data'
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function master_rekanan_act()
    {
        $id_rekanan = $this->input->post('id_rekanan');
        $nama_rekanan = $this->input->post('nama_rekanan');
        $alamat_rekanan = $this->input->post('alamat_rekanan');
        $notelp_rekanan = $this->input->post('notelp_rekanan');
        $email_rekanan = $this->input->post('email_rekanan');


        if($id_rekanan == '' OR $id_rekanan == NULL){
            $data['insert'] = $this -> m_master -> insert_rekanan($nama_rekanan,$alamat_rekanan,$notelp_rekanan,$email_rekanan);
            if($data['insert'] == 'true' OR $data['insert'] == TRUE OR $data['insert'] == 'TRUE'){
                $response = [
                    'status' => '200',
                    'message' =>  'Rekanan berhasil terinput'
                ];
            }else{
                $response = [
                    'status' => '400',
                    'message' =>  'Rekanan gagal terinput'
                ];
    
            }
        }else{
            $data['insert'] = $this -> m_master -> update_rekanan($id_rekanan,$nama_rekanan,$alamat_rekanan,$notelp_rekanan,$email_rekanan);
            if($data['insert'] == 'true' OR $data['insert'] == TRUE OR $data['insert'] == 'TRUE'){
                $response = [
                    'status' => '200',
                    'message' =>  'Rekanan berhasil teredit'
                ];
            }else{
                $response = [
                    'status' => '400',
                    'message' =>  'Rekanan gagal terinput'
                ];

            }
        }

        
        header('Content-Type: application/json');

        echo json_encode($response);
        die();
    }

    public function getdatamasterrekanan()
    {
        $data = $this->m_master->get_masterrekanan();
        echo json_encode($data);
    }

    public function get_dataeditmasterrekanan()
    {
        $id = $this->input->post('id');
        $data = $this->m_master->get_datamasterrekanan($id);
        echo json_encode($data);
    }


    public function master_satuan_act()
    {
        $id_satuan = $this->input->post('id_satuan');
        $nama_satuan = $this->input->post('nama_satuan');
        $deskripsi_satuan = $this->input->post('deskripsi_satuan');


        if($id_satuan == '' OR $id_satuan == NULL){
            $data['insert'] = $this -> m_master -> insert_satuan($nama_satuan,$deskripsi_satuan);
            if($data['insert'] == 'true' OR $data['insert'] == TRUE OR $data['insert'] == 'TRUE'){
                $response = [
                    'status' => '200',
                    'message' =>  'satuan berhasil terinput'
                ];
            }else{
                $response = [
                    'status' => '400',
                    'message' =>  'satuan gagal terinput'
                ];
    
            }
        }else{
            $data['insert'] = $this -> m_master -> update_satuan($id_satuan,$nama_satuan,$deskripsi_satuan);
            if($data['insert'] == 'true' OR $data['insert'] == TRUE OR $data['insert'] == 'TRUE'){
                $response = [
                    'status' => '200',
                    'message' =>  'satuan berhasil teredit'
                ];
            }else{
                $response = [
                    'status' => '400',
                    'message' =>  'satuan gagal terinput'
                ];

            }
        }

        
        header('Content-Type: application/json');

        echo json_encode($response);
        die();
    }

    public function getdatamastersatuan()
    {
        $data = $this->m_master->get_mastersatuan();
        echo json_encode($data);
    }

    public function get_dataeditmastersatuan()
    {
        $id = $this->input->post('id');
        $data = $this->m_master->get_datamastersatuan($id);
        echo json_encode($data);
    }

    public function getdatabarang()
    {
        $data = $this->m_master->get_databarang();
        echo json_encode($data);
    }

    public function getdatabarang2()
    {
        $id_barang = $this->input->post('id');
        $data = $this->m_master->get_databarang2($id_barang);
        echo json_encode($data);
    }


    public function master_harga_act()
    {
        $id_harga = $this->input->post('id_harga');
        $id_barang = $this->input->post('id_barang');
        $nama_barang = $this->input->post('nama_barang');
        $nama_satuan = $this->input->post('nama_satuan');
        $harga_barang = $this->input->post('harga_barang');


        if($id_harga == '' OR $id_harga == NULL){
            $data['insert'] = $this -> m_master -> insert_harga($id_barang,$nama_barang,$nama_satuan,$harga_barang);
            if($data['insert'] == 'true' OR $data['insert'] == TRUE OR $data['insert'] == 'TRUE'){
                $response = [
                    'status' => '200',
                    'message' =>  'harga berhasil terinput'
                ];
            }else{
                $response = [
                    'status' => '400',
                    'message' =>  'harga gagal terinput'
                ];
    
            }
        }else{
            $data['insert'] = $this -> m_master -> update_harga($id_harga,$id_barang,$nama_barang,$nama_satuan,$harga_barang);
            if($data['insert'] == 'true' OR $data['insert'] == TRUE OR $data['insert'] == 'TRUE'){
                $response = [
                    'status' => '200',
                    'message' =>  'harga berhasil teredit'
                ];
            }else{
                $response = [
                    'status' => '400',
                    'message' =>  'harga gagal terinput'
                ];

            }
        }

        
        header('Content-Type: application/json');

        echo json_encode($response);
        die();
    }

    public function getharga()
    {
        $id_barang = $this->input->post('id_barang');
        $data = $this->m_master->get_harga($id_barang);
        echo json_encode($data);
    }
    
    public function gethargabarang()
    {
        $id = $this->input->post('id');
        $data = $this->m_master->get_hargabarang($id);
        echo json_encode($data);
    }


}
