<?php
class Tv extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('antrian_model');
	}

	function index(){
      $data['title_group'] 	= "Antrian";
      $data['title_form']   = "Data Antrian";
      $data['video']		= $this->antrian_model->get_video_playlist();

      $data['content']= $this->parser->parse("antrian/tv",$data,true);
      $this->template->show($data,"tv");
  	}

  	function tv_pasien($id){
  		$data = array();
  		$poli 			= $this->antrian_model->get_poli($id);
  		$data['poli'] 	= $poli['value'];
  		$data['pasien'] = $this->antrian_model->get_antrian($poli['kode']);

		  echo $this->parser->parse("antrian/tv_pasien",$data,true);
 	}

  	function tv_next($id){
  		$poli 	= $this->antrian_model->get_poli($id);
  		echo $poli['id'];
 	}

  	function tv_poli($page){
  		$data = array();
  		$data['poli']	= $this->antrian_model->get_list_poli($page);

		  echo $this->parser->parse("antrian/tv_poli",$data,true);
 	}

  	function tv_page($page){
  		$page 	= $this->antrian_model->get_poli_page($page);
  		echo $page;
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
