<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends SC_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('News_model','News');
	}
	
	public function index()	{
		$data["title"] = "ACM Online Judge";
		$data["news"] = $this->News->getNews(0, NEWS_PER_PAGE);
		$this->master_view("home/home",$data);
	}
	public function time() {
		echo(nowDate());
	}
	
}
