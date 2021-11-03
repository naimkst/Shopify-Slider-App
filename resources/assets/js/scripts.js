"use strict";
$(document).ready(function() {


    /*------------ Start site menu  ------------*/

    // Start sticky header
    $(window).on('scroll', function() {
        if ($(window).scrollTop() >= 150) {
            $('#sticky-header').addClass('sticky-menu');
        } else {
            $('#sticky-header').removeClass('sticky-menu');
        }
    });

    // // slicknav
    // $('ul#navigation').slicknav({
    //     prependTo: ".responsive-menu-wrap"
    // });


    $('.topbar-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        items: 1,
        center: true
    });


    $('.hero-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        items: 1,
    });




    $('.feedback-slider').owlCarousel({
        items: 1,
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
    });


    var fixOwl = function() {
        var $stage = $('.owl-stage'),
            stageW = $stage.width(),
            $el = $('.owl-item'),
            elW = 0;
        $el.each(function() {
            elW += $(this).width() + +($(this).css("margin-right").slice(0, -2))
        });
        if (elW > stageW) {
            $stage.width(elW);
        };
    }

    $('.product-carousel').owlCarousel({
        // items: 4,
        margin: 30,
        nav: true,
        dots: false,
        autoWidth: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
        onInitialized: fixOwl,
        onRefreshed: fixOwl,
    });



    $('.is_megamenu').on('mouseenter',function(){
        $('.mega-menu').toggleClass('mega-menu-show');
    });



});
