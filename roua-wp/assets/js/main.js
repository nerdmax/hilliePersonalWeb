<!-- ================================================== -->

<!-- =============== START MENU OPTIONS ================ -->

<!-- ================================================== -->



jQuery(function(){



    "use strict";



    function outServicesTitle() {



      jQuery('.service-box').each(function(){



          var boxHeight = jQuery(this).outerHeight();



          jQuery(this).parent().parent().find('.title-for-services').css('height',boxHeight);



      });



    }



    outServicesTitle();



    jQuery(window).resize(function(){



        outServicesTitle();



    });



    var wH = jQuery(window).height();



    jQuery('.breadcrumb-fullscreen').css('height',wH);



    function slideDownDivaMenu(){



      jQuery(this).find('ul').slideDown();



    }



    function slideUpDivaMenu(){



      jQuery(this).find('ul').slideUp();



    }



    jQuery(".roua-menu .menu").hoverIntent({

        over: slideDownDivaMenu,

        out: slideUpDivaMenu,

        interval: 200,

        selector: 'li'

    });



    jQuery('.breadcrumb:not(.breadcrumb-fullscreen)').each(function(){

        

        jQuery('header.header').addClass('no-breadcrumb-fullscreen');



    });



    jQuery('.breadcrumb.breadcrumb-video-content').each(function(){

        

        jQuery('header.header').removeClass('no-breadcrumb-fullscreen');



    });



    jQuery('.roua-menu .menu ul li a').hover(function(){



        jQuery(this).parent().siblings().toggleClass('no-hovered');



    });



    jQuery('.filter-list nav ul li a').hover(function(){



        jQuery(this).parent().siblings().toggleClass('no-hovered');



    });



    jQuery('.open-menu').click(function(e){



        e.preventDefault();



        jQuery('.open-menu').toggleClass('open');



        jQuery('html').toggleClass('menu-is-open');



      });



      jQuery('.page-content').each(function(){



        jQuery('.page-content').prepend('<div class="before-page-content"></div>');



        jQuery('.before-page-content').click(function(){

          jQuery('.open-menu').removeClass('open');

          jQuery('html').removeClass('menu-is-open');

        });



      });



    jQuery('.additional-right-buttons a.filter-open , .filter-list nav .x-filter , .filter-list nav ul li a').click(function(e){



        e.preventDefault();



        jQuery('.filter-list').toggleClass('open');



    });



});



<!-- ================================================== -->

<!-- =============== END MENU OPTIONS ================ -->

<!-- ================================================== -->



<!-- ================================================== -->

<!-- =============== START WOOCOMMERCE JS ================ -->

<!-- ================================================== -->



jQuery('.woocommerce-tabs .entry-content .comment-respond .comment-form span a').click(function(event){ "use strict";



  event.preventDefault();



  jQuery('.woocommerce-tabs .entry-content .comment-respond .comment-form span a').removeClass('active in');



  jQuery(this).addClass('active in');



});



function starRate() {



    jQuery('.woocommerce-tabs .entry-content .comment-respond .comment-form span a.active').each(function(){



        jQuery(this).prev().addClass('hover-02')



        jQuery(this).prev().prev().addClass('hover-02')



        jQuery(this).prev().prev().prev().addClass('hover-02')



        jQuery(this).prev().prev().prev().prev().addClass('hover-02')



        jQuery(this).next().removeClass('hover-02')



        jQuery(this).next().next().removeClass('hover-02')



        jQuery(this).next().next().next().removeClass('hover-02')



        jQuery(this).next().next().next().next().removeClass('hover-02')



    });



};



setInterval(starRate, 10);



function hover5() {



    jQuery(this).prev().addClass('hover')



    jQuery(this).prev().prev().addClass('hover')



    jQuery(this).prev().prev().prev().addClass('hover')



    jQuery(this).prev().prev().prev().prev().addClass('hover')



};



