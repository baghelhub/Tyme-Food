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

namespace FireBox\Core\Admin\Forms;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Settings
{
	/**
	 * All Settings for the FireBox Global Settings Page
	 * 
	 * @return  array
	 */
	public static function getSettings()
	{
		$settings = [
			'id' => 'FireBoxSettings',
			'vertical' => true,
			'tabs_menu_sticky' => true,
			'mobile_menu' => true,
			'show_tab_title' => true,
			'data' => [
				'general' => self::getGeneralSettings(),
				'advanced' => self::getAdvancedSettings(),
				'geolocation' => self::getGeolocationSettings(),
				'data' => self::getDataSettings(),
				'license_key' => self::getLicenseKeySettings(),
			]
		];

		return apply_filters('firebox/forms/settings/edit', $settings);
	}

	/**
	 * Holds the General Settings
	 * 
	 * @retun  array
	 */
	private static function getGeneralSettings()
	{
		return [
			'title' => 'FPF_GENERAL',
			'content' => [
				// Media
				'media' => [
					'title' => [
						'title' => 'FPF_MEDIA',
						'description' => firebox()->_('FB_SETTINGS_MEDIA_DESC')
					],
					'fields' => [
						[
							'name' => 'loadCSS',
							'type' => 'FPToggle',
							'label' => firebox()->_('FB_SETTINGS_LOAD_CSS'),
							'description' => firebox()->_('FB_SETTINGS_LOAD_CSS_DESC'),
							'checked' => true
						],
						[
							'name' => 'loadVelocity',
							'type' => 'FPToggle',
							'label' => firebox()->_('FB_SETTINGS_LOAD_VELOCITY'),
							'description' => firebox()->_('FB_SETTINGS_LOAD_VELOCITY_DESC'),
							'checked' => true
						]
					]
				],
				// Other
				'other' => [
					'title' => [
						'title' => 'FPF_OTHER',
						'description' => firebox()->_('FB_SETTINGS_OTHER_DESC')
					],
					'fields' => [
						[
							'name' => 'show_admin_bar_menu_item',
							'type' => 'FPToggle',
							'label' => firebox()->_('FB_SETTINGS_SHOW_ADMIN_BAR_MENU_ITEM'),
							'description' => firebox()->_('FB_SETTINGS_SHOW_ADMIN_BAR_MENU_ITEM_DESC'),
							'checked' => true
						],
						[
							'name' => 'showcopyright',
							'type' => 'FPToggle',
							'label' => firebox()->_('FB_SETTINGS_SHOW_COPYRIGHT'),
							'description' => firebox()->_('FB_SETTINGS_SHOW_COPYRIGHT_DESC'),
							'checked' => true
						],
						[
							'name' => 'debug',
							'type' => 'FPToggle',
							'label' => firebox()->_('FB_SETTINGS_DEBUG'),
							'description' => firebox()->_('FB_SETTINGS_DEBUG_DESC'),
						]
					]
				]
			]
		];
	}

	/**
	 * Holds the Advanced settings
	 * 
	 * @return  array
	 */
	private static function getAdvancedSettings()
	{
		return [
			'title' => 'FPF_ADVANCED',
			'content' => [
				// Analytics
				'analytics' => [
					'title' => [
						'title' => firebox()->_('FB_SETTINGS_ANALYTICS'),
						'description' => firebox()->_('FB_SETTINGS_ANALYTICS_DESC')
					],
					'fields' => [
						[
							'name' => 'stats',
							'type' => 'FPToggle',
							'checked' => true
						],
						[
							'name' => 'statsdays',
							'type' => 'Dropdown',
							'label' => firebox()->_('FB_SETTINGS_STATS_PERIOD'),
							'description' => firebox()->_('FB_SETTINGS_STATS_PERIOD_DESC'),
							'showon' => 'firebox_settings[stats]:1',
							'input_class' => ['small'],
							'default' => 180,
							'choices' => [
								180 => fpframework()->_('FPF_6_MONTHS'),
								365 => fpframework()->_('FPF_1_YEAR'),
								365 * 2 => fpframework()->_('FPF_2_YEARS'),
								365 * 3 => fpframework()->_('FPF_3_YEARS'),
								'custom' => fpframework()->_('FPF_CUSTOM'),
							]
						],
						[
							'name' => 'statsdays_custom',
							'type' => 'Number',
							'label' => firebox()->_('FB_SETTINGS_STATS_DAYS_CUSTOM'),
							'description' => firebox()->_('FB_SETTINGS_STATS_DAYS_CUSTOM_DESC'),
							'placeholder' => 1,
							'min' => 1,
							'step' => 1,
							'addon' => 'days',
							'input_class' => ['small'],
							'showon' => 'firebox_settings[stats]:1[AND]firebox_settings[statsdays]:custom',
						]
					]
				],
				// Google Analytics
				'google_analytics' => [
					'title' => [
						'title' => firebox()->_('FB_SETTINGS_GAT'),
						'description' => firebox()->_('FB_SETTINGS_GAT_DESC')
					],
					'fields' => [
						
						
						[
							'type' => 'Pro',
							'feature_label' => firebox()->_('FB_SETTINGS_GAT')
						]
						
					]
				],
				// API Key
				'api' => [
					'title' => [
						'title' => firebox()->_('FB_JSON_API'),
						'description' => firebox()->_('FB_JSON_API_DESC')
					],
					'fields' => [
						
						
						[
							'type' => 'Pro',
							'feature_label' => firebox()->_('FB_JSON_API')
						]
						
					]
				]
			]
		];
	}

