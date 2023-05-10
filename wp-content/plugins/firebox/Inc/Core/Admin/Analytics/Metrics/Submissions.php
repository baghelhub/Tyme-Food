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

class Submissions extends Metric
{
    /**
     * Metric specific data
     */
    protected function getMetricSpecificData()
    {
        return [
            'type' => 'submissions',
            'color' => '#32a39e',
            'hover_color' => '#32b9b3',
            'clean_label' => fpframework()->_('FPF_SUBMISSIONS'),
            'label' => fpframework()->_('FPF_SUBMISSIONS'),
            'tooltip' => firebox()->_('FB_METRIC_SUBMISSIONS_TOOLTIP'),
            'read_more_link' => FPF_SITE_URL . 'docs/firebox/analytics/the-submissions-metric',
            'decimal_points' => 0,
            'hide_from_results_toolbar_items' => [
                'event'
            ]
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
        add_filter('firebox/analytics/metric/submissions/filter_query_data', [$this, 'filterMetricQueryData']);
    }

    public function filterMetricQueryData($payload = [])
    {
        if (!$payload || !is_array($payload))
        {
            return [];
        }

        // These filters are not related to a submission.
        // In the future, we could add a box column to the submissions table so we can utilize them. Does the column make sense?
        unset($payload['where']['bl.country']);
        unset($payload['where']['bl.device']);
        unset($payload['where']['bl.event']);
        unset($payload['where']['bl.page']);
        unset($payload['where']['bl.box']);

        // Set which table will be used to retrieve the data, in this case the #__firebox_submissions table
        $payload['table'] = 'submission';
        
        /**
         * We need to replace all bl.date references to bl.created_at as used in the submissions table.
         * 
         * We need a better way of setting the prefix and date column.
         */
        $payload = json_encode($payload);
        $payload = str_replace('bl.date', 'bl.created_at', $payload);
        $payload = json_decode($payload, true);

        return $payload;
    }

    /**
     * Runs prior to fetching Results Table data
     * 
     * @return  void
     */
    public function onResults()
    {
        // Date
        add_filter('firebox/analytics/metric/submissions/filter/date/results_query_data', [$this, 'filterDateResultsQueryData'], 10, 2);
        add_filter('firebox/analytics/metric/submissions/filter/date/results_last_period_query_data', [$this, 'filterDateResultsQueryData'], 10, 2);

        // Date
        add_filter('firebox/analytics/metric/submissions/filter/box/results_query_data', [$this, 'filterResultsQueryData'], 10, 2);
        add_filter('firebox/analytics/metric/submissions/filter/box/results_last_period_query_data', [$this, 'filterResultsQueryData'], 10, 2);
        
        // Country
        add_filter('firebox/analytics/metric/submissions/filter/country/results_query_data', [$this, 'filterResultsQueryData'], 10, 2);
        add_filter('firebox/analytics/metric/submissions/filter/country/results_last_period_query_data', [$this, 'filterResultsQueryData'], 10, 2);
        
        // Device
        add_filter('firebox/analytics/metric/submissions/filter/device/results_query_data', [$this, 'filterResultsQueryData'], 10, 2);
        add_filter('firebox/analytics/metric/submissions/filter/device/results_last_period_query_data', [$this, 'filterResultsQueryData'], 10, 2);
        
        // Page
        add_filter('firebox/analytics/metric/submissions/filter/page/results_query_data', [$this, 'filterResultsQueryData'], 10, 2);
        add_filter('firebox/analytics/metric/submissions/filter/page/results_last_period_query_data', [$this, 'filterResultsQueryData'], 10, 2);
        
        // Referrer
        add_filter('firebox/analytics/metric/submissions/filter/referrer/results_query_data', [$this, 'filterResultsQueryData'], 10, 2);
        add_filter('firebox/analytics/metric/submissions/filter/referrer/results_last_period_query_data', [$this, 'filterResultsQueryData'], 10, 2);
    }

    public function filterResultsQueryData($payload = [], $filter = '')
    {
        if (!$payload || !is_array($payload) || empty($filter))
        {
            return [];
        }
        
        $configuration = $this->getConfiguration();
        
        foreach ($payload['select'] as $key => $value)
        {
            $where_keys = isset($payload['where']) && count($payload['where']) ? array_keys($payload['where']) : [];
            
            if (strpos(strtolower($value), 'as total') !== false)
            {
                if ($where_keys)
                {
                    array_walk($where_keys, function(&$item) {
                        $item = '(' . str_replace('bl.', 'bll.', $item) . ' = ' . $item . ')';
                    });
                }
                
                unset($payload['select'][$key]);
                $payload['select'][] = '(
                    select count(sm.id)
                    from ' . $configuration['submissions_meta_table'] . ' as sm
                    where
                        sm.meta_key = \'box_log_id\' 
                        AND EXISTS (
                            SELECT
                                1 
                            FROM
                            ' . $configuration['logs_table'] . ' AS bll 
                            WHERE
                                ' . ($where_keys ? implode(' AND ', $where_keys) : '') . '
                                AND (
                                    sm.meta_value = bll.id
                                )
                        )

                ) as total';
                break;
            }
        }

        return $payload;
    }

    public function filterDateResultsQueryData($payload = [], $filter = '')
    {
        if (!$payload || !is_array($payload) || empty($filter))
        {
            return [];
        }

        $configuration = $this->getConfiguration();
        
        foreach ($payload['select'] as $key => $value)
        {
            if (strpos(strtolower($value), 'as total') !== false)
            {
                unset($payload['select'][$key]);
                $payload['select'][] = '(
                    select count(sm.id)
                    from ' . $configuration['submissions_meta_table'] . ' as sm
                       where
                        sm.meta_key = \'box_log_id\' and sm.meta_value IN (
                            select bll.id
                            from ' . $configuration['logs_table'] . ' as bll
                            WHERE date(bll.' . $filter . ') = date(bl.' . $filter . ')
                        )
                ) as total';
                break;
            }
        }
        
        return $payload;
    }
}