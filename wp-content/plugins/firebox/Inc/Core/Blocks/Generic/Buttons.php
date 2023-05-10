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

class Buttons extends \FireBox\Core\Blocks\Block
{
	/**
	 * Block identifier.
	 * 
	 * @var  string
	 */
	protected $name = 'buttons';

	/**
	 * Gutenberg Editor block style.
	 * 
	 * @var  string
	 */
	protected $editor_style = 'fb-block-buttons';
	
	/**
	 * Gutenberg Editor block script.
	 * 
	 * @var  string
	 */
	protected $editor_script = 'fb-block-buttons';

	/**
	 * Registers block assets.
	 * 
	 * @return  void
	 */
	public function public_assets()
	{
		wp_register_style(
			'fb-block-buttons',
			FBOX_MEDIA_PUBLIC_URL . 'css/blocks/buttons.css',
			[],
			FBOX_VERSION
		);
	}

	public function render_callback($atts, $content)
	{
		wp_enqueue_style('fb-block-buttons');

		return $content;
	}
	
	/**
	 * Registers Gutenberg Editor block assets.
	 * 
	 * @return  void
	 */
	public function assets()
	{
		wp_register_script(
			'fb-block-buttons',
			FBOX_MEDIA_ADMIN_URL . 'js/blocks/blocks/buttons.js',
			['wp-i18n', 'wp-blocks', 'wp-editor', 'wp-components', 'wp-api-fetch'],
			FBOX_VERSION,
			true
		);
	}
}