<?php

/**

 * @author Stylish Themes

 * @since 1.0.0

 */



// File Security Check

if ( ! defined( 'ABSPATH' ) ) { exit; }



global $clx_data;



if($clx_data['menu-color-scheme'] == 'light') {

    $menu_class = 'light-layout';

    $logo_small = $clx_data['logo-small-light']['url'];

    $logo_big = $clx_data['logo-big-light']['url'];

} else {

    $menu_class = 'dark-layout';

    $logo_small = $clx_data['logo-small-dark']['url'];

    $logo_big = $clx_data['logo-big-dark']['url'];

}



$prefix = Haze_Meta_Boxes::get_instance()->prefix;

$body_style = 'style="background-color: #fff;"';



if(get_post()) {

    $header_color = rwmb_meta("{$prefix}header_color", array(), get_the_ID());

    $header_bg = rwmb_meta("{$prefix}header_bg", array(), get_the_ID());

} else {

    $header_color = 'light';

    $header_bg = 'default';

}



if( function_exists( 'is_shop' ) && is_shop() ) {

	$post_id = get_option( 'woocommerce_shop_page_id' );

	

    $header_color = rwmb_meta("{$prefix}header_color", array(), $post_id);

    $header_bg = rwmb_meta("{$prefix}header_bg", array(), $post_id);

}



$header_color_opt = array(

    'class'         => 'light-layout',

    'hclass'        => 'dark-bg',

    'logo_big'      => $clx_data['logo-big-light']['url'],

    'logo_small'    => $clx_data['logo-small-light']['url']

);



if(is_single() && get_post_type() == 'post') { $body_style = ''; }

if(is_page() && !is_page_template('template-aboutus.php') && !is_page_template('template-blog.php') && !is_page_template('template-contact.php') ) { $body_style = ''; }

if($header_color) {

    if($header_color == 'light') {

        $header_color_opt = array(

            'class'         => 'light-layout',

            'hclass'        => 'dark-bg',

            'logo_big'      => $clx_data['logo-big-light']['url'],

            'logo_small'    => $clx_data['logo-small-light']['url']

        );

    } elseif ($header_color == 'dark') {

        $header_color_opt = array(

            'class'         => 'half-light-layout',

            'hclass'        => 'light-bg',

            'logo_big'      => $clx_data['logo-big-dark']['url'],

            'logo_small'    => $clx_data['logo-small-dark']['url']

        );

    }

}



?>



<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>



    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <meta name="HandheldFriendly" content="true" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>



    <link rel="profile" href="http://gmpg.org/xfn/11">

    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">



    <!-- Script required for extra functionality on the comment form -->

    <?php if (is_singular()) wp_enqueue_script( 'comment-reply' ); ?>



    <?php wp_head(); ?>



    <?php one_change_colors_css($clx_data['color1'], $clx_data['color2'], $clx_data['color3']); ?>



</head>



<body <?php body_class(); ?> <?php echo $body_style; ?>>



<?php if(strlen(trim($clx_data['csscode']))) : ?><style type="text/css"><?php echo esc_attr($clx_data['csscode']); ?></style><?php endif; ?>



<!-- PAGE LOADER -->

<div class="pageloader with-nprogress">

    <img src="<?php echo $clx_data['logo-big-dark']['url']; ?>" alt="<?php bloginfo('name'); ?>">

</div>





<!-- ================================================== -->

<!-- =============== START MENU ================ -->

<!-- ================================================== -->



<section class="roua-menu <?php echo $menu_class; ?>" style="background-image: url(<?php echo $clx_data['menu-image']['url']; ?>);">

    <div class="row">

        <div class="col-sm-12">

            <div class="logos">

                <div class="primary-logo">

                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">

                        <img src="<?php echo $logo_big; ?>" alt="">

                    </a>

                </div>

            </div>



           </div>



            <a href="#" class="open-menu">

					<span class="icon">

						<span class="top"></span>

						<span class="middle"></span>

						<span class="bottom"></span>

					</span>

                <?php _e('close menu', LANGUAGE_ZONE); ?>

            </a>



            <nav class="social-icons">

                <ul>

                    <?php if(isset($clx_data)){

                        foreach($clx_data['social'] as $icon) {

                            echo do_shortcode($icon);

                        }

                    } ?>

                </ul>

            </nav>

        </div>



    </div>



    <div class="row">

        <div class="col-sm-12">



            <nav class="menu">

                <?php

                wp_nav_menu(

                    array(

                        'theme_location'    => 'main-menu',

                        'menu_class'        => '',

                        'container'         => '',

                        'fallback_cb'       => false

                    ));

                ?>

            </nav>



        </div>

    </div>

