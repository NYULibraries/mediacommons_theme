/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
console.log('--> script.js');

function _flexslider_init(id, optionset, context) {
  console.log('initializing flexslider');
  $('#' + id, context).once('flexslider', function() {
    // Remove width/height attributes
    // @todo load the css path from the settings
    $(this).find('ul.slides > li > *').removeAttr('width').removeAttr('height');

    if (optionset) {
      // Add events that developers can use to interact.
      $(this).flexslider($.extend(optionset, {
        start: function(slider) {
          slider.trigger('start');
        },
        before: function(slider) {
          slider.trigger('before');
        },
        after: function(slider) {
          slider.trigger('after');
        },
        end: function(slider) {
          slider.trigger('end');
        },
        added: function(slider) {
          slider.trigger('added');
        },
        removed: function(slider) {
          slider.trigger('removed');
        }
      }));
    } else {
      $(this).flexslider();
    }
  });
}


(function($, Drupal, window, document, undefined) {
  console.log(" Inside anon");

// To understand behaviors, see https://drupal.org/node/756722#behaviors
//Drupal.behaviors.my_custom_behavior = {
//  attach: function(context, settings) {

    // Place your code here.

//  }
//};

/////
 // Behavior to load FlexSlider
  Drupal.behaviors.flexslider = {
   
    attach: function(context, settings) {
      var sliders = [];
      if ($.type(settings.flexslider) !== 'undefined' && $.type(settings.flexslider.instances) !== 'undefined') {

        for (var id in settings.flexslider.instances) {

          if (settings.flexslider.optionsets[settings.flexslider.instances[id]] !== undefined) {
            if (settings.flexslider.optionsets[settings.flexslider.instances[id]].asNavFor !== '') {
              // We have to initialize all the sliders which are "asNavFor" first.
              _flexslider_init(id, settings.flexslider.optionsets[settings.flexslider.instances[id]], context);
            } else {
              // Everyone else is second
              sliders[id] = settings.flexslider.optionsets[settings.flexslider.instances[id]];
            }
          }
        }
      }
      // Slider set
      for (var id in sliders) {
        _flexslider_init(id, settings.flexslider.optionsets[settings.flexslider.instances[id]], context);
      }
    }
  };
})(jQuery, Drupal, this, this.document);



