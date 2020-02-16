$(function() {
    $('.owl-carousel').owlCarousel({
        dots: false,
        nav: true,
        items: 2,
        margin: 20,
        navText: ['<i class="icon-left-small hidden"></i>', '<div id="owl-nav-right" class="absolute right-0 items-center flex justify-center"><i class="icon-right-small"></i></div>'],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 2
            },
            1200: {
                items: 2
            }
        }
    });

});