<?php
class Kiosk extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('antrian_model');
	}

	function index(){
    	$data['title_group'] 	= "Antrian";
		$data['title_form']  	= "Data Antrian";

		$data['puskesmas']	= $this->antrian_model->get_puskesmas();
		$data['district']	= $this->antrian_model->get_district();
		$data['poli']		= $this->antrian_model->get_poli_daftar();

    	$data['content']= $this->parser->parse("antrian/kiosk",$data,true);
		$this->template->show($data,"kiosk");
  	}	

  	function nik($id){
		$pasien	= $this->antrian_model->get_nik($id);
		if(!empty($pasien->cl_pid)){
			$data = array(
				'cl_pid'	=> $pasien->cl_pid,
				'nama'		=> $pasien->nama,
				'content'	=> "Selamat datang <b>".$pasien->nama."</b><br><br><div class='row'><div class='col-md-4' style='text-align:right'>Nomor RM :</div><div class='col-md-8' style='text-align:left'>".$pasien->cl_pid."</div></div><div class='row' ><div class='col-md-4' style='text-align:right'>Alamat :</div><div class='col-md-8' style='text-align:left'>".$pasien->alamat."</div></div><br><br>Silahkan lanjutkan ke POLI tujuan anda.<br><br><button class='btn-lg btn-success' onClick='mainpage()' style='width:200px'>DAFTAR</button>"
			);
		}else{
			$data = array(
				'content'	=> "Maaf <b>NIK</b> anda tidak ditemukan<br>atau belum terdaftar.<br><br>Silahkan melakukan pendaftaran melalui<br><b>LOKET PENDAFTARAN</b><br><br>Terimakasih.<br><br><button class='btn-lg btn-success' onClick='tutup()' style='width:200px'>OK</button>"
			);
		}

  		echo json_encode($data);
	}	  	  	

	function bpjs($id){
		$pasien		= $this->antrian_model->get_bpjs($id);
		if(!empty($pasien->cl_pid)){
			$data = array(
				'cl_pid'	=> $pasien->cl_pid,
				'nama'		=> $pasien->nama,
				'content'	=> "Selamat datang <b>".$pasien->nama."</b><br><br><div class='row'><div class='col-md-4' style='text-align:right'>Nomor RM :</div><div class='col-md-8' style='text-align:left'>".$pasien->cl_pid."</div></div><div class='row' ><div class='col-md-4' style='text-align:right'>Alamat :</div><div class='col-md-8' style='text-align:left'>".$pasien->alamat."</div></div><br><br>Silahkan lanjutkan ke POLI tujuan anda.<br><br><button class='btn-lg btn-success' onClick='mainpage()' style='width:200px'>DAFTAR</button>"
			);
		}else{
			$data = array(
				'content'	=> "Maaf <b>Nomor BPJS</b> anda tidak ditemukan<br>atau belum terdaftar.<br><br>Silahkan melakukan pendaftaran melalui<br><b>LOKET PENDAFTARAN</b><br><br>Terimakasih.<br><br><button class='btn-lg btn-success' onClick='tutup()' style='width:200px'>OK</button>"
			);
		}

  		echo json_encode($data);
	}

	function daftar($cl_pid,$poli){
		$data = array();

		// $pasien		= $this->antrian_model->get_bpjs($id);
		// if(!empty($pasien->cl_pid)){
		// 	$data = array(
		// 		'cl_pid'	=> $pasien->cl_pid,
		// 		'nama'		=> $pasien->nama,
		// 		'content'	=> "Selamat datang <b>".$pasien->nama."</b><br><br><div class='row'><div class='col-md-4' style='text-align:right'>Nomor RM :</div><div class='col-md-8' style='text-align:left'>".$pasien->cl_pid."</div></div><div class='row' ><div class='col-md-4' style='text-align:right'>Alamat :</div><div class='col-md-8' style='text-align:left'>".$pasien->alamat."</div></div><br><br>Silahkan lanjutkan ke POLI tujuan anda.<br><br><button class='btn-lg btn-success' onClick='mainpage()' style='width:200px'>DAFTAR</button>"
		// 	);
		// }else{
		// 	$data = array(
		// 		'content'	=> "Maaf <b>Nomor BPJS</b> anda tidak ditemukan<br>atau belum terdaftar.<br><br>Silahkan melakukan pendaftaran melalui<br><b>LOKET PENDAFTARAN</b><br><br>Terimakasih.<br><br><button class='btn-lg btn-success' onClick='tutup()' style='width:200px'>OK</button>"
		// 	);
		// }

		$print = $this->parser->parse("antrian/print",$data,true);
		$data = array(
			'content'	=> "Terimakasih.<br><br><br><button class='btn-lg btn-success btnPrint' onClick='print();tutup()' style='width:200px'>OK</button>",
			'print'		=> $print
		);

  		echo json_encode($data);
	}
}
