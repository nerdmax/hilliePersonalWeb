<?php
/**
 * Group field
 * 
 * Collectively group your fields and group fields can be cloned.
 * 
 * @package		Meta Box Group Field
 * @subpackage	Meta Box
 * @since		1.0
 * @version		1.0
 * @author		ThemePlugger
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'RWMB_Group_Field' ) ) {
	class RWMB_Group_Field extends RWMB_Field {
		
		/**
		 * Enqueue styles
		 * 
		 * @return void
		 */
		public static function admin_enqueue_scripts() {
			wp_enqueue_style( 'rwmb-group', TPMBGF_CSS_URL . 'group.css', array(), RWMB_VER );
		}
		
		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		public static function html( $meta, $field ) {
			$html = '';
			
			if ( $sub_fields = $field['fields'] ) {
				foreach ( $sub_fields as $sub_field ) {
					$sub_field_class = RW_Meta_Box::get_class_name( $sub_field );
					$has_brackets = false;
					
					// Temporarily remove single array brackets and later add them back properly.
					if ( strstr( $sub_field['field_name'], '[]' ) ) {
						$sub_field['field_name'] = str_replace( '[]', '', $sub_field['field_name'] );
						$has_brackets = true;
					}
					
					$sub_field_name 			= $sub_field['field_name'];
					$sub_field['clone']			= false; // No clones for sub fields
					$sub_field['field_name'] 	= "{$field['field_name']}[{$sub_field_name}]";
					$sub_field['id'] 			= "{$field['id']}_{$sub_field['id']}";
					
					// Add the single array brackets.
					$sub_field['field_name'] 	.= $has_brackets === true ? '[]' : '';
					
					$sub_meta 					= isset( $meta[$sub_field_name] ) ? $meta[$sub_field_name] : '';
					
					// File types
					switch ( $sub_field['type'] ) {
						case 'file' :
						case 'file_advanced' :
						case 'image' :
						case 'thickbox_image' :
						case 'plupload_image' :
						case 'image_advanced' :
							if ( ! $sub_meta ) {
								$sub_meta = array(); 
							}
							break;
					}
					
					// Display label and input in DIV and allow user-defined classes to be appended
					$classes = array( 'rwmb-field', "rwmb-{$sub_field['type']}-wrapper", 'rwmb-sub-group-wrapper' );
					if ( 'hidden' === $field['type'] )
						$classes[] = 'hidden';
					if ( !empty( $field['required'] ) )
						$classes[] = 'required';
					if ( !empty( $field['class'] ) )
						$classes[] = $field['class'];
					
					$html .= sprintf( '<div class="%s">', implode( ' ', $classes ) );
					$html .= call_user_func( array( $sub_field_class, 'begin_html' ), $sub_meta, $sub_field );
					$html .= call_user_func( array( $sub_field_class, 'html' ), $sub_meta, $sub_field );
					$html .= call_user_func( array( $sub_field_class, 'end_html' ), $sub_meta, $sub_field );
					$html .= '</div>';
				}
			}
			
			return $html;
		}
		
		/**
		 * Get meta value
		 *
		 * @param int   $post_id
		 * @param bool  $saved
		 * @param array $field
		 *
		 * @return mixed
		 */
		public static function meta( $post_id, $saved, $field ) {
			if ( $field['clone'] )
				return get_post_meta( $post_id, $field['id'], true );
			else
				return parent::meta( $post_id, $saved, $field );
		}
		
		/**
		 * Save meta value
		 *
		 * @param $new
		 * @param $old
		 * @param $post_id
		 * @param $field
		 */
		public static function save( $new, $old, $post_id, $field ) {
			update_post_meta( $post_id, $post_name = $field['id'], $field['clone'] ? array_values( $new ) : $new );
		}
		
		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		public static function normalize_field( $field ) {
			return $field;
		}
	}
}