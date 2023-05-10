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

namespace FireBox\Core\Admin\Analytics\Toolbar;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use FireBox\Core\Admin\Analytics\ToolbarItem;
use FireBox\Core\Admin\Analytics\ToolbarItemInterface;

class Date extends ToolbarItem implements ToolbarItemInterface
{
    /**
     * Toolbar Item Type
     * 
     * @var  string
     */
    protected $type = 'date';

    /**
     * Toolbar Popup Title
     * 
     * @var  string
     */
    protected $popup_title = 'FPF_DATE_RANGE';

    /**
     * Toolbar Popup Title Plural
     * 
     * @var  string
     */
    protected $popup_title_plural = 'FPF_DATES';

    /**
     * Total days we are showing
     * 
     * @var  int
     */
    protected $total_days;

    /**
     * Start date for the date range
     * 
     * @var  string
     */
    protected $start_date;

    /**
     * Whether we are fetching data for a single day.
     * 
     * @var  boolean
     */
    protected $single_day;

    /**
     * Holds the query data needed to return box log data for this type
     * 
     * @param   array  $current_query_data
     * @param   array  $payload
     * 
     * @return  array
     */
    public function getQueryData($metric, $current_query_data, $payload)
    {
        $this->single_day = isset($payload['method']) && $payload['method'] === 'filter' && isset($payload['options_key']) && $payload['options_key'] === 'today';

        $data = [
            'select' => ['count(bl.id) as total', 'DATE_FORMAT(bl.date, "%d/%m/%Y") as label'],
            'from_table_name_as' => ' as bl',
            'where' => $this->getWhere($payload),
            'groupby' => 'date(bl.date)',
            'orderby' => 'bl.date ASC'
        ];

        $data = $this->filterTodayData($data);

        return parent::getQueryData($metric, $data, $payload);
    }

    /**
     * Filter the query for `Today` data if we are searching for data today.
     * 
     * @param   array  $data
     * 
     * @return  array
     */
    private function filterTodayData($data)
    {
        if (!$this->single_day)
        {
            return $data;
        }

        $date_selection = 'CONCAT(DATE_FORMAT(bl.date, \'%H\'), \':00\')';

        $data['select'] = [
            $date_selection . ' as label',
            'count(bl.id) as total'
        ];
        $data['groupby'] = $date_selection;

        return $data;
    }

    

    /**
     * Parses the results of the dates by setting timezone if viewing "today" data.
     * 
     * @param   string  $period
     * @param   array   $dates
     * 
     * @return  void
     */
    public function parseResults($period, &$dates)
    {
        if (!$dates)
        {
            return;
        }

        // When viewing "Today" results, we need only the hour:minutes
        if ($period === 'today')
        {
            $timezone = \FPFramework\Helpers\Date::getTimezone();
            $tz = new \DateTimeZone($timezone);
    
            foreach ($dates as $key => &$value)
            {
                $date = (new \DateTime($value['label']))->setTimezone($tz);
                $value['label'] = $date->format('H:00');

            }
            return;
        }
        
        // Other periods display the full date
        foreach ($dates as $key => &$value)
        {
            // $date = \DateTime::createFromFormat('d/m/Y', $value['label']);
            // $value['label'] = $date->format('Y-m-d');
            $value['label'] = $value['label'];
        }
    }
    
    /**
     * Returns the WHERE for "filter"
     * 
     * @param   array  $payload
     * 
     * @return  array
     */
    protected function getFilterWhere($payload)
    {
        if (!$payload || !is_array($payload))
        {
            return [];
        }

        if (!isset($payload['options_key']) || !isset($payload['value']) || !is_string($payload['options_key']))
        {
            return [];
        }

        $where = [];

        $currDate = $this->calculateSQLCurrentDate();

        $current_day = date('d');
        $year = date('Y');

        switch ($payload['options_key'])
        {
            

            case 'this_month':
            default:
                $where = [
                    'MONTH(bl.date)' => ' = MONTH(CURRENT_DATE())',
                    'YEAR(bl.date)' => ' = YEAR(CURRENT_DATE())'
                ];

                $month = date('m');
                $this->total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $this->start_date = '01/' . $month . '/' . $year;
                break;

            
        }

        return $where;
    }
    
