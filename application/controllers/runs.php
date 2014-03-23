<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Runs extends SC_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Problemset_model','Problems');
		$this->load->model('Runs_model','Runs');
	}
	
	public function my($current_page = NULL) {
		$this->require_login();
		redirect("runs/user/" . $this->current_user->id);
		return;
		// OLD
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) {
			show_404();
		}
		
		$total_runs = $this->Runs->getCount($this->current_user->id);
		$total_pages = ceil($total_runs/RUNS_PER_PAGE);
		
		if ($current_page > $total_pages && $total_runs != 0) {
			redirect("runs/status", 'location');
			return;
		}
		
		$data["title"] = "My Runs :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		
		$data["runs"] = $this->Runs->getList($this->current_user->id, ($current_page-1)*RUNS_PER_PAGE, RUNS_PER_PAGE);
		$this->master_view("runs/list", $data);
	}
	
	public function problem($sections_url = NULL, $problem_id = NULL, $current_page = NULL) {
		if ($sections_url == NULL || $problem_id == NULL || !is_numeric($problem_id)) show_404();
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) show_404();
		if ($this->current_user && $this->current_user->perm_problem_setter) {
			$problem = $this->Problems->getProblem_force($sections_url, $problem_id);
		}else {
			$problem = $this->Problems->getProblem($sections_url, $problem_id);
		}
		if ($problem == NULL) show_404();
		$total_runs = $this->Runs->getCount_problem($problem->code);
		$total_pages = ceil($total_runs/RUNS_PER_PAGE);
		
		if ($current_page > $total_pages && $total_runs != 0) show_404();
		
		$data["title"] = "Problem #" . $problem->code . " Runs :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		$data['url'] = $sections_url;
		$data["problem"] = $problem;
		$data["runs"] = $this->Runs->getList_problem($problem->code, ($current_page-1)*RUNS_PER_PAGE, RUNS_PER_PAGE);
		$this->master_view("runs/problem_runs", $data);
	}
	
	public function acc_problem($sections_url, $problem_id = NULL, $current_page = NULL) {
		if ($sections_url == NULL || $problem_id == NULL || !is_numeric($problem_id)) show_404();
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) show_404();
		if ($this->current_user && $this->current_user->perm_problem_setter) {
			$problem = $this->Problems->getProblem_force($sections_url, $problem_id);
		}else {
			$problem = $this->Problems->getProblem($sections_url, $problem_id);
		}
		if ($problem == NULL) show_404();
		$acc_runs = $this->Runs->getACCCount_problem($problem->code);
		$total_pages = ceil($acc_runs/RUNS_PER_PAGE);
		
		if ($current_page > $total_pages && $acc_runs != 0) show_404();
		
		$data["title"] = "Problem #" . $problem->code . " Accepted Runs :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		$data['url'] = $sections_url;
		$data["problem"] = $problem;
		
		// information for presentation of sorted information! ;)
		$data["sorted_by"] = '';
		$sort_by = '';
		if ($this->input->get('sort') == 'length') {
			$data["sorted_by"] = 'length';
			$sort_by = 'code_length';
		}else if ($this->input->get('sort') == 'time') {
			$data["sorted_by"] = 'time';
			$sort_by = 'run_time';
		}else if ($this->input->get('sort') == 'date') {
			$data["sorted_by"] = 'date';
			$sort_by = 'time';
		}else if ($this->input->get('sort') == 'memory') {
			$data["sorted_by"] = 'memory';
			$sort_by = 'run_memory';
		}else if ($this->input->get('sort') == 'lang') {
			$data["sorted_by"] = 'lang';
			$sort_by = 'lang';
		}
		$data["in_order"] = '';
		$sort_order = '';
		if ($this->input->get('order') == 'ac') {
			$data["in_order"] = 'ac';
			$sort_order = 'AC';
		}else if ($this->input->get('order') == 'de') {
			$data["in_order"] = 'de';
			$sort_order = 'DE';
		}
		
		$data["runs"] = $this->Runs->getACCList_problem($problem->code, ($current_page-1)*RUNS_PER_PAGE, RUNS_PER_PAGE, $sort_by, $sort_order);
		$this->master_view("runs/accepted_runs", $data);
	}
	
	public function user($user_id = NULL, $current_page = NULL) {
		if ($user_id == NULL || !is_numeric($user_id)) show_404();
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) show_404();
		$this->load->model("Users_model","Users");
		if ($this->Users->userIDExists($user_id) == FALSE) show_404();
		$total_runs = $this->Runs->getCount_user($user_id);
		$total_pages = ceil($total_runs/RUNS_PER_PAGE);
		
		if ($current_page > $total_pages && $total_runs != 0) show_404();
		
		$data["title"] = "User #" . $user_id . " Runs :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		// $user = "";
		$user = new stdClass();
		$user->id = $user_id;
		$data["user"] = $user;
		$data["total_pages"] = $total_pages;
		$data["runs"] = $this->Runs->getList_user($user_id, ($current_page-1)*RUNS_PER_PAGE, RUNS_PER_PAGE);
		$this->master_view("runs/user_runs", $data);
	}
	
	public function acc_user($user_id = NULL, $current_page = NULL) {
		if ($user_id == NULL || !is_numeric($user_id)) show_404();
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) show_404();
		$this->load->model("Users_model","Users");
		if ($this->Users->userIDExists($user_id) == FALSE) show_404();
		$total_runs = $this->Runs->getACCCount_user($user_id);
		$total_pages = ceil($total_runs/RUNS_PER_PAGE);
		
		if ($current_page > $total_pages && $total_runs != 0) show_404();
		
		$data["title"] = "User #" . $user_id . " Accepted Runs :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		// $user = "";
		$user = new stdClass();
		$user->id = $user_id;
		$data["user"] = $user;
		$data["total_pages"] = $total_pages;
		$data["runs"] = $this->Runs->getACCList_user($user_id, ($current_page-1)*RUNS_PER_PAGE, RUNS_PER_PAGE);
		$this->master_view("runs/user_accruns", $data);
	}
	
	public function all($current_page = NULL) {
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) show_404();
		$total_runs = $this->Runs->getCount_all();
		$total_pages = ceil($total_runs/RUNS_PER_PAGE);
		
		if ($current_page > $total_pages && $total_runs != 0) show_404();
		
		$data["title"] = "All Runs :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		$data["runs"] = $this->Runs->getList_all(($current_page-1)*RUNS_PER_PAGE, RUNS_PER_PAGE);
		$this->master_view("runs/all_runs", $data);
	}
	
	public function source($id = NULL) {
		$this->require_login();
		if ($id == NULL || !is_numeric($id)) show_404();
		$run = $this->Runs->getRun($id);
		if ($run == NULL) show_404();
		if ($run->user_id != $this->current_user->id && !$this->current_user->perm_judge) show_404();
		$data["run"]=$run;
		$data["title"]="View Source :: " . $run->id;
		$this->master_view("runs/view_source", $data);
	}
	
	public function status($id = NULL) {
		if ($id == NULL || !is_numeric($id)) show_404();
		$run = $this->Runs->getRun($id);
		if ($run == NULL) show_404();
		$show_ce = FALSE;
		if ($this->current_user != FALSE && $run->user_id == $this->current_user->id) $show_ce = TRUE;
		if ($this->current_user != FALSE && $this->current_user->perm_judge) $show_ce = TRUE;
		echo('
{
	"id": "' . $run->id . '",
	"result": "' . $run->result . '",
	"result_label": "' . $run->result_label . '",
	"memory": "' . $run->run_memory . '",
	"time": "' . $run->run_time . '",
	"show_ce": "' . ($show_ce?"true":"false") . '",
	"ce_info": "' . htmlspecialchars(str_replace(array("\n", "\""), array("<br />","'"), ($show_ce?$run->info:''))) . '"
}
');
	}
}
