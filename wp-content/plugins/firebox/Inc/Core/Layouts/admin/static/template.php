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
$showcopyright = $this->data->get('settings.showcopyright');
?>
<?php firebox()->renderer->admin->render('static/header'); ?>
<div class="fpf-page-content padding-1">
	<?php do_action('firebox/admin_page_content'); ?>
</div>
<?php
fpframework()->renderer->admin->render('pages/footer', [
	'show_copyright' => $showcopyright,
	'plugin' => firebox()->_('FB_PLUGIN_NAME'),
	'plugin_version' => FBOX_VERSION . ' ' . ucfirst(FBOX_LICENSE_TYPE)
]);
?>
<?php firebox()->renderer->admin->render('static/footer'); ?>