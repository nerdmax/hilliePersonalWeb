<?php
/* Template Name: Portfolio Page */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$prefix = Haze_Meta_Boxes::get_instance()->prefix;
$order = rwmb_meta( "{$prefix}g_order", $args = array(), get_the_ID() );
$orderby = rwmb_meta( "{$prefix}g_order_by", $args = array(), get_the_ID() );
$posts_per_page = rwmb_meta( "{$prefix}g_posts_per_page", $args = array(), get_the_ID() );
$category = rwmb_meta( "{$prefix}g_category", $args = array('type' => 'taxonomy', 'taxonomy' => PortfolioPostType::get_instance()->postTypeTax), get_the_ID() );

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

<section id="content" class="no-mb">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <nav class="portfolio">
                        <ul class="clearfix">

                        <?php

                        // Construct the query
                        if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
                        elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
                        else { $paged = 1; }
                        $args = array(
                            'post_type'         => PortfolioPostType::get_instance()->postType,
                            'post_status'       => 'publish',
                            'paged'             => $paged,
                            'posts_per_page'    => (int)$posts_per_page,
                            'orderby'           => $orderby,
                            'order'             => $order,
                            'tax_query'         => ( !empty($cats) ? array(
                                    array(
                                        'taxonomy' => PortfolioPostType::get_instance()->postTypeTax,
                                        'field' => 'id',
                                        'terms' => $cats
                                    ),
                                ) : false ),
                        );

                        $query = new WP_Query($args);

                        ?>

                        <?php if ( $query->have_posts() ) : ?>

                            <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                                <?php
                                $work = rwmb_meta("{$prefix}work");
                                $url = rwmb_meta("{$prefix}url");
                                $images = rwmb_meta("{$prefix}imgadv", array('type'=>'image_advanced', 'size'=>'full'));

                                $terms = wp_get_post_terms( get_the_ID(), PortfolioPostType::get_instance()->postTypeTax );
                                ?>

                                <li class="col-sm-4 <?php foreach($terms as $term) { echo $term->slug . ' '; } ?>">
                                    <figure>
                                        <?php if ( has_post_thumbnail() ) : ?>

                                            <?php
                                            $img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio' );
                                            $img_url = $img_url[0];
                                            ?>

                                            <figcaption>

                                                <img src="<?php echo $img_url; ?>" alt="<?php the_title(); ?>">

                                            </figcaption>

                                        <?php endif; ?>

                                        <div class="content">

                                            <div class="left">
                                                <?php if( function_exists('zilla_likes') ) zilla_likes(); ?>
                                            </div>

                                            <div class="right">

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
                                    </figure>
                                </li>

                            <?php endwhile; ?>

                        <?php else : ?>

                            <?php
                            /* Get the none-content template (error) */
                            get_template_part( 'content', 'none' );
                            ?>

                        <?php endif; ?>
                        <?php
                        wp_reset_postdata();
                        // End The Loop
                        ?>


                        </ul>
                    </nav>
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
do_action( 'roua_after_posts_loop', $query, '', 2 );
?>

<!-- ================================================== -->
<!-- =============== END PAGINATION ================ -->
<!-- ================================================== -->


<?php get_footer(); ?>

