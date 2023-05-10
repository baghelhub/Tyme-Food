<?php
$page_title          = ppw_get_page_title();
$password_label      = _x( 'Password:', PPW_Constants::CONTEXT_SITEWIDE_PASSWORD_FORM, 'password-protect-page' );
$password_placehoder = wp_kses_post( get_theme_mod( 'ppwp_pro_form_instructions_placeholder' ) );
$btn_label           = get_theme_mod( 'ppwp_pro_form_button_label', PPW_Constants::DEFAULT_SHORTCODE_BUTTON );
$disable_logo        = get_theme_mod( 'ppwp_pro_logo_disable', 0 ) ? 'none' : 'block';
$form_transparency   = get_theme_mod( 'ppwp_pro_form_enable_transparency' ) ? 'style="background: none!important; box-shadow: initial;"' : '';
$is_wrong_password   = isset( $_GET['action'] ) && $_GET['action'] === 'ppw_postpass' && isset( $_POST['input_wp_protect_password'] );
$internal_css        = '<link rel="stylesheet" href="' . PPW_VIEW_URL . 'dist/ppw-form-entire-site.css" type="text/css">' . PHP_EOL;
$form_action         = apply_filters( 'ppw_sitewide_form_action', '?action=ppw_postpass' );
$err_msg             = apply_filters( 'ppw_sitewide_error_message', esc_html__( 'Please enter the correct password!', 'password-protect-page' ) );
$start_date			 = get_theme_mod( 'ppwp_sitewide_start_time' );
$end_date			 = get_theme_mod( 'ppwp_sitewide_end_time' );
$is_show_form		 = $end_date ? true : false;

?>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<meta name="description" content=""/>
		<meta name="viewport" content="width=device-width"/>
		<link rel="icon" href="<?php echo esc_attr( get_site_icon_url() ); ?>"/>
		<?php echo apply_filters( 'ppw_sitewide_external_css', $internal_css ); ?>
		<title><?php echo esc_attr( $page_title ); ?></title>
		<?php do_action( PPW_Constants::HOOK_CUSTOM_HEADER_FORM_ENTIRE_SITE ); ?>
		<style>
			<?php
				do_action( 'ppw_sitewide_custom_internal_css' );
				do_action( PPW_Constants::HOOK_CUSTOM_STYLE_FORM_ENTIRE_SITE );
				do_action( 'ppwp_sitewide_hide_password_form' );
				do_action( 'ppwp_countdown_timer_styles' );
			?>
		</style>
		<?php wp_custom_css_cb(); ?>
		<style type="text/css">
			video#myVideo {
			    position: fixed;
			    right: 0;
			    bottom: 0;
			    min-width: 100%;
			    min-height: 100%;
			    width: 100%;
			    height: 100%;
			    object-fit: fill;
			}
			span.StoreOwner {
			    position: absolute;
			    text-align: center;
			    bottom: 5px;
			    left: 0;
			    right: 0;
			    font-size: small;
			}
			span.StoreOwner i {
			    text-decoration: underline;
			}
			/*@media screen and (max-width: 480px) {
			  .onpc{display: none;}
			}
			@media screen and (min-width: 481px) {
			  .onmobile{display: none;}
			}*/
		</style>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<script type="text/javascript">
			jQuery(document).ready(function() { 
			jQuery("span.StoreOwner i").click(function(){
			  jQuery('#myVideo').hide();
			  jQuery('span.StoreOwner').hide();
			});
			let desktop = "/wp-content/plugins/password-protect-page/includes/views/entire-site/screen/pc.mp4";
			let mobile = "/wp-content/plugins/password-protect-page/includes/views/entire-site/screen/mobile.mp4";

			if(jQuery(window).width() >= 769) {
				// console.log("Desktop!");
				jQuery("#myVideo source").attr("src",desktop);
				setTimeout(function () {
					jQuery("#myVideo")[0].load();
					jQuery("#myVideo")[0].play();
				}, 1000);
			}else{
				// console.log("Mobile!");
				jQuery("#myVideo").attr("src",mobile);
				setTimeout(function () {
					jQuery("#myVideo")[0].load();
					jQuery("#myVideo")[0].play();
				}, 1000);
			}
			

		});
		</script>
	</head>
	<body class="ppwp-sitewide-protection">
		<video id="myVideo" class="onpc" autoplay muted loop playsinline>
		 <source src="/wp-content/plugins/password-protect-page/includes/views/entire-site/screen/pc.mp4" type="video/mp4" width="100%" height="100%" autoplay>
		</video>

		<span class="StoreOwner">Are you the store owner? <i>Click Here!</i></span>
		<div class="pda-form-login ppw-swp-form-container">
			
			<h1>
				<a style="display: <?php echo esc_attr( $disable_logo ); ?>" title="<?php echo esc_attr__( 'This site is password protected by PPWP plugin', 'password-protect-page') ?>" class="ppw-swp-logo">Password Protect WordPress plugin</a>
			</h1>
			<?php
			do_action( 'ppw_sitewide_above_password_form_container' );
			?>
			<form <?php echo wp_kses_post( $form_transparency ); ?> class="ppw-swp-form" action="<?php echo esc_attr( $form_action ); ?>" method="post">
				<?php do_action( 'ppw_sitewide_above_password_form' ); ?>
				<label for="input_wp_protect_password"><?php echo esc_html( $password_label ); ?></label>
				<input class="input_wp_protect_password" type="password" id="input_wp_protect_password"
					name="input_wp_protect_password" placeholder="<?php echo esc_attr( $password_placehoder ); ?>"/>
				<?php
					if ( $is_wrong_password ) {
						?>
							<div id="ppw_entire_site_wrong_password" class="ppw-entire-site-password-error">
								<?php echo wp_kses_post( $err_msg ); ?>
							</div>
						<?php
					}
					do_action( 'ppw_sitewide_above_submit_button' );
				?>
				<input type="submit" class="button button-primary button-login" value="<?php echo esc_html( $btn_label ); ?>">
				<?php do_action( 'ppw_sitewide_below_password_form' ); ?>
			</form>
		</div>
		<?php
			do_action('ppwp_render_sitewide_countdown');
		?>
		<?php do_action( PPW_Constants::HOOK_CUSTOM_FOOTER_FORM_ENTIRE_SITE ); ?>
	</body>
</html>
