<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Judge extends SC_Controller {
	public function __construct() {
		parent::__construct(FALSE);
		$this->require_login();
		if ($this->current_user == FALSE || !$this->current_user->perm_judge) show_404();
	}
	
	public function rejudge($rid = NULL) {
		if ($rid == NULL || !is_numeric($rid)) show_404();
		$rid = intval($rid);
		$this->load->model('Runs_model','Runs');
		$this->Runs->rejudge($rid);
		$next = "";
		if ($this->input->get("next")) $next = $this->input->get("next");
		redirect($next);
	}
	
	public function ajax_rejudge($rid = NULL) {
		if ($rid == NULL || !is_numeric($rid)) show_404();
		$rid = intval($rid);
		$this->load->model('Runs_model','Runs');
		$this->Runs->rejudge($rid);
		echo("done");
	}
	
	
	public function delete($rid = NULL) {
		if ($rid == NULL || !is_numeric($rid)) show_404();
		$rid = intval($rid);
		$this->load->model('Runs_model','Runs');
		$this->Runs->delete($rid);
		$next = "";
		if ($this->input->get("next")) $next = $this->input->get("next");
		redirect($next);
	}
	
	public function ajax_delete($rid = NULL) {
		if ($rid == NULL || !is_numeric($rid)) show_404();
		$rid = intval($rid);
		$this->load->model('Runs_model','Runs');
		$this->Runs->delete($rid);
		echo("done");
	}
	
	
	
	
}
