<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends SC_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Users_model','Users');
		$this->load->library("Logger");
	}
	
	
	
	public function user($user_id = NULL, $current_page = NULL) {
		$this->require_login();
		if ($this->current_user->perm_moderator != TRUE) show_404();
		if ($user_id == NULL || !is_numeric($user_id)) show_404();
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) show_404();
		$this->load->model("Users_model","Users");
		if ($this->Users->userIDExists($user_id) == FALSE) show_404();
		$total_runs = $this->logger->getLogsCount_user($user_id);
		$total_pages = ceil($total_runs/LOGS_PER_PAGE);
		
		if ($current_page > $total_pages && $total_runs != 0) show_404();
		
		$data["title"] = "User #" . $user_id . " Activities :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		$data["user"] = $this->Users->getUserById($user_id);
		$data["logs"] = $this->logger->getLogs($user_id, ($current_page-1)*LOGS_PER_PAGE, LOGS_PER_PAGE);
		$this->master_view("logs/user", $data);
	}
	
	
	
}
