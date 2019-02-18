<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SmartCall Agent
 *
 * You can't just ask customers what they want and then try to give that to them. 
 * By the time you get it built, they'll want something new.
 *
 * @package		SmartCall
 * @author		1508 Dev Team
 * @copyright	Copyright (c) 2012-2099, SmartCloud.im and other contributors
 * @license		http://smartcloud.im/smartcall/license.html
 * @link		http://smartcloud.im/
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

require_once FCPATH . '/modules/predis/autoload.php';

/**
 * Redis Libraries
 *
 * @package		SmartCall
 * @subpackage	Libraries
 * @category	Libraries
 * @author		1508 Dev Team
 */
class AT_Redis
{
	private $_ci;
	private $_redis;

	/**
	 * Constructor
	 */
	public function __construct($params = array())
	{
		$this->_ci = get_instance();
		$this->_ci->load->config('redis');

		// Check for the different styles of configs
		if (is_array($this->_ci->config->item('default')))
		{
			// Default connection group
			$config = $this->_ci->config->item('default');
		}
		else
		{
			// Original config style
			$config = array(
				'scheme' => $this->_ci->config->item('scheme'),
				'host' => $this->_ci->config->item('host'),
				'port' => $this->_ci->config->item('port'),
				'password' => $this->_ci->config->item('password'),
				'select' => $this->_ci->config->item('select')
			);
		}

		try {
			$this->_redis = new Predis\Client($config);

			// Authenticate when needed
			$this->_redis->auth($config['password']);
			$this->_redis->select($config['select']);
		} catch (Exception $e) {
			$this->_redis = NULL;
		}
	}

	/**
	 * Exe
	 *
	 * @return	redis object
	 */
	public function exe()
	{
		return $this->_redis;
	}

	/**
	 * Set
	 *
	 * @param	string	Cache key identifier
	 * @param	string
	 * @param   int
	 * @return	mixed
	 */
	public function set($key, $field, $ex_time = 0)
	{
		if (!$this->_redis) return FALSE;
		$ex_time = (int)$ex_time;
		
		if ($ex_time > 0)
		{
			return $this->_redis->setex($key, $ex_time, $field);
		}
		else
		{
			return $this->_redis->set($key, $field);
		}
	}

	/**
	 * Get
	 *
	 * @param	string	Cache key identifier
	 * @return	mixed
	 */
	public function get($key)
	{
		if (!$this->_redis) return FALSE;
		return $this->_redis->get($key);
	}

	/**
	 * Get_ex
	 *
	 * @param	string	Cache key identifier
	 * @return	mixed
	 */
	public function get_ex($key, $field)
	{
		if (!$this->_redis) return FALSE;
		if (!$this->_redis->exists($key))
		{
			$this->set($key, $field);
		}
		return $this->get($key);
	}

	/**
	 * Get
	 *
	 * @param	string	Cache key identifier
	 * @return	mixed
	 */
	public function hgetall($key)
	{
		if (!$this->_redis) return FALSE;
		return $this->_redis->hgetall($key);
	}

	/**
	 * HGet
	 *
	 * @param	string	Cache key identifier
	 * @param	string
	 * @return	mixed
	 */
	public function hget($key, $field)
	{
		if (!$this->_redis) return FALSE;
		return $this->_redis->hget($key, $field);
	}

	/**
	 * HDel
	 *
	 * @param	string	Cache key identifier
	 * @param	string
	 * @return	mixed
	 */
	public function hdel($key, $field)
	{
		if (!$this->_redis) return FALSE;
		return $this->_redis->hdel($key, $field);
	}

	/**
	 * Exists
	 *
	 * @param	string	Cache key identifier
	 * @return	mixed
	 */
	public function exists($key)
	{
		if (!$this->_redis) return FALSE;
		return $this->_redis->exists($key);
	}

	/**
	 * HMSet
	 *
	 * @param	string	Cache key identifier
	 * @param	array
	 * @return	mixed
	 */
	public function hmset($key, $array)
	{
		if (!$this->_redis) return FALSE;
		return $this->_redis->hmset($key, $array);
	}

	/**
	 * SAdd
	 *
	 * @param	string
	 * @param	string
	 * @return	mixed
	 */
	public function sadd($key, $member)
	{
		if (!$this->_redis) return FALSE;
		return $this->_redis->sadd($key, $member);
	}

	/**
	 * SRem
	 *
	 * @param	string
	 * @param	string
	 * @return	mixed
	 */
	public function srem($key, $member)
	{
		return $this->_redis->srem($key, $member);
	}

	/**
	 * Del
	 *
	 * @param	string
	 * @param	string
	 * @return	mixed
	 */
	public function del($key)
	{
		if (!$this->_redis) return FALSE;
		return $this->_redis->del($key);
	}

	/**
	 * Keys
	 *
	 * @param	string
	 * @param	string
	 * @return	mixed
	 */
	public function keys($key)
	{
		return $this->_redis->keys($key);
	}

	/**
	 * Publish
	 *
	 * @param	string
	 * @param	string
	 * @return	mixed
	 */
	public function publish($channel, $message)
	{
		if (!$this->_redis) return FALSE;
		return $this->_redis->publish($channel, $message);
	}
}
/* End of file AT_Redis.php */
/* Location: ./applications/agent/libraries/AT_Redis.php */