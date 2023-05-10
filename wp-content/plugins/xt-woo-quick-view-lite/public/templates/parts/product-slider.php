<?php

/**
 * This file is used to markup the slider part of the quick view modal.
 *
 * This template can be overridden by copying it to yourtheme/xt-woo-quick-view/parts/product-slider.php.
 *
 * HOWEVER, on occasion we will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see         https://docs.xplodedthemes.com/article/127-template-structure
 * @author 		XplodedThemes
 * @package     XT_Woo_Quick_View/Templates
 * @version     1.8.4
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

global $product, $attachment_ids;

$fullscreen = xt_wooqv_modal_type_is('fullscreen');

$thumb_image_size = apply_filters(
    'xt_wooqv_modal_slider_thumb_size',
    xt_wooqv_option('modal_slider_thumb_size', 'woocommerce_gallery_thumbnail')
);

$single_image_size = apply_filters(
    'xt_wooqv_modal_slider_image_size',
    xt_wooqv_option('modal_slider_image_size', 'woocommerce_single')
);

$attachment_ids = array();

$variation_id = !empty($variation_id) ? $variation_id : null;

if(!empty($variation_id)) {

	$variation = new WC_Product_Variation( $variation_id );

    $attachment_ids[] = $variation->get_image_id();

	if(class_exists('WC_Additional_Variation_Images')) {
		$gallery_attachment_ids = get_post_meta( $variation_id, '_wc_additional_variation_images', true );
		$gallery_attachment_ids = explode( ',', $gallery_attachment_ids );
		$attachment_ids = array_merge($attachment_ids, $gallery_attachment_ids);
	}
	
}else{

    $attachment_ids[] = $product->get_image_id();

	$gallery_attachment_ids = $product->get_gallery_image_ids();
	$attachment_ids = array_merge($attachment_ids, $gallery_attachment_ids);
}

$placeholder_src = wc_placeholder_img_src();
$placeholder = sprintf( '<li><img src="%s" alt="%s" /></li>', $placeholder_src, __( 'Placeholder', 'xt-woo-quick-view' ) );

?>

<div class="xt_wooqv-slider-wrapper" data-attachments="<?php echo count($attachment_ids);?>">

	<ul class="xt_wooqv-slider">
		<?php
		if ( !empty($attachment_ids) ) {

            foreach ( $attachment_ids as $attachment_id ) {

                $props            = wc_get_product_attachment_props( $attachment_id, $product );
                $thumb_image_src  = wp_get_attachment_image_src( $attachment_id, $thumb_image_size, 0);
                $single_image_src  = wp_get_attachment_image_src( $attachment_id, $single_image_size, 0);

                $single_image = !empty($single_image_src[0]) ? sprintf(
                    '<img src="%s" width="%s" height="%s" />',
                    $single_image_src[0],
                    $single_image_src[1],
                    $single_image_src[2]
                ) : $placeholder;

                $single_image = apply_filters( 'woocommerce_single_product_image_thumbnail_html', $single_image, $attachment_id);

                if(strpos($single_image, 'iframe') !== false) {
                    $placeholder_src = xt_woo_quick_view()->plugin_url('public/assets/images', 'woocommerce-video-placeholder.png');
                }

                echo sprintf(
                    '<li data-thumb="%s" data-src="%s" itemprop="image" title="%s" style="background-image:url(%s)">%s</li>',
                    !empty($thumb_image_src[0]) ? $thumb_image_src[0] : $placeholder_src,
                    !empty($single_image_src[0]) ? $single_image_src[0] : $placeholder_src,
                    esc_attr( $props['caption'] ),
                    !empty($single_image_src[0]) ? $single_image_src[0] : $placeholder_src,
                    $single_image
                );
            }
				
		}else{

            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $placeholder, $product->get_image_id() );
		}
		?>
	</ul>
	
</div> 
