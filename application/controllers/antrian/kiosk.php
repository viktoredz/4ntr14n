<?php
class Kiosk extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('antrian_model');
		$this->load->model('epus');
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

	function loket(){
      	$valid_puskesmas 	= "P".$this->session->userdata('puskesmas');
		$nomor 				= $this->antrian_model->loket();
      	$puskesmas 			= $this->epus->get_puskesmas($valid_puskesmas);
		$district			= $this->antrian_model->get_district();

		$data['nomor'] 		= $nomor;	
		$data['puskesmas'] 	= $puskesmas->value;
		$data['alamat'] 	= $district;
		$print = $this->parser->parse("antrian/print_loket",$data,true);

		$data = array(
			'content'	=> "NOMOR ANTRIAN LOKET :<br><br><b style='font-size:50px'>".$nomor."</b><br>Silahkan menunggu panggilan di<br>LOKET PENDAFTARAN<br><br><button class='btn-lg btn-success' onClick='print();tutup()' style='width:200px'>OK</button>",
			'print'	=> $print,
			'nomor'	=> $nomor
		);

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

  		$success	= "<br><br>Terimakasih.<br><br><button class='btn-lg btn-success btnPrint' onClick='print();tutup()' style='width:200px'>OK</button>"; 
  		$failed		= "<br><br>Terimakasih.<br><br><button class='btn-lg btn-danger' onClick='tutup()' style='width:200px'>TUTUP</button>"; 
  		$content	= "Maaf, pendaftaran sedang tidak dapat dilakukan<br><br><br>Silahkan menuju ke LOKET pendaftaran.";
      	$valid_puskesmas 	= "P".$this->session->userdata('puskesmas');
      	$puskesmas 			= $this->epus->get_puskesmas($valid_puskesmas);
		$district			= $this->antrian_model->get_district();
		$api 				= $this->epus_pendaftaran($cl_pid, "REG ".date("d-m-Y")." ".$poli, $valid_puskesmas);

		if(is_array($api) && isset($api['status_code']['code']) && intval($api['status_code']['code']) < 400){
			if(intval($api['status_code']['code']) == 206){
				$reply 		= isset($api['content']['validation']) ? $api['content']['validation']."<br><br><br>".$failed : "Maaf, ".$content.$failed;
			}else{
				$reply 			= isset($api['content']['kiosk']) ? $api['content']['kiosk'].$success : "Maaf, ".$content.$failed;
				$data['nomor']	= $api['content']['nomor'];
				$data['poli']	= $api['content']['poli'];
				$data['nama']	= $api['content']['nama'];
			}
		}else{
      		$reply		= $content.$failed; 
		}

		$data['cl_pid'] 	= $cl_pid;
		$data['puskesmas'] 	= $puskesmas->value;
		$data['alamat'] 	= $district;

		$print = $this->parser->parse("antrian/print",$data,true);
		$data = array(
			'content'	=> $reply,
			'print'		=> $print
		);

  		echo json_encode($data);
	}

	function epus_pendaftaran($cl_pid="", $sms="", $puskesmas){
		$config 	= $this->epus->get_config("daftar_kunjunganpid_epus");
		$url 		= $config['server'];

		$fields_string = array(
        	'client_id' 		=> $config['client_id'],
	        'kodepuskesmas' 	=> $puskesmas,
	        'cl_pid' 			=> $cl_pid,
	        'isi_sms' 	 		=> $sms,
	        'petugas' 	 		=> "puskesmas",
	        'request_output' 	=> $config['request_output'],
	        'request_time' 		=> $config['request_time'],
	        'request_token' 	=> $config['request_token']
	    );

		$curl = curl_init();

        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,count($fields_string));
		curl_setopt($curl,CURLOPT_POSTFIELDS, $fields_string);

        $result = curl_exec($curl);
		curl_close($curl);

		$res = json_decode(($result), true);
		return $res;
	}	

}
