(function($) {
    function setUpAsideReveal() {
        // visibility of arrow determined by CSS media queries
        console.log('setUp sidebars');
        if ($('aside[role="complimentary"].part-of-hub .responsive-disclosure').is(':visible')) {
            $('aside[role="complimentary"].part-of-hub header').click(function() {
                if ($(this).next('nav').is(':hidden')) {
                    $(this).next('nav').slideDown(300,
                        function() {
                            // open class is for the arrow display
                            $(this).parent('aside').addClass('open');
                        });
                } else {
                    $(this).next('nav').slideUp(300,
                        function() {
                            $(this).parent('aside').removeClass('open');
                        });
                }
            });
        } else {
            $("aside[role='complimentary'].part-of-hub nav").removeAttr('style');
            $('aside[role="complimentary"].part-of-hub header').unbind('click');
            $('aside[role="complimentary"].part-of-hub').removeClass('open');
        }
    }
    jQuery(document).ready(function($) {
        setUpAsideReveal();
        $(window).resize(_.debounce(function() {
            setUpAsideReveal();
        }, 100));
    });

})(jQuery);

