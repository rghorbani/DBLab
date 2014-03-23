<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Clars_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function newClar($user_id, $problem_id, $contest_id, $question, $date, $answer = "", $to_all = 0) {
		$sql = "INSERT INTO clars VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array(intval($user_id), intval($problem_id), intval($contest_id), nl2br(clean4print($question)), nl2br(clean4print($answer)), intval($to_all), $date));
	}
	
	
	function getUserClars($user_id, $contest_id) {
		$sql = "SELECT * FROM clars, contest_problem WHERE clars.cid = contest_problem.contest_id AND pid=problem_id AND cid=? AND (uid=? OR toall=1) UNION ALL SELECT *, '', '', '', '' FROM clars WHERE clars.pid=-1 AND clars.cid=? AND (uid=? or toall=1)  ORDER BY id DESC ";
		$query = $this->db->query($sql, array(intval($contest_id), intval($user_id), intval($contest_id), intval($user_id)));
		return $query->result();
	}
	
	function getContestClars($contest_id) {
		$sql = "SELECT * FROM clars, contest_problem WHERE clars.cid = contest_problem.contest_id AND pid=problem_id AND cid=? AND toall=1 UNION ALL SELECT *, '', '', '', '' FROM clars WHERE clars.pid=-1 AND clars.cid=? AND toall=1 ORDER BY id DESC";
		$query = $this->db->query($sql, array(intval($contest_id), intval($contest_id)));
		return $query->result();
	}
	
	function getAllClars($contest_id) {
		$sql = "SELECT clars.*, contest_problem.*, users.name FROM clars, contest_problem, users WHERE clars.uid = users.id AND clars.cid = contest_problem.contest_id AND pid=problem_id AND cid=? UNION ALL SELECT clars.*, '', '', '', '', users.name FROM clars, users WHERE clars.uid = users.id AND clars.pid=-1 AND clars.cid=? ORDER BY date";
		$query = $this->db->query($sql, array(intval($contest_id), intval($contest_id)));
		return $query->result();
	}
	
	function getClars_judge($contest_id) {
		$sql = "SELECT clars.*, contest_problem.*, users.name FROM clars, contest_problem, users WHERE users.id=clars.uid AND clars.cid = contest_problem.contest_id AND pid=problem_id AND cid=? AND answer='' UNION ALL SELECT clars.*, '', '', '', '', users.name FROM clars, users WHERE users.id=clars.uid AND clars.pid=-1 AND clars.cid=? AND answer='' ORDER BY id DESC ";
		$query = $this->db->query($sql, array(intval($contest_id), intval($contest_id)));
		return $query->result();
	}
	
	function answerClar($clar_id, $answer, $to_all) {
		$sql = "UPDATE clars SET answer=? , toall=? WHERE id=?";
		$query = $this->db->query($sql, array(nl2br(clean4print($answer)), intval($to_all), intval($clar_id)));
	}
	
	
}
