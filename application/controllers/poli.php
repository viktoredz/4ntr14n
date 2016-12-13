<?php

class Poli extends CI_Controller {

	var $limit=20;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('poli_model');

	}
	
	function index($id='administrator')
	{
		$this->authentication->verify('admin','edit');

		$data['query'] = $this->poli_model->get_poli('RJ'); 
		$data['title_group'] = "Daftar Poli";
		$data['title_form'] = "Antrian & Pendaftaran";
		$data['action']="doedit";

		$data['content'] = $this->parser->parse("antrian/poli",$data,true);
		$this->template->show($data,"home");
	}

	function update($type, $id=0, $status=1){
		$this->authentication->verify('admin','edit');
		$update = $this->poli_model->update($type, $id, $status); 

		echo $update;
	}


}
