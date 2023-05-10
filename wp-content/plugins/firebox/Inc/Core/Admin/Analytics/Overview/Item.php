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

namespace FireBox\Core\Admin\Analytics\Overview;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Item
{
    /**
     * Metrics of the Overview Item
     * 
     * @var  array
     */
    protected $metrics;

    /**
     * Toolbar Items of the Overview Item
     * 
     * @var  array
     */
    protected $toolbar_items;

    /**
     * Other Data of the Overview Item
     * 
     * @var  array
     */
    protected $other_data;

    /**
     * Overview Item Data
     * 
     * @var  array
     */
    protected $overview_item_data;
    
    public function __construct($overview_item_data = null)
    {
        $this->overview_item_data = $overview_item_data;

        $this->toolbar_items = isset($this->overview_item_data['toolbar_items']) ? $this->overview_item_data['toolbar_items'] : [];
        $this->metrics = isset($this->overview_item_data['metrics']) ? $this->overview_item_data['metrics'] : [];
        $this->other_data = isset($this->overview_item_data['other_data']) ? $this->overview_item_data['other_data'] : [];
    }

    /**
     * Returns all Overview Item data
     * 
     * @return  array
     */
    public function getData()
    {
        $item_data = [];

        if (method_exists($this, 'getItemData'))
        {
            $item_data = $this->getItemData();
        }
        
        $data = array_merge($this->getCommonData(), $item_data);

        $data['show_total'] = isset($this->overview_item_data['show_total']) ? $this->overview_item_data['show_total'] : true;

        $show_percentage = isset($this->overview_item_data['show_percentage']) ? $this->overview_item_data['show_percentage'] : true;
        if (!$show_percentage)
        {
            $data['percentage_change'] = 0;
        }

        return $data;
    }

    /**
     * Returns all common data
     * 
     * @return  array
     */
    private function getCommonData()
    {
        return [
            'overview_item_name' => isset($this->overview_item_data['overview_item_name']) ? $this->overview_item_data['overview_item_name'] : '',
            'overview_type' => isset($this->overview_item_data['overview_type']) ? $this->overview_item_data['overview_type'] : '',
            'redirect_base' => isset($this->overview_item_data['redirect_base']) ? $this->overview_item_data['redirect_base'] : false,
            'show_overlay_message' => isset($this->overview_item_data['show_overlay_message']) ? $this->overview_item_data['show_overlay_message'] : false,
            'class' => isset($this->overview_item_data['class']) ? $this->overview_item_data['class'] : '',
        ];
    }
}