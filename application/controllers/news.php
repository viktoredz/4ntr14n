<?php
class News extends CI_Controller {

    public function __construct(){
		parent::__construct();
    $this->load->helper(array('url','html','form'));
		$this->load->model('antrian_model');

	}

	function index(){
    $data['title_group'] 	= "News";
		$data['title_form']  	= "Daftar Pengumuman";
		$v = "antrian/antrian_news";

		$data['content']= $this->parser->parse($v,$data,true);

		$this->template->show($data,"home");
	}

  function add_news(){
    $data = array();
    $data['title_form'] = "Tambah Pengumuman";
		$data['action']     = "tambah";
    die($this->parser->parse('antrian/antrian_news_add', $data));
  }

  function detail_news($id){
    $data = $this->antrian_model->get_news_by_id($id);
    $data['title_form']	= "Detail Pengumuman";
		$data['action']		= "update";

    die($this->parser->parse('antrian/antrian_news_detail', $data));
  }

  function submit_news(){
    $content = $this->input->post('content');
    $data = array(
      'id' => '',
      'content' => $content,
      'status' => '1',
      'code' => 'P'.$this->session->userdata('puskesmas'),
    );
    $query = $this->antrian_model->add_news($data);
    if($query){
      echo "OK";
    }else{
      echo "ERROR";
    }
  }

  function update_news(){
    $id = $this->input->post('id');
    $content = $this->input->post('content');
    $status = $this->input->post('status');
    $data = array(
      'content' => $content,
      'status' => $status
    );
    $query = $this->antrian_model->update_news($id, $data);
    if($query){
      echo "OK";
    }else{
      echo "ERROR";
    }
  }

  function delete_news($id=""){
		//$this->authentication->verify('antrian','del');

		if($this->antrian_model->delete_news($id)){
			$this->session->set_flashdata('alert', 'Delete data ('.$id.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

  function json_news(){
    $this->db->where('cl_news.code', $this->session->userdata('klinik'));
    $rows_all = $this->antrian_model->get_news();

    $this->db->where('cl_news.code', $this->session->userdata('klinik'));
		$rows = $this->antrian_model->get_news($this->input->post('recordstartindex'), $this->input->post('pagesize'));

		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id'	=> $act->id,
				'content'	=> $act->content,
				'status'	=> $act->status,
        'klinik' => $act->value,
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows'      => $data
		);

		echo json_encode(array($json));
  }
}
