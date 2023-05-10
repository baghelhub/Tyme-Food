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

namespace FireBox\Core\Admin\Menu;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use FPFramework\Admin\Menu\Menu as FrameworkMenu;

class PluginMenu extends FrameworkMenu
{
	/**
	 * Returns all Plugin menu items
	 * 
	 * @return  array
	 */
	public function getMenuItems()
	{
		return [
			[
				'page_title' => esc_html(firebox()->_('FB_PLUGIN_NAME')),
				'menu_title' => esc_html(firebox()->_('FB_PLUGIN_NAME')),
				'menu_slug'	 => 'firebox',
				'icon_url'	 => FBOX_MEDIA_ADMIN_URL . 'images/logo_white.svg',
				'position'	 => 80,
				'controller' => 'FireBox\\Core\\Controllers\\Dashboard',
				'is_parent'  => true
			],
			[
				'page_title' => esc_html(fpframework()->_('FPF_DASHBOARD')),
				'menu_title' => esc_html(fpframework()->_('FPF_DASHBOARD')),
				'menu_slug'	 => 'firebox'
			],
			[
				'render_callback' => false,
				'page_title' => esc_html(firebox()->_('FB_NEW_POPUP')),
				'menu_title' => esc_html(firebox()->_('FB_NEW_POPUP')),
				'menu_slug'	 => 'post-new.php?post_type=firebox'
			],
			[
				'render_callback' => false,
				'menu_title' => esc_html(firebox()->_('FB_POPUPS')),
				'menu_slug'	 => 'edit.php?post_type=firebox'
			],
			[
				'page_title' => esc_html(firebox()->_('FB_ANALYTICS_PAGE_TITLE')),
				'menu_title' => esc_html(fpframework()->_('FPF_ANALYTICS')),
				'menu_slug'	 => 'firebox-analytics',
				'controller' => 'FireBox\\Core\\Controllers\\Analytics'
			],
			[
				'page_title' => esc_html(firebox()->_('FB_SUBMISSIONS_PAGE_TITLE')),
				'menu_title' => esc_html(fpframework()->_('FPF_SUBMISSIONS')),
				'menu_slug'	 => 'firebox-submissions',
				'controller' => 'FireBox\\Core\\Controllers\\Submissions'
			],
			[
				'page_title' => esc_html(firebox()->_('FB_IMPORT_PAGE_TITLE')),
				'menu_title' => esc_html(fpframework()->_('FPF_IMPORT')),
				'menu_slug'	 => 'firebox-import',
				'controller' => 'FireBox\\Core\\Controllers\\BoxImport'
			],
			[
				'page_title' => esc_html(firebox()->_('FB_SETTINGS_PAGE_TITLE')),
				'menu_title' => esc_html(fpframework()->_('FPF_SETTINGS')),
				'menu_slug'	 => 'firebox-settings',
				'controller' => 'FireBox\\Core\\Controllers\\BoxSettings'
			],
			[
				'menu_title' => esc_html(fpframework()->_('FPF_DOCUMENTATION')),
				'custom_url'  => FBOX_DOC_URL
			],
			
			[
				'menu_title' => '<span class="fb-yellow-link">' . esc_html(fpframework()->_('FPF_UPGRADE')) . '</span>',
				'custom_url'  => FBOX_GO_PRO_URL
			]
			
		];
	}

}