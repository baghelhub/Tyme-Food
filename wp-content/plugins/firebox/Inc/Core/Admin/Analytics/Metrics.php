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

use FPFramework\Libs\Registry;

class Metrics
{
    /**
     * Default active metrics
     * 
     * @var  array
     */
    const default_active_metrics = [
        'impressions'
    ];

    /**
     * Default Metrics.
     * 
     * @var  array
     */
    private $metrics_map = [
        'impressions' => [
            'class' => 'Impressions',
        ],
        'averagetimeopen' => [
            'class' => 'AverageTimeOpen'
        ],
        'submissions' => [
            'class' => 'Submissions'
        ],
        'conversionrate' => [
            'class' => 'ConversionRate'
        ]
    ];

    /**
     * Metrics.
     * 
     * @var  array
     */
    private $metrics = [];

    private $toolbar;

    public function __construct($toolbar = null)
    {
        $this->toolbar = $toolbar;
    }

    /**
     * Render metrics.
     * 
     * @return  void
     */
    public function render()
    {
        firebox()->renderer->admin->render('analytics/metrics/tmpl');
    }

    /**
     * Gets all metric data with chart-related data
     * 
     * @return  array
     */
    public function getMetrics()
    {
        if (count($this->metrics))
        {
            return $this->metrics;
        }
        
        $this->initializeMetrics();

        return $this->metrics;
    }

    public function getMetricsData($update = true)
    {
        $data = [];

        $metrics = $this->getMetrics();

        foreach ($metrics as $key => $metric)
        {
            // Metrics that require other metrics to generate data
            if ($metric->getDataSource() === 'metrics')
            {
                $found_metrics = array_intersect_key($metrics, array_flip($metric->getDataSourceInput()));
    
                if ($found_metrics)
                {
                    // Skip fill dates
                    $metric_opts = $metric->getOptionsRaw();
                    $metric_opts['skip_filling_dates'] = true;
                    $metric->setOptions($metric_opts);

                    // Set custom metrics
                    $metric->setCustomMetrics($found_metrics);
                }
            }
        
            if ($update)
            {
                $metric->update();
            }
            
            $data[$key] = $metric->getData();
        }

        return $data;
    }

    /**
     * Returns the default active metrics
     * 
     * @return  array
     */
    public function getDefaultActiveMetrics()
    {
        return self::default_active_metrics;
    }
    
    /**
     * Returns all metrics labels
     * 
     * @return  array
     */
    public function getMetricsLabels()
    {
        $metrics = [];

        foreach ($this->getMetrics() as $key => $metric)
        {
            if (!$metric instanceof Metric)
            {
                continue;
            }

            $metrics[$key] = $metric->getCleanLabel();
        }
        
        return $metrics;
    }

    /**
     * Initialize all metrics items
     * 
     * @return  array
     */
    private function initializeMetrics()
    {
        foreach ($this->metrics_map as $metric => $value)
        {
            $class = '\FireBox\Core\Admin\Analytics\Metrics\\' . $value['class'];

            if (!class_exists($class))
            {
                continue;
            }

            // init metric and fetch its data
            $this->metrics[$metric] = new $class($this->toolbar);
        }
    }
}