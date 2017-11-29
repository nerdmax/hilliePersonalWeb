<?php
/* Template Name: Contact Page */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

global $clx_data;

// Take the fields info and submit them.
require 'assets/mailer/PHPMailerAutoload.php';

// Function for email address validation
function isEmailwidget($verify_email) {

    return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$verify_email));

}

$error_name_widget = false;
$error_email_widget = false;
$error_message_widget = false;
$error_subject_widget = false;

if (isset($_POST['contact_submit'])) {


    // Initialize the variables
    $name_widget = '';
    $email_widget = '';
    $subject_widget = '';
    $message_widget = '';
    $receiver_email_widget = '';

    // Get the name
    if (trim($_POST['dname']) === '') {
        $error_name_widget = true;
    } else {
        $name_widget = trim($_POST['dname']);
    }

    // Get the email
    if (trim($_POST['demail']) === '' || !isEmailwidget($_POST['demail'])) {
        $error_email_widget = true;
    } else {
        $email_widget = trim($_POST['demail']);
    }

    // Get the message
    if (trim($_POST['dmessage']) === '') {
        $error_message_widget = true;
    } else {
        $message_widget = stripslashes(trim($_POST['dmessage']));
    }

    // Check if we have errors
    if (!$error_name_widget && !$error_email_widget && !$error_message_widget) {

        // TODO: Get the receiver email from the backend
        $receiver_email_widget = $clx_data['contact-email'];

        // If none is specified, get the WP admin email
        if (!isset($receiver_email_widget) || $receiver_email_widget == '') {
            $receiver_email_widget = get_option('admin_email');
        }

        $website = trim($_POST['durl']);

        $mail = new PHPMailer;

        // Construct the email
        $mail->From = $receiver_email_widget;
        $mail->FromName = get_bloginfo('name');
        $mail->addAddress($receiver_email_widget);
        $mail->addReplyTo($email_widget, $name_widget);
        $mail->isHTML(false);

        $mail->Subject = __('New message from ', LANGUAGE_ZONE) . $name_widget;

        $mail->Body    = $message_widget;
        $mail->Body   .= PHP_EOL . PHP_EOL . "{$name_widget}'s website is {$website}";

        if ($mail->send()) {
            $email_sent_widget = true;
        } else {
            $email_sent_error_widget = true;
        }

    }
}

//wp_enqueue_script('google-maps-api', 'http://maps.google.com/maps/api/js?sensor=true', array(), '1.0', true);
//wp_enqueue_script('mapJS', THEMEROOT . '/assets/js/map.js', array(), '1.0', true);

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
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="padding-content">

                        <?php the_content(); ?>

                        <?php if( isset($email_sent_error_widget) && $email_sent_error_widget == true ) { // If errors are found ?>
                            <div class="alert alert-warning fade in">
                                <div class="icon-alert"></div>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                <?php _e('Please check if you\'ve filled all the fields with valid information and try again. Thank you.', LANGUAGE_ZONE); ?>
                            </div>
                        <?php } ?>

                        <?php if( isset($email_sent_widget) && $email_sent_widget == true ) { // If email is sent ?>
                            <div class="alert alert-success fade in">
                                <div class="icon-alert"></div>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                <?php _e('Message Successfully Sent!', LANGUAGE_ZONE); ?>
                            </div>
                        <?php } ?>

                        <div class="comment-respond">
                            <form action="<?php get_permalink(); ?>" method="post" id="formID" class="comment-form">

                                <ul class="comment-form-inputs">

                                    <li>
                                        <input id="author" name="dname" type="text" value="<?php echo (isset($_POST['dname']) ? $_POST['dname'] : ""); ?>" aria-required="true" required placeholder="<?php _e('Name', LANGUAGE_ZONE); ?> *">
                                    </li>

                                    <li>
                                        <input id="email" name="demail" type="text" value="<?php echo (isset($_POST['demail']) ? $_POST['demail'] : ""); ?>" aria-required="true" required placeholder="<?php _e('Email', LANGUAGE_ZONE); ?> *">
                                    </li>

                                    <li>
                                        <input id="url" name="durl" type="text" value="<?php echo (isset($_POST['durl']) ? $_POST['durl'] : ""); ?>" placeholder="<?php _e('Website ', LANGUAGE_ZONE); ?> ">
                                    </li>

                                </ul>

                                <textarea name="dmessage" placeholder="<?php _e('Message', LANGUAGE_ZONE); ?> *" required rows="7"><?php echo (isset($_POST['dmessage']) ? $_POST['dmessage'] : ""); ?></textarea>

                                <p class="form-submit">
                                    <input type="hidden" id="contact_submit" name="contact_submit" value="true" />
                                    <button name="submit" type="submit">
                                        <?php _e('Send', LANGUAGE_ZONE); ?>
                                    </button>
                                </p>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <?php if(isset($clx_data) && $clx_data['contact-address'] != '') {echo clx_get_google_maps($clx_data['contact-address']);} ?>
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

