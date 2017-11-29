<?php
/* Template Name: About Us Page */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$prefix = Haze_Meta_Boxes::get_instance()->prefix;
$team_title = rwmb_meta( "{$prefix}team_title", $args = array(), get_the_ID() );
$image = rwmb_meta( "{$prefix}side_image", $args = array('type' => 'image_advanced', 'size' => 'full'), get_the_ID() );
$category = rwmb_meta( "{$prefix}team_category", $args = array('type' => 'taxonomy', 'taxonomy' => TeamPostType::get_instance()->postTypeTax), get_the_ID() );

$cats = '';
foreach($category as $cat) { $cats .= $cat->term_id . ', '; }

$img_echo = '';
foreach($image as $img) { $img_echo = $img['url']; }

$shortcode = '[diva_team category="'.$cats.'" title="'.$team_title.'" /]';

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
<?php if ( have_posts() ) : ?>

<?php while ( have_posts() ) : the_post(); ?>

<section id="content" class="no-mb">
<div class="container split-equal">
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="padding-content">
                    <div class="padding-content-inner">

                        <?php the_content(); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="big-image no-mb">

                    <img src="<?php echo $img_echo; ?>" alt="">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="row">

    <?php echo do_shortcode($shortcode); ?>

</div>
</div>
</div>
</div>
</section>

<?php endwhile; ?>

<?php endif; ?>
<!-- ================================================== -->
<!-- =============== END CONTENT PAGE ================ -->
<!-- ================================================== -->

<?php get_footer(); ?>

