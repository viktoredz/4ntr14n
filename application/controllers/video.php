<?php
class Video extends CI_Controller {

    public function __construct(){
		parent::__construct();
    $this->load->helper(array('url','html','form'));
		$this->load->model('antrian_model');

	}

	function index(){
    $data['title_group'] 	= "Video";
		$data['title_form']  	= "Palylist Video";

		$v = "antrian/antrian_video";
		$data['content']= $this->parser->parse($v,$data,true);

		$this->template->show($data,"home");
	}

  function add_video(){
    $data['title_form']	= "Tambah Video";
		$data['action']		= "tambah";
    die($this->parser->parse('antrian/antrian_video_add', $data));
  }

  function detail_video($id){
    $data = $this->antrian_model->get_video_by_id($id);
    $data['title_form']	= "Detail Video";
		$data['action']		= "update";

    die($this->parser->parse('antrian/antrian_video_detail', $data));
  }

  function submit_video(){
    if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != '') {
        $date = date("d-m-Y");
        $path = './media/';
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        $configVideo['upload_path']   = $path;
        $configVideo['allowed_types'] = '*';
        $configVideo['overwrite']     = false;
        $configVideo['remove_spaces'] = TRUE;

        @unlink($path."/".$_FILES['video']['name']);

        $this->load->library('upload', $configVideo);
        $upload = $this->upload->do_upload('video');
        if($upload === FALSE) {
            echo $this->upload->display_errors();
        }else{
            $videoDetails = $this->upload->data();

            $data = array(
              'video'   => $videoDetails['file_name'],
              'status'  => '1',
              'code'    => 'P'.$this->session->userdata('puskesmas'),
            );
            $query = $this->antrian_model->add_video($data);
            echo "OK";
        }
    }else{
        echo "Tentukan file video dengan benar";
    }
  }

  function update_video(){
    $id = $this->input->post('id');
    $status = $this->input->post('status');
    $data = array(
      'status' => $status,
      'code' => $this->session->userdata('puskesmas'),
    );
    $query = $this->antrian_model->update_video($id, $data);

    if($query){
      echo "OK";
    }else{
      echo "ERROR";
    }
  }

  function delete_video($id="", $video){
		//$this->authentication->verify('antrian','del');
    $this->load->helper("file");
    $path = "./media/". $video;
    unlink($path);
		if($this->antrian_model->delete_video($id)){
			$this->session->set_flashdata('alert', 'Delete data ('.$id.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

  function json_video(){
    $this->db->where('cl_video.code', 'P'.$this->session->userdata('puskesmas'));
    $rows_all = $this->antrian_model->get_video();

    $this->db->where('cl_video.code', 'P'.$this->session->userdata('puskesmas'));
		$rows = $this->antrian_model->get_video($this->input->post('recordstartindex'), $this->input->post('pagesize'));

    $data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id'	=> $act->id,
				'video'	=> $act->video,
				'status'	=> $act->status,
        'code' => $act->value
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows'      => $data
		);

		echo json_encode(array($json));
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

}
