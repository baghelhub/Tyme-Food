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

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

if (!$this->data->get('readonly') && !$this->data->get('disabled'))
{
	wp_register_script(
		'fpframework-rating-widget',
		FPF_MEDIA_URL . 'public/js/widgets/rating.js',
		[],
		FPF_VERSION,
		true
	);
	wp_enqueue_script('fpframework-rating-widget');
}

if ($this->data->get('load_stylesheet'))
{
	wp_register_style(
		'fpframework-rating-widget',
		FPF_MEDIA_URL . 'public/css/widgets/rating.css',
		[],
		FPF_VERSION,
		false
	);
	wp_enqueue_style('fpframework-rating-widget');
}

if ($this->data->get('load_css_vars'))
{
	wp_add_inline_style('fpframework-rating-widget', '
		.fpf-rating-wrapper.' . esc_attr($this->data->get('id')) . ' {
			--rating-selected-color: ' . esc_attr($this->data->get('selected_color')) . ';
			--rating-unselected-color: ' . esc_attr($this->data->get('unselected_color')) . ';
			--rating-size: ' . esc_attr($this->data->get('size')) . 'px;
		}
	');
}

require __DIR__ . '/rating_' . ($this->data->get('half_ratings') ? 'half' : 'default') . '.php';