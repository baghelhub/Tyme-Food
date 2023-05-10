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


	?>

	<body>

	<script>
function initComparisons() {
  var x, i;
  x = document.getElementsByClassName("img-comp-overlay");
  for (i = 0; i < x.length; i++) {
    compareImages(x[i]);
  }

  function compareImages(img) {
   
    var slider, img, clicked = 0, w, h;
    w = img.offsetWidth;
    h = img.offsetHeight;
    img.style.width = (w / 2) + "px";
    slider = document.createElement("DIV");
    slider.setAttribute("class", "img-comp-slider");
    img.parentElement.insertBefore(slider, img);
    slider.style.top = (h / 2) - (slider.offsetHeight / 2) + "px";
    slider.style.left = (w / 2) - (slider.offsetWidth / 2) + "px";
    slider.addEventListener("mousedown", slideReady);
    window.addEventListener("mouseup", slideFinish);
    slider.addEventListener("touchstart", slideReady);
    window.addEventListener("touchend", slideFinish);
   
    function slideReady(e) {
      e.preventDefault();
      clicked = 1;
      window.addEventListener("mousemove", slideMove);
      window.addEventListener("touchmove", slideMove);
    }

    function slideFinish() {
  
      clicked = 0;
    
    }
    function slideMove(e) {
    
      var pos;  
      if (clicked == 0) return false;
      pos = getCursorPos(e)
      if (pos < 0) pos = 0;
      if (pos > w) pos = w;
      slide(pos);
    }

    function getCursorPos(e) {
      var a, x = 0;
      e = (e.changedTouches) ? e.changedTouches[0] : e;
      a = img.getBoundingClientRect();
      x = e.pageX - a.left;
      x = x - window.pageXOffset;
      return x;
    }
    
    
    function slide(x) {
      img.style.width = x + "px";
      slider.style.left = img.offsetWidth - (slider.offsetWidth / 2) + "px";
    
    }
  
  }

}


//slider
jQuery(document).ready(function(){
	jQuery('').slick({
  arrows: true,
  infinite: true,
  speed: 300,
  slidesToShow: 2,
  slidesToScroll: 1,
  dots:true,
  autoplay: true,
  autoplaySpeed: 2000,
});


});

</script>

	</body>