<?php
/**
 * @author Stylish Themes
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; } ?>


<article <?php post_class("blog-single-post"); ?>>

    <header>
        <?php _e('Posted on ', LANGUAGE_ZONE); ?><a href="<?php the_permalink(); ?>"><?php the_date(); ?></a>
        <?php _e(' by ', LANGUAGE_ZONE); ?><?php the_author_link(); ?><?php _e(' on ', LANGUAGE_ZONE); ?><?php the_category(', ', 'single'); ?>
        <h1>
            <?php the_title(); ?>
        </h1>
    </header>

    <?php the_content(); ?>

    <!-- Displaying post pagination links in case we have multiple page posts -->
    <?php zen_single_post_pagination(); ?>


</article>

