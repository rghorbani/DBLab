<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function write($uid, $src, $dst, $method, $param, $time, $ip) {
		$sql = "INSERT INTO logs VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array(intval($uid), clean4print($src), clean4print($dst), clean4print($time), clean4print($method), clean4print($ip), $param));
	}
	
	function getLogsCount_user($user_id) {
		$sql = "SELECT count(*) AS num FROM logs WHERE user_id=?";
		$query = $this->db->query($sql, array(intval($user_id)));
		return $query->row()->num;
	}
	
	function getLogs($user_id, $from, $n) {
		$sql = "SELECT * FROM logs WHERE user_id = ? ORDER BY logs.time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($user_id), intval($from), intval($n)));
		return $query->result();
	}
}
