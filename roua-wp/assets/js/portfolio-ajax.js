/**
 * @author StylishThemes
 */

jQuery(document).ready(function($){

    $('a#blog-load-more-button').on('click',function(e){

        e.preventDefault();

        var link = jQuery(this).attr('href');

        /** Ajax Call */
        jQuery.get( link, function( data ) {

            //$(data).find("nav.portfolio > ul > li").appendTo(".portfolio > ul.isotope");
            var elements = $(data).find("nav.portfolio > ul > li");

            var newhref = $(data).find("#pagination-ajax-inner a").attr('href');

            var container = jQuery('nav.portfolio > ul');

            container.isotope( 'insert', elements);

            container.imagesLoaded(function() {

                container.isotope();

            });

            if( $('.zilla-likes').hasClass('active') ) {
                $('.zilla-likes.active > i').removeClass('fa-heart-o').addClass('fa-heart');
            }

            if(newhref !== undefined) {
                $('#pagination-ajax-inner a').attr('href', newhref);
            } else {
                $('#pagination-ajax-inner').html(' <h5> ' + php_array.load_more_text + '</h5> ');
            }

        });

    });

    /*
    var eTop = $('#pagination-ajax-inner a').offset().top;

    //console.log(eTop - $(window).scrollTop());

    $(window).scroll(function() {
        var height = $(window).scrollTop();

        //console.log(height);

        if(height == (eTop - $(window).scrollTop())) {
            //console.log('egal');
        }
    });
    */

});