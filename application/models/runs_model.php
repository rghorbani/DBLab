<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Runs_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function newRun($user_id, $section_id, $problem_id, $source, $lang, $time, $length) {
		if ($lang == 13) { // April's fool
			$sql = "INSERT INTO runs VALUES (NULL, ?, ?, ?, ?, ?, 11, 0, 0, 'SyntaxError: Please check your grammer.', ?, ?)";
			$query = $this->db->query($sql, array(intval($user_id), intval($section_id), intval($problem_id), $source, intval($lang), $time, actualLength($source)));
			return;
		}
		$sql = "INSERT INTO runs VALUES (NULL, ?, ?, ?, ?, ?, 0, 0, 0, '', ?, ?)";
		$query = $this->db->query($sql, array(intval($user_id), intval($section_id), intval($problem_id), $source, intval($lang), $time, actualLength($source)));
	}
	function getList($user_id, $from, $n) {
		$sql = "SELECT runs.*, judge_result.label AS result_label, languages.name AS lang_label FROM runs, judge_result, languages WHERE runs.lang=languages.id AND runs.result=judge_result.id AND user_id = ? ORDER BY runs.time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($user_id), intval($from), intval($n)));
		return $query->result();
	}
	
	function getList_problem($problem_id, $from, $n) {
		$sql = "SELECT users.name as user_name, runs.*, judge_result.label AS result_label, languages.name AS lang_label FROM runs, judge_result, languages, users WHERE runs.lang=languages.id AND runs.result=judge_result.id AND problem_id = ? AND users.id = runs.user_id ORDER BY runs.time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($problem_id), intval($from), intval($n)));
		return $query->result();
	}
	
	function getACCList_problem($problem_id, $from, $n, $sort_by = '', $sort_order = '') {
		$sortq = 'ORDER BY runs.time DESC';
		if ($sort_by != '') {
			$sortq = 'ORDER BY runs.' . $sort_by;
			if ($sort_order == 'DE') $sortq .= ' DESC';
			else $sortq .= ' ASC';
		}
		$sql = "SELECT users.name as user_name, runs.*, judge_result.label AS result_label, languages.name AS lang_label FROM runs, judge_result, languages, users WHERE runs.result = 4 AND runs.lang=languages.id AND runs.result=judge_result.id AND problem_id = ? AND users.id = runs.user_id " . $sortq . " LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($problem_id), intval($from), intval($n)));
		return $query->result();
	}
	
	function getList_all($from, $n) {
		$sql = "SELECT users.name as user_name, runs.*,judge_result.label AS result_label, languages.name AS lang_label, sections.url AS url FROM runs,judge_result, languages, users, sections WHERE runs.lang=languages.id AND runs.result=judge_result.id AND users.id = runs.user_id AND sections.id = runs.section_id ORDER BY runs.time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($from), intval($n)));
		return $query->result();
	}
	
	function getCount($user_id) {
		$sql = "SELECT COUNT(*) as count FROM runs WHERE user_id = ?";
		$query = $this->db->query($sql, array(intval($user_id)));
		$res = $query->row();
		return $res->count;
	}
	
	
	function getCount_problem($problem_id) {
		$sql = "SELECT COUNT(*) as count FROM runs WHERE problem_id = ?";
		$query = $this->db->query($sql, array(intval($problem_id)));
		$res = $query->row();
		return $res->count;
	}
	
	function getACCCount_problem($problem_id) {
		$sql = "SELECT COUNT(*) as count FROM runs WHERE runs.result=4 AND problem_id = ?";
		$query = $this->db->query($sql, array(intval($problem_id)));
		$res = $query->row();
		return $res->count;
	}
	
	function getCount_user($user_id) {
		$sql = "SELECT COUNT(*) as count FROM runs WHERE user_id = ?";
		$query = $this->db->query($sql, array(intval($user_id)));
		$res = $query->row();
		return $res->count;
	}
	
	function getACCCount_user($user_id) {
		$sql = "SELECT COUNT(*) as count FROM runs WHERE runs.result=4 AND user_id = ?";
		$query = $this->db->query($sql, array(intval($user_id)));
		$res = $query->row();
		return $res->count;
	}
	
	function getList_user($user_id, $from, $n) {
		$sql = "SELECT users.name as user_name, runs.*, judge_result.label AS result_label, languages.name AS lang_label, sections.url AS url FROM runs, judge_result, languages, users, sections WHERE runs.lang=languages.id AND runs.result=judge_result.id AND runs.user_id = ? AND users.id = runs.user_id AND sections.id = runs.section_id ORDER BY runs.time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($user_id), intval($from), intval($n)));
		return $query->result();
	}
	
	function getACCList_user($user_id, $from, $n, $sort_by = '', $sort_order = '') {
		$sql = "SELECT users.name as user_name, runs.*, judge_result.label AS result_label, languages.name AS lang_label, sections.url AS url FROM runs, judge_result, languages, users, sections WHERE runs.result = 4 AND runs.lang=languages.id AND runs.result=judge_result.id AND runs.user_id = ? AND users.id = runs.user_id AND sections.id = runs.section_id ORDER BY runs.time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($user_id), intval($from), intval($n)));
		return $query->result();
	}
	
	function getCount_all() {
		$sql = "SELECT COUNT(*) as count FROM runs";
		$query = $this->db->query($sql);
		$res = $query->row();
		return $res->count;
	}
	
	function getQueue() {
		$sql = "SELECT * FROM runs WHERE result = 0 AND NOT EXISTS(SELECT id FROM runs WHERE result=3) ORDER BY time LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() != 1) return NULL;
		return $query->row();
	}
	
	function updateRunStatus($run_id, $result) {
		$sql = "UPDATE runs SET result = ? WHERE id = ?";
		$query = $this->db->query($sql, array(intval($result), intval($run_id)));
	}
	
	function getRun($run_id) {
		$sql = "SELECT runs.*, judge_result.label AS result_label, languages.name AS language, users.name AS user_name, sections.url AS url FROM runs, judge_result, languages, users, sections WHERE result=judge_result.id AND runs.id = ? AND languages.id=runs.lang AND users.id = runs.user_id AND sections.id = runs.section_id";
		$query = $this->db->query($sql, array(intval($run_id)));
		if ($query->num_rows() != 1) return NULL;
		return $query->row();
	}
	function updateResult($run_id, $time, $memory, $result, $ce) {
		$sql = "UPDATE runs SET run_time = ?, run_memory = ?, result = ?, info = ? WHERE id = ?";
		$query = $this->db->query($sql, array(intval($time), intval($memory), intval($result), $ce, intval($run_id)));
	}
	
	function getRunsByTimePID($start, $end, $pids) {
		$sql = "SELECT * FROM runs WHERE time BETWEEN ? AND ? AND problem_id IN (" . implode(",", $pids) . ") ORDER BY time";
		$query = $this->db->query($sql, array($start, $end));
		return $query->result();
	}
	
	/*
	function getCountByTimePID($user_id, $start, $end, $pids) {
		$sql = "SELECT COUNT(*) AS count FROM runs WHERE time BETWEEN ? AND ? AND problem_id IN (" . implode(",", $pids) . ") AND user_id = ?";
		$query = $this->db->query($sql, array($start, $end, intval($user_id)));
		$res = $query->row();
		return $res->count;
	}
	
	*/
	function getUserContestRunsCount($user_id, $contest_id) {
		$sql = "SELECT count(*) AS count FROM runs WHERE runs.user_id=? AND runs.problem_id IN (SELECT problem_id FROM contest_problem WHERE contest_id=?) AND time BETWEEN (SELECT starttime FROM contests WHERE contests.id=?) AND (SELECT DATE_ADD(starttime, INTERVAL length second) FROM contests WHERE contests.id=?)";
		$query = $this->db->query($sql, array(intval($user_id), intval($contest_id), intval($contest_id), intval($contest_id)));
		$res = $query->row();
		return $res->count;
	}
	
	function getUserContestRunsList($user_id, $contest_id, $from, $n) {
		$sql = "SELECT runs.*, judge_result.label AS result_label, languages.name AS lang_label FROM runs, judge_result, languages WHERE runs.lang=languages.id AND runs.result=judge_result.id AND runs.user_id=? AND runs.problem_id IN (SELECT problem_id FROM contest_problem WHERE contest_id=?) AND time BETWEEN (SELECT starttime FROM contests WHERE contests.id=?) AND (SELECT DATE_ADD(starttime, INTERVAL length second) FROM contests WHERE contests.id=?) ORDER BY time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($user_id), intval($contest_id), intval($contest_id), intval($contest_id), intval($from), intval($n)));
		return $query->result();
	}
	
	
	function getAllContestRunsCount($contest_id) {
		$sql = "SELECT count(*) AS count FROM runs WHERE runs.problem_id IN (SELECT problem_id FROM contest_problem WHERE contest_id=?) AND time BETWEEN (SELECT starttime FROM contests WHERE contests.id=?) AND (SELECT DATE_ADD(starttime, INTERVAL length second) FROM contests WHERE contests.id=?)";
		$query = $this->db->query($sql, array(intval($contest_id), intval($contest_id), intval($contest_id)));
		$res = $query->row();
		return $res->count;
	}
	
	function getAllContestRunsList($contest_id, $from, $n) {
		$sql = "SELECT users.name AS user_name, runs.*, judge_result.label AS result_label, languages.name AS lang_label FROM runs, judge_result, languages, users WHERE users.id=runs.user_id AND runs.lang=languages.id AND runs.result=judge_result.id AND runs.problem_id IN (SELECT problem_id FROM contest_problem WHERE contest_id=?) AND time BETWEEN (SELECT starttime FROM contests WHERE contests.id=?) AND (SELECT DATE_ADD(starttime, INTERVAL length second) FROM contests WHERE contests.id=?) ORDER BY time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($contest_id), intval($contest_id), intval($contest_id), intval($from), intval($n)));
		return $query->result();
	}
	
	/*
	function getListByTimePID($user_id, $start, $end, $pids, $from, $n) {
		$sql = "SELECT runs.*, judge_result.label AS result_label, languages.name AS lang_label FROM runs, judge_result, languages WHERE runs.lang=languages.id AND runs.result=judge_result.id AND user_id = ? AND time BETWEEN ? AND ? AND problem_id IN (" . implode(",", $pids) . ") ORDER BY runs.time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($user_id), $start, $end ,intval($from), intval($n)));
		return $query->result();
	}
	*/
	function rejudge($rid) {
		$sql = "SELECT problem_id, user_id, result FROM runs WHERE id=?";
		$query = $this->db->query($sql, array(intval($rid)));
		$inf = $query->row();
		$sql = "UPDATE runs SET result=0 WHERE id=?";
		$query = $this->db->query($sql, array(intval($rid)));
		$sql = "SELECT COUNT(*) AS num FROM runs WHERE result=4 AND user_id=? AND problem_id=?";
		$query = $this->db->query($sql, array(intval($inf->user_id), intval($inf->problem_id)));
		$acc = $query->row();
		if ($acc->num==0){
			$sql = "DELETE FROM user_acc WHERE user_id=? AND problem_id=?";
			$query = $this->db->query($sql, array(intval($inf->user_id), intval($inf->problem_id)));
		}
		$sql = "UPDATE problems SET sub_counter=sub_counter-1 WHERE code=?";
		if ($inf->result == 4) $sql = "UPDATE problems SET acc_counter=acc_counter-1, sub_counter=sub_counter-1 WHERE code=?";
		$query = $this->db->query($sql, array(intval($inf->problem_id)));
	}
	
	function delete($rid) {
		$sql = "SELECT problem_id, user_id, result FROM runs WHERE id=?";
		$query = $this->db->query($sql, array(intval($rid)));
		$inf = $query->row();
		if ($inf == FALSE) return FALSE;
		$sql = "DELETE FROM runs WHERE id=?";
		$query = $this->db->query($sql, array(intval($rid)));
		$sql = "SELECT COUNT(*) AS num FROM runs WHERE result=4 AND user_id=? AND problem_id=?";
		$query = $this->db->query($sql, array(intval($inf->user_id), intval($inf->problem_id)));
		$acc = $query->row();
		if ($acc->num==0){
			$sql = "DELETE FROM user_acc WHERE user_id=? AND problem_id=?";
			$query = $this->db->query($sql, array(intval($inf->user_id), intval($inf->problem_id)));
		}
		$sql = "UPDATE problems SET sub_counter=sub_counter-1 WHERE code=?";
		if ($inf->result == 4) $sql = "UPDATE problems SET acc_counter=acc_counter-1, sub_counter=sub_counter-1 WHERE code=?";
		$query = $this->db->query($sql, array(intval($inf->problem_id)));
	}
}
