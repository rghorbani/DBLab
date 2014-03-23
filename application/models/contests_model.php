<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contests_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	
	function getList($from_time, $to_time) {
		$sql = "SELECT contests.*, (SELECT COUNT(*) FROM contest_problem WHERE contest_id=contests.id) AS problem_num FROM contests WHERE confirmed=1 AND DATE_ADD(starttime, INTERVAL length second)	 BETWEEN ? AND ? ORDER BY DATE_ADD(starttime, INTERVAL 0 second)";
		$query = $this->db->query($sql, array($from_time, $to_time));
		return $query->result();
	}
	
	function getLastFinished() {
		$sql = "SELECT *,(SELECT COUNT(*) FROM contest_problem WHERE contest_id=contests.id) AS problem_num FROM contests WHERE confirmed=1 AND DATE_ADD(starttime, INTERVAL length second)<? ORDER BY DATE_ADD(starttime, INTERVAL length second) DESC LIMIT 1";
		$query = $this->db->query($sql, array(nowDate()));
		if ($query->num_rows() == 0) return NULL;
		return $query->row();
	}
	
	function getFinishedCount() {
		$sql = "SELECT COUNT(*) AS num FROM contests WHERE confirmed=1 AND DATE_ADD(starttime, INTERVAL length second)<?";
		$query = $this->db->query($sql, array(nowDate()));
		return $query->row()->num;
	}
	
	function getFinishedList($from, $to) {
		$sql = "SELECT contests.*, (SELECT COUNT(*) FROM contest_problem WHERE contest_id=contests.id) AS problem_num FROM contests WHERE confirmed=1 AND DATE_ADD(starttime, INTERVAL length second)<? ORDER BY DATE_ADD(starttime, INTERVAL length second) DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(nowDate(), intval($from), intval($to)));
		return $query->result();
	}
	
	function addContest($label, $starttime, $length, $user_id, $desc, $confirm=0, $vranklist = -1) {
		$now = nowDate();
		$sql = "INSERT INTO contests VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array($label, $starttime, intval($length), intval($user_id), intval($confirm), $now, $desc, intval($vranklist)));
		$sql = "SELECT MAX(id) AS id FROM contests WHERE label = ? AND starttime = ? AND length = ? AND user_id = ? AND confirmed = ? AND create_date = ?";
		$query = $this->db->query($sql, array($label, $starttime, intval($length), intval($user_id), intval($confirm), $now));
		return $query->row()->id;
	}
	
	function addContestProblems($contest_id, $problem_id, $letter, $color) {
		$sql = "INSERT INTO contest_problem VALUES(?, ?, ?, ?)";
		$query = $this->db->query($sql, array(intval($contest_id), intval($problem_id), $letter, $color));
	}
	
	function getProblems($contest_id) {
		$sql = "SELECT * FROM contest_problem WHERE contest_id = ?";
		$query = $this->db->query($sql, array(intval($contest_id)));
		return $query->result();
	}
	
	function getContest($contest_id) {
		$sql = "SELECT *, (SELECT COUNT(*) FROM contest_problem WHERE contest_id=contests.id) AS problem_num FROM contests WHERE id = ? AND confirmed = 1";
		$query = $this->db->query($sql, array(intval($contest_id)));
		if ($query->num_rows() != 1) return NULL;
		return $query->row();
	}
	function getContest_f($contest_id) {
		$sql = "SELECT *,(SELECT COUNT(*) FROM contest_problem WHERE contest_id=contests.id) AS problem_num FROM contests WHERE id = ?";
		$query = $this->db->query($sql, array(intval($contest_id)));
		if ($query->num_rows() != 1) return NULL;
		return $query->row();
	}
	function confirm($contest_id) {
		$sql = "UPDATE contests SET confirmed=1 WHERE id = ?";
		$query = $this->db->query($sql, array(intval($contest_id)));
	}
	function getContestProblems($contest_id) {
		$sql = "SELECT * FROM contest_problem, problems WHERE problems.code = contest_problem.problem_id AND contest_problem.contest_id = ? AND problems.section_id = 1 ORDER BY contest_problem.letter";
		$query = $this->db->query($sql, array(intval($contest_id)));
		return $query->result();
	}
	function getContestProblemByLetter($contest_id, $problem_letter) {
		$sql = "SELECT contest_problem.*, problems.*, sources.label AS source_label FROM contest_problem, problems, sources WHERE sources.id = problems.source_id AND problems.code = contest_problem.problem_id AND problems.section_id = 1 AND contest_problem.contest_id = ? AND contest_problem.letter = ?";
		$query = $this->db->query($sql, array(intval($contest_id), $problem_letter));
		if ($query->num_rows() != 1) return NULL;
		return $query->row();
	}
	
	function addVirtualTeam_getId($team_name) {
		$this->db->trans_start();
		$sql = "INSERT INTO virtual_team VALUES (NULL, ?)";
		$query = $this->db->query($sql, array(clean4print($team_name)));
		$sql = "SELECT max(id) AS id FROM virtual_team WHERE name=?";
		$query = $this->db->query($sql, array(clean4print($team_name)));
		$result = $query->row()->id;
		$this->db->trans_complete();
		return $result;
	}
	
	function addVirtualRanklist_getId($label) {
		$this->db->trans_start();
		$sql = "INSERT INTO virtual_ranklist VALUES (NULL, ?)";
		$query = $this->db->query($sql, array(clean4print($label)));
		$sql = "SELECT max(id) AS id FROM virtual_ranklist WHERE label=?";
		$query = $this->db->query($sql, array(clean4print($label)));
		$result = $query->row()->id;
		$this->db->trans_complete();
		return $result;
	}
	
	function addVirtualRun($cid, $tid, $letter, $time, $att) {
		$sql = "INSERT INTO virtual_runs VALUES (NULL, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array(intval($tid), intval($cid), clean4print($letter), intval($time), intval($att)));
	}
	
	function getVirtualRunsByTime($cid, $seconds) {
		$sql = "SELECT virtual_runs.*, virtual_team.name FROM virtual_runs, virtual_team WHERE virtual_runs.team_id=virtual_team.id AND virtual_contest_id=? AND virtual_runs.time<?";
		$query = $this->db->query($sql, array(intval($cid), intval($seconds)));
		return $query->result();
	}
	
	function getVirtualRanklists() {
		$sql = "SELECT * FROM virtual_ranklist";
		$query = $this->db->query($sql);
		return $query->result();
	}
}
