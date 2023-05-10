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

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

$forms = $this->data->get('forms');
$selected_form = isset($_GET['form_id']) ? sanitize_text_field($_GET['form_id']) : (isset($forms[0]['id']) ? sanitize_text_field($forms[0]['id']) : '');
?>
<h1><?php esc_html_e(firebox()->_('FB_SUBMISSIONS_PAGE_TITLE')); ?></h1>
<select class="fb-form-selection">
	<option disabled<?php echo empty($forms) ? ' selected' : ''; ?>><?php esc_html_e(firebox()->_('FB_PLEASE_SELECT_A_FORM')); ?></option>
	<?php foreach($forms as $key => $value): ?>
		<option value="<?php esc_attr_e($value['id']); ?>"<?php echo $value['id'] === $selected_form ? ' selected' : ''; ?>><?php esc_html_e($value['name']); ?></option>
	<?php endforeach; ?>
</select>
<div class="fb-submissions">
	<form method="GET">
		<?php
		// Show submissions table
		$submissions = new \FireBox\Core\Form\Tables\Submissions();
		$submissions->prepare_items();
		$submissions->views();
		$submissions->display();
		// Nonce
		wp_nonce_field('fb_form_submission_action', 'fb_form_submission_field', false, true);
		?>
		<input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? esc_attr($_GET['page']) : ''; ?>" />
		<input type="hidden" name="form_id" value="<?php esc_attr_e($selected_form); ?>" />
	</form>
</div>
<?php