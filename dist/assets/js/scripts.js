/*============================
   js index
==============================
    Template Name: Consultiant - Consulting Bootstrap4 Template
    Template URI: http://tf.itech-theme.com/consultiant-preview
    Description: This is Consulting Bootstrap4 HTML5 Template.
    Author: itechtheme
    Author URI: https://themeforest.net/user/itechtheme
    Version: 1.0

==========================================*/

(function ($) {
    "use strict";

    /*================================
    Preloader
    ==================================*/
    var preloader = $('#preloader');
    $(window).on('load', function () {
        preloader.delay(500).fadeOut('slow', function () { $(this).remove(); });
    });

    /*================================
    Search form Show Hide
    ==================================*/
    $('.ht-search').on('click', function () {
        $('.offset-search').toggleClass('show_hide');
    });
    $('.offset-clox').on('click', function () {
        $('.offset-search').removeClass('show_hide');
    });

    /*================================
    nice select active
    ==================================*/
    if ($.fn.niceSelect) {
        $('.topic-select').niceSelect();
    }

    /*================================
    Owl Carousel
    ==================================*/
    // main slider active
    function slider_area() {
        var owl = $(".slider-area");
        owl.owlCarousel({
            margin: 0,
            loop: true,
            items: 1,
            dots: false,
            autoplay: true,
            autoplayTimeout: 20000,
            nav: true,
            smartSpeed: 800,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
        });
    }
    slider_area();

    // Testimonial slider active
    function tst_content() {
        var owl = $(".tst-content");
        owl.owlCarousel({
            margin: 0,
            loop: true,
            items: 1,
            dots: true,
            autoplay: true,
            autoplayTimeout: 3000,
            nav: false,
            smartSpeed: 1000
        });
    }
    tst_content();


    // case study slider active
    function case_study_carousel() {
        var owl = $(".case-study-carousel");
        owl.owlCarousel({
            margin: 30,
            loop: true,
            items: 5,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            nav: true,
            smartSpeed: 1000,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1,
                    margin: 0,
                },
                // breakpoint from 480 up
                480: {
                    items: 2,
                    margin: 15,
                },
                // breakpoint from 768 up
                768: {
                    items: 3,
                    margin: 15,
                },
                // breakpoint from 768 up
                1367: {
                    items: 4,
                    margin: 20,
                }
            }
        });
    }
    case_study_carousel();

    // case study slider active
    function client_caorusel() {
        var owl = $(".client-caorusel");
        owl.owlCarousel({
            loop: true,
            items: 5,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            nav: false,
            smartSpeed: 1000,
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 2,
                    margin: 30,
                },
                // breakpoint from 480 up
                480: {
                    items: 3,
                    margin: 30,
                },
                // breakpoint from 768 up
                768: {
                    items: 5,
                    margin: 15,
                },
                // breakpoint from 768 up
                1367: {
                    items: 6,
                    margin: 30,
                }
            }
        });
    }
    client_caorusel();

    // case study slider active
    function service_carousel() {
        var owl = $(".service-carousel");
        owl.owlCarousel({
            loop: true,
            items: 3,
            dots: true,
            autoplay: true,
            autoplayTimeout: 3000,
            nav: false,
            smartSpeed: 1000,
            responsive: {
                // breakpoint from 0 up
                0: {
                    items: 1,
                    margin: 0,
                },
                // breakpoint from 480 up
                480: {
                    items: 1,
                    margin: 0,
                },
                // breakpoint from 768 up
                768: {
                    items: 2,
                    margin: 15,
                },
                // breakpoint from 768 up
                1367: {
                    items: 3,
                    margin: 15,
                }
            }
        });
    }
    service_carousel();

    /*================================
    slicknav
    ==================================*/
    $('ul#nav_mobile_menu').slicknav({
        prependTo: "#mobile_menu"
    });


})(jQuery);