</section>



<!-- ================================================== -->

<!-- =============== END MENU ================ -->

<!-- ================================================== -->



<!-- ================================================== -->

<!-- =============== START PAGE CONTENT ================ -->

<!-- ================================================== -->



<section class="page-content">



    <!-- ================================================== -->

    <!-- =============== START FILTER LIST ================ -->

    <!-- ================================================== -->



    <?php if(is_page() && is_page_template('template-portfolio.php')): ?>

        <div class="filter-list">

            <?php

                $category = rwmb_meta( "{$prefix}g_category", $args = array('type' => 'taxonomy', 'taxonomy' => PortfolioPostType::get_instance()->postTypeTax), get_the_ID() );

                $cats = array();

                foreach($category as $cat) { $cats[] = $cat->term_id; }

                echo clx_breadcrumbs_filter(PortfolioPostType::get_instance()->postTypeTax, $cats);

            ?>

        </div>

    <?php endif; ?>



    <!-- ================================================== -->

    <!-- =============== END FILTER LIST ================ -->

    <!-- ================================================== -->



    <!-- ================================================== -->

    <!-- =============== START HEADER ================ -->

    <!-- ================================================== -->



    <header class="header <?php echo $header_color_opt['class']; ?> <?php if($header_bg == 'solid') { echo $header_color_opt['hclass']; } ?>">

        <div class="row">

            <div class="col-sm-12">



                <div class="additional-right-buttons">

                    <?php if(is_page() && is_page_template('template-portfolio.php')): ?>

                        <a href="#" class="filter-open">

                            filter

                            <i class="fa fa-filter"></i>

                        </a>

                    <?php endif; ?>

                    

                    <?php if( class_exists( 'WooCommerce' ) ) : ?>

                    	<?php global $woocommerce; ?>

                    	

	                    <a class="shopping-cart" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" aria-haspopup="true">

							<?php _e( 'Cart', LANGUAGE_ZONE ); ?>

							<span>

								<?php echo sprintf( _n( '%d', '%d', $woocommerce->cart->cart_contents_count, LANGUAGE_ZONE ), $woocommerce->cart->cart_contents_count); ?>

							</span>

							<i class="fa fa-shopping-cart"></i>

						</a>

					<?php endif; ?>

                </div>



                <div class="logos">



                    <div class="primary-logo">

                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">

                            <img src="<?php echo $header_color_opt['logo_big']; ?>" alt="<?php bloginfo('name'); ?>">

                        </a>

                    </div>



                    <div class="secondary-logo">

                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">

                            <img src="<?php echo $header_color_opt['logo_small']; ?>" alt="<?php bloginfo('name'); ?>">

                        </a>

                    </div>



                </div>



                <a href="#" class="open-menu navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-collapse">

                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                    <!-- <?php _e('menu', LANGUAGE_ZONE); ?> -->

                </a>

                <ul class="list-inline pull-right desktop-nav-links">
                <li><a href="/">HOME</a></li>
                <li><a href="/contact/">CONTACT</a></li>
                </ul>



                <nav class="social-icons">

                    <ul>

                        <?php if(isset($clx_data)){

                            foreach($clx_data['social'] as $icon) {

                                echo do_shortcode($icon);

                            }

                        } ?>

                    </ul>

                </nav>

            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="collapse navbar-collapse" id="menu-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="/">HOME</a></li>
                        <li><a href="/contact/">CONTACT</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </div>

    </header>



    <!-- ================================================== -->

    <!-- =============== END HEADER ================ -->

    <!-- ================================================== -->
