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

namespace FireBox\Core\Controllers;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use FireBox\Core\Admin\Analytics\Overview\Overview;

class Dashboard extends BaseController
{
	/**
	 * The Main Buttons of the Dashboard
	 * 
	 * @var  array
	 */
	protected $main_buttons;
	
	public function __construct()
	{
		$this->setMainButtons();
    }

	/**
	 * Load required media files
	 * 
	 * @return void
	 */
	public function addMedia()
	{
		// load geoip js
		wp_register_script(
			'fpf-geoip',
			FPF_MEDIA_URL . 'admin/js/fpf_geoip.js',
			[],
			FPF_VERSION,
			false
		);
		wp_enqueue_script( 'fpf-geoip' );
	}

	/**
	 * Render view
	 * 
	 * @return  void
	 */
	public function render()
	{
		$payload = [
			'main_buttons' => $this->main_buttons
		];

		firebox()->renderer->admin->render('pages/dashboard', $payload);
	}

	/**
	 * Sets the Main Buttons of the Dashboard
	 * 
	 * @return  void
	 */
	protected function setMainButtons()
	{
		$this->main_buttons = [
			[
				'label' => firebox()->_('FB_NEW_POPUP'),
				'icon'	=> 'dashicons-plus-alt',
				'url'	=> admin_url('post-new.php?post_type=firebox'),
				'li_class' => 'fpf-open-library-modal'
			],
			[
				'label' => firebox()->_('FB_POPUPS'),
				'icon'	=> 'dashicons-menu-alt',
				'url'	=> admin_url('edit.php?post_type=firebox')
			],
			[
				'label' => fpframework()->_('FPF_ANALYTICS'),
				'icon'	=> 'dashicons-chart-bar',
				'url'	=> admin_url('admin.php?page=firebox-analytics')
			],
			[
				'label' => fpframework()->_('FPF_SUBMISSIONS'),
				'icon'	=> 'dashicons-list-view',
				'url'	=> admin_url('admin.php?page=firebox-submissions')
			],
			[
				'label' => fpframework()->_('FPF_IMPORT'),
				'icon'	=> 'dashicons-upload',
				'url'	=> admin_url('admin.php?page=firebox-import')
			],
			[
				'label' => fpframework()->_('FPF_SETTINGS'),
				'icon'	=> 'dashicons-admin-generic',
				'url'	=> admin_url('admin.php?page=firebox-settings')
			],
			[
				'label'  => fpframework()->_('FPF_DOCUMENTATION'),
				'icon'	 => 'dashicons-editor-help',
				'url'	 => FBOX_DOC_URL,
				'target' => '_blank'
			]
		];
	}
}