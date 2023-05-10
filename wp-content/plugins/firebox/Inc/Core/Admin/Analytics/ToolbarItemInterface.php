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

namespace FireBox\Core\Admin\Analytics;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

interface ToolbarItemInterface
{
    /**
     * Holds the query data needed to return box log data for this type
     * 
     * @param   array    $$current_query_data
     * @param   array    $payload
     * 
     * @return  array
     */
    function getQueryData($metric, $current_query_data, $payload);

    
}