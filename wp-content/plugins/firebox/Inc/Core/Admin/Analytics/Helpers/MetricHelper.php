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

class MetricHelper
{
    /**
     * Adds date data to the dates period at given position(index)
     * 
     * @param   array  $dates
     * @param   int    $index
     * @param   array  $date_data
     * 
     * @return  array
     */
    public static function insertDateDataAtPosition($dates, $index, $date_data)
    {
        if (!$dates)
        {
            $dates = [];
        }
        
        if (!is_int($index) || !$date_data)
        {
            return [];
        }

        if (!is_array($dates))
        {
            return [];
        }

        $size = count($dates);
        if (!is_int($index) || $index < 0 || $index > $size)
        {
            return $dates;
        }
        
        $temp   = array_slice($dates, 0, $index);
        $temp[] = $date_data;
        return array_merge($temp, array_slice($dates, $index, $size));
    }

    /**
     * Adds missing dates to the data in order to have a consistent chart graph
     * 
     * @param   array  $dates
     * @param   array  $payload
     * @param   array  $format
     * 
     * @return  void
     */
    public static function fillMissingData($dates, $payload, $format = 'Y-m-d')
    {
        if (!$payload)
        {
            return [];
        }
        
        if (!is_array($dates))
        {
            return [];
        }

        if (!isset($payload['start_date']) && !isset($payload['total_days']))
        {
            return $dates;
        }

        $start_date = $payload['start_date'];
        $total_days = $payload['total_days'];

        if ($total_days < 0)
        {
            return $dates;
        }

        

        // find the period between start date and total days and fill missing dates
        $start_expl = explode('/', $start_date);

        $start = new \DateTime();
        $start->setDate($start_expl[2], $start_expl[1], $start_expl[0]);

        $end = clone $start;
        $end->add(new \DateInterval('P' . $total_days . 'D'));

        // add 1 extra hour to the custom date range in order to be able to get the last day in the data.
        if ($payload['options_key'] == 'custom')
        {
            $end->add(new \DateInterval('P1D'));
        }
        
        $end = $end->format('Y-m-d');

        $period = new \DatePeriod(
            new \DateTime($start->format('Y-m-d')),
            new \DateInterval('P1D'),
            new \DateTime($end)
        );

        return self::composeFinalDatesData('dates', $period, $dates, $format);
    }

    /**
     * Composes the final data array either with all dates in a period
     * or will all hours in a day.
     * 
     * @param   string  $type
     * @param   array   $period
     * @param   array   $date_data
     * @param   array   $format
     * 
     * @return  array
     */
    private static function composeFinalDatesData($type, $period, $date_data, $format = 'd/m/Y')
    {
        $index = 0;
        foreach ($period as $key => $value)
        {
            // get the current date or hour
            $date_item = $type == 'dates' ? $value->format($format) : $value['label'];
            
            if (self::dateInPeriodDataExists($date_item, $date_data))
            {
                $index++;
                continue;
            }

            $data = [
                'label' => $date_item,
                'total' => 0
            ];
            
            $date_data = self::insertDateDataAtPosition($date_data, $index, $data);

            $index++;
        }
        
        return $date_data;
    }

    

    /**
     * Checks whether the date exists in given period of dates
     * 
     * @param   string   $date
     * @param   array    $dates
     * 
     * @return  boolean 
     */
    public static function dateInPeriodDataExists($date, $dates)
    {
        if (!$date || !$dates)
        {
            return false;
        }

        if (!is_array($dates))
        {
            return false;
        }

        if (!is_string($date))
        {
            return false;
        }
        
        foreach ($dates as $key => $value)
        {
            if (!isset($value))
            {
                continue;
            }

            $value = (array) $value;

            if (!isset($value['label']))
            {
                continue;
            }

            if ($value['label'] == $date)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Prepares the hour:minute given in the data by appling the timezone of the site.
     * 
     * @param   string  $period
     * @param   array   $data
     * 
     * @return  array
     */
    public static function prepareDates($period, $data)
    {
        if ($period !== 'today')
        {
            return $data;
        }

        $timezone = \FPFramework\Helpers\Date::getTimezone();
        $tz = new \DateTimeZone($timezone);

        foreach ($data as $key => &$value)
        {
            if (!isset($value->label))
            {
                continue;
            }
            
            $date = \DateTime::createFromFormat(\DateTime::ISO8601, '2222-01-01T' . $value->label . ':00Z');
            if (!$date)
            {
                continue;
            }
            
            $value->label = $date->setTimezone($tz)->format('H:i');
        }
        
        return $data;
    }
}