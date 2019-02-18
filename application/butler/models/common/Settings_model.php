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
 * Settings Model
 *
 * @package		Neasyth
 * @subpackage	Models
 * @category	Models
 * @author		Chen
 */
class Settings_Model extends AT_Model
{
	var $table_name = 'sys_settings';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get first record
	 *
	 * @access	public
	 * @param	int
	 * @return	array
	 */
	public function get_first_record($retain = 0)
	{
		if (!is_numeric($retain)) $retain = 0;

		$this->db->select('*');
		$this->db->where('retain', $retain);
		$this->db->order_by('id', 'ASC');

		return $this->db->get($this->table_name, 1);
	}
}
/* End of file settings_model.php */
/* Location: ./applications/agent/models/common/settings_model.php */