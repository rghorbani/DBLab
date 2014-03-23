<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	
	function notify($label, $url, $type, $target, $hash, $time, $status, $except) {
		$sql = "INSERT INTO notifications (SELECT NULL, user_id, ?, ?, ?, ?, ?, ?, ? FROM subscriptions WHERE target_id=? AND type=? AND user_id!=?)";
		$query = $this->db->query($sql, array(intval($type), intval($target), $url, $label, intval($status), $time, $hash, intval($target), intval($type), intval($except)));
	}
	
	function getList($user_id) {
		$sql = "SELECT type, url, label, MAX(time) AS moment, COUNT(id) AS count FROM notifications WHERE user_id=? GROUP BY target_id, type ORDER BY moment";
		$query = $this->db->query($sql, array(intval($user_id)));
		return $query->result();
	}
	
	function getListAfter($user_id, $last) {
		$sql = "SELECT type, url, label, MAX(time) AS moment, COUNT(id) AS count FROM notifications WHERE user_id=? AND id>? GROUP BY target_id, type ORDER BY moment";
		$query = $this->db->query($sql, array(intval($user_id), intval($last)));
		return $query->result();
	}
	
	function getUnreadCount($user_id) {
		$sql = "SELECT COUNT(id) AS count FROM notifications WHERE status=1 AND user_id=?";
		$query = $this->db->query($sql, array(intval($user_id)));
		return $query->row()->count;
	}
	
	function markAsRead_uid($user_id) {
		$sql = "UPDATE notifications SET status=0 WHERE user_id=?";
		$query = $this->db->query($sql, array(intval($user_id)));
	}
	
	function deleteNotificationsHash($hash) {
		$sql = "DELETE FROM notifications WHERE hash=?";
		$query = $this->db->query($sql, array($hash));
	}
	
	function addSubscription($user_id, $target_id, $type) {
		$sql = "REPLACE INTO subscriptions VALUES(?, ?, ?)";
		$query = $this->db->query($sql, array(intval($user_id), intval($target_id), intval($type)));
	}
	
	function removeSubscription($user_id, $target_id, $type) {
		$sql = "DELETE FROM subscriptions WHERE user_id=? AND target_id=? AND type=?";
		$query = $this->db->query($sql, array(intval($user_id), intval($target_id), intval($type)));
	}
	
	function isSubscribed($user_id, $target_id, $type) {
		$sql = "SELECT * FROM subscriptions WHERE user_id=? AND target_id=? AND type=?";
		$query = $this->db->query($sql, array(intval($user_id), intval($target_id), intval($type)));
		if ($query->num_rows() == 1) return TRUE;
		return FALSE;
	}
	
	function removeOldNotifications($user_id) {
		$sql = "DELETE FROM notifications WHERE user_id=? AND status=0";
		$query = $this->db->query($sql, array(intval($user_id)));
	}
	
	function getLastId($user_id) {
		$sql = "SELECT MAX(id) AS last FROM notifications WHERE user_id=?";
		$query = $this->db->query($sql, array(intval($user_id)));
		return ($query->row()->last==NULL?0:$query->row()->last);
	}
	
	// CUSTOM FUNCTIONS
	function discussion_deleteTopicNotification($tid) {
		$sql = "DELETE FROM notifications WHERE hash IN (SELECT hash FROM discussions WHERE parent=?)";
		$query = $this->db->query($sql, array(intval($tid)));
	}
	
}
