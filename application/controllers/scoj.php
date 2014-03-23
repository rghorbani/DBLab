<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scoj extends SC_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Users_model','Users');
		$this->load->model('Runs_model','Runs');
		$this->load->model('Problemset_model','Problems');
		$this->login->loginJudge();
	}
	public function queue($front = NULL) {
		if ($front != 'front') show_404();
		$run = $this->Runs->getQueue(); // returns NULL if another run is running or if no runs remains
		if ($run == NULL) {
			echo("-1 -1 -1 -1 -1 -1 -1 -1");
			exit;
		}
		$problem = $this->Problems->getProblem_force($run->problem_id);
		if ($problem == NULL) {
			echo("-1 -1 -1 -1 -1 -1 -1 -1");
			exit;
		}
		$this->Runs->updateRunStatus($run->id, 3); // running and judging
		echo(	$run->id . "\n" .
				$run->lang . "\n" .
				$problem->code . "\n" .
				$problem->special_judge . "\n" .
				$problem->time_limit . "\n" .
				$problem->memory_limit . "\n" .
				ceil(($run->id+$run->lang+$problem->time_limit+$problem->memory_limit)/18) . "\n" .
				"1" . "\n" .
			"\n\n");
	}
	
	public function source($run_id = NULL) {
		if ($run_id == NULL) show_404();
		$run = $this->Runs->getRun($run_id);
		if ($run == NULL) show_404();
		echo($run->source);
	}
	
	public function update($run_id = NULL, $time = NULL, $memory = NULL, $result = NULL) {
		if ($run_id == NULL || $result == NULL) show_404();
		$ce = "";
		if (intval($result) == 11) {
			$ce = ($this->input->post("ceinfo"));
		}
		log_message('error', 'run ' . $run_id . ' ' . $time . ' ' . $memory . ' ' . $result);
		$run = $this->Runs->getRun($run_id);
		$this->Runs->updateResult($run_id, $time, $memory, $result, $ce);
		if (intval($result) == 4) {
			$this->load->library("notification");
			$this->notification->follow($run->user_id, $run->problem_id, Notification::$NOTIF_DISC_TOPIC);
			$this->Users->addAcc($run->user_id, $run->problem_id);
			$this->Problems->plusAcc($run->problem_id);
		}else {
			$this->Problems->plusSubmits($run->problem_id);
		}
	}
	
}
