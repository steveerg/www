<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Add to cart element
 */

global $product;
if ( ! class_exists( 'woocommerce' ) OR ! $product OR $us_elm_context == 'grid_term' ) {
	return;
}

$classes = isset( $classes ) ? $classes : '';

$classes .= ( ! empty( $el_class ) ) ? ( ' ' . $el_class ) : '';
$el_id = ( ! empty( $el_id ) AND $us_elm_context == 'shortcode' ) ? ( ' id="' . esc_attr( $el_id ) . '"' ) : '';

// Output WooCommerce Add to cart
if ( $us_elm_context == 'shortcode' ) {

	echo '<div class="w-post-elm add_to_cart' . $classes . '"' . $el_id . '>';
	if ( is_object( $product ) AND method_exists( $product, 'get_type' ) ) {
		woocommerce_template_single_add_to_cart();
		if ( function_exists( 'wc_print_notices' ) ) {
			woocommerce_output_all_notices();
		}
	}
	echo '</div>';

} else {
	add_filter( 'woocommerce_product_add_to_cart_text', 'us_add_to_cart_text', 99, 2 );
	add_filter( 'woocommerce_loop_add_to_cart_link', 'us_add_to_cart_text_replace', 99, 3 );

	if ( empty( $view_cart_link ) ) {
		$classes .= ' no_view_cart_link';
	}
	echo '<div class="w-btn-wrapper woocommerce' . $classes . '">';
	woocommerce_template_loop_add_to_cart();
	echo '</div>';

	remove_filter( 'woocommerce_product_add_to_cart_text', 'us_add_to_cart_text', 99 );
	remove_filter( 'woocommerce_loop_add_to_cart_link', 'us_add_to_cart_text_replace', 99 );
}
