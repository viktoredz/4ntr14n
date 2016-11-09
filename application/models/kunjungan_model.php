<?php
class Kunjungan_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_data_pasien($start=0,$limit=999999,$options=array()){
        $this->db->select("id_kunjungan,app_users_profile.username,app_users_profile.nama,app_users_profile.jk,app_users_profile.phone_number,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lahir)), '%Y')+0 AS usia,kunjungan.status_antri,kunjungan.tgl,kunjungan.waktu,kunjungan.systolic,kunjungan.diastolic,kunjungan.keluhan,kunjungan.asuransi,kunjungan.code,kunjungan.rujuk,cl_asuransi.value as nama_asuransi,cl_poli.value as nama_poli,app_users_asuransi.value as no_asuransi,cl_clinic.value as nama_klinik",false);
        $this->db->join('app_users_profile','kunjungan.username = app_users_profile.username AND kunjungan.code = app_users_profile.code','inner');
        $this->db->join('cl_asuransi','kunjungan.asuransi = cl_asuransi.code AND cl_asuransi.klinik = kunjungan.code','left');
        $this->db->join('app_users_asuransi','kunjungan.asuransi = app_users_asuransi.code AND app_users_asuransi.klinik = kunjungan.code AND kunjungan.username=app_users_asuransi.username','left');
        $this->db->join('cl_poli','kunjungan.poli = cl_poli.id AND cl_poli.klinik = app_users_profile.code','inner');
        $this->db->join('cl_clinic','kunjungan.code = cl_clinic.code','inner');
        if($this->session->userdata('level')!='pasien'){
            $this->db->order_by('id_kunjungan','asc');
        }else{
            $this->db->order_by('id_kunjungan','desc');
        }
        $query = $this->db->get('kunjungan',$limit,$start);
        return $query->result();
    }

    function get_filter_pasien(){
        $filter = $this->input->post('nama');
		$code   = $this->input->post('klinik');
		
        $this->db->where("app_users_list.level","pasien");
        $this->db->where("app_users_profile.code",$code);
        $this->db->where("(app_users_profile.nama LIKE '%".$filter."%' OR app_users_profile.username LIKE '%".$filter."%')");
        $this->db->select("concat(app_users_profile.username,'</br>',app_users_profile.nama,', ' ,app_users_profile.jk, ' / ',DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lahir)), '%Y')+0,' Tahun') as nama,app_users_profile.nama as name,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lahir)), '%Y')+0 AS usia, app_users_profile.code, app_users_profile.username, app_users_profile.jk",false);
        $this->db->join("app_users_list","app_users_profile.username = app_users_list.username and app_users_profile.code=app_users_list.code","inner");
        $query = $this->db->get("app_users_profile",5,0);
        return $query->result();
    }
    
    function get_filter_asuransi(){
		$code = $this->input->post('code');
		$username   = $this->input->post('username');
		
        $this->db->where("app_users_asuransi.klinik",$code);
        $this->db->where("app_users_asuransi.username",$username);
        $this->db->select("app_users_asuransi.*,cl_asuransi.value as nama_asuransi",false);
        $this->db->join("cl_asuransi","cl_asuransi.klinik = app_users_asuransi.klinik and cl_asuransi.code = app_users_asuransi.code","inner");
        $query = $this->db->get("app_users_asuransi");
        return $query->result();
	}

    function get_pemeriksaan($id_kunjungan){
        $this->db->select("kunjungan.*,app_users_profile.nama,app_users_profile.jk,app_users_profile.phone_number,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lahir)), '%Y')+0 AS usia,cl_poli.value as nama_poli,cl_poli.code as code_poli,cl_asuransi.value as nama_asuransi,cl_clinic.value as nama_klinik",false);
        $this->db->join('app_users_profile','kunjungan.username = app_users_profile.username AND kunjungan.code = app_users_profile.code','inner');
        $this->db->join('cl_poli','kunjungan.poli = cl_poli.id AND cl_poli.klinik = app_users_profile.code','inner');
        $this->db->join('cl_asuransi','kunjungan.asuransi = cl_asuransi.code AND cl_asuransi.klinik = kunjungan.code','left');
        $this->db->join('cl_clinic','kunjungan.code = cl_clinic.code','inner');
        $this->db->order_by('id_kunjungan','asc');
        $this->db->where('kunjungan.id_kunjungan',$id_kunjungan);
        $query = $this->db->get('kunjungan');
        return $query->row_array();
    }

    function get_kunjungan($username=""){
        $data = array();
        $this->db->where("username",$username);
        $this->db->where("code",$this->session->userdata('klinik'));
        $this->db->where("status_antri","antri");
        $query = $this->db->get("kunjungan");
        if ($query->num_rows()>0) {
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function insert(){
        $this->db->select('MAX(id_kunjungan) as id');
        $this->db->where('substr(id_kunjungan,1,8)',$this->session->userdata('klinik'));
        $this->db->where('tgl',date("Y-m-d",strtotime($this->input->post('tgl'))));
        $id = $this->db->get('kunjungan')->row();
        if(!empty($id->id)){
            $tmp = intval(substr($id->id, -3))+1;
            $number = sprintf("%'.03d", $tmp);
        }else{
            $number="001";
        }
		
        $data['id_kunjungan']    = $this->session->userdata('klinik').date("Ymd",strtotime($this->input->post('tgl'))).$number;
        $data['username']        = $this->input->post('username');
        $data['poli']            = $this->input->post('poli');
        $data['asuransi']        = $this->input->post('asuransi');
        $data['code']            = $this->input->post('klinik');
        $data['status_antri']    = "antri";
        $data['tgl']             = date("Y-m-d",strtotime($this->input->post('tgl')));

        $this->db->where('username',$this->input->post('username'));
        $this->db->where('code',$this->input->post('klinik'));
        $this->db->where('poli',$this->input->post('poli'));
        $this->db->where('tgl',date("Y-m-d",strtotime($this->input->post('tgl'))));
        $this->db->where('substr(id_kunjungan,1,8)',$this->session->userdata('klinik'));
        $query = $this->db->get('kunjungan');

        if ($query->num_rows() > 0) {
            return 'false';
        }else{
            $this->db->insert('kunjungan', $data);
            return 'true';  
        }
    }

    function batal(){
        $data['status_antri']   = 'batal';

        $this->db->where('username',$this->input->post('username'));
        $this->db->where('code',$this->session->userdata('klinik'));
        $this->db->where('status_antri','antri');

        if ($this->db->update('kunjungan',$data)) {
            return true;
        }else{
            return false;  
        }
    }

    function simpan($id_kunjungan){
	    $data['waktu']          = $this->input->post('waktu');
        $data['tb']             = $this->input->post('tb');
        $data['bb']             = $this->input->post('bb');
        $data['bmi']            = $this->input->post('bmi');
        $data['kategori']       = $this->input->post('kategori');
        $data['systolic']       = $this->input->post('systolic');
        $data['diastolic']      = $this->input->post('diastolic');
        $data['pulse']          = $this->input->post('pulse');
        $data['respiratory_rate'] = $this->input->post('respiratory_rate');
        $data['temperature']    = $this->input->post('temperature');
        $data['kdsadar']        = $this->input->post('kdsadar');
        $data['cl_sdm_code']    = $this->input->post('cl_sdm_code');
        $data['keluhan']        = $this->input->post('keluhan');
        $data['terapi']         = $this->input->post('terapi');
        $data['edukasi']        = $this->input->post('edukasi');
        $data['ket']            = $this->input->post('ket');
        $data['status_pulang']  = $this->input->post('status_pulang');
        $data['status_antri']   = $this->input->post('status_antri');
        $data['username_op']    = $this->input->post('username_op');
        $data['status_updated'] = 0;

        $this->db->where('id_kunjungan',$id_kunjungan);
        
        if ($this->db->update('kunjungan',$data)) {
            return 'true';  
        }else{
            return 'false';
        }
    }

    function delete($id_kunjungan){
        return $this->db->delete('kunjungan', array('id_kunjungan' => $id_kunjungan));
    }
    
    function get_all_poli(){
		$this->db->where('status','1');
		$this->db->where('klinik',$this->session->userdata('klinik'));
		$this->db->order_by('id','asc');
		$query=$this->db->get('cl_poli');
		
		return $query->result();
	}
	
	function get_all_asuransi(){
		$this->db->where('klinik',$this->session->userdata('klinik'));
		$this->db->order_by('value','asc');
		$query=$this->db->get('cl_asuransi');
		
		return $query->result();
	}
	
	function get_all_klinik(){
		$this->db->order_by('value','asc');
		$query=$this->db->get('cl_clinic');
		
		return $query->result();
	}
	
	function get_poli_rujuk($rujuk){
		$this->db->select('value');
		$this->db->where('id',$rujuk);
		$this->db->where('klinik',$this->session->userdata('klinik'));
		$query=$this->db->get('cl_poli')->row_array();
		
		return $query['value'];
	}
	
	function get_sebelumnya($code="",$nik="",$tgl_kunjungan){
        $data = array();
        $this->db->where("code",$code);
        $this->db->where("username",$nik);
        $this->db->where("tgl <",$tgl_kunjungan);
        $this->db->where("status_antri","selesai");
        $query = $this->db->get("kunjungan");

        return $query->num_rows();
    }
    
     function get_dokter($cl_sdm_code=""){
        if($cl_sdm_code != ""){
            $this->db->where('code',$cl_sdm_code);
            $this->db->where('cl_clinic',$this->session->userdata('klinik'));
            $query = $this->db->get('bpjs_data_dokter')->row();
            if(!empty($query->value)){
                return $query->value;
            }else{
                return "";
            }
        }else{
            return "";
        }
    }
    
     function get_compelling($id_kunjungan){
        $this->db->select("jnc7_compelling.*,IF(kunjungan_compelling.id_compelling!='' , 1, 0) as checked",false);
        $this->db->join("kunjungan_compelling","kunjungan_compelling.id_compelling=jnc7_compelling.id_compelling AND kunjungan_compelling.id_kunjungan='".$id_kunjungan."'","left");
        $query = $this->db->get("jnc7_compelling");

        return $query->result_array();
    } 
    
    function get_kelainan($id_kunjungan){
        $this->db->where("id_kunjungan",$id_kunjungan);
        $query = $this->db->get("kunjungan_kelainan");

        return $query->result_array();
    }
    
    function get_signa(){
        $query = $this->db->get('cl_drug_signa');

        return $query->result_array();
    }
    
    function get_kontrol_tgl($id_kunjungan, $is_update){
        if($is_update == 1){

            $this->db->select('MIN(kunjungan_obat.dosis / cl_drug_signa.hari) as hari' , false);
            $this->db->where('id_kunjungan', $id_kunjungan);
            $this->db->join('cl_drug_signa', 'cl_drug_signa.code=kunjungan_obat.cl_drug_signa_code');
            $query = $this->db->get('kunjungan_obat')->row();

            if(empty($query->hari)){
                $kontrol_tgl = date("d-m-Y");
            }else{
                $hari = new DateTime();
                $plus = round($query->hari);
                $hari->modify('+'.$plus.' day');

                $kontrol_tgl = $hari->format('d-m-Y');
            }

            $data['kontrol_tgl'] = $kontrol_tgl = $hari->format('Y-m-d');
            $this->db->where('id_kunjungan',$id_kunjungan);
            $this->db->update('kunjungan_resume',$data);
        }else{
            $this->db->where('id_kunjungan',$id_kunjungan);
            $tgl = $this->db->get('kunjungan_resume')->row();
            if(!empty($tgl->kontrol_tgl)){
                $kontrol_tgl = $tgl->kontrol_tgl;        
            }else{
                $kontrol_tgl = date("Y-m-d");   
            }
        }

        return $kontrol_tgl;
    }
    
    function get_diagnosa($id_kunjungan){
        $this->db->select('kunjungan_icdx.*,cl_icdx.value');
        $this->db->where('id_kunjungan', $id_kunjungan);
        $this->db->join('cl_icdx', 'cl_icdx.code=kunjungan_icdx.code_icdx');
//        $this->db->join('cl_icdx', 'cl_icdx.code=kunjungan_icdx.code_icdx', $id_kunjungan);
        $query = $this->db->get('kunjungan_icdx');

        return $query->result();
    }
    
     function get_obat($id_kunjungan){
        $this->db->select('kunjungan_obat.*,cl_drug.nama,cl_drug.satuan,cl_drug_signa.value as signa');
        $this->db->where('id_kunjungan', $id_kunjungan);
        $this->db->where('cl_drug_stok.cl_clinic', $this->session->userdata('klinik'));
        $this->db->join('cl_drug', 'cl_drug.drug_id=kunjungan_obat.drug_id', $id_kunjungan);
        $this->db->join('cl_drug_signa', 'cl_drug_signa.code=kunjungan_obat.cl_drug_signa_code', $id_kunjungan);
        $this->db->join('cl_drug_stok', 'cl_drug.drug_id=cl_drug_stok.drug_id', $id_kunjungan);
        $query = $this->db->get('kunjungan_obat');

        return $query->result();
    }
    
     function get_alergi($code,$username){
        $this->db->where('code', $code);
        $this->db->where('username', $username);
        $query = $this->db->get('app_users_alergi');

        return $query->result();
    }
    
     function get_hasil($id_kunjungan){
        $this->db->where('id_kunjungan',$id_kunjungan);
        $query = $this->db->get('kunjungan_resume');
        return $query->row_array();
    }
    
    function get_kelainan_hasil($id_kunjungan){
        $this->db->where('id_kunjungan',$id_kunjungan);
        $query = $this->db->get('kunjungan_kelainan');
        return $query->row_array();
    }
    
    function get_lab_hasil($id_kunjungan){
        $this->db->where('id_kunjungan',$id_kunjungan);
        $query = $this->db->get('kunjungan_lab');
        return $query->row_array();
    }
    
    function selesai($id_kunjungan){
        $data['status_antri']   = 'selesai';
        $data['status_updated'] = 0;

        $this->db->where('id_kunjungan',$id_kunjungan);
        if ($this->db->update('kunjungan',$data)) {
            return 'true';  
        }else{
            return 'false';
        }
    }
    
     function get_therapy($id_compelling){

        $this->db->where('id_compelling',$id_compelling);
        $therapy = $this->db->get('jnc7_compelling')->row();

        if(!empty($therapy->therapy)){
            return $therapy->indication .': '. $therapy->therapy;
        }else{
            return "-";
        }
    }
    
     function calculate(){
        $result = "Normal";
        $systolic   = $this->input->post('systolic');
        $diastolic  = $this->input->post('diastolic');

        if($systolic < 120 && $diastolic<80){
            $result = "Normal";
        }
        elseif(($systolic >= 120 && $systolic<139) OR ($diastolic >= 80 && $diastolic<89)){
            $result = "Prehypertension";
        }
        elseif(($systolic >= 140 && $systolic<159) OR ($diastolic >= 90 && $diastolic<99)){
            $result = "Stage 1";
        }
        else{
            $result = "Stage 2";
        }

        return $result;
    }
    
    function autosave_kelainan($id_kunjungan){
        $field      = $this->input->post('field');
        $data       = $this->input->post('data');
        $update[$field]   = $data;

        $this->db->where('id_kunjungan',$id_kunjungan);
        $check = $this->db->get('kunjungan_kelainan')->row();
        if(empty($check)){
            $update['id_kunjungan'] = $id_kunjungan;

            return $this->db->insert('kunjungan_kelainan',$update);
        }else{
            $this->db->where('id_kunjungan',$id_kunjungan);
            return $this->db->update('kunjungan_kelainan',$update);
        }
    }
    
    function autosave_lab($id_kunjungan){
        $field      = $this->input->post('field');
        $data       = $this->input->post('data');
        $update[$field]   = $data;

        $this->db->where('id_kunjungan',$id_kunjungan);
        $check = $this->db->get('kunjungan_lab')->row();
        if(empty($check)){
            $update['id_kunjungan'] = $id_kunjungan;

            return $this->db->insert('kunjungan_lab',$update);
        }else{
            $this->db->where('id_kunjungan',$id_kunjungan);
            return $this->db->update('kunjungan_lab',$update);
        }
    }
    
    function autosave($id_kunjungan){
        $field          = $this->input->post('field');
        if($field == "kontrol_tgl"){
            $data       = strtotime($this->input->post('data'));
            $data       = date("Y-m-d",$data);
        }else{
            $data       = $this->input->post('data');
        }
        $update[$field]   = $data;

        $this->db->where('id_kunjungan',$id_kunjungan);
        return $this->db->update('kunjungan_resume',$update);

    }
    
    function simpan_diagnosa($id_kunjungan){
        $data['id_kunjungan']   = $id_kunjungan;
        $data['code_icdx']      = $this->input->post('code_icdx');
        $data['jenis_kasus']    = $this->input->post('jenis_kasus');
        $data['jenis_diagnosa'] = $this->input->post('jenis_diagnosa');
        $data['status_updated'] = $this->input->post('status_updated');

        $this->db->where('id_kunjungan',$id_kunjungan);
        $this->db->where('code_icdx',$this->input->post('code_icdx'));
        $check = $this->db->get('kunjungan_icdx')->row();

        if(empty($check)){
            return $this->db->insert('kunjungan_icdx',$data);
        }else{
            return false;
        }
    }
    
     function diagnosa_delete($id_kunjungan){
        $this->db->where('id_kunjungan',$id_kunjungan);
        $this->db->where('code_icdx', $this->input->post('code_icdx'));

        return $this->db->delete('kunjungan_icdx');
    }
    
     function simpan_alergi($code,$username){
        $data['code']       = $code;
		$data['username']   = $username;
		$data['tgl']        = date("Y-m-d",strtotime($this->input->post('tgl'))).date(" H:i:s");
        $data['alergi']     = $this->input->post('alergi');
        
        $this->db->where('code',$code);
        $this->db->where('username',$username);
        $this->db->where('tgl',date("Y-m-d",strtotime($this->input->post('tgl'))));
        $query = $this->db->get('app_users_alergi');
        
        if($query->num_rows()>0){
			echo "ERROR|Silahkan gunakan tanggal yang berbeda";
		}else{
			if($this->db->insert('app_users_alergi',$data)){
				echo "OK";
			}else{
				echo "ERROR|Gagal menambah alergi";
			}
		}
    }
    
    function alergi_delete($code,$username){
        $this->db->where('code',$code);
        $this->db->where('username',$username);
        $this->db->where('tgl', $this->input->post('tgl'));

        return $this->db->delete('app_users_alergi');
    }
    
     function simpan_obat($id_kunjungan){
        $data['id_kunjungan']   = $id_kunjungan;
        $data['drug_id']        = $this->input->post('drug_id');
        $data['cl_drug_signa_code'] = $this->input->post('cl_drug_signa_code');
        $data['racikan']        = $this->input->post('racikan');
        $data['dosis']          = $this->input->post('dosis');
        $data['status_updated'] = $this->input->post('status_updated');

        $this->db->where('id_kunjungan',$id_kunjungan);
        $this->db->where('drug_id',$this->input->post('drug_id'));
        $check = $this->db->get('kunjungan_obat')->row();

        if(empty($check)){
            return $this->db->insert('kunjungan_obat',$data);
        }else{
            return false;
        }
    }
    
      function obat_delete($id_kunjungan){
        $this->db->where('id_kunjungan',$id_kunjungan);
        $this->db->where('drug_id', $this->input->post('drug_id'));

        return $this->db->delete('kunjungan_obat');
    }
}
