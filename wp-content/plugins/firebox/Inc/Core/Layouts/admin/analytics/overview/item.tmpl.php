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

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}
?>
<div class="overview-item template" data-overview-item-name="">
    <div class="overview-item-inner">
        <div class="top">
            <h2 class="title"><a href="<?php echo admin_url('admin.php?page=firebox-analytics'); ?>"></a></h2>
            <h3 class="total"></h3>
        </div>
        <div class="details">
            <div class="percentage" title="<?php echo esc_html(fpframework()->_('FPF_PERCENTAGE_CHANGE_OVER_PREVIOUS_PERIOD')); ?>"></div>
        </div>
        <div class="overview-content-outer-wrapper">
            <div class="overview-content-outer"></div>
            <div class="overview-message" data-no-data="<?php echo esc_attr(fpframework()->_('FPF_NO_DATA')); ?>"></div>
        </div>
    </div>
</div>