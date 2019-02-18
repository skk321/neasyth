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
 * Users Model
 *
 * @package		Neasyth
 * @subpackage	Models
 * @category	Models
 * @author		Chen
 */
class Users_Model extends AT_Model
{
	var $table_name = 'users';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get data list
	 *
	 * @access	public
	 * @param	array
	 * @param	int
	 * @param	int
	 * @return	array
	 */
	public function get($params = array(), $limit = NULL, $offset = NULL)
	{
		$this->db->select('u.*');
		
		$this->_where($params);
		$this->db->order_by('u.username ASC, u.id ASC');

		if (isset($limit) || isset($offset))
		{
			$this->db->limit($limit, $offset);
		}
		$query = $this->db->get();

		return $query->result();
	}

	/**
	 * Total data
	 *
	 * @access	public
	 * @param	array
	 * @return	int
	 */
	public function total($params = array())
	{
		$this->_where($params);

		return $this->db->count_all_results();
	}

	/**
	 * Search conditions
	 *
	 * @access	private
	 * @param	array
	 * @return	void
	 */
	private function _where($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				$this->$key = $val;
			}
		}

		$this->db->from("{$this->table_name} AS u");
		$this->db->where('u.enabled', TRUE);
	}
}
/* End of file users_model.php */
/* Location: ./applications/butler/models/accounts/users_model.php */