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

class DisplayConditions
{
	/**
	 * Holds the Display Conditions Settings
	 * 
	 * @return  array
	 */
	public function getSettings()
	{
		$settings = [
			'title' => firebox()->_('FB_DISPLAY_CONDITIONS'),
			'content' => [
				'general' => [
					'fields' => [
						[
							'name' => 'display_conditions_type',
							'type' => 'Toggle',
							'label' => firebox()->_('FB_DISPLAY_POPUP'),
							'description' => firebox()->_('FB_DISPLAY_POPUP_DESC'),
							'default' => 'all',
							'choices' => [
								'all' => firebox()->_('FB_DISPLAY_CONDITIONS_TYPE_ALL_PAGES'),
								'mirror' => firebox()->_('FB_DISPLAY_CONDITIONS_TYPE_MIRROR'),
								'custom' => firebox()->_('FB_DISPLAY_CONDITIONS_TYPE_CUSTOM')
							]
						],
						[
							'name' => 'mirror_box',
							'type' => 'Dropdown',
							'label' => firebox()->_('FB_POPUP'),
							'description' => firebox()->_('FB_MIRROR_POPUP_SELECT_DESC'),
							'default' => 1,
							'class' => ['fpf-flex-row-fields'],
							'description_class' => ['bottom'],
							'input_class' => ['fullwidth'],
							'choices' => BoxHelper::getAllMirrorBoxesExceptID(get_the_ID()),
							'showon' => '[display_conditions_type]:mirror'
						],
						[
							'name' => 'rules',
							'type' => 'ConditionBuilder',
							'showon' => '[display_conditions_type]:custom',
							'plugin' => 'FPF_FIREBOX',
							
							'exclude_rules' => [
								'Date\Date',
								'Date\Day',
								'Date\Month',
								'Date\Time',
								'WP\UserID',
								'WP\UserGroup',
								'WP\Tags',
								'WP\Categories',
								'WP\CustomPostTypes',
								'WP\Language',
								'Device',
								'Browser',
								'OS',
								'Geo\City',
								'Geo\Country',
								'Geo\Region',
								'Geo\Continent',
								'FireBox\Popup',
								'FireBox\Form',
								'Referrer',
								'IP',
								'Pageviews',
								'Cookie',
								'PHP',
								'TimeOnSite',
								'NewReturningVisitor'
							],
							'exclude_rules_pro' => true,
							
							
						],
					]
				]
			]
		];

		return apply_filters('firebox/box/settings/display_conditions/edit', $settings);
	}
}