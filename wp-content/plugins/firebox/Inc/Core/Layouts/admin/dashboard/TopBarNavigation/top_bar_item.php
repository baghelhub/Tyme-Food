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

if (!is_array($this->data->get('items')))
{
	return;
}

foreach ($this->data->get('items') as $item)
{
	$onclick = isset($item['onclick']) ? $item['onclick'] : '';
	$onclickAttribute = !empty($onclick) ? ' onclick="' . esc_attr($onclick) . '"' : '';
	$url = isset($item['url']) ? $item['url'] : '#';
	$target = isset($item['target']) ? $item['target'] : '';
	?>
	<a href="<?php echo esc_url($url); ?>" class="fpf-button small top-bar-btn"<?php echo !empty($target) ? ' target="' . esc_attr($target) . '"' : ''; ?><?php echo wp_kses_data($onclickAttribute); ?>>
		<span class="icon dashicons <?php echo esc_attr($item['icon']); ?>"></span>
		<span class="text"><?php echo esc_html(fpframework()->_($item['label'])); ?></span>
	</a>
	<?php
}