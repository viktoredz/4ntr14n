<?php

	class User {
		
		var $logged_in 		= false;
		var $username 		= '';
		var $table 			= 'app_users_list';
		var $table_profile 	= 'app_users_profile';
		var $level 			= array();
		var $groups 		= array();
		
		function User()
		{
			$this->obj =& get_instance();
			$this->obj->load->library('encrypt');

			if($this->obj->session->userdata('username') != ""){
				
				$update = array('last_active' => time(), 'online' => 1);
				$user 	= array('username' => $this->obj->session->userdata('username'));
				$this->obj->db->update('app_users_list', $update, $user);

			$update = array('online' => '0');
			$user 	= array('last_active < ' => (time()),'online' => 1 );
			$this->obj->db->update('app_users_list', $update, $user);
			}
		}
		function getnamapuskesmas(){
	        $code = $this->obj->session->userdata('puskesmas');
	        $this->obj->db->where('code','P'.$code);
	        $query = $this->obj->db->get('cl_phc');
	        if ($query->num_rows() > 0 ) {
	        	foreach ($query->result() as $key) {
		            $nama = $key->value;
		        }
	        }else{
	        	$nama = '';
	        }

	        
	        return $code.' - '.$nama;
	    }
		function login($type=""){
			$this->obj->db-> where("(app_users_list.username ='".$this->obj->input->post('username')."' OR app_users_profile.bpjs='".$this->obj->input->post('username')."')");
			$this->obj->db-> where('password', $this->_prep_password($this->obj->input->post('password')));
			$this->obj->db-> join('app_users_profile', 'app_users_profile.username=app_users_list.username AND app_users_profile.code=app_users_list.code','right');
			$user = $this->obj->db-> get($this->table)->row();
			if (!empty($user->username)){
				$this->_start_session($user);
				$this->obj->db-> where('username',$this->obj->session->userdata('username'));
				$p = $this->obj->db-> get($this->table_profile);
				$profile = $p->row();
					

				$update = array('last_login' => time(), 'online' => 1);
				$user 	= array('username' => $user->username);
				$this->obj->db->update('app_users_list', $update, $user);
				$namapuskes     = $this->getnamapuskesmas();
				$this->_log($type." Login $namapuskes successful...");
				$this->obj->session->set_flashdata('notification', 'Login successful...');

				redirect(base_url());
			}else{
				$this->_destroy_session();
				$this->_log($type.' Login failed...');
				$this->obj->session->set_flashdata('notification', 'Login failed...');
				redirect(base_url()."morganisasi/login");
			}
		}
		
		function logout($type="")
		{
			$namapuskes     = $this->getnamapuskesmas();
			$update = array('online' => 0);
			$user 	= array('username' => $this->obj->session->userdata('username'));
			$this->obj->db->update('app_users_list', $update, $user);
			$this->update($this->username, array('online' => 0));

			$this->_log("Logout $namapuskes successful...");
			$this->_destroy_session();
			$this->obj->session->set_flashdata('notification', 'You are now logged out');
			redirect(base_url().$type);
		}
		
		function update($username, $data)
		{
			if (isset($data['password'])){
				$data['password'] = $this->_prep_password($data['password']);
			}
			
			$this->obj->db->where('username', $username);
			$this->obj->db->set($data);
			$this->obj->db->update($this->table);
			
		}
		function recorddeletedata($type){
			$this->_log($type);
		}
		function _log($message,$icon=1){
			if($this->obj->session->userdata('username') =="" ){
				$this->obj->session->set_userdata(array('username' => $_SERVER['REMOTE_ADDR']));
			}
			$data = array('username' => $this->obj->session->userdata('username'), 
				'dtime' => time(), 
				'icon' => $icon, 
				'activity' => $message
			);
			$str = $this->obj->db->insert_string('app_users_activity',$data);
			$this->obj->db->query($str);
		}
		
		function _destroy_session()
		{
			$data = array(
						'username' 		=> '',
						'puskesmas'		=> '',
						'level' 		=> '',
						'nama' 			=> '',
						'puskesmas' 	=> '',
						'logged_in'		=> false
					);
					
			$this->obj->session->unset_userdata($data);
			
			foreach ($data as $key => $value){
				$this->$key = $value;
			}
		}

		function _start_session($user)
		{
			$data = array(
						'username' 		=> $user->username,
						'puskesmas'		=> $user->code, 
						'level'			=> $user->level, 
						'nama'			=> $user->nama,
						'puskesmas'		=> $user->code, 
						'logged_in'		=> true
					);
					
			$this->obj->session->set_userdata($data);
			
		}

		function _prep_password($password)
		{
			return $this->obj->encrypt->sha1($password.$this->obj->config->item('encryption_key'));
		}
		
	}	
