<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Neasyth Butler
 *
 * You can't just ask customers what they want and then try to give that to them. 
 * By the time you get it built, they'll want something new.
 *
 * @package		Neasyth
 * @author		Chen
 * @copyright	Copyright (c) 2012-2099, neasyth and other contributors
 * @link		http://neasyth.cn/
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Controller Class
 *
 * @package		Neasyth
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Chen
 */
class AT_Controller extends CI_Controller
{
	// Default language pack
	var $lang_common = NULL;

	/**
	 * Default constructor
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// set_error_handler('error_handler');
		set_time_limit(0);

		// Loading model
		$this->load->database();

		$this->load->helper('url');

		// Loaded class library
		$this->load->library(array('Session', 'AT_Config', 'AT_Integrate', 'AT_EventLog', 'AT_Users'));

		if ($this->at_users->logined == FALSE || $this->at_users->user_id == 0)
		{
			// Not login or log on overtime
			redirect('login');
		}
		else
		{
			if (strlen($this->at_config->time_zone) > 0)
			{
				// Set the date of the default time zone
				date_default_timezone_set($this->at_config->time_zone);
			}
		}
	}
}
/* End of file AT_Controller.php */
/* Location: ./applications/butler/core/AT_Controller.php */
