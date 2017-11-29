<?php
/**
 * @author Stylish Themes
 * @since 1.0.0
 */

/* Template Name: Services Page */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header(); ?>

<!-- ================================================== -->
<!-- =============== START BREADCRUMB ================ -->
<!-- ================================================== -->

<?php diva_page_breadcrumb(); ?>

<!-- ================================================== -->
<!-- =============== END BREADCRUMB ================ -->
<!-- ================================================== -->

<!-- ================================================== -->
<!-- =============== START CONTENT PAGE ================ -->
<!-- ================================================== -->


<?php if ( have_posts() ) : ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <?php
        $prefix = Haze_Meta_Boxes::get_instance()->prefix;
        $services_title = rwmb_meta( "{$prefix}services_title", $args = array(), get_the_ID() );
        $clients_title = rwmb_meta( "{$prefix}clients_title", $args = array(), get_the_ID() );
        $services = rwmb_meta("{$prefix}services_group");
        $images = rwmb_meta("{$prefix}clients_logos", array('type'=>'image_advanced', 'size'=>'full'));
        ?>

        <section id="content" class="no-mb">
            <div class="container split-equal">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="big-image no-mb">
                                <ul class="out-services-box">
                                    <li class="col-sm-12 col-md-6">
                                        <div class="title-for-services">
                                            <h2>
                                                <?php echo $services_title; ?>
                                            </h2>
                                        </div>
                                    </li>
                                    <?php $i=0; foreach($services as $service): ?>
                                        <li class="col-xs-6 col-sm-12 col-md-6 <?php if($i == 0) { echo 'active'; } ?>">
                                            <div class="service-box" href="#service-<?php echo $i; ?>" aria-controls="service-<?php echo $i; ?>" role="tab" data-toggle="tab">
                                                <div class="icon-service">
                                                    <i class="fa <?php echo $service["{$prefix}service_icon"]; ?>"></i>
                                                </div>
                                                <a href="#">
                                                    <span><?php echo $service["{$prefix}service_title"]; ?></span>
                                                </a>
                                            </div>
                                        </li>
                                    <?php $i++; endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="padding-content">
                                <div class="padding-content-inner">
                                    <div class="tab-content">
                                        <?php $i=0; foreach($services as $service): ?>
                                            <div role="tabpanel" class="tab-pane fade <?php if($i == 0) { echo 'in active'; } ?>" id="service-<?php echo $i; ?>">
                                                <?php echo $service["{$prefix}service_description"]; ?>
                                            </div>
                                        <?php $i++; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="owl-team oriented-at-left">
                                <div class="carousel-description">
                                    <div class="text">
                                        <div class="content">
                                            <p>
                                                <?php echo $clients_title; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="team-members">
                                    <?php foreach($images as $image): ?>
                                        <figure>
                                            <figcaption>
                                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['name']; ?>">
                                            </figcaption>
                                        </figure>
                                    <?php endforeach; ?>
                                </div>
                            </div>
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