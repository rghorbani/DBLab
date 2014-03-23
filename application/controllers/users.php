<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends SC_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	}
	
	public function login() {
		$this->form_validation->set_message('required', 'Please fill in the form!');
		$this->load->helper('security');
		$data["title"] = "Login";
		$data["invalid_login"] = FALSE;
		$data["show_login_box"] = FALSE;
		$data["back_url"] = "";
		if ($this->form_validation->run() == FALSE) {
			if ($this->input->get("next")) $data["back_url"] = $this->input->get("next");
			if ($this->input->post("back_url") != FALSE && $this->input->post("back_url") != "") $data["back_url"] = $this->input->post("back_url");
			$this->master_view("user/login", $data);
			return;
		}
		$current_user = $this->login->login($this->input->post("username"), $this->input->post("password"));
		if ($current_user == FALSE) {
			if ($this->input->post("back_url") != FALSE && $this->input->post("back_url") != "") $data["back_url"] = $this->input->post("back_url");
			$data["invalid_login"] = TRUE;
			$this->master_view("user/login",$data);
			return;
		}
		
		//removing old notifs
		$this->load->library("notification");
		$this->notification->removeOldNotifications($current_user->id);
	
		$url = '';
		if ($this->input->post("back_url") != FALSE && $this->input->post("back_url") != "") {
			$url = $this->input->post("back_url");
		}
		
		// do not redirect to signup page
		if (substr($url, 0, 12) == "users/signup") $url = "";
		
		if ($this->input->post("username") != clean4username($this->input->post("username"))) {
			$data["next"] = $url;
			$data["title"] = "Username Changed";
			$data["is_logged_in"] = TRUE;
			$data["current_user"] = $current_user;
			$this->master_view("general/username_changed", $data);
			return;
		}
		
		redirect(site_url($url), 'location');
	}
	
	public function invalid() {
		$data["title"] = "Sorry!";
		$data["show_login_box"] = TRUE;
		$this->master_view("user/invalid", $data);
	}
	
	public function logout() {
		$this->login->logout();
		$data["invalid_login"] = FALSE;
		$data["title"] = "Login";
		$data["show_login_box"] = FALSE;
		redirect('');
	}
	
	public function new_captcha($rand_str=NULL) {
		$this->load->helper('captcha');
		$cap = create_captcha();
		$this->load->model("Users_model","Users");
		$this->load->helper('security');
		$hash = do_hash(mt_rand() . $cap["word"] . "__sh_c0d3!");
		$this->Users->deleteOldCaptcha();
		$this->Users->newCaptcha($cap["word"], $hash, nowTS());
		echo ($hash . "|" . site_url("captcha/" . $cap['filename']));
		
	}
	public function signup() {
		$this->load->helper('captcha');
		$this->load->helper('security');
		$this->load->model("Users_model","Users");
		
		if ($this->form_validation->run() == FALSE) {
			$data["title"] = "SignUp";
			$cap = create_captcha();
			$data["captcha_image"] = $cap['filename'];
			$hash = do_hash(mt_rand() . $cap["word"] . "__sh_c0d3!");
			$data["captcha_hash"] = $hash;
			$this->Users->deleteOldCaptcha();
			$this->Users->newCaptcha($cap["word"], $hash, nowTS());
			$this->master_view("user/signup", $data);
			return;
		}
		$this->load->library("Mailer");
		
		srand(time(NULL));
		$rand_str = do_hash($this->input->post("email") . "__sh_c0d3!" . rand());
		$str = str_replace(array("{NAME}", "{ACTIVATION_LINK}", "{EMAIL}", "{USERNAME}"), array(clean4print($this->input->post("name")), site_url("users/validate/" . $rand_str), $this->input->post("email"), clean4print($this->input->post("username"))), EMAIL_ACTIVATION_MSG);
		if ($this->mailer->send(EMAIL_SENDER_EMAIL, EMAIL_SENDER_NAME, $this->input->post("email"), "ShareCode User", "ShareCode email validation", $str)) {
			// email sent correctly
		}
		
		$this->Users->addUser($this->input->post("username"), $this->input->post("password"), $this->input->post("email"), $this->input->post("name"), $this->input->post("school"), $rand_str);
		//$this->login->login($this->input->post("username"), $this->input->post("password")); // LOGIN AFTER SIGNUP?
		$data["title"] = "You are in";
		$this->master_view("user/signedup", $data);
	}
	
	
	public function recover() {
		$data["title"] = "Recover Account";
		$this->load->helper('captcha');
		
		if ($this->form_validation->run() == FALSE) {
		
			$cap = create_captcha();
			$data["captcha_image"] = $cap['filename'];
			$hash = do_hash(mt_rand() . $cap["word"] . "__sh_c0d3!");
			$data["captcha_hash"] = $hash;
			$this->Users->deleteOldCaptcha();
			$this->Users->newCaptcha($cap["word"], $hash, nowTS());
			
			$this->master_view("user/recover",$data);
			return;
		}
		
		$this->load->helper('security');
		$this->load->model("Users_model","Users");
		$this->load->library("Mailer");
		
		srand(time(NULL));
		$users = $this->Users->getUsersByEmail($this->input->post("email"));
		foreach($users as $user) {
			$rand_str = do_hash($this->input->post("email") . "__sh_c0d3!" . rand());
			$str = str_replace(array("{NAME}", "{RECOVERY_LINK}", "{EMAIL}", "{USERNAME}", "{PROFILE_LINK}"), array(($user->name), site_url("users/r/" . $rand_str), clean4print($user->email), clean4print($user->username), site_url("users/profile/" . $user->id)), EMAIL_RECOVERY_MSG);
			$this->Users->addRecovery($user->id, $rand_str);
			if ($this->mailer->send(EMAIL_SENDER_EMAIL, EMAIL_SENDER_NAME, $user->email, "ShareCode User", "ShareCode recovery confirmation", $str)) {
				// email sent correctly
			}
		}
		$this->master_view("user/recovered", $data);
	}
	
	// RECOVERY LINKS
	public function r($key = NULL) {
		if ($key == NULL) show_404();
		$data["title"] = "Recover Account";
		
		$this->load->model("Users_model","Users");
		$this->load->library("Mailer");
		
		$req = $this->Users->getRecovery($key);
		$this->load->helper('security');
		$this->load->helper('password');
		
		if ($req != NULL) {
			$user = $this->Users->getUserById($req->user_id);
			if ($user == NULL) show_404();
			$password = generateRandomPassword();
			$str = str_replace(array("{NAME}", "{EMAIL}", "{USERNAME}", "{PASSWORD}", "{PROFILE_LINK}"), array($user->name, clean4print($user->email), $user->username, $password, site_url("users/profile/" . $user->id)), EMAIL_NEWPASSWORD_MSG);
			
			$this->Users->deleteRecovery($user->id, $key);
			$this->Users->updatePassword($user->id, $password, $user->username);
			
			if ($this->mailer->send(EMAIL_SENDER_EMAIL, EMAIL_SENDER_NAME, $user->email, "ShareCode User", "ShareCode password reset", $str)) {
				// email sent correctly
			}
		}
		$this->master_view("user/password_changed", $data);
	}
	
	// public function edit() {
		// $this->require_login();
		// $this->load->model("Users_model","Users");
		// $data["title"] = "User Profile";
		// $data["is_default_picture"] = FALSE;
		// $data["changed"] = FALSE;
		// $data["image_size_err"] = FALSE;
		// if ($this->input->get("e") == "l") $data["image_size_err"] = TRUE;
		// if ($this->current_user->picture == DEFUALT_USER_IMAGE) {
			// $data["is_default_picture"] = TRUE;
		// }
		// if ($this->form_validation->run('users/edit') == FALSE) {
			// $this->master_view("user/edit_profile", $data);
			// return;
		// }
		// $this->Users->updateUserProfile($this->current_user->id, $this->input->post("display_name"), $this->input->post("school"));
		// $data["changed"] = TRUE;
		// $this->master_view("user/edit_profile", $data);
		
	// }
	
	public function edit() {
		$this->require_login();
		$this->load->model("Users_model","Users");
		$data["title"] = "User Profile";
		$data["is_default_picture"] = FALSE;
		$data["changed_name"] = FALSE;
		$data["changed_setting"] = FALSE;
		$data["image_size_err"] = FALSE;
		$data["pass_err"] = FALSE;
		
		$this->load->model("Problemset_model", "Problems");
		$data["langs"] = $this->Problems->getLangs();
		if ($this->input->get("e") == "l") $data["image_size_err"] = TRUE;
		if ($this->current_user->picture == DEFUALT_USER_IMAGE) {
			$data["is_default_picture"] = TRUE;
		}
		$section = $this->input->post("sectoin");
		if ($section == "name") {
			if ($this->form_validation->run('users/edit{name}') == FALSE) {
				$this->master_view("user/edit_profile", $data);
				return;
			}
			if ($this->current_user->username != $this->input->post("username") && $this->current_user->username_changes>=1) {
				if (!$this->input->post("password")) {
					$data["pass_err"] = TRUE;
				}else if ($this->login->checkPassword($this->current_user->username, $this->input->post("password"))) {
					$this->Users->updateUsernamePassword($this->current_user->id, $this->input->post("username"), hashPassword($this->input->post("password"), $this->input->post("username")));
					
					// update to show in this view
					$this->current_user->username_changes--;
					$this->current_user->username = $this->input->post("username");
					$this->login->login($this->input->post("username"), $this->input->post("password")); // LOGIN AFTER SIGNUP?
					$this->Users->decreaseUsernameChanges($this->current_user->id);
				}else {
					$data["pass_err"] = TRUE;
				}
			}
			$this->Users->updateUserProfile($this->current_user->id, $this->input->post("display_name"), $this->input->post("school"));
			$data["changed_name"] = TRUE;

			$this->master_view("user/edit_profile", $data);
		} else if ($section == "setting") {
			
			if ($this->form_validation->run('users/edit{setting}') == FALSE) {
				$this->master_view("user/edit_profile", $data);
				return;
			}
			$this->Users->updateGeneralSettings($this->current_user->id, $this->input->post("language"), $this->input->post("show_compiler") == "1");
			$data["changed_setting"] = TRUE;
			$this->master_view("user/edit_profile", $data);
		} else {
			$this->master_view("user/edit_profile", $data);
		}
	}
	
	public function delete_picture() {
		$this->require_login();
		$this->load->model("Users_model","Users");
		$this->Users->updatePicture($this->current_user->id, DEFUALT_USER_IMAGE);
		redirect("users/edit");
	}
	public function change_password() {
		$this->require_login();
		$this->load->helper('security');
		if ($this->form_validation->run('users/change_password') == FALSE) {
			$this->edit();
			return;
		}
		$this->load->model("Users_model","Users");
		$this->Users->updatePassword($this->current_user->id, $this->input->post("npassword"), $this->current_user->username);
		$data["title"] = "Login";
		$this->master_view("user/changed_pass_login", $data);
	}
	public function update_email() {
		$this->require_login();
		if ($this->form_validation->run('users/update_email') == FALSE) {
			$this->edit();
			return;
		}
		$this->load->library("Mailer");
		$this->load->model("Users_model","Users");
		if ($this->current_user->email != $this->input->post("email")) {
			$this->Users->updateEmail($this->current_user->id, $this->input->post("email"), FALSE, $this->input->post("show_email_checkbox") == "1");
			srand(time(NULL));
			$rand_str = do_hash($this->input->post("email") . "__sh_c0d3!" . rand());
			$this->Users->insertValidationRecord($this->current_user->id, $rand_str);
			$str = str_replace(array("{NAME}", "{ACTIVATION_LINK}", "{EMAIL}", "{USERNAME}"), array(clean4print($this->current_user->name), site_url("users/validate/" . $rand_str), $this->input->post("email"), clean4print($this->current_user->username)), EMAIL_ACTIVATION_MSG);
			if ($this->mailer->send(EMAIL_SENDER_EMAIL, EMAIL_SENDER_NAME, $this->input->post("email"), "ShareCode User", "ShareCode email validation", $str)) {
				// email sent correctly
			}
			$data["title"] = "Validation email sent";
			$this->master_view("user/activation_sent", $data);
		}else {
			$this->Users->changeShowEmail($this->current_user->id, $this->input->post("show_email") == "1");
			redirect("users/edit");
		}
	}
	
	public function send_validation_email() {
		$this->require_login();
		if ($this->current_user->is_valid == TRUE) show_404();
		$this->load->library("Mailer");
		$this->load->model("Users_model","Users");
		$rand_str = $this->Users->getValidationKey($this->current_user->id);
		$str = str_replace(array("{NAME}", "{ACTIVATION_LINK}", "{EMAIL}", "{USERNAME}"), array(clean4print($this->current_user->name), site_url("users/validate/" . $rand_str), $this->current_user->email, clean4print($this->current_user->username)), EMAIL_ACTIVATION_MSG);
		if ($this->mailer->send(EMAIL_SENDER_EMAIL, EMAIL_SENDER_NAME, $this->current_user->email, "ShareCode User", "ShareCode email validation", $str)) {
			// email sent correctly
		}
		$data["title"] = "Validation email sent";
		$this->master_view("user/activation_sent", $data);
	}
	
	public function validate($key = NULL) {
		if ($key == NULL) show_404();
		$this->load->model("Users_model","Users");
		if ($this->Users->key_exists($key) == FALSE) show_404();
		$this->Users->validate($key);
		$data["title"] = "Email validated!";
		$this->master_view("user/activated", $data);
	}

	public function update_picture() {
		$this->require_login();
		// if ($this->input->file("photo") == FALSE) redirect("users/edit");
		
		
		$file = $this->_upload_profilepic("photo");
		
		if ($file == FALSE) redirect("users/edit");
		
		$size = filesize('assets' . DIR_DELIM . 'user_images' . DIR_DELIM . $file . ".jpg");
		if ($size > 500000) {
			unlink('assets' . DIR_DELIM . 'user_images' . DIR_DELIM . $file . ".jpg");
			redirect("users/edit/?e=l");
			return;
		}
		$config['image_library'] = 'gd2';
		$config['source_image'] = 'assets' . DIR_DELIM . 'user_images' . DIR_DELIM . $file . ".jpg";
		$config['new_image'] = 'assets' . DIR_DELIM . 'user_images' . DIR_DELIM . do_hash($file) . "_thumb.jpg";
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 70;
		$config['height'] = 70;
		
		$this->load->library('image_lib');
		$this->image_lib->initialize($config); 
		if (!$this->image_lib->resize()) {
			redirect("users/edit");// echo $this->image_lib->display_errors();
		}
		$config['new_image'] = 'assets' . DIR_DELIM . 'user_images' . DIR_DELIM . do_hash($file) . ".jpg";
		$config['width'] = 260;
		$config['height'] = 260;
		$this->image_lib->initialize($config); 
		if ( !$this->image_lib->resize()) {
			redirect("users/edit");// echo $this->image_lib->display_errors();
		}
		unlink('assets' . DIR_DELIM . 'user_images' . DIR_DELIM . $file . ".jpg");
		
		$this->load->model("Users_model","Users");
		$this->Users->updatePicture($this->current_user->id, do_hash($file) . ".jpg");
		redirect("users/edit");
	}
	
	public function profile($user_id = NULL) {
		if ($user_id == NULL || !is_numeric($user_id)) show_404();
		$this->load->model("Users_model","Users");
		$this->load->model("Problemset_model","Problems");
		$user = $this->Users->getUserProfile($user_id);
		if ($user == NULL) show_404();
	
		$data["title"] = "User Profile";
		$data["user"] = $user;
		$user->rank = $this->Users->getUserRank_acc($user_id);
		$data["total_users"] = $this->Users->getTotalUsers();
		$data["acc_problems"] = $this->Users->getTotalUserAcc($user_id);
		$data["default_compiler"] = $this->Problems->getLang($user->default_compiler);
		$this->master_view("user/profile", $data);
	}
	
	// public function u_profile($username = NULL, $p = NULL) {
		// if ($username == NULL) show_404();
		// $this->load->model("Users_model","Users");
		// $id = $this->Users->getIdByUsername($username);
		// if ($id == NULL) show_404();
		// if ($p == NULL) return $this->profile($id);
		// if ($p == "runs") return $
	// }
	
	public function ranklist() {
		$this->load->model("Users_model","Users");
		$data["title"] = "Overall Ranklist";
		$data["users"] = $this->Users->getTopRank_acc();
		$data["act_users"] = $this->Users->getTopRank_act(ts2date(nowTS()-15*24*3600), nowDate());
		
		$data["current_rank"] = "";
		$data["current_acc"] = "";
		
		if ($this->current_user != NULL) {
			$data["current_rank"] = $this->Users->getUserRank_acc($this->current_user->id);
			$data["current_acc"] = count($this->Users->getTotalUserAcc($this->current_user->id));
			$data["current_actrank"] = $this->Users->getUserRank_act($this->current_user->id, ts2date(nowTS()-15*24*3600), nowDate());
			$data["current_actacc"] = count($this->Users->getTotalUserAct($this->current_user->id, ts2date(nowTS()-15*24*3600), nowDate()));
		}
		
		
		$this->master_view("user/ranklist", $data);
	}
	
	// used for form validation in signup
	public function _username_check($username, $field="_username_check") {
		if ($field == "") $field = __FUNCTION__;
		for ($i=0;$i<strlen($username);$i++) {
			if (ctype_alpha($username[$i])) continue;
			if (is_numeric($username[$i])) continue;
			if ($username[$i] == ".") continue;
			$this->form_validation->set_message($field, 'Username can only contain alpha, numbers and dots.');
			return FALSE;
		}
		if ($username[0] == "." || $username[strlen($username)-1] == ".") {
			$this->form_validation->set_message($field, 'Dots can not be the first or the last character.');
			return FALSE;
		}
		for ($i=0;$i<strlen($username)-1;$i++) {
			if ($username[$i] == "." && $username[$i+1] == ".") {
				$this->form_validation->set_message($field, 'Username can not contain dots after dots.');
				return FALSE;
			}
		}
		$this->load->model("Users_model","Users");
		if ($this->Users->usernameExists($username) == TRUE) {
			$this->form_validation->set_message($field, 'This username is taken!');
			return FALSE;
		}
		return TRUE;
	}
	
	// used for form validation in signup
	public function _username_change_check($username) {
		if (strtolower($username) == strtolower($this->current_user->username)) return TRUE;
		return $this->_username_check($username, "_username_change_check");
	}
	
	private function _upload_profilepic($fieldName) {
		$path = 'assets' . DIR_DELIM . 'user_images';
		$destFileName = md5($this->current_user->id . "__sc" . md5($this->current_user->username));
		$this->load->library('upload');
		if ($this->upload->error_check($fieldName) == 4) {
			return NULL;
		}
		if (!$this->upload->do_upload($fieldName, $destFileName . ".jpg", $path)) {
			return FALSE;
		}
		return $destFileName;
	}
	
	// used for form validation in change pass
	public function _check_password($password) {
		$this->load->model("Users_model","Users");
		if ($this->login->checkPassword($this->current_user->username, $password) == FALSE) {
			$this->form_validation->set_message('_check_password', 'Wrong password!');
			return FALSE;
		}
		return TRUE;
	}
	
	// used for form validatoin in signup
	public function _captcha_check($word) {
		$this->load->model("Users_model","Users");
		if ($this->Users->captchaValid($word, $this->input->post("hash"))) {
			return TRUE;
		}
		$this->form_validation->set_message('_captcha_check', 'Enter the word in the picture more carefuly!');
		return FALSE;
	}
	
	// used for form validation in default compiler - returns FALSE where the lang not exists
	public function _lang_exists($id) {
		$this->load->model("Problemset_model", "Problems");
		if (intval($id) != -1 && $this->Problems->isLangExists($id) == FALSE) {
			$this->form_validation->set_message('_lang_exists', 'Choose your language!');
			return FALSE;
		}
		return TRUE;
	}
	
}

