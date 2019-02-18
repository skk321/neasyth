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

/**
 * Common Helper
 *
 * @package		SmartCall
 * @subpackage	Helper
 * @category	Helper
 * @author		1508 Dev Team
 */

// ------------------------------------------------------------------------


/**
 * 比较两个时间差
 *
 * @access	public
 * @param	int			DatePart
 * @param	datetime	开始时间
 * @param	datetime	结束时间
 * @return	int
 */
if (!function_exists('date_difference'))
{
	function date_difference($datepart = AT_DATEPART_DAY, $startdate, $enddate = '')
	{
		$format = 'Y-m-d H:i:s';
		$userbase = 1;

		if (strlen($enddate) == 0)
		{
			$enddate = date($format);
		}
		switch ($datepart)
		{
			case AT_DATEPART_YEAR:
				return date('Y', strtotime($enddate)) - date('Y', strtotime($startdate));

			case AT_DATEPART_MONTH:
				$year_diff = date('Y', strtotime($enddate)) - date('Y', strtotime($startdate));
				$month_diff = date('m', strtotime($enddate)) - date('m', strtotime($startdate));
				return $year_diff * 12 + $month_diff;

			case AT_DATEPART_DAY:
				$format = 'Y-m-d';
				$userbase = 86400;
				break;

			case AT_DATEPART_HOUR:
				$format = 'Y-m-d H:00:00';
				$userbase = 3600;
				break;

			case AT_DATEPART_MINUTE:
				$format = 'Y-m-d H:i:00';
				$userbase = 60;
				break;

			default:
				break;
		}

		$start_stamp = strtotime(date($format, strtotime($startdate)));
		$end_stamp = strtotime(date($format, strtotime($enddate)));
		$datediff = $end_stamp - $start_stamp;

		return ceil($datediff / $userbase);
	}
}

/**
 * 格式化时间
 *
 * @access	public
 * @param	string	时间串
 * @param	string	预定义格式
 * @param	array	语言包
 * @return	string
 */
if (!function_exists('format_date'))
{
	function format_date($datetime, $format = 'Y-m-d', $lang = NULL)
	{
		if ($format == '#' || $format == '*')
		{
			if ($datetime)
			{
				if ($format == '#')
				{
					if (date_difference(AT_DATEPART_MINUTE, $datetime) < 3)
					{
						return '刚刚';
					}
					else if (date_difference(AT_DATEPART_MINUTE, $datetime) < 60)
					{
						return date_difference(AT_DATEPART_MINUTE, $datetime) . '分钟前';
					}
					else if (date_difference(AT_DATEPART_HOUR, $datetime) < 24)
					{
						return date_difference(AT_DATEPART_HOUR, $datetime) . '小时前';
					}
					else if (date_difference(AT_DATEPART_DAY, $datetime) == 1)
					{
						return '昨天';
					}
					else if (date_difference(AT_DATEPART_MONTH, $datetime) == 0)
					{
						return date('n月j日', strtotime($datetime));
					}
					else
					{
						return date('Y年n月j日', strtotime($datetime));
					}
				}
				else
				{
					if (date_difference(AT_DATEPART_HOUR, $datetime) < 24)
					{
						return date('H:i', strtotime($datetime));
					}
					else if (date_difference(AT_DATEPART_MONTH, $datetime) == 0)
					{
						return date('n月j日 H:i', strtotime($datetime));
					}
					else
					{
						return date('Y年n月j日 H:i', strtotime($datetime));
					}
				}
			}
			else
			{
				return;	
			}
		}
		else
		{
			$timestamp = $datetime;
			if (!is_numeric($timestamp))
			{
				$timestamp = strtotime($timestamp);
			}
			if ($timestamp <= 0)
			{
				return;
			}
			return date($format, $timestamp);
		}
	}
}

/**
 * 获取特殊日期
 *
 * @access	public
 * @param	string	时间串
 * @param	string	时间类型
 * @param	string	预定义格式
 * @return	string
 */
if (!function_exists('get_special_date'))
{
	function get_special_date($date, $date_type = -1, $format = 'Y-m-d')
	{
		$week = date('w', strtotime($date));
		if ($week == 0) $week = 7;
		switch ($date_type)
		{
			/// first day
			case AT_DATE_FIRST_DAY:
				$date = date('Y-m', strtotime($date));
				return date($format, strtotime($date));
				break;

			/// last day
			case AT_DATE_LAST_DAY:
				$date = date('Y-m', strtotime($date));
				return date($format, strtotime("{$date} next month -1 days"));
				break;
			
			/// yesterday
			case AT_DATE_YESTERDAY:
				return date($format, strtotime("{$date} -1 days"));
				break;
			
			/// tomorrow
			case AT_DATE_TOMORROW:
				return date($format, strtotime("{$date} +1 days"));
				break;
			
			/// last month
			case AT_DATE_LAST_MONTH:
				return date($format, strtotime("{$date} last month"));
				break;
			
			/// next month
			case AT_DATE_NEXT_MONTH:
				return date($format, strtotime("{$date} next month"));
				break;

			/// monday
			case AT_DATE_MONDAY:
				$day = $week - 1;
				return date($format, strtotime("{$date} -{$day} days"));
				break;

			/// sunday
			case AT_DATE_SUNDAY:
				$day = 7 - $week;
				return date($format, strtotime("{$date} +{$day} days"));
				break;

			/// last week monday
			case AT_DATE_LAST_MONDAY:
				$day = $week - 1 + 7;
				return date($format, strtotime("{$date} -{$day} days"));
				break;

			/// last week sunday
			case AT_DATE_LAST_SUNDAY:
				$day = 7 - $week - 7;
				return date($format, strtotime("{$date} +{$day} days"));
				break;

			/// now
			default:
				return date($format, strtotime($date));
				break;
		}
	}
}

/**
 * 获取用户IP地址
 *
 * @access	public
 * @return	string
 */
