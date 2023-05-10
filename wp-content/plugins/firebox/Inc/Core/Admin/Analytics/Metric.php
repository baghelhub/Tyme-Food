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

class Metric
{
    /**
     * Where the data are coming from.
     * Options :
     * 
     * [db]      : By default they should be fetched from the DB via the selected Toolbar Items.
     * [metrics] : It is also possible to produce metric data by combining other metrics data
     * 
     * @return  string
     */
    protected $data_source = 'db';

    /**
     * If we have set `data_source` to "metrics". We need some metric names to manipulate
     * their values in order to produce metric data
     * 
     * @var  array
     */
    protected $data_source_input = [];

    /**
     * Type of metric
     * 
     * @var  string
     */
    protected $type;

    /**
     * Suffix that appears next to the metric total, chart values
     * 
     * @var  string
     */
    protected $suffix;

    /**
     * Results decimal points
     * 
     * @var  int
     */
    protected $decimal_points;

    /**
     * Label of metric
     * 
     * @var  string
     */
    private $label;

    /**
     * Whether we are comparing
     * 
     * @var  boolean
     */
    private $is_compare;

    /**
     * Metric color
     * 
     * @var  string
     */
    private $color;

    /**
     * Metric Hover color
     * 
     * @var  string
     */
    private $hover_color;

    /**
     * Clean Label of metric
     * 
     * @var  string
     */
    private $clean_label;

    /**
     * Current period data
     * 
     * @var  array
     */
    protected $current_period_data;

    /**
     * Current period total
     * 
     * @var  array
     */
    protected $current_period_total;
    
    /**
     * Last period data
     * 
     * @var  array
     */
    protected $last_period_data;
    
    /**
     * Last period total
     * 
     * @var  array
     */
    protected $last_period_total;

    /**
     * Tooltip of metric
     * 
     * @var  string
     */
    private $tooltip;

    /**
     * Read more URL of metric
     * 
     * @var  string
     */
    private $read_more_link;

    /**
     * The toolbar items from which the metric will not appear in the search results.
     * 
     * @var  string
     */
    private $hide_from_results_toolbar_items;

    /**
     * Percentage Change of metric
     * 
     * @var  float
     */
    protected $percentage_change;

    /**
     * Toolbar
     * 
     * @var  Toolbar
     */
    protected $toolbar;

    /**
     * Payload data
     * 
     * @var  array
     */
    private $payload;

    /**
     * Metric Data
     * 
     * @var  MetricData
     */
    protected $metric_data;

    /**
     * These metrics are used to calculate the metric value
     * when other metrics are used.
     * 
     * @var  array
     */
    private $custom_metrics = [];

    /**
     * Options Raw
     * 
     * @var  array
     */
    protected $options_raw;

    /**
     * Options
     * 
     * @var  object
     */
    protected $options;

    public function __construct($toolbar = null, $metric_data = null, $payload = null, $options = [])
    {
        if (!$toolbar)
        {
            $toolbar = new Toolbar();
        }
        $this->toolbar = $toolbar;

        if (method_exists($this, 'onInit'))
        {
            $this->onInit();
        }

        if (!$payload && method_exists($this, 'getMetricSpecificData'))
        {
            $payload = $this->getMetricSpecificData();
        }
        $this->payload = new Registry($payload);

        if (!$metric_data)
        {
            $metric_data = new MetricData($this, $this->toolbar);
        }
        $this->metric_data = $metric_data;

        $this->options_raw = $options;
        $this->options = new Registry($options);

        $this->setupBasicData();
    }

    public function setupBasicData()
    {
        // set basic metric data
        $this->type = $this->payload->get('type');
        $this->decimal_points = $this->payload->get('decimal_points');
        $this->color = $this->payload->get('color');
        $this->hover_color = $this->payload->get('hover_color');
        $this->label = $this->payload->get('label');
        $this->clean_label = $this->payload->get('clean_label');
        $this->tooltip = $this->payload->get('tooltip');
        $this->read_more_link = $this->payload->get('read_more_link');
        $this->hide_from_results_toolbar_items = $this->payload->get('hide_from_results_toolbar_items');
    }

