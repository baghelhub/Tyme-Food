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

namespace FireBox\Core\Admin\Analytics\Overview\Items;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Boxestable extends Table
{
    public function parseData(&$metric_data)
    {
        if (!count($metric_data['current_period']['data']))
        {
            return;
        }

        $last_period_data = isset($metric_data['last_period']['data']) ? $metric_data['last_period']['data'] : [];

        $metrics = ['impressions'];

        // add the box toolbar item to the list of toolbar items that will be used in the link on each box label so we can directly
        // click on it and see analytics for this specific box
        $toolbar_items = $metric_data['toolbar_items'];
        $toolbar_items['box'] = [
            'method' => 'filter',
            'options_key' => 'box'
        ];

        foreach ($metric_data['current_period']['data'] as $key => &$value)
        {
            $value = (array) $value;
            $label = $value['label'];
            $total = $value['total'];

            $value['total'] = number_format($total, 0);

            $last_period_item = array_filter(
                $last_period_data,
                function ($e) use ($label, $value) {
                    $e = (array) $e;
                    return $e['box_id'] == $value['box_id'];
                }
            );
            $last_period_item = array_values($last_period_item);
            $last_period_total = isset($last_period_item[0]->total) ? $last_period_item[0]->total : 0;
            
            $difference = $last_period_total ? (($total - $last_period_total) / $last_period_total) * 100 : 0;
            $prefix = $difference > 0 ? '+' : '';

            $value['difference']['label'] = $prefix . number_format($difference, 0) . '%';
            $value['difference']['class'] = $difference > 0 ? 'plus' : ($difference < 0 ? 'minus' : '');

            $toolbar_items['box']['value'] = $value['box_id'];
            $value['label'] = [];
            $value['label']['label'] = $label;
            $value['label']['link'] = FBOX_LICENSE_TYPE === 'pro' ? admin_url('admin.php?page=firebox-analytics&toolbar_items=' . urlencode(json_encode($toolbar_items)) . '&metrics=' . urlencode(json_encode($metrics))) : '';

            // Remove the box_id key,value as we don't want it to appear on the table.
            // It's used only to set the URL for each box in the table
            unset($value['box_id']);
        }
    }
}