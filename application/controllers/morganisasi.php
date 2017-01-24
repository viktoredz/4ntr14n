<?php
class Morganisasi extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('morganisasi_model');
	}

	function index(){
		$this->authentication->verify('morganisasi','show');
		$data['title_group'] 	= "Antrian";
		$data['title_form'] 	= "Dashboard";
		$data['pbk'] 			= number_format($this->morganisasi_model->get_jml_pasien());
		$data['panggilan'] 		= $this->morganisasi_model->get_panggilan();
		$data['poli'] 			= $this->morganisasi_model->get_poli();

		$data['content'] = $this->parser->parse("antrian/show",$data,true);
		$this->template->show($data,'home');
	}

	function antrian(){
		$data['antrian']	= $this->morganisasi_model->get_antrian();
		
		echo $this->parser->parse("antrian/show_antrian",$data,true);
	}

	function panggilan($status=1){
		if($status == 1){
			$data 			= array();
			$panggilan		= $this->morganisasi_model->get_panggilan();
			$data['nama'] 	= isset($panggilan['nama']) ? $panggilan['nama'] : "Panggilan Kosong";
			$data['poli'] 	= isset($panggilan['reg_poli']) ? "Poli : ".$panggilan['reg_poli'] : "";
			$data['nomor'] 	= isset($panggilan['reg_antrian_poli']) ? "Nomor : ".$panggilan['reg_antrian_poli'] : "";
			$data['nomor_slice']	= $this->slice($panggilan);
			$data['reg_poli']		= isset($panggilan['reg_poli']) ? $panggilan['reg_poli'] : "";

			if(isset($panggilan['panggilan_id'])) $this->morganisasi_model->call_antrian($panggilan['panggilan_id']);

			echo $this->parser->parse("antrian/show_panggilan",$data,true);
		}else{
			$data = array();
			echo $this->parser->parse("antrian/show_panggilan_off",$data,true);
		}	
	}

	function slice($panggilan){
		$nomor = isset($panggilan['reg_antrian_poli']) ? $panggilan['reg_antrian_poli'] : 0;
		//if($nomor==3) $nomor = 567;

		if($nomor>0 && $nomor <= 20){
			$slice = $nomor;
		}
		elseif($nomor>20 && $nomor < 30){
			$slice = '20","'.substr($nomor, -1);
		}
		elseif($nomor>30 && $nomor < 40){
			$slice = '30","'.substr($nomor, -1);
		}
		elseif($nomor>40 && $nomor < 50){
			$slice = '40","'.substr($nomor, -1);
		}
		elseif($nomor>50 && $nomor < 60){
			$slice = '50","'.substr($nomor, -1);
		}
		elseif($nomor>60 && $nomor < 70){
			$slice = '60","'.substr($nomor, -1);
		}
		elseif($nomor>70 && $nomor < 80){
			$slice = '70","'.substr($nomor, -1);
		}
		elseif($nomor>80 && $nomor < 90){
			$slice = '80","'.substr($nomor, -1);
		}
		elseif($nomor>90 && $nomor < 100){
			$slice = '90","'.substr($nomor, -1);
		}
		elseif($nomor>99 && $nomor<110){
			$slice = '100","'.substr($nomor, -1);
		}
		elseif($nomor>109 && $nomor<120){
			$slice = '100","'.substr($nomor, -2);
		}
		elseif($nomor>119 && $nomor<200){
			$arr = array('reg_antrian_poli'=>substr($nomor, -2));
			$slice = '100","'.$this->slice($arr);
		}
		elseif($nomor>199 && $nomor<210){
			$slice = '200","'.substr($nomor, -1);
		}
		elseif($nomor>209 && $nomor<220){
			$slice = '200","'.substr($nomor, -2);
		}
		elseif($nomor>219 && $nomor<300){
			$arr = array('reg_antrian_poli'=>substr($nomor, -2));
			$slice = '200","'.$this->slice($arr);
		}
		elseif($nomor>299 && $nomor<310){
			$slice = '300","'.substr($nomor, -1);
		}
		elseif($nomor>309 && $nomor<320){
			$slice = '300","'.substr($nomor, -2);
		}
		elseif($nomor>319 && $nomor<400){
			$arr = array('reg_antrian_poli'=>substr($nomor, -2));
			$slice = '300","'.$this->slice($arr);
		}
		elseif($nomor>399 && $nomor<410){
			$slice = '400","'.substr($nomor, -1);
		}
		elseif($nomor>409 && $nomor<420){
			$slice = '400","'.substr($nomor, -2);
		}
		elseif($nomor>419 && $nomor<500){
			$arr = array('reg_antrian_poli'=>substr($nomor, -2));
			$slice = '400","'.$this->slice($arr);
		}
		elseif($nomor>599 && $nomor<510){
			$slice = '500","'.substr($nomor, -1);
		}
		elseif($nomor>509 && $nomor<520){
			$slice = '500","'.substr($nomor, -2);
		}
		elseif($nomor>519 && $nomor<600){
			$arr = array('reg_antrian_poli'=>substr($nomor, -2));
			$slice = '500","'.$this->slice($arr);
		}else{
			$slice = "";
		}

		return $slice;
	}

	function filter(){
		if($_POST) {
			if($this->input->post('bar_tpe') != '') {
				$this->session->set_userdata('filter_bar_tipe',$this->input->post('bar_tipe'));
			}
		}
	}

	function profile()
	{
		$this->authentication->verify('morganisasi','edit');
		$data = $this->morganisasi_model->get_profile();
		$data['title_group']		="Dashboard";
		$data['title_form']			="Profil Pengguna";

		$data['username']			= $this->session->userdata('username');
		$data['content']			= $this->parser->parse("sik/profile",$data,true);

		$this->template->show($data,"home");

	}

	function profile_doupdate() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_check_email2');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('phone_number', 'Nama Pendaftar', 'trim');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}elseif($username=$this->morganisasi_model->update_profile()){
			echo "Data berhasil disimpan";
		}else{
			echo "Penyimpanan data gagal dilakukan";
		}
	}

	function profile_dosave()
	{
        $this->form_validation->set_rules('username','Username','trim|required|min_length[5]|max_length[12]|callback_check_username2');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('password','Password','trim|required|min_length[5]|matches[passconf]|callback_check_pass2');
 		$this->form_validation->set_rules('nama','Nama Lengkap Penanggung Jawab','trim|required');
		$this->form_validation->set_rules('phone_number','Nomor Telepon Penanggung Jawab','trim|required');


		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}
		else
		{
			$this->morganisasi_model->create_profile();
			echo"1";
		}
	}

	function puskesmas(){
		$data = array();
		$filter = $this->input->server('QUERY_STRING');
		parse_str($filter, $_GET);

		$this->db->select("cl_district.*");
		$this->db->where("key","district");
		$this->db->join("cl_district","cl_district.code=app_config.value");
		$cnf = $this->db->get("app_config")->row();
		if(!empty($cnf->code)){
			$this->db->like("value",$_GET['q']);
			$this->db->like("code",$cnf->code);
			$phc = $this->db->get("cl_phc")->result();
			foreach($phc as $x){
				echo $x->value."	|	".str_replace("P","",$x->code)."	|	".$cnf->value."		| 	#
				";
			}
		}
		die();
	}

	function kota($kode_provinsi="",$kode_kota="")
	{
		$data['kota'] = "<option>-</option>";
		$kota = $this->crud->get_kota($kode_provinsi);
		foreach($kota as $x=>$y){
			$data['kota'] .= "<option value='".$x."' ";
			if($kode_kota == $x) $data['kota'] .="selected";
			$data['kota'] .=">".$y."</option>";
		}

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

	function kecamatan($kode_kota="",$kode_kec="")
	{
		$data['kecamatan'] = "<option>-</option>";
		$kecamatan = $this->crud->get_kecamatan($kode_kota);
		foreach($kecamatan as $x=>$y){
			$data['kecamatan'] .= "<option value='".$x."' ";
			if($kode_kec == $x) $data['kecamatan'] .="selected";
			$data['kecamatan'] .=">".$y."</option>";
		}

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

	function desa($kode_kec="",$kode_desa="")
	{
		$data['desa'] = "<option>-</option>";
		$desa = $this->crud->get_desa($kode_kec);
		foreach($desa as $x=>$y){
			$data['desa'] .= "<option value='".$x."' ";
			if($kode_desa == $x) $data['desa'] .="selected";
			$data['desa'] .=">".$y."</option>";
		}

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

	function check_email($str){

			$check = $this->morganisasi_model->check_email($str);

			if($check>0){
				echo "0__Email tidak dapat digunakan";
			}else{
				echo "1__Email dapat digunakan";
			}

	}

	function check_email2($str){

			$check = $this->morganisasi_model->check_email($str);

			if($check>0){
				$this->form_validation->set_message('check_email2', 'Email tidak dapat digunakan');
				return FALSE;
			}else{
				return TRUE;
			}

	}

	function check_username($str){
		$forbidden = array("admin", "administrator", "operator", "manager", "root");
		if(in_array($str, $forbidden)){
			echo "0__Username tidak boleh digunakan";
		}else{

			$check = $this->morganisasi_model->check_username($str);
			if($check>0){
				echo "0__Username telah digunakan";
			}else{
				echo "1__Username dapat digunakan";
			}
		}
	}

	function check_username2($str){
		if(!preg_match('/[\\|`~\s\/}{\]\[!@#$%^&*()-+=?><,]/i', $str)){
			$forbidden = array("admin", "administrator", "operator", "manager", "root");
			if(in_array($str, $forbidden)){
				$this->form_validation->set_message('check_username2', 'Username tidak boleh digunakan');
				return FALSE;
			}else{
				$check = $this->morganisasi_model->check_username($str);
				if($check>0){
					$this->form_validation->set_message('check_username2', 'Username telah digunakan');
					return FALSE;
				}else{
					return TRUE;
				}
			}
		}else{
			$this->form_validation->set_message('check_username2', 'Username hanya boleh menggunakan huruf, angka, titik dan garis bawah');
			return FALSE;
		}
	}

	function check_pass2($str){
		$regex1=preg_match('/[A-Z]/', $str);
		$regex2=preg_match('/[a-z]/', $str);
		$regex3=preg_match('/[0-9]/', $str);


		 if (!$regex1 || !$regex2 || !$regex3){
			if(!$regex1==true)
			{
				$this->form_validation->set_message('check_pass2', 'Format password harus kombinasi huruf besar');
			}
			else if(!$regex2==true)
			{
				$this->form_validation->set_message('check_pass2', 'Format password harus kombinasi huruf kecil');
			}
			else
			{
				$this->form_validation->set_message('check_pass2', 'Format password harus kombinasi angka');
			}
			return FALSE;
		 }
		 else{
			return TRUE;
 		 }
  	}

	function unset_session()
	{
		if($this->morganisasi_model->finishsession()){
			$this->session->unset_userdata('id_session');
			echo"1";
		}else{
			echo "error";
		}
	}

	function profile_doedit(){
        $this->form_validation->set_rules('nama','Nama Lengkap Penanggung Jawab','trim|required');
        $this->form_validation->set_rules('jabatan','Jabatan Penanggung Jawab','trim|required');
        //$this->form_validation->set_rules('nomor_sik','Nomor SIK Penanggung Jawab','trim|required');
        $this->form_validation->set_rules('phone_number','Nomor Telepon Penanggung Jawab','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			if($this->morganisasi_model->update_profile()){

				$this->morganisasi_model->update_status();

				echo "1";
			}else{
				echo "Simpan Data Error";
			}
		}
	}

	function profile_dopasswd(){
		$this->form_validation->set_rules('npassword','Password Baru','trim|required|min_length[5]|matches[cpassword]|callback_check_pass2');
		$this->form_validation->set_rules('cpassword', 'Konfirmasi Password', 'trim|required');

		if($this->form_validation->run()== FALSE){
			// $this->session->set_flashdata('alert', "".validation_errors());
			echo validation_errors();
			// redirect(base_url()."sik/profile");
		}else{
			if($this->morganisasi_model->check_password()){
    			$username =$this->session->userdata('username');
				if(!$this->morganisasi_model->update_password($username)) {
					// $this->session->set_flashdata('alert', 'Save data failed...');
					echo "Save data failed...";
				} else {
					// echo "Password berhasil disimpan";
					echo "1";
					// $this->session->set_flashdata('alert', 'Password berhasil disimpan');
				}

				// redirect(base_url()."sik/profile");
			}else{
				// $this->session->set_flashdata('alert', 'Password lama salah...');
				// redirect(base_url()."sik/profile");
				echo "Password lama salah...";
			}
		}
	}

	function valid_captcha($str)
	{
	  $expiration = time()-3600;
	  $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
	  $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ?
	  AND ip_address = ? AND captcha_time > ?";
	  $binds = array($str, $this->input->ip_address(), $expiration);
	  $query = $this->db->query($sql, $binds);
	  $row = $query->row();
	  if ($row->count == 0)
	  {
		  $this->form_validation->set_message('valid_captcha', 'Captcha did not match');
		  return FALSE;
	  }else{
		  return TRUE;
	  }
	}


	function login()
	{
		$this->form_validation->set_rules('kode', 'Puskesmas', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if($this->form_validation->run()){
			$this->user->login();
		}else{
			if($this->session->userdata('logged_in')){
				redirect(base_url());
			}
		}

		$data['title_group']	="Login";
		$data['title_form']		="Login";

		$data['content'] = $this->parser->parse("sik/login",$data,true);

		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

		$bln = (int) date('m');
		$thn = date('Y');

		$this->template->show($data,'home');
	}

	function logout()
	{
		$this->user->logout();
	}
}
