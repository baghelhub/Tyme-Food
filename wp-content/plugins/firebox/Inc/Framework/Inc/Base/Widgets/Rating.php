<?php
/**
 * @package         FirePlugins Framework
 * @version         1.1.57
 * 
 * @author          FirePlugins <info@fireplugins.com>
 * @link            https://www.fireplugins.com
 * @copyright       Copyright © 2023 FirePlugins All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

namespace FPFramework\Base\Widgets;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

/**
 *  The Rating Widget
 */
class Rating extends Widget
{
	/**
	 * Widget default options
	 *
	 * @var array
	 */
	protected $widget_options = [
		// The SVG icon representing the rating icon. Available values: check, circle, flag, heart, smiley, square, star, thumbs_up
		'icon' => 'star',

		// The default value of the widget. 
		'value' => 0,

		// How many stars to show?
		'max_rating' => 5,

		// Whether to show half ratings
		'half_ratings' => false,

		// The size of the rating icon in pixels.
		'size' => 24,

		// The color of the icon in the default state
		'selected_color' => '#f6cc01',

		// The color of the icon in the selected and hover state
		'unselected_color' => '#bdbdbd'
	];

	/**
	 * Class constructor
	 *
	 * @param array $options
	 */
	public function __construct($options = [])
	{
		parent::__construct($options);

		$this->options['value'] = $this->options['value'] > $this->options['max_rating'] ? $this->options['max_rating'] : $this->options['value'];
		$this->options['icon_url'] = FPF_MEDIA_URL . 'public/images/svg/rating/' . $this->options['icon'] . '.svg';
		$this->options['max_rating'] = $this->options['half_ratings'] ? 2 * $this->options['max_rating'] : $this->options['max_rating'];
	}
}