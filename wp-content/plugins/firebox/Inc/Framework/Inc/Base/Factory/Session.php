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

namespace FPFramework\Base\Factory;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Session
{
	/**
	 * Get Session ID
	 * 
	 * @return  string
	 */
    public function getSessionID()
    {
        return fpframework()->session->get_id();
    }

    /**
     * Gets Session value
     * 
     * @return  string
     */
    public function get($key)
    {
        return fpframework()->session->get($key);
    }

    /**
     * Sets session key, value
     * 
     * @return  void
     */
    public function set($key, $value)
    {
        return fpframework()->session->set($key, $value);
    }
}