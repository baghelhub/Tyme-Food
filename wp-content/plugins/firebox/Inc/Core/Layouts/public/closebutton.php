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
$btnSource = is_string($this->data->get('box.params.data.closebutton.source', 'icon')) ? $this->data->get('box.params.data.closebutton.source', 'icon') : 'icon';
$size      = is_string($this->data->get('box.params.data.closebutton.size', null)) || is_int($this->data->get('box.params.data.closebutton.size', null)) ? (int) $this->data->get('box.params.data.closebutton.size', null) : null;
?>
<button type="button" data-fbox-cmd="close" class="fb-close" aria-label="Close">
	<?php if ($btnSource == "image") { ?>
		<img src="<?php echo esc_url($this->data->get('box.params.data.closebutton.image')); ?>"/>
	<?php } else { ?>
		<svg width="<?php esc_attr_e($size); ?>" height="<?php esc_attr_e($size); ?>" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path style="transform: translate(25%, 25%);" fill-rule="evenodd" clip-rule="evenodd" d="M24 3.6L20.4 0L11.9998 8.40022L3.59999 0.000423898L0 3.60042L8.39978 12.0002L1.69741e-05 20.4L3.60001 24L11.9998 15.6002L20.4 24.0004L23.9999 20.4004L15.5998 12.0002L24 3.6Z" fill="currentColor"/></svg>
	<?php } ?>
</button>