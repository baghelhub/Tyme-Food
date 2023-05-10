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

class BaseController
{
	/**
	 * Render page
	 * 
	 * @return  void
	 */
	public function renderPage()
	{
		// load media for current page
		if (method_exists($this, 'addMedia'))
		{
			add_action('admin_enqueue_scripts', [$this, 'addMedia']);
		}
		
		// render base view of controller
		add_action('fpframework_' . fpframework()->getPluginPage() . '/admin_page', [$this, 'renderBaseView']);
		
		// render each controller view from the child controllers
		add_action('firebox/admin_page_content', [$this, 'render']);
	}

	/**
	 * Renders the Basic View of a Controller
	 * 
	 * @return  void
	 */
	public function renderBaseView()
	{
		firebox()->renderer->admin->render('static/template', ['settings' => get_option('firebox_settings')]);
	}

}