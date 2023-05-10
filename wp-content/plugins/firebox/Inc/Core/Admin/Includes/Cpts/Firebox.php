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

namespace FireBox\Core\Admin\Includes\Cpts;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use FPFramework\Libs\Cpt;
use FireBox\Core\Helpers\BoxHelper;

class Firebox extends Cpt
{
	public $singular;
	public $plural;
	
	public function __construct()
	{
		$this->singular = firebox()->_('FB_PLUGIN_NAME');
		$this->plural = firebox()->_('FB_PLUGIN_PLULAR_NAME');
		
		parent::__construct($this->getPayload());

		$this->init();
	}

	public function init()
	{
		// load dependencies
		$this->initDependencies();

		// adds extra actions per item on hover
		add_filter('post_row_actions', [$this, 'filter_row_actions'], 10, 2);

		add_action('pre_get_posts', [$this, 'custom_orderby']);
		
		// handle box duplication
		add_action('admin_action_fb_duplicate_post_as_draft', [$this, 'handle_box_duplication']);

		// handle box cookie clear
		add_action('admin_action_fb_clear_cookie', [$this, 'handle_box_cookie_clear']);

		// bulk actions
		add_action('bulk_actions-edit-firebox', [$this, 'filter_bulk_actions']);
		add_action('handle_bulk_actions-edit-firebox', [$this, 'handle_bulk_actions'], 10, 3);

		// add custom buttons at top of the CPT
		add_filter('views_edit-firebox', [$this, 'filter_top_buttons']);

		// delete hook for FireBox
		add_action('delete_post', [$this, 'before_delete_firebox_callback']);

		
	}

	
	
	/**
	 * Load dependencies
	 * 
	 * @return  void
	 */
	private function initDependencies()
	{
		new FireBox\AddFireBoxButtonAboveEditor();
		new FireBox\TinyMCEButton();
		new FireBox\SmartTagsCPTButton();
	}

	/**
	 * Before deleting the FireBox, delete its box logs and box logs details data
	 * 
	 * @param   int  $ID
	 * 
	 * @return  void
	 */
	public function before_delete_firebox_callback($ID)
	{
		global $post;

		if (!$post)
		{
			return;
		}

		if ($post->post_type != 'firebox')
		{
			return;
		}

		$logs_table = firebox()->tables->boxlog->getFullTableName();
		$logs_details_table = firebox()->tables->boxlogdetails->getFullTableName();
		
		// delete logs details
		firebox()->tables->boxlogdetails->executeRaw("DELETE FROM `$logs_details_table` WHERE log_id IN (SELECT id FROM `$logs_table` WHERE box = %d)", [$ID]);
		
		// delete logs
		firebox()->tables->boxlog->delete([
			'box' => $ID
		]);
	}

	/**
	 * Custom Order BY
	 * 
	 * @param   array  $query
	 * 
	 * @return  void
	 */
	public function custom_orderby($query)
	{
		if (!is_admin())
		{
			return;
		}

		if (!is_string($query))
		{
			return;
		}

		$orderby = strtolower($query->get('orderby'));

		switch ($orderby) {
			case 'status':
				$meta_query = [
					'relation' => 'OR',
					[
						'key' => 'post_status',
						'compare' => 'NOT EXISTS',
					],
					[
						'key' => 'post_status',
					]
				];
		
				$order = $query->get('order');

				$query->set('meta_query', $meta_query);
				$query->set('orderby', ($order == 'asc' ? 'publish' : 'draft'));
				break;
		}
	}

	/**
	 * Adds Import to the top of the CPT page
	 * 
	 * @param   array  $views
	 * 
	 * @return  array
	 */
	public function filter_top_buttons($views)
	{
		$views['import'] = '<a href="admin.php?page=firebox-import">' . fpframework()->_('FPF_IMPORT') . '</a>';
		return $views;
	}

	/**
	 * Handles custom bulk actions
	 * 
	 * @param   string  $redirect_to
	 * @param   string  $action
	 * @param   array   $post_ids
	 * 
	 * @return  mixed
	 */
	public function handle_bulk_actions($redirect_to, $action, $post_ids)
	{
		$redirect_url = admin_url() . 'edit.php?post_type=firebox';
		
		if (empty($post_ids))
		{
			return $redirect_url;
		}

		// Check whether action that user wants to perform is Export
		if ($action == 'export')
		{
			BoxHelper::exportBoxes($post_ids);
		}
		else if ($action == 'reset_stats')
		{
			BoxHelper::resetBoxStats($post_ids);

			\FPFramework\Libs\AdminNotice::displaySuccess(firebox()->_('FB_POPUP_RESET_STATS'));
		}

		return $redirect_to;
	}

