<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contests extends SC_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Problemset_model','Problems');
		$this->load->model('Contests_model','Contests');
		$this->load->library('form_validation');
		$this->problem_letters = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	}
	public function index()	{
		$data["title"] = "Contests";
		$data["current_page"] = -1;
		$data["total_pages"] = ceil($this->Contests->getFinishedCount()/CONTESTS_PER_PAGE);
		$last_finished = $this->Contests->getLastFinished();
		$data["contests"] = $this->Contests->getList(nowDate(), ts2date(nowTS()+24*3600*7*5));//5 weeks, will be changed
		array_unshift($data["contests"],$last_finished);
		$this->master_view("contests/index", $data);
	}
	
	public function page($current_page = NULL) {
		$current_page = intval($current_page);
		if ($current_page == 0) $current_page = 1;
		if ($current_page < 1) {
			show_404();
		}
		
		$total_pages = ceil($this->Contests->getFinishedCount()/CONTESTS_PER_PAGE);
		
		
		if ($current_page > $total_pages) {
			redirect("contests/page/1", 'location');
			return;
		}
		
		$data["title"] = "Past Contests :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		
	
		$data["contests"] = $this->Contests->getFinishedList(($current_page-1)*CONTESTS_PER_PAGE, CONTESTS_PER_PAGE);
		
		$this->master_view("contests/past", $data);
	}
	
	public function vranklists() {
		$this->require_login();
		if ($this->current_user->perm_create_contest == FALSE) show_404();
		$data["title"] = "Virtual Ranklists";
		if ($this->form_validation->run() == FALSE) {
			$data["vranklists"] = $this->Contests->getVirtualRanklists();
			$this->master_view("contests/vranklists", $data);
			return;
		}
		$data["pnum"] = intval($this->input->post("pnum"));
		$data["problem_letters"] = $this->problem_letters;
		$this->master_view("contests/vranklists_new", $data);
		
	}
	
	
	public function addvranklists() {
		$this->require_login();
		if ($this->current_user->perm_create_contest == FALSE) show_404();
		//////////////////////////////////////////////////////////////// TODO: FORM VALIDATOIN NEEDED!!!!!!!!!!!
		$teams = intval($this->input->post("teams"));
		$pnum = intval($this->input->post("pnum"));
		
		$contestId = $this->Contests->addVirtualRanklist_getId($this->input->post("vrlname"));
		for ($i=1;$i<=$teams;$i++) {
			$teamName = $this->input->post("team_name_" . $i);
			$teamId = $this->Contests->addVirtualTeam_getId($teamName);
			
			for ($j=0;$j<$pnum;$j++) {
				if ($this->input->post("team_" . $i . "_" . $this->problem_letters[$j])) {
					$info = $this->input->post("team_" . $i . "_" . $this->problem_letters[$j]);
					$info = explode("/", $info);
					if (count($info) != 2 || !is_numeric($info[0]) || !is_numeric($info[1])) {
						continue;
					}
					$this->Contests->addVirtualRun($contestId, $teamId, $this->problem_letters[$j], $info[1]*60, $info[0]);
				}
			}
		}
	}
	
	public function arrange() {
		$this->require_login();
		if ($this->current_user->perm_create_contest == FALSE) show_404();
		$data["title"] = "Arrange Contest";
		$data["problem_error"] = FALSE;
		$data["vranklists"] = $this->Contests->getVirtualRanklists();
		if ($this->form_validation->run() == FALSE) {
			$this->master_view("contests/arrange", $data);
			return;
		}
		// we have not done form validation yet
		$problems = $this->_get_problems();
		if (count($problems) < 3) {
			$length = count($problems);
			for ($i=$length;$i<=15;$i++) {
				$problems[$i]["code"]  = "";
				$problems[$i]["color"] = "#000000";
			}
			$data["problem_error"] = TRUE;
			$data["valid_problems"] = $problems;
			$this->master_view("contests/arrange", $data);
			return;
		}
		// everything is ok now! at least i hope to!
		$starttime = $this->input->post("starttime_date") . " " . $this->input->post("tH") . ":" . $this->input->post("tM") . ":" . $this->input->post("tS");
		$label = $this->input->post("label");
		$description = $this->input->post("description");
		$length = intval($this->input->post("lH"))*3600+intval($this->input->post("lM"))*60+intval($this->input->post("lS"));
		$contest_id = $this->Contests->addContest($label, $starttime, $length, $this->current_user->id, $description, 0, $this->input->post("vranklist"));
		for ($i=0;$i<count($problems);$i++) {			
			$this->Contests->addContestProblems($contest_id, $problems[$i]["code"], $this->problem_letters[$i], $problems[$i]["color"]); 
		}
		$data["starttime"] = $starttime;
		$data["title"] = "Contest :: Confirmation";
		$data["label"] = $label;
		$data["problems"] = $this->Contests->getContestProblems($contest_id);
		$data["length"] = formatTime($length);
		$data["contest_id"] = $contest_id;
		$this->master_view("contests/confirm", $data);
	}
	
	public function confirm($contest_id = NULL) {
		$this->require_login();
		if ($contest_id == NULL || !is_numeric($contest_id) || $this->current_user->perm_create_contest == FALSE) show_404();
		$contest = $this->Contests->getContest_f($contest_id);
		if ($contest == NULL || $contest->user_id != $this->current_user->id) show_404();
		if (date2ts($contest->starttime)-nowTS() < CONTEST_CREATE_DELAY_TIME) show_404();
		$this->Contests->confirm($contest_id);
		redirect('/contests', 'location');
	}
	
	
	public function view($contest_id = NULL) {
		if ($contest_id == NULL || !is_numeric($contest_id)) show_404();
		$contest = $this->Contests->getContest($contest_id);
		if ($contest == NULL) show_404();
		$data["title"] = "Contest :: " . $contest->label;
		$data["contest"] = $contest;
		$contest->finished = FALSE;
		$contest->ready = FALSE;
		// Ready?
		if (date2ts($contest->starttime) > nowTS()) {
			$contest->ready = TRUE;
			$data["countdown_seconds"] = date2ts($contest->starttime)-nowTS();
			$this->master_view("contests/ready", $data);
			return;
		}
		$data["problems"] = $this->Contests->getContestProblems($contest->id);
		// Finished?
		if (date2ts($contest->starttime)+$contest->length < nowTS()) {
			$contest->finished = TRUE;
			$this->master_view("contests/finished", $data);
			return;
		}
		// else -> In Progress?
		$data["countdown_seconds"] = date2ts($contest->starttime)+$contest->length-nowTS();
		$this->master_view("contests/view", $data);
	}
	
	public function problem($contest_id = NULL, $problem_letter = NULL) {
		if ($contest_id == NULL || !is_numeric($contest_id) || !in_array($problem_letter, $this->problem_letters)) show_404();
		$contest = $this->Contests->getContest($contest_id);
		if ($contest == NULL) show_404();
		
		// Ready?
		$contest->ready = FALSE;
		if (date2ts($contest->starttime) > nowTS()) show_404();
		
		$data["problems"] = $this->Contests->getContestProblems($contest->id);
		
		// Finished?
		$contest->finished = FALSE;
		if (date2ts($contest->starttime)+$contest->length < nowTS()) $contest->finished = TRUE;
		
		$problem = $this->Contests->getContestProblemByLetter($contest->id, $problem_letter);
		if ($problem == NULL) show_404();
		$data["problem"] = $problem;
		$data["title"] = "Contests :: " . $contest->label . " :: Problem " . $problem_letter;
		$data["contest"] = $contest;
		$this->master_view("contests/problem", $data);
	}
	
	private function contest_submit($contest_id = NULL) {
		$this->require_login();
		if ($contest_id == NULL || !is_numeric($contest_id)) show_404();
		$contest = $this->Contests->getContest($contest_id);
		if ($contest == NULL) show_404();
		$contest->ready = false;
		if (date2ts($contest->starttime) > nowTS()) show_404(); // ready ??
		
		$data["title"] = "Contests :: " . $contest->label;
		$data["contest"] = $contest;
		$data["problems"] = $this->Contests->getContestProblems($contest->id);
		
		$contest->finished = FALSE;
		if (date2ts($contest->starttime)+$contest->length<nowTS()) { // finished?
			$contest->finished = TRUE;
			$this->master_view("contests/submit_over", $data);
			return;
		}
		if (!$this->require_validate()) return;
		$data["langs"] = $this->Problems->getLangs();
		
		$data["select_problem_err"] = FALSE;
		if ($this->form_validation->run('contests/contest_submit') == FALSE) {
			$this->master_view('contests/contest_submit', $data);
			return;
		}
		if (!in_array($this->input->post("problem"), $this->problem_letters) || NULL == ($problem = $this->Contests->getContestProblemByLetter($contest->id, $this->input->post("problem")))) {
			$data["select_problem_err"] = TRUE;
			$this->master_view('contests/contest_submit', $data);
			return;
		}
		$this->load->model('Runs_model','Runs');
		$this->Runs->newRun($this->current_user->id, 1, $problem->code, $this->input->post("source_code"), $this->input->post("language"), nowDate(), -1);
		$this->Users->updateLastSubmit($this->current_user->id, nowDate());
		$this->master_view('contests/under_judgement', $data);
	}
	
	public function submit($contest_id = NULL, $problem_letter = NULL, $run_id = NULL) {
		if ($problem_letter == NULL) {
			$this->contest_submit($contest_id);
			return;
		}
		$this->require_login();
		if ($contest_id == NULL || !is_numeric($contest_id) || ($problem_letter != NULL && !in_array($problem_letter, $this->problem_letters))) show_404();
		$contest = $this->Contests->getContest($contest_id);
		if ($contest == NULL) show_404();
		$contest->ready = FALSE;
		if (date2ts($contest->starttime) > nowTS()) show_404(); // ready ??
		$problem = $this->Contests->getContestProblemByLetter($contest->id, $problem_letter);
		if ($problem == NULL) show_404();
		
		
		
		$data["contest"] = $contest;
		$data["problems"] = $this->Contests->getContestProblems($contest->id);
		$data["title"] = "Contests :: " . clean4print($contest->label) . " :: Problem " . $problem_letter;
		$data["problem"] = $problem;
		
		$contest->finished = FALSE;
		if (date2ts($contest->starttime)+$contest->length<nowTS()) { // finished !!
			$contest->finished = TRUE;
			$this->master_view("contests/over", $data);
			return;
		}
		
		if (!$this->require_validate()) return;
		
		if($run_id != NULL) {
			if(!is_numeric($run_id)) show_404();
			$this->load->model('Runs_model','Runs');
			$run = $this->Runs->getRun($run_id);
			if($run == NULL) show_404();
			$data['run'] = $run;
		}
		$data["langs"] = $this->Problems->getLangs();
		$this->master_view("contests/submit", $data);
	}
	
	public function ranklist($contest_id = NULL) {
		if ($contest_id == NULL || !is_numeric($contest_id)) show_404();
		$contest = $this->Contests->getContest($contest_id);
		if ($contest == NULL) show_404();
		
		$contest->ready = FALSE;
		if (date2ts($contest->starttime) > nowTS()) show_404(); // ready ??
		
		$contest->finished = FALSE;
		if (date2ts($contest->starttime)+$contest->length<nowTS()) { // finished !!
			$contest->finished = TRUE;
		}
		
		$data["contest"] = $contest;
		$problems_obj = $this->Contests->getContestProblems($contest->id);
		$data["problems"] = $problems_obj;
		$data["title"] = "Contests :: " . $contest->label . " :: Standing";
		$problems = array();
		$pids = array();
		foreach($problems_obj as $problem) {
			$problems[$problem->code] = $problem->letter;
			$pids[] = $problem->code;
		}
		
		
		
		$this->load->model('Runs_model','Runs');
		$runs = $this->Runs->getRunsByTimePID($contest->starttime, ts2date(date2ts($contest->starttime)+$contest->length), $pids);
		
		$RL = array();
		$users = array();
		$contest_ts = date2ts($contest->starttime);
		foreach($runs as $run) {
			if (!isset($RL[$run->user_id])) {
				$RL[$run->user_id] = new Ranklist_item(count($problems), $this->problem_letters);
				$RL[$run->user_id]->user_id = $run->user_id;
				$users[] = $run->user_id;
			}
			$letter = $problems[$run->problem_id];
			if ($RL[$run->user_id]->states[$letter]["acc"]) continue;
			$RL[$run->user_id]->states[$letter]["submits"]++;
			if ($run->result == 4) { // 4 means accepted
				$RL[$run->user_id]->states[$letter]["acc"] = TRUE;
				$RL[$run->user_id]->states[$letter]["acc_time"] = date2ts($run->time)-$contest_ts;
				$RL[$run->user_id]->all_acc++;
			}
		}
		if ($contest->vranklist != -1) {
			$vruns = $this->Contests->getVirtualRunsByTime($contest->vranklist, nowTS()-date2ts($contest->starttime));
			foreach ($vruns as $vrun) {
				if (!isset($RL["V" . $vrun->team_id])) {
					$RL["V" . $vrun->team_id] = new Ranklist_item(count($problems), $this->problem_letters);
					$RL["V" . $vrun->team_id]->user_id = -1;
					$RL["V" . $vrun->team_id]->is_real = FALSE;
					$RL["V" . $vrun->team_id]->user_name = $vrun->name;
				}
				
				$RL["V" . $vrun->team_id]->states[$vrun->problem_letter]["acc"] = TRUE;
				$RL["V" . $vrun->team_id]->states[$vrun->problem_letter]["submits"] = intval($vrun->att);
				$RL["V" . $vrun->team_id]->states[$vrun->problem_letter]["acc_time"] = intval($vrun->time);
				$RL["V" . $vrun->team_id]->all_acc++;
			}
		}
		
		$user_names = $this->Users->getUserNames($users);
		$users = array();
		foreach($user_names as $user) {
			$users[$user->id] = $user->name;
		}
		foreach($RL as &$item) {
			$p = 0;
			foreach($item->states as $state) {
				if ($state["acc"]) {
					$p+=20*60*($state["submits"]-1)+$state["acc_time"];
				}
			}
			if ($item->is_real) {
				$item->user_name = $users[$item->user_id];
			}
			$item->penalty = $p;
		}
		usort($RL, "ranklist_sort");
		$data["ranklist"] = $RL;
		$data["problem_letters"] = $this->problem_letters;
		
		
		$this->master_view("contests/ranklist", $data);
	}
	
	
	public function clarifications($contest_id = NULL) {
		if ($contest_id == NULL || !is_numeric($contest_id)) show_404();
		$contest = $this->Contests->getContest($contest_id);
		if ($contest == NULL) show_404();
		if (date2ts($contest->starttime) > nowTS()) show_404(); // ready ??
		$data["title"] = "Clarifications";
		$data["contest"] = $contest;
		$data["problems"] = $this->Contests->getContestProblems($contest->id);
		$contest->finished = FALSE;
		$contest->ready = FALSE;
		if (date2ts($contest->starttime)+$contest->length<nowTS()) { // finished?
			$contest->finished = TRUE;
		}
		
		$this->load->model('Clars_model','Clars');
		
		$data["select_problem_err"] = FALSE;
		if ($this->current_user == NULL) {
			$data["clars"] = $this->Clars->getContestClars($contest->id);
			$this->master_view('contests/clars', $data);
			return;
		}
		if ($contest->finished || $this->form_validation->run('contests/clars') == FALSE) {
			if ($this->current_user->perm_judge) { // already logged in!
				$data["clars"] = $this->Clars->getAllClars($contest->id);
			}else {
				$data["clars"] = $this->Clars->getUserClars($this->current_user->id, $contest->id);
			}
			if ($this->current_user->perm_judge) {
				$this->master_view('contests/clars_judge', $data);
			}else {
				$this->master_view('contests/clars', $data);
			}
			return;
		}
		
		if ($this->input->post("problem") != -2 && (!in_array($this->input->post("problem"), $this->problem_letters) || NULL == ($problem = $this->Contests->getContestProblemByLetter($contest->id, $this->input->post("problem"))))) {
			$data["clars"] = $this->Clars->getUserClars($this->current_user->id, $contest->id);
			$data["select_problem_err"] = TRUE;
			if ($this->current_user->perm_judge) {
				$this->master_view('contests/clars_judge', $data);
			}else {
				$this->master_view('contests/clars', $data);
			}
			return;
		}
		if ($this->input->post("problem") == -2) {
			$pid = "-1";
		}else {
			$pid = $problem->code;
		}
		$this->Clars->newClar($this->current_user->id, $pid, $contest->id, $this->input->post("question"), nowDate());
		
		redirect("contests/clarifications/" . $contest->id);
		
	}
	
	
	public function clarjudge($contest_id = NULL) {
		$this->require_login();
		if (!$this->current_user->perm_judge) show_404();
		if ($contest_id == NULL || !is_numeric($contest_id)) show_404();
		$contest = $this->Contests->getContest($contest_id);
		if ($contest == NULL) show_404();
		$contest->ready = FALSE;
		if (date2ts($contest->starttime) > nowTS()) show_404(); // ready ??
		$data["title"] = "Clarifications";
		$data["contest"] = $contest;
		$data["problems"] = $this->Contests->getContestProblems($contest->id);
		$contest->finished = FALSE;
		if (date2ts($contest->starttime)+$contest->length<nowTS()) { // finished?
			$contest->finished = TRUE;
		}
		
		$this->load->model('Clars_model','Clars');
		
		$data["select_problem_err"] = FALSE;
		if ($this->form_validation->run('contests/clarjudge') == FALSE) {
			$data["clars"] = $this->Clars->getClars_judge($contest->id);
			$this->master_view('contests/ansclar_judge', $data);
			return;
		}
		
		if ($this->input->post("answer") == FALSE || $this->input->post("cid") == FALSE) {
			$data["clars"] = $this->Clars->getClars_judge($this->current_user->id, $contest->id);
			$data["select_problem_err"] = TRUE;
			$this->master_view('contests/ansclar_judge', $data);
			return;
		}
		if ($this->input->post("problem") == -2) {
			$pid = "-1";
		}else {
			$pid = $problem->code;
		}
		$to_all = FALSE;
		if ($this->input->post("to_all")) $to_all = TRUE;
		$this->Clars->answerClar($this->input->post("cid"), $this->input->post("answer"), $to_all);
		redirect("contests/clarjudge/" . $contest->id);
		
	}
	
	public function my_runs($contest_id = NULL, $current_page = NULL) {
		$this->require_login();
		if ($contest_id == NULL || !is_numeric($contest_id)) show_404();
		$contest = $this->Contests->getContest($contest_id);
		if ($contest == NULL) show_404();
		$contest->ready = FALSE;
		if (date2ts($contest->starttime) > nowTS()) show_404(); // ready ??
		
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) {
			show_404();
		}
		$problems_obj = $this->Contests->getContestProblems($contest->id);
		$data["problems"] = $problems_obj;
		$problems = array();
		$pids = array();
		foreach($problems_obj as $problem) {
			$problems[$problem->code] = $problem->letter;
			$pids[] = $problem->code;
		}
		$this->load->model('Runs_model','Runs');
		
		$total_runs = $this->Runs->getUserContestRunsCount($this->current_user->id, $contest->id);
		$total_pages = ceil($total_runs/RUNS_PER_PAGE);
		
		if ($current_page > $total_pages && $total_runs != 0) show_404();
		
		$data["title"] = "Contests :: " . $contest->label . " :: My Runs";
		$data["contest"] = $contest;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		$data["contest_problem_letters"] = $problems;
		
		$data["runs"] = $this->Runs->getUserContestRunsList($this->current_user->id, $contest->id, ($current_page-1)*RUNS_PER_PAGE, RUNS_PER_PAGE);
		
		$contest->finished = FALSE;
		if (date2ts($contest->starttime)+$contest->length<nowTS()) { // finished !!
			$contest->finished = TRUE;
		}
		$this->master_view("contests/runs", $data);
		
	}
	
	public function runs($contest_id = NULL, $current_page = NULL) {
		$this->require_login();
		if (!$this->current_user->perm_judge) show_404();
		if ($contest_id == NULL || !is_numeric($contest_id)) show_404();
		$contest = $this->Contests->getContest($contest_id);
		if ($contest == NULL) show_404();
		$contest->ready = FALSE;
		if (date2ts($contest->starttime) > nowTS()) show_404(); // ready ??
		
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) {
			show_404();
		}
		$problems_obj = $this->Contests->getContestProblems($contest->id);
		$data["problems"] = $problems_obj;
		$problems = array();
		$pids = array();
		foreach($problems_obj as $problem) {
			$problems[$problem->code] = $problem->letter;
			$pids[] = $problem->code;
		}
		$this->load->model('Runs_model','Runs');
		$total_runs = $this->Runs->getAllContestRunsCount($contest->id);
		
		$total_pages = ceil($total_runs/RUNS_PER_PAGE);
		
		if ($current_page > $total_pages && $total_runs != 0) show_404();
		
		$data["title"] = "Contests :: " . $contest->label . " :: All Runs";
		$data["contest"] = $contest;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		$data["contest_problem_letters"] = $problems;
		
		$data["runs"] = $this->Runs->getAllContestRunsList($contest->id, ($current_page-1)*RUNS_PER_PAGE, RUNS_PER_PAGE);
		
		$contest->finished = FALSE;
		if (date2ts($contest->starttime)+$contest->length<nowTS()) { // finished !!
			$contest->finished = TRUE;
		}
		$this->master_view("contests/contest_runs", $data);
		
	}
	
	// used for form validation
	public function _check_date_format($date) {
		if (checkDateFormat($date) == FALSE) {
			$this->form_validation->set_message('_check_date_format', 'Choose a valid date!');
			return FALSE;
		}
		return TRUE;
	}
	
	public function _check_contest_date($date) {
		if (date2ts($date)-nowTS()>CONTEST_CREATE_ORDER_TIME) {
			$this->form_validation->set_message('_check_contest_date', 'Choose a date between now and next month!');
			return FALSE;
		}
		return TRUE;
	}
	
	public function _check_hour($hour) {
		if (intval($hour) < 0 || intval($hour) > 23) {
			$this->form_validation->set_message('_check_hour', 'Enter the Hour more carefully!');
			return FALSE;
		}
		return TRUE;
	}
	public function _check_minute($minute) {
		if (intval($minute) < 0 || intval($minute) > 59) {
			$this->form_validation->set_message('_check_minute', 'Enter the Minute more carefully!');
			return FALSE;
		}
		return TRUE;
	}
	public function _check_second($second) {
		if (intval($second) < 0 || intval($second) > 59) {
			return FALSE;
			$this->form_validation->set_message('_check_second', 'Enter the Second more carefully!');
		}
		if (date2ts($this->input->post("starttime_date"))+intval($this->input->post("tH"))*3600+intval($this->input->post("tM"))*60+intval($this->input->post("tS"))-nowTS()<CONTEST_CREATE_DELAY_TIME) {
			$this->form_validation->set_message('_check_second', 'Contests must be arranged in at least ' . CONTEST_CREATE_DELAY_TIME . ' seconds from now.');
			return FALSE;
		}
		return TRUE;
	}
	public function _check_contest_length($dummy) {
		$length = intval($this->input->post("lH"))*3600+intval($this->input->post("lM"))*60+intval($this->input->post("lS"));
		if ($length < CONTEST_MIN_LENGTH) {
			$this->form_validation->set_message('_check_contest_length', 'The Contest length is too small!');
			return FALSE;
		}
		if ($length > CONTEST_MAX_LENGTH) {
			$this->form_validation->set_message('_check_contest_length', 'The Contest length is too large!');
			return FALSE;
		}
		return TRUE;
	}
	public function _get_problems() {
		$problems = array();
		$problem_codes = array();//for removing duplicates
		$index = 0;
		for ($i=1;$i<=15;$i++) {
			if ($this->input->post("p" . $i) && $this->input->post("p" . $i . "_c") && trim($this->input->post("p" . $i))!="") {
				if (!$this->Problems->codeExistsAll($this->input->post("p" . $i)) || in_array($this->input->post("p" . $i), $problem_codes)) continue;
				$problems[$index]["code"] = intval($this->input->post("p" . $i));
				$color = $this->input->post("p" . $i. "_c");
				if (!preg_match("/^#[0-9a-fA-F]{6}$/", $color)) $color = "#000000";
				$problems[$index]["color"] = $color;
				$problem_codes[] = $problems[$index]["code"];
				$index++;
			}
		}
		return $problems;
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

function ranklist_sort($a, $b) {
	if ($a->all_acc<$b->all_acc) return 1;
	if ($a->all_acc>$b->all_acc) return -1;
	if ($a->penalty<$b->penalty) return -1;
	return 1;
}


class Ranklist_item {
	var $user_id;
	var $user_name;
	var $penalty;
	var $states;
	var $all_acc;
	var $is_real;
	public function Ranklist_item($n, $letters) {
		$this->is_real = TRUE;
		for ($i=0;$i<$n;$i++) {
			$this->states[$letters[$i]]["submits"] = 0;
			$this->states[$letters[$i]]["acc_time"] = 0;
			$this->states[$letters[$i]]["acc"] = FALSE;
		}
		$this->all_acc = 0;
	}
	
}


