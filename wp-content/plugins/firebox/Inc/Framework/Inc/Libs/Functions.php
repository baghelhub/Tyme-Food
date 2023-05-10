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

namespace FPFramework\Libs;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Functions
{
    /**
     * Increments the session
     * 
     * @return  void
     */
    public static function incrementSession()
    {
        $newValue = fpframework()->session->get('fpf.session.counter') + 1;
        fpframework()->session->set('fpf.session.counter', $newValue);
    }
}