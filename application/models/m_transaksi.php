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

    public function cekkodetransmsk($transactionCode){
        $query = $this->db->query("SELECT * FROM b_transaksi_masuk WHERE kode_transaksi = '$transactionCode'");
        return $query->result();
    }

    public function insert_transaksi($kd_transaksi,$id_rekanan,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_transaksi_masuk VALUES('','$kd_transaksi','$id_rekanan','$id_user','$tgl')");
        return $query;
    }

    public function insert_stok($kd_transaksi,$nama_barang,$nama_merk,$tahun_barang,$seri_barang,$kode_bulan,$kode_urut,$jns_brg,$kualitas,$harga_masuk,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_barang_masuk VALUES('','$kd_transaksi','$nama_barang','$nama_merk','$tahun_barang','$seri_barang','$kode_bulan','$kode_urut','$jns_brg','$kualitas','$harga_masuk','$id_user',1,'$tgl')");
        return $query;
    }

    public function get_transaksimasuk($tanggal_transaksi){
        $query = $this->db->query("SELECT btm.id, btm.kode_transaksi,DATE_FORMAT(btm.tgl_act,'%d-%m-%Y') AS tgl, r.nama_rekanan FROM b_transaksi_masuk btm JOIN m_rekanan r ON btm.id_rekanan = r.id WHERE DATE(btm.tgl_act) = '$tanggal_transaksi'");
        return $query->result();
    }

    public function get_kdtransaksimasuk($kode_transaksi){
        $query = $this->db->query("SELECT bbm.kode_transaksi,bbm.id,mb.nama_barang, ms.nama_satuan, m.nama_merk, bbm.tahun_barang, bbm.seri_barang, bbm.kode_bulan, bbm.kode_urut,bbm.jenis_barang,bbm.kualitas, bbm.harga_barang,DATE_FORMAT(bbm.tgl_act,'%d-%m-%Y') AS tgl_transaksi FROM b_barang_masuk bbm JOIN m_barang mb ON bbm.id_barang = mb.id JOIN m_merk m ON bbm.id_merk = m.id JOIN m_satuan ms ON mb.satuan_barang = ms.id WHERE bbm.kode_transaksi = '$kode_transaksi'");
        return $query->result();
    }

    public function get_idbrgmasuk($id){
        $query = $this->db->query("SELECT bbm.*,mb.nama_barang, ms.nama_satuan, m.nama_merk, DATE_FORMAT(bbm.tgl_act,'%d-%m-%Y') AS tgl_transaksi FROM b_barang_masuk bbm JOIN m_barang mb ON bbm.id_barang = mb.id JOIN m_merk m ON bbm.id_merk = m.id JOIN m_satuan ms ON mb.satuan_barang = ms.id WHERE bbm.id = '$id'");
        return $query->result();
    }

    public function get_brgkelbyidbrg($id){
        $query = $this->db->query("SELECT bbk.*,mb.nama_barang, ms.nama_satuan, m.nama_merk, DATE_FORMAT(bbk.tgl_act,'%d-%m-%Y') AS tgl_transaksi 
        FROM b_barang_keluar bbk JOIN m_barang mb ON bbk.id_barang = mb.id JOIN m_merk m ON bbk.id_merk = m.id 
        JOIN m_satuan ms ON mb.satuan_barang = ms.id WHERE bbk.id_stok = '$id'");
        return $query->result();
    }

    public function get_barang_masuk($id){
        $query = $this->db->query("SELECT btm.kode_transaksi, mb.nama_barang, ms.nama_satuan, m.nama_merk, bbm.tahun_barang, bbm.seri_barang, 
        bbm.kode_bulan, bbm.kode_urut,bbm.jenis_barang,bbm.kualitas, bbm.harga_barang, DATE_FORMAT(btm.tgl_act,'%d-%m-%Y') AS tgl_transaksi, mr.nama_rekanan 
        FROM b_transaksi_masuk btm JOIN b_barang_masuk bbm ON btm.kode_transaksi = bbm.kode_transaksi 
        JOIN m_barang mb ON bbm.id_barang = mb.id JOIN m_merk m ON bbm.id_merk = m.id JOIN m_rekanan mr ON btm.id_rekanan = mr.id
        JOIN m_satuan ms ON mb.satuan_barang = ms.id WHERE btm.id = '$id'");
        return $query->result();
    }

    public function get_stok($tgl_stok){
        $tgl = explode('-', $tgl_stok);
        $bulan = $tgl[0];
        $tahun = $tgl[1];
        $query = $this->db->query("SELECT btm.kode_transaksi, mb.nama_barang, ms.nama_satuan, m.nama_merk, bbm.tahun_barang, bbm.seri_barang, 
        bbm.kode_bulan, bbm.kode_urut,bbm.jenis_barang, bbm.harga_barang, DATE_FORMAT(btm.tgl_act,'%d-%m-%Y') AS tgl_transaksi, mr.nama_rekanan, bbm.stok,bbm.kualitas, (SELECT DATE_FORMAT(bbk.tgl_act, '%d-%m-%Y') FROM b_barang_keluar bbk WHERE bbm.id = bbk.id_stok ORDER BY bbk.id DESC LIMIT 1) AS tgl_kel
        FROM b_transaksi_masuk btm JOIN b_barang_masuk bbm ON btm.kode_transaksi = bbm.kode_transaksi 
        JOIN m_barang mb ON bbm.id_barang = mb.id JOIN m_merk m ON bbm.id_merk = m.id JOIN m_rekanan mr ON btm.id_rekanan = mr.id JOIN m_satuan ms ON mb.satuan_barang = ms.id WHERE MONTH(btm.tgl_act) = '$bulan' AND YEAR(btm.tgl_act) = '$tahun' ORDER BY bbm.id");
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
        $query = $this->db->query("SELECT * FROM m_barang JOIN m_satuan ON m_barang.satuan_barang = m_satuan.id");
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

    public function getkodetranskeluar($bulan,$tahun){
        $query = $this->db->query("SELECT COUNT(id) as jumlah FROM b_transaksi_keluar WHERE MONTH(tgl_act) = '$bulan' AND YEAR(tgl_act) = '$tahun'");
        return $query->result();
    }

    public function cekkodetransklr($transactionCode){
        $query = $this->db->query("SELECT * FROM b_transaksi_keluar WHERE kode_transaksi = '$transactionCode'");
        return $query->result();
    }

    public function insert_transaksi_keluar($kd_transaksi,$nama_pembeli,$jatuh_tempo,$batas_klaim,$jumlah_bayar,$jumlah_potongan,$id_user,$cekhutang){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_transaksi_keluar VALUES('','$kd_transaksi','$nama_pembeli','$cekhutang',null,'$jatuh_tempo','$jumlah_bayar','$jumlah_potongan','$batas_klaim','$id_user','$tgl')");
        return $query;
    }

    public function insert_barang_keluar($kd_transaksi,$id_stok,$id_barang,$id_merk,$tahun_barang,$seri_barang,$kode_bulan,$kode_urut,$harga_masuk,$hutang,$klaim,$jns_brg,$kualitas,$harga_keluar,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_barang_keluar VALUES('','$kd_transaksi','$id_stok','$id_barang','$id_merk','$tahun_barang','$seri_barang','$kode_bulan','$kode_urut','$kualitas','$jns_brg','$harga_masuk',$harga_keluar,null,'$hutang','$klaim','$id_user','$tgl')");
        return $query;
    }

    public function get_detailbarang_keluar($id){
        $query = $this->db->query("SELECT b.id id_barang,bm.kode_transaksi,bm.id id_transaksi, m.id id_merk, b.nama_barang,m.nama_merk,bm.tahun_barang,bm.seri_barang,bm.kode_bulan,bm.kode_urut,bm.kualitas,bm.jenis_barang,bm.harga_barang
        FROM b_barang_masuk bm INNER JOIN m_barang b ON bm.id_barang = b.id INNER JOIN m_merk m ON bm.id_merk = m.id
        WHERE bm.stok = '1' AND bm.id = '$id'");
        return $query->result();
    }

    public function update_stok($nama_barang){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("UPDATE b_barang_masuk SET stok = '0' WHERE id = '$nama_barang'");
        return $query;
    }

    public function update_stokready($id){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("UPDATE b_barang_masuk SET stok = '1' WHERE id = '$id'");
        $query2 = $this->db->query("UPDATE b_barang_keluar SET is_retur = '1' WHERE id_stok = '$id'");
        return $query;
    }

    public function update_barangganti($id){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("UPDATE b_barang_masuk SET stok = '0' WHERE id = '$id'");
        return $query;
    }

    public function get_transaksikeluar($tanggal_transaksi){
        $query = $this->db->query("SELECT btk.id, btk.kode_transaksi,DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') AS tgl, btk.nama_pembeli FROM b_transaksi_keluar btk WHERE DATE(btk.tgl_act) = '$tanggal_transaksi'");
        // var_dump($tanggal_transaksi);
        // die();
        return $query->result();
    }

    public function get_barang_keluar($id){
        $query = $this->db->query("SELECT btk.kode_transaksi,btk.bayar,btk.potongan,bbk.id_stok,mb.nama_barang,ms.nama_satuan,m.nama_merk,bbk.tahun_barang,bbk.seri_barang,bbk.kode_bulan,
        bbk.kode_urut,bbk.harga_jual, btk.nama_pembeli,bbk.is_hutang,bbk.jns_penjualan,bbk.kualitas, DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') as tgl_act,DATE_FORMAT(btk.tgl_jatuhtempo,'%d-%m-%Y') as tgl_jatuhtempo FROM b_transaksi_keluar btk 
        JOIN b_barang_keluar bbk ON btk.kode_transaksi = bbk.kode_transaksi JOIN m_barang mb ON bbk.id_barang = mb.id 
        JOIN m_merk m ON bbk.id_merk = m.id JOIN m_satuan ms ON mb.satuan_barang = ms.id
        WHERE btk.id = '$id' AND bbk.is_retur IS NULL");
        return $query->result();
    }

    public function get_barang_keluar4($id){
        $query = $this->db->query("SELECT btk.kode_transaksi,btk.bayar,btk.potongan,bbk.id_stok,mb.nama_barang,ms.nama_satuan,m.nama_merk,bbk.tahun_barang,bbk.seri_barang,bbk.kode_bulan,
        bbk.kode_urut,bbk.harga_jual, btk.nama_pembeli,bbk.is_hutang,bbk.jns_penjualan,bbk.kualitas,bbk.is_retur, DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') as tgl_act,DATE_FORMAT(btk.tgl_jatuhtempo,'%d-%m-%Y') as tgl_jatuhtempo FROM b_transaksi_keluar btk 
        JOIN b_barang_keluar bbk ON btk.kode_transaksi = bbk.kode_transaksi JOIN m_barang mb ON bbk.id_barang = mb.id 
        JOIN m_merk m ON bbk.id_merk = m.id JOIN m_satuan ms ON mb.satuan_barang = ms.id
        WHERE btk.id = '$id'");
        return $query->result();
    }

    public function get_barang_retur($kd_transaksi, $id_barang){
        $query = $this->db->query("SELECT rtk.*,bbk.is_hutang,mb2.nama_barang AS barang_asli,ms2.nama_satuan AS satuan_asli,m2.nama_merk AS merk_asli,
        bbm2.tahun_barang AS tahun_asli,bbm2.seri_barang AS seri_asli,bbm2.kode_bulan AS bulan_asli,
        mb.nama_barang,ms.nama_satuan,m.nama_merk,bbm.tahun_barang,bbm.seri_barang,bbm.kode_bulan,bbm.kode_urut,bbm.kualitas
        FROM b_retur_keluar rtk JOIN b_barang_masuk bbm ON rtk.id_barang_ganti = bbm.id 
	    JOIN m_barang mb ON bbm.id_barang = mb.id 
        JOIN m_merk m ON bbm.id_merk = m.id JOIN m_satuan ms ON mb.satuan_barang = ms.id
        JOIN b_barang_masuk bbm2 ON rtk.id_barang = bbm2.id JOIN m_barang mb2 ON bbm2.id_barang = mb2.id 
        JOIN m_merk m2 ON bbm2.id_merk = m2.id JOIN m_satuan ms2 ON mb2.satuan_barang = ms2.id
        JOIN b_barang_keluar bbk ON rtk.id_transaksi = bbk.id
         WHERE kd_transaksi = '$kd_transaksi' AND rtk.id_barang = '$id_barang'");
        return $query->result();
    }

    public function insert_retur_supplier($kd_transaksi,$nama_supplier,$kode_transaksimasuk,$id_transaksimasuk,$id_barang,$harga_masuk,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_retur_masuk VALUES('','$kd_transaksi','$id_transaksimasuk','$kode_transaksimasuk','$id_barang','$nama_supplier','$harga_masuk','$id_user','$tgl')");
        return $query;
    }

    public function get_retursupplier($tanggal_transaksi){
        $query = $this->db->query("SELECT bts.id, bts.kd_retur,DATE_FORMAT(bts.tgl_retur,'%d-%m-%Y') AS tgl,r.nama_rekanan FROM b_retur_masuk bts JOIN m_rekanan r on bts.id_supplier = r.id WHERE DATE(bts.tgl_retur) = '$tanggal_transaksi' GROUP BY bts.kd_retur");
        return $query->result();
    }

    public function getkoderetursupplier($bulan,$tahun){
        $query = $this->db->query("SELECT COUNT(id) as jumlah FROM b_retur_masuk WHERE MONTH(tgl_retur) = '$bulan' AND YEAR(tgl_retur) = '$tahun'");
        return $query->result();
    }

    public function get_barang_keluar2($id){
        $query = $this->db->query("SELECT btk.kode_transaksi,bbk.id_stok,mb.nama_barang,ms.nama_satuan,m.nama_merk,bbk.tahun_barang,bbk.seri_barang,bbk.kode_bulan,
        bbk.kode_urut,bbk.harga_jual, btk.nama_pembeli, DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') as tgl_act FROM b_transaksi_keluar btk 
        JOIN b_barang_keluar bbk ON btk.kode_transaksi = bbk.kode_transaksi JOIN m_barang mb ON bbk.id_barang = mb.id 
        JOIN m_merk m ON bbk.id_merk = m.id JOIN m_satuan ms ON mb.satuan_barang = ms.id
        WHERE btk.id = '$id' AND bbk.is_retur IS NULL");
        return $query->result();
    }

    public function get_barang_keluar3($id){
        $query = $this->db->query("SELECT bbk.id as id_trans,btk.kode_transaksi,bbk.id,mb.nama_barang,ms.nama_satuan,m.nama_merk,bbk.tahun_barang,bbk.seri_barang,bbk.kode_bulan,
        bbk.kode_urut,bbk.harga_jual, btk.nama_pembeli, DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') as tgl_act FROM b_transaksi_keluar btk 
        JOIN b_barang_keluar bbk ON btk.kode_transaksi = bbk.kode_transaksi JOIN m_barang mb ON bbk.id_barang = mb.id 
        JOIN m_merk m ON bbk.id_merk = m.id JOIN m_satuan ms ON mb.satuan_barang = ms.id
        WHERE bbk.id_stok = '$id' AND is_retur IS NULL");
        return $query->result();
    }

    public function getkodereturstok($bulan,$tahun){
        $query = $this->db->query("SELECT COUNT(id) as jumlah FROM b_retur_keluar WHERE MONTH(tgl_retur) = '$bulan' AND YEAR(tgl_retur) = '$tahun'");
        return $query->result();
    }

    public function insert_retur_stok($kd_transaksi,$id_keluar,$kode_transkeluar,$id_barang,$nama_pembeli,$harga_jual,$id_user,$alasan,$barang_ganti){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_retur_keluar VALUES('','$kd_transaksi','$id_keluar','$kode_transkeluar','$id_barang','$nama_pembeli','$harga_jual','$alasan','$barang_ganti','$id_user','$tgl')");
        return $query;
    }

    public function get_datareturstok($tanggal_transaksi){
        $query = $this->db->query("SELECT btk.id, btk.kd_retur,DATE_FORMAT(btk.tgl_retur,'%d-%m-%Y') AS tgl, btk.nama_pembeli,u.nama_user FROM b_retur_keluar btk JOIN a_user u on btk.user_act = u.id WHERE DATE(btk.tgl_retur) = '$tanggal_transaksi'");
        // var_dump($tanggal_transaksi);
        // die();
        return $query->result();
    }

    public function get_datahutang($tanggal_transaksi){
        $tgl = explode('-', $tanggal_transaksi);
        $bulan = $tgl[0];
        $tahun = $tgl[1];
        $query = $this->db->query("SELECT btk.id, btk.kode_transaksi,DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') AS tgl,DATE_FORMAT(btk.tgl_jatuhtempo,'%d-%m-%Y') AS tgl_jatuhtempo, btk.nama_pembeli,btk.is_lunas,btk.is_hutang FROM b_transaksi_keluar btk WHERE MONTH(btk.tgl_act) = '$bulan' AND YEAR(btk.tgl_act) = '$tahun'");
        // var_dump($tanggal_transaksi);
        // die();
        return $query->result();
    }

    public function get_data_hutang($kode_transaksi){
        $query = $this->db->query("SELECT btk.potongan,btk.bayar,btk.kode_transaksi,bbk.id_stok,mb.nama_barang,ms.nama_satuan,m.nama_merk,bbk.tahun_barang,bbk.seri_barang,bbk.kode_bulan, 
        bbk.kode_urut,bbk.harga_jual, btk.nama_pembeli,bbk.is_hutang,bbk.is_retur,bbk.is_klaim, DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') AS tgl_act 
        FROM b_transaksi_keluar btk JOIN b_barang_keluar bbk ON btk.kode_transaksi = bbk.kode_transaksi 
        JOIN m_barang mb ON bbk.id_barang = mb.id JOIN m_merk m ON bbk.id_merk = m.id JOIN m_satuan ms ON mb.satuan_barang = ms.id 
        WHERE bbk.kode_transaksi = '$kode_transaksi'");
        // var_dump($tanggal_transaksi);
        // die();
        return $query->result();
    }

    public function get_list_hutang($kode_transaksi){
        $query = $this->db->query("SELECT bth.*, u.nama_user,DATE_FORMAT(bth.tgl_act,'%d-%m-%Y %H:%i:%s') AS tgl  FROM b_transaksi_hutang bth JOIN a_user u ON bth.user_act = u.id WHERE bth.kode_transaksi = '$kode_transaksi'");
        // var_dump($tanggal_transaksi);
        // die();
        return $query->result();
    }

    public function bayar_awal($kode_transaksi){
        $query = $this->db->query("SELECT * FROM b_transaksi_keluar WHERE kode_transaksi = '$kode_transaksi'");
        return $query->result();
    }

    public function insert_hutang($kode_hutang,$kode_transaksi,$nama_pembeli,$akan_bayar,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_transaksi_hutang VALUES('','$kode_hutang','$kode_transaksi','$nama_pembeli','$akan_bayar','$id_user','$tgl')");
        return $query;
    }

    public function update_hutang($kode_transaksi){
        $tgl = date('Y-m-d H:i:s');
        $data = array(
            'is_lunas' => '1',
            'is_hutang' => '0'
         );
         
         $this->db->where('kode_transaksi', $kode_transaksi);
         $query = $this->db->update('b_transaksi_keluar', $data);

        return $query;
    }

    public function getkodehutang($bulan,$tahun){
        $query = $this->db->query("SELECT COUNT(id) as jumlah FROM b_transaksi_hutang WHERE MONTH(tgl_act) = '$bulan' AND YEAR(tgl_act) = '$tahun'");
        return $query->result();
    }

    public function get_retur_stok($id){
        // echo $id;
        // $test = "SELECT * FROM b_retur_keluar WHERE id = '$id'";
        // echo $test;
        $getkdtrans = $this->db->query("SELECT * FROM b_retur_keluar WHERE id = '$id'");
        // dd($getkdtrans);
        foreach($getkdtrans->result() as $rw):
            $kd_transaksi = $rw -> kd_transaksi;
            $id_barangganti = $rw -> id_barang_ganti;
            // dd($rw);
        endforeach;
        if($id_barangganti == 0){
            $tambahquer = "";
            $tampilquer = "";
        }else{
            $tambahquer = "JOIN b_barang_masuk bbm ON brk.`id_barang_ganti` = bbm.`id` JOIN m_barang mb2 ON bbm.`id_barang` = mb2.`id`";
            $tampilquer = ",mb2.`nama_barang` nama_barangganti,bbm.`kode_bulan` kode_bulanganti
            ,bbm.`kode_urut` kode_urutganti,bbm.`tahun_barang` tahun_barangganti";
        }
        $query = $this -> db -> query("SELECT brk.*,bbk.*,mb.`nama_barang` AS nama_barangasli $tampilquer FROM b_retur_keluar brk 
        INNER JOIN b_barang_keluar bbk ON brk.`id_transaksi` =  bbk.`id`
         JOIN m_barang mb ON bbk.`id_barang` = mb.id $tambahquer
        WHERE brk.`kd_transaksi` = '$kd_transaksi' GROUP BY brk.id");
       return $query->result();
    }

    public function get_dataklaim($tanggal_transaksi){
        $tgl = explode('-', $tanggal_transaksi);
        $bulan = $tgl[0];
        $tahun = $tgl[1];
        $query = $this->db->query("SELECT btk.id, btk.kode_transaksi,DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') AS tgl,DATE_FORMAT(btk.tgl_batasklaim,'%d-%m-%Y') AS tgl_batasklaim, btk.nama_pembeli FROM b_transaksi_keluar btk WHERE MONTH(btk.tgl_act) = '$bulan' AND YEAR(btk.tgl_act) = '$tahun'");
        // var_dump($tanggal_transaksi);
        // die();
        return $query->result();
    }

    public function get_data_klaim($kode_transaksi){
        $query = $this->db->query("SELECT btk.potongan,btk.bayar,btk.kode_transaksi,bbk.id as id_keluar,bbk.id_stok,mb.nama_barang,ms.nama_satuan,m.nama_merk,bbk.tahun_barang,bbk.seri_barang,bbk.kode_bulan, 
        bbk.kode_urut,bbk.harga_jual, btk.nama_pembeli,bbk.is_hutang,bbk.is_retur,bbk.is_klaim, DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') AS tgl_act 
        FROM b_transaksi_keluar btk JOIN b_barang_keluar bbk ON btk.kode_transaksi = bbk.kode_transaksi 
        JOIN m_barang mb ON bbk.id_barang = mb.id JOIN m_merk m ON bbk.id_merk = m.id JOIN m_satuan ms ON mb.satuan_barang = ms.id 
        WHERE bbk.kode_transaksi = '$kode_transaksi'");
        // var_dump($tanggal_transaksi);
        // die();
        return $query->result();
    }

    public function get_list_klaim($kode_transaksi){
        $query = $this->db->query("SELECT bkg.*,bbk1.id_stok as id_stok1 ,mb1.nama_barang as nama_barang1 ,m1.nama_merk as nama_merk1 ,bbk1.tahun_barang as tahun_barang1 ,bbk1.seri_barang as seri_barang1 ,bbk1.kode_bulan as kode_bulan1 , 
        bbk1.kode_urut as kode_urut1 ,bbk1.harga_jual as harga_jual1 ,bbk2.id_stok as id_stok2 ,mb2.nama_barang as nama_barang2 ,m2.nama_merk as nama_merk2 ,bbk2.tahun_barang as tahun_barang2 ,bbk2.seri_barang as seri_barang2 ,bbk2.kode_bulan as kode_bulan2 , 
        bbk2.kode_urut as kode_urut2,bbk2.harga_jual as harga_jual2 , u.nama_user,DATE_FORMAT(bkg.tgl_klaim,'%d-%m-%Y %H:%i:%s') AS tgl  FROM b_klaim_barang bkg JOIN a_user u ON bkg.user_act = u.id JOIN b_barang_keluar bbk1 ON bbk1.id = bkg.id_barang_lama JOIN b_barang_keluar bbk2 ON bbk2.id_stok = bkg.id_barang_ganti JOIN m_barang mb1 ON bbk1.id_barang = mb1.id JOIN m_merk m1 ON bbk1.id_merk = m1.id JOIN m_barang mb2 ON bbk2.id_barang = mb2.id JOIN m_merk m2 ON bbk2.id_merk = m2.id WHERE bkg.kode_transaksi = '$kode_transaksi'");
        // var_dump($tanggal_transaksi);
        // die();
        return $query->result();
    }

    public function getkodeklaim($bulan,$tahun){
        $query = $this->db->query("SELECT COUNT(id) as jumlah FROM b_klaim_barang WHERE MONTH(tgl_klaim) = '$bulan' AND YEAR(tgl_klaim) = '$tahun'");
        return $query->result();
    }

    public function insert_klaim($kode_klaim,$kd_trans,$nama_pembeli,$id_baranglama,$alasan_klaim,$pil_brgtukar,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_klaim_barang VALUES('','$kode_klaim','$kd_trans','$nama_pembeli','$id_baranglama','$alasan_klaim','$pil_brgtukar','$id_user','$tgl')");
        return $query;
    }

    public function update_brgklaimlama($id_barangkeluar){
        $tgl = date('Y-m-d H:i:s');
        $data = array(
            'is_klaim' => '1',
         );
         
         $this->db->where('id', $id_barangkeluar);
         $query = $this->db->update('b_barang_keluar', $data);

        return $query;
    }

    public function get_hutang($id){
        $query = $this->db->query("SELECT bth.*, u.nama_user,DATE_FORMAT(bth.tgl_act,'%d-%m-%Y %H:%i:%s') AS tgl ,
        DATE_FORMAT(btk.tgl_act,'%d-%m-%Y %H:%i:%s') AS tgl_transaksi, 
        DATE_FORMAT(btk.tgl_jatuhtempo,'%d-%m-%Y') AS tgl_jatuhtempo
        FROM b_transaksi_hutang bth JOIN b_transaksi_keluar btk ON bth.kode_transaksi = btk.kode_transaksi
         JOIN a_user u ON bth.user_act = u.id 
        WHERE bth.id = '$id'");
        return $query -> result();
    }

    public function update_brgkeluar($id,$nama_barang,$nama_merk,$tahun_barang,$seri_barang,$kode_bulan,$kode_urut,$jenis_brg,$kualitas,$harga_masuk){
        $tgl = date('Y-m-d H:i:s');
        $data = array(
            'id_barang' => $nama_barang,
            'id_merk' => $nama_merk,
            'tahun_barang' => $tahun_barang,
            'seri_barang' => $seri_barang,
            'kode_bulan' => $kode_bulan,
            'kode_urut' => $kode_urut,
            'kualitas'  => $kualitas,
            'harga_masuk' => $harga_masuk,
         );
         
         $this->db->where('id_stok', $id);
         $query = $this->db->update('b_barang_keluar', $data);

        return $query;
    }


    public function update_brgmasuk($id,$nama_barang,$nama_merk,$tahun_barang,$seri_barang,$kode_bulan,$kode_urut,$jenis_brg,$kualitas,$harga_masuk){
        $tgl = date('Y-m-d H:i:s');
        $data = array(
            'id_barang' => $nama_barang,
            'id_merk' => $nama_merk,
            'tahun_barang' => $tahun_barang,
            'seri_barang' => $seri_barang,
            'kode_bulan' => $kode_bulan,
            'kode_urut' => $kode_urut,
            'jenis_barang' => $jenis_brg,
            'kualitas' => $kualitas,
            'harga_barang' => $harga_masuk,
         );
         
         $this->db->where('id', $id);
         $query = $this->db->update('b_barang_masuk', $data);

        return $query;
    }


}