    /**
     * Updates metric.
     * 
     * @return  void
     */
    public function update()
    {
        $this->setupBasicData();

        $skip_filling_dates = (bool) $this->options->get('skip_filling_dates', false);
        $skip_compare_check_to_retrieve_previous_data = (bool) $this->options->get('skip_compare_check_to_retrieve_previous_data', false);

        // current period data
        $this->current_period_data = $this->getPeriodData(false);
        $this->current_period_total = Helpers\ResultsHelper::sumTotalFromResults($this->current_period_data);

        $toolbarItems = $this->toolbar->getToolbarItems();
        $fillDatesPayload = [
            'start_date'   => $toolbarItems['date']->getStartDate(),
            'total_days'   => $toolbarItems['date']->getTotalDays(),
            
            'options_key'  => $toolbarItems['date']->getOptionsKey()
        ];

        if (!$skip_filling_dates)
        {
            // fill missing current data dates
            $this->current_period_data = Helpers\MetricHelper::fillMissingData($this->current_period_data, $fillDatesPayload, 'd/m/Y');
        }

        // Parse the metric total via the metric itself
        // This is useful if the metric needs to run extra logic prior to showing the total
        if (method_exists($this, 'parseMetricTotal'))
        {
            $this->current_period_total = $this->parseMetricTotal($this->current_period_total, $this->current_period_data);
        }

        
        $this->is_compare = false;
        
        

        $percentage_change = 0;
        // if we don't have a compare selected toolbar item, then get percentage from previous period
        if (!$skip_compare_check_to_retrieve_previous_data && !$this->is_compare)
        {
            // get last period data only for db related metrics
            // non-db related metrics handle their percentage change in Metrics.php method setMetricsData()
            if ($this->getDataSource() === 'db')
            {
                $percentage_change = $this->metric_data->getPercentageChangeWithPreviousPeriod($this->current_period_total);
            }
            else
            {
                // TODO: Adds last period data for custom metrics
            }
        }
        else
        {
            // last period data
            $this->last_period_data = $this->getPeriodData(true);
            $this->last_period_total = Helpers\ResultsHelper::sumTotalFromResults($this->last_period_data);

            // check if the metric needs to parse the metric total
            if (method_exists($this, 'parseMetricTotal'))
            {
                $this->last_period_total = $this->parseMetricTotal($this->last_period_total, $this->last_period_data, true);
            }
            
            if (!$skip_filling_dates)
            {
                // We are comparing and we have re-calculated the start date, so fetch it and set it so display accurate data on x axis
                $fillDatesPayload['start_date'] = $toolbarItems['date']->getStartDate();
                
                // fill missing last period data dates
                $this->last_period_data = Helpers\MetricHelper::fillMissingData($this->last_period_data, $fillDatesPayload, 'd/m/Y');
            }

            // Calculate a local percentage change from the current and last period
            $percentage_change = $this->getLocalMetricPercentageChange($this->current_period_total, $this->last_period_total);
        }
        $this->percentage_change = $percentage_change;

        return $this;
    }

    /**
     * Returns the metric period data.
     * 
     * @param   bool   $previous_period       Whether to get the data for the previous period.
     * 
     * @return  array
     */
    private function getPeriodData($previous_period = false)
    {
        return $this->getDataSource() === 'db' ? $this->metric_data->getData($previous_period) : $this->getCustomMetricData($previous_period);
    }

