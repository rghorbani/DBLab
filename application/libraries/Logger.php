<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ShareCode
 *
 * 
 */


/**
 * ShareCode Logger Class
 *
 */
class SC_Logger {

	var $CI;
	var $ACTIVE;
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model("Logs_model","Logs");
		$this->ACTIVE = DO_MAKE_LOGS;
	}
	/**
	 * Log
	 */
	public function log($user_id, $src, $dst, $method, $param) {
		if ($this->ACTIVE == FALSE) return; // letting it go!
		$this->CI->Logs->write($user_id, $src, $dst, $method, $param, nowDate(), $this->CI->input->ip_address());
	}
	
	function getLogsCount_user($user_id) {
		return $this->CI->Logs->getLogsCount_user($user_id);
	}
	
	function getLogs($user_id, $start, $limit) {
		return $this->CI->Logs->getLogs($user_id, $start, $limit);
	}
}

// END SC_Log class

/* End of file Logger.php */
/* Location: ./application/libraries/Logger.php */
