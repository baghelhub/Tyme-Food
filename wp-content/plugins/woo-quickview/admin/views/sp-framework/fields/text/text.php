<?php
/**
 * The text field of the plugin.
 *
 * @since      1.0.7
 * @package    Woo_Quick_View
 * @subpackage Woo_Quick_View/views
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! class_exists( 'SP_WQV_Framework_Field_text' ) ) {
	/**
	 *
	 * Field: text
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class SP_WQV_Framework_Field_text extends SP_WQV_Framework_Fields {

		/**
		 * Field constructor.
		 *
		 * @param array  $field The field type.
		 * @param string $value The values of the field.
		 * @param string $unique The unique ID for the field.
		 * @param string $where To where show the output CSS.
		 * @param string $parent The parent args.
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

			$type = ( ! empty( $this->field['attributes']['type'] ) ) ? $this->field['attributes']['type'] : 'text';

			echo wp_kses_post( $this->field_before() );

			echo '<input type="' . esc_attr( $type ) . '" name="' . esc_attr( $this->field_name() ) . '" value="' . esc_attr( $this->value ) . '"' . $this->field_attributes() . ' />';

			echo wp_kses_post( $this->field_after() );

		}

	}
}