    /**
     * Returns the WHERE for "compare"
     * 
     * @param   array  $payload
     * 
     * @return  array
     */
    protected function getCompareWhere($payload)
    {
        $where = [];

        $current_day = date('d');
        $year = date('Y');

        switch ($payload['options_key'])
        {
            

            // Compare This Month
            case 'compare_this_month':
            case 'compare_this_month_yoy':
            default:
                $where = [
                    'MONTH(bl.date)' => ' = MONTH(CURRENT_DATE())',
                    'YEAR(bl.date)' => ' = YEAR(CURRENT_DATE())'
                ];

                $month = date('m');
                $this->total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $this->start_date = '01/' . $month . '/' . $year;
                break;
            
            case 'compare_this_month_prev_period':
                $currDate = $this->getSQLCurrentDateMinusInterval1Month();

                $where = [
                    'MONTH(bl.date)' => ' = MONTH(' . $currDate . ')',
                    'YEAR(bl.date)' => ' = YEAR(' . $currDate . ')'
                ];

                $month = $this->getStrtotimeWithTz('-1 month', 'm');
                $this->total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $this->start_date = '01/' . $month . '/' . $year;
                break;

            
        }
    
        return $where;
    }

    /**
     * Sets the Custom WHERE for filter/compare
     * 
     * @param   string   $start_date
     * @param   string   $end_date
     * @param   string   $where
     * 
     * @return  void
     */
    private function setCustomWhere($start_date, $end_date, &$where)
    {
        global $wpdb;
        
        $where['DATE(bl.date)'] = ' BETWEEN ' . $wpdb->prepare('%s', $start_date) . ' AND ' . $wpdb->prepare('%s', $end_date);
        
        // find diference between the 2 dates
        if (strtotime($start_date) !== false)
        {
            $start = new \DateTime($start_date);
            $end = new \DateTime($end_date);
            $this->total_days = $end->diff($start)->days;
            $this->start_date = $start->format('d/m/Y');
        }
    }

    /**
     * Sets ORDER BY for this type
     * 
     * @param   array  $data
     * @param   array  $payload
     * 
     * @return  void
     */
    private function setupOrderBy(&$data, $payload)
    {
        if ($payload['options_key'] == 'last_7_days')
        {
            $data['orderby'] = 'bl.date ASC';
        }
    }

    

    /**
     * Returns the date toolbar object that retrieve previous period data
     * 
     * @param   array   $date_toolbar_item
     * 
     * @return  array
     */
    public function getPreviousPeriodDateObject($date_toolbar_item)
    {
        if (!$date_toolbar_item)
        {
            return;
        }

        $current_period = $date_toolbar_item['options_key'];
        
        $previous_period = $current_period;
        $value = '';
        $method = 'compare';

        switch ($current_period)
        {
            case 'today':
            case 'yesterday':
                $previous_period = 'yesterday';
                $method = 'filter';
                break;

            case 'last_7_days':
            case 'compare_last_7_days':
                $previous_period = 'compare_last_7_days_prev_period';
                break;

            case 'compare_last_7_days_yoy':
                $previous_period = 'compare_last_7_days_yoy_prev_period';
                break;

            case 'this_month':
            case 'compare_this_month':
                $previous_period = 'compare_this_month_prev_period';
                break;

            case 'compare_this_month_yoy':
                $previous_period = 'compare_this_month_yoy_prev_period';
                break;

            case 'last_3_months':
                $previous_period = 'compare_last_3_months';
                break;
            case 'compare_last_3_months':
                $previous_period = 'compare_last_3_months_prev_period';
                break;

            case 'compare_last_3_months_yoy':
                $previous_period = 'compare_last_3_months_yoy_prev_period';
                break;

            case 'last_6_months':
                $previous_period = 'compare_last_6_months';
                break;
            case 'compare_last_6_months':
                $previous_period = 'compare_last_6_months_prev_period';
                break;

            case 'last_12_months':
                $previous_period = 'compare_last_12_months';
                break;
            case 'compare_last_12_months':
                $previous_period = 'compare_last_12_months_prev_period';
                break;

            case 'last_16_months':
                $previous_period = 'compare_last_16_months';
                break;
            case 'compare_last_16_months':
                $previous_period = 'compare_last_16_months_prev_period';
                break;

            case 'custom':
                $method = isset($date_toolbar_item['method']) ? $date_toolbar_item['method'] : 'filter';
                $previous_period = 'custom_prev_period';
                break;
        }

        $date_toolbar_item['options_key'] = $previous_period;
        $date_toolbar_item['method'] = $method;

        return $date_toolbar_item;
    }

    /**
     * Retrieves the toolbar item value in filter mode
     * 
     * @param   int    $value
     * 
     * @return  array
     */
    public function getFilterToolbarItemWithValue($value)
    {
        return [
            'method' => 'filter',
            'options_key' => $value,
        ];
    }

    

    public function getOptionsKey()
    {
        return $this->selectedToolbarItems['date']['options_key'];
    }

    public function getTotalDays()
    {
        return $this->total_days;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    
}