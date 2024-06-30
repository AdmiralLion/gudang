<?php
class m_laporan extends CI_Model {

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
        $query = $this->db->query("INSERT INTO b_barang_masuk VALUES('','$kd_transaksi','$nama_barang','$nama_merk','$tahun_barang','$seri_barang','$kode_bulan','$kode_urut','$harga_masuk','$id_user',1,'$tgl')");
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

    public function get_stok($tgl_stok){
        $tgl = explode('-', $tgl_stok);
        $bulan = $tgl[0];
        $tahun = $tgl[1];
        $query = $this->db->query("SELECT btm.kode_transaksi, mb.nama_barang, ms.nama_satuan, m.nama_merk, bbm.tahun_barang, bbm.seri_barang, 
        bbm.kode_bulan, bbm.kode_urut, bbm.harga_barang, DATE_FORMAT(btm.tgl_act,'%d-%m-%Y') AS tgl_transaksi, mr.nama_rekanan, bbm.stok 
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

    public function insert_transaksi_keluar($kd_transaksi,$nama_pembeli,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_transaksi_keluar VALUES('','$kd_transaksi','$nama_pembeli','$id_user','$tgl')");
        return $query;
    }

    public function insert_barang_keluar($kd_transaksi,$id_stok,$id_barang,$id_merk,$tahun_barang,$seri_barang,$kode_bulan,$kode_urut,$harga_masuk,$harga_keluar,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_barang_keluar VALUES('','$kd_transaksi','$id_stok','$id_barang','$id_merk','$tahun_barang','$seri_barang','$kode_bulan','$kode_urut','$harga_masuk',$harga_keluar,null,'$id_user','$tgl')");
        return $query;
    }

    public function get_detailbarang_keluar($id){
        $query = $this->db->query("SELECT b.id id_barang,bm.kode_transaksi,bm.id id_transaksi, m.id id_merk, b.nama_barang,m.nama_merk,bm.tahun_barang,bm.seri_barang,bm.kode_bulan,bm.kode_urut,bm.harga_barang
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

    public function get_transaksikeluar($tanggal_transaksi){
        $query = $this->db->query("SELECT btk.id, btk.kode_transaksi,DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') AS tgl, btk.nama_pembeli FROM b_transaksi_keluar btk WHERE DATE(btk.tgl_act) = '$tanggal_transaksi'");
        // var_dump($tanggal_transaksi);
        // die();
        return $query->result();
    }

    public function get_barang_keluar($id){
        $query = $this->db->query("SELECT btk.kode_transaksi,bbk.id_stok,mb.nama_barang,ms.nama_satuan,m.nama_merk,bbk.tahun_barang,bbk.seri_barang,bbk.kode_bulan,
        bbk.kode_urut,bbk.harga_jual, btk.nama_pembeli, DATE_FORMAT(btk.tgl_act,'%d-%m-%Y') as tgl_act FROM b_transaksi_keluar btk 
        JOIN b_barang_keluar bbk ON btk.kode_transaksi = bbk.kode_transaksi JOIN m_barang mb ON bbk.id_barang = mb.id 
        JOIN m_merk m ON bbk.id_merk = m.id JOIN m_satuan ms ON mb.satuan_barang = ms.id
        WHERE btk.id = '$id'");
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
        $query = $this->db->query("SELECT btk.kode_transaksi,bbk.id_stok,mb.nama_barang,ms.nama_satuan,m.nama_merk,bbk.tahun_barang,bbk.seri_barang,bbk.kode_bulan,
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

    public function insert_retur_stok($kd_transaksi,$kode_transkeluar,$id_barang,$nama_pembeli,$harga_jual,$id_user){
        $tgl = date('Y-m-d H:i:s');
        $query = $this->db->query("INSERT INTO b_retur_keluar VALUES('','$kd_transaksi','$kode_transkeluar','$id_barang','$nama_pembeli','$harga_jual','$id_user','$tgl')");
        return $query;
    }

    public function get_datareturstok($tanggal_transaksi){
        $query = $this->db->query("SELECT btk.id, btk.kd_retur,DATE_FORMAT(btk.tgl_retur,'%d-%m-%Y') AS tgl, btk.nama_pembeli,u.nama_user FROM b_retur_keluar btk JOIN a_user u on btk.user_act = u.id WHERE DATE(btk.tgl_retur) = '$tanggal_transaksi'");
        // var_dump($tanggal_transaksi);
        // die();
        return $query->result();
    }

    public function lap_barang_masuk($jangka_waktu, $tgl){
        if($jangka_waktu == 'Harian'){
            $tambahanquer = "DATE(bm.tgl_act) ='".$tgl."'";
        }else{
            $tgls = explode('-', $tgl);
            $bulan = $tgls[0];
            $tahun = $tgls[1];
            $tambahanquer = "MONTH(bm.tgl_act) = '".$bulan."' AND YEAR(bm.tgl_act) = '".$tahun."'";
        }
        $query = $this->db->query("SELECT bm.`kode_transaksi`,b.nama_barang,m.nama_merk,bm.tahun_barang,bm.seri_barang,bm.kode_bulan,bm.kode_urut,bm.jenis_barang,
        bm.harga_barang,u.`nama_user`,DATE_FORMAT(bm.tgl_act,'%d-%m-%Y %H:%i:%s') AS tgl 
        FROM b_barang_masuk bm INNER JOIN m_barang b ON bm.id_barang = b.id INNER JOIN m_merk m ON bm.id_merk = m.id
        INNER JOIN a_user u ON bm.`user_act` = u.`id` WHERE $tambahanquer");
        return $query->result();

    }

    public function lap_barang_keluar($jangka_waktu, $tgl){
       if($jangka_waktu == 'Harian'){
            $tambahanquer = "DATE(bbk.tgl_act) ='".$tgl."'";
        }else{
            $tgls = explode('-', $tgl);
            $bulan = $tgls[0];
            $tahun = $tgls[1];
            $tambahanquer = "MONTH(bbk.tgl_act) ='".$bulan."' AND YEAR(bbk.tgl_act) = '".$tahun."'";
        }
        $query = $this->db->query("SELECT bbk.`kode_transaksi`,b.nama_barang,m.nama_merk,bbk.tahun_barang,bbk.seri_barang,bbk.kode_bulan,bbk.kode_urut,bbk.kualitas,
        bbm.`harga_barang`,bbk.harga_jual,u.`nama_user`,is_retur,bbk.is_hutang,DATE_FORMAT(bbk.tgl_act,'%d-%m-%Y %H:%i:%s') AS tgl 
        FROM b_barang_keluar bbk 
        INNER JOIN b_barang_masuk bbm ON bbk.`id_stok` = bbm.`id`
        INNER JOIN m_barang b ON bbk.id_barang = b.id 
        INNER JOIN m_merk m ON bbk.id_merk = m.id INNER JOIN a_user u ON bbk.`user_act` = u.`id` WHERE bbk.is_retur IS NULL AND $tambahanquer ORDER BY bbk.tgl_act ASC" );
        return $query->result();
    }

    public function lap_retur_supplier($jangka_waktu, $tgl){
        if($jangka_waktu == 'Harian'){
            $tambahanquer = "DATE(tgl_retur) ='".$tgl."'";
        }else{
            $tgls = explode('-', $tgl);
            $bulan = $tgls[0];
            $tahun = $tgls[1];
            $tambahanquer = "MONTH(tgl_retur) ='".$bulan."' AND YEAR(tgl_retur) = '".$tahun."'";
        }
        $query = $this->db->query("SELECT kd_retur,kd_transaksi, b.nama_barang,bm.tahun_barang,bm.seri_barang,bm.kode_bulan,bm.kode_urut,m.nama_merk,
        bm.harga_barang,u.`nama_user`,tgl_retur,bm.tgl_act AS tgl_masuk FROM b_retur_masuk rm 
        INNER JOIN b_barang_masuk bm ON rm.id_transaksi = bm.id
        INNER JOIN m_barang b ON rm.id_barang = b.id
        INNER JOIN m_merk m ON bm.id_merk = m.id
         INNER JOIN m_rekanan r ON rm.id_supplier = r.id
        INNER JOIN a_user u ON rm.`user_act` = u.`id` WHERE $tambahanquer");
        return $query->result();
    }

    public function lap_retur_penjualan($jangka_waktu, $tgl){
        if($jangka_waktu == 'Harian'){
            $tambahanquer = "DATE(tgl_retur) ='".$tgl."'";
        }else{
            $tgls = explode('-', $tgl);
            $bulan = $tgls[0];
            $tahun = $tgls[1];
            $tambahanquer = "MONTH(tgl_retur) ='".$bulan."' AND YEAR(tgl_retur) = '".$tahun."'";
        }
        $query = $this->db->query("SELECT rk.*,bk.*,b.`nama_barang` AS nama_barangasli,mb2.`nama_barang` nama_barangganti,bbm.`kode_bulan` kode_bulanganti
        ,bbm.`kode_urut` kode_urutganti,bbm.`tahun_barang` tahun_barangganti,
                bk.harga_jual,u.`nama_user`,tgl_retur,bk.tgl_act AS tgl_keluar FROM b_retur_keluar rk 
                JOIN b_barang_keluar bk ON rk.id_transaksi = bk.id
                JOIN b_barang_masuk bbm ON rk.`id_barang_ganti` = bbm.`id` 
                JOIN m_barang mb2 ON bbm.`id_barang` = mb2.`id`
                INNER JOIN m_barang b ON bk.id_barang = b.id 
                INNER JOIN m_merk m ON bk.id_merk = m.id
                INNER JOIN a_user u ON rk.`user_act` = u.`id`  WHERE $tambahanquer");
        return $query->result();
    }

    public function lap_penghasilan($jangka_waktu, $tgl){
        if($jangka_waktu == 'Harian'){
            $tambahanquer = "DATE(bbk.tgl_act) ='".$tgl."'";
        }else{
            $tgls = explode('-', $tgl);
            $bulan = $tgls[0];
            $tahun = $tgls[1];
            $tambahanquer = "MONTH(bbk.tgl_act) ='".$bulan."' AND YEAR(bbk.tgl_act) = '".$tahun."'";
        }
        $query = $this->db->query("SELECT  btk.bayar,btk.potongan,bbk.`kode_transaksi`,b.nama_barang,m.nama_merk,bbk.tahun_barang,bbk.seri_barang,bbk.kode_bulan,bbk.kode_urut,
        bbk.harga_jual,bbk.harga_masuk,u.`nama_user`,DATE_FORMAT(btk.tgl_act,'%d-%m-%Y %H:%i:%s') AS tgl FROM b_transaksi_keluar btk JOIN b_barang_keluar bbk ON btk.kode_transaksi = bbk.kode_transaksi
        INNER JOIN m_barang b ON bbk.id_barang = b.id 
        INNER JOIN m_merk m ON bbk.id_merk = m.id INNER JOIN a_user u ON bbk.`user_act` = u.`id`
        WHERE bbk.is_retur IS NULL AND $tambahanquer");
        return $query->result();
    }

    public function lap_pembayaran_hutang($jangka_waktu, $tgl){
        if($jangka_waktu == 'Harian'){
            $tambahanquer = "DATE(bth.tgl_act) ='".$tgl."'";
        }else{
            $tgls = explode('-', $tgl);
            $bulan = $tgls[0];
            $tahun = $tgls[1];
            $tambahanquer = "MONTH(bth.tgl_act) ='".$bulan."' AND YEAR(bth.tgl_act) = '".$tahun."'";
        }
        $query = $this->db->query("SELECT bth.*, 
        btk.tgl_jatuhtempo,btk.is_lunas, 
        (SELECT SUM(bb.harga_jual)
         FROM b_barang_keluar bb
         WHERE bb.kode_transaksi = bth.kode_transaksi
        ) AS total_hutang,u.`nama_user` FROM b_transaksi_hutang bth LEFT JOIN b_transaksi_keluar btk ON bth.kode_transaksi = btk.kode_transaksi INNER JOIN a_user u ON bth.`user_act` = u.`id` WHERE $tambahanquer GROUP BY bth.id ");
        return $query->result();
    }
   
    public function lap_jatuh_tempo($jangka_waktu, $tgl){
        if($jangka_waktu == 'Harian'){
            $tambahanquer = "DATE(btk.tgl_jatuhtempo) ='".$tgl."'";
        }else{
            $tgls = explode('-', $tgl);
            $bulan = $tgls[0];
            $tahun = $tgls[1];
            $tambahanquer = "MONTH(btk.tgl_jatuhtempo) ='".$bulan."' AND YEAR(btk.tgl_jatuhtempo) = '".$tahun."'";
        }
        $query = $this->db->query("SELECT btk.*,(SELECT SUM(bb.harga_jual)
        FROM b_barang_keluar bb
        WHERE bb.kode_transaksi = btk.kode_transaksi
       ) AS total_hutang,u.`nama_user` FROM b_transaksi_keluar btk INNER JOIN a_user u ON btk.`user_act` = u.`id` WHERE $tambahanquer");
        return $query->result();
    }
}