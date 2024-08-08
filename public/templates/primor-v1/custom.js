(function($) {
    const BOOTSTRAP_BREAKPOINT_LG = 992;
    const BOOTSTRAP_BREAKPOINT_MD = 768;
    const BOOTSTRAP_BREAKPOINT_SM = 576;

    const MOBILE_MENU = $("#header-mobile-menu");
    const CAROUSEL_SINGLE = $('.carousel-single');
    const CAROUSEL_RECIPES = $('.carousel-recipes');

    $(document).ready(function() {
        MOBILE_MENU.hide();
        $("#header-menu-mobile #hmm-icon").click(function() {
            MOBILE_MENU.slideToggle( "slow");
        });

        CAROUSEL_SINGLE.slick({
            'adaptiveHeight': true,
            'dots': true,
            'draggable': false,
            'zIndex': 998,
            'autoplay': true,
            'autoplaySpeed': 4000,
        });
        CAROUSEL_SINGLE.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
            // hide all text-box
            $(this).find('div.text-box').hide();

            // display the one for the next slide
            $(this).find(`[data-slick-index='${nextSlide}']`).find('div.text-box').show();
        });

        CAROUSEL_RECIPES.slick({
            'adaptiveHeight': true,
            'dots': false,
            'draggable': false,
            'zIndex': 998,
            'slidesToShow': 5,
            'slidesToScroll': 1,
            'autoplay': true,
            'autoplaySpeed': 4000,
            responsive: [
                {
                    breakpoint: BOOTSTRAP_BREAKPOINT_LG,
                    settings: {
                      slidesToShow: 4,
                    }
                },
                {
                  breakpoint: BOOTSTRAP_BREAKPOINT_MD,
                  settings: {
                    slidesToShow: 3,
                  }
                },
                {
                    breakpoint: BOOTSTRAP_BREAKPOINT_SM,
                    settings: {
                      slidesToShow: 2,
                    }
                  },
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
              ]
        });
    });

    $('#recipes #f-search').on('keypress', function(e) {
        if(e.which == 13) {
            const search = $(this).val();
            const div_recipes_holder = $('#recipes-list .recipes-holder')
            
            $.post(`/api/v1/recipes/filter`, { 'search': search }, function (retData) {

              if (retData?.data?.html !== null) {
                div_recipes_holder.html(retData?.data?.html);
              }
            });
        }
    });

    $(window).on('resize', function(){
        var win = $(this); //this = window
        if (win.width() >= BOOTSTRAP_BREAKPOINT_MD) {
            MOBILE_MENU.hide();
        }
    });

}(jQuery));