<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
	'sections/add_existing_problem' => array(
		array(
			'field' => 'section_from',
			'label' => 'Section From ID',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'code',
			'label' => 'Problem Code',
			'rules' => 'trim|required|exact_length[4]|numeric'
		),
		array(
			'field' => 'section_to',
			'label' => 'Section To ID',
			'rules' => 'trim|required|numeric'
		)
	),
	'sections/edit_problem' => array(
		array(
			'field' => 'section',
			'label' => 'Section ID',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'code',
			'label' => 'Problem Code',
			'rules' => 'trim|required|exact_length[4]|numeric'
		),
		array(
			'field' => 'name',
			'label' => 'Problem Name',
			'rules' => 'trim|required|min_length[3]'
		),
		array(
			'field' => 'time_limit',
			'label' => 'Time Limit',
			'rules' => 'trim|required|is_natural|greater_than[0]|less_than[61]'
		),
		array(
			'field' => 'memory_limit',
			'label' => 'Memory Limit',
			'rules' => 'trim|required|is_natural|greater_than[0]|less_than[257]'
		),
		array(
			'field' => 'statement',
			'rules' => ''
		),
		array(
			'field' => 'input',
			'rules' => ''
		),
		array(
			'field' => 'output',
			'rules' => ''
		),
		array(
			'field' => 'output',
			'rules' => ''
		),
		array(
			'field' => 'sample_input',
			'rules' => ''
		),
		array(
			'field' => 'sample_output',
			'rules' => ''
		),
		array(
			'field' => 'hint',
			'rules' => ''
		),
		array(
			'field' => 'source_id',
			'rules' => ''
		),
		array(
			'field' => 'is_visible',
			'rules' => ''
		)
	),
	'sections/arrange' => array(
		array(
			'field' => 'label',
			'label' => 'Section Label',
			'rules' => 'required|clean4label|min_length[2]|max_length[50]'
		),
		array(
			'field' => 'url',
			'label' => 'Section URL',
			'rules' => 'required|clean4label|min_length[2]|max_length[10]'
		),
		array(
			'field' => 'starttime_date',
			'label' => 'Section Date',
			'rules' => 'required|callback__check_date_format|callback__check_contest_date'
		),
		array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => ''
		),
		array(
			'field' => 'tH',
			'label' => 'Hour',
			'rules' => 'required|numeric|is_natural|callback__check_hour'
		),
		array(
			'field' => 'tM',
			'label' => 'Minute',
			'rules' => 'required|numeric|is_natural|callback__check_minute'
		),
		array(
			'field' => 'tS',
			'label' => 'Second',
			'rules' => 'required|numeric|is_natural|callback__check_second'
		),
		array(
			'field' => 'lH',
			'label' => 'Hours',
			'rules' => 'required|numeric|is_natural'
		),
		array(
			'field' => 'lM',
			'label' => 'Minutes',
			'rules' => 'required|numeric|is_natural'
		),
		array(
			'field' => 'lS',
			'label' => 'Seconds',
			'rules' => 'required|numeric|is_natural|callback__check_contest_length'
		),
		array(
			'field' => 'priority',
			'label' => 'Priority',
			'rules' => 'required|numeric'
		),
		array(
			'field' => 'visible',
			'label' => 'Visibility',
			'rules' => 'required|numeric'
		)
	),
	'sections/submit' => array(
		array(
			'field' => 'source_code',
			'label' => 'Source Code',
			'rules' => 'required|min_length[5]|max_length[51201]'
		),
		array(
			'field' => 'language',
			'label' => 'Programming Language',
			'rules' => 'required|numeric|callback__lang_exists'
		),
		array(
			'field' => 'code',
			'label' => '',
			'rules' => 'callback__time_check'
		)
	),
	'admin/manage_news' => array(
		array(
			'field' => 'priority',
			'label' => 'Priority',
			'rules' => 'required|numeric'
		),
		array(
			'field' => 'visible',
			'label' => 'Visible',
			'rules' => 'required|numeric'
		),
		array(
			'field' => 'content',
			'label' => 'Content',
			'rules' => 'required'
		)
	),
	'contests/vranklists' => array(
		array(
			'field' => 'pnum',
			'label' => 'Number of Problems',
			'rules' => 'trim|required|is_natural|greater_than[5]|less_than[15]'
		)
	),
	'users/login' => array(
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required'
		)
	),
	'users/recover' => array(
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email'
		),
		array(
			'field' => 'captcha',
			'label' => 'Captcha',
			'rules' => 'trim|required|callback__captcha_check'
		)
	),
	'users/signup' => array(
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required|min_length[4]|max_length[20]|callback__username_check'
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|min_length[7]'
		),
		array(
			'field' => 'confirm_password',
			'label' => 'Confirm Password',
			'rules' => 'required|matches[password]'
		),
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email'
		),
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'trim|required|min_length[4]|max_length[30]'
		),
		array(
			'field' => 'captcha',
			'label' => 'Captcha',
			'rules' => 'trim|required|callback__captcha_check'
		),
		array(
			'field' => 'school',
			'label' => 'School',
			'rules' => 'trim|max_length[50]'
		)
	),
	'admin/add_problem' => array(
		array(
			'field' => 'code',
			'label' => 'Problem Code',
			'rules' => 'trim|required|exact_length[4]|callback__problem_code_check|numeric'
		),
		array(
			'field' => 'name',
			'label' => 'Problem Name',
			'rules' => 'trim|required|min_length[3]'
		),
		array(
			'field' => 'time_limit',
			'label' => 'Time Limit',
			'rules' => 'trim|required|is_natural|greater_than[0]|less_than[61]'
		),
		array(
			'field' => 'memory_limit',
			'label' => 'Memory Limit',
			'rules' => 'trim|required|is_natural|greater_than[0]|less_than[257]'
		),
		array(
			'field' => 'statement',
			'rules' => ''
		),
		array(
			'field' => 'input',
			'rules' => ''
		),
		array(
			'field' => 'output',
			'rules' => ''
		),
		array(
			'field' => 'output',
			'rules' => ''
		),
		array(
			'field' => 'sample_input',
			'rules' => ''
		),
		array(
			'field' => 'sample_output',
			'rules' => ''
		),
		array(
			'field' => 'hint',
			'rules' => ''
		),
		array(
			'field' => 'source_id',
			'rules' => ''
		),
		array(
			'field' => 'section_url',
			'rules' => 'required|numeric|is_natural'
		),
		array(
			'field' => 'is_visible',
			'rules' => ''
		)
	),
	'admin/edit_problem' => array(
		array(
			'field' => 'section',
			'label' => 'Section ID',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'code',
			'label' => 'Problem Code',
			'rules' => 'trim|required|exact_length[4]|numeric'
		),
		array(
			'field' => 'name',
			'label' => 'Problem Name',
			'rules' => 'trim|required|min_length[3]'
		),
		array(
			'field' => 'time_limit',
			'label' => 'Time Limit',
			'rules' => 'trim|required|is_natural|greater_than[0]|less_than[61]'
		),
		array(
			'field' => 'memory_limit',
			'label' => 'Memory Limit',
			'rules' => 'trim|required|is_natural|greater_than[0]|less_than[257]'
		),
		array(
			'field' => 'statement',
			'rules' => ''
		),
		array(
			'field' => 'input',
			'rules' => ''
		),
		array(
			'field' => 'output',
			'rules' => ''
		),
		array(
			'field' => 'output',
			'rules' => ''
		),
		array(
			'field' => 'sample_input',
			'rules' => ''
		),
		array(
			'field' => 'sample_output',
			'rules' => ''
		),
		array(
			'field' => 'hint',
			'rules' => ''
		),
		array(
			'field' => 'source_id',
			'rules' => ''
		),
		array(
			'field' => 'is_visible',
			'rules' => ''
		)
	),
	'admin/manage_sources' => array(
		array(
			'field' => 'label',
			'label' => 'Source Label',
			'rules' => 'trim|required|min_length[3]|max_length[255]'
		)
	),
	'problemset/submit' => array(
		array(
			'field' => 'source_code',
			'label' => 'Source Code',
			'rules' => 'required|min_length[5]|max_length[51201]'
		),
		array(
			'field' => 'language',
			'label' => 'Programming Language',
			'rules' => 'required|numeric|callback__lang_exists'
		),
		array(
			'field' => 'code',
			'label' => '',
			'rules' => 'callback__time_check'
		)
	),
	'admin/add_picture' => array(
		array(
			'field' => 'problem_code',
			'label' => 'Problem Code',
			'rules' => 'required|min_length[4]'
		)
	),
	'contests/arrange' => array(
		array(
			'field' => 'label',
			'label' => 'Contest Label',
			'rules' => 'required|clean4label|min_length[5]|max_length[50]'
		),
		array(
			'field' => 'starttime_date',
			'label' => 'Contest Date',
			'rules' => 'required|callback__check_date_format|callback__check_contest_date'
		),
		array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => ''
		),
		array(
			'field' => 'vranklist',
			'label' => 'Virtual Ranklist',
			'rules' => 'required|trim|is_numeric'
		),
		array(
			'field' => 'tH',
			'label' => 'Hour',
			'rules' => 'required|numeric|is_natural|callback__check_hour'
		),
		array(
			'field' => 'tM',
			'label' => 'Minute',
			'rules' => 'required|numeric|is_natural|callback__check_minute'
		),
		array(
			'field' => 'tS',
			'label' => 'Second',
			'rules' => 'required|numeric|is_natural|callback__check_second'
		),
		array(
			'field' => 'lH',
			'label' => 'Hours',
			'rules' => 'required|numeric|is_natural'
		),
		array(
			'field' => 'lM',
			'label' => 'Minutes',
			'rules' => 'required|numeric|is_natural'
		),
		array(
			'field' => 'lS',
			'label' => 'Seconds',
			'rules' => 'required|numeric|is_natural|callback__check_contest_length'
		),
		array(
			'field' => 'p1',
			'label' => 'Problem A',
			'rules' => 'required|is_natural'
		),
		array(
			'field' => 'p2',
			'label' => 'Problem B',
			'rules' => 'required|is_natural'
		),
		array(
			'field' => 'p3',
			'label' => 'Problem C',
			'rules' => 'required|is_natural'
		),
		array(
			'field' => 'p4',
			'label' => 'Problem D',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p5',
			'label' => 'Problem E',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p6',
			'label' => 'Problem F',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p7',
			'label' => 'Problem G',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p8',
			'label' => 'Problem H',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p9',
			'label' => 'Problem I',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p10',
			'label' => 'Problem J',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p11',
			'label' => 'Problem K',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p12',
			'label' => 'Problem L',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p13',
			'label' => 'Problem M',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p14',
			'label' => 'Problem N',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p15',
			'label' => 'Problem O',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'p1_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p2_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p3_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p4_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p5_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p6_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p7_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p8_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p9_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p10_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p11_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p12_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p13_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p14_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		),
		array(
			'field' => 'p15_c',
			'label' => 'Problem O Color',
			'rules' => 'trim'
		)
	),
	'contests/contest_submit' => array(
		array(
			'field' => 'source_code',
			'label' => 'Source Code',
			'rules' => 'required|min_length[5]|max_length[51201]|callback__time_check'
		),
		array(
			'field' => 'language',
			'label' => 'Programming Language',
			'rules' => 'required|numeric|callback__lang_exists'
		),
		array(
			'field' => 'problem',
			'label' => '',
			'rules' => 'required'
		)
	),
	'contests/clars' => array(
		array(
			'field' => 'question',
			'label' => 'Question',
			'rules' => 'required|min_length[5]|max_length[2001]'
		),
		array(
			'field' => 'problem',
			'label' => '',
			'rules' => 'required'
		)
	),
	'contests/clarjudge' => array(
		array(
			'field' => 'answer',
			'label' => 'Answer',
			'rules' => ''
		),
		array(
			'field' => 'to_all',
			'label' => '',
			'rules' => ''
		),
		array(
			'field' => 'cid',
			'label' => '',
			'rules' => 'numeric'
		)
	),
	'users/edit{name}' => array(
		array(
			'field' => 'display_name',
			'label' => 'Display Name',
			'rules' => 'trim|required|min_length[4]|max_length[30]'
		),
		array(
			'field' => 'school',
			'label' => 'School',
			'rules' => 'trim|max_length[65]'
		),
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|min_length[4]|max_length[20]|callback__username_change_check'
		)
	),
	'users/edit{setting}' => array(
		array(
			'field' => 'language',
			'label' => 'Programming Language',
			'rules' => 'required|numeric|callback__lang_exists'
		),
		array(
			'field' => 'show_compiler',
			'label' => 'Show Compiler',
			'rules' => 'trim|numeric'
		)
	),
	'users/update_email' => array(
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email'
		),
		array(
			'field' => 'show_email',
			'label' => 'Show Email',
			'rules' => ''
		)
	),
	'discussion{new_post}' => array(
		array(
			'field' => 'text',
			'label' => 'Message',
			'rules' => 'required|min_length[5]|max_length[3000]'
		)
	),
	'discussion{new_topic}' => array(
		array(
			'field' => 'text',
			'label' => 'Message',
			'rules' => 'required|min_length[5]|max_length[3000]'
		),
		array(
			'field' => 'subject',
			'label' => 'Subject',
			'rules' => 'required|min_length[5]|max_length[250]|callback__subject_check'
		),
	),
	'users/change_password' => array(
		array(
			'field' => 'cpassword',
			'label' => 'Current Password',
			'rules' => 'required|callback__check_password'
		),
		array(
			'field' => 'npassword',
			'label' => 'Password',
			'rules' => 'required|min_length[7]'
		),
		array(
			'field' => 'npassword_conf',
			'label' => 'Confirm Password',
			'rules' => 'required|matches[npassword]'
		)
	),
	
);





/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */







