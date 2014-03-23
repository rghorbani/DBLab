<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function addReport($user_id, $message, $time, $ip, $page) {
		$sql = "INSERT INTO reports VALUES(NULL, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array(intval($user_id), $time, clean4print($message), $ip, $page));
	}
	
}
