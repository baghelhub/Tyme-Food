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
<div id="firebox-analytics">
    <div class="firebox-analytics-inner">
        <div class="firebox-analytics-top">
            <h2 class="title"><?php echo esc_html(fpframework()->_('FPF_ANALYTICS')); ?></h2>
            <p class="description"><?php echo esc_html(firebox()->_('FB_ANALYTICS_TOP_DESC')); ?></p>
        </div>

        <?php
        
        ?>
        
        <!-- FireBox Analytics Chart Wrapper -->
        <div class="firebox-analytics-chart-wrapper">
            <?php
            

            // Render Analytics Chart
            do_action('firebox/analytics/chart');
            ?>
        </div>
        <!-- /FireBox Analytics Chart -->

        <?php
        
        ?>
    </div>
</div>