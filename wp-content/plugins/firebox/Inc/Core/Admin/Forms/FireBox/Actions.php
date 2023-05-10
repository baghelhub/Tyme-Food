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

namespace FireBox\Core\Admin\Forms\FireBox;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use FireBox\Core\Helpers\BoxHelper;

class Actions
{
	/**
	 * Holds the Actions Settings
	 * 
	 * @return  array
	 */
	public function getSettings()
	{
		$boxes = BoxHelper::getAllMirrorBoxesExceptID(get_the_ID());

		// if we are editing a box, replace its name in the list with `This Box`
		if (isset($_GET['post']))
		{
			$popup = \intval($_GET['post']);
			$boxes[$popup] = firebox()->_('FB_THIS_BOX') . '(' . $popup . ')';
		}
		
		return [
			'title' => firebox()->_('FB_METABOX_ACTIONS'),
			'content' => [
				'actions' => [
					'wrapper' => [
						'class' => ['grid-x', 'grid-margin-y']
					],
					'fields' => [
						[
							'type' => 'Alert',
							'class' => ['margin-bottom-1'],
							'input_class' => ['primary', 'flex-container'],
							'right_action' => '<a href="https://www.fireplugins.com/docs/firebox/the-popup-editor/working-with-actions"><i class="dashicons dashicons-info"></i>' . fpframework()->_('FPF_HELP') . '</a>',
							'text' => firebox()->_('FB_ACTIONS_ALERT_DESC')
						],
						
						
						[
							'type' => 'Pro',
							'feature_label' => firebox()->_('FB_METABOX_ACTIONS'),
							'class' => [ 'text-center', 'margin-top-1' ]
						],
						
					]
				]
			]
		];
	}
}