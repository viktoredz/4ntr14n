<?php
class Setting extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('sms/setting_model');
	}
	
	function index(){
		$data = $this->setting_model->get_data(); 
		$data['title_group'] = "SMS";
		$data['title_form'] = "Setting";

		$data['content'] = $this->parser->parse("sms/setting/setting",$data,true);
		$this->template->show($data,'home');
	}

	function doupdate(){
		$this->form_validation->set_rules('com', 'COM', 'trim|required');
		
		if($this->form_validation->run()== FALSE){
			$this->session->set_flashdata('alert_form', validation_errors());
			redirect(base_url()."sms/setting");
		}elseif($this->setting_model->update_entry()){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."sms/setting");
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."sms/setting");
		}
	}

	function cleaninbox(){
		$this->db->query("TRUNCATE inbox");

		die("<br><br>Inbox sudah dibersihkan.");
	}	

	function cleansent(){
		$this->db->query("TRUNCATE sentitems");

		die("<br><br>Sent Items sudah dibersihkan.");
	}	

	function cleanoutbox(){
		$this->db->query("TRUNCATE outbox");

		die("<br><br>Outbox sudah dibersihkan.");
	}	

	function restart(){
        $this->db->where('key','path');
        $row = $this->db->get('sms_config')->row();
        $path = $row->value;

		$stop = NULL;

		exec($path."gammu-smsd -k",$stop);
		exec($path."gammu-smsd -c smsdrc -s", $hasil);

		foreach ($hasil as $row) {
			echo "<br>".$row;
		}
		
		die();
	}	

	function ussd(){
        $this->db->where('key','path');
        $row = $this->db->get('sms_config')->row();
        $path = $row->value;

		$ussd = $this->input->post('ussd');

		$hasil = NULL;
		$stop = NULL;
	
		exec($path."gammu-smsd -k",$stop);
		
		exec($path."gammu -c ".$path."gammurc getussd ".$ussd, $hasil);
		
		exec($path."gammu-smsd -c smsdrc -s");
		
		$i=0;
		foreach ($hasil as $row) {
			if($i>2) echo "<br>".$row;
			$i++;
		}
		
		die();
	}	

	function identify(){
        $this->db->where('key','path');
        $row = $this->db->get('sms_config')->row();
        $path = $row->value;

		$hasil = NULL;
		$stop = NULL;

		exec($path."gammu-smsd -k",$stop);
		
		exec($path."gammu -c ".$path."gammurc --identify ", $hasil);

		exec($path."gammu-smsd -c smsdrc -s");

		foreach ($hasil as $row) {
			echo "<br>".$row;
		}
		
		die();
	}	

}
