<?php
/**
 * Register scripts and load templates
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Dashboard functions of Coupon X
 */
class Coupon_X
{


    /**
     * Constructor.
     */
    public function __construct()
    {

        add_action('admin_init', [ $this, 'redirect_user_to_settings_page' ]);
        add_action('plugins_loaded', [ $this, 'load_domain_files' ]);
        $this->files_loader();

    }//end __construct()


    /**
     * Load text domain folder
     */
    public function load_domain_files()
    {
        load_plugin_textdomain('cx', false, dirname(plugin_basename(__FILE__)).'/languages/');

    }//end load_domain_files()


    /**
     * Redirect user to plugin settings page on first activation.
     */
    public function redirect_user_to_settings_page()
    {
        global $wpdb;

        $redirect_option = get_option('cx_redirect_user', false);
        $widget_count    = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type='cx_widget'");
        if (( $redirect_option && '0' === $widget_count )) {
            update_option('cx_redirect_user', false);
            exit(wp_redirect(admin_url('admin.php?page=add_couponx')));
        } else if ($redirect_option && $widget_count > 0) {
            update_option('cx_redirect_user', false);
            exit(wp_redirect(admin_url('admin.php?page=couponx')));
        }

    }//end redirect_user_to_settings_page()


    /**
     * Load plugin related files
     */
    public function files_loader()
    {

        include_once 'class-dashboard.php';
        include_once 'class-couponx-frontend.php';

    }//end files_loader()


}//end class

new Coupon_X();
