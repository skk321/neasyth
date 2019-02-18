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
class AT_Model extends CI_Model
{
	public $table_name = '';
	public $redis_key  = '';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Insert data
	 *
	 * @access	public
	 * @param	array
	 * @param	bool
	 * @return	int
	 */
	public function insert($obj = array(), $got_id = TRUE)
	{
		if (count($obj) > 0)
		{
			$result = $this->db->insert($this->table_name, $obj);
			if ($got_id == TRUE)
			{
				$result = $this->db->insert_id();
			}
			return $result;
		}
		return FALSE;
	}

	/**
	 * Update data
	 *
	 * @access	public
	 * @param	array
	 * @param	mixed
	 * @param	string
	 * @param	bool
	 * @return	int
	 */
	public function update($obj = array(), $mixed, $field = 'Id', $is_int = TRUE)
	{
		if (count($obj) <= 0 ||
			($is_int == TRUE && intval($mixed) <= 0) ||
			($is_int == FALSE && strlen($mixed) == 0))
		{
			return FALSE;
		}

		if ($is_int == TRUE)
		{
			$this->db->where($field, intval($mixed));
		}
		else
		{
			$this->db->where($field, $mixed);
		}
		return $this->db->update($this->table_name, $obj);
	}

	/**
	 * Bulk update data
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	string
	 * @param	array
	 * @return	int
	 */
	public function bulk_update($idlist = '', $obj = array(), $field = 'Id', $where = array())
	{
		$data = explode(',', $idlist);

		if (strlen($idlist) > 0 && count($obj) > 0)
		{
			$this->db->where($where);
			$this->db->where_in($field, $data);
			return $this->db->update($this->table_name, $obj);
		}
		return FALSE;
	}

	/**
	 * Delete data
	 *
	 * @access	public
	 * @param	array
	 * @return	int
	 */
	public function delete($obj = array())
	{
		if (count($obj) > 0)
		{
			return $this->db->delete($this->table_name, $obj);
		}
		return FALSE;
	}

	/**
	 * Bulk delete data
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	int
	 */
	public function bulk_delete($idlist = '', $field = 'Id', $where = array())
	{
		$data = explode(',', $idlist);

		if (strlen($idlist) > 0)
		{
			$this->db->where_in($field, $data);
			if (count($where) > 0)
			{
				$this->db->where($where);
			}
			return $this->db->delete($this->table_name);
		}
		return FALSE;
	}

	/**
	 * Truncate table
	 *
	 * @access	public
	 * @return	int
	 */
	public function truncate()
	{
		return $this->db->truncate($this->table_name);
	}

	/**
	 * Get single data
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @param	bool
	 * @return	array
	 */
	public function get_single($mixed, $field = 'Id', $is_int = TRUE)
	{
		$this->db->select('*');
		if ($is_int == TRUE)
		{
			$this->db->where($field, intval($mixed));
		}
		else
		{
			$this->db->where($field, $mixed);
		}
		$this->db->order_by("`{$field}` DESC");

		return $this->db->get($this->table_name, 1);
	}

	/**
	 * Get first record
	 *
	 * @access	public
	 * @return	array
	 */
	public function get_first_record($orderby = 'Id ASC')
	{
		$this->db->select('*');
		$this->db->order_by($orderby);

		return $this->db->get($this->table_name, 1);
	}

	/**
	 * Get field
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function get_field($value = '', $field = '', $select_field = 'Id')
	{
		$result = FALSE;

		$this->db->select($select_field);
		$this->db->from($this->table_name);
		$this->db->where($field, $value);
		$this->db->limit(1);

		$query = $this->db->get();
		if ($query->num_rows() == 1)
		{
			$result = $query->row()->{$select_field};
		}
		unset($query);
		return $result;
	}

	/**
	 * Gets the maximum value of the specified field
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @return	array
	 */
	public function select_max($field, $where = array())
	{
		$this->db->select_max($field, "`{$field}`");
		if (count($where) > 0)
		{
			$this->db->where($where);
		}
		return $this->db->get($this->table_name);
	}

	/**
	 * Gets the minimum value of the specified field
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @return	array
	 */
	public function select_min($field, $where = array())
	{
		$this->db->select_min($field, "`{$field}`");
		if (count($where) > 0)
		{
			$this->db->where($where);
		}
		return $this->db->get($this->table_name);
	}

	/**
	 * Specifies whether the conditions exist
	 *
	 * @access	public
	 * @param	array
	 * @param	mixed
	 * @param	string
	 * @return	bool
	 */
	public function is_exists($where = array(), $mixed, $field = 'Id')
	{
		$this->db->select($field);
		$this->db->where($where);
		$this->db->order_by('Id', 'DESC');
		$query = $this->db->get($this->table_name, 1);

		if ($query->num_rows() == 0 ||
			$mixed == $query->row()->$field)
		{
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Get cache data
	 *
	 * @access	public
	 * @param	string
	 * @param	bool
	 * @param	mixed
	 * @param	array
	 * @return	bool
	 */
	public function get_cache($key, $is_hash = FALSE, $field = NULL, $args = NULL)
	{
		$this->load->library('AT_Redis');
		$redis_key = $this->redis_key . $key;
		$result    = FALSE;

		if ($this->at_redis == NULL)
		{
			return $result;
		}

		if (!$this->at_redis->exists($redis_key) && $args != NULL)
		{
			$element = $this->got_cache_element($args);
			if (is_array($element) && count($element) <= 0)
			{
				return $result;
			}
			$this->set_cache($key, $this->got_cache_element($args));
		}

		if ($is_hash)
		{
			if (isset($field) && strlen($field) > 0)
			{
				$result = $this->at_redis->hget($redis_key, $field);

			}
			else
			{
				$result = $this->at_redis->hgetall($redis_key);
			}
		}
		else
		{
			$result = $this->at_redis->get($redis_key);
		}
		return $result;
	}

	/**
	 * Set cache data
	 *
	 * @access	public
	 * @param	string
	 * @param	mixed
	 * @return	bool
	 */
	public function set_cache($key, $field)
	{
		$this->load->library('AT_Redis');
		$redis_key = $this->redis_key . $key;
		$result    = FALSE;
		if (is_array($field))
		{
			if (count($field) > 0)
			{
				$result = $this->at_redis->hmset($redis_key, $field);
			}
		}
		else
		{
			$result = $this->at_redis->set($redis_key, $field);
		}
		return $result;
	}
}
/* End of file AT_Model.php */
/* Location: ./applications/agent/core/AT_Model.php */