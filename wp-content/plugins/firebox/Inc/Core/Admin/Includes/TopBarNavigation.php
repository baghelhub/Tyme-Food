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

namespace FireBox\Core\Admin\Includes;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class TopBarNavigation
{
	/**
	 * View Top Bar Items
	 * 
	 * @var  array
	 */
	private $top_bar_items = [];

	public function __construct()
	{
		if (!is_admin())
		{
			return;
		}
		
		// init default top bar items
		$this->initTopBarItems();

		// render top bar
		add_action('firebox/before_main_content', [$this, 'renderTopBar']);
	}

	/**
	 * Renders the Top Bar
	 * 
	 * @return  void
	 */
	public function renderTopBar()
	{
		$payload = [
			'top_bar_items' => $this->top_bar_items
		];

		firebox()->renderer->admin->render('dashboard/TopBarNavigation/top_bar', $payload);
	}

	/**
	 * Sets the top bar default items
	 */
	private function initTopBarItems()
	{
		$default_items = [
			'right' => [
				'items' => [
					[
						'label'	  => 'FPF_HELP',
						'icon'	  => 'dashicons-editor-help',
						'url' 	  => FBOX_DOC_URL,
						'target'  => 'blank'
					],
					[
						'label'	  => 'FPF_SETTINGS',
						'icon'	  => 'dashicons-admin-generic',
						'url'	  => admin_url('admin.php?page=firebox-settings')
					]
				]
			]
		];

		$items = apply_filters( 'firebox/filter_top_bar_items', $default_items);

		$this->top_bar_items = $items;
	}
}