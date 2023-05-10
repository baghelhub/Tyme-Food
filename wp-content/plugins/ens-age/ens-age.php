<?php
/**
 * Plugin Name: Ens Age Verification.
 * Plugin URI: https://ensmedicos.com/
 * Description: Display pop form during admin without login and create cookies then hidden popup. A customisable age gate to block content from younger people
 * Version: 2.9.0
 * Text Domain: ens-age-verifications
 * Author: Ens Enterprises
 * Author URI: https://ensmedicos.com/
 */

     /* activate and deactivate basic hooks ************************************/
       register_activation_hook( __FILE__, 'age_activation_function' );
       register_deactivation_hook(__FILE__ ,'age_deactivation_function');	
       register_uninstall_hook(__FILE__ ,'age_uninstall_function');

  function age_activation_function() {
  
           include_once(plugin_dir_path( __FILE__ ) . 'ageDb/acreteTable.php');
         }

  function  age_deactivation_function()  {

           include_once(plugin_dir_path( __FILE__ ) . 'ageDb/adropTable.php');
         }

  function age_uninstall_function(){}

    /* add function using hooks ******************/
    add_action('admin_menu', 'ens_age_verification');
  function ens_age_verification() {
    

    add_menu_page('My Page Title', 'Ens Age', 'manage_options', 'ens-setting', 'age_menu_output','dashicons-visibility');
  
     }
     
    add_action("admin_enqueue_scripts","add_script_age");
  function add_script_age() {
    
     wp_enqueue_script( 'jQuery1', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js',array( 'jquery' ), true);  
     wp_enqueue_script('jQuery1');
  }
   

  function age_menu_output() {

      /*js file register****************/
      wp_register_script( 'custom-script', plugins_url( '/admin/avalidation.js', __FILE__ ) );
      wp_enqueue_script( 'custom-script' );
      
      /*setting form path**************************/
      include_once(plugin_dir_path( __FILE__ ) . 'asettingForm.php');  
    
     }
      
  function ageVerify_checkin() {
         
         if(!isset($_COOKIE['acookie']) && (!is_user_logged_in()))  {   
          
           include_once(plugin_dir_path( __FILE__ ) . 'age-verify-box.php'); 
     
          }
      }
     
    add_action('init', 'ageVerify_checkin');
  
    /* setting function ****************************** */
  function plugin_add_settings_link( $links ) {
      $settings_link = '<a href="http://localhost/wordpress/wp-admin/admin.php?page=ens-setting">' . __( 'Settings' ) . '</a>';
      array_push( $links, $settings_link );
      return $links;
     }
  $plugin = plugin_basename( __FILE__ );
  add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );


    ?>