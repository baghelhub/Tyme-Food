<?php
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
$plugin_name = $this->data->get('plugin_name');
$plugin_alias = $this->data->get('plugin_alias');
$current_version = $this->data->get('current_version');
$version = $this->data->get('version');
?>
<div class="fpf-update-notice-wrapper">
	<div class="update-notice">
		<div class="title"><?php echo esc_html(sprintf(fpframework()->_('FPF_X_VERSION_IS_AVAILABLE'), $plugin_name . ' ' . $version)); ?></div>
		<div class="subtitle"><?php echo esc_html(sprintf(fpframework()->_('FPF_YOUR_CURRENT_VERSION_IS_X'), $current_version)); ?> <a href="<?php echo esc_url(sprintf(FPF_PLUGIN_CHANGELOG_URL, $plugin_alias)); ?>"><?php echo esc_html(fpframework()->_('FPF_VIEW_CHANGELOG')) ?></a></div>
		<a href="<?php echo admin_url('plugins.php'); ?>" class="fpf-button small primary"><i class="icon dashicons dashicons-download"></i><?php echo esc_html(fpframework()->_('FPF_UPDATE')) ?></a>
	</div>
</div>