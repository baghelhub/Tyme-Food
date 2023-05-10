<?php
/**
 * The action functionality of the plugin.
 *
 * @since      1.0.7
 * @package    Woo_Quick_View
 * @subpackage Woo_Quick_View/views
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! function_exists( 'sp_wqv_get_option' ) ) {
	/**
	 * Get option
	 *
	 * @param  mixed $option_name option name.
	 * @param  mixed $default default value.
	 * @return statement
	 */
	function sp_wqv_get_option( $option_name = '', $default = '' ) {

		$options = apply_filters( 'sp_wqv_get_option', get_option( '_sp_wqv_options' ), $option_name, $default );

		if ( isset( $option_name ) && isset( $options[ $option_name ] ) ) {
			return $options[ $option_name ];
		} else {
			return ( isset( $default ) ) ? $default : null;
		}

	}
}

if ( ! function_exists( 'sp_wqv_set_option' ) ) {
	/**
	 * Set option
	 *
	 * @param  mixed $option_name option name.
	 * @param  mixed $new_value new value.
	 * @return void
	 */
	function sp_wqv_set_option( $option_name = '', $new_value = '' ) {

		$options = apply_filters( 'sp_wqv_set_option', get_option( '_sp_wqv_options' ), $option_name, $new_value );

		if ( ! empty( $option_name ) ) {
			$options[ $option_name ] = $new_value;
			update_option( '_sp_wqv_options', $options );
		}

	}
}

if ( ! function_exists( 'sp_wqv_get_all_option' ) ) {
	/**
	 *
	 * Get all option
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function sp_wqv_get_all_option() {
		return get_option( '_sp_wqv_options' );
	}
}
