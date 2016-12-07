<?php
class Antrian_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function loket(){
      $tgl = date("Y-m-d");
      $this->db->select('MAX(no)+1 as no');
      $this->db->where('tgl',$tgl);

      $data = $this->db->get('cl_loket')->row();

      $no = empty($data->no) ? 1 : $data->no;
      $add = array(
          'tgl' => $tgl,
          'no'  => $no
        );
      if($this->db->insert('cl_loket',$add)){
        return $no;
      }else{
        return 0;
      }
    }

    function get_puskesmas($value=''){
      $value = "P".($value != "" ? $value : $this->session->userdata('puskesmas'));
      $this->db->where('code',$value);
      $puskesmas = $this->db->get('cl_phc')->row();
      
      return $puskesmas->value;
    }

    function get_district(){
      $this->db->where('key','district');
      $district = $this->db->get('app_config')->row();
      $this->db->where('code',$district->value);

      $district = $this->db->get('cl_district')->row();
      
      return ucwords(strtolower($district->value));
    }

    function get_nik($id=""){
      $this->db->where('nik',$id);
      $this->db->or_where('cl_pid',$id);
      $pasien = $this->db->get('cl_pasien')->row();
      if(!empty($pasien->nama)){
        return $pasien;
      }else{
        return false;
      }
    }

    function get_bpjs($id=""){
      $this->db->where('bpjs',$id);
      $pasien = $this->db->get('cl_pasien')->row();
      if(!empty($pasien->nama)){
        return $pasien;
      }else{
        return false;
      }
    }

    function get_video_playlist(){
        $this->db->where('status',1);
        $this->db->order_by('id','asc');

        $query = $this->db->get('cl_video');
        return $query->result();
    }

    function get_poli($id){
      $this->db->where('is_antrian', 1);
      $this->db->where('id > ', $id);
      $this->db->order_by('id','asc');
      $poli = $this->db->get('cl_clinic')->row_array();

      if(!isset($poli['value'])){
        $poli = array(
            'id'      => 999,
            'kode'    => 'APOTEK',
            'value'   => 'APOTEK'
          );
        // $this->db->where('is_antrian', 1);
        // $this->db->order_by('id','asc');
        // $poli = $this->db->get('cl_clinic')->row_array();
      }

      return $poli;
    }

    function get_list_poli($page){
      $start_date = mktime(0,0,0,date('m'),date('d'),date('Y'));
      $data = array();
      $dt = array();

      $limit = 5;
      $start = $limit * $page;

      $this->db->select('kode');
      $this->db->where('is_antrian',1);
      $this->db->limit($limit,$start);
      $poli = $this->db->get('cl_clinic')->result_array();
      foreach ($poli as $rows) {
        $this->db->select('MIN(reg_antrian) as reg_antrian,reg_antrian_poli');
        $this->db->where('reg_poli',$rows['kode']);
        $this->db->where('status_periksa',0);
        $this->db->where('reg_time >', $start_date);
        $antrian = $this->db->get('cl_reg')->row();

        $dt['nomor']  = !empty($antrian->reg_antrian_poli) ? $antrian->reg_antrian_poli : "-";
        $dt['kode']   = $rows['kode'];
        $data[]       = $dt; 
      }


      $this->db->select('MIN(reg_antrian) as reg_antrian,reg_antrian_poli,cl_pasien.nama');
      $this->db->where('status_periksa',1);
      $this->db->where('status_apotek NOT IN(0,3)');
      $this->db->where('reg_time >', $start_date);
      $this->db->join('cl_pasien', 'cl_pasien.cl_pid=cl_reg.cl_pid');
      $apotek = $this->db->get('cl_reg')->row();

      $apotek       = array('nomor' => !empty($apotek->nama) ? $apotek->nama : "-",
                            'kode'  => 'APOTEK'
                      );
      $data[]       = $apotek; 

      return $data;
    }

    function get_poli_page($page){
      $page = $page+1;
      $limit = 6;
      $start = $limit * ($page);

      $this->db->select('kode');
      $this->db->where('is_antrian',1);
      $this->db->limit($limit,$start);
      $poli = $this->db->get('cl_clinic')->num_rows();
      if($poli<1){
        return 0;
      }else{
        return $page;
      }
    }

    function get_poli_daftar(){
      $this->db->where('is_daftar',1);
      $poli = $this->db->get('cl_clinic')->result_array();

      return $poli;
    }

    function get_antrian($kode){
      $start_date = mktime(0,0,0,date('m'),date('d'),date('Y'));

      if($kode == 'APOTEK'){
        $this->db->select('cl_pasien.nama,cl_reg.reg_antrian,cl_reg.reg_antrian_poli');
        $this->db->where('reg_time >', $start_date);
        $this->db->where('status_periksa', 1);
        $this->db->where('status_apotek NOT IN(0,3)');
        $this->db->join('cl_pasien','cl_pasien.cl_pid=cl_reg.cl_pid');
        $this->db->order_by('reg_id','asc');
        $pasien = $this->db->get('cl_reg',5)->result_array();
      }else{
        $this->db->select('cl_pasien.nama,cl_reg.reg_antrian,cl_reg.reg_antrian_poli');
        $this->db->where('reg_time >', $start_date);
        $this->db->where('status_periksa', 0);
        $this->db->where('reg_poli', $kode);
        $this->db->join('cl_pasien','cl_pasien.cl_pid=cl_reg.cl_pid');
        $this->db->order_by('reg_id','asc');
        $pasien = $this->db->get('cl_reg',5)->result_array();
      }

      return $pasien;
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
