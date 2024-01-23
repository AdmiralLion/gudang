<?php
class m_login extends CI_Model {

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

    public function ceklogin($username,$password){
        $query = $this->db->query("SELECT * FROM a_user WHERE username = '$username' AND passwd = '$password'");
        // var_dump($query);
        return $query->result();
    }

    public function getuser($id_user){
        $query = $this->db->query("SELECT * FROM a_user WHERE id = '$id_user'");
        return $query->result();
    }
    
    function getpoliAll()
    {
        $query = $this->db->query("SELECT * FROM b_ms_unit WHERE parent_id = '1' AND aktif = '1'");
            return $query->result();
    }

    public function getkunjungan($tgldari,$tglke)
    {
        $query = $this->db->query("SELECT bk.id, bk.tgl_act,bk.tgl_pulang, peg.nama as nama_dokter,peg.nik as nik_dokter, bmp.nama as nama_px,bmp.no_ktp,bmp.no_rm, mu.nama as nama_unit,mu.ihs_id FROM b_kunjungan bk LEFT JOIN b_ms_pasien AS bmp ON bk.pasien_id = bmp.id
        LEFT JOIN b_pelayanan bp ON bk.id = bp.kunjungan_id LEFT JOIN b_ms_pegawai peg ON bp.dokter_id = peg.id LEFT JOIN b_ms_unit mu ON bp.unit_id = mu.id
     WHERE bk.jenis_layanan = '1' AND mu.nama LIKE '%Poli%' AND bk.tgl BETWEEN '$tgldari' AND '$tglke'");
        return $query->result();
    }

    public function getdokter ($user_act)
    {
        $query = $this -> db-> query("SELECT * FROM b_ms_pegawai WHERE id = '$user_act'");
        return $query->result();
    }

    public function getdiagnosa($kunjungan_id)
    {
        $query = $this->db->query("SELECT bd.*, bmd.nama,bmd.kode FROM b_diagnosa bd JOIN b_ms_diagnosa bmd ON bd.ms_diagnosa_id = bmd.id WHERE kunjungan_id = '$kunjungan_id'");
        return $query->result();
    }

    public function getsoapid($kunjungan_id)
    {
        $query = $this->db->query("SELECT * FROM b_soap WHERE kunjungan_id = '$kunjungan_id'");
        return $query->result();
    }


    public function getobservasi($soap_id)
    {
        $query = $this->db->query("SELECT tekanan,nadi,suhu,nafas,spo2,bb FROM soap_obj WHERE soap_id = '$soap_id'");
        return $query->result();
    }

    public function getobservasi2($kunjungan_id)
    {
        $query = $this->db->query("SELECT assesment_id,tekanan,nadi,suhu,nafas,bb,user_act,tgl_assesment FROM b_assesment_lanjut WHERE kunjungan_id = '$kunjungan_id'");
        return $query->result();
    }

    public function insertenclog($kunjungan_id,$tampungresult){
        $query = $this->db->query("INSERT INTO b_log_encounter VALUES('','$kunjungan_id','$tampungresult')");
        return $query;
    }

    public function insertencounter($kunjungan_id,$encounter_id){
        $tglskrg = date('Y-m-d H:i:s');
        $query = $this->db4->query("INSERT INTO encounter VALUES('','$encounter_id','$kunjungan_id','$tglskrg','')");
        return $query;
    }

    public function getencounter($kunjungan_id)
    {
        $query = $this->db4->query("SELECT * FROM encounter WHERE kunjungan_id = '$kunjungan_id'");
        return $query->result();
    }

    public function insertcondition($kunjungan_id,$encounter_id,$condition_id,$diagnosa_id){
        $tglskrg = date('Y-m-d H:i:s');
        $query = $this->db4->query("INSERT INTO conditions VALUES('','$condition_id','$encounter_id','$kunjungan_id','$diagnosa_id','$tglskrg','')");
        return $query;
    }

    public function insertobservation($kunjungan_id,$encounter_id,$observation_id,$assesment_id,$jenis_observation){
        $tglskrg = date('Y-m-d H:i:s');
        $query = $this->db4->query("INSERT INTO observation VALUES('','$observation_id','$encounter_id','$kunjungan_id','$assesment_id','$jenis_observation','$tglskrg','')");
        return $query;
    }

    public function gettindakan($kunjungan_id)
    {
        $query = $this->db->query("SELECT t.id,t.user_act,t.tgl_act,nama, kode_icd9cm FROM b_tindakan t JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id = mtk.id 
        JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id = mt.id WHERE kunjungan_id = '$kunjungan_id' AND nama NOT IN('Karcis Poli','Karcis BPJS','Jasa Dokter Spesialis BPJS')");
        return $query->result();
    }

    public function gettindakan2($kunjungan_id)
    {
        $query = $this->db->query("SELECT k.id,md.nama as nama_diag, md.kode ,t.id as tindakan_id,t.user_act,t.tgl_act, mt.nama as nama_tind, kode_icd9cm FROM b_kunjungan k JOIN b_diagnosa d ON k.id = d.kunjungan_id 
        JOIN b_ms_diagnosa md ON d.ms_diagnosa_id = md.id
        JOIN b_tindakan t ON k.id = t.kunjungan_id JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id = mtk.id 
        JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id = mt.id WHERE k.id = '$kunjungan_id' AND mt.nama NOT IN('Karcis Poli','Karcis BPJS','Jasa Dokter Spesialis BPJS','Jasa Dokter Spesialis')");
        return $query->result();
    }

    public function insertprocedure($kunjungan_id,$encounter_id,$procedure_id,$tindakan_id,$nama_tindakan){
        $tglskrg = date('Y-m-d H:i:s');
        $query = $this->db4->query("INSERT INTO procedures VALUES('','$procedure_id','$encounter_id','$kunjungan_id','$tindakan_id','$nama_tindakan','$tglskrg','')");
        return $query;
    }

    public function getdiagnosa2($kunjungan_id)
    {
        $query = $this->db->query("SELECT bd.*, bmd.nama,bmd.kode FROM b_diagnosa bd JOIN b_ms_diagnosa bmd ON bd.ms_diagnosa_id = bmd.id WHERE kunjungan_id = '$kunjungan_id' ORDER BY primer DESC");
        return $query->result();
    }

    public function log_bundle($kunjungan_id, $uuid_encounter,$uuid_nadi,$uuid_suhu,$uuid_sistole,$uuid_diastole,$uuid_nafas,$assesment_id)
    {
        $tglskrg = date('Y-m-d H:i:s');
        $query_enc = $this->db4->query("INSERT INTO encounter VALUES('','$uuid_encounter','$kunjungan_id','$tglskrg','')");
        $query_nadi = $this->db4->query("INSERT INTO observation VALUES('','$uuid_nadi','$uuid_encounter','$kunjungan_id','$assesment_id','Denyut Jantung','$tglskrg','')");
        $query_suhu = $this->db4->query("INSERT INTO observation VALUES('','$uuid_suhu','$uuid_encounter','$kunjungan_id','$assesment_id','Suhu tubuh','$tglskrg','')");
        $query_sistole = $this->db4->query("INSERT INTO observation VALUES('','$uuid_sistole','$uuid_encounter','$kunjungan_id','$assesment_id','Sistole','$tglskrg','')");
        $query_diastole = $this->db4->query("INSERT INTO observation VALUES('','$uuid_diastole','$uuid_encounter','$kunjungan_id','$assesment_id','Diastole','$tglskrg','')");
        $query_nafas = $this->db4->query("INSERT INTO observation VALUES('','$uuid_nafas','$uuid_encounter','$kunjungan_id','$assesment_id','Pernafasan','$tglskrg','')");

        return $query_enc;
    }
}