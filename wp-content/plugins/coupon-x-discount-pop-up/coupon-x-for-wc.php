<?php
/**
    Plugin Name: Coupon X Discount Pop Up
    Description: Use Coupon X to surprise visitors with engaging discount codes to boost your WooCommerce store's sales
    Author: Premio
    Author URI: https://premio.io/downloads/coupon-x-discount-pop-up/
    Version: 1.2.5
    Text Domain: coupon-x
    Domain Path: /languages
    License: GPLv2 or later

    @package Coupon X
*/

// Main plugin file.
namespace Coupon_X;

if (! defined('ABSPATH')) {
    exit;
}

// Define constants.
define('COUPON_X_FILE', __FILE__);
define('COUPON_X_PATH', __DIR__);
define('COUPON_X_URL', plugin_dir_url(COUPON_X_FILE));
define('COUPON_X_BUILD_URL', COUPON_X_FILE.'build/');
define('COUPON_X_PLUGIN_BASE', plugin_basename(COUPON_X_FILE));

define('COUPON_X_VERSION', '1.2.5');

require_once 'inc/class-coupon-x.php';
require_once 'inc/class-cx-rest.php';
require_once 'inc/class-cx-review-box.php';


register_activation_hook(COUPON_X_FILE, __NAMESPACE__.'\\save_redirect_status');


/**
 * Save redirection value on plugin activation.
 */
function save_redirect_status()
{
    add_option('cx_signup_popup', true, 'no');
    update_option('cx_redirect_user', true, 'no');
    global $wpdb;

    $lead_table = $wpdb->prefix.'cx_leads';
	//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
    if ($wpdb->get_var("show tables like '$lead_table'") !== $lead_table) {
        $sql = 'CREATE TABLE '.$lead_table.' (
            id int NOT NULL AUTO_INCREMENT,
            email varchar(255),
            widget_id int,
            widget_name varchar(255),
            date varchar(50),
            coupon_code varchar(100),
            ip_address varchar(50),
            Primary Key (id)
            );';

        include_once ABSPATH.'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

}//end save_redirect_status()