if (!function_exists('get_ip'))
{
	function get_ip()
	{
		if (isset($_SERVER))
		{
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
				$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				foreach ($arr as $ip)
				{
					$ip = trim($ip);
					if ($ip != 'unknown')
					{
						$realip = $ip;
						break;
					}
				}
			}
			elseif (isset($_SERVER['HTTP_CLIENT_IP']))
			{
				$realip = $_SERVER['HTTP_CLIENT_IP'];
			}
			else
			{
				if (isset($_SERVER['REMOTE_ADDR']))
				{
					$realip = $_SERVER['REMOTE_ADDR'];
				}
				else
				{
					$realip = '127.0.0.1';
				}
			}
		}
		else
		{
			if (getenv('HTTP_X_FORWARDED_FOR'))
			{
				$realip = getenv('HTTP_X_FORWARDED_FOR');
			}
			elseif (getenv('HTTP_CLIENT_IP'))
			{
				$realip = getenv('HTTP_CLIENT_IP');
			}
			else
			{
				$realip = getenv('REMOTE_ADDR');
			}
		}
		preg_match('/[\d\.]{7,15}/', $realip, $onlineip);
		$realip = !empty($onlineip[0]) ? $onlineip[0] : '127.0.0.1';
		return $realip;
	}
}

/**
 * 获取服务器IP地址
 *
 * @access	public
 * @return	string
 */
if (!function_exists('get_server_ip'))
{
	function get_server_ip()
	{
		$server_ip = '';
		if (isset($_SERVER))
		{
			if ($_SERVER['SERVER_ADDR'])
			{
				$server_ip = $_SERVER['SERVER_ADDR'];
			}
			else
			{
				$server_ip = $_SERVER['LOCAL_ADDR'];
			}
		}
		else
		{
			$server_ip = getenv('SERVER_ADDR');
		}
		return $server_ip;
	}
}

/**
 * 验证浏览器版本
 *
 * @access	public
 * @return	int
 */
if (!function_exists('check_browser'))
{
	function check_browser()
	{
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$matches = array();

		if (preg_match('/MSIE/i', $user_agent, $matches))
		{
			return FALSE;
		}
		return TRUE;
	}
}

/**
 * 判断字符串是否为URL
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_url'))
{
	function is_url($str = '')
	{
		if (!isset($str))
		{
			return FALSE;
		}
		return preg_match('/^[a-zA-z]+:\/\/(\w+(-\w+)*)(\.(\w+(-\w+)*))*(\?\S*)?$/', $str);
	}
}

/**
 * 判断字符串是否为日期
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_date'))
{
	function is_date($str = '')
	{
		if (!isset($str))
		{
			return FALSE;
		}
		return preg_match('/^(([1-9][0-9]{3})-((0?2-(0?[1-9]|[12][0-9]))|(0?[469]|11)-(0?[1-9]|[12][0-9]|30)|(0?[13578]|1[02])-(0?[1-9]|[12][0-9]|3[01])))$/', $str);
	}
}

/**
 * 判断字符串是否包含中文
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_chinese'))
{
	function is_chinese($str = '')
	{
		if (!isset($str))
		{
			return FALSE;
		}
		return preg_match('/[\x80-\xff]./', $str);
	}
}

/**
 * 判断是否为手机号码
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_mobile'))
{
	function is_mobile($str = '')
	{
		if (!isset($str) || empty($str) || strlen($str) == 0)
		{
			return FALSE;
		}
		else
		{
			return preg_match("/^1[3-9]{1}[0-9]{9}$/", $str);
		}
	}
}

/**
 * 判断是否为外地手机号码
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_nonlocal_mobile'))
{
	function is_nonlocal_mobile($str = '')
	{
		if (!isset($str) || empty($str) || strlen($str) == 0)
		{
			return FALSE;
		}
		else
		{
			return preg_match("/^01[3-9]{1}[0-9]{9}$/", $str);
		}
	}
}

/**
 * 判断是否为电话号码
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_telephone'))
{
	function is_telephone($str = '')
	{
		if (!isset($str) || empty($str) || strlen($str) == 0)
		{
			return FALSE;
		}
		else
		{
			return preg_match("/^(0\d{2}-?\d{8}|0\d{3}-?\d{7}|0\d{3}-?\d{8}|400-?\d{3}-?\d{4}|0085[23]-?\d{8}|00886-?\d{8}|[1-9]{1}\d{4}|001-?\d{3}-?\d{7})$/", $str);
		}
	}
}

/**
 * 判断是否为本地电话号码
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_local_telephone'))
{
	function is_local_telephone($str = '')
	{
		if (!isset($str) || empty($str) || strlen($str) == 0)
		{
			return FALSE;
		}
		else
		{
			return preg_match("/^[2-9]{1}\d{6,7}$/", $str);
		}
	}
}

/**
 * 判断是否为电话或手机号码
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_phone'))
{
	function is_phone($str = '')
	{
		if (is_mobile($str) || is_telephone($str))
		{
			return TRUE;
		}
		return FALSE;
	}
}

/**
 * 判断是否为邮箱
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_email'))
{
	function is_email($str = '')
	{
		if (!isset($str) || empty($str) || strlen($str) == 0)
		{
			return FALSE;
		}
		else
		{
			return preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $str);
		}
	}
}

/**
 * 判断是否为号码缩写
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_abbr'))
{
	function is_abbr($str = '')
	{
		if (!isset($str) || empty($str) || strlen($str) == 0)
		{
			return FALSE;
		}
		else
		{
			return preg_match("/^\d{3,4}\*\d{4}$/", $str);
		}
	}
}

/**
 * 判断是否为客户编码
 *
 * @access	public
 * @param	string
 * @return	bool
 */
if (!function_exists('is_ucode'))
{
	function is_ucode($str = '')
	{
		if (!isset($str) || empty($str) || strlen($str) == 0)
		{
			return FALSE;
		}
		else
		{
			return preg_match("/^\d{7,}$/", $str);
		}
	}
}

/**
 * 跨域访问提交限制
 *
 * @access	public
 * @return	bool
 */
if (!function_exists('allow_acces'))
{
	function allow_acces()
	{
		if ($_POST)
		{
			if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === FALSE)
			{
				return FALSE;
			}
		}
		return TRUE;
	}
}

/**
 * 生成通用唯一标识符(UUID)
 *
 * @access	public
 * @return	string
 */
if (!function_exists('create_uuid'))
{
	function create_uuid()
	{
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand(0, 0xffff), mt_rand(0, 0xffff),
				mt_rand(0, 0xffff),
				mt_rand(0, 0x0fff) | 0x4000,
				mt_rand(0, 0x3fff) | 0x8000,
				mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
			);
	}
}

/**
 * 计算百分比
 *
 * @access	public
 * @param	float	除数
 * @param	float	被除数
 * @param	int		小数位
 * @return	float	百分比
 */
if (!function_exists('percentage'))
{
	function percentage($divisor, $dividend, $decimal = 2)
	{
		$result = 0;
		if ($divisor > 0 && $dividend > 0)
		{
			$result = $divisor / $dividend * 100;
		}
		return sprintf('%.' . $decimal . 'f%%', $result);
	}
}

