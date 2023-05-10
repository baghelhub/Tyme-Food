<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Food Restro
 * @since Food Restro 1.0.0
 */

/**
 * food_restro_content_end_action hook
 *
 * @hooked food_restro_content_end -  10
 *
 */
do_action( 'food_restro_content_end_action' );

/**
 * food_restro_content_end_action hook
 *
 * @hooked food_restro_footer_start -  10
 * @hooked Food_Restro_Footer_Widgets->add_footer_widgets -  20
 * @hooked food_restro_footer_site_info -  40
 * @hooked food_restro_footer_end -  100
 *
 */
do_action( 'food_restro_footer' );

/**
 * food_restro_page_end_action hook
 *
 * @hooked food_restro_page_end -  10
 *
 */
do_action( 'food_restro_page_end_action' ); 

?>

<?php wp_footer(); ?>

<script src="<?php echo get_stylesheet_directory_uri(). '/assets/js/custom-js.js"' ; ?>" type="text/javascript"></script>
<script>
initComparisons();
jQuery(document).ready(function(){
 jQuery(".page-id-9352 #content section:nth-child(2),.page-id-9413 #content section:nth-child(2),.page-id-9395 #content section:nth-child(2),.page-id-9426 #content section:nth-child(2),.page-id-9440 #content section:nth-child(2),.page-id-9454 #content section:nth-child(2)").prepend("<p class='pre-add'>Categories <span class='arrow-btn'> <i class='fa fa-angle-down' aria-hidden='true'></i></span></p>");
  jQuery(".pre-add").click(function(){
    jQuery(".elementor-col-16").toggleClass("dd-block");
  });
});	
</script>
</body>
</html>
