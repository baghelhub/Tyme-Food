<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.
/**
 *
 * Field: license
 *
 * @since 2.1.0
 * @version 2.1.0
 */
if ( ! class_exists( 'SP_WQV_Framework_Field_wqv_help' ) ) {
	class SP_WQV_Framework_Field_wqv_help extends SP_WQV_Framework_Fields {

		/**
		 * Create fields.
		 *
		 * @param  mixed $field field.
		 * @param  mixed $value value.
		 * @param  mixed $unique unique id.
		 * @param  mixed $where where to add.
		 * @param  mixed $parent parent.
		 * @return void
		 */
		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {

			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		/**
		 * Render
		 *
		 * @return void
		 */
		public function render() {
			echo wp_kses_post( $this->field_before() );
			?>
		<div class="wrap about-wrap sp-wqv-help">
			<h1><?php echo esc_html__( 'Welcome to WooCommerce Quick View!', 'woo-quickview' ); ?></h1>
			<p class="about-text">
			<?php
			echo esc_html__( 'Get introduced to WooCommerce Quick View plugin by watching our "Getting Started" video tutorial series. This video will help you get started with the plugin.', 'woo-quickview' );
			?>
				</p>

			<div class="headline-feature-video">
			<div class="headline-feature feature-video">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/aVznU7U7Hv4?list=PLoUb-7uG-5jNpcDKwo1WNot5tGlMmzhAH" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
				</div>

			<div class="feature-section three-col">
				<div class="col">
					<div class="sp-wqv-feature ">
						<h3><i class="sp-font fas fa-headset"></i> Need Help?</h3>
						<p>Stuck with any issues? No worries! Our Expert Support Team is always ready to help you out promptly.</p>
						<a href="https://shapedplugin.com/support/" target="_blank" class="wqv-help-button">Get Support</a>
					</div>
				</div>
				<div class="col">
					<div class="sp-wqv-feature">
						<h3><i class="sp-font fa fa-file-text" ></i>Documentation</h3>
						<p>Check out our documentation page and more information about what you can do with WooCommerce Quick View.</p>
						<a href="https://docs.shapedplugin.com/docs/woocommerce-quick-view/overview/" target="_blank" class="wqv-help-button">Documentation</a>
					</div>
				</div>
				<div class="col">
					<div class="sp-wqv-feature">
						<h3><i class="sp-font fa fa-heart-o" ></i>Show Your Love</h3>
						<p>We are really thankful to choose our plugin. Take your 1 minute to review the plugin and spread the love to inspire us.</p>
						<a href="https://wordpress.org/support/plugin/woo-quickview/reviews/?filter=5" target="_blank" class="wqv-help-button">Review Now</a>
					</div>
				</div>
			</div>

			<div class="about-wrap sp-wqv-plugin-section">
				<div class="sp-plugin-section-title text-center">
					<h2>Take your shop beyond the typical with more WooCommerce plugins!</h2>
					<h4>Some of our powerful premium plugins are ready to make your online store awesome.</h4>
				</div>
				<div class="feature-section first-cols three-col">
				<div class="col">
					<a href="https://shapedplugin.com/woocommerce-product-slider/" target="_blank" alt="WooCommerce Product Slider Pro" class="wqv-plugin-link">
						<div class="sp-wqv-feature ">
						<img src="https://shapedplugin.com/wp-content/uploads/edd/2022/08/woo-product-slider.png" alt="WooCommerce Product Slider Pro" class="wqv-help-img">
						<h3>Product Slider for WooCommerce</h3>
						<p>Boost sales by interactive product Slider, Grid, and Table in your WooCommerce website or store.</p>
					</div>
					</a>
				</div>
				<div class="col">
					<a href="https://shapedplugin.com/plugin/woocommerce-category-slider-pro/" target="_blank" alt="Category Slider Pro for WooCommerce" class="wqv-plugin-link">
						<div class="sp-wqv-feature ">
						<img src="https://shapedplugin.com/wp-content/uploads/edd/2022/08/woo-category-slider.png" alt="Category Slider Pro for WooCommerce" class="wqv-help-img">
						<h3>Category Slider Pro for WooCommerce</h3>
						<p>Display by filtering the list of categories aesthetically and boosting sales.</p>
					</div>
					</a>
				</div>
				<div class="col">
					<a href="https://shapedplugin.com/plugin/woocommerce-gallery-slider-pro/" target="_blank" alt="Gallery Slider for WooCommerce" class="wqv-plugin-link">
						<div class="sp-wqv-feature ">
						<img src="https://shapedplugin.com/wp-content/uploads/edd/2022/08/gallery-slider-for-woocommerce.png" alt="Gallery Slider for WooCommerce" class="wqv-help-img">
						<h3>Gallery Slider for WooCommerce</h3>
						<p>Product gallery slider and additional variation images gallery for WooCommerce and boost your sales.</p>
					</div>
					</a>
				</div>
			</div>
			<div class="feature-section three-col">
				<div class="col">
					<a href="https://shapedplugin.com/wp-carousel/" alt="WP Carousel" target="_blank" class="wqv-plugin-link">
						<div class="sp-wqv-feature ">
						<img src="https://shapedplugin.com/wp-content/uploads/edd/2022/08/wp-carousel.png" alt="WP Carousel" class="wqv-help-img">
						<h3>WP Carousel</h3>
						<p>The most powerful and user-friendly multi-purpose carousel, slider, & gallery plugin for WordPress.</p>
					</div>
					</a>
				</div>
				<div class="col">
					<a href="https://shapedplugin.com/real-testimonials/" alt="Real Testimonials" target="_blank" class="wqv-plugin-link">
						<div class="sp-wqv-feature ">
						<img src="https://shapedplugin.com/wp-content/uploads/edd/2022/08/real-testimonials.png" alt="Real Testimonials" class="wqv-help-img">
						<h3>Real Testimonials</h3>
						<p>Simply collect, manage, and display Testimonials on your website and boost conversions.</p>
					</div>
					</a>
				</div>
				<div class="col">
				<a href="https://smartpostshow.com/" alt="Smart Post Show" target="_blank" class="wqv-plugin-link" >
						<div class="sp-wqv-feature ">
						<img src="https://shapedplugin.com/wp-content/uploads/edd/2022/08/smart-post-show.png" alt="Smart Post Show" class="wqv-help-img">
						<h3>Smart Post Show</h3>
						<p>Filter and display posts (any post types), pages, taxonomy, custom taxonomy, and custom field, in beautiful layouts.</p>
					</div>
					</a>
				</div>
			</div>
			</div>

			</div>
			<?php
			echo wp_kses_post( $this->field_after() );
		}

	}
}
