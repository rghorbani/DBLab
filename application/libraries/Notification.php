<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ShareCode
 *
 */



/**
 * ShareCode Notification Class
 *
 */
class Notification {



	public static $NOTIF_DISC_TOPIC = 1;
	public static $NOTIF_DISC_REPLY = 2;
	
	public static $NOTIF_BUG_REPORT = 100;
	
	var $CI;
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model("Notifications_model","Notifs");
	}
	
	public function notifySubscriptions($type, $label, $url, $point, $hash = '', $except=-1) {
		$this->CI->Notifs->notify($label, $url, $type, $point, $hash, nowDate(), 1, $except);
	}
	
	public function getNotificationList($user_id) {
		$list = $this->CI->Notifs->getList($user_id);
		return $list;
	}
	public function getNotificationListAfter($user_id, $date) {
		$list = $this->CI->Notifs->getListAfter($user_id, $date);
		return $list;
	}
	public function getUnreadCount($user_id) {
		return $this->CI->Notifs->getUnreadCount($user_id);
	}
	public function markAsRead($user_id) {
		$this->CI->Notifs->markAsRead_uid($user_id);
	}
	public function getHash($int) {
		return sha1("SCN0T" . sha1(mt_rand()+$int) . md5($int . 2*mt_rand()));
	}
	
	public function deleteNotificationsHash($hash) {
		$this->CI->Notifs->deleteNotificationsHash($hash);
	}
	
	public function follow($user_id, $target_id, $type) {
		$this->CI->Notifs->addSubscription($user_id, $target_id, $type);
	}
	
	public function unfollow($user_id, $target_id, $type) {
		$this->CI->Notifs->removeSubscription($user_id, $target_id, $type);
	}
	
	public function following($user_id, $target_id, $type) {
		return $this->CI->Notifs->isSubscribed($user_id, $target_id, $type);
	}
	
	public function removeOldNotifications($user_id) {
		$this->CI->Notifs->removeOldNotifications($user_id);
	}
	
	public function getLastId($user_id) {
		return $this->CI->Notifs->getLastId($user_id);
	}
	
	
	// CUSTOM FUNCTIONS
	public function discussion_deleteTopicNotification($topic_id) {
		$this->CI->Notifs->discussion_deleteTopicNotification($topic_id);
	}
	
	
}

