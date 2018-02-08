;
(function($) {
  Drupal.mediacommons = {
    setUpAsideReveal: function() {
      // visibility of arrow determined by CSS media queries
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
  };
  Drupal.behaviors.mediacommons = {
    attach: function(context, settings) {

      $('.view-all-spokes-in-this-spokes-hub .item-list>ul>li').filter(function() {
        return $(this).find('.spoke-title>a').hasClass('active') === true;
      }).addClass('active');

      $(window).resize(_.debounce(function() {
        Drupal.mediacommons.setUpAsideReveal();
      }, 100));

      $(window).bind('load', function() {
        Drupal.mediacommons.setUpAsideReveal();
      });

      $searchresults = $('#searchresults-sort');

      if ($searchresults.length) {
        $searchresults.change(function() {
          window.location.href = $(this).find(':selected').val();
        });
      }
    }
  };
})(jQuery);