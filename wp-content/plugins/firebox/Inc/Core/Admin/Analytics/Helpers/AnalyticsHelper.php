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

use FPFramework\Libs\Registry;
use Firebox\Core\Admin\Analytics\Toolbar;

class AnalyticsHelper
{
    /**
     * Returns the data based on metrics, toolbar items and other data
     * 
     * @param   array  $metrics
     * @param   array  $toolbar_data
     * @param   array  $other_data
     * 
     * @return  array
     */
    public static function getData($metrics = [], $toolbar_data = [], $other_data = [])
    {
        if (!$metrics || !is_array($metrics))
        {
            return [];
        }

        $other_data = new Registry($other_data);

        $data = [];

        // create a Toolbar and set the selected toolbar items
        $toolbar = new Toolbar(null, $toolbar_data);

        $metricsObjects = new \FireBox\Core\Admin\Analytics\Metrics($toolbar);
        $metricsObjects = $metricsObjects->getMetricsData();

        foreach ($metrics as $metric)
        {
            $metricInstance = $metricsObjects[$metric]['metric'];

            // Metrics that require other metrics to generate data
            if ($metricInstance->getDataSource() === 'metrics')
            {
                $found_metrics = array_intersect_key($metricsObjects, array_flip($metricInstance->getDataSourceInput()));

                if ($found_metrics)
                {
                    foreach ($found_metrics as &$_metric)
                    {
                        $_metric = $_metric['metric'];
                    }
                    
                    // Skip fill dates
                    $metric_opts = $metricInstance->getOptionsRaw();
                    $metric_opts['skip_filling_dates'] = true;
                    $metricInstance->setOptions($metric_opts);

                    // Set custom metrics
                    $metricInstance->setCustomMetrics($found_metrics);
                }
            }

            // Check if we were given extra query data that modify the base query and apply them.
            $metric_modify_query_data = $other_data->get('modify_query_data', []);
            if ($metric_modify_query_data)
            {
                $metricInstance->getMetricData()->setModifyQueryData($metric_modify_query_data);
            }

            // Check if we have extra options to set for the Metric
            $metric_options = $other_data->get('options', []);
            if ($metric_options)
            {
                $metricInstance->setOptions($metric_options);
            }

            $metric_data = $metricInstance->update()->getData();

            // store them
            if (count($metrics) == 1)
            {
                $data = $metric_data;
            }
            else
            {
                $data[$metricInstance->getType()] = $metric_data;
            }
        }
        
        return $data;
    }
    
    /**
     * Whether we can run an analytics page or not
     * 
     * @param   string   $page
     * 
     * @return  boolean
     */
    public static function canRun($page = '')
    {
        if (!$page)
        {
            return false;
        }
        
        // we must be on admin panel
        if (!is_admin())
        {
            return false;
        }

        // ensure we have correct priviledges
        if (!is_user_logged_in() || !current_user_can('manage_options'))
        {
            return false;
        }

        // we must be on admin.php page
        global $pagenow;
        if ($pagenow !== 'admin.php')
        {
            return false;
        }

        // ensure we are on firebox dashboard
        $page = fpframework()->getPluginPage();
        if (!$page || !in_array($page, [$page]))
        {
            return false;
        }
        
        return true;
    }
}