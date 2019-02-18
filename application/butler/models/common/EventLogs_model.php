<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Neasyth Butler
 *
 * You can't just ask customers what they want and then try to give that to them. 
 * By the time you get it built, they'll want something new.
 *
 * @package		Neasyth
 * @author		1508 Dev Team
 * @copyright	Copyright (c) 2012-2099, Neasyth and other contributors
 * @link		http://neasyth.cn/
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Neasyth Eventlogs Model
 *
 * @package		Neasyth
 * @subpackage	Models
 * @category	Models
 * @author		Chen
 */
class Eventlogs_Model extends AT_Model
{
	var $table_name = 'eventlogs';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}
}
/* End of file eventlogs_model.php */
/* Location: ./applications/butler/models/common/eventlogs_model.php */