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

namespace FireBox\Core\Admin;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Admin
{
	/**
	 * Admin Page Settings
	 * 
	 * @var  AdminPageSettings
	 */
	private $pageSettings;

	/**
	 * Library
	 * 
	 * @var  Library
	 */
	public $library;

	/**
	 * Admin constructor
	 */
	public function __construct()
	{
		// init dependencies
		$this->initDependencies();
		
		// Admin Page Settings
		$this->pageSettings = new AdminPageSettings();
		
		// run actions
		$this->handleActions();

		// run filters
		$this->handleFilters();
	}
	
	/**
	 * Load admin dependencies.
	 * 
	 * @return  void
	 */
	private function initDependencies()
	{
		new Media();
		
		$this->library = firebox()->library;

		// Update Notice
		$valid_pages = [
			'firebox',
			'firebox-analytics',
			'firebox-import',
			'firebox-submissions',
			'firebox-settings'
		];
		$updateNotice = new \FPFramework\Admin\Includes\UpdateNotice(
			firebox()->plugin_slug,
			firebox()->plugin_name,
			FBOX_VERSION,
			$valid_pages
		);
		$updateNotice->init();

		// Top Bar Navigation
		new Includes\TopBarNavigation();

		// Review Reminder
		new \FPFramework\Admin\Includes\ReviewReminder(
			firebox()->plugin_slug,
			firebox()->plugin_name,
			FBOX_MEDIA_ADMIN_URL
		);
	}

	/**
	 * Runs all Admin Actions
	 * 
	 * @return  void
	 */
	private function handleActions()
	{
		add_action('admin_enqueue_scripts', [$this, 'registerMedia'], 20);
		
		
		add_action('plugin_action_links_' . plugin_basename(FBOX_PLUGIN_BASE_FILE), [$this, 'plugin_action_links']);

		add_action('fpframework/admin/template/footer/firebox/nav_links', [$this, 'add_admin_page_template_footer_nav_links']);
		
	}

	
	/**
	 * Adds extra links to the Plugins page in the free version.
	 * - Upgrade to Pro button
	 * 
	 * @param   array  $links
	 * 
	 * @return  array
	 */
	public function plugin_action_links($links)
	{
		$links = array_merge( $links, array(
			'<a href="' . FBOX_GO_PRO_URL . '" class="firebox-go-pro-link" title="' . fpframework()->_('FPF_UNLOCK_MORE_FEATURES_WITH_PRO_READ_MORE') . '">' . fpframework()->_('FPF_GO_PRO') . '</a>'
		) );
			
		return $links;
	}

	/**
	 * Adds links to the admin template footer nav links
	 * 
	 * @return  void
	 */
	public function add_admin_page_template_footer_nav_links()
	{
		?>
		<li><a href="https://www.fireplugins.com/<?php echo esc_attr(firebox()->plugin_slug); ?>" target="_blank"><?php echo esc_html(fpframework()->_('FPF_GET_PRO_FEATURES')); ?></a></li>
		<?php
	}
	

	/**
	 * Runs all Admin Filters
	 * 
	 * @return  void
	 */
	private function handleFilters()
	{
		add_filter('admin_body_class', [$this, 'setPluginPageBodyClass']);
	}

	/**
	 * Sets a class to the body of the FireBox Admin Pages
	 * 
	 * @return  string
	 */
	public function setPluginPageBodyClass($classes)
	{
		if (!$this->isPluginPage())
		{
			return $classes;
		}

		$classes .= ' fpf-admin-page fpf-firebox-page';

		if ($this->isControllerPage())
		{
			$classes .= ' fpf-controller-page';
		}
		
		return $classes;
	}

	/**
	 * Checks if we are in a plugin page
	 * 
	 * @return  boolean
	 */
	private function isPluginPage()
	{
		if ($this->getPageNow() == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'firebox')
		{
			return true;
		}

		if ($this->getPageNow() == 'post.php')
		{
			return true;
		}
		
		if ($this->isControllerPage())
		{
			return true;
		}

		if (current_user_can('manage_options'))
		{
			return true;
		}

		return false;
	}

	/**
	 * Whether we are browsing a plugin page from the plugin's menu
	 * 
	 * @return  boolean
	 */
	private function isControllerPage()
	{
		if (!firebox()->menu)
		{
			return false;
		}

		$current_plugin_page = fpframework()->getPluginPage();
		$plugin_menu_items = firebox()->menu->getPluginMenuItems();

		// Only set the class to the plugin pages
		return $this->getPageNow() == 'admin.php' && in_array($current_plugin_page, $plugin_menu_items);
	}

	/**
	 * Returns page now
	 * 
	 * @return  string
	 */
	protected function getPageNow()
	{
		global $pagenow;
		return $pagenow;
	}

	/**
	 * Registers CSS and JS files
	 * 
	 * @return  void
	 */
	public function registerMedia()
	{
		$this->registerStyles();
		$this->registerScripts();
	}

	/**
	 * Register admin styles.
	 *
	 * @return  void
	 */
	public function registerStyles()
	{
		// load dashicons
		wp_enqueue_style('dashicons');
		
		// firebox main admin css
		wp_register_style(
			'firebox-admin',
			FBOX_MEDIA_ADMIN_URL . 'css/firebox.css',
			[],
			FBOX_VERSION,
			false
		);
		wp_enqueue_style('firebox-admin');

		$css = '
			:root {
				--fpf-templates-library-header-logo: url(' . FBOX_MEDIA_ADMIN_URL . 'images/logo.svg);
			}
		';
		wp_add_inline_style('firebox-admin', $css);
	}

	/**
	 * Registers admin scripts.
	 * 
	 * @return  void
	 */
	public function registerScripts()
	{
		wp_register_script('firebox-admin', false);
		wp_enqueue_script('firebox-admin');

		$data = array(
			'media_url' => FBOX_MEDIA_URL,
			'admin_url' => get_admin_url(),
			'submissions_page' => admin_url('admin.php?page=firebox-submissions')
		);

		wp_localize_script('firebox-admin', 'fbox_admin_js_object', $data);
	}
}