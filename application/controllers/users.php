<?php

class Users extends CI_Controller {

	var $limit=10;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		$this->load->model('sendmail_model');
		$this->load->model('disbun_model');
		$this->load->helper('html');
        $this->load->library('email');
        $this->load->library('image_CRUD');
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}
	
	function baru(){
		$this->authentication->verify('user','show');
		$data['title_group']	="Dashboard";
		$data['title_form']		="Pendaftar Baru (menunggu approval)";

		$data['query'] = $this->users_model->get_data(0,9999999,array("status_aproved"=>"0")); 

		$data['content'] = $this->parser->parse("users/baru",$data,true);

		$this->template->show($data,"home");
	}

	function aktif(){
		$this->authentication->verify('user','show');
		$data['title_group']	="Dashboard";
		$data['title_form']		="Produsen Benih Aktif";

		$data['query'] = $this->users_model->get_data(0,9999999,array("status_aproved"=>"1")); 

		$data['content'] = $this->parser->parse("users/aktif",$data,true);

		$this->template->show($data,"home");
	}


	function profile($username="")
	{
		$this->authentication->verify('user','edit');

		$data = $this->users_model->get_data_row($username); 

		$data['provinsi_option']	= $this->crud->provinsi_option($data['propinsi']);
		$data['title_group']	="Dashboard";
		$data['title_form']		="Pendaftar Baru (detail profil)";
		$user['username']		= $username;

		$image_crud = new image_CRUD();
	
		$image_crud->unset_upload();
		$image_crud->unset_delete();

		$image_crud->set_primary_key_field('id');
		$image_crud->set_url_field('filename');
		$image_crud->set_table('app_users_gallery')
			->set_relation_field('username')
			->set_relation_value($username)
			->set_ordering_field('priority')
			->set_image_path('public/gallery')
			->set_draganddrop(false);
			
		$output = $image_crud->render();
		// print_r($output);
		$data['output'] =$output->output;



		$data['content'] = $this->parser->parse("users/profile",$data,true);
		$this->template->show($data,"home");
	}

	function detail_pelanggan($id=0)
	{
		$this->authentication->verify('user','edit');

		$data = $this->users_model->get_data_row($id); 
		$data['balai_option']	= $this->crud->get_balai($data['kode_balai'],"","disabled style='background:white;border:1px solid #CCCCCC'");
		$data['provinsi_kantor']= $this->crud->get_propinsi_span($data['kantor_kode_provinsi']);
		$data['kota_kantor']	= $this->crud->get_kota_span($data['kantor_kode_provinsi'],$data['kantor_kode_kota']);
		$data['provinsi_pabrik']= $this->crud->get_propinsi_span($data['pabrik_kode_provinsi']);
		$data['kota_pabrik']	= $this->crud->get_kota_span($data['pabrik_kode_provinsi'],$data['pabrik_kode_kota']);
		$data['title_form']	= "Data Pelanggan &raquo;";
		$user['id']			    = $id;
		$data['form_reject']	= $this->parser->parse("users/reject_detail",$user,true);
		echo $this->parser->parse("users/detail_pelanggan",$data,true);
	}
	
	function data_reject($id){

		die(json_encode($this->users_model->json_data_reject($id)));
		
	}

	function detail_pengguna($id=0)
	{
		$this->authentication->verify('user','edit');

		$data = $this->users_model->get_data_row($id); 
		$data['balai_option']	= $this->crud->get_balai($data['kode_balai'],"","disabled style='background:white;border:1px solid #CCCCCC'");
		$data['provinsi_kantor']= $this->crud->get_propinsi_span($data['kantor_kode_provinsi']);
		$data['kota_kantor']	= $this->crud->get_kota_span($data['kantor_kode_provinsi'],$data['kantor_kode_kota']);
		$data['provinsi_pabrik']= $this->crud->get_propinsi_span($data['pabrik_kode_provinsi']);
		$data['kota_pabrik']	= $this->crud->get_kota_span($data['pabrik_kode_provinsi'],$data['pabrik_kode_kota']);
		$data['title_form']	= "Data Pelanggan &raquo;";
		
		echo $this->parser->parse("users/detail_pengguna",$data,true);
	}

	function detail_update($id_log=0)
	{
		$this->authentication->verify('user','edit');
		$data = $this->users_model->get_edit_row($id_log); 		
		$data['title_form']	= "Data Update &raquo;";

		echo $this->parser->parse("users/detail_update",$data,true);
	}
	
	
	
	
	function dodownload($id=0){
		

		$data = $this->users_model->get_data_row($id); 	
		$path = './public/files/'.$data['id']."/".$data['file_bukti'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['file_bukti']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}

	function edit($id_balai=0)
	{
		$this->authentication->verify('user','add');

		$data = $this->users_model->get_data_row($id_balai); 
		$data['title_form']="Balai &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("users/form",$data,true);
	}

	function doedit($id_balai=0)
	{
		$this->authentication->verify('user','edit');

		$this->form_validation->set_rules('nama_balai', 'Nama Balai', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat Balai', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->users_model->update_entry($id_balai);
			echo "1";
		}
	}
	
	function doapprove($id=0,$status=0)
	{
		$this->authentication->verify('user','edit');

		if($this->users_model->doapprove($id,$status)){
			$user		= $this->users_model->get_data_row($id);
			$message	= "Terimakasih ".$user['nama']."<br><br>";
			
			if($status==1){
			 	//$aktifasi	= $this->users_model->create_aktifasi($id,$user['id'],$user['email']);
			 	$message	.= "Permintaan pendaftaran anda telah kami terima dan account anda telah aktif.<br><br>";
			}else{
			 	$message	.= "Permintaan pendaftaran anda telah kami terima dan account anda tidak dapat diaktifkan.<br><br>";
			}

			$sending = $this->sendmail_model->dosendmail($user['email'],"Registrasi Anggota ".($status==1? "Diterima":"Ditolak"),$message);
			//echo $sending;
			echo "1";
		}else{
			echo "0";	
		}
	}
	
	function calon_reject($id=0)
	{
		$this->authentication->verify('user','edit');
 		$data = $this->users_model->get_data_row($id); 		
		$data['title_form']	= "Data Update &raquo;";
		$data['oke']="dddddddd";		
		echo $this->parser->parse("users/update_reject", $data,true);
	}
	
	function doapprove2($id=0, $status=0)
	{
		
		$this->form_validation->set_rules('nip', 'NIP', 'trim|required');
		$this->form_validation->set_rules('catatan', 'Catatan', 'trim|required');
		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
		
			if($this->users_model->doapprove($id,$status)){
				$user		= $this->users_model->get_data_row($id);
				$message	= "Terimakasih ".$user['nama']."<br><br>";
				if($status==9){
					$aktifasi	= $this->users_model->create_reject($id);
					$message	.= ":<br>".base_url()."aktifasi/".$aktifasi."/".$user['email'];
			}else{
				$message	.= "Permintaan pendaftaran anda telah kami terima dan account anda tidak dapat diaktifkan.<br><br>";
			}
				//$sending = $this->sendmail_model->dosendmail($user['email'],"Registrasi Pelanggan ".($status==1? "Diterima":"Ditolak"),$message);
				//echo $sending;
				echo "1";
			}else{
				echo "0";	
			}
		}
	}
	
	
	function aktifasi($id=0,$email="")
	{
		if($userid = $this->users_model->doaktifasi($id,$email)){
			$user		= $this->users_model->get_data_row($userid);
			$message	= "Terimakasih ".$user['nama']."<br><br>";
 			$message	.= "Akun anda telah diaktifkan.<br><br>";

			//$sending = $this->sendmail_model->dosendmail($user['email'],"Registrasi Pelanggan Berhasil",$message);
		}else{
			$message	= "Akun anda tidak dapat diaktifkan, atau link yang anda buka tidak benar.<br><br>";
		}


		$data['title'] = "Registrasi Pelanggan";
		$data['message'] = $message;
		$data['content'] = $this->parser->parse("users/done",$data,true);

		$this->template->show($data,'home_guest',1);
	}
	
}