	/**
	 * Adds filter to the bulk actions
	 * 
	 * @param   array  $actions
	 * 
	 * @return  array
	 */
	public function filter_bulk_actions($actions)
	{
		$actions['export'] = fpframework()->_('FPF_EXPORT');
		$actions['reset_stats'] = firebox()->_('FB_RESET_IMPRESSIONS');
		return $actions;
	}

	/**
	 * Adds extra action in each row item
	 * 
	 * @param   array   $actions
	 * @param   object  $post
	 * 
	 * @return  array
	 */
	public function filter_row_actions($actions, $post)
	{
		if ($post->post_type != 'firebox')
		{
			return $actions;
		}

		// Remove "View" from published popups as we are not utilizing the front-end view of the custom post type.
		if ($post->post_status === 'publish')
		{
			unset($actions['view']);
		}
		
		// Add 'Duplicate' action
		$actions['duplicate'] = '<a href="admin.php?action=fb_duplicate_post_as_draft&post=' . $post->ID . '" title="' . firebox()->_('FB_DUPLICATE_BOX') . '" rel="permalink">' . fpframework()->_('FPF_DUPLICATE') . '</a>';

		/**
		 * Check if cookie has been set
		 */
		if ((new \FireBox\Core\FB\Cookie(firebox()->box->get($post->ID)))->exist())
		{
			$actions['clear_cookie'] = '<a class="fb_red_text_color" href="admin.php?action=fb_clear_cookie&post=' . $post->ID . '" title="' . firebox()->_('FB_CLEAR_COOKIE') . '" rel="permalink">' . firebox()->_('FB_HIDDEN_BY_COOKIE') . '</a>';
		}
		return $actions;
	}

	/**
	 * Handles Box duplication
	 * 
	 * @return  void
	 */
	public function handle_box_duplication()
	{
		$post_id = isset($_GET['post']) ? intval($_GET['post']) : '';
		
		$redirect_url = admin_url() . 'edit.php?post_type=firebox';
		
		if (empty($post_id))
		{
			wp_redirect($redirect_url);
			exit();
		}

		BoxHelper::duplicateBox($post_id);

		// redirect back to box list
		wp_redirect($redirect_url);
	}

	/**
	 * Clears cookie from box
	 * 
	 * @return  void
	 */
	public function handle_box_cookie_clear()
	{
		$post_id = isset($_GET['post']) ? intval($_GET['post']) : '';

		$redirect_url = admin_url() . 'edit.php?post_type=firebox';
		
		if (empty($post_id))
		{
			wp_redirect($redirect_url);
			exit();
		}

		$cookie = new \FireBox\Core\FB\Cookie(firebox()->box->get($post_id));
		$cookie->remove();

		// redirect back to box list
		wp_redirect($redirect_url);
	}

	/**
	 * Returns CPT payload
	 * 
	 * @return  array
	 */
	protected function getPayload()
	{
		return [
			'label_name' => firebox()->_('FB_PLUGIN_NAME'),
			'singular' => $this->singular,
			'label' => firebox()->_('FB_PLUGIN_NAME'),
			'plural' => $this->plural,
			'name' => 'firebox',
			'slug' => 'firebox',
			'has_archive' => false,
			'show_in_menu' => false,
			'is_public' => true,
			'supports' => ['title', 'editor'],
			'extra_columns' => [
				'status' => [
					'index' => 0,
					'label' => fpframework()->_('FPF_STATUS')
				],
				'mode' => fpframework()->_('FPF_MODE'),
				'trigger_point' => firebox()->_('FB_METABOX_TRIGGER_METHOD'),
				'impressions' => fpframework()->_('FPF_IMPRESSIONS'),
				'last_date_viewed' => firebox()->_('FB_LAST_DATE_VIEWED'),
				'id' => fpframework()->_('FPF_ID')
			],
			'capability_type' => ['firebox', 'fireboxes']
		];
	}

