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

namespace FireBox\Core\Blocks;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class FireBox extends Block
{
	/**
	 * Keep the old namespace for this block.
	 */
	protected $namespace = 'fireplugins';
	
	/**
	 * Block identifier.
	 * 
	 * @var  string
	 */
	protected $name = 'firebox';

	/**
	 * Block script.
	 * 
	 * @var  string
	 */
	protected $editor_script = 'fb-block-firebox';
	
	/**
	 * Keywords that will be used in search results.
	 * 
	 * @var  array
	 */
	protected $keywords = [
		'popup',
		'pop up',
		'optin',
		'box'
	];

	/**
	 * Registers block assets.
	 * 
	 * @return  void
	 */
	public function assets()
	{
		wp_register_script(
			'fb-block-firebox',
			FBOX_MEDIA_ADMIN_URL . 'js/blocks/firebox.js',
			['wp-i18n', 'wp-blocks', 'wp-editor', 'wp-components', 'wp-api-fetch'],
			FBOX_VERSION,
			true
		);
	}
}