function unHover5() {



    jQuery(this).prev().removeClass('hover')



    jQuery(this).prev().prev().removeClass('hover')



    jQuery(this).prev().prev().prev().removeClass('hover')



    jQuery(this).prev().prev().prev().prev().removeClass('hover')



};



jQuery('.woocommerce-tabs .entry-content .comment-respond .comment-form span a').hover(hover5,unHover5);







jQuery("#shiptobilling .input-checkbox").change(function() {



   if(this.checked) {



       jQuery('.shipping_address').slideUp();



   } else {



       jQuery('.shipping_address').slideDown();



   }



});







jQuery("#createaccount").change(function() {



   if(this.checked) {



       jQuery('.create-account').slideDown();



   } else {



       jQuery('.create-account').slideUp();



   }



});







jQuery('.payment_methods li').click(function() {



    jQuery('.payment_methods li').find('.payment_box').removeClass('active-box');



    jQuery(this).find('.payment_box').addClass('active-box');



});



<!-- ================================================== -->

<!-- =============== END WOOCOMMERCE JS ================ -->

<!-- ================================================== -->



<!-- ================================================== -->

<!-- =============== START CHOSEN ================ -->

<!-- ================================================== -->



jQuery(function(){



  "use strict";



  jQuery(".chzn-done").chosen();



});



<!-- ================================================== -->

<!-- =============== END CHOSEN ================ -->

<!-- ================================================== -->



<!-- ================================================== -->

<!-- =============== START BG PAGE OPTION ================ -->

<!-- ================================================== -->



jQuery(function(){



  "use strict";



  var bodyBg = jQuery('body').css("background");



  jQuery('.page-content').css('background',bodyBg);



});



<!-- ================================================== -->

<!-- =============== END BG PAGE OPTION ================ -->

<!-- ================================================== -->



<!-- ================================================== -->

<!-- =============== START VIDEO BREADCRUMB ================ -->

<!-- ================================================== -->



jQuery(function(){



  "use strict";



  jQuery(function(){



      var videoID = jQuery('.video-bg').attr('id');



      jQuery('.video-bg').okvideo({ 

         source: videoID,

         volume: 0,

         loop: true,

         hd:true,

         adproof: true,

         annotations: false

      });



  });



  jQuery(".breadcrumb").fitVids({ customSelector: "iframe"});



});



<!-- ================================================== -->

<!-- =============== END VIDEO BREADCRUMB ================ -->

<!-- ================================================== -->



<!-- ================================================== -->

<!-- =============== START BREACRUMB OPTIONS ================ -->

<!-- ================================================== -->



