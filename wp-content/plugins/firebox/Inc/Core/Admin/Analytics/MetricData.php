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

class MetricData
{
	/**
	 * Toolbar
	 * 
	 * @var  Toolbar
	 */
    private $toolbar;
    
    /**
     * Analytics DB Object
     * 
     * @var  DB
     */
    private $db;

    /**
     * Metric
     * 
     * @var  Metric
     */
    private $metric;

    /**
     * Query Data that will be used to merge with
     * the currently used query data.
     * 
     * @var  array
     */
    private $modify_query_data = [];
	
	/**
	 * MetricData Constructor
	 * 
	 * @param   Metric   $metric
	 * @param   Toolbar  $toolbar
	 * @param   DB       $db
	 * 
	 * @return  void
	 */
	public function __construct($metric = null, $toolbar = null, $db = null)
	{
        $this->metric = $metric;
        
        if (!$toolbar)
        {
            $toolbar = new Toolbar();
        }
        $this->toolbar = $toolbar;

        if (!$db)
        {
            $db = new DB();
        }
        $this->db = $db;
	}

    private function getToolbarItems()
    {
        return $this->toolbar->getToolbarItems();
    }

    private function getSelectedToolbarItems()
    {
        return $this->toolbar->getSelectedToolbarItems();
    }

	/**
	 * Returns the payload used to retrieve data for current period
	 * 
     * @param   mixed  $previous_period
     * 
	 * @return  array
	 */
    public function getResultsQueryData($previous_period = false)
    {
        $query_data = [];
        
        $toolbar_items = $this->getToolbarItems();

        foreach ($this->getSelectedToolbarItems() as $key => &$value)
        {
            if (empty($value))
            {
                continue;
            }

            $suffix = '';

            // get previous period
            if ($previous_period)
            {
                if ($key === 'date')
                {
                    $value = $toolbar_items['date']->getPreviousPeriodDateObject($value);
                }
                else
                {
                    $suffix .= '_prev_period';
                }
            }
            
            $method = $value['method'];

            $data = [
                'type' => $key,
                'method' => $method,
                'options_key' => $value['options_key'] . $suffix,
                'value' => isset($value['value']) ? $value['value'] : '',
                'previous_period' => $previous_period
            ];

            // get query data for each selected toolbar item
            $toolbarItemData = $toolbar_items[$key]->getQueryData($this->metric, $query_data, $data);

            /**
             * Get the manipulated query data from the toolbar item and use it.
             * The toolbar may alter the query data for its own purposes.
             */
            if (isset($toolbarItemData['query_data']))
            {
                // we receive the query data in case we have modified it within each toolbar item
                $query_data = $toolbarItemData['query_data'];

                unset($toolbarItemData['query_data']);
            }

            // merge the query data
            $query_data = array_replace_recursive($toolbarItemData, $query_data);
        }

        if ($this->metric)
        {
            $query_data = apply_filters('firebox/analytics/metric/' . $this->metric->getType() . '/filter_query_data', $query_data);
        }
        
        return $query_data;
    }

    /**
     * Get Metric Data
     * 
     * @param   bool   $previous_period
     * @param   array  $payload
     * 
     * @return  array
     */
    public function getData($previous_period = false, $payload = null)
    {
        if (!$payload)
        {
            $payload = $this->getResultsQueryData($previous_period);
        }

        if (!isset($payload['select']))
        {
            return [];
        }

        if (isset($this->modify_query_data))
        {
            $payload = array_replace_recursive($payload, json_decode(json_encode($this->modify_query_data), true));
        }

        $selected_toolbar_items = $this->getSelectedToolbarItems();

        return Helpers\MetricHelper::prepareDates($selected_toolbar_items['date']['options_key'], $this->db->getResults($payload));
	}

    /**
     * Get percentage change over previous period(month)
     * 
     * @param   int    $current_total
     * 
     * @return  float
     */
    public function getPercentageChangeWithPreviousPeriod($current_total)
    {
        if ($current_total <= 0)
        {
            return 0;
        }

        $toolbar_items = $this->getToolbarItems();

        $selected_toolbar_items = $this->getSelectedToolbarItems();

        $previous_period = $toolbar_items['date']->getPreviousPeriodDateObject($selected_toolbar_items['date']);

        $selected_toolbar_items['date'] = $previous_period;
        
        $payload = $this->getResultsQueryData(true);

        $results = $this->db->getResults($payload);
        
        $result = isset($results[0]) ? (array) $results[0] : null;

        $previous_period_total = isset($result['total']) ? (int) $result['total'] : 0;

        if ($previous_period_total <= 0)
        {
            return 0;
        }

        $percentage = (($current_total - $previous_period_total) / $previous_period_total) * 100;

        return $percentage;
    }

    public function setModifyQueryData($data)
    {
        $this->modify_query_data = $data;
    }

    public function setToolbar($toolbar)
    {
        $this->toolbar = $toolbar;
    }
}