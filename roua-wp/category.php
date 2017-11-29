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

    <!-- ================================================== -->
    <!-- =============== END BREADCRUMB ================ -->
    <!-- ================================================== -->

    <!-- ================================================== -->
    <!-- =============== START CONTENT PAGE ================ -->
    <!-- ================================================== -->

    <section class="no-mb" id="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">

                        <section class="blog-posts">


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
                                    get_template_part( 'content', get_post_format() );
                                    ?>

                                <?php endwhile; ?>

                            <?php else : ?>

                                <?php
                                /* Get the none-content template (error) */
                                get_template_part( 'content', 'none' );
                                ?>

                            <?php endif; ?>


                        </section>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================== -->
    <!-- =============== END CONTENT PAGE ================ -->
    <!-- ================================================== -->

    <!-- ================================================== -->
    <!-- =============== START PAGINATION ================ -->
    <!-- ================================================== -->

<?php
/**
 * clubix_after_posts_loop hook
 *
 * @hooked nothing
 */
global $wp_query;
do_action( 'clubix_after_posts_loop', $wp_query, '', 2 );
?>

    <!-- ================================================== -->
    <!-- =============== END PAGINATION ================ -->
    <!-- ================================================== -->


<?php get_footer(); ?>