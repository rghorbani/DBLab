<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ShareCode
 *
 * 
 */

// ------------------------------------------------------------------------

function hashPassword($password, $username) {
	return do_hash($password . HASH_SALT . $username . md5($password));
}

function clean4print($str) {
	return htmlspecialchars($str);
}

function clean4label($str) {
	$label = stripslashes($str);
	$label = preg_replace("~^(\s*)(.*?)(\s*)$~m", "\\2", $label);
	$label = preg_replace("/[^A-Za-z0-9 \.\#\@\!\?\-\_\(\)]/","",$label);
	$label = preg_replace('/\s\s+/', ' ', $label);
	return $label;
}
function actualLength($str) {
	return strlen(preg_replace("/\s/", "", $str));
}

function clean4username($username) {
	for ($i=0;$i<strlen($username);$i++) {
		if (ctype_alpha($username[$i])) continue;
		if (is_numeric($username[$i])) continue;
		if ($username[$i] == ".") continue;
		$username[$i] = ".";
	}
	
	for ($i=0;$i<strlen($username)-1;$i++) {
		if ($username[$i] == "." && $username[$i+1] == ".") {
			$username = substr($username, 0, $i) . substr($username, $i+1);
			$i--;
		}
	}
	if ($username[0] == ".") $username = substr($username, 1);
	if ($username[strlen($username)-1] == ".") $username = substr($username, 0, strlen($username)-1);
	return $username;
}
	

/* End of file security_helper.php */
/* Location: ./application/helpers/security_helper.php */
