<?php
class Pasien extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('pasien_model');
	}

	function index(){
		$this->authentication->verify('antrian','show');
		$data['title_group'] 	= "Pasien";
		$data['title_form'] 	= "Daftar Pasien";

		$data['cl_phc']	 		= $this->session->userdata('filter_id_puskesmas');
		$data['phc']	 	= $this->pasien_model->get_puskesmas();

		$data['content'] 	= $this->parser->parse("pasien/show",$data,true);

		$this->template->show($data,"home");
	}

	function json(){
		$this->authentication->verify('antrian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				$this->db->like($field,$value);
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		if($this->session->userdata('filter_id_puskesmas') != '') {
			$this->db->where('cl_pasien.cl_phc',$this->session->userdata('filter_id_puskesmas'));
		}else{
			$this->db->where('cl_pasien.cl_phc','-');
		}

		$rows_all = $this->pasien_model->get_data();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				$this->db->like($field,$value);
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

    if($this->session->userdata('filter_id_puskesmas') != '') {
			$this->db->where('cl_pasien.cl_phc',$this->session->userdata('filter_id_puskesmas'));
		}else{
			$this->db->where('cl_pasien.cl_phc','-');
		}

		$rows = $this->pasien_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		$no=1;
		foreach($rows as $act) {
			$data[] = array(
				'no'		  => $no++,
				'cl_pid'  => $act->cl_pid,
				'nik'	  	=> $act->nik,
				'nama' 		=> $act->nama,
				'alamat'	=> $act->alamat,
				'created_on'=> $act->created_on,
				'edit'		=> 1,
				'delete'	=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function filter(){
		if($_POST) {
			if($this->input->post('id_antrian_grup') != '') {
				$this->session->set_userdata('filter_id_antrian_grup',$this->input->post('id_antrian_grup'));
			}else{
				$this->session->unset_userdata('filter_id_antrian_grup');
			}

			if($this->input->post('id_puskesmas') != '') {
				$this->session->set_userdata('filter_id_puskesmas',$this->input->post('id_puskesmas'));
			}else{
				$this->session->unset_userdata('filter_id_puskesmas');
			}
				echo $this->session->userdata('filter_id_antrian_grup') ;
				echo $this->session->userdata('filter_id_puskesmas') ;
		}
	}

	function add(){
		$this->authentication->verify('antrian','add');

        $this->form_validation->set_rules('cl_phc', 'Puskesmas', 'trim|required');
        $this->form_validation->set_rules('cl_pid', 'No RM', 'trim|required');
        $this->form_validation->set_rules('nomor', 'Nomor', 'trim|required|callback_cekNomor');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('id_antrian_grup', 'Grup', 'trim|required');

		if($this->form_validation->run()== FALSE){
			$data['title_group'] = "Buku Telepon";
			$data['title_form']="Tambah Nomor Telepon";
			$data['action']="add";
			$data['nomor']="";
			$data['phc']	 	= $this->pasien_model->get_puskesmas();

			$data['grupoption'] 	= $this->pasien_model->get_grupoption();

			$data['content'] = $this->parser->parse("pasien/form",$data,true);
		}elseif($id = $this->pasien_model->insert_entry()){
			$this->session->set_flashdata('alert', 'Save data successful...');
			redirect(base_url().'pasien/');
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."pasien/add");
		}

		$this->template->show($data,"home");
	}

	function edit($cl_pid="", $cl_phc=""){
		$this->authentication->verify('antrian','edit');

        $this->form_validation->set_rules('cl_pid', 'No RM', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('id_antrian_grup', 'Grup', 'trim|required');
        $this->form_validation->set_rules('bpjs', 'BPJS', 'trim');
        $this->form_validation->set_rules('nomor', 'Nomor', 'trim');

		if($this->form_validation->run()== FALSE){
			$data 	= $this->pasien_model->get_data_row($cl_pid,$cl_phc);

			$data['title_group'] 	= "Buku Telepon";
			$data['title_form']		= "Ubah Nomor Telepon";
			$data['action']			= "edit";
			$data['cl_pid']			= $cl_pid;
			$data['cl_phc']			= $cl_phc;
			$data['phc']	 		= $this->pasien_model->get_puskesmas(99,0,$cl_phc);

			$data['grupoption'] 	= $this->pasien_model->get_grupoption();

			$data['content'] 	= $this->parser->parse("pasien/form",$data,true);
		}elseif($this->pasien_model->update_entry($cl_pid,$cl_phc)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."pasien/edit/".$cl_pid."/".$cl_phc);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."pasien/edit/".$cl_pid."/".$cl_phc);
		}

		$this->template->show($data,"home");
	}

	function dodel($kode=0,$cl_phc=""){
		$this->authentication->verify('antrian','del');

		if($this->pasien_model->delete_entry($kode,$cl_phc)){
			$this->session->set_flashdata('alert', 'Delete data ('.$kode.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}


	function cekNomor(){
		$nomor = $this->input->post('nomor');
		$this->db->where('nomor',$nomor);
		$pbk = $this->db->get('antrian_pbk')->row();
		if(!empty($pbk)){
			$this->form_validation->set_message('cekNomor', 'Nomor '.$nomor.' sudah terdaftar.');
			return FALSE;
		}else{
			return TRUE;
		}
	}
}
