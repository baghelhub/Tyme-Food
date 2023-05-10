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

class ResultsHelper
{
	/**
	 * Sumarize the total metrics from a set of results
	 * 
	 * @param   array  $results
	 * 
	 * @return  int
	 */
    public static function sumTotalFromResults($results)
    {
		if (!$results)
		{
			return 0;
        }

        if (!is_array($results))
        {
            return 0;
        }

        if (!count($results))
        {
            return 0;
        }

        $sum = array_reduce($results, function($total, $res)
        {
            $res = (array) $res;

			if (!isset($res['total']))
			{
				return $total += 0;
			}

            return $total += (float) $res['total'];
        });

        return $sum;
    }
}