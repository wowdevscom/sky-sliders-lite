(function ($, elementor) {
  'use strict';
  var $window = jQuery(window);

  var widgetMinimal = function ($scope, $) {
    var $minimal = $scope.find('.sky-sliders--minimal'),
      $slider = $minimal.find('.swiper'),
      $id = '#' + $minimal.attr('id'),
      $settings = $minimal.data('settings');

    if (!$minimal.length) {
      return;
    }

    console.log('Minimal');
    console.log($id);

    const Swiper = elementorFrontend.utils.swiper;
    initSwiper();
    async function initSwiper() {
      var swiper = await new Swiper($slider, {
        ...$settings,

        on: {
          init: function () {
            var swiper = this;
            for (var i = 0; i < swiper.slides.length; i++) {
              $(swiper.slides[i])
                .find('.slide-bg')
                .attr({
                  'data-swiper-parallax': 0.75 * swiper.width
                });
            }
          },
          resize: function () {
            this.update();
          }
        },

        pagination: {
          el: `${$id} .swiper-pagination`,
          clickable: true,
          renderBullet: function (index, className) {
            return '<span class="' + className + '">' + '<svg class="fp-arc-loader" width="16" height="16" viewBox="0 0 16 16">' +
              '<circle class="path" cx="8" cy="8" r="5.5" fill="none" transform="rotate(-90 8 8)" stroke="#FFF"' +
              'stroke-opacity="1" stroke-width="1px"></circle>' +
              '<circle cx="8" cy="8" r="3" fill="#FFF"></circle>' +
              '</svg></span>';
          },

        },
      });
    };

  };

  $window.on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/sky-sliders-minimal.default', widgetMinimal);
  });

}(jQuery, window.elementorFrontend));
