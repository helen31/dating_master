/**
 * Created by Alena on 14.04.2017.
 */
/**script for Owl.Carousel**/
    if ($(window).width() <= '768'){
        $('.online').owlCarousel({
            loop:true,
            margin: 5,
            nav:true,
            navText: [
                "<img src='/public/uploads/next.svg'>",
                "<img src='/public/uploads/next.svg'>"
            ],
            autoplay: false,
            autoplayTimeout: 2500,
            responsive:{
                0:{
                    items:1/**3, without 400**/
                },
                400:{
                    items:2
                },
                550:{
                    items:3
                },
                600:{
                    items:3
                },
                1000:{
                    items:4
                }
            }
        });
    } else if ($(window).width() >= '768'){
        $('.online').owlCarousel({
            loop:true,
            margin: 50,
            nav:true,
            navText: [
                "<img src='/public/uploads/next.svg'>",
                "<img src='/public/uploads/next.svg'>"
            ],
            autoplay: false,
            autoplayTimeout: 2500,
            responsive:{
                0:{
                    items:3
                },
                600:{
                    items:3
                },
                1000:{
                    items:4
                }
            }
        });
    }

    /**$('.top-hot').owlCarousel({
                loop:true,
                margin:50,
                nav:true,
                navText: [
                    "<img src='/public/uploads/next.svg'>",
                    "<img src='/public/uploads/next.svg'>"
                ],
                autoplay: true,
                autoplayTimeout: 3500,
                responsive:{
                    0:{
                        items:3
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:4
                    }
                }
            });**/