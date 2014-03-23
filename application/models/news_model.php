<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function getNewsCount() {
		$sql = "SELECT COUNT(*) AS count FROM news";
		$query = $this->db->query($sql);
		return $query->row()->count;
	}

	function newsExists($id) {
		$sql = "SELECT id FROM news WHERE news.id=?";
		$query = $this->db->query($sql,array(intval($id)));
		return $query->num_rows() == 1;
	}

	function getNews($from, $n) {
		$sql = "SELECT *, news.content AS content FROM news WHERE visible = 1 ORDER BY news.priority, news.time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($from), intval($n)));
		return $query->result();
	}
	
	function getNewsList($from, $n) {
		$sql = "SELECT news.* FROM news ORDER BY news.priority, news.time DESC LIMIT ?, ?";
		$query = $this->db->query($sql, array(intval($from), intval($n)));
		return $query->result();
	}
	
	function addNews($uid,$pri,$visible,$title,$content) {
		$sql = "INSERT INTO news VALUES(NULL, ?, ?, ?, ?, ?, NULL)";
		$query = $this->db->query($sql, array(intval($uid),intval($pri),intval($visible),$title,$content));
	}
	
	function deleteNews($id) {
		$sql = "DELETE FROM news WHERE id = ?";
		$query = $this->db->query($sql, array(intval($id)));
	}
}
