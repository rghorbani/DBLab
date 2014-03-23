<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discussion_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function getTopicPostsCount($topic_id) {
		// +1 is for the topic first post
		$sql = "SELECT COUNT(*)+1 as count FROM discussions WHERE parent=? AND visible=1";
		$query = $this->db->query($sql, array(intval($topic_id)));
		$res = $query->row();
		return $res->count;
	}
	
	function getTopicsCount($problemId) {
		$sql = "SELECT COUNT(*) as count FROM discussions WHERE problem_id=? AND parent=-1 AND visible=1";
		$query = $this->db->query($sql, array(intval($problemId)));
		$res = $query->row();
		return $res->count;
	}

	function getTopicPosts($topic_id, $from, $to) {
		$sql = "SELECT discussions.*, users.name, users.picture FROM discussions, users WHERE users.id=discussions.user_id AND visible=1 AND (discussions.parent=? OR discussions.id=?) ORDER BY time LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($topic_id), intval($topic_id), intval($from), intval($to)));
		return $query->result();
	}
	
	function getTopicsByProblemId($problemId, $from, $to) {
		$sql = "SELECT T.*, users.name, (SELECT count(*) FROM discussions D WHERE D.parent=T.id AND D.visible=1) as replies FROM discussions T, users WHERE users.id=T.user_id AND T.problem_id=? AND parent=-1 AND visible=1 ORDER BY time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($problemId), intval($from), intval($to)));
		return $query->result();
	}

	function getPostById($id) {
		$sql = "SELECT discussions.*, users.name, users.picture FROM discussions, users WHERE users.id=discussions.user_id AND discussions.id=? AND visible=1";
		$query = $this->db->query($sql, array(intval($id)));
		if ($query->num_rows() == 0) return NULL;
		return $query->row();
	}

	function deletePostById($id) {
		$sql = "UPDATE discussions SET visible=0 WHERE id=?";
		$query = $this->db->query($sql, array(intval($id)));
		return $query;
	}
	
	function deleteTopic($tid) {
		$sql = "UPDATE discussions SET visible=0 WHERE (id=? OR parent=?)";
		$query = $this->db->query($sql, array(intval($tid), intval($tid)));
	}
	
	function newDiscussion($pid, $uid, $subject, $text, $date, $hash, $parent) {
		$sql = "INSERT INTO discussions VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, 1)";
		$query = $this->db->query($sql, array(intval($pid), clean4print($subject), $text, intval($uid), $date, intval($parent), $hash));
		$sql = "SELECT id FROM discussions where problem_id=? AND text=? AND user_id=? AND time=? AND hash=? AND visible=1";
		$query = $this->db->query($sql, array(intval($pid), $text, intval($uid), $date, $hash));
		$id = $query->row();
		return $id->id;
	}

	function newPost($tid, $pid, $uid, $text, $date, $hash) {
		return $this->newDiscussion($pid, $uid, '@', $text, $date, $hash, $tid);
	}
	
	
	function newTopic($pid, $uid, $subject, $text, $date, $hash) {
		return $this->newDiscussion($pid, $uid, $subject, $text, $date, $hash, -1);
	}
	

}