jQuery(function(){



    "use strict";



    var breadcrumbH = jQuery('.breadcrumb').outerHeight();



    if (jQuery(window).width() >= 1200){  

      jQuery('.breadcrumb-video-content').each(function(){



        breadcrumbH = (jQuery('.breadcrumb').outerHeight() - 250);



      });

    };



    jQuery('.breadcrumb-video-content').each(function(){



      breadcrumbH = (jQuery('.breadcrumb').outerHeight() - 75);



    });



    jQuery('.breadcrumb-fullscreen-parent').after('<div class="before-affix-breadcrumb"></div>');



    var wH = jQuery(window).height();



    jQuery('.breadcrumb > *').each(function(){



      var fadeStart= 0

          ,fadeUntil= 400

          ,fading = jQuery(this);



      jQuery(window).bind('scroll', function(){

          var offset = jQuery(document).scrollTop()

              ,opacity=0

          ;

          if( offset<=fadeStart ){

              opacity=1;

          }else if( offset<=fadeUntil ){

              opacity=1-offset/fadeUntil;

          }

          fading.css('opacity',opacity);

      });



    });

    jQuery('header.header > .row > .col-sm-12').each(function(){
      
      
      
            var fadeStart= 0
      
                ,fadeUntil= 138
      
                ,fading = jQuery(this);
      
      
      
            jQuery(window).bind('scroll', function(){
      
                var offset = jQuery(document).scrollTop()
      
                    ,opacity=0
      
                ;
      
                if( offset<=fadeStart ){
      
                    opacity=1;
      
                }else if( offset<=fadeUntil ){
      
                    opacity=1-offset/fadeUntil;
      
                }
      
                fading.css('opacity',opacity);
      
            });
      
      
      
          });



    function affixPhoneMenu() {



      jQuery('header.header').addClass('phone-menu-bg');



      jQuery('.phone-menu-bg').affix({

          offset: {

            top: 50

          }

      });



    };



    function unAffixPhoneMenu() {



      jQuery('header.header').removeClass('phone-menu-bg');



    };



    if (jQuery(window).width() <= 768){

          affixPhoneMenu();

        } else {

         jQuery(window).resize(function(){

          if (jQuery(window).width() <= 768){

            affixPhoneMenu();

          }

      });

    };



    if (jQuery(window).width() >= 768){

          unAffixPhoneMenu();

        } else {

         jQuery(window).resize(function(){

          if (jQuery(window).width() >= 768){

            unAffixPhoneMenu();

          }

      });

    };



    // jQuery('.breadcrumb-fullscreen-parent').affix({

    //     offset: {

    //       top: function () {

    //         return (this.top = (breadcrumbH - 69))

    //       }

    //     }

    // });



    // jQuery('header.header').affix({

    //     offset: {

    //       top: function () {

    //         return (this.top = (breadcrumbH - 120))

    //       }

    //     }

    // });



    // jQuery('header.header').on('affix.bs.affix', function () {



    //         jQuery('.project-single').addClass('affix');



    //     });



    //     jQuery('header.header').on('affix-top.bs.affix', function () {



    //         jQuery('.project-single').removeClass('affix');



    //     });



    // function fullScreenBreadcrumb() {



    //     jQuery('.breadcrumb-fullscreen-parent').on('affix-top.bs.affix', function () {



    //         jQuery('.before-affix-breadcrumb').css('height',0);



    //         if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {



    //           jQuery(this).css('bottom',0);



    //         };



    //     });



    //     jQuery('.breadcrumb-fullscreen-parent').on('affix.bs.affix', function () {



    //         jQuery('.before-affix-breadcrumb').css('height',breadcrumbH);



    //         if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {



    //           jQuery(this).css('bottom',wH - 69);



    //         };



    //     });



    // };



    function splitEqual() {



        jQuery('.split-equal').each(function(){



          var bigImageH = jQuery(this).find('.big-image').outerHeight();



          jQuery('.padding-content > div').css('height', bigImageH - 160 );



        });



    };



    // fullScreenBreadcrumb();



    jQuery(window).resize(function(){



        // fullScreenBreadcrumb();



        splitEqual();



    });



});



<!-- ================================================== -->

<!-- =============== END BREACRUMB OPTIONS ================ -->

<!-- ================================================== -->



<!-- ================================================== -->

<!-- =============== START PORTFOLIO SINGLE ================ -->

<!-- ================================================== -->



jQuery(function(){



  "use strict";



   function portfolioSingleAffix() {



        var breadcrumbHH = jQuery('.breadcrumb').outerHeight();



        if (jQuery('.breadcrumb-video-content').length) {



            breadcrumbHH = jQuery('.breadcrumb').outerHeight() - 70;



        };



        jQuery('.portfolio-single').affix({

            offset: {

              top: breadcrumbHH - 75

            }

        });



        // jQuery('.portfolio-single').on('affix.bs.affix', function () {



        //     jQuery('header.header').addClass('affix');



        // });



        // jQuery('.portfolio-single').on('affix-top.bs.affix', function () {



        //     jQuery('header.header').removeClass('affix');



        // });



        var portfolioSingleHeight = function() {



          var windowHeight = jQuery(window).height() ,

              portfolioSingleHeaderH = jQuery('.header-portfolio-single').outerHeight() ,

              portfolioSingleFooterH = jQuery('.footer-portfolio-single').outerHeight() ,

              footerH = jQuery('footer.footer').outerHeight() ,

              fromTopH = 229 + portfolioSingleHeaderH + portfolioSingleFooterH ,

              finalPortfolioSingleContentH = windowHeight - fromTopH - footerH ;



          jQuery('.content-portfolio-single').css({



            'max-height' : finalPortfolioSingleContentH ,



            'padding' : '0' ,



            'margin' : '40px 0'



          });



        }



        portfolioSingleHeight();



        jQuery(window).resize(function(){



          portfolioSingleHeight();



        });



    };



    portfolioSingleAffix();



    jQuery(window).resize(function(){



      portfolioSingleAffix();



    });



    jQuery('.portfolio-single .footer-portfolio-single .social-icons a i.fa-plus').parent().parent().css('display','inline-block');



    jQuery('.portfolio-single .footer-portfolio-single .social-icons a i.fa-plus').parent().click(function(e){



      e.preventDefault();



      jQuery('.portfolio-single .footer-portfolio-single .social-icons li').css('display','inline-block');



      jQuery(this).parent().hide();



    });



});



