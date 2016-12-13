<?php
class Poli_model extends CI_Model {

    var $tabel    = 'cl_clinic';

    function __construct() {
        parent::__construct();
    }
    
	function get_poli($type){
		$data = array();
		$this->db->from('cl_clinic');
		$this->db->where('type',$type);
		$this->db->where('keyword <> ""');
		$query = $this->db->get();
        return $query->result();
	}

	function update($type, $id, $status){
		$data = array();
		$data[$type] = $status == "true" ? 1:0;
		$this->db->where('id',$id);
		return $this->db->update('cl_clinic',$data);
	}

}