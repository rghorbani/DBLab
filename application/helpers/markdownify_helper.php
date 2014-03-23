<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Codeigniter HTMLPurifier Helper
 *
 * Purify input using the HTMLPurifier standalone class.
 * Easily use multiple purifier configurations.
 *
 * @author     Tyler Brownell <tyler@bluefoxstudio.ca>
 * @copyright  Public Domain
 * @license    http://bluefoxstudio.ca/release.html
 *
 * @access  public
 * @param   string or array
 * @param   string
 * @return  string or array
 */
if (! function_exists('markdownify'))
{
	function markdownify($input)
	{
		require_once APPPATH . 'third_party/markdownify/markdownify.php';
		$md = new Markdownify;
		return $md->parseString($input);
	}
}

/* End of htmlpurifier_helper.php */
/* Location: ./application/helpers/htmlpurifier_helper.php */