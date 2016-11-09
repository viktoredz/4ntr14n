<?php
class Antrian_model extends CI_Model {

    var $tabel_dokter        = 'bpjs_data_dokter';

    function __construct() {
        parent::__construct();
    }

    function get_data_pasien($start=0,$limit=999999,$options=array()){
        $this->db->select("id_kunjungan,app_users_profile.username,app_users_profile.nama,kunjungan.code,app_users_profile.jk,app_users_profile.phone_number,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lahir)), '%Y')+0 AS usia,kunjungan.status_antri,kunjungan.tgl,kunjungan.waktu",false);
        $this->db->join('app_users_profile','kunjungan.username = app_users_profile.username AND kunjungan.code = app_users_profile.code','inner');
        $this->db->where('tgl','CURDATE()',false);
        $this->db->where('status_antri','antri');
        $this->db->where('substr(id_kunjungan,1,8)',$this->session->userdata('klinik'));
        $this->db->order_by('id_kunjungan','asc');

        $query = $this->db->get('kunjungan',$limit,$start);
        return $query->result();
    }

    function get_data_non_pasien($start=0,$limit=10,$options=array()){
        $this->db->select("id_kunjungan,app_users_profile.username,app_users_profile.nama,kunjungan.code,app_users_profile.jk,app_users_profile.phone_number,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lahir)), '%Y')+0 AS usia,kunjungan.poli, kunjungan.status_antri,kunjungan.tgl,kunjungan.waktu",false);
        $this->db->join('app_users_profile','kunjungan.username = app_users_profile.username AND kunjungan.code = app_users_profile.code','inner');
        $this->db->where('status_antri','antri');
        $this->db->where('tgl','CURDATE()',false);
        //$this->db->where('substr(id_kunjungan,1,8)',$this->session->userdata('klinik'));
        if($this->session->userdata('level')!='pasien'){
            $this->db->order_by('id_kunjungan','asc');
        }else{
            $this->db->order_by('id_kunjungan','asc');
        }
        $query = $this->db->get('kunjungan',$limit,$start);
        return $query->result();
    }

    function get_data_show_antrian($id, $status, $start=0,$limit=10,$options=array()){
        $this->db->select("id_kunjungan,app_users_profile.username, app_users_profile.nama,app_users_profile.jk, kunjungan.code, app_users_profile.phone_number,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lahir)), '%Y')+0 AS usia,kunjungan.poli, kunjungan.status_antri,kunjungan.tgl,kunjungan.waktu",false);
        $this->db->join('app_users_profile','kunjungan.username = app_users_profile.username AND kunjungan.code = app_users_profile.code','inner');
        //$this->db->join('cl_poli', 'kunjungan.code = cl_poli.klinik', 'left');
        $this->db->where('status_antri', $status);
        $this->db->where('poli', $id);
        $this->db->where('tgl','CURDATE()',false);
        if($this->session->userdata('level')!='pasien'){
            $this->db->order_by('id_kunjungan','asc');
        }else{
            $this->db->order_by('id_kunjungan','asc');
        }
        $this->db->group_by('id_kunjungan');

        $query = $this->db->get('kunjungan',$limit,$start);
        return $query->result();
    }

    function get_value_by_klinik($klinik){
      $this->db->select('value');
      $this->db->where('id', $klinik);
      $this->db->order_by('id');
      $this->db->group_by('id');
      $query = $this->db->get('cl_poli')->row();

      //$query->row_array();
      //var_dump($query->row_array());
      return $query->value;
    }

    function get_poli_on_kunjungan(){
      $this->db->distinct();
      $this->db->select('poli');
      $this->db->where('tgl', 'CURDATE()', false);
      $this->db->where('status_antri', 'antri');
      $this->db->where('poli <> 14');
      $this->db->where('poli <> 15');
      $this->db->order_by('poli', 'asc');
      $query = $this->db->get('kunjungan');
      return $query->result();
    }

    function get_news(){
      $this->db->join('cl_phc','cl_news.code = cl_phc.code','inner');
      $query = $this->db->get('cl_news');
      return $query->result();
    }

    function get_video(){
      $this->db->join('cl_phc','cl_video.code = cl_phc.code','inner');
      $query = $this->db->get('cl_video');
      return $query->result();
    }

    function get_news_by_id($id){
      $data = array();
      $this->db->where('id', $id);
      $query = $this->db->get('cl_news')->row_array();
      if($query){
        return $query;
      }else{
        return $data;
      }
    }

    function get_video_by_id($id){
      $data = array();
      $this->db->where('id', $id);
      $query = $this->db->get('cl_video')->row_array();
      if($query){
        return $query;
      }else{
        return $data;
      }
    }

    function add_news($data){
      $query = $this->db->insert('cl_news', $data);
      if($query){
        return TRUE;
      }else{
        return FALSE;
      }
    }

    function add_video($data){
      $query = $this->db->insert('cl_video', $data);
      if($query){
        return TRUE;
      }else{
        return FALSE;
      }
    }

    function update_news($id,$data){
      $this->db->where('id', $id);
      $query = $this->db->update('cl_news', $data);
      if($query){
        return TRUE;
      }else{
        return FALSE;
      }
    }

    function update_video($id,$data){
      $this->db->where('id', $id);
      $query = $this->db->update('cl_video', $data);
      if($query){
        return TRUE;
      }else{
        return FALSE;
      }
    }

    function delete_news($id){
  		$this->db->where('id',$id);
  		return $this->db->delete('cl_news');
  	}

    function delete_video($id){
  		$this->db->where('id',$id);
  		return $this->db->delete('cl_video');
  	}

    function get_pus ($code,$condition,$table){
        $this->db->select("*");
        $this->db->like($condition,$code);
        $query = $this->db->get($table);
        return $query->result();
    }

}
