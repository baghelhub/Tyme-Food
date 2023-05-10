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
$left_items = $this->data->get('top_bar_items.left.items');
$right_items = $this->data->get('top_bar_items.right.items');
?>
<div class="fb-top-bar padding-1">
	<div class="items left">
		<a href="<?php echo admin_url('admin.php?page=firebox'); ?>" class="top-bar-logo"><img src="<?php echo FBOX_MEDIA_ADMIN_URL . 'images/logo_full.svg'; ?>" alt="FireBox Logo"></a>
		<?php
		if (is_array($left_items) && count($left_items))
		{
			firebox()->renderer->admin->render('dashboard/TopBarNavigation/top_bar_item', ['items' => $left_items]);
		}
		?>
	</div>
	<?php if (is_array($right_items) && count($right_items)): ?>
	<div class="items right">
		<?php
		firebox()->renderer->admin->render('dashboard/TopBarNavigation/top_bar_item', ['items' => $right_items]);
		?>
	</div>
	<?php endif; ?>
</div>