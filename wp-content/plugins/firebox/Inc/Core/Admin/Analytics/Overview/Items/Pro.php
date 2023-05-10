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

class Pro extends Item
{
    /**
     * Returns all Overview Item data
     * 
     * @return  array
     */
    public function getItemData()
    {
		$image = isset($this->overview_item_data['image']) ? $this->overview_item_data['image'] : '';
		
		return [
			'image' => $image,
			'message' => $this->overview_item_data['message'],
			'feature' => $this->overview_item_data['feature'],
			'class' => $this->overview_item_data['class'],
		];
	}
}