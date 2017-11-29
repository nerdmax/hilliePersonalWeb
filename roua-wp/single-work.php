<?php
/**
 * @author Stylish Themes
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$prefix = Haze_Meta_Boxes::get_instance()->prefix;
$video_header = rwmb_meta("{$prefix}header_video");
$video_id = rwmb_meta("{$prefix}header_video_id");

get_header(); ?>

    <!-- ================================================== -->
    <!-- =============== START BREADCRUMB ================ -->
    <!-- ================================================== -->

<?php if($video_header == 'enable' && $video_id != '') : ?>

    <section class="no-mb">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-fullscreen-parent">
                    <div class="breadcrumb breadcrumb-video-content">
                       <iframe src="//player.vimeo.com/video/<?php echo $video_id; ?>?autoplay=1&amp;badge=0&amp;portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php elseif ( $cover_image = rwmb_meta("{$prefix}cover_image", array('type'=>'image_advanced', 'size'=>'full')) ) : ?>

    <?php $cover_image = array_shift($cover_image); ?>

    <section class="no-mb">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-fullscreen-parent">
                    <div class="breadcrumb breadcrumb-fullscreen alignleft small-description" style="background-image: url(<?php echo $cover_image['url']; ?>);" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"></div>
                </div>
            </div>
        </div>
    </section>

<?php elseif ( has_post_thumbnail() && ! post_password_required() ) : ?>

    <?php
    $img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
    $img_url = $img_url[0];
    ?>

    <section class="no-mb">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-fullscreen-parent">
                    <div class="breadcrumb breadcrumb-fullscreen alignleft small-description" style="background-image: url(<?php echo $img_url; ?>);" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"></div>
                </div>
            </div>
        </div>
    </section>

<?php else: ?>

    <section>
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb" style="margin-bottom: 0px;">
                    <h1>
                        <?php roua_upper_title(); ?>
                    </h1>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>

    <!-- ================================================== -->
    <!-- =============== END BREADCRUMB ================ -->
    <!-- ================================================== -->

    <!-- ================================================== -->
    <!-- =============== START CONTENT PAGE ================ -->
    <!-- ================================================== -->

    <section class="no-mb">
        <div class="container">
            <div class="row">



                <?php
                /**
                 * clubix_before_posts hook
                 *
                 * @hooked nothing
                 */
                do_action( 'clubix_before_posts' );
                ?>

                <?php if ( have_posts() ) : ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php
                        /* Get the content template */
                        get_template_part( 'lib/templates/work/content', '' );
                        ?>

                    <?php endwhile; ?>

                <?php else : ?>

                    <?php
                    /* Get the none-content template (error) */
                    get_template_part( 'content', 'none' );
                    ?>

                <?php endif; ?>



            </div>
        </div>
    </section>

    <!-- ================================================== -->
    <!-- =============== END CONTENT PAGE ================ -->
    <!-- ================================================== -->

    <style>
        html.menu-is-open {
            overflow: hidden;
        }
    </style>

<?php get_footer(); ?>