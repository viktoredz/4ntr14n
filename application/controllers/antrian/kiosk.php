<?php
class Kiosk extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('antrian_model');
	}

	function index(){
    	$data['title_group'] 	= "Antrian";
		$data['title_form']  	= "Data Antrian";

		$data['puskesmas']= $this->antrian_model->get_puskesmas();
		$data['district']= $this->antrian_model->get_district();

    	$data['content']= $this->parser->parse("antrian/kiosk",$data,true);
		$this->template->show($data,"kiosk");
  	}	

  	function json_marquee(){
	    $this->db->where('status', '1');
	    $this->db->where('cl_news.code', $this->session->userdata('klinik'));
	    $data = $this->antrian_model->get_news();
	    echo json_encode($data);
	}	  	  	
}
