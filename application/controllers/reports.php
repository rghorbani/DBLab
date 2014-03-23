<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends SC_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("Reports_model","Reports");
	}
	
	
	public function send() {
		$this->require_login();
		if ($this->input->post("message") == FALSE || strlen($this->input->post("message"))<5) die("e");
		$this->load->library('user_agent');
		$this->Reports->addReport($this->current_user->id, $this->input->post("message"), nowDate(), $this->input->ip_address(), $this->agent->referrer());
		$this->load->library("notification");
		$this->notification->notifySubscriptions(Notification::$NOTIF_BUG_REPORT, "A new bug or suggestion thrown!", "reports/list", -100);
		echo("done");
	}
	
}

