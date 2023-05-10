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
$nonce_name = $this->data->get('configuration.nonce_name');
$nonce_value = $this->data->get('configuration.nonce_value');
$filters = $this->data->get('filters');
?>
<div class="overview-filters-wrapper">
	<?php
	foreach ($filters as $key => $value)
	{
		$value = (array) $value;
		$items = isset($value['items']) ? $value['items'] : false;
		$item = isset($value['item']) ? $value['item'] : '';
		$default_label = $value['default_label'];
		$item_class = $extra_atts = '';

		
		if (strpos($key, '_pro') !== false)
		{
			$item_class = ' fpf-modal-opener';
			$extra_atts = ' data-fpf-modal-item="' . esc_attr($item) . '" data-fpf-modal="#fpfUpgradeToPro"';
		}
		
		?>
		<div class="overview-filter-item" data-filter="<?php echo esc_attr($key); ?>">
			<span class="filter-title<?php echo esc_attr($item_class); ?>"<?php echo wp_kses_data($extra_atts); ?>><span class="filter-title-label"><?php echo esc_html($default_label); ?></span><span class="icon dashicons dashicons-arrow-down-alt2"></span></span>
			<?php
			
			?>
		</div>
		<?php
	}
	?>
    <input type="hidden" class="nonce_hidden" name="<?php echo esc_attr($nonce_name); ?>" value="<?php echo esc_attr($nonce_value); ?>" />
</div>