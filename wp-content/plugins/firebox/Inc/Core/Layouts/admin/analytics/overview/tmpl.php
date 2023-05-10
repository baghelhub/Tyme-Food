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
$overview_items_names = $this->data->get('overview_items_names');
$default_filters = $this->data->get('default_filters');
?>
<!-- FireBox Analytics Overview -->
<div class="firebox-analytics-overview" data-overview-items-names="<?php echo esc_attr(json_encode($overview_items_names)); ?>" data-default-filters="<?php echo esc_attr(json_encode($default_filters)); ?>">
    <div class="overview-top">
        <h2 class="overview-title"><?php echo esc_html(firebox()->_('FB_ANALYTICS_OVERVIEW')); ?></h2>
        <?php echo do_action('firebox/analytics/overview/filters'); ?>
    </div>
    <?php firebox()->renderer->admin->render('analytics/overview/items'); ?>
    <div class="overview-footer">
        <a href="<?php echo admin_url('admin.php?page=firebox-analytics'); ?>"><?php echo fpframework()->_('FPF_ADVANCED_ANALYTICS'); ?></a>
    </div>
	<div class="overview-items-loader"><?php echo esc_html(fpframework()->_('FPF_ANALYTICS_OVERVIEW_LOADING')); ?></div>
</div>
<!-- /FireBox Analytics Overview -->