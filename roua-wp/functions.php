<?php
/**
 * @author Stylish Themes
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }


/************************************************************/
/* Define Theme's Constants */
/************************************************************/
if ( !defined( 'THEMEROOT' ) ) {
    define('THEMEROOT', get_stylesheet_directory_uri());
}

if ( !defined( 'THEMEDIR' ) ) {
    define('THEMEDIR', get_stylesheet_directory());
}

if ( !defined( 'IMAGES' ) ) {
    define('IMAGES', THEMEROOT . '/assets/img');
}

if ( !defined( 'LANGUAGE_ZONE' ) ) {
    define( 'LANGUAGE_ZONE', 'roua' );
}

if ( !defined( 'LANGUAGE_ZONE_ADMIN' ) ) {
    define( 'LANGUAGE_ZONE_ADMIN', 'roua' );
}


/************************************************************/
/* Theme Setup Function */
/************************************************************/
add_action( 'after_setup_theme', 'roua_theme_setup' );

function roua_theme_setup() {

    // Load textdomain for translation
    load_theme_textdomain( 'roua', get_template_directory() . '/lang' );

    // Set a max with for the uploaded images.
    if (!isset($content_width)) $content_width = 1028;


    // Add Theme Support for Post Formats, Post Thumbnails and Automatic Feed Links
    if (function_exists('add_theme_support')) {


        // This theme supports a variety of post formats
        add_theme_support('post-formats', array());


        // Add theme support for post-thumbnails & declare its size
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(350, 350, true);


        // Adds RSS feed links to <head> for posts and comments
        add_theme_support( 'automatic-feed-links' );
        
        
        // Add theme support for WooCommerce plugin
        add_theme_support( 'woocommerce' );


        // This theme styles the visual editor with editor-style.css to match the theme style
        add_editor_style();


        // Add special field to image for audio/video post
        //add_filter( 'attachment_fields_to_edit', 'zen_attachment_fields_to_edit', 10, 2 );
        //add_action( 'edit_attachment', 'zen_save_attachment_fields' );

    }


    if ( function_exists( 'add_image_size' ) ) {

        add_image_size('blog_image_1', 300, 300, true);

        add_image_size('portfolio', 650, 650, true);

        add_image_size('clients', 613, 407, true);

        add_image_size('employee', 480, 584, true);

        add_image_size('roua_blog', 1800, 400, true);

    }


    // Load custom Scripts and Styles for Haze.
    add_action('wp_enqueue_scripts', 'clubix_load_custom_scripts');
    add_action('wp_enqueue_scripts', 'clubix_load_custom_styles');


    // Set widgets to accept shortcodes
    add_filter('widget_text', 'do_shortcode');


    // Comments filters
    add_filter('comment_form_defaults', 'zen_custom_comment_form');
    add_filter('comment_form_default_fields', 'zen_custom_comment_fields');


    // Register Menus
    add_action('init', 'haze_register_my_menus');


    // Add Google Analytics
    add_action('wp_head','zen_google_analytics');


    // TODO: Nu uita sa scoti asta
    //add_filter('show_admin_bar', '__return_false');

}


