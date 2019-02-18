<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Neasyth
 *
 * You can't just ask customers what they want and then try to give that to them. 
 * By the time you get it built, they'll want something new.
 *
 * @package		Neasyth
 * @author		Chen
 * @copyright	Copyright (c) 2019-2099, neasyth and other contributors
 * @link		http://neasyth.cn/
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * AT_Integrate Libraries
 *
 * @package		Neasyth
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Chen
 */
class AT_Integrate
{
	/**
	 * Fomat date
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function format_date($datetime)
	{
		$CI =& get_instance();
		$format = $CI->at_config->date_format;

		$timestamp = $datetime;
		if (!is_numeric($timestamp))
		{
			$timestamp = strtotime($timestamp);
		}
		if (intval($timestamp) <= 0)
		{
			return;
		}
		return date($format, $timestamp);
	}

	/**
	 * Format time
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function format_time($datetime)
	{
		$CI =& get_instance();
		$format = $CI->at_config->time_format;
		
		$timestamp = $datetime;
		if (!is_numeric($timestamp))
		{
			$timestamp = strtotime($timestamp);
		}
		if (intval($timestamp) <= 0)
		{
			return;
		}
		return date($format, $timestamp);
	}

	/**
	 * Format datetime
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function format_datetime($datetime)
	{
		$CI =& get_instance();
		date_default_timezone_set($CI->at_config->time_zone);
		$format = $CI->at_config->date_format . ' ' . $CI->at_config->time_format;
		
		$timestamp = $datetime;
		if (!is_numeric($timestamp))
		{
			$timestamp = strtotime($timestamp);
		}
		if (intval($timestamp) <= 0)
		{
			return;
		}
		return date($format, $timestamp);
	}

	/**
	 * Get Lang Array
	 *
	 * Fetches a language Array
	 *
	 * @access	public
	 * @param	string	the language filename. Can be an array
	 * @param	string	the language
	 * @return	string
	 */
	public function get_lang($filename = '', $idiom = '')
	{
		$CI =& get_instance();
		if (strlen($idiom) == 0)
		{
			$idiom = $CI->at_config->language;
		}
		$CI->lang->load($filename, $idiom);
		return $CI->lang->language;
	}
}
/* End of file AT_Integrate.php */
/* Location: ./applications/butler/libraries/AT_Integrate.php */