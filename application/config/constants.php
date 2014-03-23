<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');



/*
|--------------------------------------------------------------------------
| Password Hashing
|--------------------------------------------------------------------------
|
| This key is used as a salt for hashing password
|
*/

define('HASH_SALT', 'sharecode__');

/*
|--------------------------------------------------------------------------
| ALL
|--------------------------------------------------------------------------
|
|
*/

define('CAPTCHA_LIFETIME', 120);

define('PAGE_TITLE_PREFIX', "ShareCode :: ");
define('TIME_SHIFT', 0);//-4.3*3600);
define('MYSQL_TIME_SHIFT', -4.3*3600);
define('SUBMIT_DELAY_TIME', 15);
define('CONTEST_CREATE_DELAY_TIME', 60);
define('CONTEST_CREATE_ORDER_TIME', 3600*24*31); // 1 month
define('CONTEST_MIN_LENGTH', 15*60); // 10 minutes
define('CONTEST_MAX_LENGTH', 24*60*60); // 24 Hours

define('DEFUALT_THEME_ID', 2);
define('DEFUALT_USER_IMAGE', 'default.png');
define('DEFUALT_COMPILER', '-1');
define('DEFUALT_SHOWCOMPILER', '1');
define('DEFUALT_SHOWEMAIL', '1');
define('DEFAULT_USERNAME_CHANGES', '1');

define('DO_MAKE_LOGS', FALSE);
define('DO_MAKE_STATS', FALSE);

/*
|--------------------------------------------------------------------------
| Email
|--------------------------------------------------------------------------
|
| Mail constants
|
*/

define('EMAIL_SUPPORT_EMAIL', 'sharecode@acm.org');
define('EMAIL_SENDER_EMAIL', 'sharecode@acm.org');
define('EMAIL_SENDER_NAME', 'ShareCode');
define('EMAIL_ACTIVATION_MSG', "Greetings {NAME},<br />
Thank you for applying for registration with us. We have received your validation request and we will process it as soon as you confirm your email address by clicking on the following
hyperlink:<br />
<a href='{ACTIVATION_LINK}'>{ACTIVATION_LINK}</a><br />
Email: {EMAIL}<br />
Username: {USERNAME}<br />
<br />
Kind Regards,<br />
ShareCode Team<br />
<br />
NOTE: This email was automatically generated from ShareCode OnlineJudge (<a href='http://sharecode.ir'>http://sharecode.ir</a>)<br />");

define('EMAIL_RECOVERY_MSG', "Hello {NAME},<br />
We have received an account recovery request and we will process it as soon as you confirm it by clicking on the following
hyperlink:<br />
<a href='{RECOVERY_LINK}'>{RECOVERY_LINK}</a><br />
Email: {EMAIL}<br />
Username: {USERNAME}<br />
Profile: <a href='{PROFILE_LINK}'>{PROFILE_LINK}</a><br />
<br />
<strong>If you have no idea what is this email, just do nothing about it and feel free to ignore this message.</strong><br /><br />
Kind Regards,<br />
ShareCode Team<br />
<br />
NOTE: This email was automatically generated from ShareCode OnlineJudge (<a href='http://sharecode.ir'>http://sharecode.ir</a>)<br />");

define('EMAIL_NEWPASSWORD_MSG', "Hello {NAME},<br />
As you have requested, your password has been changed to something random.<br />
<br />
Email: {EMAIL}<br />
Username: {USERNAME}<br />
Password: {PASSWORD}<br /><br />
<strong>Please change your password as soon as possible.</strong><br /><br />
Kind Regards,<br />
ShareCode Team<br />
<br />
NOTE: This email was automatically generated from ShareCode OnlineJudge (<a href='http://sharecode.ir'>http://sharecode.ir</a>)<br />");


/*
|--------------------------------------------------------------------------
| Listing
|--------------------------------------------------------------------------
|
| Listing constants
|
*/

define('PROBLEMS_PER_PAGE', 100);
define('RUNS_PER_PAGE', 20);
define('DISCUSS_PER_PAGE', 10);
define('TOPICS_PER_PAGE', 20);
define('LOGS_PER_PAGE', 20);
define('CONTESTS_PER_PAGE', 100);
define('NEWS_PER_PAGE', 20);
define('SECTIONS_PER_PAGE', 100);
define('DATA_UPLOAD_PATH', "/home/judge/testdata/"); // it must be created first!
define('DIR_DELIM', "/");

//define('DATA_UPLOAD_PATH', "C:\\JUDGE\\DATA\\"); // it must be created first!
//define('DIR_DELIM', "\\");


/* End of file constants.php */
/* Location: ./application/config/constants.php */
