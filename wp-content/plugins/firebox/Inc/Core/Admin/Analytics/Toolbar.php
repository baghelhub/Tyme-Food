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

class Toolbar
{
    

    /**
     * The default Toolbar Item
     * 
     * @var  string
     */
    const default_toolbar_item = 'date';

    /**
     * Configuration data
     * 
     * @var array
     */
    private $configuration;

    /**
     * Toolbar Items
     * 
     * @var  array
     */
    private $settings;

    /**
     * Selected Toolbar Items
     * 
     * @var  array
     */
    private $selectedToolbarItems = null;

    /**
     * Default toolbar items.
     * 
     * @var  array
     */
    private $defaultToolbarItems = [
        'Box',
        'Country',
        'Date',
        'Device',
        'Event',
        'Page',
        'Referrer'
    ];

    /**
     * Toolbar Items Classes Objects
     * 
     * @var  array
     */
    private $toolbarItems;

    /**
     * Which toolbar item we currently edited
     * 
     * @var  string
     */
    private $editing_toolbar_item;

    /**
     * DB
     * 
     * @var  DB
     */
    private $db;

    /**
     * Toolbar Constructor
     * 
     * @param   array    $db
     * @param   array    $selectedToolbarItems
     * @param   array    $toolbarItems
     * 
     * @return  void
     */
    public function __construct($db = null, $selectedToolbarItems = null, $toolbarItems = null)
    {
        $this->configuration = firebox()->analytics_configuration;
        $this->db = $db;

        $this->selectedToolbarItems = $selectedToolbarItems;
        
        if (!$toolbarItems)
        {
            $toolbarItems = $this->getNewToolbarItems();
        }
        $this->toolbarItems = $toolbarItems;

        $this->setSelectedToolbarItems($this->selectedToolbarItems);

        
    }

    

    /**
     * Retrieves the currently selected Toolbar Items
     * 
     * @return  array
     */
    public function setSelectedToolbarItems($selected_toolbar_items = [])
    {
        if (!$selected_toolbar_items)
        {
            $selected_toolbar_items = $this->getDefaultToolbarItems();
        }
        
        

        // validate and set other toolbar items data
        foreach ($selected_toolbar_items as $key => &$value)
        {
            if (!$key)
            {
                continue;
            }

            if (empty($value))
            {
                unset($selected_toolbar_items[$key]);
                continue;
            }

            // ensure only valid toolbar items are processed
            if (!isset($this->toolbarItems[$key]))
            {
                unset($selected_toolbar_items[$key]);
                continue;
            }

            
        }

        // add date if not exist
        $this->checkAndAddDateToolbarItem($selected_toolbar_items);

        $this->selectedToolbarItems = $selected_toolbar_items;
    }

    public function getSelectedToolbarItems()
    {
        return $this->selectedToolbarItems;
    }

    /**
     * Adds the date toolbar item at the front of the selected toolbar_items if it does not exist
     * 
     * @param   array  $selected_toolbar_items
     * 
     * @return  void
     */
    private function checkAndAddDateToolbarItem(&$selected_toolbar_items)
    {
        if (!isset($selected_toolbar_items[self::default_toolbar_item]))
        {
            $selected_toolbar_items = $this->toolbarItems[self::default_toolbar_item]->getDefaultToolbarItemData() + $selected_toolbar_items;
        }
    }

    

    /**
     * Default Selected Toolbar Items
     * 
     * @return  array
     */
    private function getDefaultSelectedToolbarItems()
    {
        return [
            'toolbar_items' => $this->getDefaultToolbarItems(),
            'editing_toolbar_item' => self::default_toolbar_item
        ];
    }

    /**
     * Returns the default Toolbar Items
     * - Date - Filter : This Month
     * 
     * @return  array
     */
    public function getDefaultToolbarItems()
    {
        return [
            'date' => [
                'method' => 'filter',
                'options_key' => 'this_month',
            ]
        ];
    }

    /**
     * Re-initialize all toolbar items
     * 
     * @return  array
     */
    public function getNewToolbarItems()
    {
        if (!empty($this->toolbarItems))
        {
            return $this->toolbarItems;
        }
        
        $items = [];

        foreach ($this->defaultToolbarItems as $toolbar_class_name)
        {
            // instantiate class
            $className = '\FireBox\Core\Admin\Analytics\Toolbar\\' . $toolbar_class_name;

            if (!class_exists($className))
            {
                continue;
            }
            
            $items[strtolower($toolbar_class_name)] = new $className($this->db, $this->configuration, $this->getSelectedToolbarItems());
        }

        return $items;
    }

    /**
     * Set the Toolbar Items
     * 
     * @param   array  $items
     * 
     * @return  array
     */
    public function setToolbarItems($items = [])
    {
        $this->toolbarItems = $items;
    }

    /**
     * Returns the Toolbar Items
     * 
     * @return  array
     */
    public function getToolbarItems()
    {
        return $this->toolbarItems;
    }

    /**
     * Returns the toolbar settings
     * 
     * @return  array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    public function setSelectedToolbarItemsValue($value)
    {
        $this->selectedToolbarItems = $value;
    }

    public function setEditingToolbarItem($editing_toolbar_item)
    {
        $this->editing_toolbar_item = $editing_toolbar_item;
    }
    
    public function getConfiguration()
    {
        return $this->configuration;
    }
}