<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends SC_Controller {
	public function __construct() {
		parent::__construct();
		if ($this->current_user == FALSE) show_404();
		$this->load->model('Users_model','Users');
		$this->load->model('Problemset_model','Problems');
		$this->load->model('News_model','News');
		$this->load->library('form_validation');
	}

	public function change_usernames() {
		show_404();
		return;
		$this->load->model('Users_model','Users');
		$users = $this->Users->getAllUsers();
		foreach($users as $user) {
			if ($user->username != clean4username($user->username)) {
				$this->Users->addReservedUsername(clean4username($user->username));	
			}
		}
		
	}
	
	public function make_visible() {
		if ($this->current_user->perm_problem_setter == FALSE || $this->input->post("code") == FALSE || !is_numeric($this->input->post("code"))) show_404();
		$this->Problems->updateVisible($this->input->post("code"), TRUE);
		echo "Ajax - Ok";
	}
	
	public function make_unspecial() {
		if ($this->current_user->perm_problem_setter == FALSE || $this->input->post("code") == FALSE || !is_numeric($this->input->post("code"))) show_404();
		$this->Problems->updateSpecialJudge($this->input->post("code"), FALSE);
		echo "Ajax - Ok";
	}
	
	public function edit_problem($section_url = NULL, $code = NULL) {
		if ($this->current_user->perm_problem_setter == FALSE || $section_url == NULL || $code == NULL || !is_numeric($code)) show_404();
		$problem = $this->Problems->getProblem_force($section_url, $code);
		if ($problem == NULL) show_404();
		$data["title"] = "Edit Problem";
		$data["problem_editted"] = FALSE;
		if ($this->form_validation->run('admin/edit_problem') == FALSE) {
			$this->load->model('Sections_model','Sections');
			$data['sections'] = $this->Sections->getSectionsAllByID();
			$data["sources"] = $this->Problems->getSourcesAll();
			$data["problem"] = $problem;
			$this->master_view("admin/edit_problem", $data);
			return;
		}
		
		$data["problem_editted"] = TRUE;
		
		$this->_reupload($this->input->post("code"), "input_file", "data.in");
		$this->_reupload($this->input->post("code"), "output_file", "data.out");
		$is_special = $this->_reupload($this->input->post("code"), "checker_file", "checker.cc");
		
		$this->Problems->updateProblem(	$this->input->post("code"),
										$this->input->post("section"),
										$this->input->post("name"),
										$this->input->post("time_limit"),
										$this->input->post("memory_limit"),
										$this->input->post("statement"),
										$this->input->post("input"),
										$this->input->post("output"),
										$this->input->post("sample_input"),
										$this->input->post("sample_output"),
										$this->input->post("hint"),
										$this->input->post("source_id"),
										$is_special,
										$this->input->post("is_visible"),
										$this->current_user->id);
										
		$data["problem"] = $this->Problems->getProblem_force($code);
		$this->master_view("admin/edit_problem", $data);
	}
	
	public function manage_sources() {
		if ($this->current_user->perm_problem_setter == FALSE) show_404();
		$data["title"] = "Source Administration";
		$data["source_added"] = FALSE;
		
		if ($this->form_validation->run() == FALSE) {
			$data["sources"] = $this->Problems->getSourcesStatAll();
			$this->master_view('admin/man_sources', $data);
			return;
		}
		$data["source_added"] = TRUE;
		$this->Problems->addSource($this->input->post("label"));
		$data["sources"] = $this->Problems->getSourcesStatAll();
		$this->master_view('admin/man_sources', $data);
	}
	
	public function delete_source($id = NULL) {
		if ($id == NULL || !is_numeric($id)) show_404();
		if ($this->current_user->perm_problem_setter == FALSE) show_404();
		if ($this->Problems->getSourceNum($id) != 0) show_404();
		$this->Problems->deleteSource($id);
		$this->manage_sources();
	}
	
	public function add_picture() {
		if ($this->current_user->perm_problem_setter == FALSE) show_404();
		$data["title"] = "Upload Pictures";
		$data["picture_uploaded"] = NULL;
		if ($this->form_validation->run() == FALSE) {
			$this->master_view("admin/pic_upload", $data);
			return;
		}
		$data["picture_uploaded"] = $this->_uploadpic('pic_file', $this->input->post("problem_code"));
		$this->master_view("admin/pic_upload", $data);
		
	}

	public function manage_news($current_page = NULL) {
		if ($this->current_user->perm_moderator == FALSE) show_404();
		if ($current_page == NULL) {
			$current_page = 1;
		}

		$current_page = intval($current_page);
		if ($current_page < 1) show_404();
		$total_news = $this->News->getNewsCount();
		$total_pages = ceil($total_news/NEWS_PER_PAGE);
		
		if ($current_page > $total_pages && $total_news != 0) show_404();
		
		$data["title"] = "News Management :: Page " . $current_page;
		$data["current_page"] = $current_page;
		$data["total_pages"] = $total_pages;
		$data["news_added"] = FALSE;

		if ($this->form_validation->run() == FALSE || $this->input->post("content") == NULL) {
			$data["news"] = $this->News->getNewsList(($current_page-1)*NEWS_PER_PAGE, NEWS_PER_PAGE);
			$this->master_view('admin/manage_news', $data);
			return;
		}

		$data["news_added"] = TRUE;
		$this->News->addNews($this->current_user->id,$this->input->post("priority"),$this->input->post("visible"),NULL,$this->input->post("content"));
		$data["news"] = $this->News->getNewsList(($current_page-1)*NEWS_PER_PAGE, NEWS_PER_PAGE);
		$this->master_view("admin/manage_news", $data);
	}

	public function delete_news($id = NULL) {
		if ($id == NULL || !is_numeric($id)) show_404();
		if ($this->current_user->perm_moderator == FALSE) show_404();
		if (!$this->News->newsExists($id)) show_404();
		$this->News->deleteNews($id);
		redirect("admin/manage_news");
	}

	public function add_problem() {
		if ($this->current_user->perm_problem_setter == FALSE) show_404();
		$data["title"] = "Add Problem";
		$data["sources"] = $this->Problems->getSourcesAll();
		$data["problem_added"] = FALSE;
		if ($this->form_validation->run() == FALSE) {
			$this->load->model('Sections_model','Sections');
			$data['sections'] = $this->Sections->getSectionsAllByID();
			$this->master_view("admin/add_problem", $data);
			return;
		}
		$data["problem_added"] = TRUE;
		$this->_upload($this->input->post("code"), "input_file", "data.in");
		$this->_upload($this->input->post("code"), "output_file", "data.out");
		$is_special = $this->_upload($this->input->post("code"), "checker_file", "checker.cc");
		
		$this->Problems->addProblem($this->input->post("code"),
									$this->input->post("section_id"),
									$this->input->post("name"),
									$this->input->post("time_limit"),
									$this->input->post("memory_limit"),
									$this->input->post("statement"),
									$this->input->post("input"),
									$this->input->post("output"),
									$this->input->post("sample_input"),
									$this->input->post("sample_output"),
									$this->input->post("hint"),
									$this->input->post("source_id"),
									$is_special,
									$this->input->post("is_visible"),
									$this->current_user->id);
		$this->master_view("admin/add_problem", $data);
	}
	
	public function view_input($code = NULL) {
		if ($this->current_user->perm_problem_setter == FALSE || $code == NULL || !is_numeric($code)) show_404();
		if ($this->Problems->codeExistsAll($code) == FALSE) show_404();
		$this->load->helper('file');
		$this->load->helper('download');
		force_download($code . "_input.txt", read_file(DATA_UPLOAD_PATH . $code . DIR_DELIM . "data.in"));
	}
	
	public function view_output($code = NULL) {
		if ($this->current_user->perm_problem_setter == FALSE || $code == NULL || !is_numeric($code)) show_404();
		if ($this->Problems->codeExistsAll($code) == FALSE) show_404();
		$this->load->helper('file');
		$this->load->helper('download');
		force_download($code . "_output.txt", read_file(DATA_UPLOAD_PATH . $code . DIR_DELIM . "data.out")); 
	}
	
	public function view_checker($code = NULL) {
		if ($this->current_user->perm_problem_setter == FALSE || $code == NULL || !is_numeric($code)) show_404();
		if ($this->Problems->codeExistsAll($code) == FALSE) show_404();
		$this->load->helper('file');
		$this->load->helper('download');
		force_download($code . "_checker.cc", read_file(DATA_UPLOAD_PATH . $code . DIR_DELIM . "checker.cc")); 
	}
	
	// used for form validation in add_problem
	public function _problem_code_check($code) {
		if ($this->Problems->codeExistsAll($code) == TRUE) {
			$this->form_validation->set_message('_problem_code_check', 'This Problem Code is taken!');
			return FALSE;
		}
		return TRUE;
	}
	
	private function _upload($code, $fieldName, $destFileName) {
		$path = DATA_UPLOAD_PATH . $code;
		if (!file_exists($path)) {
			mkdir($path, 0777);
		}
		$this->load->library('upload');
		if ($this->upload->error_check($fieldName) == 4) {
			fclose(fopen($path . DIR_DELIM . $destFileName, 'w'));			
			return FALSE;
		}
		if (!$this->upload->do_upload($fieldName, $destFileName, $path)) {
			print_r($_FILES);
			print_r( $this->upload->display_errors());
			die();
			return FALSE;
		}
		return TRUE;
	}
	
	private function _reupload($code, $fieldName, $destFileName) {
		$path = DATA_UPLOAD_PATH . $code;
		if (!file_exists($path)) {
			mkdir($path, 0777);
		}
		$this->load->library('upload');
		if ($this->upload->error_check($fieldName) == 4) {
			return FALSE;
		}
		if (!$this->upload->do_upload($fieldName, $destFileName, $path)) {
			echo($path);
			//print_r($_FILES);
			print_r( $this->upload->display_errors());
			die();
			return FALSE;
		}
		return TRUE;
	}
	
	private function _uploadpic($fieldName, $problemCode) {
		srand(time());
		$path = 'assets' . DIR_DELIM . 'problem_images';
		$destFileName = $problemCode . '_' . md5(rand()) . ".jpg";
		$this->load->library('upload');
		if ($this->upload->error_check($fieldName) == 4) {
			return NULL;
		}
		if (!$this->upload->do_upload($fieldName, $destFileName, $path)) {
			echo($path);
			print_r( $this->upload->display_errors());
			die();
			return FALSE;
		}
		return $destFileName;
	}
	
}