<!-- ================================================== -->

<!-- =============== EMD PORTFOLIO SINGLE ================ -->

<!-- ================================================== -->



<!-- ================================================== -->

<!-- =============== START ISOTOPE ================ -->

<!-- ================================================== -->



jQuery(function(){



  "use strict";



  function isotope() {



    var container = jQuery('.portfolio ul , .products');



    container.imagesLoaded(function() {



      container.isotope();



    });



    container.isotope();



    var jQueryoptionSets = jQuery('.option-set'),



    jQueryoptionLinks = jQueryoptionSets.find('a');



    jQueryoptionLinks.click(function(){



      var jQuerythis = jQuery(this);



      if ( jQuerythis.hasClass('selected') ) {

         return false;

      }



      var jQueryoptionSet = jQuerythis.parents('.option-set');



      jQueryoptionSet.find('.selected').removeClass('selected');



      jQuerythis.addClass('selected');



      var options = {},

          key = jQueryoptionSet.attr('data-option-key'),

          value = jQuerythis.attr('data-option-value');



      value = value === 'false' ? false : value;



      options[ key ] = value;



      if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {

        changeLayoutMode( jQuerythis, options )

      } else {

        container.isotope( options );

      }



        return false;



    });



  };



  isotope();



  jQuery(window).resize(function(){



    isotope();



  });



});



<!-- ================================================== -->

<!-- =============== END ISOTOPE ================ -->

<!-- ================================================== -->



<!-- ================================================== -->

<!-- =============== START OWL ================ -->

<!-- ================================================== -->

  

jQuery(document).ready(function(){

  

  "use strict";

  

  jQuery('.owl-team .team-members').owlCarousel({

    items:1,

    loop:false,

    margin:0,

    nav: true,

    responsiveRefreshRate: 0,

    navText: ['<i class="fa fa-long-arrow-left"></i>','<i class="fa fa-long-arrow-right"></i>'],

    responsive:{

      1366:{

      items:3

      },

      768:{

      items:2

      }

    }

  });

  

});



<!-- ================================================== -->

<!-- =============== END OWL ================ -->

<!-- ================================================== -->



<!-- ================================================== -->

<!-- =============== START PAGE LOADER SCRIPT ================ -->

<!-- ================================================== -->

  

(function(jQuery) {

  

  "use strict";



  if (jQuery('.with-nprogress').length > 0) {



    NProgress.start();



  };

  

  jQuery(window).load(function() {



    NProgress.done();

      

    jQuery(".pageloader").fadeOut();



    function splitEqual() {



        jQuery('.split-equal').each(function(){



          var bigImageH = jQuery(this).find('.big-image').outerHeight();



          jQuery('.padding-content > div').css('height', bigImageH - 160 );



        });



    };



    splitEqual();

      

  });

  

 })(jQuery);



<!-- ================================================== -->

<!-- =============== END PAGE LOADER SCRIPT ================ -->

<!-- ================================================== -->
