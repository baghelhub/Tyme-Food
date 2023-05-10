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

namespace FireBox\Core\Admin\Analytics\Overview\Items;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use FireBox\Core\Admin\Analytics\Overview\Item;
use FireBox\Core\Admin\Analytics\Helpers\AnalyticsHelper;
use FireBox\Core\Admin\Analytics\Helpers\ToolbarHelper;

class Chart extends Item
{
    /**
     * Returns all Overview Item data
     * 
     * @return  array
     */
    public function getItemData()
    {
        $metric_data = AnalyticsHelper::getData($this->metrics, $this->toolbar_items, $this->other_data);

        $metric_data['metrics_url_safe'] = ToolbarHelper::dataToURLParam('metrics', $this->metrics);
        $metric_data['total'] = $metric_data['current_period']['total'];

        return $metric_data;
    }
}