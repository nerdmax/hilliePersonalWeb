<?php

$comm_closed = true;

/***********************************************************************************************/
/* Prevent the direct loading of comments.php */
/***********************************************************************************************/
if (!empty($_SERVER['SCRIPT-FILENAME']) && basename($_SERVER['SCRIPT-FILENAME']) == 'comments.php') {
    die(__('You cannot access this page directly.', LANGUAGE_ZONE));
}

/***********************************************************************************************/
/* If the post is password protected then display text and return */
/***********************************************************************************************/
if (post_password_required()) : ?>

    <p style="text-align: center; padding: 50px;">
        <?php
        _e( 'This post is password protected. Enter the password to view the comments.', LANGUAGE_ZONE);
        return;
        ?>
    </p>

<?php endif;

/***********************************************************************************************/
/* If we have comments to display, we display them */
/***********************************************************************************************/
if (comments_open()) {$comm_closed = false;}
if (have_comments()) :  ?>

    <div class="container">
    <div class="row">
    <div class="col-md-7 col-md-offset-2-5 col-sm-10 col-sm-offset-1">
    <div class="row">
    <div class="col-sm-12">
    <!-- ============== COMMENTS CONTAINER ============= -->
    <div class="comment-container">
    <div class="col-sm-12">

    <h1 class="title-comments">
        <span>
            <?php _e('Join the discussion', LANGUAGE_ZONE); ?>
        </span>
        <?php comments_number(__('No Comments', LANGUAGE_ZONE), __('1 Comment', LANGUAGE_ZONE), __('% Comments', LANGUAGE_ZONE)); ?>
    </h1>

    <ul class="comments">
        <?php wp_list_comments('callback=zen_comments'); ?>
    </ul>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>

        <div class="comment-nav-section clearfix">

            <p class="fl"><?php previous_comments_link(__( '&larr; Older Comments', LANGUAGE_ZONE)); ?></p>
            <p class="fr"><?php next_comments_link(__( 'Newer Comments &rarr;', LANGUAGE_ZONE)); ?></p>

        </div> <!-- end comment-nav-section -->

    <?php endif; ?>

    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

<?php
/***********************************************************************************************/
/* If we don't have comments and the comments are closed, display a text */
/***********************************************************************************************/

elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>

<?php endif;

/***********************************************************************************************/
/* Display the comment form */
/***********************************************************************************************/
?>

<!-- ============== COMMENT RESPOND ============= -->
<?php if (!$comm_closed) : ?>
<section class="no-mb">
<div class="container">
    <div class="row">
    <div class="padding-content clearfix" style="background-color: #fff;">
    <div class="col-md-7 col-md-offset-2-5 col-sm-10 col-sm-offset-1">
    <div class="row">
    <div class="contact-form-diva">
    <div class="comment-respond">

        <?php
        comment_form();
        ?>

    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>
</section>
<?php endif; ?>

<?php

?>