/************************************************************/
/* Theme Scripts Function */
/************************************************************/
function clubix_load_custom_scripts() {

    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrapJS', THEMEROOT . '/assets/js/bootstrap.min.js', array(), '1.0', true);
    wp_enqueue_script('onePluginsJS', THEMEROOT . '/assets/js/plugins.js', array(), '1.0', true);
    wp_enqueue_script('oneMainJS', THEMEROOT . '/assets/js/main.js', array(), '1.1', true);

    if(is_page() && 'template-contact.php' === get_page_template_slug( get_the_ID() )) {

        wp_enqueue_script('google-maps-api', 'http://maps.google.com/maps/api/js?sensor=true', array(), '1.0', true);
        wp_enqueue_script('mapJS', THEMEROOT . '/assets/js/map.js', array(), '1.0', true);

    }

    if(is_page() && 'template-portfolio.php' === get_page_template_slug( get_the_ID() )) {

        wp_enqueue_script('ajax-portfolio', THEMEROOT . '/assets/js/portfolio-ajax.js', array(), '1.0', true);

        /** Localize Scripts */
        $php_array = array(
            'admin_ajax' => admin_url('admin-ajax.php'),
            'load_more_text' => __('No more items to load...', LANGUAGE_ZONE),
        );
        wp_localize_script('ajax-portfolio', 'php_array', $php_array);

    }
    
    if( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {

        wp_enqueue_script('ajax-portfolio', THEMEROOT . '/assets/js/shop-ajax.js', array(), '1.0', true);

        /** Localize Scripts */
        $php_array = array(
            'admin_ajax' => admin_url('admin-ajax.php'),
            'load_more_text' => __('No more products to load...', LANGUAGE_ZONE),
        );
        wp_localize_script('ajax-portfolio', 'php_array', $php_array);

    }

}


/************************************************************/
/* Theme Styles Function */
/************************************************************/
function clubix_load_custom_styles() {

    wp_enqueue_style( 'master', THEMEROOT . '/assets/css/master.css');
    //wp_enqueue_style( 'base-color', THEMEROOT . '/assets/css/color.css');
    wp_enqueue_style( 'style', get_stylesheet_uri());
    
    wp_dequeue_style( 'woocommerce-layout' );
    wp_dequeue_style( 'woocommerce-smallscreen' );
    wp_dequeue_style( 'woocommerce-general' );

}


/************************************************************/
/* Register Menus */
/************************************************************/
function haze_register_my_menus() {
    register_nav_menus(
        array(
            'main-menu' => __('Main Menu', LANGUAGE_ZONE_ADMIN)
        )
    );
}

/************************************************************/
/* Add Google Analytics */
/************************************************************/
function zen_google_analytics() {
    global $clx_data;

    if(!empty($clx_data['jscode'])) {
        print_r(stripslashes($clx_data['jscode']));
    }
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'roua_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'roua_wrapper_end', 10 );

function roua_wrapper_start() {
	echo '<section id="content" class="no-mb">';
	echo '<div class="container">';
}

function roua_wrapper_end() {
	echo '</div>';
	echo '</section>';
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

add_filter( 'woocommerce_show_page_title', '__return_false' );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

add_filter( 'woocommerce_output_related_products_args', 'roua_woocommerce_output_related_products_args' );

function roua_woocommerce_output_related_products_args( $args ) {
	$args['posts_per_page'] = 3;
	$args['columns'] = 3;
	
	return $args;
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

add_filter( 'woocommerce_product_tabs', 'roua_product_tabs' );

function roua_product_tabs( $tabs ) {
	unset( $tabs['additional_information'] );
	
	return $tabs;
}

/**
 * Changes the number of columns under our main image on single product pages
 *
 * @since 1.0
 * @author WP Theme Tutorial, Curtis McHale
 */
function roua_one_column( $number ){
    return 1;
}

add_filter( 'woocommerce_product_thumbnails_columns', 'roua_one_column');

function woocommerce_button_proceed_to_checkout() {
	$checkout_url = WC()->cart->get_checkout_url();
	
	?>
	<a href="<?php echo $checkout_url; ?>" class="checkout-button btn button alt wc-forward"><?php _e( 'Proceed to Checkout', 'woocommerce' ); ?></a>
	<?php
}


/************************************************************/
/* Theme Includes Helpers */
/************************************************************/
require_once(THEMEDIR . '/lib/functions/core-functions.php');
require_once(THEMEDIR . '/lib/functions/color-handler.php');
require_once(THEMEDIR . '/lib/functions/filters_and_actions.php');
require_once(THEMEDIR . '/lib/functions/helpers.php');
require_once(THEMEDIR . '/lib/functions/comments-helpers.php');
require_once(THEMEDIR . '/lib/functions/seo/seo-option.php');
require_once(THEMEDIR . '/admin/importer/import.php');

/**
 * Custom Post Types CLASS
 *
 * This class creates all custom post-types of the theme.
 */
require_once(THEMEDIR . '/lib/functions/roua-posttypes.php');

/**
 * Special Shortcodes CLASS
 *
 * This class creates all the shortcodes of the theme.
 */
require_once(THEMEDIR . '/lib/functions/roua-shortcodes.php');

/**
 * Define meta-box constants & require meta-box plugins.
 *
 * Meta-box plugin and its extentions are used for the custom content boxes from the posts, pages and other places
 * in the admin dashboard.
 */
if ( !defined( 'RWMB_URL' ) ) {
    define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/admin/meta-box' ) );
}

if ( !defined( 'RWMB_DIR' ) ) {
    define( 'RWMB_DIR', trailingslashit( get_stylesheet_directory() . '/admin/meta-box' ) );
}

if ( !defined( 'TPMBGF_URL' ) ) {
    define('TPMBGF_URL', trailingslashit(get_stylesheet_directory_uri() . '/admin/meta-box-group-field'));
}
if ( !defined( 'TPMBGF_DIR' ) ) {
    define('TPMBGF_DIR', trailingslashit(get_stylesheet_directory() . '/admin/meta-box-group-field'));
}

require_once(RWMB_DIR . 'meta-box.php');
require_once(THEMEDIR . '/admin/meta-box-show-hide/meta-box-show-hide.php');
require_once(THEMEDIR . '/admin/meta-box-group-field/meta-box-group-field.php');
require_once(THEMEDIR . '/admin/meta-box-tabs/meta-box-tabs.php');
require_once(THEMEDIR . '/lib/functions/roua-metaboxes.php');

/**
 * Call Zilla Likes
 *
 * This mini-plugin is used for the hearts like system.
 */
if( !function_exists('zilla_likes') ) {
    require_once(THEMEDIR . '/admin/zilla-likes/zilla-likes.php');
}

/**
 * Call Redux Framework plugin
 *
 * This plugin is used for the options panel of the theme.
 */
if (class_exists('ReduxFramework')) {
    require_once(THEMEDIR . '/admin/redux-framework/options-init.php');
}

/**
 * TGM Activation Plugin
 *
 * This plugin helps to call all the required plugins for the theme.
 */
require_once(THEMEDIR . '/admin/tgm/tgm-init.php');

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require THEMEDIR . '/admin/tcm-theme-lock/class-tcm-theme-lock.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tcm_theme_lock() {

    $plugin = new Tcm_Theme_Lock();
    $plugin->run();

}
run_tcm_theme_lock();
