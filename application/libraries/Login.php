<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ShareCode
 *
 * 
 */

// ------------------------------------------------------------------------

/**
 * ShareCode Login Class
 *
 */
class SC_Login {

	var $CI;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model("Users_model","Users");
		$this->CI->load->library("Userdata","userdata");
	}

	// --------------------------------------------------------------------

	/**
	 * Login
	 */
	function login($username, $password_org) {
		$cleaned_username = clean4username($username);
		$password = hashPassword($password_org, clean4print($username));
		$user = $this->CI->Users->checkUser($username, $password);
		if ($cleaned_username == $username) {
			if (!$user) {
				$this->CI->userdata->unset_data('username');
				$this->CI->userdata->unset_data('password');
				return FALSE;
			}
			$this->CI->userdata->set_data('username', $username);
			$this->CI->userdata->set_data('password', $password);
			return $user;
		}
	
		if ($user) {
			$password = hashPassword($password_org, $cleaned_username);
			$this->CI->Users->updateUsernamePassword($user->id, $cleaned_username, $password);
			$user = $this->CI->Users->checkUser($cleaned_username, $password);
			$this->CI->userdata->set_data('username', $cleaned_username);
			$this->CI->userdata->set_data('password', $password);
			$this->CI->Users->removeReservedUsername($cleaned_username);
			return $user;
		}
		
		$password = hashPassword($password_org, clean4print($cleaned_username));
		$user = $this->CI->Users->checkUser($cleaned_username, $password);
		if (!$user) return FALSE;
		$this->CI->userdata->set_data('username', $cleaned_username);
		$this->CI->userdata->set_data('password', $password);
		return $user;
	}
	
	function checkPassword($username, $password) {
		$password = hashPassword($password, $username);
		$user = $this->CI->Users->checkUser($username, $password);
		if (!$user) {
			return FALSE;
		}
		return TRUE;
	}
	
	function logout() {
		$this->CI->userdata->unset_data('username');
		$this->CI->userdata->unset_data('password');		
	}
	
	// deprecated
	function isLogin() {
		if (!$this->CI->userdata->data('username') || !$this->CI->userdata->data('password')) return FALSE;
		if ($this->loginNoHash($this->CI->userdata->data('username'), $this->CI->userdata->data('password')) == FALSE) return FALSE;
		return TRUE;
	}
	
	// deprecated
	function getCurrentUser() {
		return $this->loginNoHash($this->CI->userdata->data('username'), $this->CI->userdata->data('password'));
	}
	
	function loginNoHash($username, $password) {
		$user = $this->CI->Users->checkUser($username, $password);
		if (!$user) {
			return FALSE;
		}
		$this->CI->userdata->set_data('username', $username);
		$this->CI->userdata->set_data('password', $password);
		return $user;
	}
	
	// currently in use :)
	function checkAndGet() {
		if (!$this->CI->userdata->data('username') || !$this->CI->userdata->data('password')) return FALSE;
		return $this->loginNoHash($this->CI->userdata->data('username'), $this->CI->userdata->data('password'));
	}
	
	function loginJudge() {
		if (!$this->CI->input->post('username') || !$this->CI->input->post('password')) show_404();
		if ($this->CI->input->post('username') != 'rashnu1' || hashPassword($this->CI->input->post('password'), 'rashnu1') != '49738e5f5301fb11a4108f25b06ee3c695e154a7') show_404();
		return TRUE;
		/*
		49738e5f5301fb11a4108f25b06ee3c695e154a7
		rima-doonheb-edocerahs
		rashnu1
		*/
	}
	
}

// END SC_Login class

/* End of file Login.php */
/* Location: ./application/libraries/Login.php */
