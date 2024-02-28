<?php
class m_transaksi extends CI_Model {

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

    public function getkodetrans($bulan,$tahun){
        $query = $this->db->query("SELECT COUNT(id) as jumlah FROM b_transaksi_masuk WHERE MONTH(tgl_act) = '$bulan' AND YEAR(tgl_act) = '$tahun'");
        return $query->result();
    }

    public function insert_transaksi($kd_transaksi,$id_rekanan,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_transaksi_masuk VALUES('','$kd_transaksi','$id_rekanan','$id_user','$tgl')");
        return $query;
    }

    public function insert_stok($kd_transaksi,$nama_barang,$nama_merk,$tahun_barang,$seri_barang,$kode_bulan,$kode_urut,$harga_masuk,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_barang_masuk VALUES('','$kd_transaksi','$nama_barang','$nama_merk','$tahun_barang','$seri_barang','$kode_bulan','$kode_urut','$harga_masuk','$id_user','$tgl')");
        return $query;
    }

    public function get_transaksimasuk($tanggal_transaksi){
        $query = $this->db->query("SELECT btm.id, btm.kode_transaksi,DATE_FORMAT(btm.tgl_act,'%d-%m-%Y') AS tgl, r.nama_rekanan FROM b_transaksi_masuk btm JOIN m_rekanan r ON btm.id_rekanan = r.id WHERE DATE(btm.tgl_act) = '$tanggal_transaksi'");
        return $query->result();
    }

    public function get_barang_masuk($id){
        $query = $this->db->query("SELECT btm.kode_transaksi, mb.nama_barang, ms.nama_satuan, m.nama_merk, bbm.tahun_barang, bbm.seri_barang, 
        bbm.kode_bulan, bbm.kode_urut, bbm.harga_barang, DATE_FORMAT(btm.tgl_act,'%d-%m-%Y') AS tgl_transaksi, mr.nama_rekanan 
        FROM b_transaksi_masuk btm JOIN b_barang_masuk bbm ON btm.kode_transaksi = bbm.kode_transaksi 
        JOIN m_barang mb ON bbm.id_barang = mb.id JOIN m_merk m ON bbm.id_merk = m.id JOIN m_rekanan mr ON btm.id_rekanan = mr.id
        JOIN m_satuan ms ON mb.satuan_barang = ms.id WHERE btm.id = '$id'");
        return $query->result();
    }

    public function get_barang_bulan($tgl_stok){
        $tgl = explode('-', $tgl_stok);
        $bulan = $tgl[1];
        $tahun = $tgl[2];
        $query = $this->db->query("SELECT btm.kode_transaksi, mb.nama_barang, ms.nama_satuan, m.nama_merk, bbm.tahun_barang, bbm.seri_barang, 
        bbm.kode_bulan, bbm.kode_urut, bbm.harga_barang, DATE_FORMAT(btm.tgl_act,'%d-%m-%Y') AS tgl_transaksi, mr.nama_rekanan 
        FROM b_transaksi_masuk btm JOIN b_barang_masuk bbm ON btm.kode_transaksi = bbm.kode_transaksi 
        JOIN m_barang mb ON bbm.id_barang = mb.id JOIN m_merk m ON bbm.id_merk = m.id JOIN m_rekanan mr ON btm.id_rekanan = mr.id
        JOIN m_satuan ms ON mb.satuan_barang = ms.id WHERE MONTH(btm.tgl_act) = '$bulan' AND YEAR(btm.tgl_act) = '$tahun'");
        return $query->result();
    }

    public function get_namarekanan(){
        $query = $this->db->query("SELECT * FROM m_rekanan");
        return $query->result();
    }

    public function get_namabarang(){
        $query = $this->db->query("SELECT * FROM m_barang");
        return $query->result();
    }

    public function get_namamerk(){
        $query = $this->db->query("SELECT * FROM m_merk");
        return $query->result();
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