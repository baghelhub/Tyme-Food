<?php
/**
 * @package         FirePlugins Framework
 * @version         1.1.57
 * 
 * @author          FirePlugins <info@fireplugins.com>
 * @link            https://www.fireplugins.com
 * @copyright       Copyright © 2023 FirePlugins All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

namespace FPFramework\Base;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Session
{
	/**
	 * Holds the session data.
	 *
	 * @var array
	 */
	private $session;

	/**
	 * Session index prefix
	 *
	 * @var string
	 */
	private $prefix = '';

	public function __construct()
	{
		if (is_multisite())
		{
			$this->prefix = '_' . get_current_blog_id();
		}

		$this->init();
	}

	/**
	 * Initialize.
	 * 
	 * @return  array
	 */
	public function init()
	{
		$key = 'fpframework' . $this->prefix;
		$this->session = isset($_SESSION[$key]) && is_array($_SESSION[$key]) ? $_SESSION[$key] : [];
	}

	/**
	 * Starts a new session if one hasn't started yet.
	 * 
	 * @return  void
	 */
	public function maybe_start_session()
	{
		if (headers_sent())
		{
			return;
		}

		if (session_id())
		{
			return;
		}

		session_start();
	}

	/**
	 * Retrieve session ID.
	 *
	 * @return  string
	 */
	public function get_id()
	{
		$this->maybe_start_session();

		if (!$this->get('session_id'))
		{
			$this->set('session_id', session_id());
		}
		
		return $this->get('session_id');
	}

	/**
	 * Set a session variable.
	 *
	 * @param   string  $key
	 * @param   mixed   $value
	 *
	 * @return  mixed
	 */
	public function set($key, $value)
	{
		$this->maybe_start_session();

		$key = strtolower($key);
        $key = preg_replace('/[^.a-z0-9_\-]/', '', $key);

		if (is_array($value))
		{
			$this->session[$key] = wp_json_encode($value);
		}
		else
		{
			$this->session[$key] = esc_attr($value);
		}

		$_SESSION['fpframework' . $this->prefix] = $this->session;

		return $this->session[$key];
	}

	/**
	 * Retrieve a session value.
	 *
	 * @param   string  $key
	 * 
	 * @return  mixed
	 */
	public function get($key)
	{
		$this->maybe_start_session();

		$key = strtolower($key);
        $key = preg_replace('/[^.a-z0-9_\-]/', '', $key);
		
		$return = false;

		if (isset($this->session[$key]) && !empty($this->session[$key]))
		{
			preg_match('/[oO]\s*:\s*\d+\s*:\s*"\s*(?!(?i)(stdClass))/', $this->session[$key], $matches);

			if (!empty($matches))
			{
				$this->set($key, null);
				return false;
			}

			if (is_numeric($this->session[$key]))
			{
				$return = $this->session[$key];
			}
			else
			{
				$maybe_json = json_decode($this->session[$key]);

				// Since json_last_error is PHP 5.3+, we have to rely on a `null` value for failing to parse JSON.
				if (is_null($maybe_json))
				{
					$is_serialized = is_serialized($this->session[$key]);

					if ($is_serialized)
					{
						$value = @unserialize($this->session[$key]);
						$this->set($key, (array) $value);
						$return = $value;
					}
					else
					{
						$return = $this->session[$key];
					}
				}
				else
				{
					$return = json_decode($this->session[$key], true);
				}
			}
		}

		return $return;
	}
}