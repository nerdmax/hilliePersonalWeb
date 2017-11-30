<?php
/**
 * Plugin Name: 	Meta Box Group Field
 * Plugin URI: 		http://www.themeplugger.com/products/meta-box-group-field
 * Description: 	Meta Box Group Field is Meta Box Add-on that extends a new field named 'group' for collectively grouping over 20+ supported fields and able to clone them.
 * Version: 		1.0
 * Author: 			ThemePlugger
 * Author URI:		http://www.themeplugger.com
 * License URI:		http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:		/languages
 * 
 * @package         Meta Box Group Field
 * @author          Raymond Ang <themeplugger@gmail.com>
 * @license         GNU General Public License, version 3
 * @copyright       2014 Meta Box Group Field
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Currently supports only these field types:
 * - text
 * - checkbox
 * - radio
 * - select
 * - hidden
 * - password
 * - textarea
 * - heading
 * - slider
 * - number
 * - datetime
 * - time
 * - color
 * - checkbox_list
 * - email
 * - range
 * - url
 * - post
 * - button
 * - wysiwyg (No visual or text tab)
 * - taxonomy (Bug: select_tree|checkbox_tree) (Working: checkbox_list|select_advanced|select)
 *
 * Minor adjustments
 * - oembed (Partly not working)
 *
 * Warning: Please do not use these field types for 'group' field type
 * as this currently wouldn't work.
 *
 * Still on development field types:
 * - file
 * - file_advanced
 * - image
 * - thickbox_image
 * - plupload_image
 * - image_advanced
 *
 * Fix label "for" attribute to point to new id
 */

// Tested on Meta Box 4.3.8

if ( ! defined( 'TPMBGF_URL' ) )
	define( 'TPMBGF_URL', plugin_dir_url( __FILE__ ) );

define( 'TPMBGF_JS_URL', trailingslashit( TPMBGF_URL . 'js' ) );
define( 'TPMBGF_CSS_URL', trailingslashit( TPMBGF_URL . 'css' ) );

if ( ! defined( 'TPMBGF_DIR' ) )
	define( 'TPMBGF_DIR', plugin_dir_path( __FILE__ ) );

define( 'TPMBGF_INC_DIR', trailingslashit( TPMBGF_DIR . 'inc' ) );
define( 'TPMBGF_FIELDS_DIR', trailingslashit( TPMBGF_INC_DIR . 'fields' ) );

/**
 * Init
 * 
 * @since 1.0
 */
function tpmbgf_init() {
	if ( class_exists( 'RW_Meta_Box' ) ) {
		if ( is_admin() ) {
			require_once( TPMBGF_FIELDS_DIR . 'group.php' );
			
			new TP_Meta_Box_Group_Field();
		}
	}
}
add_action( 'init', 'tpmbgf_init' );
	
if ( ! class_exists( 'TP_Meta_Box_Group_Field' ) ) {
	class TP_Meta_Box_Group_Field {
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 9999 );
		}
		
		/**
		 * Override RWMB scripts
		 * 
		 * @since 1.0
		 */
		public function admin_enqueue_scripts() {
		    global $wp_scripts;
		
			if ( isset( $wp_scripts->registered ) && $wp_scripts->registered ) {
				foreach ( $wp_scripts->registered as $script_id => $script ) {
					if ( $script_id == 'rwmb-clone' ) {
						$wp_scripts->registered[$script_id]->src = TPMBGF_JS_URL . 'clone.js';
					} elseif ( $script_id == 'rwmb-color' ) {
						$wp_scripts->registered[$script_id]->src = TPMBGF_JS_URL . 'color.js';
					}
				}
			}
		}
	}
}
