<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ShareCode
 *
 * 
 */

// ------------------------------------------------------------------------

/**
 * ShareCode Mailer Class
 *
 */
class SC_Mailer {

	var $CI;
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->config->load('scmailer');
	}
	// --------------------------------------------------------------------

	/**
	 * mailer
	 */
	
	function send($from_email, $from_name, $to_email, $to_name, $subject, $message) {
		
		$newLine = "\r\n";
		$errno = ""; $errstr = "";
		$smtpConnect = fsockopen($this->CI->config->item('scmailer_server'), $this->CI->config->item('scmailer_port'), $errno, $errstr, $this->CI->config->item('scmailer_timeout'));
		$smtpResponse = fgets($smtpConnect, 4096);
		if(empty($smtpConnect)) return FALSE;
		
		fputs($smtpConnect, "HELO ". $this->CI->config->item('scmailer_localhost') . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		
		fputs($smtpConnect,"AUTH LOGIN" . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		
		fputs($smtpConnect, base64_encode($this->CI->config->item('scmailer_username')) . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		
		fputs($smtpConnect, base64_encode($this->CI->config->item('scmailer_password')) . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		
		fputs($smtpConnect, "MAIL FROM: <" . $this->CI->config->item('scmailer_username') . ">" . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		
		fputs($smtpConnect, "RCPT TO: <" . $to_email . ">" . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		
		fputs($smtpConnect, "DATA" . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		
		$headers = "MIME-Version: 1.0" . $newLine;
		$headers .= "Content-type: text/html; charset=iso-8859-1" . $newLine;
		$headers .= "From: " . $from_name . " <" . $from_email . ">" . $newLine;
		$headers .= "To: " . $to_name . " <" . $to_email . ">" . $newLine;
		$headers .= "Subject: " . $subject . $newLine;
		//$headers .= "Reply-To: amir.s@acm.org" . $newLine;

		fputs($smtpConnect, $headers . "\r\n\r\n" . $message . "\r\n.\r\n");
		$smtpResponse = fgets($smtpConnect, 4096);
		
		fputs($smtpConnect,"QUIT" . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		fclose($smtpConnect);
		return TRUE;
	}
	
	
}

// END SC_Mailer class

/* End of file Mailer.php */
/* Location: ./application/libraries/Userdata.php */
