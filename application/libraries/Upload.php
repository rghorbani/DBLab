<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ShareCode
 *
 */

// ------------------------------------------------------------------------

/**
 * File Uploading Class
 *
 */
class SC_Upload {
	public $error_msg	= array();
	
	// Was the file able to be uploaded? If not, determine the reason why.
	public function error_check ($field) {
		if (!is_uploaded_file($_FILES[$field]['tmp_name'])) {
			$error = ( ! isset($_FILES[$field]['error'])) ? 4 : $_FILES[$field]['error'];
			switch($error){
				case 1:	// UPLOAD_ERR_INI_SIZE
					$this->set_error('upload_file_exceeds_limit');
					break;
				case 2: // UPLOAD_ERR_FORM_SIZE
					$this->set_error('upload_file_exceeds_form_limit');
					break;
				case 3: // UPLOAD_ERR_PARTIAL
					$this->set_error('upload_file_partial');
					break;
				case 4: // UPLOAD_ERR_NO_FILE
					$this->set_error('upload_no_file_selected');
					break;
				case 6: // UPLOAD_ERR_NO_TMP_DIR
					$this->set_error('upload_no_temp_directory');
					break;
				case 7: // UPLOAD_ERR_CANT_WRITE
					$this->set_error('upload_unable_to_write_file');
					break;
				case 8: // UPLOAD_ERR_EXTENSION
					$this->set_error('upload_stopped_by_extension');
					break;
				default :   $this->set_error('upload_no_file_selected');
					break;
			}
			return $error;
		}
		return 0;
	}
	public function do_upload($field, $fileName, $dest) {

		// Is $_FILES[$field] set? If not, no reason to continue.
		if ( ! isset($_FILES[$field])) {
			$this->set_error('upload_no_file_selected');
			return FALSE;
		}

		
		// Was the file able to be uploaded? If not, determine the reason why.
		if ($this->error_check($field) != 0) return FALSE;

		/*
		 * Move the file to the final destination
		 * To deal with different server configurations
		 * we'll attempt to use copy() first.  If that fails
		 * we'll use move_uploaded_file().  One of the two should
		 * reliably work in most environments
		 */
		if (!@copy($_FILES[$field]['tmp_name'], $dest. DIR_DELIM . $fileName)) {
			if (!@move_uploaded_file($_FILES[$field]['tmp_name'], $dest. DIR_DELIM . $fileName)) {
				$this->set_error('upload_destination_error');
				return FALSE;
			}
		}
		return TRUE;
	}
	
	public function selected($field) {
		if (isset($_FILES[$field])) return TRUE;
		return FALSE;
	}

	
	// --------------------------------------------------------------------

	/**
	 * Set an error message
	 *
	 * @param	string
	 * @return	void
	 */
	public function set_error($msg) {
		$CI =& get_instance();
		$CI->lang->load('upload');

		if (is_array($msg)) {
			foreach ($msg as $val) {
				$msg = ($CI->lang->line($val) == FALSE) ? $val : $CI->lang->line($val);
				$this->error_msg[] = $msg;
				log_message('error', $msg);
			}
		}else {
			$msg = ($CI->lang->line($msg) == FALSE) ? $msg : $CI->lang->line($msg);
			$this->error_msg[] = $msg;
			log_message('error', $msg);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Display the error message
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function display_errors($open = '<p>', $close = '</p>') {
		$str = '';
		foreach ($this->error_msg as $val)
		{
			$str .= $open.$val.$close;
		}

		return $str;
	}
	// --------------------------------------------------------------------

}
// END Upload Class

/* End of file Upload.php */
/* Location: ./system/libraries/Upload.php */