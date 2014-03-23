<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends SC_Controller {
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$data["title"] = "About";
		$this->master_view("home/about", $data);
	}
	public function befunge() {
		$data["title"] = "Bedunge98 Playground";
		$this->master_view("about/befunge", $data);
	}
}