	/**
	 * Adds the values for the exta columns
	 * 
	 * @param   string  $column
	 * @param   int     $post_id
	 * 
	 * @return  void
	 */
	public function addExtraColumnsValues($column, $post_id)
	{
		switch ($column)
		{
			case 'status':
				echo \FPFramework\Helpers\HTML::renderFPToggle([
					'input_class' => ['fpf-toggle-post-status'],
					'name' => 'fb_toggle_post_' . $post_id,
					'extra_atts' => [
						'data-post-id' => $post_id
					],
					'value' => get_post_status($post_id) == 'publish' ? 1 : 0
				]);
				break;
			case 'mode':
				$meta = get_post_meta( $post_id, 'fpframework_meta_settings', true );
				echo esc_html($this->getMode($meta));
				break;
			case 'trigger_point':
				$meta = get_post_meta( $post_id, 'fpframework_meta_settings', true );
				echo esc_html($this->getTriggerPoint($meta)) . esc_html($this->getPosition($meta));
				break;
			case 'impressions':

				$impressions = (int) firebox()->tables->boxlog->getResults([
					'where' => [
						'box' => ' = ' . esc_sql($post_id)
					]
				], false, true);
				
				
				$link_start = $link_end = '';
				
				
				
				
				?>
				<span class="fpf-badge info" title="<?php echo esc_attr(sprintf(firebox()->_('FB_POPUP_TOTAL_IMPRESSIONS'), $impressions)); ?>">
					<?php echo wp_kses($link_start, ['a' => [ 'href' => true]]) . esc_html($impressions) . wp_kses($link_end, ['a' => true]); ?>
				</span>
				<?php
				break;
			case 'last_date_viewed':
				$last_date_viewed = firebox()->tables->boxlog->getResults([
					'select' => [
						'date as last_date_viewed'
					],
					'where' => [
						'box' => ' = ' . esc_sql($post_id),
					],
					'orderby' => ' date desc',
					'limit' => 1
				]);

				$last_date_viewed = isset($last_date_viewed[0]->last_date_viewed) ? $last_date_viewed[0]->last_date_viewed : '-';
				
				echo '<span title="' . esc_attr(firebox()->_('FB_LAST_DAY_OPENED_DESC')) . '">' . esc_html($last_date_viewed) . '</span>';
				break;
			case 'id':
				echo esc_html($post_id);
				break;
		}
	}

	/**
	 * Set sortable columns
	 * 
	 * @param   array  $columns
	 * 
	 * @return  array
	 */
	function setSortableColumns($columns)
	{
		$columns['status'] = fpframework()->_('FPF_STATUS');
		$columns['mode'] = fpframework()->_('FPF_MODE');
		$columns['id'] = fpframework()->_('FPF_ID');
		return $columns;
	}

	/**
	 * Gets the mode
	 * 
	 * @param   array  $meta
	 * 
	 * @return  string
	 */
	private function getMode($meta)
	{
		$mode = isset($meta['mode']) ? $meta['mode'] : '';

		if (empty($mode))
		{
			return '';
		}

		return firebox()->_('FB_METABOX_MODE_' . strtoupper($mode));
	}

	/**
	 * Gets the Trigger Point
	 * 
	 * @param   array  $meta
	 * 
	 * @return  string
	 */
	private function getTriggerPoint($meta)
	{
		$point = isset($meta['triggermethod']) ? $meta['triggermethod'] : '';

		if (empty($point))
		{
			return '';
		}

		switch ($point)
		{
			case 'pageheight':
				$point = 'PH';
				break;
			case 'element':
				$point = 'EL';
				break;
			case 'pageready':
				$point = 'PR';
				break;
			case 'pageload':
				$point = 'PL';
				break;
			case 'userleave':
				$point = 'UL';
				break;
			case 'onclick':
				$point = 'OC';
				break;
			case 'elementHover':
				$point = 'EH';
				break;
			case 'ondemand':
				$point = 'OD';
				break;
			case 'onexternallink':
				$point = 'ELC';
				break;
		}

		return firebox()->_('FB_METABOX_TRIGGER_METHOD_' . $point) .  ' / ';
	}

	/**
	 * Gets the position of the box
	 * 
	 * @param   array  $meta
	 * 
	 * @return  array
	 */
	private function getPosition($meta)
	{
		$position = isset($meta['position']) ? $meta['position'] : '';

		if (empty($position))
		{
			return '';
		}

		switch ($position)
		{
			case 'top-left':
				$position = 'TL';
				break;
			case 'top-center':
				$position = 'TC';
				break;
			case 'top-right':
				$position = 'TR';
				break;
			case 'bottom-left':
				$position = 'BL';
				break;
			case 'bottom-center':
				$position = 'BC';
				break;
			case 'bottom-right':
				$position = 'BR';
				break;
			case 'middle-left':
				$position = 'ML';
				break;
			case 'middle-right':
				$position = 'MR';
				break;
			case 'center':
				$position = 'C';
				break;
		}

		return firebox()->_('FB_METABOX_POSITION_' . $position);
	}
}