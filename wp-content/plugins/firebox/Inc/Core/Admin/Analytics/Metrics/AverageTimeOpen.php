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

class AverageTimeOpen extends Metric
{
    /**
     * The suffix that is added to the results.
     * s => seconds
     * Todo: make it translatable
     * 
     * @var  string
     */
    protected $suffix = 's';

    /**
     * Metric specific data
     */
    protected function getMetricSpecificData()
    {
        return [
            'type' => 'averagetimeopen',
            'color' => '#5e35b1',
            'hover_color' => '#7e57c2',
            'clean_label' => fpframework()->_('FPF_AVG_TIME_OPEN'),
            'label' => fpframework()->_('FPF_AVG_TIME_OPEN'),
            'tooltip' => firebox()->_('FB_AVG_TIME_OPEN_TOOLTIP'),
            'read_more_link' => FPF_SITE_URL . 'docs/firebox/analytics/the-average-time-open-metric',
            'decimal_points' => 0,
            'hide_from_results_toolbar_items' => [
                'event'
            ]
        ];
    }

    /**
     * Parses the metric total amount
     * 
     * @param   int    $total
     * @param   array  $data
     * @param   bool   $parseMetricTotal
     * 
     * @return  int
     */
    public function parseMetricTotal($total, $data, $parseMetricTotal = false)
    {
        $total_data = count($data);

        if (!$total_data)
        {
            return 0;
        }

        return $total / $total_data;
    }

    /**
     * Runs when we are initializing the Metric.
     * Useful when we want to run something related to this metric only.
     * 
     * @return  void
     */
    public function onInit()
    {
        add_filter('firebox/analytics/metric/averagetimeopen/filter_query_data', [$this, 'filterQueryData']);
    }
    
    /**
     * Runs prior to fetching Results Table data
     * 
     * @return  void
     */
    public function onResults()
    {
        add_filter('firebox/analytics/metric/averagetimeopen/filter/all/results_query_data', [$this, 'filterQueryData']);
        add_filter('firebox/analytics/metric/averagetimeopen/filter/all/results_last_period_query_data', [$this, 'filterQueryData']);
    }

    /**
     * Ensure we only get average time open data
     * 
     * @param   array  $payload
     * 
     * @return  array
     */
    public function filterQueryData($payload = [])
    {
        if (!$payload || !is_array($payload))
        {
            return [];
        }

        $configuration = $this->getConfiguration();

        $left_join_key = 'left join ' . $configuration['logs_details_table'] . ' as bld';
        
        // if JOIN is not set, set it
        if (!isset($payload['join'][$left_join_key]))
        {
            $payload['join'][$left_join_key] = ' ON bl.id = bld.log_id';
        }

        // remove current `as total` and set it to return the average time open
        foreach ($payload['select'] as $key => $value)
        {
            if (strpos(strtolower($value), 'as total') !== false)
            {
                unset($payload['select'][$key]);
                $payload['select'][] = 'IFNULL(TRUNCATE(avg(TIMESTAMPDIFF(SECOND, bl.date, bld.date)), 2), 0) AS total';
                break;
            }
        }
        
        return $payload;
    }
}