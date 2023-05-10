<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):

function chld_thm_cfg_locale_css( $uri ) {
    if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
    $uri = get_template_directory_uri() . '/rtl.css';
    return $uri;
}
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):

function chld_thm_cfg_parent_css() {
    wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'custom', 'new-custom', 'slick', 'slick-theme', 'magnific-popup', 'food-restro-blocks' ) );
}
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

function wpb_widgets_init() {

    register_sidebar( array(
        'name' => __( 'Bottom Right', 'wpb' ),
        'id' => 'sidebar-bottom',
        'description' => __( ' ', 'wpb' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

}
add_action( 'widgets_init', 'wpb_widgets_init' );

function wpa89819_wc_single_product() {
    $product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
    if ( $product_cats && ! is_wp_error ( $product_cats ) ) {
        $single_cat = array_shift( $product_cats );
        ?>
        <h5 itemprop = 'name' class = 'cus-product_category_title' style = 'font-size:20px'><span><?php echo $single_cat->name;
        ?></span></h5>
        <?php }
    }
    add_action( 'woocommerce_after_shop_loop_item_title', 'wpa89819_wc_single_product', 2 );


    

    /* default  code end ****************************************************************/

    /* get payment id payment by razorpay  **************************************************/

    //  global $wpdb;
    // 	$order_date = $wpdb->get_row( "SELECT `meta_value` FROM `wp_postmeta` WHERE `meta_key` = '_transaction_id' AND `post_id` = 12555" );
    // 	echo 'Payment id ='.$order_date->meta_value ;

    /*  new code ******************/

//     if ( is_user_logged_in() ) {

//    global $current_user;
//        wp_get_current_user();
        
//         echo 'Username: ' . $current_user->user_login;

//        } else {

//         echo  'no';
//     }

    //  global $current_user;

    //  wp_get_current_user();
    //  echo 'Username: ' . $current_user->user_login . '\n';
    //echo 'User display name: ' . $current_user->display_name . '\n';

    

    ?>