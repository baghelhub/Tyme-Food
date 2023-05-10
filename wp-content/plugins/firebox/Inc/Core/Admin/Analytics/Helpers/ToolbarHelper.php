<?php
/**
 * @package         FireBox
 * @version         2.0.3 Free
 * 
 * @author          FirePlugins <info@fireplugins.com>
 * @link            https://www.fireplugins.com
 * @copyright       Copyright © 2023 FirePlugins All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

namespace FireBox\Core\Admin\Analytics\Helpers;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class ToolbarHelper
{
    /**
     * Returns a GET parameter of key and its value.
     * The value is JSON encoded and then run by urlencode().
     * 
     * @param   string  $key
     * @param   array   $data
     * 
     * @return  string
     */
    public static function dataToURLParam($key, $data)
    {
        if (!$data || !is_array($data))
        {
            return '';
        }

        return $key . '=' . urlencode(json_encode($data));
    }
}