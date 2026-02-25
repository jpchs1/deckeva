window.the7GetElementorMasonryColumnsConfig = function ($container) {
    var $dataAttrContainer = $container.parent().hasClass("mode-masonry") ? $container.parent() : $container;

    var  attrDesktop = "data-desktop-columns-num",
        attrTablet ="data-tablet-columns-num",
        attrMobile = "data-mobile-columns-num";

    if ($dataAttrContainer.hasClass('products-shortcode')){
        attrTablet ="data-v-tablet-columns-num";
        attrMobile = "data-phone-columns-num";
    }

    var containerWidth = $container.width() - 1;
    var breakpoints = elementorFrontend.config.breakpoints;
    var columnsNum = "";
    var singleWidth = "";
    var doubleWidth = "";

    if (Modernizr.mq("all and (min-width:" + (dtLocal.elementor.settings.container_width + 1) + "px)")) {
        columnsNum = parseInt($dataAttrContainer.attr("data-wide-desktop-columns-num"));

        return {
            singleWidth: Math.floor(containerWidth / columnsNum) + "px",
            doubleWidth: Math.floor(containerWidth / columnsNum) * 2 + "px",
            columnsNum: columnsNum
        };
    }

    var modernizrMqPoints = [
        {
            breakpoint: breakpoints.xl,
            columns: parseInt($dataAttrContainer.attr(attrDesktop))
        },
        {
            breakpoint: breakpoints.lg,
            columns: parseInt($dataAttrContainer.attr(attrTablet))
        },
        {
            breakpoint: breakpoints.md,
            columns: parseInt($dataAttrContainer.attr(attrMobile))
        }
    ];

    modernizrMqPoints.forEach(function (mgPoint) {
        if (Modernizr.mq("all and (max-width:" + (mgPoint.breakpoint - 1) + "px)")) {
            columnsNum = mgPoint.columns;
            singleWidth = Math.floor(containerWidth / columnsNum) + "px";
            doubleWidth = Math.floor(containerWidth / columnsNum) * 2 + "px";

            return false;
        }
    });

    return {
        singleWidth: singleWidth,
        doubleWidth: doubleWidth,
        columnsNum: columnsNum
    };
};

window.the7ApplyMasonryWidgetCSSGridFiltering = function($container) {
    var config = the7ShortcodesFilterConfig($container);

    config.pagerClass = "page filter-item";
    config.previousButtonLabel = "<i class=\"dt-icon-the7-arrow-35-1\" aria-hidden=\"true\"></i>";
    config.nextButtonLabel = "<i class=\"dt-icon-the7-arrow-35-2\" aria-hidden=\"true\"></i>";

    $container.shortcodesFilter(config);
};

jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/the7_elements.default", function ($scope) {
        var $container = $scope.find(".iso-container");

        if ($container.length) {
            the7ApplyColumns($scope.attr("data-id"), $container, the7GetElementorMasonryColumnsConfig);
        }
    });
});

jQuery(function ($) {
    $(".elementor-widget-the7_elements .jquery-filter .dt-css-grid").each(function () {
        the7ApplyMasonryWidgetCSSGridFiltering($(this));
    });
});