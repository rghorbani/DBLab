<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ShareCode
 *
// ------------------------------------------------------------------------

/**
 * Get "now" time
 *
 * Returns time() or its GMT equivalent based on the config file preference
 *
 * @access	public
 * @return	integer
 */

	function ts2date($ts) {
		return date("Y-m-d H:i:s",$ts);
	}
	function date2ts($date) {
		return strtotime($date);
	}
	function nowTS() {
		return time()+TIME_SHIFT;
	}
	function nowDate() {
		return ts2date(nowTS());
	}
	function nowDateArray() {
		return explode("-", date("Y-m-d-H-i-s",nowTS()));
	}
	function checkDateFormat($date) {
		if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) if(checkdate($parts[2],$parts[3],$parts[1])) return TRUE;
		return FALSE;
	}
	function checkDateTimeFormat($date) {
		if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$/", $date, $parts)) return TRUE;
		return FALSE;
	}
	function getDateParts($date) {
		preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts);
		return array($parts[1], $parts[2], $parts[3]);
	}
	function formatTime($secs) {
		$times = array(3600, 60, 1);
		$time = '';
		$tmp = '';
		for($i = 0; $i < 3; $i++) {
			$tmp = floor($secs / $times[$i]);
			if($tmp < 1) $tmp = '00';
			else if($tmp < 10) $tmp = '0' . $tmp;
			$time .= $tmp;
			if($i < 2) $time .= ':';
			$secs = $secs % $times[$i];
		}
		return $time;
	}
	
	function _addS($i, $m) {
		return ($i>1?$i:"one") . " " . $m . ($i>1?"s":"");
	}
	function date2ago($date) {
		
		$now = nowTS();
		$time= date2ts($date);
		$diff = $now-$time;
		if ($diff < 5)  return "Just now";
		if ($diff < 60) return $diff . " seconds ago";
		if ($diff < 60*60) {
			$m = floor($diff/60);
			$s = $diff%60;
			return _addS($m,"minute") . " and " . _addS($s, "second") . " ago";
		}
		if ($diff < 24*60*60) {
			$h = floor($diff/3600);
			$m = floor(($diff%3600)/60);
			return _addS($h, "hour") . " and " . _addS($m, "minute") . " ago";
		}
		if ($diff < 7*24*60*60) {
			$d = floor($diff/(3600*24));
			$h = floor(($diff%(3600*24))/3600);
			return  _addS($d, "day") . " and " . _addS($h, "hour") . " ago";
		}
		return $date;
	}
/* End of file SC_date_helper.php */
/* Location: ./application/helpers/SC_date_helper.php */