	/**
	 * Holds the Geolocation settings
	 * 
	 * @return  array
	 */
	private static function getGeolocationSettings()
	{
		return [
			'title' => 'FPF_GEOLOCATION',
			'content' => [
				// Database
				'database' => [
					'title' => [
						'title' => 'FPF_GEOLOCATION_SERVICES',
						'description' => 'FPF_GEOIP_GEOLOCATION_SERVICES_HEADING_DESC'
					],
					'fields' => [
						
						
						[
							'type' => 'Pro',
							'feature_label' => 'FPF_GEOLOCATION_SERVICES'
						]
						
					]
				],
				// Lookup IP Address
				'geo_lookup' => [
					'title' => [
						'title' => 'FPF_GEOIP_LOOKUP',
						'description' => 'FPF_GEOIP_LOOKUP_DESC'
					],
					'fields' => [
						
						
						[
							'type' => 'Pro',
							'feature_label' => 'FPF_GEOIP_LOOKUP'
						]
						
					]
				]
			]
		];
	}

	/**
	 * Holds the Data settings
	 * 
	 * @return  array
	 */
	private static function getDataSettings()
	{
		return [
			'title' => 'FPF_DATA',
			'content' => [
				// Uninstall
				'keep_data_on_uninstall' => [
					'title' => [
						'title' => 'FPF_UNINSTALL',
						'description' => 'FPF_SETTINGS_UNINSTALL_DESC'
					],
					'fields' => [
						[
							'name' => 'keep_data_on_uninstall',
							'type' => 'FPToggle',
							'label' => 'FPF_KEEP_DATA_ON_UNINSTALL',
							'description' => 'FPF_KEEP_DATA_ON_UNINSTALL_DESC',
							'checked' => true
						],
					]
				]
			]
		];
	}

	/**
	 * Holds the License Key settings
	 * 
	 * @return  array
	 */
	private static function getLicenseKeySettings()
	{
		$plugin_name = firebox()->_(firebox()->_('FB_PLUGIN_NAME'));
		
		$status = '';
		$status_prefix = 'You\'re using ' . $plugin_name . ' ' . ucfirst(FBOX_LICENSE_TYPE) . ' - ';
		$enjoy = fpframework()->_('FPF_ENJOY') . '! <img role="img" class="emoji" alt="🙂" src="https://s.w.org/images/core/emoji/13.0.0/svg/1f642.svg" />';

		
		$status = $status_prefix . fpframework()->_('FPF_NO_LICENSE_NEEDED') . ' ' . $enjoy;
		

		

		return [
			'title' => 'FPF_LICENSE_KEY',
			'content' => [
				// License
				'license_key' => [
					'title' => [
						'title' => 'FPF_LICENSE',
						'description' => 'FPF_SETTINGS_LICENSE_DESC'
					],
					'fields' => [
						
						
						[
							'type' => 'Pro',
							'feature_label' => 'FPF_ACTIVATE_LICENSE'
						]
						
					]
				]
			]
		];
	}
}