/**
 * 格式化座席时间
 *
 * @access	public
 * @param	int
 * @return	string
 */
if (!function_exists('format_agentstime'))
{
	function format_agentstime($seconds = 0)
	{
		if (!is_numeric($seconds)) $seconds = 0;
		$seconds = intval($seconds);
		$hour = floor($seconds / 3600);
		$remain = $seconds % 3600;
		$minute = floor($remain / 60);
		$seconds = $seconds % 60;

		if ($hour < 0 || $minute < 0 || $seconds < 0)
		{
			return '--';
		}

		if ($hour < 10) $hour = '0' . $hour;
		if ($minute < 10) $minute = '0' . $minute;
		if ($seconds < 10) $seconds = '0' . $seconds;
		
		return "{$hour}:{$minute}:{$seconds}";
	}
}

/**
 * 格式化货币格式
 *
 * @access	public
 * @param	int
 * @param	int
 * @return	string
 */
if (!function_exists('format_currency'))
{
	function format_currency($money = 0, $decimal = 2)
	{
		//return sprintf('%.2f', $money);
		return number_format($money, $decimal);
	}
}

/**
 * 转换字节
 *
 * @access	public
 * @param	string
 * @return	string
 */
if (!function_exists('convert_bytes'))
{
	function convert_bytes($val)
	{
		$val = trim($val);
		$unit = strtolower($val{strlen($val) - 1});
		switch ($unit)
		{
			case 'g':
				$val *= 1024 * 1024 * 1024;
				break;
			case 'm':
				$val *= 1024 * 1024;
				break;
			case 'k':
				$val *= 1024;
				break;
		}
		return $val;
	}
}

/**
 * 将序列化字符串转为数组
 *
 * @access	public
 * @param	array	初始数组
 * @param	string	序列化的字符串
 * @return	array	数组
 */
if (!function_exists('str_to_array'))
{
	function str_to_array($obj = array(), $str)
	{
		if (strlen($str) > 0)
		{
			$query = explode('&', $str);
			foreach ($query as $rows)
			{
				$row = explode('=', $rows);
				if (count($row) == 2)
				{
					$obj[$row[0]] = urldecode($row[1]);
				}
			}
		}
		return $obj;
	}
}

/**
 * The serialized string into an array
 *
 * @access	public
 * @param	string
 * @return	string
 */
if (!function_exists('csv_to_array'))
{
	function csv_to_array($str, $delimiter)
	{
		$query = explode("\n", $str);
		$result = array();
		if (trim(strtoupper($str)) == '+OK' || 
			trim(strtoupper($query[0])) == '+OK')
		{
			return $result;
		}
		$columns = explode($delimiter, $query[0]);
		for ($x = 1; $x < count($query); $x++)
		{
			$items = explode($delimiter, $query[$x]);
			for ($y = 0; $y < count($items); $y++)
			{
				if (trim(strtoupper($items[$y])) != '+OK')
				{
					$result[$x][$columns[$y]] = $items[$y];
				}
			}
		}
		return $result;
	}
}

/**
 * 全角转半角
 *
 * @access	public
 * @param	string
 * @param	string
 * @return	string
 */
if (!function_exists('to_dbc'))
{
	function to_dbc($str, $encode = 'UTF8')
	{
		if ($encode != 'UTF8')
		{
			$str = mb_convert_encoding($str, 'UTF-8', $encode);
		}
		$result = '';
		for ($i=0; $i < strlen($str); $i++)
		{
			$s1 = $str[$i];
			if (($c = ord($s1)) & 0x80)
			{
				$s2 = $str[++$i];
				$s3 = $str[++$i];
				$c = (($c & 0xF) << 12) | ((ord($s2) & 0x3F) << 6) | (ord($s3) & 0x3F);
				if ($c == 12288)
				{
					$result .= ' ';
				}
				elseif ($c > 65280 && $c < 65375)
				{
					$c -= 65248;
					$result .= chr($c);
				}
				else
				{
					$result .= $s1 . $s2 . $s3;
				}
			}
			else
			{
				$result .= $str[$i];
			}
		}
		return ($encode == 'UTF8' ? $result : mb_convert_encoding($result, $encode, 'UTF-8'));
	}
}

/**
 * Text to html
 *
 * @access	public
 * @param	string
 * @return	string
 */
if (!function_exists('text_to_html'))
{
	function text_to_html($str)
	{
		$result = $str;
		if (strlen($result) > 0)
		{
			$result = str_replace(' ', '&nbsp;', $result);
			$result = str_replace("\n", '<br/>', $result);
		}
		return $result;
	}
}

/**
 * Html to text
 *
 * @access	public
 * @param	string
 * @return	string
 */
if (!function_exists('html_to_text'))
{
	function html_to_text($str)
	{
		$result = $str;
		if (strlen($result) > 0)
		{
			$result = str_replace('&nbsp;', ' ', $result);
			$result = preg_replace("@<(.*?)>@is", '', $result);
		}
		return $result;
	}
}

/**
 * array to string
 *
 * @access	public
 * @param	mixed
 * @return	string
 */
if (!function_exists('array_to_string'))
{
	function array_to_string($mixed = '')
	{
		$result = $mixed;
		if (is_array($result))
		{
			$result = implode(',', $result);
		}
		return strval($result);
	}
}

/**
 * 生成缩略图
 *
 * @access    public
 * @param     string
 * @param     string
 * @param     string
 * @param     int
 * @param     int
 * @return    string
 */
