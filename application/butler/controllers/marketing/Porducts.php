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
 * Products Controller
 *
 * @package		Neasyth
 * @subpackage	Controller
 * @category	Controller
 * @author		Chen
 */
class Products extends AT_Controller {

	/**
	 * Default login Page
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$data['title'] = '产品管理';

		$this->load->view($this->page_path, $data);
	}
}