    /**
     * Returns all metric data
     * 
     * @return  array
     */
    public function getData()
    {
        $selected_toolbar_items = $this->toolbar->getSelectedToolbarItems();

        

        return [
            'type' => $this->type,
            'period_key' => $selected_toolbar_items['date']['options_key'],
            'data_source' => $this->data_source,
            'data_source_input' => $this->data_source_input,
            'suffix' => $this->suffix,
            'decimal_points' => $this->decimal_points,
            'label' => $this->label,
            'color' => $this->color,
            'hover_color' => $this->hover_color,
            'clean_label' => $this->clean_label,
            'compare' => $this->is_compare,
            'current_period' => [
                'data' => $this->current_period_data,
                'total' => $this->current_period_total,
                
            ],
            'last_period' => [
                'data' => $this->last_period_data,
                'total' => $this->last_period_total,
                
            ],
            'tooltip' => $this->tooltip,
            'read_more_link' => $this->read_more_link,
            'hide_from_results_toolbar_items' => $this->hide_from_results_toolbar_items,
            'percentage_change' => $this->percentage_change,
            'toolbar_items' => $selected_toolbar_items,
            'toolbar_items_url_safe' => Helpers\ToolbarHelper::dataToURLParam('toolbar_items', $selected_toolbar_items),
            'metric' => $this
        ];
    }

    /**
     * Returns the local metric percentage change
     * 
     * @param   int    $current_period_total
     * @param   int    $last_period_total
     * 
     * @return  float
     */
    public function getLocalMetricPercentageChange($current_period_total, $last_period_total)
    {
        if (!$last_period_total)
        {
            return 0;
        }

        $percentage = (($current_period_total - $last_period_total) / $last_period_total) * 100;

        return $percentage;
    }

    public function getMetricData()
    {
        return $this->metric_data;
    }
    
    /**
     * Get type
     * 
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get Label
     * 
     * @return  string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get Tooltip
     * 
     * @return  string
     */
    public function getTooltip()
    {
        return $this->tooltip;
    }

    /**
     * Get Read More Link
     * 
     * @return  string
     */
    public function getReadMoreLink()
    {
        return $this->read_more_link;
    }

    /**
     * Get Precentage Change
     * 
     * @return  float
     */
    public function getPercentageChange()
    {
        return $this->percentage_change;
    }

    /**
     * Get Current Period Metric Total
     * 
     * @return  float
     */
    public function getCurrentPeriodTotal()
    {
        return $this->current_period_total;
    }

    /**
     * Get Current Period Metric Data
     * 
     * @return  float
     */
    public function getCurrentPeriodData()
    {
        return $this->current_period_data;
    }

    /**
     * Get Last Period Metric Value
     * 
     * @return  float
     */
    public function getLastPeriodTotal()
    {
        return $this->last_period_total;
    }

    /**
     * Get Last Period Metric Data
     * 
     * @return  float
     */
    public function getLastPeriodData()
    {
        return $this->last_period_data;
    }

    /**
     * Get color
     * 
     * @return  float
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get hover color
     * 
     * @return  float
     */
    public function getHoverColor()
    {
        return $this->hover_color;
    }

    /**
     * Returns the clean label 
     * 
     * @return  boolean
     */
    public function getCleanLabel()
    {
        return $this->clean_label;
    }

    public function getDataSource()
    {
        return $this->data_source;
    }

    public function getDataSourceInput()
    {
        return $this->data_source_input;
    }

    public function getSuffix()
    {
        return $this->suffix;
    }

    public function getDecimalPoints()
    {
        return $this->decimal_points;
    }

    public function getToolbar()
    {
        return $this->toolbar;
    }

    protected function getConfiguration()
    {
        return $this->toolbar->getConfiguration();
    }

    public function setOptions($options)
    {
        $this->options = new Registry($options);
    }

    public function getOptionsRaw()
    {
        return $this->options_raw;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function setToolbar($toolbar)
    {
        $this->toolbar = $toolbar;
        $this->metric_data->setToolbar($toolbar);
    }

    public function getHideFromResultsToolbarItems()
    {
        return $this->hide_from_results_toolbar_items;
    }

    public function setCustomMetrics($custom_metrics)
    {
        $this->custom_metrics = $custom_metrics;
    }

    public function getCustomMetrics()
    {
        return $this->custom_metrics;
    }
}