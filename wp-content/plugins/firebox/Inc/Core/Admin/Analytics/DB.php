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

class DB
{
    /**
     * Returns box results from the database given a payload
     * 
     * @param   array  $payload
     * 
     * @return  array
     */
    public function getBoxResults($payload)
    {
        if (!$payload)
        {
            return [];
        }

        if (!isset($payload['select']))
        {
            return [];
        }
        
        return firebox()->tables->box->getResults($payload, false, false);
    }

    /**
     * Returns results from the database given a payload
     * 
     * @param   array  $payload
     * 
     * @return  array
     */
    public function getResults($payload)
    {
        if (!$payload)
        {
            return [];
        }

        if (!isset($payload['select']))
        {
            return [];
        }

        $table = $this->getTable($payload, 'boxlog');
        
        return firebox()->tables->$table->getResults($payload, false, false, ARRAY_A);
    }

    /**
     * Returns the table to fetch data.
     * 
     * @param   array   $payload
     * @param   string  $fallback
     * 
     * @return  string
     */
    private function getTable($payload = [], $fallback = '')
    {
        return isset($payload['table']) && !empty($payload['table']) ? $payload['table'] : $fallback;
    }
}