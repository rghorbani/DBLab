<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function checkUser($username, $password) {
		$sql = "SELECT users.is_valid, users.picture, users.id, username, email, name, school, perm_problem_setter, perm_judge, perm_create_contest, perm_moderator, last_submit, theme AS theme_id, themes.dir AS theme_name, default_compiler, show_compiler, show_email, username_changes FROM users, themes WHERE themes.id=users.theme AND username = ? AND password = ?";
		$query = $this->db->query($sql, array(clean4print($username), $password)); 
		if ($query->num_rows() != 1) return FALSE;
		return $query->row();
	}
	
	function updateUsernamePassword($user_id, $username, $password) {
		$sql = "UPDATE users SET username=? , password=? WHERE id=?";
		$query = $this->db->query($sql, array($username, $password, intval($user_id)));
	}
	function removeReservedUsername($username) {
		$sql = "DELETE FROM reserved_usernames WHERE username=?";
		$query = $this->db->query($sql, array($username));
	}
	function decreaseUsernameChanges($user_id) {
		$sql = "UPDATE users SET username_changes=username_changes-1 WHERE id=?";
		$query = $this->db->query($sql, array(intval($user_id)));
	}
	function getUserById($user_id) {
		$sql = "SELECT users.is_valid, users.picture, users.id, username, email, name, school, default_compiler, perm_problem_setter, perm_judge, perm_create_contest, perm_moderator, last_submit FROM users WHERE id=?";
		$query = $this->db->query($sql, array(intval($user_id)));
		if ($query->num_rows() != 1) return NULL;
		return $query->row();
	}
	
	function getDefaultCompilerById($user_id) {
		$sql = "SELECT default_compiler FROM users WHERE id=?";
		$query = $this->db->query($sql, array($user_id));
		if ($query->num_rows() != 1) return -1;
		return $query->row()->default_compiler;
	}
	
	function getUserAccCount($user_id) {
		$sql = "SELECT COUNT(*) AS num FROM user_acc WHERE user_id = ?";
		$query = $this->db->query($sql, array(intval($user_id)));
		return $query->row()->num;
	}
	
	function usernameExists($username) {
		$sql = "SELECT id FROM users WHERE username = ? UNION SELECT id FROM reserved_usernames WHERE username = ?";
		$query = $this->db->query($sql, array($username, $username));
		if ($query->num_rows() != 0) return TRUE;
		return FALSE;
	}
	
	function userIDExists($user_id) {
		$sql = "SELECT id FROM users WHERE id = ?";
		$query = $this->db->query($sql, array(intval($user_id)));
		if ($query->num_rows() != 1) return FALSE;
		return TRUE;
	}
	
	function addAcc($user_id, $problem_id) {
		$sql = "REPLACE INTO user_acc VALUES(?, ?)";
		$query = $this->db->query($sql, array(intval($user_id), intval($problem_id)));
	}
	
	function addUser($username, $password, $email, $name, $school, $key, $is_valid = 0, $perm_problem_setter = 0, $perm_judge = 0, $perm_create_contest = 0, $perm_moderator = 0, $theme = DEFUALT_THEME_ID, $image = DEFUALT_USER_IMAGE, $default_compiler = DEFUALT_COMPILER, $show_compiler = DEFUALT_SHOWCOMPILER, $show_email = DEFUALT_SHOWEMAIL, $username_changes=DEFAULT_USERNAME_CHANGES) {
		$sql = "INSERT INTO users VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array(clean4print($username), hashPassword($password, clean4print($username)), clean4print($email), intval($is_valid), intval($username_changes), $key, clean4print($name), clean4print($school), $image, intval($theme), intval($default_compiler), intval($show_compiler), intval($show_email), $perm_problem_setter, $perm_judge, $perm_create_contest, $perm_moderator));
	}
	
	function getTopRank_acc() {
		$sql = "SELECT users.name, users.id, (SELECT COUNT(*) FROM user_acc WHERE user_id = users.id) AS acc FROM users ORDER BY acc DESC LIMIT 0, 15";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function getTopRank_act($from, $to) {
		$sql = "SELECT users.name, users.id, (SELECT COUNT(DISTINCT problem_id) FROM runs A WHERE A.user_id = users.id AND A.result=4 AND A.time BETWEEN ? AND ? AND NOT EXISTS(SELECT id FROM runs R WHERE R.result=4 AND R.user_id=users.id AND R.problem_id = A.problem_id AND R.time<?)) AS acc FROM users ORDER BY acc DESC LIMIT 0, 15";
		$query = $this->db->query($sql, array($from, $to, $from));
		return $query->result();
	}
	
	function updatePassword($user_id, $password, $username) {
		$sql = "UPDATE users SET password = ? WHERE id = ?";
		$query = $this->db->query($sql, array(hashPassword($password, $username), $user_id));
	}
	
	function updateLastSubmit($user_id, $date) {
		$sql = "UPDATE users SET last_submit = ? WHERE id = ?";
		$query = $this->db->query($sql, array($date, intval($user_id)));
	}
	
	function getUserProfile($user_id) {
		$sql = "SELECT id, username, name, email, default_compiler, show_email, show_compiler, picture, school, (select count(*) from runs where user_id=users.id) AS submit_count, (select count(*) from user_acc where user_id = users.id) AS acc_count FROM users WHERE id = ?";
		$query = $this->db->query($sql, array(intval($user_id)));
		if ($query->num_rows() == 0) return NULL;
		return $query->row();
	}
	
	function getIdByUsername($username) {
		$sql = "SELECT id FROM users WHERE username = ?";
		$query = $this->db->query($sql, array($username));
		if ($query->num_rows() == 0) return NULL;
		return $query->row()->id;
	}
	
	function getUserRank_acc($user_id) {
		$sql = "SELECT count(*)+1 AS rank FROM (SELECT count(*) AS num FROM user_acc GROUP BY user_id) T WHERE num > (SELECT COUNT(*) FROM user_acc WHERE user_id=?)";
		$query = $this->db->query($sql, array(intval($user_id)));
		return $query->row()->rank;
	}
	
	function getTotalUserAcc($user_id) {
		$sql = "SELECT problem_id AS code FROM user_acc WHERE user_acc.user_id = ?";
		$query = $this->db->query($sql, array(intval($user_id)));
		return $query->result();
	}
	
	function getUserRank_act($user_id, $from, $to) {
		$sql = "SELECT count(*)+1 AS rank FROM (SELECT COUNT(DISTINCT problem_id) AS num FROM runs A WHERE A.result=4 AND A.time BETWEEN ? AND ? AND NOT EXISTS(SELECT id FROM runs R WHERE R.result=4 AND R.user_id=A.user_id AND R.problem_id = A.problem_id AND R.time< ? ) GROUP BY A.user_id) T WHERE T.num > (SELECT COUNT(DISTINCT problem_id) FROM runs M WHERE M.result=4 AND M.user_id = ? AND M.time BETWEEN ? AND ? AND NOT EXISTS(SELECT id FROM runs MR WHERE MR.user_id = ? AND MR.result=4 AND MR.problem_id = M.problem_id AND MR.time< ? ))";
		$query = $this->db->query($sql, array($from, $to, $from, intval($user_id), $from, $to, intval($user_id), $from));
		return $query->row()->rank;
	}
	
	function getTotalUserAct($user_id, $from, $to) {
		$sql = "SELECT DISTINCT problem_id AS code FROM runs A WHERE A.user_id = ? AND A.result=4 AND A.time BETWEEN ? AND ? AND NOT EXISTS(SELECT id FROM runs R WHERE R.result=4 AND R.user_id=? AND R.problem_id = A.problem_id AND R.time<?)";
		$query = $this->db->query($sql, array(intval($user_id), $from, $to, intval($user_id), $from));
		return $query->result();
	}
	
	function getTotalUsers() {
		$sql = "SELECT count(*) AS num FROM users";
		$query = $this->db->query($sql);
		return $query->row()->num;
	}
	
	function getUserNames($users) {
		if (count($users) == 0) return array();
		$sql = "SELECT id, name FROM users WHERE id IN(" . implode(",", $users) . ")";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function updatePicture($user_id, $picture) {
		$sql = "UPDATE users SET picture=? WHERE id=?";
		$query = $this->db->query($sql, array($picture, intval($user_id)));
	}
	
	function updateUserProfile($user_id, $name, $school) {
		$sql = "UPDATE users SET name=? , school=? WHERE id=?";
		$query = $this->db->query($sql, array(clean4print($name), clean4print($school), intval($user_id)));
	}

	function updateGeneralSettings($user_id, $defaultCompiler, $show_compiler) {
		$sql = "UPDATE users SET default_compiler=? , show_compiler=? WHERE id=?";
		$query = $this->db->query($sql, array(intval($defaultCompiler), intval($show_compiler), intval($user_id)));
	}
	function changeShowEmail($user_id, $show_email) {
		$sql = "UPDATE users SET show_email=? WHERE id=?";
		$query = $this->db->query($sql, array(intval($show_email), intval($user_id)));
	}
	function updateEmail($user_id, $email, $is_valid, $show_email) {
		$sql = "UPDATE users SET email=? , is_valid=?, show_email=? WHERE id=?";
		$query = $this->db->query($sql, array(clean4print($email), intval($is_valid), intval($show_email), intval($user_id)));
	}
	
	function insertValidationRecord($user_id, $key) {
		$sql = "UPDATE users SET activation_key=? WHERE id=?";
		$query = $this->db->query($sql, array($key, intval($user_id)));
	}
	
	function getValidationKey($user_id) {
		$sql = "SELECT activation_key FROM users WHERE id=?";
		$query = $this->db->query($sql, array(intval($user_id)));
		return $query->row()->activation_key;
	}
	
	function key_exists($key) {
		$sql = "SELECT COUNT(*) AS num FROM users WHERE activation_key=? AND is_valid=0";
		$query = $this->db->query($sql, array($key));
		if ($query->row()->num == 1) return TRUE;
		return FALSE;
	}
	
	function validate($key) {
		$sql = "UPDATE users SET is_valid=1 WHERE activation_key=? AND is_valid=0";
		$query = $this->db->query($sql, array($key));
	}
	
	function getUsersByEmail($email) {
		$sql = "SELECT id, username, name, school, email, is_valid FROM users WHERE email=?";
		$query = $this->db->query($sql, array(clean4print($email)));
		return $query->result();
	}
	
	function addRecovery($user_id, $key) {
		$sql = "REPLACE INTO recovery VALUES(?, ?)";
		$query = $this->db->query($sql, array(intval($user_id), $key));
	}
	
	function deleteRecovery($user_id, $key) {
		$sql = "DELETE FROM recovery WHERE user_id=? AND recovery.key=?";
		$query = $this->db->query($sql, array(intval($user_id), $key));
	}
	
	function getRecovery($key) {
		$sql = "SELECT * FROM recovery WHERE recovery.key=?";
		$query = $this->db->query($sql, array(clean4print($key)));
		if ($query->num_rows() != 1) return NULL;
		return $query->row();
	}
	
	function deleteOldCaptcha() {
		$sql = "DELETE FROM captcha WHERE time<?";
		$query = $this->db->query($sql, array(nowTS()-CAPTCHA_LIFETIME));
	}
	
	function newCaptcha($word, $hash, $time) {
		$sql = "INSERT INTO captcha VALUES(NULL, ?, ?, ?)";
		$query = $this->db->query($sql, array($word, $hash, $time));
	}
	
	function captchaValid($word, $hash) {
		$sql = "SELECT COUNT(*) AS num FROM captcha WHERE word=? AND hash=?";
		$query = $this->db->query($sql, array($word, $hash));
		$result = $query->row()->num;
		$sql = "DELETE FROM captcha WHERE hash=?";
		$query = $this->db->query($sql, array($hash));
		if ($result == 0) return FALSE;
		return TRUE;
	}
	
	function getAllUsers() {
		$sql = "SELECT id, users.name, users.username FROM users";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function addReservedUsername($username) {
		$sql = "INSERT INTO reserved_usernames VALUES(NULL, ?)";
		$query = $this->db->query($sql, array($username));
	}
}
