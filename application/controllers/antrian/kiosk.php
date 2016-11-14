<?php
class Kiosk extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('antrian_model');
		$this->load->model('kunjungan_model');
	}

	function index(){
    	$data['title_group'] 	= "Antrian";
		$data['title_form']  	= "Data Antrian";
		$data['video']			= $this->antrian_model->get_video_playlist();

    	$data['content']= $this->parser->parse("antrian/kiosk",$data,true);
		$this->template->show($data,"kiosk");
  	}	

  	function json_show(){
	    $poli = $this->antrian_model->get_poli_on_kunjungan();
	    $data = array();
	    $i = 0;

	    foreach ($poli as $value) {
	      if(!empty($this->antrian_model->get_data_show_antrian($value->poli, "periksa"))){
	        //$data[$i]['pasien_periksa'] = $this->antrian_model->get_data_show_antrian($value->poli, "periksa");
	      }else{

	      }

	      if(!empty($this->antrian_model->get_data_show_antrian($value->poli, "antri"))){
	        $data[$i]['pasien_antri'] = $this->antrian_model->get_data_show_antrian($value->poli, "antri");
	        $data[$i]['count'] = sizeof($data[$i]['pasien_antri']);
	        $data[$i]['nama_poli'] = $this->antrian_model->get_value_by_klinik($value->poli);

	      }else{

	      }

	      //echo $this->db->last_query() . "<br><br>";
	    $i++;

	    }
	    $data = array(
	      'row' => sizeof($data),
	      'result' => $data
	    );
	    //die();
	    echo json_encode($data);
  	}


  	function json_video_list(){
	    $this->db->where('status', '1');
	    $this->db->where('cl_video.code', 'P'.$this->session->userdata('puskesmas'));
			$rows = $this->antrian_model->get_video();

	    $data = array();
		foreach($rows as $act) {
			$data[] = $act->video;
		}

		echo json_encode($data);
  	}	

  	function json_marquee(){
	    $this->db->where('status', '1');
	    $this->db->where('cl_news.code', $this->session->userdata('klinik'));
	    $data = $this->antrian_model->get_news();
	    echo json_encode($data);
	}	  	  	
}
