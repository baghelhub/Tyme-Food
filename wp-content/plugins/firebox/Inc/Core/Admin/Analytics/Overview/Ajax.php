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

use FireBox\Core\Admin\Analytics\Helpers\OverviewHelper;

class Ajax
{
    /**
     * Overview
     * 
     * @var  Overview
     */
    private $overview;

    /**
     * Overview AJAX constructor
     * 
     * @param   Overview  $overview
     * 
     * @return  void
     */
    public function __construct($overview = null)
    {
		if (!wp_doing_ajax())
		{
			return;
		}
		
        add_action('wp_ajax_fb_analytics_overview_items_update', [$this, 'fb_analytics_overview_items_update']);
    }

    /**
     * Handles the update of the analytics overview items
     * 
     * @return  void
     */
    public function fb_analytics_overview_items_update()
    {
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';

        // verify user logged in and is admin
        if (!is_user_logged_in() || !current_user_can('manage_options'))
        {
            return false;
        }
        
        // verify nonce
        if (!$verify = wp_verify_nonce($nonce, 'fb-analytics-nonce'))
        {
            return false;
        }

        $this->overview = firebox()->analytics_overview;
        $this->overview->init();

		
		// get the default filters
		$selected_filter_data['date'] = 'this_month';
		

		

		$updating_overview_items = isset($_POST['updating_overview_items']) ? sanitize_text_field($_POST['updating_overview_items']) : [];
        $updating_overview_items = html_entity_decode(stripslashes($updating_overview_items));
        $updating_overview_items = json_decode($updating_overview_items, true);

		// validate updating overview items
		if (!$this->validateUpdatingOverviewItems($updating_overview_items))
		{
			return false;
		}

        $response = [
			'data' => $this->getOverviewItemsData($selected_filter_data, $updating_overview_items)
        ];

        echo json_encode($response);
        wp_die();
	}

	/**
	 * Retrieves all data for all given overview item names by applying the selected filters
	 * 
	 * @param   array  $selected_filter_data
	 * @param   array  $updating_overview_items
	 * 
	 * @return  array
	 */
	private function getOverviewItemsData($selected_filter_data, $updating_overview_items)
	{
		$data = [];

		$toolbar_items = $this->overview->getToolbar()->getToolbarItems();

		foreach ($this->overview->getOverviewItemsPayload() as $item_name => $overview_item_data)
		{
			$this->applyFiltersToOverviewItem($selected_filter_data, $toolbar_items, $overview_item_data);

			$data[$item_name] = OverviewHelper::getOverviewData([$item_name => $overview_item_data]);
		}

		return $data;
	}

	/**
	 * Applies filters to the overview items
	 * 
	 * @param   array  $selected_filter_data
	 * @param   array  $toolbar_items
	 * @param   array  $overview_item_data
	 * 
	 * @return  void
	 */
	private function applyFiltersToOverviewItem($selected_filter_data, $toolbar_items, &$overview_item_data)
	{
		// get toolbar items either by the overview item data or from the first source item(all source items have the same toolbar items)
		$toolbar_items_data = isset($overview_item_data['toolbar_items']) ? $overview_item_data['toolbar_items'] : (isset($overview_item_data['source']) ? $overview_item_data['source'][0]['toolbar_items'] : []);
		
		$allowed_filters = isset($overview_item_data['allowed_filters']) ? $overview_item_data['allowed_filters'] : [];

		foreach ($selected_filter_data as $key => $value)
		{
			// proceess only filters that are allowed in this overview item
			if (!in_array($key, $allowed_filters))
			{
				continue;
			}

			$toolbar_items_data[$key] = $toolbar_items[$key]->getFilterToolbarItemWithValue($value);
		}

		// handle overview items that have 1 source only
		if (isset($overview_item_data['toolbar_items']))
		{
			$overview_item_data['toolbar_items'] = $toolbar_items_data;
		}
		
	}

	
	
	/**
	 * Ensure the given overview item names are valid.
	 * 
	 * @param   array  $updating_overview_items
	 * 
	 * @return  void
	 */
	private function validateUpdatingOverviewItems(&$updating_overview_items)
	{
		if (!$updating_overview_items || !is_array($updating_overview_items))
		{
			return false;
		}
		
		$overview_items_names = $this->overview->getOverviewItemsNames();

		foreach ($updating_overview_items as $name)
		{
			if (!in_array($name, $overview_items_names))
			{
				unset($updating_overview_items[$name]);
			}
		}
		
		if (empty($updating_overview_items))
		{
			return false;
		}

		return true;
	}
}