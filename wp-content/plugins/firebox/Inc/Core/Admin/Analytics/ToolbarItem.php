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

use FPFramework\Base\Ui\Tabs;
use FPFramework\Base\FieldsParser;

abstract class ToolbarItem
{
    /**
     * Popup Settings
     * 
     * @var  string
     */
    protected $settings;

    /**
     * Selected Toolbar Items
     * 
     * @var  array
     */
    protected $selectedToolbarItems;

    /**
     * Whether we are fetching data for previous period
     * 
     * @var  boolean
     */
    protected $fetchPreviousPeriodData;

    /**
     * Analytics configuration
     * 
     * @var  array
     */
    protected $configuration;

    /**
     * Manipulating metric
     * 
     * @var  Metric
     */
    protected $metric;

    /**
     * Current query data that we are manipulating.
     * This is passed to each toolbar item class that it
     * can use to modify.
     * 
     * @var  array
     */
    protected $current_query_data;

    /**
     * DB
     * 
     * @var  DB
     */
    protected $db;

    public function __construct($db = null, $configuration = [], $selectedToolbarItems = [])
    {
        if (!$db)
        {
            $db = new DB();
        }
        $this->db = $db;

        $this->configuration = $configuration;
        $this->selectedToolbarItems = $selectedToolbarItems;
        
        
    }

    /**
     * Holds the query data needed to return box log data for this type
     * 
     * @param   array    $current_query_data
     * @param   array    $payload
     * 
     * @return  array
     */
    public function getQueryData($metric, $current_query_data, $payload)
    {
        $this->metric = $metric;
        
        // get the current query data to manipulate
        $this->current_query_data = $current_query_data;
        
        if (!$payload && !is_array($payload) && !isset($payload['method']))
        {
            return [];
        }
        
        $method = $payload['method'];

        if (!is_string($method))
        {
            return [];
        }

        if (!in_array(strtolower($method), ['filter', 'compare']))
        {
            return [];
        }
        
        if (isset($payload['previous_period']))
        {
            $this->fetchPreviousPeriodData = $payload['previous_period'];
        }

        // Send back the WHERE and the manipulated query data
        $data = [
            'where' => $this->getWhere($payload),
            'query_data' => $this->current_query_data
        ];

        return $data;
    }

    /**
     * Return the popup title
     * 
     * @return  array
     */
    public function getPopupTitle()
    {
        return fpframework()->_($this->popup_title);
    }

    /**
     * Return the results table title
     * 
     * @return  array
     */
    public function getResultsTableTitle()
    {
        return $this->getPopupTitle();
    }

    /**
     * Return the plural popup title
     * 
     * @return  array
     */
    public function getPluralPopupTitle()
    {
        return fpframework()->_($this->popup_title_plural);
    }

    

    /**
     * Returns the CURDATE() minus interval of 1 month if we are fetching previous period data
     * 
     * @return  string
     */
    protected function getSQLCurrentDateOrWithMinusInterval1Month()
    {
        return 'CURDATE()' . ($this->fetchPreviousPeriodData ? ' - INTERVAL 1 MONTH' : '');
    }
    
    /**
     * Returns the CURDATE() minus interval of 1 week if we are fetching previous period data
     * 
     * @return  string
     */
    protected function getSQLCurrentDateOrWithMinusInterval1Week()
    {
        return 'CURDATE()' . ($this->fetchPreviousPeriodData ? ' - INTERVAL 1 WEEK' : '');
    }
    
    /**
     * Returns the CURDATE() minus interval of 1 year
     * 
     * @return  string
     */
    protected function getSQLCurrentDateWithMinusInterval1Year()
    {
        return 'CURDATE() - INTERVAL 1 YEAR';
    }
    
    /**
     * Returns the CURDATE() minus interval of 1 month
     * 
     * @return  string
     */
    protected function getSQLCurrentDateMinusInterval1Month()
    {
        return 'CURDATE() - INTERVAL 1 MONTH';
    }
    
    /**
     * Returns the CURDATE() minus interval of 1 week
     * 
     * @return  string
     */
    protected function getSQLCurrentDateMinusInterval1Week()
    {
        return 'CURDATE() - INTERVAL 1 WEEK';
    }
    
    /**
     * Returns the CURDATE()
     * 
     * @return  string
     */
    protected function getSQLCurrentDate()
    {
        return 'CURDATE()';
    }
    
    /**
     * Calculate the current date
     * 
     * @return  string
     */
    protected function calculateSQLCurrentDate()
    {
        if (!is_string($this->fetchPreviousPeriodData))
        {
            return $this->getSQLCurrentDate();
        }

        if ($this->fetchPreviousPeriodData == 'month')
        {
            return $this->getSQLCurrentDateOrWithMinusInterval1Month();
        }

        return $this->getSQLCurrentDate();
    }

    /**
     * Returns the WHERE statement depending on the filtering method
     * 
     * @param   array   $payload
     * 
     * @return  mixed
     */
    protected function getWhere($payload)
    {
        if (!isset($payload['method']))
        {
            return;
        }
        
        $methodName = 'get' . $payload['method'] . 'where';

        if (!method_exists($this, $methodName))
        {
            return;
        }
        
        return $this->$methodName($payload);
    }

    protected function getStrtotimeWithTz($value, $format = 'd/m/Y')
    {
        $date = $this->getDateWithTz();

        return date($format, strtotime($value, strtotime($date)));
    }

    private function getDateWithTz()
    {
		$hash = md5('firebox_analytics_date_with_tz');

		if ($date = wp_cache_get($hash))
		{
			return $date;
		}

        $timezone = \FPFramework\Helpers\Date::getTimezone();
        $tz = new \DateTimeZone($timezone);
        $date = (new \DateTime())->setTimezone($tz)->format('Y-m-d H:i:s');

        wp_cache_set($hash, $date);
        
        return $date;
    }

    
    abstract protected function getFilterWhere($payload);
    abstract protected function getCompareWhere($payload);
}