if (!function_exists('create_thumbnail'))
{
	function create_thumbnail($upload_path = NULL, $source, $destinat = NULL, $width = 0, $height = 0)
	{
		if (isset($upload_path))
		{
			$source = "{$upload_path}/{$source}";
		}

		if ($destinat)
		{
			if ($upload_path) $destinat = "{$upload_path}/{$destinat}";
		}
		else
		{
			$destinat = $source;
		}

		if ($height == 0) $height = $width;

		$source_info = getimagesize($source);
		switch ($source_info[2])
		{
			case 1:
				$im = imagecreatefromgif($source);
				break;
			case 2:
				$im = imagecreatefromjpeg($source);
				break;
			case 3:
				$im = imagecreatefrompng($source);
				break;
			case 6:
				$im = imagecreatefromwbmp($source);
				break;
			default:
				break;
		}

		$source_width = imagesx($im);
		$source_height = imagesy($im);

		if ($source_width <= $width && $source_height <= $height)
		{
			copy($source, $destinat);
			return TRUE;
		}

		if ($source_width <= $width && $source_height <= $height) return TRUE;
		$destinat_scale = $width / $height;
		$source_scale = $source_width / $source_height;

		if ($destinat_scale <= $source_scale)
		{
			$destinat_width = $width;
			$destinat_height = $destinat_width * ($source_height / $source_width);
		}
		else
		{
			$destinat_height = $height;
			$destinat_width = $destinat_height * ($source_width / $source_height);
		}

		if ($source_width > $width || $source_height > $height)
		{
			if (function_exists("imagecreateTRUEcolor"))
			{
				@$ni = imagecreateTRUEcolor($destinat_width, $destinat_height);
				imagesavealpha($ni, TRUE);
				$trans_color = imagecolorallocatealpha($ni, 0, 0, 0, 127);
				imagefill($ni, 0, 0, $trans_color);

				if ($ni)
				{
					imagecopyresampled($ni, $im, 0, 0, 0, 0, $destinat_width, $destinat_height, $source_width, $source_height);					
				}
				else
				{
					$ni = imagecreate($destinat_width, $destinat_height);
					imagecopyresized($ni, $im, 0, 0, 0, 0, $destinat_width, $destinat_height, $source_width, $source_height);
				}
			}
			else
			{
				$ni = imagecreate($destinat_width, $destinat_height);
				imagecopyresized($ni, $im, 0, 0, 0, 0, $destinat_width, $destinat_height, $source_width, $source_height);
			}
			switch ($source_info[2])
			{
				case 1:
					imagepng($ni, $destinat);
					break;
				case 2:
					imagejpeg($ni, $destinat, 85);
					break;
				case 3:
					imagepng($ni, $destinat);
					break;
				case 6:
					imagebmp($ni, $destinat);
					break;
				default:
					return FALSE;
			}
			imagedestroy($ni);
		}
		imagedestroy($im);
		return TRUE;
	}
}

/**
 * Json replace special character
 *
 * @access	public
 * @param	string
 * @param	bool
 * @return	string
 */
if (!function_exists('json_replace'))
{
	function json_replace($str = '', $retain = FALSE)
	{
		$result = $str;
		if ($retain)
		{
			$result = preg_replace('/\'/is', '’', $result);
		}
		else
		{
			$result = preg_replace('/\'/is', '', $result);
		}
		$result = preg_replace('/\n/is', '', $result);
		$result = preg_replace('/\r/is', '', $result);
		$result = preg_replace('/\t/is', '', $result);
		$result = trim($result);
		$result = addslashes($result);
		return $result;
	}
}

/**
 * Replace style info
 *
 * @access	public
 * @param	string
 * @return	string
 */
if (!function_exists('style_replace'))
{
	function style_replace($str = '')
	{
		$result = $str;
		$result = preg_replace('/ style="(.[^"]*)"/is', '', $result);
		$result = preg_replace('/ style=\'(.[^\']*)\'/is', '', $result);
		$result = preg_replace('/ class="(.[^"]*)"/is', '', $result);
		$result = preg_replace('/ class=\'(.[^\']*)\'/is', '', $result);
		$result = json_replace($result);
		return $result;
	}
}

/**
 * Get photo path
 *
 * @access	public
 * @param	string
 * @param	int
 * @param	bool
 * @return	void
 */
if (!function_exists('get_photo'))
{
	function get_photo($uuid, $size = -1, $cache = TRUE)
	{
		$suffix = '';
		$result = '';

		if (intval($size) > 0)
		{
			$suffix = "_{$size}";
		}

		if (strlen($uuid) > 0)
		{
			$result = "/upfiles/crm/avatar/{$uuid}{$suffix}.jpg";
		}

		if (strlen($uuid) == 0 || !file_exists(FCPATH . $result))
		{
			$result = "/themes/public/images/avatar_user{$suffix}.jpg";
		}
		else if ($cache == FALSE)
		{
			$result .= '?s=' . time();
		}
		return $result;
	}
}

/**
 * MD5加密
 *
 * @access    public
 * @param     string
 * @param     bool
 * @return    string
 */
if (!function_exists('get_md5'))
{
	function get_md5($str, $charlist = FALSE)
	{
		$result = md5("#s1;l5{$str}@.k3");
		if ($charlist == TRUE)
		{
			$result = substr($result, 8, -8);
		}
		return $result;
	}
}

/**
 * 获取Abbr
 *
 * @access    public
 * @param     string
 * @param     string
 * @param     bool
 * @return    string
 */
if (!function_exists('get_abbr'))
{
	function get_abbr($telephone, $prefix = '', $ubb_format = FALSE)
	{
		$result = $telephone;
		$length = 3;
		$telephone = str_replace('+86', '0', $telephone);
		if (is_nonlocal_mobile($telephone))
		{
			$telephone = str_replace('###0', '', "###{$telephone}");
		}

		if (is_phone($telephone) && strlen($result) >= 7)
		{
			if (strlen($prefix) > 0)
			{
				$length = strlen($prefix);
			}
			else if (strlen($telephone) >= 12)
			{
				$length = strlen($telephone) - 8;
			}

			if ($ubb_format)
			{
				$result = substr($telephone, 0, $length) . '[TEL]' . substr($telephone, $length, -4) . '[/TEL]' . substr($telephone, -4);
			}
			else
			{
				$result = substr($telephone, 0, $length) . '*' . substr($telephone, -4);
			}
		}
		return $result;
	}
}

/**
 * 格式化Abbr
 *
 * @access    public
 * @param     string
 * @return    string
 */
if (!function_exists('format_abbr'))
{
	function format_abbr($abbr)
	{
		return str_replace('*', '****', $abbr);
	}
}

/**
 * 获取RAN
 *
 * @access    public
 * @param     string
 * @param     string
 * @return    string
 */
if (!function_exists('get_ran'))
{
	function get_ran($telephone, $prefix = '')
	{
		$result = '';
		$length = 3;
		if (is_phone($telephone) && strlen($telephone) >= 7)
		{
			if (strlen($prefix) > 0)
			{
				$length = strlen($prefix);
			}
			else if (strlen($telephone) >= 12)
			{
				$length = strlen($telephone) - 8;
			}
			$result = substr($telephone, $length, strlen($telephone) - 4 - $length);
		}
		return $result;
	}
}

/**
 * 格式化电话号码
 *
 * @access    public
 * @param     string
 * @param     string
 * @return    string
 */
