<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problemset_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function getCount($sid) {
		$sql = "SELECT COUNT(*) as count FROM problems WHERE is_visible = 1 AND section_id = ?";
		$query = $this->db->query($sql, array(intval($sid)));
		$res = $query->row();
		return $res->count;
	}
	
	function getCountAll($sid) {
		$sql = "SELECT COUNT(*) as count FROM problems WHERE section_id = ?";
		$query = $this->db->query($sql, array(intval($sid)));
		$res = $query->row();
		return $res->count;
	}
	
	function getList($from, $n, $section) {
		$sql = "SELECT * FROM problems WHERE is_visible = 1 AND problems.section_id = ? AND section_id = ? ORDER BY problems.code LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($sid), intval($section), intval($from), intval($n)));
		return $query->result();
	}
	
	function getList_user($from, $n, $uid, $section) {
		$sql = "SELECT problems.*, EXISTS(SELECT id FROM runs WHERE runs.problem_id=problems.code AND runs.user_id = ?) AS user_submitted, EXISTS(SELECT id FROM runs WHERE runs.problem_id=problems.code AND runs.user_id = ? AND runs.result=4) AS user_accepted FROM problems WHERE is_visible = 1 AND section_id = ? AND problems.section_id = ? ORDER BY problems.code LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($uid), intval($uid), intval($sid), intval($section), intval($from), intval($n)));
		return $query->result();
	}
	
	function getListAll($from, $n, $section) {
		$sql = "SELECT * FROM problems WHERE problems.section_id = ? ORDER BY problems.code LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($section), intval($from), intval($n)));
		return $query->result();
	}
	
	function getListAll_user($from, $n, $uid, $section) {
		$sql = "SELECT problems.*, EXISTS(SELECT id FROM runs WHERE runs.problem_id=problems.code AND runs.user_id = ?) AS user_submitted, EXISTS(SELECT id FROM runs WHERE runs.problem_id=problems.code AND runs.user_id = ? AND runs.result=4) AS user_accepted FROM problems WHERE section_id = ? ORDER BY problems.code LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($uid), intval($uid), intval($section), intval($from), intval($n)));
		return $query->result();
	}
	
	
	function codeExists($code) {
		$sql = "SELECT code FROM problems WHERE is_visible = 1 AND code = ?";
		$query = $this->db->query($sql, array(intval($code)));
		if ($query->num_rows() != 0) return TRUE;
		return FALSE;
	}
	
	function codeExistsAll($code) {
		$sql = "SELECT code FROM problems WHERE code = ?";
		$query = $this->db->query($sql, array(intval($code)));
		if ($query->num_rows() != 0) return TRUE;
		return FALSE;
	}
	
	function getSources() {
		$sql = "SELECT * FROM sources WHERE (SELECT COUNT(code) FROM problems WHERE problems.source_id=sources.id)>0 ORDER BY id";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getSourcesAll() {
		$sql = "SELECT * FROM sources ORDER BY id";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getSourcesStat() {
		$sql = "SELECT sources.id, sources.label, (SELECT COUNT(code) FROM problems WHERE source_id = sources.id AND problems.is_visible=1) AS num FROM sources WHERE (SELECT COUNT(code) FROM problems WHERE source_id = sources.id AND problems.is_visible=1)>0 ORDER BY id";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getSourcesStatAll() {
		$sql = "SELECT sources.id, sources.label, (SELECT COUNT(code) FROM problems WHERE source_id = sources.id) AS num FROM sources ORDER BY id";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function addSource($label) {
		$sql = "INSERT INTO sources VALUES(NULL, ?)";
		$query = $this->db->query($sql, array($label));
	}
	
	function getSourceNum($id) {
		$sql = "SELECT COUNT(code) AS num FROM problems WHERE source_id = ?";
		$query = $this->db->query($sql, array(intval($id)));
		return $query->row()->num;
	}
	
	function deleteSource($id) {
		$sql = "DELETE FROM sources WHERE id = ?";
		$query = $this->db->query($sql, array(intval($id)));
	}
	
	function addProblem($code, $section_id, $name, $time_limit, $memory_limit, $statement, $input, $output, $sample_input, $sample_output, $hint, $source_id, $is_special, $is_visible, $user_id) {
		$sql = "INSERT INTO problems VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, ?)";
		$query = $this->db->query($sql, array(intval($code), intval($section_id), $name, $statement, $input, $output, $sample_input, $sample_output, $hint, intval($source_id), intval($is_special), intval($is_visible), intval($memory_limit), intval($time_limit), intval($user_id)));
	}
	
	function updateProblem($code, $section_id, $name, $time_limit, $memory_limit, $statement, $input, $output, $sample_input, $sample_output, $hint, $source_id, $is_special, $is_visible, $user_id) {
		$sql = "UPDATE problems SET code = ? , section_id = ? , name = ? , statement = ?, input = ?, output = ?, sample_input = ?, sample_output = ?, hint = ?, source_id = ?, special_judge = ?, is_visible = ?, memory_limit = ?, time_limit = ?, user_id = ? WHERE code = ? AND section_id = ? ";
		$query = $this->db->query($sql, array(intval($code), intval($section_id), $name, $statement, $input, $output, $sample_input, $sample_output, $hint, intval($source_id), intval($is_special), intval($is_visible), intval($memory_limit), intval($time_limit), intval($user_id), intval($code), intval($section_id)));
	}
	
	function updateSpecialJudge($code, $to) {
		$sql = "UPDATE problems SET special_judge = ? WHERE code = ?";
		$query = $this->db->query($sql, array(intval($to), intval($code)));
	}
	
	function updateVisible($url, $code, $to) {
		$sql = "UPDATE problems SET is_visible = ? WHERE code = ? AND section_id = (SELECT id from sections WHERE url = ?)";
		$query = $this->db->query($sql, array(intval($to), intval($code), $url));
	}
	function getProblem_force($section_url, $code) {
		$sql = "SELECT problems.*, sources.label AS source_label, sections.id AS section_id FROM problems, sources, sections WHERE sections.url = ? AND sections.id = problems.section_id AND problems.code = ? AND problems.source_id=sources.id";
		$query = $this->db->query($sql, array($section_url, intval($code)));
		if ($query->num_rows() != 1) return NULL;
		return $query->row();
	}
	function getProblem($section_url, $code) {
		$sql = "SELECT problems.*, sources.label AS source_label FROM problems, sources, sections WHERE sections.url = ? AND sections.id = problems.section_id AND problems.code = ? AND is_visible=1 AND problems.source_id=sources.id";
		$query = $this->db->query($sql, array($section_url, intval($code)));
		if ($query->num_rows() != 1) return NULL;
		
		return $query->row();
	}
	
	function searchProblemsAll($q) {
		$q = $this->db->escape_like_str($q);
		$sql = "SELECT * FROM problems WHERE name LIKE ?";
		$query = $this->db->query($sql, array('%'.$q.'%'));
		return $query->result();
	}
	function searchProblemsAll_user($q, $uid) {
		$q = $this->db->escape_like_str($q);
		$sql = "SELECT *, EXISTS(SELECT id FROM runs WHERE runs.problem_id=problems.code AND runs.user_id = ?) AS user_submitted, EXISTS(SELECT id FROM runs WHERE runs.problem_id=problems.code AND runs.user_id = ? AND runs.result=4) AS user_accepted FROM problems WHERE name LIKE ?";
		$query = $this->db->query($sql, array(intval($uid), intval($uid), '%'.$q.'%'));
		return $query->result();
	}
	function searchProblems($q) {
		$q = $this->db->escape_like_str($q);
		$sql = "SELECT * FROM problems WHERE name LIKE ? AND is_visible=1";
		$query = $this->db->query($sql, array('%'.$q.'%'));
		return $query->result();
	}
	function searchProblems_user($q, $uid) {
		$q = $this->db->escape_like_str($q);
		$sql = "SELECT *, EXISTS(SELECT id FROM runs WHERE runs.problem_id=problems.code AND runs.user_id = ?) AS user_submitted, EXISTS(SELECT id FROM runs WHERE runs.problem_id=problems.code AND runs.user_id = ? AND runs.result=4) AS user_accepted FROM problems WHERE name LIKE ? AND is_visible=1";
		$query = $this->db->query($sql, array(intval($uid), intval($uid), '%'.$q.'%'));
		return $query->result();
	}
	function getLangs() {
		$sql = "SELECT * FROM languages ORDER BY id";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function isLangExists($id) {
		$sql = "SELECT id FROM languages WHERE id = ?";
		$query = $this->db->query($sql, array(intval($id)));
		if ($query->num_rows() == 1) return TRUE;
		return FALSE;
	}
	function getLang($id) {
		$sql = "SELECT * FROM languages WHERE id = ?";
		$query = $this->db->query($sql, array(intval($id)));
		if ($query->num_rows() == 0) return NULL;
		return $query->row();
	}
	function plusAcc($problem_id) {
		$sql = "UPDATE problems SET acc_counter = acc_counter+1, sub_counter = sub_counter+1 WHERE code = ?";
		$query = $this->db->query($sql, array(intval($problem_id)));
	}
	
	function plusSubmits($problem_id) {
		$sql = "UPDATE problems SET sub_counter = sub_counter+1 WHERE code = ?";
		$query = $this->db->query($sql, array(intval($problem_id)));
	}
}
