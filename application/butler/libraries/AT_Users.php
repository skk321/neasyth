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
 * AT_Users Libraries
 *
 * @package		Neasyth
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Chen
 */
class AT_Users
{
	/**
	 * Private property
	 */
	private $user_id          = 0;
	private $uuid             = '';
	private $username         = '';
	private $password         = '';
	private $truename         = '';
	private $fullname         = '';
	private $avatar           = '';
	private $Signature		  = '';
	private $is_super         = FALSE;
	private $logined          = FALSE;

	private $CI = NULL;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->CI = &get_instance();

		// Init user data
		$this->init_userdata();
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
	 * Init user data
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function init_userdata()
	{
		$this->CI->load->library('AT_Redis');

		$userdata = $this->CI->session->all_userdata();

		if (isset($userdata) && isset($userdata['user_id']))
		{
			$this->user_id         = intval($userdata['user_id']);
			$this->uuid           = strval($userdata['uuid']);
			$this->username       = strval($userdata['username']);
			$this->password       = strval($userdata['password']);
			$this->truename       = strval($userdata['truename']);
			$this->signature      = strval($userdata['signature']);
			$this->avatar         = get_photo($this->uuid, 40);
			$this->is_uper        = intval($userdata['is_uper']);
			$this->logined        = intval($userdata['logined']);

			if (strlen($this->signature) == 0)
			{
				$this->signature = '未填写个人签名';
			}

			$this->fullName         = get_fullname($this->username, $this->truename);
		}
	}

	/**
	 * validate user
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @param	bool
	 * @return	bool
	 */
	public function validate_user($username, $password)
	{
		$this->CI->load->database();
		$this->CI->load->model('accounts/users_model');
		$this->CI->load->library(array('AT_Redis'));

		if (strlen($username) == 0 || strlen($password) == 0)
		{
			return FALSE;
		}

		// Get a single data
		$query = $this->CI->users_model->get_single($username, 'username', FALSE);
		if ($query->num_rows() == 1)
		{
			$data = $query->row();

			if ($data->enabled == TRUE && ($data->password == get_md5($password)))
			{
				$this->user_id          = $data->id;
				$this->uuid             = $data->uuid;
				$this->username         = $data->username;
				$this->password         = $data->password;
				$this->truename         = $data->truename;
				$this->fullname         = get_fullname($data->username, $data->truename);
				$this->signature        = $data->signature;
				$this->is_super         = $data->is_super;

				// Update user attached data
				$item = array(
					'last_login_time' => date('Y-m-d H:i:s'),
					'last_login_ip'   => get_ip()
				);
				$this->CI->users_model->update($item, $this->user_id);
				unset($item);

				return TRUE;
			}
		}
		return FALSE;
	}
}
/* End of file AT_Users.php */
/* Location: ./applications/butler/libraries/AT_Users.php */