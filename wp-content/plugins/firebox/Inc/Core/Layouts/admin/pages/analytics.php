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
// Analytics


$data = [
    'image' => FBOX_MEDIA_ADMIN_URL . 'images/analytics.png',
    'feature' => fpframework()->_('FPF_ANALYTICS'),
    'class' => 'analytics-main-page overlay-bg margin-top-2',
    'overview_title' => 'test',
    'show_overlay_message' => true
];
\FPFramework\Helpers\HTML::renderImageProFeature($data);

?>