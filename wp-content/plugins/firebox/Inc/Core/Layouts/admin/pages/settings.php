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
$class = $this->data->get('class') ? ' ' . $this->data->get('class') : '';
?>
<div class="fpf-settings-page<?php echo esc_attr($class); ?>">
	<?php do_action('firebox/settings_page'); ?>
</div>