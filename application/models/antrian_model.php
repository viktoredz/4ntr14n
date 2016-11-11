<?php
class Antrian_model extends CI_Model {

    function __construct() {
        parent::__construct();
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
        $this->db->where('is_antrian', 1);
        $this->db->order_by('id','asc');
        $poli = $this->db->get('cl_clinic')->row_array();
      }

      return $poli;
    }

    function get_list_poli($page){
      $data = array();
      $dt = array();

      $limit = 6;
      $start = $limit * $page;

      $this->db->select('kode');
      $this->db->where('is_antrian',1);
      $this->db->limit($limit,$start);
      $poli = $this->db->get('cl_clinic')->result_array();
      foreach ($poli as $rows) {
        $this->db->select('MIN(reg_antrian) as reg_antrian');
        $this->db->where('reg_poli',$rows['kode']);
        $this->db->where('status_periksa',0);
        $antrian = $this->db->get('cl_reg')->row();

        $dt['nomor']  = !empty($antrian->reg_antrian) ? $antrian->reg_antrian : "-";
        $dt['kode']   = $rows['kode'];
        $data[]       = $dt; 
      }

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

    function get_antrian($kode){
      $this->db->select('cl_pasien.nama,cl_reg.reg_antrian');
      $this->db->where('status_periksa', 0);
      $this->db->where('reg_poli', $kode);
      $this->db->join('cl_pasien','cl_pasien.cl_pid=cl_reg.cl_pid');
      $this->db->order_by('reg_id','asc');
      $pasien = $this->db->get('cl_reg',5)->result_array();

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
