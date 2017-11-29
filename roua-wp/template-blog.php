<?php
/* Template Name: Blog Page */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$prefix = Haze_Meta_Boxes::get_instance()->prefix;

$order = rwmb_meta( "{$prefix}order", $args = array(), get_the_ID() );
$orderby = rwmb_meta( "{$prefix}order_by", $args = array(), get_the_ID() );
$posts_per_page = rwmb_meta( "{$prefix}posts_per_page", $args = array(), get_the_ID() );
$category = rwmb_meta( "{$prefix}category", $args = array('type' => 'taxonomy', 'taxonomy' => 'category', get_the_ID() ));

foreach($category as $cat) { $cats[] = $cat->term_id; }


get_header(); ?>


<!-- ================================================== -->
<!-- =============== START BREADCRUMB ================ -->
<!-- ================================================== -->

<?php diva_page_breadcrumb('no-mb'); ?>

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

                        // Construct the query
                        if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
                        elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
                        else { $paged = 1; }
                        $args = array(
                            'post_type'         => 'post',
                            'post_status'       => 'publish',
                            'paged'             => $paged,
                            'posts_per_page'    => (int)$posts_per_page,
                            'orderby'           => $orderby,
                            'order'             => $order,
                            'category__in'      => $cats,
                            //'author__in'        => $authors
                        );

                        $query = new WP_Query($args);

                        ?>

                        <?php
                        /**
                         * clubix_before_posts hook
                         *
                         * @hooked nothing
                         */
                        do_action( 'clubix_before_posts' );
                        ?>

                        <?php if ( $query->have_posts() ) : ?>

                            <?php while ( $query->have_posts() ) : $query->the_post(); ?>

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
do_action( 'clubix_after_posts_loop', $query, '', 2 );
?>
<?php
wp_reset_postdata();
// End The Loop
?>

<!-- ================================================== -->
<!-- =============== END PAGINATION ================ -->
<!-- ================================================== -->

<?php get_footer(); ?>

