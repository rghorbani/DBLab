<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discussion extends SC_Controller {

	public function __construct() {
		parent::__construct(FALSE);
		$this->load->library('form_validation');
		
	}

	public function delete($id = NULL) {
		if ($id == NULL || !is_numeric($id)) show_404();
		$this->require_login();
		$this->load->model("Discussion_model","Discussion");
		$post = $this->Discussion->getPostById($id);
		if ($post == NULL) show_404();
		if ($post->user_id != $this->current_user->id && $this->current_user->perm_moderator == FALSE) show_404();
		
		$this->load->library("notification");
		
		if ($post->parent == -1) {
			$this->Discussion->deleteTopic($id);
			$this->notification->deleteNotificationsHash($post->hash);
			$this->notification->discussion_deleteTopicNotification($post->id);
			redirect("discussion/problem/" . $post->problem_id);
		} else {
			$this->Discussion->deletePostById($id);
			$this->notification->deleteNotificationsHash($post->hash);
			redirect($this->input->get("next"));
		}
		
	}
	
	public function ajax_follow_topic($topic_id = NULL) {
		if ($topic_id == NULL || !is_numeric($topic_id)) show_404();
		$this->require_login();
		
		$this->load->model("Discussion_model","Discussion");
		$topic_head = $this->Discussion->getPostById($topic_id);
		if ($topic_head == NULL || $topic_head->parent != -1) show_404();
		
		$this->load->library("notification");
		$this->notification->follow($this->current_user->id, $topic_head->id, Notification::$NOTIF_DISC_REPLY);
		echo("done");
	}
	
	public function ajax_unfollow_topic($topic_id = NULL) {
		if ($topic_id == NULL || !is_numeric($topic_id)) show_404();
		$this->require_login();
		
		$this->load->model("Discussion_model","Discussion");
		$topic_head = $this->Discussion->getPostById($topic_id);
		if ($topic_head == NULL || $topic_head->parent != -1) show_404();
		
		$this->load->library("notification");
		$this->notification->unfollow($this->current_user->id, $topic_head->id, Notification::$NOTIF_DISC_REPLY);
		echo("done");
	}
	
	
	public function ajax_follow_problem($problem_id = NULL) {
		if ($problem_id == NULL || !is_numeric($problem_id)) show_404();
		$this->require_login();
		
		$this->load->model("Problemset_model","Problems");
		$problem = $this->Problems->getProblem($problem_id);
		if ($problem == NULL) show_404();
		
		$this->load->library("notification");
		$this->notification->follow($this->current_user->id, $problem_id, Notification::$NOTIF_DISC_TOPIC);
		echo("done");
	}
	
	public function ajax_unfollow_problem($problem_id = NULL) {
		if ($problem_id == NULL || !is_numeric($problem_id)) show_404();
		$this->require_login();
		
		$this->load->model("Problemset_model","Problems");
		$problem = $this->Problems->getProblem($problem_id);
		if ($problem == NULL) show_404();
		
		$this->load->library("notification");
		$this->notification->unfollow($this->current_user->id, $problem_id, Notification::$NOTIF_DISC_TOPIC);
		echo("done");
	}
	
	
	public function problem($problem_id = NULL, $current_page = NULL) {
		if ($problem_id == NULL || !is_numeric($problem_id)) show_404();
		$this->load->model("Discussion_model","Discussion");
		$this->load->model("Problemset_model","Problems");
		$this->load->library("notification");
		
		$problem = $this->Problems->getProblem($problem_id);
		if ($problem == NULL) show_404();
		
		
		if ($this->form_validation->run('discussion{new_topic}') != FALSE) {
			$this->require_login(); //////////////////
			if (!$this->require_validate()) return;

			$this->load->helper('htmlpurifier');
			$this->load->helper('markdown');
			
			$clean_html = Markdown($this->input->post("text"));
			$clean_html = html_purify($clean_html, 'forum_post');
			$hash = $this->notification->getHash($this->current_user->id);
			
			$topic_id = $this->Discussion->newTopic($problem->code, $this->current_user->id, $this->input->post("subject"), $clean_html, nowDate(), $hash);
			
			$this->notification->follow($this->current_user->id, $topic_id, Notification::$NOTIF_DISC_REPLY);
			$this->notification->notifySubscriptions(Notification::$NOTIF_DISC_TOPIC, "Someone posted a topic on the problem #" . $problem->code, "discussion/problem/" . $problem->code, $problem->code, $hash, $this->current_user->id);
			
			redirect("discussion/topic/" . $topic_id);
			return;
		}
		
		
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) show_404();
		$topic_count = $this->Discussion->getTopicsCount($problem_id);
		$total_pages = ceil($topic_count/TOPICS_PER_PAGE);
		if ($topic_count == 0) $total_pages = 1;
		if ($current_page > $total_pages) show_404();
		
		$data["title"] = "Problem #" . $problem_id . " Discussions";
		$data["problem"] = $problem;

		$data["total_pages"] = $total_pages;
		$data["current_page"] = $current_page;
		$data["subscribed"] = FALSE;
		if ($this->current_user != FALSE) $data["subscribed"] = $this->notification->following($this->current_user->id, $problem_id, Notification::$NOTIF_DISC_TOPIC);
		$data["topics"] = $this->Discussion->getTopicsByProblemId($problem_id, ($current_page-1)*TOPICS_PER_PAGE, TOPICS_PER_PAGE);

		$this->master_view("discussion/topics", $data);
	}
	
	public function ajax_delete($id = NULL) {
		if ($id == NULL || !is_numeric($id)) show_404();
		$this->require_login();
		$this->load->model("Discussion_model","Discussion");
		$post = $this->Discussion->getPostById($id);
		if ($post == NULL) show_404();
		if ($post->user_id != $this->current_user->id && $this->current_user->perm_moderator == FALSE) show_404();
		
		
		$this->load->library("notification");
		
		if ($post->parent == -1) {
			$this->Discussion->deleteTopic($id);
			$this->notification->deleteNotificationsHash($post->hash);
			$this->notification->discussion_deleteTopicNotification($post->id);
			redirect("discussion/problem/" . $post->problem_id);
		} else {
			$this->Discussion->deletePostById($id);
			$this->notification->deleteNotificationsHash($post->hash);
			redirect($this->input->get("next"));
		}
		
		echo("done");
	}

	public function topic($topic_id = NULL, $current_page = NULL, $new = NULL) {
		if ($topic_id == NULL || !is_numeric($topic_id)) show_404();
		$this->load->model("Discussion_model","Discussion");
		$this->load->model("Problemset_model","Problems");
		
		$topic_head = $this->Discussion->getPostById($topic_id);
		if ($topic_head == NULL || $topic_head->parent != -1) show_404();
		
		$problem = $this->Problems->getProblem($topic_head->problem_id);
		if ($problem == NULL) show_404();
		
		if ($current_page == NULL) {
			$current_page = 1;
		}
		$current_page = intval($current_page);
		if ($current_page < 1) show_404();
		$post_count = $this->Discussion->getTopicPostsCount($topic_id);
		$total_pages = ceil($post_count/DISCUSS_PER_PAGE);
		if ($post_count == 0) $total_pages = 1;
		if ($current_page > $total_pages) show_404();
		
		$data["quoted_post"] = NULL;
		$quote = $this->input->get("quote");
		if ($quote != NULL) {
			$quoted_post = $this->Discussion->getPostById($quote);
			if ($quoted_post != NULL && $quoted_post->problem_id == $topic_head->problem_id) {
				$this->require_login(); //////////////////
				$this->load->helper('markdownify');
				$data["quoted_post"] = $quoted_post;
			}
		}
		
		$this->load->library("notification");
		
		$data["title"] = "Discussion #" . $problem->code;
		$data["problem"] = $problem;
		$data["topic_head"] = $topic_head;
		
		if ($new == "new") {
			$this->require_login(); //////////////////
			if (!$this->require_validate()) return;
			$this->load->helper('htmlpurifier');
			$this->load->helper('markdown');
			
			$clean_html = Markdown($this->input->post("text"));
			$clean_html = html_purify($clean_html, 'forum_post');
			
			if ($this->form_validation->run('discussion{new_post}') != FALSE) {
				$hash = $this->notification->getHash($this->current_user->id);
				$this->Discussion->newPost($topic_id, $problem->code, $this->current_user->id, $clean_html, nowDate(), $hash);
				
				$this->notification->follow($this->current_user->id, $topic_head->id, Notification::$NOTIF_DISC_REPLY);
				$this->notification->notifySubscriptions(Notification::$NOTIF_DISC_REPLY, "Some new replies on your subscribed topic #" . $problem->code, "discussion/topic/" . $topic_head->id, $topic_head->id, $hash, $this->current_user->id);
				$post_count++;
				$total_pages = ceil($post_count/DISCUSS_PER_PAGE);
				redirect("discussion/topic/" . $topic_id . "/" . $total_pages);
				return;
			}
		}

		$data["total_pages"] = $total_pages;
		$data["current_page"] = $current_page;
		
		$data["subscribed"] = FALSE;
		if ($this->current_user != FALSE) $data["subscribed"] = $this->notification->following($this->current_user->id, $topic_head->id, Notification::$NOTIF_DISC_REPLY);
		
		$data["posts"] = $this->Discussion->getTopicPosts($topic_id, ($current_page-1)*DISCUSS_PER_PAGE, DISCUSS_PER_PAGE);
		
		
		$this->master_view("discussion/view", $data);
	}
	
	public function ajax_new_post($topic_id = NULL) {
		if ($this->current_user == NULL) die("login");
		if ($this->current_user->is_valid == FALSE) die("error");
		if ($this->form_validation->run('discussion{new_post}') == FALSE) die("error");
		
		$this->load->model("Discussion_model","Discussion");
		$this->load->model("Problemset_model","Problems");
		
		
		$topic_head = $this->Discussion->getPostById($topic_id);
		if ($topic_head == NULL || $topic_head->parent != -1) show_404();
		
		$problem = $this->Problems->getProblem($topic_head->problem_id);
		if ($problem == NULL) show_404();
		
		$this->load->helper('htmlpurifier');
		$this->load->helper('markdown');
		
		$clean_html = Markdown($this->input->post("text"));
		$clean_html = html_purify($clean_html, 'forum_post');
		
		$this->load->library("notification");
		$hash = $this->notification->getHash($this->current_user->id);
		$id = $this->Discussion->newPost($topic_id, $problem->code, $this->current_user->id, $clean_html, nowDate(), $hash);
		
		$this->notification->follow($this->current_user->id, $topic_head->id, Notification::$NOTIF_DISC_REPLY);
		$this->notification->notifySubscriptions(Notification::$NOTIF_DISC_REPLY, "Some new replies on your subscribed topic #" . $problem->code, "discussion/topic/" . $topic_head->id, $topic_head->id, $hash, $this->current_user->id);

		echo($id);
	}
	
	public function ajax_quote_post($post_id = NULL) {
		if ($post_id == NULL) show_404();
		$this->load->model("Discussion_model","Discussion");
		$quoted_post = $this->Discussion->getPostById($post_id);
		if ($quoted_post == NULL) show_404();
		$this->load->helper('markdownify');
		$quoted_text = "> **" . $quoted_post->name . "** said:\n\n> " . str_replace(array("\r","\n"), array("","\n> "), markdownify($quoted_post->text)) . "\n\n";
		$this->output->set_content_type('application/json')->set_output(json_encode(array('quoted_text' => $quoted_text)));
	}
	
	public function _subject_check($subject) {
		for ($i=0;$i<strlen($subject);$i++) {
			$c = $subject[$i]; 
			if ($c >= 'a' && $c <= 'z') continue;
			if ($c >= 'A' && $c <= 'Z') continue;
			if ($c >= '0' && $c <= '9') continue;
			if (strpos("!@#$*()-=_+[]{}%./'\"\\|`~:;,? ", $c) === FALSE) {
				$this->form_validation->set_message('_subject_check', 'The %s field can not contain the character "' . htmlspecialchars($c) . '"');
				return FALSE;
			}
		}
		return TRUE;
	}
	
}
