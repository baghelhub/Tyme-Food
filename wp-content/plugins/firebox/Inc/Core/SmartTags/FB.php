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

namespace FireBox\Core\SmartTags;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class FB extends \FPFramework\Base\SmartTags\SmartTag
{
    /**
     * Returns the ID of the box
     * 
     * @return  string
     */
    public function getID()
    {
        if (!isset($this->data->ID))
        {
            return;
        }
        
        return $this->data->ID;
    }

    /**
     * Returns the title of the box
     * 
     * @return  string
     */
    public function getTitle()
    {
        if (!isset($this->data->post_title))
        {
            return;
        }

        return $this->data->post_title;
    }
}