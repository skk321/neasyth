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
 * Config Libraries
 *
 * @package		Neasyth
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Chen
 */
class AT_Config
{
	/**
	 * Private property
	 */
	private $org_name = '';
	private $time_zone = '';
	private $date_format = '';
	private $time_format = '';
	private $language = '';

	private $CI = NULL;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->library('AT_Redis');

		$userdata = $this->CI->session->all_userdata();

		/// 判断Session值存在否
		if (!isset($userdata) || count($userdata) < 11)
		{
			$this->CI->load->model('common/settings_model');

			$items = array(
					'org_name' => '', 
					'time_zone' => 'Asia/Brunei', 
					'date_format' => 'Y-m-d', 
					'time_format' => 'H:i:s', 
					'language' => 'chinese'
				);

			/// General settings
			$query = $this->CI->settings_model->get_first_record(0);
			if ($query->num_rows() > 0)
			{
				$gotdata = $query->row();

				/// 判断如果Language为空，则返回系统配置的Language
				if (strlen($gotdata->Language) == 0)
				{
					$gotdata->Language = $this->CI->config->item('language');
				}

				$items['org_name'] = $gotdata->org_name;
				$items['time_zone'] = $gotdata->time_zone;
				$items['date_format'] = $gotdata->date_format;
				$items['time_format'] = $gotdata->time_format;
				$items['language'] = $gotdata->language;
				unset($gotdata);
			}
			unset($query);

			/// 更新Session数据
			$this->CI->session->set_userdata($items);
			$userdata = $items;
			unset($items);
		}

		foreach ($userdata as $key => $value)
		{
			if (is_array($value))
			{
				$this->{$key} = $value;
			}
			else
			{
				$this->{$key} = strval($value);
			}
		}
		unset($userdata);
	}

	/**
	 * __get()
	 *
	 * @access	public
	 * @return	string
	 */
	public function __get($property_name)
	{
		if (isset($this->$property_name))
		{
			// 判断如果Language为空，则返回系统配置的Language
			if (strlen($this->Language) == 0)
			{
				$this->language = $this->CI->config->item('language');
			}
			return $this->$property_name;
		}
		else
		{
			return NULL;
		}
	}
}
/* End of file AT_Config.php */
/* Location: ./applications/agent/libraries/AT_Config.php */