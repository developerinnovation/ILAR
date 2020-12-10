(function($) {
    $(document).ready(function() {
        var screenWidth = window.screen.width;
        // owl menu home
        $("#main.page-front .top .slider").owlCarousel({
            nav: false,
            loop: false,
            navRewind: false,
            center: true,
            items: 1,
        });
        $("#main.page-front .top .slider").addClass('owl-carousel');
        

        // node curso cover
        $( "picture.cover-video" ).click(function() {
           $(this).removeClass('active');
           var vid = document.getElementById('presentation');
           vid.play();
        });
        

        // mobile
        if(screenWidth < 769){
            // scroll show menu
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if (scroll >= 197) {
                    $("nav#menu-fixed").addClass("scroll");
                } else {
                    $("nav#menu-fixed").removeClass("scroll");
                }
            });

            // slider node curso
            $(".main.node-course .right .other-course .more").owlCarousel({
                nav: false,
                loop: true,
                navRewind: false,
                center: true,
                items: 1.5,
            });
            $(".main.node-course .right .other-course .more").addClass('owl-carousel');

            $('#menu-live').click(function() {
                $(this).toggleClass('active');
                $('.izq.menu-live').toggleClass('active');
            });
            
        }
        $('#ngtModal').removeClass('none');
    
    });
   
})(jQuery);