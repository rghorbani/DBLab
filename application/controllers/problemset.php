<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problemset extends SC_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Problemset_model','Problems');
		$this->load->library('form_validation');
	}
	
	public function index()	{
		$this->page(1);
	}
	
	public function page($current_page = 1) {
		$current_page = intval($current_page);
		if ($current_page < 1) {
			show_404();
		}
		if ($this->current_user && $this->current_user->perm_problem_setter) {
			$total_problems = $this->Problems->getCountAll();
		}else {
			$total_problems = $this->Problems->getCount();
		}
		$total_pages = ceil($total_problems/PROBLEMS_PER_PAGE);
		
		
		if ($current_page > $total_pages) {
			redirect("problemset", 'location');
			return;
		}
		
		$data["title"] = "Problemset :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		
		if ($this->current_user && $this->current_user->perm_problem_setter) {
			$data["problems"] = $this->Problems->getListAll_user(($current_page-1)*PROBLEMS_PER_PAGE, PROBLEMS_PER_PAGE, $this->current_user->id);
		}else if ($this->current_user) {
			$data["problems"] = $this->Problems->getList_user(($current_page-1)*PROBLEMS_PER_PAGE, PROBLEMS_PER_PAGE, $this->current_user->id);
		}else {
			$data["problems"] = $this->Problems->getList(($current_page-1)*PROBLEMS_PER_PAGE, PROBLEMS_PER_PAGE);
		}
		
		$this->master_view("problemset/list", $data);
	}
	
	public function view($code = NULL) {
		if ($code == NULL || !is_numeric($code)) show_404();
		$code = intval($code);
		if ($this->current_user != FALSE && $this->current_user->perm_problem_setter) {
			$problem = $this->Problems->getProblem_force($code);
		}else {
			$problem = $this->Problems->getProblem($code);
		}
		if ($problem == NULL) show_404();
		$data["title"] = "Problem #" . $code . " :: " . $problem->name;
		$data["problem"] = $problem;
		$this->master_view("problemset/problem_view", $data);
	}
	
	public function search() {
		if ($this->input->post("q") != FALSE) redirect('problemset/search/?q=' . $this->input->post("q"));
		$q = $this->input->get("q");
		if ($q == FALSE) redirect('problemset');
		if (is_numeric($q)) {
			if ($this->current_user && $this->current_user->perm_problem_setter) {
				$problem = $this->Problems->getProblem_force($q);
			}else {
				$problem = $this->Problems->getProblem($q);
			}
			if ($problem != NULL) {
				redirect('problemset/view/' . intval($q));
				return;
			}
		}
		if ($this->current_user && $this->current_user->perm_problem_setter) {
			$problems = $this->Problems->searchProblemsAll_user($q, $this->current_user->id);
		}else if ($this->current_user) {
			$problems = $this->Problems->searchProblems_user($q, $this->current_user->id);
		}else {
			$problems = $this->Problems->searchProblems($q);
		}
		if (count($problems) == 1) {
			redirect('problemset/view/' . $problems[0]->code);
			exit;
		}
		$data["title"] = "Search Result";
		$data["result"] = $problems;
		$this->master_view('problemset/search', $data);
	}
	
	public function submit($code = NULL) {
		if ($code == NULL || !is_numeric($code)) show_404();
		$this->require_login();
		if ($this->current_user->perm_problem_setter) {
			$problem = $this->Problems->getProblem_force($code);
		}else {
			$problem = $this->Problems->getProblem($code);
		}
		if ($problem == NULL) show_404();
		
		if (!$this->require_validate()) return;
		$data["title"] = "Submit Solution";
		
		if ($this->form_validation->run('problemset/submit') == FALSE) {
			$data["langs"] = $this->Problems->getLangs();
			$data["problem"] = $problem;
			$this->master_view('problemset/submit', $data);
			return;
		}
		$this->load->model('Runs_model','Runs');
		$this->Runs->newRun($this->current_user->id, $code, $this->input->post("source_code"), $this->input->post("language"), nowDate(), -1);
		$this->Users->updateLastSubmit($this->current_user->id, nowDate());
		redirect('problemset/queue/' . $code, 'locatoin');
	}
	
	public function queue($code = NULL) {
		if ($code == NULL || !is_numeric($code)) show_404();
		$this->require_login();
		if ($this->current_user->perm_problem_setter) {
			$problem = $this->Problems->getProblem_force($code);
		}else {
			$problem = $this->Problems->getProblem($code);
		}
		if ($problem == NULL) show_404();
		$data["title"] = "Redirecting ...";
		$data["problem"] = $problem;
		$this->master_view('problemset/under_judgement', $data);
	}
	
	// used for form validation in submit - returns FALSE where the lang not exists
	public function _lang_exists($id) {
		if ($this->Problems->isLangExists($id) == FALSE) {
			$this->form_validation->set_message('_lang_exists', 'Choose your language!');
			return FALSE;
		}
		return TRUE;
	}
	
	public function _time_check($dummy) {
		if (nowTS()-date2ts($this->current_user->last_submit)<SUBMIT_DELAY_TIME) {
			$this->form_validation->set_message('_time_check', 'You have submitted too quick! wait 10 seconds and try again!');
			return FALSE;
		}
		return TRUE;
	}
}
