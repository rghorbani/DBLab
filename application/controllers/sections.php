<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sections extends SC_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Problemset_model','Problems');
		$this->load->model('Sections_model','Sections');
		$this->load->library('form_validation');
		$this->problem_letters = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	}

	public function index($current_page = 1) {
		$current_page = intval($current_page);
		if($current_page == NULL) show_404();

		if ($this->current_user && $this->current_user->perm_problem_setter) {
			$total_sections = $this->Sections->getCountAll();
		}else {
			$total_sections = $this->Sections->getCount();
		}
		$total_pages = ceil($total_sections/SECTIONS_PER_PAGE);

		$data["title"] = "Sections :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		
		if ($this->current_user && $this->current_user->perm_problem_setter) {
			$data['sections'] = $this->Sections->getSectionsAll(($current_page-1)*SECTIONS_PER_PAGE, SECTIONS_PER_PAGE);
		}else {
			$data['sections'] = $this->Sections->getSections(($current_page-1)*SECTIONS_PER_PAGE, SECTIONS_PER_PAGE);
		}

		$this->master_view("sections/index", $data);
	}
	
	public function page($current_page = NULL) {

		redirect("sections");
		
		$current_page = intval($current_page);
		if ($current_page == 0) $current_page = 1;
		if ($current_page < 1) {
			show_404();
		}
		
		$total_pages = ceil($this->Sections->getFinishedCount()/SECTIONS_PER_PAGE);
		
		
		if ($current_page > $total_pages) {
			redirect("sections/page/1", 'location');
			return;
		}
		
		$data["title"] = "Past Sections :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		
	
		$data["sections"] = $this->Sections->getFinishedList(($current_page-1)*SECTIONS_PER_PAGE, SECTIONS_PER_PAGE);
		
		$this->master_view("sections/past", $data);
	}
	
	public function arrange() {
		$this->require_login();
		if ($this->current_user->perm_create_contest == FALSE) show_404();
		$data["title"] = "Arrange Section";
		$data["problem_error"] = FALSE;
		// $data["vranklists"] = $this->Sections->getVirtualRanklists();
		if ($this->form_validation->run() == FALSE) {
			$this->master_view("sections/arrange", $data);
			return;
		}
		// we have not done form validation yet
		// die("fhskjfdhkjf");
		// everything is ok now! at least i hope to!
		$starttime = $this->input->post("starttime_date") . " " . $this->input->post("tH") . ":" . $this->input->post("tM") . ":" . $this->input->post("tS");
		$label = $this->input->post("label");
		$url = $this->input->post("url");
		$description = $this->input->post("description");
		$length = intval($this->input->post("lH"))*3600+intval($this->input->post("lM"))*60+intval($this->input->post("lS"));
		$section_id = $this->Sections->addSection($label, $url, $starttime, $length, $this->current_user->id, $this->input->post("priority"), $this->input->post("visible"), $description);
		// for ($i=0;$i<count($problems);$i++) {			
		// 	$this->Sections->addContestProblems($contest_id, $problems[$i]["code"], $this->problem_letters[$i], $problems[$i]["color"]); 
		// }
		$data["starttime"] = $starttime;
		$data["title"] = "Section :: Confirmation";
		$data["label"] = $label;
		$data['url'] = $url;
		// $data["problems"] = $this->Sections->getContestProblems($section_id);
		$data["length"] = formatTime($length);
		$data["section_id"] = $section_id;
		$this->master_view("sections/confirm", $data);
	}

	public function make_problem_visible() {
		if ($this->current_user->perm_problem_setter == FALSE || $this->input->post("url") == FALSE || $this->input->post("code") == FALSE || !is_numeric($this->input->post("code"))) show_404();
		$this->Problems->updateVisible($this->input->post("url"), $this->input->post("code"), TRUE);
		echo "Ajax - Ok";
	}

	public function make_visible($section_url = NULL) {
		$this->require_login();
		if($section_url == NULL || $this->current_user->perm_create_contest == FALSE) show_404();
		$this->Sections->makeSectionVisible($section_url);
		redirect("sections");
	}

	public function make_invisible($sections_url = NULL) {
		$this->require_login();
		if($section_url == NULL || $this->current_user->perm_create_contest == FALSE) show_404();
		$this->Sections->makeSectionInvisible($section_url);
		redirect("sections");
	}

	public function delete($section_url = NULL) {
		$this->require_login();
		if($section_url == NULL || $this->current_user->perm_create_contest == FALSE) show_404();
		$this->Sections->deleteSection($section_url);
		redirect("sections");
	}

	public function add_problems($section_url = NULL) {
		$this->require_login();
		if (!$this->current_user->perm_problem_setter) show_404();
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Section :: Add Problems";
			$data['sections'] = $this->Sections->getSectionsALLByID();
			$this->master_view("sections/add_problems", $data);
			return;
		}
		if($sections_url == NULL) show_404();
		for($i=0;$i<count();$i++) {
			//
		}

		redirect("sections");
	}
	/*
	public function edit_problem($id = NULL) {
		if ($this->current_user->perm_problem_setter == FALSE || $id == NULL || !is_numeric($id)) show_404();
		$problem = $this->Problems->getProblem_forceByID($id);
		if ($problem == NULL) show_404();
		$data["title"] = "Edit Problem";
		$data["problem_editted"] = FALSE;
		$data["sources"] = $this->Problems->getSourcesAll();
		if ($this->form_validation->run('sections/edit_problem') == FALSE) {
			$data["problem"] = $problem;
			$this->master_view("sections/edit_problem", $data);
			return;
		}
		
		$data["problem_editted"] = TRUE;
		
		$this->_reupload($this->input->post("code"), "input_file", "data.in");
		$this->_reupload($this->input->post("code"), "output_file", "data.out");
		$is_special = $this->_reupload($this->input->post("code"), "checker_file", "checker.cc");
		
		$this->Problems->updateProblem(	$this->input->post("id"),
										$this->input->post("code"),
										$this->input->post("name"),
										$this->input->post("time_limit"),
										$this->input->post("memory_limit"),
										$this->input->post("statement"),
										$this->input->post("input"),
										$this->input->post("output"),
										$this->input->post("sample_input"),
										$this->input->post("sample_output"),
										$this->input->post("hint"),
										$this->input->post("source_id"),
										$is_special,
										$this->input->post("is_visible"),
										$this->current_user->id);
										
		$data["problem"] = $this->Problems->getProblem_forceByID($id);
		$this->master_view("sections/edit_problem", $data);
	}*/

	public function add_existing_problem() {
		$this->require_login();
		if ($this->current_user->perm_problem_setter == FALSE) show_404();
		$data["title"] = "Add Existing Problem";
		$data["phase"] = 1;
		$data['sections'] = $this->Sections->getSectionsAllByID();
		if($this->form_validation->run('sections/add_existing_problem') == FALSE) {
			$this->master_view('sections/add_problem', $data);
			return;
		}

		$to  = $this->Sections->getSectionByID($this->input->post("section_to"));
		$from  = $this->Sections->getSectionByID($this->input->post("section_from"));
		$code  = $this->input->post("code");
		redirect('sections/edit_problem/' . $to . '/' . $from . '/' . $code);
	}

	public function edit_problem($to = NULL, $from = NULL, $code = NULL) {
		$this->require_login();
		if ($this->current_user->perm_problem_setter == FALSE) show_404();
		if($to == NULL || $from == NULL || $code == NULL || !is_numeric($code)) show_404();

		$data["title"] = "Add Existing Problem";
		$data['phase'] = 2;
		$data['url'] = $to;
		$data['sections'] = $this->Sections->getSectionsALLByID();

		if($this->form_validation->run('sections/edit_problem') == FALSE) {
			$problem = $this->Problems->getProblem_force($from, $code);
			if($problem == NULL) show_404();
			$data['problem'] = $problem;
			$data["sources"] = $this->Problems->getSourcesAll();
			$data["section_id"] = $this->Sections->getSectionID($to);
			$this->master_view('sections/add_problem', $data);
			return;
		}

		$data['phase'] = 3;
	
		$this->_reupload($this->input->post("code"), "input_file", "data.in");
		$this->_reupload($this->input->post("code"), "output_file", "data.out");
		$is_special = $this->_reupload($this->input->post("code"), "checker_file", "checker.cc");
		
		$this->Problems->addProblem(	$this->input->post("code"),
										$this->input->post("section"),
										$this->input->post("name"),
										$this->input->post("time_limit"),
										$this->input->post("memory_limit"),
										$this->input->post("statement"),
										$this->input->post("input"),
										$this->input->post("output"),
										$this->input->post("sample_input"),
										$this->input->post("sample_output"),
										$this->input->post("hint"),
										$this->input->post("source_id"),
										$is_special,
										$this->input->post("is_visible"),
										$this->current_user->id);
										
		$problem = $this->Problems->getProblem_force($to, $code);
		if($problem == NULL) show_404();
		$data['problem'] = $problem;
		$this->master_view("sections/add_problem", $data);
	}
	
	public function view($section_url = NULL, $current_page = 1) {
		if($section_url == NULL) {
			redirect("sections");
			return;
		}

		$section = $this->Sections->getSection($section_url);
		if($section == NULL) show_404();
		
		$current_page = intval($current_page);
		if ($current_page < 1) show_404();
		
		if ($this->current_user && $this->current_user->perm_problem_setter) {
			$total_problems = $this->Problems->getCountAll($section->id);
		}else {
			$total_problems = $this->Problems->getCount($section->id);
		}
		$total_pages = ceil($total_problems/PROBLEMS_PER_PAGE);
		// if ($current_page > $total_pages) { //Don't know what it does
		// 	redirect("sections", 'location');
		// 	return;
		// }


		$data['title'] = "Section :: " . $section->label . " :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;

		if ($this->current_user && $this->current_user->perm_problem_setter) {
			$data["problems"] = $this->Problems->getListAll_user(($current_page-1)*PROBLEMS_PER_PAGE, PROBLEMS_PER_PAGE, $this->current_user->id, $section->id);
		}else if ($this->current_user) {
			$data["problems"] = $this->Problems->getList_user(($current_page-1)*PROBLEMS_PER_PAGE, PROBLEMS_PER_PAGE, $this->current_user->id, $section->id);
		}else {
			$data["problems"] = $this->Problems->getList(($current_page-1)*PROBLEMS_PER_PAGE, PROBLEMS_PER_PAGE, $section->id);
		}

		$data['section'] = $section;
		$data['url'] = $section->url;
		
		$this->master_view("sections/list", $data);
	}

	public function confirm($section_id = NULL) {
		$this->require_login();
		if ($section_id == NULL || $this->current_user->perm_create_contest == FALSE) show_404();
		$section = $this->Sections->getSection_f($contest_id);
		if ($section == NULL || $section->user_id != $this->current_user->id) show_404();
		if (date2ts($section->starttime)-nowTS() < SECTION_CREATE_DELAY_TIME) show_404();
		$this->Sections->confirm($contest_id);
		redirect('sections', 'location');
	}
	
	
	public function problem($section_url = NULL, $code = NULL) {
		if ($section_url == NULL || $code == NULL || !is_numeric($code)) show_404();
		
		if ($this->current_user != FALSE && $this->current_user->perm_problem_setter) {
			$problem = $this->Problems->getProblem_force($section_url, $code);
		}else {
			$problem = $this->Problems->getProblem($section_url, $code);
		}
		if ($problem == NULL) show_404();
		$data["title"] = "Problem #" . $code . " :: " . $problem->name;
		$data["problem"] = $problem;
		$data['url'] = $section_url;
		$this->master_view("sections/problem_view", $data);		
	}

	public function search() { // need attention
		if ($this->input->post("q") != FALSE) redirect('sections/search/?q=' . $this->input->post("q"));
		$q = $this->input->get("q");
		if ($q == FALSE) redirect('sections'); // back last page
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
	
	public function submit($section_url = NULL, $code = NULL, $run_id = NULL) {
		if ($section_url == NULL || $code == NULL || !is_numeric($code)) show_404();

		$this->require_login();
		if ($this->current_user->perm_problem_setter) {
			$problem = $this->Problems->getProblem_force($section_url, $code);
		}else {
			$problem = $this->Problems->getProblem($section_url, $code);
		}
		if ($problem == NULL) show_404();
		
		if (!$this->require_validate()) return;
		$data["title"] = "Submit Solution";
		$data['url'] = $section_url;
		
		if ($this->form_validation->run('sections/submit') == FALSE) {
			if($run_id != NULL) {
				if(!is_numeric($run_id)) show_404();
				$this->load->model('Runs_model','Runs');
				$run = $this->Runs->getRun($run_id);
				if($run == NULL) show_404();
				$data['run'] = $run;
			}
			$data["langs"] = $this->Problems->getLangs();
			$data["problem"] = $problem;
			$this->master_view('sections/submit', $data);
			return;
		}
		$this->load->model('Runs_model','Runs');
		$section = $this->Sections->getSection($section_url);
		$this->Runs->newRun($this->current_user->id, $section->id, $code, $this->input->post("source_code"), $this->input->post("language"), nowDate(), -1);
		$this->Users->updateLastSubmit($this->current_user->id, nowDate());
		redirect('sections/queue/' . $section_url . '/' . $code, 'location');
	}

	public function edit_submit($section_url = NULL, $code = NULL, $run_id = NULL) {
		if ($section_url == NULL || $code == NULL || $run_id == NULL || !is_numeric($code) || !is_numeric($run_id)) show_404();
		
		$this->require_login();
		if ($this->current_user->perm_problem_setter) {
			$problem = $this->Problems->getProblem_force($section_url, $code);
		}else {
			$problem = $this->Problems->getProblem($section_url, $code);
		}
		if ($problem == NULL) show_404();

		if (!$this->require_validate()) return;
		$data["title"] = "Submit Solution";
		$data['url'] = $section_url;

		if ($this->form_validation->run('sections/edit_submit') == FALSE) {
			$this->load->model('Runs_model','Runs');
			$run = $this->Runs->getRun($run_id);
			if($run == NULL) show_404();
			$data['run'] = $run;
			$data["langs"] = $this->Problems->getLangs();
			$data["problem"] = $problem;
			$this->master_view('sections/edit_submit', $data);
			return;
		}

		$this->load->model('Runs_model','Runs');
		$section = $this->Sections->getSection($section_url);
		$this->Runs->newRun($this->current_user->id, $section->id, $code, $this->input->post("source_code"), $this->input->post("language"), nowDate(), -1);
		$this->Users->updateLastSubmit($this->current_user->id, nowDate());
		redirect('sections/queue/' . $section_url . '/' . $code, 'location');
	}
	
	public function queue($section_url = NULL, $code = NULL) {
		if ($section_url == NULL || $code == NULL || !is_numeric($code)) show_404();
		$this->require_login();
		if ($this->current_user->perm_problem_setter) {
			$problem = $this->Problems->getProblem_force($section_url, $code);
		}else {
			$problem = $this->Problems->getProblem($section_url, $code);
		}
		if ($problem == NULL) show_404();
		$data["title"] = "Redirecting ...";
		$data['url'] = $section_url;
		$data["problem"] = $problem;
		$this->master_view('sections/under_judgement', $data);
	}

	private function _reupload($code, $fieldName, $destFileName) {
		$path = DATA_UPLOAD_PATH . $code;
		if (!file_exists($path)) {
			mkdir($path, 0777);
		}
		$this->load->library('upload');
		if ($this->upload->error_check($fieldName) == 4) {
			return FALSE;
		}
		if (!$this->upload->do_upload($fieldName, $destFileName, $path)) {
			echo($path);
			//print_r($_FILES);
			print_r( $this->upload->display_errors());
			die();
			return FALSE;
		}
		return TRUE;
	}
}