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
 * EventLog Libraries
 *
 * @package		Neasyth
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Chen
 */
class AT_EventLog
{
	var $CI = NULL;
	var $operator = '';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		//$this->operator = 'System';
	}

	/**
	 * __get()
	 */
	public function __get($property_name)
	{
		if (isset($this->$property_name))
		{
			return $this->$property_name;
		}
		else
		{
			return NULL;
		}
	}

	/**
	 * Write Event Log
	 *
	 * @access	public
	 * @param	string Category
	 * @param	string Event Description
	 * @param	string Operator
	 * @return	string	
	 */
	public function write($category, $description, $operator = 'System')
	{
		$CI =& get_instance();

		$CI->load->database();
		$CI->load->model('common/eventlogs_model');

		if (strlen($this->operator) > 0)
		{
			$operator = $this->operator;
		}

		$obj = array(
				'uuid' => create_uuid(),
				'operator' => $operator,
				'assort' => intval($category), 
				'content' => $description, 
				'created_at' => date('Y-m-d H:i:s'), 
				'ip' => get_ip()
			);

		// Save data
		$CI->eventlogs_model->insert($obj);
		unset($obj);
	}
}
/* End of file AT_EventLog.php */
/* Location: ./applications/butler/libraries/AT_EventLog.php */