(function ($, elementor) {
    'use strict';
    var $window = jQuery(window);

    var widgetFolio = function ($scope, $) {
      var $photography = $scope.find('.sky-sliders--photography'),
            $slider = $photography.find('.photography-swiper--slider'),
            $settings = $photography.data('settings');

        if (!$photography.length) {
            return;
        }

      const Swiper = elementorFrontend.utils.swiper;
      initSwiper();
      async function initSwiper() {
        var swiper = await new Swiper($slider, $settings);
      };

    };

    $window.on('elementor/frontend/init', function () {
      elementorFrontend.hooks.addAction('frontend/element_ready/sky-sliders-photography.default', widgetFolio);
    });

}(jQuery, window.elementorFrontend));
