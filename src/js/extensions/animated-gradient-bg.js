;
(function ($) {
    var $window = $(window),
        debounce = function (func, wait, immediate) {
            // 'private' variable for instance
            // The returned function will be able to reference this due to closure.
            // Each call to the returned function will share this common timer.
            var timeout;

            // Calling debounce returns a new anonymous function
            return function () {
                // reference the context and args for the setTimeout function
                var context = this,
                    args = arguments;

                // Should the function be called now? If immediate is true
                //   and not already in a timeout then the answer is: Yes
                var callNow = immediate && !timeout;

                // This is the basic debounce behaviour where you can call this
                //   function several times, but it will only execute once
                //   [before or after imposing a delay].
                //   Each time the returned function is called, the timer starts over.
                clearTimeout(timeout);

                // Set the new timeout
                timeout = setTimeout(function () {

                    // Inside the timeout function, clear the timeout variable
                    // which will let the next execution run when in 'immediate' mode
                    timeout = null;

                    // Check if the function already ran with the immediate flag
                    if (!immediate) {
                        // Call the original function with apply
                        // apply lets you define the 'this' object as well as the arguments
                        //    (both captured before setTimeout)
                        func.apply(context, args);
                    }
                }, wait);

                // Immediate mode and no wait timer? Execute the function..
                if (callNow)
                    func.apply(context, args);
            };
        };
    $window.on('elementor/frontend/init', function () {
        var ModuleHandler = elementorModules.frontend.handlers.Base,
            AnimatedGradientBg;

        AnimatedGradientBg = ModuleHandler.extend({

            bindEvents: function () {
                this.run();
            },

            getDefaultSettings: function () {
                return {
                    direction: 'left-right',
                    isPausedWhenNotInView: true,
                };
            },

            settings: function (key) {
                return this.getElementSettings('sa_agbg_' + key);
            },

            onElementChange: debounce(function (prop) {
                if (prop.indexOf('sa_agbg_') !== -1) {
                    if ($('#' + this.Granim).length) {
                        $('#' + this.Granim).remove();
                    }
                    this.run();
                }
            }, 400),

            run: function () {
                var options = this.getDefaultSettings(),
                    elementID = this.getID(),
                    elementContainer = $('.elementor-element-' + elementID),
                    element = 'ss-agbg-' + elementID;

                if (this.settings('enable') !== 'yes') {
                    return;
                }

                if ($(this.$element).hasClass('elementor-widget')) {
                    elementContainer = $('.elementor-element-' + elementID + ' > :first-child');
                    elementContainer.css({
                        'position': 'relative',
                        'overflow': 'hidden',
                    });
                }

                if ($(this.$element).hasClass('elementor-column')) {
                    elementContainer = $('.elementor-element-' + elementID).find('.elementor-column-wrap');
                    elementContainer.css({
                        // 'position' : 'relative',
                        'overflow': 'hidden',
                    });
                }

                elementContainer.prepend('<canvas id="' + element + '" class="ss-animated-gradient-bg ss-d-block ss-w-100 ss-h-100"></canvas>');

                $('.ss-animated-gradient-bg').css({
                    'position': 'absolute',
                    'top': 0,
                    'right': 0,
                    'bottom': 0,
                    'left': 0,
                    'pointer-events': 'none',
                });

                options.element = '#' + element;

                if (this.settings('direction')) {
                    options.direction = this.settings('direction');
                }

                let $color_list = this.settings('color_list');
                let gradients = [];

                $color_list.forEach(element => {
                    gradients.push([element.sa_agbg_start_color, element.sa_agbg_end_color]);
                });

                var transitionSpeed = 7000;

                if (typeof this.settings('transition_speed.size') !== "undefined" && this.settings('transition_speed.size')) {
                    transitionSpeed = this.settings('transition_speed.size');
                }

                options.states = {
                    'default-state': {
                        'gradients': gradients,
                        'transitionSpeed': transitionSpeed
                    }
                }

                var granimInstance = new Granim(options);

                this.Granim = element;
            }
        });


        elementorFrontend.hooks.addAction('frontend/element_ready/section', function ($scope) {
            elementorFrontend.elementsHandler.addHandler(AnimatedGradientBg, {
                $element: $scope
            });
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/container', function ($scope) {
            elementorFrontend.elementsHandler.addHandler(AnimatedGradientBg, {
                $element: $scope
            });
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/column', function ($scope) {
            elementorFrontend.elementsHandler.addHandler(AnimatedGradientBg, {
                $element: $scope
            });
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope) {
            elementorFrontend.elementsHandler.addHandler(AnimatedGradientBg, {
                $element: $scope
            });
        });

    });

}(jQuery));
