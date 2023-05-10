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

class OverviewHelper
{
    /**
     * Get overview data given a payload of data
     * 
     * @param   array    $payload
     * 
     * @return  array
     */
    public static function getOverviewData($payload)
    {
        if (!$payload)
        {
            return [];
        }
        
        $data = [];
        
        foreach ($payload as $key => $value)
        {
            if (!isset($value['overview_type']))
            {
                continue;
            }

            $overview_type = $value['overview_type'];

            $class = '\FireBox\Core\Admin\Analytics\Overview\Items\\' . ucfirst($overview_type);

            if (!class_exists($class))
            {
                continue;
            }

            // also send the overview item name
            $value['overview_item_name'] = $key;

            $class = new $class($value);

            $overview_data = $class->getData();

            // set the layout for this specific overview item if we were given one
            $layout = isset($value['layout']) ? $value['layout'] : $overview_type;
            $overview_data['layout'] = $layout;

            $overview_title = isset($value['overview_title']) ? $value['overview_title'] : '';
            $overview_data['overview_title'] = $overview_title;

            // get the overview item content
            $overview_data['content'] = firebox()->renderer->admin->render('analytics/overview/item.' . $layout, $overview_data, true);

            if (count($payload) == 1)
            {
                $data = $overview_data;
            }
            else
            {
                $data[] = $overview_data;
            }
        }

        return $data;
    }
}