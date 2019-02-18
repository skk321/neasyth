<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Login extends CI_Controller {

	private $cookie_name = 'butler_username';

	private $page_path = 'login';

	/**
	 * Default login Page
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->load->helper(array('url', 'cookie', 'form'));
		$this->load->library(array('Session', 'AT_Config', 'AT_Integrate'));

		$keep_login = FALSE;
		$username = get_cookie($this->cookie_name);
		if (isset($username) && strlen($username) > 0)
		{
			$keep_login = TRUE;
		}

		$this->session->sess_destroy();

		// Common data
		$data['keep_login'] = $keep_login;
		$data['auth_code'] = $this->_get_auth_code();

		$this->load->view($this->page_path, $data);
	}

	/**
	 * Login reco
	 *
	 * @access public
	 * @return void
	 */
	public function login_reco()
	{
		$this->load->database();
		$this->load->helper(array('url', 'cookie'));
		$this->load->library(
				array('Session', 'AT_Config', 'AT_Integrate', 'AT_Users', 'AT_EventLog', 'Form_validation')
			);

		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$keep_login = $this->input->post('keep_login');
		$safe_factor = $this->input->post('safe_factor');
		$safe_code = $this->input->post('safe_code');

		// Validation content of the form
		$this->form_validation->set_rules('username', '', 'required|trim');
		$this->form_validation->set_rules('password', '', 'required|trim');

		if ($this->form_validation->run() === FALSE)
		{
			exit('{"code": 1, "msg": "抱歉，账户或密码不能为空"}');
		}

		$password = base64_decode($password);
		$auth_code = $this->_get_auth_code();

		if (get_md5($safe_factor) != $safe_code || 
			$auth_code < $safe_factor || $auth_code - $safe_factor > 28800)
		{
			exit('{"code": 1, "msg": "抱歉，账户授权失败"}');
		}

		if ($this->at_users->validate_user($username, $password) == FALSE)
		{
			//** AT-OPERATIONLOG **/
			$this->at_eventlog->write(AT_EVENT_LOG_WARNING, "{$username} 尝试登录失败");

			exit('{"code": 1, "msg": "抱歉，账户或密码错误"}');
		}

		if (intval($keep_login) == 1)
		{
			// Keep me signed in
			set_cookie($this->cookie_name, $username, 3600 * 30);
		}
		else
		{
			delete_cookie($this->cookie_name);
		}

		//** AT-OPERATIONLOG **/
		$this->at_eventlog->write(AT_EVENT_LOG_MESSAGE, '登录成功');

		exit('{"code": 0, "msg": "登录成功!"}');
	}

	/**
	 * Get auth code
	 *
	 * @access	private
	 * @return	void
	 */
	private function _get_auth_code()
	{
		return time() + 31415926 + date('mdH');
	}
}
