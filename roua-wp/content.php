<?php
/**
 * @author Stylish Themes
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Remove filter because it stays activated throw all posts.
 */
remove_filter('zen_get_content_more', 'zen_return_empty_string', 15);

$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'roua_blog' );
$img = $img[0];
?>


<article style="background-image: url(<?php echo $img; ?>);">

    <section>

        <header>
            <?php _e('Posted on ', LANGUAGE_ZONE); ?><a href="<?php the_permalink(); ?>"><?php the_date(); ?></a>
            <?php _e(' by ', LANGUAGE_ZONE); ?><?php the_author_link(); ?><?php _e(' on ', LANGUAGE_ZONE); ?><?php the_category(', ', 'single'); ?>
            <h3>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        </header>

        <?php zen_the_excerpt(); ?>

        <footer>
            <?php echo zen_get_content_more(); ?>
        </footer>

    </section>

</article>