if (!function_exists('format_telephone'))
{
	function format_telephone($telephone, $prefix = '')
	{
		$result = $telephone;
		$length = 3;
		if (is_telephone($telephone) && strlen($telephone) >= 7)
		{
			if (strpos($telephone, '400') == 0 && strlen($telephone) == 10)
			{
				$result = substr($telephone, 0, 3) . '-' . substr($telephone, 3, 3) . '-' . substr($telephone, -4, 4);
			}
			elseif (strlen($telephone) == 13 && substr($telephone, 0, 3) == '001')
			{
				$result = substr($telephone, 0, 3) . '-' . substr($telephone, 3, 3) . '-' . substr($telephone, -7, 7);
			}
			else
			{
				if (strlen($prefix) > 0)
				{
					$length = strlen($prefix);
				}
				elseif (strlen($telephone) >= 12)
				{
					$length = strlen($telephone) - 8;
				}
				$result = substr($telephone, 0, $length) . '-' . substr($telephone, $length, strlen($telephone) - $length);
			}
		}
		return $result;
	}
}

/**
 * 匹配电话号码
 *
 * @access    public
 * @param     string
 * @param     string
 * @return    string
 */
if (!function_exists('match_phone'))
{
	function match_phone($phone = '', $landing_code = '')
	{
		if (is_nonlocal_mobile($phone))
		{
			$phone = str_replace('###0', '', "###{$phone}");
		}
		elseif (is_local_telephone($phone))
		{
			$phone = $landing_code . $phone;
		}
		return $phone;
	}
}

/**
 * 截取字符长度
 *
 * @access    public
 * @param     string
 * @param     int
 * @param     bool
 * @return    string
 */
if (!function_exists('substring'))
{
	function substring($string, $length, $append = FALSE) 
	{ 
		if (strlen($string) <= $length)
		{ 
			return $string;
		}

		$result = '';

		$i = 0;
		while ($i < $length)
		{ 
			$string_tmp = substr($string, $i, 1);
			if (ord($string_tmp) >= 224)
			{ 
				$string_tmp = substr($string, $i, 3);
				$i = $i + 3;
			} 
			else if (ord($string_tmp) >= 192)
			{ 
				$string_tmp = substr($string, $i, 2);
				$i = $i + 2;
			} 
			else
			{
				$i = $i + 1;
			}
			$string_last[] = $string_tmp;
		}

		$result = implode('', $string_last);

		if ($append && strlen($string) > $length)
		{ 
			$result .= '...';
		}
		return $result;
	}
}

/**
 * 空值替换
 *
 * @access    public
 * @param     string
 * @param     string
 * @return    string
 */
if (!function_exists('replace_empty'))
{
	function replace_empty($string = '', $replace = '--') 
	{ 
		$result = $replace;
		if (isset($string) && strlen($string) > 0)
		{
			$result = $string;
		}
		return $result;
	}
}

	/**
	 * Replace not exist data
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	string
	 * @return	array
	 */
if (!function_exists('replace_empty'))
{
	function replace_no_exist($string = '', $data = array(), $replace = '--')
	{
		$result = $replace;
		if (array_key_exists($string, $data) && isset($data[$string]) && strlen($data[$string]) > 0)
		{
			$result = $data[$string];
		}
		return $result;
	}	
}

/**
 * Get color value
 *
 * @access    public
 * @param     int
 * @param     array
 * @return    string
 */
if (!function_exists('get_color'))
{
	function get_color($value = 0, $colors = array()) 
	{ 
		$result = '';
		$count = count($colors);
		
		if ($count > 0)
		{
			$result = $colors[$value];
		}
		return $result;
	}
}

/**
 * Get enabled status string
 *
 * @access    public
 * @param     bool
 * @return    string
 */
if (!function_exists('get_enabled_str'))
{
	function get_enabled_str($enabled = FALSE)
	{
		$result = '';
		if ($enabled == FALSE)
		{
			$result = addslashes(' disabled="disabled"');
		}
		return $result;
	}
}

/**
 * Validate binary
 *
 * @access	public
 * @param	int
 * @param	int
 * @param	int
 * @return	bool
 */
if (!function_exists('validate_binary'))
{
	function validate_binary($limits, $bit, $val = 0)
	{
		$binary_list = array(1, 2, 4, 8, 16, 32);

		if ($val == -1 || $val == 2)
		{
			return $val;
		}
		if ($limits == -1 || $limits == -2)
		{
			return $limits * -1;
		}
		else if ($bit < 1 || $bit > count($binary_list))
		{
			return 0;
		}
		else if ($bit == count($binary_list))
		{
			return intval($limits == $binary_list[$bit]);
		}
		else
		{
			return intval(($limits % $binary_list[$bit]) >= $binary_list[$bit - 1]);
		}
	}
}

/**
 * Validate limit
 *
 * @access	public
 * @param	int
 * @param	int
 * @return	bool
 */
if (!function_exists('validate_limit'))
{
	function validate_limit($limits, $limit)
	{
		$binary_list = array(1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048, 4096, 8192, 16384, 32768, 65536, 131072, 262144, 524288, 1048576, 2097152, 4194304, 8388608);

		if (!in_array($limit, $binary_list))
		{
			return FALSE;
		}
		$bit = 1;
		foreach ($binary_list as $key => $value)
		{
			if ($value == $limit)
			{
				break;
			}
			$bit++;
		}
		if ($bit == count($binary_list))
		{
			return intval($limits == $binary_list[$bit]);
		}
		else
		{
			return intval(($limits % $binary_list[$bit]) >= $binary_list[$bit - 1]);
		}
	}
}

/**
 * Permission inheritance conversion
 *
 * @access	public
 * @param	int
 * @return	int
 */
if (!function_exists('inherit_limit'))
{
	function inherit_limit($limit = 0)
	{
		if ($limit == 1)
		{
			return 2;
		}
		return $limit;
	}
}

/**
 * String unique
 *
 * @access	public
 * @param	string
 * @return	string
 */
if (!function_exists('str_unique'))
{
	function str_unique($str = '')
	{
		$items = explode(',', $str);
		$data = array();
		foreach ($items as $i => $item)
		{
			if (in_array($item, $data))
			{
				unset($items[$i]);
			}
			else
			{
				$data[$i] = $item;
			}
		}
		return implode(',', $data);
	}
}

/**
 * Set error handler
 *
 * @access    public
 * @param     bool
 * @return    string
 */
