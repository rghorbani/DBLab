<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SC_Controller extends CI_Controller {
	public $current_user = FALSE;
	public function __construct($dummy = TRUE) {
		parent::__construct();
		$this->current_user = $this->login->checkAndGet();
		// $this->output->enable_profiler(TRUE);
		// LOGGING
		if (DO_MAKE_LOGS && current_url() != site_url("scoj/queue/front")
						 && current_url() != site_url("notifications/ajax_get_notifications")
						 && current_url() != site_url("notifications/ajax_mark_as_read")
						 && current_url() != site_url("notifications/ajax_get_unread_count")) {
			$this->load->library("Logger");
			$this->load->library('user_agent');
			$param = "";
			if ($this->agent->is_robot()) $param="{robot:" . $this->agent->robot() . "}";
			else $param = "{agent:" . $this->agent->browser() . "-" . $this->agent->platform() . "}" . serialize($this->input->post());
			$this->logger->log(($this->current_user==FALSE?-1:$this->current_user->id), $this->agent->referrer(), current_url() . ($this->input->server("QUERY_STRING")!=""?"?":"") . $this->input->server("QUERY_STRING"), $this->input->server("REQUEST_METHOD"), $param);
		}
	}
	
	public function master_view($content_view, $data) {
		$defualt_theme = 'new';
		if (!isset($data["show_login_box"])) $data["show_login_box"] = TRUE;
		if (!isset($data["title"])) $data["title"] = "";
		if (!isset($data["is_logged_in"])) $data["is_logged_in"] = ($this->current_user==FALSE?FALSE:TRUE);
		if (!isset($data["current_user"])) $data["current_user"] = NULL;
		if ($data["is_logged_in"] == TRUE && $data["current_user"] == NULL) $data["current_user"] = $this->current_user;
		$data["title"] = PAGE_TITLE_PREFIX . $data["title"];
		$data['BASE'] = base_url();
		$data['CURRENT_PAGE'] = substr(current_url(), strlen(site_url()));
		$theme = $this->current_user?$this->current_user->theme_name:$defualt_theme;
		$this->load->helper('view_new_helper');
        $data['content'] = $this->load->view($theme . '/' . $content_view, $data, true);
		$this->load->view($theme . '/master', $data);
    }
	
	public function require_login() {
		if ($this->current_user == FALSE){
			redirect('users/login?next=' . (substr(current_url(), strlen(site_url()))));
			exit;
		}
	}
	
	public function require_validate() {
		$this->require_login();
		if ($this->current_user->is_valid == FALSE) {
			$data["title"] = "Validation Needed";
			$this->master_view("general/please_validate", $data);
			return FALSE;
		}
		return TRUE;
	}
}
