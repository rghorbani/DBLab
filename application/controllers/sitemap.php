<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends SC_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Contests_model','Contests');
		$this->load->model('Problemset_model','Problems');
		$this->load->model('Runs_model','Runs');
		$this->load->model("Users_model","Users");
		$this->load->model("Discussion_model","Discussion");
		$this->load->helper('url');
	}
	
	public function index()	{
		header('Content-type: text/xml');
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		//urls
		echo $this->str_url("");

		echo "<!-- contests -->\n";
		echo $this->str_url("contests");
		$total_pages = ceil($this->Contests->getFinishedCount()/CONTESTS_PER_PAGE);
		for($current_page=1; $current_page<=$total_pages; ++$current_page)
		{
			echo "\n";
			if($current_page != 1)
			{
				echo $this->str_url("contests/page/".$current_page);
				echo "\n";
			}
			$contests = $this->Contests->getFinishedList(($current_page-1)*CONTESTS_PER_PAGE, CONTESTS_PER_PAGE);
			foreach ($contests as $contest)
				echo $this->single_contest($contest->id);
			
		}

		echo "<!-- problemset -->\n";
		echo $this->str_url("problemset");
		$total_pages = ceil($this->Problems->getCount()/PROBLEMS_PER_PAGE);
		for($current_page=1; $current_page<=$total_pages; ++$current_page)
		{
			echo "\n";
			if($current_page != 1)
			{
				echo $this->str_url("problemset/page/".$current_page);
				echo "\n";
			}
			$problems = $this->Problems->getList(($current_page-1)*PROBLEMS_PER_PAGE, PROBLEMS_PER_PAGE);
			foreach ($problems as $problem)
				echo $this->single_problem($problem->code);
			
		}

		echo "<!-- all runs -->\n";
		$total_runs = $this->Runs->getCount_all();
		$total_pages = ceil($total_runs/RUNS_PER_PAGE);
		for($current_page=1; $current_page<=$total_pages; ++$current_page)
		{
			if($current_page == 1)
				echo $this->str_url("runs/all", 1, TRUE);
			else			
				echo $this->str_url("runs/all/".$current_page, 1, TRUE);

			echo "\n";
		}


		echo "<!-- users -->\n";
		echo $this->str_url("users/signup");
		echo $this->str_url("users/login");
		echo $this->str_url("users/recover");
		echo $this->str_url("users/ranklist");
		echo "\n";

		echo "<!-- user profiles -->\n";
		$users = $this->Users->getAllUsers();
		foreach ($users as $user)
			echo $this->single_user($user->id);
		

		//end of urls
		echo "</urlset>\n";

	}

	public function str_url($loc, $indent = 1, $is_run = FALSE){
		$tabs = "";
		for($i=0; $i<$indent; ++$i)
			$tabs = $tabs."\t";

		$optional = "";
		if($is_run) $optional = $tabs."\t<changefreq>always</changefreq>\n";

		return $tabs."<url>\n".$tabs."\t<loc>".site_url().$loc."</loc>\n".$optional.$tabs."</url>\n";
	}

	private function single_contest($id)
	{
		$contest = $this->str_url("contests/view/".$id, 2);
		$contest = $contest.$this->str_url("contests/ranklist/".$id, 2);
		$contest = $contest.$this->str_url("contests/clarifications/".$id, 2);
		return $contest."\n";
	}

	private function single_problem($id)
	{
		$problem = $this->str_url("problemset/view/".$id, 2);
		$problem = $problem.$this->str_url("problemset/submit/".$id, 2);
		$problem = $problem.$this->str_url("runs/problem/".$id, 2, TRUE);
		$problem = $problem.$this->str_url("runs/acc_problem/".$id, 2, TRUE);

		//Discussions
		$topic_count = $this->Discussion->getTopicsCount($id);
		$total_pages = ceil($topic_count/TOPICS_PER_PAGE);
		if ($topic_count == 0) $total_pages = 1;
		for($current_page=1; $current_page<=$total_pages; ++$current_page)
		{
			$problem = $problem."\n";
			$problem = $problem.$this->str_url("discussion/problem/".$id."/".$current_page, 3);
			$problem = $problem."\n";

			$topics = $this->Discussion->getTopicsByProblemId($id, ($current_page-1)*TOPICS_PER_PAGE, TOPICS_PER_PAGE);
			if(sizeof($topics) > 0 ) $problem = $problem."\t\t\t<!-- Related topics -->\n";
			foreach ($topics as $topic)
				$problem = $problem.$this->single_topic($topic->id);
			
		}

		return $problem."\n\n";
	}

	private function single_user($id)
	{
		//assume that $id is a valid user_id
		$user = $this->str_url("users/profile/".$id, 2);
		$user = $user."\n";

		$user = $user.$this->runs($id, FALSE);
		$user = $user.$this->runs($id, TRUE);
		return $user;          //."\n";
	}

	private function runs($id, $acc_or_not)
	{
		$run = "";
		$total_runs = $this->Runs->getCount_user($id);
		$page = "user";

		if($acc_or_not)
		{
			$total_runs = $this->Runs->getACCCount_user($id);
			$page = "acc_".$page;
		}
		
		$total_pages = ceil($total_runs/RUNS_PER_PAGE);

		for($current_page=1; $current_page<=$total_pages; ++$current_page)
			if($current_page == 1)
				$run = $run.$this->str_url("runs/".$page."/".$id, 3, TRUE);
			else			
				$run = $run.$this->str_url("runs/".$page."/".$id."/".$current_page, 3, TRUE);

		return $run."\n";
	}

	private function single_topic($id)
	{
		$post_count = $this->Discussion->getTopicPostsCount($id);
		$total_pages = ceil($post_count/DISCUSS_PER_PAGE);
		if ($post_count == 0) $total_pages = 1;

		for($current_page=1; $current_page<=$total_pages; ++$current_page)
			if($current_page == 1)
				$topic = $this->str_url("discussion/topic/".$id, 4);
			else			
				$topic = $topic.$this->str_url("discussion/topic/".$id."/".$current_page, 4);

		return $topic."\n";
	}
	
}