if (!function_exists('error_handler'))
{
	function error_handler($errno, $errstr, $errfile, $errline, $context)
	{
		set_status_header(500);
		@ob_clean();
		ob_start();
		include(APPPATH . 'errors/error_default.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
		die();
	}
}

/**
 * Show unauthorized page
 *
 * @access    public
 * @return    void
 */
if (!function_exists('show_unauthorized'))
{
	function show_unauthorized()
	{
		@ob_clean();
		ob_start();
		include(APPPATH . 'errors/error_purview.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
		exit();
	}
}

/**
 * Filter home review
 *
 * @access    public
 * @param     string
 * @param     string
 * @param     bool
 * @return    string
 */
if (!function_exists('filter_home_review'))
{
	function filter_home_review($str, $user_name = '', $is_link = TRUE)
	{
		$result = trim($str);
		if (strpos($result, $user_name) === 0)
		{
			$result = str_replace("###{$user_name}", '', "###{$result}");
		}
		$result = preg_replace("/<([a-zA-Z]+)[^>]*>/", '', $result);
		return ubb_convert($result, $is_link);
	}
}

/**
 * Get folder name
 *
 * @access    public
 * @param     array
 * @param     int
 * @return    string
 */
if (!function_exists('get_folder_name'))
{
	function get_folder_name($arr, $val)
	{
		foreach ($arr as $item)
		{
			if ($item['Value'] == $val)
			{
				return $item['Text'];
			}
		}
	}
}

/**
 * ubb format convert
 *
 * @access    public
 * @param     string
 * @param     bool
 * @param     bool
 * @return    string
 */
if (!function_exists('ubb_convert'))
{
	function ubb_convert($str = '', $is_link = FALSE, $is_special = FALSE)
	{
		$result = trim($str);
		if (strlen($result) > 0)
		{
			$result = preg_replace("/\[TEL\](.[^\[]*)(\[\/TEL\])/is", '****', $result);
			if ($is_link)
			{
				$site_url = site_url();
				$result = preg_replace("/\[USER=(.[^\]]*)\](.[^\[]*)(\[\/USER\])/is", "<a href='{$site_url}/accounts/users/view/$1' alt='$2' width='480' height='385' event='popup'>$2</a>", $result);
				$result = preg_replace("/\[CLIENT=(.[^UUID]*)UUID=(.[^\]]*)\](.[^\[]*)(\[\/CLIENT\])/is", "<a href='{$site_url}/marketing/customers/info/$1' event='tabs' patches='true' alt='$3' uuid='$2'>$3</a>", $result);
				$result = preg_replace("/\[COMPANY=(.[^UUID]*)UUID=(.[^\]]*)\](.[^\[]*)(\[\/COMPANY\])/is", "<a href='{$site_url}/marketing/companys/info/$1' event='tabs' patches='true' alt='$3' uuid='$2'>$3</a>", $result);
				$result = preg_replace("/\[CONTACT=(.[^UUID]*)UUID=(.[^\]]*)\](.[^\[]*)(\[\/CONTACT\])/is", "<a href='{$site_url}/marketing/contacts/info/$1' event='tabs' patches='true' alt='$3' uuid='$2'>$3</a>", $result);
				$result = preg_replace("/\[COMPLAINT=(.[^\]]*)\](.[^\[]*)(\[\/COMPLAINT\])/is", "<a href='{$site_url}/support/complaints/view/$1' event='tabs' patches='true' alt='$2'>$2</a>", $result);
				$result = preg_replace("/\[SUPPLIER=(.[^\]]*)\](.[^\[]*)(\[\/SUPPLIER\])/is", "<a href='{$site_url}/products/supplier/view/$1' event='tabs' patches='true' alt='$2'>$2</a>", $result);
				$result = preg_replace("/\[CAMPAIGN=(.[^UUID]*)UUID=(.[^\]]*)\](.[^\[]*)(\[\/CAMPAIGN\])/is", "<a href='{$site_url}/marketing/campaigns/view/$1' event='tabs' patches='true' alt='$3' uuid='$2'>$3</a>", $result);
				$result = preg_replace("/\[CALENDER=(.[^\]]*)\](.[^\[]*)(\[\/CALENDER\])/is", "<a href='{$site_url}/tools/calender' event='tabs' transascId='$1' alt='日历'>$2</a>", $result);
				$result = preg_replace("/\[SALESORDER=(.[^\]]*)\](.[^\[]*)(\[\/SALESORDER\])/is", "<a href='{$site_url}/marketing/sales_order/view/$1' event='pushoff' orderId='$1' alt='销售订单'>$2</a>", $result);
				$result = preg_replace("/\[INVENTORY=(.[^\]]*)SORT=(.[^\]]*)\](.[^\[]*)(\[\/INVENTORY\])/is", "<a href='{$site_url}/products/inventory/view/$2/$1' event='pushoff' orderId='$1' alt='库存信息'>$3</a>", $result);
				$result = preg_replace("/\[WORKORDER=(.[^UUID]*)UUID=(.[^\]]*)\](.[^\[]*)(\[\/WORKORDER\])/is", "<a href='{$site_url}/support/work_order/info/$1' event='tabs' patches='true' alt='$3' uuid='$2'>$3</a>", $result);
			}
			else if ($is_special == TRUE)
			{
				$result = preg_replace("/\[CLIENT=(.[^UUID]*)UUID=(.[^\]]*)\](.[^\[]*)(\[\/CLIENT\])/is", '', $result);
				$result = preg_replace("/\[COMPANY=(.[^UUID]*)UUID=(.[^\]]*)\](.[^\[]*)(\[\/COMPANY\])/is", '', $result);
				$result = preg_replace("/\[CONTACT=(.[^UUID]*)UUID=(.[^\]]*)\](.[^\[]*)(\[\/CONTACT\])/is", '', $result);
				$result = preg_replace("/\[WORKORDER=(.[^UUID]*)UUID=(.[^\]]*)\](.[^\[]*)(\[\/WORKORDER\])/is", '', $result);
			}
			$result = preg_replace("/\[(.[^\]]*)\](.[^\[]*)(\[\/(.[^\]]*)\])/is", '$2', $result);
			$result = preg_replace("/\[(.[^\]]*)\](\[\/(.[^\]]*)\])/is", '', $result);
		}
		return trim($result);
	}
}

/**
 * Get fullname
 *
 * @access    public
 * @param     string
 * @param     string
 * @return    string
 */
if (!function_exists('get_fullname'))
{
	function get_fullname($ucode, $username = '')
	{
		$username = str_replace('&nbsp;', '', $username);
		$username = str_replace(' ', '', $username);
		$username = trim($username);
		if (strlen($username) > 0 && strlen(str_replace(' ', '', $username)) > 0)
		{
			return $username;
		}
		return $ucode;
	}
}

/**
 * Get fullname describe
 *
 * @access    public
 * @param     string
 * @param     string
 * @return    string
 */
if (!function_exists('get_fullname_describe'))
{
	function get_fullname_describe($ucode, $username = '')
	{
		$username = str_replace('&nbsp;', '', $username);
		$username = str_replace(' ', '', $username);
		$username = trim($username);
		if (strlen($username) > 0 && strlen(str_replace(' ', '', $username)) > 0)
		{
			return "{$username}({$ucode})";
		}
		return $ucode;
	}
}

/**
 * Set reserve filed
 *
 * @access    public
 * @param     object
 * @param     string
 * @param     string
 * @return    void
 */
if (!function_exists('set_reserve_filed'))
{
	function set_reserve_filed($ci, $filed_name, $filed_value = '')
	{
		if (is_array($filed_value))
		{
			$count = count($filed_value);
			if ($count > 0)
			{
				if ($count == 2 && (is_date($filed_value[0]) || is_date($filed_value[1])))
				{
					$filed_value[0] = replace_empty($filed_value[0], $filed_value[1]);
					$filed_value[1] = replace_empty($filed_value[1], $filed_value[0]);

					if (strlen($filed_value[0]) > 0 && strlen($filed_value[1]) > 0)
					{
						$ci->db->where("{$filed_name} BETWEEN '{$filed_value[0]}' AND '{$filed_value[1]}'");
					}
				}
				else
				{
					$sqlstr = '';
					foreach ($filed_value as $item)
					{
						if (strlen($item) > 0)
						{
							if (strlen($sqlstr) > 0) $sqlstr .= ' OR ';
							$sqlstr .= "FIND_IN_SET({$item}, {$filed_name})";
						}
					}

					if (strlen($sqlstr) > 0)
					{
						$ci->db->where("({$sqlstr})");
					}
				}
			}
		}
		else if (strlen($filed_value) > 0)
		{
			$ci->db->where($filed_name, $filed_value);
		}
	}
}

/**
 * Set date filed
 *
 * @access    public
 * @param     object
 * @param     string
 * @param     string
 * @return    void
 */
if (!function_exists('set_date_filed'))
{
	function set_date_filed($ci, $filed_name, $filed_value = '', $is_unix = FALSE)
	{
		if (!is_array($filed_value) || 
			count($filed_value) != 2 ||
			(!is_date($filed_value[0]) && !is_date($filed_value[1]))) 
		{
			return FALSE;
		}

		// $filed_value[0] = replace_empty($filed_value[0], $filed_value[1]);
		// $filed_value[1] = replace_empty($filed_value[1], $filed_value[0]);
		
		if ($is_unix === FALSE)
		{
			if (!is_date($filed_value[0]))
			{
				$ci->db->where("{$filed_name} <= '{$filed_value[1]} 23:59:59' AND {$filed_name} > 0 AND LENGTH({$filed_name}) > 0");
			}
			elseif (!is_date($filed_value[1]))
			{
				$ci->db->where("{$filed_name} >= '{$filed_value[0]} 00:00:00'");
			}
			else
			{
				$ci->db->where("{$filed_name} BETWEEN '{$filed_value[0]} 0:0:0' AND '{$filed_value[1]} 23:59:59'");
			}
		}
		else
		{
			$strtotime[0] = strtotime("{$filed_value[0]} 0:0:0");
			$strtotime[1] = strtotime("{$filed_value[1]} 23:59:59");

			if (!is_date($filed_value[0]))
			{
				$ci->db->where("{$filed_name} <= {$strtotime[1]} AND {$filed_name} > 0");
			}
			elseif (!is_date($filed_value[1]))
			{
				$ci->db->where("{$filed_name} >= {$strtotime[0]}");
			}
			else
			{
				$ci->db->where("({$filed_name} >= {$strtotime[0]} AND {$filed_name} <= {$strtotime[1]})");
			}
		}
	}
}

/**
 * Get IP section
 *
 * @access    public
 * @param     string
 * @return    string
 */
if (!function_exists('get_ip_section'))
{
	function get_ip_section($ipaddress = '')
	{
		$result = '';
		$items = explode('.', $ipaddress);
		if (count($items) == 4)
		{
			for ($i = 0; $i < 3; $i++)
			{
				$result .= $items[$i] . '.';
			}
			$result .= '*';
		}
		return $result;
	}
}

/**
 * Replace menu label
 *
 * @access    public
 * @param     string
 * @param     string
 * @param     string
 * @return    string
 */
if (!function_exists('replace_menu_label'))
{
	function replace_menu_label($url = '', $agent_account = '', $agent_name = '')
	{
		$result = trim($url);
		$result = str_replace('{AgentAccount}', $agent_account, $result);
		$result = str_replace('{AgentName}', urlencode($agent_name), $result);

		return $result;
	}
}

/**
 * Replace customer label
 *
 * @access    public
 * @param     string
 * @param     array
 * @param     array
 * @return    string
 */
if (!function_exists('replace_label'))
{
	function replace_label($url = '', $data = array(), $numbers = array())
	{
		$CI =& get_instance();

		$result = trim($url);
		$result = str_replace('{UCode}', $data->UCode, $result);
		$result = str_replace('{Username}', urlencode($data->Username), $result);
		$result = str_replace('{Address}', urlencode($data->StreetAddress), $result);
		$result = str_replace('{Owner}', $data->OwnerAccount, $result);
		$result = str_replace('{OwnerAccount}', $data->OwnerAccount, $result);
		$result = str_replace('{OwnerName}', urlencode($data->OwnerName), $result);
		$result = str_replace('{AgentAccount}', $CI->at_users->Username, $result);
		$result = str_replace('{AgentName}', urlencode($CI->at_users->TrueName), $result);

		if (stripos($result, '{Reserve1}') !== FALSE)
		{
			$result = str_replace('{Reserve1}', urlencode($CI->at_picklist->get_field_pick($data->Reserve_1, 'FE_CUSTOMER_RESERVE_1')), $result);
		}

		if (stripos($result, '{Reserve2}') !== FALSE)
		{
			$result = str_replace('{Reserve2}', urlencode($CI->at_picklist->get_field_pick($data->Reserve_2, 'FE_CUSTOMER_RESERVE_2')), $result);
		}

		if (stripos($result, '{Reserve3}') !== FALSE)
		{
			$result = str_replace('{Reserve3}', urlencode($CI->at_picklist->get_field_pick($data->Reserve_3, 'FE_CUSTOMER_RESERVE_3')), $result);
		}
		
		if (stripos($result, '{Telephone}') !== FALSE)
		{
			$telephone = '';
			foreach ($numbers as $rows)
			{
				if (strlen($telephone) > 0) $telephone .= ',';
				$telephone .= $rows->Number;
			}
			$result = str_replace('{Telephone}', $telephone, $result);
		}
		return $result;
	}
}

/**
 * Replace company label
 *
 * @access    public
 * @param     string
 * @param     array
 * @param     array
 * @return    string
 */
if (!function_exists('replace_company_label'))
{
	function replace_company_label($url = '', $data = array(), $numbers = array())
	{
		$CI =& get_instance();

		$result = trim($url);
		$result = str_replace('{UCode}', $data->UCode, $result);
		$result = str_replace('{CompanyName}', urlencode($data->CompanyName), $result);
		$result = str_replace('{Address}', urlencode($data->StreetAddress), $result);
		$result = str_replace('{Owner}', $data->OwnerAccount, $result);
		$result = str_replace('{OwnerAccount}', $data->OwnerAccount, $result);
		$result = str_replace('{OwnerName}', urlencode($data->OwnerName), $result);

		if (stripos($result, '{Reserve1}') !== FALSE)
		{
			$result = str_replace('{Reserve1}', urlencode($CI->at_picklist->get_field_pick($data->Reserve_1, 'FE_COMPANY_RESERVE_1', 1)), $result);
		}

		if (stripos($result, '{Reserve2}') !== FALSE)
		{
			$result = str_replace('{Reserve2}', urlencode($CI->at_picklist->get_field_pick($data->Reserve_2, 'FE_COMPANY_RESERVE_2', 1)), $result);
		}

		if (stripos($result, '{Reserve3}') !== FALSE)
		{
			$result = str_replace('{Reserve3}', urlencode($CI->at_picklist->get_field_pick($data->Reserve_3, 'FE_COMPANY_RESERVE_3', 1)), $result);
		}
		return $result;
	}
}

/**
 * Format company name
 *
 * @access  public
 * @param   string
 * @return  string
 */
if (!function_exists('format_company_name'))
{
	function format_company_name($company_name = '')
	{
		if (strlen($company_name) > 0)
		{
			$company_name = str_replace(' ', '', $company_name);
			$company_name = str_replace(' ', '', $company_name);
			$company_name = str_replace('\'', '’', $company_name);
			$company_name = str_replace('（', '(', $company_name);
			$company_name = str_replace('）', ')', $company_name);
			$company_name = trim($company_name);
		}
		return $company_name;
	}
}

/**
 * Format contact name
 *
 * @access  public
 * @param   string
 * @return  string
 */
if (!function_exists('format_contact_name'))
{
	function format_contact_name($contact_name = '')
	{
		if (strlen($contact_name) > 0)
		{
			$contact_name = str_replace(' ', '', $contact_name);
			$contact_name = str_replace('\'', '’', $contact_name);
			$contact_name = str_replace('（', '(', $contact_name);
			$contact_name = str_replace('）', ')', $contact_name);
			$contact_name = trim($contact_name);
		}
		return $contact_name;
	}
}

/**
 * Http request
 *
 * @access  public
 * @param   string
 * @param   string
 * @return  string
 */
if (!function_exists('http_request'))
{
	function http_request($url = '', $data = NULL)
	{
		if (!function_exists('curl_init'))
		{
			return FALSE;
		}

		try
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

			if (empty($data) === FALSE)
			{
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			}
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($curl);
			curl_close($curl);

			return $result;
		}
		catch (Exception $e)
		{
			return FALSE;
		}
	}
}

/**
 * Get table name
 *
 * @access    public
 * @param     string
 * @param     mixed
 * @return    string
 */
if (!function_exists('get_table_name'))
{
	function get_table_name($table_name, $datetime = '')
	{
		$CI =& get_instance();
		$partition = $CI->config->item('table_partition');
		if (isset($partition) && $partition == TRUE)
		{
			$year = date('Y');
			if (isset($datetime) && strlen($datetime) > 0)
			{
				if (is_numeric($datetime))
				{
					if (intval($datetime) > 0)
					{
						if (strlen($datetime) == 4)
						{
							$year = $datetime;
						}
						elseif (strlen($datetime) >= 10)
						{
							$year = date('Y', $datetime);
						}
					}
				}
				elseif (strlen($datetime) > 0)
				{
					$year = date('Y', strtotime($datetime));
				}
			}
			$table_name .= '_' . $year;
		}
		return $table_name;
	}
}

/**
 * Get url
 *
 * @access    public
 * @param     string
 * @return    string
 */
if (!function_exists('get_href'))
{
	function get_href($ipaddress = '')
	{
		$result = $ipaddress;
		if (stripos($ipaddress, 'http://') === FALSE && stripos($ipaddress, 'https://') === FALSE)
		{
			$result = 'http://' . $ipaddress;
		}
		return $result;
	}
}

/**
 * Encrypt And Eecrypt
 *
 * @access    public
 * @param     string
 * @param     bool
 * @return    string
 */
if (!function_exists('encrypt_and_decrypt'))
{
	function encrypt_and_decrypt($mobile = '', $is_encode = FALSE)
	{
		$result = '';
		$CI =& get_instance();
		$key = $CI->config->item('mobile_secret_key');
		if ($is_encode == TRUE)
		{
			$result = (float)$mobile + (float)$key;
		}
		else
		{
			$result = (float)$mobile - (float)$key;
		}
		return $result;
	}
}

/**
 *  获取六位激活码
 *
 * @access    public
 * @param     int
 * @return    string
 */
if (!function_exists('active_code'))
{
	function active_code($length = 6)
	{
		$result = '';
		for ($i = 0; $i < $length; $i++)
		{
			$result .= rand(0, 9);
		}
		return $result;
	}
}

/**
 * 数组序列化
 *
 * @access  public
 * @param   array
 * @return  string
 */
if (!function_exists('serialize_params'))
{
	function serialize_params($items)
	{
		if (!is_array($items))
		{
			return $items;
		}

		$result = array();
		foreach ($items as $key => $val)
		{
			if (is_array($val))
			{
				$val = implode(',', $val);
			}
			$result[] = "{$key}={$val}";
		}
		return implode('&', $result);
	}
}
/* End of file at_common_helper.php */
/* Location: ./applications/agent/helpers/at_common_helper.php */