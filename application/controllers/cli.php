<?php
class Cli extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('cli_model');
		$this->load->model('epus');
	}

	function index($args = ""){ //jalankan setiap malam
		if($this->input->is_cli_request()) {
			ini_set('max_execution_time', 0);
			ini_set('max_input_time', -1);
			ini_set('html_errors', 'Off');
			ini_set('register_argc_argv', 'On');
			ini_set('output_buffering', 'Off');
			ini_set('implicit_flush', 'On');

			$this->db->where('key','cl_phc');
			$cl_phc = $this->db->get('app_config')->row();
			if(!empty($cl_phc->value)){
				$this->pasien_search($cl_phc->value);
			}
		}else{
			die("Please access via cli");
		}
	}

	function loop($cl_phc=""){
		$tanggal 	= date("Y-m-d");
		$lastregid 	= "RJ".date("Ymd")."000";

		for($i=0;$i<20;$i++){
			$lastpanggilanid = $this->cli_model->getlastpanggilanid();
			$this->update_panggilan($cl_phc, $lastpanggilanid ,$tanggal);
			if($i%5==0) {
				$this->update_antrian($cl_phc, $lastregid ,$tanggal);
			}	
			sleep(3);
		}
	}

	function update_antrian($cl_phc="",$lastregid="",$tanggal=""){ //jalankan setiap 15 detik
		$tanggal 	= $tanggal=="" ? date("Y-m-d") : $tanggal;
		$lastregid	= $lastregid=="" ? "RJ".str_replace("-", "", $tanggal)."001" : $lastregid;

		$config 	= $this->epus->get_config("get_data_antrian");

		$url 		= $config['server'];
		$qr 		= $this->input->post("qr");

		if ($cl_phc=='') {
			$puskesmas 	="P".$this->session->userdata('puskesmas');
		}else{
			$puskesmas 	= $cl_phc;
		}

		$fields_string = array(
        	'client_id' 		=> $config['client_id'],
	        'kodepuskesmas' 	=> $puskesmas,
	        'tanggal' 			=> $tanggal,
	        'LastRegId' 	 	=> $lastregid,
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
		$pbk = array();
		if(is_array($res['content'])){
			$antrian = $res['content'];
			$count 	= 0;
			foreach ($antrian as $dt) {
				$update_antrian = $this->cli_model->update_antrian($dt,$cl_phc);
				$count++;
				if($this->input->is_cli_request()) {
					if($update_antrian == 'notexisted'){
						$this->pasien_search($cl_phc, $dt['cl_pid']);
					}
					echo "\n".$count." -> ".$cl_phc." :: ".$dt['reg_id'].":".$update_antrian;
				}
			}
			echo "<br>".$cl_phc." synced: ".$count;
		}else{
			echo "\nNo data";
		}
	}

	function update_panggilan($cl_phc="",$lastpanggilanid="",$tanggal=""){ //jalankan setiap 3 detik
		$tanggal 			= $tanggal=="" ? date("Y-m-d") : $tanggal;
		$lastpanggilanid	= $lastpanggilanid=="" ? "0" : $lastpanggilanid;

		$config 	= $this->epus->get_config("get_data_panggilan");

		$url 		= $config['server'];
		$qr 		= $this->input->post("qr");

		if ($cl_phc=='') {
			$puskesmas 	="P".$this->session->userdata('puskesmas');
		}else{
			$puskesmas 	= $cl_phc;
		}

		$fields_string = array(
        	'client_id' 		=> $config['client_id'],
	        'kodepuskesmas' 	=> $puskesmas,
	        'tanggal' 			=> $tanggal,
	        'LastPanggilanId' 	=> $lastpanggilanid,
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
		$pbk = array();
		if(is_array($res['content'])){
			$panggilan = $res['content'];
			$count 	= 0;
			foreach ($panggilan as $dt) {
				$insert_panggilan = $this->cli_model->insert_panggilan($dt);
				$count++;
				if($this->input->is_cli_request()) {
					echo "\n".$count." -> ".$insert_panggilan;
				}
			}
			echo "<br>".$cl_phc." synced: ".$count;
		}else{
			echo "\nNo data";
		}
	}

	function pasien_search($cl_phc="", $filter=""){
    	echo $cl_phc;
		$config 	= $this->epus->get_config("get_data_allPasien");
		$exclude 	= "('x')";

		$url 		= $config['server'];
		$qr 		= $filter != "" ? $filter : $this->input->post("qr");

		if ($cl_phc=='') {
			$puskesmas 	="P".$this->session->userdata('puskesmas');
		}else{
			$puskesmas 	= $cl_phc;
		}

		$fields_string = array(
        	'client_id' 		=> $config['client_id'],
	        'kodepuskesmas' 	=> $puskesmas,
	        'exclude' 			=> $exclude,
	        'filterPasien' 	 	=> $qr,
	        'limit' 			=> 999999,
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
		$pbk = array();
		if(is_array($res['content'])){
			$pasien = $res['content'];
			$count 	= 0;
			foreach ($pasien as $dt) {
				$register = $this->cli_model->register($dt,$cl_phc);
				$count++;
				if($this->input->is_cli_request()) {
					echo "\n".$count." -> ".$cl_phc." :: ".$dt['id'].":".$register;
				}
			}
			echo "<br>".$cl_phc." synced: ".$count;
		}else{
			echo "\nNo data";
		}
	}

  //   function sync_data_pasien($puskesmas=""){
  //   	echo "\n".$puskesmas."\n";
		// $config 	= $this->epus->get_config("form_get_pasienByDiagnosa");
		// $exclude 	= $this->cli_model->exclude_cl_pid($puskesmas);

		// $url 		= $config['server'];
		// $fields_string = array(
  //       	'client_id' 		=> $config['client_id'],
	 //        'kodepuskesmas' 	=> $puskesmas,
	 //        'exclude' 			=> $exclude,
	 //        'filterDiagnosa' 	=> 'i10',
	 //        'limit' 			=> 100,
	 //        'request_output' 	=> $config['request_output'],
	 //        'request_time' 		=> $config['request_time'],
	 //        'request_token' 	=> $config['request_token']
	 //    );


		// $curl = curl_init();

  //       curl_setopt($curl,CURLOPT_URL,$url);
  //       curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
  //       curl_setopt($curl,CURLOPT_POST,count($fields_string));
		// curl_setopt($curl,CURLOPT_POSTFIELDS, $fields_string);

  //       $result = curl_exec($curl);
		// curl_close($curl);

		// $res = json_decode(($result), true);
		// if(is_array($res['content'])){
		// 	$pasien = $res['content'];
		// 	$count 	= 0;
		// 	foreach ($pasien as $dt) {
		// 		$code = substr($puskesmas,1,10);
		// 		$next = $this->cli_model->register($dt, $code);
		// 		$count++;
		// 	}

		// 	if($next==1) {
		// 		echo date("d-m-Y H:i:s")." -> ".$count." Imported\n";
		// 		$this->sync_data_pasien($puskesmas);
		// 	}else{
		// 		echo "No new data";
		// 	}
		// }else{
		// 	echo "No new data";
		// }
  //   }

}
