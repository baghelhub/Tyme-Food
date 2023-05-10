<style>		
  @font-face {
    font-family: Erode-Light;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/Erode-Light.otf');
  }

  @font-face {
    font-family: Erode-Bold;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/Erode-Bold.otf');
  }
  @font-face {
    font-family: Erode-Regular;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/Erode-Regular.otf');
  }


@font-face {
    font-family: Erode-Semibold;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/Erode-Semibold.otf');
  }

  @font-face {
    font-family: Erode-Medium;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/Erode-Medium.otf');
  }
  
  @font-face {
    font-family: GeneralSans-Extralight;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/GeneralSans-Extralight.otf');
  }
  @font-face {
    font-family: GeneralSans-Bold;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/GeneralSans-Bold.otf');
  }
  @font-face {
    font-family: GeneralSans-Regular;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/GeneralSans-Regular.otf');
  }
  @font-face {
    font-family: GeneralSans-Light;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/GeneralSans-Light.otf');
  }
  @font-face {
    font-family: GeneralSans-Medium;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/GeneralSans-Medium.otf');
  }
  @font-face {
    font-family: GeneralSans-Semibold;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/GeneralSans-Semibold.otf');
  }
  GeneralSans-Bold.ttf

  @font-face {
    font-family: GeneralSansnb;
    src: url('<?php echo home_url() ?>/wp-content/themes/food-restro-child/assets/fonts/GeneralSans-Bold.ttf');
  }
</style>


<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Food Restro
	 * @since Food Restro 1.0.0
	 */

	/**
	 * food_restro_doctype hook
	 *
	 * @hooked food_restro_doctype -  10
	 *
	 */
	do_action( 'food_restro_doctype' );

?>
<head>
<?php
	/**
	 * food_restro_before_wp_head hook
	 *
	 * @hooked food_restro_head -  10
	 *
	 */
	do_action( 'food_restro_before_wp_head' );

	wp_head(); 
?>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri().'/assets/css/custom-style.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri().'/assets/css/media-style.css' ?>">
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri().'/assets/css/responsive-style.css' ?>">
<!-- <script src="<?php //echo get_stylesheet_directory_uri(). '/assets/js/custom-js.js"' ; ?>" type="text/javascript"></script> -->
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/ rel="dns-prefetch">
	<!-- Add the slick-theme.css if you want default styling -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/ rel="dns-prefetch">

	

</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<?php
	/**
	 * food_restro_page_start_action hook
	 *
	 * @hooked food_restro_page_start -  10
	 *
	 */
	do_action( 'food_restro_page_start_action' ); 

	/**
	 * food_restro_header_action hook
	 *
	 * @hooked food_restro_header_start -  10
	 * @hooked food_restro_site_branding -  20
	 * @hooked food_restro_site_navigation -  30
	 * @hooked food_restro_header_end -  50
	 *
	 */
	do_action( 'food_restro_header_action' );

	/**
	 * food_restro_content_start_action hook
	 *
	 * @hooked food_restro_content_start -  10
	 *
	 */
	do_action( 'food_restro_content_start_action' );

	/**
	 * food_restro_header_image_action hook
	 *
	 * @hooked food_restro_header_image -  10
	 *
	 */
	do_action( 'food_restro_header_image_action' );

    if ( food_restro_is_frontpage() ) {

    	$sections = food_restro_sortable_sections();
    	$i = 1;
		foreach ( $sections as $section => $value ) {
			add_action( 'food_restro_primary_content', 'food_restro_add_'. $section .'_section', $i . 0 );
		}
		do_action( 'food_restro_primary_content' );
	} 

    /* code login ***********************************/ 

	if ( is_user_logged_in() ) {

        global $current_user;
        wp_get_current_user();
        $username = $current_user->user_login;
        ?>
        <script src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>
        <script>
            $(document).ready(function() {
					
             jQuery("li#menu-item-1488 a").html("<div class='cuslog'><?php echo  $username; ?></div>");
    
         });
	    </script>
        <?php
    
        } else {

            //echo  'no';
       }

	?>
