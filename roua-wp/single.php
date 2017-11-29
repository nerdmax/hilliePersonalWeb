<?php
/**
 * @author Stylish Themes
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header(); ?>

    <!-- ================================================== -->
    <!-- =============== START BREADCRUMB ================ -->
    <!-- ================================================== -->

    <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>

    <?php
    $img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
    $img_url = $img_url[0];
    ?>

    <section class="no-mb">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-fullscreen-parent">
                    <div class="breadcrumb breadcrumb-fullscreen alignleft" style="background-image: url(<?php echo $img_url; ?>);" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"></div>
                </div>
            </div>
        </div>
    </section>

    <?php else: ?>

    <section>
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb">
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

    <section>
        <div class="sticky-background"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3 col-sm-10 col-sm-offset-1">
                    <div class="row">
                        <div class="col-sm-12">



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
                                    get_template_part( 'lib/templates/blog/content', get_post_format() );
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
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================== -->
    <!-- =============== END CONTENT PAGE ================ -->
    <!-- ================================================== -->


    <!-- ================================================== -->
    <!-- =============== START COMMENT FORM ================ -->
    <!-- ================================================== -->


    <?php comments_template('', true); ?>


    <!-- ================================================== -->
    <!-- =============== END COMMENT FORM ================ -->
    <!-- ================================================== -->

    <!-- ================================================== -->
    <!-- =============== START PAGINATION ================ -->
    <!-- ================================================== -->

    <?php clx_post_single_nav(get_the_ID(), 'post'); ?>

    <!-- ================================================== -->
    <!-- =============== END PAGINATION ================ -->
    <!-- ================================================== -->


<?php get_footer(); ?>