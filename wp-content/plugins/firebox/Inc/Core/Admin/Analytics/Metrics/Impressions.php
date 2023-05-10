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

namespace FireBox\Core\Admin\Analytics\Metrics;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use FireBox\Core\Admin\Analytics\Metric;

class Impressions extends Metric
{
    /**
     * Metric specific data
     */
    protected function getMetricSpecificData()
    {
        return [
            'type' => 'impressions',
            'color' => '#4285f4',
            'hover_color' => '#5e97f6',
            'clean_label' => fpframework()->_('FPF_IMPRESSIONS'),
            'label' => fpframework()->_('FPF_IMPRESSIONS'),
            'tooltip' => firebox()->_('FB_TOTAL_IMPRESSIONS_TOOLTIP'),
            'read_more_link' => FPF_SITE_URL . 'docs/firebox/analytics/the-impressions-metric',
            'decimal_points' => 0
        ];
    }

    /**
     * Runs when we are initializing the Metric.
     * Useful when we want to run something related to this metric only.
     * 
     * @return  void
     */
    public function onInit()
    {
        add_filter('firebox/analytics/metric/impressions/filter_query_data', [$this, 'filterMetricQueryData']);
    }

    /**
     * Ensure we only get impressions data
     * 
     * @param   array  $payload
     * 
     * @return  array
     */
    public function filterMetricQueryData($payload = [])
    {
        if (!$payload || !is_array($payload))
        {
            return [];
        }
        
        if (!isset($payload['select']))
        {
            return $payload;
        }
        
        // if a total already, exists, remove it and add a new total for impressions
        foreach ($payload['select'] as $key => $value)
        {
            // if a total exists and its not a count(bl.id) total which is used to retrieve impressions, then replace it with an impressions count
            if (strpos($value, 'as total') !== false && strpos($value, 'count(bl.id) as total') === false) {
                unset($payload['select'][$key]);

                $payload['select'][] = 'count(bl.id) as total';
            }
        }

        return $payload;
    }
}