(function ($) {

    'use strict';

    elementor.hooks.addFilter("panel/elements/regionViews", function (panel) {

        if (SkyAddonsEditorConfig.pro_installed || SkyAddonsEditorConfig.promotional_widgets <= 0) return panel;

        var promotionalWidgetHandler,
            promotionalWidgets = SkyAddonsEditorConfig.promotional_widgets,
            elementsCollection = panel.elements.options.collection,
            categories = panel.categories.options.collection,
            categoriesView = panel.categories.view,
            elementsView = panel.elements.view,
            freeCategoryIndex, proWidgets = [];


        _.each(promotionalWidgets, function (widget, index) {
            elementsCollection.add({
                name: widget.name,
                title: widget.title,
                icon: widget.icon,
                categories: widget.categories,
                editable: false
            })
        });

        elementsCollection.each(function (widget) {
            "sky-sliders-pro" === widget.get("categories")[0] && proWidgets.push(widget)
        });

        freeCategoryIndex = categories.findIndex({
            name: "sky-sliders"
        });

        freeCategoryIndex && categories.add({
            name: "sky-sliders-pro",
            title: "Sky Sliders Pro",
            defaultActive: !1,
            items: proWidgets
        }, {
            at: freeCategoryIndex + 1
        });

        promotionalWidgetHandler = {

            getWedgetOption: function (name) {
                return promotionalWidgets.find(function (item) {
                    return item.name == name;
                });
            },

            className: function () {
                var className = 'elementor-element-wrapper';

                if (!this.isEditable()) {
                    className += ' elementor-element--promotion';
                }
                return className;
            },

            onMouseDown: function () {
                void this.constructor.__super__.onMouseDown.call(this);
                var promotion = this.getWedgetOption(this.model.get("name"));
                elementor.promotion.showDialog({
                    title: sprintf(wp.i18n.__('%s', 'elementor'), this.model.get("title")),
                    content: sprintf(wp.i18n.__('Use %s widget and dozens more pro features to extend your toolbox and build sites faster and better.', 'elementor'), this.model.get("title")),
                    targetElement: this.el,
                    position: {
                        blockStart: '-7'
                    },
                    actionButton: {
                        url: promotion.action_button.url,
                        text: promotion.action_button.text,
                        classes: promotion.action_button.classes || ['elementor-button', 'elementor-button-success']
                    }
                })
            }
        }

        panel.elements.view = elementsView.extend({
            childView: elementsView.prototype.childView.extend(promotionalWidgetHandler)
        });

        panel.categories.view = categoriesView.extend({
            childView: categoriesView.prototype.childView.extend({
                childView: categoriesView.prototype.childView.prototype.childView.extend(promotionalWidgetHandler)
            })
        });

        return panel;
    });

}(jQuery));
