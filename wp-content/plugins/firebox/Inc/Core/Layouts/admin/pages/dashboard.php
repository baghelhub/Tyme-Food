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
// Main Buttons
if ($this->data->get('main_buttons', []))
{
	?>
	<ul class="fb-main-buttons">
	<?php
	foreach($this->data->get('main_buttons') as $btn)
	{
		$target = isset($btn['target']) ? ' target="' . esc_attr($btn['target']) . '"' : '';
		$class = isset($btn['li_class']) ? ' class="' . esc_attr($btn['li_class']) . '"' : '';
		?>
		<li<?php echo wp_kses_data($class); ?>>
			<a href="<?php echo esc_url($btn['url']); ?>"<?php echo wp_kses_data($target); ?>>
				<span class="icon dashicons <?php echo esc_attr($btn['icon']); ?>"></span>
				<span><?php echo esc_html($btn['label']); ?></span>
			</a>
		</li>
		<?php
	}
	?>
	</ul>
	<?php
}
do_action('firebox/dashboard/content');
?>