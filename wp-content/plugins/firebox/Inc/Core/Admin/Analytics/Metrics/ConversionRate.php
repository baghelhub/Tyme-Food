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

class ConversionRate extends Metric
{
    protected $data_source = 'metrics';

    protected $data_source_input = [
        'impressions',
        'submissions'
    ];

    /**
     * The suffix that is added to the results.
     * s => seconds
     * Todo: make it translatable
     * 
     * @var  string
     */
    protected $suffix = '%';

    /**
     * Metric specific data
     */
    protected function getMetricSpecificData()
    {
        return [
            'type' => 'conversionrate',
            'color' => '#c6a124',
            'hover_color' => '#e1b215',
            'clean_label' => fpframework()->_('FPF_CONVERSION_RATE'),
            'label' => fpframework()->_('FPF_CONVERSION_RATE'),
            'tooltip' => firebox()->_('FB_CONVERSION_RATE_TOOLTIP'),
            'read_more_link' => FPF_SITE_URL . 'docs/firebox/analytics/the-conversion-rate-metric',
            'decimal_points' => 2,
            'hide_from_results_toolbar_items' => [
                'event'
            ]
        ];
    }

    public function getCustomMetricData($previous_period = false)
    {
        if (!$metrics = $this->getCustomMetricsData())
        {
            return [];
        }
        
        $impressionsPeriodData = $previous_period ? $metrics['impressions']->getLastPeriodData() : $metrics['impressions']->getCurrentPeriodData();
        $submissionsPeriodData = $previous_period ? $metrics['submissions']->getLastPeriodData() : $metrics['submissions']->getCurrentPeriodData();

        $data = [];

        $index = 0;
        foreach ($submissionsPeriodData as $submission)
        {
            $data[] = [
                'label' => $impressionsPeriodData[$index]['label'],
                'total' => $impressionsPeriodData[$index]['total'] ? ($submission['total'] / $impressionsPeriodData[$index]['total']) * 100 : 0
            ];

            $index++;
        }

        return $data;
    }

    public function getResultsDataFromOtherMetrics($data)
    {
        $cvr = [];

        foreach ($data['impressions'] as $key => $value)
        {
            $cvr[$key]['data'] = [
                'current' => [],
                'last_period' => []
            ];

            foreach (['current', 'last_period'] as $period)
            {
                if (!isset($data['submissions'][$key]['data'][$period]))
                {
                    continue;
                }
                
                $submissions = $data['submissions'][$key]['data'][$period];

                if (empty($submissions))
                {
                    continue;
                }

                // Current
                $index = 0;
                foreach ($value['data'][$period] as $item)
                {
                    $cvr[$key]['data'][$period][] = [
                        'label' => $item['label'],
                        'total' => isset($submissions[$index]) ? ((int) $item['total'] ? ((int) $submissions[$index]['total'] / (int) $item['total']) * 100 : 0) : 0
                    ];
                    $index++;
                }
            }
        }
        
        return $cvr;
    }

    /**
     * Parses the metric total amount
     * 
     * @param   int    $total
     * @param   array  $data
     * @param   bool   $previous_period
     * 
     * @return  int
     */
    public function parseMetricTotal($total, $data, $previous_period = false)
    {
        if (!$metrics = $this->getCustomMetricsData())
        {
            return [];
        }
        
        $impressionsTotal = $previous_period ? $metrics['impressions']->getLastPeriodTotal() : $metrics['impressions']->getCurrentPeriodTotal();
        $submissionsTotal = $previous_period ? $metrics['submissions']->getLastPeriodTotal() : $metrics['submissions']->getCurrentPeriodTotal();

        return $impressionsTotal ? ($submissionsTotal / $impressionsTotal) * 100 : 0;
    }

    private function getCustomMetricsData()
    {
        $metrics = $this->getCustomMetrics();

        if (!isset($metrics['impressions']) || !isset($metrics['submissions']))
        {
            return;
        }

        return [
            'impressions' => $metrics['impressions'],
            'submissions' => $metrics['submissions']
        ];
    }
}