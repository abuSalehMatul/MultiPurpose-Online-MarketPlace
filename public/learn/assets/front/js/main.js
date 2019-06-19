(function ($) {
	"use strict";
    jQuery(document).ready(function($){
        /*---- most visited filter activation -----*/
         var Container = $('.most-visited-filter-area');
         Container.imagesLoaded(function () {
             var festivarMasonry = $('.most-visited-filter-area').isotope({
                 layoutMode: 'fitRows',
                 itemSelector: '.single-most-visited-item'
             });
             $(document).on('click', '.most-vislited-menu li', function () {
                 var filterValue = $(this).attr('data-filter');
                 festivarMasonry.isotope({
                     filter: filterValue
                 });
             });
         });
         /*---- festival menu active  ------*/
         var portfolioMenu = '.most-vislited-menu li';
         $(document).on('click', portfolioMenu, function () {
             $(this).siblings().removeClass('active');
             $(this).addClass('active');
         });

        //  radious slider
        function update() {
            var value = $('#radius_range').slider('value');
            $('#slider_text').text(value + 'Km');
        }
        var $radiusRangeSlider = $("#radius_range");
        $radiusRangeSlider.slider({
            range: "min",
            value: 120,
            min: 1,
            max: 1000,
            slide: function () {
                update();
            }
        });
        //magnific popup
        var $videoPopup = $('.video-play-btn');
         $videoPopup.magnificPopup({
             type: 'video'
         });
         var $postThumbCarousel = $('.post-thumb-carousel');
            $postThumbCarousel.owlCarousel({
                loop: true,
                dots: false,
                nav: true,
                navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 1
                    },
                    960: {
                        items: 1
                    },
                    1200: {
                        items: 1
                    },
                    1920: {
                        items: 1
                    }
                }
            });
            var $slickNav = $('#main-menu');
            $slickNav.slicknav({
                prependTo: '.responsive-menu',
                label: ''
            });



    });


    $(document).ready(function() {
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            margin:30,
            items:4,
            loop:true,
            autoplay:true,
            autoplayTimeout:5000,
            autoplayHoverPause:true,

            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 3
                }
            }
        })
    })

    $(window).on('scroll', function () {
      
    });
           
    $(window).on('load',function(){
        // var preLoder = $(".preloader");
        // preLoder.fadeOut(1000);
    });

}(jQuery));	