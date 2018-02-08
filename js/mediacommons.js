;
(function($) {
  Drupal.mediacommons = {
    setUpFacetsReveal: function() {
      $(".responsive-disclosure").each(function(index) {
        if ($(this).is(':visible')) {

          $(this).closest('header').click(function() {

            if ($(this).next('div').is(':visible')) {
              $(this).next('div').slideUp(300,
                function() {
                  // console.log("removing is open " + index);
                  $(this).closest('.responsive-container').removeClass('is-open');
                });
            } else {
              $(this).next('div').slideDown(300,
                function() {
                  // open class is for the arrow display
                  //console.log("adding is open " + index);
                  $(this).closest('.responsive-container').addClass('is-open');
                });
            }
          });
        }
      });
    },
    setUpAsideReveal: function() {

      // visibility of arrow determined by CSS media queries
      if ($('.responsive-disclosure').is(':visible')) {

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
        Drupal.mediacommons.setUpFacetsReveal();
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