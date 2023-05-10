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

class Paragraph extends \FireBox\Core\Blocks\Block
{
	/**
	 * Block identifier.
	 * 
	 * @var  string
	 */
	protected $name = 'paragraph';

	/**
	 * Gutenberg Editor block style.
	 * 
	 * @var  string
	 */
	protected $editor_style = 'fb-block-paragraph';
	
	/**
	 * Gutenberg Editor block script.
	 * 
	 * @var  string
	 */
	protected $editor_script = 'fb-block-paragraph';
	
	/**
	 * Adds Google Fonts.
	 * 
	 * @param   array   $attributes
	 * @param   string  $content
	 * 
	 * @return  string
	 */
	public function render_callback($attributes, $content)
	{
		wp_enqueue_style('fb-block-paragraph');

		if (isset($attributes['blockFontType']) && isset($attributes['blockFontFamily']) && $attributes['blockFontType'] === 'google')
		{
			$fontWeight = isset($attributes['blockFontWeight']) ? $attributes['blockFontWeight'] : 400;
			$fontFamily = $attributes['blockFontFamily']['value'];
			
			$font = [
				'fontfamily' => $fontFamily,
				'fontvariants' => [$fontWeight]
			];

			\FPFramework\Libs\GoogleFontsRenderer::getInstance()->addFont($fontFamily, $font);
		}

		return $content;
	}
	
	/**
	 * Registers front-end block assets.
	 * 
	 * @return  void
	 */
	public function public_assets()
	{
		wp_register_style(
			'fb-block-paragraph',
			FBOX_MEDIA_PUBLIC_URL . 'css/blocks/paragraph.css',
			[],
			FBOX_VERSION,
			false
		);
	}

	/**
	 * Registers Gutenberg Editor block assets.
	 * 
	 * @return  void
	 */
	public function assets()
	{
		wp_register_script(
			'fb-block-paragraph',
			FBOX_MEDIA_ADMIN_URL . 'js/blocks/blocks/paragraph.js',
			['wp-i18n', 'wp-blocks', 'wp-editor', 'wp-components', 'wp-api-fetch'],
			FBOX_VERSION,
			true
		);
	}
}