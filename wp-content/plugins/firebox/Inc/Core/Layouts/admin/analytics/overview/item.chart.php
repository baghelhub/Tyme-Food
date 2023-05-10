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
$item = new \FPFramework\Libs\Registry($this->data);

$suffix = $item->get('suffix', '');
$decimal_points = $item->get('decimal_points', 0);
$color = $item->get('color', '');
?>
<canvas
    class="firebox-analytics-overview-chart chart"
    data-chart-suffix="<?php echo esc_attr($suffix); ?>"
    data-chart-decimal-points="<?php echo esc_attr($decimal_points); ?>"
    data-chart-colors="<?php echo esc_attr($color); ?>"
    data-chart-data="<?php echo esc_attr(json_encode($item->get('current_period.data'))); ?>"></canvas>