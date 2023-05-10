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

namespace FireBox\Core\Blocks\Generic;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Column extends \FireBox\Core\Blocks\Block
{
	/**
	 * Block identifier.
	 * 
	 * @var  string
	 */
	protected $name = 'column';

	/**
	 * Gutenberg Editor block script.
	 * 
	 * @var  string
	 */
	protected $editor_script = 'fb-block-column';
	
	/**
	 * Registers Gutenberg Editor block assets.
	 * 
	 * @return  void
	 */
	public function assets()
	{
		wp_register_script(
			'fb-block-column',
			FBOX_MEDIA_ADMIN_URL . 'js/blocks/blocks/column.js',
			['wp-i18n', 'wp-blocks', 'wp-editor', 'wp-components', 'wp-api-fetch'],
			FBOX_VERSION,
			true
		);
	}
}