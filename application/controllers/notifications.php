<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends SC_Controller {

	public function __construct() {
		parent::__construct(FALSE);
		$this->load->library('notification');
	}

	public function ajax_get_notifications() {
		if ($this->current_user == NULL) exit();
		$list = NULL;
		$last = ($this->input->get("last") && is_numeric($this->input->get("last")))?intval($this->input->get("last")):-1;
		
		$new_last = $this->notification->getLastId($this->current_user->id);
		$list = $this->notification->getNotificationListAfter($this->current_user->id, $last);
		
		$this->output->set_content_type('application/json')->set_output(json_encode(array('list' => $list, 'last' => $new_last)));
	}
	
	public function ajax_get_unread_count() {
		if ($this->current_user == NULL) exit();
		$count = $this->notification->getUnreadCount($this->current_user->id);
		$this->output->set_content_type('application/json')->set_output(json_encode(array('count' => $count, 'last' => nowDate())));
	}
	public function ajax_mark_as_read() {
		if ($this->current_user == NULL) exit();
		$this->notification->markAsRead($this->current_user->id);
		$this->output->set_content_type('application/json')->set_output(json_encode(array('now' => nowDate())));
	}
}
