;
(function($) {
  Drupal.behaviors.mediacommons_responsivesidebars = {
    attach: function(context, settings) {
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
      $(window).resize(_.debounce(function() {
        // executed when the DOM is ready
        console.log("resized (debounced) from from mc.js");
        setUpAsideReveal();
      }, 100));
      $(window).bind("load", function() {
        // executed once every element of the page is loaded, including fonts
        console.log("Load event triggered from mc.js");
        setUpAsideReveal();
      });
    }
  }
})(jQuery);


jQuery(function () {

    jQuery('.view-all-spokes-in-this-spokes-hub .item-list>ul>li').filter(function(index) {
      return jQuery(this).find(".spoke-title>a").hasClass("active") === true;
    }).addClass("active");

});