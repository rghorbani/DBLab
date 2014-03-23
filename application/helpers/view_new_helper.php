<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ShareCode
 *
 * 
 */

// ------------------------------------------------------------------------



	class Tabs {
		var $tabs;
		
		function add($label, $link, $sel = FALSE) {
			$this->tabs[] = array($label, $link, $sel);
		}
		
		function generate() {
			$ret = "<ul>";
			for ($i=0;$i<count($this->tabs);$i++) {
				$class = '';
				$end = '';
				if ($this->tabs[$i][2]) $class = ' class="selected"';
				if ($i == count($this->tabs)-1) $end = '<div class="last"></div>';
				$ret .= '<li' . $class . '><div></div>' . ($this->tabs[$i][1] == ''?('<a>' . $this->tabs[$i][0] . '</a>'):('<a href="' . $this->tabs[$i][1] . '">' . $this->tabs[$i][0] . '</a>')) . $end . '</li>';
			}
			$ret .= "</ul>";
			return $ret;
		}
	}
	
	
		
	define('TAB_CONTEST_PROBLEMS',1);
	define('TAB_CONTEST_STANDING',2);
	define('TAB_CONTEST_CLARS',	3);
	define('TAB_CONTEST_JCLARS',4);
	define('TAB_CONTEST_SUBMIT',5);
	define('TAB_CONTEST_MYRUNS',6);
	define('TAB_CONTEST_RUNS',7);
	
	define('TAB_CONTEST_READY',8);
	
	function contest_tabs($contest, $is_logged_in, $current_user, $current_tab = -1) {
		$tabs = new Tabs;
		if ($contest->ready == TRUE && $current_tab == TAB_CONTEST_READY) {
			$tabs->add('Ready', site_url("contests/view/" . $contest->id), TRUE);
		}else {
			$tabs->add('Contest Problems', site_url("contests/view/" . $contest->id), $current_tab == TAB_CONTEST_PROBLEMS);
			$tabs->add('Standing', site_url("contests/ranklist/" . $contest->id), $current_tab == TAB_CONTEST_STANDING);
			$tabs->add('Clarifications', site_url("contests/clarifications/" . $contest->id), $current_tab == TAB_CONTEST_CLARS);
			if ($is_logged_in && $current_user->perm_judge) $tabs->add('New Clars', site_url("contests/clarjudge/" . $contest->id), $current_tab == TAB_CONTEST_JCLARS);
			if ($is_logged_in && $contest->finished == FALSE) $tabs->add('Submit', site_url("contests/submit/" . $contest->id), $current_tab == TAB_CONTEST_SUBMIT);
			if ($is_logged_in) $tabs->add('My Runs', site_url("contests/my_runs/" . $contest->id), $current_tab == TAB_CONTEST_MYRUNS);
			if ($is_logged_in && $current_user->perm_judge) $tabs->add('Contest Runs', site_url("contests/runs/" . $contest->id), $current_tab == TAB_CONTEST_RUNS);
		}
		echo $tabs->generate();
	}

	
	
	
	define('TAB_CONTEST_HOME_CONTESTS', 1);
	define('TAB_CONTEST_HOME_PAST', 2);
	define('TAB_CONTEST_HOME_ARRANGE', 3);
	define('TAB_CONTEST_HOME_VRANKLIST', 4);
	
	function contest_home_tabs($is_logged_in, $current_user, $current_tab = -1) {
		$tabs = new Tabs;
		$tabs->add('Contests', site_url("contests"), $current_tab == TAB_CONTEST_HOME_CONTESTS);
		$tabs->add('Past Contests', site_url("contests/page/1"), $current_tab == TAB_CONTEST_HOME_PAST);
		if ($is_logged_in && $current_user->perm_create_contest) $tabs->add('Arrange Contest', site_url("contests/arrange"), $current_tab == TAB_CONTEST_HOME_ARRANGE);
		if ($is_logged_in && $current_user->perm_create_contest) $tabs->add('Virtual Ranklists', site_url("contests/vranklists"), $current_tab == TAB_CONTEST_HOME_VRANKLIST);
		echo $tabs->generate();
	}


	define('TAB_SECTION_HOME_SECTIONS', 1);
	define('TAB_SECTION_HOME_PAST', 2);
	define('TAB_SECTION_ARRANGE', 3);
	define('TAB_SECTION_ADD_PROBLEM', 4);
	
	function section_tabs($is_logged_in, $current_user, $current_tab = -1) {
		$tabs = new Tabs;
		$tabs->add('Sections', site_url("sections"), $current_tab == TAB_SECTION_HOME_SECTIONS);
		$tabs->add('Past Sections', site_url("sections/page/1"), $current_tab == TAB_SECTION_HOME_PAST);
		if ($is_logged_in && $current_user->perm_create_contest) $tabs->add('Arrange Section', site_url("sections/arrange"), $current_tab == TAB_SECTION_ARRANGE);
		if ($is_logged_in && $current_user->perm_problem_setter) $tabs->add('Add Problems', site_url("sections/add_existing_problem"), $current_tab == TAB_SECTION_ADD_PROBLEM);
		echo $tabs->generate();
	}
	
	
	
	define('TAB_ADMIN_ADD_PROBLEM', 1);
	define('TAB_ADMIN_EDIT_PROBLEM', 2);
	define('TAB_ADMIN_SOURECS', 3);
	define('TAB_ADMIN_UPLOADPIC', 4);
	define('TAB_ADMIN_NEWS', 5);

	function admin_tabs($is_logged_in, $current_user, $current_tab = -1) {
		$tabs = new Tabs;
		if ($current_tab == TAB_ADMIN_EDIT_PROBLEM) {
			// no tab needed
		}else {
			$tabs->add('Add Problem', site_url("admin/add_problem"), $current_tab == TAB_ADMIN_ADD_PROBLEM);
			$tabs->add('Upload Picture', site_url("admin/add_picture"), $current_tab == TAB_ADMIN_UPLOADPIC);
			$tabs->add('Manage Sources', site_url("admin/manage_sources"), $current_tab == TAB_ADMIN_SOURECS);
			$tabs->add('Manage News', site_url("admin/manage_news"), $current_tab == TAB_ADMIN_NEWS);
		}
		echo $tabs->generate();
	}
	
	
	define('TAB_PSET_PROBLEMS', 1);
	define('TAB_PSET_ALLRUNS', 2);
	define('TAB_PSET_SEARCH', 4);

	function problemset_tabs($is_logged_in, $current_user, $current_tab = -1, $url = "problemset") {
		$tabs = new Tabs;
		$tabs->add('Problem list', site_url("sections/view/" . $url . "/1"), $current_tab == TAB_PSET_PROBLEMS);
		$tabs->add('Runs', site_url("runs/all"), $current_tab == TAB_PSET_ALLRUNS);
		if ($current_tab == TAB_PSET_SEARCH) {
			$tabs->add('Search Result', '', $current_tab == TAB_PSET_SEARCH);
		}
		
		echo $tabs->generate();
	}
	
	
	define('TAB_PROBLEM_VIEW', 1);
	define('TAB_PROBLEM_SUBMIT', 2); //	   --. (down arrow) :)
	define('TAB_PROBLEM_QUEUE', 2); // EQ to TAB_PROBLEM_SUBMIT ;)
	define('TAB_PROBLEM_RUNS', 4);
	define('TAB_PROBLEM_ACCRUNS', 5);
	define('TAB_PROBLEM_DISCUSSION', 6);

	function problem_tabs($is_logged_in, $current_user, $current_tab = -1, $section, $problem) {
		$tabs = new Tabs;
		$tabs->add('Problem #' . $problem->code, site_url("sections/problem/" . $section . "/" . $problem->code), $current_tab == TAB_PROBLEM_VIEW);
		if ($is_logged_in) $tabs->add('Submit', site_url("sections/submit/" . $section . "/" . $problem->code), $current_tab == TAB_PROBLEM_SUBMIT);
		$tabs->add('All Runs', site_url("runs/problem/" . $section . "/" . $problem->code), $current_tab == TAB_PROBLEM_RUNS);
		$tabs->add('Accepted Runs', site_url("runs/acc_problem/" . $section . "/" . $problem->code), $current_tab == TAB_PROBLEM_ACCRUNS);
		$tabs->add('Discussion', site_url("discussion/problem/" . $problem->code), $current_tab == TAB_PROBLEM_DISCUSSION);
		
		echo $tabs->generate();
	}
	
	define('TAB_USERLOG_LOGIN', 1);
	define('TAB_USERLOG_SIGNUP', 2);
	define('TAB_USERLOG_RECOVER', 3);

	function user_login_tabs($is_logged_in, $current_user, $current_tab = -1) {
		$tabs = new Tabs;
		$tabs->add('Signup', site_url("users/signup"), $current_tab == TAB_USERLOG_SIGNUP);
		$tabs->add('Login', site_url("users/login"), $current_tab == TAB_USERLOG_LOGIN);
		$tabs->add('Recover Account', site_url("users/recover"), $current_tab == TAB_USERLOG_RECOVER);
		echo $tabs->generate();
	}
	
	
	define('TAB_USERPROFILE_PROFILE', 1);
	define('TAB_USERPROFILE_RUNS', 2);
	define('TAB_USERPROFILE_ACCRUNS', 3);
	define('TAB_USERPROFILE_EDIT', 4);
	define('TAB_USERPROFILE_ACTIVITIES', 5);

	function user_profile_tabs($is_logged_in, $user, $current_user, $current_tab = -1) {
		$tabs = new Tabs;
		$tabs->add('Profile', site_url("users/profile/" . $user->id), $current_tab == TAB_USERPROFILE_PROFILE);
		if ($is_logged_in && $current_user->id == $user->id) $tabs->add('Edit Profile', site_url("users/edit/"), $current_tab == TAB_USERPROFILE_EDIT);
		$tabs->add('Runs', site_url("runs/user/" . $user->id), $current_tab == TAB_USERPROFILE_RUNS);
		$tabs->add('Accepted Runs', site_url("runs/acc_user/" . $user->id), $current_tab == TAB_USERPROFILE_ACCRUNS);
		if ($is_logged_in && $current_user->perm_moderator) $tabs->add('Activities', site_url("logs/user/" . $user->id), $current_tab == TAB_USERPROFILE_ACTIVITIES);
		echo $tabs->generate();
	}
	