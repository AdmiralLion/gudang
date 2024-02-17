<?php
class m_master extends CI_Model {

	/*private $table = 'rm_ms_ttd';*/
	private $table = 'general_consent';
	private $table2 = 'terima_transfer_pasien';
	private $table3 = 'transfer_pasien';
	private $table4 = 'askep_riwayat_sakit';
	private $table5 = 'form_fisioterapi';
    private $table6 = 'informasi_kedokteran';
    private $table7 = 'penolakan_shk';
    private $table8 = 'ket_kematian';
    private $table9 = 'pemberian_informasi_terminal';
    private $table10 = 'lembar_masuk_icunicu';
    private $table11 = 'pulang_paksa';
    private $table12 = 'pengkajian_restrain';
    private $table13 = 'penandaan_lokasi';
    private $table14 = 'ket_kelahiran';
    private $table15 = 'penundaan_pelayanan';

	private $edukasi_px = 'edukasi_pasien';

	function __construct()
 	{
        parent::__construct();
        // $this->db2 = $this->load->database('berkas', TRUE);
        // $this->db3 = $this->load->database('lokal3', TRUE);
        // $this->db4 = $this->load->database('satset', TRUE);
        $this->db = $this->load->database('default', TRUE);
    	// $db_rme 	= $this->load->database("lokal3", TRUE);

 	}

     public function insert_barang($nama_barang,$satuan_barang,$jenis_barang){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO m_barang VALUES('','$nama_barang','$satuan_barang','$jenis_barang','$tgl')");
        return $query;
    }

    public function update_barang($id_barang,$nama_barang,$satuan_barang,$jenis_barang){
        $tgl = date('Y-m-d H:i:s');
        $data = array(
            'nama_barang' => $nama_barang,
            'satuan_barang' => $satuan_barang,
            'jenis_barang' => $jenis_barang,
            'tgl_act' => $tgl
         );
         
         $this->db->where('id', $id_barang);
         $query = $this->db->update('m_barang', $data);

        return $query;
    }

    public function get_masterbarang(){
        $query = $this->db->query("SELECT * FROM m_barang");
        return $query->result();
    }

    public function get_datamasterbarang($id){
        $query = $this->db->query("SELECT * FROM m_barang WHERE id = '$id'");
        return $query->result();
    }

    public function getuser($id_user){
        $query = $this->db->query("SELECT * FROM a_user WHERE id = '$id_user'");
        return $query->result();
    }

    public function insert_rekanan($nama_rekanan,$alamat_rekanan,$notelp_rekanan,$email_rekanan){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO m_rekanan VALUES('','$nama_rekanan','$alamat_rekanan','$notelp_rekanan','$email_rekanan','$tgl')");
        return $query;
    }

    public function update_rekanan($id_rekanan,$nama_rekanan,$alamat_rekanan,$notelp_rekanan,$email_rekanan){
        $tgl = date('Y-m-d H:i:s');
        $data = array(
            'nama_rekanan' => $nama_rekanan,
            'alamat_rekanan' => $alamat_rekanan,
            'notelp_rekanan' => $notelp_rekanan,
            'email_rekanan' => $email_rekanan,
            'tgl_act' => $tgl
         );
         
         $this->db->where('id', $id_rekanan);
         $query = $this->db->update('m_rekanan', $data);

        return $query;
    }

    public function get_masterrekanan(){
        $query = $this->db->query("SELECT * FROM m_rekanan");
        return $query->result();
    }

    public function get_datamasterrekanan($id){
        $query = $this->db->query("SELECT * FROM m_rekanan WHERE id = '$id'");
        return $query->result();
    }
    

    public function insert_satuan($nama_satuan,$deskripsi_satuan){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO m_satuan VALUES('','$nama_satuan','$deskripsi_satuan','$tgl')");
        return $query;
    }

    public function update_satuan($id_satuan,$nama_satuan,$deskripsi_satuan){
        $tgl = date('Y-m-d H:i:s');
        $data = array(
            'nama_satuan' => $nama_satuan,
            'deskripsi_satuan' => $deskripsi_satuan,
            'tgl_act' => $tgl
         );
         
         $this->db->where('id', $id_satuan);
         $query = $this->db->update('m_satuan', $data);

        return $query;
    }

    public function get_mastersatuan(){
        $query = $this->db->query("SELECT * FROM m_satuan");
        return $query->result();
    }

    public function get_datamastersatuan($id){
        $query = $this->db->query("SELECT * FROM m_satuan WHERE id = '$id'");
        return $query->result();
    }

    public function get_databarang(){
        $query = $this -> db -> query("SELECT mb.id,mb.nama_barang, ms.nama_satuan FROM m_barang mb JOIN m_satuan ms ON mb.satuan_barang = ms.id");
        return $query -> result();
    }

    public function get_databarang2($id_barang){
        $query = $this -> db -> query("SELECT mb.id,mb.nama_barang, ms.nama_satuan,mh.harga_jual FROM m_barang mb JOIN m_satuan ms ON mb.satuan_barang = ms.id LEFT JOIN m_harga mh ON mb.id = mh.id_barang WHERE mb.id = '$id_barang'");
        return $query -> result();
    }
    
    public function get_harga($id_barang){
        $query = $this->db->query("SELECT * FROM m_harga WHERE id_barang = '$id_barang'");
        return $query -> result();
    }

    public function get_hargabarang($id){
        $query = $this->db->query("SELECT * FROM m_harga WHERE id = '$id'");
        return $query -> result();
    }

    public function insert_harga($id_barang,$nama_barang,$nama_satuan,$harga_barang){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO m_harga VALUES('','$id_barang','$nama_barang','$nama_satuan','$harga_barang','$tgl')");
        return $query;
    }

    public function update_harga($id_harga,$id_barang,$nama_barang,$nama_satuan,$harga_barang){
        $tgl = date('Y-m-d H:i:s');
        $data = array(
            'harga_jual' => $harga_barang,
            'tgl_act' => $tgl
         );
         
         $this->db->where('id', $id_harga);
         $query = $this->db->update('m_harga', $data);

        return $query;
    }
}