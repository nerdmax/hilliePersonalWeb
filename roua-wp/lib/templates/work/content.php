<?php
/**
 * @author Stylish Themes
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$prefix = Haze_Meta_Boxes::get_instance()->prefix;
$work = rwmb_meta("{$prefix}work");
$url = rwmb_meta("{$prefix}url");
$images = rwmb_meta("{$prefix}imgadv", array('type'=>'image_advanced', 'size'=>'full'));
?>

<section class="no-mb">
    <div class="container">
        <div class="row">

            <div class="col-sm-6">
                <div class="row">
                    <div class="padding-content">
                        <div class="portfolio-single">
                            <div class="header-portfolio-single">

                                <div class="like">
                                    <?php if( function_exists('zilla_likes') ) zilla_likes(); ?>
                                </div>

                                <div class="title">
                                    <a href="<?php the_permalink(); ?>">
                                        <h2>
                                            <?php the_title(); ?>
                                        </h2>
                                    </a>
                                    <div class="category">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo $work; ?>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div class="content-portfolio-single">
                                <?php the_content(); ?>

                                <?php if($url != ''): ?>
                                    <p style="margin-top: -15px;">
                                    <a href="<?php echo $url; ?>" target="_blank">
                                        <?php _e('visit website', LANGUAGE_ZONE); ?> <i class="fa fa-arrow-right"></i>
                                    </a>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="footer-portfolio-single">

                                <h4>
                                    <?php _e('Filed under', LANGUAGE_ZONE); ?>
                                </h4>

                                <div class="category">
                                    <?php
                                    $cats = wp_get_post_terms( get_the_ID(), PortfolioPostType::get_instance()->postTypeTax );
                                    foreach($cats as $cat):
                                        ?>
                                        <a href="<?php echo get_term_link( $cat->term_id, PortfolioPostType::get_instance()->postTypeTax ); ?>">
                                            <?php echo $cat->name; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>

                                <!--<h4>
                                    <?php _e('Share on social media', LANGUAGE_ZONE); ?>
                                </h4>

                                <nav class="social-icons">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-pinterest"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>-->

                                <?php roua_post_single_nav(get_the_ID(), PortfolioPostType::get_instance()->postType); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="row">
                    <div class="big-image no-mb">

                        <?php foreach($images as $image): ?>
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['name']; ?>">
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>


</div></div></section>
